<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-model {name} {domain}
    {--m|migration : Create a new migration file for the model}
    {--f|factory : Create a new factory for the model}
    {--s|seed : Create a new seeder file for the model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model with optional migration, factory, and seeder files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');
        $options = $this->options();

        $this->call('make:model', [
            'name' => "App\\Domains\\{$domain}\\Models\\{$name}",
        ]);

        if ($options['migration']) {
            $this->call('make:migration', [
                'name' => "create_{$name}_table",
                '--create' => Str::snake($name),
                '--path' => "app/Domains/{$domain}/Models/Migrations",
            ]);
        }

        if ($options['factory']) {
            $this->call('make:factory', [
                'name' => "{$name}Factory",
            ]);

            // Move the factory from database/factories to app/Domains/{$domain}/Models/Factories
            Storage::disk('root')->move(
                "database/factories/{$name}Factory.php",
                "app/Domains/{$domain}/Models/Factories/{$name}Factory.php"
            );

            // Replace {{factoryDomainNamespace}} and {{domainNamespacedModel}} in the factory file
            $file = Storage::disk('root')->get("app/Domains/{$domain}/Models/Factories/{$name}Factory.php");
            $file = str_replace('{{ factoryDomainNamespace }}', "App\\Domains\\{$domain}\\Models\\Factories", $file);
            $file = str_replace('{{ domainNamespacedModel }}', "App\\Domains\\{$domain}\\Models\\{$name}", $file);

            // Save the updated file
            Storage::disk('root')->put("app/Domains/{$domain}/Models/Factories/{$name}Factory.php", $file);
        }

        if ($options['seed']) {
            $this->call('make:seeder', [
                'name' => "{$name}Seeder",
            ]);

            // Move the seeder from database/seeders to app/Domains/{$domain}/Models/Seeders
            Storage::disk('root')->move(
                "database/seeders/{$name}Seeder.php",
                "app/Domains/{$domain}/Models/Seeders/{$name}Seeder.php"
            );

            // Replace placeholders in the seeder file (if any)
            $file = Storage::disk('root')->get("app/Domains/{$domain}/Models/Seeders/{$name}Seeder.php");
            $file = str_replace('{{ seederDomainNamespace }}', "App\\Domains\\{$domain}\\Models\\Seeders", $file);

            // Save the updated file
            Storage::disk('root')->put("app/Domains/{$domain}/Models/Seeders/{$name}Seeder.php", $file);
        }
    }
}
