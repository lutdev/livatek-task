<?php

declare(strict_types=1);

namespace App\Configuration\Routing\Exceptions;

use RuntimeException;

class RequestMethodIsInvalidException extends RuntimeException
{
    public function __construct(
        public readonly string $method,
    ) {
        parent::__construct('Request method is not valid for this request');
    }
}
