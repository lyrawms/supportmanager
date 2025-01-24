<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class ClearAlgoliaIndexes extends Command
{
    protected $signature = 'algolia:clear';

    protected $description = 'Clear Algolia indices';

    public function handle(): void
    {
        // Find all models in the app/Domains/*/Models directories
        $domainsPath = app_path('Domains');
        $directories = $this->getModelDirectories($domainsPath);

        // Loop through each domain directory and handle models
        foreach ($directories as $directory) {
            $models = $this->getModelFiles($directory);

            foreach ($models as $model) {
                $modelName = pathinfo($model, PATHINFO_FILENAME);

                // Build the fully qualified class name
                $modelClass = $this->getModelClassName($directory, $modelName);

                // Check if the class exists and if it uses the Searchable trait
                if (class_exists($modelClass) && in_array(Searchable::class, class_uses($modelClass))) {
                    // Remove the model from Algolia index
                    $modelClass::query()->unsearchable();
                    $this->info("Cleared Algolia index for: $modelClass");
                }
            }
        }

        $this->info('Algolia indices cleared.');
    }

    /**
     * Recursively get all subdirectories under app/Domains//Models
     *
     * @param  string  $path
     * @return array
     */
    private function getModelDirectories($path)
    {
        $directories = [];
        $subDirs = scandir($path);

        foreach ($subDirs as $subDir) {
            $fullPath = $path.DIRECTORY_SEPARATOR.$subDir;

            // Only consider directories that aren't '.' or '..' and contain a Models folder
            if (is_dir($fullPath) && ! in_array($subDir, ['.', '..'])) {
                $modelsPath = $fullPath.DIRECTORY_SEPARATOR.'Models';
                if (is_dir($modelsPath)) {
                    $directories[] = $modelsPath;
                }
            }
        }

        return $directories;
    }

    /**
     * Get all PHP files in a given Models directory
     *
     * @param  string  $directory
     * @return array
     */
    private function getModelFiles($directory)
    {
        $files = scandir($directory);

        return array_filter($files, function ($file) use ($directory) {
            return is_file($directory.DIRECTORY_SEPARATOR.$file) && Str::endsWith($file, '.php');
        });
    }

    /**
     * Build the fully qualified class name based on directory and model file name
     *
     * @param  string  $directory
     * @param  string  $modelName
     * @return string
     */
    private function getModelClassName($directory, $modelName)
    {
        $namespace = 'App\\Domains\\'.basename(dirname($directory)).'\\Models'; // Extract domain name dynamically

        return $namespace.'\\'.$modelName;
    }
}
