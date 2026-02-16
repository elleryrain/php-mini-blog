<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мини-блог')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        h1,h2,h3,.brand { font-family: "Space Grotesk", sans-serif; }
        body,p,a,button,input,textarea { font-family: "Merriweather", serif; }
    </style>
</head>
<body>
<header class="sticky top-0 z-40 backdrop-blur bg-white/75 border-b border-gray-200">
    <div class="container-blog py-4 flex items-center justify-between">
        <a href="{{ route('posts.index') }}" class="brand text-2xl font-bold tracking-tight">Mini Blog</a>
        <nav class="flex items-center gap-2">
            @auth
                <a href="{{ route('posts.create') }}" class="btn-primary">Новый пост</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-ghost">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-ghost">Войти</a>
                <a href="{{ route('register') }}" class="btn-primary">Регистрация</a>
            @endauth
        </nav>
    </div>
</header>

<main class="container-blog py-8 fade-up">
    @if (session('status'))
        <div class="card p-4 mb-5 text-emerald-800 bg-emerald-50 border-emerald-200">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="card p-4 mb-5 text-red-800 bg-red-50 border-red-200">
            @foreach ($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
