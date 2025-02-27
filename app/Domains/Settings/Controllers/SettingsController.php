<?php

namespace App\Domains\Settings\Controllers;

use App\Domains\Settings\ViewModels\SettingsViewModel;
use App\Domains\Tasks\ViewModels\ShowTaskViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function __invoke(Request $request, SettingsViewModel $viewModel): Response
    {
        return Inertia::render($viewModel->component, $viewModel->toArray($request->input('query')));
    }
}
