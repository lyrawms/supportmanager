<?php

namespace Tests\Feature;

use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Users\Database\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class TaskUpdateStatus extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

    }

    public function test_not_authenticated_user_cannot_update_task_status()
    {
        $task = Task::factory()->create();

        $response = $this->post('/tasks/create', [
            'uuid' => $task->uuid,
            'status' => 'finished',
        ]);

        dd($response);

    }

}
