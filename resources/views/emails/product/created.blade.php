@php $locale = app()->getLocale(); @endphp

<div style="font-family: sans-serif; line-height: 1.5; color: #333;">
    <h2>{{ $product->translation($locale)->name }}</h2>
    <p>{{ $product->translation($locale)->description ?? '' }}</p>

    <p><strong>{{ __('Price') }}:</strong> {{ $product->price }} €</p>

    @if($product->image_url)
        <img src="{{ $product->image_url }}" alt="{{ $product->translation($locale)->name }}" style="width:200px; height:auto; border:1px solid #ccc;">
    @endif

    <p>
        <a href="{{ route('admin.products.show', $product) }}"
           style="display:inline-block; background-color:#38bdf8; color:white; padding:10px 15px; border-radius:5px; text-decoration:none;">
            {{ __('View Product') }}
        </a>
    </p>
</div>
