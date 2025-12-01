<?php

namespace App\Services;

use App\Events\ProductCreated;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data): Product {
            $product = Product::create([
                'hash' => $data['hash'],
                'price' => $data['price'],
                'image_url' => $data['image_url'] ?? null,
            ]);

            foreach (config('locales.available') as $locale => $langName) {
                if (!empty($data['translations'][$locale])) {
                    $trans = $data['translations'][$locale];
                    $product->translations()->create([
                        'locale' => $locale,
                        'name' => $trans['name'] ?? null,
                        'slug' => $trans['slug'] ?? null,
                        'description' => $trans['description'] ?? null,
                    ]);
                }
            }

            $product->categories()->sync($data['categories'] ?? []);

            event(new ProductCreated($product));

            return $product;
        });
    }

    public function update(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($data, $product) {
            // Never update UUID
            $product->update([
                'price' => $data['price'],
                'image_url' => $data['image_url'] ?? null,
            ]);

            foreach ($data['translations'] as $locale => $transData) {
                $product->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'name' => $transData['name'],
                        'slug' => $transData['slug'],
                        'description' => $transData['description'] ?? null
                    ]
                );
            }

            $product->categories()->sync($data['categories'] ?? []);

            return $product;
        });
    }


}
