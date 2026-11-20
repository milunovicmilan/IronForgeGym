<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require_once __DIR__ . '/../bootstrap.php';
$checks = 0;
function verify($ok, string $message): void {
    global $checks;
    $checks++;
    if (!$ok) { throw new RuntimeException($message); }
}
function rejects(callable $action, int $status): void {
    try { $action(); } catch (HttpException $e) {
        verify($e->getStatus() === $status, 'Wrong exception status: ' . $e->getMessage()); return;
    }
    throw new RuntimeException('Expected rejection with status ' . $status);
}
$pdo = Database::connect();
$pdo->beginTransaction();
$failed = false;
try {
    $tag = bin2hex(random_bytes(6));
    $users = new UserService(); $categories = new CategoryService(); $trainers = new TrainerService();
    $classes = new ClassService(); $plans = new MembershipService(); $bookings = new BookingService();
    $links = new UserMembershipService();
    $u = $users->create(['full_name' => 'Test Member', 'email' => "  MEMBER-$tag@EXAMPLE.TEST ", 'password' => 'StrongPass123']);
    $uid = $u['user_id'];
    verify(!isset($u['password_hash']) && !isset($u['password']), 'Password leaked from create');
    verify($u['email'] === "member-$tag@example.test" && $u['role'] === 'user', 'User normalization failed');
    verify(password_verify('StrongPass123', (new UserDao())->getById($uid)['password_hash']), 'Stored password not hashed');
    $u2 = $users->create(['full_name' => 'Second Member', 'email' => "second-$tag@example.test", 'password' => 'StrongPass123']);
    rejects(fn() => $users->create(['full_name' => 'Duplicate', 'email' => $u['email'], 'password' => 'StrongPass123']), 400);
    rejects(fn() => $users->create(['full_name' => 'Weak', 'email' => "weak-$tag@example.test", 'password' => '123']), 400);
    rejects(fn() => $users->update($uid, ['password' => null]), 400);
    rejects(fn() => $users->update($uid, ['role' => 'owner']), 400);
    rejects(fn() => $users->update($uid, ['email' => ['nested']]), 400);
    rejects(fn() => $users->update($uid, ['password_hash' => 'injected']), 400);
    rejects(fn() => $users->update($uid, []), 400);
    rejects(fn() => $users->getById(0), 400);
    rejects(fn() => $users->getById(2147483647), 404);
    verify(!isset($users->getAll()[0]['password_hash']), 'Hash leaked from list');
    $c = $categories->create(['name' => "Category $tag"]); $cid = $c['category_id'];
    rejects(fn() => $categories->create(['name' => $c['name']]), 400);
    verify($categories->update($cid, ['name' => $c['name']])['name'] === $c['name'], 'Own category name rejected');
    rejects(fn() => $categories->create(['name' => '<script>']), 400);
    $t = $trainers->create(['full_name' => 'Test Trainer', 'email' => "trainer-$tag@example.test", 'experience_years' => 4]); $tid = $t['trainer_id'];
    rejects(fn() => $trainers->create(['full_name' => 'Duplicate', 'email' => $t['email']]), 400);
    rejects(fn() => $trainers->update($tid, ['experience_years' => -1]), 400);
    $m = $plans->create(['name' => 'Test Plan', 'price' => '25.50', 'duration_months' => 1]); $mid = $m['membership_id'];
    rejects(fn() => $plans->update($mid, ['price' => -5]), 400);
    rejects(fn() => $plans->update($mid, ['price' => '1.999']), 400);
    rejects(fn() => $plans->update($mid, ['duration_months' => 0]), 400);
    $future = gmdate('Y-m-d H:i:s', time() + 86400 * 7);
    $cl = $classes->create(['title' => 'Test Class', 'category_id' => $cid, 'trainer_id' => $tid, 'schedule_time' => $future, 'capacity' => 1]); $clid = $cl['class_id'];
    $classData = ['title' => 'Other class', 'category_id' => $cid, 'trainer_id' => $tid, 'schedule_time' => $future, 'capacity' => 2];
    rejects(fn() => $classes->create(array_replace($classData, ['schedule_time' => '2020-01-01 12:00:00'])), 400);
    rejects(fn() => $classes->create(array_replace($classData, ['schedule_time' => '2027-02-30 12:00:00'])), 400);
    rejects(fn() => $classes->create(array_replace($classData, ['category_id' => 2147483647])), 400);
    rejects(fn() => $categories->delete($cid), 400);
    rejects(fn() => $trainers->delete($tid), 400);
    verify(count($categories->getClasses($cid)) === 1 && count($trainers->getClasses($tid)) === 1, 'Nested class list failed');
    verify($classes->getDetails($clid)['trainer_name'] === 'Test Trainer', 'Class details join failed');
    $b = $bookings->create(['user_id' => $uid, 'class_id' => $clid]); $bid = $b['booking_id'];
    rejects(fn() => $bookings->create(['user_id' => $uid, 'class_id' => $clid]), 400);
    rejects(fn() => $bookings->create(['user_id' => $u2['user_id'], 'class_id' => $clid]), 400);
    verify(count($bookings->getByUser($uid)) === 1 && count($bookings->getByClass($clid)) === 1, 'Booking joins failed');
    $classes->update($clid, ['capacity' => 2]);
    $b2 = $bookings->create(['user_id' => $u2['user_id'], 'class_id' => $clid]);
    rejects(fn() => $classes->update($clid, ['capacity' => 1]), 400);
    rejects(fn() => $bookings->update($bid, ['user_id' => $u2['user_id']]), 400);
    verify($bookings->cancel($bid)['status'] === 'cancelled', 'Cancellation failed');
    $bookings->update($bid, ['status' => 'booked']);
    $classes->update($clid, ['schedule_time' => '2020-01-01 12:00:00']);
    $bookings->cancel($bid);
    rejects(fn() => $bookings->update($bid, ['status' => 'booked']), 400);
    $l = $links->create(['user_id' => $uid, 'membership_id' => $mid, 'start_date' => '2027-01-31']); $lid = $l['user_membership_id'];
    verify($l['end_date'] === '2027-02-28', 'Calendar month end must be clamped');
    rejects(fn() => $links->create(['user_id' => $uid, 'membership_id' => $mid, 'start_date' => '2027-02-01', 'end_date' => '2027-03-01']), 400);
    rejects(fn() => $links->update($lid, ['end_date' => '2020-01-01']), 400);
    rejects(fn() => $links->update($lid, ['user_id' => $u2['user_id']]), 400);
    rejects(fn() => $links->getActive($uid), 404);
    $links->update($lid, ['start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d', time() + 86400)]);
    verify((int)$links->getActive($uid)['user_membership_id'] === (int)$lid, 'Active membership failed');
    foreach ([[$links, $lid], [$bookings, $bid], [$bookings, $b2['booking_id']], [$classes, $clid], [$plans, $mid], [$trainers, $tid], [$categories, $cid], [$users, $uid], [$users, $u2['user_id']]] as [$service, $id]) {
        $service->delete($id); rejects(fn() => $service->getById($id), 404);
    }
    echo "PASS service CRUD, business rules and error cases ($checks checks).\n";
} catch (Throwable $e) {
    $failed = true; fwrite(STDERR, 'FAIL: ' . $e->getMessage() . PHP_EOL);
} finally { if ($pdo->inTransaction()) { $pdo->rollBack(); } }
exit($failed ? 1 : 0);
