<?php

namespace Tests\Feature;

use App\Domains\Users\Database\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TaskCreateTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     */

    public function test_user_can_acces_create_task_modal()
    {
        $this->actingAs($this->user);
        $response = $this->get('/tasks/create');

        $response->assertStatus(200);
    }

    public function test_user_can_create_task_with_valid_data()
    {
        $this->actingAs($this->user);
        $response = $this->post('/tasks/create', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'intercomLink' => 'https://intercom.com',
        ]);
        $response->dump();
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'intercom_link' => 'https://intercom.com',
            'sla' => 5,
        ]);
    }
}
