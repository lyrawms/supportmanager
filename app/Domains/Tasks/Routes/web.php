<?php

use App\Domains\Tasks\Controllers\CreateTaskController;
use App\Domains\Tasks\Controllers\IndexSearchTypeController;
use App\Domains\Tasks\Controllers\IndexSearchUserController;
use App\Domains\Tasks\Controllers\IndexTaskController;
use App\Domains\Tasks\Controllers\SaveTaskController;
use App\Domains\Tasks\Controllers\ShowTaskController;
use App\Domains\Tasks\Controllers\UpdateTaskTypeController;
use App\Domains\Tasks\Controllers\UpdateTaskUserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->get('/tasks/index', IndexTaskController::class)
    ->name('tasks.index');


Route::middleware(['auth', 'verified'])->get('/tasks/create', CreateTaskController::class)
    ->name('tasks.create');

Route::middleware(['auth', 'verified'])->post('/tasks/create', SaveTaskController::class)
    ->name('tasks.create');

Route::middleware(['auth', 'verified'])->get('/tasks/show', ShowTaskController::class)
    ->name('tasks.show');





Route::middleware(['auth:sanctum'])->get('/types/index-search', IndexSearchTypeController::class)
    ->name('types.index');

Route::middleware(['auth:sanctum'])->get('/users/index-search', IndexSearchUserController::class)
    ->name('users.index');



Route::middleware(['auth:sanctum'])->post('/task/update-type', UpdateTaskTypeController::class)
    ->name('task.update-type');

Route::middleware(['auth:sanctum'])->post('/task/update-user', UpdateTaskUserController::class)
    ->name('task.update-user');









