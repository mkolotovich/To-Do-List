<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;

class StatusTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function testCreate(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('task_statuses.create'));
        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        $newStatus = 'in work';
        $response = $this->post(route('task_statuses.store'), ['name' => $newStatus]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertDatabaseHas('task_statuses', ['name' => $newStatus,]);
    }

    public function testIndex(): void
    {
        $this->seed();
        $response = $this->get(route('task_statuses.index'));
        $response->assertStatus(200);
        $status = TaskStatus::where('name', 'новый')->first();
        $this->assertEquals('новый', $status->name);
    }

    public function testEdit(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $status = TaskStatus::first();
        $response = $this->actingAs($user)->get(route('task_statuses.edit', $status->id));
        $response->assertStatus(200);
    }

    public function testUpdate(): void
    {
        $updatedStatus = 'in work';
        $this->seed();
        $status = TaskStatus::first();
        $response = $this->patch(route('task_statuses.update', $status), ['name' => $updatedStatus]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $this->assertDatabaseHas('task_statuses', ['name' => $updatedStatus,]);
    }

    public function testDestroy(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $status = TaskStatus::first();
        $response = $this->actingAs($user)->delete(route('task_statuses.destroy', $status->id));
        $response->assertStatus(302);
        $removedStatus = TaskStatus::where('id', $status->id)->first();
        $this->assertNull($removedStatus);
    }
}
