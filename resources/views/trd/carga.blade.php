@extends('template.pages.mainerror')

@section('title')
    Carga Retención Documental
@endsection


@section('name_aplication')
    <h1>
      	Carga Retención Documental
    </h1>
@endsection


@section('content')

			{!! Form::label('Des', 'Descargar formato CSV ')!!}
			<a href="{{ asset('formato/formatoTRD.csv')}}" download >Descargar</a>

<br/><br/>
	{!! Form::open(['route' => 'trd.cargartrd', 'method' => 'POST', 'files'=>true]) !!}

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
