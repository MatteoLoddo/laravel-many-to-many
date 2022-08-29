<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="{{ asset('./css/app.css') }}">

        
    </head>
    <body>
        <div id="app" class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ route('admin.index') }}">Admin</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel - PARTE PUBBLICA
                </div>
                @auth
                    <h2>utente-LOGGATO {{Auth::user()->name}}</h2>
                @endauth

                @guest
                <h2>utente NON-LOGGATO</h2>
                @endguest
                <a class="decoration-text-none" href="https://laravel.com/docs">ciao</a>
                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                </div>
            </div>
        </div>
        <script src="{{asset('js/frontend.js')}}"></script>
    </body>
</html>
