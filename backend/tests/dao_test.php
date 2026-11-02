<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

foreach (glob(__DIR__ . '/../dao/*Dao.php') as $file) {
    require_once $file;
}

function check($ok, $message) {
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$pdo = Database::connect();
$failed = false;
$pdo->beginTransaction();

try {
    $tag = bin2hex(random_bytes(6));
    $users = new UserDao();
    $cats = new CategoryDao();
    $trainers = new TrainerDao();
    $classes = new ClassDao();
    $plans = new MembershipDao();
    $bookings = new BookingDao();
    $links = new UserMembershipDao();
    $created = [];

    function exercise($dao, $data, $field, $value) {
        global $created;

        $id = $dao->insert($data);

        check(
            $id > 0 &&
            $dao->getById($id)[$field] == $data[$field],
            'Create/read failed'
        );
        check(
            $dao->update($id, [$field => $value]),
            'Update statement failed'
        );
        check(
            $dao->getById($id)[$field] == $value,
            'Updated value mismatch'
        );
        check(count($dao->getAll()) > 0, 'List failed');

        $created[] = [$dao, $id];

        echo 'PASS create/read/update/list ' .
            get_class($dao) . PHP_EOL;

        return $id;
    }

    $user = exercise(
        $users,
        [
            'full_name' => "O'Brien $tag",
            'email' => "$tag@example.test",
            'password_hash' =>
                password_hash('test-only', PASSWORD_DEFAULT)
        ],
        'full_name',
        'Updated user'
    );

    $cat = exercise(
        $cats,
        ['name' => "Test $tag"],
        'name',
        'Updated category'
    );

    $trainer = exercise(
        $trainers,
        [
            'full_name' => 'Test trainer',
            'email' => "trainer-$tag@example.test"
        ],
        'full_name',
        'Updated trainer'
    );

    $plan = exercise(
        $plans,
        [
            'name' => 'Test plan',
            'price' => '25.00',
            'duration_months' => 1
        ],
        'name',
        'Updated plan'
    );

    $class = exercise(
        $classes,
        [
            'title' => 'Test class',
            'category_id' => $cat,
            'trainer_id' => $trainer,
            'capacity' => 2,
            'schedule_time' =>
                date('Y-m-d H:i:s', time() + 86400)
        ],
        'title',
        'Updated class'
    );

    $booking = exercise(
        $bookings,
        [
            'user_id' => $user,
            'class_id' => $class,
            'status' => 'cancelled'
        ],
        'status',
        'booked'
    );

    $link = exercise(
        $links,
        [
            'user_id' => $user,
            'membership_id' => $plan,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', time() + 86400 * 30)
        ],
        'end_date',
        date('Y-m-d', time() + 86400 * 60)
    );

    check(
        (int)$users->getByEmail("$tag@example.test")['user_id']
            === $user,
        'Email lookup failed'
    );

    check(
        $users->getByEmail("' OR 1=1 --") === false,
        'Prepared value isolation failed'
    );

    check(
        (int)$cats->getCategoryWithClasses($cat)['total_classes']
            === 1,
        'Category join failed'
    );

    check(
        $classes->getClassWithDetails($class)['trainer_name']
            === 'Updated trainer',
        'Trainer join failed'
    );

    check(
        count($bookings->getByUser($user)) === 1,
        'Booking join failed'
    );

    check(
        count(array_filter(
            $classes->getAvailableClasses(),
            fn($r) =>
                (int)$r['class_id'] === $class &&
                (int)$r['available_spots'] === 1
        )) === 1,
        'Capacity failed'
    );

    $bookings->cancelBooking($booking);

    check(
        $bookings->checkIfUserBooked($user, $class) === false,
        'Cancellation failed'
    );

    check(
        (int)$links->getActiveMembership($user)
            ['user_membership_id'] === $link,
        'Membership join failed'
    );

    $links->update(
        $link,
        ['start_date' => date('Y-m-d', time() + 86400)]
    );

    check(
        $links->getActiveMembership($user) === false,
        'Future membership accepted'
    );

    foreach (
        [
            [],
            ['id' => 1],
            ['user_id' => 1],
            ['full_name = NULL --' => 'x']
        ] as $bad
    ) {
        foreach (['insert', 'update'] as $method) {
            $rejected = false;

            try {
                $method === 'insert'
                    ? $users->insert($bad)
                    : $users->update($user, $bad);
            } catch (InvalidArgumentException $e) {
                $rejected = true;
            }

            check($rejected, 'Invalid write accepted');
        }
    }

    $rejected = false;

    try {
        $users->insert([
            'full_name' => 'Duplicate',
            'email' => "$tag@example.test",
            'password_hash' => 'unused'
        ]);
    } catch (PDOException $e) {
        $rejected = $e->getCode() === '23000';
    }

    check($rejected, 'Unique constraint failed');

    $rejected = false;

    try {
        $bookings->insert([
            'user_id' => $user,
            'class_id' => -1
        ]);
    } catch (PDOException $e) {
        $rejected = $e->getCode() === '23000';
    }

    check($rejected, 'Foreign key constraint failed');

    foreach (array_reverse($created) as [$dao, $id]) {
        check(
            $dao->delete($id) &&
            $dao->getById($id) === false,
            'Delete failed'
        );

        echo 'PASS delete ' . get_class($dao) . PHP_EOL;
    }

    echo "ALL DAO TESTS PASSED (7 entities)\n";
} catch (Throwable $e) {
    $failed = true;
    fwrite(STDERR, 'FAIL: ' . $e->getMessage() . PHP_EOL);
} finally {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
}

exit($failed ? 1 : 0);