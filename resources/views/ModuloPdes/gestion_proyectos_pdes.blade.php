@extends('layouts.plataforma')

@section('header')

<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.light.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.darkblue.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.arctic.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.energyblue.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.dark.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.shinyblack.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.ui-start.css" type="text/css" />

<link rel="stylesheet" href="/plugins/bower_components/bootstrap-urban-master/urban.css" type="text/css"/>
<link rel="stylesheet" href="/plugins/bower_components/select2/dist/css/select2.min.css" type="text/css"/>

<style>
.highlight { background-color: yellow }
</style>

@endsection

@section('content')
<div class="container-fluid">      
    </div>
        <div class="row mb10">
            <div class="col-sm-12 bg-white">
            <h3 class="">Gestión de Proyectos</h3>
            </div>
        </div>
        <div class="row">
            <div id="contenido_proys" class="col-md-8">
                <div class="box white-box p-10">
                    <h3 class="box-title"> Lista de proyectos PDES <b><span id="cantidad_proyectos"></span></b>
                        <button id="btnExcel" class="btn btn-success pull-right" ><i class="fa fa-file-excel-o fa-lg"></i> </button>
                        <button id="btnAgregarEditar" class="btn btn-primary  waves-effect waves-light pull-right"  >  <!-- data-toggle="modal" data-target="#form_proyecto"  --> 
                            <i class="fa fa-plus m-l-5"></i><span> Agregar Proyecto</span> 
                        </button>

                    </h3>
                    <div id='jqxNavBarList'>
                        <div>
                            <b></b>
                        </div>
                        <div>
                            <div id="gridP"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel " id="sel_panel" style="min-height: 100%; max-height: 600px;  overflow-y: scroll; ">
                    <div class="panel panel-heading bg-dark-dark">Detalle Proyecto/programa PDES</div>
                    <div class="panel panel-body p-10 "  style="font-size: 11px; color: #000">
                        <div class="col-sm-12 bg-primary-dark" id="sel_sup"></div>
                        {{-- <div class="col-sm-12 bg-primary-light" id="sel_sup2"></div> --}}
                        <div class="col-sm-12 bg-info-light" id="sel_inf"></div>
                        <div class="col-sm-12 bg-warning" id="sel_inf2"></div>
                    </div> 
                </div>
            </div>
        </div>


<!--=========================================================================================================================== -->
<!--====                                                                FORM                                        =========== -->
<!--====                                                                                                            =========== -->

