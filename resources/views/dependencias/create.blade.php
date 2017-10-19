@extends('template.pages.main')

@section('title')
    Nuevo Estructura Orgánica
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Crear Estructura
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

	{!! Form::open(['route' => 'dependencias.store' , 'method' => 'POST', 'onsubmit' => 'return validar()'])!!}
<!--		        
	<div class="form-group">
     	<label>Oficina Dependiente</label>
        <select name='COD_PADR' class="form-control select2" style="width: 100%;">
        		<option value="" selected="selected">Ninguno</option>
          	@foreach($orgs as $orga)
				<option value="{{$orga->COD_ORGA}}">{{$orga->NOM_ORGA}}</option>
            @endforeach
        </select>
    </div>
-->

	<div class='form-group'>
		{!! Form::label('COD_ORGA', 'Código')!!}
		{!! Form::text('COD_ORGA', null, ['class' => 'form-control' , 'placeholder' => '', 'required' , 
		'pattern' => '^[0-9]+[0-9.]*$' , 'title'=>'Solo se permiten números y puntos', 'id'=> 'COD_ORGA'])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('NOM_ORGA', 'Nombre')!!}
		{!! Form::text('NOM_ORGA', null, ['class' => 'form-control' , 'placeholder' => '', 'required', 
		'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 
		'title'=>'El campo no puede estar en blanco'])!!}
	</div>

<!--
	<div class='form-group'>
		{!! Form::label('COD_NIVE', 'Nivel')!!}
		{!! Form::number('COD_NIVE', null, ['class' => 'form-control' , 'placeholder' => '', 'min'=>'0', ])!!}
	</div>
-->

	<div id="cursos" class='form-group' >
		{!! Form::label('IND_ESTA', 'Estado')!!}
		{!! Form::select('IND_ESTA', ['A'=>'Activado', 'D'=>'Desactivado'] , null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>	

	 <div class='form-group'>
                {!! Form::label('PATH', 'Ruta')!!}
                {!! Form::text('PATH', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
        </div>


	<div class='form-group'> 
		{!! Form::submit('Registrar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection

@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script type="text/javascript">
		  $(".select2").select2();
		function validar()
		{
			var status = "Y";
			var codigo = $("#COD_ORGA").val();
			for(i=0; i<codigo.length; i++) 
			{
				if(codigo.charAt(i) == ".")
				{
					if(codigo.charAt(i+1) == ".")
                                	{
						status = "N";
					}
				}
				//alert(i + ': ' + codigo.charAt(i));
			}
			if(codigo.charAt(codigo.length-1) == ".")
			{ status = "N";}
			if(status == "N")
			{
				alert("El código ingresado no es valido");
				return false;
			}
			else{
			return true;
			}
		}
	</script>
@endsection
