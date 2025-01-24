<?php

namespace App\Domains\Issues\Controllers;

use App\Domains\Issues\ViewModels\CreateIssueViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateIssueController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return app(CreateIssueViewModel::class)->toInertia();
    }
}
