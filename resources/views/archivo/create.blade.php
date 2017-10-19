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

{!! Form::open(['route' => 'archivo.store' , 'method' => 'POST', 'files'=>true]) !!}

	<div class='form-group'>
		{!! Form::label('NOM_ARCH', 'Archivo')!!}
		<input type="file" name="NOM_ARCH" required id="NOM_ARCH">
	</div>
	

	<div class='form-group'>
		<div class='form-group'>
			<label>Fecha</label>
			<div class="input-group date">
	            <div class="input-group-addon">
	                <i class="fa fa-calendar"></i>
	            </div>
	            <input type="text" class="form-control pull-right" id="datepicker" name="FEC_ARCH">
          	</div>
				
		</div>
	</div>

	<div class='form-group'>
		{!! Form::label('NUM_PAGI', 'Paginas')!!}
		{!! Form::text('NUM_PAGI', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
	</div>

		<div class='form-group'>
		{!! Form::label('NUM_TAMA', 'Tamaño (kilobyte)')!!}
		{!! Form::text('NUM_TAMA', null, ['class' => 'form-control' , 'placeholder' => '', 'disabled', 'id'=>'NUM_TAMA'])!!}
	</div>


	<div class='form-group'>
		{!! Form::label('NOM_SOFT', 'Software')!!}
		{!! Form::text('NOM_SOFT', null, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('NOM_VERS', 'Versión')!!}
		{!! Form::text('NOM_VERS', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('NOM_RESO', 'Resolución')!!}
		{!! Form::text('NOM_RESO', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('NOM_IDIO', 'Idiomas')!!}
		{!! Form::text('NOM_IDIO', null, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
	</div>


	<div class='form-group'> 
		{!! Form::submit('Registrar',['class' => 'btn btn-primary'] )!!}
	</div>

	<input type="text" name="COD_EXPE" value="{{$COD_EXPE}}" style="display:none">
	<input type="text" name="NUM_REGI" value="{{$NUM_REGI}}" style="display:none">
	
	{!! Form::close() !!}

@endsection

@section('js')
	<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>
		<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>



	<script type="text/javascript">

				$('#datepicker').datepicker({
		autoclose: true
	});




		  $(".select2").select2();
		 $('#NOM_ARCH').change(function (){
	     var sizeByte = this.files[0].size;
	     var siezekiloByte = parseInt(sizeByte / 1024);
	     $("#NUM_TAMA").val(siezekiloByte);
	     
	 	});
	</script>
@endsection