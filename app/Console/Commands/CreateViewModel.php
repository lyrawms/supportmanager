<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateViewModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-viewmodel {name} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view model for the domain';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');

        $this->createViewModel($name, $domain);
        $this->createComponent($name, $domain);
    }

    /**
     * Create the ViewModel file from the stub.
     */
    protected function createViewModel(string $name, string $domain): void
    {
        $namespace = "App\\Domains\\{$domain}\\ViewModels";
        $stubPath = base_path('stubs/viewmodel.stub');
        $destinationPath = "app/Domains/{$domain}/ViewModels/{$name}ViewModel.php";

        $stubContent = $this->populateStub($stubPath, [
            '{{ viewmodel }}' => $name.'ViewModel',
            '{{ namespace }}' => $namespace,
            '{{ component }}' => $name,
            '{{ domain }}' => $domain,
        ]);

        if ($this->writeFile($destinationPath, $stubContent)) {
            $this->info("View model created for domain: {$domain}");
        } else {
            $this->error("Failed to create view model for domain: {$domain}");
        }
    }

    /**
     * Create the Vue component file from the stub.
     */
    protected function createComponent(string $name, string $domain): void
    {
        $stubPath = base_path('stubs/component.stub');
        $destinationPath = "app/Domains/{$domain}/Views/Pages/{$name}.vue";

        // Remove words like 'create', 'edit', 'show' and 'index' from the title
        $title = str_replace(['Create', 'Edit', 'Show', 'Index'], '', $name);

        $stubContent = $this->populateStub($stubPath, [
            '{{ component }}' => $name,
            '{{ title }}' => $title,
        ]);

        if ($this->writeFile($destinationPath, $stubContent)) {
            $this->info("Component created for view model: {$name}");
        } else {
            $this->error("Failed to create component for view model: {$name}");
        }
    }

    /**
     * Populate stub content with placeholders replaced.
     */
    protected function populateStub(string $stubPath, array $replacements): string
    {
        $stubContent = file_get_contents($stubPath);

        foreach ($replacements as $placeholder => $value) {
            $stubContent = str_replace($placeholder, $value, $stubContent);
        }

        return $stubContent;
    }

    /**
     * Write content to a file.
     */
    protected function writeFile(string $filePath, string $content): bool
    {
        return Storage::disk('root')->put($filePath, $content);
    }
}
