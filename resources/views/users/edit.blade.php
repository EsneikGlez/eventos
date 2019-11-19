@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Editar informacion de: {{$user->name}}
        </div>
        <div class="card-body">
            <div class="container">
                <form action="{{route('users.update',$user)}}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="name"></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label for="email"></label>
                        <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}">
                    </div>
                    <div class="form-group">
                        <button type="submit">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
