<?php

namespace App\Domains\Slack\Services;


use App\Domains\Tasks\Database\Models\Task;
use App\Notifications\SlackNotification;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;


class SlackService
{
    private $slackWebhookUrl;

    public function __construct()
    {
        $this->slackWebhookUrl = env('SLACK_WEBHOOK_URL');
    }

    public function sendSlackMessage(array $data): void
    {

        Notification::route('slack', $this->slackWebhookUrl)
            ->notify(new SlackNotification($data));

    }

    public function toArray($message, $data)
    {
        return [
            'message' => $message,
            'data' => $data,
        ];

    }

    public function prepareSlackData(Task $task): array
    {
        return [
            'assignee' => $task->assignee !== null && $task->assignee->slack_id !== null ? $this->getTaggedUsersString([$task->assignee->slack_id]) : null ,
            'url' => route('tasks.show', ['task' => $task->uuid]),
            'task' => $task
        ];
    }

    //this function receives an array of slack_id and returns 1 string with each slack_id in its own tag
    public function getTaggedUsersString(array $assignees): string
    {
        $taggedUsersString = '';
        foreach ($assignees as $userId) {
            $taggedUsersString .= ' <@' . $userId . '>';
        }
        return $taggedUsersString;
    }


}
