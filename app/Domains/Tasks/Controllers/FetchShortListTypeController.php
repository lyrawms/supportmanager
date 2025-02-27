<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\ViewModels\FetchShortListTypeViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class FetchShortListTypeController extends controller
{
    public function __invoke(FetchShortListTypeViewModel $viewModel, Request $request): JsonResponse|Response
    {
        return response()->json($viewModel->toArray($request->input('query'), $request->input('currentAssignedType')));
    }

}
