<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Slack\Controllers\HandleSlackRequest;

Route::middleware(['auth', 'verified'])->get('/slack', HandleSlackRequest::class)
    ->name('slack');
