@extends('template.pages.main')

@section('title')
    CCD
@endsection


@section('name_aplication')
    <h1>
        Subseries
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
          {!! Form::open(['route' => 'ccd.create' , 'method' => 'GET' ,'id' =>'createR'])!!}
          <button type="submit" class="btn btn-primary"  style="display:none">
               <span class="fa fa-plus-circle" aria-hidden="true"> </span>
            </button>  
          {!! Form::close() !!}
        </div>

	<hr>


     
	<div class="box-body table-responsive no-padding">
	<table id='datainfo' class="table table-bordered table-hover">
		<thead>
			<!--<th>Numero Registro</th>-->
			<th>Código</th>
			<th>Subserie</th>
			<th>Nombre</th>
			<th>Estado</th>
     
			<!-- <th>Usuario</th>
			<th>Fecha</th>
			<th>Hora</th> -->
			<th>Acción</th>
		</thead>
		<tbody>
			@foreach($ccds as $ccd)
				<tr>
					<!--<td>{{ $ccd->NUM_REGI}} </td>-->
					<td>{{ $ccd->COD_SERI}} </td>
					<td>{{ $ccd->COD_SUBS}} </td>
					<td>{{ $ccd->NOM_SUBS}} </td>
					<td>{{ $ccd->IND_ESTA}} </td>
					<!-- <td>{{ $ccd->COD_USUA}} </td>
					<td>{{ $ccd->FEC_ACTU}} </td>
					<td>{{ $ccd->HOR_ACTU}} </td>
					-->
					
         <td>
						<a href="{{ route('ccd.edit', $ccd->COD_ENTI.'_'.$ccd->NUM_REGI) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
						<a href="{{ route('ccd.destroy', $ccd->COD_ENTI.'_'.$ccd->NUM_REGI) }}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el registro seleccionado?')"></a> 	
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
