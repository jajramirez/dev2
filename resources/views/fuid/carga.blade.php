@extends('template.pages.mainerror')

@section('title')
    Carga FUID
@endsection


@section('name_aplication')
    <h1>
      	Carga FUID
    </h1>
@endsection


@section('content')

			{!! Form::label('Des', 'Descargar formato CSV ')!!}
			<a href="{{ asset('formato/formatoFuid.csv')}}" download >Descargar</a>

<br/><br/>
	{!! Form::open(['route' => 'home.store', 'method' => 'POST', 'files'=>true]) !!}

		<input type="text" value=";" name="separador" style="display:none"> 
		<div class='form-group'>
			{!! Form::label('url_recurso', 'Archivo')!!}
			<input type="file" name="url_recurso" required/>
		</div>

		<div class='form-group'> 
			{!! Form::submit('Cargar',['class' => 'btn btn-primary'] )!!}
		</div>

	{!! Form::close() !!}

@endsection


@section('js')

@endsection
