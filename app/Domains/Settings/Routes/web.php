<?php

use App\Domains\Settings\Controllers\SettingsController;
use App\Domains\Slack\Controllers\CreateSlackConnectionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->get('/settings', SettingsController::class)
    ->name('settings');

Route::middleware(['auth', 'verified'])->get('/settings/slack', CreateSlackConnectionController::class)
    ->name('settings.slack');
