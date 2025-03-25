<?php

namespace App\Domains\Slack\Controllers;

use App\Domains\Slack\Services\SlackService;
use Illuminate\Http\Request;

class HandleSlackRequest
{
    public function __invoke(Request $request, SlackService $slackService)
    {
        $slackService->handleSlackRequest($request);
        return redirect('settings');
    }
}
