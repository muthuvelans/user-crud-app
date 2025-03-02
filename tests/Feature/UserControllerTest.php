<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

/**
 * UserControllerTest
 *
 * This test file handles test cases
 *
 * @category   Test cases for users CRUD
 * @package    Tests\Feature\UserControllerTest
 * @author     Muthu velan
 * @created    01-03-2025
 * @updated    01-03-2025
 */

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $response = $this->postJson('/api/users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'role' => 'Agent',
            'email' => 'john.doe@example.com',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'date_of_birth' => '1990-01-01',
            'timezone' => 'UTC'
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['first_name' => 'John']);

        $this->assertDatabaseHas('users', ['email' => 'john.doe@example.com']);
    }

    /** @test */
    public function it_can_fetch_users()
    {
        User::factory()->create(['first_name' => 'Alice']);

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonFragment(['first_name' => 'Alice']);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'first_name' => 'UpdatedName',
            'last_name' => 'UpdatedLast',
            'role' => 'Supervisor',
            'email' => 'updated@example.com',
            'latitude' => 50.1234,
            'longitude' => -50.5678,
            'date_of_birth' => '1995-05-05',
            'timezone' => 'PST'
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['first_name' => 'UpdatedName']);

        $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
