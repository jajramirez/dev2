  
  @include('template.pages.partials.encabezado')


<div class="wrapper">

  <header class="main-header" >

    <!-- Logo -->
    <a style="background-color: #1D0094; height: auto;" href="{{ route('home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
     
      <!-- logo for regular state and mobile devices class="tam_img"  -->
      <img src="{{ asset('images/esap_izq3.png')}}"  />

    </a>
  
    @include('template.pages.partials.nav')
    
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  @include('template.pages.partials.aside')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('name_aplication')
      
    </section>
    
    <!-- Main content -->
    <section class="content">
       @yield('content')
      @include('flash::message')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2017 <a href="#"></a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

  @include('template.pages.partials.footer')