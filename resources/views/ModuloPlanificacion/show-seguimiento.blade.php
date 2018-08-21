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
.sp_cellTable, .sp_cellTable:hover{
    background-color: #FFFFFF !important;
};
</style>

@endsection


@section('content')
    <div class="tray tray-center va-t posr sp_planes">
        <div class="row">
            <div class="col-md-12">
                <div class="panel" >
                    <div class="panel-heading text-center bg-dark">
                        <span class="panel-title"> Seguimiento y Evaluación de indicadores</span>
                    </div>
                    <div class="panel-body">
                        <h4>Indicadores: <strong  class=""></strong></h4>
                        <select id="indicadores" style="width:100%"></select>
                        <div id="contenido_indicador">

                            <div id="dataTable"></div>
                        </div>
                        {{-- <div class="row">
                            <div id="estructura" class="col-md-12" >
                                <button id="nuevo" type="button" class="btn btn-sm btn-success dark m5  br6 "><i class="fa fa-plus-circle text-white"></i> </button>
                                <button id="editar" type="button" class="btn btn-sm btn-warning dark m5 br6 "><i class="fa fa-edit text-white"></i> Editar</button>
                                <button id="eliminar" type="button" class="btn btn-sm btn-danger dark m5 br6 "><i class="fa fa-minus-circle text-white"></i> Eliminar</button>
                                <div id="dataTable"></div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Form Popup -->
    <div id="frm_modal"  class="popup-basic popup-lg admin-form mfp-with-anim mfp-hide ">
        <div class="panel">
            <div class="panel-heading bg-dark ">
                  <span class="panel-title text-white" id="tituloModal"><i class="fa fa-pencil"></i> <span> </span></span>
            </div>
                  <!-- end .panel-heading section -->
                  <form method="post" action="/" id="form-plan" name="form-plan">
                      <div class="panel-body of-a" id="val">
                        <input class="hidden" name="id" id="id" >
                        <div class="row">
                            <div class=" pl5 br-r mvn15">
                                <h3 class="ml5 mt20 ph10 pb5 br-b fw700">Periodo en curso: <strong  class="sp_periodo text"></strong><small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h3>
                                <div class="section">
                                    <label class="field-label" for="id_tipo_plan">Tipo de Plan</label>
                                    <label class="field select">
                                        <select id="id_tipo_plan" name="id_tipo_plan" class="required" style="width:100%;">
                                            <option></option>
                                        </select>
                                        <i class="arrow double"> </i>                    
                                    </label>
                                </div>

                                <div class="section">
                                    <label class="field-label" for="descripcion">Descripción</label>
                                    <label for="descripcion" class="field prepend-icon">
                                        <textarea class="gui-textarea " id="descripcion" name="descripcion" placeholder="Breve descripción" style="height: 70px"></textarea>
                                        <label for="descripcion" class="field-icon"><i class="fa fa-text-width"></i></label>
                                    </label>
                                </div>

                                <div class="section">
                                    <strong class="field-label ">Periodo de Planificación</strong>
                                    <strong>Gestion inicio: </strong><span id="gestion_inicio"></span>
                                    <strong class='ml10'>Gestion fin: </strong><span id="gestion_fin"></span>                                    
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="panel-footer">
                        <button type="submit" id="guardar"  class="button btn-primary">Guardar</button>
                        <a href="#"  id="cancelar"  class="button btn-danger ml25">Cancelar</a>
                    </div>
                </form>

        </div>
      <!-- end: .panel -->
    </div>
      <!-- end: .admin-form -->


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
    var ctxseg = {
        indicadores: [],
        dataTable : $("#dataTable"),
        periodo_planificacion: {},
        source : {},
        fillIndicadores: function(){
            $.get(globalSP.urlApi + 'listindicadores', {p:globalSP.idPlanActivo} , function(res) {
                ctxseg.indicadores = res.data;
                $("#indicadores").html( res.data.reduce(function(carry, op){ return carry + `<option value="${op.id_arti_indicador}">${op.nombre_indicador} </option>`},'<option value="">seleccione</option>') );
            });

            $("#form_art #indicadores").select2({
                    placeholder: 'Seleccione el indicador',
            });
        },
        fillTabla : function(indsel) {
            $.get(globalSP.urlApi + 'datosindicador', {id_arti_indicador: indsel[0].id_arti_indicador}, function(resp)
            {
                indsel[0].ejecucion = resp.ejecucion;
                indsel[0].programacion = resp.programacion;
                ctxseg.source =
                {
                    dataType: "json",
                    localdata: indsel,
                    dataFields: [
                        { name: 'id_pmra', type: 'number' },
                        { name: 'cod_p', type: 'string' },
                        { name: 'cod_m', type: 'string' },
                        { name: 'cod_r', type: 'string' },
                        { name: 'cod_a', type: 'string' },
                        { name: 'nombre_indicador', type: 'string' },
                        { name: 'nivel_indicador', type: 'string' },
                        { name: 'cod_unidad_medida', type: 'string' },
                        { name: 'unidad_medida', type: 'string' },
                        { name: 'linea_base', type: 'number' },
                        { name: 'linea_base_gestion', type: 'number' },
                        { name: 'id_indicador_ejecucion', type: 'number' },
                        { name: 'alcance', type: 'number' },
                        { name: 'variable', type: 'string' },
                        { name: 'gestion_ini', type: 'number' },
                        { name: 'gestion_fin', type: 'number' },
                        { name: 'programacion', type: 'object' },
                        { name: 'ejecucion', type: 'object' },                    
                    ],
                    id: 'id',
                };
                //Configuracion de la tabla
                var dataAdapter = new $.jqx.dataAdapter(ctxseg.source);
                ctxseg.dataTable.jqxDataTable({
                    source: dataAdapter,
                    altRows: false,
                    sortable: true,
                    width: "100%",
                    filterable: false,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    localization: getLocalization('es'),
                    columns: [
                        { text: 'P', dataField: 'cod_p', width: 50, align:'center',  cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.cod_p}</b> - ">${rowData.cod_p}</span>`;
                            } 
                        },
                        { text: 'M', width: 50, align:'center', cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.cod_m}</b> - ">${rowData.cod_m}</span>`
                            } 
                        },
                        { text: 'R',  dataField: 'cod_r', width: 50, align:'center', cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.cod_r}</b> -">${rowData.cod_r}</span>`
                            } 
                        },
                        { text: 'A',  dataField: 'cod_a', width: 50, align:'center', cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.cod_a}</b> -">${rowData.cod_a || ''}</span>`
                            } 
                        },
                        { text: 'Variable',  dataField: 'variable', width: 150, align:'center', cellsalign: 'center' },
                        { text: 'Linea Base',  dataField: 'linea_base', width: 150, align:'center', cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span >${rowData.linea_base} ${rowData.cod_unidad_medida}</span>`
                            } 
                        },
                        { text: 'Alcance',  dataField: 'alcance', width: 150, align:'center', cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span>${rowData.alcance} ${rowData.cod_unidad_medida}</span>`
                            } 
                        },
                        { text: 'Evaluación',   align:'center', width: 800,cellClassName: 'sp_cellTable', 
                                cellsrenderer: function(row, column, value, rowData){
                                    var html = ''; 
                                    var headGestiones = '';
                                    for(i = rowData.gestion_ini; i <= rowData.gestion_fin; i++)
                                        headGestiones += `<th>${i}</th>`;                                     

                                        html = `<table class="table table-bordered table-hover fs11 sp_table">
                                        <thead><tr class="primary"><th>dato</th> ${headGestiones}</thead>
                                        <tbody>`;
                                         var prog_row = '';
                                        _.sortBy(rowData.programacion, 'gestion').forEach(function(ip){
                                            var valor = (ip.dato) ? `${ip.dato} ${rowData.cod_unidad_medida}` : '';
                                            prog_row += `<td>${valor}</td>`;
                                        });


                                        html += `<tr>
                                            <td>Programado</td>${prog_row}
                                            </tr>`;

                                        var ej_row = '';
                                        _.sortBy(rowData.ejecucion, 'gestion').forEach(function(ip){
                                            var valor = (ip.dato) ? `${ip.dato} ${rowData.cod_unidad_medida}` : '';
                                            ej_row += `<td>${valor}</td>`;
                                        });
                                        
                                        html += `<tr>
                                            <td>Ejecutado</td>${ej_row}
                                            </tr>`;
                                        html +=  `</tbody>
                                                    </table>`;
                                    
                                    return html
                                } 
                        },
                        // { text: ' ', width: 50, cellsalign: 'center', cellsrenderer: function (row, column, value, rowData) {
                        //         return `<!-- <a href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar " ><i class="fa fa-edit fa-lg text-warning "></i></a> -->
                        //                 <a href="#"  class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a>`;
                        //     }
                        // },
                    ]
                });
            });
        },
        refresh: function(){
            $.get(globalSP.urlApi + 'listctxseg', function(resp) {
                ctxseg.source.localdata = resp.data;
                ctxseg.dataTable.jqxDataTable("updateBoundData");
            })   
        },
        nuevo: function(){
            $("#tituloModal span").html("Crear Plan");
            $('#form-plan select, #form-plan input:text, textarea').val('');
            ctxForm.showModal();
        },
        editar: function(){
            var rowSelected = planes.dataTable.jqxDataTable('getSelection');
            if(rowSelected.length > 0)
            {
                var rowSel = rowSelected[0]; 
                ctxForm.setDataForm(rowSel);
                $("#tituloModal span").html("Modificar Plan");
                ctxForm.showModal();
            }
            else{
                swal("Seleccione el registro para modificar.");
            }
        },
        eliminar: function(){
            var rowSelected = planes.dataTable.jqxDataTable('getSelection');
            if(rowSelected.length > 0)
            {
                var rowSel = rowSelected[0];
                ctxForm.deletePlan(rowSel.id);             
            }
            else{
                swal("Seleccione el registro que desea eliminar.");
            }
        },
        cargar: function(){
            var rowsel = planes.dataTable.jqxDataTable('getSelection')[0];
            planactivo = rowsel;
                $('input[name=id_plan]').val(planactivo.id) ;
                // globalSP.planActivo = {
                //     id : planactivo.id,
                //     sigla_entidad : planactivo.sigla_entidad,
                //     cod_tipo_plan : planactivo.cod_tipo_plan,
                //     gestion_inicio : planactivo.gestion_inicio,
                //     gestion_fin : planactivo.gestion_fin
                // } 
            // $.get(globalSP.urlApi + 'getmenu', {p :rowsel.id}, function(res){
                // globalSP.generarMenu(rowsel.id, res.data);
                // globalSP.configuraMenu(rowsel); 
                window.location = globalSP.url + 'showEnfoque?p=' + rowsel.id ; 
            // })
             

            $('#menuSP .sp_menu').each(function(index, elem){
                var urlhref = $(elem).attr('href');
                // coloca el querystring en las urls del menu
                urlhref = urlhref.split('=')[0] + '=' + globalSP.planActivo.id;
                $(elem).attr('href', urlhref);
            });    
            globalSP.setTitulo2();
        },
    }

    globalSP.activarMenu(37);
    globalSP.cargarGlobales();
    globalSP.setBreadcrumb('Seguimiento y Evaluación', 'Seguimiento y Evaluación');

    ctxseg.fillIndicadores();

    $("#indicadores").change(function(){
        var id_arti_indicador = $("#indicadores").val();
        indsel = []
         indsel[0] = _.find(ctxseg.indicadores, function(elem){
            return elem.id_arti_indicador == id_arti_indicador;
        });
         console.log(indsel)
         ctxseg.fillTabla(indsel)
    });

    $('#nuevo').click(function(){
        planes.nuevo();
    });

    $(".sp_planes").on('click', '.sel_edit, #editar', function(){
        planes.editar();
    });

    $(".sp_planes").on('click', '.sel_delete, #eliminar', function(){
        planes.eliminar();
    });
    $(".sp_planes").on('click', '.sel_cargar_plan', function(){
        planes.cargar();
    });

    $("#cancelar").click(function(){
        $.magnificPopup.close();
    })

    // $("#form-plan").validate(ctxForm.validateRules());

    

})
</script>
@endpush
