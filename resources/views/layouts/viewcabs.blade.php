<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-85363773-2');
        </script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Stomatime') }}</title>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">   
    </head>
    <body>  
        <nav class="navbar navbar-expand-md  bg-dark fixed-top navbar-dark navbar-laravel">
            <div class="container-fluid">
               <a class="navbar-brand" href="{!! route('view.cabs', ['id'=>$info->id]) !!}">
               {!! $info->name!!}
               </a>
               <button
                  class="navbar-toggler"
                  type="button"
                  data-toggle="collapse"
                  data-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent"
                  aria-expanded="false"
                  aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                     @guest
                     @else
                     <li>
                        <a class="nav-link" href="{!! route('view.cabs.serv', ['id'=>$info->id]) !!}">Tarife</a>
                     </li>
                     @endguest
                  </ul>
                  <ul class="navbar-nav ml-auto">
                     <li>
                        <a class="nav-link" href="/home">{{ __('Acasă') }}</a>
                     </li>
                  </ul>
               </div>
            </div>
         </nav>
         <br>
    <div class="container-fluid">
    <main class="py-4">
               @yield('content')
    </main>
    </div>
        
   
        <script async type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </body>
</html>