<?php
return [
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'port' => getenv('DB_PORT') ?: '3306',
    'database' => getenv('DB_NAME') ?: 'iron_forge_gym',
    'username' => getenv('DB_USER') ?: 'ironforge',
    'password' => getenv('DB_PASSWORD') ?: '',
    // Open-Meteo needs no API key. Maximum total request time, in seconds.
    'weather_timeout' => 5,
];
