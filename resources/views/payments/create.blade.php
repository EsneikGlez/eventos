@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Abono a evento: {{$event->tipo}}
            </div>
            <div class="card-body">
                <div class="container">
                    @if(auth()->user()->role->poder==2 || auth()->user()->role->poder==3)
                        <form action="{{route('payments.store',$event)}}" method="POST">
                            @csrf
                                <div class="form-group">
                                    <label for="monto" class="col-sm-1-12 col-form-label">Monto</label>
                                    <div class="col-sm-1-12">
                                        <input type="number" class="form-control" name="monto" id="monto" placeholder="Abono al evento">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-success">Abonar</button>
                                    </div>
                                </div>
                        </form>
                    @else
                        <div>No puedes hacer abonos </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
