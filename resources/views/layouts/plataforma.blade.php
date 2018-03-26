<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=0.4, maximum-scale=2, minimum-scale=0.4">
    <meta name="description" content="">
    <meta name="author" content="Cristhian Marcelo Flores Lopez">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicons.png">

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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    @yield('header')

</head>

<body class="fix-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0" style="position: sticky;">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="Buscar..." class="form-control">
                            <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li>
                </ul>
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
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav in" id="side-menu">
                    <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <!-- input-group -->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="bUSCAR...">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                            </span> </div>
                                        <!-- /input-group -->
                    </li>

                    {{-- <li class=" m-t-10">--Subsistema de Planificación</li> --}}

                    {{-- <li>
                      <a id="modulopdes" href="{{ url('modulopdes/indicadores')}}" class="waves-effect"><img src="{{ asset('img/pdes-logo.png') }}" width="100" alt="home" /><span class="hide-menu" >MODULO PDES</span></a>
                    </li> --}}

                    @foreach($modulos as $m)
                      <li class="">
                            <a id="mod-{{ $m["id_html"] }}" href="{{ url($m["url"])}}" class="waves-effect" target="{{ url($m["target"])}}">
                              <img src="{{ asset('img/'.$m["icono"]) }}" width="100" alt="home" />
                              <span class="hide-menu" >{{ $m["titulo"] }}</span>
                          </a>
                      </li>
                    @endforeach

                    {{-- <li> <a href="{{ url('moduloIndicadores/dashboard')}}" class="waves-effect"><img src="img/indicadores-logo.png" width="100" alt="home" /><span class="hide-menu" >CATALOGO INDICADORES</span></a> </li> --}}



                </ul>
            </div>
        </div>

        <!-- Left navbar-header end -->
        <!-- Page Content -->

        <div id="page-wrapper">
          <div class="container-fluid" style="padding-left: 0px; padding-right: 0px;">
              <div class="row">
                <div class="col-lg-12">
                  {{-- <header>
                    <input type="checkbox" id="btn-menu">
                    <label for="btn-menu" class="ti-menu"></label>
                    <nav class="menu">
                      <ul>
                        <li><a href="#"><i class="fa fa-cogs"></i> Dashboard</a></li>
                        <li class="submenu"><a href="#"><i class="fa fa-cogs"></i> Indicadores <span class="icon-arrow-down"></span></a>
                          <ul>
                            <li><a href="#">Sub menu</a></li>
                            <li><a href="#">Sub menu</a></li>
                          </ul>
                        </li>
                        <li class="submenu"><a href="#"><i class="fa fa-cogs"></i> Proyectos<span class="icon-arrow-down"></span></a>
                          <ul>
                            <li><a href="#">Sub menu</a></li>
                            <li><a href="#">Sub menu</a></li>
                          </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-cogs"></i> Presupuesto</a></li>
                      </ul>
                    </nav>
                  </header> --}}

                  <a id="touch-menu" class="mobile-menu" href="#"><i class="ti-menu"></i> Menu</a>
                     <nav style="background:#5c6175;">
                       <ul class="menu">
                         @foreach($menus as $m)
                           <li class="">
                             @if( $m["submenus"] )
                               <a id="mp-{{ $m["id_html"] }}"  href="{{ url( $m["url"] ) }}"> <i class="{{ $m["icono"] }}"></i> {{ $m["titulo"] }}</a>
                               <ul>
                                 @foreach($m["submenus"] as $sm)
                                   <li id="{{ $sm->id }}" ><a href="{{ $sm->url }}">{{ $sm->titulo }}</a></li>
                                 @endforeach
                               </ul>
                             @else
                               <a id="mp-{{ $m["id_html"] }}"  href="{{ url( $m["url"] ) }}"> <i class="{{ $m["icono"] }}"></i> {{ $m["titulo"] }}</a>
                             @endif
                           </li>
                         @endforeach
                      </ul>
                    </nav>




                </div>
              </div>

                @yield('content')
                <!-- br/>
                <br/ -->
                <!-- /.container-fluid -->
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
            </div>
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
