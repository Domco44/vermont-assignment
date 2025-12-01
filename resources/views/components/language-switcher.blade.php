<form action="{{ route('locale.switch') }}" method="GET">
    <select
        name="locale"
        onchange="this.form.submit()"
        class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
    >
        @foreach(config('locales.available') as $locale => $label)
            <option value="{{ $locale }}" {{ app()->getLocale() === $locale ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</form>
