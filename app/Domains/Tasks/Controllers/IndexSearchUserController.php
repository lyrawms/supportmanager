<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Users\ViewModels\IndexSearchUserViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class IndexSearchUserController extends Controller
{
    public function __invoke(IndexSearchUserViewModel $viewModel, Request $request): JsonResponse|Response
    {
        return response()->json($viewModel->toArray($request->input('query'), $request->input('currentAssignedUser')));
    }
}
