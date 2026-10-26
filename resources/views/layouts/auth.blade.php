<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Capsulify')</title>
    <script src="{{ asset('js/theme.js') }}?v={{ filemtime(public_path('js/theme.js')) }}"></script>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}?v={{ filemtime(public_path('css/theme.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ filemtime(public_path('css/auth.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}?v={{ filemtime(public_path('css/modal.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}?v={{ filemtime(public_path('css/toast.css')) }}">
</head>

<body>
    <div class="auth-topbar">
        <button class="theme-toggle" type="button" aria-pressed="false">Тема</button>
    </div>

    <div class="container">
        <div class="container-header">
            <a class="brand" href="{{ route('login') }}">Capsulify</a>
        </div>

        @yield('content')
    </div>

    @include('partials.modal')
    @include('partials.toasts')

    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}" defer></script>
</body>

</html>
