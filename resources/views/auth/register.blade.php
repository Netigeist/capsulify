@extends('layouts.auth')

@section('title', 'Регистрация')

@section('content')
    <h1>Регистрация</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label>
            Имя пользователя
            <input type="text" name="username" value="{{ old('username') }}" required>
        </label>
        @error('username')
            <p class="error">{{ $message }}</p>
        @enderror

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

        <button type="submit">Зарегистрироваться</button>
    </form>

    <div class="links">
        <a href="{{ route('login') }}">Вход</a>
    </div>
@endsection
