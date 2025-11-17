<?php

require __DIR__ . '/../../vendor/autoload.php';

use Flight;
use App\Config\DB;


Flight::route('GET /', function () {
   

require __DIR__ . '/routes/userRoutes.php';
require __DIR__ . '/routes/parkingLotRoutes.php';
require __DIR__ . '/routes/parkingSpotRoutes.php';
require __DIR__ . '/routes/reservationRoutes.php';
require __DIR__ . '/routes/paymentRoutes.php';

Flight::start();
