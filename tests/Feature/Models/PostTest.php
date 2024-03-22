<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_insert_data(): void
    {
        $data = Post::factory()->make()->toArray();

        Post::query()->create($data);

        $this->assertDatabaseHas('posts', $data);
    }

    public function test_post_relationship_with_user()
    {
        $post = Post::factory()
            ->for(User::factory())
            ->create();

        $this->assertTrue(isset($post->user->id));;
        $this->assertTrue($post->user instanceof User);

    }

    public function test_post_relationship_with_tag()
    {
        $count = rand(0, 10);

        $post = Post::factory()
            ->hasTags($count)
            ->create();

        $this->assertCount($count, $post->tags);;
        $this->assertTrue($post->tags->first() instanceof Tag);

    }
}
