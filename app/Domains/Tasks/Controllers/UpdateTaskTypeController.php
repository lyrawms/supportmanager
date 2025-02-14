<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;

class UpdateTaskTypeController
{
    protected TaskService $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    public function __invoke()
    {
        $taskUuid = request()->uuid;
        $typeUuid = request()->type_uuid;

        $this->taskService->updateTaskType($taskUuid, $typeUuid);

        return redirect()->route('tasks.show', ['uuid' => $taskUuid]);

    }
}
