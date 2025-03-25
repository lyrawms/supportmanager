<?php

namespace App\Domains\Slack\Services;


use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Users\Database\Models\User;
use App\Domains\Users\Repositories\UserRepository;
use App\Notifications\SlackNotification;
use Exception;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;


class SlackService
{
    private  $slackWebhookUrl;
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->slackWebhookUrl = env('SLACK_WEBHOOK_URL');
        $this->userRepository = new UserRepository();
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
            'assignee' => $task->assignee !== null && $task->assignee->slack_id !== null ? $this->getTaggedUsersString([$task->assignee->slack_id]) : null,
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

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function handleSlackRequest($request)
    {
        $code = $request->query('code');
        $response = Http::asMultipart()->post('https://slack.com/api/oauth.v2.access', [
            'code' => $request->code,
            'client_id' => env('SLACK_CLIENT_ID'),
            'client_secret' => env('SLACK_CLIENT_SECRET'),
        ]);
        if ($response->json()['ok']) {
            $user = User::findOrFail(auth()->id());
            return $this->userRepository->updateSlackId($user, $response->json()['authed_user']['id']);
        } else {
            throw new Exception($response->json()['error']);
        }


    }


}
