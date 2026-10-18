<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->task = Task::factory()->create(['created_by_id' => $this->user->id]);
    }

    public function testIndex(): void
    {
        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertSee($this->task->name);
    }

    public function testIndexFilter(): void
    {
        $other = Task::factory()->create();

        $this->get(route('tasks.index', ['filter' => ['status_id' => $this->task->status_id]]))
            ->assertOk()
            ->assertSee($this->task->name)
            ->assertDontSee($other->name);
    }

    public function testShow(): void
    {
        $this->get(route('tasks.show', $this->task))
            ->assertOk()
            ->assertSee($this->task->name)
            ->assertSee($this->task->status->name);
    }

    public function testCreate(): void
    {
        $this->get(route('tasks.create'))->assertRedirect(route('login'));
        $this->actingAs($this->user)->get(route('tasks.create'))->assertOk();
    }

    public function testStore(): void
    {
        $status = TaskStatus::factory()->create();
        $label = Label::factory()->create();
        $data = [
            'name' => 'Новая задача',
            'description' => 'Описание',
            'status_id' => $status->id,
            'assigned_to_id' => $this->user->id,
        ];

        $this->actingAs($this->user)
            ->post(route('tasks.store'), [...$data, 'labels' => [$label->id]])
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [...$data, 'created_by_id' => $this->user->id]);
        $task = Task::where('name', 'Новая задача')->firstOrFail();
        $this->assertTrue($task->labels->contains($label));
    }

    public function testStoreValidation(): void
    {
        $this->actingAs($this->user)
            ->post(route('tasks.store'), ['name' => ''])
            ->assertSessionHasErrors(['name', 'status_id']);
    }

    public function testEdit(): void
    {
        $this->actingAs($this->user)->get(route('tasks.edit', $this->task))->assertOk();
    }

    public function testUpdate(): void
    {
        $data = ['name' => 'Обновлённая', 'status_id' => $this->task->status_id];

        $this->actingAs($this->user)
            ->patch(route('tasks.update', $this->task), $data)
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', ['id' => $this->task->id, 'name' => 'Обновлённая']);
    }

    public function testDestroy(): void
    {
        $this->actingAs($this->user)
            ->delete(route('tasks.destroy', $this->task))
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
    }

    public function testOnlyCreatorCanDestroy(): void
    {
        $stranger = User::factory()->create();

        $this->actingAs($stranger)->delete(route('tasks.destroy', $this->task))->assertForbidden();

        $this->assertDatabaseHas('tasks', ['id' => $this->task->id]);
    }
}
