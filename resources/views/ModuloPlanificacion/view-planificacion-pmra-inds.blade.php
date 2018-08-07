

    
<!-- ============================================  Vista de la PROGRAMACION DE ACCIONES ============================================= -->

<!-- =================== el div que contiene a todos #planificacionContainer ================== -->
<!-- =================== el div donde se carga esta vista <div class="col-md-12 slick-slide" id="planificacion_plaa"></div> ================== -->
            

<div class="panel panel-visible" >
    <div class="panel-heading  bg-dark ">
        <div class="panel-title ">
            <div>
                <i class="glyphicon glyphicon-tasks" ></i><span class="sp_titulo_panel"> Planificación de la  Acción</span><span id="sp_est_plaa" class="ml5 badge bg-dark dark"></span>                                 
                <span class="pull-right">
                    <button id="plaa_nuevo" type="button" class="btn btn-sm btn-success dark m5 br4"><i class="fa fa-plus-circle text-white"></i> Agregar </button>
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
                    <div id="sp_est_plaa_inds">                                       
                    </div>
                </div>
            </div>
            <div id="" class="col-sm-11" >                                
                <div id="dt_plaa"></div>
            </div>
        </div>
    </div>
</div>

    <!-- -----------------------------------------          Modal Proyecto  --------------------------------------------------- -->
    <div id="modal_plaa_proyecto"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <!-- end .panel-heading section -->
            <form method="post" action="/" id="form_plaa" name="form_plaa">
                {{ csrf_field() }}
                <div class="panel-body mnw700 of-a">                    
                    <input class="hidden" name="" id="id_plan_articulacion_pdes" >
                    <h4 class="ml5 mt20 ph10 pb5 br-b fw700">Defina el proyecto para la acción: <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div class=" bg-success lighter  row p10">
                        <div id="pmr_plaa"></div>
                        <div id="pilar_plaa"></div>
                        <div id="meta_plaa"></div>
                        <div id="resultado_plaa"></div>
                        <div id="accion_plaa"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 br-r">

                            <h5 class="mt5 ph10 pb5 br-b fw700">Indicador <small class="pull-right fw700 text-primary">- </small> </h5>

                            <div class="section">
                                <label class="field-label" for="variable_res">Tipo Programa/Proyecto</label>
                                <label class="field select">
                                    <select id="idp_tipo_proyecto" name="idp_tipo_proyecto" class="required" style="width:100%;">
                                        <option value=""></option>
                                    </select>
                                    <i class="arrow"></i>
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="idp_tipo_proyecto">Nombre proyecto</label>
                                <label for="nombre_proyecto" class="field prepend-icon">
                                    <textarea class="gui-textarea" id="nombre_proyecto" name="nombre_proyecto"  placeholder="Nombre proyecto"></textarea>
                                    <label for="nombre_proyecto" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                    </label>                                        
                                </label>
                            </div>

                            <div class="section">
                                <label class="field-label" for="codigo">Código (código demanda)</label>
                                <label class="field prepend-icon">
                                    <input type="text" class="gui-input" id="codigo" name="codigo" placeholder="Código demanda" style="width:100%;">
                                    <label for="codigo" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                    </label>                 
                                </label>
                            </div>

                        </div>
                    </div>
                    
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary sp_save">Guardar</button>
                    <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cerrar</a>
                </div>
            </form>
        </div>
        
    </div>

    <div id="modal_plaa_generico"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <!-- end .panel-heading section -->
            <form method="post" action="/" id="form_plaa" name="form_plaa">

                <div class="panel-body mnw700 of-a">                    
                    <input class="hidden" name="" id="" >
                    <input class="hidden" name="" id="" >
                    <h4 class="ml5 mt20 ph10 pb5 br-b fw700">Describa su indicador y la programación para el resultado articulado: <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div class=" bg-success lighter  row p10">
                        <div id="pmr_plaa"></div>
                        <div id="pilar_plaa"></div>
                        <div id="meta_plaa"></div>
                        <div id="resultado_plaa"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 br-r sp_elementos">
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


    <!-- -------------------------------------------edicion de campos ---------------------------------------------------------- -->
{{--     <div id="modal_editcampo" class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
        <div class="panel">
            <div class="panel-heading bg-dark">
                    Modificar
            </div>
            <div class="panel-body mnw700 of-a"> 
                <input class="hidden" name="sp_id_editcampo" id="sp_id_editcampo" >
                <input class="hidden" name="sp_codtc" id="sp_codtc" >
                <div class="section">
                    <label class="field-label" for="alcance_res">Nuevo valor</label>
                    <label class="field prepend-icon">
                        <input type="text" class="gui-input" id="sp_valor_editcampo" name="sp_valor_editcampo" placeholder="valor" style="width:100%;">
                        <label for="alcance_res" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                        </label>                  
                    </label>

                </div>
            </div>
            <div class="panel-footer">
                <button  class="button btn-primary sp_save_editcampo">Guardar</button>
                <a href="javascript:void(0)"   class="button btn-danger ml25 sp_cancelar">Cerrar</a>
            </div>

        </div>
    </div> --}}

