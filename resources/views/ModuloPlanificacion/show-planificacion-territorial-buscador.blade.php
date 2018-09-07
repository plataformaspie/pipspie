@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.shinyblack.css" type="text/css" />

@endsection

@section('title-topbar')

@endsection

@section('content')
<section id="content_wrapper">
  <section id="content" class="table-layout animated fadeIn" style="min-height: 3500px;">
                  <div class="tray tray-center p40 va-t posr">
      <div class="row">

          <div class="col-md-12">
              <div class="panel panel-visible" >
                <div class="panel-heading bg-dark text-center">
                     <span class="panel-title"> Departamentos con Planificación</span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="estructura" class="col-md-12" >
                          <div class="panel panel-visible">
                              <div id='jqxWidget'>
                                <div id="grid1"></div>        
                                <div id="grid"></div>
                              </div>
                            </div>
                                                     
                      </div>
                    </div>
                </div>
                <div class="panel-heading bg-dark text-center">
                     <span class="panel-title"> Filtro Matrices</span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="estructura" class="col-md-12" >
                          <div class="panel panel-visible">
                              <p><input class="btn btn-sm btn-success dark m5 br4" style="margin-top: 10px;" value="Limpiar Filtro" id="clearfilteringbutton" type="button" /><input class="btn btn-sm btn-success dark m5 br4" style="margin-top: 10px;" value="Exportar" id="export" type="button" /></p>
                     <p>
                      
                      <div id='matrices' ></div></p>
                            </div>
                                                     
                      </div>
                    </div>
                </div>
                     
                     
                     
                
              </div>
          </div>
      </div>
  </div>
</section>
  </section>



@endsection

@push('script-head')
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />   

    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.selection.js"></script> 
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.aggregates.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxDataTable.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxinput.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.pager.js"></script> 
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.grouping.js"></script> 
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdata.export.js"></script> 
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.export.js"></script> 
<!----------------------------------------------------------------->



<script type="text/javascript">     
   $(function()
          {
            $.get("listarRegistroMatrices",function(respuesta)
              {
                var source =
                 {
                  localdata: respuesta.registros,
                  datafields:
                  [
                    { name: 'descripcion_departamento',type:'datafield'},
                    { name: 'descripcion_provincia', type: 'datafield' },
                    { name: 'descripcion_municipio', type: 'datafield'},
                    { name: 'registros1', type: 'int' }
                  ],
                  datatype: "json"
                 };
                var dataAdapter = new $.jqx.dataAdapter(source);
                $("#grid").jqxGrid(
                  {
                    width:600,// getWidth('Grid'),
                    source: dataAdapter, theme: 'shinyblack',
                    groupable: true,
                    pageable: true,
                    autoheight: true,                    
                    columns: 
                    [
                      { text: 'DEPARTAMENTO', datafield: 'descripcion_departamento', width: 250 },
                      { text: 'PROVINCIA', datafield: 'descripcion_provincia', width: 120 },
                      { text: 'MUNICIPIO', datafield: 'descripcion_municipio', width: 120 },
                      { text: 'CANTIDAD', datafield: 'registros1', width: 80 }

                    ],
                    groups: ['descripcion_departamento']
                  });                     
                $("#expand").on('click', function () 
                {
                  var groupnum = parseInt($("#groupnum").val());
                  if (!isNaN(groupnum)) 
                  {
                      $("#grid").jqxGrid('expandgroup', groupnum);
                  }
                });
                $("#collapse").on('click', function () 
                {
                  var groupnum = parseInt($("#groupnum").val());
                  if (!isNaN(groupnum)) 
                   {
                      $("#grid").jqxGrid('collapsegroup', groupnum);
                   }
                });                
                $("#expandall").on('click', function () 
                {
                  $("#grid").jqxGrid('expandallgroups');
                });
                      // collapse all groups.
                $("#collapseall").on('click', function () 
                {
                  $("#grid").jqxGrid('collapseallgroups');
                });
                      // trigger expand and collapse events.
                $("#grid").on('groupexpand', function (event) 
                {
                  var args = event.args;
                  $("#expandedgroup").text("Group: " + args.group + ", Level: " + args.level);
                });
                $("#grid").on('groupcollapse', function (event) 
                {
                  var args = event.args;
                  $("#collapsedgroup").text("Group: " + args.group + ", Level: " + args.level);
                });
              });
          });
</script>
    
