<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower((string) $this->input('email')),
        ]);
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3', 'max:20', 'regex:/^[A-Za-z]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Укажите имя пользователя.',
            'username.min' => 'Имя пользователя должно быть не короче 3 символов.',
            'username.max' => 'Имя пользователя должно быть не длиннее 20 символов.',
            'username.regex' => 'Имя пользователя может содержать только латинские буквы.',
            'email.required' => 'Укажите email.',
            'email.email' => 'Укажите корректный email.',
            'email.max' => 'Email слишком длинный.',
            'email.unique' => 'Этот email уже занят.',
            'password.required' => 'Укажите пароль.',
            'password.min' => 'Пароль должен быть не короче 8 символов.',
        ];
    }
}
