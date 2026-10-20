<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:3072',
                'mimes:jpg,jpeg,png,gif,webp,pdf,docx',
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $uploaded = $this->file('file');

            if ($uploaded === null) {
                return;
            }

            if (mb_strlen($uploaded->getClientOriginalName()) > 255) {
                $validator->errors()->add('file', 'Имя файла слишком длинное.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Выберите файл для загрузки.',
            'file.file' => 'Некорректный файл.',
            'file.max' => 'Размер файла не должен превышать 3 МБ.',
            'file.mimes' => 'Допустимые форматы: jpg, jpeg, png, gif, webp, pdf, docx.',
        ];
    }
}
