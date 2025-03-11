<?php

namespace App\Domains\Settings\ViewModels;

use App\Domains\Slack\Services\SlackService;
use App\Domains\Tasks\Services\TaskService;
use App\Http\ViewModels\ViewModel;

class CreateSlackConnectionViewModel extends ViewModel
{
    public string $component = 'Settings/Settings';

    protected SlackService $slackService;

    public function __construct()
    {
        $this->slackService = new SlackService();
    }

    public function toArray(): array
    {
        return [
            'slack' => $this->slackService->createSlackConnection()->toArray(),
        ];
    }

}