<script type="text/javascript">
$(function(){

    var ctxplaa = {
            dataTable : $("#dt_plaa"),
            source : {},
            urlList: globalSP.urlApi + 'listaaccionesproy',

            fillDataTable : function() {
                $.get(ctxplaa.urlList, {p : globalSP.idPlanActivo}, function(resp)
                {
                    ctxplaa.source =
                    {
                        dataType: "json",
                        localdata: resp.data,
                        dataFields: [
                            { name: 'id_pmra', type: 'number' },
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
                            { name: 'sector', type: 'string' },
                            { name: 'cod_periodo_plan', type: 'string' },
                            { name: 'gestion_ini', type: 'string' },
                            { name: 'gestion_fin', type: 'string' },
                            { name: 'indicadores', type: 'object' },   
                        ],
                        id: 'id',
                    };
                    ctxplaa.estadistics();
                    var dataAdapter = new $.jqx.dataAdapter(ctxplaa.source);
                    ctxplaa.dataTable.jqxDataTable({
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
                            { text: '<span title="Resultados">A</span>', dataField: 'cod_a', width: 50,  cellsalign: 'center', align:'center', cellsrenderer: function(row, column, value, rowData){
                                    return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_a}</b> - ${rowData.desc_a}">${rowData.cod_a}</span>`
                                } 
                            },
                            { text: '', width: 40, cellsalign: 'center', cellsrenderer: function (row, column, value, rowData) {
                                    return `<a href="javascript:void(0)"  class="m-l-10 m-r-10 m-t-10 sel_add" title="Agregar proyecto en la articulación de accion " ><i class="fa fa-plus-circle fa-2x text-success "></i></a>`;
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
                // var obj = new FormData($("#form-nuevo")[0]);
                var obj = {
                    id : $("#modal_plaa_proyecto #id").val(),
                    idp_tipo_proyecto: $("#modal_plaa_proyecto #idp_tipo_proyecto").val(),
                    codigo: $("#modal_plaa_proyecto #codigo").val(),
                    nombre_proyecto: $("#modal_plaa_proyecto #nombre_proyecto").val(),
                    id_plan_articulacion_pdes: $("#modal_plaa_proyecto #id_plan_articulacion_pdes").val(),
                    _token : $('input[name=_token]').val(),
                    id_plan : globalSP.idPlanActivo,
                    p: globalSP.idPlanActivo
                }
                return obj;
            },
            nuevo: function(){
                $(".tituloModal span").html(`Agregar proyecto a la acción`);
                $('#modal_plaa_proyecto input:text, #modal_plaa_proyecto textarea').val('');
                $("select").val('').change();
                var rowSelected = ctxplaa.dataTable.jqxDataTable('getSelection')[0];
                $("#modal_plaa_proyecto #id_plan_articulacion_pdes").val(rowSelected.id_pmra);
                $("#modal_plaa_proyecto #pmr_plaa").html(`<b>${rowSelected.cod_p} . ${rowSelected.cod_m} . ${rowSelected.cod_r} . ${rowSelected.cod_a}</b>`);
                $("#modal_plaa_proyecto #pilar_plaa").html(`<b>${rowSelected.nombre_p}</b> - ${rowSelected.desc_p}`);
                $("#modal_plaa_proyecto #meta_plaa").html(`<b>${rowSelected.nombre_m}</b> - ${rowSelected.desc_m}`);
                $("#modal_plaa_proyecto #resultado_plaa").html(`<b>${rowSelected.nombre_r}</b> - ${rowSelected.desc_r}`);
                $("#modal_plaa_proyecto #accion_plaa").html(`<b>${rowSelected.nombre_a}</b> - ${rowSelected.desc_a}`);
                ctxgral.showModal('#modal_plaa_proyecto');
            },
            eliminar: function(){
                var rowSelected = ctxplaa.dataTable.jqxDataTable('getSelection');
                if(rowSelected.length > 0)
                {
                    var rowSel = rowSelected[0];
                    ctxplaa.delete(rowSel.id);             
                }
                else{
                    swal("Seleccione el registro que desea eliminar.");
                }
            },
            validateRules: function(){                
                return {
                            idp_tipo_proyecto:  { required: 'Debe seleccionar el tipo de proyecto' },
                            nombre:  { required: 'El nombre del proyecto es obligatorio' },
                            codigo:  { required: 'El codigo del proyecto es obligatorio' },
                        }; 
            }, 
            saveData: function(){
                var obj = ctxplaa.getDataForm();
                $.post(globalSP.urlApi + 'saveproyecto', obj, function(resp){
                    ctxgral.refreshList(ctxplaa);
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
                        $.post(globalSP.urlApi + 'deleteproyecto', {'id': id, _token : $('input[name=_token]').val(), }, function(res){
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
                            ctxplaa.refreshList();
                        });
                    });
            },
            estadistics: function(){
                $("#sp_est_plaa").html('Total de proyectos ' + ctxplaa.source.localdata.length);
                var pils = _.groupBy(ctxplaa.source.localdata, function(elem){
                    return elem.cod_p;
                });
                var html = `<div class="panel-heading">
                                            <span class="panel-icon"><i class="glyphicons glyphicons-bank"></i>
                                            </span>
                                            <span class="panel-title"></span>
                                        </div>`;
                _.mapObject(pils, function(elem, key){
                    var pilar = elem[0];
                    html += `<div class="panel-body"> 
                                <div>                                        
                                    <span class="badge badge-hero pull-right bg-system dark" data-toggle="tooltip" data-container="body" data-html="true" title="N° de proyectos ${elem.length}">${elem.length}</span> 
                                    <img width="50" class=""  src="/img/${pilar.logo_p}"/>
                                   <!-- <span class="badge badge-hero bg-primary dark" data-toggle="tooltip" data-container="body" data-html="true" title="N° de proyectos ${elem.length}">${elem.length}</span> --> 
                                </div> 
                            </div>`;               
                });
                 $("#sp_est_plaa_inds").html(html);
            }

        }
    



    var init_plaa = (function(){

        /* [ {tipo:input, campo:id, placeholder: placeholder, nombre: 'Codigo de Demanda', options: <option></option>, } , {...}]*/
        generaModal = function(obj){

            html= obj.reduce(function(carry, elem){
                var tag = {
                            textarea : `<div class="section">
                                                <label class="field-label" for="${elem.campo}">${elem.nombre}</label>
                                                <label for="${elem.campo}" class="field prepend-icon">
                                                    <textarea class="gui-textarea" id="${elem.campo}" name="${elem.campo}"  placeholder="${elem.placeholder}"></textarea>
                                                    <label for="${elem.campo}" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                                    </label>                                        
                                                </label>
                                            </div>`,                            
                            select : `<div class="section">
                                                <label class="field-label" for="${elem.campo}">${elem.nombre}</label>
                                                <label class="field select">
                                                    <select id="${elem.campo}" name="${elem.campo}" class="required" style="width:100%;">
                                                        <option value=""></option>${elem.options}
                                                    </select>
                                                    <i class="arrow"></i>
                                                </label>
                                            </div>` ,
                            input:  `<div class="section">
                                                <label class="field-label" for="${elem.campo}">${elem.nombre}</label>
                                                <label class="field prepend-icon">
                                                    <input type="text" class="gui-input" id="${elem.campo}" name="${elem.campo}" placeholder="${elem.placeholder}" style="width:100%;">
                                                    <label for="${elem.campo}" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                                    </label>                 
                                                </label>
                                            </div>` , 
                }

                return carry + tag[elem.tipo];

            }, '');  
            return html;
        }
        elementosModal = {
            modalProyectos: [
                { tipo: 'input', campo: 'nombre', placeholder: 'Nombre del Proyecto', nombre: 'Nombre del Proyecto' },
                { tipo: 'input', campo: 'codigo', placeholder: 'Codigo de Demanda', nombre: 'Codigo de Demanda' },

                ],
        }
        
        // $("#modal_plaa_proyecto .sp_elementos").html(generaModal(modalProyectos));
        // $(".state-error").removeClass("state-error")
        // $('#modal_plaa_proyecto' + " em").remove();
        // $.magnificPopup.open({
        //     removalDelay: 500, //delay removal by X to allow out-animation,
        //     // focus: '#pmra_id_pilar',
        //     items: {
        //         src: '#modal_plaa_proyecto'
        //     },
        //     // overflowY: 'hidden', //
        //     callbacks: {
        //         beforeOpen: function(e) {
        //             var Animation = "mfp-zoomIn";
        //             this.st.mainClass = Animation;
        //         }
        //     },
        //     midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
        // });




        var listeners_plaa = function()
        {                      
            /* select 2 */  
            $.get(globalSP.urlApi + "getparametros/tipo_proyecto", function(res){
                var html = res.data.reduce(function(c, op){
                    return c + `<option value="${op.id}">${op.codigo} - ${op.nombre} </option>`;
                }, '');
         
                $("#idp_tipo_proyecto").html(html);
                $("#idp_tipo_proyecto").select2({
                    placeholder: 'Tipo de proyecto ...',
                });
            });

          
            /* ---------- Contexto plaa ---------------------------------------------------------*/
            ctxplaa.fillDataTable();
            $("#form_plaa").validate(ctxgral.creaValidateRules(ctxplaa));

            $("#planificacion_plaa").on('click', '.sel_add', function(){
                ctxplaa.nuevo()
            });

            // $("#planificacion_plaa").on('click', '.sel_delete', function(){
            //     var id_ari = $(this).attr("id_arti_resultado_indicador");
            //     ctxprog.delete(id_ari);
            // });

            // genera_inputgestiones();
        }

        listeners_plaa();

    })();



    // planif_submenu_activo(3);

})






</script>

{{-- @en}dpush --}}
