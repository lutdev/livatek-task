<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Repository\TaskRepositoryInterface;
use App\Controller\Dto\NewTaskDto;
use App\Domain\Entity\Task;

readonly class DeleteTasksService
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function process(string $taskId): void
    {
        $this->taskRepository->deleteById($taskId);
    }
}