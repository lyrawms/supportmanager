<?php

use App\Domains\Tasks\Controllers\CreateTaskController;
use App\Domains\Tasks\Controllers\IndexTaskController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->get('/tasks/index', IndexTaskController::class)
    ->name('tasks.index');


Route::middleware(['auth', 'verified'])->get('/tasks/create', CreateTaskController::class)
    ->name('tasks.create');



