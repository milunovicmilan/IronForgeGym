<?php
require_once __DIR__ . '/../utils/exceptions.php';
require_once __DIR__ . '/../utils/HttpClient.php';
require_once __DIR__ . '/../utils/Logger.php';
class WeatherService {
    private $fetch;
    public function __construct(?callable $fetch = null) {
        $this->fetch = $fetch ?? [new HttpClient(), 'getJson'];
    }
    public function getSarajevo(): array {
        $configFile = __DIR__ . '/../config/config.php';
        $config = is_file($configFile) ? require $configFile : [];
        $timeout = max(1, min(15, (int)($config['weather_timeout'] ?? 5)));
        $url = 'https://api.open-meteo.com/v1/forecast?' . http_build_query([
            'latitude' => 43.8563, 'longitude' => 18.4131,
            'current' => 'temperature_2m,precipitation,weather_code,wind_speed_10m',
            'timezone' => 'UTC', 'wind_speed_unit' => 'kmh',
        ]);
        try {
            $data = ($this->fetch)($url, $timeout);
            $current = $data['current'] ?? [];
            foreach (['temperature_2m', 'precipitation', 'weather_code', 'wind_speed_10m'] as $key) {
                if (!isset($current[$key]) || !is_numeric($current[$key]) || !is_finite((float)$current[$key])) {
                    throw new RuntimeException('Incomplete weather data.');
                }
            }
            if (!isset($current['time']) || !is_string($current['time']) ||
                !preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}(:\d{2})?$/D', $current['time'])) {
                throw new RuntimeException('Missing weather observation time.');
            }
            $code = (int)$current['weather_code'];
            $condition = match (true) {
                $code === 0 => 'Clear', $code <= 3 => 'Partly cloudy', $code <= 48 => 'Foggy',
                $code <= 67 => 'Rainy', $code <= 77 => 'Snowy', $code <= 82 => 'Rain showers',
                $code <= 86 => 'Snow showers', default => 'Stormy',
            };
            $indoor = (float)$current['precipitation'] > 0 || (float)$current['wind_speed_10m'] > 35 ||
                (float)$current['temperature_2m'] < 5 || (float)$current['temperature_2m'] > 32 || $code >= 95;
            return [
                'city' => 'Sarajevo', 'source' => 'Open-Meteo', 'timezone' => 'UTC',
                'observed_at' => $current['time'], 'temperature_c' => (float)$current['temperature_2m'],
                'wind_kmh' => (float)$current['wind_speed_10m'],
                'precipitation_mm' => (float)$current['precipitation'], 'condition' => $condition,
                'advice' => $indoor ? 'Consider an indoor workout at IronForge Gym today.' : 'Conditions may suit an outdoor warm-up before your gym session.',
            ];
        } catch (Throwable $e) {
            Logger::error('Open-Meteo failure: ' . $e->getMessage());
            throw new ExternalServiceException();
        }
    }
}
