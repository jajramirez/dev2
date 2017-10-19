@extends('template.pages.main')

@section('title')
    Editar
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
	<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Editar Expediente
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

	{!! Form::open(['route' => 'expedientes.actualiza' , 'method' => 'POST'])!!}
	
	<div class="form-group">
     	<label>Tipo Documento</label>
        <select name='TIP_DOCU1' class="form-control select2" style="width: 100%;" required disabled>
            <option value="">Seleccione una opcion</option>
          	<option value="CC" {{$data[0]}}>Cédula de Ciudadanía</option>
			<option value="CE" {{$data[1]}}>Cédula de Extranjería</option>
			<option value="RC" {{$data[2]}}>Registro civil</option>
			<option value="TI" {{$data[3]}}>Tarjeta de identidad</option>
			<option value="NIT" {{$data[4]}}>NIT para personas jurídicas</option> 
        </select>
    </div>



	<div class='form-group'>
		{!! Form::label('NUM_DOCU1', 'Numero Documento')!!}
		{!! Form::text('NUM_DOCU1', $expe->NUM_DOCU, ['class' => 'form-control' , 'placeholder' => '', 'disabled'])!!}
	</div>

	<div class='form-group' >
		{!! Form::label('PRI_NOMB', 'Primer Nombre')!!}
		{!! Form::text('PRI_NOMB', $expe->PRI_NOMB, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>	
	<div class='form-group' >
		{!! Form::label('SEG_NOMB', 'Segundo Nombre')!!}
		{!! Form::text('SEG_NOMB', $expe->SEG_NOMB, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>	
	<div class='form-group' >
		{!! Form::label('PRI_APEL', 'Primer Apellido')!!}
		{!! Form::text('PRI_APEL', $expe->PRI_APEL, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>	
	<div class='form-group' >
		{!! Form::label('SEG_APEL', 'Segundo Apellido')!!}
		{!! Form::text('SEG_APEL', $expe->SEG_APEL, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>
	<input type="text" name="COD_EXPE" value="{{$expe->COD_EXPE}}" style= "display:none;">
	<input type="text" name="TIP_DOCU" value="{{$expe->TIP_DOCU}}" style= "display:none;">
	<input type="text" name="NUM_DOCU" value="{{$expe->NUM_DOCU}}" style= "display:none;">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">	

	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection


@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script type="text/javascript">
		  $(".select2").select2();
	</script>
@endsection