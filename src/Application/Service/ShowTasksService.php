<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Repository\TaskRepositoryInterface;
use App\Controller\Dto\NewTaskDto;
use App\Domain\Entity\Task;

readonly class ShowTasksService
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
    ) {
    }

    /**
     * @return Task[]
     */
    public function process(): array
    {
        return $this->taskRepository->findAll();
    }
}