@extends('template.pages.main')

@section('title')
    Nueva Retención 
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Crear registro de Retención Documental
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

	{!! Form::open(['route' => 'trd.store' , 'method' => 'POST'])!!}
		        
	<div class="form-group">
     	<label>Codigo TRD</label>
        	<div class="row">
			<div class="col-xs-4">
				<div class="form-group">
			     
			        <select name='COD_ORGA' class="form-control select2" style="width: 100%;" required>
			        	<option value="">Seleccione una Oficina Productora</option>
			          	@foreach($orgas as $orga)
							<option value="{{$orga->COD_ORGA}}">{{$orga->NOM_ORGA}}</option>
			            @endforeach
			        </select>
			    </div>
			</div>

			<div class="col-xs-8">
				<div class="form-group">
			     
			     	<div class="row">
			     		<div class="col-xs-6">
					        <select id="COD_SERI" name='COD_SERI' class="form-control select2" style="width: 100%;" required onchange="cargarSubs()">>
					        	<option value="">Seleccione una serie</option>
					          	@foreach($seris as $seri)
									<option value="{{$seri->COD_SERI}}">{{$seri->NOM_SERI}}</option>
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

		</div>
    </div>
    <div class="row">
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('ARC_GEST', 'Gestión')!!}
				{!! Form::text('ARC_GEST', null, ['class' => 'form-control' , 'placeholder' => '', 'required',  'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
			</div>
		</div>
		
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('ARC_CENT', 'Central')!!}
				{!! Form::text('ARC_CENT', null, ['class' => 'form-control' , 'placeholder' => '', 'required',  'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
			</div>
		</div>

		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('BAN_CT', 'Conservación Total (0 = No, 1 = Si)')!!}
				{!! Form::text('BAN_CT', null, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
	</div>
		
	<div class="row">
		<div class="col-xs-4">	
			<div class='form-group'>
				{!! Form::label('BAN_E', 'Eliminación  (0 = No, 1 = Si)')!!}
				{!! Form::text('BAN_E', null, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('BAN_M', 'Microfilmación  (0 = No, 1 = Si)' )!!}
				{!! Form::text('BAN_M', null, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('BAN_S', 'Selección (0 = No, 1 = Si)')!!}
				{!! Form::text('BAN_S', null, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
	</div>
	<div class='form-group'>
		{!! Form::label('TEX_OBSE', 'Observaciones')!!}
		{!! Form::textarea('TEX_OBSE', null, ['class' => 'form-control' , 'placeholder' => '', 'required', 'style'=> 'height:6em;'])!!}
	</div>

	<div id="cursos" class='form-group' >
		{!! Form::label('IND_ESTA', 'Estado')!!}
		{!! Form::select('IND_ESTA', ['A'=>'Activado', 'D'=>'Desactivado'] , null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>

	<div class="form-group">
        <label>Detalle</label>
        <div class="row">
	        <div class="col-xs-4">
	        	{!! Form::text('textoSelect', null, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'textodetalle'])!!}
	        </div>
	        <div class="col-xs-4">
	        	{!! Form::button('Agregar',['class' => 'btn btn-primary', 'id'=>'agregarselect', 'onclick' => 'agregar()'] )!!}
	        </div>
        </div>
        <div class="row">
        	<div class="col-xs-10">
		        <select multiple class="form-control" name='datosselect' id="datosselect">
		        </select>
		     	<input type="text" style="display:none" name='deta' id="deta">
	        </div>
	        <div class="col-xs-2">
	        	{!! Form::button('Eliminar',['class' => 'btn btn-primary', 'onclick' => 'removeritem()'] )!!}
	        </div>
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

		function agregar()
		{
			var texto = $('#textodetalle').val();
			var data = '<option value="'+texto+'">'+ texto +'</option>'
		 	$("#datosselect").append(data);
		 	$("#deta").val("");
		 	var lista = "";
		 	$("#datosselect option").each(function(){
		 		lista = lista+ $(this).text() + '^';
    		});
    		$("#deta").val(lista);
    		$('#textodetalle').val("");
		}

		function removeritem() {
		    var x = document.getElementById("datosselect");
		    x.remove(x.selectedIndex);
		    $("#deta").val("");
		 	var lista = "";
		 	$("#datosselect option").each(function(){
		 		lista = lista+ $(this).text() + '^';
    		});
    		$("#deta").val(lista);
		}

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
