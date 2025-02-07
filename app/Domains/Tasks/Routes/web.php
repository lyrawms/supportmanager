<?php

use App\Domains\Tasks\Controllers\CreateTaskController;
use App\Domains\Tasks\Controllers\fetchTypeController;
use App\Domains\Tasks\Controllers\IndexTaskController;
use App\Domains\Tasks\Controllers\ShowTaskController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->get('/tasks/index', IndexTaskController::class)
    ->name('tasks.index');


Route::middleware(['auth', 'verified'])->get('/tasks/create', CreateTaskController::class)
    ->name('tasks.create');

Route::middleware(['auth', 'verified'])->get('/tasks/show', ShowTaskController::class)
    ->name('tasks.show');






