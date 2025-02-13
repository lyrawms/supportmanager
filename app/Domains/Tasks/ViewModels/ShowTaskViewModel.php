<?php

namespace App\Domains\Tasks\ViewModels;

use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Tasks\Services\TaskService;
use App\Http\ViewModels\ViewModel;
use Illuminate\Support\Carbon;

class ShowTaskViewModel extends ViewModel
{
    public string $component = 'Tasks/Modals/ShowTask';

    protected TaskService $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService;
    }


    public function toArray(String $uuid = null): array
    {
        return [
            'task' => $this->taskService->getTaskWithRelationships($uuid)->toArray(),
        ];
    }
}
