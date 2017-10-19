@extends('template.pages.main')

@section('title')
    Lista
@endsection


@section('name_aplication')
    <h1>
      
    </h1>
@endsection


@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista FUID</h3>
            </div>
     
	<div class="box-body table-responsive no-padding">
	<table id='datainfo' class="table table-bordered table-hover">
		<thead>
			<th>No.ORD.</th>
			<th>CODIGO</th>
			<th>SERIE</th>
			<th>ASUNTO</th>
			<th>SUBS</th>
			<th>CONSECUTIVO</th>
			<th>FECHA INICIAL</th>
			<th>FECHA FINAL</th>
			<th>CARPETA</th>
			<th>TOMO</th>
			<th>CAJA</th>
			<th>CONSECUTIVO BODEGA</th>
			<th>No. DE FOLIOS</th>
			<th>FRECUENCIA CONSULTA</th>
			<th>DIGITALIZADOR</th>
			<th>NOMBRE ARCHIVO</th>
			<th>OBSERVACIONES	</th>
			<th>NUMERO ENTREGA</th>
		</thead>
		<tbody>
			@if($datos != null)
				
				@foreach($datos as $dato)
					
					<tr>
						<td>{{ $dato->NUM_REGI}} </td>
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
						<td>{{ $dato->NUM_DOCU}} </td>
						<td>{{ $dato->FEC_INIC}} </td>
						<td>{{ $dato->FEC_FINA}} </td>
						<td>{{ $dato->NUM_CARP}} </td>
						<td>{{ $dato->NUM_TOMO}} </td>
						<td>{{ $dato->NUM_CAJA}} </td>
						<td>{{ $dato->NUM_INTE}} </td>
						<td>{{ $dato->NUM_FOLI}} </td>
						<td>{{ $dato->FRE_CONS}} </td>
						<td>{{ $dato->NOM_DIGI}} </td>
						<td><a href="documentos/{{ $dato->NOM_ARCH}}" download>{{ $dato->NOM_ARCH}}</a> </td>
						<td>{{ $dato->OBS_GEN1}} </td>
						<td>{{ $dato->OBS_GEN2}} </td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
	</div>
</div>
</div>
@endsection


@section('js')

<script>
  $(function () {
    $('#datainfo').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
</script>
@endsection