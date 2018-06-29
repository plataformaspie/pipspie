@extends('layouts.moduloplanificacion')
@section('headerIni')
  <link rel="stylesheet" type="text/css" href="{{ asset('sty-mode-2/vendor/editors/summernote/summernote.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('sty-mode-2/vendor/editors/summernote/summernote-bs3.css') }}">
@endsection
@section('header')
  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />
  <link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="/plugins/bower_components/select2/dist/css/select2.min.css" type="text/css"/>
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
.dina4 {
    width: auto;
    max-width: 210mm;
    padding: 20px 60px;
    border: 1px solid #D2D2D2;
    background: #fff;
    margin: 10px auto;
}

</style>

@endsection

@section('title-topbar')
<div class="topbar-left">
    <ol class="breadcrumb">
        <li class="crumb-active">
            <a href="dashboard.html">Enfoque Político</a>
        </li>
        <li class="crumb-icon">
            <a href="/sistemasisgri/index">
                <span class="glyphicon glyphicon-home"></span>
            </a>
        </li>
        <li class="crumb-link">
            <a href="/sistemasisgri/index">Home</a>
        </li>
        <li class="crumb-trail">Enfoque Político</li>
    </ol>
</div>
<div class="topbar-right">
    <div class="ml15 ib va-m" id="toggle_sidemenu_r">
        <a href="#" class="pl5"> <i class="fa fa-sign-in fs22 text-primary"></i>
            <span class="badge badge-hero badge-danger">3</span>
        </a>
    </div>
</div>
@endsection

@section('content')
    <!-- ===========================================    begin: .tray-left         ========================================================== -->
    <aside class="tray tray-left tray250 va-t pn" data-tray-height="match">

        <div class="animated-delay p20" data-animate='["300","fadeIn"]'>
            <h4 class="mt5 mb20"> Completar datos </h4>
            <ul class="fs14 list-unstyled list-spacing-10 mb10 pl5">
                <li>
                    <i class="fa fa-exclamation-circle text-warning fa-lg pr10"></i>
                    Llene la información solicitada por el sistema
                </li>
            </ul>
        </div>
        <div id="nav-spy" >
            <ul class="nav tray-nav tray-nav-border custom-nav-animation affix " data-spy="affix" data-offset-top="180" style="width: 269px">
                <li class="active">
                    <a href="#spy1">
                    <span class="fa fa-newspaper-o fa-lg"></span>  Enfoque Político</a>
                </li>
                <li>
                    <a href="#spy2">
                    <span class="glyphicon glyphicon-tasks fa-lg"></span>  Atribuciones <span class="sp_atr badge bg-green">3</span></a>
                </li>
            </ul>
        </div>

    </aside>
    <!-- end: .tray-left -->

    <!--  ===========================================    begin: .tray-center    =============================================================== -->
    <div class="tray tray-center p40 va-t posr">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs">
                            <span class="fa fa-newspaper-o"></span>  Enfoque Político
                            <button id="editar" type="button" class="btn btn-sm btn-warning dark m5 btn-alt pull-right"><i class="fa fa-edit text-warning"></i> Modificar</button>
                            <input type="hidden" name="id_enfoque_politico">
                        </div>
                    </div>
                    <div class="panel-body pn">
                        <div  class="dina4 " style="max-height: 500px; min-height: 200px; overflow-y: scroll;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-visible" id="spy2">
                    <div class="panel-heading">
                        <div class="panel-title hidden-xs">
                            <span class="glyphicon glyphicon-tasks"></span> Atribuciones principales del sector
                        </div>
                    </div>
                    <div class="panel-body pn">
                        <div class="row">
                            <div id="div_atribuciones" class="col-md-12" >
                                <button id="atr_nuevo" type="button" class="btn btn-sm btn-success dark m5 btn-alt  "><i class="glyphicon glyphicon-plus-sign text-success"></i> Agregar atribución</button>
                                <button id="atr_editar" type="button" class="btn btn-sm btn-warning dark m5  btn-alt  "><i class="fa fa-edit glyphicon-plus-sign text-warning"></i> Editar</button>
                                <button id="atr_elimar" type="button" class="btn btn-sm btn-danger dark m5 btn-alt   "><i class="glyphicon glyphicon-minus-sign text-danger"></i> Eliminar</button>
                                
                                <div id="dtAtribuciones"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
      <!-- end: .tray-center -->


    <!--  ===========================================      Modales   ========================================================================= -->
    <!-- -----------------------------------------          Modal Enfoque Politico --------------------------------------------------- -->
    <div id="modal-ep"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title"><i class="fa fa-pencil"></i>Enfoque Politico</span>
            </div>
            <!-- end .panel-heading section -->
            <form method="post" action="/" id="form-ep" name="form-ep">
                <input type="hidden" name="mod_id" id="mod_id" value="">

                <div class="panel-body mnw700 of-a">
                    <div class="row">
                        <!-- Icon Column -->
                        <div class="col-md-12 ">
                          <div class="panel-body p20 pb10">
                              <div class="tab-content pn br-n">
                                <section class="wizard-section">
                                  <div class="section">
                                       <div class="panel">
                                            <div class="panel-body pn of-h">
                                                <textarea id="txt_enfoque_politico" class="summernote required" name="txt_enfoque_politico"></textarea>
                                            </div>
                                        </div>
                                  </div>
                                </section>
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary">Guardar</button>
                    <a href="#"  id="cancelar"  class="button btn-danger ml25">Cancelar</a>
                </div>
            </form>
        </div>
        <!-- end: .panel -->
    </div>

    <!-- -----------------------------------------          Modal Atribuciones Pilares --------------------------------------------------- -->
    <div id="modal-atr"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title" id="tituloModal"><i class="fa fa-pencil"></i> <span>Modificar Enfoque Politico</span></span>
            </div>
            <!-- end .panel-heading section -->
            <form method="post" action="/" id="form-atr" name="form-atr">
                <input type="hidden" name="mod_id" id="mod_id" value="">

                <div class="panel-body mnw700 of-a">
                    <div class="row">

                            <input class="hidden" name="id_atr" id="id_atr" >
                            <div class="row">
                                <div class=" pl5 br-r mvn15">
                                    <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Atribuciones<small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>
                                    <div class="section">
                                        <label class="field-label" for="atribucion">Atribución directa del sector</label>
                                        <label for="atribucion" class="field prepend-icon">
                                            <input type="text" class="gui-input" id="atribucion" name="atribucion" placeholder="Atribución directa/importante ">
                                            <label for="atribucion" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="section">
                                        <label class="field-label" for="atribucion">Pilares</label>
                                        <label class="field select">
                                            <select id="ids_pilares" name="ids_pilares" class="required" multiple="multiple"  style="width:100%;">
                                                {{-- <option value="">...</option> --}}
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
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25">Cancelar</a>
                </div>
            </form>
        </div>
        <!-- end: .panel -->
    </div>

