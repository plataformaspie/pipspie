@extends('layouts.plataforma')

@section('header')

<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.base.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.light.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.darkblue.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.arctic.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.energyblue.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.dark.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.shinyblack.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.ui-start.css') }}" type="text/css" />

<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-urban-master/urban.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('plugins/bower_components/select2/dist/css/select2.min.css') }}" type="text/css"/>

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
                    <h3 class="box-title"> Lista de proyectos PDES 
                        <button id="btnAgregarEditar" class="btn btn-primary  waves-effect waves-light pull-right"  >  <!-- data-toggle="modal" data-target="#form_proyecto"  --> 
                            <i class="fa fa-plus m-l-5"></i><span> Agregar Proyecto</span> 
                        </button>
                    </h3>
                    <div id='jqxNavBarList'>
                        <div>
                            <b> </b>
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
                    <div class="panel panel-body p-10"  style="font-size: 11px; color: #1D181FFF">
                        <div class="col-sm-12 bg-primary-dark" id="sel_sup"></div>
                        <div class="col-sm-12 bg-info-light" id="sel_inf"></div>
                        <div class="col-sm-12 bg-warning-light" id="sel_inf2"></div>
                    </div> 
                </div>
            </div>
        </div>


<!--=========================================================================================================================== -->
<!--====                                                                FORM                                        =========== -->
<!--====                                                                                                           =========== -->

<form id="form_proyecto" class="modal fadein " role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-dark-dark">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title bg-dark-dark" id="form_titulo">Proyecto</h4>
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
                             <select id="form_sisinweb" multiple="">
                            </select>
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
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxcore.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxdata.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxbuttons.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxscrollbar.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxmenu.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxlistbox.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxdropdownlist.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxradiobutton.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxgrid.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxgrid.sort.js')}}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxgrid.filter.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxgrid.selection.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxgrid.pager.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxgrid.columnsresize.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxnavigationbar.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxcombobox.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxpanel.js')}}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxcheckbox.js')}}"></script>

