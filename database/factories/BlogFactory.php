<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title=fake()->title();
        return [
            "titre" => $this,
            "content" => "lol",
            "slug" => Str::slug($title),
            "image" => fake()->imageUrl(),
            "user_id" =>User::factory()
        ];
    }
}
