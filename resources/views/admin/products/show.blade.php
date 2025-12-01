@extends('admin.layout')

@section('title', __('Products'))

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">{{ $product->translation(app()->getLocale())->name }}</h1>

        <div class="mb-4">
            <strong>{{ __('Hash') }}:</strong> {{ $product->hash }}
        </div>

        <div class="mb-4">
            <strong>{{ __('Price') }}:</strong> {{ $product->price }} €
        </div>

        <div class="mb-4">
            <strong>{{ __('Categories') }}:</strong>
            {{ $product->categories->map(fn($c) => $c->translation(app()->getLocale())->name)->join(', ') }}
        </div>

        <div class="mb-4">
            <strong>{{ __('Image') }}:</strong>
            @if($product->image_url)
                <p class="text-sm">{{$product->image_url}}</p>
                <img src="{{ $product->image_url }}" alt="{{ $product->translation(app()->getLocale())->name }}"
                     class="h-64 object-cover border">
            @else
                <span>{{ __('No image') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <strong>{{ __('Description') }}:</strong>
            <p>{{ $product->translation(app()->getLocale())->description ?? '-' }}</p>
        </div>

        <a href="{{ route('admin.products.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            {{ __('Back to products') }}
        </a>
    </div>
@endsection

