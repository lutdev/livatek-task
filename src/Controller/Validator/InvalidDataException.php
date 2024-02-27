<?php

declare(strict_types=1);

namespace App\Controller\Validator;

use RuntimeException;

class InvalidDataException extends RuntimeException
{
    public function __construct(
        string $message,
    ) {
        parent::__construct('Data is invalid: ' . $message);
    }
}