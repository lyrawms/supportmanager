<?php

namespace App\Domains\Tasks\Services;

use App\Domains\Slack\Services\SlackService;
use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Tasks\Database\Models\Type;
use App\Domains\Tasks\Repositories\TaskRepository;
use App\Domains\Users\Database\Models\User;
use App\Domains\Users\Services\UserService;
use Carbon\Carbon;
use Exception;
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
     * @throws Exception
     */
    public function updateTaskType(string $taskUuid, string $typeUuid)
    {
        $task = Task::where('uuid', $taskUuid)->firstOrFail();
        $type = Type::where('uuid', $typeUuid)->firstOrFail();
        $deadline = $this->calcDeadline($type->sla, $task->created_at);

        $updatedTask = $this->taskRepository->updateTaskType($task, $type, $deadline);

        if ($updatedTask->wasChanged('type_id')) {
            return $updatedTask->type_id;
        }
        throw new Exception('Task type could not be updated', 500);
    }

    /**
     * @throws Exception
     */
    public function updateTaskUser(string $taskUuid, string $userUuid): string
    {
        $task = Task::where('uuid', $taskUuid)->firstOrFail();
        $user = User::where('uuid', $userUuid)->firstOrFail();

        $updatedTask = $this->taskRepository->updateTaskUser($task, $user);
        $message = "A TASK HAS BEEN ASSIGNED TO: {$user->name}";
        if ($user->slack_id) {
            $message = "A TASK HAS BEEN ASSIGNED TO YOU:";
        }

        if ($updatedTask->wasChanged('assignee_id')) {
            $this->slackService->sendSlackMessage(
                $this->slackService->toArray(
                    $message,
                    [$this->slackService->prepareSlackData($updatedTask)]
                ));
            return $user->uuid;
        }
        throw new Exception('User could not be assigned to task', 500);
    }

    /**
     * @throws Exception
     */
    public function saveTask(array $taskData): string
    {
        $creator = User::findOrFail(auth()->id());
        $type = Type::where('uuid', $taskData['type'])->firstOrFail();
        $deadline = $this->calcDeadline($type->sla, Carbon::now());

        $newTask = $this->taskRepository->saveTask($taskData, $creator, $deadline, $type);

        if ($newTask instanceof Task) {
            $this->slackService->sendSlackMessage(
                $this->slackService->toArray(
                    "A NEW TASK HAS BEEN CREATED:",
                    [$this->slackService->prepareSlackData($newTask)]
                )
            );
            return $newTask->uuid;
        }
        throw new Exception('Task could not be created', 500);

    }

    public function calcDeadline(int $typeSla, string $created_at): string
    {

        return Carbon::parse($created_at)->addDays($typeSla)->format('Y-m-d H:i:s');
    }

    /**
     * @throws Exception
     */
    public function updateTaskStatus(string $taskUuid, string $status)
    {
        $task = Task::where('uuid', $taskUuid)->firstOrFail();

        $statusMethods = [
            'finished' => 'updateTaskStatusFinished',
        ];
        $method = $statusMethods[$status] ?? 'updateTaskStatus';

        $updatedTask = $this->taskRepository->$method($task, $status);

        if ($updatedTask->wasChanged('status')) {
            return $updatedTask->status;
        }
        throw new Exception('Task status could not be updated', 500);
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


        if (count($tasks) > 0) {
            $data = [];
            foreach ($tasks as $task) {
                $data[] = $this->slackService->prepareSlackData($task);
            }
            $this->slackService->sendSlackMessage($this->slackService->toArray($message, $data));
        }
    }
}
