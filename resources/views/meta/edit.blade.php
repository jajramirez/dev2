@extends('template.pages.main')

@section('title')
    Editar Descripción Subseries
@endsection


@section('name_aplication')
    <h1>
        Editar Descripción Subseries
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
	{!! Form::open(['route' => 'meta.actualizar' , 'method' => 'POST'])!!}
	<input type="text" value="{{$ccdf->NUM_REGI}}" name="NUM_REGI" style="display:none">
	
	    <div class="row">
            <div class="col-xs-6">
               	<div class="form-group">
		            @foreach($seris as $ser)
						@if($ccdf->COD_SERI == $ser->COD_SERI)
							<label>Serie:  {{$ser->COD_SERI}} - {{$ser->NOM_SERI}}</label>								
						@endif
					@endforeach 
					<br/>
					
					 @foreach($ccdo as $serw)
					 	@if($ccdf->COD_SUBS  != null)
							@if($ccdf->COD_SUBS == $serw->COD_SUBS && $ccdf->COD_SERI == $serw->COD_SERI)
								<label>Subserie:  {{$serw->COD_SUBS}} - {{$serw->NOM_SUBS}}</label>								
							@endif
						@endif
					@endforeach 
		        </div>
            </div>

            <div class="col-xs-6">
               	<div class="form-group">
		           
		        </div>
            </div>
        </div>

		<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET1', 'Metadato 1')!!}
			<?php 
				$met1 = null;
				$met2 = null;
				$met3 = null;
				$met4 = null;
				$met5 = null;
				$met6 = null;
				$met7 = null;
				$met8 = null;
				$met9 = null;
				$met10 = null;
				$met11 = null;
				if($ccd != null)
				{
					$met1 = $ccd->MET1;
					$met2 = $ccd->MET2;
					$met3 = $ccd->MET3;
					$met4 = $ccd->MET4;
					$met5 = $ccd->MET5;
					$met6 = $ccd->MET6;
					$met7 = $ccd->MET7;
					$met8 = $ccd->MET8;
					$met9 = $ccd->MET9;
					$met10 = $ccd->MET10;
					$met11 = $ccd->MET11;
				}

			?>
		
			{!! Form::text('MET1', $met1, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET2', 'Metadato 2')!!}
			{!! Form::text('MET2', $met2, ['class' => 'form-control' , 'placeholder' => ''])!!}
		</div>
	</div>
	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET3', 'Metadato 3')!!}
			{!! Form::text('MET3', $met3, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET4', 'Metadato 4')!!}
			{!! Form::text('MET4', $met4, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET5', 'Metadato 5')!!}
			{!! Form::text('MET5', $met5, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>
	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET6', 'Metadato 6')!!}
			{!! Form::text('MET6', $met6, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET7', 'Metadato 7')!!}
			{!! Form::text('MET7', $met7, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET8', 'Metadato 8')!!}
			{!! Form::text('MET8', $met8, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET9', 'Metadato 9')!!}
			{!! Form::text('MET9', $met9, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>
	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET10', 'Metadato 10')!!}
			{!! Form::text('MET10', $met10, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class="col-xs-12">
		<div class='form-group'>
			{!! Form::label('MET11', 'Metadato 11')!!}
			{!! Form::text('MET11', $met11, ['class' => 'form-control' , 'placeholder' => ''])!!}

		</div>
	</div>

	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection
