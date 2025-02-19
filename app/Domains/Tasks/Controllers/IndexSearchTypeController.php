<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\Services\TypeService;
use App\Domains\Tasks\ViewModels\IndexSearchTypeViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IndexSearchTypeController
{
    public function __invoke(IndexSearchTypeViewModel $viewModel, Request $request): JsonResponse|Response
    {
        return response()->json($viewModel->toArray($request->input('query'), $request->input('currentAssignedType')));
    }

}
