@extends('template.pages.main')

@section('title')
    CODIGO BARRAS
@endsection


@section('name_aplication')
    <h1>
        Generar Código de barras
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
           
              <div class="col-xs-12">
                <div class='form-group'>
                  

                  <?php
                    $h = (int)$hasta+1;
                    for($i=(int)$desde; $i < $h; $i++)
                    {
                      echo '<div class="col-xs-4">';
                      echo 'Codigo Numero: '.$i;
                      echo $d->getBarcodeHTML($i, "EAN13");
                      echo '<br/>';
                      echo '</div>';
                
                    }
                  ?>



                </div>
              </div>
          </div>
          
        </div>
      </div>
    </div>
@endsection

@section('js')
<script>

</script>
@endsection
