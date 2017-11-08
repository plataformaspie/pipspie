@extends('layouts.plataforma')

@section('header')
  <link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.base.css') }}" type="text/css"/>
  <link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.light.css') }}" type="text/css"/>
  <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
  <link rel="stylesheet" href="{{ asset('css/visores.css') }}" type="text/css" />
  <style>
  #chartdiv {
    width: 100%;
    height: 450px;
  }
  .panel-heading{
    background: #D9EDF7;
    padding: 0 5px;
  }
  </style>
@endsection


@section('content')
<div id="opciones-padre" class="row">
  <div class="col-lg-12 col-md-12">
      <div class="">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                  <div class="white-box analytics-info p-10">
                      <div class="message-center">
                          <a href="javascript:void(0);" class="detallar" aria-controls="1">
                              <div class="user-img" style="width: 57px;"> <img src="{{ asset('img/priori-1.png') }}" alt="user" class="img-circle"> </div>
                              <div class="mail-contnet">
                                  <h4>DATOS MACROECONOMICOS Y SOCIALES</h4>
                              </div>
                          </a>
                      </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="white-box analytics-info p-10">
                        <div class="message-center">
                          <a href="javascript:void(0);" class="detallar" aria-controls="2">
                              <div class="user-img" style="width: 57px;"> <img src="{{ asset('img/priori-2.png') }}" alt="user" class="img-circle"></div>
                              <div class="mail-contnet">
                                  <h4>PROYECTOS ESPECIALES</h4>
                              </div>
                          </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                  <div class="white-box analytics-info p-10">
                      <div class="message-center">
                        <a href="javascript:void(0);" class="detallar" aria-controls="3">
                            <div class="user-img" style="width: 57px;"> <img src="{{ asset('img/priori-3.png') }}" alt="user" class="img-circle">  </div>
                            <div class="mail-contnet">
                                <h4>INVERSION PUBLICA</h4>
                            </div>
                        </a>
                      </div>
                  </div>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                  <div class="white-box center p-10">
                      <div class="message-center">
                        <a href="javascript:void(0);" class="detallar" aria-controls="4">
                            <div class="user-img" style="width: 57px;"> <img src="{{ asset('img/priori-4.png') }}" alt="user" class="img-circle"> </div>
                            <div class="mail-contnet">
                                <h4>RED VIAL FUNDAMENTAL</h4>
                            </div>
                        </a>
                      </div>
                  </div>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="white-box analytics-info p-10">
                        <div class="message-center">
                          <a href="javascript:void(0);" class="detallar" aria-controls="5">
                              <div class="user-img" style="width: 57px;"> <img src="{{ asset('img/priori-5.png') }}" alt="user" class="img-circle"> </div>
                              <div class="mail-contnet">
                                  <h4>INFORMES</h4>
                              </div>
                          </a>
                        </div>
                    </div>
                </div>
            </div>

      </div>
  </div>
