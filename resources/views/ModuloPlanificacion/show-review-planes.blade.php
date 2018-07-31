@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/plugins/bower_components/select2/dist/css/select2.min.css" type="text/css"/>
<link rel="stylesheet" href="/plugins/bower_components/sweetalert/sweetalert.css" type="text/css">

<style media="screen">
.popup-basic {
    position: relative;
    background: #FFF;
    width: auto;
    max-width: 500px;
    margin: 40px auto;
}

##.admin-form .panel-heading{
    background-color: #fafafa;
    border-color: transparent -moz-use-text-color #ddd;
    border-radius: 0;
    border-style: solid none;
    border-width: 1px 0;
    color: #999;
    height: auto;
    overflow: hidden;
    padding: 3px 15px 2px;
    position: relative;
}

</style>

@endsection


@section('content')
    <div class="tray tray-center va-t posr sp_planes">
        <div class="row">
            <div class="col-md-12">
                <div class="panel" >
                    <div class="panel-heading text-center bg-dark">
                        <span class="panel-title"> Listado de Planes </span>
                    </div>
                    <div class="panel-body">
                        <h4>Periodo vigente en curso: <strong  class="sp_periodo text"></strong></h4>
                        <div id="estructura" class="row">
                            <div  class="col-lg-4 col-sm-12 text-center">
                              <h5><b>Planes Ministerios Cabeza</b></h5>
                                <div id="dataTable"></div>
                            </div>
                            <div  class="col-lg-4 col-sm-12 text-center">
                              <h5><b>Planes Entidades sin cabeza de Sector</b></h5>
                                <div id="dataTable2"></div>
                            </div>
                            <div  class="col-lg-4 col-sm-12 text-center">
                              <h5><b>Planes Multisectoriales</b></h5>
                                <div id="dataTable3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@push('script-head')
<script src="/plugins/bower_components/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdata.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdatatable.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdraw.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxtreegrid.js "></script>

