<?php

declare(strict_types=1);

namespace App\Configuration\Routing\Exceptions;

use RuntimeException;

class ParamDoesNotExistException extends RuntimeException
{
    public function __construct(
        public readonly string $parameter,
    ) {
        parent::__construct('Parameter doesn\'t exist in the request');
    }
}
