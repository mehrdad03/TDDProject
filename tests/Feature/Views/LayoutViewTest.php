<?php

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LayoutViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_layout_view_rendered_when_user_admin()
    {
        $user = User::factory()->state(['type' => 'admin'])->create();
        $this->actingAs($user);
        $view = $this->view('layouts.layout');

        //FALSE for html tag and TRUE for text in assertSee
        $view->assertSee('<a href="/admin/dashboard">admin panel</a>', false);


    }

    public function test_layout_view_rendered_when_user_is_not_admin()
    {
        $user = User::factory()->state(['type' => 'user'])->create();
        $this->actingAs($user);
        $view = $this->view('layouts.layout');

        //FALSE for html tag and TRUE for text in assertSee
        $view->assertDontSee('<a href="/admin/dashboard">admin panel</a>', false);


    }
}
