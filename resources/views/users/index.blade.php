@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Usuarios registrados</h1>
            </div>
            <div class="card-body">
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td scope="row">{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role->nombre}}</td>
                                    <th>
                                        @if(auth()->user()->role->poder==3)
                                            <ul>
                                                <li>
                                                    <a class="btn btn-warning" href="{{route('users.edit',$user)}}">Editar</a>
                                                </li>
                                                <li>
                                                    <form action="{{route('users.destroy',$user)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{route('users.password',$user)}}" method="POST">
                                                        @csrf
                                                        @method('put')
                                                        <div class="form-group">
                                                          <label for="password">Restablecer contraseña</label>
                                                          <input type="password" class="form-control" name="password" id="password" placeholder="nueva contraseña">
                                                          <button type="submit">Restablecer</button>
                                                        </div>
                                                    </form>
                                                </li>
                                            </ul>
                                        @endif
                                    </th>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" scope="row">No hay usuarios</td>
                                </tr>
                            @endforelse
                        </tbody>
                </table>
            </div>
            {{$users->links()}}
        </div>
    </div>
@endsection