</div>
<div id="opciones-hijos" style="display:none;">
  <div class="row" >
    <div id="titulo-hijo" class="col-lg-12 col-md-12" style="height: 66px;">

    </div>
  </div>

  <div class="row">
      <div class="col-lg-12">
          <div class="white-box p-10" style="margin-bottom: 1px;">
            <div class="row">
               <div id="desc_resultado" class="col-lg-12 list-group-item-warning font-normal" style="height: 36px;">
                 <!-- Nav tabs -->
                 <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="nav-item">
                       <a href="javascript:void(0);" class="nav-link panel-menu active" aria-controls="m-p-datos">
                         <span class="visible-xs"><i class=" fa fa-book"></i></span>
                         <span class="hidden-xs"><i class=" fa  fa-book "></i> Datos</span></a>
                     </li>
                     <li role="presentation" class="nav-item">
                       <a href="javascript:void(0);" class="nav-link panel-menu" aria-controls="m-p-filtros">
                         <span class="visible-xs"><i class=" ti-filter "></i></span>
                         <span class="hidden-xs"><i class=" ti-filter "></i> Filtros</span></a>
                     </li>
                     <li role="presentation" class="nav-item">
                       <a href="javascript:void(0);" class="nav-link panel-menu" aria-controls="m-p-detalles">
                         <span class="visible-xs"><i class="fa fa-info-circle"></i></span>
                         <span class="hidden-xs"><i class="fa fa-info-circle"></i> Filtro Avanzado</span>
                       </a>
                     </li>
                     <li role="presentation" class="nav-item">
                       <a href="javascript:void(0);" class="nav-link panel-menu" aria-controls="m-p-graficas">
                         <span class="visible-xs"><i class="fa fa-bar-chart-o"></i></span>
                         <span class="hidden-xs"><i class="fa fa-bar-chart-o"></i> Graficas</span>
                       </a>
                     </li>



                 </ul>
               </div>
            </div>
          </div>
      </div>
  </div>

  <div id="cont-panel-menu" class="row" style="display:none;" >
      <div class="col-lg-12">
          <div class="white-box p-10" style="background-color: #fcf8e3;color: #8a6d3b;">
            <!-- Tab panes -->
            <div class="tab-content m-0">
                <div role="tabpanel" class="tab-pane" id="m-p-detalles">
                  <div class="stats-row m-0">
                      <div class="stat-item containertipoimg">
                        Filtros desactivados
                      </div>

                  </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="m-p-graficas">

                  <div class="stats-row m-0">
                      <div class="stat-item containertipoimg">
                          <img name="column" src="{{ asset('img/icon-graf/11.png') }}" alt="11" class="image imgsel">
                          <div class="middle">
                            <div class="text">Usar</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="serial" src="{{ asset('img/icon-graf/1.png') }}" alt="1" class="image">
                          <div class="middle">
                            <div class="text">Usar</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="line" src="{{ asset('img/icon-graf/3.png') }}" alt="3" class="image">
                          <div class="middle">
                            <div class="text">Usar</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg hide">
                          <img name="pie" src="{{ asset('img/icon-graf/8.png') }}" alt="8" class="image">
                          <div class="middle">
                            <div class="text">Usar</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="area" src="{{ asset('img/icon-graf/4.png') }}" alt="4" class="image">
                          <div class="middle">
                            <div class="text">Usar</div>
                          </div>
                      </div>

                  </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="m-p-filtros" aria-expanded="true">

                </div>

            </div>

          </div>
      </div>
  </div>
  <div class="row" >
        <div id="contenido_datos" class="col-lg-3 col-md-12">
          <div class="white-box">
                <div id='jqxNavigationBar'>


                </div>
           </div>
        </div>

        <div id="contenido_detalle" class="col-lg-9 col-md-12 block">

            <div class="white-box p-10 block-content">
                <div style="height: 500px;">
                  <div id="chartdiv"></div>
                  <div id="separador"><hr/></div>
                  <div id="jqxgrid"></div>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection


@push('script-head')
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxcore.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxnavigationbar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxbuttons.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxscrollbar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxlistbox.js') }}"></script>


  <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
  <script src="https://www.amcharts.com/lib/3/serial.js"></script>
  <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
  <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

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


  var chart;
  var filtroSel;
  $(document).ready(function(){
    activarMenu('x','mp-9');
    menuModulosHideShow(1)
    var theme = 'light';




    $("#jqxNavigationBar").jqxNavigationBar({ theme:theme,width: "100%", expandMode: 'toggle'});



    $('.detallar').click(function() {
        $('#opciones-hijos').show();
        $('#opciones-padre').hide();

        $('#titulo-hijo').html('');
        $('#jqxNavigationBar').html('');

        var padre = $(this).attr("aria-controls");

        $.ajax({
                url: "{{url("/modulopriorizacion/ajax/cargarhijos")}}",
                data: {'padre': padre },
                type: "GET",
                dataType: 'json',
                success: function(date){
                  $.each(date, function(i, item) {
                    if(i=='titulo'){
                      $('#titulo-hijo').html(item);
                    }
                    if(i=='hijos'){
                      $('#jqxNavigationBar').html(item);
                      //$('#jqxNavigationBar').jqxNavigationBar({ source: item});
                    }

                  });
                  $('#jqxNavigationBar').jqxNavigationBar('add','-', ' ');
                  //$('#jqxNavigationBar').jqxNavigationBar('update', 1, 'Header', 'Content');
                  //$('#jqxNavigationBar').jqxNavigationBar('collapseAt', 0);
                  //$('#jqxNavigationBar').jqxNavigationBar('insert', 1, '-', '-');
                  //$('#jqxNavigationBar').jqxNavigationBar('refresh');

                },
                error:function(data){
                  console("Error recuperando configuracion de filtro de combos.");
                }
         });
    });







    var pressHistorico = "m-p-datos";
    $('.panel-menu').click(function() {
      //configuramos y activamos el menu del panel
      $('.panel-menu').removeClass('active');
      var panel = $(this).attr("aria-controls");
      $(this).addClass('active');
      if(panel != "m-p-datos"){
          if(pressHistorico == panel && $('#cont-panel-menu').is(":visible")){
              $('#cont-panel-menu').hide();
          }else{
            pressHistorico = panel;
            //configuramos y activamos el panel
            $('#cont-panel-menu').show();
            $('.tab-pane').removeClass('active');
            $('#'+panel).addClass('active');

            if($('#contenido_datos').is(":visible") && $('.mobile-main').is(":visible")){
              $('#contenido_datos').hide();
            }
          }
      }else{

          if(pressHistorico == panel && $('#contenido_datos').is(":visible")){
              //$('#contenido_datos').hide();
              $('#contenido_datos').attr('style','display:none !important');
          }else{
            pressHistorico = panel;
            $('#contenido_datos').show();
            $('#cont-panel-menu').hide();
          }

      }

    });

    function limpiarPaneles(){
      //LIMPIAMOS LOS PANELS SECUNDARIOS ANTES DE VARGAR ALGUN DATO
      $('#cont-panel-menu').hide();
      $('.panel-menu').removeClass('active');
      $('.tab-pane').removeClass('active');
    }



    $('.middle').click(function() {

          $(".image").removeClass('imgsel');
          $(this).siblings('img').addClass('imgsel');
          var type = $(this).siblings('img').attr('name');
          switch (type) {
            case 'line':
              for(i=0;i < filtroSel;i++){
                chart.graphs[i].type = 'line';
                chart.graphs[i].bullet = 'round';
                chart.graphs[i].lineAlpha = 2;
                chart.graphs[i].fillAlphas = 0;
              }

              chart.rotate = false;
              chart.validateNow();
              break;
            case 'area':
              for(i=0;i < filtroSel;i++){
                chart.graphs[i].type = 'line';
                chart.graphs[i].bullet = 'round';
                chart.graphs[i].lineAlpha = 1;
                chart.graphs[i].fillAlphas = 0.3;
              }

              chart.rotate = false;
              chart.validateNow();
              break;
            case 'column':
              for(i=0;i < filtroSel;i++){
                chart.graphs[i].type = 'column';
                chart.graphs[i].lineAlpha = 2;
                chart.graphs[i].fillAlphas = 1;
              }

              chart.rotate = false;
              chart.validateNow();
            break;
            case 'serial':
              for(i=0;i < filtroSel;i++){
                chart.graphs[i].type = 'column';
                chart.graphs[i].lineAlpha = 2;
                chart.graphs[i].fillAlphas = 1;
              }
              //chart.valueAxes.stackType = 'regular';
              chart.rotate = true;
              chart.validateNow();
            break;
            case 'pie':

            AmCharts.makeChart("chartdiv",
                  {
                    "type": "pie",
                    "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                    "titleField": "dimension",
                    "valueField": "valor",
                    "allLabels": [],
                    "balloon": {},
                    "legend": {
                      "enabled": true,
                      "align": "center",
                      "markerType": "circle",
                      "valueText": "",
                    },
                    "titles": [],
                    "dataProvider":chartData
                  }
                );
              return;
          }

    });




  });

function operador(ele){
      var operador = $(ele).val();

 }
function filtDepto(ele,vista,campo,nivel,title){
  filtroSel = 9;
$('#contenido_detalle').toggleClass('block-opt-refresh');
  if($('input:radio[name=operador]:checked').val() == 'null'){
    var operador = null;
    var simbolo = " ";
    var subtitle = "(Expresado en número de personas)";
  }else{
    var operador = true;
    var simbolo = "%";
    var subtitle = "(Expresado en porcentaje)";
  }

  $(".image").removeClass('imgsel');
  $(ele).siblings('img').addClass('imgsel');
  $.ajax({
          url: "{{url("/modulopriorizacion/ajax/obtenerDatosFiltro")}}",
          data: {'variableEstadistica':vista,'campo':campo,'nivel':nivel,'porcentaje': operador},
          type: "GET",
          dataType: 'json',
          success: function(date){
                graficaDepartamento(date,title,simbolo,subtitle);
          },
          error:function(data){
            console("Error recuperar los datos.");
          }
  });

}

function filtUrbRu(ele,vista,campo,nivel,title){
  filtroSel = 2;
$('#contenido_detalle').toggleClass('block-opt-refresh');
if($('input:radio[name=operador]:checked').val() == 'null'){
  var operador = null;
  var simbolo = " ";
  var subtitle = "(Expresado en número de personas)";
}else{
  var operador = true;
  var simbolo = "%";
  var subtitle = "(Expresado en porcentaje)";
}
  $(".image").removeClass('imgsel');
  $(ele).siblings('img').addClass('imgsel');
  $.ajax({
          url: "{{url("/modulopriorizacion/ajax/obtenerDatosFiltro")}}",
          data: {'variableEstadistica':vista,'campo':campo,'nivel':nivel,'porcentaje':operador},
          type: "GET",
          dataType: 'json',
          success: function(date){
                graficaUrbRu(date,title,simbolo,subtitle);
          },
          error:function(data){
            console("Error recuperar los datos.");
          }
  });

}

