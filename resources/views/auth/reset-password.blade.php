@extends('layouts.auth')

@section('title', 'Новый пароль')

@section('content')
    <h1>Новый пароль</h1>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <label>
            Email
            <input type="email" name="email" value="{{ $email ?? old('email') }}" readonly>
        </label>
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <label>
            Новый пароль
            <input type="password" name="password" required>
        </label>
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit">Изменить пароль</button>
    </form>
@endsection
