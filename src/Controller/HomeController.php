<?php

declare(strict_types=1);

namespace App\Controller;

use App\Configuration\HttpResponseCodeEnum;

class HomeController extends Controller
{
    public function index(): string
    {
        return $this->response([
            'success' => true,
            'message' => 'This is a home page'
        ], HttpResponseCodeEnum::Success);
    }
}