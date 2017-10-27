@extends('layouts.plataforma')
@section('header')



<style>
#chartdiv {
  width: 100%;
  height: 450px;
}
</style>
@endsection
@section('content')

  <h1>En construcciòn</h1>

@endsection
@push('script-head')





  <script type="application/javascript">
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
      var pressHistorico = "";
      var sourceH;
      var chart;
      $(document).ready(function(){


          activarMenu('mod-1','mp-1');
          menuModulosHideShow(1)

      });

   </script>
@endpush
