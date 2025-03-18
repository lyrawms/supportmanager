<?php

namespace App\Domains\Slack\Services;


use App\Domains\Tasks\Database\Models\Task;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;


class SlackService
{
    public function sendSlackMessage(string $message, array $taggedUsers, string $taskUrl, Task $task): void
    {
        Notification::route('slack', env('SLACK_WEBHOOK_URL'))
            ->notify(new SlackNotification($this->toArray($message, $taggedUsers, $taskUrl, $task)));

    }

    public function toArray($message, $taggedUsers, $taskUrl, $task)
    {

        return [
            'message' => $message,
            'taggedUsers' => $this->getTaggedUsersString($taggedUsers),
            'taskUrl' => $taskUrl,
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
