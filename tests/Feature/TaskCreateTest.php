<?php

namespace Tests\Feature;

use App\Domains\Slack\Services\SlackService;
use App\Domains\Tasks\Database\Models\Task;
use App\Domains\Tasks\Database\Models\Type;
use App\Domains\Tasks\Repositories\TaskRepository;
use App\Domains\Tasks\Services\TaskService;
use App\Domains\Users\Database\Models\User;
use App\Domains\Users\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JsonException;
use Mockery;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class TaskCreateTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_access_create_task_modal()
    {
        $response = $this->actingAs($this->user)->get('/tasks/create');

        $response->assertInertia(fn(Assert $page) => $page
            ->component('Tasks/Modals/CreateTask', false)
        );
        $response->assertStatus(200);

    }

    public function test_not_authenticated_user_cannot_access_create_task_modal()
    {
        $response = $this->get('/tasks/create');

        $response->assertStatus(302);
        $response->assertSessionHas('toasts', function ($toasts) {
            return isset($toasts['message']) && $toasts['message'] === 'Unauthenticated.' &&
                isset($toasts['type']) && $toasts['type'] === 'error';
        });
    }

    /**
     * @throws JsonException
     */
    public function test_authenticated_user_can_create_task_with_valid_data()
    {
        $type = Type::factory()->create();

        $taskRepository = app(TaskRepository::class);
        $slackService = app(SlackService::class);
        $userService = app(UserService::class);

        $mockTaskService = Mockery::mock(TaskService::class, [
            $taskRepository,
            $slackService,
            $userService
        ])->makePartial();
        $mockTaskService->shouldReceive('callSendSlackMessageMethod')->andReturnNull();

        $this->app->instance(TaskService::class, $mockTaskService);

        $newTask = [
            'title' => 'Very Important',
            'description' => 'Testie Testie',
            'intercomLink' => 'https://intercom.com',
            'type' => $type->uuid->toString(),
        ];

        $response = $this->actingAs($this->user)->post('/tasks/create', $newTask);
        $lastProduct = Task::latest()->with('type')->first();

        $response->assertStatus(302);
        $this->assertEquals($lastProduct->title, $newTask['title']);
        $this->assertEquals($lastProduct->type->uuid, $newTask['type']);
        $response->assertSessionHasNoErrors();
    }

    public function test_not_authenticated_user_cannot_create_task_with_valid_data()
    {
        $type = Type::factory()->create();

        $newTask = [
            'title' => 'Very Important',
            'description' => 'Testie Testie',
            'intercomLink' => 'https://intercom.com',
            'type' => $type->uuid->toString(),
        ];

        $response = $this->post('/tasks/create', $newTask);


        $response->assertStatus(302);
        $response->assertSessionHas('toasts', function ($toasts) {
            return isset($toasts['message']) && $toasts['message'] === 'Unauthenticated.'
                && isset($toasts['type']) && $toasts['type'] === 'error';
        });


    }

    public function test_authenticated_user_cannot_create_task_with_invalid_data()
    {
        $newTask = [
            'title' => '',
            'description' => 'Testie Testie',
            'intercomLink' => 'https://intercom.com',
            'type' => '',
        ];

        $response = $this->actingAs($this->user)->post('/tasks/create', $newTask);

        $response->assertStatus(302);
        $response->assertInvalid(['title', 'type']);
        $response->assertSessionHas('toasts', function ($toasts) {
            return isset($toasts['message']) && isset($toasts['type']) && $toasts['type'] === 'error';
        });
    }

    public function test_authenticated_user_cannot_create_task_with_not_existing_type_uuid()
    {

        $taskRepository = app(TaskRepository::class);
        $slackService = app(SlackService::class);
        $userService = app(UserService::class);

        $mockTaskService = Mockery::mock(TaskService::class, [
            $taskRepository,
            $slackService,
            $userService
        ])->makePartial();
        $mockTaskService->shouldReceive('callSendSlackMessageMethod')->andReturnNull();

        $this->app->instance(TaskService::class, $mockTaskService);

        $newTask = [
            'title' => 'Very important',
            'description' => 'Testie Testie',
            'intercomLink' => 'https://intercom.com',
            'type' => '47475115-56ab-4022-aaaf-bde67971d8ff',
        ];

        $response = $this->actingAs($this->user)->post('/tasks/create', $newTask);



        $response->assertStatus(302);
        $response->assertSessionHas('toasts', function ($toasts) {
            return isset($toasts['message']) && $toasts['message'] === 'No query results for model [App\Domains\Tasks\Database\Models\Type].'
            && isset($toasts['type']) && $toasts['type'] === 'error';
        });
    }
}
