@extends('template.pages.main')

@section('title')
    FUID
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection



@section('name_aplication')
    <h1>
       	Formato Unico de Inventario Documental (FUID) 
        <small></small>
    </h1>
    <ol class="breadcrumb">
    </ol>
@endsection



@section('content')

<div class="row">
        <div class="col-xs-12">
          <div class="box">

		{!! Form::open(['route' => 'home.fuid', 'method' => 'GET', 'id'=>'buscarF']) !!}
				<div class="row"></div>
			
		 <div class="row">

                <div class="col-xs-3">
	                <div class="form-group">
			            <select name='COD_ORGA' class="form-control select2" >                 
			            	<option value="">Seleccione una oficina productora</option>                 
			            	@foreach($orga as $org)
			            		@if($codorga != null)
									@if($codorga == $org->COD_ORGA)
										<option value="{{$org->COD_ORGA}}" selected="selected">{{$org->NOM_ORGA}}</option>
									@else
										<option value="{{$org->COD_ORGA}}">{{$org->NOM_ORGA}}</option>
									@endif
								@else
									<option value="{{$org->COD_ORGA}}">{{$org->NOM_ORGA}}</option>
			            		@endif
			            		
							@endforeach             
						</select>         
					</div>

                </div>
                <div class="col-xs-3">
                 	<div class="form-group">
			            <select name='COD_SERI' class="form-control select2">
			            	<option value="">Seleccione una serie</option>
			              	@foreach($seri as $ser)
								@if($codseri != null)
									@if($codseri == $ser->COD_SERI)
										<option value="{{$ser->COD_SERI}}" selected="selected">{{$ser->NOM_SERI}}</option>
									@else
										<option value="{{$ser->COD_SERI}}">{{$ser->NOM_SERI}}</option>
									@endif
								@else
									<option value="{{$ser->COD_SERI}}">{{$ser->NOM_SERI}}</option>
			            		@endif

								
			                @endforeach
			            </select>
			        </div>

                </div>

                 <div class="col-xs-3">
	                <div class="form-group">
						{!! Form::text('OBS_GEN1', null, ['class' => 'form-control' , 'placeholder' => 'NOTAS'])!!}
					</div>
                </div>
			 </div>
				<div class="row">
	                

					 <div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('OBS_GEN2', null, ['class' => 'form-control' , 'placeholder' => 'OBS_GEN2'])!!}
						</div>
	                </div>
	                <div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('OBS_GEN3', null, ['class' => 'form-control' , 'placeholder' => 'OBS_GEN3'])!!}
						</div>
	                </div>
	                
					<input ype="text" value="1" name="data" style="display:none">

					<div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('OBS_GEN4', null, ['class' => 'form-control' , 'placeholder' => 'OBS_GEN4'])!!}
						</div>
	                </div>

				</div>

				<div class="row">
					
					<div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('Asunto', null, ['class' => 'form-control' , 'placeholder' => 'Asunto'])!!}
						</div>
	                </div>
	                
					<input ype="text" value="1" name="data" style="display:none">

					<div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('Anio', null, ['class' => 'form-control' , 'placeholder' => 'Año' , 'maxlength' => '4'])!!}
						</div>
	                </div>

					
					<div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('CON_BODE', null, ['class' => 'form-control' , 'placeholder' => 'Consecutivo Bodega'])!!}
						</div>
	                </div>

				</div>


				<div class="row">
					
				
	                <div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('FEC_TRAN', null, ['class' => 'form-control' , 'placeholder' => 'Fecha Transferencia'])!!}
						</div>
	                </div>

	                <div class="col-xs-3">
		                <div class="form-group">
							{!! Form::text('NUM_TRAN', null, ['class' => 'form-control' , 'placeholder' => 'Numero Transferencia'])!!}
						</div>
	                </div>

	                  
	                
				</div>
           

			<div class="row">
				<div class="col-xs-10"></div>
				<div class="col-xs-1">
	                	<div class="form-group">	
							<button id="buscar" type="submit" class="btn btn-primary" style="display:none">
						  		<span class="glyphicon glyphicon-search" aria-hidden="true"> </span>
						 	</button>
						</div>
					</div>

					{!! Form::close()!!}


				<div class="col-xs-1">
					{!! Form::open(['route' => 'fuid.create' , 'method' => 'GET' ,'id' =>'createR'])!!}
					<input type="text" name="busqueda" value="" style="display:none">
					<button type="submit" class="btn btn-primary"  style="display:none">
				       <span class="fa fa-plus-circle" aria-hidden="true"> </span>
				    </button>  
					{!! Form::close() !!}
				</div>


			</div>
           
        
	

		

	<div class="box-body table-responsive no-padding">
		<table id='datainfo' class="table table-bordered table-hover">
			<thead>
				<th>No.Orden</th>
				<th>Código</th>
				<th>Serie</th>
				<th>Subserie</th>
				<th>Asunto</th>
				<th>Fecha Inicial</th>
				<th>Fecha Final</th>
				<th>Caja</th>
				<th>Carpeta</th>
				<th>Tomo</th>
				<th>Otro</th>
				<th>No. Folios</th>
				<th>Soporte</th>
				<th>Frecuencia Consulta</th>
				<th>Notas</th>
				<th>Consecutivo Bodega</th>
				<th>Fecha Transferencia</th>
				<th>Numero Transferencia</th>
				<th>Archivo</th>
				<th>Metadatos</th>
				<th>Acción</th>
			</thead>
			<tbody>
				@if($datos != null)
					@foreach($datos as $dato)
						<tr>
							<td>@if($dato->NUM_ORDE == NULL) {{ $dato->NUM_REGI}} @else {{ $dato->NUM_ORDE}} @endif </td>
							<td>{{ $dato->COD_TRD}} </td>
							<td>{{ $dato->NOM_SERI}} </td>
							<td>
								<?php

									if(count($info)>= $secuencia)
									{ 
										$dac = $info[$secuencia];
										foreach($dac as $v)
										{
											echo($v->NOM_SUBS);
										}
									}
									$secuencia++
								?>



							</td>
							<td>{{ $dato->NOM_ASUN}} </td>
							<td>{{ $dato->FEC_INIC}} </td>
							<td>{{ $dato->FEC_FINA}} </td>
							<td>{{ $dato->NUM_CAJA}} </td>
							<td>{{ $dato->NUM_CARP}} </td>
							<td>{{ $dato->NUM_TOMO}} </td>
							<td>{{ $dato->NUM_INTE}} </td>
							<td>{{ $dato->NUM_FOLI}} </td>
							<td>{{ $dato->GEN_SOPO}} </td>
							<td>{{ $dato->FRE_CONS}} </td>
						 	<td>{{ $dato->OBS_GEN1}} </td>
							<td>{{ $dato->CON_BODE}} </td>
							<td>{{ $dato->FEC_TRAN}} </td>
							<td>{{ $dato->NUM_TRAN}} </td>
							<!--<td><a href="documentos/{{ $dato->NOM_ARCH}}" download><i class="fa fa-eye" aria-hidden="true"></i></a> </td> -->
							<td>
								@if( $dato->NOM_ARCH != null)
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" 	onclick="cargarmodal('{{$dato->PATH}}','{{ $dato->NOM_ARCH}}')">
									<i class="fa fa-eye" aria-hidden="true"></i>
								</button>
								@endif

							</td>
							<td>
							
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" 	onclick="verMetadatos('{{$dato->FEC_CREA}}', '{{$dato->NUM_PAGI}}', '{{$dato->TAM_ARCH}}', '{{$dato->SOF_CAPT}}', '{{$dato->VER_ARCH}}', '{{$dato->RES_ARCH}}', '{{$dato->IDI_ARCH}}')">
									Consultar
								</button>
								
							</td>
							<td>
								<a href="{{ route('fuid.edit', $dato->COD_ENTI.'_'.$dato->COD_TRD.'_'.$dato->NUM_REGI) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
								<a href="{{ route('fuid.destroy', $dato->COD_ENTI.'_'.$dato->COD_TRD.'_'.$dato->NUM_REGI)}}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el registro seleccionado?')"></a> 	
							</td>		

							<!--<td>{{ $dato->NOM_DIGI}} </td>-->
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
</div>




