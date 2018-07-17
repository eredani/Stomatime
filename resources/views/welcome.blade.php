<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>StomaTime</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/ico" href="http://stomatime.com/favicon.ico">
    <meta name="theme-color" content="#317EFB" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="{{ Seo::get('description') }}" /> 
    <link rel="preload" as="style" onload="this.rel='stylesheet'" href="plugins/slick/slick.css">
    <link rel="preload" as="style" onload="this.rel='stylesheet'" href="css/style.css">
    <link rel="preload" as="style" onload="this.rel='stylesheet'" href="plugins/slick/slick-theme.css">
    <link rel="preload" as="style" onload="this.rel='stylesheet'" href="{{ mix('css/app.css') }}">

    @include('laravel-seo::meta-facebook') 
    @include('laravel-seo::meta-twitter')    
</head>
<body>
    @include('laravel-seo::sd-organization') 
    @include('laravel-seo::sd-local-business') 
    @include('laravel-seo::sd-website') 
    @include('laravel-seo::sd-breadcrumblist')
    <div class="page-wrapper">
        <div id="htop"></div>           
        <section class="header-uper">
                <div class="container clearfix">
                    <div class="logo">
                        <figure>
                            <a href="/">
                                <img src="images/logo.png" alt="logo" width="150">
                            </a>
                        </figure>
                    </div>
                    <br>
                    <div class="right-side">
                        <ul class="contact-info">
                            @if(!Auth::guard('cabinet')->user())
                            <li class="item">
                                <div class="icon-box">
                                    <i class="fa fa-television"></i>
                                </div>
                                <strong>Cabinete</strong>
                                <br>
                                <a href="{{url('cabinet/login')}}">
                                    <span>Login</span>
                                </a>
                                <span> | </span>
                                <a href="{{url('cabinet/register')}}">
                                    <span>Register</span>
                                </a>
                            </li>
                            @else
                            <li class="item">
                                <div class="icon-box">
                                    <i class="fa fa-television"></i>
                                </div>
                                <strong>Cabinete</strong>
                                <br>
                                <a href="{{url('cabinet/')}}">
                                    <span>{{Auth::guard('cabinet')->user()->name}}</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                        <ul class="contact-info">
                            <li class="item">
                                <div class="icon-box">
                                    <i class="fa fa-envelope-o"></i>
                                </div>
                                <strong>Email</strong>
                                <br>
                                <a>
                                    <span>info@stomatime.com</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
        </section>
    </div>
    <nav class="navbar navbar-expand-md sticky-top navbar-light  navbar-laravel">
    <button
                        class="navbar-toggler"
                        type="button"
                        data-toggle="collapse"
                        data-target="#tog"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
            <div class="container">
                <div class="collapse navbar-collapse" id="tog">
                    <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Acasa</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#despre">Despre</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#oferte">Oferte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#aff">Afiliați</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @if (!Auth::guard('admin')->user() && !Auth::guard('web')->user())
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @else

                            @if(Auth::guard('web')->user())
                            <li class="nav-item">
                            <a class="nav-link"  href="{{ url('/home') }}">{{Auth::guard('web')->user()->name}}</a>
                            </li>
                            @endif  
                            @if(Auth::guard('admin')->user())
                            <li class="nav-item">
                            <a class="nav-link"  href="{{ url('/admin') }}">Staff</a>
                            </li>
                            @endif
                      
                        @endif
                    </ul>
                </div>
            </div>
        </nav>  
    <div id="secpart">
    </div>
    <script defer src="https://stomatime.com/js/app.js"></script>
    
    <script defer src="https://stomatime.com/plugins/slick/slick.min.js"></script>
    <script  defer src="https://stomatime.com/js/script.js"></script>
    
   </body>
</html>