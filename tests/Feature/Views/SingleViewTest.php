<?php

namespace Tests\Feature\Views;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SingleViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_single_view_rendered_when_user_logged_in()
    {

        $this->withExceptionHandling();
        $post = Post::factory()->create();
        $comments = [];
        $view = (string)$this->actingAs(User::factory()->create())
            ->view('single', compact('post', 'comments')
            );

        $dom = new \DOMDocument();
        $dom->loadHTML($view);
        $dom = new \DOMXPath($dom);
        $action = route('single.comment', $post->id);

        $this->assertCount(
            1,
            $dom->query("//form[@mehtod='post'][@action='$action']/textarea[@name='text']")
        );

    }

    public function test_single_view_rendered_when_user_not_logged_in()
    {

        $this->withExceptionHandling();
        $post = Post::factory()->create();
        $comments = [];
        $view = (string)$this
            ->view('single', compact('post', 'comments')
            );

        $dom = new \DOMDocument();
        $dom->loadHTML($view);
        $dom = new \DOMXPath($dom);
        $action = route('single.comment', $post->id);

        $this->assertCount(
            0,
            $dom->query("//form[@mehtod='post'][contains(@action,'$action')]/textarea[@name='text']")
        );

    }
}
