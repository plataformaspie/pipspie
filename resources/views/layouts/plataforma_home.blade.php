<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1, maximum-scale=3, minimum-scale=5"-->
    <meta name="description" content="">
    <meta name="author" content="Cristhian Marcelo Flores Lopez">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">


    <title>Plataforma SPIE</title>
      <!-- Bootstrap Core CSS -->
      <link href="{{ asset('sty-home/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
      <link href="{{ asset('plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css') }}" rel="stylesheet">
      <!-- Menu CSS -->
      <link href="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
      <link href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}" rel="stylesheet" type="text/css" />
      <!-- animation CSS -->
      <link href="{{ asset('sty-home/css/animate.css') }}" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="{{ asset('sty-home/css/style.css') }}" rel="stylesheet">
      <!-- color CSS you can use different color css from css/colors folder -->
      <link href="{{ asset('sty-home/css/colors/default.css') }}" id="theme" rel="stylesheet">

      {{-- <link href="{{ asset('css/fontello.css') }}" rel="stylesheet"> --}}
      <link href="{{ asset('css/auxmenu.css') }}" rel="stylesheet">

      @yield('header')
</head>

<body class="fix-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <!-- Toggle icon for mobile view -->
                <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <!--li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="Search..." class="form-control">
                            <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li-->
                </ul>
                <!-- Search input and Toggle icon -->
                <!-- /.dropdown-messages -->
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <!-- /.dropdown -->
                    <li class="right-side-toggle">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                          <i class="fa fa-user img-circle"></i> <b class="hidden-xs">{{ Auth::user()->name }}</b>
                        </a>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <div class="top-left-part"><a class="logo" href="{{url('home')}}"><b><img src="{{ asset('img/spie-ico-b.png') }}" width="50" alt="home" /></b><span class="hidden-xs">Plataforma SPIE</span></a></div>
            </div>
            <!-- /.Logo -->
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                  @foreach($modulos as $m)
                    <li class="">
                          <a id="mod-{{ $m["id_html"] }}" href="{{ url($m["url"])}}" class="waves-effect"
                            @if($m["target"])
                            target="{{ url($m["target"])}}"
                            @endif
                          >
                          <img src="{{ asset('img/'.$m["icono"]) }}" width="100" alt="home" />
                          <span class="hide-menu" >{{ $m["titulo"] }}</span>
                        </a>
                    </li>
                  @endforeach
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                @yield('content')

                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> {{ Auth::user()->name }} <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul>
                                <li><b>Opciones</b></li>
                            </ul>
                            <ul class="">
                                <li><a href="#"><i class="ti-user"></i> Mi perfil</a></li>
                                <li><a href="#"><i class="ti-wallet"></i> Cambiar contraseña</a></li>

                                <li role="separator" class="divider"></li>
                                <li><a href="{{ url('/home') }}"><i class="fa icon-logout"></i> Cerrar Modulos </a></li>
                                <li>
                                  <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Cerrar Sesión </a>
                                  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                          {{ csrf_field() }}
                                  </form>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <!-- /.right-sidebar -->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> 2017 &copy; Ministerio de Planificación del Desarrollo - Viceministerio Planificación y Coordinación </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('sty-home/bootstrap/dist/js/tether.min.js') }}"></script>
    <script src="{{ asset('sty-home/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('sty-home/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('sty-home/js/waves.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('sty-home/js/custom.js') }}"></script>
    <!--Style Switcher -->
    <script src="{{ asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>

    <script src="{{ asset('js/auxmenu.js') }}"></script>
    @stack('script-head')
</body>

</html>
