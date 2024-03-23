<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SingleControllerTest extends TestCase
{
 use RefreshDatabase;
    public function test_index_method()
    {

        $count = rand(0, 3);
        $post = Post::factory()->hasComments($count)->create();

        $response = $this->get(route('single', $post->id));

        //check error in request starts
        // $this->withoutExceptionHandling();

        $response->assertOk();
        // view test with 'single' name
        $response->assertViewIs('single');
        //pass data test with post key
        $response->assertViewHasAll([
            'post'=>$post,
            'comments'=>$post->comments()->latest()->paginate(15),
        ]);

    }
}
