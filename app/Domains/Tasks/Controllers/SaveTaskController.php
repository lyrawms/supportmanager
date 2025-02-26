<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Tasks\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SaveTaskController extends Controller
{
    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'string',
            'intercomLink' => 'nullable|url',
            'sla' => 'required|integer',
        ]);

        $taskService = new TaskService();

        return response()->json([
            'uuid' => $taskService->saveTask($validatedData),
        ]);
    }
}
