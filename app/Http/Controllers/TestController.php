<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\UserTransformer;


/**
 * @OA\Info(
 *     version="3.0",
 *     title="Task Resource OpenApi",
 *     @OA\Contact(
 *         name="kan",
 *         url="http://kan.test",
 *         email="hirose.morisaki@gmail.com"
 *     )
 * ),
 * @OA\Server(
 *     url="http://shopapi.test/api"
 * ),
 * @OA\SecurityScheme(
 *     type="oauth2",
 *     description="Use a global client_id / client_secret and your email / password combo to obtain a token",
 *     name="passport",
 *     in="header",
 *     scheme="http",
 *     securityScheme="passport",
 *     @OA\Flow(
 *         flow="password",
 *         authorizationUrl="/oauth/authorize",
 *         tokenUrl="/oauth/token",
 *         refreshUrl="/oauth/token/refresh",
 *         scopes={}
 *     )
 * )
 */
class TestController extends BaseController
{
    public function __construct()
    {
        // $this->middleware('auth:api');
        //兩種寫法
        $this->middleware('api.auth');
    }

    /**
     * @OA\Get(
     *     path="/",
     *     operationId="getTaskList",
     *     tags={"Tasks"},
     *     summary="Get list of tasks",
     *     description="Returns list of tasks",
     *     @OA\Parameter(
     *         name="Accept",
     *         description="Accept header to specify api version",
     *         required=false,
     *         in="header",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         description="The page num of the list",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         description="The item num per page",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The result of tasks"
     *     ),
     *     security={
     *         {"passport": {}},
     *     }
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ? : 10;
        // 获取认证用户实例
        $user = $request->user('api');
        $tasks = Task::where('user_id', $user->id)->paginate($limit);
        return $this->response->paginator($tasks, new TaskTransformer());
    }
    public function users(Request $request)
    {
        $limit = $request->input('limit') ? : 10;
        // 所有用戶
        $users = User::all();
        // return $this->response->collection($users, new UserTransformer);
        // 获取一個认证用户实例
        // 第一種方式
        // $user = app('Dingo\Api\Auth\Auth') -> user();
        // 第二種方式
        // $user = auth('api')->user();
        // 第三種方式 如果使用量 use Helpers; 就可以 $this 這種方式獲取了
        $user = $this->auth->user();
        return $user;
    }
    //API文檔的寫法
    /**
     * 注册用户
     *
     * 使用 `username` 和 `password` 注册用户。
     *
     * @Post("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"username": "foo", "password": "bar"}),
     *      @Response(200, body={"id": 10, "username": "foo"}),
     *      @Response(422, body={"error": {"username": {"Username is already taken."}}})
     * })
     */

    public function in() 
    {
        //分发器实例
        $dispatcher = app('Dingo\Api\Dispatcher');

        //普通请求 并没有查询用户数据，只是内部调用
        // $users = $dispatcher->get('api/users');

        // 模拟认证用户
        $user = User::find(1);
        $users = $dispatcher->be($user)->get('api/users');
        return $users;
    }
    public function in2()
    {
        //多版本控制测试 指定版本的API 請求時
        // 请求時加上 Accept，vnd是 在env文件里设置的API_STANDARDS_TREE 的值，我们设置的是x API_SUBTYPE 是 shop
        //Accept: application/vnd.YOUR_SUBTYPE.v1+json => Accept: application/x.shop.v1+json
        $dispatcher = app('Dingo\Api\Dispatcher');
        // 模拟认证用户
        $user = User::find(2);
        // $users = $dispatcher->be($user)->get('api/users');
        return $user;
    }
}
