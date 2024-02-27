<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use JsonSerializable;

class Task implements JsonSerializable
{
    public ?string $id = null;

    public function __construct(
        public string $title,
        public ?string $deadline,
        public bool $hasDeadline,
        public string $description,
        public string $author,
    ) {
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'deadline' => $this->deadline,
            'has_deadline' => $this->hasDeadline,
            'description' => $this->description,
            'author' => $this->author,
        ];
    }
}