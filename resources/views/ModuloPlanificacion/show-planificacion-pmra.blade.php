@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.energyblue.css">
<link rel="stylesheet" href="/plugins/bower_components/select2/dist/css/select2.min.css" type="text/css"/>
<link rel="stylesheet" href="/plugins/bower_components/sweetalert/sweetalert.css" type="text/css">
<link rel="stylesheet" type="text/css" href="/sty-mode-2/vendor/plugins/slick/slick.css" />
<style media="screen">
.popup-basic {
  position: relative;
  background: #FFF;
  width: auto;
  max-width: 700px;
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
/*.sp_tooltip{
    z-index: 999999999 !important;
}
.flotTip { z-index: 9999 !important; }*/
.sp_cellTable, .sp_cellTable:hover{
    background-color: #FFFFFF !important;
};

.sp_fila_seleccionada , .sp_fila_seleccionada:hover{
    background-color: #345  !important;
};
.jqx-grid-column-header{
    background-color: #222 !important;
}


</style>

@endsection


@section('content')


    <!--  ===========================================    SUB MENU de planificacion    =============================================================== -->

    <div class="tray tray-center ph40 va-t posr ptn">
        <header id="topbar" class="ph10 pbn mb10">
            <div id="submenus-planificacion" class="topbar-left">
                <button id="limpiaTooltips" class="pull-left fa fa-square-o bg-dark darker fa-2x" title="Quitar mensajes de ayuda y tooltips"></button>
                <ul class="nav nav-list nav-list-topbar pull-left pbn mn">
                    <li id="planif_submenu_1">
                        <a href="javascript:void(0)" id="1">Articulación con la acción </a>
                    </li>
                    <li id="planif_submenu_2">
                        <a href="javascript:void(0)" id="2">Programación del Resultado</a>
                    </li>
                    <li id="planif_submenu_3">
                        <a href="javascript:void(0)" id="3">Planificación de acciones</a>
                    </li>
                </ul>
            </div>
            <div class="topbar-right sp_titulo_topbar_right">
                <h3>Planificación __</h3>
            </div>
        </header>

        <div id="planificacionContainer" class="row">

            <!--  ===========================================  Planificacion de la Accion PMRA ================================ -->
            <div class="col-md-12 slick-slide" id="planificacion_pmra">
                <div class="panel panel-visible" >
                    <div class="panel-heading  bg-dark ">
                        <div class="panel-title ">
                            <div>
                                <i class="glyphicon glyphicon-tasks" ></i><span class="sp_titulo_panel"> Identificación de la Articulación PDES </span> <span id="sp_est_pmra" class="ml5 badge bg-dark dark"></span>                                 
                                <span class="pull-right">
                                    <button id="pmra_nuevo" type="button" class="btn btn-sm btn-success dark m5 br4" data-toggle="tooltip" title=""><i class="fa fa-plus-circle text-white"></i> Agregar </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body pn">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="panel ">
                        {{--     <div class="panel-heading">
                                        <span class="panel-icon"><i class="fa fa-pencil"></i>
                                        </span>
                                        <span class="panel-title">Pilares</span>
                                    </div> --}}
                                    <div id="sp_est_pilar_acciones">                                       
                                    </div>
                                </div>
                            </div>
                            <div id="" class="col-sm-9" >                                
                                <div id="dt_pmra"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!--  ===========================================   Programacion del Resultado=================================== -->
            <div class="col-md-12 slick-slide" id="planificacion_prog">
                <div class="panel panel-visible" >
                    <div class="panel-heading  bg-dark ">
                        <div class="panel-title ">
                            <div>
                                <i class="glyphicon glyphicon-tasks"></i> <span class="sp_titulo_panel"> Programación del Resultado </span> <span id="sp_est_prog" class="ml5 badge bg-dark dark"></span>                                 
                                <span class="pull-right">
                                    {{-- <button id="prog_nuevo" type="button" class="btn btn-sm btn-success dark m5 br4" data-toggle="tooltip" title=""><i class="fa fa-plus-circle text-white"></i> Agregar </button> --}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body pn">
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="panel ">
                    {{--                                     <div class="panel-heading">
                                        <span class="panel-icon"><i class="fa fa-pencil"></i>
                                        </span>
                                        <span class="panel-title">Pilares</span>
                                    </div> --}}
                                    <div id="sp_est_pilar_res">                                       
                                    </div>
                                </div>
                            </div>
                            <div id="" class="col-sm-11" >                                
                                <div id="dt_prog"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--  ===========================================   Planificacion Acciones e indicadores ================================== -->
           <div class="col-md-12 slick-slide" id="planificacion_plaa">
            </div>

        </div>
    </div>
      <!-- end: .tray-center -->




    <!-- -----------------------------------------          Modal PMRA  --------------------------------------------------- -->
    <div id="modal_pmra"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <!-- end .panel-heading section -->
            <form method="post" action="/" id="form-pmra" name="form-pmra">

                <div class="panel-body  of-a">
                    <div class="row">
                            <input class="hidden" name="id_pmra" id="id_pmra" >
                            <div class="row">
                                <div class=" pl5 br-r mvn15">
                                    <h4 class="ml5 mt20 ph10 pb5 br-b fw700">Defina su pilar meta resultado y acciones<small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>

                                     <div class="section">
                                        <label class="field-label" for="pmra_id_p">Pilares según sus atribuciones</label>
                                        <label class="field select">
                                            <select id="pmra_id_p" name="pmra_id_p" class="required" style="width:100%;">
                                                <option value=""></option>
                                            </select>
                                            <i class="arrow"></i>                  
                                        </label>
                                    </div>

                                    <div class="section">
                                        <label class="field-label" for="pmra_id_m">Metas </label>
                                        <label class="field select">
                                            <select id="pmra_id_m" name="pmra_id_m" class="required" style="width:100%;">
                                            </select>
                                            <i class="arrow"></i>                  
                                        </label>
                                    </div>

                                    <div class="section">
                                        <label class="field-label" for="pmra_id_r">Resultados</label>
                                        <label class="field select">
                                            <select id="pmra_id_r" name="pmra_id_r" class="required" style="width:100%;">
                                            </select>
                                            <i class="arrow"></i>                  
                                        </label>
                                    </div>

                                    <div class="section">
                                        <label class="field-label" for="pmra_id_a">Acciones</label>
                                        <label class="field select">
                                            <select id="pmra_id_a" name="pmra_id_a" class="required" style="width:100%;">
                                            </select>
                                            <i class="arrow"></i>                  
                                        </label>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary">Guardar</button>
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
                </div>
            </form>
        </div>
        <!-- end: .panel -->
    </div>

    <!-- -----------------------------------------          Modal Programacion  --------------------------------------------------- -->
    <div id="modal_prog"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <!-- end .panel-heading section -->
            <form method="post" action="/" id="form_prog" name="form_prog">
                <div class="panel-body  of-a">                    
                    {{-- <input type="hidden"  name="id_plan_articulacion_pdes_prog" id="id_plan_articulacion_pdes_prog" > --}}
                    <input  class="hidden" name="id_arti_resultado_indicador_prog" id="id_arti_resultado_indicador_prog" >
                    <input  class="hidden" name="id_indicador_prog" id="id_indicador_prog" >
                    <input  class="hidden" name="id_indicador_ejecucion_prog" id="id_indicador_ejecucion_prog" >
                    <h4 class="ml5 mt20 ph10 pb5 br-b fw700">Describa su indicador y la programación para el resultado articulado: <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div class=" bg-system  row p10">
                        <div id="pmr_prog"></div>
                        <div id="pilar_prog"></div>
                        <div id="meta_prog"></div>
                        <div id="resultado_prog"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 br-r">

                            <h5 class="mt5 ph10 pb5 br-b fw700">Indicador <small class="pull-right fw700 text-primary">- </small> </h5>
                            <div class="section">
                                <label class="field-label" for="nombre_indicador_prog">Indicador de resultado</label>
                                <label for="nombre_indicador_prog" class="field prepend-icon">
                                    <textarea class="gui-textarea" id="nombre_indicador_prog" name="nombre_indicador_prog"  placeholder="Indicador de resultado"></textarea>
                                    <label for="nombre_indicador_prog" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                    </label>                                        
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="id_diagnostico">Variables del diagnóstico</label>
                                <label class="field select">
                                    <select id="id_diagnostico" name="id_diagnostico" class="" style="width:100%;">
                                        <option value=""></option>
                                    </select>
                                    <i class="arrow"></i>
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="variable_prog">Variable</label>
                                <label class="field prepend-icon">
                                    <input type="text" id="variable_prog" name="variable_prog" class="gui-input" placeholder="Variable" style="width:100%;">
                                    <label for="variable_prog" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                    </label>
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="idp_unidad_prog">Unidad de Medida </label>
                                <label class="field select">
                                    <select id="idp_unidad_prog" name="idp_unidad_prog" class="required sp_metrica" style="width:100%;">
                                    </select>
                                    <i class="arrow"></i>                  
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="linea_base_prog">Linea Base</label>
                                <label class="field prepend-icon">
                                    <input type="text" class="gui-input" id="linea_base_prog" name="linea_base_prog" placeholder="Linea Base" style="width:100%;">
                                    <label for="linea_base_prog" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                    </label>                 
                                </label>
                            </div>
                            <div class="section">
                                <label class="field-label" for="alcance_prog">Alcance</label>
                                <label class="field prepend-icon">
                                    <input type="text" class="gui-input" id="alcance_prog" name="alcance_prog" placeholder="Alcance" style="width:100%;">
                                    <label for="alcance_prog" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                    </label>                  
                                </label>

                            </div>
                        </div>


                        <div class="col-sm-6" id="gestiones_prog">
                            <h5 class="mt5 ph10 pb5 br-b fw700">Programación <small class="pull-right fw700 text-primary">- </small> </h5>
                            <table class="table mbn">
                                <thead>
                                    <tr class="hidden">
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary sp_save">Guardar</button>
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
                </div>
            </form>
        </div>
        <!-- end: .panel -->
    </div>



@endsection

@push('script-head')

<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdata.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdatatable.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdraw.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxchart.core.js"></script>
<script type="text/javascript" src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
<script type="text/javascript" src="/js/jqwidgets-localization.js"></script>
<script type="text/javascript" src="/plugins/bower_components/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="/sty-mode-2/vendor/plugins/slick/slick.min.js"></script>
{{-- <script type="text/javascript" src="/sty-mode-2/vendor/plugins/moment/moment.min.js"></script> --}}
{{-- <script type="text/javascript" src="/sty-mode-2/vendor/plugins/datepicker/js/bootstrap-datetimepicker.min.js"></script> --}}
<script type="text/javascript">
$(function(){
    ctxgral = {
        theme : 'energyblue',
        token: $('input[name=_token]').val(),
        showModal : function(modal){
            $(".state-error").removeClass("state-error")
            $(modal + " em").remove();
            $.magnificPopup.open({
                removalDelay: 500, //delay removal by X to allow out-animation,
                // focus: '#pmra_id_pilar',
                items: {
                    src: modal
                },
                // overflowY: 'hidden', //
                callbacks: {
                    beforeOpen: function(e) {
                        var Animation = "mfp-zoomIn";
                        this.st.mainClass = Animation;
                    }
                },
                midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
            });
        }, 
        refreshList: function(ctxObj, fn){
            $.get(ctxObj.urlList, {p:globalSP.idPlanActivo}, function(resp) {
                ctxObj.source.localdata = resp.data;
                ctxObj.dataTable.jqxDataTable("updateBoundData");
                ctxObj.estadistics();
                if(fn) fn();
            })   
        },
        /* ctxobj debe tener validateRules y saveData*/
        creaValidateRules: function(ctxObj){
            messagesObj = ctxObj.validateRules();
            var messages = $.extend(true, {}, messagesObj);// _.clone(messagesObj)
            var rules = _.mapObject(messagesObj, function(val, key){
                val.required = true;
                return val;
            });
            var reglasVal = {
                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",
                    rules: rules,
                    messages: ctxObj.validateRules(),

                    highlight: function(element, errorClass, validClass) {
                            $(element).closest('.field').addClass(errorClass).removeClass(validClass);
                    },
                    unhighlight: function(element, errorClass, validClass) {
                            $(element).closest('.field').removeClass(errorClass).addClass(validClass);
                    },
                    errorPlacement: function(error, element) {
                        if (element.is(":radio") || element.is(":checkbox")) {
                                element.closest('.option-group').after(error);
                        } else {
                                error.insertAfter(element.parent());
                        }
                    },
                    submitHandler: function(form) {
                        ctxObj.saveData();
                    }
            }
            return reglasVal; 
        }, 

    }

    /***********************************  P M R A  ***************************************************************************/
    var ctxpmra = {
        dataTable : $("#dt_pmra"),
        source : {},
        urlList: globalSP.urlApi + 'lista_pmraPlan',

        fillDataTable : function() {
            $.get(ctxpmra.urlList, {p : globalSP.idPlanActivo}, function(resp)
            {
                ctxpmra.source =
                {
                    dataType: "json",
                    localdata: resp.data,
                    dataFields: [
                        { name: 'id', type: 'number' },
                        { name: 'cod_p', type: 'string' },
                        { name: 'cod_m', type: 'string' },
                        { name: 'cod_r', type: 'string' },
                        { name: 'cod_a', type: 'string' },                        
                        { name: 'nombre_p', type: 'string' },
                        { name: 'nombre_m', type: 'string' },
                        { name: 'nombre_r', type: 'string' },
                        { name: 'nombre_a', type: 'string' },
                        { name: 'desc_p', type: 'string' },
                        { name: 'desc_m', type: 'string' },
                        { name: 'desc_r', type: 'string' },
                        { name: 'desc_a', type: 'string' },
                        { name: 'logo_p', type: 'string' },
                        { name: 'sector', type: 'object' },
                    ],
                    id: 'id',
                };
                ctxpmra.estadistics();
                var dataAdapter = new $.jqx.dataAdapter(ctxpmra.source);
                ctxpmra.dataTable.jqxDataTable({
                    // ready: function () {   
                    //     $(".contentdt_pmra").css({"z-index": "100", 'font-size':'9px'
                    //     });  
                    // },
                    source: dataAdapter,
                    theme: ctxgral.theme,
                    altRows: false,
                    sortable: true,
                    width: "100%",
                    filterable: false,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    columnsResize: true,
                    localization: getLocalization('es'),
                    columns: [
                        { text: '-', width: 50, align:'center',  cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<img width="30" class="img-circle"  src="/img/${rowData.logo_p}" data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_p}</b> - ${rowData.desc_p}" /> `
                            } 
                        },
                        { text: 'P', dataField: 'cod_p', width: 50, align:'center',  cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_p}</b> - ${rowData.desc_p}">${rowData.cod_p}</span>`;
                            } 
                        },
                        { text: 'M', width: 50, align:'center', cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_m}</b> - ${rowData.desc_m}">${rowData.cod_m}</span>`
                            } 
                        },
                        { text: 'R',  dataField: 'cod_r', width: 50, align:'center', cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_r}</b> - ${rowData.desc_r}">${rowData.cod_r}</span>`
                            } 
                        },
                        { text: 'A',  dataField: 'cod_a', width: 50, align:'center', cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_a}</b> - ${rowData.desc_a}">${rowData.cod_a}</span>`
                            } 
                        },
                        { text: 'Descripción Accion ',  dataField: 'desc_a', width:'50%', align:'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_a}</b> - ${rowData.desc_a}">${rowData.nombre_a} - ${rowData.desc_a}</span>`
                            } 
                        },
                        { text: ' ', width: 50, cellsalign: 'center', cellsrenderer: function (row, column, value, rowData) {
                                return `<!-- <a href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar " ><i class="fa fa-edit fa-lg text-warning "></i></a> -->
                                        <a href="#"  class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a>`;
                            }
                        },
                    ]
                });


            });
        },
        getDataForm: function(){
            var obj = {
                id : $("#id_pmra").val(),
                id_a: $("#pmra_id_a").val(),
                _token : ctxgral.token,
                id_plan : globalSP.idPlanActivo,
                p: globalSP.idPlanActivo
            }
            return obj;
        },
        nuevo: function(){
            $(".tituloModal span").html(`Agregar articulación pdes`);
            $('#form-pmra input:text').val('');
            $("select").val('').change();
            ctxgral.showModal("#modal_pmra");
        },
        eliminar: function(){
            var rowSelected = ctxpmra.dataTable.jqxDataTable('getSelection');
            if(rowSelected.length > 0)
            {
                var rowSel = rowSelected[0];
                ctxpmra.delete(rowSel.id);             
            }
            else{
                swal("Seleccione el registro que desea eliminar.");
            }
        },
        validateRules: function(){
            return {
                        pmra_id_p:  { required: 'Falta pilar' },
                        pmra_id_m:  { required: 'Falta meta' },
                        pmra_id_r:  { required: 'Falta resultado' },
                        pmra_id_a:  { required: 'Debe seleccionar una acción' }
                    };
        }, 
        saveData: function(){
            var obj = ctxpmra.getDataForm();
            $.post(globalSP.urlApi + 'save_pmra', obj, function(resp){
                ctxgral.refreshList(ctxpmra);
                new PNotify({
                            title: resp.estado == 'success' ? 'Guardado' : 'Error',
                            text: resp.msg,
                            shadow: true,
                            opacity: 0.9,
                            addclass: noteStack,
                            type: (resp.estado == 'success') ? "success" : "danger",
                            stack: Stacks[noteStack],
                            width: findWidth(),
                            delay: 1500
                        });
                $.magnificPopup.close();  
            });             
        },
        delete: function(id){
            swal({
                  title: `Está seguro de eliminar la articulación PDES del plan?`,
                  text: "No podrá recuperar este registro!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Si, eliminar!",
                  closeOnConfirm: true
                }, function(){
                    $.post(globalSP.urlApi + 'delete_pmra', {'id': id, _token : ctxgral.token, }, function(res){
                        new PNotify({
                                  title: !res.error ? 'Eliminado' : 'Error!!' ,
                                  text: res.msg,
                                  shadow: true,
                                  opacity: 0.9,
                                  addclass: noteStack,
                                  type: !res.error ? "success" : 'danger',
                                  stack: Stacks[noteStack],
                                  width: findWidth(),
                                  delay: 2000
                              });
                        ctxgral.refreshList(ctxpmra);
                    });
                });
        },
        estadistics: function(){
            $("#sp_est_pmra").html('Total de acciones ' + ctxpmra.source.localdata.length);
            var pils = _.groupBy(ctxpmra.source.localdata, function(elem){
                return elem.cod_p;
            });
            var html = `<div class="panel-heading">
                                        <span class="panel-icon"><i class="glyphicons glyphicons-bank"></i>
                                        </span>
                                        <span class="panel-title">Pilares</span>
                                    </div>`;
            _.mapObject(pils, function(elem, key){
                var pilar = elem[0];
                html += `<div class="panel-body row" > 
                            <div class="col-sm-3">
                                <div class="w50">
                                    <img width="50" class=""  src="/img/${pilar.logo_p}"/>
                                    <span class="badge badge-hero bg-system dark pull-right posr" style="top:-6px;" data-toggle="tooltip" data-container="body" data-html="true" title="N° de acciones ${elem.length}, para el <b>${pilar.nombre_p}</b>- ${pilar.desc_p}">${elem.length}</span> 
                                </div> 
                            </div>
                            <div class="col-sm-9"><span><b>${pilar.nombre_p}</b>- ${pilar.desc_p}</span>  </div>
                                
                        </div>`;               
            });
             $("#sp_est_pilar_acciones").html(html);
        }

    }



    /***********************************  Programacion ***************************************************************************/
    var ctxprog = {
        dataTable : $("#dt_prog"),
        source : {},   
        urlList: globalSP.urlApi + 'listaprogramacion',     
        fillDataTable : function() {
            $.get(ctxprog.urlList, {p : globalSP.idPlanActivo}, function(resp)
            {
                ctxprog.source =
                {
                    dataType: "json",
                    localdata: resp.data,
                    dataFields: [
                        { name: 'id_pmra', type: 'number' },
                        { name: 'cod_p', type: 'string' },
                        { name: 'cod_m', type: 'string' },
                        { name: 'cod_r', type: 'string' },
                        // { name: 'cod_a', type: 'string' },                        
                        { name: 'nombre_p', type: 'string' },
                        { name: 'nombre_m', type: 'string' },
                        { name: 'nombre_r', type: 'string' },
                        // { name: 'nombre_a', type: 'string' },
                        { name: 'desc_p', type: 'string' },
                        { name: 'desc_m', type: 'string' },
                        { name: 'desc_r', type: 'string' },
                        // { name: 'desc_a', type: 'string' },
                        { name: 'logo_p', type: 'string' },
                        { name: 'sector', type: 'string' },
                        { name: 'cod_periodo_plan', type: 'string' },
                        { name: 'gestion_ini', type: 'string' },
                        { name: 'gestion_fin', type: 'string' },
                        { name: 'indicadores', type: 'object' },                        
                    ],
                    id: 'id',
                };
                ctxprog.estadistics();
                var dataAdapter = new $.jqx.dataAdapter(ctxprog.source);
                ctxprog.dataTable.jqxDataTable({
                    source: dataAdapter,
                    theme: ctxgral.theme,
                    altRows: false,
                    sortable: true,
                    width: "100%",
                    filterable: false,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    columnsResize: true,
                    localization: getLocalization('es'),
                    columns: [                       
                        { text: '-', width: 50, align:'center',  cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<img width="30" class="img-circle"  src="/img/${rowData.logo_p}" data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_p}</b> - ${rowData.desc_p}" /> `
                            } 
                        },
                        { text: '<span title="Pilares">P</span>', dataField: 'cod_p', width: 50, align:'center', cellsalign: 'center',  cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_p}</b> - ${rowData.desc_p}">${rowData.cod_p}</span>`;
                            } 
                        },
                        { text: '<span title="Metas">M</span>', dataField: 'cod_m', width: 50,  align:'center', cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_m}</b> - ${rowData.desc_m}">${rowData.cod_m}</span>`
                            } 
                        },
                        { text: '<span title="Resultados">R</span>', dataField: 'cod_r', width: 50,  cellsalign: 'center', align:'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_r}</b> - ${rowData.desc_r}">${rowData.cod_r}</span>`
                            } 
                        },
                        { text: '', width: 40, cellsalign: 'center', cellsrenderer: function (row, column, value, rowData) {
                                return `<a href="javascript:void(0)"  class="m-l-10 m-r-10 m-t-10 sel_add" title="Agregar indicador y programación dentro en la articulación de resultado " ><i class="fa fa-plus-circle fa-2x text-success "></i></a>`;
                            }
                        }, 
                        { text: 'Indicadores de resultado y su Programación ' + ( (ctxprog.source.localdata.length>0) ? ` para ${ctxprog.source.localdata[0].gestion_ini} -  ${ctxprog.source.localdata[0].gestion_fin} ` : '' ),    align:'center', width: 1200,cellClassName: 'sp_cellTable', 
                            cellsrenderer: function(row, column, value, rowData){
                                var html = ''; 
                                if(rowData.indicadores.length>0){ 
                                    var headGestiones = '';
                                    for(i=rowData.gestion_ini; i<= rowData.gestion_fin; i++){
                                        headGestiones += `<th>${i}</th>`;
                                    }
                                        

                                     html = `<table class="table table-bordered table-hover fs11 sp_table">
                                                    <thead><tr class="primary"> <th>Indicador de Res.</th> <th>Variable</th>  <th>L. Base</th> <th>Alcance</th>${headGestiones} <th></th> </tr> </thead>
                                                    <tbody>`;

                                    rowData.indicadores.forEach(function(ind, index){

                                        var prog_row = '';
                                        for(i=rowData.gestion_ini; i<= rowData.gestion_fin; i++){
                                            progGestion = _.find(ind.programacion, function(el){
                                                                return el.gestion == i;
                                                            }) ;
                                            var valor = (progGestion && progGestion.dato) ? `${progGestion.dato } ${ind.unidad}` : '';
                                            prog_row += `<td> ${valor}</td>`;
                                        }

                                        html += `<tr>
                                                    <td class="">${ind.nombre_indicador}</td> 
                                                    <td>${ind.variable || ''}</td>
                                                    <td>${ind.linea_base ||  ''} ${ind.unidad || ''}</td> 
                                                    <td class="">${ind.alcance || ''} ${ind.unidad || ''}</td> 
                                                    ${prog_row} 
                                                    <td><a href="javascript:void(0)"  index_ari="${index}" class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar Indicador y programación" ><i class="fa fa-edit text-warning fa-lg"></i></a>
                                                        <a href="javascript:void(0)" id_arti_resultado_indicador="${ind.id_arti_resultado_indicador}" class="sel_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a></td>
                                                </tr>`;
                                    });
                                    html +=    `</tbody>
                                             </table>`;
                                }
                                return html
                            } 
                           
                        },          
                    ]
                });


            });
        },
        getDataForm: function(){
            gestion_ini = ctxprog.dataTable.jqxDataTable('getSelection')[0].gestion_ini;
            gestion_fin = ctxprog.dataTable.jqxDataTable('getSelection')[0].gestion_fin;
            var obj = {
                _token : ctxgral.token,
                id_plan : globalSP.idPlanActivo,
                p: globalSP.idPlanActivo,
                indicador: {
                    id : $("#id_indicador_prog").val(),
                    nombre :$("#nombre_indicador_prog").val(),
                    idp_unidad: $("#idp_unidad_prog").val(),
                    // id_diagnostico: $("#id_diagnostico").val(),
                    variable: $("#variable_prog").val(),
                    alcance: $("#alcance_prog").val(),
                },
                arti_resultado_indicador: {
                    id: $("#id_arti_resultado_indicador_prog").val(),
                    id_plan_articulacion_pdes : ctxprog.dataTable.jqxDataTable('getSelection')[0].id_pmra,
                },
                indicador_ejecucion: {
                    id: $("#id_indicador_ejecucion_prog").val(),
                    gestion: gestion_ini - 1,
                    dato: $("#linea_base_prog").val(),
                }


            };
            var indProgramacion = [];
            for(var i = gestion_ini; i <= gestion_fin; i++){
                var prog = {};
                prog.id = $("#form_prog .id" + i).val();;
                prog.gestion = i;
                prog.dato =  $("#form_prog .d" + i).val();
                indProgramacion.push(prog);
            }     
            obj.indicadores_programacion = indProgramacion;
            return obj;
        },
        editar: function(index){
            $(".tituloModal span").html(`Modificar Programación de Resultado`);
            var rowSelected = ctxprog.dataTable.jqxDataTable('getSelection')[0];
            var indicadorsel = rowSelected.indicadores[index];
            $("#id_diagnostico").val('').change();
            $("#id_arti_resultado_indicador_prog").val(indicadorsel.id_arti_resultado_indicador);
            $("#id_indicador_prog").val(indicadorsel.id_indicador);
            $("#id_indicador_ejecucion_prog").val(indicadorsel.id_indicador_ejecucion);
            $("#nombre_indicador_prog").val(indicadorsel.nombre_indicador);

            $("#variable_prog").val(indicadorsel.variable);
            $("#idp_unidad_prog").val(indicadorsel.idp_unidad).change();
            $("#linea_base_prog").val(indicadorsel.linea_base);
            $("#alcance_prog").val(indicadorsel.alcance);
            
            var html = genera_inputgestiones(rowSelected.gestion_ini, rowSelected.gestion_fin, indicadorsel.programacion);
            $("#gestiones_prog tbody").html(html);
            ctxgral.showModal("#modal_prog");
        },
        nuevo: function(){
            $(".tituloModal span").html(`Agregar Programación de Resultado`);
            $('#form_prog input:text, #form_prog textarea').val('');
            $("select").val('').change();
            var rowSelected = ctxprog.dataTable.jqxDataTable('getSelection')[0];
            var html = genera_inputgestiones(rowSelected.gestion_ini, rowSelected.gestion_fin);
            $("#gestiones_prog tbody").html(html);
            $("#id_plan_articulacion_pdes").val(rowSelected.id);
            $("#pmr_prog").html(`<b>${rowSelected.cod_p} . ${rowSelected.cod_m} . ${rowSelected.cod_r}</b>`);
            $("#pilar_prog").html(`<b>${rowSelected.nombre_p}</b> - ${rowSelected.desc_p}`);
            $("#meta_prog").html(`<b>${rowSelected.nombre_m}</b> - ${rowSelected.desc_m}`);
            $("#resultado_prog").html(`<b>${rowSelected.nombre_r}</b> - ${rowSelected.desc_r}`);
            ctxgral.showModal("#modal_prog");
        },

        validateRules: function(){
           return {
                nombre_indicador_prog:  { required: 'Campo requerido' },
                idp_unidad_prog:  { required: 'Campo requerido' },
                variable_prog:  { required: 'Campo requerido' },
                linea_base_prog:  { required: 'Campo requerido' },
                alcance_prog:  { required: 'Campo requerido' },
            }                 
        }, 
        saveData: function(){
            var obj = ctxprog.getDataForm();
            $.post(globalSP.urlApi + 'saveIndicadorResProg', obj, function(resp){
                ctxgral.refreshList(ctxprog);
                new PNotify({
                            title: resp.estado == 'success' ? 'Guardado' : 'Error',
                            text: resp.msg,
                            shadow: true,
                            opacity: 0.9,
                            addclass: noteStack,
                            type: (resp.estado == 'success') ? "success" : "danger",
                            stack: Stacks[noteStack],
                            width: findWidth(),
                            delay: 1500
                        });
                $.magnificPopup.close();  
            });             
        },
        /* llama a la ruta para eliminar el id_arti_resultado_indicador*/
        delete: function(id_ari){
            var rowSel = ctxprog.dataTable.jqxDataTable('getSelection')[0];
            swal({
                  title: `Está seguro de eliminar el indicador del resultado: ${rowSel.cod_p} . ${rowSel.cod_m} . ${rowSel.cod_r}?`,
                  text: `No podrá recuperar este registro!`,
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Si, eliminar!",
                  closeOnConfirm: true
                }, function(){
                    $.post(globalSP.urlApi + 'deleteprogramacion', {'id_ari': id_ari, _token : ctxgral.token, }, function(res){
                        new PNotify({
                                  title: !res.error ? 'Eliminado' : 'Error!!' ,
                                  text: res.msg,
                                  shadow: true,
                                  opacity: 0.9,
                                  addclass: noteStack,
                                  type: !res.error ? "success" : 'danger',
                                  stack: Stacks[noteStack],
                                  width: findWidth(),
                                  delay: 1400
                              });
                        ctxgral.refreshList(ctxprog);
                    });
                });
        },
        estadistics: function(){
            var total_indicadores = ctxprog.source.localdata.reduce(function(carry, elem, indice, vector){
                                      return carry + elem.indicadores.length;
                                    }, 0);
            $("#sp_est_prog").html( 'Total de indicadores de Resultado ' + total_indicadores);

            var pils = _.groupBy(ctxprog.source.localdata, function(elem){
                return elem.cod_p;
            });
            var html = `<div class="panel-heading">
                                        <span class="panel-icon"><i class="glyphicons glyphicons-bank"></i>
                                        </span>
                                    </div>`;
            _.mapObject(pils, function(elem, key){
                var inds = elem.reduce(function(sum, item){
                    return sum + item.indicadores.length;
                }, 0);
                var pilar = elem[0];
                html += `<div class="panel-body"> 
                                <div class="w50">

                                    <img width="50" class="" data-toggle="tooltip" data-container="body" data-html="true" title="<b>${pilar.nombre_p}</b> - ${pilar.desc_p}" src="/img/${pilar.logo_p}"/>
                                    <span class="badge badge-hero  bg-warning dark pull-left posr" style="top:-9px;" data-toggle="tooltip" data-container="body" data-html="true" title="N° de resultados asociados ${elem.length}">${elem.length}</span> 
                                    <span class="badge badge-hero bg-primary dark pull-right posr" style=" top: -9px; " data-toggle="tooltip" data-container="body" data-html="true" title="N° de indicadores ${inds}">${inds}</span>  
                                </div> 
                            </div>`;               
            });
             $("#sp_est_pilar_res").html(html);
        }

    }




    /* ************************************* Init ****************************/
    var init = (function(){
        gerera_opciones = function(arr){
            return arr.reduce(function(carry, op){
                return carry + `<option value="${op.id}">${op.nombre} - ${op.descripcion} </option>`;
            },'');          
        }

        genera_inputgestiones = function(gestion_ini, gestion_fin, data){
            var html='';                  
            for(var g = gestion_ini; g <= gestion_fin; g++)
            { 
                var ip = { id_ip:'', dato: ''};
                if(data && data.length>0)
                    ip =  _.find(data, function(prog){ return prog.gestion == g});
                
                html += `<tr>
                    <td class="fs17 text-center w30">
                        <span class="fa fa-newspaper-o text-info"></span>
                    </td>
                    <td class="va-m fw600 text-muted">${g}</td>
                    <td class="fs14 fw700 text-muted text-right">
                        <label for="mod_dato" class="field prepend-icon">
                            <input type="text"  class="hidden id${g}" value="${ip.id_ip || ''}" >
                            <input type="text"  class="hidden g${g} " value="${g}" >
                            <input type="text"  class="gui-input d${g}" placeholder="Valor" value="${ip.dato || ''}">
                            <label for="d${g}" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                            </label>
                        </label>
                    </td>
                </tr>`;
            }
            return html;            
        }

        planif_submenu_activo =  function(index){
            $("#submenus-planificacion li").removeClass('active');            
            $("#planif_submenu_" + (index)).addClass('active');
            $("#planificacionContainer").slickGoTo(index-1);
        }

        var listeners = function()
        {
            /* Inicia el slide de los menus de arriba */
            $('#planificacionContainer').slick({
                dots: false,
                infinite: false,
                speed: 500,
                arrows:false,
                touchMove:false,
                swipe:false,
            });

            /* De los submenus de arriba */            
            $("#submenus-planificacion a").click(function(){
                index = $(this).attr('id');
                planif_submenu_activo(index);
            });

            /* De los Tool tips con data-toggle */
            $("body").on('mouseenter ', '[data-toggle="tooltip"]', function(){
                $(this).tooltip('show')
            });
            $("body").on('mouseleave', '[data-toggle="tooltip"]', function(){
                $(this).tooltip('hide');
            }); 

            $("#limpiaTooltips").click(function(){
                $('.tooltip-inner, .tooltip-arrow').hide();
            })           

            $(".sp_cancelar").click(function(){
                $.magnificPopup.close();
            });   
        }

        var listeners_pmra =  function()
        {
            /* instancia Select2 de los selects pilar ,eta resultado accion */
            $.get(globalSP.urlApi + "getPilaresVinculadosAlPlan", {p:globalSP.idPlanActivo}, function(res){
                $("#pmra_id_p").append(gerera_opciones(res.data));
                $("#pmra_id_p").select2({
                    placeholder: 'Pilar ...',
                });
            });

            $("#pmra_id_m").select2({
                placeholder: 'Meta ...',
            });   
            $("#pmra_id_r").select2({
                placeholder: 'Resultado ...',
            });   
            $("#pmra_id_a").select2({
                placeholder: 'Acción ...',
            });   

            /* De los Selects */
            $("#pmra_id_p").change(function(){
                $.get(globalSP.urlApi + "getmetaspilar", {id_pilar: $("#pmra_id_p").val()}, function(res){
                    $("#pmra_id_m").html('<option></option>' + gerera_opciones(res.data) );
                    $("label attr[for=pmra_id_m]").html('Metas (' + res.data.length)
                })
            });

            $("#pmra_id_m").change(function(){
                $.get(globalSP.urlApi + "getresultadosmeta", {id_meta: $("#pmra_id_m").val()}, function(res){
                    $("#pmra_id_r").html('<option></option>' + gerera_opciones(res.data) );
                })
            });

            $("#pmra_id_r").change(function(){
                $.get(globalSP.urlApi + "getaccionesresultado", {id_resultado: $("#pmra_id_r").val()}, function(res){
                    $("#pmra_id_a").html('<option></option>' + gerera_opciones(res.data) );
                })
            });


            /* ------------- del contexto de pmra ----------------------------------------------------------------*/
            ctxpmra.fillDataTable();
            $("#form-pmra").validate(ctxgral.creaValidateRules(ctxpmra));

            $("#pmra_nuevo").click(function(){
                ctxpmra.nuevo();
            });

            $("#planificacion_pmra").on('click','.sel_delete, #pmra_eliminar', function(){
                ctxpmra.eliminar();
            });
      
        }

        var listeners_prog = function()
        {                      
            variablesDiagnostico = [];
            metricas = [];

            /* de los select 2 */  
            $.get(globalSP.urlApi + "getparametros/metricas", function(res){
                metricas = _.sortBy(res.data, 'nombre');
                var html = '';
                metricas.forEach(function(op){
                    html += `<option value="${op.id}">${op.nombre} (${op.codigo}) </option>`;
                });         
                $(".sp_metrica").html(html);
                $(".sp_metrica").select2({
                    placeholder: 'Unidad de medida ...',
                });
            });

            $.get(globalSP.urlApi + 'listvariables_lb', {p : globalSP.idPlanActivo}, function(res){
                var html = '';
                variablesDiagnostico = res.data;
                res.data.forEach(function(op){
                    html += `<option value="${op.id_diagnostico}">${op.variable}</option>`;
                });
                $("#id_diagnostico").html(html);
                $("#id_diagnostico").select2({
                    placeholder: 'Puede seleccionar una Variable del diagnóstico ',
                }); 
            });

            $("#id_diagnostico").change(function() {
                var varsel = _.find(variablesDiagnostico, function(elem){ return elem.id_diagnostico == $("#id_diagnostico").val(); });
                if(varsel){ 
                    $("#variable_prog").val(varsel.variable);
                    $("#idp_unidad_prog").val(varsel.idp_unidad).change();
                    $("#linea_base_prog").val(varsel.dato);
                }
            });
            

            /* ---------- Contexto programacion ---------------------------------------------------------*/
            ctxprog.fillDataTable();
            $("#form_prog").validate(ctxgral.creaValidateRules(ctxprog));

            $("#planificacion_prog").on('click', '.sel_add', function(){
                ctxprog.nuevo()
            });

            $("#planificacion_prog").on('click', '.sel_edit', function(){
                var index_ari = $(this).attr("index_ari");
                ctxprog.editar(index_ari);
            });

            $("#planificacion_prog").on('click', '.sel_delete', function(){
                var id_ari = $(this).attr("id_arti_resultado_indicador");
                ctxprog.delete(id_ari);
            });
        }

        listeners();
        listeners_pmra();
        listeners_prog();

    })();

    globalSP.activarMenu(globalSP.menu.Planificacion);
    globalSP.cargarGlobales(function(){
        /*Coloca el titulo en topdbar*/
            $(".sp_titulo_topbar_right h3").html( (globalSP.planActivo.cod_tipo_plan == 'PSDI') ? 'Planificación Sectorial':'Planificación Institucional');
    });
    globalSP.setBreadcrumb('Planificación', 'Planificación');
    $("#planificacion_plaa").load('/v/ModuloPlanificacion.view-planificacion-pmra-inds')
    planif_submenu_activo(1);

})






</script>

@endpush
