<?php

namespace App\Domains\Tasks\ViewModels;

use App\Domains\Tasks\Models\Task;
use App\Http\ViewModels\ViewModel;

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
