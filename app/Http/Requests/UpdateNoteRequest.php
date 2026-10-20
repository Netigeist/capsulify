<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'category_id' => $this->input('category_id') === '' ? null : $this->input('category_id'),
            'file_id' => $this->input('file_id') === '' ? null : $this->input('file_id'),
            'due_date' => $this->input('due_date') === '' ? null : $this->input('due_date'),
            'is_completed' => $this->boolean('is_completed'),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where('user_id', $this->user()->id),
            ],
            'file_id' => [
                'nullable',
                Rule::exists('files', 'id')->where('user_id', $this->user()->id),
            ],
            'due_date' => ['nullable', 'date'],
            'is_completed' => ['boolean'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->has('due_date')) {
                return;
            }

            $incoming = $this->input('due_date');

            if ($incoming === null || $incoming === '') {
                return;
            }

            $note = $this->user()->notes()->find($this->route('note'));

            if ($note === null) {
                return;
            }

            $parsed = Carbon::createFromFormat('Y-m-d', $incoming);

            if ($parsed === false) {
                return;
            }

            if ($note->due_date?->format('Y-m-d') === $parsed->format('Y-m-d')) {
                return;
            }

            if ($parsed->lt(Carbon::today())) {
                $validator->errors()->add('due_date', 'Срок должен быть не раньше сегодняшнего дня.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Введите название заметки.',
            'title.max' => 'Название не должно превышать 255 символов.',
            'content.required' => 'Введите текст заметки.',
            'category_id.exists' => 'Категория не найдена.',
            'file_id.exists' => 'Файл не найден.',
            'due_date.date' => 'Укажите корректную дату срока.',
        ];
    }
}
