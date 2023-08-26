<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_authenticated_user_can_create_task(): void
    {
        $user = User::factory(1)->create()[0];
        $response = $this->actingAs($user)
            ->post('/api/tasks', [
                'title' => 'this test title',
                'description' => 'this test description',
                'due_date' => '12/08/2023'
            ]);

            $response->assertStatus(201);
            $expectedTitle = 'this test title';
            $task = Task::where('title', 'this test title')->firstOrFail();
            $this->assertEquals($expectedTitle, $task->title);
    }


}
