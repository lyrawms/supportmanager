<?php

namespace App\Domains\Slack\Services;


use App\Domains\Slack\Repositories\SlackRepository;

class SlackService
{

    protected SlackRepository $slackRepository;

    public function __construct()
    {
        $this->slackRepository = new SlackRepository;
    }


    public function createSlackConnection()
    {

        toast_success('Slack connection created');
        return "hoi";
    }

}
