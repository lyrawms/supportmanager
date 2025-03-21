<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;

class CheckDeadline1DayController
{
    public function __invoke(TaskService $taskService)
    {
        $taskService->checkDeadline('THE DEADLINE OF THESE TASKS ARE IN 1 DAY:', now()->addDay()->toDateString());
    }
}
