<?php

namespace App\Domains\Tasks\ViewModels;

use App\Http\ViewModels\ViewModel;

class CreateTypeViewModel extends ViewModel
{
    public string $component = 'Tasks/Modals/CreateType';

    public function toArray(): array
    {
        return [];
    }
}
