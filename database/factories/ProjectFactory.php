<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->paragraph(),
            'type' => $this->faker->randomElement(['fixed', 'hourly']),
            'budget' => fake()->numberBetween(100, 1000), // password
            'user_id' => User::where('email', 'muhammed.saber@gmail.com')->first()->id,
            'category_id' => Category::all()->random()->id
        ];
    }
}
