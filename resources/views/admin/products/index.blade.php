@extends('admin.layout')

@section('title', __('Products'))

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">{{ __('Products') }}</h1>

        <a href="{{ route('admin.products.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4 inline-block">
            {{ __('Create product') }}
        </a>

        <table class="table-auto w-full border border-gray-200 rounded shadow-sm">
            <thead>
            <tr class="bg-gray-100 border-b">
                <th class="px-4 py-2 text-left">{{ __('Hash') }}</th>
                <th class="px-4 py-2 text-left">{{ __('Name') }}</th>
                <th class="px-2 py-2 text-left">{{ __('Image') }}</th>
                <th class="px-2 py-2 text-left">{{ __('Price') }}</th>
                <th class="px-4 py-2 text-left">{{ __('Categories') }}</th>
                <th class="px-4 py-2 text-left">{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2 font-mono">{{ $product->hash }}</td>
                    <td class="px-4 py-2">
                        {{ $product->translation(app()->getLocale())->name ?? '-' }}
                    </td>
                    <td class="px-2 py-2"><img class="h-16" src="{{$product->image_url}}" alt="{{$product->name . __("Image")}}"></td>
                    <td class="px-2 py-2">{{ $product->price }}€</td>
                    <td class="px-4 py-2">
                        {{ $product->categories->map(fn($c) => $c->translation(app()->getLocale())->name)->join(', ') }}
                    </td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('admin.products.show', $product) }}" title="{{ ('View Product') }}"
                           class="text-green-600 hover:text-green-800 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5">
                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                            </svg>
                        </a>

                        <a href="{{ route('admin.products.edit', $product) }}" title="{{ ('Edit') }}"
                           class="text-blue-600 hover:text-blue-800 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5">
                                <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z"/>
                                <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z"/>
                            </svg>
                        </a>

                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="{{ __('Delete') }}"
                                    class="text-red-600 hover:text-red-800 flex items-center justify-center p-0"
                                    onclick="return confirm('{{ __('Are you sure you want to delete this product?') }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                     class="h-5">
                                    <path fill-rule="evenodd"
                                          d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
