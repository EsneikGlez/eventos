@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Mis eventos</h1>
        </div>
        <div class="card-body">
            {{$event->tipo}}<br>
            {{$event->fecha}}<br>
            {{$event->hora}}<br>
            {{$event->precio?'$'.$event->precio:'No asignado'}}<br>
            {{$event->confirmado?'Si':'No'}}<br>
        </div>
    </div>
</div>
@endsection
<style>
    li{
        list-style: none;
    }
</style>
