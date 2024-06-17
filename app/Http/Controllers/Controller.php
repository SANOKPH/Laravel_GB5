<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

#[\OpenApi\Attributes\Info(
    title: "Test API REST",
    version: "latest",
    description: "test",
)]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
