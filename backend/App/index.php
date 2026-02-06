<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);   // IMPORTANT: don't print warnings into responses
ini_set('log_errors', 1);

/*
|--------------------------------------------------------------------------
| CORS (needed for browser → backend calls)
|--------------------------------------------------------------------------
*/
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

/*
|--------------------------------------------------------------------------
| Autoload
|--------------------------------------------------------------------------
*/
require __DIR__ . '/../../vendor/autoload.php';

use App\services\AuthService;

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/
Flight::map('haltJson', function (int $status, string $message) {
    Flight::json(['error' => $message], $status);
    Flight::stop();
});

Flight::map('requireRole', function (string $role) {
    $user = Flight::get('user');
    if (!$user || ($user['role'] ?? null) !== $role) {
        Flight::haltJson(403, 'Forbidden');
    }
});

/*
|--------------------------------------------------------------------------
| Error handling
|--------------------------------------------------------------------------
*/
Flight::map('error', function (Throwable $ex) {
    error_log($ex);
    Flight::json([
        'error' => 'Server error',
        'message' => $ex->getMessage()
    ], 500);
});

Flight::map('notFound', function () {
    Flight::json(['error' => 'Not found'], 404);
});

/*
|--------------------------------------------------------------------------
| DB
|--------------------------------------------------------------------------
*/
require __DIR__ . '/Config/DB.php';

/*
|--------------------------------------------------------------------------
| AUTH MIDDLEWARE
|--------------------------------------------------------------------------
*/
Flight::before('route', function () {

    $request = Flight::request();
    $method  = $request->method;
    $path    = parse_url($request->url, PHP_URL_PATH);

    $publicRoutes = [
        ['GET',  '/'],
        ['POST', '/auth/login'],
        ['POST', '/auth/register'],
        ['GET',  '/parking-lots'],
        ['GET',  '/parking-spots'],
    ];

    foreach ($publicRoutes as [$m, $p]) {
        if ($method === $m && $path === $p) {
            return;
        }
    }

    $authHeader = $request->getHeader('Authorization');
    if (!$authHeader || !preg_match('/Bearer\s+(.+)/', $authHeader, $m)) {
        Flight::haltJson(401, 'Missing Authorization header');
    }

    try {
        $user = AuthService::verifyToken($m[1]);
        Flight::set('user', $user);
    } catch (Exception $e) {
        Flight::haltJson(401, 'Invalid or expired token');
    }
});

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Flight::route('GET /', function () {
    Flight::json([
        'status' => 'ok',
        'message' => 'API running'
    ]);
});

/*
|--------------------------------------------------------------------------
| ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/routes/authRoutes.php';
require __DIR__ . '/routes/userRoutes.php';
require __DIR__ . '/routes/parkingLotRoutes.php';
require __DIR__ . '/routes/parkingSpotRoutes.php';
require __DIR__ . '/routes/reservationRoutes.php';
require __DIR__ . '/routes/paymentRoutes.php';

/*
|--------------------------------------------------------------------------
| START
|--------------------------------------------------------------------------
*/
Flight::start();
