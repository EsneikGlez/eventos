<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <title>Eventos</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
    </head>
    <body>
        @if (Route::has('login'))

            <nav class="navbar navbar-expand-lg navbar-light bg-light">

                    <div class="navbar-brand">
                        Aplicacion de Eventos
                    </div>
                    <div class="navbar-nav" style="margin-left:60%">
                        @auth
                            <div class="nav-item">
                                <a class="nav-link" href="{{ url('/home') }}">Inicio</a>
                            </div>
                        @else
                            <div class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Iniciar sesion</a>
                            </div>
                            @if (Route::has('register'))
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registro</a>
                                </div>
                            @endif
                        @endauth
                    </div>

            </nav>
        @endif
        @include('message')
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h1>Nuestros paquetes</h1>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th>Evento</th>
                                <th>Fecha</th>
                                <th>Responsable</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($packages as $p)
                                    @if($p->activo)
                                        <tr>
                                            <td scope="row">{{$p->descripcion}}</td>
                                            <td>${{$p->precio}}</td>
                                            <td>{{$p->event->tipo}}</td>
                                            <td>{{$p->event->fecha}}</td>
                                            <td>{{$p->event->gerente->email}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <h3>Fotos del evento</h3>
                                                <div class="row">
                                                        @forelse ($p->event->photo->all() as $photo)
                                                        <div class="col-auto">
                                                            <img src="{{env('APP_URL').$photo->path}}" style="width: 200px;height:200px">

                                                        </div>
                                                        @empty
                                                        <div class="col-auto">
                                                            <p>No hay fotos </p>
                                                        </div>
                                                        @endforelse

                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="4" scope="row">No hay paquetes</td>
                                    </tr>
                                @endforelse
                            </tbody>
                    </table>
                </div>
                {{$packages->links()}}
            </div>
        </div>
    </body>
</html>
