<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets_home/assets/img/iconos/sp_icono.png">
    <title>SPIE - Subsistema de Planificación</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap Core CSS -->
    <link href="/css/tpl_planificacion.css" rel="stylesheet">
    <style>
      .navbar-static-top .navbar-default{
        z-index: 1000;
      }
    </style>
    @yield('header')

</head>

<body class="fix-header">
    <div id="app">    <!-- Preloader -->
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <div id="wrapper">
            <!-- Top Navigation -->
            <nav class="navbar navbar-default navbar-static-top m-b-0">
                <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                    <div class="top-left-part">
                      <a class="logo" href="{{url ('/planesTerritoriales/index') }}"><b><img src="/img/sp_icono_60x60.png" alt="SP" />
                      </b><span class="hidden-xs"> <img src="/img/text_sp.png" alt="SP" /> </span>
                      </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right pull-right">
                        <li class="right-side-toggle">
                          <a class="waves-effect waves-light" href="javascript:void(0)">
                            <i class="ti-settings"></i>
                          </a>
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                </div>
                <!-- /.navbar-header -->
                <!-- /.navbar-top-links -->
                <!-- /.navbar-static-side -->
            </nav>
            <!-- End Top Navigation -->
            <!-- Left navbar-header -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                            <!-- input-group -->
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Buscar en sitio...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        @foreach($menus as $m)
                          <li>
                            @if( $m["submenus"] )
                              <a id="mp-{{ $m["id_html"] }}"  href="{{ url( $m["url"] ) }}" class="waves-effect">
                                <i class="linea-icon {{ $m["class"] }}"  data-icon="{{ $m["icono"] }}" style="font-size: 18px"></i>
                                <span class="hide-menu"> {{ $m["titulo"] }}</span>
                              </a>
                              <ul class="nav nav-second-level">
                                @foreach($m["submenus"] as $sm)
                                  <li id="{{ $sm->id }}" ><a href="{{ $sm->url }}">{{ $sm->titulo }}</a></li>
                                @endforeach
                              </ul>
                            @else
                              <a id="mp-{{ $m["id_html"] }}"  href="{{ url( $m["url"] ) }}" class="waves-effect">
                                <i class=" {{ $m["class"] }}" data-icon="{{ $m["icono"] }}" style="font-size: 18px;"></i>
                                <span class="hide-menu"> {{ $m["titulo"] }}</span>
                              </a>
                            @endif
                          </li>
                        @endforeach



                    </ul>
                </div>
            </div>
            <!-- Left navbar-header end -->
            <!-- Page Content -->
            <div id="page-wrapper">
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
                                <li><a href="{{ url('/home') }}"><i class="fa icon-logout"></i> Salir a menu </a></li>
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
                <footer class="footer text-center"> 2018 &copy; MPD </footer>
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
    </div>
    <!-- jQuery -->
    <script src="/js/tpl_planificacion.js"></script>
    <script src="/js/app-planificacion.js"></script>
    <script type="text/javascript">
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();
    </script>
    @stack('script-head')

</body>

</html>
