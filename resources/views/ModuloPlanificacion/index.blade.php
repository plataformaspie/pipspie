@extends('layouts.moduloplanificacion')

@section('header')


@endsection

@section('title-topbar')

@endsection

@section('content')


Bienvenido...!!!



@endsection

@push('script-head')

  <script type="text/javascript">
    $(document).ready(function(){
      globalSP.activarMenu('0');
      // activarMenu('2','0');
      globalSP.cargarGlobales();

    });
  </script>
@endpush
