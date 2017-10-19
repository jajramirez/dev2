@extends('template.pages.main')

@section('title')
    Nueva Descripción Subseries
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
	<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Crear Descripción Subseries
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

	{!! Form::open(['route' => 'meta.store' , 'method' => 'POST'])!!}
	
	<div class="col-xs-12">
		<div class="form-group">    
			<div class="row">
				<div class="col-xs-6">
					<input type="text" value="{{$subserie->COD_SERI}}" name="COD_SERI" style="display:none">
			        <select id="COD_SERI" name='COD_SERIS' class="form-control select2" style="width: 100%;" disabled onchange="cargarSubs()">>
			        	<option value="">Seleccione una serie</option>
				        @foreach($seris as $seri)
				        	@if($subserie->COD_SERI == $seri->COD_SERI)

								<option value="{{$seri->COD_SERI}}" selected>{{$seri->NOM_SERI}}</option>
							@else
								<option value="{{$seri->COD_SERI}}">{{$seri->NOM_SERI}}</option>
							@endif
				        @endforeach
				    </select>
				</div>
				<div class="col-xs-6">
				    <select id="COD_SUBS" name='COD_SUBS' class="form-control select2" style="width:100%;">
				      	<option value="">Seleccione una subserie</option>
				    </select>
			    </div>
			</div>
	    </div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET1', 'MET1')!!}
			{!! Form::text('MET1', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET2', 'MET2')!!}
			{!! Form::text('MET2', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET3', 'MET3')!!}
			{!! Form::text('MET3', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET4', 'MET4')!!}
			{!! Form::text('MET4', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET5', 'MET5')!!}
			{!! Form::text('MET5', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET6', 'MET6')!!}
			{!! Form::text('MET6', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET7', 'MET7')!!}
			{!! Form::text('MET7', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET8', 'MET8')!!}
			{!! Form::text('MET8', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET9', 'MET9')!!}
			{!! Form::text('MET9', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>
	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET10', 'MET10')!!}
			{!! Form::text('MET10', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>
	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET11', 'MET11')!!}
			{!! Form::text('MET11', null, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
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
		function cargarSubs()
		{
			var cod_seri = $("#COD_SERI").val();
			var PostUri = "{{ route('seris.buscarccd')}}"; 

			$.ajax({
			    url: PostUri,
			    type: 'post',
			    data: {
			        cod_seri: cod_seri
			    },
			    headers: {
			        'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
			    },
			    success: function (data) {
			    	var comilla = '"';
			    	if(data != "<option value="+comilla+comilla+">Seleccione una subserie</option>")
			    	{
			    	
			    		$("#COD_SUBS").attr('required', 'required');
			    	}
			    	else
			    	{
			    		$("#COD_SUBS").removeAttr('required');
			    	}

		
			        $("#COD_SUBS").html(data); 

			    }
			});

		}
	</script>
@endsection
