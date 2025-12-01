<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $faker->seed(100);

        $categories = Category::factory()->count(5)->create();

        foreach ($categories as $category) {

            // EN
            $nameEn = $faker->words(2, true);
            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale' => 'en',
                'name' => ucfirst($nameEn),
                'slug' => Str::slug($nameEn),
            ]);

            // SK
            $nameSk = $faker->words(2, true);
            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale' => 'sk',
                'name' => ucfirst($nameSk),
                'slug' => Str::slug($nameSk),
            ]);
        }
    }
}
