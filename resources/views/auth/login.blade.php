@extends('layouts.auth')

@section('title', 'Вход')

@section('content')
    <h1>Вход</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label>
            Email
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <label>
            Пароль
            <input type="password" name="password" required>
        </label>
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit">Войти</button>
    </form>

    <div class="links">
        <a href="{{ route('register') }}">Регистрация</a>
        <a href="{{ route('password.request') }}">Забыли пароль?</a>
    </div>
@endsection
