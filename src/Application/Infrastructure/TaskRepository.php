<?php

declare(strict_types=1);

namespace App\Application\Infrastructure;

use App\Application\Exception\EntityNotFoundException;
use App\Application\Repository\TaskRepositoryInterface;
use App\Controller\Dto\NewTaskDto;
use App\Domain\Entity\Task;

final class TaskRepository implements TaskRepositoryInterface
{
    private const DEADLINE_DATE_FORMAT = 'Y-m-d H:i:s';

    private const FILE_EXTENSION = '.log';

    public function __construct(
        private readonly string $storageFolder,
    ) {
    }

    public function store(NewTaskDto $newTaskDto): Task
    {
        $task = new Task(
            $newTaskDto->title,
            $newTaskDto->deadline?->format(self::DEADLINE_DATE_FORMAT),
            $newTaskDto->hasDeadline,
            $newTaskDto->description,
            $newTaskDto->author,
        );

        $recordId = $this->generateId();

        $task->setId($recordId);

        file_put_contents(
            $this->storageFolder . DIRECTORY_SEPARATOR . $recordId . self::FILE_EXTENSION,
            json_encode($task, JSON_THROW_ON_ERROR)
        );

        return $task;
    }

    public function findAll(): array
    {
        $tasks = [];

        if ($handle = \opendir($this->storageFolder)) {
            while (false !== ($entry = \readdir($handle))) {
                if ($entry !== "." && $entry !== ".." && $entry !== '.gitkeep') {
                    $fullFilePath = $this->storageFolder . DIRECTORY_SEPARATOR . $entry;

                    if (
                        !\is_file($fullFilePath)
                        || !\is_readable($fullFilePath)
                    ) {
                        throw new EntityNotFoundException('Expected file is not a file or is not readable');
                    }

                    $rawData = \file_get_contents($fullFilePath);

                    if ($rawData === false) {
                        throw new EntityNotFoundException('Problems to get data from the file');
                    }

                    $jsonDecodedData = json_decode($rawData, true, 512, JSON_THROW_ON_ERROR);

                    $task = new Task(
                        $jsonDecodedData['title'],
                        $jsonDecodedData['deadline'],
                        $jsonDecodedData['has_deadline'],
                        $jsonDecodedData['description'],
                        $jsonDecodedData['author'],
                    );
                    $task->setId(str_replace(self::FILE_EXTENSION, '', $entry));

                    $tasks[] = $task;
                }
            }
            closedir($handle);
        }

        return $tasks;
    }

    public function deleteById(string $taskId): void
    {
        unlink($this->storageFolder . DIRECTORY_SEPARATOR . $taskId . self::FILE_EXTENSION);
    }

    private function generateId(): string
    {
        return md5(time() . '-' . random_int(0, 10000));
    }
}