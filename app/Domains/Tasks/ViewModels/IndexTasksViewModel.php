<?php

namespace App\Domains\Tasks\ViewModels;

use App\Domains\Tasks\Services\TaskService;
use App\Http\ViewModels\ViewModel;

class IndexTasksViewModel extends ViewModel
{
    public string $component = 'Tasks/Pages/IndexTasks';

    protected TaskService $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService;
    }

    public function toArray(): array
    {
        return [
            'tasks' => $this->taskService->getAllTasks()->toArray(),
        ];
    }
}
