<?php

namespace App\Domains\Tasks\ViewModels;

use App\Domains\Tasks\Repositories\TaskRepository;
use App\Http\ViewModels\ViewModel;
use App\Models\Task;

class ShowTaskViewModel extends ViewModel
{
public string $component = 'Tasks/ShowTask';


    public function toArray(Task $task = null): array
    {
        return [
            'task' => $task,
        ];
    }
}
