<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'QA') }}</title>

   

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/prismjs-themes/prism.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                {{-- route par vue router --}}
                <router-link class="navbar-brand" :to="{ name: 'home'}">
                    {{ config('app.name', 'QA') }}
                </router-link>
                {{-- <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'QA') }}
                </a> --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <router-link class="nav-item" tag="li" :to="{ name : 'questions'}"><a class="nav-link">Questions</a></router-link>
                        <router-link class="nav-item" tag="li" :to="{ name : 'my-posts'}"><a class="nav-link">My Posts</a></router-link>
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            {{-- Pour faire des transitions entre chaque page on spécifie avec le name et le mode --}}
            <transition name="fade" mode="out-in">
                <router-view></router-view>
            </transition>
        </main>
    </div>
    <script>
        // ds app js et json c'est laravel
        window.Auth = @json([
            'signedIn' => Auth::check(),
            'user' => Auth::user()
        ]);
        // voir ds bootstrap.js
        window.Urls = @json([
            'api' => url('/api'),
            'login' => route('login')
        ]);
    </script>
     <!-- Scripts j'ai enlevé defer car je mets le fichier script en bas-->
     <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
