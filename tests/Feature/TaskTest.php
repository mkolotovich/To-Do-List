<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function testCreate(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.create'));
        $response->assertStatus(200);
    }

    public function testShow(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $request = $this->actingAs($user)->post(route('tasks.store'), ['name' => 'new', 'status_id' => 1, 'created_by_id' => $user->id]);
        $request->assertSessionHasNoErrors();
        $task = Task::where('name', 'new')->where('created_by_id', $user->id)->first();
        $response = $this->actingAs($user)->get(route('tasks.show', $task->id));
        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        $user = User::factory()->create();
        $newTask = ['name' => 'new', 'status_id' => 1, 'created_by_id' => $user->id];
        $response = $this->actingAs($user)->post(route('tasks.store'), $newTask);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', $newTask);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
    }

    public function testEdit(): void
    {
        $user = User::factory()->create();
        $request = $this->actingAs($user)->post(route('tasks.store'), ['name' => 'new', 'status_id' => 1, 'created_by_id' => $user->id]);
        $request->assertSessionHasNoErrors();
        $task = Task::first();
        $response = $this->actingAs($user)->get(route('tasks.edit', $task->id));
        $response->assertStatus(200);
    }

    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $updatedTask = ['name' => 'in work', 'status_id' => 1, 'created_by_id' => $user->id];
        $request = $this->actingAs($user)->post(route('tasks.store'), ['name' => 'new', 'status_id' => 1, 'created_by_id' => $user->id]);
        $request->assertSessionHasNoErrors();
        $task = Task::first();
        $response = $this->patch(route('tasks.update', $task), $updatedTask);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', $updatedTask);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $request = $this->actingAs($user)->post(route('tasks.store'), ['name' => 'new', 'status_id' => 1, 'created_by_id' => $user->id]);
        $task = Task::first();
        $response = $this->delete(route('tasks.destroy', $task->id));
        $response->assertStatus(302);
        $removedTask = Task::first();
        $this->assertNull($removedTask);
    }
}
