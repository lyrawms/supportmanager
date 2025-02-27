<?php

namespace App\Domains\Users\Controllers;

use App\Domains\Users\ViewModels\FetchShortListUserViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class FetchShortListUserController extends Controller
{
    public function __invoke(FetchShortListUserViewModel $viewModel, Request $request): JsonResponse|Response
    {
        return response()->json($viewModel->toArray($request->input('query'), $request->input('currentAssignedUser')));
    }
}
