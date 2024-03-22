<?php

namespace Tests\Feature\Models;

use App\Models\ModelHelperTesting;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{

    use RefreshDatabase, ModelHelperTesting;

    protected function model(): Model
    {
        return new Tag();
    }

    public function test_insert_data(): void
    {
        $data = Tag::factory()->make()->toArray();

        Tag::query()->create($data);

        $this->assertDatabaseHas('tags', $data);
    }

    public function test_tag_relationship_with_post()
    {
        $count = rand(1, 10);

        $tag = Tag::factory()
            ->hasPosts($count)
            ->create();

        $this->assertCount($count, $tag->posts);;
        $this->assertTrue($tag->posts->first() instanceof Post);

    }
}
