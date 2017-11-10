@extends('template.pages.main')

@section('title')
Detalle  Préstamo
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
<h1>
    Detalle Préstamos 
    <small> </small>
</h1>
@endsection


@section('content')

@if(count($errors) >0)
<div class="alert alert-danger" role="alert">
    <ul>
        @foreach($errors->all() as $error)
        <li>
            {{ $error}}
        </li>
        @endforeach
    </ul>
</div>
@endif

<div class='form-group col-md-6'>
    {!! Form::label('SID_OFCI', 'Oficina solicitante ')!!}
    {!! Form::text('SID_OFCI', $prestamos->SID_OFCI, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'SID_OFCI', 'disabled'])!!}

</div>
<div class='form-group col-md-6'>
    {!! Form::label('NOM_SOLI', 'Funcionario que solicita')!!}
    {!! Form::text('NOM_SOLI', $prestamos->NOM_SOLI, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'NOM_SOLI', 'disabled'])!!}


</div>
<div class='form-group col-md-6'>
    {!! Form::label('DES_SOPO', 'Soporte')!!}
    {!! Form::text('DES_SOPO', $prestamos->DES_SOPO, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'DES_SOPO', 'disabled'])!!}
</div>
<div class='form-group col-md-6' >
    <label>Fecha entrega</label>
    <div class="input-group date">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="datepicker4" name="FEC_ENTR" value="{{$prestamos->FEC_ENTR}}" disabled>
    </div>
</div>

<table id='datainfo' class="table table-bordered table-hover">
    <thead>
        <th>Ítem</th>
        <th>Código</th>
        <th>Caja</th>
        <th>Carpeta</th>
        <th>Carpetas contenidas</th>
        <th>Tipo</th>
        <th>Observación</th>
        <th>Fecha solicitud</th>
    </thead>
<tbody>
    @if($detalles != null)
        @foreach($detalles as $d)
        <tr>
            <td> {{$d->SID_COD}}</td>
            <td> {{$d->COD_TRD}}</td>
            <td> {{$d->SID_CAJA}}</td>
            <td> {{$d->SID_CARP}}</td>
            <td> {{$d->SID_CONT}}</td>
            <td> {{$d->SID_TIPO}}</td>
            <td> {{$d->SID_OBSE}}</td>
            <td> {{$d->SID_OBSE}}</td>
            <td> {{$d->FEC_SOLI}}</td>
        </tr>
        @endforeach

    @endif
 
</tbody>
</table>




@endsection

@section('js')
<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">
$(function () {
$('#datainfo').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    dom: 'Bfrtip',
    "language": {
        "lengthMenu": "Mostrando _MENU_ registros por pagina",
        "zeroRecords": "Sin resultados",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtro desde _MAX_ total registros)",
        "search": "Buscar"
    }
});
});

</script>


@endsection
