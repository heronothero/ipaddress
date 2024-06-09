<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Авторизация</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Styles -->
        <style>
            body {
                background: #DCDDDF url(https://cssdeck.com/uploads/media/items/7/7AF2Qzt.png);
                color: #000;
                font: 14px;
                position: relative;
            }
            h1{ font-size:28px;}
            h1{ color:#563D64;}
            a{ text-decoration: none;}
            form:after {
                content: ".";
                display: block;
                height: 0;
                clear: both;
                visibility: hidden;
            }
            .container { margin: 10em auto; position: relative; width: 900px; }
            #content {
                background: #f9f9f9;
                background: -moz-linear-gradient(top,  rgba(248,248,248,1) 0%, rgba(249,249,249,1) 100%);
                background: -webkit-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: -o-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: -ms-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8f8f8', endColorstr='#f9f9f9',GradientType=0 );
                -webkit-box-shadow: 0 1px 0 #fff inset;
                -moz-box-shadow: 0 1px 0 #fff inset;
                -ms-box-shadow: 0 1px 0 #fff inset;
                -o-box-shadow: 0 1px 0 #fff inset;
                box-shadow: 0 1px 0 #fff inset;
                border: 1px solid #c4c6ca;
                margin: 0 auto;
                padding: 25px 0 0;
                position: relative;
                text-align: center;
                text-shadow: 0 1px 0 #fff;
                width: 400px;
            }
            #content h1 {
                color: #7E7E7E;
                font: bold 25px;
                line-height: 20px;
                margin: 10px 0 30px;
            }
            #content h1:before,
            #content h1:after {
                content: "";
                height: 1px;
                position: absolute;
                top: 10px;
                width: 27%;
            }
            #content h1:after {
                background: rgb(126,126,126);
                background: -moz-linear-gradient(left,  rgba(126,126,126,1) 0%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: -o-linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: -ms-linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: linear-gradient(left,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                right: 0;
            }
            #content h1:before {
                background: rgb(126,126,126);
                background: -moz-linear-gradient(right,  rgba(126,126,126,1) 0%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: -o-linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: -ms-linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                background: linear-gradient(right,  rgba(126,126,126,1) 0%,rgba(255,255,255,1) 100%);
                left: 0;
            }
            #content:after,
            #content:before {
                background: #f9f9f9;
                background: -moz-linear-gradient(top,  rgba(248,248,248,1) 0%, rgba(249,249,249,1) 100%);
                background: -webkit-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: -o-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: -ms-linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                background: linear-gradient(top,  rgba(248,248,248,1) 0%,rgba(249,249,249,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f8f8f8', endColorstr='#f9f9f9',GradientType=0 );
                border: 1px solid #c4c6ca;
                content: "";
                display: block;
                height: 100%;
                left: -1px;
                position: absolute;
                width: 100%;
            }
            #content:after {
                -webkit-transform: rotate(2deg);
                -moz-transform: rotate(2deg);
                -ms-transform: rotate(2deg);
                -o-transform: rotate(2deg);
                transform: rotate(2deg);
                top: 0;
                z-index: -1;
            }
            #content:before {
                -webkit-transform: rotate(-3deg);
                -moz-transform: rotate(-3deg);
                -ms-transform: rotate(-3deg);
                -o-transform: rotate(-3deg);
                transform: rotate(-3deg);
                top: 0;
                z-index: -2;
            }
            #content form { margin: 0 20px; position: relative }
            #content form input[type="text"],
            #content form input[type="password"] {
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                -ms-border-radius: 3px;
                -o-border-radius: 3px;
                border-radius: 3px;
                -webkit-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
                -moz-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
                -ms-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
                -o-box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
                box-shadow: 0 1px 0 #fff, 0 -2px 5px rgba(0,0,0,0.08) inset;
                -webkit-transition: all 0.5s ease;
                -moz-transition: all 0.5s ease;
                -ms-transition: all 0.5s ease;
                -o-transition: all 0.5s ease;
                transition: all 0.5s ease;
                background: #eae7e7;
                border: 1px solid #c8c8c8;
                color: #777;
                font: 14px;
                margin: 0 0 10px;
                padding: 15px;
                width: 80%;
            }
            #content form input[type="text"]:focus,
            #content form input[type="password"]:focus {
                -webkit-box-shadow: 0 0 2px #ed1c24 inset;
                -moz-box-shadow: 0 0 2px #ed1c24 inset;
                -ms-box-shadow: 0 0 2px #ed1c24 inset;
                -o-box-shadow: 0 0 2px #ed1c24 inset;
                box-shadow: 0 0 2px #ed1c24 inset;
                background-color: #fff;
                border: 1px solid #ed1c24;
                outline: none;
            }
            #content form input[type="submit"] {
                background: #1b47e3b3;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                -ms-border-radius: 5px;
                -o-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
                -moz-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
                -ms-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
                -o-box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
                box-shadow: 0 1px 0 rgba(255,255,255,0.8) inset;
                border: 1px solid #a5b8d4;
                color: white;
                cursor: pointer;
                float: left;
                font: bold 15px;
                height: 35px;
                margin: 20px 0 35px 15px;
                position: relative;
                text-shadow: 0 1px 0 rgba(255,255,255,0.5);
                width: 150px;
            }
            #content form input[type="submit"]:hover {
                background: #2c54e5b3;
                background: -moz-linear-gradient(top,  #2c54e5b3 0%,#4f6ee0b3 100%);
                background: -webkit-linear-gradient(top,  #2c54e5b3 0%,#4f6ee0b3 100%);
                background: -o-linear-gradient(top,  #2c54e5b3 0%,#4f6ee0b3 100%);
                background: -ms-linear-gradient(top,  #2c54e5b3 0%,#4f6ee0b3 100%);
                background: linear-gradient(top,  #2c54e5b3 0%,#4f6ee0b3 100%);
            }
            #content form div a {
                color: #004a80;
                float: right;
                font-size: 14px;
                margin-bottom: 5px;
                margin-right: 20px;
                margin-top: 12px;
                text-decoration: underline;
            }
            .button {
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.1) inset;
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,0.1) inset;
                -ms-box-shadow: 0 1px 2px rgba(0,0,0,0.1) inset;
                -o-box-shadow: 0 1px 2px rgba(0,0,0,0.1) inset;
                box-shadow: 0 1px 2px rgba(0,0,0,0.1) inset;
                -webkit-border-radius: 0 0 5px 5px;
                -moz-border-radius: 0 0 5px 5px;
                -o-border-radius: 0 0 5px 5px;
                -ms-border-radius: 0 0 5px 5px;
                border-radius: 0 0 5px 5px;
                border-top: 1px solid #CFD5D9;
                padding: 15px 0;
            }
            .button a {
                font-size: 16px;
                padding: 2px 0 2px 40px;
                text-decoration: none;
                -webkit-transition: all 0.3s ease;
                -moz-transition: all 0.3s ease;
                -ms-transition: all 0.3s ease;
                -o-transition: all 0.3s ease;
                transition: all 0.3s ease;
            }
            .button a:hover {
                background-position: 0 -135px;
                color: #00aeef;
            }
        </style>
    </head>
    <body>
        <div>
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    </header>
                        <div class="container">
                            <section id="content">
                                <form action="">
                                    <h1>Авторизация</h1>
                                    <div>
                                        <input type="text" placeholder="Email" required="" id="username" />
                                    </div>
                                    <div>
                                        <input type="password" placeholder="Пароль" required="" id="password" />
                                    </div>
                                    <div>
                                        <input type="submit" value="Войти" />
                                        <a href="#">Забыли пароль?</a>
                                        <a href="#">Зарегистрироваться</a>
                                    </div>
                                </form>
                            </section>
                        </div>
                </div>
            </div>
        </div>
    </body>
</html>
