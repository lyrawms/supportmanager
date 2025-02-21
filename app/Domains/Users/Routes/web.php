<?php

use App\Domains\Tasks\Controllers\IndexSearchUserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/users/index-search', IndexSearchUserController::class)
    ->name('users.index');