<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	<div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        	<span aria-hidden="true">&times;</span>
	        </button>
	        
	      </div>
	      <div class="modal-body">
	        <div id="contenidomodal"></div>
      	</div>
    </div>
  </div>
</div>




@endsection


@section('js')

<script src="{{ asset('template/plugins/select2/select2.full.min.js')}}"></script>

<script>
$(document).ready(function() {
  $(function () {
    $('#datainfo').removeAttr('width').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      dom: 'Bfrtip',
      buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            },
            {
                text:      '<span class="glyphicon glyphicon-search" aria-hidden="true"> </span>',
                titleAttr: 'Buscar',
                action: function ( e, dt, node, config ) {
                    $( "#buscarF" ).submit();
                }
                
            },
            {
                text: '<span class="fa fa-plus-circle" aria-hidden="true"> </span>',
                titleAttr: 'Añadir',
                action: function ( e, dt, node, config ) {
                    $( "#createR" ).submit();
                }
                
            }




        ],
         "language": {
            "lengthMenu": "Mostrando _MENU_ registros por pagina",
            "zeroRecords": "Sin resultados",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtro desde _MAX_ total registros)",
            "search": "Buscar",
            "showing":"Mostrando"
        },
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
        columnDefs: [
            { width: 60, targets: 5 },
            { width: 60, targets: 6 }
        ],
        fixedColumns: true
    });
  });



} );

</script>

	<script type="text/javascript">
		  $(".select2").select2();

		  function cargarmodal(ruta, data)
		  {
		  		
		  		if(ruta == '' )
				{
					url = "{{url('/')}}";
					url = url+'/documentos/'
				}
				else
				{
					url = ruta;
				}

		  		res = '<iframe src="https://docs.google.com/viewerng/viewer?url='+url+data
		  		+'&embedded=true" style="border: none; width:100%; height: 35em;"></iframe>';

		  	$("#contenidomodal").html(res);
		  }

		  function verMetadatos(FEC_CREA, NUM_PAGI, TAM_ARCH, SOF_CAPT, VER_ARCH, RES_ARCH, IDI_ARCH)
		  {
		  	res = 	"Fecha Creación Archivo: " + FEC_CREA
				  	+"<br/>Número de Páginas: " + NUM_PAGI
					+"<br/>Tamaño Archivo: " + TAM_ARCH
					+"<br/>Software de Captura: " + SOF_CAPT
					+"<br/>Versión Archivo: " + VER_ARCH
					+"<br/>Resolución: " + RES_ARCH
					+"<br/>Idioma: " + IDI_ARCH
					+"";

			$("#contenidomodal").html(res);
		  }
	</script>


@endsection
