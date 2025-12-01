<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $rules = [
//            'hash' => 'nullable', // ignore in requests
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'translations' => 'required|array',
        ];

        foreach (config('locales.available') as $locale => $langName) {
            $rules["translations.$locale.name"] = 'required|string|min:3|max:255';
            $rules["translations.$locale.slug"] = [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('product_translations', 'slug')
                    ->where(fn($query) => $query->where('locale', $locale))
                    ->ignore($this->product?->id ?? null, 'product_id'),
            ];
            $rules["translations.$locale.description"] = 'nullable|string';
        }

        return $rules;
    }

}
