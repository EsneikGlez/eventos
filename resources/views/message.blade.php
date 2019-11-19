@if(session('message'))
<div class="alert @if(session('code')=="error") alert-danger @endif alert-success alert-dismissible fade show" role="alert" style="width:400px;margin:auto">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>
        {{session('message')}}
    </strong>
</div>
<script type="application/javascript">
    $(".alert").alert();
</script>
@endif
