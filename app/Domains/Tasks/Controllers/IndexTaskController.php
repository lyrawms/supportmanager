<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\ViewModels\IndexTasksViewModel;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class IndexTaskController extends  Controller
{
    public function __invoke(IndexTasksViewModel $viewModel): Response
    {
        return Inertia::render($viewModel->component, $viewModel->toArray());
    }


}
