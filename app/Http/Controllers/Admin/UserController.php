<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\UserTransformer;

class UserController extends BaseController
{
    /**
     * 会員リスト
     */
        /**
     * (
     * #ref: './users.yaml'
     * )
     */
    public function index(Request $request)
    {
        //search
        $name = $request->input('name'); // queryはGETしか取得できない。　input は　GET or POST 両方でも取得できる
        $email = $request->input('email');

        echo "shopapi";
        
        $users = User::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%$name%"); // "" 可以直接寫變量
        })
        ->when($email, function($query) use ($email) {
            $query->where('email', $email);
        })
        ->paginate(3);
        // var_dump($users);
        // $users = User::all();
        // return $users; UserTransformer フィルタカラム　過濾想要返回的字段
        // return $this->response->collection($users, new UserTransformer());

        // ページネーション
        // "meta": {
        //     "pagination": {
        //         "total": 5,
        //         "count": 2,
        //         "per_page": 2,
        //         "current_page": 1,
        //         "total_pages": 3,
        //         "links": {
        //             "next": "http://shopapi.test/api/admin/users?page=2"
        //         }
        //     }
        // }
        // $users = User::paginate(3);// "3"はリストのアイテム数です。
        return $this->response->paginator($users, new UserTransformer());
    }

    /**
     * 会員詳細
     * GET|HEAD
     * /api/admin/users/{id}
     * $id 取得　{id} の値
     * 獲取的id 為什麼不能注入 User的實例呢
     * 需要配置中間件 Kernel.php 的$routeMiddleware 裡面的 SubstituteBindings
     * 這樣 就可以自動獲取到 傳入的id對應的用戶的值了 // 支持路由模型注入
     */
    /**
     * @OA\GET(
     *     path="/admin/users/{id}",
     *     tags={"Admin"},
     *     summary="会員詳細",
     *     description="会員詳細",
     *     operationId="usersid",
     *     deprecated=false,
     *     security={ {"bearer_token": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ユーザID",
     *         required=true,
     *         @OA\Schema(
     *             type="number"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     )
     * )
     */
    public function show(User $user)
    {
        //
        // return $user;

        // 返回結果：
        // {
        //     "data": {
        //         "id": 2,
        //         "name": "bbb",
        //         "email": "bbb@bbb.com",
        //         "created_at": "2021-05-20T16:01:31.000000Z",
        //         "updated_at": "2021-05-20T16:01:38.000000Z"
        //     }
        // }
        return $this->response->item($user, new UserTransformer());
    }
    /**
     * 会員ロック/非ロック
     */
    /**
     * @OA\patch(
     *     path="/admin/users/{userid}/lock",
     *     tags={"Admin"},
     *     summary="会員ロック/非ロック",
     *     description="会員ロック/非ロック",
     *     operationId="userlock",
     *     deprecated=false,
     *     security={ {"bearer_token": {} }},
     *     @OA\Parameter(
     *         name="userid",
     *         in="path",
     *         description="ユーザID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="noContent!"
     *     )
     * )
    */
    public function lock(User $user)
    {
        $user->is_locked = $user->is_locked == 0 ? 1 : 0;
        $user->save();
        return $this->response->noContent(); 
    }
}
