<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends BaseController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login', 'refresh']]);

        // 整个控制器的接口都需要登录验证
        // $this->middleware('api.auth');

        // 这个需要登录验证中间件只在  me  中启用
        // $this->middleware('api.auth', ['only' => ['me']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\POST(
     *     path="/auth/login",
     *     tags={"Auth"},
     *     summary="ログイン",
     *     description="会員ログイン",
     *     operationId="login",
     *     deprecated=false,
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="E-mail",
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
     *     @OA\Response(
     *         response=200,
     *         description="ログインしました！"
     *     ),
    * @OA\Response(
    *     response=422,
    *     description="Validation error",
    *     @OA\JsonContent(
    *        @OA\Property(property="message", type="string", example="The given data was invalid."),
    *        @OA\Property(
    *           property="errors",
    *           type="object",
    *           @OA\Property(
    *              property="email",
    *              type="array",
    *              collectionFormat="multi",
    *              @OA\Items(
    *                 type="string",
    *                 example={"The email field is required.","The email must be a valid email address."},
    *              )
    *           )
    *        )
    *     )
    *  ),
     *     @OA\Response(
     *         response=400,
     *         description="ログインエラーです。"
     *     )
     * )
     */
    public function login(Request $request)
    {
        // dd(bcrypt('1111qqqq'));
        $credentials = request(['email', 'password']);


        // dd($credentials);
        if (!$token = auth('api')->attempt($credentials)) { //進行認證
            // return response()->json(['error' => 'Unauthorized'], 401);
            return $this->response->errorUnauthorized(); //認證不通過返回異常
        }
        // ユーザー状態検査
        $user = auth('api')->user();
        if ($user->is_locked == 1) {
            return $this->response->errorForbidden('ユーザはロックされています。');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /** 
    * @OA\Post ( 
    * path="/auth/logout", 
    * summary="注销", 
    * description="注销用户并使令牌无效", 
    * operationId="authLogout", 
    * tags={"Auth"}, 
    * security={ {"bearer": {} }}, 
    * @OA\Response ( 
    * response=200, 
    * description="Success" 
    * ), 
    * @OA\Response ( 
    * response=401, 
    * description ="用户未通过身份验证时返回", 
    *     @OA\JsonContent ( 
    *        @OA\Property (property="message", type="string", example="未授权"), 
    * ) 
    * ) 
    * )
    */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}