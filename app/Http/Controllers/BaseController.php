<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers; // 就可以使用 $this->respose 等等了

class BaseController extends Controller
{
    use Helpers;
}
