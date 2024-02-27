<?php

declare(strict_types=1);

namespace App\Configuration\Routing\Exceptions;

use RuntimeException;

class ContentTypeIsInvalidException extends RuntimeException
{
    public function __construct(
        public readonly string $contentType,
    ) {
        parent::__construct('Content type is not valid for this request');
    }
}
