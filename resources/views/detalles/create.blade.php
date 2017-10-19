@extends('template.pages.main')

@section('title')
    Nuevo 
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
	<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Crear 
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

{!! Form::open(['route' => 'detalle.store' , 'method' => 'POST'])!!}

	<div class="form-group">
        <label>Código Serie</label>
        <select name='COD_SERI' class="form-control select2" style="width: 100%;" required>
        	<option value="">Seleccione una opcion</option>
           	@foreach($series as $seri)
				<option value="{{$seri->COD_SERI}}">{{$seri->NOM_SERI}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
     	<label>Organizacion</label>
        <select name='COD_ORGA' class="form-control select2" style="width: 100%;" required>
        	<option value="">Seleccione una opcion</option>
          	@foreach($orgas as $orga)
				<option value="{{$orga->COD_ORGA}}">{{$orga->NOM_ORGA}}</option>
            @endforeach
        </select>
    </div>
	
	<div class='form-group'>
		{!! Form::label('COD_SUBS', 'Sub Serie')!!}
		{!! Form::text('COD_SUBS', null, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
	</div>


	<div class='form-group'>
		{!! Form::label('NOM_MODA', 'Modalidad')!!}
		{!! Form::text('NOM_MODA', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('NOM_PROG', 'Programa academico')!!}
		{!! Form::text('NOM_PROG', null, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('FEC_INGR', 'Fecha Ingreso')!!}
		{!! Form::text('FEC_INGR', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('ANH_FINA', 'Año Finalizacion')!!}
		{!! Form::text('ANH_FINA', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>


	<div class='form-group'>
		{!! Form::label('TIP_NIVEL', 'Nivel')!!}
		{!! Form::text('TIP_NIVEL', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('OBS_GENE', 'Obseraciones')!!}
		{!! Form::text('OBS_GENE', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>


	<div class='form-group'> 
		{!! Form::submit('Registrar',['class' => 'btn btn-primary'] )!!}
	</div>

	<input type="text" name="COD_EXPE" value="{{$COD_EXPE}}" style="display:none">
	{!! Form::close() !!}

@endsection

@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
	<script type="text/javascript">
		  $(".select2").select2();
	</script>
@endsection