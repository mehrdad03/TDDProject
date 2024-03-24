<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'type' => Arr::random(['admin', 'user']),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's type should be user.
     */
    public function user(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'user',
        ]);
    }

    /**
     * Indicate that the model's type should be admin.
     */
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'admin',
        ]);
    }
}
