

    
<!-- ============================================  Vista de la PROGRAMACION DE ACCIONES ============================================= -->

<!-- =================== el div que contiene a todos #planificacionContainer ================== -->
<!-- =================== el div donde se carga esta vista <div class="col-md-12 slick-slide" id="planificacion_plaa"></div> ================== -->
            

<div class="panel panel-visible" >
    <div class="panel-heading  bg-dark ">
        <div class="panel-title ">
            <div>
                <i class="glyphicons glyphicons-riflescope" ></i><span class="sp_titulo_panel"> Planificación de la  Acción</span><span id="sp_est_plaa" class="ml5 badge bg-dark dark"></span>                                 
                <span class="pull-right">                   
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
                <div style="max-height: 500px; overflow-y: scroll;" >
                   <div id="dt_plaa"></div> 
                </div> 
                <div id="selcontenido">
                    
                </div>                              
                
            </div>
        </div>
    </div>
</div>

    <!-- -----------------------------------------          Modal Proyecto  --------------------------------------------------- -->
    <div id="modal_plaa_proyecto"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide ">
        <div class="panel">
            <div class="panel-heading bg-dark">
                <span class="panel-title text-white tituloModal" id=""><i class="fa fa-pencil"></i> <span>__</span></span>
            </div>
            <!-- end .panel-heading section -->
            <form method="post" action="/" id="form_plaa" name="form_plaa">
                <div class="panel-body of-a">                    
                    <input class="hidden" name="" id="id_arti_pdes_proyecto" >
                    <input class="hidden" name="" id="id_proyecto" >
                    <h4 class="ml5 mt5 ph10 pb5 br-b fw700">Defina el proyecto para la acción: <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h4>
                    <div class=" bg-system  row p10 mb10">
                        <div id="pmr_plaa"></div>
                        <div id="pilar_plaa"></div>
                        <div id="meta_plaa"></div>
                        <div id="resultado_plaa"></div>
                        <div id="accion_plaa"></div>
                        <span class="bg-dark "><i class="fa fa-dot-circle-o"></i> I</span>
                                                <span class="bg-dark "><i class="fa fa-sitemap" ></i> R</span>
                                                <span class="bg-dark "><i class="glyphicons glyphicons-group"></i> RA</span>
                                                <span class="bg-dark "><i class="fa fa-share-square-o"></i> AC</span> 
                                                <span class="bg-dark "><i class="fa fa-map-marker"></i> T</span>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 br-r">
                            <div class="section">
                                <label class="field-label" for="codp_tipo_proyecto"><b>Tipo Programa/Proyecto</b></label>
                                <label class="field select ">
                                    <select id="codp_tipo_proyecto" name="codp_tipo_proyecto" class="required br-primary" style="width:100%;">
                                    </select>
                                    <i class="arrow"></i>
                                </label>
                            </div>

                            <div id="proy-ocultos" class=" hidden">

                                <div class="section proy-ocultos section_select_id_proyecto">
                                    <label class="field-label" for="select_id_proyecto">Proyecto</label>
                                    <label class="field select">
                                        <select id="select_id_proyecto" name="select_id_proyecto"  style="width:100%;">
                                        </select>
                                        <i class="arrow"></i>
                                    </label>
                                </div>

                                <div class="section proy-ocultos section_nombre_proyecto">
                                    <label class="field-label" for="codp_tipo_proyecto">Nombre proyecto</label>
                                    <label for="nombre_proyecto" class="field prepend-icon">
                                        <textarea class="gui-textarea" id="nombre_proyecto" name="nombre_proyecto"  placeholder="Nombre proyecto"></textarea>
                                        <label for="nombre_proyecto" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                        </label>                                        
                                    </label>
                                </div>

                                <div class="section proy-ocultos section_codigo">
                                    <label class="field-label" for="codigo">Código - código demanda</label>
                                    <label class="field prepend-icon">
                                        <input type="text" class="gui-input" id="codigo"   name="codigo" placeholder="Código.." style="width:40%;" >
                                        <label for="codigo" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                        </label>                 
                                    </label>
                                </div>

                                <div class="section">
                                    <div class="form-group col-md-4">
                                        <label class="field-label" for="fecha_ini_picker">Fecha inicio</label>
                                        <div class="">
                                            <div class="input-group date" id="fecha_ini_picker">
                                                <span class="input-group-addon cursor"><i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control" id="fecha_ini" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="field-label" for="fecha_fin_picker">Fecha fin</label>
                                        <div class="">
                                            <div class="input-group date" id="fecha_fin_picker">
                                                <span class="input-group-addon cursor"><i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" class="form-control" id="fecha_fin" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="panel-footer">
                    <button type="submit" class="button btn-primary sp_save">Guardar</button>
                    <a href="javascript:void(0)"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
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
                    <a href="javascript:void(0)"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
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
            proyectos:[], 
            cssDisabled : 'bg-dark darker',           

            fillDataTable : function() {
                $.get(ctxplaa.urlList, {p : globalSP.idPlanActivo}, function(resp)
                {
                    ctxplaa.source =
                    {
                        dataType: "json",
                        localdata: resp.data,
                        dataFields: [
                            { name: 'id_pmra', type: 'number' },
                            { name: 'id_a', type: 'number' },
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
                            { name: 'proyectos', type: 'object' },   
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
                            { text: '<span title="Acciones">A</span>', dataField: 'cod_a', width: 50,  cellsalign: 'center', align:'center', cellsrenderer: function(row, column, value, rowData){
                                    return `<span data-toggle="tooltip" data-container="body" data-html="true" title="<b>${rowData.nombre_a}</b> - ${rowData.desc_a}">${rowData.cod_a}</span>`
                                } 
                            },
                            { text: '', width: 40, cellsalign: 'center', cellsrenderer: function (row, column, value, rowData) {
                                    return `<a href="javascript:void(0)"  class="m-l-10 m-r-10 m-t-10 sel_add" title="Agregar proyecto en la articulación de accion " ><i class="fa fa-plus-circle fa-2x text-success "></i></a>`;
                                }
                            }, 
                            
                            { text: 'Proyectos ',    align:'center', width: 1000,cellClassName: 'sp_cellTable', 
                                cellsrenderer: function(row, column, value, rowData){
                                    var html = ''; 
                                    if(rowData.proyectos.length>0){ 

                                        html = `<table class="table table-bordered table-hover fs11 sp_table">
                                        <thead><tr class="primary"> <th>Tipo proyecto</th> <th>Nombre</th> <th>Opciones</th>  <th>Codigo</th> <th>Fecha inicio</th> <th>Fecha fin</th> <th></th> </tr> </thead>
                                        <tbody>`;

                                        rowData.proyectos.forEach(function(proy, index){
                                                      html += `<tr>
                                            <td class="">${proy.tipo_proyecto}</td> 
                                            <td>${proy.nombre_proyecto}</td>
                                            <td>
                                                <span class="bg-dark "><i class="fa fa-dot-circle-o"></i> I</span>
                                                <span class="bg-dark "><i class="fa fa-sitemap" ></i> R</span>
                                                <span class="bg-dark "><i class="glyphicons glyphicons-group"></i> RA</span>
                                                <span class="bg-dark "><i class="fa fa-share-square-o"></i> AC</span> 
                                                <span class="bg-dark "><i class="fa fa-map-marker"></i> T</span>
                                            </td>
                                            <td>${ proy.codigo ? proy.codigo : ''} </td> 
                                            <td class="">${proy.fecha_ini}</td> <td class="">${proy.fecha_fin}</td> 
                                            
                                            <td><a href="javascript:void(0)"  index_proy="${index}" class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar proyecto" ><i class="fa fa-edit text-warning fa-lg"></i></a>
                                            <a href="javascript:void(0)" id_arti_pdes_proyecto="${proy.id_arti_pdes_proyecto}" class="sel_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger "></i></a></td>
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
            getDataContent: function(content){
                inputs = $(`${content} input, ${content} select, ${content} textarea`);
                var obj = {}
                inputs.each(function(index, el) {
                    obj[$(el).attr('id')] = $(el).val();
                });
                obj._token = ctxgral.token;
                return obj;
            },
            nuevo: function(){
                $(".tituloModal span").html(`Agregar proyecto a la acción`);
                // $('#modal_plaa_proyecto input:text, #modal_plaa_proyecto textarea').val('');
                $("#modal_plaa_proyecto select").val('').change();
                var rowSelected = ctxplaa.selrow();
                $("#modal_plaa_proyecto #pmr_plaa").html(`<b>${rowSelected.cod_p} . ${rowSelected.cod_m} . ${rowSelected.cod_r} . ${rowSelected.cod_a}</b>`);
                $("#modal_plaa_proyecto #pilar_plaa").html(`<b>${rowSelected.nombre_p}</b> - ${rowSelected.desc_p}`);
                $("#modal_plaa_proyecto #meta_plaa").html(`<b>${rowSelected.nombre_m}</b> - ${rowSelected.desc_m}`);
                $("#modal_plaa_proyecto #resultado_plaa").html(`<b>${rowSelected.nombre_r}</b> - ${rowSelected.desc_r}`);
                $("#modal_plaa_proyecto #accion_plaa").html(`<b>${rowSelected.nombre_a} - ${rowSelected.desc_a}</b>`);

                $("#codp_tipo_proyecto").removeClass(ctxplaa.cssDisabled).removeAttr('disabled');
                $("#nombre_proyecto").removeClass(ctxplaa.cssDisabled).removeAttr('disabled');
                $("#codigo").removeClass(ctxplaa.cssDisabled).removeAttr('disabled');
                ctxgral.showModal('#modal_plaa_proyecto');
            },
            editar: function(index){
                $(".tituloModal span").html(`Modificar datos de proyecto`);
                var selrow = ctxplaa.selrow();
                var proy = selrow.proyectos[index];
                // console.log(proy)
                var rowSelected = ctxplaa.selrow();
                /* coloca los pilares m r y acciones*/
                $("#modal_plaa_proyecto #pmr_plaa").html(`<b>${rowSelected.cod_p} . ${rowSelected.cod_m} . ${rowSelected.cod_r} . ${rowSelected.cod_a}</b>`);
                $("#modal_plaa_proyecto #pilar_plaa").html(`<b>${rowSelected.nombre_p}</b> - ${rowSelected.desc_p}`);
                $("#modal_plaa_proyecto #meta_plaa").html(`<b>${rowSelected.nombre_m}</b> - ${rowSelected.desc_m}`);
                $("#modal_plaa_proyecto #resultado_plaa").html(`<b>${rowSelected.nombre_r}</b> - ${rowSelected.desc_r}`);
                $("#modal_plaa_proyecto #accion_plaa").html(`<b>${rowSelected.nombre_a} - ${rowSelected.desc_a}</b>`);

                /* coloca sus valores de la fila seleccionada*/
                $("#id_arti_pdes_proyecto").val(proy.id_arti_pdes_proyecto);
                $("#id_proyecto").val(proy.id_proyecto);
                $("#codp_tipo_proyecto").val(proy.codp_tipo_proyecto);
                $("#nombre_proyecto").val(proy.nombre_proyecto);
                $("#codigo").val(proy.codigo);
                $("#fecha_ini").val(proy.fecha_ini);
                $("#fecha_fin").val(proy.fecha_fin);

                /* oculta el selector de proyectos (ya no se edita) y deshabilita todas las opciones no editables */
                $(".section_select_id_proyecto").hide();
                $("#proy-ocultos").removeClass('hidden');
                $("#codp_tipo_proyecto").addClass(ctxplaa.cssDisabled).attr('disabled', 'disabled');
                $("#nombre_proyecto").addClass(ctxplaa.cssDisabled).attr('disabled', 'disabled');
                $("#codigo").addClass(ctxplaa.cssDisabled).attr('disabled', 'disabled');

                /* si es producto puede editar el nombre y codigo del proyecto*/
                if(proy.codp_tipo_proyecto == 'prod')  {
                    $("#nombre_proyecto").removeAttr('disabled').removeClass(ctxplaa.cssDisabled);
                    $("#codigo").removeAttr('disabled').removeClass(ctxplaa.cssDisabled).show();
                };
                /* si es de continuidad o accionsector no requiere codigo*/
                if(proy.codp_tipo_proyecto == 'accs' || proy.codp_tipo_proyecto == 'cont'){
                    $(".section_codigo").hide();
                }
                if(proy.codp_tipo_proyecto == 'pdes'){
                    $(".section_codigo").show();
                }
                ctxgral.showModal("#modal_plaa_proyecto");
            },            
            validateRules: function(){                
                return {
                            codp_tipo_proyecto:  { required: 'Debe seleccionar el tipo de proyecto' },
                            nombre_proyecto:  { required: 'El nombre del proyecto es obligatorio' },
                        }; 
            }, 
            saveData: function(){
                var obj = ctxplaa.getDataContent('#modal_plaa_proyecto');
                obj.id_accion = ctxplaa.selrow().id_a;
                obj.id_plan_articulacion_pdes = ctxplaa.selrow().id_pmra;
                $.post(globalSP.urlApi + 'saveartiproyecto', obj, function(resp){
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
                // var rowsel = ctxplaa.selrow();
                swal({
                      title: `Está seguro de eliminar la articulación PDES del plan?`,
                      text: "No podrá recuperar este registro!",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Si, eliminar!",
                      closeOnConfirm: true
                }, function(){
                    $.post(globalSP.urlApi + 'saveartiproyecto', {'id_arti_pdes_proyecto': id, delete: true, _token : ctxgral.token, }, function(res){
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
                        ctxgral.refreshList(ctxplaa);
                    });
                }); 
            },
            estadistics: function(){
                var proys = ctxplaa.source.localdata.reduce(function(acum, el){
                                return acum + el.proyectos.length;
                            },0);
                $("#sp_est_plaa").html('Total de proyectos ' + proys);

                var pils = _.groupBy(ctxplaa.source.localdata, function(elem){
                    return elem.cod_p;
                });
                var html = `<div class="panel-heading">
                                            <span class="panel-icon"><i class="glyphicons glyphicons-bank"></i>
                                            </span>
                                            <span class="panel-title"></span>
                                        </div>`;
                _.mapObject(pils, function(elems, key){
                    var pilar = elems[0];
                    var nproy = elems.reduce(function(acum, el){ return acum + el.proyectos.length; }, 0);
                    html += `<div class="panel-body"> 
                                <div>                                        
                                    <span class="badge badge-hero pull-right bg-system dark" data-toggle="tooltip" data-container="body" data-html="true" title="N° de proyectos ${nproy}">${nproy}</span> 
                                    <img width="50" class=""  src="/img/${pilar.logo_p}"/>
                                   
                                </div> 
                            </div>`;               
                });
                 $("#sp_est_plaa_inds").html(html);
            },
            selrow : function(){
                return ctxplaa.dataTable.jqxDataTable('getSelection')[0];
            }

        }
    



    var init_plaa = (function(){
        

        /* [ {tipo:input, campo:id, placeholder: placeholder, nombre: 'Codigo de Demanda', options: <option></option>, } , {...}]*/
        generaModal = function(objs){

            html= objs.reduce(function(carry, elem){
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
                var html = res.data.reduce(function(retorno, op){
                    return retorno + `<option value="${op.codigo}">${op.nombre} </option>`;
                }, '<option value="">Seleccione el tipo de Proyecto ...</option>');
         
                $("#codp_tipo_proyecto").append(html);
                
            });

            $.get(globalSP.urlApi + "listproyectos", function(res){
                ctxplaa.proyectos = res.data;
            });
            
            /* De los selects*/
            $("#select_id_proyecto").select2({
            }); 

            /* Inicializa fechas*/
            // $('#fecha_ini_picker, #fecha_fin_picker').datetimepicker();


            /*comportamientos del select codp_tipo_proyecto*/
            $("#codp_tipo_proyecto").change(function() {                
                var tipo = $(this).val();
                var t=400; 
                if(tipo == ''){
                    $("#proy-ocultos").addClass('hidden');
                }
                else{
                    $("#proy-ocultos").removeClass('hidden');
                    $(".proy-ocultos").hide(300);
                    $(".proy-ocultos input, .proy-ocultos textarea, .proy-ocultos select").removeAttr('disabled').removeClass(ctxplaa.cssDisabled).val(''); 

                    /* selecciona PDES */
                    if(tipo == 'pdes'){

                        $(".section_select_id_proyecto").show(t); 
                        $(".section_codigo").show(t);
                        $("#codigo").attr('disabled', 'disabled').addClass(ctxplaa.cssDisabled); 
                        var ops = _.chain(ctxplaa.proyectos).filter(function(elem){
                            return elem.codp_tipo_proyecto=='pdes';
                        }).reduce(function(carry, elem){
                            return carry + `<option value="${elem.id}"><b>${elem.codigo} </b>- ${elem.nombre_proyecto}</option>`
                        },'<option value="">seleccione proyecto PDES ...</option>').value();
                        $("#select_id_proyecto").html(ops);    

                    }
                    /* selecciona Accion sector*/
                    else if(tipo == "accs"){
                        $(".section_nombre_proyecto").show(t);
                        $("#nombre_proyecto").attr('disabled', 'disabled').addClass(ctxplaa.cssDisabled);
                        $("#nombre_proyecto").val(ctxplaa.selrow().desc_a);

                    }
                    /* selecciona continuidad*/
                    else if(tipo == "cont"){
                        $(".section_select_id_proyecto").show(t);
                        var ops = ctxplaa.proyectos.reduce(function(carry, elem){
                            return carry +  `<option value="${elem.id}">${elem.codigo} ${elem.nombre_proyecto}</option>`;
                        }, '<option value="">seleccione proyecto...</option>');
                        $("#select_id_proyecto").html(ops);
                    }
                    /*Selecciona Prodcto*/
                    else if(tipo == "prod"){
                        $(".section_nombre_proyecto").show(t);
                        $(".section_codigo").show(t);
                        $("#nombre_proyecto").val('');
                        $("#codigo").val('');
                    }
                } 
            });

            /* Cuando cambia el combo de proyectos se actualiza el input codigo en caso de tipo_proyecto pdes*/
            $("#select_id_proyecto").change(function(){
                if($("#codp_tipo_proyecto").val()=='pdes'){ 
                    var proysel = _.find(ctxplaa.proyectos, function(elem){
                        return elem.id == $("#select_id_proyecto").val();
                    });
                    $("#codigo").val(proysel.codigo);
                };
                proyNombre = $('#select_id_proyecto').find('option:selected').text();
                $("#nombre_proyecto").val(proyNombre);
            }); 





            /* ---------- Contexto plaa ---------------------------------------------------------*/
            ctxplaa.fillDataTable();

            $("#form_plaa").validate(ctxgral.creaValidateRules(ctxplaa));

            $("#planificacion_plaa").on('click', '.sel_add', function(){
                ctxplaa.nuevo()
            });

            $("#planificacion_plaa").on('click', '.sel_edit', function(){
                var index = $(this).attr("index_proy");
                ctxplaa.editar(index);
            });

            $("#planificacion_plaa").on('click', '.sel_delete', function(){
                var id = $(this).attr("id_arti_pdes_proyecto");
                ctxplaa.delete(id);
            });

            $(".sp_cancelar").click(function(){
                $.magnificPopup.close();
            });

            

            // genera_inputgestiones();
        }

        listeners_plaa();

    })();







})






</script>


