<?php

namespace App\Http\Requests\Auth;

use App\Rules\EmailWithDomain;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['bail', 'required', 'string', 'email:rfc', new EmailWithDomain],
            'password' => ['bail', 'required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Укажите email.',
            'email.email' => 'Укажите корректный email.',
            'password.required' => 'Укажите пароль.',
        ];
    }
}
