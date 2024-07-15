@vite(['resources/css/app.css'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <title>Registration</title>
</head>
<body>
    <div>
        <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                </header>
                    <div class="container">
                        <section id="content">
                            <form>
                                <h1>Регистрация</h1>
                                <div>
                                    <input type="text" placeholder="Имя" required="" id="name" name="name"/>
                                </div>
                                <div>
                                    <input type="text" placeholder="Email" required="" id="username" name="email"/>
                                </div>
                                <div>
                                    <input type="password" placeholder="Пароль" required="" id="password" name="password"/>
                                </div>
                                <div>
                                    <input type="password" placeholder="Подтвердите пароль" required="" id="confirm_password" name="password_confirmation"/>
                                </div>
                                <!--<div>
                                    <input type="hidden" name="ip" value="{{ request()->ip() }}" />
                                </div>-->
                                <div class="bttn-link">
                                    <input type="submit" value="Зарегистрироваться" />
                                    <a id="link" href="/authorization">Есть аккаунт?</a>
                                </div>
                            </form>
                        </section>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>
