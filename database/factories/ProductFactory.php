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
            'distributor_id' => \App\Models\Distributor::factory(),
            'brand_id' => \App\Models\Brand::factory(),
            'sku' => $this->faker->unique()->regexify('[A-Za-z0-9]{12}'),
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stocks' => $this->faker->numberBetween(1, 100),
            'photo' => 'https://i.pravatar.cc/300?img=' . $this->faker->numberBetween(1, 70),
            'status' => $this->faker->boolean()
        ];
    }
}
