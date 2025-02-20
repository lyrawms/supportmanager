<?php

namespace App\Domains\Tasks\Repositories;

use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Tasks\Database\Models\Type;
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
}
