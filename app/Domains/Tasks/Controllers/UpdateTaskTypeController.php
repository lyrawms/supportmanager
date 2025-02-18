<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;
use Illuminate\Http\Request;

class UpdateTaskTypeController
{
    protected TaskService $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    public function __invoke(Request $request)
    {
        $taskUuid = $request->input('taskUuid');
        $typeUuid = $request->input('typeUuid');

        return $this->taskService->updateTaskType($taskUuid, $typeUuid);
    }
}
