<?php

namespace App\Domains\Tasks\Repositories;

use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Tasks\Database\Models\Type;
use App\Domains\Users\Database\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository
{
    public function getAll(): LengthAwarePaginator
    {
        return Task::orderBy('deadline', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getTaskWithRelationships(String $uuid): Task
    {
        return Task::with('creator')
            ->with('type')
            ->with('assignee')
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    public function updateTaskType(String $taskUuid, String $typeUuid)
    {
        $task = Task::where('uuid', $taskUuid)->firstOrFail();
        $type = Type::where('uuid', $typeUuid)->firstOrFail();
        $task->type()->associate($type);
        $task->save();
        return $type;
    }

    public function updateTaskUser(String $taskUuid, String $userUuid)
    {
        $task = Task::where('uuid', $taskUuid)->firstOrFail();
        $user = User::where('uuid', $userUuid)->firstOrFail();
        $task->assignee()->associate($user);
        $task->save();
        return $user;
    }

    public function saveTask(Array $taskData)
    {
        $task = new Task();
        $task->title = $taskData['title'];
        $task->description = $taskData['description'];
        $task->deadline = $taskData['deadline'];
        $task->intercom_link = $taskData['intercomLink'];
        $task->sla = $taskData['sla'];
        $task->reporter = $taskData['reporter'];
        return $task;
    }
}
