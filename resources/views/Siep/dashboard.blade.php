@extends('layouts.plataforma_home')

@section('header')

@endsection


@section('content')


  <div class="embed-responsive embed-responsive-16by9" style="height: 800px;">
      <iframe class="embed-responsive-item" src="http://siep.vipfe.gob.bo" allowfullscreen></iframe>
  </div>







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
        activarMenu('x','mp-6');
        menuModulosHideShow(1)
      });
  </script>
@endpush
