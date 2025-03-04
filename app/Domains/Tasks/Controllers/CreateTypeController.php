<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\ViewModels\CreateTypeViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class CreateTypeController extends Controller
{
    public function __invoke(CreateTypeViewModel $viewModel): Response
    {
        return Inertia::render($viewModel->component, $viewModel->toArray());
    }
}
