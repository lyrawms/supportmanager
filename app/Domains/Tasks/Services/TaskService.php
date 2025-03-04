<?php

namespace App\Domains\Tasks\Services;

use App\Domains\Tasks\Controllers\ShowTaskController;
use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Tasks\Repositories\TaskRepository;
use App\Domains\Tasks\ViewModels\ShowTaskViewModel;
use App\Domains\Users\Database\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

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

    public function getTaskWithRelationships(String $uuid): Task
    {
        return $this->taskRepository->getTaskWithRelationships($uuid);
    }

    public function updateTaskType(String $taskUuid, String $typeUuid)
    {
        return $this->taskRepository->updateTaskType($taskUuid, $typeUuid);
    }

    public function updateTaskUser(String $taskUuid, String $userUuid)
    {
        return $this->taskRepository->updateTaskUser($taskUuid, $userUuid);
    }

    public function saveTask(Array $taskData): String
    {
        $creator = User::findOrFail(auth()->id());
        $deadline = Carbon::now()->addDays($taskData['sla'])->format('Y-m-d H:i:s');
        return $this->taskRepository->saveTask($taskData, $creator, $deadline);
    }
}
