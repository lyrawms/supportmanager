<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\ViewModels\ShowTaskViewModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowTaskController
{
    public function __invoke(Request $request, ShowTaskViewModel $viewModel): Response
    {
        return Inertia::render($viewModel->component, $viewModel->toArray($request->uuid));
    }
}
