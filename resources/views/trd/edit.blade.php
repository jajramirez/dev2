@extends('template.pages.main')

@section('title')
    Editar Retención 
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Editar registro de Retención Documental
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

	{!! Form::open(['route' => 'trd.actualizar' , 'method' => 'POST'])!!}
		        
	<div class="form-group">
     	<label>Codigo TRD {{$trd->COD_TRD}}</label>
     	<input type="text" style="display:none;" value="{{$trd->COD_TRD}}" name="COD_TRD">
     	<input type="text" style="display:none;" value="{{$trd->COD_ENTI}}" name="COD_ENTI">
        <div class="row">
			<div class="col-xs-5">
	            <div class="form-group">
		        	@foreach($orga as $org)
		      			@if($codorga == $org->COD_ORGA)
							<label> {{$org->COD_ORGA}} - {{$org->NOM_ORGA}}</label>
						@endif
					@endforeach
				</div>
			</div>
            <div class="col-xs-5">
               	<div class="form-group">
		            @foreach($seri as $ser)
						@if($codseri == $ser->COD_SERI)
							<label> {{$ser->COD_SERI}} - {{$ser->NOM_SERI}}</label>								
						@endif
					@endforeach 
		        </div>
            </div>
        </div>
    </div>

	<div class="row">
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('ARC_GEST', 'Gestión')!!}
				{!! Form::text('ARC_GEST', $trd->ARC_GEST, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
			</div>
		</div>
		
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('ARC_CENT', 'Central')!!}
				{!! Form::text('ARC_CENT', $trd->ARC_CENT, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
			</div>
		</div>

		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('BAN_CT', 'Conservación Total (0 = No, 1 = Si)')!!}
				{!! Form::text('BAN_CT', $trd->BAN_CT, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
	</div>
		
	<div class="row">
		<div class="col-xs-4">	
			<div class='form-group'>
				{!! Form::label('BAN_E', 'Eliminación (0 = No, 1 = Si)')!!}
				{!! Form::text('BAN_E', $trd->BAN_E, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('BAN_M', 'Microfilmación (0 = No, 1 = Si)')!!}
				{!! Form::text('BAN_M', $trd->BAN_M, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
		<div class="col-xs-4">
			<div class='form-group'>
				{!! Form::label('BAN_S', 'Selección (0 = No, 1 = Si)')!!}
				{!! Form::text('BAN_S', $trd->BAN_S, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-1]', 'title' => 'Solo se permiten 0 - 1'])!!}
			</div>
		</div>
	</div>
	<div class='form-group'>
		{!! Form::label('TEX_OBSE', 'Observaciones')!!}
		{!! Form::textarea('TEX_OBSE', $trd->TEX_OBSE, ['class' => 'form-control' , 'placeholder' => '', 'required', 'style'=> 'height:6em;'])!!}
	</div>

	<div id="cursos" class='form-group' >
		{!! Form::label('IND_ESTA', 'Estado')!!}
		{!! Form::select('IND_ESTA', ['A'=>'Activado', 'D'=>'Desactivado'] , $trd->IND_ESTA, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
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
		        	@if($detalle != null)
						@foreach($detalle as $d)
							<option value="{{$d->NOM_DESC}}">{{$d->NOM_DESC}}</option>
						@endforeach
		        	@endif
		        </select>
		     	<input type="text" style="display:none;" name='deta' id="deta" value="{{$des_deta}}">
		     	<input type="text" style="display:none;" name='original' id="original" value="{{$des_deta}}">
	        </div>
	        <div class="col-xs-2">
	        	{!! Form::button('Eliminar',['class' => 'btn btn-primary', 'onclick' => 'removeritem()'] )!!}
	        </div>
    	</div>
    </div>


	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
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


	</script>
@endsection
