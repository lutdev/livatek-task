<?php

declare(strict_types=1);

namespace App\Controller;

use App\Configuration\HttpResponseCodeEnum;
use App\Configuration\Request;

class Controller
{
    public function __construct(
        protected readonly Request $request,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     *
     * Feature: separate Response class + https://github.com/php-fig/http-message
     */
    public function response(array $data, HttpResponseCodeEnum $statusCode): string
    {
        http_response_code($statusCode->value);
        header('Content-Type: application/json; charset=utf-8');

        return json_encode($data, JSON_THROW_ON_ERROR);
    }
}