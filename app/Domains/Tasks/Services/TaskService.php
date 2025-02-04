<?php

namespace App\Domains\Tasks\Services;

use App\Domains\Tasks\Repositories\TaskRepository;
use Illuminate\Support\Collection;

class TaskService
{
    protected TaskRepository $taskRepository;

    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
    }

    public function getAllTasks(): Collection
    {
        return $this->taskRepository->getAll();

    }
}
