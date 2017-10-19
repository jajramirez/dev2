@extends('template.pages.main')

@section('title')
    Invalido
@endsection

@section('content')

      <div class="error-page">
        <h2 class="headline text-yellow"> 403</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i>Página no disponible</h3>

          <p>
            No tiene permisos para ingresar a la página solicitada..
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
        <!-- /.error-content -->
      </div>



</div>

@endsection

