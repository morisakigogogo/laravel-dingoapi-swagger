<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Dingo\Api\Routing\Helpers; // 就可以使用 $this->respose 等等了


class Controller extends BaseController
{
    use Helpers;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
