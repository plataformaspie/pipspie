@extends('layouts.plataforma')

@section('header')
  <link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.base.css') }}" type="text/css"/>
  <link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.light.css') }}" type="text/css"/>
  <link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.darkblue.css') }}" type="text/css"/>
  <link rel="stylesheet" href="{{ asset('css/visores.css') }}" type="text/css" />
  <style>
  #chartdiv {
    width: 100%;
    height: 450px;
  }

  #tooltip
  {
      width: 100%;
      text-align: left;
      color: #000;
      background: #f8f0c8;
      position: absolute;
      z-index: 300 !important;
      padding: 15px;
      opacity: 0.5;
  }

  #tooltip:after
    {
      width: 0;
      height: 0;
      border-left: 10px solid transparent;
      border-right: 10px solid transparent;
      border-top: 10px solid #111;
      content: '';
      position: absolute;
      left: 50%;
      bottom: -10px;
      margin-left: -10px;
  }

      #tooltip.top:after
      {
          border-top-color: transparent;
          border-bottom: 10px solid #111;
          top: -20px;
          bottom: auto;
      }

      #tooltip.left:after
      {
          left: 10px;
          margin: 0;
      }

      #tooltip.right:after
      {
          right: 10px;
          left: auto;
          margin: 0;
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

  <div id="cont-panel-menu" class="row" style="display:none;" >
      <div class="col-lg-12">
          <div class="white-box p-10" style="background-color: #fcf8e3;color: #8a6d3b;">
            <!-- Tab panes -->
            <div class="tab-content m-0">
                <div role="tabpanel" class="tab-pane" id="m-p-detalles">
                  <div class="stats-row m-0">
                      <div class="stat-item containertipoimg">
                        Sector:<br/>
                        Institucion:<br/>
                        Lugar:<br/>
                        Inicio:<br/>
                        Fin:
                      </div>
                      <div class="stat-item containertipoimg">
                        Estado:<br/>
                        Presupuesto Programado:<br/>
                        Presupuesto Reprogramado:<br/>
                        Presupuesto Efectuado:<br/>
                        Fin:
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
              <div style="height: 450px;">
                  <h3 class="box-title"> lista de proyectos <b id="resultado_lita_resultado"></b>

                  </h3>
                  <div id='jqxNavigationBar'>
                          <div>
                              <b> - </b>
                          </div>
                          <div>
                            <div id="jqxgridProyectos"> </div>
                          </div>

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
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxgrid.filter.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxgrid.selection.js') }}"></script>

    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/pie.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/responsive/responsive.min.js" type="text/javascript"></script>
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

    function number_format(amount, decimals) {

        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0)
            return parseFloat(0).toFixed(decimals);

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

        return amount_parts.join('.');
    }


    var pressHistorico = "";
    var sourceH;
    var chart;
    $(document).ready(function(){
      activarMenu('mod-1','mp-3');
      menuModulosHideShow(1)
        iniGrafica();




        var theme = 'light';
        var theme2 = 'darkblue';
        $("#jqxNavigationBar").jqxNavigationBar({ theme:theme2, width: '100%', height: 400});

        /*TABLAS DE INDICADORES POR TIPO CONFIGURACIONES*/
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




        /*COMBOS PDES CONFIGURACIONES*/
        var pilaresSource =
        {
          dataType: "json",
          dataFields: [
            { name: 'nombre'},
            { name: 'id'}
          ],
          url: '{{ url('/modulopdes/ajax/listarpilares2') }}'
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
            url:  '{{ url('/modulopdes/ajax/listarmetas') }}'
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
            url:  '{{ url('/modulopdes/ajax/listarresultados2') }}'
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
                $("#resultados").jqxComboBox('clearSelection');
                var value = event.args.item.value;
                metasSource.data = {pilar: value};
                metasAdapter = new $.jqx.dataAdapter(metasSource, {
                    beforeLoadComplete: function (records) {
                        var filteredRecords = new Array();
                        //for (var i = 0; i < records.length; i++) {        for (var i = 0; i < 11; i++) {
                        for (var i = 0; i < records.length; i++) {

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
                        //for (var i = 0; i < records.length; i++) {        for (var i = 0; i < 2; i++) {
                        for (var i = 0; i < records.length; i++) {
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
          var idP = $("#pilares").val();
          var idM = $("#metas").val();
          var idR = $("#resultados").val();
          $('#jqxgridProyectos').jqxGrid('clearselection');
          activarfiltros();

          if(idR != ""){
            //LIMPIAMOS LOS PANELS SECUNDARIOS ANTES DE CARGAR ALGUN DATO
            cargarFiltro('R');
            limpiarPaneles();
            //CARGAMOS DETALLE DEL FILTRO SELECIONADO
            precargarTotalDetalle();
            configDatosVariableGraficaAll()


          }else if(idM != ""){
            //LIMPIAMOS LOS PANELS SECUNDARIOS ANTES DE CARGAR ALGUN DATO
            cargarFiltro('M');
            limpiarPaneles();
            //CARGAMOS DETALLE DEL FILTRO SELECIONADO
            precargarTotalDetalle();
            configDatosVariableGraficaAll()


          }else if(idP != ""){
            //LIMPIAMOS LOS PANELS SECUNDARIOS ANTES DE CARGAR ALGUN DATO
            cargarFiltro('P');
            limpiarPaneles();
            precargarTotalDetalle();
            configDatosVariableGraficaAll()


          }else{
            alert("Seleccione alguna opcion");
          }


         });


         $('#clear_filtro_pdes').click(function() {
           $("#pilares").jqxComboBox('clearSelection');
           $("#metas").jqxComboBox('clearSelection');
           $("#resultados").jqxComboBox('clearSelection');
           $('#jqxgridProyectos').jqxGrid('clearselection');
           limpiarPaneles();
           activarfiltros();
                 var pilaresSource =
                 {
                   dataType: "json",
                   dataFields: [
                     { name: 'nombre'},
                     { name: 'id'}
                   ],
                   url: '{{ url('/modulopdes/ajax/listarpilares2') }}'
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
                     url:  '{{ url('/modulopdes/ajax/listarresultados2') }}'
                 };
                 var resultadosAdapter = new $.jqx.dataAdapter(resultadosSource);
                 $("#resultados").jqxComboBox({ source: resultadosAdapter, disabled: false, autoDropDownHeight:false });
                cargarFiltro('G');
                precargarTotalDetalle();
                configDatosVariableGraficaAll();
         });


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
          cargarFiltro('G');
          precargarTotalDetalle();
          configDatosVariableGraficaAll()



         /*GRAFICADOR CONFIGURACIONES*/

         $('#graficar').click(function() {

           var rowindex = $('#jqxgridProyectos').jqxGrid('getselectedrowindex');
           if (rowindex > -1)
           {
              limpiarFiltrosGraficas(1);
              $('#contenido_detalle').toggleClass('block-opt-refresh');
              var dataRecord = $("#jqxgridProyectos").jqxGrid('getrowdata', rowindex);
              //Configuracion template graficar

              // //CARGAMOS DATOS DE LOS FILTROS HIJOS
              // sourceH =
              // {
              //     datatype: "json",
              //     datafields: [
              //         { name: 'valor'},
              //         { name: 'nombre'},
              //         { name: 'padre'},
              //     ],
              //     data: {'idProy': dataRecord.id },
              //     url: '{{url("/modulopdes/ajax/combofiltroshijos")}}',
              //     async: false
              // };
              // var dataAdapterH = new $.jqx.dataAdapter(sourceH);
              // $("#jqxFiltroDimensionValor1").jqxDropDownList({source: dataAdapterH});
              // $("#jqxFiltroDimensionValor2").jqxDropDownList({source: dataAdapterH});
              // $("#jqxFiltroDimensionValor3").jqxDropDownList({source: dataAdapterH});


              //PRESELECCIONAMOS LOS FILTROS SEGUN LA CONFIGURACION DEL DATO SELECCIONADO (AJAX)
              // $.ajax({
              //         url: "{{url("/modulopdes/ajax/configcombofiltros")}}",
              //         data: {'vista': dataRecord.vista_base_estadistica },
              //         type: "GET",
              //         dataType: 'json',
              //         success: function(date){
              //           $.each(date, function(i, item) {
              //               $.each(item, function(c, valor) {
              //                   switch (i) {
              //                     case 'cols':
              //                       $("#jqxFiltroColumna").jqxDropDownList('checkItem',valor);
              //                     break;
              //                     case 'rows':
              //                       $("#jqxFiltroFila").jqxDropDownList('checkItem',valor);
              //                     break;
              //                     case 'dim':
              //                       $( "#jqxFiltroDimension"+ (c+1) ).jqxDropDownList('selectItem',valor);
              //                     break;
              //                     case 'dimval':
              //                       $("#jqxFiltroDimensionValor" + (c+1) ).jqxDropDownList('selectItem',valor);
              //                     break;
              //                   }
              //               });
              //           });
              //         },
              //         error:function(data){
              //           console("Error recuperando configuracion de filtro de combos.");
              //         }
              //  });

              desactivarfiltros();
              configDatosVariableGrafica();


             }else {
                   alert("Seleccione un proyecto.");
             }

          });

          function configDatosVariableGrafica() {
            var rowindex = $('#jqxgridProyectos').jqxGrid('getselectedrowindex');
            if (rowindex > -1)
            {

              var dataRecord = $("#jqxgridProyectos").jqxGrid('getrowdata', rowindex);

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

                     //LIMPIAMOS LOS PANELS SECUNDARIOS ANTES DE CARGAR ALGUN DATO
                     limpiarPaneles();
                     //CARGAMOS DETALLE DEL FILTRO SELECIONADO
                     $.ajax({
                             url: "{{ url('/modulopdes/ajax/datosproyecto') }}",
                             data: { 'idProy': dataRecord.id },
                             type: "GET",
                             dataType: 'json',
                             success: function(date){

                                     $("#m-p-detalles").html(date);
                                     //$('[data-toggle="popover"]').popover();
                                     conftool();
                                     $('.panel-menu').removeClass('active');
                                     //Activamos el panel de deatlles para que muetre el filtro PDES realizado
                                     pressHistorico = "m-p-detalles";
                                     $('.nav-tabs li:nth-child(1) a').addClass('active');// $('.nav-tabs li:first-child').addClass('active');
                                     $('#cont-panel-menu').show();
                                     $('#m-p-detalles').addClass('active');

                             },
                             error:function(data){
                               console("Error recuperar los datos.");
                             }
                       });


                      $.ajax({
                              url: "{{url("/modulopdes/ajax/graficaproyecto")}}",
                              data: {'idProy': dataRecord.id,'cols':selCols,'rows':selRows,'filter':selDimVal},
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
                                GRaficarDatos(chartData,'PRESUPUESTO PROGRAMADO\n(proyecto seleccionado)',unidad);

                              },
                              error:function(data){
                                console("Error recuperar los datos.");
                              }
                          });
                }else{
                    alert("El filtro de Columnas debe estar con algún dato.");
                }


              }else {
                    alert("Seleccione un proyecto.");
              }
          }

          function configDatosVariableGraficaAll() {
            var idP = $("#pilares").val();
            var idM = $("#metas").val();
            var idR = $("#resultados").val();

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
                              url: "{{url("/modulopdes/ajax/graficapresupuestoall")}}",
                              data: {'cols':selCols,'rows':selRows,'filter':selDimVal, 'pilar':idP, 'meta': idM, 'resultado': idR},
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
                                GRaficarDatos(chartData,'PRESUPUESTO PROGRAMADO',unidad);

                              },
                              error:function(data){
                                console("Error recuperar los datos.");
                              }
                      });

                      //CARGAMOS LOS PROYECTOS DE LA OPCION SELECIONADA

                      var source =
                      {
                          dataType: "json",
                          dataFields: [
                            { name: 'id_pdes', type: 'number' },
                            { name: 'codigo', type: 'string' },
                            { name: 'descripcion_pdes',type: 'string' }
                          ],
                          id: 'id',
                          data:{'pilar':idP, 'meta': idM, 'resultado': idR,'filter':selDimVal,'cols':selCols},
                          url: "{{ url('/modulopdes/ajax/listadatospdes') }}"
                      };
                      var dataAdapter = new $.jqx.dataAdapter(source);
                     //$("#jqxgridProyectos").jqxGrid({source: dataAdapter});
                     $("#jqxgridProyectos").jqxGrid(
                       {
                           width: '99%',
                           //height: 265,
                           source: dataAdapter,
                           autoheight: true,
                           autorowheight:true,
                           showfilterrow: true,
                           filterable: true,
                           theme: theme,
                           columns: [
                             { text: 'Codigo',datafield: 'codigo',  cellsalign: 'center', align: 'center', columntype: 'textbox'},
                             { text: 'Descripcion PDES', datafield: 'descripcion_pdes', columntype: 'textbox'}
                           ]
                       });


                }else{
                    alert("El filtro de Columnas debe estar con algún dato.");
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
                   "startDuration": 1,
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
                     "title": "Valores",
                     "labelsEnabled": false
                   }],

                   "graphs": [{
                     "type": "column",
                     "balloonText": "<b>[[category]]: [[value]] "+ unidad +"</b>",
                     "fillColorsField": "color",
                     "fillAlphas": 0.9,
                     "lineAlpha": 0.2,
                     "valueField": "valor",
                     "gridPosition": "start",
                     "labelRotation": -45,
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
                   "categoryAxis": {
                     "gridPosition": "start",
                     "ignoreAxisWidth": true,
                     "autoWrap": true
                   },
                    "chartScrollbar": {
                      "enabled": true
                    },
                   "export": {
                     "enabled": false
                   },
                   "marginBottom": 100

                 });

            }




            $("#jqxFiltroDimension1").bind('select', function(event)
            {
              if (event.args)
                  {
                    $("#jqxFiltroDimensionValor1").jqxDropDownList({ disabled: false});
                    var value = event.args.item.value;

                    var rowindex = $('#jqxgridProyectos').jqxGrid('getselectedrowindex');
                    var dataRecord = $("#jqxgridProyectos").jqxGrid('getrowdata', rowindex);

                    sourceH.data = {padre:value};
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

                    var rowindex = $('#jqxgridProyectos').jqxGrid('getselectedrowindex');
                    var dataRecord = $("#jqxgridProyectos").jqxGrid('getrowdata', rowindex);

                    sourceH.data = {padre:value};
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

                    var rowindex = $('#jqxgridProyectos').jqxGrid('getselectedrowindex');
                    var dataRecord = $("#jqxgridProyectos").jqxGrid('getrowdata', rowindex);

                    sourceH.data = {padre:value};
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
                  precargarTotalDetalleFIL();
                  configDatosVariableGraficaAll();
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

          //PRECARGAR TOTALES
          function precargarTotalDetalle(){
            var idP = $("#pilares").val();
            var idM = $("#metas").val();
            var idR = $("#resultados").val();

            var lisCols = $("#jqxFiltroColumna").jqxDropDownList('getCheckedItems');
            var selCols = "";
              $.each(lisCols, function (index) {
                   selCols += this.value + ", ";
              });

            var selDimVal = "";
            var lisDimVal1 = $("#jqxFiltroDimensionValor1").jqxDropDownList('getSelectedItem');
            selDimVal += (lisDimVal1)?lisDimVal1.value + ", ":'';
            var lisDimVal2 = $("#jqxFiltroDimensionValor2").jqxDropDownList('getSelectedItem');
            selDimVal += (lisDimVal2)?lisDimVal2.value + ", ":'';
            var lisDimVal3 = $("#jqxFiltroDimensionValor3").jqxDropDownList('getSelectedItem');
            selDimVal += (lisDimVal3)?lisDimVal3.value + ", ":'';
              $.ajax({
                      url: "{{ url('/modulopdes/ajax/totalespresupuestodetalle') }}",
                      type: "GET",
                      dataType: 'json',
                      data:{'filter':selDimVal, 'pilar':idP, 'meta': idM, 'resultado': idR,'cols':selCols},
                      success: function(date){

                        $("#m-p-detalles").html(date);
                        $('.panel-menu').removeClass('active');
                        //Activamos el panel de deatlles para que muetre el filtro PDES realizado
                        pressHistorico = "m-p-detalles";
                        $('.nav-tabs li:nth-child(1) a').addClass('active');// $('.nav-tabs li:first-child').addClass('active');
                        $('#cont-panel-menu').show();
                        $('#m-p-detalles').addClass('active');

                      },
                      error:function(data){
                        console("Error recuperar los datos.");
                      }
              });

          }
          function precargarTotalDetalleFIL(){
            var idP = $("#pilares").val();
            var idM = $("#metas").val();
            var idR = $("#resultados").val();

            var lisCols = $("#jqxFiltroColumna").jqxDropDownList('getCheckedItems');
            var selCols = "";
              $.each(lisCols, function (index) {
                   selCols += this.value + ", ";
              });

            var selDimVal = "";
            var lisDimVal1 = $("#jqxFiltroDimensionValor1").jqxDropDownList('getSelectedItem');
            selDimVal += (lisDimVal1)?lisDimVal1.value + ", ":'';
            var lisDimVal2 = $("#jqxFiltroDimensionValor2").jqxDropDownList('getSelectedItem');
            selDimVal += (lisDimVal2)?lisDimVal2.value + ", ":'';
            var lisDimVal3 = $("#jqxFiltroDimensionValor3").jqxDropDownList('getSelectedItem');
            selDimVal += (lisDimVal3)?lisDimVal3.value + ", ":'';
              $.ajax({
                      url: "{{ url('/modulopdes/ajax/totalespresupuestodetalle') }}",
                      type: "GET",
                      dataType: 'json',
                      data:{'filter':selDimVal, 'pilar':idP, 'meta': idM, 'resultado': idR,'cols':selCols},
                      success: function(date){
                        $("#m-p-detalles").html(date);
                      },
                      error:function(data){
                        console("Error recuperar los datos.");
                      }
              });

          }



          function limpiarPaneles(){
            //LIMPIAMOS LOS PANELS SECUNDARIOS ANTES DE VARGAR ALGUN DATO
            $('#cont-panel-menu').hide();
            $('.panel-menu').removeClass('active');
            $('.tab-pane').removeClass('active');
          }

          function iniGrafica(){
            var ini = [{
              "datacolumn": "-",
              "valor": 0,
              "color": "#FF0F00"
            }];
            GRaficarDatos(ini,'-',null);
          }

          function cargarFiltro(ele){
            limpiarFiltrosGraficas(1);
            //CARGAMOS DATOS A LOS FILTROS DE LA GRAFICA
            switch (ele) {
              case 'G':
                  var valorFiltro = [
                     { valor: 7, nombre: "Pilares" },
                     { valor: 8, nombre: "Metas" },
                     { valor: 9, nombre: "Resultados"}
                  ];

                  var valorFiltroD = [
                     { valor: 2, nombre: "Sector" },
                     { valor: 3, nombre: "Programado" },
                     { valor: 4, nombre: "No programado" }
                  ];
                break;
              case 'P':
                  var valorFiltro = [
                    { valor: 7, nombre: "Pilares" },
                    { valor: 8, nombre: "Metas" },
                    { valor: 9, nombre: "Resultados"}
                  ];
                  var valorFiltroD = [
                     { valor: 2, nombre: "Sector" },
                     { valor: 3, nombre: "Programado" },
                     { valor: 4, nombre: "No programado" }
                  ];
                break;
              case 'M':
                  var valorFiltro = [
                    { valor: 7, nombre: "Pilares" },
                    { valor: 8, nombre: "Metas" },
                    { valor: 9, nombre: "Resultados"}
                  ];
                  var valorFiltroD = [
                     { valor: 2, nombre: "Sector" },
                     { valor: 3, nombre: "Programado" },
                     { valor: 4, nombre: "No programado" }
                  ];
                break;
              case 'R':
                  var valorFiltro = [
                    { valor: 7, nombre: "Pilares" },
                    { valor: 8, nombre: "Metas" },
                    { valor: 9, nombre: "Resultados"}
                  ];
                  var valorFiltroD = [
                     { valor: 2, nombre: "Sector" },
                     { valor: 3, nombre: "Programado" },
                     { valor: 4, nombre: "No programado" }
                  ];
                break;


            }

            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'valor' },
                    { name: 'nombre' }
                ],
                localdata: valorFiltro
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            $("#jqxFiltroColumna").jqxDropDownList({source: dataAdapter});
            $("#jqxFiltroFila").jqxDropDownList({source: dataAdapter});
            switch (ele) {
              case 'G':
              $("#jqxFiltroColumna").jqxDropDownList('checkItem',7);
              break;
              case 'P':
              $("#jqxFiltroColumna").jqxDropDownList('checkItem',7);
              break;
              case 'M':
              $("#jqxFiltroColumna").jqxDropDownList('checkItem',7);
              $("#jqxFiltroColumna").jqxDropDownList('checkItem',8);
              break;
              case 'R':
              $("#jqxFiltroColumna").jqxDropDownList('checkItem',7);
              $("#jqxFiltroColumna").jqxDropDownList('checkItem',8);
              $("#jqxFiltroColumna").jqxDropDownList('checkItem',9);
              break;
            }


            // var sourceD =
            // {
            //     datatype: "json",
            //     datafields: [
            //         { name: 'valor' },
            //         { name: 'nombre' }
            //     ],
            //     localdata: valorFiltroD
            // };
            // var dataAdapterD = new $.jqx.dataAdapter(sourceD);
            // $("#jqxFiltroDimension1").jqxDropDownList({source: dataAdapterD});
            // $("#jqxFiltroDimension2").jqxDropDownList({source: dataAdapterD});
            // $("#jqxFiltroDimension3").jqxDropDownList({source: dataAdapterD});
            //
            //
            //
            // // //CARGAMOS DATOS DE LOS FILTROS HIJOS
            // sourceH =
            // {
            //     datatype: "json",
            //     datafields: [
            //         { name: 'valor'},
            //         { name: 'nombre'},
            //         { name: 'padre'},
            //     ],
            //     url: '{{url("/modulopdes/ajax/combofiltroshijosproyectos")}}'
            // };
            // var dataAdapterH = new $.jqx.dataAdapter(sourceH);
            // $("#jqxFiltroDimensionValor1").jqxDropDownList({source: dataAdapterH});
            // $("#jqxFiltroDimensionValor2").jqxDropDownList({source: dataAdapterH});
            // $("#jqxFiltroDimensionValor3").jqxDropDownList({source: dataAdapterH});


          }


          function desactivarfiltros(){
            $("#jqxFiltroColumna").jqxDropDownList('uncheckAll');
            $("#jqxFiltroColumna").jqxDropDownList({ disabled: true});

            $("#jqxFiltroFila").jqxDropDownList('uncheckAll');
            $("#jqxFiltroFila").jqxDropDownList({ disabled: true});

            $("#jqxFiltroDimension1").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimension1").jqxDropDownList({ disabled: true});
            $("#jqxFiltroDimensionValor1").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimensionValor1").jqxDropDownList({ disabled: true});

            $("#jqxFiltroDimension2").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimension2").jqxDropDownList({ disabled: true});
            $("#jqxFiltroDimensionValor2").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimensionValor2").jqxDropDownList({ disabled: true});

            $("#jqxFiltroDimension3").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimension3").jqxDropDownList({ disabled: true});
            $("#jqxFiltroDimensionValor3").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimensionValor3").jqxDropDownList({ disabled: true});

            $("#jqxFiltroColumna").jqxDropDownList('checkItem',1);
          }


          function activarfiltros(){
            $("#jqxFiltroColumna").jqxDropDownList('uncheckAll');
            $("#jqxFiltroColumna").jqxDropDownList({ disabled: false});

            $("#jqxFiltroFila").jqxDropDownList('uncheckAll');
            $("#jqxFiltroFila").jqxDropDownList({ disabled: false});

            $("#jqxFiltroDimension1").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimension1").jqxDropDownList({ disabled: false});
            $("#jqxFiltroDimensionValor1").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimensionValor1").jqxDropDownList({ disabled: false});

            $("#jqxFiltroDimension2").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimension2").jqxDropDownList({ disabled: false});
            $("#jqxFiltroDimensionValor2").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimensionValor2").jqxDropDownList({ disabled: false});

            $("#jqxFiltroDimension3").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimension3").jqxDropDownList({ disabled: false});
            $("#jqxFiltroDimensionValor3").jqxDropDownList('clearSelection');
            $("#jqxFiltroDimensionValor3").jqxDropDownList({ disabled: false});

            $("#jqxFiltroColumna").jqxDropDownList('checkItem',1);
          }


          function conftool(){
          var targets = $( '[rel~=tooltip]' ),
              target  = false,
              tooltip = false,
              title   = false;

          targets.bind( 'mouseenter', function()
          {
              target  = $( this );
              tip     = target.attr( 'title' );
              tooltip = $( '<div id="tooltip"></div>' );

              if( !tip || tip == '' )
                  return false;

              target.removeAttr( 'title' );
              tooltip.css( 'opacity', 0.2 )
                     .html( tip )
                     .appendTo( 'body' );

              var init_tooltip = function()
              {
                  if( $( window ).width() < tooltip.outerWidth() * 1.5 )
                      tooltip.css( 'max-width', $( window ).width() / 2 );
                  else
                      tooltip.css( 'max-width', 340 );

                  var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( tooltip.outerWidth() / 2 ),
                      pos_top  = target.offset().top - tooltip.outerHeight() - 20;

                  if( pos_left < 0 )
                  {
                      pos_left = target.offset().left + target.outerWidth() / 2 - 20;
                      tooltip.addClass( 'left' );
                  }
                  else
                      tooltip.removeClass( 'left' );

                  if( pos_left + tooltip.outerWidth() > $( window ).width() )
                  {
                      pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20;
                      tooltip.addClass( 'right' );
                  }
                  else
                      tooltip.removeClass( 'right' );

                  if( pos_top < 0 )
                  {
                      var pos_top  = target.offset().top + target.outerHeight();
                      tooltip.addClass( 'top' );
                  }
                  else
                      tooltip.removeClass( 'top' );

                  tooltip.css( { left: pos_left, top: pos_top } )
                         .animate( { top: '+=10', opacity: 1 }, 50 );
              };

              init_tooltip();
              $( window ).resize( init_tooltip );

              var remove_tooltip = function()
              {
                  tooltip.animate( { top: '-=10', opacity: 0 }, 50, function()
                  {
                      $( this ).remove();
                  });

                  target.attr( 'title', tip );
              };

              target.bind( 'mouseleave', remove_tooltip );
              tooltip.bind( 'click', remove_tooltip );
          });
        }


    });





  </script>
@endpush
