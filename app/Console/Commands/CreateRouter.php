<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateRouter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-router {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $domain = $this->argument('domain');

        $file = base_path("app/Domains/{$domain}/Routes/web.php");

        if (! file_exists($file)) {
            $this->info("Creating new Routes file for domain: {$domain}");

            // Create file from stub
            $stub = file_get_contents(base_path('stubs/router-web.stub'));

            // Create the file
            $file = Storage::disk('root')->put("app/Domains/{$domain}/Routes/web.php", $stub);

            if ($file) {
                $this->info("Routes file created for domain: {$domain}");

                // Add the route to the main routes file
                $mainRoutesFile = base_path('routes/web.php');
                $route = PHP_EOL."// Include the routes file for the {$domain} domain".PHP_EOL;
                $route .= "require __DIR__.'/../app/Domains/{$domain}/Routes/web.php';";

                file_put_contents($mainRoutesFile, $route, FILE_APPEND);

            } else {
                $this->error("Failed to create Routes file for domain: {$domain}");
            }

        } else {
            $this->info("Routes file already exists for domain: {$domain}");
        }
    }
}
