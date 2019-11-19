@if(auth()->user()->role->poder==3)
    <div class="container">
        <div class="card">
            <div class="card-header">
                Registrar Gasto
            </div>
            <div class="card-body">
                <form action="{{route('expenses.store')}}" method="POST">
                    @csrf
                    <input class="form-control" placeholder="concepto" name="concepto" type="text" required>
                    <input class="form-control" placeholder="monto" name="monto" type="number" required>
                    <input class="form-control" placeholder="fecha" name="fecha" type="date" required>
                    <button class="btn btn-success" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>fecha</th>
                </tr>
                </thead>
                <tbody>
                    @forelse(\App\Expense::all() as $expense)
                    <tr>
                        <td scope="row">{{$expense->concepto}}</td>
                        <td>{{$expense->monto}}</td>
                        <td>{{$expense->fecha}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td>No hay gastos</td>
                    </tr>
                    @endforelse
                </tbody>
        </table>
    </div>
@endif
