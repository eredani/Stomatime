<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-85363773-2"></script>
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
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <title>{{ config('app.name', 'Stomatime') }}</title>
        <style>
            #cabinete {
                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                transition: 0.3s;
                width: 40%;
                border-radius: 5px;
            }
            #cabinete:hover {
                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            }
            #profile
            {
                border-radius: 50%;
            }
                    input[type="file"] {
                            display: none;
                        }
                        #send{display: none;}
                        .custom-file-upload {
                            border: 1px solid #ccc;
                            display: inline-block;
                            padding: 6px 12px;
                            cursor: pointer;
                        }
        </style>
    </head>
    <body> 
    <nav class="navbar navbar-expand-md bg-dark fixed-top navbar-dark navbar-laravel">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Stomatime') }}
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
                                <a class="nav-link" href="/home">Home</a>
                        </li>
                        <li>
                                <a class="nav-link" href="{{ route('programari') }}">Appointments</a>
                        </li>
                        <li>
                                <a class="nav-link" href="{{ route('setting') }}">Settings</a>
                        </li>
                        @endguest
                        </ul>
                        <ul class="navbar-nav ml-auto">

                            @guest
                            <li>
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @else
                            <li class="nav-item dropdown">
                                <a
                                    id="navbarDropdown"
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    role="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    v-pre="v-pre"
                                    style="position:relative; padding-left:50px;">
                                        @if(Auth::user()->img_profile==null)
                                        @else
                                        <img src="{{Storage::url(Auth::user()->img_profile)}}" style="width:32px; height:32px; position:absolute; top:10px; left:10px; border-radius:50%">
                                        @endif  
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a
                                        class="dropdown-item"
                                        href="{{ route('user.logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form
                                        id="logout-form"
                                        action="{{ route('user.logout') }}"
                                        method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
    <br>
    <br>
    <div id="app">
           
            <div class="container-fluid">
            <main class="py-4">
            
                @yield('content')
               
            </main>
             </div>
    </div>
    <script async type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </body>
</html>