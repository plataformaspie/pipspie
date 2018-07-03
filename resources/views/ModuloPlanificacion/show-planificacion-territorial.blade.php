@extends('layouts.moduloplanificacion')

@section('header')


@endsection

@section('title-topbar')

@endsection

@section('content')


Planificacion...!!!



@endsection

@push('script-head')

  <script type="text/javascript">
    $(document).ready(function(){
      globalSP.activarMenu('0');
      // activarMenu('2','0');

    });
  </script>
@endpush
