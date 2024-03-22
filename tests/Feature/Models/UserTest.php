<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_insert_data(): void
    {
        $data = User::factory()->make()->toArray();
        $data['password'] = Hash::make(123456);
        $data['email_verified_at'] = Carbon::now()->format('Y-m-d H:i:s');
        User::create($data);

        $this->assertDatabaseHas('users', $data);

    }
    public function test_user_relationship_with_post()
    {
        $count=rand(1,10);

        $user = User::factory()
            ->hasPosts($count)
            ->create();

        $this->assertCount($count,$user->posts);
        $this->assertTrue($user->posts->first() instanceof Post);

    }

    public function test_user_relationship_with_comment()
    {
        $count = rand(1, 10);

        $user = User::factory()
            ->hasComments($count)
            ->create();

        $this->assertCount($count, $user->comments);
        $this->assertTrue($user->comments->first() instanceof Comment);

    }
}
