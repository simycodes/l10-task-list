<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence, // sentence, without () then its a property
            'description' => fake()->paragraph,
            'long_description' => fake()->paragraph(7, true), // 7 paragraphs
            'completed' => fake()->boolean,
            // no need to set up timestamps
        ];
    }
}
