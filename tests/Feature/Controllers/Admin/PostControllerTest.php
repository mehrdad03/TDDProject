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

    protected $middlewares = ['web', 'admin'];

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

    public function test_store_method()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $data = Post::factory()
            ->state(['user_id' => $user->id])
            ->make()
            ->toArray();

        $tags = Tag::factory()->count(rand(1, 9))->create();

        $this->actingAs($user)
            ->post(
                route('post.store'),
                array_merge(
                    ['tags' => $tags->pluck('id')->toArray()], $data),
            )
            ->assertSessionHas('message', 'new post has been created')
            ->assertRedirect(route('post.index'));

        $this->assertDatabaseHas('posts', $data);

        $this->assertEquals(
            $tags->pluck('id')->toArray(),
            Post::query()->where($data)->first()->tags()->pluck('id')->toArray()
        );

        $this->assertEquals(
            $this->middlewares,
            request()->route()->middleware()
        );
    }

}
