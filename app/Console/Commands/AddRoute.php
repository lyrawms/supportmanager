<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-route {domain} {route} {controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a route to the domain Routes/web.php file';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $domain = $this->argument('domain');
        $route = $this->argument('route');
        $controller = $this->argument('controller');

        $file = base_path("app/Domains/{$domain}/Routes/web.php");

        if (! file_exists($file)) {
            $this->error("Routes file does not exist for domain: {$domain}");
            $this->info("Run 'php artisan app:create-router {$domain}' to create it.");

            return;
        }

        // Format the route to add
        $routeCode = PHP_EOL."Route::middleware(['auth', 'verified'])->get('{$route}', {$controller}::class);".PHP_EOL;

        // Append the route to the file
        file_put_contents($file, $routeCode, FILE_APPEND);

        $this->info("Route '{$route}' added to {$file}");
    }
}
