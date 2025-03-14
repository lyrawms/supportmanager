<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateTaskUserController extends Controller
{
    public function __invoke(Request $request, TaskService $taskService)
    {
        $taskUuid = $request->input('taskUuid');
        $userUuid = $request->input('userUuid');
        $category = $request->input('category');

        $taskService->updateTaskUser($taskUuid, $userUuid);
        return redirect(route('tasks.index', ["category" => $category]));

    }
}
