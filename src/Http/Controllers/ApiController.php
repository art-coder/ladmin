<?php

namespace Artcoder\Ladmin\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{

    public $response = [
        'code'       => 10001,
        'message'    => null,
        'data'       => null,
    ];

}
