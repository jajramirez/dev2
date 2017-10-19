@extends('template.pages.main')

@section('title')
    Descripción Subseries
@endsection


@section('name_aplication')
    <h1>
        Descripción Subseries
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
          {!! Form::open(['route' => 'meta.create' , 'method' => 'GET' ,'id' =>'createR'])!!}
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
			<th>Serie</th>
			<th>Subserie</th>
			<th>MET1</th>
			<th>MET2</th>
      <th>MET3</th>
      <th>MET4</th>
      <th>MET5</th>
      <th>MET6</th>
      <th>MET7</th>
      <th>MET8</th>
      <th>MET9</th>
      <th>MET10</th>
      <th>MET11</th>
			<th>Acción</th>
		</thead>
		<tbody>
			@foreach($ccds as $ccd)
				<tr>
					<!--<td>{{ $ccd->NUM_REGI}} </td>-->
					<td>{{ $ccd->COD_SERI}} </td>
					<td>{{ $ccd->COD_SUBS}} </td>
					<td>{{ $ccd->MET1}} </td>
          <td>{{ $ccd->MET2}} </td>
          <td>{{ $ccd->MET3}} </td>
          <td>{{ $ccd->MET4}} </td>
          <td>{{ $ccd->MET5}} </td>
          <td>{{ $ccd->MET6}} </td>
          <td>{{ $ccd->MET7}} </td>
          <td>{{ $ccd->MET8}} </td>
          <td>{{ $ccd->MET9}} </td>
          <td>{{ $ccd->MET10}} </td>
          <td>{{ $ccd->MET11}} </td>
					<td>
						<a href="{{ route('meta.edit', $ccd->COD_ENTI.'_'.$ccd->NUM_REGI) }}"  class="btn btn-warning fa fa-pencil" title="Editar Registro"></a>
						<a href="{{ route('meta.destroy', $ccd->NUM_REGI) }}" class="btn btn-danger fa fa-times" title="Eliminar Registro" onclick ="return confirm('Desea eliminar el registro seleccionado?')"></a> 	
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
