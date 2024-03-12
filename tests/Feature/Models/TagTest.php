<?php

namespace Tests\Feature\Models;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{

    use RefreshDatabase;

    public function test_insert_data(): void
    {
        $data = Tag::factory()->make()->toArray();

        Tag::query()->create($data);

        $this->assertDatabaseHas('tags', $data);
    }
}
