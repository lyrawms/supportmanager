<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->get('/issues/create', \App\Domains\Issues\Controllers\CreateIssueController::class)
    ->name('issues.create');