<script type="text/javascript">
    $(function()
    {      
      $("#export").click(function()
      {   
        var hoy = new Date();
        fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
        var hora=hoy.getHours()+':'+hoy.getMinutes()+':'+hoy.getSeconds();
       // alert(fecha+ " "+hora);
        $("#matrices").jqxGrid('exportdata', 'xls', 'matrices'+fecha+hora, true, null, true);

      });
      $.get("listarMatrices",function(respuesta)
      {
        var source =
        {
          localdata: respuesta.matrices,
          datafields:
          [
            { name: 'id_correlativo', type: 'int' },
            { name: 'descripcion_departamento',type:'datafield'},
            { name: 'descripcion_provincia', type: 'datafield' },
            { name: 'descripcion_municipio', type: 'datafield'},
            { name: 'id_programa', type: 'int' },
            { name: 'descripcion_programa', type: 'datafield'},
            { name: 'accion_eta', type: 'datafield'},
            { name: 'linea_base', type: 'datafield'},
            { name: 'proceso_indicador', type: 'datafield'},
            { name: 'cantidad_indicador', type: 'numeric'},
            { name: 'indicador2016', type: 'numeric'},
            { name: 'indicador2017', type: 'numeric'},
            { name: 'indicador2018', type: 'numeric'},
            { name: 'indicador2019', type: 'numeric'},
            { name: 'indicador2020', type: 'numeric'},
            { name: 'cantidad_presupuesto', type: 'numeric'},
            { name: 'presupuesto2016', type: 'numeric'},
            { name: 'presupuesto2017', type: 'numeric'},
            { name: 'presupuesto2018', type: 'numeric'},
            { name: 'presupuesto2019', type: 'numeric'},
            { name: 'presupuesto2020', type: 'numeric'},
            { name: 'id_servicio', type: 'numeric'},
            { name: 'descripcion_servicio', type: 'datafield'},
            { name: 'id_clasificador', type: 'numeric'},
            { name: 'descripcion_clasificador', type: 'datafield'},
            { name: 'pilar', type: 'int'},
            { name: 'meta', type: 'int'},
            { name: 'resultado', type: 'int'},
            { name: 'accion', type: 'int'},
            { name: 'descripcion_accion_eta', type: 'datafield'},
            { name: 'descripcion_accion', type: 'datafield'}
          ],
          datatype: "json"
        };
        var dataAdapter = new $.jqx.dataAdapter(source);
        $("#matrices").jqxGrid(
          {
             width: '100%',
            source: dataAdapter,
             theme: 'shinyblack',
            altrows: true,
            pageable: true,
            autoheight: true,
            selectionmode: 'multiplecellsextended',
            showgroupaggregates: true,
            showstatusbar: true,
            showaggregates: true,
            statusbarheight: 40,
            source: dataAdapter,
            showfilterrow: true,
            filterable: true,
            autorowheight: true,
            columns: 
            [
              { text: 'DEPARTAMENTO', filtercondition: 'starts_with', datafield: 'descripcion_departamento', width: 150},
             { text: 'PROVINCIA', filtercondition: 'starts_with',datafield: 'descripcion_provincia',   width: 150 },
             { text: 'MUNICIPIO', filtercondition: 'starts_with',datafield: 'descripcion_municipio',   width: 150 },
             { text: 'PROG', filtercondition: 'starts_with',datafield: 'id_programa',   width: 50 },
             { text: 'ESTRUCTURA PROGRAMATÍCA', filtercondition: 'starts_with',datafield: 'descripcion_programa',   width: 215 },
             { text: 'ACCIÓN ESTANDAR ETA', filtercondition: 'starts_with',datafield: 'accion_eta',   width: 250 },
             { text: 'DESCRIPCION ACCION ESTANDAR ', filtertype: 'checkedlist', datafield: 'descripcion_accion_eta', width: 250},
             { text: 'SERVICIO', filtertype: 'checkedlist', datafield: 'descripcion_servicio', width: 50},
             { text: 'CLASIFICADOR', filtertype: 'checkedlist', datafield: 'descripcion_clasificador', width: 50},
             { text: 'LINEA BASE', filtercondition: 'starts_with',datafield: 'linea_base',   width: 215 },
             { text: 'INDICADOR DE PROCESOS', filtercondition: 'starts_with',datafield: 'proceso_indicador',   width: 215 },
             { text: 'INDICADOR',filtercondition: 'starts_with',datafield: 'cantidad_indicador',   width: 80 },
             { text: '2016', filtercondition: 'starts_with',datafield: 'indicador2016',   width: 50 },
             { text: '2017', filtercondition: 'starts_with',datafield: 'indicador2017',   width: 50 },
             { text: '2018', filtercondition: 'starts_with',datafield: 'indicador2018',   width: 50 },
             { text: '2019', filtercondition: 'starts_with',datafield: 'indicador2019',   width: 50 },
             { text: '2020', filtercondition: 'starts_with',datafield: 'indicador2020',   width: 50 },
             { text: 'PRESUPUESTO TOTAL', datafield: 'cantidad_presupuesto', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: 'c2' },
             { text: '2016', datafield: 'presupuesto2016', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: 'c2' },
             { text: '2017', datafield: 'presupuesto2017', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: 'c2' },
             { text: '2018', datafield: 'presupuesto2018', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: 'c2' },
             { text: '2019', datafield: 'presupuesto2019', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: 'c2' },
             { text: '2020', datafield: 'presupuesto2020', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: '' },
             { text: 'P',filtertype: 'checkedlist', datafield: 'pilar',  cellsalign: 'right', width: 50 },
             { text: 'M',filtertype: 'checkedlist', datafield: 'meta',  cellsalign: 'right', width: 50 },
             { text: 'R',filtertype: 'checkedlist', datafield: 'resultado',  cellsalign: 'right', width: 50 },
             { text: 'A',filtertype: 'checkedlist', datafield: 'accion',filtertype: 'checkedlist',  cellsalign: 'right', width: 50 },
             { text: 'CONCORDANCIA PDES', filtertype: 'checkedlist', datafield: 'descripcion_accion', width: 270},
            ]
          });
        $('#clearfilteringbutton').jqxButton({ height: 25});
        $('#clearfilteringbutton').click(function () 
          {
              $("#matrices").jqxGrid('clearfilters');
          });            
      });
    })
 </script>

 
@endpush
