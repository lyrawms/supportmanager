<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateTaskUserController extends Controller
{
    public function __invoke(Request $request)
    {
        $taskService = new TaskService();
        $taskUuid = $request->input('taskUuid');
        $userUuid = $request->input('userUuid');
        return $taskService->updateTaskUser($taskUuid, $userUuid);
    }

}
