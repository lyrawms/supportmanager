<?php

namespace App\Domains\Settings\ViewModels;

use App\Domains\Tasks\Services\TypeService;
use App\Http\ViewModels\ViewModel;

class SettingsViewModel extends ViewModel
{
    public string $component = 'Settings/Settings';

    protected TypeService $typeService;

    public function __construct()
    {
        $this->typeService = new TypeService;
    }

    public function toArray(): array
    {
        return [
            'types' => $this->typeService->fetchAllTypesSearch()->toArray(),
        ];
    }
}
