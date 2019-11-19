@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Mis eventos</h1>
        </div>
        <div class="card-body">
            <table class="table table-striped table-inverse table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Precio</th>
                        <th>Confirmado</th>
                        <th>Fotos</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $e)
                            @if(auth()->user()->role->poder==2 && $e->confirmado)
                                <tr>
                                    <td scope="row">{{$e->tipo}}</td>
                                    <td>{{$e->fecha}}</td>
                                    <td>{{$e->hora}}</td>
                                    <td>{{$e->precio?'$'.$e->precio:'No asignado'}}</td>
                                    <td>{{$e->confirmado?'Si':'No'}}</td>
                                    <td>
                                        <ul>
                                            @foreach ($e->photo->all() as $photo)
                                                <li>
                                                    <div class="btn-group btn-group-sm">
                                                        <a class="btn btn-primary" target="_blank" href="{{env('APP_URL').$photo->path}}">Foto({{$loop->iteration}})</a>
                                                        <form action="{{route('photos.destroy',$photo)}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger" type="submit">x</button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                <form action="{{route('events.photos',$e)}}" method="POST" enctype="multipart/form-data">
                                                    @method('put')
                                                    @csrf
                                                    <div class="form-control-file">
                                                        <input class="btn btn-secondery" type="file" draggable="true" name="foto" id="foto" required>
                                                        <button class="btn btn-primary" type="submit">Subir foto</button>
                                                    </div>
                                                </form>
                                            </li>
                                            <li>
                                                <a class="btn btn-success" href="{{route('events.show',$e)}}">Ver</a>
                                            </li>
                                            <li><a class="btn btn-warning" href="{{route('payments.create',$e)}}">Abonar</a></li>
                                        </ul>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td scope="row">{{$e->tipo}}</td>
                                    <td>{{$e->fecha}}</td>
                                    <td>{{$e->hora}}</td>
                                    <td>{{$e->precio?'$'.$e->precio:'No asignado'}}</td>
                                    <td>{{$e->confirmado?'Si':'No'}}</td>
                                    <td>
                                        <ul>
                                            @foreach ($e->photo->all() as $photo)
                                            <li>
                                                <div class="btn-group-sm">
                                                    <a class="btn btn-primary" target="_blank" href="{{env('APP_URL').$photo->path}}">Foto({{$loop->iteration}})</a>
                                                    <form action="{{route('photos.destroy',$photo)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit">x</button>
                                                    </form>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                <form action="{{route('events.photos',$e)}}" method="POST" enctype="multipart/form-data">
                                                    @method('put')
                                                    @csrf
                                                    <div class="form-group">
                                                    <input type="file" class="form-control-file" draggable="true" name="foto" id="foto" required>
                                                    <button class="btn btn-primary form-control" type="submit">Subir foto</button>
                                                    </div>
                                                </form>
                                            </li>
                                            <li>
                                                <a class="btn btn-primary" href="{{route('events.show',$e)}}">Ver</a>
                                            </li>
                                            @if((auth()->user()->role->poder==3 || auth()->user()->role->poder==1) && !$e->confirmado)
                                                <li>
                                                    <a class="btn btn-dark" href="{{route('events.edit',$e)}}">Editar</a>
                                                </li>
                                                <li>
                                                    <form action="{{route('events.destroy',$e)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if((auth()->user()->role->poder==3 || auth()->user()->role->poder==2) && $e->confirmado)
                                                <li><a class="btn btn-warning" href="{{route('payments.create',$e)}}">Abonar</a></li>
                                            @endif
                                            @if(auth()->user()->role->poder==3 && !$e->confirmado)
                                                <li>
                                                    <a class="btn btn-success" href="{{route('events.confirm',$e)}}">confirmar</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5">No hay eventos</td>
                            </tr>
                        @endforelse
                    </tbody>
            </table>
        </div>
    </div>
    {{$events->links()}}
</div>

@endsection
<style>
    li{
        list-style: none;
    }
</style>
