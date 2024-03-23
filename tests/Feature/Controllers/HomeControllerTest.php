<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_index_method()
    {
        Post::factory()->count(10)->create();

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        // test view with home name
        $response->assertViewIs('home');
        //test data with post key
        $response->assertViewHas('posts', Post::query()->latest()->paginate(15));

    }
}
