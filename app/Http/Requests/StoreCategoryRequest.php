<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'category_title' => trim((string) $this->input('category_title')),
        ]);
    }

    public function rules(): array
    {
        return [
            'category_title' => ['required', 'string', 'max:25'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->has('category_title')) {
                return;
            }

            $title = (string) $this->input('category_title');
            $normalized = mb_strtolower($title);

            $exists = $this->user()
                ->categories()
                ->pluck('category_title')
                ->contains(fn ($existing): bool => mb_strtolower(trim((string) $existing)) === $normalized);

            if ($exists) {
                $validator->errors()->add('category_title', 'Категория с таким названием уже существует.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'category_title.required' => 'Укажите название категории.',
            'category_title.max' => 'Название категории должно быть не длиннее 25 символов.',
        ];
    }
}
