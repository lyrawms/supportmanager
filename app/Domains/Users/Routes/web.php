<?php

use App\Domains\Users\Controllers\FetchShortListUserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/users/short-list', FetchShortListUserController::class)
    ->name('users.index');
