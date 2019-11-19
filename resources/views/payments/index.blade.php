@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Abonos registrados</h1>
        </div>
        <div class="card-body">
            <table class="table table-striped table-inverse table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>Evento</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Recibido por</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $pay)
                            <tr>
                                <td scope="row">{{$pay->event->tipo}}</td>
                                <td>${{$pay->event->precio}}</td>
                                <td>{{$pay->fecha}}</td>
                                <td>{{$pay->monto}}</td>
                                <td>{{$pay->user->name}}</td>
                            </tr>
                            <tr>
                                @foreach($totals as $total)
                                    @if($pay->event->id == $total->event_id)
                                        <th colspan="4">Adeudo ${{$pay->event->precio - $total->total}}</th>
                                    @endif
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" scope="row">No hay usuarios</td>
                            </tr>
                        @endforelse
                    </tbody>
            </table>
        </div>
        {{$payments->links()}}
    </div>
</div>

@endsection
