<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1],function ($api) {
    //需要登录验证的接口，用组划分
    $api->group(['middleware' => 'api.auth'],function ($api) {
        // $api->get('users',  [TestController::class, 'users']);
    });
});
