<?php

namespace Tests\Feature;

use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Users\Database\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class TaskUpdateStatusTest extends TestCase
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

        $response = $this->get('/tasks/updateStatus?uuid=' . $task->uuid->toString() . '&status=finished&category=Company');


        $response->assertStatus(302);
        $response->assertSessionHas('toasts', function ($toasts) {
            return isset($toasts['message']) && $toasts['message'] === 'Unauthenticated.' &&
                isset($toasts['type']) && $toasts['type'] === 'error';
        });
    }

    public function test_authenticated_user_can_update_task_status_to_finished()
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)->get('/tasks/updateStatus?uuid=' . $task->uuid->toString() . '&status=finished&category=Company');
        $newTask = Task::latest()->first();

        $response->assertStatus(302);
        $this->assertEquals('Finished', $newTask->status);
        $this->assertNotNull($newTask->finished_at);

    }

    public function test_authenticated_user_cannot_update_task_status_to_to_long_status_name()
    {
        $task = Task::factory()->create();

        $response = $this->actingAs($this->user)->get('/tasks/updateStatus?uuid=' . $task->uuid->toString() . '&status=morethan20charactersarehererightnowf&category=Company');

        $response->assertStatus(302);
        $response->assertInvalid('status');
        $response->assertSessionHas('toasts', function ($toasts) {
            return isset($toasts['message']) &&
                $toasts['message'] === 'The status field must not be greater than 20 characters.' &&
                isset($toasts['type']) &&
                $toasts['type'] === 'error';
        });

    }

}
