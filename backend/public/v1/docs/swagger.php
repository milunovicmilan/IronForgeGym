<?php
ini_set('display_errors', '0');
require_once __DIR__ . '/../../../vendor/autoload.php';
// Relative server URL works in XAMPP subfolders as well as PHP's development server.
$script = $_SERVER['SCRIPT_NAME'] ?? '/backend/public/v1/docs/swagger.php';
define('API_BASE_PATH', preg_replace('~/public/v1/docs/swagger\.php$~', '', $script));
$files = array_merge([__DIR__ . '/doc_setup.php'], glob(__DIR__ . '/paths/*.php'));
foreach ($files as $file) { require_once $file; }
$openapi = (new OpenApi\Generator())->generate($files);
header('Content-Type: application/json; charset=utf-8');
echo $openapi->toJson();