<script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
<script src="/js/jqwidgets-localization.js"></script>
<script type="text/javascript">
$(function(){
  //$('input[name=id_p_act]').val('');
    var planes = {
        dataTable : $("#dataTable"),
        dataTable2 : $("#dataTable2"),
        dataTable3 : $("#dataTable3"),
        periodo_planificacion: {},
        source : {},

        fillPlanesMinisterios : function() {
            $.get(globalSP.urlApi + 'apiSetListMinisterios', function(resp)
            {
                planes.periodo_planificacion = resp.periodo_vigente;
                $(".sp_periodo").html(planes.periodo_planificacion.nombre);
                $("#gestion_inicio").html(planes.periodo_planificacion.valor);
                $("#gestion_fin").html(planes.periodo_planificacion.valor2);

                planes.source =
                {
                    dataType: "json",
                    localdata: resp.data,
                    dataFields: [
                        { name: 'id', type: 'number' },
                        { name: 'gestion_inicio', type: 'number' },
                        { name: 'gestion_fin', type: 'number' },
                        { name: 'descripcion_plan', type: 'string' },
                        { name: 'periodo_descripcion', type: 'string' },
                        { name: 'nombre_entidad', type: 'string' },
                        { name: 'sigla_entidad', type: 'string' },
                        { name: 'cod_tipo_plan', type: 'string' },
                        { name: 'id_plan', type: 'number' }
                    ],
                    id: 'id',
                    // url: globalSP.urlApi + 'listEntidadPlan'
                };
                //Configuracion de la tabla
                var dataAdapter = new $.jqx.dataAdapter(planes.source);
                planes.dataTable.jqxDataTable({
                    source: dataAdapter,
                    altRows: false,
                    sortable: true,
                    width: "100%",
                    height: 500,
                    filterable: true,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    localization: getLocalization('es'),
                    columns: [
                        /* boton de cargar */
                        { text: '*', width: 80, cellsRenderer: function (row, datafield, value, rowData) {
                                        var html = "";
                                        if(rowData.id_plan){
                                          html = '<button class="sel_cargar_plan btn btn-xs bg-system dark btn-rounded text-white-lighter"><i class="fa fa-arrow-circle-up icon-success"></i> <span>cargar</span></button>';
                                        }
                                        return html;
                                    },
                        },
                        /* imagen segun el tipo de plan */
                        { text: '-', width: 90, cellsRenderer: function (row, column, value, rowData) {
                                var image = "";
                                if (rowData.id_plan) {
                                   image = `<div style='margin: 5px; margin-bottom: 3px;'>
                                            <img width="60" height="80" style="display: block;" src="/img/ico_${rowData.cod_tipo_plan}.png"/>
                                            </div>`
                                }
                              return image;
                              }
                        },
                        /* descripcion armada */
                        { text: 'Descripción', dataField: 'nombre', align: 'center',
                            cellsRenderer: function (row, column, value, rowData) {
                                var container = `<div style="width: 100%; height: 100%;">
                                                    <div style="float: left; width: 100%;">
                                                    <div class="ml10"><b>Nombre Entidad:</b> ${rowData.nombre_entidad}</div>
                                                    <div class="ml10"><b>Sigla:</b> ${rowData.sigla_entidad}"</div>
                                                    <div class="ml10"><b>Periodo Plan:</b> ${rowData.gestion_inicio} - ${rowData.gestion_fin}</div>
                                                    <div class="ml10"><b>Documento Planificación:</b> ${rowData.cod_tipo_plan} </div>
                                                    <div class="ml10"><b>Descripción:</b> ${rowData.descripcion_plan ? rowData.descripcion_plan : '' } </div>
                                                </div>`
                                return container;
                            }
                        },
                        { text: 'Nombre entidad', dataField: 'nombre_entidad', align: 'center',hidden:true},
                        { text: 'Sigla entidad', dataField: 'sigla_entidad', align: 'center',hidden:true},
                        { text: 'Tipo Plan', dataField: 'cod_tipo_plan', align: 'center',hidden:true},
                    ]
                });
            });
        },
        fillPlanesSinCabeza : function() {
            $.get(globalSP.urlApi + 'apiSetListSinCabeza', function(resp)
            {
                planes.source =
                {
                    dataType: "json",
                    localdata: resp.data,
                    dataFields: [
                        { name: 'id', type: 'number' },
                        { name: 'gestion_inicio', type: 'number' },
                        { name: 'gestion_fin', type: 'number' },
                        { name: 'descripcion_plan', type: 'string' },
                        { name: 'periodo_descripcion', type: 'string' },
                        { name: 'nombre_entidad', type: 'string' },
                        { name: 'sigla_entidad', type: 'string' },
                        { name: 'cod_tipo_plan', type: 'string' },
                        { name: 'id_plan', type: 'number' }
                    ],
                    id: 'id',
                    // url: globalSP.urlApi + 'listEntidadPlan'
                };
                //Configuracion de la tabla
                var dataAdapter = new $.jqx.dataAdapter(planes.source);
                planes.dataTable2.jqxDataTable({
                    source: dataAdapter,
                    altRows: false,
                    sortable: true,
                    width: "100%",
                    height: 500,
                    filterable: true,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    localization: getLocalization('es'),
                    columns: [
                        /* boton de cargar */
                        { text: '*', width: 80, cellsRenderer: function (row, datafield, value, rowData) {
                                        var html = "";
                                        if(rowData.id_plan){
                                          html = '<button class="sel_cargar_plan btn btn-xs bg-system dark btn-rounded text-white-lighter"><i class="fa fa-arrow-circle-up icon-success"></i> <span>cargar</span></button>';
                                        }
                                        return html;
                                    },
                        },
                        /* imagen segun el tipo de plan */
                        { text: '-', width: 90, cellsRenderer: function (row, column, value, rowData) {
                                var image = "";
                                if (rowData.id_plan) {
                                   image = `<div style='margin: 5px; margin-bottom: 3px;'>
                                            <img width="60" height="80" style="display: block;" src="/img/ico_${rowData.cod_tipo_plan}.png"/>
                                            </div>`
                                }
                              return image;
                              }
                        },
                        /* descripcion armada */
                        { text: 'Descripción', dataField: 'nombre', align: 'center',
                            cellsRenderer: function (row, column, value, rowData) {
                                var container = `<div style="width: 100%; height: 100%;">
                                                    <div style="float: left; width: 100%;">
                                                    <div class="ml10"><b>Nombre Entidad:</b> ${rowData.nombre_entidad}</div>
                                                    <div class="ml10"><b>Sigla:</b> ${rowData.sigla_entidad}"</div>
                                                    <div class="ml10"><b>Periodo Plan:</b> ${rowData.gestion_inicio} - ${rowData.gestion_fin}</div>
                                                    <div class="ml10"><b>Documento Planificación:</b> ${rowData.cod_tipo_plan} </div>
                                                    <div class="ml10"><b>Descripción:</b> ${rowData.descripcion_plan ? rowData.descripcion_plan : '' } </div>
                                                </div>`
                                return container;
                            }
                        },
                        { text: 'Nombre entidad', dataField: 'nombre_entidad', align: 'center',hidden:true},
                        { text: 'Sigla entidad', dataField: 'sigla_entidad', align: 'center',hidden:true},
                        { text: 'Tipo Plan', dataField: 'cod_tipo_plan', align: 'center',hidden:true},
                    ]
                });
            });
        },
        fillPlanesMultis : function() {
            $.get(globalSP.urlApi + 'apiSetListMultis', function(resp)
            {
                planes.source =
                {
                    dataType: "json",
                    localdata: resp.data,
                    dataFields: [
                        { name: 'id', type: 'number' },
                        { name: 'gestion_inicio', type: 'number' },
                        { name: 'gestion_fin', type: 'number' },
                        { name: 'descripcion_plan', type: 'string' },
                        { name: 'periodo_descripcion', type: 'string' },
                        { name: 'nombre_entidad', type: 'string' },
                        { name: 'sigla_entidad', type: 'string' },
                        { name: 'cod_tipo_plan', type: 'string' },
                        { name: 'id_plan', type: 'number' }
                    ],
                    id: 'id_plan',
                    // url: globalSP.urlApi + 'listEntidadPlan'
                };
                //Configuracion de la tabla
                var dataAdapter = new $.jqx.dataAdapter(planes.source);
                planes.dataTable3.jqxDataTable({
                    source: dataAdapter,
                    altRows: false,
                    sortable: true,
                    width: "100%",
                    height: 500,
                    filterable: true,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    localization: getLocalization('es'),
                    columns: [
                        /* boton de cargar */
                        { text: '*', width: 80, cellsRenderer: function (row, datafield, value, rowData) {
                                        var html = "";
                                        if(rowData.id_plan){
                                          html = '<button class="sel_cargar_plan btn btn-xs bg-system dark btn-rounded text-white-lighter"><i class="fa fa-arrow-circle-up icon-success"></i> <span>cargar</span></button>';
                                        }
                                        return html;
                                    },
                        },
                        /* imagen segun el tipo de plan */
                        { text: '-', width: 90, cellsRenderer: function (row, column, value, rowData) {
                                var image = "";
                                if (rowData.id_plan) {
                                   image = `<div style='margin: 5px; margin-bottom: 3px;'>
                                            <img width="60" height="80" style="display: block;" src="/img/ico_${rowData.cod_tipo_plan}.png"/>
                                            </div>`
                                }
                              return image;
                              }
                        },
                        /* descripcion armada */
                        { text: 'Descripción', dataField: 'nombre', align: 'center',
                            cellsRenderer: function (row, column, value, rowData) {
                                var container = `<div style="width: 100%; height: 100%;">
                                                    <div style="float: left; width: 100%;">
                                                    <div class="ml10"><b>Nombre Entidad:</b> ${rowData.nombre_entidad}</div>
                                                    <div class="ml10"><b>Sigla:</b> ${rowData.sigla_entidad}"</div>
                                                    <div class="ml10"><b>Periodo Plan:</b> ${rowData.gestion_inicio} - ${rowData.gestion_fin}</div>
                                                    <div class="ml10"><b>Documento Planificación:</b> ${rowData.cod_tipo_plan} </div>
                                                    <div class="ml10"><b>Descripción:</b> ${rowData.descripcion_plan ? rowData.descripcion_plan : '' } </div>
                                                </div>`
                                return container;
                            }
                        },
                        { text: 'Nombre entidad', dataField: 'nombre_entidad', align: 'center',hidden:true},
                        { text: 'Sigla entidad', dataField: 'sigla_entidad', align: 'center',hidden:true},
                        { text: 'Tipo Plan', dataField: 'cod_tipo_plan', align: 'center',hidden:true},
                    ]
                });
            });
        },
        refresh: function(){
            $.get(globalSP.urlApi + 'listPlanes', function(resp) {
                planes.source.localdata = resp.data;
                planes.dataTable.jqxDataTable("updateBoundData");
            })
        },
        cargar: function(){

                var rowsel = planes.dataTable.jqxDataTable('getSelection')[0];
                planactivo = rowsel;
                $('input[name=id_plan]').val(planactivo.id_plan) ;
                window.location = globalSP.url + 'showEnfoque?p=' + rowsel.id_plan +'&e=' + rowsel.id ;

                $('#menuSP .sp_menu').each(function(index, elem){
                    var urlhref = $(elem).attr('href');
                    // coloca el querystring en las urls del menu
                    urlhref = urlhref.split('=')[0] + '=' + globalSP.planActivo.id_plan;
                    $(elem).attr('href', urlhref);
                });
                globalSP.setTitulo2();
        }
    }



    globalSP.activarMenu(globalSP.menu.ListaDePlanes);
    globalSP.cargarGlobales();
    globalSP.setBreadcrumb('Planes de la Institución', 'Administrar Planes');
    planes.fillPlanesMinisterios();
    planes.fillPlanesSinCabeza();
    planes.fillPlanesMultis();


    $(".sp_planes").on('click', '.sel_cargar_plan', function(){
        planes.cargar();
    });





})
</script>
@endpush
