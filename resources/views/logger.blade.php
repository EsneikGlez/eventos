@if ($errors->any())
    @foreach ($errors->all() as $e)
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="width:400px;margin:auto">
          <strong>Parece que tienes un error: {{$e}}</strong>
        </div>
    @endforeach
@endif
