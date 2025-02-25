<?php

namespace App\Domains\Tasks\Services;

use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Tasks\Repositories\TaskRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    protected TaskRepository $taskRepository;

    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
    }

    public function getAllTasks(): LengthAwarePaginator
    {
        return $this->taskRepository->getAll();
    }

    public function getTaskWithRelationships(String $uuid): Task
    {
        return $this->taskRepository->getTaskWithRelationships($uuid);
    }

    public function updateTaskType(String $taskUuid, String $typeUuid)
    {
        return $this->taskRepository->updateTaskType($taskUuid, $typeUuid);
    }

    public function updateTaskUser(String $taskUuid, String $userUuid)
    {
        return $this->taskRepository->updateTaskUser($taskUuid, $userUuid);
    }
}
