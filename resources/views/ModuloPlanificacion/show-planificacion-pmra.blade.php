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
                        <a href="#" id="1">Articulación con la acción </a>
                    </li>
                    <li id="planif_submenu_2">
                        <a href="#"  id="2">Programación del Resultado</a>
                    </li>
                    <li id="planif_submenu_3">
                        <a href="#"  id="3">Planificación de acciones</a>
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
            <div class="col-md-12 slick-slide" id="programacion_pmr">
                <div class="panel panel-visible" >
                    <div class="panel-heading  bg-dark ">
                        <div class="panel-title ">
                            <div>
                                <i class="glyphicon glyphicon-tasks" ></i><span class="sp_titulo_panel">Programación del Resultado</span><span id="sp_est_pmra" class="ml5 badge bg-dark dark"></span>                                 
                                <span class="pull-right">
                                    <button id="prog_nuevo" type="button" class="btn btn-sm btn-success dark m5 br4" data-toggle="tooltip" title=""><i class="fa fa-plus-circle text-white"></i> Agregar </button>
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
                                <div id="dt_prog"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--  ===========================================   Planificacion Acciones e indicadores ================================== -->
            <div class="col-md-12 slick-slide" id="planificacion_ind">
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
            </div>

        </div>
    </div>
      <!-- end: .tray-center -->




    <!-- -----------------------------------------          Modal PMRA  --------------------------------------------------- -->
    <div id="modal_pmra"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white" id="tituloModal"><i class="fa fa-pencil"></i> <span>__</span></span>
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
        // setDataForm: function(obj){
        //     $("#id_pol").val(obj.id);
        //     $("#politica").val(obj.politica);
        //     $("#ids_pilares").val(obj.ids_pilares).change();
        // },
        nuevo: function(){
            $("#tituloModal span").html(`Agregar articulación pdes`);
            $('#form-pmra input:text').val('');
            $("select").val('').change();
            ctxpmra.showModal();
        },
        // editar: function(){
        //     var rowSelected = ctxpmra.dataTable.jqxDataTable('getSelection');
        //     if(rowSelected.length > 0)
        //     {
        //         var rowSel = rowSelected[0]; 
        //         ctxpmra.setDataForm(rowSel);
        //         $("#tituloModal span").html(`Modificar ${funciones.tipoPolitica()}`);
        //         ctxpmra.showModal();
        //     }
        //     else{
        //         swal("Seleccione el registro para modificar.");
        //     }
        // },
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
        // setDataForm: function(obj){
        //     $("#id_pol").val(obj.id);
        //     $("#politica").val(obj.politica);
        //     $("#ids_pilares").val(obj.ids_pilares).change();
        // },
        nuevo: function(){
            $("#tituloModal span").html(`Agregar articulación pdes`);
            $('#form-pmra input:text').val('');
            $("select").val('').change();
            ctxpmra.showModal();
        },
        // editar: function(){
        //     var rowSelected = ctxpmra.dataTable.jqxDataTable('getSelection');
        //     if(rowSelected.length > 0)
        //     {
        //         var rowSel = rowSelected[0]; 
        //         ctxpmra.setDataForm(rowSel);
        //         $("#tituloModal span").html(`Modificar ${funciones.tipoPolitica()}`);
        //         ctxpmra.showModal();
        //     }
        //     else{
        //         swal("Seleccione el registro para modificar.");
        //     }
        // },
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
                                  delay: 1400
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

    var init = (function(){
        var gerera_opciones = function(arr){
            var html = '';
            arr.forEach(function(op){
                html += `<option value="${op.id}">${op.nombre} - ${op.descripcion} </option>`;
            });            
            return html;
        }

        planif_submenu_activo =  function(index){
            $("#submenus-planificacion li").removeClass('active');            
            $("#planif_submenu_" + (index)).addClass('active');
            $("#planificacionContainer").slickGoTo(index-1);
        }

        var listeners_pmra =  function(){
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

            /* De los Tool tips con data-toggle */
            $("body").on('mouseover', '[data-toggle="tooltip"]', function(){
                $(this).tooltip('show')
            });

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

            /* del contexto de pmra */
            ctxpmra.fillDataTable();

            $("#form-pmra").validate(ctxpmra.validateRules());

            $("#pmra_nuevo").click(function(){
                ctxpmra.nuevo();
            });

            // $("#planificacion_pmra").on('click','.sel_edit, #pmra_editar', function(){
            //     ctxpmra.editar();
            // });

            $("#planificacion_pmra").on('click','.sel_delete, #pmra_eliminar', function(){
                ctxpmra.eliminar();
            });

            $(".sp_cancelar").click(function(){
                $.magnificPopup.close();
            });
        }

        listeners_pmra();

    })();

    globalSP.activarMenu(globalSP.menu.Planificacion);
    globalSP.cargarGlobales(function(){/* */});
    globalSP.setBreadcrumb('Planificación', 'Planificación');
    planif_submenu_activo(2);




 
})






</script>

@endpush
