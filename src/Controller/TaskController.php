<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\Service\CreateTaskService;
use App\Application\Service\DeleteTasksService;
use App\Application\Service\ShowTasksService;
use App\Configuration\HttpResponseCodeEnum;
use App\Configuration\Request;
use App\Controller\Dto\NewTaskDto;
use App\Controller\Validator\DeleteTaskValidator;
use App\Controller\Validator\InvalidDataException;
use App\Controller\Validator\NewTaskValidator;
use DateTimeImmutable;
use function DI\value;

class TaskController extends Controller
{
    public function __construct(
        Request $request,
        private readonly NewTaskValidator $newTaskValidator,
        private readonly DeleteTaskValidator $deleteTaskValidator,
        private readonly CreateTaskService $createTaskService,
        private readonly ShowTasksService $showTasksService,
        private readonly DeleteTasksService $deleteTasksService,
    ) {
        parent::__construct($request);
    }

    public function createNewTask(): string
    {
        $params = $this->request->fetchParams(['title', 'description', 'has_deadline', 'deadline', 'author']);

        try {
            $this->newTaskValidator->validate($params);
        } catch (InvalidDataException $exception) {
            return $this->response([
                'success' => false,
                'message' => $exception->getMessage(),
            ], HttpResponseCodeEnum::ValidationError);
        }

        $deadline = DateTimeImmutable::createFromFormat('Y-m-d', $params['deadline']);

        // have no time to implement better solution
        if ($deadline === false) {
            return $this->response([
                'success' => false,
                'message' => 'Deadline is invalid',
            ], HttpResponseCodeEnum::ValidationError);
        }

        $dto = new NewTaskDto(
            $params['title'],
            $deadline,
            $params['has_deadline'],
            $params['description'],
            $params['author'],
        );

        $task = $this->createTaskService->process($dto);

        return $this->response([
            'success' => true,
            'model' => $task,
        ], HttpResponseCodeEnum::Created);
    }

    public function showTasks(): string
    {
        $tasks = $this->showTasksService->process();

        return $this->response([
            'success' => true,
            'list' => $tasks,
        ], HttpResponseCodeEnum::Success);
    }

    public function deleteTask(): string
    {
        $params = $this->request->fetchParams(['id']);

        try {
            $this->deleteTaskValidator->validate($params);
        } catch (InvalidDataException $exception) {
            return $this->response([
                'success' => false,
                'message' => $exception->getMessage(),
            ], HttpResponseCodeEnum::ValidationError);
        }

        $this->deleteTasksService->process($params['id']);

        return $this->response([
            'success' => true,
        ], HttpResponseCodeEnum::Gone);
    }
}