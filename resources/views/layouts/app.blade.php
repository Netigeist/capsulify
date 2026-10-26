<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Capsulify')</title>
    <script src="{{ asset('js/theme.js') }}?v={{ filemtime(public_path('js/theme.js')) }}"></script>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}?v={{ filemtime(public_path('css/theme.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}?v={{ filemtime(public_path('css/categories.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/notes.css') }}?v={{ filemtime(public_path('css/notes.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/search.css') }}?v={{ filemtime(public_path('css/search.css')) }}">
</head>

<body>
    <div class="shell">
        <header class="topbar">
            <div class="topbar-start">
                <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-nav">Меню</button>
                <a class="brand" href="{{ route('home') }}">Capsulify</a>
            </div>
            <nav id="main-nav" class="nav">
                <a href="{{ route('categories.index') }}">Категории</a>
                <a href="{{ route('files.index') }}">Файлы</a>
                <a href="{{ route('notes.index') }}">Заметки</a>
                <a href="{{ route('search') }}">Поиск</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="link-button">Выйти</button>
                </form>
            </nav>
            <button class="theme-toggle" type="button" aria-pressed="false">Тема</button>
        </header>
        <main class="page">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}" defer></script>
</body>

</html>
