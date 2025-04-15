<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class updateTaskStatusController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(Request $request, TaskService $taskService)
    {
        $taskUuid = $request->uuid;
        $status = $request->status;
        $category = $request->category;

        $taskService->updateTaskStatus($taskUuid, $status);
        return redirect(route('tasks.index', ["category" => $category]));
    }
}
