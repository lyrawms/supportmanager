<?php

namespace App\Domains\Slack\Services;


use App\Domains\Tasks\Database\Models\Task;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;


class SlackService
{
    private $slackWebhookUrl;

    public function __construct()
    {
        $this->slackWebhookUrl = env('SLACK_WEBHOOK_URL');
    }

    public function sendSlackMessage(
        string  $message,
        array  $taggedUsers = [],
        string $url = '',
        ?Task   $task = null
    ): void
    {
        Notification::route('slack', $this->slackWebhookUrl)
            ->notify(new SlackNotification($this->toArray($message, $taggedUsers, $url, $task)));

    }

    public function toArray($message, $taggedUsers, $url, ?Task $task = null)
    {
        return [
            'message' => $message,
            'taggedUsers' => $this->getTaggedUsersString($taggedUsers),
            'taskUrl' => $url,
            'task' => $task
        ];
    }

    protected function getTaggedUsersString($taggedUsers): string
    {
        $taggedUsersString = '';
        if (!empty($taggedUsers)) {
            foreach ($taggedUsers as $userId) {
                $taggedUsersString .= '<@' . $userId . '>';
            }
        }
        return $taggedUsersString;
    }


}
