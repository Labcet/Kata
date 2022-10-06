<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            *{padding:0;margin:0;}html{font-size:16px;font-family:"Roboto";}.container{width:80%;height:100%;max-width:1350px;margin:0 auto;display:flex;align-items:center;}header{display:flex;background:#00CBFF;}header .menu-container{display:flex;justify-content:space-between;align-items:center;width:100%;}header .menu-container .logo-container{padding:30px 0;}header .menu-container nav ul{display:flex;list-style:none;align-items:center;padding-left:0;}header .menu-container nav ul li{padding:1rem;}header .menu-container nav ul li.login{padding:1rem 1.2rem;background-color:#013461;margin-left:1rem;border-radius:1px;height:6px;display:flex;align-items:center;transition:all ease 0.3s;}header .menu-container nav ul li.login:hover{background-color:#FFD000;transition:all ease 0.3s;}header .menu-container nav ul li.register{padding:1rem 1.2rem;background-color:#FF287B;margin-left:1rem;height:6px;display:flex;align-items:center;}header .menu-container nav ul li a{text-decoration:none;color:#fff;font-family:"Archivo Black";font-size:0.9rem;}section.banner-background{background:linear-gradient(100deg,#013461 65%,#FFD000 65%);height:calc( 100vh - 104px );position:relative;}section img.decorator1{position:absolute;width:6rem;left:3%;top:7%;z-index:1;}section img.decorator2{position:absolute;width:3rem;right:3%;bottom:7%;z-index:1;}section .content-container{display:flex;justify-content:space-between;}section .content-container .details{width:50%;}section .content-container .details >span{width:20%;height:5px;display:block;background-color:#FFD000;margin-bottom:-1rem;}section .content-container .details h1{font-family:"Archivo Black";font-size:3rem;color:#fff;margin-bottom:3rem;}section .content-container .details ul{list-style:none;padding-left:0;margin-bottom:3rem;}section .content-container .details ul li{font-size:1.2rem;color:#fff;margin-bottom:2rem;display:flex;align-items:center;}section .content-container .details ul li span{font-size:1.3rem;color:#fff;margin-bottom:0;margin-right:1rem;background:#FFD000;display:block;width:3rem;height:3rem;border-radius:50%;display:flex;align-items:center;justify-content:center;}section .content-container .details a{color:#fff;background-color:#FF287B;padding:0.5rem 1.5rem;text-decoration:none;font-family:"Archivo Black";transition:all ease 0.3s;}section .content-container .details a:hover{transition:all ease 0.3s;background-color:#FFD000;}section .content-container .image-container{width:50%;display:flex;align-items:center;}section .content-container .image-container img{width:40vw;}@media screen and (max-width:1601px){html{font-size:14px;}}@media screen and (max-width:1350px){html{font-size:12px;}}@media screen and (max-width:1024px){html{font-size:11px;}section .content-container .image-container img{width:43vw;}}@media screen and (max-width:768px){html{font-size:10px;}}@media screen and (max-width:480px){html{font-size:10px;}section .content-container{display:flex;justify-content:space-between;flex-direction:column;}section .content-container .details{width:100%;margin-bottom:4rem;}section .content-container .image-container{width:100%;justify-content:center;}section .content-container .image-container img{width:80vw;}section img.decorator1{position:absolute;width:3rem;left:70%;top:3%;}section img.decorator2{position:absolute;width:4rem;right:12%;bottom:3%;}}@media screen and (max-width:320px){.container{width:90%;}header .menu-container .logo-container{padding:15px 0;}header .menu-container .logo-container img{width:70px;}}
        </style>

        <link rel="stylesheet" type="text/css" href="">

    </head>
    <body class="antialiased">
        <header>
            <div class="container">
                <div class="menu-container">
                    <div class="logo-container">
                        <img src="{{ asset('upload/logo_web.png') }}" alt="Andesqa">
                    </div>
                    <nav>
                        <ul>
                        @if (Route::has('login'))
                            @auth
                            <li class="login"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            @else
                            <li class="login"><a href="{{ route('login') }}">Ingresar</a></li>
                            @endauth
                        @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <section class="banner-background">
            <img class="decorator1" src="{{ asset('upload/puntito.png') }}" alt="">
            <img class="decorator2" src="{{ asset('upload/puntito2.png') }}" alt="">
            <div class="container">
                <div class="content-container">
                    <div class="details">
                        <span></span>
                        <h1>Sistema de gestión de casos de Prueba Andes QA</h1>
                        <ul>
                            <li><span>1</span> Simple y minimalista</li>
                            <li><span>2</span>Rapido y de fácil uso</li>
                            <li><span>3</span>Lorem ipsum masguinume</li>
                        </ul>
                        <!--<a href="/login">Empezar</a>-->
                    </div>
                    <div class="image-container">
                        <img src="{{ asset('upload/kata-mockup.png') }}" alt="">
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
