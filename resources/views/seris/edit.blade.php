@extends('template.pages.main')

@section('title')
    Editar Serie
@endsection


@section('name_aplication')
    <h1>
        Editar Serie 
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
	{!! Form::open(['route' => 'seris.actualizar' , 'method' => 'POST'])!!}


	<div class='form-group'>
		{!! Form::label('COD_SERI2', 'Código')!!}
		{!! Form::text('COD_SERI', $seri->COD_SERI, ['class' => 'form-control' , 'placeholder' => '', 'required', 'disabled'])!!}
	</div>

	<input type="text" name="COD_ENTI" value="{{$seri->COD_ENTI}}" style="display:none"> 
	<input type="text" name="COD_SERI" value="{{$seri->COD_SERI}}" style="display:none"> 


	<div class='form-group'>
		{!! Form::label('NOM_SERI', 'Nombre')!!}
		{!! Form::text('NOM_SERI', $seri->NOM_SERI, ['class' => 'form-control' , 'placeholder' => '', 'required', 
		'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 
		'title'=>'El campo no puede estar en blanco'])!!}

		
	</div>



	<div id="cursos" class='form-group' >
		{!! Form::label('IND_ESTA', 'Estado')!!}
		{!! Form::select('IND_ESTA', ['A'=>'Activado', 'D'=>'Desactivado'] , $seri->IND_ESTA, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>	

	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection
