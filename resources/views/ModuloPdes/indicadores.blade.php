@extends('layouts.plataforma')
@section('header')


<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.base.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.light.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.darkblue.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('css/visores.css') }}" type="text/css" />

<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<style>
#chartdiv {
  width: 100%;
  height: 450px;
}
</style>
@endsection
@section('content')

  <div class="row">
      <div class="col-lg-12">
          <div class="white-box p-10" style="margin-bottom: 1px;">
            <div class="row">
               <div class="col-lg-3 btn-group">
                   <div>
                       <button id="clear_filtro_pdes" type="button" class="btn btn-sm btn-info btn-circle">
                         <i class="fa fa-times"></i>
                       </button>
                   </div>
                   <div  id="pilares"></div>
                   <div id="metas"></div>
                   <div id="resultados"></div>
                   <div>
                        <button id="aplicar_filtro" class="btn btn-sm btn-info waves-effect waves-light">
                          <i class="fa fa-filter m-l-5"></i> <span>Aplicar</span>
                        </button>
                   </div>
                   <div>

                   </div>
               </div>

               <div id="desc_resultado" class="col-lg-9 list-group-item-warning font-normal" style="height: 36px;">
                 <!-- Nav tabs -->
                 <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="nav-item">
                       <a href="javascript:void(0);" class="nav-link panel-menu" aria-controls="m-p-detalles">
                         <span class="visible-xs"><i class="fa fa-info-circle"></i></span>
                         <span class="hidden-xs"><i class="fa fa-info-circle"></i> Detalles</span>
                       </a>
                     </li>
                     <li role="presentation" class="nav-item mobile-main">
                       <a href="javascript:void(0);" class="nav-link panel-menu" aria-controls="m-p-datos">
                         <span class="visible-xs"><i class=" fa fa-book"></i></span>
                         <span class="hidden-xs"><i class=" fa  fa-book "></i> Datos</span></a>
                     </li>

                     <li role="presentation" class="nav-item">
                       <a href="javascript:void(0);" class="nav-link panel-menu" aria-controls="m-p-graficas">
                         <span class="visible-xs"><i class="fa fa-bar-chart-o"></i></span>
                         <span class="hidden-xs"><i class="fa fa-bar-chart-o"></i> Graficas</span>
                       </a>
                     </li>

                     <li role="presentation" class="nav-item">
                       <a href="javascript:void(0);" class="nav-link panel-menu" aria-controls="m-p-filtros">
                         <span class="visible-xs"><i class=" ti-filter "></i></span>
                         <span class="hidden-xs"><i class=" ti-filter "></i> Filtros</span></a>
                     </li>

                 </ul>
               </div>
            </div>
          </div>
      </div>
  </div>
  {{-- <div id="cont-panel-menu" class="row" style="display:none;position: absolute; z-index: 1; width: 100%;" > --}}
  <div id="cont-panel-menu" class="row" style="display:none;" >
      <div class="col-lg-12">
          <div class="white-box p-10" style="background-color: #fcf8e3;color: #8a6d3b;">
            <!-- Tab panes -->
            <div class="tab-content m-0">
                <div role="tabpanel" class="tab-pane" id="m-p-detalles">
                  Descripcion de los pilares, metas y resultados seleccionados.
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
                      <div class="stat-item containertipoimg">
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
                  <div class="row">
                      <div class="col-lg-6">
                        <p>
                          <b><i class="fa fa-list gly-rotate-90"></i> Filtro Columnas</b><button id="clear_filtro_cols" type="button" class="fcbtn btn btn-outline btn-info  btn-1b btn-xs" style="margin-bottom: 2px;"><i class="fa fa-cut"></i> </button>
                          <div id='jqxFiltroColumna'></div>
                        </p>
                        <p>
                          <b><i class="fa fa-list"></i> Filtro Filas</b><button id="clear_filtro_rows" type="button" class="fcbtn btn btn-outline btn-info  btn-1b btn-xs" style="margin-bottom: 2px;"><i class="fa fa-cut"></i> </button>
                            <div id='jqxFiltroFila'></div>
                        </p>
                      </div>
                      <div class="col-lg-6">

                        <div class="row">
                            <div class="col-lg-6">
                              <b><i class="fa fa-filter"></i> Filtrar Dimension (1) </b><button id="clear_filtro_1" type="button" class="fcbtn btn btn-outline btn-info  btn-1b btn-xs" style="margin-bottom: 2px;"><i class="fa fa-cut"></i> </button>
                              <div id='jqxFiltroDimension1'></div>
                            </div>
                            <div class="col-lg-6">
                              <b> = Valor </b>
                              <div id='jqxFiltroDimensionValor1'></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                              <b><i class="fa fa-filter"></i> Filtrar Dimension (2)</b><button id="clear_filtro_2" type="button" class="fcbtn btn btn-outline btn-info  btn-1b btn-xs" style="margin-bottom: 2px;"><i class="fa fa-cut"></i> </button>
                              <div id='jqxFiltroDimension2'></div>
                            </div>
                            <div class="col-lg-6">
                              <b> = Valor </b>
                              <div id='jqxFiltroDimensionValor2'></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                              <b><i class="fa fa-filter"></i> Filtrar Dimension (3)</b><button id="clear_filtro_3" type="button" class="fcbtn btn btn-outline btn-info  btn-1b btn-xs" style="margin-bottom: 2px;"><i class="fa fa-cut"></i> </button>
                              <div id='jqxFiltroDimension3'></div>
                            </div>
                            <div class="col-lg-6">
                              <b> = Valor </b>
                              <div id='jqxFiltroDimensionValor3'></div>
                            </div>
                        </div>
                      </div>
                  </div>
                  <hr style="margin-top: 8px; margin-bottom: 8px;"/>
                  <div class="row">
                      <div class="col-lg-12">
                          <button id="filtro_grafica" class="btn btn-block btn-warning btn-outline"><i class="fa fa-filter m-l-5"></i> Aplicar Filtro </button>
                      </div>
                  </div>
                </div>

            </div>

          </div>
      </div>
  </div>

  <div class="row">

      <div id="contenido_datos" class="col-lg-4 col-md-12">
          <div class="white-box p-10">

              <h3 class="box-title"> Indicadores del Resultado por tipo <b id="resultado_lita_resultado"></b>
                <button id="graficar" class="btn btn-sm btn-info waves-effect waves-light pull-right">
                <span>Graficar</span> <i class="fa fa-bar-chart-o m-l-5"></i>
                </button>
              </h3>
              <br/>
              <div id='jqxNavigationBar'>
                      <div>
                          <b> Indicadores de Resultado </b>
                      </div>
                      <div>
                          <div id="jqxgridResultado"> </div>
                      </div>
                      <div>
                        <b>Indicadores de Producto</b>
                      </div>
                      <div>
                          <div id="jqxgridProducto"> </div>
                      </div>
                      <div>
                          <b>Indicadores de Proceso</b>
                      </div>
                      <div>
                          <div id="jqxgridProceso"> </div>
                      </div>
                  </div>
          </div>
      </div>

      <div id="contenido_detalle" class="col-lg-8 col-md-12 block ">
          <div class="white-box p-10 block-content">
              <div style="height: 500px;">
                <div id="chartdiv"></div>

              </div>
          </div>
      </div>

  </div>


