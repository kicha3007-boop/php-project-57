<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Label $label;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
    }

    public function testIndex(): void
    {
        $this->get(route('labels.index'))
            ->assertOk()
            ->assertSee($this->label->name);
    }

    public function testCreate(): void
    {
        $this->get(route('labels.create'))->assertRedirect(route('login'));
        $this->actingAs($this->user)->get(route('labels.create'))->assertOk();
    }

    public function testStore(): void
    {
        $data = ['name' => 'bug', 'description' => 'Something is broken'];

        $this->actingAs($this->user)
            ->post(route('labels.store'), $data)
            ->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $data);
    }

    public function testStoreValidation(): void
    {
        $this->actingAs($this->user)
            ->post(route('labels.store'), ['name' => $this->label->name])
            ->assertSessionHasErrors('name');
    }

    public function testEdit(): void
    {
        $this->actingAs($this->user)->get(route('labels.edit', $this->label))->assertOk();
    }

    public function testUpdate(): void
    {
        $this->actingAs($this->user)
            ->patch(route('labels.update', $this->label), ['name' => 'feature', 'description' => ''])
            ->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', ['id' => $this->label->id, 'name' => 'feature']);
    }

    public function testDestroy(): void
    {
        $this->actingAs($this->user)
            ->delete(route('labels.destroy', $this->label))
            ->assertRedirect(route('labels.index'));

        $this->assertDatabaseMissing('labels', ['id' => $this->label->id]);
    }

    public function testDestroyUsedLabel(): void
    {
        Task::factory()->create()->labels()->attach($this->label);

        $this->actingAs($this->user)->delete(route('labels.destroy', $this->label));

        $this->assertDatabaseHas('labels', ['id' => $this->label->id]);
    }
}
