@extends('template.pages.main')

@section('title')
    Editar CCD
@endsection


@section('name_aplication')
    <h1>
        Editar CCD 
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
	{!! Form::open(['route' => 'ccd.actualizar' , 'method' => 'POST'])!!}
	
	<div class="form-group">
     	   <label>Código Serie</label>
            <select name='COD_SERI' class="form-control select2" style="width: 100%;" required>
              	@foreach($seris as $seri)
              		@if($ccd->COD_SERI == $seri->COD_SERI)
						<option value="{{$seri->COD_SERI}}" selected="selected">{{$seri->NOM_SERI}}</option>
					@else
						<option value="{{$seri->COD_SERI}}">{{$seri->NOM_SERI}}</option>
              		@endif
					
                @endforeach
            </select>
    </div>

	<input type="text" name="COD_ENTI" value="{{$ccd->COD_ENTI}}" style="display:none"> 
	<input type="text" name="NUM_REGI" value="{{$ccd->NUM_REGI}}" style="display:none"> 

	<div class='form-group'>
		{!! Form::label('COD_SUBS', 'Subserie')!!}
		{!! Form::text('COD_SUBS', $ccd->COD_SUBS, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
	</div>

	<div class='form-group'>
		{!! Form::label('NOM_SUBS', 'Nombre')!!}
		{!! Form::text('NOM_SUBS', $ccd->NOM_SUBS, ['class' => 'form-control' , 'placeholder' => '', 'required', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco'])!!}
	</div>

	<div id="cursos" class='form-group' >
		{!! Form::label('IND_ESTA', 'Estado')!!}
		{!! Form::select('IND_ESTA', ['A'=>'Activado', 'D'=>'Desactivado'] , $ccd->IND_ESTA, ['class' => 'form-control', 'placeholder' => 'Seleccione una opcion', 'required'])!!}
	</div>	

	<div class='form-group'> 
		{!! Form::submit('Editar',['class' => 'btn btn-primary'] )!!}
	</div>

	{!! Form::close() !!}

@endsection
