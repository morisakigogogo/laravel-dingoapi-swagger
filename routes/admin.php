<?php
use \App\Http\Controllers\Admin\UserController as Users;
use \App\Http\Controllers\Admin\CategoryController as Category;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\GoodsController;

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
        $api->patch('users/{user}/lock', [Users::class, 'lock']);

        // 会員管理リソースルーティング
        // $api->resource dingoAPI 書き方　
        $api->resource('users', Users::class, ['only' => ['index', 'show']]);

        /**カテゴリ管理 */
        $api->patch('category/{category}/status', [Category::class, 'status']);
        $api->resource('category', Category::class,['except' => ['destroy', 'index']]);
        $api->get('categorys', [Category::class,'index']);

        /**
         * 商品管理
         */

        // * 是否上架
        $api->patch('goods/{good}/on', [GoodsController::class, 'isOn']);

        // * 是否推荐
        $api->patch('goods/{good}/recommend', [GoodsController::class, 'isRecommend']);

        //商品リソースルーティング
        $api->resource('goods', GoodsController::class,['except' => ['destroy']]);


        /**
         * 評價管理
         */
        //評價列表
        $api->get('comments', [CommentController::class, 'index']);
        //評價详情
        $api->get('comments/{comment}', [CommentController::class, 'show']);
        //商家的回复
        $api->get('comments/{comment}/reply', [CommentController::class, 'reply']);

    });
});
