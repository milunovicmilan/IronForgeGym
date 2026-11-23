<?php
ini_set('display_errors', '0');
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/utils/RequestBody.php';
foreach (['user' => 'User', 'category' => 'Category', 'trainer' => 'Trainer', 'class' => 'Class',
          'membership' => 'Membership', 'booking' => 'Booking', 'userMembership' => 'UserMembership', 'weather' => 'Weather'] as $name => $class) {
    Flight::register($name . 'Service', $class . 'Service');
}
Flight::map('error', function (Throwable $e) {
    $status = $e instanceof HttpException ? $e->getStatus() : 500;
    $message = $e instanceof HttpException ? $e->getMessage() : 'Something went wrong on the server. Please try again later.';
    if ($status === 500) { Logger::error(get_class($e) . ': ' . $e->getMessage()); }
    Flight::response()->clearBody()->status($status)->header('Content-Type', 'application/json; charset=utf-8')
        ->write(json_encode(['status' => $status, 'error' => $message], JSON_INVALID_UTF8_SUBSTITUTE))->send();
});
Flight::map('notFound', function () {
    Flight::json(['status' => 404, 'error' => 'Endpoint not found.'], 404);
});
Flight::route('GET /', function () {
    Flight::json(['app' => 'IronForge Gym API', 'message' => 'The backend is running.', 'docs' => 'public/v1/docs/']);
});
foreach (glob(__DIR__ . '/routes/*Routes.php') as $file) { require $file; }
Flight::start();
