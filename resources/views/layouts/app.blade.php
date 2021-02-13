<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('style')

    <style>
        .centered{
            width:100%;
            height:100%;
            min-width:400px;
            min-height:400px;
            position:absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            background:#000;
            z-index: 99999;
            filter: blur(10px) contrast(20);
        }
        .blob-1,.blob-2{
            width:70px;
            height:70px;
            position:absolute;
            background:#fff;
            border-radius:50%;
            top:50%;left:50%;
            transform:translate(-50%,-50%);
        }
        .blob-1{
            left:20%;
            animation:osc-l 2.5s ease infinite;
        }
        .blob-2{
            left:80%;
            animation:osc-r 2.5s ease infinite;
            background:#0ff;
        }
        @keyframes osc-l{
            0%{left:20%;}
            50%{left:50%;}
            100%{left:20%;}
        }
        @keyframes osc-r{
            0%{left:80%;}
            50%{left:50%;}
            100%{left:80%;}
        }
    </style>

</head>
<body>
    <div class="centered">
        <div class="blob-1"></div>
        <div class="blob-2"></div>
    </div>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @foreach ($menus as $i => $item)
                            @if (count($item->childs))
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown-{{$i}}" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $item->title }}
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown-{{$i}}">
                                        @foreach ($item->childs as $child)
                                            <a class="dropdown-item" href="{{ $child->link_url ?? '#' }}">
                                                {{ $child->title ?? '' }}
                                            </a>
                                        @endforeach
                                    </div>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ $item->link_url ?? '#' }}">{{ $item->title ?? '' }}</a>
                                </li>
                            @endif
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('menu.index') }}">{{ __('Menu') }}</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    @stack('script')

    <script>
        window.onload = () => {
            $('.centered').css('display', 'none');
        }
    </script>
</body>
</html>
