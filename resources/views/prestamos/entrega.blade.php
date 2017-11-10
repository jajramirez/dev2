@extends('template.pages.main')

@section('title')
Devolución  Préstamo
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
<h1>
    Devolución Préstamos 
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

    <input type="text" id="id" name="id" value="{{$id}}" style="display:none">

    <div class='form-group col-md-12' >
        <label>Fecha Devolución </label>
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="datepicker6"  name="FEC_DEV" value="">
        </div>
    </div>


    {!! Form::button('Registrar',['class' => 'btn btn-primary', 'id'=>'registrar'] )!!}


<hr/>
<div class='form-group col-md-12' >
    <label>Detalle Prestamo</label>
</div>
<hr/>


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



@endsection

@section('js')
<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">
    $('#datepicker6').datepicker({
    autoclose: true
    });


    $("#registrar").click(function () {
        var PostUri = "{{ route('prestamo.devolver')}}";
        var redirect = "{{ route('prestamo.index')}}";

        $.ajax({
            url: PostUri,
            type: 'post',
            data: {
                id: $("#id").val(),
                FEC_DEV: $("#datepicker6").val()
            },
            headers: {
                'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
            },
            success: function (data) {
                if(data != "error")
                {
                        urlb = "{{url('/')}}"; 
                        var url = urlb+"/documentos/devolucion"+data+".pdf";   
                        
                        window.open(url, "", "width=800,height=800");
                        window.location.replace(redirect);


                }

            }
        });




    });
</script>
@endsection
