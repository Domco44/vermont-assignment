<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $faker->seed(200);

        $categories = Category::all();

        Product::factory()->count(20)->create()->each(function ($product) use ($categories, $faker) {
            $shuffled = $faker->shuffle($categories->values()->all());

            $count = $faker->numberBetween(1, 3);
            $selectedCategories = array_slice($shuffled, 0, $count);

            $product->categories()->attach(array_map(fn($cat) => $cat->id, $selectedCategories));

            foreach (config('locales.available') as $locale => $langName) {
                $name = $faker->words(3, true) . " ({$locale})";
                $product->translations()->create([
                    'locale' => $locale,
                    'name' => $name,
                    'description' => $faker->paragraph(3),
                    'slug' => Str::slug($name),
                ]);
            }
        });
    }
}