function filtGenero(ele,vista,campo,nivel,title){
  filtroSel = 2;
  $('#contenido_detalle').toggleClass('block-opt-refresh');
  if($('input:radio[name=operador]:checked').val() == 'null'){
    var operador = null;
    var simbolo = " ";
    var subtitle = "(Expresado en número de personas)";
  }else{
    var operador = true;
    var simbolo = "%";
    var subtitle = "(Expresado en porcentaje)";
  }

        $(".image").removeClass('imgsel');
        $(ele).siblings('img').addClass('imgsel');
        $.ajax({
                url: "{{url("/modulopriorizacion/ajax/obtenerDatosFiltro")}}",
                data: {'variableEstadistica':vista,'campo':campo,'nivel':nivel,'porcentaje':operador},
                type: "GET",
                dataType: 'json',
                success: function(date){
                      graficaGenero(date,title,simbolo,subtitle);
                },
                error:function(data){
                  console("Error recuperar los datos.");
                }
        });

}

function filtPex(ele,vista,campo,nivel,title){
  filtroSel = 3;
  $('#contenido_detalle').toggleClass('block-opt-refresh');
  if($('input:radio[name=operador]:checked').val() == 'null'){
    var operador = null;
    var simbolo = " ";
    var subtitle = "(Expresado en número de personas)";
  }else{
    var operador = true;
    var simbolo = "%";
    var subtitle = "(Expresado en porcentaje)";
  }
  $(".image").removeClass('imgsel');
  $(ele).siblings('img').addClass('imgsel');
  $.ajax({
          url: "{{url("/modulopriorizacion/ajax/obtenerDatosFiltro")}}",
          data: {'variableEstadistica':vista,'campo':campo,'nivel':nivel,'porcentaje':operador},
          type: "GET",
          dataType: 'json',
          success: function(date){
                graficaPex(date,title,simbolo,subtitle);
          },
          error:function(data){
            console("Error recuperar los datos.");
          }
  });

}
function filtPmo(ele,vista,campo,nivel,title){
  filtroSel = 3;
  $('#contenido_detalle').toggleClass('block-opt-refresh');
  if($('input:radio[name=operador]:checked').val() == 'null'){
    var operador = null;
    var simbolo = " ";
    var subtitle = "(Expresado en número de personas)";
  }else{
    var operador = true;
    var simbolo = "%";
    var subtitle = "(Expresado en porcentaje)";
  }
  $(".image").removeClass('imgsel');
  $(ele).siblings('img').addClass('imgsel');
  $.ajax({
          url: "{{url("/modulopriorizacion/ajax/obtenerDatosFiltro")}}",
          data: {'variableEstadistica':vista,'campo':campo,'nivel':nivel,'porcentaje':operador},
          type: "GET",
          dataType: 'json',
          success: function(date){
                graficaPmo(date,title,simbolo,subtitle);
          },
          error:function(data){
            console("Error recuperar los datos.");
          }
  });

}
function filtDesem(ele,vista,campo,nivel,title){
  filtroSel = 3;
  $('#contenido_detalle').toggleClass('block-opt-refresh');
  if($('input:radio[name=operador]:checked').val() == 'null'){
    var operador = null;
    var simbolo = " ";
    var subtitle = "(Expresado en número de personas)";
  }else{
    var operador = true;
    var simbolo = "%";
    var subtitle = "(Expresado en porcentaje)";
  }
  $(".image").removeClass('imgsel');
  $(ele).siblings('img').addClass('imgsel');
  $.ajax({
          url: "{{url("/modulopriorizacion/ajax/obtenerDatosFiltro")}}",
          data: {'variableEstadistica':vista,'campo':campo,'nivel':nivel,'porcentaje':operador},
          type: "GET",
          dataType: 'json',
          success: function(date){
                graficaDesem(date,title,simbolo,subtitle);
          },
          error:function(data){
            console("Error recuperar los datos.");
          }
  });

}
  function back(){
      $('#opciones-padre').show();
      $('#opciones-hijos').hide();
  }

