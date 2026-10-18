<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Capsulify')</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
