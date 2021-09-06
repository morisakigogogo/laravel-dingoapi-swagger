<?php
use App\Http\Controllers\Auth\RegisterController as Register;
use App\Http\Controllers\Auth\AuthController as Auth;

$api = app('Dingo\Api\Routing\Router');

// $api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1],function ($api) {
//     //需要登录验证的接口，用组划分
//     $api->group(['middleware' => 'api.auth'],function ($api) {
//         // $api->get('users',  [TestController::class, 'users']);
//     });
// });

$api->version('v1', ['middleware' => 'api.throttle', 'limit' => 60, 'expires' => 1],function ($api) {
    $api->group(['prefix' => 'auth'],function ($api) {
        //会員登録
        $api->post('register', [Register::class, 'store']);
        //ログイン
        $api->post('login', [Auth::class, 'login']);
        //ログアウト
        $api->post('logout', [Auth::class, 'logout']);
    });
});