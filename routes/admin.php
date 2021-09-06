<?php
use \App\Http\Controllers\Admin\UserController as Admin;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1],function ($api) {
    //需要登录验证的接口，用组划分
    $api->group(['prefix' => 'admin','middleware' => 'api.auth'],function ($api) {
        // $api->get('users',  [TestController::class, 'users']);
        /**
         * 会員管理
         */
        // 会員ロック/非ロック
        $api->patch('users/{user}/lock', [Admin::class, 'lock']);

        // 会員管理リソースルーティング
        // $api->resource dingoAPI 書き方　
        $api->resource('users', Admin::class, ['only' => ['index', 'show']]);
    });
});
