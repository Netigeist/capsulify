<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function create(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function store(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function (User $user, string $password) {
                $user->password = $password;
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect('/login')->with('status', 'Пароль изменён.');
        }

        return back()->withErrors([
            'email' => 'Не удалось изменить пароль.',
        ]);
    }
}
