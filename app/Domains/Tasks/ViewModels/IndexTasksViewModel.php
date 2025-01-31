<?php

namespace App\Domains\Tasks\ViewModels;

use App\Http\ViewModels\ViewModel;

class IndexTasksViewModel extends ViewModel
{

    /**
     * Define a component that inertia should render
     * @var string
     */
    public string $component = 'Tasks/IndexTasks';

    public function toArray(): array
    {
        return [];
    }
}
