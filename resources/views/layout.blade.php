<!DOCTYPE html>
<html lang="{{ str_replace('_', '_', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SIGES</title>

        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
         
        <link reel="stylescheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">

        <style type="text/css">
            @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);
    
            body{
                margin: 0;
                font-size: .9rem;
                font-weight: 400;
                line-height: 1.6;
                color: #212529;
                text-align: left;
                background-color: #f5f8fa;
            }
            .navbar-laravel
            {
                box-shadow: 0 2px 4px rgba(0,0,0,.04);
            }
            .navbar-brand , .nav-link, .my-form, .login-form
            {
                font-family: Raleway, sans-serif;
            }
            .my-form
            {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }
            .my-form .row
            {
                margin-left: 0;
                margin-right: 0;
            }
            .login-form
            {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }
            .login-form .row
            {
                margin-left: 0;
                margin-right: 0;
            }
        </style>
    </head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light navbar-laravel" style="background-color: #01C4FA;">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="{{asset('/upload/andes.jpg')}}" width="80px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
       
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>-->
                    @else
                        @if (Auth::user()->rol == 'administrador')
                            <a class="nav-link" href="{{ route('analytics') }}">Analytics</a>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        </li>
                    @endguest
                </ul>
      
            </div>
        </div>
    </nav>

    <div id="app">
        
        @yield('content')
        @yield('footer_scripts')

    </div>

    <footer class="bg-light text-center text-lg-start">
        <strong>
            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: #01C4FA; color: #FFFFFF;">
                © 2022 Copyright -
                <a class="" href="https://mdbootstrap.com/">Los Andes</a>
            </div>
            <!-- Copyright -->
        </strong>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
<script src="{{mix('js/app.js')}}" type="text/javascript"></script>
@stack('other-scripts')
</html>