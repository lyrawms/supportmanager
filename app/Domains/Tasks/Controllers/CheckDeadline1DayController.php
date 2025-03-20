<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;

class CheckDeadline1DayController
{
    public function __invoke(TaskService $taskService)
    {
        $taskService->checkDeadline('The deadline of these tasks are in 1 day!', now()->addDay()->toDateString());
    }
}
