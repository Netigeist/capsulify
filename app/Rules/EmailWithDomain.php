<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailWithDomain implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || preg_match('/^[^\s@]+@([^\s@]+\.)+[^\s@]{2,}$/', $value) !== 1) {
            $fail('Укажите корректный email с доменом, например user@example.com.');
        }
    }
}
