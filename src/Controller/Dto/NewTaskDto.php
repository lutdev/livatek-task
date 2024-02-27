<?php

declare(strict_types=1);

namespace App\Controller\Dto;

use DateTimeImmutable;

readonly class NewTaskDto
{
    public function __construct(
        public string $title,
        public ?DateTimeImmutable $deadline,
        public bool $hasDeadline,
        public string $description,
        public string $author,
    ) {
    }
}