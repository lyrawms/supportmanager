<?php

namespace App\Domains\Tasks\ViewModels;

use App\Http\ViewModels\ViewModel;

class CreateTasksViewModel extends ViewModel
{
    /**
     * Define a component that inertia should render
     * @var string
     */
    public string $component = 'Tasks/Modals/CreateTask';

    /**
     * Define the props that should be passed to the component
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [];
    }
}
