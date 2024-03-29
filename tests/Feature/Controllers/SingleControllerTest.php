<?php

namespace Tests\Feature\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
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
            'post' => $post,
            'comments' => $post->comments()->latest()->paginate(15),
        ]);

    }

    public function test_comment_method_when_user_logged_in()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $data = Comment::factory()->state([
            'user_id' => $user->id,
            'commentable_id' => $post->id,
        ])->make()->toArray();

        //send post request to single.comment
        $response = $this
            ->actingAs($user)
            ->withHeaders([
                'HTTP_X-Requested-with' => 'XMLHttpRequest'
            ])
            ->postJson(
                route('single.comment', $post->id),
                ['text' => $data['text']]
            );
        //If we use redirection in the controller, we expect a 302 status code
        $response
            ->assertOk()
            ->assertJson([
                'created' => true
            ]);
        $this->assertDatabaseHas('comments', $data);
    }

    public function test_comment_method_when_user_not_logged_in()
    {
        $post = Post::factory()->create();
        $data = Comment::factory()->state([

            'commentable_id' => $post->id,
        ])->make()->toArray();

        //for ignore user_id
        unset($data['user_id']);

        // $this->withoutExceptionHandling();
        //send post request to single.comment
        $response = $this
            ->withHeaders([
                'HTTP_X-Requested-with' => 'XMLHttpRequest'
            ])
            ->postJson(
                route('single.comment', $post->id),
                ['text' => $data['text']]
            );
        //If we use redirection in the controller, we expect a 302 status code
        //$response->assertOk();
        // $response->assertRedirect(route('login'));
        $response->assertUnauthorized();
        $this->assertDatabaseMissing('comments', $data);
    }

    public function test_comment_method_valid_required_data()
    {
       // $this->withoutExceptionHandling();
        $post = Post::factory()->create();

        $response = $this
            ->actingAs(User::factory()->create())
            ->withHeaders([
                'HTTP_X-Requested-with' => 'XMLHttpRequest'
            ])
            ->postJson(
                route('single.comment', $post->id),
                ['text' =>'']
            );

        $response->assertJsonValidationErrors([
            'text' =>'The text field is required.'
        ]);

    }
}