<form id="form_proyecto" class="modal " role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-dark-light">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title bg-dark-light" id="form_titulo">Proyecto</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" role="form">
                    <input class="hidden"  id="form_id">
                    <div class="form-group">
                        <label class="control-label col-md-3" for="form_nombre_proyecto">Nombre Proyecto</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="form_nombre_proyecto" placeholder="Nombre proyecto">
                        </div>
                    </div>             
                    <div class="form-group">
                        <label class="control-label col-md-3" for="form_codigo">Código</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="form_codigo" placeholder="código" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="form_sector">Sector</label>
                        <div class="col-md-9">
                            <select  class="form-control" id="form_sector" >
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="form_costo_total">Costo total</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="form_costo_total" placeholder="Costo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="form_institucion">Responsable</label>
                        <div class="col-md-9">
                            <select   class="form-control"  id="form_institucion">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="form_resultados">Resultado asociado</label>
                        <div class="col-md-9">
                            <select  id="form_resultados" multiple="">                              
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="form_sisinweb">Proyecto SISIN asociado</label>
                        <div class="col-md-9">
                             <input id="form_sisinweb">
                            {{--  <select id="form_sisinweb" multiple="">
                            </select> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i><span> Cancelar</span></button>
                <button id="btnGuardar" type="submit" class="btn btn-success "  data-dismiss="modal" ><i class="fa fa-check"></i><span> Guardar</span></button>
            </div>
        </div>
    </div>
</form>
<!--=========================================================================================================================== -->


@endsection


@push('script-head')
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxdata.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxmenu.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxradiobutton.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxgrid.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxgrid.sort.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxgrid.filter.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxgrid.selection.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxgrid.columnsresize.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxnavigationbar.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxpanel.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxcheckbox.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/globalization/globalize.js"></script>
<script type="text/javascript" src="/js/jqwidgets-localization.js"></script>

<script type="text/javascript" src="/plugins/bower_components/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="/plugins/underscore/underscore-min.js"></script>

<script type="text/javascript">
jQuery.fn.extend({
    resaltar: function(highlightText){
        var regex = new RegExp("(<[^>]*>)|("+ highlightText.replace(/([-.*+?^${}()|[\]\/\\])/g,"\\$1") +')', 'ig');
        var nuevoHtml=this.html(this.html().replace(regex, function(a, b, c){
            return (a.charAt(0) == "<") ? a : '<span class="highlight">' + c + "</span>";
        }));
        return nuevoHtml;
    }
});
</script>


<script>
$(function () 
{
    var cnf = {
        theme: 'energyblue', //'light', // 'darkblue';
        theme_dark: 'darkblue',
        urlBase: '/api/modulopdes',
        alerta:{
            'cero' : 'bg-orange',
            'positivo' : 'bg-primary-dark'
        },
    }


    var ctxList = {
        listaProyectos: [],
        objSel: null, //objeto seleccionado
        source : {},
        btnAgregar: $("#btnAgregarEditar"),
        btnExcel: $("#btnExcel"),
        cantidad_proyectos: $("#cantidad_proyectos"),
        grid : $("#gridP"),

        llenarLista : function(){
            $("#jqxNavBarList").jqxNavigationBar({theme: cnf.theme_dark, width: '100%', height: 600});
            $.get(cnf.urlBase + '/gestionproyectos', function (resp)
            {
                ctxList.listaProyectos = resp.datos;
                ctxList.source = {
                    datatype: "json",
                    localdata: ctxList.listaProyectos,
                    //url: ''
                    datafields: [
                        {name: 'id', type: 'string'},
                        {name: 'cod_pm', type: 'string'},
                        {name: 'codigo', type: 'string'},
                        {name: 'nombre_proyecto', type: 'string'},
                        {name: 'sector', type: 'string'},
                        {name: 'responsable', type: 'string'},
                        {name: 'costo_total', type: 'string'},
                        {name: 'resultados_count', type: 'integer'},
                        {name: 'sisinweb_count', type: 'integer'},
                    ],
                    id: 'id',
                };
                var dataAdapter = new $.jqx.dataAdapter(ctxList.source);
                var rendererEdit = function (row, columnfield, value, defaulthtml, columnproperties) {
                    html = '<a href="#" id="' + value + '" class="m-l-10 m-r-10 m-t-10" ><i class="fa fa-lg fa-pencil"></i></a>' 
                    // + ' <button class="bprueba" onclick="button1Click(23)">pruebaBTN</button> ';
                    return html;
                };
                var rendererCount = function (row, columnfield, value, defaulthtml, columnproperties) {
                    var bg_color = (value == 0) ? cnf.alerta.cero : cnf.alerta.positivo;
                    html = '<span class="badge m-l-10 m-t-5 ' + bg_color + ' "> ' + value + '</span>';
                    return html;
                };

                ctxList.grid.jqxGrid(
                {
                    ready: function () {   
                        $(".jqx-grid-content").css({"z-index": "100", 'font-size':'9px'
                        });  
                    },
                    theme: cnf.theme,
                    width: '99%',
                    source: dataAdapter,
                    localization: getLocalization('es'),
                    autoheight: true,
                    sortable: true,
                    filterable: true,
                    autoshowfiltericon: true,
                    showfilterrow: true,
                    columnsresize: true,
                    enabletooltips: true,
                    columns: [
                            // {text: 'id', datafield: 'id', sortable: false},
                            {text: 'P.M.', datafield: 'cod_pm', width: 35},
                            {text: 'Cód dem', datafield: 'codigo', cellsalign: 'right', width: 80},
                            {text: 'Proyecto PDES', datafield: 'nombre_proyecto', width: '50%'},
                            {text: 'Sector', datafield: 'sector', },
                            {text: 'Responsable', datafield: 'responsable', },
                            {text: 'Costo ', datafield: 'costo_total', cellsformat: 'f', cellsalign: 'right'},
                            {text: 'Result.', datafield: 'resultados_count', cellsalign: 'center', cellsrenderer: rendererCount, width: 50},
                            {text: 'Sisin', datafield: 'sisinweb_count', cellsalign: 'center', cellsrenderer : rendererCount, width: 50},
                            {text: ' ', datafield: 'id', cellsrenderer: rendererEdit, width: 30},
                        ]
                    });
                ctxList.cantidad_proyectos = ctxList.listaProyectos.length;
            });
        },
        refreshLista : function(idElemSel){
            $.get(cnf.urlBase + "/gestionproyectos", function (resp)
            {
                ctxList.listaProyectos = resp.datos;
                ctxList.source.localdata = ctxList.listaProyectos;
                ctxList.grid.jqxGrid('updatebounddata', 'cells');
                if(idElemSel == '')
                {
                    var indexLast = ctxList.listaProyectos.length - 1;
                    ctxList.grid.jqxGrid('selectrow', indexLast);
                }
            })
        },
        // highlight: function(texto) {
        //     $('.jqx-grid-content').resaltar(texto);
        // },
        // highlightReset: function(){
        //     $('.jqx-grid-content').find('span.highlight').each(function () {
        //         $(this).replaceWith(function () {
        //             return $(this).text();
        //         });
        //     });
        // }
    }

    var ctxForm = {
        form_proyecto : $("#form_proyecto"),
        id: $("#form_id"),
        nombre_proyecto: $("#form_nombre_proyecto"),
        sector: $("#form_sector"),
        codigo: $("#form_codigo"),
        costo_total: $("#form_costo_total"),
        responsable: $("#form_institucion"),
        resultados: $("#form_resultados"),
        sisinweb: $("#form_sisinweb"),
        btnguardar : $("#btnGuardar"),

        limpiar: function () {
            $("#form_proyecto input, #form_proyecto select").val('');
            ctxForm.sector.select2('val','');            
            ctxForm.responsable.select2('val','');
            ctxForm.resultados.select2('val','');
            ctxForm.sisinweb.select2('val','');
        },
        getObjProyecto: function () {
            var objproyecto = {
                id: this.id.val(),
                nombre_proyecto: this.nombre_proyecto.val(),
                sector: this.sector.val(),
                codigo: this.codigo.val(),
                costo_total:  this.costo_total.val().trim().replace(/\./g, '').replace(/,/,'.'),
                responsable: this.responsable.val(),
                resultados: this.resultados.val(),
                sisinweb: this.sisinweb.val()
            }
            return objproyecto;
        },
        setObjProyecto: function (objproyecto) {
            this.limpiar();
            this.id.val(objproyecto.id)
            this.nombre_proyecto.val(objproyecto.nombre_proyecto);
            this.sector.select2('val', objproyecto.sector);
            this.codigo.val(objproyecto.codigo);
            this.costo_total.val(objproyecto.costo_total);
            this.responsable.select2('val', objproyecto.responsable);            
            
            if(objproyecto.resultados.length > 0)
            {
                var resultadosIds = [];
                for(i=0;i<objproyecto.resultados.length; i++)
                    resultadosIds.push(objproyecto.resultados[i].id_r);
                ctxForm.resultados.select2('val', resultadosIds);
            }                

            if(objproyecto.sisinweb_count > 0)
            {
                $.get(cnf.urlBase + '/gestionproyectos/buscar/sisin', {'id_proyecto_pdes': objproyecto.id}, function(res){
                    ctxForm.sisinweb.val('');

                    options = res.datos.map(function(item){
                        return {
                            id : item.codigo_sisin,
                            text:  item.cod_pmra + '-' + item.nombre_proyecto + '<br><b>cod_sisin: </b>' + item.codigo_sisin 
                            + ' <b>Monto presupuestado: </b>' + item.monto_presupuestado + '<br><b>entidad: </b>' + item.entidad 
                            + '<br>' + item.depto + ' - ' + item.prov + ' - '+ item.mun 
                        }
                    })
                    ctxForm.sisinweb.data().select2.updateSelection(options);
                })
            }
        },
        mostrarForm: function (objSel = null) {            
            if (objSel == null) {
            }
            else  {
                this.setObjProyecto(objSel);
            }
            this.validarForm();
            $("#form_proyecto").fadeIn(500).modal();
        },
        
        iniciarResultadosPDES: function() {
            $.get(cnf.urlBase + '/gestionproyectos/listar/resultados', function(res){
                resultados = res.datos;
                ctxForm.resultados.select2({
                    placeholder: 'Seleccione el/los resultados',
                    dropdownParent: $('#form_proyecto'),
                    cache: false,
                    language: "es",
                    formatSelection: function (val) {
                        return "<div title ='" + val.text + "'>" +val.text.substr(0,20) + '...' + "</div>"
                    },
                });
                for(i = 0; i < resultados.length; i++)
                {
                    op = resultados[i];
                    html = '<option value="' + op.id_r + '" > ' + op.descripcion_pmr + '</option> ';
                    ctxForm.resultados.append(html);                    
                }
            })
        },
        iniciarProyectosSisinweb: function() {
                ctxForm.sisinweb.select2({
                    placeholder: 'Seleccione proyecto SISIN - WEB',
                    // dropdownParent: $('#form_proyecto'),
                    minimumInputLength:4,
                    multiple: true,
                    ajax:{
                        url: cnf.urlBase + '/gestionproyectos/buscar/sisin',
                        dataType: 'json',
                        type: 'GET',
                        data: function (params) {
                            return {
                                term: params, // search term
                            };
                        },
                        results: function (data) {
                            var items = data.datos.map(function(obj){
                                return { 
                                    'id': obj.codigo_sisin, 
                                    'text' : obj.cod_pmra + '-' + obj.nombre_proyecto + '<br><b>cod_sisin: </b>' + obj.codigo_sisin 
                                    + /*' <b>Monto presupuestado: </b>' + obj.monto_presupuestado +*/ '<br><b>entidad: </b>' + obj.entidad + '<br><b>sector: </b>' + obj.sector
                                    /*+ '<br>' + obj.depto + ' - ' + obj.prov + ' - '+ obj.mun */
                                }
                            })
                            return { results : items};
                        },
                    },

                    // language: "es",
                    formatResult: function (val) {
                        return "<div>" +val.text + "</div>"
                    },
                    formatSelection: function (val) {
                        return  "<div title ='" + val.text + "'>" +val.text.substr(0,25) + '...' + "</div>"
                    },
                })       
        },
        iniciarSectores: function(){
            $.get(cnf.urlBase + '/gestionproyectos/listar/sectores', function(res){
                var sectores = res.datos;
                for(i=0; i < sectores.length; i++)
                {
                    op = sectores[i];
                    html = '<option value="' + op.sector + '"> ' + op.sector + '</option> ';
                    ctxForm.sector.append(html);
                    $("#sel_sect").append(html);
                }
                ctxForm.sector.select2({
                    placeholder: 'Seleccione sector',
                    dropdownParent: $('#form_proyecto'),
                    cache: false,
                    // language: "es",
                })
            })
        },
        iniciarInstituciones: function(){
            $.get(cnf.urlBase + '/gestionproyectos/listar/instituciones', function(res){
                var instituciones = res.datos;
                for(var i=0; i < instituciones.length; i++)
                {
                    op = instituciones[i];
                    html = '<option value="' + op.nombre + '"> ' + op.descripcion + '</option> ';
                    ctxForm.responsable.append(html);
                    $("#sel_inst").append(html);
                }

                ctxForm.responsable.select2({
                    placeholder: 'Entidad responsable',
                    dropdownParent: $('#form_proyecto'),
                    cache: false,
                    // language: "es",
                });

            })
        },
        validarForm : function(proyectoObj = null){
                $("#form_proyecto small.validacion_error").remove();
                $("#form_proyecto div").removeClass('has-error');
                var i = 0;
                if(proyectoObj)
                {                     
                    function htmlOnError(obj, mensaje){
                        if(obj.siblings('.validacion_error').length == 0)
                        {
                            valError = $('<small  class="bg-danger-dark block pl10 validacion_error" >' + mensaje + '</small>');
                            obj.parent().append(valError).hide().slideDown(400);
                            obj.parent().addClass('has-error');
                        }
                        i++;
                    }
                    //////////// REGLAS DE VALIDACION
                    if(proyectoObj.nombre_proyecto == '') { htmlOnError(ctxForm.nombre_proyecto, 'El Nombre del proyecto es requerido.'); }
                    if(proyectoObj.codigo == '') { htmlOnError(ctxForm.codigo, 'El Código es requerido.'); } 
                    if(isNaN(proyectoObj.codigo)) { htmlOnError(ctxForm.codigo, 'El Código debe contener unicamente números.'); } 
                    if(proyectoObj.sector == '') { htmlOnError(ctxForm.sector, 'El Sector no puede ser vacío.'); } 
                    if(isNaN(proyectoObj.costo_total)) { htmlOnError(ctxForm.costo_total, 'El Costo total no es un numero valido.'); } 
                    $(".validacion_error").show(300);
                }
                return (i==0);
        }

    };

    var ctxElem = {
        panel : $("#sel_panel"),
        sup : $("#sel_sup"),
        // sup2 : $("#sel_sup2"),
        inf : $("#sel_inf"),
        inf2 : $("#sel_inf2"),

        htmlGen: function(){
            var htmlSup = function(){
                var objSel = ctxList.objSel;
                var htmlsup = '<h4>Proyecto PDES: <button id="sel_btn_editar" class="btn btn-xs btn-primary pull-right"><span> editar </span><i class="fa fa-pencil "></i></button></h4>'
                +'<div><h5 class="bg-primary-dark">' + objSel.nombre_proyecto + '</h5>'
                +'ID: ' + objSel.id + ' </div>' 
                +'<div class="bg-white" style="color: #333"> '
                +'    <ul class="list-group m-2">'
                +'        <li class="list-group-item">'
                +'            </br><b>PILAR ' + objSel.cod_p + '</b>: ' + objSel.desc_p  
                +'            </br><b>META ' + objSel.cod_m + '</b>: ' + objSel.desc_m  
                +'            <div><b>Código</b>: ' +  objSel.codigo 
                +'            </br><b>Sector: </b>' +  objSel.sector  
                +'            </br><b>Responsable: </b>' +  objSel.responsable  
                +'            </br><b>Costo total: </b>' +  objSel.costo_total   
                +'            </div> '
                +'        </li> '
                +'    </ul>';

                badgeColor = objSel.resultados_count > 0   ? cnf.alerta.positivo : cnf.alerta.cero;         
                htmlsup += '<h5 class="p-10 "<b>Resultados asociados </b><span class="badge ' + badgeColor + ' pull-right">'+ objSel.resultados_count + '</span></h5>';
                if(objSel.resultados_count > 0)
                {
                    htmlsup += '<ul class="list-group m-2">';
                    for (var i = 0; i < objSel.resultados.length; i++) {
                        var r = objSel.resultados[i];
                        htmlsup += '<li class="list-group-item">'
                        +'<div><b> Pilar ' + objSel.cod_p + ', Meta ' + objSel.cod_m + ', Resultado ' + r.cod_r + ' ( ' + r.cod_pmr + ' )</b>'
                        +'    <br><b>Resultado '  + r.cod_r  +': </b> ' + r.desc_r 
                        +'</div>'
                        +'</li>';
                    }
                    htmlsup += '</ul>'
                    +'</div>';
                };
                ctxElem.sup.html(htmlsup); 
            };
            var htmlInf = function(){
                var badgeCountPullRight = '';
                var htmlinf ='<h5 class="p10"><b>Pilar, Meta, Res, Accion de Proyecto en SP </b>  ......- </h5>' ; // los caracteres ......- se remplazaran mas adelante por el numero correspondiente en la variable badgeCountPullRight
                ctxElem.inf.html(htmlinf);
                $.get(cnf.urlBase + '/gestionproyectos/sp/obtener_proyecto_sp/' + ctxList.objSel.codigo, function(res){
                    var proyectoSP = res.data;
                    if(res.mensaje != 'ok')
                    {
                        htmlinf += '<div class="bg-white" style="color: #111"><b>' + res.mensaje + '</b></div>';
                    }
                    else
                    { 
                        // htmlinf+= '<div><h5 class="bg-info-light">' + proyectoSP.nombre_proyecto +'</h5></div>'
                        // + '<div class="bg-white" style="color: #333">';
                        // + '     <ul class="list-group m-2">'
                        // + '         <li class="list-group-item">'
                        // + '         <div><b>Código</b>: ' +  proyectoSP.codigo 
                        // + '         </br><b>Sector: </b>' +  proyectoSP.sector  
                        // + '         </br><b>Costo total: </b>' +  proyectoSP.total_costo  
                        // + '         </div></li>'
                        // + '     </ul>';

                        if(proyectoSP.contextoProyecto)
                        { 
                            badgeColor = cnf.alerta.positivo;  
                            badgeCountPullRight = '<span class="badge ' + badgeColor + ' pull-right">'+ proyectoSP.contextoProyecto.length + '</span> ';      
                            htmlinf += 
                                '<div class="bg-white" style="color: #333">'
                                +'<ul class="list-group m-2">';
                            for (var i = 0; i < proyectoSP.contextoProyecto.length; i++) {
                                var r = proyectoSP.contextoProyecto[i];
                                // responsables = 
                                htmlinf += '<li class="list-group-item">'
                                +'      <div><b> Pilar: ' + r.cod_p + ', Meta: ' + r.cod_m + ', Resultado: ' + r.cod_r + ', Accion: ' + r.cod_a + ', ( ' + r.cod_pmra + ' )</b>'
                                +'          <br><b>Resultado: </b>' + r.desc_r 
                                +'          <br><b>Accion: </b>' + r.desc_a
                                +'      </div>'
                                +'      <div>'
                                +'          <b>Entidad Ejecutora: </b>' + r.ejecutor 
                                +'          <br><b>Entidades Responsables: </b>' 
                                +'          <ul>'
                                +       r.responsables.reduce(function(anterior, item){
                                    return anterior + '<li>' + item + '</li>';
                                },'') 
                                +'          </ul>'
                                +'          <br><b>Indicadores de Proceso: </b>' + r.desc_indicador_proceso
                                +'      </div>'
                                +'</li>';                        }
                                htmlinf += '</ul>';
                        }
                        else
                        {
                            badgeColor = cnf.alerta.cero;         
                            badgeCountPullRight = '<span class="badge ' + badgeColor + ' pull-right">'+ 0 + '</span> ';  
                        }

                        htmlinf += '</div>' ;
                        htmlinf = htmlinf.replace('......-', badgeCountPullRight);
                        ctxElem.inf.html(htmlinf);
                    }
                });
                

            };    
            var htmlInf2 = function(){
                var objSel = ctxList.objSel;
                badgeColor = objSel.sisinweb_count > 0   ? cnf.alerta.positivo : cnf.alerta.cero;  
                var htmlInf2 = '<h5 class="p10"><b>Proyectos SISINWEB vinculados con el proyecto </b> <span class="badge ' + badgeColor + ' pull-right">'+ objSel.sisinweb_count + '</span></h5>';
                ctxElem.inf2.html(htmlInf2);
                if(objSel.sisinweb_count > 0)
                {
                    $.get(cnf.urlBase + '/gestionproyectos/buscar/sisin', {'id_proyecto_pdes': objSel.id}, function(res){
                        htmlInf2 += '<ul class="list-group bg-white m-2" style="color: #333">';

                        sisingroup = _.chain(res.datos).groupBy(function(item){ return item.codigo_sisin}).values().value();
                        for (var i = 0; i < sisingroup.length; i++) {
                            var sw = sisingroup[i][0];
                            htmlInf2 += '<li class="list-group-item">'
                            + '<div><h5 clas="bg-warning-light"><b>Codigo sisin: ' + sw.codigo_sisin +'</b></h5>'
                            + '<b> Nombre proy. SISIN: ' + sw.nombre_proyecto + '</b>'
                            + '</br>Pilar: ' + sw.cod_p + ', Meta: ' + sw.cod_m + ', Resultado: ' + sw.cod_r + ', Accion: '+ sw.cod_a + ' ('+ sw.cod_pmra + ')</b>'
                            + '</br><b>Proyectos por lugares y presupuesto </b> <span class="badge bg-default">' + sisingroup[i].length + '</span>' 
                            + '</div>';

                            var desagregados = _.reduce(sisingroup[i], function(anterior, item){
                               return anterior  + '<div>'
                                                + '     </br>Entidad: ' + item.entidad 
                                                + '     </br>Monto presupuestado: ' + item.monto_presupuestado  
                                                + '     </br>Lugar: ' + item.depto + ', ' + item.prov + ', ' + item.mun       
                                                + '</div>';

                            }, '');
                            console.log(desagregados);
                            htmlInf2 += desagregados;

                        }
                        htmlInf2 += '</li></ul>'
                        ctxElem.inf2.html(htmlInf2);
                    });
               };
                // return htmlInf2
            }

            htmlSup();
            htmlInf()
            htmlInf2(); 
        },
    };

    ctxForm.limpiar();
    ctxList.llenarLista();

    setTimeout(function () {
        ctxForm.iniciarSectores();
        ctxForm.iniciarResultadosPDES();
        ctxForm.iniciarProyectosSisinweb();
        ctxForm.iniciarInstituciones();
        // console.log("despues de 3 seg");
    }, 3000); 

    
    // Al hacer click en agregar muestra el formulario modal vacio //////////////////////////////////////
    ctxList.btnAgregar.click(function () {
        ctxForm.limpiar();
        ctxForm.mostrarForm();
        ctxForm.nombre_proyecto.focus();
    });

    // al seleccionar una fila , muestra el objeto correspondiente ///////////////////////////
    ctxList.grid.on('rowselect', function (event) {
        index = event.args.rowindex;
        ctxList.objSel = ctxList.listaProyectos[index];
        ctxElem.htmlGen();
    });

    // al hacer click sobre una celda compara si es sobre el boton editar luego muestra el formulario modal con el elemento //////////////////////
    ctxList.grid.on('cellclick', function (event) {
        var columna = event.args.datafield;
        index = event.args.rowindex;        
        if (columna == 'id') {
            ctxList.objSel = ctxList.listaProyectos[index];
            ctxForm.mostrarForm(ctxList.objSel);
        }
    });    

    // ctxList.grid.on('filter', function (event) {
    //     ctxList.highlightReset();
    //     var filtros = $(".jqx-grid-cell-filter-row input");
    //     if(filtros[1].value != '')
    //     {
    //         ctxList.highlight(filtros[1].value)   // indice 1 es donde esta el filtro de la columna nombre_proyecto
    //     }
    // }); 

    // al hacer click sobre el boton editar del elemento seleccionado //////////////////////////////
    ctxElem.panel.on('click', '#sel_btn_editar', function(){
        if(ctxList.objSel != null)
        {
            ctxList.objSel = ctxList.listaProyectos[index];
            ctxForm.mostrarForm(ctxList.objSel);
        }
    });

    // Al hacer click en el boton guardar de la ventana MOdal /////////////////////////////////////////////////
    ctxForm.btnguardar.click(function () {
        var proyecto = ctxForm.getObjProyecto();
        console.log(proyecto)
        if(ctxForm.validarForm(proyecto)) 
        {
            proyecto._token =  $('input[name=_token]').val();
            // $.post(cnf.urlBase + '/gestionproyectos', proyecto, function () {
            //     ctxList.refreshLista(proyecto.id);
            // }); 
        }
        else
            return false;
    });

    ctxList.btnExcel.click(function(){
        location.href = cnf.urlBase + '/gestionproyectos/export/excel'
    });


});
</script>

<script type="text/javascript">
$(function()
{
    function activarMenu(id,aux){
        $('#'+id).addClass('active');
        $('#'+aux).addClass('activeaux');
    }

    function menuModulosHideShow(ele){
        //1 hide
        //2 show
        switch (ele) {
            case 1:
            $("body").addClass("content-wrapper")
            $(".open-close i").removeClass('icon-arrow-left-circle');
            $(".sidebar").css("overflow", "inherit").parent().css("overflow", "visible");
            break;
            case 2:
            $("body").removeClass('content-wrapper');
            $(".open-close i").addClass('icon-arrow-left-circle');
            $(".logo span").show();
            break;
        }
    }

    activarMenu('mod-1','mp-4');
    menuModulosHideShow(1);

})

</script>
@endpush
