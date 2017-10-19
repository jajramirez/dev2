@extends('template.pages.main')

@section('title')
    Editar FUID
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Editar FUID
        <small> </small>
    </h1>
@endsection


@section('content')

<div class="row">
    <div class="col-xs-12">
        

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

		{!! Form::open(['route' => 'fuid.actualiza' , 'method' => 'POST'])!!}
			

			<div class="row">
				<div class="col-xs-12">
						<div class='form-group'>
							{!! Form::label('NUM_REGI', 'Número Registro')!!}
							{!! Form::text('NUM_REGI', $fuid->NUM_REGI, ['class' => 'form-control' , 'placeholder' => '', 'disabled'])!!}
						</div>
				</div>

				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('COD_ORGA', 'Código Estructura')!!}
							{!! Form::text('COD_ORGA', $fuid->COD_ORGA, ['class' => 'form-control' , 'placeholder' => '', 'disabled'])!!}
						</div>
				</div>
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('COD_CCD', 'Código CCD')!!}
							{!! Form::text('COD_CCD', $fuid->COD_CCD, ['class' => 'form-control' , 'placeholder' => '', 'disabled'])!!}
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
		                        <input type="text" value="{{$fuid->FEC_INIC}}" class="form-control pull-right" id="datepicker" name="FEC_INIC">
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
		                        <input type="text"value="{{$fuid->FEC_FINA}}" class="form-control pull-right" id="datepicker2" name="FEC_FINA">
	                    	</div>
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('NUM_CAJA', 'Caja')!!}
							{!! Form::text('NUM_CAJA', $fuid->NUM_CAJA, ['class' => 'form-control'  , 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
						</div>
				</div>
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('NUM_CARP', 'Carpeta')!!}
							{!! Form::text('NUM_CARP', $fuid->NUM_CARP, ['class' => 'form-control' , 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números' ])!!}
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('NUM_TOMO', 'Tomo')!!}
							{!! Form::text('NUM_TOMO', $fuid->NUM_TOMO, ['class' => 'form-control' , 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
						</div>
				</div>
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('NUM_INTE', 'Otro')!!}
							{!! Form::text('NUM_INTE', $fuid->NUM_INTE, ['class' => 'form-control', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('NUM_FOLI', 'No. FOLIOS')!!}
							{!! Form::text('NUM_FOLI', $fuid->NUM_FOLI, ['class' => 'form-control' , 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
						</div>
				</div>
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('GEN_SOPO', 'Soporte')!!}
							{!! Form::text('GEN_SOPO', null, ['class' => 'form-control' , 'placeholder' => '' ])!!}
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('OBS_GEN1', 'Notas')!!}
							{!! Form::text('OBS_GEN1', $fuid->OBS_GEN1, ['class' => 'form-control' , 'placeholder' => ''])!!}
						</div>
				</div>
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('FRE_CONS', 'Frecuencia Consulta')!!}
							{!! Form::text('FRE_CONS', $fuid->FRE_CONS, ['class' => 'form-control' , 'placeholder' => ''])!!}
						</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('NOM_ARCH', 'Archivo')!!}
							{!! Form::File('NOM_ARCH')!!}
							<input type="text" name='nombrearchivo' value="{{$fuid->NOM_ARCH}}" style="display:none"/>
						</div>
				</div>

				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('NOM_ASUN', 'Asunto')!!}
							{!! Form::text('NOM_ASUN', $fuid->NOM_ASUN, ['class' => 'form-control' , 'placeholder' => ''])!!}
						</div>
				</div>
				
			</div>

				<div class="row">
				<div class="col-xs-6">
						<div class='form-group'>
							{!! Form::label('CON_BODE', 'Consecutivo Bodega')!!}
							{!! Form::text('CON_BODE', $fuid->CON_BODE, ['class' => 'form-control' , 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
						</div>
				</div>
				
			</div>



			<input type="text" name="COD_ENTI" value="{{$fuid->COD_ENTI}}" style="display:none">
			<input type="text" name="NUM_REGI" value="{{$fuid->NUM_REGI}}" style="display:none">
			<input type="text" name="COD_TRD" value="{{$fuid->COD_TRD}}" style="display:none">

			<div class="row">
				<div class="col-xs-12">
					<div class='form-group'> 
						{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
					</div>
				</div>
			</div>

		{!! Form::close() !!}

</div>

</div>

@endsection

@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>

	$('#datepicker').datepicker({
		autoclose: true
	});
	$('#datepicker2').datepicker({
		autoclose: true
	});
	
	$(".select2").select2();
	</script>
@endsection
