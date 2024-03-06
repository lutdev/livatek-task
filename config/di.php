<?php

declare(strict_types=1);

use App\Application\Infrastructure\TaskRepository;
use App\Application\Repository\TaskRepositoryInterface;
use App\Application\Service\CreateTaskService;
use App\Application\Service\DeleteTasksService;
use App\Application\Service\ShowTasksService;

return [
    TaskRepositoryInterface::class => static function ($container): TaskRepository {
        $storagePath = dirname(__DIR__) . '/storage';

        return new TaskRepository($storagePath);
    },

    CreateTaskService::class => static function ($container): CreateTaskService {
        $taskRepository = $container->get(TaskRepositoryInterface::class);

        return new CreateTaskService($taskRepository);
    },

    ShowTasksService::class => static function ($container): ShowTasksService {
        $taskRepository = $container->get(TaskRepositoryInterface::class);

        return new ShowTasksService($taskRepository);
    },

    DeleteTasksService::class => static function ($container): DeleteTasksService {
        $taskRepository = $container->get(TaskRepositoryInterface::class);

        return new DeleteTasksService($taskRepository);
    },
];