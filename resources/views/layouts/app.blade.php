<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Capsulify')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
</head>

<body>
    <div class="shell">
        <header class="topbar">
            <a class="brand" href="{{ route('home') }}">Capsulify</a>
            <nav class="nav">
                <a href="{{ route('categories.index') }}">Категории</a>
                <a href="{{ route('files.index') }}">Файлы</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="link-button">Выйти</button>
                </form>
            </nav>
        </header>
        <main class="page">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
