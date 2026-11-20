<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require_once __DIR__ . '/../services/WeatherService.php';
// Provider responses are injected for deterministic error-path coverage, not presented as live weather.
$fixture = ['current' => ['time' => '2026-11-20T12:00', 'temperature_2m' => 15, 'precipitation' => 0, 'weather_code' => 0, 'wind_speed_10m' => 5]];
$captured = [];
$service = new WeatherService(function ($url, $timeout) use ($fixture, &$captured) {
    $captured = [$url, $timeout]; return $fixture;
});
$row = $service->getSarajevo();
if ($row['city'] !== 'Sarajevo' || $row['condition'] !== 'Clear' || !str_contains($row['advice'], 'outdoor') ||
    !str_starts_with($captured[0], 'https://api.open-meteo.com/') || $captured[1] < 1 || $captured[1] > 15) { throw new RuntimeException('Weather normalization failed.'); }
$fixture['current']['precipitation'] = 3;
$row = (new WeatherService(fn() => $fixture))->getSarajevo();
if (!str_contains($row['advice'], 'indoor')) { throw new RuntimeException('Rain advice failed.'); }
$log = __DIR__ . '/../logs/error.log';
$before = is_file($log) ? filesize($log) : 0;
foreach ([fn() => throw new RuntimeException('simulated timeout'), fn() => ['current' => []], fn() => 'not an object'] as $client) {
    try { (new WeatherService($client))->getSarajevo(); throw new RuntimeException('Provider failure was accepted.'); }
    catch (ExternalServiceException $e) {
        if ($e->getStatus() !== 503 || !str_contains($e->getMessage(), 'temporarily unavailable')) { throw $e; }
    }
}
clearstatcache(true, $log);
if (!is_file($log) || filesize($log) <= $before) { throw new RuntimeException('Weather failures were not logged.'); }
echo "PASS weather normalization, workout advice, timeout/malformed data, safe 503 and error logging (fixture tests).\n";
if (in_array('--live', $argv, true)) {
    echo json_encode((new WeatherService())->getSarajevo(), JSON_PRETTY_PRINT) . PHP_EOL;
    echo "PASS live Open-Meteo request.\n";
}
