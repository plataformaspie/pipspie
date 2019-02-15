@extends('layouts.planificacionterritorial')

@section('header')


@endsection

@section('content')
  <template v-if="view==0">
      <index></index>
  </template>
  <template v-if="view==1">
      <recursos></recursos>
  </template>
  <template v-if="view==2">
      <deudas></deudas>
  </template>
  <template v-if="view==3">
      <planificacion-categorias></planificacion-categorias>
  </template>
  <template v-if="view==31">
      <planificacion></planificacion>
  </template>
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
