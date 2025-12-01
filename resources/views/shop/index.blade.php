@extends('layout')

@section('content')
    <div class="container mx-auto flex flex-col lg:flex-row gap-6">

        <!-- Categories sidebar -->
        <aside class="w-full lg:w-1/4 bg-white p-4 rounded shadow">
            <h2 class="text-xl font-bold mb-3">{{__('Categories')}}</h2>
            <ul>
                <li class="mb-1">
                    <a href="{{ route('shop.index') }}"
                       class="{{ request('category') ? 'text-gray-700 hover:text-blue-500' : 'font-bold text-blue-600' }}">
                        All
                    </a>
                </li>
                @foreach ($categories as $category)
                    <li class="mb-1">
                        <a href="{{ route('shop.index', ['category' => $category->id]) }}"
                           class="{{ request('category') == $category->id ? 'font-bold text-blue-600' : 'text-gray-700 hover:text-blue-500' }}">
                            {{ $category->translation(app()->getLocale())->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <!-- Products list -->
        <main class="w-full lg:w-3/4">
            <h1 class="text-3xl font-bold mb-6">{{__('Products')}}</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    @php
                        $trans = $product->translation(app()->getLocale());
                    @endphp
                    <div class="border rounded shadow bg-white overflow-hidden flex flex-col">
                        <img src="{{ $product->image_url }}" alt="{{ $trans->name }}" class="w-full h-48 object-cover">
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="text-xl font-semibold mb-2">{{ $trans->name }}</h3>
                            <p class="text-md text-gray-600 mt-auto">{{ $product->price }}€</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->withQueryString()->links() }}
            </div>
        </main>
    </div>
@endsection
