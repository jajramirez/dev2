@extends('template.pages.main')

@section('title')
    Nuevo FUID
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Crear FUID
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
	{!! Form::open(['route' => 'fuid.store' , 'method' => 'POST'])!!}
		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
			     	<label>Codigo Estructura</label>
			        <select name='COD_ORGA' class="form-control select2" style="width: 100%;" required>
			        	<option value="">Seleccione una Oficina Productora</option>
			          	@foreach($orgas as $orga)
							<option value="{{$orga->COD_ORGA}}">{{$orga->NOM_ORGA}}</option>
			            @endforeach
			        </select>
			    </div>
			</div>

			<div class="col-xs-6">
				<div class="form-group">
			     	<label>Codigo CCD</label>
			     	<div class="row">
			     		<div class="col-xs-6">
					        <select id="COD_SERI" name='COD_SERI' class="form-control select2" style="width: 100%;" required onchange="cargarSubs()">>
					        	<option value="">Seleccione una serie</option>
					          	@foreach($seris as $seri)
									<option value="{{$seri->COD_SERI}}">{{$seri->NOM_SERI}}</option>
					            @endforeach
					        </select>
				    	</div>
						<div class="col-xs-6">
					        <select id="COD_SUBS" name='COD_SUBS' class="form-control select2" style="width: 100%;" >
					        	<option value="">Seleccione una subserie</option>
					          	<!--@foreach($ccds as $ccd)
									<option value="{{$ccd->COD_SUBS}}">{{$ccd->NOM_SUBS}}</option>
					            @endforeach
					        	-->
					        </select>
				    	</div>
				       </div>

			    </div>
			</div>

		</div>

		<div class="row">
			<div class="col-xs-6">
				<div class='form-group'>
						{!! Form::label('FEC_INIC', 'Fecha Inicial')!!}
						
						<div class="input-group date">
	                        <div class="input-group-addon">
	                            <i class="fa fa-calendar"></i>
	                        </div>
	                        <input type="text" class="form-control pull-right" id="datepicker" name="FEC_INIC">
                    	</div>
				</div>
			</div>
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('FEC_FINA', 'Fecha Final')!!}
						<div class="input-group date">
	                        <div class="input-group-addon">
	                            <i class="fa fa-calendar"></i>
	                        </div>
	                        <input type="text" class="form-control pull-right" id="datepicker2" name="FEC_FINA">
                    	</div>
					</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('NUM_CAJA', 'Caja')!!}
						{!! Form::text('NUM_CAJA', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('NUM_CARP', 'Carpeta')!!}
						{!! Form::text('NUM_CARP', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('NUM_TOMO', 'Tomo')!!}
						{!! Form::text('NUM_TOMO', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('NUM_INTE', 'Otro')!!}
						{!! Form::text('NUM_INTE', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('NUM_FOLI', 'No. FOLIOS')!!}
						{!! Form::text('NUM_FOLI', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('GEN_SOPO', 'Soporte')!!}
						{!! Form::text('GEN_SOPO', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('OBS_GEN1', 'Notas')!!}
						{!! Form::text('OBS_GEN1', null, ['class' => 'form-control' , 'placeholder' => '' ])!!}
					</div>
			</div>
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('FRE_CONS', 'Frecuencia Consulta')!!}
						{!! Form::text('FRE_CONS', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('NOM_ARCH', 'Archivo')!!}
						{!! Form::File('NOM_ARCH')!!}
					</div>
			</div>

			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('NOM_ASUN', 'Asunto')!!}
						{!! Form::text('NOM_ASUN', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
					</div>
			</div>
			
		</div>

		<div class="row">
			<div class="col-xs-6">
					<div class='form-group'>
						{!! Form::label('CON_BODE', 'Consecutivo Bodega')!!}
						{!! Form::text('CON_BODE', null, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
					</div>
			</div>
			
		</div>


		<input type="text" name="busqueda" value="{{$busqueda}}" style="display:none">


	<div class="row">
		<div class="col-xs-12">
			<div class='form-group'> 
				{!! Form::submit('Registrar',['class' => 'btn btn-primary'] )!!}
			</div>
		</div>
	</div>

	{!! Form::close() !!}


@endsection

@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>

	
	 $('#NOM_ARCH').change(function (){
     var sizeByte = this.files[0].size;
     var siezekiloByte = parseInt(sizeByte / 1024);
     $("#NUM_TAMA").val(siezekiloByte);
     $("#NUM_TAMA2").val(siezekiloByte);
     
 	});

	$('#datepicker').datepicker({
		autoclose: true
	});
	$('#datepicker2').datepicker({
		autoclose: true
	});
	
	$(".select2").select2();


	function cargarSubs()
	{
		var cod_seri = $("#COD_SERI").val();
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
			    if(data != "<option value="+comilla+comilla+">Seleccione una subserie</option>")
			    {
			    	$("#COD_SUBS").attr('required', 'required');
			    }
			    else
			    {
			    	$("#COD_SUBS").removeAttr('required');
			    }

		        $("#COD_SUBS").html(data);
		    }
		});

	}




	</script>
@endsection
