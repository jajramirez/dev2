@extends('template.pages.main')

@section('title')
    Editar Usuario
@endsection


@section('name_aplication')
    <h1>
        Editar 
        <small> {{$usuario->NOM_USUA}}</small>
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

	{!! Form::open(['route' => ['usuarios.update', $usuario], 'method' => 'PUT'])!!}

	<div class='form-group'>
		{!! Form::label('NOM_USUA', 'Nombre')!!}
		{!! Form::text('NOM_USUA', $usuario->NOM_USUA, ['class' => 'form-control' , 'placeholder' => 'Nombre Usuario', 'required'])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('CON_USUA', 'Contraseña')!!}
		{!! Form::password('CON_USUA', ['class' => 'form-control' , 'placeholder' => '*******', 'required'])!!}
	</div>

	<div id="cursos" class='form-group' >
		{!! Form::label('IND_ESTA', 'Estado')!!}
		{!! Form::select('IND_ESTA', ['A'=>'Activado', 'D'=>'Desactivado'] , $usuario->IND_ESTA, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>

		<div class="form-group">
				{!! Form::label('COD_ROLE', 'ROL')!!}
				{!! Form::select('COD_ROLE', ['1'=>'Administrador', '2'=>'Operario', '3'=>'Consulta'] , $usuario->COD_ROLE, ['class' => 'form-control', 'placeholder' => 'Seleccione un rol', 'required'])!!}
     </div>

	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection
