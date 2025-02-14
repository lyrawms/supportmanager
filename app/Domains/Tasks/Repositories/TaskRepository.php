<?php

namespace App\Domains\Tasks\Repositories;

use App\Domains\Tasks\Database\Models\Task;
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

    public function updateTaskType(String $taskUuid, Int $typeUuid): Int
    {
        $task = Task::where('uuid', $taskUuid)->firstOrFail();
        $task->type_id = $typeUuid;
        $task->save();
        return $task->type_id;
    }
}
