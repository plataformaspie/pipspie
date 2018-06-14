<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>::PIPSPIE::</title>
    <meta name="keywords" content="HTML5 Bootstrap3" />
    <meta name="description" content="Viceministerio de Planificacion y Coordinacion">
    <meta name="author" content="CristhianFloresLopez">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font CSS (Via CDN) -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">

    <!-- Required Plugin CSS -->
    <!--link rel="stylesheet" type="text/css" href="{{ asset('sty-mode-2/assets/js/utility/highlight/styles/googlecode.css') }}"-->

    @yield('headerIni')

    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('sty-mode-2/vendor/plugins/magnific/magnific-popup.css') }}">
    <!-- Admin Forms CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('sty-mode-2/assets/admin-tools/admin-forms/css/admin-forms.css') }}">
    <!-- Admin Modals CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('sty-mode-2/assets/admin-tools/admin-plugins/admin-modal/adminmodal.css') }}">
    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href=" {{ asset('sty-mode-2/assets/skin/default_skin/css/theme.css') }} ">

    <!-- Admin Panels CSS -->
    <!--link rel="stylesheet" type="text/css" href="{{ asset('sty-mode-2/assets/admin-tools/admin-plugins/admin-panels/adminpanels.css') }}"-->

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('sty-mode-2/assets/img/favicon.ico') }} ">
    @yield('header')

</head>

