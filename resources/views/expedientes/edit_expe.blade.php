@extends('template.pages.main')

@section('title')
    Editar Expediente
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('template/plugins/datepicker/datepicker3.css')}}">
	<link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection

@section('name_aplication')
    <h1>
        Crear Expediente
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

	{!! Form::open(['route' => 'expedientes.actualiza' , 'method' => 'POST' , 'files'=>true]) !!}


	 <div class="col-md-12">

          <div class="box box-info">
            <div class="box-header">
              
            </div>
            <div class="box-body">
   
				<div class='form-group'>
					{!! Form::label('TRD', 'Código TRD')!!}
					{!! Form::text('TRD', null, ['class' => 'form-control' , 'placeholder' => '', 'disabled', 'id' => 'TRD'])!!}
				
				</div>

   					<div class="form-group col-md-4">
   						<label>Oficina Productora</label>
				     
				        <select id="COD_ORGA" name='COD_ORGA' class="form-control select2" style="width: 100%;"  required onchange="codigoTRD()">
				        	<option value="">Seleccione una opcion</option>
				          	@foreach($orgas as $orga)
				          		@if($orga->COD_ORGA == $detalle->COD_ORGA)
									<option value="{{$orga->COD_ORGA}}" selected>{{$orga->NOM_ORGA}}</option>
								@else
									<option value="{{$orga->COD_ORGA}}">{{$orga->NOM_ORGA}}</option>
								@endif
				            @endforeach
				        </select>
			    	</div>

				<div class="form-group col-md-4">
			        <label>Código Serie</label>
			        <select name='COD_SERI' id='COD_SERI' class="form-control select2" style="width: 100%;" required onchange="cargarSubs()">
			        	<option value="">Seleccione una opcion</option>
			           	@foreach($series as $seri)
			           		@if($seri->COD_SERI == $codse)
								<option value="{{$seri->COD_SERI}}" selected>{{$seri->NOM_SERI}}</option>
							@else
								<option value="{{$seri->COD_SERI}}">{{$seri->NOM_SERI}}</option>
							@endif
			            @endforeach
			        </select>
			    </div>

			  
				
				<div class='form-group col-md-4'>
					{!! Form::label('COD_SUBS', 'Sub Serie')!!}
					<input type="text" style="display:none" id="CODSUB" value="{{$codsu}}">
					<select id="COD_SUBS" name='COD_SUBS' class="form-control select2" style="width: 100%;" onchange="codigoTRD()">
					        <option value="">Seleccione una subserie</option>
					</select>
				</div>

				<div class='form-group col-md-4'>
						@if($enc == null)
				     		{!! Form::label('NOM_MODA', 'Modalidad')!!}
				     	@else
				     		<label> {!!$enc->MET8!!} </label>
				     	@endif
					

					{!! Form::text('NOM_MODA', $detalle->NOM_MODA, ['class' => 'form-control' , 'placeholder' => ''])!!}
				</div>

				<div class='form-group col-md-4'>
					@if($enc == null)
				     		{!! Form::label('NOM_PROG', 'Programa académico')!!}
						{!! Form::text('NOM_PROG', $detalle->NOM_PROG, ['class' => 'form-control' , 'placeholder' => '' , 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco'])!!}
				     	@else
				     		<label> {!!$enc->MET7!!} </label>
						{!! Form::text('NOM_PROG', $detalle->NOM_PROG, ['class' => 'form-control' , 'placeholder' => '', ])!!}
				     	@endif
				</div>

					<div class='form-group col-md-4'>
						@if($enc == null)
				     		{!! Form::label('FEC_INGR', 'Fecha Ingreso')!!}
				     	@else
				     		<label> {!!$enc->MET10!!} </label>
				     	@endif
					
					<div class="input-group date">
	                        <div class="input-group-addon">
	                            <i class="fa fa-calendar"></i>
	                        </div>
	                        <input type="text" class="form-control pull-right" id="datepicker" name="FEC_INGR">
                    	</div>
				</div>

					<div class='form-group col-md-4'>
					
						@if($enc == null)
				     		{!! Form::label('ANH_FINA', 'Año Finalizacion')!!}
				     	@else
				     		<label> {!!$enc->MET11!!} </label>
				     	@endif
					{!! Form::text('ANH_FINA', $detalle->ANH_FINA, ['class' => 'form-control' , 'placeholder' => '' ,'maxlength'=>'4','pattern' => '^[0-9]*$', 'title' => 'Solo se permiten números'])!!}
				</div>


				<div class='form-group col-md-4'>
						@if($enc == null)
				     		{!! Form::label('TIP_NIVEL', 'Nivel')!!}
				     	@else
				     		<label> {!!$enc->MET9!!} </label>
				     	@endif
					
					
					{!! Form::text('TIP_NIVEL', $detalle->TIP_NIVEL, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

				<div class='form-group col-md-4'>
					{!! Form::label('OBS_GENE', 'Observaciones')!!}
					{!! Form::text('OBS_GENE', $detalle->OBS_GENE, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

				<input type="text" name="NUM_REGI" value="{{$detalle->NUM_REGI}}" style="display:none">
            </div>
 
          </div>

        </div>


	


	<div class="row">

		<div class="col-md-6">
			<div class="box box-default">
        <div class="box-header with-border">    
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
         <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
             	
				<div class="form-group">
					@if($enc == null)
			     		<label>Tipo Documento</label>
			     	@else
			     		<label>{{$enc->MET2}}</label>
			     	@endif
			        <select name='TIP_DOCU1' class="form-control select2" style="width: 100%;"  disabled>
			            <option value="">Seleccione una opcion</option>
			          	<option value="CC" {{$data[0]}}>Cédula de Ciudadanía</option>
						<option value="CE" {{$data[1]}}>Cédula de Extranjería</option>
						<option value="RC" {{$data[2]}}>Registro civil</option>
						<option value="TI" {{$data[3]}}>Tarjeta de identidad</option>
						<option value="NIT" {{$data[4]}}>NIT para personas jurídicas</option> 
			        </select>
			    </div>



				<div class='form-group'>
					@if($enc == null)
			     		{!! Form::label('NUM_DOCU1', 'Número Documento')!!}
			     	@else
			     		{!! Form::label('NUM_DOCU1', $enc->MET1)!!}
			     	@endif
				
					{!! Form::text('NUM_DOCU1', $expe->NUM_DOCU, ['class' => 'form-control' , 'placeholder' => '', 'disabled'])!!}
				</div>

				<div class='form-group' >
					
					@if($enc == null)
			     		{!! Form::label('PRI_NOMB', 'Primer Nombre')!!}
			     	@else
			     		{!! Form::label('PRI_NOMB', $enc->MET3)!!}
			     	@endif
					{!! Form::text('PRI_NOMB', $expe->PRI_NOMB, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco'])!!}
				</div>	
				

            </div>
            <!-- /.col -->
            <div class="col-md-12">

            	<div class='form-group' >
            		@if($enc == null)
			     		{!! Form::label('SEG_NOMB', 'Segundo Nombre')!!}
			     	@else
			     		{!! Form::label('SEG_NOMB', $enc->MET4)!!}
			     	@endif
					
					{!! Form::text('SEG_NOMB', $expe->SEG_NOMB, ['class' => 'form-control' , 'placeholder' => ''])!!}
				</div>	
				<div class='form-group' >
					@if($enc == null)
			     		{!! Form::label('PRI_APEL', 'Primer Apellido')!!}
			     	@else

			     		<label> {!!$enc->MET5!!} </label>
			     	@endif
					
					{!! Form::text('PRI_APEL', $expe->PRI_APEL, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco'])!!}
				</div>	
				<div class='form-group' >
					
					@if($enc == null)
			     		{!! Form::label('SEG_APEL', 'Segundo Apellido')!!}
			     	@else
			     		<label> {!!$enc->MET6!!} </label>
			     	@endif
					{!! Form::text('SEG_APEL', $expe->SEG_APEL, ['class' => 'form-control' , 'placeholder' => '', 'pattern' => '[a-zA-Z0-9.àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]+[ a-zA-Z0-9.,#-_+àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]*$', 'title'=>'El campo no puede estar en blanco'])!!}
				</div>
				<input type="text" name="COD_EXPE" value="{{$expe->COD_EXPE}}" style= "display:none;">
				<input type="text" name="TIP_DOCU" value="{{$expe->TIP_DOCU}}" style= "display:none;">
				<input type="text" name="NUM_DOCU" value="{{$expe->NUM_DOCU}}" style= "display:none;">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	

            </div>

          </div>

        </div>


        <div class="box-footer">
        
        </div>
      </div>

		</div>
       
         <div class="col-md-6">

          <div class="box box-info">
            <div class="box-header">
              
            </div>
            <div class="box-body">
	            	<div class='form-group'>
						{!! Form::label('NOM_ARCH', 'Archivo')!!}
						{!! Form::File('NOM_ARCH', null, ['required', 'id'=> 'NOM_ARCH'])!!}
						<input type="text" name='nombrearchivo' value="{{$arch->NOM_ARCH}}" style="display:none"/>
					</div>
				<div class='form-group'>
					{!! Form::label('FEC_ARCH', 'Fecha Creación del Archivo')!!}
					<div class="input-group date">
	                        <div class="input-group-addon">
	                            <i class="fa fa-calendar"></i>
	                        </div>
	                        <input type="text" class="form-control pull-right" id="datepicker2" name="FEC_ARCH">
                    	</div>
				</div>

					<div class='form-group'>
					{!! Form::label('NUM_PAGI', 'Paginas')!!}
					{!! Form::text('NUM_PAGI', $arch->NUM_PAGI, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

					<div class='form-group'>
					{!! Form::label('NUM_TAMA', 'Tamaño (kilobyte)')!!}
		
					{!! Form::text('NUM_TAMA2', $arch->NUM_TAMA, ['class' => 'form-control' , 'placeholder' => '', 'id'=>'NUM_TAMA2', 'disabled'])!!}
					<input type="text" name="NUM_TAMA" id="NUM_TAMA" style="display:none" value="{{$arch->NUM_TAMA}}">
				</div>


				<div class='form-group'>
					{!! Form::label('NOM_SOFT', 'Software')!!}
					{!! Form::text('NOM_SOFT', $arch->NOM_SOFT, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
				</div>

				<div class='form-group'>
					{!! Form::label('NOM_VERS', 'Versión')!!}
					{!! Form::text('NOM_VERS', $arch->NOM_VERS, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

				<div class='form-group'>
					{!! Form::label('NOM_RESO', 'Resolución')!!}
					{!! Form::text('NOM_RESO', $arch->NOM_RESO, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

				<div class='form-group'>
					{!! Form::label('NOM_IDIO', 'Idioma')!!}
					{!! Form::text('NOM_IDIO', $arch->NOM_IDIO, ['class' => 'form-control' , 'placeholder' => '', ''])!!}
				</div>

				<input type="text" name="NUM_ARCH" value="{{$arch->NUM_ARCH}}" style="display:none">
	
            </div>
            
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
	<script src="{{ asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
	<script type="text/javascript">

	$('#NOM_ARCH').change(function (){
     var sizeByte = this.files[0].size;
     var siezekiloByte = parseInt(sizeByte / 1024);
     $("#NUM_TAMA").val(siezekiloByte);
     $("#NUM_TAMA2").val(siezekiloByte);
     if(sizeByte > 0)
     {
     	$("#NOM_PROG").attr('required', 'required');
     }
     else
     {
     	$("#NOM_PROG").removeAttr('required');
     }
     
 	});

	window.onload=cargarSubs;

	$('#datepicker').datepicker({
		autoclose: true
	});
	
	$('#datepicker2').datepicker({
		autoclose: true
	});
		  $(".select2").select2();

	function cargarSubs()
	{
		var cod_seri = $("#COD_SERI").val();
		var cod_subs = $("#CODSUB").val();
		var PostUri = "{{ route('seris.buscarccd')}}"; 
		
		$.ajax({
		    url: PostUri,
		    type: 'post',
		    data: {
		        cod_seri: cod_seri,
		        cod_subs: cod_subs
		    },
		    headers: {
		        'X-CSRF-TOKEN': "{{ Session::token() }}", //for object property name, use quoted notation shown in second
		    },
		    success: function (data) {
		        $("#COD_SUBS").html(data);
		        codigoTRD();	
		    }
		});
		

	}

		function codigoTRD()
	{

		var oficina = $("#COD_ORGA").val();
		var cod_seri = $("#COD_SERI").val();
		if(cod_seri.length > 0)
		{
			cod_seri = '.'+$("#COD_SERI").val();
		}	
		
		var cod_subs = $("#COD_SUBS").val();
		if(cod_subs.length > 0)
		{
			cod_subs = '.'+$("#COD_SUBS").val();
		}
		else
		{

		}	
		var trd = oficina+cod_seri+cod_subs;
		$("#TRD").val(trd);
	}


	</script>
@endsection
