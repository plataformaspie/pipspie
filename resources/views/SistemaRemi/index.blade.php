@extends('layouts.sistemaremi')

@section('header')
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<style>
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


#chartdivMetas {
	width		: 100%;
	height	: 250px;
	font-size	: 12px;
}
#chartdivTipo {
	width		: 100%;
	height	: 400px;
	font-size	: 11px;
}
#chartdivActui {
	width		: 100%;
	height	: 300px;
	font-size	: 11px;
}
.amcharts-export-menu-top-right {
  top: 10px;
  right: 0;
}
.amcharts-chart-div a {display:none !important;}

.imagensob > div
{
      position: absolute;
      bottom: -11px;
      /* color: #c60000; */
      color: #fff;
      padding: 2px 10px;
      opacity: 1;
      font-weight: bold;
      right: 37px;
      font-size: 68px;
      /* text-shadow: 0.1em 0.1em 0.2em #fff; */
      text-shadow: -2px -2px 1px #000, 2px 2px 1px #000, -2px 2px 1px #000, 2px -2px 1px #000;

      -webkit-text-fill-color: yellowgreen;
      -webkit-text-stroke: 1px black;

}


#chartdivEtapa {
  width: 190%;
  height:250px;
  /* position: relative;*/
  margin-left: -150px;
}
#chartdivPDES {
  width: 100%;
  height: 200px;
}


#tspan{
  font-size: 15px;
  font-weight: bold;
}

.push_buttonA {
    position: relative;
    width: 200px;
    color: #FFF;
    display: block;
    cursor: pointer;
    text-decoration: none;
    margin: 0 auto;
    margin-right: auto;
    margin-left: auto;
    border-radius: 5px;
    border: solid 1px #8DC122;
    text-align: center;
    padding: 2px 2px;
    -webkit-transition: all 0.1s;
    -moz-transition: all 0.1s;
    transition: all 0.1s;
    -webkit-box-shadow: 0px 9px 0px #8DC122;
    -moz-box-shadow: 0px 9px 0px #8DC122;
    box-shadow: 0px 9px 0px #8DC122;
}
.push_buttonA:active{
    -webkit-box-shadow: 0px 2px 0px #1EA4EE; /*color box-shadow  84261a  /  1565C0   color border  D94E3B  /   2196F3     */
    -moz-box-shadow: 0px 2px 0px #1EA4EE;
    box-shadow: 0px 2px 0px #1EA4EE;
    position:relative;
    top:7px;
}

</style>
@endsection

@section('content')


  <div class="row bg-title">
      <!-- .page title -->
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Bienvenido...!!!</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      {{-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/index') }}">Inicio</a></li>
              <li class="active">Pagina Principal</li>
          </ol>
      </div> --}}
      <!-- /.breadcrumb -->
  </div>
  <!-- .row -->
  <div class="row">
      <div class="col-md-12">
          <div class="white-box">
            <h4 class="font-bold m-t-0">¿Qué es RIME? </h4>
            <hr>
