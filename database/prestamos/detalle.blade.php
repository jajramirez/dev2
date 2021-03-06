@extends('template.pages.main')

@section('title')
Nuevo  Ítem
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
<h1>
    Crear Ítem
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

{!! Form::open(['route' => 'prestamo.prestamo' , 'method' => 'POST' ,'id' =>'createR'])!!}
 <input type="text" name="proceso" value="D" style="display:none">
<div class='form-group col-md-12'>
    {!! Form::label('TRD', 'Código TRD')!!}
    {!! Form::text('TRD', null, ['class' => 'form-control' , 'placeholder' => '', 'disabled', 'id' => 'TRD'])!!}
</div>

<div class="form-group col-md-4">
    <label>Oficina Productora</label>
    <select id='COD_ORGA' name='COD_ORGA' class="form-control select2" style="width: 100%;" required onchange="codigoTRD()">
        <option value="">Seleccione una opcion</option>
        @foreach($orgas as $orga)
        <option value="{{$orga->COD_ORGA}}">{{$orga->NOM_ORGA}}</option>
        @endforeach
    </select>
</div>


<div class="form-group col-md-4">
    <label>Código Serie</label>
    <select name='COD_SERI' id='COD_SERI' class="form-control select2" style="width: 100%;" required onchange="cargarSubs()">
        <option value="">Seleccione una opcion</option>
        @foreach($series as $seri)
        <option value="{{$seri->COD_SERI}}">{{$seri->NOM_SERI}}</option>
        @endforeach
    </select>
</div>


<div class='form-group col-md-4'>
    {!! Form::label('COD_SUBS', 'Sub Serie')!!}
    <select id="COD_SUBS" name='COD_SUBS' class="form-control select2" style="width: 100%;" onchange="codigoTRD()">
        <option value="">Seleccione una subserie</option>
    </select>
</div>

<div class='form-group col-md-4'>
    {!! Form::label('COD_TRD', 'TRD')!!}
    <select id="COD_TRD" name='COD_TRD' class="form-control select2" style="width: 100%;">
    </select>
</div>



<div class="col-md-4">
    <div class='form-group'>
        <div class="col-md-5">
            {!! Form::label('SID_CAJA', 'Caja      ')!!} 
        </div> 
        <div class="col-md-7">
            <input type="checkbox" id="SID_CAJA_C" name="SID_CAJA_C" value="Completa">Caja Completa
        </div>
        {!! Form::text('SID_CAJA', null, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'SID_CAJA', 'required'])!!}  
    </div>
</div>
<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('SID_CARP', 'Carpeta')!!}
        {!! Form::text('SID_CARP', null, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}          
    </div>
</div>
<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('SID_CONT', 'Carpetas Contenidas')!!}
        {!! Form::text('SID_CONT', null, ['class' => 'form-control' , 'placeholder' => ''])!!}          
    </div>
</div>  

<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('SID_TIPO', 'Tipo')!!}
        {!! Form::text('SID_TIPO', null, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}  
    </div>
</div>

<div class="col-md-4">
    <div class='form-group'>
        <label>Fecha solicitud</label>
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="datepicker" name="FEC_SOLI" required>
        </div>          
    </div>
</div>

<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('SID_OBSE', 'Observaciones')!!}
        {!! Form::text('SID_OBSE', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
    </div>
</div>

<div class='form-group'> 
    {!! Form::submit('Ingresar',['class' => 'btn btn-primary'] )!!}
</div>

{!! Form::close() !!}


@endsection

@section('js')
<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">
                   $(".select2").select2();
                   $('#datepicker').datepicker({
                       autoclose: true
                   });
                   $('#datepicker2').datepicker({
                       autoclose: true
                   });
                   $('#datepicker3').datepicker({
                       autoclose: true
                   });
                   $('#datepicker4').datepicker({
                       autoclose: true
                   });


                    $( "#SID_CAJA_C" ).on( "click", function() {
                      $("#SID_CAJA").val("");
                      var caja = $( "input:checked" ).val();
                      if(caja == "Completa")
                      {
                        $("#SID_CAJA").attr('disabled', 'disabled');
                        $("#SID_CAJA").removeAttr('required');
                      }
                      else
                      {
                         $("#SID_CAJA").removeAttr('disabled');
                         $("#SID_CAJA").attr('required', 'required');
                      }

                    });
                   function cargarSubs()
                   {
                       var cod_seri = $("#COD_SERI").val();
                       codigoTRD();
                       var PostUri = "{{ route('seris.buscarccd')}}";

                       $.ajax({
                           url: PostUri,
                           type: 'post',
                           data: {
                               cod_seri: cod_seri
                           },
                           headers: {
                               'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
                           },
                           success: function (data) {
                               var comilla = '"';
                               if (data != "<option value=" + comilla + comilla + ">Seleccione una subserie</option>")
                               {

                                   $("#COD_SUBS").attr('required', 'required');
                               } else
                               {
                                   $("#COD_SUBS").removeAttr('required');
                               }


                               $("#COD_SUBS").html(data);

                           }
                       });

                   }

                   function codigoTRD()
                   {

                       var oficina = $("#COD_ORGA").val();
                       var cod_seri = $("#COD_SERI").val();
                       if (cod_seri.length > 0)
                       {
                           cod_seri = '.' + $("#COD_SERI").val();

                       }

                       var cod_subs = $("#COD_SUBS").val();
                       if (cod_subs.length > 0)
                       {
                           cod_subs = '.' + $("#COD_SUBS").val();

                       }
                       var trd = oficina + cod_seri + cod_subs;
                       $("#TRD").val(trd);

                       var PostUri = "{{ route('trd.buscarfuid')}}";
                       $.ajax({
                           url: PostUri,
                           type: 'post',
                           data: {
                               COD_TRD: trd
                           },
                           headers: {
                               'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
                           },
                           success: function (data) {
                           

                           }
                       });

                   }

</script>


@endsection
