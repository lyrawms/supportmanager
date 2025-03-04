<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\ViewModels\IndexTasksViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IndexTaskController extends  Controller
{
    public function __invoke(IndexTasksViewModel $viewModel, Request $request): Response
    {
        return Inertia::render($viewModel->component, $viewModel->toArray($request->input('category')));
    }


}
