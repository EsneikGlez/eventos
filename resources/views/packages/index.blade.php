@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Paquetes registrados</h1>
            </div>
            <div class="card-body">
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Activo</th>
                            <th>Evento</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse ($packages as $p)
                                <tr>
                                    <td scope="row">{{$p->descripcion}}</td>
                                    <td>${{$p->precio}}</td>
                                    <td>{{$p->activo?'Si':'No'}}</td>
                                    <td>{{$p->event->tipo}}</td>
                                    <td>
                                        <ul>
                                            @if($p->activo)
                                                <li>
                                                    <a class="btn btn-warning" href="{{route('packages.edit',$p)}}">Editar</a>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="btn @if($p->activo) btn-danger  @else btn-success @endif" href="{{route('packages.toggle',$p)}}">{{$p->activo?'Desactivar':'Activar'}}</a>
                                            </li>
                                        </ul>
                                    </td>
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
@endsection
