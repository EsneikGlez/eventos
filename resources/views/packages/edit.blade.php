@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Crear un paquete
            </div>
            <div class="card-body">
                <div class="container">
                    @if(auth()->user()->role->poder==3)
                        <form action="{{route('packages.update',$package)}}" method="POST">
                            @csrf
                            @method('put')
                                <div class="form-group">
                                    <label for="descripcion" class="col-sm-1-12 col-form-label">descripcion</label>
                                    <div class="col-sm-1-12">
                                        <input type="text" class="form-control" name="descripcion" id="descripcion" value="{{$package->descripcion}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="precio" class="col-sm-1-12 col-form-label">Precio</label>
                                    <div class="col-sm-1-12">
                                        <input type="number" class="form-control" name="precio" id="precio" value="{{$package->precio}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Crear</button>
                                    </div>
                                </div>
                        </form>
                    @else
                        <div>No puedes crear paquetes </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
