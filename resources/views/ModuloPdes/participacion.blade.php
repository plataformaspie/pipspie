@extends('layouts.plataforma')

@section('header')

@endsection


@section('content')
HOLAMUNDO participacion


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

  $(document).ready(function(){
    activarMenu('mod-1','mp-11');
    menuModulosHideShow(1)
  });
  </script>
@endpush
