<?php

namespace Database\Factories;

use App\Models\CategoryTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryTranslationFactory extends Factory
{
    protected $model = CategoryTranslation::class;

    public function definition(): array
    {
        $name = $this->faker->words(2, true);

        return [
            'locale' => 'en',
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
