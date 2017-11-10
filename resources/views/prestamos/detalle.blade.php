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
 <div class="col-md-12">
    <div class='form-group'>
    
        {!! Form::label('CON_BODE', 'No. de Caja')!!} 
        
        {!! Form::text('CON_BODE', null, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'CON_BODE', 'required', 'onblur'=> 'BuscarCajas()'])!!}  
    </div>
</div>


<div class="col-md-12">
    <div class='form-group'>
        <div class="col-md-5">
            {!! Form::label('SID_CAJA', 'Carpeta      ')!!} 
        </div> 
        <div class="col-md-7">
            <input type="checkbox" id="SID_CAJA_C" name="SID_CAJA_C" value="Completa">Caja Completa
        </div>
          <select name="cajas[]" id="cajas" data-placeholder="Seleccione la caja" multiple="multiple" class="form-control select2" style="width: 100%;">
         
         </select>
   




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

                    $( "#SID_CAJA_C" ).on( "click", function() {
                      $("#SID_CAJA").val("");
                      var caja = $( "input:checked" ).val();
                      if(caja == "Completa")
                      {
                        $("#cajas").attr('disabled', 'disabled');
                        $("#cajas").removeAttr('required');
                      }
                      else
                      {
                         $("#cajas").removeAttr('disabled');
                         $("#cajas").attr('required', 'required');
                      }

                    });

                  function BuscarCajas()
                  {
                       var CON_BODE = $("#CON_BODE").val();
                       var PostUri = "{{ route('fuid.datos')}}";

                       $.ajax({
                           url: PostUri,
                           type: 'post',
                           data: {
                               CON_BODE: CON_BODE
                           },
                           headers: {
                               'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
                           },
                           success: function (data) {
                              $("#cajas").html(data);
                              var types = JSON.parse(data);
                              for(x=0; x<types.length; x++) {
                                    $("#cajas").append("<option value='"+types[x].NUM_CARP+"'>"+types[x].NUM_CARP+"</option>");
                              }

                           }
                       });

                  }
</script>


@endsection
