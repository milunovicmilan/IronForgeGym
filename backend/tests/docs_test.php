<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
$_SERVER['SCRIPT_NAME'] = '/backend/public/v1/docs/swagger.php';
ob_start();
require __DIR__ . '/../public/v1/docs/swagger.php';
$json = ob_get_clean();
$spec = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
if (!str_starts_with($spec['openapi'] ?? '', '3.')) { throw new RuntimeException('OpenAPI 3 document missing.'); }
$routes = array_merge([__DIR__ . '/../index.php'], glob(__DIR__ . '/../routes/*Routes.php'));
$count = 0;
foreach ($routes as $file) {
    preg_match_all("/Flight::route\('([^']+)'/", file_get_contents($file), $matches);
    foreach ($matches[1] as $route) {
        [$methods, $path] = explode(' ', $route, 2);
        $path = str_replace('@id:[0-9]+', '{id}', $path);
        foreach (explode('|', $methods) as $method) {
            $operation = $spec['paths'][$path][strtolower($method)] ?? null;
            if (!$operation) { throw new RuntimeException("Missing documentation: $method $path"); }
            $success = $method === 'POST' && !str_ends_with($path, '/cancel') ? '201' : '200';
            if (!isset($operation['responses'][$success])) { throw new RuntimeException("Missing $success: $method $path"); }
            if (str_contains($path, '{id}')) {
                $ids = array_filter($operation['parameters'] ?? [], fn($p) => $p['name'] === 'id' && $p['in'] === 'path' && ($p['required'] ?? false));
                if (!$ids) { throw new RuntimeException("Missing path parameter: $method $path"); }
            }
            $count++;
        }
    }
}
if (isset($spec['components']['schemas']['User']['properties']['password_hash']) ||
    isset($spec['components']['schemas']['User']['properties']['password'])) { throw new RuntimeException('User response schema exposes a password.'); }
$errorFields = $spec['components']['schemas']['Error']['properties'] ?? [];
if (!isset($errorFields['status'], $errorFields['error'])) { throw new RuntimeException('Wrong Error schema.'); }
if (!isset($spec['paths']['/weather/sarajevo']['get']['responses']['503'])) { throw new RuntimeException('Weather failure not documented.'); }
echo 'PASS OpenAPI: ' . count($spec['paths']) . ' paths, ' . $count . ' documented operations, ' . count($spec['components']['schemas']) . " schemas.\n";