<body class="admin-panels-page" data-spy="scroll" data-target="#nav-spy" data-offset="300">
    <!-- Start: Main -->
    <div id="main">
        <!-- Start: Header -->
        <header class="navbar navbar-fixed-top bg-light">
            <div class="navbar-branding">
                <a class="navbar-brand" href="dashboard.html"> <img src="{{ asset('img/spie-ico-b.png') }}" width="50" alt="home" /> <b></b>Plataforma </a>
                <span id="toggle_sidemenu_l" class="glyphicons glyphicons-show_lines"></span>
                <ul class="nav navbar-nav pull-right hidden">
                    <li>
                        <a href="#" class="sidebar-menu-toggle">
                            <span class="octicon octicon-ruby fs20 mr10 pull-right "></span>
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a class="sidebar-menu-toggle" href="#">
                        <span class="octicon octicon-ruby fs18"></span>
                    </a>
                </li>
                <li>
                    <a class="topbar-menu-toggle" href="#">
                        <span class="glyphicons glyphicons-show_thumbnails fs16"></span>
                    </a>
                </li>
                <li>
                    <span id="toggle_sidemenu_l2" class="glyphicon glyphicon-log-in fa-flip-horizontal hidden"></span>
                </li>
                <li class="dropdown hidden">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicons glyphicons-settings fs14"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="javascript:void(0);">
                                <span class="fa fa-times-circle-o pr5 text-primary"></span> Reset LocalStorage </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <span class="fa fa-slideshare pr5 text-info"></span> Force Global Logout </a>
                        </li>
                        <li class="divider mv5"></li>
                        <li>
                            <a href="javascript:void(0);">
                                <span class="fa fa-tasks pr5 text-danger"></span> Run Cron Job </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <span class="fa fa-wrench pr5 text-warning"></span> Maintenance Mode </a>
                        </li>
                    </ul>
                </li>
                <li class="hidden-xs">
                    <a class="request-fullscreen toggle-active" href="#">
                        <span class="octicon octicon-screen-full fs18"></span>
                    </a>
                </li>
            </ul>
            <form class="navbar-form navbar-left navbar-search ml5" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Buscar..." value="Buscar...">
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">

                <!--li class="dropdown dropdown-item-slide">
                    <a class="dropdown-toggle pl10 pr10" data-toggle="dropdown" href="#">
                        <span class="octicon octicon-radio-tower fs18"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-hover dropdown-persist pn w350 bg-white animated animated-shorter fadeIn" role="menu">
                        <li class="bg-light p8">
                            <span class="fw600 pl5 lh30"> Notifications</span>
                            <span class="label label-warning label-sm pull-right lh20 h-20 mt5 mr5">12</span>
                        </li>
                        <li class="p10 br-t item-1">
                            <div class="media">
                                <a class="media-left" href="#"> <img src="assets/img/avatars/2.jpg" class="mw40" alt="holder-img"> </a>
                                <div class="media-body va-m">
                                    <h5 class="media-heading mv5">Article <small class="text-muted">- 08/16/22</small> </h5> Last Updated 36 days ago by
                                    <a class="text-system" href="#"> Max </a>
                                </div>
                            </div>
                        </li>
                        <li class="p10 br-t item-2">
                            <div class="media">
                                <a class="media-left" href="#"> <img src="assets/img/avatars/3.jpg" class="mw40" alt="holder-img"> </a>
                                <div class="media-body va-m">
                                    <h5 class="media-heading mv5">Article <small class="text-muted">- 08/16/22</small> </h5> Last Updated 36 days ago by
                                    <a class="text-system" href="#"> Max </a>
                                </div>
                            </div>
                        </li>
                        <li class="p10 br-t item-3">
                            <div class="media">
                                <a class="media-left" href="#"> <img src="assets/img/avatars/4.jpg" class="mw40" alt="holder-img"> </a>
                                <div class="media-body va-m">
                                    <h5 class="media-heading mv5">Article <small class="text-muted">- 08/16/22</small> </h5> Last Updated 36 days ago by
                                    <a class="text-system" href="#"> Max </a>
                                </div>
                            </div>
                        </li>
                        <li class="p10 br-t item-4">
                            <div class="media">
                                <a class="media-left" href="#"> <img src="assets/img/avatars/5.jpg" class="mw40" alt="holder-img"> </a>
                                <div class="media-body va-m">
                                    <h5 class="media-heading mv5">Article <small class="text-muted">- 08/16/22</small> </h5> Last Updated 36 days ago by
                                    <a class="text-system" href="#"> Max </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li-->

                <!--li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="flag-xs flag-us"></span>
                        <span class="fw600">US</span>
                    </a>
                    <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                        <li>
                            <a href="javascript:void(0);" class="fw600">
                                <span class="flag-xs flag-in mr10"></span> Hindu </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="fw600">
                                <span class="flag-xs flag-tr mr10"></span> Turkish </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="fw600">
                                <span class="flag-xs flag-es mr10"></span> Spanish </a>
                        </li>
                    </ul>
                </li-->

                <li class="ph10 pv20 hidden-xs"> <i class="fa fa-circle text-tp fs8"></i>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
                        <img src="{{ asset('sty-mode-2/assets/img/avatars/1.jpg') }}" alt="avatar" class="mw30 br64 mr15">
                        <span>{{ Auth::user()->name }}</span>
                        <span class="caret caret-tp hidden-xs"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-persist pn w250 bg-white" role="menu">
                      <li class="br-t of-h">
                          <a href="#" class="fw600 p12 animated animated-short fadeInDown">
                              <span class="fa fa-gear pr5"></span> Mi perfil </a>
                      </li>
                        <li class="br-t of-h">
                            <a href="#" class="fw600 p12 animated animated-short fadeInDown">
                                <span class="fa fa-gear pr5"></span> Cambiar contraseña </a>
                        </li>
                        <li class="br-t of-h">
                            <a href="{{ url('/home') }}" class="fw600 p12 animated animated-short fadeInDown">
                                <span class="fa fa-gear pr5"></span> Cerrar Modulo </a>
                        </li>
                        <li class="br-t of-h">
                            <a href="#" class="fw600 p12 animated animated-short fadeInDown" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <span class="fa fa-power-off pr5"></span> Cerrar Sesión </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </header>
        <!-- End: Header -->

        <!-- Start: Sidebar -->
        <aside id="sidebar_left" class="sidebar-light nano nano-primary affix">
            <div class="nano-content">

                <!-- Start: Sidebar Header -->
                <header class="sidebar-header">
                    <div class="user-menu">
                        <div class="row text-center mbn">
                            <div class="col-xs-4">
                                <a href="#" class="text-primary" data-toggle="tooltip" data-placement="top" title="Dashboard">
                                    <span class="glyphicons glyphicons-home"></span>
                                </a>
                            </div>
                            <div class="col-xs-4">
                                <a href="#" class="text-info" data-toggle="tooltip" data-placement="top" title="Messages">
                                    <span class="glyphicons glyphicons-inbox"></span>
                                </a>
                            </div>
                            <div class="col-xs-4">
                                <a href="#" class="text-alert" data-toggle="tooltip" data-placement="top" title="Tasks">
                                    <span class="glyphicons glyphicons-bell"></span>
                                </a>
                            </div>
                            <div class="col-xs-4">
                                <a href="#" class="text-system" data-toggle="tooltip" data-placement="top" title="Activity">
                                    <span class="glyphicons glyphicons-imac"></span>
                                </a>
                            </div>
                            <div class="col-xs-4">
                                <a href="#" class="text-danger" data-toggle="tooltip" data-placement="top" title="Settings">
                                    <span class="glyphicons glyphicons-settings"></span>
                                </a>
                            </div>
                            <div class="col-xs-4">
                                <a href="#" class="text-warning" data-toggle="tooltip" data-placement="top" title="Cron Jobs">
                                    <span class="glyphicons glyphicons-restart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- End: Sidebar Header -->

                <!-- sidebar menu -->
                <ul class="nav sidebar-menu">
                  <li class="sidebar-label pt20">PDES</li>

                  <?php
                  $g = 0;
                  $grupo = "";
                  ?>
                  @foreach($menus as $m)
                    @if( $grupo !=  $m->tipo_menu)
                      <?php $g++;
                      $grupo = $m->tipo_menu;
                      ?>
                      @if( $g > 1 )
                          </ul>
                      </li>
                      @endif
                        {{-- <<<<<<<<<<< --}}
                   <li>
                        <a id="G{{ $g }}" class="accordion-toggle" href="#">
                            <span class="glyphicons glyphicons-fire"></span>
                            <span class="sidebar-title"> {{ $m->tipo_menu }}</span>
                            <span class="caret"></span>
                        </a>
                        <ul class="nav sub-nav">

                          <li id="G{{ $g }}-{{ $m->id }}" class="">
                            @if( $m->submenus )
                              <a href="{{ url( $m->url ) }}">
                                  <img style="width: 35px; height: 35px; opacity: 0.7; border: 3px none white;" class="img-circle" src="{{ $m->icono }}">  {{ $m->titulo }}
                              </a>
                              <ul class="nav sub-nav">
                                @foreach($m->submenus as $sm)
                                  <li id="sm-{{ $sm->id }}" class="">
                                    <a href="{{ $sm->url }}">{{ $sm->titulo }}</a>
                                  </li>
                                @endforeach
                              </ul>
                            @else
                              <a href="{{ url( $m->url ) }}">
                                <img style="width: 35px; height: 35px; opacity: 0.7; border: 3px none white;" class="img-circle" src="{{ $m->icono }}">  {{ $m->titulo }}
                              </a>
                            @endif
                          </li>
                    {{-- era aqui <<<<<<<<<<<<<<<--}}
                    @else
                      <li id="G{{ $g }}-{{ $m->id }}" class="">
                        @if( $m->submenus )
                          <a href="{{ url( $m->url ) }}">
                              <img style="width: 35px; height: 35px; opacity: 0.7; border: 3px none white;" class="img-circle" src="{{ $m->icono }}">  {{ $m->titulo }}
                          </a>
                          <ul class="nav sub-nav">
                            @foreach($m->submenus as $sm)
                              <li id="sm-{{ $sm->id }}" class="">
                                <a href="{{ $sm->url }}">{{ $sm->titulo }}</a>
                              </li>
                            @endforeach
                          </ul>
                        @else
                          <a href="{{ url( $m->url ) }}">
                            <img style="width: 35px; height: 35px; opacity: 0.7; border: 3px none white;" class="img-circle" src="{{ $m->icono }}">  {{ $m->titulo }}
                          </a>
                        @endif
                      </li>

                    @endif

                  @endforeach

                      </ul>
                    </li>


                    <!-- sidebar progress bars -->
                    <li class="sidebar-label pt25 pb10">User Stats</li>
                    <li class="sidebar-stat mb10">
                        <a href="#projectOne" class="fs11">
                            <span class="fa fa-inbox text-info"></span>
                            <span class="sidebar-title text-muted">Email Storage</span>
                            <span class="pull-right mr20 text-muted">35%</span>
                            <div class="progress progress-bar-xs ml20 mr20">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 35%">
                                    <span class="sr-only">35% Complete</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="sidebar-stat mb10">
                        <a href="#projectOne" class="fs11">
                            <span class="fa fa-dropbox text-warning"></span>
                            <span class="sidebar-title text-muted">Bandwidth</span>
                            <span class="pull-right mr20 text-muted">58%</span>
                            <div class="progress progress-bar-xs ml20 mr20">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 58%">
                                    <span class="sr-only">58% Complete</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="sidebar-toggle-mini">
                    <a href="#">
                        <span class="fa fa-sign-out"></span>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">

            <!-- Start: Topbar-Dropdown -->
            <div id="topbar-dropmenu">
                <div class="topbar-menu row">
                  @foreach($modulos as $m)
                     <div class="col-xs-4 col-sm-2">
                         <a id="mod-{{ $m->id_html }}" href="{{ url($m->url)}}" class="metro-tile bg-success">
                             <img class="metro-icon" src="{{ asset('img/'.$m->icono) }}" width="60" alt="" />
                             <p class="metro-title">{{ $m->titulo }}</p>
                         </a>
                     </div>
                  @endforeach
                </div>
            </div>
            <!-- End: Topbar-Dropdown -->

            <!-- Start: Topbar -->
            <header id="topbar">
                 @yield('title-topbar')
            </header>
            <!-- End: Topbar -->

            <!-- Begin: Content -->
            <section id="content" class="table-layout animated fadeIn" style="min-height: 3500px;">
                @yield('content')
            </section>
            <!-- End: Content -->

        </section>

        <!-- Start: Right Sidebar -->
        <aside id="sidebar_right" class="nano">
            <div class="sidebar_right_content nano-content">
                <div class="tab-block sidebar-block br-n">
                    <ul class="nav nav-tabs tabs-border nav-justified hidden">
                        <li class="active">
                            <a href="#sidebar-right-tab1" data-toggle="tab">Tab 1</a>
                        </li>
                        <li>
                            <a href="#sidebar-right-tab2" data-toggle="tab">Tab 2</a>
                        </li>
                        <li>
                            <a href="#sidebar-right-tab3" data-toggle="tab">Tab 3</a>
                        </li>
                    </ul>
                    <div class="tab-content br-n">
                        <div id="sidebar-right-tab1" class="tab-pane active">

                            <h5 class="title-divider text-muted mb20"> Server Statistics <span class="pull-right"> 2013 <i class="fa fa-caret-down ml5"></i> </span> </h5>
                            <div class="progress mh5">
                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 44%">
                                    <span class="fs11">DB Request</span>
                                </div>
                            </div>
                            <div class="progress mh5">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 84%">
                                    <span class="fs11 text-left">Server Load</span>
                                </div>
                            </div>
                            <div class="progress mh5">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 61%">
                                    <span class="fs11 text-left">Server Connections</span>
                                </div>
                            </div>

                            <h5 class="title-divider text-muted mt30 mb10">Traffic Margins</h5>
                            <div class="row">
                                <div class="col-xs-5">
                                    <h3 class="text-primary mn pl5">132</h3>
                                </div>
                                <div class="col-xs-7 text-right">
                                    <h3 class="text-success-dark mn"> <i class="fa fa-caret-up"></i> 13.2% </h3>
                                </div>
                            </div>

                            <h5 class="title-divider text-muted mt25 mb10">Database Request</h5>
                            <div class="row">
                                <div class="col-xs-5">
                                    <h3 class="text-primary mn pl5">212</h3>
                                </div>
                                <div class="col-xs-7 text-right">
                                    <h3 class="text-success-dark mn"> <i class="fa fa-caret-up"></i> 25.6% </h3>
                                </div>
                            </div>

                            <h5 class="title-divider text-muted mt25 mb10">Server Response</h5>
                            <div class="row">
                                <div class="col-xs-5">
                                    <h3 class="text-primary mn pl5">82.5</h3>
                                </div>
                                <div class="col-xs-7 text-right">
                                    <h3 class="text-danger mn"> <i class="fa fa-caret-down"></i> 17.9% </h3>
                                </div>
                            </div>

                            <h5 class="title-divider text-muted mt40 mb20"> Server Statistics <span class="pull-right text-primary fw600">USA</span> </h5>
                            <div id="sidebar-right-map" class="hide-jzoom" style="width: 100%; height: 180px;"></div>

                        </div>
                        <div id="sidebar-right-tab2" class="tab-pane"></div>
                        <div id="sidebar-right-tab3" class="tab-pane"></div>
                    </div>
                    <!-- end: .tab-content -->
                </div>
            </div>
        </aside>
        <!-- End: Right Sidebar -->

    </div>
    <!-- End: Main -->


    <style>

    /*demo styles*/
    body {
        min-height: 2000px;
    }
    .custom-nav-animation li {
        display: none;
    }
    .custom-nav-animation li.animated {
        display: block;
    }

    /* nav fixed settings */
    ul.tray-nav.affix {
        width: 319px;
        top: 80px;
    }
    </style>

    <!-- BEGIN: PAGE SCRIPTS -->

    <!-- jQuery -->
        <script type="text/javascript" src=" {{ asset('sty-mode-2/vendor/jquery/jquery-1.11.1.min.js') }}"></script>
        <script type="text/javascript" src=" {{ asset('sty-mode-2/vendor/jquery/jquery_ui/jquery-ui.min.js') }}"></script>

        <!-- Bootstrap -->
        <script type="text/javascript" src=" {{ asset('sty-mode-2/assets/js/bootstrap/bootstrap.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('sty-mode-2/assets/admin-tools/admin-forms/js/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sty-mode-2/assets/admin-tools/admin-forms/js/additional-methods.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sty-mode-2/vendor/plugins/magnific/jquery.magnific-popup.js') }}"></script>

        <!-- Theme Javascript -->
        <script type="text/javascript" src=" {{ asset('sty-mode-2/assets/js/utility/utility.js') }}"></script>
        <script type="text/javascript" src=" {{ asset('sty-mode-2/assets/js/main.js') }}"></script>
        <script type="text/javascript" src=" {{ asset('sty-mode-2/assets/js/demo.js') }}"></script>






    <script type="text/javascript">
        jQuery(document).ready(function() {

            "use strict";

            // Init Theme Core
            Core.init();

            // Init Theme Core
            //Demo.init();

            // Init tray navigation smooth scroll
            $('.tray-nav a').smoothScroll({
                offset: -145
            });

            // Init custom navigation animation
            setTimeout(function() {
                $('.custom-nav-animation li').each(function(i, e) {
                    var This = $(this);
                    var timer = setTimeout(function() {
                        This.addClass('animated animated-short zoomIn');
                    }, 50 * i);
                });
            }, 500);

            // Init tray navigation smooth scroll

            //$('.tray-nav a').smoothScroll({
            //    offset: -145
            //});

            // Init Highlight.js Plugin
            // $('pre code').each(function(i, block) {
            //     hljs.highlightBlock(block);
            // });







        });

        function activarMenu(gr,mn){
            $('#G'+gr).addClass('menu-open');
            $('#G'+gr+'-'+mn).addClass('active');
        }
        function number_format(amount, decimals) {

            amount += ''; // por si pasan un numero en vez de un string
            amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

            decimals = decimals || 0; // por si la variable no fue fue pasada

            // si no es un numero o es igual a cero retorno el mismo cero
            if (isNaN(amount) || amount === 0)
                return parseFloat(0).toFixed(decimals);

            // si es mayor o menor que cero retorno el valor formateado como numero
            amount = '' + amount.toFixed(decimals);

            var amount_parts = amount.split('.'),
                regexp = /(\d+)(\d{3})/;

            while (regexp.test(amount_parts[0]))
                amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

            return amount_parts.join('.');
        }

        var Stacks = {
            stack_top_right: {
                "dir1": "down",
                "dir2": "left",
                "push": "top",
                "spacing1": 10,
                "spacing2": 10
            },
            stack_top_left: {
                "dir1": "down",
                "dir2": "right",
                "push": "top",
                "spacing1": 10,
                "spacing2": 10
            },
            stack_bottom_left: {
                "dir1": "right",
                "dir2": "up",
                "push": "top",
                "spacing1": 10,
                "spacing2": 10
            },
            stack_bottom_right: {
                "dir1": "left",
                "dir2": "up",
                "push": "top",
                "spacing1": 10,
                "spacing2": 10
            },
            stack_bar_top: {
                "dir1": "down",
                "dir2": "right",
                "push": "top",
                "spacing1": 0,
                "spacing2": 0
            },
            stack_bar_bottom: {
                "dir1": "up",
                "dir2": "right",
                "spacing1": 0,
                "spacing2": 0
            },
            stack_context: {
                "dir1": "down",
                "dir2": "left",
                "context": $("#stack-context")
            },
        }

        var  noteStack ="stack_top_right";
        function findWidth() {
            if (noteStack == "stack_bar_top") {
                return "100%";
            }
            if (noteStack == "stack_bar_bottom") {
                return "70%";
            } else {
                return "290px";
            }
        }
    </script>
    <!-- END: PAGE SCRIPTS -->
  @stack('script-head')
</body>

</html>
