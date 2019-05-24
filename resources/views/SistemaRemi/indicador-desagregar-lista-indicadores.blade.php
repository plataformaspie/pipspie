@extends('layouts.sistemaremi')

@section('header')

<style>
a:hover {
text-decoration: underline;
}
.box {
  position: relative;
  display: inline-block;
  width: 80%;
  height: 90%;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
  transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.box::after {
  content: "";
  border-radius: 5px;
  position: absolute;
  z-index: -1;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  opacity: 0;
  -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
  transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.box:hover {
  -webkit-transform: scale(1.25, 1.25);
  transform: scale(1.25, 1.25);
  cursor: pointer;
}

.box:hover::after {
    opacity: 1;
}

</style>
@endsection

@section('content')

  <div class="row bg-title">
      <!-- .page title -->
      <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Lista de Indicadores registrados.</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      <div class="col-lg-7 col-sm-8 col-md-8 col-xs-12">
          {{-- <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi') }}">Inicio</a></li>
              <li class="active">Indicadores por Tipo</li>
          </ol> --}}
      </div>
      <!-- /.breadcrumb -->
  </div>
  <!-- .row -->
  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-inverse ">
              <div class="panel-heading"> <button onclick="window.history.back();" class="btn btn-info btn-sm">Atrás</button>
                  <div class="pull-right">
                      <a href="#" data-perform="panel-collapse">
                        <i class="ti-minus"></i>Listado
                      </a>
                  </div>
              </div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                  <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel">
                                <div class="panel-body">


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
                                                          <b>PDES:</b>

                                                            @foreach ($arrayDatosExtras[$item->id]['pdes_logo'] as $value)
                                                              @if($value)
                                                                <center>
                                                                  <a href="/sistemaremi/dataIndicador/{{ $item->id }}">
                                                                      <img class="media-object" src="/img/{{ $value }}"  style="width: 50px; height: 50px;">
                                                                  </a>
                                                                </center>
                                                              @else
                                                                <center>
                                                                  <a href="/sistemaremi/dataIndicador/{{ $item->id }}">
                                                                      <img class="media-object" src="/img/NO_ART.png"  style="width: 50px; height: 50px;">
                                                                  </a>
                                                                </center>
                                                              @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="col-lg-1 col-xs-12">
                                                          <b>ODS:</b>

                                                        @foreach ($arrayDatosExtras[$item->id]['ods_logo'] as $value)
                                                            @if($value)
                                                            <center>
                                                              <a href="/sistemaremi/dataIndicador/{{ $item->id }}">
                                                                  <img class="media-object" src="/img/BG_{{ $value }}"  style="width: 50px; height: 50px;">
                                                              </a>
                                                            </center>
                                                          @else
                                                            <center>
                                                              <a href="/sistemaremi/dataIndicador/{{ $item->id }}">
                                                                  <img class="media-object" src="/img/NO_ART.png"  style="width: 50px; height: 50px;">
                                                              </a>
                                                            </center>
                                                          @endif
                                                        @endforeach


                                                        </div>

                                                        <div class="col-lg-10 col-xs-12">
                                                          <div class="row">
                                                              <div class="col-lg-12 card-footer">
                                                                    <a href="/sistemaremi/dataIndicador/{{ $item->id }}" style="color:#000000;font-weight: bold;">{{ str_pad($item->id, 4, "0", STR_PAD_LEFT) }}: {{ mb_strtoupper(strtolower($item->nombre )) }}</a>
                                                              </div>
                                                              <div class="col-lg-1 col-md-2 col-sm-6 col-xs-6 text-center">
                                                                  <p class="text-muted">Tipo:</p>
                                                                  <p style="font-weight:bold;"> {{ $item->tipo }} </p>
                                                              </div>
                                                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                                                  <p class="text-muted">Unidad de medida:</p>
                                                                  <p style="font-weight:bold;">{{ $item->unidad_medida }}</p>
                                                              </div>
                                                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                                                  <p class="text-muted">Serie disponible:</p>
                                                                  <p style="font-weight:bold;">{{ $item->serie_disponible }}</p>
                                                              </div>
                                                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                                                  <p class="text-muted">Línea base:</p>
                                                                  <p style="font-weight:bold;">{{ trim(trim(number_format($item->linea_base_valor,4,",","."),0),',') }}</p>
                                                              </div>
                                                              <div class="col-lg-1 col-md-1 col-sm-6 col-xs-6 text-center">
                                                                  <p class="text-muted">Meta 2020:</p>
                                                                  <p style="font-weight:bold;">{{ trim(trim(number_format($arrayDatosAvances[$item->id]['meta_2020'],4,",","."),0),',') }}</p>
                                                              </div>
                                                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                                                  <p class="text-muted">Último valor Reportado:</p>
                                                                  @if($arrayDatosAvances[$item->id]['gestion_reporte'] > 0)
                                                                    <p style="font-weight:bold;font-size:20px;color:#4F93A0;">{{ trim(trim(number_format($arrayDatosAvances[$item->id]['avance_'.$arrayDatosAvances[$item->id]['gestion_reporte']],4,",","."),0),',') }}</p>
                                                                  @endif
                                                              </div>
                                                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                                                  <p class="text-muted">Total <br/>Ejecutado:</p>
                                                                  <p style="font-weight:bold;font-size:25px;color:{{$color}};">{{ trim(trim(number_format($arrayEjecutadoIndicadores[$item->id]['ejecutado'],4,",","."),0),',') }}</p>
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



                                </div>
                           </div>
                        </div>
                    </div>

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
