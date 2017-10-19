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
        Editar 
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

{!! Form::open(['route' => 'archivo.actualiza' , 'method' => 'POST'])!!}



	<div class='form-group'>
		{!! Form::label('NOM_ARCH', 'Archivo')!!}
		<input type="file" name="NOM_ARCH"  id="NOM_ARCH">
	</div>
	

	<div class='form-group'>
		{!! Form::label('FEC_ARCH', 'Fecha')!!}
		{!! Form::text('FEC_ARCH', $expe->FEC_ARCH, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('NUM_PAGI', 'Paginas')!!}
		{!! Form::text('NUM_PAGI', $expe->NUM_PAGI, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('NUM_TAMA', 'Tamaño (kilobyte)')!!}
		{!! Form::text('NUM_TAMA', $expe->NUM_TAMA, ['class' => 'form-control' , 'placeholder' => '', 'disabled', 'id'=>'NUM_TAMA'])!!}
	</div>


	<div class='form-group'>
		{!! Form::label('NOM_SOFT', 'Software')!!}
		{!! Form::text('NOM_SOFT', $expe->NOM_SOFT, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('NOM_VERS', 'Versión')!!}
		{!! Form::text('NOM_VERS', $expe->NOM_VERS, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('NOM_RESO', 'Resolución')!!}
		{!! Form::text('NOM_RESO', $expe->NOM_RESO, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('NOM_IDIO', 'Idiomas')!!}
		{!! Form::text('NOM_IDIO', $expe->NOM_IDIO, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>
	<input type="text" name="COD_EXPE" value="{{$expe->COD_EXPE}}" style="display:none">
	<input type="text" name="NUM_REGI" value="{{$expe->NUM_REGI}}" style="display:none">
	<input type="text" name="NUM_ARCH" value="{{$expe->NUM_ARCH}}" style="display:none">
	<input type="text" name="NOM_ARCH" value="{{$expe->NOM_ARCH}}" style="display:none">
	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>


	
	
	{!! Form::close() !!}

@endsection
