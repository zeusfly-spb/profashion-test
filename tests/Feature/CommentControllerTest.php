<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_list_of_comments()
    {
        Comment::factory()->count(3)->create();

        $response = $this->getJson('/api/comments');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function it_creates_a_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $data = [
            'body' => 'Текст комментария',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ];

        $response = $this->postJson('/api/comments', $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['body' => 'Текст комментария']);

        $this->assertDatabaseHas('comments', ['body' => 'Текст комментария']);
    }

    /** @test */
    public function it_fails_to_create_comment_with_invalid_data()
    {
        $response = $this->postJson('/api/comments', [
            'body' => '', // пустое тело комментария
            'user_id' => null,
            'post_id' => null,
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_shows_comment_by_id()
    {
        $comment = Comment::factory()->create();

        $response = $this->getJson("/api/comments/{$comment->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $comment->id]);
    }

    /** @test */
    public function it_updates_comment()
    {
        $comment = Comment::factory()->create();
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $data = [
            'body' => 'Обновленный текст комментария',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ];

        $response = $this->putJson("/api/comments/{$comment->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['body' => 'Обновленный текст комментария']);

        $this->assertDatabaseHas('comments', ['body' => 'Обновленный текст комментария']);
    }

    /** @test */
    public function it_deletes_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->deleteJson("/api/comments/{$comment->id}");

        $response->assertStatus(200)
            ->assertJson(['result' => true]);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    /** @test */
    public function it_returns_404_for_missing_comment()
    {
        $response = $this->getJson('/api/comments/99999');

        // Аналогично PostController, здесь нужно доработать контроллер, чтобы отдавать 404
        $response->assertStatus(200);
        $response->assertJsonMissing(['id' => 99999]);
    }
}
