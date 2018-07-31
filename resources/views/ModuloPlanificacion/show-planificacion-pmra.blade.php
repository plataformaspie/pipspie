@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/plugins/bower_components/select2/dist/css/select2.min.css" type="text/css"/>
<link rel="stylesheet" href="/plugins/bower_components/sweetalert/sweetalert.css" type="text/css">
<link rel="stylesheet" type="text/css" href="/sty-mode-2/vendor/plugins/slick/slick.css" />
<style media="screen">
.popup-basic {
  position: relative;
  background: #FFF;
  width: auto;
  max-width: 900px;
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
/*.sp_tool{
    z-index: 999999999 !important;
}
.flotTip { z-index: 9999 !important; }*/

</style>

@endsection


@section('content')


    <!--  ===========================================    SUB MENU de planificacion    =============================================================== -->

    <div class="tray tray-center ph40 va-t posr ptn">
        <header id="topbar" class="ph10 pbn mb10">
            <div id="submenus-planificacion" class="topbar-left">
                <ul class="nav nav-list nav-list-topbar pull-left pbn mn">
                    <li id="planif_submenu_1">
                        <a href="javascript:void(0)" id="1">Articulación con la acción </a>
                    </li>
                    <li id="planif_submenu_2">
                        <a href="javascript:void(0)"  id="2">Programación del Resultado</a>
                    </li>
                    <li id="planif_submenu_3">
                        <a href="javascript:void(0)"  id="3">Planificación de acciones</a>
                    </li>
                </ul>
            </div>
            <div class="topbar-right">
                <h3>Planificación Sectorial</h3>
            </div>
        </header>
        <div id="planificacionContainer" class="row">

            <!--  ===========================================  Planificacion de la Accion PMRA ================================ -->
            <div class="col-md-12 slick-slide" id="planificacion_pmra">
                <div class="panel panel-visible" >
                    <div class="panel-heading  bg-dark ">
                        <div class="panel-title ">
                            <div>
                                <i class="glyphicon glyphicon-tasks" ></i><span class="sp_titulo_panel"> Identificación de la Articulación PDES</span><span id="sp_est_pmra" class="ml5 badge bg-dark dark"></span>                                 
                                <span class="pull-right">
                                    <button id="pmra_nuevo" type="button" class="btn btn-sm btn-success dark m5 br4" data-toggle="tooltip" title=""><i class="fa fa-plus-circle text-white"></i> Agregar </button>
                                    {{-- <button id="pmra_editar" type="button" class="btn btn-sm btn-warning dark m5 br4"><i class="fa fa-edit text-white"></i> Editar</button> --}}
                                    {{-- <button id="pmra_eliminar" type="button" class="btn btn-sm btn-danger dark m5 br4"><i class="fa fa-minus-circle text-white"></i> Eliminar</button> --}}
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
                                <i class="glyphicon glyphicon-tasks" ></i><span class="sp_titulo_panel">Programación del Resultado</span><span id="sp_est_prog" class="ml5 badge bg-dark dark"></span>                                 
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
           <!-- <div class="col-md-12 slick-slide" id="planificacion_ind">
                <div class="panel panel-visible" >
                    <div class="panel-heading  bg-dark ">
                        <div class="panel-title ">
                            <div>
                                <i class="glyphicon glyphicon-tasks" ></i><span class="sp_titulo_panel">Programación del Resultado</span><span id="sp_est_pmra" class="ml5 badge bg-dark dark"></span>                                 
                                <span class="pull-right">
                                    <button id="pmra_nuevo" type="button" class="btn btn-sm btn-success dark m5 br4" data-toggle="tooltip" title=""><i class="fa fa-plus-circle text-white"></i> Agregar </button>
                                    {{-- <button id="pmra_editar" type="button" class="btn btn-sm btn-warning dark m5 br4"><i class="fa fa-edit text-white"></i> Editar</button> --}}
                                    {{-- <button id="pmra_eliminar" type="button" class="btn btn-sm btn-danger dark m5 br4"><i class="fa fa-minus-circle text-white"></i> Eliminar</button> --}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body pn">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="panel ">
                    {{--                                     <div class="panel-heading">
                                        <span class="panel-icon"><i class="fa fa-pencil"></i>
                                        </span>
                                        <span class="panel-title">Pilares</span>
                                    </div> --}}
                                    <div id="sp_est_pilar_acciones">                                       
                                    </div>
                                </div>
                            </div>
                            <div id="" class="col-sm-9" >                                
                                <div id="dt_programacion"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

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

                <div class="panel-body mnw700 of-a">
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
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cerrar</a>
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

                <div class="panel-body mnw700 of-a">                    
                    <input class="hidden" name="id_plan_articulacion_pdes" id="id_plan_articulacion_pdes" >
                    <input class="hidden" name="id_arti_indicador" id="id_arti_indicador" >
                    <h4 class="ml5 mt20 ph10 pb5 br-b fw700">Describa su indicador y la programación para el resultado articulado: <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div class=" bg-success lighter  row p10">
                        <div id="pmr_prog"></div>
                        <div id="pilar_prog"></div>
                        <div id="meta_prog"></div>
                        <div id="resultado_prog"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 br-r">

                            <h5 class="mt5 ph10 pb5 br-b fw700">Indicador <small class="pull-right fw700 text-primary">- </small> </h5>
                            <div class="section">
                                <label class="field-label" for="nombre_indicador_res">Indicador de resultado</label>
                                <label for="nombre_indicador_res" class="field prepend-icon">
                                    <textarea class="gui-textarea" id="nombre_indicador_res" name="nombre_indicador_res"  placeholder="Indicador de resultado"></textarea>
                                    <label for="nombre_indicador_res" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                    </label>                                        
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="variable_res">Variable</label>
                                <label class="field select">
                                    <select id="variable_res" name="variable_res" class="required" style="width:100%;">
                                        <option value=""></option>
                                    </select>
                                    <i class="arrow"></i>
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="idp_unidad_res">Unidad de Medida </label>
                                <label class="field select">
                                    <select id="idp_unidad_res" name="idp_unidad_res" class="required" style="width:100%;">
                                    </select>
                                    <i class="arrow"></i>                  
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="linea_base_res">Linea Base</label>
                                <label class="field prepend-icon">
                                    <input type="text" class="gui-input" id="linea_base_res" name="linea_base_res" placeholder="Linea Base" style="width:100%;">
                                    <label for="linea_base_res" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                    </label>                 
                                </label>
                            </div>
                            <div class="section">
                                <label class="field-label" for="alcance_res">Alcance</label>
                                <label class="field prepend-icon">
                                    <input type="text" class="gui-input" id="alcance_res" name="alcance_res" placeholder="Alcance" style="width:100%;">
                                    <label for="alcance_res" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
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
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cerrar</a>
                </div>
            </form>
        </div>
        <!-- end: .panel -->
    </div>
@endsection

@push('script-head')

<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcore.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxbuttons.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxscrollbar.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdata.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdatatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdraw.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxchart.core.js') }} "></script>

<script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
<script src="/js/jqwidgets-localization.js"></script>
<script type="text/javascript" src="/plugins/bower_components/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="/sty-mode-2/vendor/plugins/slick/slick.min.js"></script>
<script type="text/javascript">
$(function(){

{
    var ctxpmra = {
        dataTable : $("#dt_pmra"),
        source : {},

        fillDataTable : function() {
            $.get(globalSP.urlApi + 'lista_pmraPlan', {p : globalSP.idPlanActivo}, function(resp)
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
                    altRows: false,
                    sortable: true,
                    width: "100%",
                    filterable: false,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    localization: getLocalization('es'),
                    columns: [
                        // { text: 'Pilar',  dataField: 'cod_p',align:'center',
                        //         cellsrenderer: function(row, column, value, rowData){
                        //             return `<div class="col-sm-4"> <img width="30" class="img-circle"  src="/img/${rowData.logo_p}"/> </div> <div class="col-sm-8"><b>  ${rowData.cod_p}</b> </div>`
                        //     } 
                        // },                        
                        { text: '-', width: 60, align:'center',  cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<img width="30" class="img-circle"  src="/img/${rowData.logo_p}" data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_p}</b> - ${rowData.desc_p}" /> `
                            } 
                        },
                        { text: 'Pilar ', dataField: 'cod_p', align:'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_p}</b> - ${rowData.desc_p}">${rowData.nombre_p}</span>`;
                            } 
                        },
                        { text: 'Meta ', align:'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_m}</b> - ${rowData.desc_m}">${rowData.nombre_m}</span>`
                            } 
                        },
                        { text: 'Resultado ',  dataField: 'cod_r', align:'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_r}</b> - ${rowData.desc_r}">${rowData.nombre_r}</span>`
                            } 
                        },
                        { text: 'Descripción Accion ',  dataField: 'cod_a', width:'50%', align:'center', cellsrenderer: function(row, column, value, rowData){
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
        refreshList: function(){
            $.get(globalSP.urlApi + 'lista_pmraPlan', {p:globalSP.idPlanActivo}, function(resp) {
                ctxpmra.source.localdata = resp.data;
                ctxpmra.dataTable.jqxDataTable("updateBoundData");
                ctxpmra.estadistics();
                 // $('[data-toggle="tooltip"]').tooltip();  
                  // $(".sp_res").tooltip({container: "#planificacion_pmra"});  
                // $(".sp_res").data
            })   
        },
        showModal : function(){
            $(".state-error").removeClass("state-error")
            $("#form-pmra em").remove();
                $.magnificPopup.open({
                removalDelay: 500, //delay removal by X to allow out-animation,
                focus: '#pmra_id_pilar',
                items: {
                    src: "#modal_pmra"
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
        getDataForm: function(){
            var obj = {
                id : $("#id_pmra").val(),
                id_a: $("#pmra_id_a").val(),
                _token : $('input[name=_token]').val(),
                id_plan : globalSP.idPlanActivo,
                p: globalSP.idPlanActivo
            }
            return obj;
        },
        nuevo: function(){
            $(".tituloModal span").html(`Agregar articulación pdes`);
            $('#form-pmra input:text').val('');
            $("select").val('').change();
            ctxpmra.showModal();
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
            var reglasVal = {
                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    rules: {
                        pmra_id_p: { required: true },
                        pmra_id_m: { required: true },
                        pmra_id_r: { required: true },
                        pmra_id_a: { required: true },
                    },

                    messages:{
                        pmra_id_p:  { required: 'Falta pilar' },
                        pmra_id_m:  { required: 'Falta meta' },
                        pmra_id_r:  { required: 'Falta resultado' },
                        pmra_id_a:  { required: 'Debe seleccionar una acción' },
                    },

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
                        ctxpmra.saveData();
                    }
            }
            return reglasVal; 
        }, 
        saveData: function(){
            var obj = ctxpmra.getDataForm();
            $.post(globalSP.urlApi + 'save_pmra', obj, function(resp){
                ctxpmra.refreshList();
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
                    $.post(globalSP.urlApi + 'delete_pmra', {'id': id, _token : $('input[name=_token]').val(), }, function(res){
                        new PNotify({
                                  title: !res.error ? 'Eliminado' : 'Error!!' ,
                                  text: res.msg,
                                  shadow: true,
                                  opacity: 1,
                                  addclass: noteStack,
                                  type: !res.error ? "success" : 'danger',
                                  stack: Stacks[noteStack],
                                  width: findWidth(),
                                  delay: 2000
                              });
                        ctxpmra.refreshList();
                    });
                });
        },
        estadistics: function(){
            $("#sp_est_pmra").html( ctxpmra.source.localdata.length);
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
                html += `<div class="panel-body"> 
                                <div class="col-sm-3">
                                    <img width="50" class=""  src="/img/${pilar.logo_p}"/>
                                    <span class="badge badge-hero bg-system dark">${elem.length}</span> 
                                </div> 
                                <div class="col-sm-9"><span><b>${pilar.nombre_p}</b>- ${pilar.desc_p}</span>  </div>
                            </div>`;               
            });
             $("#sp_est_pilar_acciones").html(html);
        }

    }
}

    var ctxprog = {
        dataTable : $("#dt_prog"),
        source : {},


        fillDataTable : function() {
            $.get(globalSP.urlApi + 'listaprogramacion', {p : globalSP.idPlanActivo}, function(resp)
            {
                ctxprog.source =
                {
                    dataType: "json",
                    localdata: resp.data,
                    dataFields: [
                        { name: 'id', type: 'number' },
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
                    // ready: function () {   
                    //     $(".contentdt_pmra").css({"z-index": "100", 'font-size':'9px'
                    //     });  
                    // },
                    source: dataAdapter,
                    altRows: false,
                    sortable: true,
                    width: "100%",
                    filterable: false,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    localization: getLocalization('es'),
                    columns: [
                        // { text: 'Pilar',  dataField: 'cod_p',align:'center',
                        //         cellsrenderer: function(row, column, value, rowData){
                        //             return `<div class="col-sm-4"> <img width="30" class="img-circle"  src="/img/${rowData.logo_p}"/> </div> <div class="col-sm-8"><b>  ${rowData.cod_p}</b> </div>`
                        //     } 
                        // },                        
                        { text: '-', width: 60, align:'center',  cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<img width="30" class="img-circle"  src="/img/${rowData.logo_p}" data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_p}</b> - ${rowData.desc_p}" /> `
                            } 
                        },
                        { text: 'Pilar ', dataField: 'cod_p', align:'center', cellsalign: 'center',  cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_p}</b> - ${rowData.desc_p}">${rowData.cod_p}</span>`;
                            } 
                        },
                        { text: 'Meta ', align:'center', cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_m}</b> - ${rowData.desc_m}">${rowData.cod_m}</span>`
                            } 
                        },
                        { text: 'Resultado ',  dataField: 'cod_r', cellsalign: 'center', align:'center', cellsrenderer: function(row, column, value, rowData){
                                return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_r}</b> - ${rowData.desc_r}">${rowData.cod_r}</span>`
                            } 
                        },
                        { text: '', width: 40, cellsalign: 'center', cellsrenderer: function (row, column, value, rowData) {
                                return `<a href="javascript:void(0)"  class="m-l-10 m-r-10 m-t-10 sel_add" title="Agregar indicador y programación dentro en la articulación de resultado " ><i class="fa fa-plus-circle fa-2x text-success "></i></a>`;
                            }
                        }, 
                        { text: 'Indicadores de resultado y su Programación ' + ( (ctxprog.source.localdata.length>0) ? ` para ${ctxprog.source.localdata[0].gestion_ini} -  ${ctxprog.source.localdata[0].gestion_fin} ` : '' ),   width:'65%', align:'center', 
                            cellsrenderer: function(row, column, value, rowData){
                                html = '';
                                var headGestiones = '';
                                for(i=rowData.gestion_ini; i<= rowData.gestion_fin; i++)
                                    headGestiones += `<th>${i}</th>`;

                                if(rowData.indicadores.length>0){ 
                                    var html = `<table class="table table-bordered table-condensed ">
                                                    <thead><tr class="success"> <th>Indicador de Res.</th> <th>Variable</th> <th>Unidad</th> <th>L. Base</th> <th>Alcance</th>${headGestiones} <th></th> </tr> </thead>
                                                    <tbody>`;

                                    rowData.indicadores.forEach(function(ind){
                                        iprow = '';
                                        ind.programacion.forEach(function(ip){
                                            iprow += `<td>${ip.dato}</td>`;
                                        });

                                        html += `<tr>
                                                    <td>${ind.nombre_indicador}</td> <td>${ind.variable}</td> <td>${ind.unidad}</td> <td>${ind.linea_base}</td> <td>${ind.alcance}</td> ${iprow} <td><a href="javascript:void(0)"  class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="fa fa-minus-circle text-danger "></i></a></td>
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
        refreshList: function(){
            $.get(globalSP.urlApi + 'listaprogramacion', {p:globalSP.idPlanActivo}, function(resp) {
                ctxprog.source.localdata = resp.data;
                ctxprog.dataTable.jqxDataTable("updateBoundData");
                ctxprog.estadistics();
                 // $('[data-toggle="tooltip"]').tooltip();  
                  // $(".sp_res").tooltip({container: "#planificacion_pmra"});  
                // $(".sp_res").data
            })   
        },
        showModal : function(){
            $(".state-error").removeClass("state-error")
            $("#form_prog em").remove();
                $.magnificPopup.open({
                removalDelay: 500, //delay removal by X to allow out-animation,
                focus: '',
                items: {
                    src: "#modal_prog"
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
        getDataForm: function(){
            var obj = {
                id_plan_articulacion_pdes: $("#id_plan_articulacion_pdes").val(),
                id_arti_indicador : $("#id_arti_indicador").val(),
                nombre_indicador :$("#nombre_indicador_res").val(),
                idp_unidad: $("#idp_unidad_res").val(),
                id_diagnostico: $("#variable_res").val(),
                variable: $("#variable_res  option:selected").text(),
                linea_base : $("#linea_base_res").val(),
                alcance: $("#alcance_res").val(),
                _token : $('input[name=_token]').val(),
                id_plan : globalSP.idPlanActivo,
                p: globalSP.idPlanActivo
            }
            var indProgramacion = [];
            for(var i = globalSP.planActivo.gestion_inicio; i <= globalSP.planActivo.gestion_fin; i++){
                var prog = {};
                prog.gestion = i;
                prog.dato =  $("#form_prog .d" + i).val();
                indProgramacion.push(prog);
            }     
            obj.indicadoresProgramacion = indProgramacion;
            return obj;
        },
        // setDataForm: function(obj){
        //     $("#id_pol").val(obj.id);
        //     $("#politica").val(obj.politica);
        //     $("#ids_pilares").val(obj.ids_pilares).change();
        // },
        nuevo: function(){
            $(".tituloModal span").html(`Agregar Programacion de Resultado`);
            $('#form_prog input:text, #form_prog textarea ').val('');
            $("select").val('').change();
            var rowSelected = ctxprog.dataTable.jqxDataTable('getSelection')[0];
            $("#id_plan_articulacion_pdes").val(rowSelected.id);
            $("#pmr_prog").html(`<b>${rowSelected.cod_p} . ${rowSelected.cod_m} . ${rowSelected.cod_r}</b>`);
            $("#pilar_prog").html(`<b>${rowSelected.nombre_p}</b> - ${rowSelected.desc_p}`);
            $("#meta_prog").html(`<b>${rowSelected.nombre_m}</b> - ${rowSelected.desc_m}`);
            $("#resultado_prog").html(`<b>${rowSelected.nombre_r}</b> - ${rowSelected.desc_r}`);
            ctxprog.showModal();
        },
        editar: function(){
            // var rowSelected = ctxprog.dataTable.jqxDataTable('getSelection');
            // if(rowSelected.length > 0)
            // {
            //     var rowSel = rowSelected[0]; 
            //     ctxprog.setDataForm(rowSel);
            //     $("#tituloModal span").html(`Modificar ${funciones.tipoPolitica()}`);
            //     ctxprog.showModal();
            // }
            // else{
            //     swal("Seleccione el registro para modificar.");
            // }
        },
        eliminar: function(){
            // var rowSelected = ctxprog.dataTable.jqxDataTable('getSelection');
            // if(rowSelected.length > 0)
            // {
            //     var rowSel = rowSelected[0];
            //     ctxprog.delete(rowSel.id);             
            // }
            // else{
            //     swal("Seleccione el registro que desea eliminar.");
            // }
        },
        validateRules: function(){
            var reglasVal = {
                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    rules: {
                        nombre_indicador_res: { required: true },
                        idp_unidad_res: { required: true },
                        linea_base_res: { required: true },
                        alcance_res: { required: true },
                    },

                    messages:{
                        nombre_indicador_res:  { required: 'Campo requerido' },
                        idp_unidad_res:  { required: 'Campo requerido' },
                        linea_base_res:  { required: 'Campo requerido' },
                        alcance_res:  { required: 'Campo requerido' },
                    },

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
                        ctxprog.saveData();
                    }
            }
            return reglasVal; 
        }, 
        saveData: function(){
            var obj = ctxprog.getDataForm();
            $.post(globalSP.urlApi + 'saveprogramacion', obj, function(resp){
                ctxprog.refreshList();
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
                    $.post(globalSP.urlApi + 'delete_pmra', {'id': id, _token : $('input[name=_token]').val(), }, function(res){
                        new PNotify({
                                  title: !res.error ? 'Eliminado' : 'Error!!' ,
                                  text: res.msg,
                                  shadow: true,
                                  opacity: 1,
                                  addclass: noteStack,
                                  type: !res.error ? "success" : 'danger',
                                  stack: Stacks[noteStack],
                                  width: findWidth(),
                                  delay: 1400
                              });
                        ctxprog.refreshList();
                    });
                });
        },
        estadistics: function(){
            var total_indicadores = ctxprog.source.localdata.reduce(function(carry, elem, indice, vector){
                                      return carry + elem.indicadores.length;
                                    }, 0);
            $("#sp_est_prog").html( 'N° de indicadores' + total_indicadores);

            var pils = _.groupBy(ctxprog.source.localdata, function(elem){
                return elem.cod_p;
            });
            console.log(pils)
            var html = `<div class="panel-heading">
                                        <span class="panel-icon"><i class="glyphicons glyphicons-bank"></i>
                                        </span>
                                    </div>`;
            _.mapObject(pils, function(elem, key){
                var pilar = elem[0];
                html += `<div class="panel-body"> 
                                <div class="">
                                    <img width="50" class="" data-toggle="tooltip" data-container="body" data-html="true" title="<b>${pilar.nombre_p}</b> - ${pilar.desc_p}" src="/img/${pilar.logo_p}"/>
                                    <span class="badge badge-hero  bg-system dark" data-toggle="tooltip" data-container="body" data-html="true" title="N° de resultados asociados ${elem.length}">${elem.length}</span> 
                                    <span class="badge badge-hero bg-primary dark" style="  top: -12px; margin-left: 20px;" data-toggle="tooltip" data-container="body" data-html="true" title="N° de indicadores ${elem.length}">${elem.length}</span> 
                                </div> 
                            </div>`;               
            });
             $("#sp_est_pilar_res").html(html);
        }

    }

    var init = (function(){
        var gerera_opciones = function(arr){
            var html = '';
            arr.forEach(function(op){
                html += `<option value="${op.id}">${op.nombre} - ${op.descripcion} </option>`;
            });            
            return html;
            return html;
        }

        genera_inputgestiones = function(){
            var html='';
            $.get(globalSP.urlApi + "getparametros/periodo_plan", function(res){    
                periodo = res.data[0];
                gestion_ini = periodo.valor;
                gestion_fin = periodo.valor2;
                for(var gt = gestion_ini; gt <= gestion_fin; gt++)
                { 
                    html += `<tr>
                        <td class="fs17 text-center w30">
                            <span class="fa fa-newspaper-o text-info"></span>
                        </td>
                        <td class="va-m fw600 text-muted">${gt}</td>
                        <td class="fs14 fw700 text-muted text-right">
                            <label for="mod_dato" class="field prepend-icon">
                                <input type="text" name="g${gt}"  class="hidden g${gt}" value="${gt}" >
                                <input type="text" name="d${gt}"  class="gui-input d${gt}" placeholder="Valor">
                                <label for="d${gt}" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                </label>
                            </label>
                        </td>
                    </tr>`;
                }
                $("#gestiones_prog tbody").html(html);
                return html;
            })
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
            });

            /* De los submenus de arriba */            
            $("#submenus-planificacion a").click(function(){
                index = $(this).attr('id');
                planif_submenu_activo(index);
            });

            /* De los Tool tips con data-toggle */
            $("body").on('mouseover', '[data-toggle="tooltip"]', function(){
                $(this).tooltip('show')
            });
            $("body").on('mouseout', '[data-toggle="tooltip"]', function(){
                $(this).tooltip('hide')
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
            $("#form-pmra").validate(ctxpmra.validateRules());

            $("#pmra_nuevo").click(function(){
                ctxpmra.nuevo();
            });

            $("#planificacion_pmra").on('click','.sel_delete, #pmra_eliminar', function(){
                ctxpmra.eliminar();
            });

            $(".sp_cancelar").click(function(){
                $.magnificPopup.close();
            });          
        }

        var listeners_prog = function()
        {
                      
            variablesDiagnostico = [];
            metricas = [];

            /* select 2 */  
            $.get(globalSP.urlApi + "getparametros/metricas", function(res){
                metricas = res.data;
                var html = '';
                res.data.forEach(function(op){
                    html += `<option value="${op.id}">${op.codigo} - ${op.nombre} </option>`;
                });         
                $("#idp_unidad_res").html(html);
                $("#idp_unidad_res").select2({
                    placeholder: 'Unidad de medida ...',
                });
            });



            $.get(globalSP.urlApi + 'listvariables_lb', {p : globalSP.idPlanActivo}, function(res){
                var html = '';
                variablesDiagnostico = res.data;
                res.data.forEach(function(op){
                    html += `<option value="${op.id_diagnostico}">${op.variable}</option>`;
                });
                $("#variable_res").html(html);
                $("#variable_res").select2({
                    placeholder: 'Variable ...',
                }); 
            });

            $("#variable_res").change(function() {
                varsel = _.find(variablesDiagnostico, function(elem){ return elem.id_diagnostico == $("#variable_res").val(); });
                if(varsel){ 
                    $("#idp_unidad_res").val(varsel.idp_unidad).change();
                    $("#linea_base_res").val(varsel.dato);
                }
            });
            

            /* ---------- Contexto programacion ---------------------------------------------------------*/
            ctxprog.fillDataTable();
            $("#form_prog").validate(ctxprog.validateRules());

            $("#planificacion_prog").on('click', '.sel_add', function(){
                ctxprog.nuevo()
            });

            $("#planificacion_prog").on('click', '.sel_delete', function(){
                ctxprog.eliminar()
            });

            // $("#form_prog .sp_save").click(function(){
            //     console.log('c')
            //     ctxprog.saveData()
            // })
            genera_inputgestiones();
        }

        listeners();
        listeners_pmra();
        listeners_prog();

    })();

    globalSP.activarMenu(globalSP.menu.Planificacion);
    globalSP.cargarGlobales();
    globalSP.setBreadcrumb('Planificación', 'Planificación');
    planif_submenu_activo(2);




 
})






</script>

@endpush
