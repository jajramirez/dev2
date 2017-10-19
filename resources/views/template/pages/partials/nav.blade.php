<nav class="navbar navbar-static-top" style="
    background-color: #d7eef2;
">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="color: #0f3193;">
    <span class="sr-only">Navegador</span>
  </a>

  <img src="{{ asset('images/banner3.png')}}" 
      class="img-responsive"  
      style="
        
        float: left;
        position: relative;
        left: 25%;"/>

  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <span class="hidden-xs" style="color: #0f3193;"> Bienvenido {{Auth::user()->NOM_USUA}}
           </span>
        </a>
        <ul class="dropdown-menu">
          <!-- Menu Footer-->
          <li class="user-body">
            <div class="col-xs-4 text-center">
              <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                Salir
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>