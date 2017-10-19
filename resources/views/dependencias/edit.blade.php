@extends('template.pages.main')

@section('title')
    Editar Estructura Orgánica
@endsection


@section('name_aplication')
    <h1>
        Editar Estructura
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
	{!! Form::open(['route' => 'dependencias.actualizar' , 'method' => 'POST'])!!}
<!--    
    <div class="form-group">
     	<label>Oficina Dependiente</label>
        <select name='COD_PADR' class="form-control select2" style="width: 100%;">
        	@if($seri->COD_PADR == null)
				<option value="" selected="selected" >Ninguno</option>
			@else
				<option value="" >Ninguno</option>
			@endif
          	@foreach($orgs as $orga)
	          	@if($orga->COD_ORGA == $seri->COD_PADR)
					<option value="{{$orga->COD_ORGA}}" selected="selected">{{$orga->NOM_ORGA}}</option>
	           	@else
					<option value="{{$orga->COD_ORGA}}">{{$orga->NOM_ORGA}}</option>
				@endif
            @endforeach
        </select>
    </div>
-->
	<div class='form-group'>
		{!! Form::label('COD_ORGA', 'Código')!!}
		{!! Form::text('COD_ORGA2', $seri->COD_ORGA, ['class' => 'form-control' , 'placeholder' => '', 'disabled'=>'disabled', ])!!}
	</div>
	<input type="text" style="display:none" name="COD_ENTI" value="{{$seri->COD_ENTI}}">
	<input type="text" style="display:none" name="COD_ORGA" value="{{$seri->COD_ORGA}}">

	<div class='form-group'>
		{!! Form::label('NOM_ORGA', 'Nombre')!!}
		{!! Form::text('NOM_ORGA', $seri->NOM_ORGA, ['class' => 'form-control' , 'placeholder' => '', 'required', 
		'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 
		'title'=>'El campo no puede estar en blanco'])!!}
	</div>

<!--
	<div class='form-group'>
		{!! Form::label('COD_NIVE', 'Nivel')!!}
		{!! Form::number('COD_NIVE', $seri->COD_NIVE, ['class' => 'form-control' , 'placeholder' => '', 'required', 'min'=>'0'])!!}
	</div>

-->
	<div id="cursos" class='form-group' >
		{!! Form::label('IND_ESTA', 'Estado')!!}
		{!! Form::select('IND_ESTA', ['A'=>'Activado', 'D'=>'Desactivado'] , $seri->IND_ESTA, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>	

	<div class='form-group'>
                {!! Form::label('PATH', 'ruta')!!}
                {!! Form::text('PATH', $seri->PATH, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
        </div>


	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection
