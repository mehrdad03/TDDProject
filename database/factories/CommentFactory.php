<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<Model>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commentable_id' => Post::factory(),
            'commentable_type' => Post::class,
            'text' => $this->faker->text,
            'user_id' => User::factory()
        ];
    }
}
