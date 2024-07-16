@vite(['resources/css/app.css'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>

<body>
    <div>
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                </header>
                <div class="container">
                    <section id="content">
                        @if (Auth::check())
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <h1>Добро пожаловать, {{ Auth::user()->name }}</h1>
                                <input type="submit" value="Выход"/>
                            </form>
                        @else
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <h1>Авторизация</h1>
                                <div>
                                    <input type="text" placeholder="Email" required="" id="username" name="email" />
                                </div>
                                <div>
                                    <input type="password" placeholder="Пароль" required="" id="password" name="password" />
                                </div>
                                <div>
                                    <input type="submit" value="Войти" />
                                    <a id="links" href="#">Забыли пароль?</a>
                                    <a id="links" href="{{ route('register') }}">Зарегистрироваться</a>
                                </div>
                            </form>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
