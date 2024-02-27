<?php

declare(strict_types=1);

namespace App\Configuration;

enum HttpResponseCodeEnum: int
{
    case Success = 200;

    case Created = 201;

    case ValidationError = 400;

    case Gone = 410;
}
