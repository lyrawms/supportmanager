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

    public function __construct(TaskRepository $taskRepository, SlackService $slackService, UserService $userService)
    {

        $this->taskRepository = $taskRepository;
        $this->slackService = $slackService;
        $this->userService = $userService;
    }

    public function getAllTasks($category): LengthAwarePaginator
    {
        // checks the category and fetches the corresponding tasks
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
        // fetches the task and type
        $task = Task::where('uuid', $taskUuid)->firstOrFail();
        $type = Type::where('uuid', $typeUuid)->firstOrFail();

        // calculates the deadline
        $deadline = $this->calcDeadline($type->sla, $task->created_at);

        // updates the task type, and deadline
        $updatedTask = $this->taskRepository->updateTaskType($task, $type, $deadline);

        // if the task_id has not changed it sends a exception
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
        // fetches the task and user
        $task = Task::where('uuid', $taskUuid)->firstOrFail();
        $user = User::where('uuid', $userUuid)->firstOrFail();

        // updates the task user
        $updatedTask = $this->taskRepository->updateTaskUser($task, $user);

        //setting the default message
        $message = "A TASK HAS BEEN ASSIGNED TO: {$user->name}";

        // if the user has a slack_id, it creates a new slack message
        if ($user->slack_id) {
            $message = "A TASK HAS BEEN ASSIGNED TO YOU:";
        }

        // if the task has indeed been updated, it sends a slack message, if not a exceotion is thrown
        if ($updatedTask->wasChanged('assignee_id')) {
            $this->callSendSlackMessageMethod($updatedTask, $message);
            return $user->uuid;
        }
        throw new Exception('User could not be assigned to task', 500);
    }

    /**
     * @throws Exception
     */
    public function saveTask(array $taskData): string
    {
        // fetches the creator and type
        $creator = User::findOrFail(auth()->id());
        $type = Type::where('uuid', $taskData['type'])->firstOrFail();

        // calculates the deadline
        $deadline = $this->calcDeadline($type->sla, Carbon::now());

        // saves the task to the database
        $newTask = $this->taskRepository->saveTask($taskData, $creator, $deadline, $type);

        // if the task has been created and is a correct instance of Task it sends a slack message, otherwise a exception is thrown
        if ($newTask instanceof Task) {
            $this->callSendSlackMessageMethod($newTask, 'A NEW TASK HAS BEEN CREATED:');
            return $newTask->uuid;
        }
        throw new Exception('Task could not be created', 500);

    }

    public function calcDeadline(int $typeSla, string $created_at): string
    {
        // adds the typeSla days to the created_at date and creates the deadline
        return Carbon::parse($created_at)->addDays($typeSla)->format('Y-m-d H:i:s');
    }

    /**
     * @throws Exception
     */
    public function updateTaskStatus(string $taskUuid, string $status)
    {
        $availableStatuses = [
            'Finished',
            'Active',
            'Open',
        ];
        if (!in_array($status, $availableStatuses)) {
            throw new Exception('This status is not allowed', 500);
        }
        // fetches the task
        $task = Task::where('uuid', $taskUuid)->firstOrFail();

        // associates the status with the corresponding method
        $statusMethods = [
            'Finished' => 'updateTaskStatusFinished',
        ];

        // if the status is not in the array, it uses the default method
        $method = $statusMethods[$status] ?? 'updateTaskStatus';

        // updates the task status
        $updatedTask = $this->taskRepository->$method($task, $status);

        // if the status has been updated, it returns the new status, otherwise a exception is thrown
        if ($updatedTask->wasChanged('status')) {
            return $updatedTask->status;
        }
        throw new Exception('Task status could not be updated', 500);
    }

    public function delete(string $taskUuid)
    {
        // fetches the task
        $task = Task::where('uuid', $taskUuid)->firstOrFail();

        // change the status to deleted
        $this->taskRepository->updateTaskStatus($task, 'Deleted');

        // softdeletes the task
        return $this->taskRepository->delete($task);
    }

    public function checkDeadline(string $message, $date = null)
    {
        // checks is the date attribute is given, and executes the corresponding fetch method
        if ($date) {
            $tasks = $this->taskRepository->getUnfinishedTasksAfterDate($date);
        } else {
            $tasks = $this->taskRepository->getUnfinishedTasksAfterDeadline();
        }

        // if there are tasks, it sends a slack message
        if (count($tasks) > 0) {
            $data = [];
            foreach ($tasks as $task) {
                $data[] = $this->slackService->prepareSlackData($task);
            }
            $this->slackService->sendSlackMessage($this->slackService->toArray($message, $data));
        }
    }

    /**
     * @param Task $task
     * @param string $message
     * @return void
     */
    public function callSendSlackMessageMethod(Task $task, string $message): void
    {
        $this->slackService->sendSlackMessage(
            $this->slackService->toArray(
                $message,
                [$this->slackService->prepareSlackData($task)]
            )
        );
    }
}
