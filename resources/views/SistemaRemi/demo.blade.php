@extends('layouts.sistemaremi')

@section('header')


@endsection

@section('content')

  <div class="row bg-title">
      <!-- .page title -->
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Bienvenido...!!!</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/index') }}">Inicio</a></li>
              <li class="active">Pagina Principal</li>
          </ol>
      </div>
      <!-- /.breadcrumb -->
  </div>
  <!-- .row -->
  <div class="row">
      <div class="col-md-12">
          <div class="white-box">
            <h4 class="font-bold m-t-0">¿Qué es REMI? </h4>
            <hr>
            <div class="media m-b-30 p-t-20">
                  <div class="media-body"> <span class="media-meta pull-right">-</span>
                    <h4 class="text-danger m-0">Registro, Evaluación y Monitoreo de Indicadores</h4>
                    <p class="text-muted">
                      El Registro, Evaluación y Monitoreo de Indicadores (REMI), es una herramienta que nos permite realizar el seguimiento y monitoreo
                      para el logro de los resultados y metas del PDES relacionados a los ODS, coherente con las políticas de cada sector involucrado.
                    </p>
                  </div>
            </div>

          </div>
      </div>
  </div>





@endsection

@push('script-head')

  <script type="text/javascript">
    $(document).ready(function(){


    });
  </script>
@endpush
