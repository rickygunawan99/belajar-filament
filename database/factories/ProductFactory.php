<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(4, true),
            'description' => $this->faker->words(10, true),
            'qty' => $this->faker->numberBetween(1,50),
            'is_visible' => $this->faker->numberBetween(0,1),
            'price' => $this->faker->numberBetween(10000, 500000)
        ];
    }
}
