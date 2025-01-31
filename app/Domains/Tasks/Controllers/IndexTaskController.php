<?php

namespace App\Domains\Tasks\Controllers;

use App\Domains\Tasks\ViewModels\IndexTasksViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexTaskController extends  Controller
{
    public function __invoke(Request $request)
    {
        return app(IndexTasksViewModel::class)->toInertia();
    }


}
