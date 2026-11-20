<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
// Requires a multi-worker server (Apache/XAMPP), unlike PHP's single-worker dev server.
$base = rtrim(getenv('API_TEST_URL') ?: '', '/');
if (!$base) { fwrite(STDERR, "Set API_TEST_URL to your Apache backend URL first.\n"); exit(1); }
$cleanup = [];
function callApi($method, $path, $body = null) {
    global $base;
    $c = curl_init($base . $path);
    curl_setopt_array($c, [CURLOPT_RETURNTRANSFER => true, CURLOPT_CUSTOMREQUEST => $method, CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']]);
    if ($body !== null) { curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body)); }
    $raw = curl_exec($c); $status = curl_getinfo($c, CURLINFO_RESPONSE_CODE); curl_close($c);
    return [$status, json_decode($raw, true, 512, JSON_THROW_ON_ERROR)];
}
function addFixture($resource, $pk, $data) {
    global $cleanup;
    [$status, $row] = callApi('POST', '/' . $resource, $data);
    if ($status !== 201) { throw new RuntimeException('Fixture failed: ' . json_encode($row)); }
    $cleanup[] = [$resource, $row[$pk]];
    return $row[$pk];
}
function simultaneousBookings($class, $users): array {
    global $base, $cleanup;
    $multi = curl_multi_init(); $handles = [];
    foreach ($users as $user) {
        $c = curl_init($base . '/bookings');
        curl_setopt_array($c, [CURLOPT_RETURNTRANSFER => true, CURLOPT_POST => true, CURLOPT_TIMEOUT => 15,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode(['user_id' => $user, 'class_id' => $class])]);
        curl_multi_add_handle($multi, $c); $handles[] = $c;
    }
    do {
        curl_multi_exec($multi, $running);
        if ($running) { curl_multi_select($multi, 0.1); }
    } while ($running);
    $statuses = [];
    foreach ($handles as $c) {
        $status = curl_getinfo($c, CURLINFO_RESPONSE_CODE); $statuses[] = $status;
        $row = json_decode(curl_multi_getcontent($c), true, 512, JSON_THROW_ON_ERROR);
        if ($status === 201) { $cleanup[] = ['bookings', $row['booking_id']]; }
        curl_multi_remove_handle($multi, $c); curl_close($c);
    }
    curl_multi_close($multi);
    sort($statuses);
    return $statuses;
}
$failed = false;
try {
    $tag = bin2hex(random_bytes(6));
    $users = [];
    for ($i = 0; $i < 2; $i++) {
        $users[] = addFixture('users', 'user_id', ['full_name' => 'Concurrent User', 'email' => "concurrent-$tag-$i@example.test", 'password' => 'Concurrent123']);
    }
    $category = addFixture('categories', 'category_id', ['name' => "Concurrent $tag"]);
    $trainer = addFixture('trainers', 'trainer_id', ['full_name' => 'Concurrent Trainer']);
    $class = addFixture('classes', 'class_id', ['title' => 'Last Seat', 'category_id' => $category, 'trainer_id' => $trainer, 'schedule_time' => gmdate('Y-m-d H:i:s', time()+86400), 'capacity' => 1]);
    if (simultaneousBookings($class, $users) !== [201, 400]) { throw new RuntimeException('Last seat was oversold or both requests failed.'); }
    [$status, $rows] = callApi('GET', "/classes/$class/bookings");
    if ($status !== 200 || count($rows) !== 1) { throw new RuntimeException('Wrong booking count after concurrent requests.'); }
    [$status] = callApi('POST', '/bookings/' . $rows[0]['booking_id'] . '/cancel');
    if ($status !== 200) { throw new RuntimeException('Cancellation failed.'); }
    if (simultaneousBookings($class, [$users[0], $users[0]]) !== [201, 400]) { throw new RuntimeException('Concurrent duplicate booking accepted.'); }
    echo "PASS simultaneous requests: one last seat, no overbooking, no duplicate active booking.\n";
} catch (Throwable $e) { $failed = true; fwrite(STDERR, 'FAIL: ' . $e->getMessage() . PHP_EOL); }
finally {
    foreach (array_reverse($cleanup) as [$resource, $id]) { callApi('DELETE', "/$resource/$id"); }
}
exit($failed ? 1 : 0);
