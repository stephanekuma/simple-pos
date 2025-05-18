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
            'name' => ucwords($this->faker->word),
            'description' => $this->faker->sentence,
            'image' => $this->faker->imageUrl,
            // 'quantity' => 50,
            // 'barcode' => $this->faker->unique()->ean13,
            'regular_price' => $this->faker->randomFloat(2, 50, 200),
            'price' => $this->faker->randomFloat(2, 40, 190),
            'status' => true
        ];
    }
}
