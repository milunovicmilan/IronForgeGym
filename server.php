<?php
// Development router. From the project root: php -S localhost:8000 server.php
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$root = __DIR__;
if (str_contains($path, "\0") || preg_match('~(^|/)\.\.?(/|$)~', $path) || str_contains($path, '\\')) {
    http_response_code(404); return true;
}
if ($path === '/') { header('Location: /frontend/'); return true; }
if ($path === '/backend' || str_starts_with($path, '/backend/')) {
    if (preg_match('~^/backend/(config|dao|services|tests|utils|logs|vendor|middleware)(/|$)~i', $path) ||
        preg_match('~^/backend/(bootstrap\.php|composer\.(json|lock))$~i', $path)) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['status' => 403, 'error' => 'This file is not public.']);
        return true;
    }
    if ($path === '/backend/public/v1/docs') { header('Location: ' . $path . '/'); return true; }
    if ($path === '/backend/public/v1/docs/') {
        header('Content-Type: text/html; charset=utf-8');
        readfile($root . '/backend/public/v1/docs/index.html'); return true;
    }
    if ($path === '/backend/public/v1/docs/swagger.php') {
        $_SERVER['SCRIPT_NAME'] = $path;
        require $root . $path; return true;
    }
    if (preg_match('~^/backend/public/v1/docs/assets/[a-zA-Z0-9_.-]+$~', $path) && is_file($root . $path)) { return false; }
    $_SERVER['SCRIPT_NAME'] = '/backend/index.php';
    require $root . '/backend/index.php'; return true;
}
if (str_starts_with($path, '/frontend/') && is_file($root . $path) && pathinfo($path, PATHINFO_EXTENSION) !== 'php') { return false; }
http_response_code(404);
return true;
