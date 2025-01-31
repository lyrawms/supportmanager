<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Issues\ViewModels\CreateIssueViewModel;
use App\Domains\Tasks\ViewModels\CreateTasksViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateTaskController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return app(CreateTasksViewModel::class)->toInertia();
    }
}
