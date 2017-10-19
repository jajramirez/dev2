@extends('template.pages.main')

@section('title')
    Nuevo Usuario
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
@endsection

@section('name_aplication')
    <h1>
        Crear 
        <small> Usuario</small>
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

<!-- ['route' => 'admin.users.store', 'method' => 'POST']-->
	{!! Form::open(['route' => 'usuarios.store', 'method' => 'POST']) !!}
	<div class='form-group'>
		{!! Form::label('NOM_USUA', 'Nombre')!!}
		{!! Form::text('NOM_USUA', null, ['class' => 'form-control' , 'placeholder' => 'Nombre Usuario', 'required'])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('CON_USUA', 'Contraseña')!!}
		{!! Form::password('CON_USUA', ['class' => 'form-control' , 'placeholder' => '*******', 'required'])!!}
	</div>

	<div id="cursos" class='form-group' >
		{!! Form::label('IND_ESTA', 'Estado')!!}
		{!! Form::select('IND_ESTA', ['A'=>'Activado', 'D'=>'Desactivado'] , null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>

	<div class="form-group">
     	   <label>ROL</label>
            <select name='COD_ROLE' class="form-control select2" style="width: 100%;" required>
					<option value="" selected="selected">Seleccione un rol</option>
					<option value="1">Administrador</option>
					<option value="2">Operario</option>
					<option value="3">Consutla</option>
            </select>
     </div>

	<div class='form-group'> 
		{!! Form::submit('Registrar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection

@section('js')

@endsection