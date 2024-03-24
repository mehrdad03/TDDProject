<?php

namespace Tests\Feature\Middlewares;

use App\Http\Middleware\CheckUserIsAdmin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class CheckUserIsAdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_when_user_is_not_admin(): void
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $request = Request::create('/admin');

        $middleware = new CheckUserIsAdmin();

        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals($response->getStatusCode(), 302);

    }

    public function test_when_user_is_admin(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user);

        $request = Request::create('/admin');

        $middleware = new CheckUserIsAdmin();

        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals($response, null);

    }

    public function test_when_user_is_not_logged_in(): void
    {

        $request = Request::create('/admin');

        $middleware = new CheckUserIsAdmin();

        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals($response->getStatusCode(), 302);

    }

}
