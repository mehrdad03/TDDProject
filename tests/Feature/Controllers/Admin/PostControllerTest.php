<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method(): void
    {
        Post::factory()->count(100)->create();


        $this->get(route('post.index'))
            ->assertOk()
            ->assertViewIs('admin.post.index')
            ->assertViewHas('posts', Post::query()->latest()->paginate(15));

    }

    public function test_create_method(): void
    {
        Tag::factory()->count(20)->create();


        $this->get(route('post.create'))
            ->assertOk()
            ->assertViewIs('admin.post.create')
            ->assertViewHas('tags', Tag::query()->latest()->get());

    }

    public function test_edit_method(): void
    {
        $post = Post::factory()->create();
        Tag::factory()->count(20)->create();


        $this->get(route('post.edit', $post->id))
            ->assertOk()
            ->assertViewIs('admin.post.edit')
            ->assertViewHasAll([
                'tags' => Tag::query()->latest()->get(),
                'post' => $post,
            ]);

    }
}
