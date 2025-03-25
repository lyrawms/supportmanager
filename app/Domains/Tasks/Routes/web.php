<?php

use App\Domains\Tasks\Controllers\CreateTaskController;
use App\Domains\Tasks\Controllers\CreateTypeController;
use App\Domains\Tasks\Controllers\DeleteTaskController;
use App\Domains\Tasks\Controllers\FetchAllTypesSearchController;
use App\Domains\Tasks\Controllers\FetchShortListTypeController;
use App\Domains\Tasks\Controllers\IndexTaskController;
use App\Domains\Tasks\Controllers\SaveTaskController;
use App\Domains\Tasks\Controllers\SaveTypeController;
use App\Domains\Tasks\Controllers\ShowTaskController;
use App\Domains\Tasks\Controllers\updateTaskStatusController;
use App\Domains\Tasks\Controllers\UpdateTaskTypeController;
use App\Domains\Tasks\Controllers\UpdateTaskUserController;
use App\Domains\Users\Controllers\FetchShortListUserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])->get('/tasks/index', IndexTaskController::class)
    ->name('tasks.index');


Route::middleware(['auth', 'verified'])->get('/tasks/create', CreateTaskController::class)
    ->name('tasks.create');

Route::middleware(['auth', 'verified'])->get('/tasks/delete', DeleteTaskController::class)
    ->name('tasks.delete');

Route::middleware(['auth', 'verified'])->post('/tasks/create', SaveTaskController::class)
    ->name('tasks.create');

Route::middleware(['auth', 'verified'])->get('/tasks/updateStatus', updateTaskStatusController::class)
    ->name('tasks.updateStatus');


Route::middleware(['auth', 'verified'])->get('/tasks/show', ShowTaskController::class)
    ->name('tasks.show');

Route::middleware(['auth', 'verified'])->get('/types/create', CreateTypeController::class)
    ->name('types.create');

Route::middleware(['auth', 'verified'])->post('/types/create', SaveTypeController::class)
    ->name('types.create');






Route::middleware(['auth', 'verified'])->get('/types/short-list', FetchShortListTypeController::class)
    ->name('types.small-list');

Route::middleware(['auth', 'verified'])->get('/types/index-search', FetchAllTypesSearchController::class)
    ->name('types.index-search');


Route::middleware(['auth', 'verified'])->get('/users/short-list', FetchShortListUserController::class)
    ->name('users.index');



Route::middleware(['auth', 'verified'])->post('/task/update-type', UpdateTaskTypeController::class)
    ->name('task.update-type');

Route::middleware(['auth:sanctum'])->post('/task/update-user', UpdateTaskUserController::class)
    ->name('task.update-user');









