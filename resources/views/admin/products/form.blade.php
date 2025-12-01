@php $isEdit = isset($product);
    if (!isset($product)) {
        $product = null;
    }
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <!-- Hash, price, image_url -->
    <div class="mb-4">
        <span>{{ __('Hash') }} <span class="text-gray-500 text-xs">{{__('Generated if not provided')}}</span></label>
            <input type="text" name="hash" value="{{ old('hash', $product?->hash ?? '') }}"
                   class="border p-2 w-full {{ $isEdit ? 'bg-gray-100 cursor-not-allowed' : '' }}"
            {{ $isEdit ? 'readonly' : '' }}>
        @error('hash')<p class="text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="mb-4">
        <label>{{ __('Price') }} (€)</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product?->price ?? '') }}"
               class="border p-2 w-full">
        @error('price')<p class="text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="mb-4">
        @if ($product?->image_url)
            <img class="h-40" src="{{$product?->image_url ?? ''}}" alt="Image"/>
        @endif
        <label>{{ __('Image URL') }}</label>
        <input type="text" name="image_url" value="{{ old('image_url', $product?->image_url ?? '') }}"
               class="border p-2 w-full">
        @error('image_url')<p class="text-red-600">{{ $message }}</p>@enderror
    </div>

    <!-- Translations -->
    @foreach(config('locales.available') as $locale => $langName)
        <fieldset class="mb-4 border p-4">
            <legend>{{ $langName }}</legend>

            <div class="mb-2">
                <label>{{ __('Name') }}</label>
                <input type="text" name="translations[{{ $locale }}][name]" id="name-{{$locale}}"
                       value="{{ old("translations.$locale.name", $product?->translation($locale)->name ?? '') }}"
                       class="border p-2 w-full">
                @error("translations.$locale.name")<p class="text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-2">
                <label>{{ __('Slug') }}</label>
                <input type="text" name="translations[{{ $locale }}][slug]" id="slug-{{$locale}}"
                       value="{{ old("translations.$locale.slug", $product?->translation($locale)->slug ?? '') }}"
                       class="border p-2 w-full">
                @error("translations.$locale.slug")<p class="text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label>{{ __('Description') }}</label>
                <textarea name="translations[{{ $locale }}][description]"
                          class="border p-2 w-full">{{ old("translations.$locale.description", $product?->translation($locale)->description ?? '') }}</textarea>
                @error("translations.$locale.description")<p class="text-red-600">{{ $message }}</p>@enderror
            </div>
        </fieldset>
    @endforeach

    <!-- Categories multiselect -->
    <div class="mb-4">
        <label>{{ __('Categories') }}</label>
        <select name="categories[]" multiple class="border p-2 w-full">
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ in_array($category->id, old('categories', $product?->categories->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                    {{ $category->translation(app()->getLocale())->name }}
                </option>
            @endforeach
        </select>
        @error('categories')<p class="text-red-600">{{ $message }}</p>@enderror
    </div>

    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
        {{ $isEdit ? __('Update product') : __('Create product') }}
    </button>
</form>

<script>
    function slugify(text) {
        return text.toString()
            .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // remove accents
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-+|-+$/g, "");
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("input[id^='name-']").forEach(nameInput => {
            const locale = nameInput.id.replace('name-', '');
            const slugInput = document.getElementById('slug-' + locale);
            if (!slugInput) return;

            nameInput.addEventListener("input", function () {
                slugInput.value = slugify(this.value);
            });
        });
    });
</script>
