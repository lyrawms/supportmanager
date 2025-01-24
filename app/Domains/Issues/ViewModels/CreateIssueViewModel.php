<?php

namespace App\Domains\Issues\ViewModels;

use App\Http\ViewModels\ViewModel;

class CreateIssueViewModel extends ViewModel
{
    /**
     * Define a component that inertia should render
     * @var string
     */
    public string $component = 'Issues/CreateIssue';

    /**
     * Define the props that should be passed to the component
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [];
    }
}