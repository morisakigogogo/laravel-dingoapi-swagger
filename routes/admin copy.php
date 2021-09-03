<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1],function ($api) {
    $api->get('test', [TestController::class, 'index']);

    // 命名路由
    $api->get('users/{id}', [TestController::class, 'name']);
    // $api->get('name', ['as' => 'test.name', 'test' => '\App\Http\Controllers\TestController@name']);
    
    // 内部调用
    $api->get('in', [TestController::class, 'in']);


    // $api->group([],function ($api) {
    //     $api->post('auth/login', [AuthController::class, 'login']);
    // });
    $api->post('auth/login', [AuthController::class, 'login']);
    // $api->get('users',  [TestController::class, 'users']);

    //需要登录验证的接口，用组划分
    $api->group(['middleware' => 'api.auth'],function ($api) {
        $api->get('users',  [TestController::class, 'users']);
    });
});

$api->version('v2', function ($api) {
    $api->get('in', [TestController::class, 'in2']);
});