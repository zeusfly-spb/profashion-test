<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_list_of_users()
    {
        User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $data = ['name' => 'Иван Иванов', 'email' => 'ivan@example.com'];

        $response = $this->postJson('/api/users', $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Иван Иванов']);

        $this->assertDatabaseHas('users', ['email' => 'ivan@example.com']);
    }

    /** @test */
    public function it_returns_validation_error_when_creating_user_with_invalid_data()
    {
        $response = $this->postJson('/api/users', ['name' => '']);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_shows_user_by_id()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $user->id]);
    }

    /** @test */
    public function it_updates_a_user()
    {
        $user = User::factory()->create();

        $newData = ['name' => 'Сидор Петров', 'email' => 'sidor@example.com'];

        $response = $this->putJson("/api/users/{$user->id}", $newData);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Сидор Петров']);

        $this->assertDatabaseHas('users', ['email' => 'sidor@example.com']);
    }

    /** @test */
    public function it_deletes_a_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson(['result' => true]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_returns_user_posts()
    {
        $user = User::factory()->hasPosts(2)->create();

        $response = $this->getJson("/api/users/{$user->id}/posts");

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    /** @test */
    public function it_returns_user_comments()
    {
        $user = User::factory()->hasComments(2)->create();

        $response = $this->getJson("/api/users/{$user->id}/comments");

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }
}
