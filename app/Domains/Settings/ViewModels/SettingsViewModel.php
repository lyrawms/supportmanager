<?php

namespace App\Domains\Settings\ViewModels;

use App\Domains\Settings\Services\SettingsService;
use App\Domains\Tasks\Services\TaskService;
use App\Http\ViewModels\ViewModel;

class SettingsViewModel extends ViewModel
{
    public string $component = 'Settings/Settings';

    protected SettingsService $settingsService;

    public function __construct()
    {
        $this->settingsService = new SettingsService;
    }

    public function toArray(): array
    {
        return [
//            'tasks' => $this->settingsService->getAllTasks()->toArray(),
        ];
    }
}
