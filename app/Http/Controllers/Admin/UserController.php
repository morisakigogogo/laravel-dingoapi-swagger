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
    public function index(Request $request)
    {
        //search
        $name = $request->input('name'); // queryはGETしか取得できない。　input は　GET or POST 両方でも取得できる
        $email = $request->input('email');

        $users = User::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%$name%"); // "" 可以直接寫變量
        })
        ->when($email, function($query) use ($email) {
            $query->where('email', $email);
        })
        ->paginate(3);

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
     */
    public function show($id)
    {
        //
    }
    /**
     * 会員ロック/非ロック
     */
    public function lock($id)
    {
        //
    }
}
