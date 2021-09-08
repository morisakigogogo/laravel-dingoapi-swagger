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
 *     description="Use a global client_id / client_secret and your email / password combo to obtain a token",
 *     name="access_token",
 *     in="header",
 *     scheme="http",
 *     securityScheme="access_token",
 *     @OA\Flow(
 *         flow="password",
 *         authorizationUrl="/oauth/authorize",
 *         tokenUrl="/oauth/token",
 *         refreshUrl="/oauth/token/refresh",
 *         scopes={}
 *     )
 * )
 */
class BaseController extends Controller
{
    use Helpers;
}
