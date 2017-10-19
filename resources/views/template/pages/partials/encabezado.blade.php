<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="ANSI">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title') | SID</title>

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('template/bootstrap/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-3.1.3/dt-1.10.15/af-2.2.0/b-1.3.1/b-html5-1.3.1/kt-2.2.1/datatables.min.css"/>

  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css')}}">

  <style>
    .tam_img{
      width: 43%;
    }

    @media only screen and (max-width: 750px) {
    /* Aqui pones los estilos de la página */
      .tam_img{
        width: 5%;
      }
    }

  </style>

    @yield('css')
  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">