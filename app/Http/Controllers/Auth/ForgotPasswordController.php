<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Ссылка для сброса пароля записана в storage/logs/laravel.log.');
        }

        return back()->withErrors([
            'email' => 'Не удалось отправить ссылку для сброса пароля.',
        ]);
    }
}
