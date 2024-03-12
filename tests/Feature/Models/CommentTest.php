<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
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
}
