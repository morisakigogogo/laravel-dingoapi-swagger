<?php
use \App\Http\Controllers\Admin\UserController as Admin;

$api = app('Dingo\Api\Routing\Router');

//bindings 是在Kernel.php 裡面設置的$routeMiddleware 路由中間件
$paramsMiddlewares = [
    'middleware' => [
            'api.throttle', 
            'serializer:array', // liyu/dingo-serializer-switch 格式化返回的數據 減少transformer的包裹層級
            'bindings' // 支持路由模型注入
        ], 
        'limit' => 60, 
        'expires' => 1
];

$api->version('v1', $paramsMiddlewares, function ($api) {
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
