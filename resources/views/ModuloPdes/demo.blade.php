@extends('layouts.plataforma')

@section('header')

@endsection

@section('auxmenu')
  <a id="touch-menu" class="mobile-menu" href="#"><i class="ti-menu"></i> Menu</a>
     <nav style="background:#5c6175;">
     <ul class="menu">
       <li><a id="1"  href="{{ url('modulopdes/indicadores')}}"><i class="fa fa-bar-chart-o"></i> INDICADORES</a></li>
       <li><a id="2"  href="{{ url('modulopdes/proyectos')}}"><i class="fa fa-cubes"></i> PROYECTOS</a></li>
       <li><a id="3"  href="#"><i class="fa fa-money"></i> PRESUPUESTO</a></li>
       {{-- <li><a  href="#"><i class="icon-bullhorn"></i>BLOG</a></li>
       <li><a  href="#"><i class="icon-envelope-alt"></i>CONTACT</a></li> --}}
   </ul>
   </nav>
@endsection


@section('content')
HOLAMUNDO


@endsection


@push('script-head')
  <script type="text/javascript">
    function activarMenu(id,aux){
        $('#'+id).addClass('active');
        $('#'+aux).addClass('activeaux');
    }

    function menuModulosHideShow(ele){
      //1 hide
      //2 show
      switch (ele) {
        case 1:
          $("body").addClass("content-wrapper")
          $(".open-close i").removeClass('icon-arrow-left-circle');
          $(".sidebar").css("overflow", "inherit").parent().css("overflow", "visible");
        break;
        case 2:
          $("body").removeClass('content-wrapper');
          $(".open-close i").addClass('icon-arrow-left-circle');
          $(".logo span").show();
          break;
      }
    }
      $(document).ready(function(){
          activarMenu('modulopdes',2);
          menuModulosHideShow(1)
      });
  </script>
@endpush
