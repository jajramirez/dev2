@extends('template.pages.main')

@section('title')
Editar  Ítem
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
<h1>
    Editar Ítem
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
 <input type="text" name="proceso" value="E" style="display:none">
 <input type="text" name="item" value="{{$item}}" style="display:none">
<div class='form-group col-md-12'>
    {!! Form::label('TRD', 'Código TRD')!!}

    {!! Form::text('TRD', $datos['COD_TRD'], ['class' => 'form-control' , 'placeholder' => '', 'disabled', 'id' => 'TRD'])!!}
</div>

<div class="form-group col-md-4">
    <label>Oficina Productora</label>
    <select id='COD_ORGA' name='COD_ORGA' class="form-control select2" style="width: 100%;" required onchange="codigoTRD()">
        <option value="">Seleccione una opcion</option>
        @foreach($orgas as $orga)
          @if($datos['COD_ORGA'] == $orga->COD_ORGA  )
            <option selected value="{{$orga->COD_ORGA}}">{{$orga->NOM_ORGA}}</option>
          @else
            <option value="{{$orga->COD_ORGA}}">{{$orga->NOM_ORGA}}</option>
          @endif
        @endforeach
    </select>
</div>


<div class="form-group col-md-4">
    <label>Código Serie</label>
    <select name='COD_SERI' id='COD_SERI' class="form-control select2" style="width: 100%;" required onchange="cargarSubs()">
        <option value="">Seleccione una opcion</option>
        @foreach($series as $seri)
          @if($datos['COD_SERI'] == $seri->COD_SERI)
            <option selected value="{{$seri->COD_SERI}}">{{$seri->NOM_SERI}}</option>
          @else
            <option value="{{$seri->COD_SERI}}">{{$seri->NOM_SERI}}</option>
          @endif
        @endforeach
    </select>
</div>


      <div class='form-group col-md-4'>
          {!! Form::label('COD_SUBS', 'Sub Serie')!!}
          <input type="text" style="display:none" id="CODSUB" value="{{$datos['COD_SUBS']}}">
          <select id="COD_SUBS" name='COD_SUBS' class="form-control select2" style="width: 100%;" onchange="codigoTRD()">
                  <option value="">Seleccione una subserie</option>
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
        {!! Form::text('SID_CAJA', $datos['SID_CAJA'] , ['class' => 'form-control' , 'placeholder' => '', 'id'=>'SID_CAJA', 'required'])!!}  
    </div>
</div>
<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('SID_CARP', 'Carpeta')!!}
        {!! Form::text('SID_CARP', $datos['SID_CARP'], ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}          
    </div>
</div>
<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('SID_CONT', 'Carpetas Contenidas')!!}
        {!! Form::text('SID_CONT', $datos['SID_CONT'], ['class' => 'form-control' , 'placeholder' => ''])!!}          
    </div>
</div>  

<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('SID_TIPO', 'Tipo')!!}
        {!! Form::text('SID_TIPO', $datos['SID_TIPO'], ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}  
    </div>
</div>

<div class="col-md-4">
    <div class='form-group'>
        <label>Fecha solicitud</label>
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="datepicker" name="FEC_SOLI" required value="{{$datos['FEC_SOLI']}}">
        </div>          
    </div>
</div>

<div class="col-md-4">
    <div class='form-group'>
        {!! Form::label('SID_OBSE', 'Observaciones')!!}
        {!! Form::text('SID_OBSE', $datos['SID_OBSE'], ['class' => 'form-control' , 'placeholder' => ''])!!}
    </div>
</div>

<div class='form-group'> 
    {!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
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


                    window.onload=load;

                    function load()
                    {
                      cargarSubs();
                      caja();
                    }

                    function caja()
                    {
                        if($("#SID_CAJA").val() == "Caja Completa")
                        {
                          $("#SID_CAJA_C").prop( "checked", true );
                          $("#SID_CAJA").val("");
                          $("#SID_CAJA").attr('disabled', 'disabled');

                        }

                    }

                   function cargarSubs()
                   {
                       var cod_seri = $("#COD_SERI").val();
                       var cod_subs = $("#CODSUB").val();
                       var cod_subs = "135";
                       codigoTRD();
                       var PostUri = "{{ route('seris.buscarccd')}}";

                       $.ajax({
                           url: PostUri,
                           type: 'post',
                           data: {
                               cod_seri: cod_seri,
                               cod_subs: cod_subs
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
                   }

</script>


@endsection
