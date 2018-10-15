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

</style>

@endsection


@section('content')


    <!--  ===========================================    begin: .tray-center    =============================================================== -->
    <div class="tray tray-center p40 va-t posr" id="div_gestion_documental">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy2">
                    <div class="panel-heading  bg-dark ">
                        <div class="panel-title hidden-xs">
                            <span class="glyphicons glyphicons-file_import"></span> Documentos <span class="sp_est_archivos"></span>
                            <span class="pull-right"><button id="arch_nuevo" type="button" class="btn btn-sm btn-success dark m5 br4"><i class="fa fa-plus-circle text-white"></i> Agregar Archivo</button></span>
                        </div>
                    </div>
                    <div class="panel-body pn">
                        <div class="row">
                            <div id="div_archivos" class="col-md-10" >
                                <div id="dtArchivos"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <!-- end: .tray-center -->




    <!-- -----------------------------------------          Modal  --------------------------------------------------- -->
    <div id="modal-arch"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white" id="tituloModal"><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <!-- end .panel-heading section -->
            <form method="post" action="javascript:void(0)"  id="form-arch" name="form-arch">
                <div class="panel-body mnw700 of-a">
                    <div class="row">
                        <input class="hidden" name="id" id="id" >
                        <div class="row">
                            <div class=" pl5 br-r mvn15">
                                <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Archivo  <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>

                                <div class="section">
                                    <label class="field-label" for="cite_respaldo">Subir Archivo <small>Solo archivos pdf</small></label>
                                    <label class="field prepend-icon file">
                                        <span class="button bg-warning br6"><i class="fa fa-search"></i> Buscar archivo</span>
                                        <input name="archivo" id="archivo" class="gui-file" type="file" accept="application/pdf">
                                        <input class="gui-input" id="archivo_visible" type="text" placeholder="Archivo ...">
                                        <label class="field-icon"><i class="fa fa-upload"></i>
                                        </label>
                                    </label>
                                </div>  

                                <div class="section">
                                    <label class="field-label" for="cite_respaldo">Cite de Respaldo</label>
                                    <label for="cite_respaldo" class="field prepend-icon">
                                        <input type="text" class="gui-input" id="cite_respaldo" name="cite_respaldo" placeholder="cite respaldo">
                                        <label for="cite_respaldo" class="field-icon"><i class="glyphicons glyphicons-paperclip"></i>
                                        </label>
                                    </label>
                                </div>

                                <div class="section">
                                    <label class="field-label" for="tipo_respaldo">Tipo Respaldo</label>
                                    <label for="tipo_respaldo" class="field select ">
                                        <select id="tipo_respaldo" name="tipo_respaldo" class="required"  style="width:100%;">
                                            <option value="">Seleccione</option>
                                            <option value="Resolución Ministerial">Resolución Ministerial</option>
                                            <option value="Resolución Administrativa">Resolución Administrativa</option>
                                            <option value="Dictamen">Dictamen</option>
                                        </select>
                                        <i class="arrow"> </i>
                                    </label>
                                </div>

                                <div class="section">
                                    <label class="field-label" for="descripcion">Descripcion</label>
                                    <label for="descripcion" class="field prepend-icon">
                                      <textarea class="gui-textarea" id="descripcion" name="descripcion" placeholder="Descripcion..." rows="2"></textarea>
                                      <label for="descripcion" class="field-icon"><i class="glyphicons glyphicons-list"></i>
                                      </label>
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
<script type="text/javascript">
$(function(){

    ctxdoc = {
        dataTable : $("#dtArchivos"),
        source : {},
        subir_archivo: false,
        fillData: function() {
            $.get(globalSP.urlApi + 'listDocumentos', {p : globalSP.idPlanActivo}, function(resp)
            {
                ctxdoc.source =
                {
                    dataType: "json",
                    localdata: resp.data,
                    dataFields: [
                        { name: 'id', type: 'number' },
                        { name: 'descripcion', type: 'string' },
                        { name: 'cite_respaldo', type: 'string' },
                        { name: 'tipo_respaldo', type: 'string' },
                        { name: 'archivo', type: 'string' },
                        { name: 'nombre_original', type: 'string' },
                    ],
                    id: 'id',
                };
                var dataAdapter = new $.jqx.dataAdapter(ctxdoc.source);
                var editDelRenderer = function (row, columnfield, value, defaulthtml, rowData) {
                    html = `<a href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar " ><i class="fa fa-edit fa-lg text-warning "></i></a>
                            <a href="#"  class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a>`
                    return html;
                };
                ctxdoc.dataTable.jqxDataTable({
                    source: dataAdapter,
                    altRows: false,
                    sortable: true,
                    width: "100%",
                    filterable: false,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    localization: getLocalization('es'),
                    columns: [
                        { text: 'Archivo', width: 60, align:'center',  cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return `<a href="/sp-files/gestion-documental/${rowData.archivo}" class=" fa fa-book fa-lg text-danger" target="blank"></a>`
                            } 
                        },
                        { text: 'Cite Respaldo ', dataField: 'cite_respaldo', align:'center'},
                        { text: 'Tipo ', dataField: 'tipo_respaldo', align:'center'},
                        { text: 'Descripcion ', dataField: 'descripcion', align:'center'},                        
                        { text: ' ', width: 50, cellsrenderer: editDelRenderer},
                    ]
                });
                ctxdoc.estadistics();
            });
        },
        refreshList: function(){
            $.get(globalSP.urlApi + 'listDocumentos', {p:globalSP.idPlanActivo}, function(resp) {
                ctxdoc.source.localdata = resp.data;
                ctxdoc.dataTable.jqxDataTable("updateBoundData");
                ctxdoc.estadistics()
            })   
        },
        estadistics: function(){
            var html = `<span class="badge bg-dark darker">${ctxdoc.source.localdata.length}</span>`
            $(".sp_est_archivos").html(html);
        },
        showModal : function(){
            $(".state-error").removeClass("state-error")
            $("#form-arch em").remove();
                $.magnificPopup.open({
                removalDelay: 500, //delay removal by X to allow out-animation,
                items: {
                    src: "#modal-arch"
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
            var formData = new FormData($("#form-arch")[0]);
            formData.append("_token", $('input[name=_token]').val());
            formData.append("id_plan", globalSP.idPlanActivo);
            formData.append("p", globalSP.idPlanActivo);
            formData.append("subir_archivo", ctxdoc.subir_archivo);
            return formData;
        },
        setDataForm: function(obj){
            $("#id").val(obj.id);
            $("#cite_respaldo").val(obj.cite_respaldo);
            $("#tipo_respaldo").val(obj.tipo_respaldo);
            $("#descripcion").val(obj.descripcion);
            $("#archivo_visible").val(obj.nombre_original);
        },
        nuevo: function(){
            ctxdoc.subir_archivo = false;
            $("#tituloModal span").html(`Agregar Documentos`);
            $('#form-arch input, #form-arch select, #form-arch textarea').val('');
            ctxdoc.showModal();
        },
        editar: function(){
            ctxdoc.subir_archivo = false;
            var rowSelected = ctxdoc.dataTable.jqxDataTable('getSelection');
            if(rowSelected.length > 0)
            {
                var rowSel = rowSelected[0]; 
                ctxdoc.setDataForm(rowSel);
                $("#tituloModal span").html(`Modificar`);
                ctxdoc.showModal();
            }
            else{
                swal("Seleccione el registro para modificar.");
            }
        },
        eliminar: function(){
            var rowSelected = ctxdoc.dataTable.jqxDataTable('getSelection');
            if(rowSelected.length > 0)
            {
                var rowSel = rowSelected[0];
                ctxdoc.delete(rowSel.id);             
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
                        archivo_visible: { required: true },
                        tipo_respaldo:  { required: true },
                    },

                    messages:{
                        archivo_visible: { required: 'Seleccione un archivo' },
                        tipo_respaldo:  { required: 'Debe Seleccionar el tipo de respaldo' },
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
                        ctxdoc.saveData();
                    }
            }
            return reglasVal; 
        }, 
        saveData: function(){
            var obj = ctxdoc.getDataForm();
            $.ajax({
                    url: globalSP.urlApi + 'savedocumento',
                    type: "POST",
                    data: obj,
                    contentType: false,
                    processData: false,
                    success: function(resp){
                        ctxdoc.refreshList();
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
                        $.magnificPopup.close(); 
                    },
                    error:function(resp){
                        new PNotify({
                            title: resp.title,
                            text: resp.msg,
                            shadow: true,
                            opacity: 1,
                            addclass: noteStack,
                            type: "danger",
                            stack: Stacks[noteStack],
                            width: findWidth(),
                            delay: 1400
                        });
                    }
            });           
             
        },
        delete: function(id){
            swal({
                  title: `Está seguro de eliminar  el documento?`,
                  text: "No podrá recuperar este registro!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Si, eliminar!",
                  closeOnConfirm: true
                }, function(){
                    $.post(globalSP.urlApi + 'deletedocumento', {'id': id, _token : $('input[name=_token]').val(), }, function(res){
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
                        ctxdoc.refreshList();
                    });
                });
        },

    }


    //-------------------- init --------------------------------
    var init = (function(){
        ctxdoc.fillData();

        $("#form-arch").validate(ctxdoc.validateRules());

        $("#arch_nuevo").click(function(){
            ctxdoc.nuevo();
        });

        $("#div_archivos").on('click','.sel_edit', function(){
            ctxdoc.editar();
        });

        $("#div_archivos").on('click','.sel_delete', function(){
            ctxdoc.eliminar();
        });

        $(".sp_cancelar").click(function(){
            $.magnificPopup.close();
        });  

        /*Comportamiento del input:fle*/
        $("#archivo").change(function(){
            $("#archivo_visible").val($(this).val());
            ctxdoc.subir_archivo = true;
        });
    })();


    globalSP.activarMenu(globalSP.menu.GestionDocumental);
    globalSP.cargarGlobales();
    globalSP.setBreadcrumb('Gestion Documental', 'Documentos');

                        



})






</script>

@endpush
