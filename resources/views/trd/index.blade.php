@extends('template.pages.main')

@section('title')
    Dependencias
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/select2.min.css')}} ">
@endsection


@section('name_aplication')
    <h1>
        Tabla de Retención Documental
        <small></small>
    </h1>
    <ol class="breadcrumb">
    </ol>
@endsection





@section('content')

	<div class="row">
        <div class="col-xs-12">
          	<div class="box">
			
			{!! Form::open(['route' => 'trd.index', 'method' => 'GET', 'id'=>'buscarF']) !!}
	            <div class="row">

	                <div class="col-xs-4">
		                <div class="form-group">
				            <select id='COD_ORGA' name='COD_ORGA' class="form-control select2" onchange="url()" >                 
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
	                <input type="text" name="data" value="1" style="display:none">
	                <div class="col-xs-4">
	                 	<div class="form-group">
				            <select id='COD_SERI' name='COD_SERI' class="form-control select2" onchange="url()">
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
	                <div class="col-xs-1">
						
					</div>
					<div class="row">
						<!--<div class="col-xs-1">	

							<a target="_blank" href="excel/{{$corga.'/'.$cseri}}" class="btn btn-primary">Exportar Detalle</a>
							<input type="text" id="urlExcel" value="excel/{{$corga.'/'.$cseri}}" style="display:none"/>
						</div>
					-->
						<div class="col-xs-9">
						</div>
		                <div class="col-xs-1">
			                	<div class="form-group">	
									<button type="submit" class="btn btn-primary" style="display:none">
								  		<span class="glyphicon glyphicon-search" aria-hidden="true"> </span>
								 	</button>
								</div>
						</div>

				


					</div>
				</div>
			{!! Form::close()!!}

			<form action="excel/{{$corga.'/'.$cseri}}" id="exportarF">
				<input type="submit" value="This is a button link" style="display:none">
			</form>

					<div class="row">
							
					          {!! Form::open(['route' => 'trd.create' , 'method' => 'GET' ,'id' =>'createR'])!!}
					          <button type="submit" class="btn btn-primary"  style="display:none">
					               <span class="fa fa-plus-circle" aria-hidden="true"> </span>
					            </button>  
					          {!! Form::close() !!}
     		</div>
	     
				<div class="box-body table-responsive no-padding">
					<table id='datainfo' class="table table-bordered table-hover">
						<thead>

							<th>Código</th>
							<th>Serie</th>
							<th> Sub serie</th>
							<th>Gestión</th>
							<th>Central</th>
							<th>Conservación Total</th>
							<th>Eliminación</th>
							<th>Microfilmación</th>
							<th>Selección</th>
							<th>Observaciones</th>
							<th>Soporte</th>
						
							<?php /*
								for($i=0; $i<=200; $i++)
								{
									echo '<th style="display:none"></th>';
								}*/
							?>
							<th>Estado</th>
							
							<!-- <th>Fecha</th>
							<th>Hora</th> -->
							<th>Acción</th>
						</thead>
						<tbody>
							@if($deps != null)
							@foreach($deps as $dep)
								<tr>	
									<td>{{ $dep->COD_TRD}} </td>
									<td>{{ $dep->NOM_SERI}} </td>
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
									<td>{{ $dep->ARC_GEST}} </td>
									<td>{{ $dep->ARC_CENT}} </td>
									<td>
										@if( $dep->BAN_CT == "1")
											SI
										@endif
									</td>
									<td>
										@if( $dep->BAN_E == "1")
											SI
										@endif
									</td>
									<td>
										@if( $dep->BAN_M == "1")
											SI
										@endif
									</td>
									<td>
										@if( $dep->BAN_S == "1")
											SI
										@endif		
									</td>
									<td>{{ $dep->TEX_OBSE}} </td>
									<td> </td>
									
									<?php
										/*
										if(count($info)>= $secuencia)
										{ 
												$dac = $info[$secuencia];
												$contador = 0;

												foreach($dac as $v)
												{
													echo( '<td style="display:none">'.$v->NOM_DESC.'</td>');
													$contador++;
												}

												for($contador; $contador<=200; $contador++)
												{
													echo( '<td style="display:none"></td>');
												}
												
										}
											$secuencia++
										*/
									?>
									
									<td>{{ $dep->IND_ESTA}} </td>
									
									<!-- <td>{{ $dep->COD_USUA}} </td>
									<td>{{ $dep->FEC_ACTU}} </td>
									<td>{{ $dep->HOR_ACTU}} </td> -->
									<td>

										<a href="{{ route('trd.edit', $dep->COD_ENTI.'_'.$dep->COD_TRD) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
										<a href="{{ route('trd.destroy', $dep->COD_ENTI.'_'.$dep->COD_TRD) }}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el registro seleccionado?')"></a> 	
									</td>		
									
									
								</tr>							
							@endforeach
							@endif
						</tbody>
					</table>
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
    $('#datainfo').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
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
            	text: 'Exportar Detalle',
            	action: function ( e, dt, node, config ) {
            		var cod_seri = ($("#COD_SERI").val());
					var s = cod_seri.length;
					var cod_orga = ($("#COD_ORGA").val());
		            var n = cod_orga.length;
		            if(s == 0 && n == 0)
		            {
		            	alert("Seleccione una oficina productora");
		            }
		            else{
                    $( "#exportarF" ).submit();
                	}

                }
                
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
            "search": "Buscar"
        }
    });
  });
} );

	function url()
	{
		var seri, orga;
		var cod_seri = ($("#COD_SERI").val());
		var n = cod_seri.length;
		if(n>0)
		{
			seri = cod_seri;
		}
		else
		{
			seri= "0";
		}
		var cod_orga = ($("#COD_ORGA").val());
		var n = cod_orga.length;
		if(n>0)
		{
			orga = cod_orga;
		}
		else
		{
			orga= "0";
		}
		$("#exportarF").attr("action", 'excel/'+orga+'/'+seri);
	}




</script>

<script type="text/javascript">
		  $(".select2").select2();
</script>


@endsection
