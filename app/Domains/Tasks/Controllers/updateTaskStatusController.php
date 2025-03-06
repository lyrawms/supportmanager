<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class updateTaskStatusController extends Controller
{
    public function __invoke(Request $request)
    {
        $taskService = new TaskService();
        $taskUuid = $request->uuid;
        $status = $request->status;
        return $taskService->updateTaskStatus($taskUuid, $status);
    }
}
