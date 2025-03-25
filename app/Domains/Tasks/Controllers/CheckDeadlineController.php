<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;
use App\Http\Controllers\Controller;

class CheckDeadlineController extends Controller
{

    public function __invoke(TaskService $taskService)
    {
        $taskService->checkDeadline('THESE TASKS ARE PAST THEIR DEADLINE:');
    }
}
