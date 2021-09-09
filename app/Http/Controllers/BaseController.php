<?php
// 
namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers; // 就可以使用 $this->respose 等等了

/**
 * @OA\Info(
 *     version="1.0",
 *     title="laravel + dingoApi デモ",
 *     @OA\Contact(
 *         name="hirose.morisaki",
 *         url="/",
 *         email="hirose.morisaki@gmail.com"
 *     )
 * ),
 * @OA\Server(
 *     url="http://shopapi.test/api"
 * ),
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     description="Enter token in format (Bearer <token>)",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer_token",
 *     securityScheme="Bearer"
 * )
 */
class BaseController extends Controller
{
    use Helpers;
}