@endsection
@push('script-head')
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxcore.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxnavigationbar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxdata.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxbuttons.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxscrollbar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxmenu.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxcombobox.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxlistbox.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxdropdownlist.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxradiobutton.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxgrid.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxgrid.selection.js') }}"></script>



  <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
  <script src="https://www.amcharts.com/lib/3/serial.js"></script>
  <script src="https://www.amcharts.com/lib/3/pie.js"></script>
  <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
  <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
  <script src="https://www.amcharts.com/lib/3/plugins/responsive/responsive.min.js" type="text/javascript"></script>
  <script type="application/javascript">
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
      var pressHistorico = "";
      var sourceH;
      var chart;
      $(document).ready(function(){


          activarMenu('mod-1','mp-1');
          menuModulosHideShow(1)
          $(".select2").select2();

          var ini = [{
            "datacolumn": "-",
            "valor": 0,
            "color": "#FF0F00"
          }];
          GRaficarDatos(ini,'Indicador',null);



          var theme = 'light';
          var theme2 = 'darkblue';
           $("#jqxNavigationBar").jqxNavigationBar({ theme:theme2, width: '100%', height: 350});

          /*COMBOS PDES CONFIGURACIONES*/
          var pilaresSource =
          {
            dataType: "json",
            dataFields: [
              { name: 'nombre'},
              { name: 'id'}
            ],
            url: '{{ url('/modulopdes/ajax/listarpilares') }}',
            async: false
          };
          var pilaresAdapter = new $.jqx.dataAdapter(pilaresSource);

          $("#pilares").jqxComboBox(
          {
            source: pilaresAdapter,
            width: '100%',
            height: 25,
            promptText: "PILAR",
            displayMember: 'nombre',
            valueMember: 'id'
          });
          var metasSource =
          {
              dataType: "json",
              dataFields: [
                { name: 'nombre'},
                { name: 'pilar'},
                { name: 'id'}
              ],
              url:  '{{ url('/modulopdes/ajax/listarmetas') }}',
              async: false
          };
          var metasAdapter = new $.jqx.dataAdapter(metasSource);
          $("#metas").jqxComboBox(
          {
            width: '100%',
            height: 25,
            disabled: true,
            promptText: "META",
            displayMember: 'nombre',
            valueMember: 'id'
          });
          var resultadosSource =
          {
              dataType: "json",
              dataFields: [
                { name: 'nombre'},
                { name: 'meta'},
                { name: 'id'}
              ],
              url:  '{{ url('/modulopdes/ajax/listarresultados') }}'
          };
          var resultadosAdapter = new $.jqx.dataAdapter(resultadosSource);

          $("#resultados").jqxComboBox(
          {
            width: '100%',
            height: 25,
            disabled: false,
            source: resultadosAdapter,
            promptText: "RESULTADO",
            displayMember: 'nombre',
            valueMember: 'id'
          });

          $("#pilares").bind('select', function(event)
          {
            if (event.args)
                {
                  $("#metas").jqxComboBox({ disabled: false});
                  $("#resultados").jqxComboBox({ disabled: true});
                  var value = event.args.item.value;
                  metasSource.data = {pilar: value};
                  metasAdapter = new $.jqx.dataAdapter(metasSource, {
                      beforeLoadComplete: function (records) {
                          var filteredRecords = new Array();
                          //for (var i = 0; i < records.length; i++) {
                          for (var i = 0; i < 11; i++) {

                              if (records[i].pilar == value){
                                  filteredRecords.push(records[i]);
                              }

                          }
                          return filteredRecords;
                      }
                  });
                  $("#metas").jqxComboBox({ source: metasAdapter, autoDropDownHeight: metasAdapter.records.length > 10 ? false : true});


                }
          });


          $("#metas").bind('select', function(event)
          {

            if (event.args)
                {
                  $("#resultados").jqxComboBox({ disabled: false});
                  var value = event.args.item.value;
                  resultadosSource.data = {meta: value};
                  resultadosAdapter = new $.jqx.dataAdapter(resultadosSource, {
                      beforeLoadComplete: function (records) {
                          var filteredRecords = new Array();
                          //for (var i = 0; i < records.length; i++) {
                          for (var i = 0; i < 2; i++) {
                              if (records[i].meta == value)
                                  filteredRecords.push(records[i]);
                          }
                          return filteredRecords;
                      }
                  });
                  $("#resultados").jqxComboBox({ source: resultadosAdapter, height: 25, autoDropDownHeight: resultadosAdapter.records.length > 10 ? false : true});

                }
          });



          $('#aplicar_filtro').click(function() {
            var idR = $("#resultados").val();
            //LIMPIAMOS LOS PANELS SECUNDARIOS ANTES DE VARGAR ALGUN DATO
            $('#cont-panel-menu').hide();
            $('.panel-menu').removeClass('active');
            $('.tab-pane').removeClass('active');
            $.ajax({
                    url: "{{ url('/modulopdes/ajax/datosresultado') }}",
                    data: { 'resultado': idR },
                    type: "GET",
                    dataType: 'json',
                    success: function(date){
                      $.each(date, function(i, data) {
                            var descripcion = "<b>"+data.pilar_nombre+"</b>: "+data.pilar_desc+"<br/>"+"<b>"+data.meta_nombre+"</b>: "+ data.meta_desc+"<br/><b>"+data.nombre+"</b>: "+data.descripcion;
                            //var descripcion = "<b>"+data.nombre+"</b>: "+data.descripcion;
                            $("#m-p-detalles").html(descripcion);
                            $('.panel-menu').removeClass('active');
                            //Activamos el panel de deatlles para que muetre el filtro PDES realizado
                            pressHistorico = "m-p-detalles";
                            $('.nav-tabs li:nth-child(1) a').addClass('active');// $('.nav-tabs li:first-child').addClass('active');
                            $('#cont-panel-menu').show();
                            $('#m-p-detalles').addClass('active');
                      });
                    },
                    error:function(data){
                      console("Error recuperar los datos.");
                    }
                });
              if(idR){
                  var source =
                  {
                      dataType: "json",
                      dataFields: [
                        { name: 'id_indicador',type: 'number' },
                        { name: 'id_resultado_indicador',type: 'number' },
                        { name: 'nombre', type: 'string' },
                        { name: 'punto_medicion', type: 'string' },
                        { name: 'vista_base_estadistica', type: 'string' }
                      ],
                      id: 'id',
                      data:{'resultado': idR,'tipo': 'Resultado'},
                      url: "{{ url('/modulopdes/ajax/listaindicadores') }}"
                  };
                  var dataAdapter = new $.jqx.dataAdapter(source);
                  $("#jqxgridResultado").jqxGrid({source: dataAdapter});

                  var source =
                  {
                      dataType: "json",
                      dataFields: [
                        { name: 'id_indicador',type: 'number' },
                        { name: 'id_resultado_indicador',type: 'number' },
                        { name: 'nombre', type: 'string' },
                        { name: 'punto_medicion', type: 'string' },
                        { name: 'vista_base_estadistica', type: 'string' }
                      ],
                      id: 'id',
                      data:{'resultado': idR,'tipo': 'Producto'},
                      url: "{{ url('/modulopdes/ajax/listaindicadores') }}"
                  };
                  var dataAdapter = new $.jqx.dataAdapter(source);
                  $("#jqxgridProducto").jqxGrid({source: dataAdapter});

                  var source =
                  {
                      dataType: "json",
                      dataFields: [
                        { name: 'id_indicador',type: 'number' },
                        { name: 'id_resultado_indicador',type: 'number' },
                        { name: 'nombre', type: 'string' },
                        { name: 'punto_medicion', type: 'string' },
                        { name: 'vista_base_estadistica', type: 'string' }
                      ],
                      id: 'id',
                      data:{'resultado': idR,'tipo': 'Proceso'},
                      url: "{{ url('/modulopdes/ajax/listaindicadores') }}"
                  };
                  var dataAdapter = new $.jqx.dataAdapter(source);
                  $("#jqxgridProceso").jqxGrid({source: dataAdapter});
              }


           });


           $('#clear_filtro_pdes').click(function() {
                   var pilaresSource =
                   {
                     dataType: "json",
                     dataFields: [
                       { name: 'nombre'},
                       { name: 'id'}
                     ],
                     url: '{{ url('/modulopdes/ajax/listarpilares') }}',
                     async: false
                   };
                   var pilaresAdapter = new $.jqx.dataAdapter(pilaresSource);
                   $("#pilares").jqxComboBox({source: pilaresAdapter });
                   $("#metas").jqxComboBox({ disabled: true});

                   var resultadosSource =
                   {
                       dataType: "json",
                       dataFields: [
                         { name: 'nombre'},
                         { name: 'meta'},
                         { name: 'id'}
                       ],
                       url:  '{{ url('/modulopdes/ajax/listarresultados') }}'
                   };
                   var resultadosAdapter = new $.jqx.dataAdapter(resultadosSource);
                   $("#resultados").jqxComboBox({ source: resultadosAdapter, disabled: false, autoDropDownHeight:false });

           });






          /*TABLAS DE INDICADORES POR TIPO CONFIGURACIONES*/
          var theme = 'light';
          var localizationobj = {};
          localizationobj.loadtext = "Cargando...";
          localizationobj.emptydatastring = "No hay registros que mostrar";
          localizationobj.groupsheaderstring = "Arrastre una columna para que se agrupe por ella";
          localizationobj.filterclearstring = "Limpiar";
          localizationobj.filterstring = "Filtro";
          localizationobj.groupbystring = "Agrupar por esta columna";
          localizationobj.groupremovestring = "Quitar de grupos";
          localizationobj.filterselectallstring = "(Seleccionar Todo)";
          localizationobj.filtershowrowstring = "Mostrar filas donde:";
          localizationobj.pagerrangestring = " de ";
          var cellGrafIcono = function (row, columnfield, value, defaulthtml, columnproperties) {
                var archivo = $('#jqxgridResultado').jqxGrid('getcellvalue', row, "vista_base_estadistica");
                if(archivo != '' && archivo != null){
                    return '<i class="fa fa-bar-chart-o"></i>';
                }else{
                    return '';
                }

            }
          $("#jqxgridResultado").jqxGrid(
            {
                width: '99%',
                autoheight: true,
                autorowheight:true,
                theme: theme,
                ready: function () {
                  $("#jqxgridResultado").jqxGrid('localizestrings', localizationobj);
                },
                columns: [
                  { text: '-', cellsrenderer: cellGrafIcono,cellsalign: 'center', align: 'center'},
                  { text: 'Tipo', datafield: 'punto_medicion', width: 130},
                  { text: 'Nombre Indicador', datafield: 'nombre', columntype: 'textbox'}
                ]
            });
          $("#jqxgridProducto").jqxGrid(
            {
                  width: '99%',
                  autoheight: true,
                  autorowheight:true,
                  theme: theme,
                  ready: function () {
                    $("#jqxgridProducto").jqxGrid('localizestrings', localizationobj);
                  },
                  columns: [
                    { text: '-', cellsrenderer: cellGrafIcono},
                    { text: 'Tipo', datafield: 'punto_medicion', width: 130},
                    { text: 'Nombre Indicador', datafield: 'nombre', columntype: 'textbox'}
                  ]
            });
            $("#jqxgridProceso").jqxGrid(
            {
                  width: '99%',
                  autoheight: true,
                  autorowheight:true,
                  theme: theme,
                  ready: function () {
                    $("#jqxgridProceso").jqxGrid('localizestrings', localizationobj);
                  },
                  columns: [
                    { text: '-', cellsrenderer: cellGrafIcono},
                    { text: 'Tipo', datafield: 'punto_medicion', width: 130},
                    { text: 'Nombre Indicador', datafield: 'nombre', columntype: 'textbox'}
                  ]
            });




           /*GRAFICADOR CONFIGURACIONES*/

           $('#graficar').click(function() {

             var rowindex = $('#jqxgridResultado').jqxGrid('getselectedrowindex');
             if (rowindex > -1)
             {
                limpiarFiltrosGraficas(1);
                $('#contenido_detalle').toggleClass('block-opt-refresh');
                var dataRecord = $("#jqxgridResultado").jqxGrid('getrowdata', rowindex);
                //Configuracion template graficar

                //Cargamos datos a filtros de grafica
                var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'valor' },
                        { name: 'nombre' }
                    ],
                    data: {'vista': dataRecord.vista_base_estadistica },
                    url: '{{url("/modulopdes/ajax/combofiltros")}}',
                    async: false
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                $("#jqxFiltroColumna").jqxDropDownList({source: dataAdapter});
                $("#jqxFiltroFila").jqxDropDownList({source: dataAdapter});
                $("#jqxFiltroDimension1").jqxDropDownList({source: dataAdapter});
                $("#jqxFiltroDimension2").jqxDropDownList({source: dataAdapter});
                $("#jqxFiltroDimension3").jqxDropDownList({source: dataAdapter});

                sourceH =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'valor'},
                        { name: 'nombre'},
                        { name: 'padre'},
                    ],
                    data: {'vista': dataRecord.vista_base_estadistica },
                    url: '{{url("/modulopdes/ajax/combofiltroshijos")}}',
                    async: false
                };
                var dataAdapterH = new $.jqx.dataAdapter(sourceH);
                $("#jqxFiltroDimensionValor1").jqxDropDownList({source: dataAdapterH});
                $("#jqxFiltroDimensionValor2").jqxDropDownList({source: dataAdapterH});
                $("#jqxFiltroDimensionValor3").jqxDropDownList({source: dataAdapterH});


                $.ajax({
                        url: "{{url("/modulopdes/ajax/configcombofiltros")}}",
                        data: {'vista': dataRecord.vista_base_estadistica },
                        type: "GET",
                        dataType: 'json',
                        success: function(date){

                          $.each(date, function(i, item) {
                              $.each(item, function(c, valor) {
                                  switch (i) {
                                    case 'cols':
                                      $("#jqxFiltroColumna").jqxDropDownList('checkItem',valor);
                                    break;
                                    case 'rows':
                                      $("#jqxFiltroFila").jqxDropDownList('checkItem',valor);
                                    break;
                                    case 'dim':
                                      $( "#jqxFiltroDimension"+ (c+1) ).jqxDropDownList('selectItem',valor);
                                    break;
                                    case 'dimval':
                                      $("#jqxFiltroDimensionValor" + (c+1) ).jqxDropDownList('selectItem',valor);
                                    break;
                                  }
                              });
                          });
                          configDatosVariableGrafica();
                        },
                        error:function(data){
                          console("Error recuperando configuracion de filtro de combos.");
                        }
                 });
                // $.ajax({
                //         url: "",
                //         data: {'vista': dataRecord.vista_base_estadistica },
                //         type: "GET",
                //         dataType: 'json',
                //         success: function(date){
                //           date.forEach(function(d, i) {
                //               $('#filtro-columnas').append('<option value="'+d.column+'">'+d.name+'</option>');
                //               $('#filtro-filas').append('<option value="'+d.column+'">'+d.name+'</option>');
                //               $('#filtro-dimension').append('<option value="'+d.column+'">'+d.name+'</option>');
                //           });
                //           $('.select2').trigger('change');
                //         },
                //         error:function(data){
                //           console("Error recuperar  datos para los filtros.");
                //         }
                //  });

               }else {
                     alert("Seleccione un indicador.");
               }

            });

            function configDatosVariableGrafica() {
              var rowindex = $('#jqxgridResultado').jqxGrid('getselectedrowindex');
              if (rowindex > -1)
              {

                  var dataRecord = $("#jqxgridResultado").jqxGrid('getrowdata', rowindex);
                  if(dataRecord.vista_base_estadistica != "" && dataRecord.vista_base_estadistica != null ){


                var lisCols = $("#jqxFiltroColumna").jqxDropDownList('getCheckedItems');
                  if(lisCols != "") {
                       var selCols = "";
                         $.each(lisCols, function (index) {
                              selCols += this.value + ", ";
                         });
                       var lisRows = $("#jqxFiltroFila").jqxDropDownList('getCheckedItems');
                       var selRows = "";
                       $.each(lisRows, function (index) {
                            selRows += this.value + ", ";
                       });

                       var selDimVal = "";
                       var lisDimVal1 = $("#jqxFiltroDimensionValor1").jqxDropDownList('getSelectedItem');
                       selDimVal += (lisDimVal1)?lisDimVal1.value + ", ":'';
                       var lisDimVal2 = $("#jqxFiltroDimensionValor2").jqxDropDownList('getSelectedItem');
                       selDimVal += (lisDimVal2)?lisDimVal2.value + ", ":'';
                       var lisDimVal3 = $("#jqxFiltroDimensionValor3").jqxDropDownList('getSelectedItem');
                       selDimVal += (lisDimVal3)?lisDimVal3.value + ", ":'';

                        $.ajax({
                                url: "{{url("/modulopdes/ajax/graficaindicador")}}",
                                data: {'vista': dataRecord.vista_base_estadistica,'cols':selCols,'rows':selRows,'filter':selDimVal},
                                type: "GET",
                                dataType: 'json',
                                success: function(date){
                                  chartData = [];
                                  var unidad = "";
                                  date.forEach(function(d, i) {
                                      unidad = d.unidad;
                                      chartData.push({
                                          datacolumn: d.titulo,
                                          valor: parseInt(d.valor, 10)
                                      });
                                  });
                                  GRaficarDatos(chartData,"Indicador: "+dataRecord.nombre+"\n(expresado en "+unidad+" )",unidad);


                                },
                                error:function(data){
                                  console("Error recuperar los datos.");
                                }
                            });
                  }else{
                      alert("El filtro de Columnas debe estar con algún dato.");
                  }
                  }else{
                      GRaficarDatos(null,null,null);
                  }

                }else {
                      alert("Seleccione un indicador.");
                }
            }


              function GRaficarDatos(ele,titulo,unidad){
                $('#contenido_detalle').removeClass('block-opt-refresh');

                // alert(dataRecord.nombre);
                //Configuracion de GRAFICAAAAAAs
                chart = AmCharts.makeChart("chartdiv", {
                     "type": "serial",
                     "theme": "light",
                     "rotate": false,
                     "marginRight": 70,
                     "dataProvider": ele,
                     "responsive": {
                        "enabled": true
                      },
                     "titles": [
                    		{
                    			"id": "Title-1",
                    			"size": 15,
                    			"text": titulo
                    		}
                    	],
                     "valueAxes": [{
                       "axisAlpha": 0,
                       "position": "left",
                       "title": "Valores"
                     }],

                     "graphs": [{
                       "type": "column",
                       "balloonText": "<b>[[category]]: [[value]] "+ unidad +"</b>",
                       "fillColorsField": "color",
                       "fillAlphas": 0.9,
                       "lineAlpha": 0.2,
                       "valueField": "valor",
                       //"labelText": "[[value]] "+ unidad,
                       "gridPosition": "start",
                       "labelRotation": -45
                     }],
                     "depth3D": 20,
                     "angle": 40,
                     "chartCursor": {
                         "pan": true,
                         "valueLineEnabled": true,
                         "valueLineBalloonEnabled": true,
                         "cursorAlpha": 0,
                         "valueLineAlpha": 0.5,
                         "valueBalloonsEnabled": true
                     },


                    "categoryField": "datacolumn",
                    "startDuration": 1,
                     "categoryAxis": {
                       "gridPosition": "start",
                       "labelRotation": 90
                     },
                    	"chartScrollbar": {
                    		"enabled": true
                    	},
                     "export": {
                       "enabled": false
                     }

                   });


              }

              $("#jqxFiltroColumna").jqxDropDownList({
                selectedIndex: 0,
                width: '100%',
                height: '25',
                placeHolder: "...",
                checkboxes: true,
                displayMember: "nombre",
                valueMember: "valor"
              });
              $("#jqxFiltroFila").jqxDropDownList({
                selectedIndex: 0,
                width: '100%',
                height: '25',
                placeHolder: "...",
                checkboxes: true,
                displayMember: "nombre",
                valueMember: "valor"
              });


              $("#jqxFiltroDimension1").jqxDropDownList(
              {
                width: '100%',
                height: '25',
                placeHolder: "...",
                displayMember: "nombre",
                valueMember: "valor"
              });

              $("#jqxFiltroDimensionValor1").jqxDropDownList(
              {
                width: '100%',
                height: '25',
                placeHolder: "...",
                displayMember: "nombre",
                valueMember: "valor"
              });


              $("#jqxFiltroDimension2").jqxDropDownList(
              {
                width: '100%',
                height: '25',
                placeHolder: "...",
                displayMember: "nombre",
                valueMember: "valor"
              });

              $("#jqxFiltroDimensionValor2").jqxDropDownList(
              {
                width: '100%',
                height: '25',
                placeHolder: "...",
                displayMember: "nombre",
                valueMember: "valor"
              });


              $("#jqxFiltroDimension3").jqxDropDownList(
              {
                width: '100%',
                height: '25',
                placeHolder: "...",
                displayMember: "nombre",
                valueMember: "valor"
              });

              $("#jqxFiltroDimensionValor3").jqxDropDownList(
              {
                width: '100%',
                height: '25',
                placeHolder: "...",
                displayMember: "nombre",
                valueMember: "valor"
              });

              $("#jqxFiltroDimension1").bind('select', function(event)
              {
                if (event.args)
                    {
                      $("#jqxFiltroDimensionValor1").jqxDropDownList({ disabled: false});
                      var value = event.args.item.value;

                      var rowindex = $('#jqxgridResultado').jqxGrid('getselectedrowindex');
                      var dataRecord = $("#jqxgridResultado").jqxGrid('getrowdata', rowindex);

                      sourceH.data = {vista: dataRecord.vista_base_estadistica,padre:value};
                      jqxFiltroDimensionValor1Adapter = new $.jqx.dataAdapter(sourceH, {
                          beforeLoadComplete: function (records) {
                              var filteredRecords = new Array();

                              for (var i = 0; i < records.length; i++) {

                                  if (records[i].padre == value){
                                      filteredRecords.push(records[i]);
                                  }

                              }
                              return filteredRecords;
                          }
                      });
                      $("#jqxFiltroDimensionValor1").jqxDropDownList({
                        source: jqxFiltroDimensionValor1Adapter,
                        autoDropDownHeight: jqxFiltroDimensionValor1Adapter.records.length > 10 ? false : true});
                    }
              });

              $("#jqxFiltroDimension2").bind('select', function(event)
              {
                if (event.args)
                    {
                      $("#jqxFiltroDimensionValor2").jqxDropDownList({ disabled: false});
                      var value = event.args.item.value;

                      var rowindex = $('#jqxgridResultado').jqxGrid('getselectedrowindex');
                      var dataRecord = $("#jqxgridResultado").jqxGrid('getrowdata', rowindex);

                      sourceH.data = {vista: dataRecord.vista_base_estadistica,padre:value};
                      jqxFiltroDimensionValor2Adapter = new $.jqx.dataAdapter(sourceH, {
                          beforeLoadComplete: function (records) {
                              var filteredRecords = new Array();
                              //for (var i = 0; i < records.length; i++) {
                              for (var i = 0; i < records.length; i++) {

                                  if (records[i].padre == value){
                                      filteredRecords.push(records[i]);
                                  }

                              }
                              return filteredRecords;
                          }
                      });
                      $("#jqxFiltroDimensionValor2").jqxDropDownList({
                        source: jqxFiltroDimensionValor2Adapter,
                        autoDropDownHeight: jqxFiltroDimensionValor2Adapter.records.length > 10 ? false : true});
                    }
              });


              $("#jqxFiltroDimension3").bind('select', function(event)
              {
                if (event.args)
                    {
                      $("#jqxFiltroDimensionValor3").jqxDropDownList({ disabled: false});
                      var value = event.args.item.value;

                      var rowindex = $('#jqxgridResultado').jqxGrid('getselectedrowindex');
                      var dataRecord = $("#jqxgridResultado").jqxGrid('getrowdata', rowindex);

                      sourceH.data = {vista: dataRecord.vista_base_estadistica,padre:value};
                      jqxFiltroDimensionValor3Adapter = new $.jqx.dataAdapter(sourceH, {
                          beforeLoadComplete: function (records) {
                              var filteredRecords = new Array();
                              //for (var i = 0; i < records.length; i++) {
                              for (var i = 0; i < records.length; i++) {

                                  if (records[i].padre == value){
                                      filteredRecords.push(records[i]);
                                  }

                              }
                              return filteredRecords;
                          }
                      });
                      $("#jqxFiltroDimensionValor3").jqxDropDownList({
                        source: jqxFiltroDimensionValor3Adapter,
                        autoDropDownHeight: jqxFiltroDimensionValor3Adapter.records.length > 10 ? false : true});
                    }
              });



              $('#clear_filtro_cols').click(function() {
                      $("#jqxFiltroColumna").jqxDropDownList('uncheckAll');
              });
              $('#clear_filtro_rows').click(function() {
                      $("#jqxFiltroFila").jqxDropDownList('uncheckAll');

              });
              $('#clear_filtro_1').click(function() {
                      $("#jqxFiltroDimension1").jqxDropDownList('clearSelection');
                      $("#jqxFiltroDimensionValor1").jqxDropDownList('clearSelection');
                      $("#jqxFiltroDimensionValor1").jqxDropDownList({ disabled: true});
              });
              $('#clear_filtro_2').click(function() {
                      $("#jqxFiltroDimension2").jqxDropDownList('clearSelection');
                      $("#jqxFiltroDimensionValor2").jqxDropDownList('clearSelection');
                      $("#jqxFiltroDimensionValor2").jqxDropDownList({ disabled: true});
              });
              $('#clear_filtro_3').click(function() {
                      $("#jqxFiltroDimension3").jqxDropDownList('clearSelection');
                      $("#jqxFiltroDimensionValor3").jqxDropDownList('clearSelection');
                      $("#jqxFiltroDimensionValor3").jqxDropDownList({ disabled: true});
              });

              $('#filtro_grafica').click(function() {
                    configDatosVariableGrafica();
              });

              $('.middle').click(function() {
                    $(".image").removeClass('imgsel');
                    $(this).siblings('img').addClass('imgsel');
                    var type = $(this).siblings('img').attr('name');
                    switch (type) {
                      case 'line':
                        chart.graphs[0].type = 'line';
                        chart.graphs[0].bullet = 'round';
                        chart.graphs[0].lineAlpha = 2;
                        chart.graphs[0].fillAlphas = 0;
                        chart.rotate = false;
                        chart.validateNow();
                        break;
                      case 'area':
                        chart.graphs[0].type = 'line';
                        chart.graphs[0].bullet = 'round';
                        chart.graphs[0].lineAlpha = 1;
                        chart.graphs[0].fillAlphas = 0.3;
                        chart.rotate = false;
                        chart.validateNow();
                        break;
                      case 'column':
                        chart.graphs[0].type = 'column';
                        chart.graphs[0].lineAlpha = 2;
                        chart.graphs[0].fillAlphas = 1;
                        chart.rotate = false;
                        chart.validateNow();
                      break;
                      case 'serial':
                        chart.graphs[0].type = 'column';
                        chart.graphs[0].lineAlpha = 2;
                        chart.graphs[0].fillAlphas = 1;
                        chart.rotate = true;
                        chart.validateNow();
                      break;
                      case 'pie':

                      AmCharts.makeChart("chartdiv",
                    				{
                    					"type": "pie",
                    					"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                    					"titleField": "datacolumn",
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


              //OTRAS FUNCIONES DENTRO LA vista

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
                      $('#contenido_datos').hide();
                  }else{
                    pressHistorico = panel;
                    $('#contenido_datos').show();
                    $('#cont-panel-menu').hide();
                  }

               }

            });

            function limpiarFiltrosGraficas(ele){

              // $("#jqxFiltroColumna").jqxDropDownList('uncheckAll');
              // $("#jqxFiltroFila").jqxDropDownList('uncheckAll');

              $("#jqxFiltroDimension1").jqxDropDownList('clearSelection');
              $("#jqxFiltroDimensionValor1").jqxDropDownList('clearSelection');
              $("#jqxFiltroDimensionValor1").jqxDropDownList({ disabled: true});
              $("#jqxFiltroDimension2").jqxDropDownList('clearSelection');
              $("#jqxFiltroDimensionValor2").jqxDropDownList('clearSelection');
              $("#jqxFiltroDimensionValor2").jqxDropDownList({ disabled: true});
              $("#jqxFiltroDimension3").jqxDropDownList('clearSelection');
              $("#jqxFiltroDimensionValor3").jqxDropDownList('clearSelection');
              $("#jqxFiltroDimensionValor3").jqxDropDownList({ disabled: true});
            }


      });

   </script>
@endpush