function configurarFiltros(ele){

  var cod = ele.substr(0,8);
  $("#m-p-filtros").html("");
  $.ajax({
          url: "{{url("/modulopriorizacion/ajax/configurarfiltrovariable")}}",
          data: {'cod':cod},
          type: "GET",
          dataType: 'json',
          success: function(date){
            $("#m-p-filtros").html(date);


          },
          error:function(data){
            console("Error recuperar los datos.");
          }
  });
}
  function configurarDatosVE0001(ele){
    filtroSel = 1;
    $('#contenido_detalle').toggleClass('block-opt-refresh');
    configurarFiltros(ele);
    // $.ajax({
    //         url: "{{url("/modulopriorizacion/ajax/generardatosVE0001")}}",
    //         data: {'vista':ele},
    //         type: "GET",
    //         dataType: 'json',
    //         success: function(date){
    //           chartData = [];
    //           var unidad = "";
    //           date.forEach(function(d, i) {
    //               unidad = d.unidad;
    //               chartData.push({
    //                   dimension: d.dimension,
    //                   valor: parseInt(d.valor, 10)
    //               });
    //           });
    //           graficarVariable(chartData,'POBREZA EXTREMA');
    //
    //
    //         },
    //         error:function(data){
    //           console("Error recuperar los datos.");
    //         }
    // });

    $.ajax({
            url: "{{url("/modulopriorizacion/ajax/obtenerDatosFiltro")}}",
            data: {'variableEstadistica':ele,'campo':null,'nivel': 'POBRE EXTREMO','porcentaje': null},
            type: "GET",
            dataType: 'json',
            success: function(date){
                graficarVariable(date,'POBREZA EXTREMA');
            },
            error:function(data){
              console("Error recuperar los datos.");
            }
    });
  }

  function configurarDatosVE0002(ele){
    filtroSel = 1;
    $('#contenido_detalle').toggleClass('block-opt-refresh');
    configurarFiltros(ele);
    // $.ajax({
    //         url: "{{url("/modulopriorizacion/ajax/generardatosVE0002")}}",
    //         data: {'vista':ele},
    //         type: "GET",
    //         dataType: 'json',
    //         success: function(date){
    //           chartData = [];
    //           var unidad = "";
    //           date.forEach(function(d, i) {
    //               unidad = d.unidad;
    //               chartData.push({
    //                   dimension: d.dimension,
    //                   valor: parseInt(d.valor, 10)
    //               });
    //           });
    //           graficarVariable(chartData,'POBREZA MODERADA');
    //
    //
    //         },
    //         error:function(data){
    //           console("Error recuperar los datos.");
    //         }
    // });
    $.ajax({
            url: "{{url("/modulopriorizacion/ajax/obtenerDatosFiltro")}}",
            data: {'variableEstadistica':ele,'campo':null,'nivel': 'POBRE','porcentaje': null},
            type: "GET",
            dataType: 'json',
            success: function(date){
                graficarVariable(date,'POBREZA MODERADA');
            },
            error:function(data){
              console("Error recuperar los datos.");
            }
    });
  }

  function configurarDatosVE0003(ele){
    filtroSel = 1;
    $('#contenido_detalle').toggleClass('block-opt-refresh');
    configurarFiltros(ele);
    // $.ajax({
    //         url: "{{url("/modulopriorizacion/ajax/generardatosVE0003")}}",
    //         data: {'vista':ele},
    //         type: "GET",
    //         dataType: 'json',
    //         success: function(date){
    //           chartData = [];
    //           var unidad = "";
    //           date.forEach(function(d, i) {
    //               unidad = d.unidad;
    //               chartData.push({
    //                   dimension: d.dimension,
    //                   valor: parseInt(d.valor, 10)
    //               });
    //           });
    //           graficarVariable(chartData,'DESEMPLEO');
    //
    //
    //         },
    //         error:function(data){
    //           console("Error recuperar los datos.");
    //         }
    // });
    $.ajax({
            url: "{{url("/modulopriorizacion/ajax/obtenerDatosFiltro")}}",
            data: {'variableEstadistica':ele,'campo':null,'nivel': 'DESOCUPADO','porcentaje': null},
            type: "GET",
            dataType: 'json',
            success: function(date){
                graficarVariable(date,'DESEMPLEO');
            },
            error:function(data){
              console("Error recuperar los datos.");
            }
    });
  }
  function iniGrafica(){
    var ini = [{
      "dimension": "-",
      "valor": 0,
      "color": "#FF0F00"
    }];
    graficarVariable(ini,'-');
  }

  function graficarVariable(data,title){
  $('#contenido_detalle').removeClass('block-opt-refresh');
    chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",
        "theme": "light",
        "marginRight": 80,
        "autoMarginOffset": 20,
        "marginTop": 7,
        "dataProvider": data,
        "titles": [
           {
             "id": "Title-1",
             "size": 15,
             "text": title
           },{
             "text": "(Expresado en número de personas)"
           }
         ],
        "valueAxes": [{
            "axisAlpha": 0.2,
            "dashLength": 1,
            "position": "left"
        }],
        "mouseWheelZoomEnabled": true,
        "graphs": [{
            "id": "g1",
            "balloonText": "<b>[[category]]</b>\n [[value]]",
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "hideBulletsCount": 50,
            "title": "red line",
            "valueField": "valor",
            "useLineColorForBulletBorder": true,
            "balloon":{
                "drop":true
            }
        }],
        "chartScrollbar": {
            "autoGridCount": true,
            "graph": "g1",
            "scrollbarHeight": 40
        },
        "chartCursor": {
           "limitToGraph":"g1"
        },
        "categoryField": "gestion",
        "categoryAxis": {
            //"parseDates": true,
            "axisColor": "#DADADA",
            "dashLength": 1,
            "minorGridEnabled": true
        },
        "export": {
            "enabled": true
        }
    });
    chart.addListener("rendered", zoomChart);
    //zoomChart();
  }

  function graficaGenero(data,title,simbolo,subtitle){
    $('#contenido_detalle').removeClass('block-opt-refresh');
    chart = AmCharts.makeChart("chartdiv", {
            	"type": "serial",
            	"categoryField": "gestion",
            	"dataDateFormat": "YYYY",
            	"theme": "default",
            	"categoryAxis": {
            		"minPeriod": "YYYY",
            		"parseDates": true
            	},
            	"chartCursor": {
            		"enabled": true,
            		"animationDuration": 0,
            		"categoryBalloonDateFormat": "YYYY"
            	},
            	"chartScrollbar": {
            		"enabled": true
            	},
            	"trendLines": [],
            	"graphs": [
            		{
            			"bullet": "round",
                  "balloonText": "<b>HOMBRE</b>:[[value]] "+simbolo,
            			"id": "AmGraph-1",
            			"title": "HOMBRE",
            			"valueField": "HOMBRE"
            		},
            		{
            			"bullet": "square",
                  "balloonText": "<b>MUJER</b>:[[value]] "+simbolo,
            			"id": "AmGraph-2",
            			"title": "MUJER",
            			"valueField": "MUJER"
            		}
            	],
            	"guides": [],
            	"valueAxes": [
            		{
            			"id": "ValueAxis-1",
            			"title": "VALORES"
            		}
            	],
            	"allLabels": [],
            	"balloon": {},
            	"legend": {
            		"enabled": true,
            		"useGraphSettings": true
            	},
            	"titles": [
            		{
            			"id": "Title-1",
            			"size": 15,
            			"text": title,

            		},{
                  "text":subtitle
                }
            	],
            	"dataProvider": data
            });
  }


  function graficaDepartamento(data,title,simbolo,subtitle){
    $('#contenido_detalle').removeClass('block-opt-refresh');
    chart = AmCharts.makeChart("chartdiv", {
            	"type": "serial",
            	"categoryField": "gestion",
            	"dataDateFormat": "YYYY",
            	"theme": "default",
            	"categoryAxis": {
            		"minPeriod": "YYYY",
            		"parseDates": true
            	},
            	"chartCursor": {
            		"enabled": true,
            		"animationDuration": 0,
            		"categoryBalloonDateFormat": "YYYY"
            	},
            	"chartScrollbar": {
            		"enabled": true
            	},
            	"trendLines": [],
            	"graphs": [
            		{
            			"bullet": "round",
                  "balloonText": "<b>CHUQUISACA</b>:[[value]] "+simbolo,
            			"id": "AmGraph-1",
            			"title": "CHUQUISACA",
            			"valueField": "CHUQUISACA"
            		},
            		{
            			"bullet": "round",
                  "balloonText": "<b>LA PAZ</b>:[[value]] "+simbolo,
            			"id": "AmGraph-2",
            			"title": "LA PAZ",
            			"valueField": "LA PAZ"
            		},{
            			"bullet": "round",
                  "balloonText": "<b>COCHABAMBA</b>:[[value]] "+simbolo,
            			"id": "AmGraph-3",
            			"title": "COCHABAMBA",
            			"valueField": "COCHABAMBA"
            		},{
            			"bullet": "round",
                  "balloonText": "<b>ORURO</b>:[[value]] "+simbolo,
            			"id": "AmGraph-4",
            			"title": "ORURO",
            			"valueField": "ORURO"
            		},{
            			"bullet": "round",
                  "balloonText": "<b>POTOS\u00cd</b>:[[value]] "+simbolo,
            			"id": "AmGraph-5",
            			"title": "POTOS\u00cd",
            			"valueField": "POTOS\u00cd"
            		},{
            			"bullet": "round",
                  "balloonText": "<b>TARIJA</b>:[[value]] "+simbolo,
            			"id": "AmGraph-6",
            			"title": "TARIJA",
            			"valueField": "TARIJA"
            		},{
            			"bullet": "round",
                  "balloonText": "<b>SANTA CRUZ</b>:[[value]] "+simbolo,
            			"id": "AmGraph-7",
            			"title": "SANTA CRUZ",
            			"valueField": "SANTA CRUZ"
            		},{
            			"bullet": "round",
                  "balloonText": "<b>BENI</b>:[[value]] "+simbolo,
            			"id": "AmGraph-8",
            			"title": "BENI",
            			"valueField": "BENI"
            		},{
            			"bullet": "round",
                  "balloonText": "<b>PANDO</b>:[[value]] "+simbolo,
            			"id": "AmGraph-9",
            			"title": "PANDO",
            			"valueField": "PANDO"
            		}
            	],
            	"guides": [],
            	"valueAxes": [
            		{
            			"id": "ValueAxis-1",
            			"title": "Valore"
            		}
            	],
            	"allLabels": [],
            	"balloon": {},
            	"legend": {
            		"enabled": true,
            		"useGraphSettings": true
            	},
            	"titles": [
            		{
            			"id": "Title-1",
            			"size": 15,
            			"text": title
            		},{
                  "text":subtitle
                }
            	],
            	"dataProvider": data
            });
  }

  function graficaUrbRu(data,title,simbolo,subtitle){
    $('#contenido_detalle').removeClass('block-opt-refresh');
    chart = AmCharts.makeChart("chartdiv", {
            	"type": "serial",
            	"categoryField": "gestion",
            	"dataDateFormat": "YYYY",
            	"theme": "default",
            	"categoryAxis": {
            		"minPeriod": "YYYY",
            		"parseDates": true
            	},
            	"chartCursor": {
            		"enabled": true,
            		"animationDuration": 0,
            		"categoryBalloonDateFormat": "YYYY"
            	},
            	"chartScrollbar": {
            		"enabled": true
            	},
            	"trendLines": [],
            	"graphs": [
            		{
            			"bullet": "round",
                  "balloonText": "<b>\u00c1REA RURAL</b>:[[value]] "+simbolo,
            			"id": "AmGraph-1",
            			"title": "\u00c1REA RURAL",
            			"valueField": "\u00c1REA RURAL"
            		},
            		{
            			"bullet": "square",
                  "balloonText": "<b>\u00c1REA URBANA</b>:[[value]] "+simbolo,
            			"id": "AmGraph-2",
            			"title": "\u00c1REA URBANA",
            			"valueField": "\u00c1REA URBANA"
            		}
            	],
            	"guides": [],
            	"valueAxes": [
            		{
            			"id": "ValueAxis-1",
            			"title": "Valores"
            		}
            	],
            	"allLabels": [],
            	"balloon": {},
            	"legend": {
            		"enabled": true,
            		"useGraphSettings": true
            	},
            	"titles": [
            		{
            			"id": "Title-1",
            			"size": 15,
            			"text": title
            		},{
                  "text":subtitle
                }
            	],
            	"dataProvider": data
            });
  }


  function graficaPex(data,title,simbolo,subtitle){
    $('#contenido_detalle').removeClass('block-opt-refresh');
    chart = AmCharts.makeChart("chartdiv", {
            	"type": "serial",
            	"categoryField": "gestion",
            	"theme": "default",
            	"categoryAxis": {
                "dashLength": 1,
                "minorGridEnabled": true
            	},
            	"chartCursor": {
            		"enabled": true,
            		"animationDuration": 0
            	},
            	"chartScrollbar": {
            		"enabled": true
            	},
            	"trendLines": [],
            	"graphs": [
            		{
            			"bullet": "round",
                  "balloonText": "<b>NO POBRE EXTREMO</b>:[[value]] "+simbolo,
            			"id": "AmGraph-1",
            			"title": "NO POBRE EXTREMO",
            			"valueField": "NO POBRE EXTREMO"
            		},
            		{
            			"bullet": "round",
                  "balloonText": "<b>POBRE EXTREMO</b>:[[value]] "+simbolo,
            			"id": "AmGraph-2",
            			"title": "POBRE EXTREMO",
            			"valueField": "POBRE EXTREMO"
            		},
            		{
            			"bullet": "round",
                  "balloonText": "<b>SIN IDENTIFICAR</b>:[[value]] "+simbolo,
            			"id": "AmGraph-3",
            			"title": "SIN IDENTIFICAR",
            			"valueField": "otros"
            		}
            	],
            	"guides": [],
            	"valueAxes": [
            		{
            			"id": "ValueAxis-1",
            			"title": "Valores"
            		}
            	],
            	"allLabels": [],
            	"balloon": {},
            	"legend": {
            		"enabled": true,
            		"useGraphSettings": true
            	},
            	"titles": [
            		{
            			"id": "Title-1",
            			"size": 15,
            			"text": title
            		},{
                  "text":subtitle
                }
            	],
            	"dataProvider": data
            });
  }


  function graficaPmo(data,title,simbolo,subtitle){
    $('#contenido_detalle').removeClass('block-opt-refresh');
    chart = AmCharts.makeChart("chartdiv", {
              "type": "serial",
              "categoryField": "gestion",
              "theme": "default",
              "categoryAxis": {
                "dashLength": 1,
                "minorGridEnabled": true
              },
              "chartCursor": {
                "enabled": true,
                "animationDuration": 0
              },
              "chartScrollbar": {
                "enabled": true
              },
              "trendLines": [],
              "graphs": [
                {
                  "bullet": "round",
                  "balloonText": "<b>NO POBRE</b>:[[value]] "+simbolo,
                  "id": "AmGraph-1",
                  "title": "NO POBRE",
                  "valueField": "NO POBRE"
                },
                {
                  "bullet": "round",
                  "balloonText": "<b>POBRE</b>:[[value]] "+simbolo,
                  "id": "AmGraph-2",
                  "title": "POBRE",
                  "valueField": "POBRE"
                },
                {
                  "bullet": "round",
                  "balloonText": "<b>SIN IDENTIFICAR</b>:[[value]] "+simbolo,
                  "id": "AmGraph-3",
                  "title": "SIN IDENTIFICAR",
                  "valueField": "otros"
                }
              ],
              "guides": [],
              "valueAxes": [
                {
                  "id": "ValueAxis-1",
                  "title": "Valores"
                }
              ],
              "allLabels": [],
              "balloon": {},
              "legend": {
                "enabled": true,
                "useGraphSettings": true
              },
              "titles": [
                {
                  "id": "Title-1",
                  "size": 15,
                  "text": title
                },{
                  "text":subtitle
                }
              ],
              "dataProvider": data
            });
  }


  function graficaDesem(data,title,simbolo,subtitle){
    $('#contenido_detalle').removeClass('block-opt-refresh');
    chart = AmCharts.makeChart("chartdiv", {
              "type": "serial",
              "categoryField": "gestion",
              "theme": "default",
              "categoryAxis": {
                "dashLength": 1,
                "minorGridEnabled": true
              },
              "chartCursor": {
                "enabled": true,
                "animationDuration": 0
              },
              "chartScrollbar": {
                "enabled": true
              },
              "trendLines": [],
              "graphs": [
                {
                  "bullet": "round",
                  "balloonText": "<b>OCUPADO</b>:[[value]] "+simbolo,
                  "id": "AmGraph-1",
                  "title": "OCUPADO",
                  "valueField": "OCUPADO"
                },
                {
                  "bullet": "round",
                  "balloonText": "<b>DESOCUPADO</b>:[[value]] "+simbolo,
                  "id": "AmGraph-2",
                  "title": "DESOCUPADO",
                  "valueField": "DESOCUPADO"
                },
                {
                  "bullet": "round",
                  "balloonText": "<b>SIN IDENTIFICAR</b>:[[value]] "+simbolo,
                  "id": "AmGraph-3",
                  "title": "SIN IDENTIFICAR",
                  "valueField": "otros"
                }
              ],
              "guides": [],
              "valueAxes": [
                {
                  "id": "ValueAxis-1",
                  "title": "Valores"
                }
              ],
              "allLabels": [],
              "balloon": {},
              "legend": {
                "enabled": true,
                "useGraphSettings": true
              },
              "titles": [
                {
                  "id": "Title-1",
                  "size": 15,
                  "text": title
                },{
                  "text":subtitle
                }
              ],
              "dataProvider": data
            });
  }

  function zoomChart() {
    // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
    chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);
  }


  </script>
@endpush
