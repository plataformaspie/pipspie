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
                        <span class="panel-title"> Listado de Planes de la institución</span>
                    </div>
                    <div class="panel-body">
                        <h4>Periodo vigente en curso: <strong  class="sp_periodo text"></strong></h4>
                        <div class="row">
                            <div id="estructura" class="col-md-12" >
                                <button id="nuevo" type="button" class="btn btn-sm btn-success dark m5  br6 "><i class="fa fa-plus-circle text-white"></i> Agregar Plan</button>
                                <button id="editar" type="button" class="btn btn-sm btn-warning dark m5 br6 "><i class="fa fa-edit text-white"></i> Editar</button>
                                <button id="eliminar" type="button" class="btn btn-sm btn-danger dark m5 br6 "><i class="fa fa-minus-circle text-white"></i> Eliminar</button>
                                <div id="dataTable"></div>
                            </div>
                        </div>
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
                                            <option value="">Seleccione el tipo de plan</option>
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
    var planes = {
        dataTable : $("#dataTable"),
        periodo_planificacion: {},
        source : {},

        fillPlanes : function() {
            $.get(globalSP.urlApi + 'listPlanes', function(resp)
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
                        { name: 'nombre_entidad', type: 'string' },
                        { name: 'sigla_entidad', type: 'string' },
                        { name: 'cod_tipo_plan', type: 'string' },
                        { name: 'id_tipo_plan', type: 'number' },
                        { name: 'etapas_completadas', type: 'string' }
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
                    filterable: false,
                    filterMode: 'simple',
                    selectionMode: 'singleRow',
                    localization: getLocalization('es'),
                    columns: [
                        /* boton de cargar */
                        { text: '*', width: 80, cellsRenderer: function (row, datafield, value) {
                                        var html = '<button class="sel_cargar_plan btn btn-xs bg-system dark btn-rounded text-white-lighter"><i class="fa fa-arrow-circle-up icon-success"></i> <span>cargar</span></button>';
                                        return html;
                                    },  
                        },
                        /* imagen segun el tipo de plan */
                        { text: '-', width: 90, cellsRenderer: function (row, column, value, rowData) {
                              var image = `<div style='margin: 5px; margin-bottom: 3px;'>
                                          <img width="60" height="80" style="display: block;" src="/img/ico_${rowData.cod_tipo_plan}.png"/>
                                          </div>`
                              return image;
                              }
                        },
                        /* descripcion armada */
                        { text: 'Descripcion', dataField: 'nombre', align: 'center',
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
                        /* botones de edicion*/
                        { text: ' ', dataField: 'id', cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                                html = `<a href="#" id="edit-${value}" class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar Plan" ><i class="fa fa-edit text-warning fa-lg"></i></a> 
                                <a href="#" id="del-${value}" class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar Plan" ><i class="fa fa-minus-circle text-danger fa-lg"></i></a> ` ;
                                return html;
                            }
                        },
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
                window.location = globalSP.url + 'showPlanesInstitucion?p=' + rowsel.id ; 
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

    var ctxForm = {
        showModal : function(){
            $(".state-error").removeClass("state-error")
            $("#form-plan em").remove();
                    // Inline Admin-Form example
            $.magnificPopup.open({
                removalDelay: 500, //delay removal by X to allow out-animation,
                focus: '#focus-blur-loop-select',
                items: {
                    src: "#frm_modal"
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
        cargarCombos : function(){
            $.get(globalSP.urlApi + "getparametros/tipo_plan/valor/SECTORIAL", function(res){
                opts = res.data;
                opts.forEach(function(op){
                    $("#id_tipo_plan").append('<option value="' + op.id + '">' + op.nombre + '</option>');
                })
            })
        },
        getDataForm: function(){
            var objPlan = {
                            id: $("#id").val(),
                            id_tipo_plan:$("#id_tipo_plan").val(),
                            descripcion: $("#descripcion").val(),
                            // gestion_inicio: $("#gestion_inicio").val(),
                            // gestion_fin: $("#gestion_fin").val(),
                            _token : $('input[name=_token]').val()
                        }
            return objPlan;
        },   
        setDataForm: function(objPlan){
            $("#id").val(objPlan.id);
            $("#id_tipo_plan").val(objPlan.id_tipo_plan);
            $("#descripcion").val(objPlan.descripcion_plan);
            // $("#gestion_inicio").val(objPlan.gestion_inicio);
            // $("#gestion_fin").val(objPlan.gestion_fin);
        },
        validateRules: function(){
            var reglasVal = {
                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    rules: {
                        tipoPlan: { required: true },
                        gestion_inicio:  { required: true },
                        gestion_fin: { required: true }
                    },

                    messages:{
                        tipoPlan: { required: 'Seleccione el tipo de plan' },
                        gestion_inicio:  { required: 'Ingresar la gestion de inicio' },
                        gestion_fin:  { required: 'Ingresar la gestion de inicio' }
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
                        ctxForm.saveData();
                    }
            }
            return reglasVal; 
        }, 
        saveData: function(){    
            var objPlan = this.getDataForm();
            $.post(globalSP.urlApi + 'savePlan', objPlan, function(res){
                new PNotify({
                            title: !res.error ? (res.accion=='insert' ? 'Plan Creado' : 'Modificado') : 'Error!!',
                            text: res.msg,
                            shadow: true,
                            opacity: 1,
                            addclass: noteStack,
                            type: !res.error ? "success" : "danger",
                            stack: Stacks[noteStack],
                            width: findWidth(),
                            delay: 1500
                        });
                planes.refresh();
                $.magnificPopup.close();
            });  
        },
        deletePlan: function(id){
            swal({
                  title: "Está seguro de eliminar el Plan?",
                  text: "No podrá recuperar este registro!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Si, eliminar!",
                  closeOnConfirm: true
                }, function(){
                    $.get(globalSP.urlApi + 'deletePlan', {'id': id}, function(res){
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
                        planes.refresh();
                    });
                });
        },

    }


    globalSP.activarMenu(globalSP.menu.AdminPlanes);
    globalSP.cargarGlobales();
    globalSP.setBreadcrumb('Planes de la Institución', 'Administrar Planes');

    planes.fillPlanes();
    ctxForm.cargarCombos();

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

    $("#form-plan").validate(ctxForm.validateRules());

    

})
</script>
@endpush
