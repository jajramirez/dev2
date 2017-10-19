   
@extends('template.pages.main')

@section('title')
    Error
@endsection

@section('content')

    <div class="error-page">
        <h2 class="headline text-red">500</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i> Oops! Algo esta mal</h3>

          <p>
            Se presenta un error desconocido.
          </p>

          <form class="search-form">
            <div class="input-group">
              <lavel>
                Comunicarse con el administrador
              </lavel> 

            </div>
            <!-- /.input-group -->
          </form>
      </div>

@endsection


