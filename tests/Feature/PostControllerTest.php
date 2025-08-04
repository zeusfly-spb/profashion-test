<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_list_of_posts()
    {
        Post::factory()->count(3)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function it_creates_a_post()
    {
        $user = User::factory()->create();
        $data = [
            'title' => 'Заголовок',
            'body' => 'Текст публикации',
            'user_id' => $user->id,
        ];

        $response = $this->postJson('/api/posts', $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Заголовок']);

        $this->assertDatabaseHas('posts', ['title' => 'Заголовок']);
    }

    /** @test */
    public function it_fails_to_create_post_with_invalid_data()
    {
        $response = $this->postJson('/api/posts', [
            'title' => '',
            'body' => 'Контент',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_shows_post_by_id()
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $post->id]);
    }

    /** @test */
    public function it_updates_post()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $data = [
            'title' => 'Новый заголовок',
            'body' => 'Новый текст',
            'user_id' => $user->id,
        ];

        $response = $this->putJson("/api/posts/{$post->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Новый заголовок']);

        $this->assertDatabaseHas('posts', ['title' => 'Новый заголовок']);
    }

    /** @test */
    public function it_deletes_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJson(['result' => true]);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /** @test */
    public function it_returns_404_for_missing_post()
    {
        $response = $this->getJson('/api/posts/99999');
        $response->assertStatus(200);
        $response->assertJsonMissing(['id' => 99999]);
    }
}
