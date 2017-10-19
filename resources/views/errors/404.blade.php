@extends('template.pages.main')

@section('title')
    Error
@endsection

@section('content')

      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i>Página no econtrada</h3>

          <p>
            La página ingresada no existe.
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

