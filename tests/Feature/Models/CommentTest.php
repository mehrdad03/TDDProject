<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{

    use RefreshDatabase;

    public function test_insert_data(): void
    {
        $data = Comment::factory()->make()->toArray();

        Comment::query()->create($data);

        $this->assertDatabaseHas('comments', $data);
    }

    public function test_comment_relationship_with_post()
    {
        $comment = Comment::factory()
            ->hasCommentable(Post::factory())
            ->create();


        $this->assertTrue(isset($comment->commentable->id));
        $this->assertTrue($comment->commentable instanceof Post);

    }

    public function test_comment_relationship_with_user()
    {
        $comment = Comment::factory()
            ->for(User::factory())
            ->create();

        $this->assertTrue(isset($comment->user->id));
        $this->assertTrue($comment->user instanceof User);

    }
}
