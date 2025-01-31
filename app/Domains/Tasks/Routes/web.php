<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->get('/tasks/index', \App\Domains\Tasks\Controllers\IndexTaskController::class)
    ->name('tasks.index');


Route::middleware(['auth', 'verified'])->get('/tasks/create', \App\Domains\Tasks\Controllers\CreateTaskController::class)
    ->name('tasks.create');



