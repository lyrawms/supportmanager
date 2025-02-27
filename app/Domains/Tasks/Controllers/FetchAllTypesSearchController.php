<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\ViewModels\FetchAllTypesSearchViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FetchAllTypesSearchController extends Controller
{
    public function __invoke(Request $request ,FetchAllTypesSearchViewModel $viewModel)
    {
        return response()->json($viewModel->toArray($request->input('query')));
    }
}
