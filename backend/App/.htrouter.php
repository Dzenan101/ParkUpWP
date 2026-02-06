<?php
// Router for PHP built-in server
// Run with: php -S localhost:8000 .htrouter.php

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file        = __DIR__ . $requestPath;

// If a static file exists (css, js, images, etc.), let PHP serve it
if (is_file($file)) {
    return false;
}

// Otherwise always load the backend entry point
require __DIR__ . '/index.php';
