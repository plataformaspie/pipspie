@extends('layouts.planificacionterritorial')

@section('header')


@endsection

@section('content')
  <!--template v-if="view==0">
      <index></index>
  </template>
  <template v-if="view==1">
      <recursos></recursos>
  </template>
  <template v-if="view==2">
      <deudas></deudas>
  </template>
  <template v-if="view==3">
      <planificacion></planificacion>
  </template>
  
  <template v-if="view==5">
      <indexseguimiento></indexseguimiento>
  </template>
  <template v-if="view==6">
      <seguimientorecursos></seguimientorecursos>
  </template>
  <template v-if="view==7">
      <seguimientoacciones></seguimientoacciones>
  </template>
  <template v-if="view==8">
      <seguimientofisicofinanciera></seguimientofisicofinanciera>
  </template>
  <template v-if="view==9">
      <seguimientoproyectosinversion></seguimientoproyectosinversion>
  </template>
  <template v-if="view==10">
      <presentacion></presentacion>
  </template-->
 <template v-if="viewe==11">
      <evaluacion></evaluacion>
  </template>
 <!--template v-if="view==12">
      <evaluacion></evaluacion>
  </template-->
@endsection

@push('script-head')

  <script type="text/javascript">
    $(document).ready(function(){
      // function activarMenu(id,sub){
      //     $('#'+id).addClass('active');
      // }
      // activarMenu(1,0);

    });
  </script>
@endpush