<!--             <div class="links">
                <a href="{{ route('registrar.index') }}">TABLA DE USUARIOS</a>
            </div> -->
            <div class="media m-b-30 p-t-20">
                  <div class="col-1">
                      <img class="metro-icon" src="{{ asset('img/logo_remi.png') }}" width="80" alt="" />
                  </div>
                  <div class="col-11">
                    <div class="media-body"> <span class="media-meta pull-right"><i class="fa fa-info-circle" style="font-size: 25px"></i></span>
                      <h4 class="text-danger m-0">Registro de Indicadores Monitoreo  y Evaluación </h4>
                      <p class="text-muted">
                        El Registro de Indicadores Monitoreo y Evaluación (RIME), es una herramienta que nos permite realizar el seguimiento y monitoreo
                        para el logro de los resultados y metas del PDES relacionados a los ODS, coherente con las políticas de cada sector involucrado.
                      </p>
                    </div>
                  </div>


            </div>

          </div>
      </div>
  </div>


  <div class="row">
      <div class="col-md-12">
          <div class="white-box">
            <div class="row" >
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 m-b-10 text-center">
                <h4 class="font-bold m-t-0"> Indicadores Registrados</h4>
                <a href="{{ url('sistemarime/listaIndicadores') }}">
                <div class="white-box p-10 text-center push_buttonA" style="background:#21B2AB;height:223px;z-index: 10 !important;">

                    <ul class="list-inline two-part">
                        <li><img src="{{ asset('images/indicadores.png') }}"></li>
                    </ul>
                    <ul class="list-inline two-part">
                        <li><span class="counter" style="font-weight:bold;color:white;">{{ $totalIndicadores }}</span></li>
                    </ul>

                </div>
                </a>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-10 text-center">
                  <h4 class="font-bold m-t-0">Total Indicadores por Etapa</h4>
                  <div id="chartdivEtapa"></div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 m-b-10 text-center">
                  <h4 class="font-bold m-t-0">Cumplimiento de metas al 2020</h4>
                  <div id="chartdivMetas"></div>
              </div>


            </div>
          </div>
      </div>
  </div>

  <div class="row">
      <div class="col-md-12">
          <div class="white-box">
            <div class="row" >
                {{-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 m-b-10 text-center">
                    <h4 class="font-bold m-t-0">Cumplimientos de metas al 2020</h4>
                    <div id="chartdivMetas"></div>
                </div> --}}
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-10 text-center">
                    <h4 class="font-bold m-t-0">Indicadores por tipo</h4>
                    <div id="chartdivTipo"></div>
                </div>
                {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 m-b-10 text-center">
                  <h4 class="font-bold m-t-0">Últimos indicadores actualizados(DEMO)</h4>
                  <div id="chartdivActui"></div>
                  <h5 class="font-bold m-t-0">Indicadores actualizados en los ùltimos 30 días</h5>
                </div> --}}
            </div>
          </div>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12">
          <div class="white-box">
            <h4 class="font-bold m-t-0">Indicadores por Pilar</h4>
            <hr>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_1.jpg" height="150" alt="-"  class="box" onclick="filtrarPdes(1)" />
                  <div>{{$pdes[1]}}</div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_2.jpg" height="150" alt="-"  class="box" onclick="filtrarPdes(2)"/>
                  <div>{{$pdes[2]}}</div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_3.jpg" height="150" alt="-" class="box"  onclick="filtrarPdes(3)"/>
                  <div>{{$pdes[3]}}</div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_4.jpg" height="150" alt="-"  class="box" onclick="filtrarPdes(4)"/>
                  <div>{{$pdes[4]}}</div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_5.jpg" height="150" alt="-"  class="box" onclick="filtrarPdes(5)"/>
                  <div>{{$pdes[5]}}</div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_6.jpg" height="150" alt="-"  class="box" onclick="filtrarPdes(6)"/>
                  <div>{{$pdes[6]}}</div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_7.jpg" height="150" alt="-"  class="box" onclick="filtrarPdes(7)"/>
                  <div>{{$pdes[7]}}</div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_8.jpg" height="150" alt="-" class="box"  onclick="filtrarPdes(8)"/>
                  <div>{{$pdes[8]}}</div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_9.jpg" height="150" alt="-"  class="box" onclick="filtrarPdes(9)"/>
                  <div>{{$pdes[9]}}</div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_10.jpg" height="150" alt="-"  class="box" onclick="filtrarPdes(10)"/>
                  <div>{{$pdes[10]}}</div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_11.jpg" height="150" alt="-"  class="box" onclick="filtrarPdes(11)"/>
                  <div>{{$pdes[11]}}</div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_12.jpg" height="150" alt="-"  class="box" onclick="filtrarPdes(12)"/>
                  <div>{{$pdes[12]}}</div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10 imagensob">
                  <img src="/img/PILAR_13.jpg" height="150" alt="-"  class="box" onclick="filtrarPdes(13)"/>
                  <div>{{$pdes[13]}}</div>
                </div>
            </div>
          </div>
      </div>
  </div>

  <div class="row hide">
      <div class="col-md-12">
          <div class="white-box">
            <h4 class="font-bold m-t-0">Indicadores por ODS</h4>
            <hr>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_1.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_2.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_3.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_4.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_5.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_6.jpg" height="150" alt="-" class="box" />
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_7.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_8.jpg" height="150" alt="-"  class="box"/>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_9.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_10.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_11.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_12.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_13.jpg" height="150" alt="-" class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_14.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_15.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_16.jpg" height="150" alt="-"  class="box"/>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 m-b-10">
                  <img src="/img/ODS_17.jpg" height="150" alt="-"  class="box"/>
                </div>
            </div>
          </div>
      </div>
  </div>


@endsection

