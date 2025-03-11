<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteTaskController extends Controller
{
    public function __invoke(Request $request)
    {
        $taskService = new TaskService();
        $taskUuid = $request->uuid;
        return $taskService->delete($taskUuid);
    }
}
