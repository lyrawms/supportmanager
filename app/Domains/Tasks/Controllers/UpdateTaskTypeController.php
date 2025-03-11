<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateTaskTypeController  extends Controller
{
    public function __invoke(Request $request)
    {
        $taskService = new TaskService();
        $taskUuid = $request->input('taskUuid');
        $typeUuid = $request->input('typeUuid');
        $taskService->updateTaskType($taskUuid, $typeUuid);
        return back()->withSuccess("Type Successfully Updated");
    }
}
