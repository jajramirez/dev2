<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <div class="user-panel">
    </div>
    <ul class="sidebar-menu">
      <li class="header">
        <br/>
      </li>
      <li class="active treeview ">
          <a href="#">
            <i class=""></i> <span>MENU PRINCIPAL </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php
              $class = array('','','','','','','','','','', '', '', '', '');
              $url = \Request::getPathInfo();
              $url_array = explode('/', $url);
              if($url_array[1]=="dependencias")
              {
                $class[0] = 'class=active';
              }
              if($url_array[1]=="seris")
              {
                $class[1] = 'class=active';
              }
              if($url_array[1]=="ccd")
              {
                $class[2] = 'class=active';
              }
              if($url_array[1]=="trd")
              {
                $class[3] = 'class=active';
              }
              if($url_array[1]=="listafuid")
              {
                $class[4] = 'class=active';
              }
              if($url_array[1]=="cargafuid")
              {
                $class[5] = 'class=active';
              }
              if($url_array[1]=="expedientes")
              {
                $class[6] = 'class=active';
              }
              if($url_array[1]=="reportes")
              {
                $class[7] = 'class=active';
              }
              if($url_array[1]=="usuarios")
              {
                $class[8] = 'class=active';
              }
              if($url_array[1]=="detalle")
              {
                $class[6] = 'class=active';
              }
              if($url_array[1]=="meta")
              {
                $class[2] = 'class=active';
              }
              if($url_array[1]=="prestamo")
              {
                $class[7] = 'class=active';
              }
               if($url_array[1]=="pdf")
              {
                $class[10] = 'class=active';
              }
              if($url_array[1]=="barras")
              {
                $class[13] = 'class=active';
                $class[12] = 'class=active';
              }
    
	      if(count($url_array) >  2 ) {
              if($url_array[2]=="cargararchivo")
              {
                $class[3] = '';
                $class[9] = 'class=active';
              }
	           
              if($url_array[2]=="etiquetas")
              {
                $class[11] = 'class=active';
                $class[12] = 'class=active';
              }
              }

            ?>

            @if(Auth::user()->COD_ROLE == "1")
            <li {{$class[0]}}><a style="font-size:90%;" href="{{ route('dependencias.index') }}"><i class="fa fa-circle-o"></i> Estructura Orgánica</a></li>
            <li {{$class[1]}}><a style="font-size:90%;" href="{{ route('seris.index') }}"><i class="fa fa-circle-o"></i> Series Documentales</a></li>
            <li {{$class[2]}}><a style="font-size:90%;" href="{{ route('ccd.index') }}"><i class="fa fa-circle-o"></i> Subseries</a></li>
            <li {{$class[3]}}><a style="font-size:90%;" href="{{ route('trd.index') }}"><i class="fa fa-circle-o"></i> Tabla de Retención Documental</a></li>
            <li {{$class[9]}}><a style="font-size:90%;" href="{{ route('trd.cargararchivo') }}"><i class="fa fa-circle-o"></i> Carga Retención Documental</a></li>
            <li {{$class[4]}}><a style="font-size:90%;" href="{{ route('home.fuid') }}"><i class="fa fa-circle-o"></i> FUID</a></li>
            <li {{$class[5]}}><a href="{{ route('home.carga') }}"><i class="fa fa-circle-o"></i> Carga de FUID</a></li>
            <li {{$class[6]}}><a style="font-size:90%;" href="{{ route('expedientes.index') }}"><i class="fa fa-circle-o"></i> Expedientes Electrónicos</a></li>
            <li {{$class[10]}}><a style="font-size:90%;" href="#"><i class="fa fa-circle-o"></i> Reportes y Consulta</a>
               <ul class="treeview-menu">
                <li>
                  <a href="{{ route('pdf.index') }}">
                    <i class="fa fa-circle-o"></i> 
                      Retención Documental
                  </a>
                </li>
                  
           
              </ul>

            </li>
            <li {{$class[7]}}><a style="font-size:90%;" href="{{ route('prestamo.index') }}"><i class="fa fa-circle-o"></i>Prestamos</a></li>


            <li {{$class[12]}}><a style="font-size:90%;" href="#"><i class="fa fa-circle-o"></i> Etiquetas</a>
               <ul class="treeview-menu">
                <li {{$class[11]}}><a style="font-size:90%;" href="{{ route('fuid.etiquetas') }}"><i class="fa fa-circle-o"></i>Etiquetas de Carpeta</a></li>
                <li {{$class[13]}}><a style="font-size:90%;" href="{{ route('barras.index') }}"><i class="fa fa-circle-o"></i>Etiquetas de Cajas</a></li>
           
              </ul>

            </li>


            <li {{$class[8]}}><a style="font-size:90%;" href="{{ route('usuarios.index') }}"><i class="fa fa-circle-o"></i> Usuarios</a></li>
            @endif

            @if(Auth::user()->COD_ROLE == "2")
            <li {{$class[3]}}><a style="font-size:90%;" href="{{ route('trd.index') }}"><i class="fa fa-circle-o"></i> Tabla de Retención Documental</a></li>
            <li {{$class[4]}}><a style="font-size:90%;" href="{{ route('home.fuid') }}"><i class="fa fa-circle-o"></i> FUID</a></li><li {{$class[6]}}><a style="font-size:90%;" href="{{ route('expedientes.index') }}"><i class="fa fa-circle-o"></i> Expedientes Electrónicos</a></li>
             <li {{$class[5] }}><a href="{{ route('home.carga') }}"><i class="fa fa-circle-o"></i> Carga de FUID</a></li>
            <li {{$class[6]}}><a style="font-size:90%;" href="{{ route('expedientes.index') }}"><i class="fa fa-circle-o"></i> Expedientes Electrónicos</a></li>
            <li {{$class[7]}}><a style="font-size:90%;" href="#"><i class="fa fa-circle-o"></i> Reportes y Consulta</a>
               <ul class="treeview-menu">
                <li>
                  <a href="{{ route('pdf.index') }}">
                    <i class="fa fa-circle-o"></i> 
                      Retención Documental
                  </a>
                </li>
                  
           
              </ul>

            </li>
            @endif

            @if(Auth::user()->COD_ROLE == "3")
             <li {{$class[4]}}><a style="font-size:90%;" href="{{ route('home.fuid') }}"><i class="fa fa-circle-o"></i> FUID</a></li>
            <li {{$class[6]}}><a style="font-size:90%;" href="{{ route('expedientes.index') }}"><i class="fa fa-circle-o"></i> Expedientes Electrónicos</a></li>
            <li {{$class[7]}}><a style="font-size:90%;" href="#"><i class="fa fa-circle-o"></i> Reportes y Consulta</a></li>
            @endif


           </ul>
        </li>


    </ul>
  </section>
  <!-- /.sidebar -->
</aside>



