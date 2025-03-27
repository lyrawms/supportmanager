<?php

namespace App\Domains\Tasks\ViewModels;

use App\Domains\Tasks\Services\TaskService;
use App\Http\ViewModels\ViewModel;

class IndexTasksViewModel extends ViewModel
{
    public string $component = 'Tasks/Pages/IndexTasks';

    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function toArray(String $category = null): array
    {
        return [
            'tasks' => $this->taskService->getAllTasks($category)->toArray(),
        ];
    }
}
