<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\Exception\EntityNotFoundException;
use App\Controller\Dto\NewTaskDto;
use App\Domain\Entity\Task;

interface TaskRepositoryInterface
{
    /**
     * @throws EntityNotFoundException
     */
    public function store(NewTaskDto $newTaskDto): Task;

    /**
     * @return Task[]
     */
    public function findAll(): array;

    public function deleteById(string $taskId): void;
}