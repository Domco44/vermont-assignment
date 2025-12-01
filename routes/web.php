<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/locale', function (\Illuminate\Http\Request $request) {
    $locale = $request->input('locale');

    if (! array_key_exists($locale, config('locales.available'))) {
        $locale = config('locales.default');
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('locale.switch');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware('admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::resource('products', ProductController::class);
        });
});

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
