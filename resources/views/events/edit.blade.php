@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Editar evento
            </div>
            <div class="card-body">
                <div class="container">
                    @if(auth()->user()->role->poder==1)
                        <form action="{{route('events.update',$event)}}" method="POST">
                            @method('put')
                            @csrf
                                @if(auth()->user()->role->poder==1)
                                    <div class="form-group">
                                        <label for="tipo" class="col-sm-1-12 col-form-label">Tipo</label>
                                        <div class="col-sm-1-12">
                                            <input type="text" class="form-control" name="tipo" id="tipo" placeholder="" value="{{$event->tipo}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha" class="col-sm-1-12 col-form-label">Fecha</label>
                                        <div class="col-sm-1-12">
                                            <input type="date" class="form-control" name="fecha" id="fecha" placeholder="" value="{{$event->fecha}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hora" class="col-sm-1-12 col-form-label">Hora</label>
                                        <div class="col-sm-1-12">
                                            <input type="time" class="form-control" name="hora" id="hora" placeholder="" value="{{$event->hora}}">
                                        </div>
                                    </div>
                                @elseif(auth()->user()->role->poder==3)
                                    <div class="form-group">
                                        <label for="precio" class="col-sm-1-12 col-form-label">Precio</label>
                                        <div class="col-sm-1-12">
                                            <input type="number" class="form-control" name="precio" id="precio" placeholder="" value="{{$event->precio}}">
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </div>
                                </div>
                        </form>
                    @else
                        <div>No puedes crear eventos </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
