<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags=[
            "React",
            "Angular",
            "TailWind",
            "DevOps",
            "Security",
            "Bug"
        ];
        return [
            "titre"=>fake()->word()
        ];
    }
}