@endsection

@push('script-head')

<script type="text/javascript" src="{{ asset('sty-mode-2/vendor/editors/summernote/summernote.min.js') }}"></script>
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
<script type="text/javascript">
$(function(){

    var ctxEP = {
        epObj : {},
        input_idEnfoqueP: $('input[name=id_enfoque_politico]'),

        cargarEnfoquePolitico: function(){

            $.get(globalSP.urlApi + "getEnfoque", {p : globalSP.idPlanActivo}, function(res){      
                ctxEP.epObj = res.data;
                var enfoqueTexto = (res.data.enfoque_politico) ? res.data.enfoque_politico : '<span class="text-danger"> Enfoque Político No Definido  !!!!!!!! </span>';
                $(".dina4").html(enfoqueTexto);
                ctxEP.input_idEnfoqueP.val(ctxEP.epObj ? ctxEP.epObj.id : '');
            } )
        },

        inicializaSummerNote: function(){
            $('.summernote').summernote({
                height: 350, //set editable area's height
                focus: false, //set focus editable area after Initialize summernote
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ],
                oninit: function() {},
                onChange: function(contents, $editable) {},

            });
        },
        getFormData: function(){
            var objEnfoque = {
                id: this.input_idEnfoqueP.val(),
                enfoque_politico : $("#txt_enfoque_politico").val(),
                id_plan: globalSP.idPlanActivo,
                p:  globalSP.idPlanActivo,
                _token : $('input[name=_token]').val(),                
            }
            return objEnfoque;
        },
        setFormData: function(obj){
            if(ctxEP.input_idEnfoqueP.val() == '')
                $('#txt_enfoque_politico').val('');
            else
                $('#txt_enfoque_politico').val(obj.enfoque_politico);
        },
        showmodal: function(idModal){
            $(".state-error").removeClass("state-error")
            $("#form-ep em").remove();
                    // Inline Admin-Form example
            $.magnificPopup.open({
                removalDelay: 500, //delay removal by X to allow out-animation,
                focus: '#focus-blur-loop-select',
                items: {
                    src: "#" + idModal
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
        editar: function(){
            ctxEP.setFormData(ctxEP.epObj);
            ctxEP.showmodal('modal-ep');
        },
        validateRules: function(){
            var reglasVal = { 
                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",
                    rules: { 
                        txt_enfoque_politico: { required: true },
                    },
                    messages:{
                        txt_enfoque_politico: { required: 'Debe ingresar el enfoque político' },
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
                        } 
                        else {
                            error.insertAfter(element.parent());
                        }
                    },
                    submitHandler: function(form) {
                        ctxEP.save();
                    }
            };
            return reglasVal;
        },
        save: function(){
            var objEnfoque = this.getFormData();
            $.post(globalSP.urlApi + 'saveEnfoque', objEnfoque, function(resp){
                ctxEP.epObj = resp.data;
                var enfoqueTexto = ctxEP.epObj.enfoque_politico
                $(".dina4").html(enfoqueTexto);
                ctxEP.input_idEnfoqueP.val(ctxEP.epObj ? ctxEP.epObj.id : '');

                new PNotify({
                            title: (resp.estado == 'success') ? (resp.accion=='insert' ? 'Enfoque Político Creado' : 'Enfoque Político Modificado') : 'Error!!',
                            text: resp.msg,
                            shadow: true,
                            opacity: 1,
                            addclass: noteStack,
                            type: (resp.estado == 'success') ? "success" : "danger",
                            stack: Stacks[noteStack],
                            width: findWidth(),
                            delay: 1500
                        });
                
            });  
            $.magnificPopup.close();          
        }
    }


    var atr = {
        dataTable : $("#dtAtribuciones"),
        source : {},

        fillAtr : function() {
            $.get(globalSP.urlApi + 'listAtribucionesPilares', {p:globalSP.idPlanActivo}, function(resp)
            {
                atr.source =
                {
                    dataType: "json",
                    localdata: resp.data,
                    dataFields: [
                        { name: 'id', type: 'number' },
                        { name: 'atribucion', type: 'string' },
                        { name: 'ids_pilares', type: 'string' },
                        { name: 'pilares', type: 'object' },
                    ],
                    id: 'id',
                };
                var dataAdapter = new $.jqx.dataAdapter(atr.source);
                var editDelRenderer = function (row, columnfield, value, defaulthtml, rowData) {
                    html = '<a href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar " ><i class="fa fa-edit text-warning fa-lg"></i></a>\
                            <a href="#"  class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="glyphicon glyphicon-minus-sign text-danger "></i></a> ' 
                    return html;
                };
                atr.dataTable.jqxDataTable({
                    source: dataAdapter,
                    altRows: false,
                    sortable: true,
                    width: "100%",
                    filterable: false,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    localization: getLocalization('es'),
                    columns: [
                        { text: 'Atribuciones', dataField: 'atribucion', align:'center'},
                        { text: 'Pilares Asociados', dataField: 'id', align:'center',
                                cellsrenderer: function(row, column, value, rowData){
                                    var pilares = rowData.pilares;
                                    html = "";
                                    pilares.forEach(function(pilar){
                                        html += "<div class='br-b m10 pv5'><b>" + pilar.nombre + "</b> - "+ pilar.descripcion + "</div>" 
                                    });
                                   return html;
                            } 
                        },
                        { text: ' ', width: 50, cellsrenderer: editDelRenderer},
                    ]
                });
            });
        },
        refreshList: function(){
            $.get(globalSP.urlApi + 'listAtribucionesPilares', {p:globalSP.idPlanActivo}, function(resp) {
                atr.source.localdata = resp.data;
                atr.dataTable.jqxDataTable("updateBoundData");
            })   
        },
        initCombos : function(){
            $.get(globalSP.urlApi + "getpilares", function(res){
                opts = res.data;
                opts.forEach(function(op){
                    $("#ids_pilares").append('<option value="' + op.id + '">' + op.nombre + ' - ' + op.descripcion + '</option>');
                });
                // $("#ids_pilares").select2()
                $("#ids_pilares").select2({
                    placeholder: 'Seleccione los pilares asociados a la Atribución',
                    dropdownParent: $('#form-atr'),
                    cache: false,
                    language: "es",
                    templateSelection: function (val) {
                        return $("<div class='list-group-item' style='width:100%;' title ='" + val.text + "'>" +val.text + "</div>");
                    },
                });
            })
        },
        showModal : function(){
            $(".state-error").removeClass("state-error")
            $("#form-atr em").remove();
                    // Inline Admin-Form example
                $.magnificPopup.open({
                removalDelay: 500, //delay removal by X to allow out-animation,
                focus: '#focus-blur-loop-select',
                items: {
                    src: "#modal-atr"
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
            var objAtr = {
                id: $("#id_atr").val(),
                atribucion: $("#atribucion").val(),
                ids_pilares: $("#ids_pilares").val(),
                _token : $('input[name=_token]').val(),
                id_plan : globalSP.idPlanActivo,
                p: globalSP.idPlanActivo
            }
            return objAtr;
        },
        setDataForm: function(obj){
            $("#id_atr").val(obj.id);
            $("#atribucion").val(obj.atribucion);
            $("#ids_pilares").val(obj.ids_pilares).change();
            // $("#ids_pilares").select2('val', obj.ids_pilares);
        },
        nuevo: function(){
            $("#tituloModal span").html("Agregar una atribución");
            $('#form-atr input:text').val('');
            $("#ids_pilares").val('').change();
            // $("#ids_pilares").select2('val', '').change();
            atr.showModal();
        },
        editar: function(){
            var rowSelected = atr.dataTable.jqxDataTable('getSelection');
            if(rowSelected.length > 0)
            {
                var rowSel = rowSelected[0]; 
                atr.setDataForm(rowSel);
                $("#tituloModal span").html("Modificar Atribución");
                atr.showModal();
            }
            else{
                swal("Seleccione el registro para modificar.");
            }
        },
        eliminar: function(){
            var rowSelected = atr.dataTable.jqxDataTable('getSelection');
            if(rowSelected.length > 0)
            {
                var rowSel = rowSelected[0];
                atr.deleteAtribucion(rowSel.id);             
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
                        atribucion: { required: true },
                        ids_pilares:  { required: true },
                    },

                    messages:{
                        atribucion: { required: 'Seleccione el tipo de plan' },
                        ids_pilares:  { required: 'Seleccionar los pilares asociados a la atribución' },
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
                        atr.saveData();
                    }
            }
            return reglasVal; 
        }, 
        saveData: function(){
            var objAtr = atr.getDataForm();
            $.post(globalSP.urlApi + 'saveAtribucion', objAtr, function(resp){
                atr.refreshList();
                new PNotify({
                            title: resp.estado == 'success' ? 'Guardado' : 'Error',
                            text: resp.msg,
                            shadow: true,
                            opacity: 1,
                            addclass: noteStack,
                            type: (resp.estado == 'success') ? "success" : "danger",
                            stack: Stacks[noteStack],
                            width: findWidth(),
                            delay: 1500
                        });
            });
            $.magnificPopup.close();   
        },
        deleteAtribucion: function(id){
            swal({
                  title: "Está seguro de eliminar la atribucion?",
                  text: "No podrá recuperar este registro!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Si, eliminar!",
                  closeOnConfirm: true
                }, function(){
                    $.post(globalSP.urlApi + 'deleteAtribucion', {'id': id, _token : $('input[name=_token]').val(), }, function(res){
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
                        atr.refresh();
                    });
                });
        },

    }

    //-------------------- del Enfoque politico --------------------------------
    globalSP.activarMenu(globalSP.menu.EnfoquePolitico);
    globalSP.cargarGlobales();
    ctxEP.cargarEnfoquePolitico();
    ctxEP.inicializaSummerNote();

    $("#form-ep").validate(ctxEP.validateRules());

    $("#editar").click(function(){
        ctxEP.editar();
    });

    $("#cancelar").click(function(){
        $.magnificPopup.close();
    });

    //-------------------- de las atribuciones --------------------------------
    atr.fillAtr();
    atr.initCombos();
    $("#form-atr").validate(atr.validateRules());

    $("#atr_nuevo").click(function(){
        atr.nuevo();
    });

    $("#div_atribuciones").on('click','.sel_edit, #atr_editar', function(){
        atr.editar();
    });

    $("#div_atribuciones").on('click','.sel_delete, #atr_elimar', function(){
        atr.eliminar();
    });

    $("#atr_cancelar").click(function(){
        $.magnificPopup.close();
    });


  
})




        

$(document).keydown(function(tecla){
    if (tecla.keyCode == 113) {}
});





</script>

@endpush
