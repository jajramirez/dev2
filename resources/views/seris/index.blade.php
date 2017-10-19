@extends('template.pages.main')

@section('title')
Series
@endsection

@section('name_aplication')
    <h1>
        Series Documentales
        <small></small>
    </h1>
    <ol class="breadcrumb">
    </ol>
@endsection





@section('content')

	<div class="row">
        <div class="col-xs-12">
          <div class="box">

    <div class="row">
          {!! Form::open(['route' => 'seris.create' , 'method' => 'GET' ,'id' =>'createR'])!!}
          <button type="submit" class="btn btn-primary"  style="display:none">
               <span class="fa fa-plus-circle" aria-hidden="true"> </span>
            </button>  
          {!! Form::close() !!}
        </div>

	<hr>

	
     
			<div class="box-body table-responsive no-padding">
				<table id='datainfo' class="table table-bordered table-hover">
					<thead>
						<th style="width: 10px;">Código</th>
						<th>Nombre</th>
						<th>Estado</th>
						<!-- <th>Usuario</th>
						<th>Fecha</th>
						<th>Hora</th> -->
            <th>Metadatos</th>
						<th>Acción</th>
					</thead>
					<tbody>
						@foreach($seris as $seri)
							<tr>
								<td>{{ $seri->COD_SERI}} </td>
								<td>{{ $seri->NOM_SERI}} </td>
								<td>{{ $seri->IND_ESTA}} </td>
								<!-- <td>{{ $seri->COD_USUA}} </td>
								<td>{{ $seri->FEC_ACTU}} </td>
								<td>{{ $seri->HOR_ACTU}} </td> -->
                <td>
                     {!! Form::open(['route' => 'meta.subserie' , 'method' => 'POST' ])!!}
                     <input type="text" style="display:none" value="{{$seri->COD_ENTI}}" name="COD_ENTI"> 
                     <input type="text" style="display:none" value="{{$seri->COD_SERI}}" name="COD_SERI"> 
                      <button type="submit" class="btn btn-success" title="Añadir Metadatos" >
                           <span class="fa fa-clone" aria-hidden="true"> </span>
                        </button>  
                      {!! Form::close() !!}
    
                </td>
								<td>
									<a href="{{ route('seris.edit', $seri->COD_ENTI.'_'.$seri->COD_SERI) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
									<a href="{{ route('seris.destroy', $seri->COD_ENTI.'_'.$seri->COD_SERI) }}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el registro seleccionado?')"></a> 	
								</td>		
								
								
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
@endsection

@section('js')

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

</script>

@endsection
