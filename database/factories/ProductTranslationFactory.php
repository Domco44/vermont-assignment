<?php

namespace Database\Factories;

use App\Models\ProductTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductTranslationFactory extends Factory
{
    protected $model = ProductTranslation::class;

    public function definition(): array
    {
        $name = $this->faker->sentence(3);

        return [
            'locale' => 'en',
            'name' => $name,
            'description' => $this->faker->paragraph(3),
            'slug' => Str::slug($name),
        ];
    }
}
