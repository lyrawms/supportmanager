<?php

use App\Domains\Tasks\Controllers\FetchTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/types/fetch', [FetchTypeController::class]);
