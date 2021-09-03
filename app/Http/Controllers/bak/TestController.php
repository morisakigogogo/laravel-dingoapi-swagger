<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\UserTransformer;

class TestController extends Controller
{
    
    public function index(Request $request)
    {
        
        // return User::all();
        // return User::find(1);
        $user = User::findOrFail(1);
        // 使用相应生成器，相应一个数组
        // return $this->response->array($user->toArray());
        // return $this->response->noContent();
        // return $this->response->created(); //201
        
        // 一个自定义消息和状态码的普通错误。
        // return $this->response->error('This is an error.', 404);

        // 一个没有找到资源的错误，第一个参数可以传递自定义消息。
        // return $this->response->errorNotFound();

        // 一个 bad request 错误，第一个参数可以传递自定义消息。
        // return $this->response->errorBadRequest();

        // // 一个服务器拒绝错误，第一个参数可以传递自定义消息。
        // return $this->response->errorForbidden();

        // // 一个内部错误，第一个参数可以传递自定义消息。
        // return $this->response->errorInternal();

        // // 一个未认证错误，第一个参数可以传递自定义消息。
        // return $this->response->errorUnauthorized();

        // throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException('请求错误测试');

        // 字段驗證異常
        // $rules = [
        //     'username' => ['required', 'alpha'],
        //     'password' => ['required', 'min:7']
        // ];

        // $payload = app('request')->only('username', 'password');

        // $validator = app('validator')->make($payload, $rules);

        // if ($validator->fails()) {
        //     throw new \Dingo\Api\Exception\StoreResourceFailedException('エラー　Could not create new user.', $validator->errors());
        // }

        // $validatedData = $request->validate([
        //     'title' => 'required|unique:posts|max:255',
        //     'body' => 'required'
        // ]);
        // return $this->response->item($user, new UserTransformer);

        //相应生成器
        // $user = User::find(1);
        // return $user;
        // return $this->response->item($user, new UserTransformer());

        // $users = User::all();

        // return $this->response->collection($users, new UserTransformer);

        $users = User::paginate(1);

        return $this
        ->response
        ->paginator($users, new UserTransformer)
        ->withHeader('X-Foo', 'Bar')
        ->addMeta('foo', 'bar');
        // ->setStatusCode(400);

    }

    // public function users()
    // {
    //     $url = app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('test.name');
    //     dd($url);
    // }
    public function name()
    {
        $url = app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('test.name');
        // dd($url);
        // dd('ddd');
        // return 'name';
    }

    // public function login(Request $request)
    // {
    //     $email = $request->input('email');
    //     $password = $request->input('password');
    //     return $this->response->collection($users, new UserTransformer);
    // }

    public function users()
    {
        $users = User::all();
        return $this->response->collection($users, new UserTransformer);

        //重token获取信息
        // $user = app('Dingo\Api\Auth\Auth')->user();
        // $user = auth('api')->user();

        $user = $this->auth->user();

        return $user;

    }
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
