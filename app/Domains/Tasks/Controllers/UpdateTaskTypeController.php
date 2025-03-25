<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;
use App\Domains\Tasks\ViewModels\ShowTaskViewModel;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class UpdateTaskTypeController  extends Controller
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request, TaskService $taskService, ShowTaskViewModel $showTaskViewModel)
    {
        $taskUuid = $request->input('taskUuid');
        $typeUuid = $request->input('typeUuid');
        $category = $request->input('category');

        $taskService->updateTaskType($taskUuid, $typeUuid);
        return redirect(route('tasks.index', ["category" => $category]));
    }
}
