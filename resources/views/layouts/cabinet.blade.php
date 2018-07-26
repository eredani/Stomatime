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
      @include('layouts.script')
      <title>{{ config('app.name', 'StomaTime Cabinet') }}</title>
      <style>
         .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
         }


         .switch input {display:none;}


         .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
         }

         .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
         }

         input:checked + .slider {
            background-color: #2196F3;
         }

         input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
         }

         input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
         }


         .slider.round {
            border-radius: 34px;
         }

         .slider.round:before {
            border-radius: 50%;
         }
.vertical-menu {
    width: 200px;
    height:  50px;
    overflow-y: auto;
}

.vertical-menu a {
    background-color: #eee;
    color: black;
    display: block;
    padding: 12px;
    text-decoration: none;
}

.vertical-menu a:hover {
    background-color: #ccc;
}

.vertical-menu a.active {
    background-color: #4CAF50;
    color: white;
}
         .table td {
         text-align: center;   
         }
         .table { border-collapse: collapse; }
         .table th {
         text-align: center;   
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
      <div id="app">
         <nav class="navbar navbar-expand-md bg-dark fixed-top navbar-dark navbar-light">
            <div class="container-fluid">
               <a class="navbar-brand" href="{{ url('/') }}">
               StomaTime
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
                  <!-- Left Side Of Navbar -->
                  <ul class="navbar-nav mr-auto">
                     @guest
                     @else
                     <li>
                        <a class="nav-link" href="/cabinet">Acasă</a>
                     </li>
                     <li>
                        <a class="nav-link" href="{{ route('cabinet.config') }}">Configurare</a>
                     </li>
                     <li>
                        <a class="nav-link" href="{{ route('cabinet.setting') }}">Setări</a>
                     </li>
                     @endguest
                  </ul>
                  <!-- Right Side Of Navbar -->
                  <ul class="navbar-nav ml-auto">
                     <!-- Authentication Links -->
                     @if(!Auth::guard('cabinet')->check())
                     <li>
                        <a class="nav-link" href="{{ route('cabinet.login') }}">{{ __('Logare') }}</a>
                     </li>
                     <li>
                        <a class="nav-link" href="{{ route('cabinet.register') }}">{{ __('Înregistrare') }}</a>
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
                           v-pre="v-pre">
                        @if(Auth::user()->img_profile==null)
                        @else
                        <img src="{{Auth::user()->img_profile}}" style="width:32px; height:32px; border-radius:50%">
                        @endif  
                        {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                           <a
                              class="dropdown-item"
                              href="{{ route('cabinet.logout') }}"
                              onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                           {{ __('Logout') }}
                           </a>
                           <form
                              id="logout-form"
                              action="{{ route('cabinet.logout') }}"
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
         <br><br>
         <div class="container-fluid">
            <main class="py-4">
               @yield('content')
            </main>
         </div>
      </div>
   </body>
</html>