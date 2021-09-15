<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;

//　会員登録
class RegisterController extends BaseController
{
    /**
     * @OA\POST(
     *     path="/auth/register",
     *     tags={"Auth"},
     *     summary="会員登録",
     *     description="会員登録",
     *     operationId="register",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="ユーザ名",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Eメール",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="パスワード",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="パスワード確認",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success! 登録しました！"
     *     )
     * )
    */
    public function store(RegisterRequest $request)
    {
        //Request 元にある， RegisterRequest　自分書いた
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return $this->response->created();
    }
}
