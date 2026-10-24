<?php

namespace App\Http\Requests\Auth;

use App\Rules\EmailWithDomain;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Укажите email.',
            'email.email' => 'Укажите корректный email.',
        ];
    }
}
