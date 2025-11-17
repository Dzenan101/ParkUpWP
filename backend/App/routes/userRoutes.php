<?php

use Flight;

Flight::route('GET /users', function () {
    Flight::json([
        "status" => "success",
        "message" => "Users endpoint working"
    ]);
});
