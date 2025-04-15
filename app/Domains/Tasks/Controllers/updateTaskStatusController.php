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

        $validatedData = $request->validate([
            'uuid' => 'required|uuid',
            'status' => 'required|string|max:20',
        ]);
        $category = $request->category;

        $taskService->updateTaskStatus($validatedData['uuid'], $validatedData['status']);
        return redirect(route('tasks.index', ["category" => $category]));
    }
}
