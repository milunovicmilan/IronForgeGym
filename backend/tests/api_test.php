<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
// Real HTTP requests. Reuses API_TEST_URL, or starts the project's development router.
$process = null;
$log = tempnam(sys_get_temp_dir(), 'ironforge-api-');
$url = rtrim(getenv('API_TEST_URL') ?: '', '/');
if (!$url) {
    $socket = stream_socket_server('tcp://127.0.0.1:0', $errno, $error);
    if (!$socket) { throw new RuntimeException($error); }
    $address = stream_socket_get_name($socket, false);
    fclose($socket);
    $root = dirname(__DIR__, 2);
    $process = proc_open([PHP_BINARY, '-S', $address, '-t', $root, $root . '/server.php'],
        [0 => ['pipe', 'r'], 1 => ['file', $log, 'a'], 2 => ['file', $log, 'a']], $pipes, $root);
    if (!is_resource($process)) { throw new RuntimeException('Could not start PHP server.'); }
    fclose($pipes[0]);
    $url = 'http://' . $address . '/backend';
}
$checks = 0;
$cleanup = [];
function request(string $method, string $path, mixed $body = null, ?string $raw = null): array {
    global $url;
    $curl = curl_init($url . $path);
    $options = [CURLOPT_RETURNTRANSFER => true, CURLOPT_CUSTOMREQUEST => $method, CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json']];
    if ($body !== null || $raw !== null) { $options[CURLOPT_POSTFIELDS] = $raw ?? json_encode($body); }
    curl_setopt_array($curl, $options);
    $answer = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    $type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
    $error = curl_error($curl); curl_close($curl);
    if ($answer === false) { throw new RuntimeException($error); }
    $data = json_decode($answer, true, 512, JSON_THROW_ON_ERROR);
    if (!str_contains($type ?? '', 'application/json')) { throw new RuntimeException('Response is not application/json.'); }
    return [$status, $data];
}
function expect(string $method, string $path, int $expected, mixed $body = null, ?string $raw = null): array {
    global $checks;
    [$status, $data] = request($method, $path, $body, $raw);
    if ($status !== $expected) { throw new RuntimeException("$method $path: expected $expected, got $status: " . json_encode($data)); }
    if ($status >= 400 && (($data['status'] ?? null) !== $status || !is_string($data['error'] ?? null))) { throw new RuntimeException('Wrong error shape.'); }
    $checks++;
    echo "PASS $method $path -> $status\n";
    return $data;
}
function createRow(string $path, string $key, array $data): array {
    global $cleanup;
    $row = expect('POST', $path, 201, $data);
    if (empty($row[$key])) { throw new RuntimeException('Created ID missing.'); }
    $cleanup[] = [$path, $row[$key]];
    return $row;
}
$failed = false;
try {
    if ($process) {
        $ready = false;
        for ($i = 0; $i < 50; $i++) {
            try { [$status] = request('GET', '/'); if ($status === 200) { $ready = true; break; } }
            catch (Throwable $e) {}
            usleep(100000);
        }
        if (!$ready) { throw new RuntimeException('API did not start. ' . file_get_contents($log)); }
    }
    $tag = bin2hex(random_bytes(6));
    expect('GET', '/', 200);
    expect('GET', '/not-an-endpoint', 404);
    expect('GET', '/users/abc', 404);
    expect('GET', '/users/0', 400);
    expect('GET', '/users/2147483647', 404);
    expect('POST', '/categories', 400, null, '{broken');
    expect('POST', '/categories', 400, []);
    expect('POST', '/categories', 400, ['name' => (object)['nested' => 1]]);
    $user = createRow('/users', 'user_id', ['full_name' => 'HTTP User', 'email' => "http-$tag@example.test", 'password' => 'HttpPass123']);
    if (isset($user['password_hash']) || isset($user['password'])) { throw new RuntimeException('Password leaked.'); }
    $uid = $user['user_id'];
    expect('POST', '/users', 400, ['full_name' => 'Duplicate', 'email' => $user['email'], 'password' => 'HttpPass123']);
    expect('PATCH', "/users/$uid", 400, ['password' => null]);
    $cat = createRow('/categories', 'category_id', ['name' => "HTTP $tag"]); $cid = $cat['category_id'];
    expect('POST', '/categories', 400, ['name' => $cat['name']]);
    $trainer = createRow('/trainers', 'trainer_id', ['full_name' => 'HTTP Trainer', 'email' => "trainer-$tag@example.test"]); $tid = $trainer['trainer_id'];
    $plan = createRow('/memberships', 'membership_id', ['name' => 'HTTP Plan', 'price' => '30.00', 'duration_months' => 1]); $mid = $plan['membership_id'];
    expect('POST', '/memberships', 400, ['name' => 'Bad plan', 'price' => -1, 'duration_months' => 1]);
    $classData = ['title' => 'HTTP Class', 'category_id' => $cid, 'trainer_id' => $tid, 'schedule_time' => gmdate('Y-m-d H:i:s', time() + 86400 * 7), 'capacity' => 1];
    $class = createRow('/classes', 'class_id', $classData); $clid = $class['class_id'];
    expect('GET', '/classes/upcoming', 200); expect('GET', '/classes/available', 200);
    expect('GET', "/classes/$clid/details", 200);
    expect('DELETE', "/categories/$cid", 400); expect('DELETE', "/trainers/$tid", 400);
    $booking = createRow('/bookings', 'booking_id', ['user_id' => $uid, 'class_id' => $clid]); $bid = $booking['booking_id'];
    expect('POST', '/bookings', 400, ['user_id' => $uid, 'class_id' => $clid]);
    expect('GET', "/users/$uid/bookings", 200); expect('GET', "/classes/$clid/bookings", 200);
    expect('POST', "/bookings/$bid/cancel", 200);
    $link = createRow('/user-memberships', 'user_membership_id', ['user_id' => $uid, 'membership_id' => $mid, 'start_date' => gmdate('Y-m-d')]); $lid = $link['user_membership_id'];
    expect('GET', "/users/$uid/memberships", 200); expect('GET', "/users/$uid/active-membership", 200);
    expect('GET', "/categories/$cid/classes", 200); expect('GET', "/trainers/$tid/classes", 200);
    foreach ([['/users', $uid, ['full_name' => 'Changed User']], ['/categories', $cid, ['description' => 'Changed category']],
              ['/trainers', $tid, ['experience_years' => 7]], ['/memberships', $mid, ['price' => '35.00']],
              ['/classes', $clid, ['title' => 'Changed Class']], ['/bookings', $bid, ['status' => 'cancelled']],
              ['/user-memberships', $lid, ['end_date' => gmdate('Y-m-d', time() + 86400 * 40)]]] as [$path, $id, $change]) {
        expect('GET', $path, 200); expect('GET', "$path/$id", 200);
        foreach (['PUT', 'PATCH'] as $method) {
            $row = expect($method, "$path/$id", 200, $change);
            foreach ($change as $key => $value) {
                if ((string)$row[$key] !== (string)$value) { throw new RuntimeException('Update was not persisted.'); }
            }
        }
        if ($path === '/users' && (isset($row['password_hash']) || isset($row['password']))) { throw new RuntimeException('Hash leaked after update.'); }
    }
    foreach (array_reverse($cleanup) as [$path, $id]) {
        expect('DELETE', "$path/$id", 200); expect('GET', "$path/$id", 404);
    }
    $cleanup = [];
    echo "ALL API TESTS PASSED ($checks HTTP checks; 7 entities).\n";
} catch (Throwable $e) { $failed = true; fwrite(STDERR, 'FAIL: ' . $e->getMessage() . PHP_EOL); }
finally {
    foreach (array_reverse($cleanup) as [$path, $id]) {
        try { request('DELETE', "$path/$id"); } catch (Throwable $e) { fwrite(STDERR, "Cleanup failed: $path/$id\n"); }
    }
    if ($process) { proc_terminate($process); proc_close($process); }
    @unlink($log);
}
exit($failed ? 1 : 0);
