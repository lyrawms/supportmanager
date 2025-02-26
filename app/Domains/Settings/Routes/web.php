<?php

use App\Domains\Settings\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->get('/settings', SettingsController::class)
    ->name('settings');
