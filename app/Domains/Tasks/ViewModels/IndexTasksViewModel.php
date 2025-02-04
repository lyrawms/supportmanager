<?php

namespace App\Domains\Tasks\ViewModels;

use App\Domains\Tasks\Services\TaskService;
use App\Http\ViewModels\ViewModel;

class IndexTasksViewModel extends ViewModel
{

    /**
     * Define a component that inertia should render
     * @var string
     */
    public string $component = 'Tasks/IndexTasks';

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