@push('script-head')

  <!-- Resources -->
  <script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
  <script type="text/javascript" src="https://www.amcharts.com/lib/3/pie.js"></script>
  <script type="text/javascript" src="http://cdn.amcharts.com/lib/3/serial.js"></script>
  <script type="text/javascript" src="https://www.amcharts.com/lib/3/gauge.js"></script>
  <script type="text/javascript" src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
  <script type="text/javascript" src="https://www.amcharts.com/lib/3/themes/light.js"></script>
  <!-- EASY PIE CHART JS -->
  <script src="{{ asset('plugins/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
  <script src="{{ asset('plugins/bower_components/jquery.easy-pie-chart/easy-pie-chart.init.js') }}"></script>
  <!-- Custom Theme JavaScript -->
  <script type="text/javascript">
      var chartActui;

    $(document).ready(function(){
      var dataMeta =  <?php echo $graficaAvanceMeta20; ?>;
      var chart = AmCharts.makeChart( "chartdivMetas", {
        "type": "pie",
        "balloonText": "[[titulo]]<br><span style='font-size:14px'><b>[[valor]]</b> ([[percents]]%)</span>",
        "radius": "26%",
        "innerRadius": "60%",
        "titleField": "titulo",
        "valueField": "valor",
        "labelRadius": 5,
        "allLabels": [],
        "balloon": {},
        "listeners": [{
          "event": "clickSlice"
        }],
        "urlField": "url",
        "legend": {
          "enabled": true,
          "position": "right",
          "align": "center",
          "markerType": "circle"
        },
        "titles": [],
        "colors": [
            "#505050",
            "#EF5A28",
            "#F9AE40",
            "#009245",
            "#40A4F9"
          ],
          "dataProvider": dataMeta
      });



      var dataTipo =  <?php echo $tipoindicadores; ?>;
      var chartTipo = AmCharts.makeChart("chartdivTipo", {
            "theme": "light",
            "type": "serial",
            "dataProvider": dataTipo,
            "valueAxes": [{
                "title": "",
                "valueField": "valor"
            }],
            "graphs": [{
                "balloonText": "[[category]]:[[value]]",
                "fillAlphas": 1,
                "lineAlpha": 0.2,
                "title": "",
                "type": "column",
                "valueField": "valor",
                "labelText": "[[value]]",
                "listeners": [{
                  "event": "clickItem"
                }],
                "urlField": "url"
            }],
            "rotate": true,
            "categoryField": "titulo",
            "chartCursor": {
              "fullWidth": true,
              "cursorAlpha": 0.1,
              "listeners": [{
                "event": "changed",
                "method": function(ev) {
                  // Log last cursor position
                  ev.chart.lastCursorPosition = ev.index;
                }
              }]
            },
            "categoryAxis": {
                "gridPosition": "start",
                "fillAlpha": 0.05,
                "position": "left",
            },
            "export": {
            	"enabled": false
             }
        });


      //   chartActui = AmCharts.makeChart("chartdivActui", {
      //     "theme": "light",
      //     "type": "gauge",
      //     "axes": [{
      //       "topText": 0,
      //       "topTextFontSize": 50,
      //       "topTextYOffset": 70,
      //       "axisColor": "#31d6ea",
      //       "axisThickness": 1,
      //       "endValue": 100,
      //       "gridInside": true,
      //       "inside": true,
      //       "radius": "80%",
      //       "valueInterval": -1,
      //       "tickColor": false,
      //       "startAngle": -90,
      //       "endAngle": 90,
      //       "unit": "",
      //       "bandOutlineAlpha": 0,
      //       "bands": [{
      //         "color": "#0080ff",
      //         "endValue": 100,
      //         "innerRadius": "100%",
      //         "radius": "130%",
      //         "gradientRatio": [0.5, 0, -0.5],
      //         "startValue": 0
      //       }, {
      //         "color": "#3cd3a3",
      //         "endValue": 0,
      //         "innerRadius": "100%",
      //         "radius": "130%",
      //         "gradientRatio": [0.5, 0, -0.5],
      //         "startValue": 0
      //       }]
      //     }],
      //     "arrows": [{
      //       "alpha": 1,
      //       "innerRadius": "35%",
      //       "nailRadius": 0,
      //       "radius": "120%",
      //       "value": 0
      //     }]
      //   });
      //
      //
      // setInterval(updatedValue, 2000);



      //updatedValue();
    });



    // set random value
    function updatedValue() {
      var value = Math.round(Math.random() * 100);
      chartActui.arrows[0].setValue(value);
      chartActui.axes[0].setTopText(value);
      // adjust darker band to new value
      chartActui.axes[0].bands[1].setEndValue(value);
    }

    function filtrarPdes(ele){
      var concat = "";
      concat += "pdes="+ele+"&";
      $(location).attr('href', '/sistemaremi/setIndicadores/?'+concat);
    }
  </script>



  <script src="https://www.amcharts.com/lib/4/core.js"></script>
  <script src="https://www.amcharts.com/lib/4/charts.js"></script>
  <script src="https://www.amcharts.com/lib/4/plugins/forceDirected.js"></script>
  <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

  <script>
    $(document).ready(function(){
            // Themes begin
          am4core.useTheme(am4themes_animated);
          // Themes end

          var chart = am4core.create("chartdivEtapa", am4plugins_forceDirected.ForceDirectedTree);
          var networkSeries = chart.series.push(new am4plugins_forceDirected.ForceDirectedSeries())

          var data =  <?php echo $indicadoresEtapa; ?>;
          chart.data = [
            {
              name: "Total\nIndicadores",
              children: data
            }
          ];

          networkSeries.dataFields.value = "value";
          networkSeries.dataFields.name = "name";
          networkSeries.maxLevels = 2;
          networkSeries.dataFields.children = "children";
          networkSeries.nodes.template.tooltipText = "{name}: {value}";
          networkSeries.nodes.template.fillOpacity = 2;
          networkSeries.manyBodyStrength = -50;
          networkSeries.links.template.strength = 0.8;
          networkSeries.minRadius = am4core.percent(5);

          networkSeries.links.template.strokeWidth = 20;
          networkSeries.links.template.strokeOpacity = 0.3;
          networkSeries.links.template.disatnce = 1;

          networkSeries.nodes.template.label.text = "{name}\n{value}";

          networkSeries.nodes.template.propertyFields.url = "url";
          //networkSeries.nodes.template.urlTarget = "_blank";

          networkSeries.fontSize = 12;



          // var chartPDES = am4core.create("chartdivPDES", am4charts.SlicedChart);
          // chartPDES.hiddenState.properties.opacity = 0; // this makes initial fade in effect
          // var dataPDES =
          // chartPDES.data = dataPDES;
          //
          // var series = chartPDES.series.push(new am4charts.FunnelSeries());
          // series.colors.step = 2;
          // series.dataFields.value = "value";
          // series.dataFields.category = "name";
          // series.alignLabels = false;
          // series.orientation = "vertical";
          // series.bottomRatio = 1;


          // chartPDES.legend = new am4charts.Legend();
          // chartPDES.legend.position = "top";



          // var chartPDES = am4core.create("chartdivPDES", am4plugins_forceDirected.ForceDirectedTree);
          // var networkSeriesPDES = chartPDES.series.push(new am4plugins_forceDirected.ForceDirectedSeries())
          //
          // var dataPDES =  <?php /*echo $pdesPilares;*/ ?>;
          // chartPDES.data = [
          //   {
          //     name: "Total\nIndicadores",
          //     children: dataPDES
          //   }
          // ];
          // networkSeriesPDES.colors.list = [
          //   am4core.color("#67B7DC"),
          // ];
          //
          // networkSeriesPDES.dataFields.value = "value";
          // networkSeriesPDES.dataFields.name = "name";
          // networkSeriesPDES.maxLevels = 2;
          // networkSeriesPDES.dataFields.children = "children";
          // networkSeriesPDES.nodes.template.tooltipText = "{name}: {value}";
          // networkSeriesPDES.nodes.template.fillOpacity = 2;
          // networkSeriesPDES.manyBodyStrength = -30;
          // networkSeriesPDES.links.template.strength = 0.8;
          // networkSeriesPDES.minRadius = am4core.percent(7);
          //
          // networkSeriesPDES.links.template.strokeWidth = 20;
          // networkSeriesPDES.links.template.strokeOpacity = 0.3;
          // networkSeriesPDES.links.template.disatnce = 1;
          //
          // networkSeriesPDES.nodes.template.label.text = "{name}\n{value}";
          //
          // networkSeriesPDES.nodes.template.propertyFields.url = "url";
          // networkSeriesPDES.fontSize = 13;
    });
  </script>


@endpush
