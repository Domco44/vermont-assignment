<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'hash' => $this->faker->unique()->regexify('[A-Za-z0-9]{16}'),
            'image_url' => 'https://picsum.photos/seed/' . $this->faker->unique()->numberBetween(1, 1000) . '/200/300',
            'price' => $this->faker->randomFloat(2, 5, 300),
        ];
    }
}
