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
        $this->slackService->sendSlackMessage('A task has been assigned to:', ['U07PEU0NB3M'], route('tasks.show', ['task' => $task->uuid]), $task);
        return $this->taskRepository->updateTaskUser($task, $user);
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

    public function checkDeadline($timestamp)
    {
        $tasks = $this->taskRepository->getTasksWithDeadlineCheck($timestamp);
        if (!empty($tasks)) {
            foreach ($tasks as $task) {
                $assignees = [];
                if ($task->assignee?->slack_id) {
                    $assignees[] = $task->assignee->slack_id;
                }
                $this->slackService->sendSlackMessage(
                    'Task is past its deadline',
                    $assignees,
                    route('tasks.show', ['task' => $task->uuid]),
                    $task);
            }
            return 1;

        }
        return null;

    }
}
