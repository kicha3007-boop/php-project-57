<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private TaskStatus $taskStatus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
    }

    public function testIndex(): void
    {
        $this->get(route('task_statuses.index'))
            ->assertOk()
            ->assertSee($this->taskStatus->name);
    }

    public function testCreate(): void
    {
        $this->get(route('task_statuses.create'))->assertRedirect(route('login'));
        $this->actingAs($this->user)->get(route('task_statuses.create'))->assertOk();
    }

    public function testStore(): void
    {
        $this->actingAs($this->user)
            ->post(route('task_statuses.store'), ['name' => 'новый статус'])
            ->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', ['name' => 'новый статус']);
    }

    public function testStoreValidation(): void
    {
        $this->actingAs($this->user)
            ->post(route('task_statuses.store'), ['name' => $this->taskStatus->name])
            ->assertSessionHasErrors('name');
        $this->actingAs($this->user)
            ->post(route('task_statuses.store'), ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    public function testEdit(): void
    {
        $this->actingAs($this->user)->get(route('task_statuses.edit', $this->taskStatus))->assertOk();
    }

    public function testUpdate(): void
    {
        $this->actingAs($this->user)
            ->patch(route('task_statuses.update', $this->taskStatus), ['name' => 'обновлён'])
            ->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id, 'name' => 'обновлён']);
    }

    public function testDestroy(): void
    {
        $this->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $this->taskStatus))
            ->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseMissing('task_statuses', ['id' => $this->taskStatus->id]);
    }

    public function testDestroyUsedStatus(): void
    {
        Task::factory()->create(['status_id' => $this->taskStatus->id]);

        $this->actingAs($this->user)->delete(route('task_statuses.destroy', $this->taskStatus));

        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id]);
    }

    public function testGuestCannotDestroy(): void
    {
        $this->delete(route('task_statuses.destroy', $this->taskStatus))->assertRedirect(route('login'));

        $this->assertDatabaseHas('task_statuses', ['id' => $this->taskStatus->id]);
    }
}
