@extends('layouts.sistemaremi')

@section('header')

<style>
a:hover {
text-decoration: underline;
}
</style>
@endsection

@section('content')

  <div class="row bg-title">
      <!-- .page title -->
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">LISTA DE INDICADORES</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/setIndicadores') }}">Indicadores</a></li>
              <li class="active">Lista de indicadores</li>
          </ol>
      </div>
      <!-- /.breadcrumb -->
  </div>
  <!-- .row -->
  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-inverse ">
              <div class="panel-heading"> Filtrar Indicadores
                  <div class="pull-right">
                      <a href="#" data-perform="panel-collapse">
                        <i class="ti-minus"></i>
                      </a>
                  </div>
              </div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                  <div class="panel-body">
                      <div class="row">
                          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <input type="text" name="buscar_sel" class="form-control buscar" value="{{ $buscar }}" placeholder="Buscar...">
                          </div>
                          <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                            <select name="tipo" class="form-control filter">
                                <option value="">-Tipo Indicador-</option>
                                @foreach ($tiposMedicion as $item)
                                  <option value="{{ $item->nombre }}" {{ $tipo === $item->nombre  ? "selected" : "" }}>{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                          </div>

                          <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                            <select name="unidad" class="form-control filter">
                                <option value="">-Unidad de Medida-</option>
                                @foreach ($unidadesMedidas as $item)
                                  <option value="{{ $item->nombre }}" {{ $unidad === $item->nombre  ? "selected" : "" }}>{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

      </div>
  </div>


  <div class="row">
      <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
              <div>
                <p>
                  {{ $indicadores->total() }} registros | página {{ $indicadores->currentPage() }} de {{ $indicadores->lastPage() }}
                </p>
                {!! $indicadores->render() !!}
              @foreach ($indicadores as $item)
                    <div class="row media" style="padding-right: 0px;padding-top: 0px;padding-left: 0px;">
                        <div class="col-lg-1 col-xs-12">
                          <center>
                            <a href="/sistemaremi/dataIndicador/{{ $item->id }}">
                                <img class="media-object" src="/img/icono_indicadores/{{ $item->logo }}"  style="width: 90px; height: 100px;">
                            </a>
                          </center>
                        </div>
                        <div class="col-lg-11 col-xs-12">
                          <div class="row">
                              <div class="col-lg-12 card-footer">
                                    <a href="/sistemaremi/dataIndicador/{{ $item->id }}" style="color:#000000;font-weight: bold;">{{ $item->nombre }}</a>
                              </div>
                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                  <p class="text-muted">Tipo:</p>
                                  <p> {{ $item->tipo }} </p>
                              </div>
                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                  <p class="text-muted">Unidad de medida:</p>
                                  <p>{{ $item->unidad_medida }}</p>
                              </div>
                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                  <p class="text-muted">Serie disponible:</p>
                                  <p>{{ $item->serie_disponible }}</p>
                              </div>
                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                  <p class="text-muted">Linea base:</p>
                                  <p>{{ $item->linea_base_valor }}</p>
                              </div>

                          </div>
                        </div>
                    </div>
              @endforeach
              </div>
              {!! $indicadores->render() !!}

          </div>
       </div>





      </div>
  </div>



@endsection

@push('script-head')

  <script type="text/javascript">
    $(document).ready(function(){

      $( ".filter" ).change(function() {
            var tipo = $( "select[name*='tipo']" ).val();
            var unidad = $( "select[name*='unidad']" ).val();
            var buscar = $('input[name="buscar_sel"]').val();
            var concat = "";
            if(tipo){
              concat += "tipo="+tipo+"&";
            }
            if(unidad){
              concat += "unidad="+unidad+"&";
            }
            if(buscar){
              concat += "buscar="+buscar+"&";
            }
            $(location).attr('href', '/sistemaremi/setIndicadores/?'+concat);
      });


      $(".buscar").keypress(function(e) {
          var code = (e.keyCode ? e.keyCode : e.which);
          if(code==13){
              $(".filter" ).trigger( "change" );
          }
      });
    });
  </script>
@endpush