<script type="text/javascript" src="{{ asset('plugins/bower_components/select2/dist/js/select2.min.js')}}"></script>
<!-- <script type="text/javascript" src="{{ asset('plugins/highlight.js')}}"></script> -->

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

    var cnf = {
        theme: 'light', //'light', // 'darkblue';
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
        grid : $("#gridP"),

        llenarLista : function(){
            $("#jqxNavBarList").jqxNavigationBar({theme: cnf.theme_dark, width: '100%', height: 600});
            $.get(cnf.urlBase + '/proyectosgestion', function (resp)
            {
                ctxList.listaProyectos = resp.datos;
                ctxList.source = {
                    datatype: "json",
                    localdata: ctxList.listaProyectos,
                    //url: ''
                    datafields: [
                        {name: 'id', type: 'string'},
                        {name: 'codigo', type: 'string'},
                        {name: 'nombre_proyecto', type: 'string'},
                        {name: 'sector', type: 'string'},
                        {name: 'responsable', type: 'string'},
                        {name: 'costo_total', type: 'numeric'},
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
                        $(".jqx-grid-content").css({"z-index": "100", 'font-size':'10px'
                        });  
                    },
                    theme: cnf.theme,
                    width: '95%',
                    source: dataAdapter,
                    autoheight: true,
                    sortable: true,
                    filterable: true,
                    autoshowfiltericon: true,
                    showfilterrow: true,
                    columnsresize: true,
                    enabletooltips: true,
                    columns: [
                        // {text: 'id', datafield: 'id', sortable: false},
                        {text: 'codigo', datafield: 'codigo', cellsalign: 'right'},
                        {text: 'nombre Proyecto', datafield: 'nombre_proyecto', width: '50%'},
                        {text: 'Sector', datafield: 'sector', },
                        {text: 'Responsable', datafield: 'responsable', },
                        {text: 'Costo ', datafield: 'costo_total', cellsformat: 'D', cellsalign: 'right'},
                        {text: 'Result.', datafield: 'resultados_count', cellsalign: 'center', cellsrenderer: rendererCount, width: 50},
                        {text: 'Sisin', datafield: 'sisinweb_count', cellsalign: 'center', cellsrenderer : rendererCount, width: 50},
                        {text: ' ', datafield: 'id', cellsrenderer: rendererEdit, width: 30},
                        ]
                    });
            });
        },
        refreshLista : function(idElemSel){
            $.get(cnf.urlBase + "/proyectosgestion", function (resp)
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
        highlight: function(texto) {
            $('.jqx-grid-content').resaltar(texto);
        },
        highlightReset: function(){
            $('.jqx-grid-content').find('span.highlight').each(function () {
                $(this).replaceWith(function () {
                    return $(this).text();
                });
            });
        }

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
                costo_total: this.costo_total.val(),
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

            if(objproyecto.sisinweb.length > 0)
            {
                var sisinWebIds = [];
                for(i=0;i<objproyecto.sisinweb.length; i++)
                    sisinWebIds.push(objproyecto.sisinweb[i].id_sisinweb);
                ctxForm.sisinweb.select2('val', sisinWebIds);
            }
        },
        mostrarForm: function (objSel = null) {            
            if (objSel == null) {
            }
            else  {
                this.setObjProyecto(objSel);
            }
            this.validarForm('hide');
            $("#form_proyecto").modal();
        },
        // iniciarResultadosPDES: function() {
        //     // $.get(cnf.urlBase + '/proyectosgestion/listar/resultados', function(res){
        //         // resultados = res.datos;
        //         // datos = [];
        //         // 
        //         // 
        //         // 
        //         // for(i = 0; i < resultados.length; i++)
        //         // {
        //         //     op = resultados[i];
        //         //     datos.push({
        //         //         'id' : op.id_r,
        //         //         'text': op.descripcion_pmr
        //         //     })


        //             // html = '<option value="' + op.id_r + '" > ' + op.descripcion_pmr + '</option> ';
        //             // ctxForm.resultados.append(html);                    
        //         // }
        //         ctxForm.resultados.select2({
        //             ajax: {
        //                 url: cnf.urlBase +  '/proyectosgestion/listar/resultados',
        //                 dataType: 'json',
        //                 delay: 250,
        //                 data: function (params) {
        //                     var query = {
        //                         search: params.term,
        //                         type: 'public'
        //                     }
        //                       return query;
        //                 },

        //             },
        //             minimumInputLength:4,                    
        //             placeholder: 'Seleccione el/los resultados',
        //             // data: datos,
        //             dropdownParent: $('#form_proyecto'),
        //             cache: false,
        //             // allowClear:true,
        //             // language: "es",
        //             formatResult: function (val) {
        //                 return "<div title ='" + val.text + "'>" +val.text + "</div>"
        //             },
        //             formatSelection: function (val) {
        //                 return "<div title ='" + val.text + "'>" +val.text.substr(0,20) + '...' + "</div>"
        //             },
        //         });

        //     // })
        // },

        
        iniciarResultadosPDES: function() {
            $.get(cnf.urlBase + '/proyectosgestion/listar/resultados', function(res){
                resultados = res.datos;
                ctxForm.resultados.select2({
                    placeholder: 'Seleccione el/los resultados',
                    dropdownParent: $('#form_proyecto'),
                    cache: false,
                    allowClear:true,
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
            $.get(cnf.urlBase + '/proyectosgestion/listar/sisinweb', function(res){
                sisinweb = res.datos;
                ctxForm.sisinweb.select2({
                    placeholder: 'Seleccione proyecto SISIN-WEB',
                    dropdownParent: $('#form_proyecto'),
                    cache: false,
                    allowClear:true,
                    language: "es",
                    formatResult: function (val) {
                        return "<div>" +val.text + "</div>"
                    },
                    formatSelection: function (val) {
                        return  "<div title ='" + val.text + "'>" +val.text.substr(0,25) + '...' + "</div>"
                    },
                })
                for(i=0; i < sisinweb.length; i++)
                {
                    op = sisinweb[i];
                    opcionNombre = op.cod_accion_plan + '- '+ op.nombre_proyecto //+ ' --<b> CODIGO:</b> ' + op.codigo_sisin + ' -- ' + op.depto  + ' - ' + op.prov + ' - '  + op.mun;
                    html = '<option value="' + op.id + '" > ' + opcionNombre + '</option> ';
                    ctxForm.sisinweb.append(html);
                }
            })
        },
        iniciarSectores: function(){
            $.get(cnf.urlBase + '/proyectosgestion/listar/sectores', function(res){
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
                    // allowClear:true,
                    // language: "es",
                })

            })
        },
        iniciarInstituciones: function(){
            $.get(cnf.urlBase + '/proyectosgestion/listar/instituciones', function(res){
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
                    // allowClear:true,
                    // language: "es",
                });

            })
        },
        validarForm : function(op=''){
            if(op=='') {
                ctxForm.validarForm('hide');
                var i = 0;
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
                if(ctxForm.nombre_proyecto.val() == '') { htmlOnError(ctxForm.nombre_proyecto, 'El Nombre del proyecto es requerido.'); }
                if(ctxForm.codigo.val() == '') { htmlOnError(ctxForm.codigo, 'El Código es requerido.'); } 
                if(isNaN(ctxForm.codigo.val())) { htmlOnError(ctxForm.codigo, 'El Código debe contener unicamente números.'); } 
                if(ctxForm.sector.val() == '') { htmlOnError(ctxForm.sector, 'El Sector no puede ser vacío.'); } 
                if(isNaN(ctxForm.costo_total.val())) { htmlOnError(ctxForm.costo_total, 'El Costo total no es un numero valido.'); } 
                $(".validacion_error").show(300);
                return (i==0);
            }
            if(op=='hide')
            {
                $("#form_proyecto small.validacion_error").remove();
                $("#form_proyecto div").removeClass('has-error');
            }
        }

    };

    var ctxElem = {
        panel : $("#sel_panel"),
        sup : $("#sel_sup"),
        inf : $("#sel_inf"),
        inf2 : $("#sel_inf2"),
        htmlGen: function(){
            var htmlSup = function(){
                var objSel = ctxList.objSel;
                return '<h4>Proyecto: <button id="sel_btn_editar" class="btn btn-xs btn-primary pull-right"><span> editar </span><i class="fa fa-pencil "></i></button></h4>' 
                + '<div><h5 class="bg-primary-dark">' + objSel.nombre_proyecto +'</h5>'
                + 'ID: ' + objSel.id + '</div>'  
                + '<ul class="list-group bg-white m-2">'
                + '<li class="list-group-item">'
                + '<div><b>Código</b>: ' +  objSel.codigo 
                + '</br><b>Sector: </b>' +  objSel.sector  
                + '</br><b>Responsable: </b>' +  objSel.responsable  
                + '</br><b>Costo total: </b>' +  objSel.costo_total  
                + '</div></li>'
                + '</ul>';
            };
            var htmlInf = function() { 
                var objSel = ctxList.objSel;
                badgeColor = objSel.resultados_count > 0   ? cnf.alerta.positivo : cnf.alerta.cero;         
                var htmlInf = '<b>Resultados asociados </b> <span class="badge ' + badgeColor + ' pull-right">'+ objSel.resultados_count + '</span>';
                if(objSel.resultados_count > 0)
                {
                    htmlInf += '<ul class="list-group bg-white m-2">';
                    for (var i = 0; i < objSel.resultados.length; i++) {
                        var r = objSel.resultados[i];
                        htmlInf += '<li class="list-group-item">'
                        + '<div><b> Pilar: ' + r.cod_p + ', Meta: ' + r.cod_m + ', Resultado: ' + r.cod_r + ', ( ' + r.cod_pmr + ' )</b>'   
                        + '<br><b>Descripción R: </b>' + r.desc_r 
                        + '<br><b>Código R: </b>' + r.cod_r      
                        + '</div></li>';
                    }
                    htmlInf += '</ul>'
                };
                return htmlInf
            };
            var htmlInf2 = function(){
                var objSel = ctxList.objSel;
                badgeColor = objSel.sisinweb_count > 0   ? cnf.alerta.positivo : cnf.alerta.cero;  
                var htmlInf2 = '<b>Proyectos SISINWEB asociados </b> <span class="badge ' + badgeColor + ' pull-right">'+ objSel.sisinweb_count + '</span>';
                if(objSel.sisinweb_count > 0)
                {
                    htmlInf2 += '<ul class="list-group bg-white m-2">';
                    for (var i = 0; i < objSel.sisinweb.length; i++) {
                        var sw = objSel.sisinweb[i];
                        htmlInf2 += '<li class="list-group-item">'
                        + '<div><b> Nombre proy. SISINWEB: ' + sw.sw_nombre_proyecto + '</b>'
                        + '</br><b>Codigo sisinweb: ' + sw.sw_codigo +'</b>'
                        + '</br>Pilar: ' + sw.sw_cod_p + ', Meta: ' + sw.sw_cod_m + ', Resultado: ' + sw.sw_cod_r + ', ('+ sw.cod_pmr + ')</b>'     
                        + '</br>Entidad: ' + sw.sw_entidad 
                        + '</br>Monto presupuestado: ' + sw.sw_monto_presupuestado  
                        + '</br>Lugar: ' + sw.sw_depto + ', ' + sw.sw_prov + ', ' + sw.sw_mun       
                        + '</div></li>';
                    }
                    htmlInf2 += '</ul>'
                };
                return htmlInf2
            }

            ctxElem.sup.html(htmlSup());
            ctxElem.inf.html(htmlInf());
            ctxElem.inf2.html(htmlInf2());
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

    ctxList.grid.on('filter', function (event) {
        ctxList.highlightReset();
        var filtros = $(".jqx-grid-cell-filter-row input");
        if(filtros[1].value != '')
        {
            ctxList.highlight(filtros[1].value)   // indice 1 es donde esta el filtro de la columna nombre_proyecto
        }
    }); 

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
        if(ctxForm.validarForm()) 
        {
            proyecto._token =  $('input[name=_token]').val();
            $.post(cnf.urlBase + '/proyectosgestion', proyecto, function () {
                ctxList.refreshLista(proyecto.id);
            }); 
        }
        else
            return false;
    });


});
</script>
@endpush
