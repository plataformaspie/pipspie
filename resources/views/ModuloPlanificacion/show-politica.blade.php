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
    <div class="tray tray-center p40 va-t posr" id="div_politicas">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy2">
                    <div class="panel-heading  bg-dark ">
                        <div class="panel-title ">
                            <i class="fa fa-puzzle-piece fa-2x" ></i><span class="sp_politica"></span> <span class="sp_est_politica"></span>
                        </div>
                    </div>
                    <div class="panel-body pn">
                        <div class="row">
                            <div  class="col-md-12" >
                                <button id="pol_nuevo" type="button" class="btn btn-sm btn-success dark m5 br4"><i class="fa fa-plus-circle text-white"></i> Agregar </button>
                                <button id="pol_editar" type="button" class="btn btn-sm btn-warning dark m5 br4"><i class="fa fa-edit text-white"></i> Editar</button>
                                <button id="pol_eliminar" type="button" class="btn btn-sm btn-danger dark m5 br4"><i class="fa fa-minus-circle text-white"></i> Eliminar</button>                                
                                
                            </div>
                        </div>
                        <div id="dtPoliticas"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <!-- end: .tray-center -->




    <!-- -----------------------------------------          Modal  --------------------------------------------------- -->
    <div id="modal-pol"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white" id="tituloModal"><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <!-- end .panel-heading section -->
            <form method="post" action="/" id="form-pol" name="form-pol">
                {{-- <input type="hidden" name="mod_id" id="mod_id" value=""> --}}

                <div class="panel-body mnw700 of-a">
                    <div class="row">

                            <input class="hidden" name="id_pol" id="id_pol" >
                            <div class="row">
                                <div class=" pl5 br-r mvn15">
                                    <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Defina su <span class="sp_politica"></span><small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>
                                    <div class="section">
                                        <label class="field-label sp_politica" for="atribucion"></label>
                                        <label for="politica" class="field prepend-icon">
                                            <input type="text" class="gui-input" id="politica" name="politica" placeholder="Politica sectorial / institucional ">
                                            <label for="politica" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="section">
                                        <label class="field-label" for="ids_pilares">Pilares según sus atribuciones </label>
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

    var pol = {
        dataTable : $("#dtPoliticas"),
        source : {},

        fillPolitics : function() {
            $.get(globalSP.urlApi + 'listPoliticasPilares', {p : globalSP.idPlanActivo}, function(resp)
            {
                pol.source =
                {
                    dataType: "json",
                    localdata: resp.data,
                    dataFields: [
                        { name: 'id', type: 'number' },
                        { name: 'politica', type: 'string' },
                        { name: 'ids_pilares', type: 'string' },
                        { name: 'pilares', type: 'object' },
                    ],
                    id: 'id',
                };
                var dataAdapter = new $.jqx.dataAdapter(pol.source);
                var editDelRenderer = function (row, columnfield, value, defaulthtml, rowData) {
                    html = `<a href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar " ><i class="fa fa-edit fa-lg text-warning "></i></a>
                            <a href="#"  class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a>`
                    return html;
                };
                pol.dataTable.jqxDataTable({
                    source: dataAdapter,
                    altRows: false,
                    sortable: true,
                    width: "70%",
                    filterable: false,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    localization: getLocalization('es'),
                    columns: [
                        { text: 'Política ', dataField: 'politica', align:'center'},
                        { text: 'Pilares Asociados', dataField: 'id', align:'center',
                                cellsrenderer: function(row, column, value, rowData){
                                    var pilares = rowData.pilares;
                                    html = "";
                                    pilares.forEach(function(pilar){
                                        html += `<div class='br-b m10 pv5 row'>
                                                    <div class="col-md-2"><img width="40" class=""  src="/img/${pilar.logo}"/></div>
                                                    <div class="col-md-10"><b>${pilar.nombre}</b> - ${pilar.descripcion}</div>
                                                </div>`
                                    });
                                   return html;
                            } 
                        },
                        { text: ' ', width: 50, cellsrenderer: editDelRenderer},
                    ]
                });
                funciones.estadistics();
            });
        },
        refreshList: function(){
            $.get(globalSP.urlApi + 'listPoliticasPilares', {p:globalSP.idPlanActivo}, function(resp) {
                pol.source.localdata = resp.data;
                pol.dataTable.jqxDataTable("updateBoundData");
                funciones.estadistics()
            })   
        },
        init : function(){
            $.get(globalSP.urlApi + "getPilaresVinculadosAlPlan", {p:globalSP.idPlanActivo}, function(res){
                opts = res.data;
                opts.forEach(function(op){
                    $("#ids_pilares").append('<option value="' + op.id + '">' + op.nombre + ' - ' + op.descripcion + '</option>');
                });
                $("#ids_pilares").select2({
                    placeholder: 'Seleccione los pilares de la política',
                    dropdownParent: $('#form-pol'),
                    cache: false,
                    language: "es",
                    templateSelection: function (val) {
                        return $("<div class='list-group-item' style='width:100%;' title ='" + val.text + "'>" +val.text + "</div>");
                    },
                });
            });


            $(".sp_politica").html(funciones.tipoPolitica());
        },
        showModal : function(){
            $(".state-error").removeClass("state-error")
            $("#form-pol em").remove();
                $.magnificPopup.open({
                removalDelay: 500, //delay removal by X to allow out-animation,
                focus: '#politica',
                items: {
                    src: "#modal-pol"
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
                id: $("#id_pol").val(),
                politica: $("#politica").val(),
                ids_pilares: $("#ids_pilares").val(),
                _token : $('input[name=_token]').val(),
                id_plan : globalSP.idPlanActivo,
                p: globalSP.idPlanActivo
            }
            return obj;
        },
        setDataForm: function(obj){
            $("#id_pol").val(obj.id);
            $("#politica").val(obj.politica);
            $("#ids_pilares").val(obj.ids_pilares).change();
        },
        nuevo: function(){
            $("#tituloModal span").html(`Agregar ${funciones.tipoPolitica()}`);
            $('#form-pol input:text').val('');
            $("#ids_pilares").val('').change();
            pol.showModal();
        },
        editar: function(){
            var rowSelected = pol.dataTable.jqxDataTable('getSelection');
            if(rowSelected.length > 0)
            {
                var rowSel = rowSelected[0]; 
                pol.setDataForm(rowSel);
                $("#tituloModal span").html(`Modificar ${funciones.tipoPolitica()}`);
                pol.showModal();
            }
            else{
                swal("Seleccione el registro para modificar.");
            }
        },
        eliminar: function(){
            var rowSelected = pol.dataTable.jqxDataTable('getSelection');
            if(rowSelected.length > 0)
            {
                var rowSel = rowSelected[0];
                pol.delete(rowSel.id);             
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
                        politica: { required: true },
                        ids_pilares:  { required: true },
                    },

                    messages:{
                        politica: { required: 'Debe escribir su política sectorial/institucional' },
                        ids_pilares:  { required: 'Seleccionar los pilares asociados a la política' },
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
                        pol.saveData();
                    }
            }
            return reglasVal; 
        }, 
        saveData: function(){
            var obj = pol.getDataForm();
            $.post(globalSP.urlApi + 'savePolitica', obj, function(resp){
                pol.refreshList();
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
            });
             
        },
        delete: function(id){
            swal({
                  title: `Está seguro de eliminar  la ${funciones.tipoPolitica()}?`,
                  text: "No podrá recuperar este registro!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Si, eliminar!",
                  closeOnConfirm: true
                }, function(){
                    $.post(globalSP.urlApi + 'deletePolitica', {'id': id, _token : $('input[name=_token]').val(), }, function(res){
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
                        pol.refreshList();
                    });
                });
        },

    }

    var funciones = {
        estadistics : function()
        {
            try{ 
                var politicas = pol.source.localdata;
                $(".sp_est_politica").removeClass('badge bg-success bg-danger dark');
                $(".sp_est_politica").addClass( (politicas.length > 0) ? 'badge bg-system dark' : 'badge bg-danger');
                $(".sp_est_politica").html(politicas.length);

                obj ={
                    id_menu : globalSP.menu.PoliticaSectorial,
                    p: globalSP.idPlanActivo,
                    _token : $('input[name=_token]').val(),
                    agregar: (politicas.length > 0)   ? '1' : '0' ,
                }
                $.post(globalSP.urlApi + 'actualizaEtapas', obj, function() {});

            }
            catch(e){}
        },
        tipoPolitica: function(){
            tipoPolitica = globalSP.planActivo.cod_tipo_plan == 'PSDI' ? 'Política Sectorial' : 'Política Institucional';
            return tipoPolitica;
        }
    }


    globalSP.activarMenu(globalSP.menu.PoliticaSectorial);
    globalSP.cargarGlobales(function(){
        pol.init();
    });
    globalSP.setBreadcrumb('Politica', 'Politica');

    

    //-------------------- de las Politicas --------------------------------
    pol.fillPolitics();
    

    $("#form-pol").validate(pol.validateRules());

    $("#pol_nuevo").click(function(){
        pol.nuevo();
    });

    $("#div_politicas").on('click','.sel_edit, #pol_editar', function(){
        pol.editar();
    });

    $("#div_politicas").on('click','.sel_delete, #pol_eliminar', function(){
        pol.eliminar();
    });



    $(".sp_cancelar").click(function(){
        $.magnificPopup.close();
    });

})






</script>

@endpush
