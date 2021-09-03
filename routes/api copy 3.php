<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1],function ($api) {
    $api->get('test', [TestController::class, 'index']);
});

$api->version('v2', function ($api) {
    $api->get('in', [TestController::class, 'in2']);
});