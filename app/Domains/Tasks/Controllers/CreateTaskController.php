<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\ViewModels\CreateTasksViewModel;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CreateTaskController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __invoke(CreateTasksViewModel $viewModel): Response
    {
        return Inertia::render($viewModel->component, $viewModel->toArray());
    }


}
