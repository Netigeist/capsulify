<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $term = trim((string) $this->input('q'));

        $this->merge([
            'q' => $term === '' ? null : $term,
        ]);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'min:2', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'q.min' => 'Поисковый запрос должен быть не короче 2 символов.',
            'q.max' => 'Поисковый запрос не должен превышать 255 символов.',
        ];
    }
}
