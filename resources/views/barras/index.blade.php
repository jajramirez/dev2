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
              {!! Form::open(['route' => 'barras.create' , 'method' => 'GET' ,'id' =>'createR'])!!}

              <div class="col-xs-12">
                <div class='form-group'>
                  {!! Form::label('desde', 'Desde')!!}
                  {!! Form::text('desde', null, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
                </div>
              </div>


              <div class="col-xs-12">
                <div class='form-group'>
                  {!! Form::label('hasta', 'Hasta')!!}
                  {!! Form::text('hasta', null, ['class' => 'form-control' , 'placeholder' => '', 'required'])!!}
                </div>
              </div>

              <div class="col-xs-12">
                <div class='form-group'> 
                  {!! Form::submit('Generar',['class' => 'btn btn-primary'] )!!}
                </div>
              </div>
              {!! Form::close() !!}
          </div>
          
        </div>
      </div>
    </div>
@endsection

@section('js')
<script>

</script>
@endsection
