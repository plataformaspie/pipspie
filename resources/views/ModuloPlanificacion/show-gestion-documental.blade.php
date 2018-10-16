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
                <div class="panel panel-visible" id="">
                    <div class="panel-heading  bg-dark ">
                        <div class="panel-title hidden-xs">
                            <span class="glyphicons glyphicons-file_import"></span> Documentos <span class="sp_est_archivos"></span>
                            <span class="pull-right"><button id="arch_nuevo" type="button" class="btn btn-sm btn-success dark m5 br4"><i class="fa fa-plus-circle text-white"></i> Agregar Archivo</button></span>
                        </div>
                    </div>
                    <div class="panel-body pn ">
                        <div class="row">
                            <div class="col-md-12" style="overflow-x: scroll;">
                                <div id="div_archivos" class="pv10" style="width:1500px;min-height: 200px ;"  >
                                    <div id="dtArchivos" class=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <!-- end: .tray-center -->




    <!-- -----------------------------------------          Modal  --------------------------------------------------- -->
    <div id="modal-gd"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white" id="tituloModal"><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <!-- end .panel-heading section -->
            <form method="post" action="javascript:void(0)"  id="form-gd" name="form-gd">
                <div class="panel-body mnw700 of-a">
                    <div class="row">
                        <input class="hidden" name="id" id="id" >
                        <div class="row">
                            <div class=" pl5 br-r mvn15">
                                <div class="section">
                                    <label class="field-label" for="id_entidad">Entidad</label>
                                    <label for="id_entidad" class="field select ">
                                        <select id="id_entidad" name="id_entidad" class="required"  style="width:100%;">
                                        </select>
                                        <i class="arrow"> </i>
                                    </label>
                                </div>

                                <div class="section">
                                    <label class="field-label" for="tipo_documento">Documento planificación</label>
                                    <label for="tipo_documento" class="field select ">
                                        <select id="tipo_documento" name="tipo_documento" class="required"  style="width:100%;">
                                            <option value="">Seleccione</option>
                                            <option value="PSDI">PSDI</option>
                                            <option value="PEI">PEI</option>
                                            <option value="PEM">PEM</option>
                                        </select>
                                        <i class="arrow"> </i>
                                    </label>
                                </div>

                                <div class="section">
                                    <label class="field-label" for="fecha_documento">Fecha Entrega</label>
                                    <label for="fecha_documento" class="field prepend-icon">
                                        <input type="text" class="gui-input" id="fecha_documento" name="fecha_documento" placeholder="DD/MM/AAAA">
                                        <label for="fecha_documento" class="field-icon"><i class="fa fa-calendar-o"></i>
                                        </label>
                                    </label>
                                </div>

                                <div class="section">
                                    <label class="field-label" for="archivo">Subir Archivo <small>(solo archivos pdf)</small></label>
                                    <label class="field prepend-icon file">
                                        <span class="button bg-warning br6"><i class="fa fa-search"></i> Buscar archivo</span>
                                        <input name="archivo" id="archivo" class="gui-file" type="file" accept="application/pdf">
                                        <input class="gui-input" id="archivo_visible" type="text" placeholder="Archivo no seleccionado ...">
                                        <label class="field-icon"><i class="fa fa-upload"></i>
                                        </label>
                                    </label>
                                </div>


                                <hr>
                                <h5>Respaldos</h5>
                                <div class="row bg-light mb5 darker"> 
                                    
                                    {{-- respaldo 1 --}}
                                    <div class="section col-sm-4">
                                        <label class="field-label" for="tipo_respaldo_1">Inf. Compatibilidad</label>
                                        <label for="tipo_respaldo_1" class="field select ">
                                            <select id="tipo_respaldo_1" name="tipo_respaldo_1"  style="width:100%;">
                                                <option value="">Seleccione</option>
                                                <option value="DICTAMEN">DICTAMEN</option>
                                                <option value="INFORME">INFORME</option>
                                                <option value="RESOLUCION MINISTERIAL">RESOLUCION MINISTERIAL</option>
                                                <option value="RESOLUCION ADMINISTRATIVA">RESOLUCION ADMINISTRATIVA</option>
                                            </select>
                                            <i class="arrow"> </i>
                                        </label>
                                    </div>

                                    <div class="section  col-sm-4">
                                        <label class="field-label" for="fecha_respaldo_1">Fecha documento</label>
                                        <label for="fecha_respaldo_1" class="field prepend-icon">
                                            <input type="text" class="gui-input" id="fecha_respaldo_1" name="fecha_respaldo_1" placeholder="DD/MM/AAAA">
                                            <label for="fecha_respaldo_1" class="field-icon"><i class="fa fa-calendar-o"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="section col-sm-4">
                                        <label class="field-label" for="archivo_respaldo_1">Archivo</label>
                                        <label class="field prepend-icon file">
                                            <span class="button bg-alert  br6"><i class="fa fa-search"></i> buscar</span>
                                            <input name="archivo_respaldo_1" id="archivo_respaldo_1" class="gui-file" type="file" accept="application/pdf">
                                            <input class="gui-input" id="archivo_visible_1" type="text" placeholder="No seleccionado ...">
                                            <label class="field-icon"><i class="fa fa-upload"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="section  col-sm-12">
                                        <label class="field-label" for="cite_respaldo_1">Cite documento</label>
                                        <label for="cite_respaldo_1" class="field prepend-icon">
                                            <input type="text" class="gui-input" id="cite_respaldo_1" name="cite_respaldo_1" placeholder="CITE respaldo">
                                            <label for="cite_respaldo_1" class="field-icon"><i class="fa fa-calendar-o"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="row bg-light mb5 darker"> 
                                    {{-- respaldo 2 --}}
                                    <div class="section col-sm-4">
                                        <label class="field-label" for="tipo_respaldo_2">Dictamen</label>
                                        <label for="tipo_respaldo_2" class="field select ">
                                            <select id="tipo_respaldo_2" name="tipo_respaldo_2" style="width:100%;">
                                                <option value="">Seleccione</option>
                                                <option value="DICTAMEN">DICTAMEN</option>
                                                <option value="INFORME">INFORME</option>
                                                <option value="RESOLUCION MINISTERIAL">RESOLUCION MINISTERIAL</option>
                                                <option value="RESOLUCION ADMINISTRATIVA">RESOLUCION ADMINISTRATIVA</option>
                                            </select>
                                            <i class="arrow"> </i>
                                        </label>
                                    </div>

                                    <div class="section  col-sm-4">
                                        <label class="field-label" for="fecha_respaldo_2">Fecha documento</label>
                                        <label for="fecha_respaldo_2" class="field prepend-icon">
                                            <input type="text" class="gui-input" id="fecha_respaldo_2" name="fecha_respaldo_2" placeholder="DD/MM/AAAA">
                                            <label for="fecha_respaldo_2" class="field-icon"><i class="fa fa-calendar-o"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="section col-sm-4">
                                        <label class="field-label" for="archivo_respaldo_2">Archivo</label>
                                        <label class="field prepend-icon file">
                                            <span class="button bg-alert br6"><i class="fa fa-search"></i> buscar</span>
                                            <input name="archivo_respaldo_2" id="archivo_respaldo_2" class="gui-file" type="file" accept="application/pdf">
                                            <input class="gui-input" id="archivo_visible_2" type="text" placeholder="No seleccionado ...">
                                            <label class="field-icon"><i class="fa fa-upload"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="section  col-sm-12">
                                        <label class="field-label" for="cite_respaldo_2">Cite documento</label>
                                        <label for="cite_respaldo_2" class="field prepend-icon">
                                            <input type="text" class="gui-input" id="cite_respaldo_2" name="cite_respaldo_2" placeholder="CITE respaldo">
                                            <label for="cite_respaldo_2" class="field-icon"><i class="fa fa-calendar-o"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="row bg-light mb5 darker"> 
                                    {{-- respaldo 3 --}}
                                    <div class="section col-sm-4">
                                        <label class="field-label" for="tipo_respaldo_3">Resolución</label>
                                        <label for="tipo_respaldo_3" class="field select ">
                                            <select id="tipo_respaldo_3" name="tipo_respaldo_3" style="width:100%;">
                                                <option value="">Seleccione</option>
                                                <option value="DICTAMEN">DICTAMEN</option>
                                                <option value="INFORME">INFORME</option>
                                                <option value="RESOLUCION MINISTERIAL">RESOLUCION MINISTERIAL</option>
                                                <option value="RESOLUCION ADMINISTRATIVA">RESOLUCION ADMINISTRATIVA</option>
                                            </select>
                                            <i class="arrow"> </i>
                                        </label>
                                    </div>

                                    <div class="section  col-sm-4">
                                        <label class="field-label" for="fecha_respaldo_3">Fecha documento</label>
                                        <label for="fecha_respaldo_3" class="field prepend-icon">
                                            <input type="text" class="gui-input" id="fecha_respaldo_3" name="fecha_respaldo_3" placeholder="DD/MM/AAAA">
                                            <label for="fecha_respaldo_3" class="field-icon"><i class="fa fa-calendar-o"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="section col-sm-4">
                                        <label class="field-label" for="archivo_respaldo_3">Archivo</label>
                                        <label class="field prepend-icon file">
                                            <span class="button bg-alert br6"><i class="fa fa-search"></i> buscar</span>
                                            <input name="archivo_respaldo_3" id="archivo_respaldo_3" class="gui-file" type="file" accept="application/pdf">
                                            <input class="gui-input" id="archivo_visible_3" type="text" placeholder="No seleccionado ...">
                                            <label class="field-icon"><i class="fa fa-upload"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="section  col-sm-12">
                                        <label class="field-label" for="cite_respaldo_3">Cite documento</label>
                                        <label for="cite_respaldo_3" class="field prepend-icon">
                                            <input type="text" class="gui-input" id="cite_respaldo_3" name="cite_respaldo_3" placeholder="CITE respaldo">
                                            <label for="cite_respaldo_3" class="field-icon"><i class="fa fa-calendar-o"></i>
                                            </label>
                                        </label>
                                    </div>
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
        subir_archivo_1: false,
        subir_archivo_2: false,
        subir_archivo_3: false,
        fillData: function() {
            $.get(globalSP.urlApi + 'listDocumentos', {p : globalSP.idPlanActivo}, function(resp)
            {
                ctxdoc.source =
                {
                    dataType: "json",
                    localdata: resp.data,
                    dataFields: [
                        { name: 'id', type: 'number' },
                        { name: 'id_entidad', type: 'number' },
                        { name: 'nombre_entidad', type: 'string' },
                        { name: 'tipo_documento', type: 'string' },
                        { name: 'fecha_documento', type: 'string' },
                        { name: 'archivo', type: 'string' },

                        { name: 'tipo_respaldo_1', type: 'string' },
                        { name: 'fecha_respaldo_1', type: 'string' },
                        { name: 'cite_respaldo_1', type: 'string' },
                        { name: 'archivo_respaldo_1', type: 'string' },
                        { name: 'tipo_respaldo_2', type: 'string' },
                        { name: 'fecha_respaldo_2', type: 'string' },
                        { name: 'cite_respaldo_2', type: 'string' },
                        { name: 'archivo_respaldo_2', type: 'string' },
                        { name: 'tipo_respaldo_3', type: 'string' },
                        { name: 'fecha_respaldo_3', type: 'string' },
                        { name: 'cite_respaldo_3', type: 'string' },
                        { name: 'archivo_respaldo_3', type: 'string' },
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
                    columnsResize: true,
                    localization: getLocalization('es'),
                    columns: [
                        { text: 'Entidad ', dataField: 'nombre_entidad', align:'center'},
                        { text: 'Doc. plan.', dataField: 'tipo_documento', align:'center'},
                        { text: 'Fecha entrega ', dataField: 'fecha_documento', align:'center'},
                        { text: 'Archivo', width: 60, align:'center',  cellsalign: 'center', cellsrenderer: function(row, column, value, rowData){
                                return rowData.archivo ? `<a href="/sp-files/gestion-documental/${rowData.archivo}" class=" fa fa-book fa-lg text-danger" target="blank"></a>` : '';
                            } 
                        },
                        
                        { text: 'Respaldo 1', align:'center', cellsrenderer: function(row, column, value, rowData){
                                return rowData.archivo_respaldo_1 ? `<a href="/sp-files/gestion-documental/${rowData.archivo_respaldo_1}"  target="blank"><i class=" fa fa-book fa-lg text-alert"></i> ${rowData.tipo_respaldo_1}</a>` : '';
                            } 
                        },
                        { text: 'Fecha', dataField: 'fecha_respaldo_1', align:'center'},
                        { text: 'CITE', dataField: 'cite_respaldo_1', align:'center'},


                        { text: 'Respaldo 2', align:'center', cellsrenderer: function(row, column, value, rowData){
                                return rowData.archivo_respaldo_2 ? `<a href="/sp-files/gestion-documental/${rowData.archivo_respaldo_2}" target="blank"><i class=" fa fa-book fa-lg text-alert"></i> ${rowData.tipo_respaldo_2}</a>` : '';
                            } 
                        },
                        { text: 'Fecha', dataField: 'fecha_respaldo_2', align:'center'},
                        { text: 'CITE', dataField: 'cite_respaldo_2', align:'center'},

                        { text: 'Respaldo 3', align:'center', cellsrenderer: function(row, column, value, rowData){
                                return rowData.archivo_respaldo_3 ? `<a href="/sp-files/gestion-documental/${rowData.archivo_respaldo_3}" target="blank"><i class=" fa fa-book fa-lg text-alert"></i> ${rowData.tipo_respaldo_3}</a>` : '';
                            } 
                        },
                        { text: 'Fecha', dataField: 'fecha_respaldo_3', align:'center'},
                        { text: 'CITE', dataField: 'cite_respaldo_3', align:'center'},                       
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
            $("#form-gd em").remove();
                $.magnificPopup.open({
                removalDelay: 500, //delay removal by X to allow out-animation,
                items: {
                    src: "#modal-gd"
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
            var formData = new FormData($("#form-gd")[0]);
            formData.append("_token", $('input[name=_token]').val());
            formData.append("id_plan", globalSP.idPlanActivo);
            formData.append("p", globalSP.idPlanActivo);
            formData.append("subir_archivo", ctxdoc.subir_archivo);
            formData.append("subir_archivo_1", ctxdoc.subir_archivo_1);
            formData.append("subir_archivo_2", ctxdoc.subir_archivo_2);
            formData.append("subir_archivo_3", ctxdoc.subir_archivo_3);
            return formData;
        },
        setDataForm: function(obj){
            console.log(obj)
            $("#id").val(obj.id);
            $("#id_entidad").val(obj.id_entidad);
            $("#tipo_documento").val(obj.tipo_documento);
            $("#fecha_documento").val(obj.fecha_documento);
            $("#archivo_visible").val( obj.archivo ? 'Archivo cargado' : '') ;
            
            $("#tipo_respaldo_1").val(obj.tipo_respaldo_1);
            $("#fecha_respaldo_1").val(obj.fecha_respaldo_1);
            $("#cite_respaldo_1").val(obj.cite_respaldo_1);
            $("#archivo_respaldo_1").val( obj.archivo_respaldo_1 ? 'Archivo cargado' : '') ;

            $("#tipo_respaldo_2").val(obj.tipo_respaldo_2);
            $("#fecha_respaldo_2").val(obj.fecha_respaldo_2);
            $("#cite_respaldo_2").val(obj.cite_respaldo_2);
            $("#archivo_respaldo_2").val( obj.archivo_respaldo_2 ? 'Archivo cargado' : '') ;

            $("#tipo_respaldo_3").val(obj.tipo_respaldo_3);
            $("#fecha_respaldo_3").val(obj.fecha_respaldo_3);
            $("#cite_respaldo_3").val(obj.cite_respaldo_3);
            $("#archivo_respaldo_3").val( obj.archivo_respaldo_3 ? 'Archivo cargado' : '') ;


        },
        inicializaForm: function(obj){
            ctxdoc.subir_archivo = false;
            ctxdoc.subir_archivo_1 = false;
            ctxdoc.subir_archivo_2 = false;
            ctxdoc.subir_archivo_3 = false;
            $.get(globalSP.urlApi + 'getEntidadesHijos/' + globalSP.usuario.id_institucion, function(res){
                $("#form-gd #id_entidad").html( res.data.reduce(function(carry, op){ return carry + `<option value="${op.id}">${op.nombre} (${op.sigla}) </option>`},'<option value="">Seleccione la entidad</option>') );
                if(obj){
                    ctxdoc.setDataForm(obj);
                }
            });
        },
        nuevo: function(){
            ctxdoc.inicializaForm();
            $("#tituloModal span").html(`Agregar Documentos`);
            $('#form-gd input, #form-gd select, #form-gd textarea').val('');
            ctxdoc.showModal();
        },
        editar: function(){
            var rowSelected = ctxdoc.dataTable.jqxDataTable('getSelection');
            if(rowSelected.length > 0)
            {
                var rowSel = rowSelected[0]; 
                ctxdoc.inicializaForm(rowSel);
                // ctxdoc.setDataForm(rowSel);
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

        $("#form-gd").validate(ctxdoc.validateRules());

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
        $("#archivo_respaldo_1").change(function(){
            $("#archivo_visible_1").val($(this).val());
            ctxdoc.subir_archivo_1 = true;
        });
        $("#archivo_respaldo_2").change(function(){
            $("#archivo_visible_2").val($(this).val());
            ctxdoc.subir_archivo_2 = true;
        });
        $("#archivo_respaldo_3").change(function(){
            $("#archivo_visible_3").val($(this).val());
            ctxdoc.subir_archivo_3 = true;
        });

    })();


    globalSP.activarMenu(globalSP.menu.GestionDocumental);
    globalSP.cargarGlobales();
    globalSP.setBreadcrumb('Gestion Documental', 'Documentos');

})






</script>

@endpush
