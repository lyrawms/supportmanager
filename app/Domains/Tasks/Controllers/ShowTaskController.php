<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Models\Task;
use App\Domains\Tasks\ViewModels\ShowTaskViewModel;
use Inertia\Inertia;
use Inertia\Response;

class ShowTaskController
{
    public function __invoke(Task $task, ShowTaskViewModel $viewModel): Response
    {
        return Inertia::render($viewModel->component, $viewModel->toArray($task));
    }
}
