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
            ->with('type')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getAllTasksForUser($uuid): LengthAwarePaginator
    {
        return Task::orderBy('deadline', 'asc')
            ->orderBy('created_at', 'desc')
            ->with('type')
            ->where('assignee_id', $uuid)
            ->paginate(10);
    }

    public function getAllTasksForTeam($id): LengthAwarePaginator
    {
//        dit moet nog gemaakt worden
        return Task::orderBy('deadline', 'asc')
            ->orderBy('created_at', 'desc')
            ->with('type')
            ->where('assignee_id', $id)
            ->paginate(10);
    }

    public function getTaskWithRelationships(string $uuid): Task
    {
        return Task::with('creator')
            ->with('type')
            ->with('assignee')
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    public function updateTaskType(Task $task, Type $type, string $deadline)
    {
        $task->sla = $type->sla;
        $task->deadline = $deadline;
        $task->type()->associate($type);
        $task->save();
        return $type;
    }

    public function updateTaskUser(Task $task, User $user)
    {
        $task->assignee()->associate($user);
        $task->save();
        return $user;
    }

    public function saveTask(array $taskData, User $creator, string $deadline, Type $type): string
    {
        $task = new Task();
        $task->title = $taskData['title'];
        $task->description = $taskData['description'];
        $task->intercom_link = $taskData['intercomLink'];
        $task->sla = $type->sla;
        $task->deadline = $deadline;
        $task->type()->associate($type);
        $task->creator()->associate($creator);
        $task->save();
        return $task->uuid;
    }
}
