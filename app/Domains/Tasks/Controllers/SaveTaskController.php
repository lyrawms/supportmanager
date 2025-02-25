<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SaveTaskController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'formData.title' => 'required|string',
            'formData.description' => 'string',
            'formData.deadline' => 'required|date',
            'formData.intercomLink' => 'required|string',
            'formData.sla' => 'required|string',
        ]);

        $taskService = new TaskService();

        return $taskService->saveTask($validatedData);
    }
}
