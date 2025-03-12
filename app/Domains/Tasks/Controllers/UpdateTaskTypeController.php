<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class UpdateTaskTypeController  extends Controller
{
    public function __invoke(Request $request, TaskService $taskService)
    {
        $taskUuid = $request->input('taskUuid');
        $typeUuid = $request->input('typeUuid');

        try {
            $taskService->updateTaskType($taskUuid, $typeUuid);
            toast_success('Task type updated');
            return Inertia::render('Tasks/Modal/Show');
        } catch (Exception $e) {
            toast_error($e->getMessage());
            return Inertia::render('Tasks/Modals/Show', ['errors' => [$e->getMessage()]])->toResponse($request)->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
