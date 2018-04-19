@extends('layouts.sistemaremi')

@section('header')
  <style>
  .amcharts-export-menu-top-right {
    top: 10px;
    right: 0;
  }
  .amcharts-chart-div a {display:none !important;}
  #chartdivAvance {
  	width	: 100%;
  	height	: 300px;
  }

  </style>
@endsection

@section('content')

  <div class="row bg-title">
      <!-- .page title -->
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Detalle Indicador</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/setIndicadores') }}">Indicadores</a></li>
              <li class="active">Detalle Indicador</li>
          </ol>
      </div>
      <!-- /.breadcrumb -->
  </div>
  <!-- .row -->
  <div class="row">
      <div class="col-md-12">
          <div class="white-box">


            <div class="row">
                <div class="col-md-9">

                  <div class="row media" style="margin-right:6px;margin-left:6px;" > <!--style="padding-right: 0px;padding-top: 0px;padding-left: 0px;"-->
                      <div class="col-lg-2 col-xs-12">
                        <center>
                              <img class="media-object" src="/img/icono_indicadores/IND_1.png"  style="width: auto; height: auto;">
                        </center>
                      </div>
                      <div class="col-lg-10 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 ">
                                  <label style="color:#000000;font-weight: bold;">{{ $indicador->nombre }}</label>
                            </div>
                            <div class="col-lg-12">
                                  <label>{{$indicador->definicion}}</label>
                            </div>
                        </div>
                      </div>
                      <div class="col-lg-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center">
                                <p class="text-muted card-footer" >Último valor reportado:</p>
                                <p> x </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center">
                                <p class="text-muted card-footer"> Unidad de medida: </p>
                                <p> {{$indicador->unidad_medida}} </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center">
                                <p class="text-muted card-footer">Meta PDES al 2020</p>
                                @foreach ($metas as $item)
                                  @if ($item->gestion == 2020)
                                      <p>{{$item->valor}}</p>
                                  @endif
                                @endforeach

                            </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-12 col-sm-12">
                      <div class="panel panel-success">
                          <div class="panel-heading" style="background-color: #468E9B;">

                              <div class="pull-left" style="margin-top: -9px;">
                                <a href="#" data-perform="panel-collapse">
                                  <i class="ti-minus"></i> Información básica
                                </a>
                              </div>
                          </div>
                          <div class="panel-wrapper collapse in" aria-expanded="true">
                              <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Código</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>:</p>
                                    </div>

                                    <div class="col-lg-4 col-sm-6">
                                      <b>Tipo de indicador</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: {{$indicador->tipo}}</p>
                                    </div>

                                    <div class="col-lg-4 col-sm-6">
                                      <b>Variables de desagregación</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <?php echo str_replace(',',', ',$indicador->variables_desagregacion)?></p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Serie disponible</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: {{$indicador->serie_disponible}}</p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Fecha de linea base</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: {{$indicador->linea_base_mes}}/{{$indicador->linea_base_anio}}</p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Valor actual de linea base</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: {{$indicador->linea_base_valor}}</p>
                                    </div>

                                </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-12 col-sm-12">
                      <div class="panel panel-success">
                          <div class="panel-heading" style="background-color: #468E9B;">

                              <div class="pull-left" style="margin-top: -9px;">
                                <a href="#" data-perform="panel-collapse">
                                  <i class="ti-minus"></i> Método de cálculo
                                </a>
                              </div>
                          </div>
                          <div class="panel-wrapper collapse in" aria-expanded="true">
                              <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Formula de cálculo</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6">
                                          <p>: {{$indicador->formula}}</p>
                                        </div>
                                        <div class="col-lg-12">
                                            <h5><b>Parámetros de la formula</b></h5>
                                            <hr/>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Numerador</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6">
                                          <p>: {{$indicador->numerador_detalle}}</p>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Fuente del numerador</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6">
                                          <p>: {{$indicador->numerador_fuente}}</p>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Denominador</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6">
                                          <p>: {{$indicador->denominador_detalle}}</p>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Fuente del denominador</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6">
                                          <p>: {{$indicador->denominador_fuente}}</p>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Observaciones a la fuente de datos</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6">
                                          <p>: {{$indicador->observacion}}</p>
                                        </div>
                                    </div>
                              </div>
                          </div>
                      </div>
                  </div>



                  <div class="col-lg-12 col-sm-12">
                      <div class="panel panel-success">
                          <div class="panel-heading" style="background-color: #468E9B;">

                              <div class="pull-left" style="margin-top: -9px;">
                                <a href="#" data-perform="panel-collapse">
                                  <i class="ti-minus"></i> Metas
                                </a>
                              </div>
                          </div>
                          <div class="panel-wrapper collapse in" aria-expanded="true">
                              <div class="panel-body">
                                    <div class="row">
                                        @foreach ($metas as $item)
                                          <div class="col-lg-4 col-sm-6">
                                            <b>{{ $item->gestion }}</b>
                                          </div>
                                          <div class="col-lg-8 col-sm-6">
                                            <p>: {{ $item->valor }}</p>
                                          </div>
                                        @endforeach
                                    </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-12 col-sm-12">
                      <div class="panel panel-success">
                          <div class="panel-heading" style="background-color: #468E9B;">

                              <div class="pull-left" style="margin-top: -9px;">
                                <a href="#" data-perform="panel-collapse">
                                  <i class="ti-minus"></i> Articulación PDES
                                </a>
                              </div>
                          </div>
                          <div class="panel-wrapper collapse in" aria-expanded="true">
                              <div class="panel-body">
                                    <div class="row">
                                        @foreach ($pdes as $item)
                                          <div class="row">
                                                <div class="media row col-lg-12 ">
                                                    <div class="col-lg-2 text-center">
                                                        <img src="/img/{{$item->logo}}" alt="Pliar" width="100">
                                                    </div>
                                                    <div class="row col-lg-10">
                                                        <div class="col-12"><b>{{$item->pilar}}:</b> {{$item->desc_p}}</div>
                                                        <div class="col-12"><b>{{$item->meta}}:</b> {{$item->desc_m}}</div>
                                                        <div class="col-12"><b>{{$item->resultado}}:</b> {{$item->desc_r}}</div>
                                                    </div>
                                                </div>
                                          </div>
                                        @endforeach
                                    </div>
                              </div>
                          </div>
                      </div>
                  </div>

                </div>
                <div class="col-md-3">


                    <div class="row media" style="margin-right:6px;margin-left:6px;" > <!--style="padding-right: 0px;padding-top: 0px;padding-left: 0px;"-->
                          <h5>Gráfica de Avance</h5>
                          <div id="chartdivAvance"></div>
                    </div>

                    <div class="row" style="margin-right:6px;margin-left:6px;" > <!--style="padding-right: 0px;padding-top: 0px;padding-left: 0px;"-->
                        <div class="panel panel-success" style="border: 1px solid transparent;border-color: #d6e9c6;width:100%">
                            <div class="panel-heading panel-heading-c2" style="color: #3c763d; background-color: #dff0d8;border-color: #d6e9c6;"> Descargar ficha indicador </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body text-center">
                                    <a href="#"><img src="/img/icono_indicadores/pdf.png" title="Descargar ficha indicador "></a>
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
  <script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
  <script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      var chartData = [{"date":"Ene","avance":2.0},{"date":"Feb","avance":8.0},{"date":"Mar","avance":8.0}];
      var chart = AmCharts.makeChart("chartdivAvance", {
                        "type": "serial",
                        "theme": "light",
                        "fontSize":9,
                        "legend": {
                            "marginLeft":20,
                            "marginRight":0,
                            "autoMargins":false
                        },
                        "dataProvider": chartData,
                        "graphs": [{
                            "title": "Avances",
                            "lineColor": "#00749F",
                            "bullet": "diamond",
                            "bulletSize":12,
                            "bulletBorderThickness": 1,
                            "valueField": "avance"
                        },{
                            "title": "Metas",
                            "lineColor": "#FF0000",
                            "bullet": "round",
                            "bulletBorderThickness": 1,
                            "valueField": "meta"
                        }],
                        "chartCursor": {
                            "cursorPosition": "mouse"
                        },
                        "categoryField": "date",
                        "categoryAxis": {
                            "gridCount": chartData.length,
                            "autoGridCount": false
                        }
          });

          /*
          var chart = AmCharts.makeChart("chartdivAvance", {
                              "type": "serial",
                              "theme": "light",
                              "fontSize":9,
                              "dataProvider": chartData,
                              "legend": {
                                  "useGraphSettings": true,
                                  "valueWidth":0,
                                  "verticalGap":0
                              },
                              "graphs": [{
                                  "title": "Meta",
                                  "lineColor": "#FF0000",
                                  "valueField": "meta",
                                  "fillAlphas": 0.9,
                                  "lineAlpha": 0.2,
                                  "type": "column"
                              },{
                                  "title": "Avances",
                                  "lineColor": "#00749F",
                                  "valueField": "avance",
                                  "fillAlphas": 0.9,
                                  "lineAlpha": 0.2,
                                  "columnWidth":0.5,
                                  "clustered":false,
                                  "type": "column"
                              }],
                              "categoryField": "date",
                              "categoryAxis": {
                                  "gridCount":chartData.length,
                                  "labelRotation":45,
                                  "autoGridCount": false
                              }
                          });
          */
    });
  </script>
@endpush
