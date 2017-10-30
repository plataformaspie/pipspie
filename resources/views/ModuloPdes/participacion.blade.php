@extends('layouts.plataforma')

@section('header')
  <link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.base.css') }}" type="text/css"/>
  <link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.light.css') }}" type="text/css"/>
  <link rel="stylesheet" href="{{ asset('css/visores.css') }}" type="text/css" />
@endsection


@section('content')
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
                       <a href="javascript:void(0);" class="nav-link panel-menu" aria-controls="m-p-detalles">
                         <span class="visible-xs"><i class="fa fa-info-circle"></i></span>
                         <span class="hidden-xs"><i class="fa fa-info-circle"></i> Detalles</span>
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

                      </div>
                      <div class="col-lg-6">


                      </div>
                  </div>
                </div>

            </div>

          </div>
      </div>
  </div>
  <div class="row" >
        <div id="contenido_datos" class="col-lg-3 col-md-12">
          <div class="white-box">
               <div id='jqxNavigationBar'>
                      <div>
                          <b> LISTA DE PILARES </b>
                      </div>
                      <div>
                          <div id="jqxgridPilares"> </div>
                      </div>
                </div>
           </div>
        </div>

        <div id="contenido_detalle" class="col-lg-9 col-md-12 block">

            <div class="white-box p-10 block-content">

                  <div id="chartdiv"></div>

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

  $(document).ready(function(){
    activarMenu('mod-1','mp-11');
    menuModulosHideShow(1)


    var theme = 'light';
    var theme2 = 'darkblue';
    /*TABLAS DE INDICADORES POR TIPO CONFIGURACIONES*/


    $("#jqxNavigationBar").jqxNavigationBar({ theme:theme2, width: '100%', height: 400});
    var localizationobj = {};
    localizationobj.loadtext = "Cargando";
    localizationobj.emptydatastring = "No hay registros que mostrar";
    localizationobj.groupsheaderstring = "Arrastre una columna para que se agrupe por ella";
    localizationobj.filterclearstring = "Limpiar";
    localizationobj.filterstring = "Filtro";
    localizationobj.groupbystring = "Agrupar por esta columna";
    localizationobj.groupremovestring = "Quitar de grupos";
    localizationobj.filterselectallstring = "(Seleccionar Todo)";
    localizationobj.filtershowrowstring = "Mostrar filas donde:";
    localizationobj.pagerrangestring = " de ";


    var source =
    {
        dataType: "json",
        dataFields: [
          { name: 'id', type: 'number' },
          { name: 'cod_p', type: 'string' },
          { name: 'descripcion',type: 'string' }
        ],
        id: 'cod_p',
        url: "{{ url('/modulopdes/ajax/detallepilares') }}"
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
   $("#jqxgridPilares").jqxGrid(
     {
         width: '99%',
         //height: 265,
         source: dataAdapter,
         autoheight: true,
         autorowheight:true,
         showfilterrow: true,
         filterable: true,
         theme: theme,
         localization:localizationobj,
         columns: [
           { text: 'Codigo',datafield: 'cod_p',  cellsalign: 'center', align: 'center', columntype: 'textbox'},
           { text: 'Descripcion', datafield: 'descripcion', columntype: 'textbox'}
         ]
     });


   $("#jqxgrid").bind('rowclick', function(event) {
     var args = event.args;
     var row = args.rowindex;
     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
     var id = dataRecord.id;





   });





   function graficarDatos(id,ele,titulo,unidad){
     $('#contenido_detalle').removeClass('block-opt-refresh');

     // alert(dataRecord.nombre);
     //Configuracion de GRAFICAAAAAAs

        var chart = AmCharts.makeChart( "chartdiv"+id, {
          "type": "pie",
          "theme": "light",
          "dataProvider":ele,
          "valueField": "valor",
          "titleField": "datacolumn",
           "balloon":{
           "fixedPosition":true
          },
          "export": {
            "enabled": true
          }
        } );

   }



















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




  });
  </script>
@endpush
