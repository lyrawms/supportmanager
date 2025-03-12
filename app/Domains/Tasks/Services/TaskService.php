<?php

namespace App\Domains\Tasks\Services;

use App\Domains\Tasks\Controllers\ShowTaskController;
use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Tasks\Database\Models\Type;
use App\Domains\Tasks\Repositories\TaskRepository;
use App\Domains\Tasks\ViewModels\ShowTaskViewModel;
use App\Domains\Users\Database\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class TaskService
{
    protected TaskRepository $taskRepository;

    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
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
        return $this->taskRepository->updateTaskUser($task, $user);
    }

    public function saveTask(array $taskData): string
    {
        $creator = User::findOrFail(auth()->id());
        $type = Type::where('uuid', $taskData['type'])->firstOrFail();
        $deadline = $this->calcDeadline($type->sla, Carbon::now());
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
}
