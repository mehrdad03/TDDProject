<?php

namespace Tests\Feature\Models;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    public function test_insert_data(): void
    {
       $data= Post::factory()->make()->toArray();

       Post::query()->create($data);

       $this->assertDatabaseHas('posts',$data);
    }
}
