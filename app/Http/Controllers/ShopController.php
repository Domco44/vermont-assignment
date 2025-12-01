<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        $categories = Category::with('translations')->get();

        $query = Product::with('translations', 'categories');

        if ($categoryId = request('category')) {
            $query->whereHas('categories', fn($q) => $q->where('id', $categoryId));
        }

        $products = $query->paginate(12)->withQueryString();

        return view('shop.index', compact('products', 'categories'));
    }
}
