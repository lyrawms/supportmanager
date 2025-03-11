<?php

namespace App\Providers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Domains/Tasks/Database/Migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../Domains/Users/Database/Migrations');
    }

    private function registerMacros()
    {
        RedirectResponse::macro(
            'withSuccess',
            function (string $message) {
                return toast_success($message);
            }
        );
        RedirectResponse::macro(
            'withError',
            function (string $message) {
                return toast_error($message);
            }
        );
    }
}
