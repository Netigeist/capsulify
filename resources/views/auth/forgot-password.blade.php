@extends('layouts.auth')

@section('title', 'Восстановление пароля')

@section('content')
    <h1>Восстановление пароля</h1>

    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <label>
            Email
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit">Отправить ссылку</button>
    </form>

    <div class="links">
        <a href="{{ route('login') }}">Назад ко входу</a>
    </div>
@endsection
