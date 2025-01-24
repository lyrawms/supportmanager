<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-controller {name} {domain} 
    {--route= : Add a route for the controller}
    {--viewmodel : Create a view model for the controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller for the domain';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');

        $this->call('make:controller', [
            'name' => "App\\Domains\\{$domain}\\Controllers\\{$name}Controller",
            '--invokable' => true,
        ]);

        if ($this->option('route')) {
            // add route to the domains Routes/web.php file (create if it doesn't exist)
            $route = $this->option('route');

            $this->call('app:create-router', ['domain' => $domain]);
            $this->call('app:add-route', [
                'domain' => $domain,
                'route' => $route,
                'controller' => "App\\Domains\\{$domain}\\Controllers\\{$name}Controller",
            ]);
        }

        $file = base_path("app/Domains/{$domain}/Controllers/{$name}Controller.php");
        $content = file_get_contents($file);

        if ($this->option('viewmodel')) {
            $this->call('app:create-viewmodel', [
                'name' => $name,
                'domain' => $domain,
            ]);

            // replace {{ cursor }} with app(class)->toInertia();
            $viewmodel = "\\App\Domains\\{$domain}\ViewModels\\{$name}ViewModel";
            $content = str_replace('{{ cursor }}', "return app({$viewmodel}::class)->toInertia();", $content);

            $this->info("View model created for domain: {$domain}");
        }

        // Replace the cursor with nothing
        $content = str_replace('{{ cursor }}', '', $content);
        file_put_contents($file, $content);

        $this->info("Controller created for domain: {$domain}");

    }
}
