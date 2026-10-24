<?php

namespace App\Http\Requests\Auth;

use App\Rules\EmailWithDomain;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower(trim((string) $this->input('email'))),
        ]);
    }

    public function rules(): array
    {
        return [
            'token' => ['bail', 'required', 'string'],
            'email' => ['bail', 'required', 'string', 'email:rfc', new EmailWithDomain],
            'password' => ['bail', 'required', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'token.required' => 'Токен сброса отсутствует.',
            'email.required' => 'Укажите email.',
            'email.email' => 'Укажите корректный email.',
            'password.required' => 'Укажите новый пароль.',
            'password.min' => 'Пароль должен быть не короче 8 символов.',
        ];
    }
}
