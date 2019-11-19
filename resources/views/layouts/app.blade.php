<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
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

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Iniciar sesion</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrarme</a>
                                </li>
                            @endif
                        @else
                            @if(auth()->user()->role->poder==3 || auth()->user()->role->poder==2)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('payments.index') }}">
                                        Abonos
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownEvent" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Eventos
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('events.index') }}">
                                        Todos
                                    </a>
                                    <a class="dropdown-item" href="{{ route('events.create') }}">
                                        Crear
                                    </a>
                                </div>
                            </li>
                            @if(auth()->user()->role->poder==3)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownEvent" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Paquetes
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('packages.index') }}">
                                            Todos
                                        </a>
                                        <a class="dropdown-item" href="{{ route('packages.create') }}">
                                            Crear
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.index') }}">
                                        Usuarios
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownEvent" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Nofificaciones <span class="badge badge-danger">{{count(\App\Event::where('confirmado','=',false)->get())}}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownEvent" style="height:300px; overflow-y:auto; width:300px">
                                        @forelse (\App\Event::where('confirmado','=',false)->get() as $event)
                                            <div class="card">
                                                <div class="card-header">
                                                    Evento: {{$event->tipo}}
                                                </div>
                                                <div class="card-body">
                                                    Fecha:{{$event->fecha}}
                                                    Hora:{{$event->hora}}
                                                    <form action="{{route('events.update',$event)}}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input class="form-control" type="number" name="precio" placeholder="Precio">
                                                        <button class="btn btn-success" type="submit">Asignar precio</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @empty
                                            <p>No hay eventos sin confirmar</p>
                                        @endforelse
                                    </div>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <div class="dropdown-item">
                                        <form action="{{route('users.password',auth()->user())}}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="form-group">
                                                <label for="password">Restablecer contraseña</label>
                                                <input type="password" class="form-control" name="password" id="password" placeholder="nueva contraseña">
                                                <button type="submit">Restablecer</button>
                                            </div>
                                        </form>
                                    </div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       Cerrar sesion
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
            @include('message')
            @yield('content')
            @include('logger')
        </main>
    </div>
</body>
</html>
