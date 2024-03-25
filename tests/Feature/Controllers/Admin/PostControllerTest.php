<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method()
    {
        Post::factory()->count(100)->create();


        $this->actingAs(User::factory()->admin()->create())
            ->get(route('post.index'))
            ->assertOk()
            ->assertViewIs('admin.post.index')
            ->assertViewHas('posts', Post::query()->latest()->paginate(15));

        $this->assertEquals(
            ['web', 'admin'],
            request()->route()->middleware()
        );

        //dd(request()->route()->middleware());
    }

    public function test_create_method(): void
    {
        Tag::factory()->count(20)->create();


        $this->actingAs(User::factory()->admin()->create())
            ->get(route('post.create'))
            ->assertOk()
            ->assertViewIs('admin.post.create')
            ->assertViewHas('tags', Tag::query()->latest()->get());

        $this->assertEquals(
            ['web', 'admin'],
            request()->route()->middleware()
        );

    }

    public function test_edit_method(): void
    {
        $post = Post::factory()->create();
        Tag::factory()->count(20)->create();


        $this->actingAs(User::factory()->admin()->create())
            ->get(route('post.edit', $post->id))
            ->assertOk()
            ->assertViewIs('admin.post.edit')
            ->assertViewHasAll([
                'tags' => Tag::query()->latest()->get(),
                'post' => $post,
            ]);
        $this->assertEquals(
            ['web', 'admin'],
            request()->route()->middleware()
        );
    }
}
