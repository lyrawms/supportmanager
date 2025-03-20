<?php

namespace App\Domains\Tasks\Services;

use App\Domains\Slack\Services\SlackService;
use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Tasks\Database\Models\Type;
use App\Domains\Tasks\Repositories\TaskRepository;
use App\Domains\Users\Database\Models\User;
use App\Domains\Users\Services\UserService;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    protected TaskRepository $taskRepository;
    protected SlackService $slackService;

    protected UserService $userService;

    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
        $this->slackService = new SlackService();
        $this->userService = new UserService();
    }

    public function getAllTasks($category): LengthAwarePaginator
    {
        if ($category === 'Your') {
            return $this->taskRepository->getAllTasksForUser(auth()->id());
        } elseif ($category === 'Team') {
            return $this->taskRepository->getAllTasksForTeam(auth()->user()->toArray()['current_team_id']);
        } else {
            return $this->taskRepository->getAll();
        }

    }

    public function getTaskWithRelationships(string $uuid): Task
    {

        return $this->taskRepository->getTaskWithRelationships($uuid);
    }

    /**
     * @throws \Exception
     */
    public function updateTaskType(string $taskUuid, string $typeUuid)
    {
        try {
            $task = Task::where('uuid', $taskUuid)->firstOrFail();
            $type = Type::where('uuid', $typeUuid)->firstOrFail();
            $deadline = $this->calcDeadline($type->sla, $task->created_at);
            return $this->taskRepository->updateTaskType($task, $type, $deadline);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateTaskUser(string $taskUuid, string $userUuid): string
    {

        $task = Task::where('uuid', $taskUuid)->firstOrFail();
        $user = User::where('uuid', $userUuid)->firstOrFail();
        $updatedTask =  $this->taskRepository->updateTaskUser($task, $user);
        $this->slackService->sendSlackMessage($this->slackService->toArray("A new user has been assigned to a task", [$this->slackService->prepareSlackData($updatedTask)]));
        return $user->uuid;
    }

    public function saveTask(array $taskData): string
    {
        $creator = User::findOrFail(auth()->id());
        $type = Type::where('uuid', $taskData['type'])->firstOrFail();

        $deadline = $this->calcDeadline($type->sla, Carbon::now());
        $this->slackService->sendSlackMessage('A new task has been created', []);

        return $this->taskRepository->saveTask($taskData, $creator, $deadline, $type);
    }

    public function calcDeadline(int $typeSla, string $created_at): string
    {

        return Carbon::parse($created_at)->addDays($typeSla)->format('Y-m-d H:i:s');
    }

    public function updateTaskStatus(string $taskUuid, string $status)
    {
        $task = Task::where('uuid', $taskUuid)->firstOrFail();

        $statusMethods = [
            'finished' => 'updateTaskStatusFinished',
        ];

        $method = $statusMethods[$status] ?? 'updateTaskStatus';

        return $this->taskRepository->$method($task, $status);
    }
    public function delete(string $taskUuid)
    {
        $task = Task::where('uuid', $taskUuid)->firstOrFail();
        $this->taskRepository->updateTaskStatus($task, 'deleted');
        return $this->taskRepository->delete($task);
    }

    public function checkDeadline(string $message, $date = null)
    {
        if ($date) {
            $tasks = $this->taskRepository->getUnfinishedTasksAfterDate($date);
        } else {
            $tasks = $this->taskRepository->getUnfinishedTasksAfterDeadline();
        }


        if (!empty($tasks)) {
            $data = [];
            foreach ($tasks as $task) {
                $data[] = $this->slackService->prepareSlackData($task);
            }
            $this->slackService->sendSlackMessage($this->slackService->toArray($message, $data));
        }
    }
}
