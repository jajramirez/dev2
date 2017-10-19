@extends('template.pages.main')

@section('title')
    Seleccionar Subseries
@endsection


@section('name_aplication')
    <h1>
        Seleccionar Subseries
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
	{!! Form::open(['route' => 'meta.seleccion' , 'method' => 'POST'])!!}

	<div class="form-group col-md-12">
			     	<label>Subserie</label>
			        <select id='COD_SUBS' name='COD_SUBS' class="form-control select2" style="width: 100%;" required>
			        	<option value="">Seleccione una opcion</option>
			          	@foreach($ccds as $ccd)
							<option value="{{$ccd->COD_ENTI.'_'.$ccd->NUM_REGI}}">{{$ccd->NOM_SUBS}}</option>
			            @endforeach
			        </select>
	</div>
	<div class="form-group col-md-12">
	{!! Form::submit('Seleccionar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection
