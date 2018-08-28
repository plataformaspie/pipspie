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
                        <select id="indicadores" style="width:80%"></select>
                        <span class="pull-right"> <button id="addEj" type="button" class="btn btn-sm btn-success dark m5 br4"><i class="fa fa-plus-circle text-white"></i> Completar datos de ejecución</button></span>
                        <div id="contenido_indicador">
                            <div id="dataTable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div id="modal_ej"  class="popup-basic popup-lg admin-form mfp-with-anim mfp-hide ">
        <div class="panel">
            <div class="panel-heading bg-dark ">
                  <span class="panel-title text-white" id="tituloModal"><i class="fa fa-pencil"></i> <span>Modificar el valor de lo ejecutado </span></span>
            </div>
                  <!-- end .panel-heading section -->
                  <form method="post" action="/" id="form-ej" name="form-ej">
                      <div class="panel-body of-a" id="val">
                        <input class="hidden" name="id" id="id" >
                        <div class="row">
                            <div class=" pl5 br-r mvn15">
                                <h3 class="ml5 mt20 ph10 pb5 br-b fw700"> <strong  class="sp_periodo text"></strong><small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h3>
                                <div class="col-sm-6" id="gestiones_ej" style="height: 400px; overflow-y: scroll;">
                                    <h5 class="mt5 ph10 pb5 br-b fw700">Ingrese lo ejecutado <small class="pull-right fw700 text-primary">- </small> </h5>
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
   ctxseg = {
        indicadores: [],
        indsel : [],
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
                ctxseg.indsel = indsel;
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

                                         var prog_row = ej_row = calc_row = '';

                                        for(i = rowData.gestion_ini; i <= rowData.gestion_fin; i++){
                                            /* Programaciones */ 
                                            var progGestion = _.find(rowData.programacion, function(el){
                                                return el.gestion == i;
                                            }) ;
                                            var valorprog = (progGestion && progGestion.dato) ? `${progGestion.dato } ${rowData.unidad || ''}` : '';
                                            prog_row += `<td> ${valorprog}</td>`;

                                            /* ejecuciones */
                                            var ejGestion = _.find(rowData.ejecucion, function(el){
                                                return el.gestion == i;
                                            }) ;
                                            var valorej = (ejGestion && ejGestion.dato) ? `${ejGestion.dato } ${rowData.unidad || ''}` : '';
                                            ej_row += `<td> ${valorej}</td>`;

                                            var calc = ((ejGestion && ejGestion.dato) ? ejGestion.dato : 0 )   / ((progGestion && progGestion.dato) ? progGestion.dato : 0.1) * 100;
                                             calc_row += `<td> ${calc} % </td>`;

                                        }

                                        html += `<tr>   <td>Programado</td>${prog_row} </tr>
                                                <tr>   <td>Ejecutado</td>${ej_row} </tr>
                                                <tr>   <td>Tasa Cumplimiento</td>${calc_row} </tr> `;
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
        showEjecuciones: function(){
            var opts = genera_inputgestiones(2011, 2020, ctxseg.indsel[0].ejecucion);
            $("#gestiones_ej tbody").html(opts);
            ctxseg.showModal('#modal_ej')
        },
        refresh: function(){
            ctxseg.fillTabla(ctxseg.indsel);   
        },
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
        saveEj: function(){
            var indEj = [];
            for(var i = 2011; i <= 2020; i++){
                var prog = {};
                prog.id = $("#form-ej .id" + i).val();;
                prog.gestion = i;
                prog.dato =  $("#form-ej .d" + i).val();
                indEj.push(prog);
            }
            var obj = {};
            obj.ejecuciones = indEj;
            obj.id_arti_indicador = $("#indicadores").val();// ctxseg.indsel.id_arti_indicador;
            obj.codp_nivel_pmra = ctxseg.indsel.nivel_indicador;
            obj._token = $('input[name=_token]').val();
            $.post(globalSP.urlApi + 'saveejecuciones', obj, function(resp){
                ctxseg.refresh();
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
        validateRules: function(){
            var reglasVal = {
                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    rules: {
                    },

                    messages:{
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
                        ctxseg.saveEj();
                    }
            }
            return reglasVal; 
        }, 
        // nuevo: function(){
        //     $("#tituloModal span").html("Crear Plan");
        //     $('#form-plan select, #form-plan input:text, textarea').val('');
        //     ctxForm.showModal();
        // },
        // editar: function(){
        //     var rowSelected = planes.dataTable.jqxDataTable('getSelection');
        //     if(rowSelected.length > 0)
        //     {
        //         var rowSel = rowSelected[0]; 
        //         ctxForm.setDataForm(rowSel);
        //         $("#tituloModal span").html("Modificar Plan");
        //         ctxForm.showModal();
        //     }
        //     else{
        //         swal("Seleccione el registro para modificar.");
        //     }
        // },
        // eliminar: function(){
        //     var rowSelected = planes.dataTable.jqxDataTable('getSelection');
        //     if(rowSelected.length > 0)
        //     {
        //         var rowSel = rowSelected[0];
        //         ctxForm.deletePlan(rowSel.id);             
        //     }
        //     else{
        //         swal("Seleccione el registro que desea eliminar.");
        //     }
        // },

    }


    var init = (function(){
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
        };

         ctxseg.fillIndicadores();

        $("#indicadores").change(function(){
            var id_arti_indicador = $("#indicadores").val();
            indsel = []
            indsel[0] = _.find(ctxseg.indicadores, function(elem){
                return elem.id_arti_indicador == id_arti_indicador;
            });
            ctxseg.fillTabla(indsel)
        }).select2({ placeholder: 'Indicadores',});

        $('#addEj').click(function(){
            ctxseg.showEjecuciones();
        });

        $("#cancelar").click(function(){
            $.magnificPopup.close();
        });
        $("#form-ej").validate(ctxseg.validateRules());
    })();

    globalSP.activarMenu(37);
    globalSP.cargarGlobales();
    globalSP.setBreadcrumb('Seguimiento y Evaluación', 'Seguimiento y Evaluación');

   

})
</script>
@endpush
