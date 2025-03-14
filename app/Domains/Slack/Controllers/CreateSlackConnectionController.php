<?php

namespace App\Domains\Slack\Controllers;

use App\Domains\Settings\ViewModels\CreateSlackConnectionViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CreateSlackConnectionController extends Controller
{

    public function __invoke(CreateSlackConnectionViewModel $viewModel, Request $request)
    {
        return Inertia::render($viewModel->component, $viewModel->toArray());
    }

}
