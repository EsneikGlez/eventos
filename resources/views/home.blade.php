@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">Bienvenido al sistema</div>

            <div class="card-body">
                Nos complace verte de vuelta, {{auth()->user()->name}}
            </div>
        </div>
    </div>
</div>
@include('expenses')
@endsection
