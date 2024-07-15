@vite(['resources/css/app.css'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    <div class="main-container">
        <form class="main-form">
            <h1>Welcome!</h1>
            <div class="links">
                <a id="link" href="/authorization">Log in</a>
                <a id="link" href="/registration">Sign up</a>
            </div>
        </form>
    </div>
</body>
</html>
