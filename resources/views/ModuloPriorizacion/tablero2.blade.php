@extends('layouts.plataforma')

@section('header')
{{-- <link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.light.css" type="text/css"/>
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.darkblue.css" type="text/css"/>
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.energyblue.css" type="text/css"/>
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.ui-overcast.css" type="text/css"/> --}}

<link rel="stylesheet" href="/plugins/amcharts3.21.8/plugins/export/export.css" type="text/css" media="all" />
<link rel="stylesheet" href="/css/visores.css" type="text/css" />

<link rel="stylesheet" type="text/css" href="/plugins/modify/pivot___.css">
<link rel="stylesheet" href="/plugins/bower_components/bootstrap-urban-master/urban.css" type="text/css" />
<style>

.sidenav {
    position: absolute;
    z-index: 1;
    background-color: #fff;
    overflow-x: hidden;
    transition: 1s;
    margin: 0px 0px 0px -20px;
}
.menuDetail{
    margin: 0px 0px 0px -20px;
    padding: 55px 2px 5px 72px ;
    overflow-y: scroll;
    /*transition: width 1s, margin-left 1s;*/
    font-size: 12px;
}
.sidenav a {
    text-decoration: none;
    color: #818181;
    display: block;
    transition: 3s;
}

.sidenav a:hover, .menuDetail a:hover {
    /*color: #f1f1f1;*/
    background-color: #F5F5DC;
}

.tituloDetail{
    color: #333;
}

.activoPri{
   background-color: #444449 !important; /* 4c5064 dark-dark */
   color: #f1f1f1 !important;
   border-color: #aed248;
}
.activoSub{
   background-color: #ABEBC6   !important;
   border-color: #aed248;
}

/*#contenido {
    transition: margin-left 1s;
    margin-left: 70px;
}*/
/*
@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 12px;}
}*/

#chartdiv {
    width   : 100%;
    height  : 500px;
} 

.jqx-pivotgrid{
    background-color: #fff;
}

/*.pvtTotal, .pvtTotalLabel, .pvtGrandTotal {display: none}*/
</style>
@endsection


@section('content')
<div class='container-fluid'>
    <div class=row>
    
        <div class="col-md-3">
            <div id="menuPrincipal"  class="sidenav list-group bordered border-default rounded-right w300" style="height: 720px">
                <div href="#" id='btnmenu' class="p5" style="cursor: pointer;">
                    <i class="fa fa-bars fa-3x pull-right"></i>
                </div>   
            </div>
            <div id="menuDetalle" class="menuDetail " style="height: 720px;" >
            </div>
        </div>    
    
        <div class="col-md-9 ">
            <div class="row">
                <div id="contenedorPredefinidos" class="col-sm-12 stats-row m-0 bg-white p-3" >
                </div>
            </div>
            <div class="row m-0">
                <div id="contenedorDatos" style="height: 1000px; max-height: auto; width: 100%"  class="bg-white p15 mt-1" style="overflow-y: scroll;"> 

                    <div id="divTitulo" class="row">
                        <div id="titulo" class="col-sm-9"></div>
                        <div class="col-sm-3">      
                  
                            <a href="#" id="btn_grafico" class="btn btn-default btn-xs  " ><i class="fa fa-2x fa-bar-chart"></i></a>
                            <a href="#" id="btn_tabla" class="btn btn-default btn-xs "><i class="fa fa-2x fa-table"></i></a>
                            
                            <a  class="dropdown-toggle pull-right btn btn-xs" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                                <i class="fa fa-2x fa-cog bg-dark-light pr5 pl5 bordered round"></i><span ></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href=# id="predef_update"><i class="fa fa-save fa-2x"></i><span> Guardar la configuración actual  </span></a></li>
                                <li><a href=# id="predef_new"><i class="fa fa-clone fa-2x"></i><span> Guardar como una conf. nueva     </span></a></li>
                                <li><a href=# id="predef_del"><i class="fa fa-trash-o fa-2x bg-warning-dark"></i><span> Eliminar configuarción actual  </span></a></li>                                   
                            </ul>
                        </div>
                    </div>

                    <div id='divGrafico'>
                        <div id="tituloGrafico" class="mb15"></div>

                        <select id="opcionesGrafico" onchange="ctxGra.graficarH(this);" >
                            <option value="line">Linea</option> 
                            <option value="column">Columnas</option>
                            <option value="column-stacked">Columnas apiladas</option>    
                            <option value="column-stackedp">Columnas apiladas en proporcion</option>                            
                            <option value="bar">Barras</option> 
                            <option value="bar-stacked">Barras apiladas</option>    
                            <option value="bar-stackedp">Barras apiladas en proporcion</option>  
                            <option value="area">Area</option>
                            <option value="area-stacked">Areas apiladas</option>    
                            <option value="area-stackedp">Areas apiladas en proporcion</option>
                        </select>
                        <div id="divChart" style="font-family: arial; width: 90%; min-height: 600px; margin: 0 auto"></div>
                    </div>

                    <div id='divDatos' class="">
                        <div id=tituloDatos class="mb15"></div>
                        <div class="row m-0 bg-white mt-2" style="overflow: scroll; width: 100%; height: 600px;padding: 2px">
                            <div id="pvtTable"></div>                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalConfig" class="modal  " role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-dark-light">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title bg-dark-light" id="modal_titulo"></h4>
                <input class="hidden"  id="accion">
            </div>
            <div class="modal-body" >
                <div>
                    <div class="stat-item item_campo_predefinido containertipoimg col-sm-2 offset-5"  title=''  style="cursor:pointer;">
                        <img id="imagen"  src='' alt='' class="image" style="width:80px;height:60px">
                        <div class="filt" >
                            <div id='dixTextoImagen' class="text"></div>
                        </div>
                    </div>
                </div>
                <div class="form-horizontal" role="form" id='predefNewUpdate'>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3" for="predef_nombre">Nombre</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="predef_nombre" placeholder="Nombre ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="predef_etiqueta">Etiqueta visible</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="predef_etiqueta" placeholder="Etiqueta visible ">
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="control-label col-md-3" for="predef_imagen">imagen</label>
                        <div id="selectImagenes" class="col-md-9">
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="control-label col-md-3" for="predef_posicion">Posicion</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="predef_posicion" placeholder="Posicion 1,2,3.. ">
                        </div>
                    </div> 
                </div>

                <div id="predefDel">
                    <div class="bg-danger-dark row" style="border-radius: 6px">
                        <div class="col-sm-2">
                            <i class="fa fa-exclamation-triangle fa-3x mt15"></i>
                        </div>
                        <div class="col-sm-9">
                            <h5 >Se va a Eliminar la configuración que esta actualmente visualizando. Si elimina se perdará definitivamente dicha configuracion de visualizacion, pero no los datos mostrados.</h5>
                        </div>
                    </div>
                    <h4 class="text-danger"><i class="fa fa-danger"></i> <span><b>Esta seguro que desea eliminar la configuarcion de visualizacion de datos actual ?</b></span></h4>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnCancelar" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i><span> Cancelar</span></button>
                <button id="btnGuardar" type="submit" class="btn btn-success "  data-dismiss="modal" ><i class="fa fa-check"></i><span> Aceptar</span></button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script-head')
<script type="text/javascript" src="/plugins/Highcharts-6.0.4/code/highcharts.js"></script>
<script type="text/javascript" src="/plugins/Highcharts-6.0.4/code/highcharts-3d.js"></script>
<script type="text/javascript" src="/plugins/Highcharts-6.0.4/code/modules/exporting.js"></script>

<script type="text/javascript" src="/plugins/pivottable/dist/jquery-ui.min.js"></script>
<script type="text/javascript" src="/plugins/modify/pivot___.js"></script>
<script type="text/javascript" src="/plugins/modify/pivot___.es.js"></script>

<script type="text/javascript" src="/plugins/underscore/underscore-min.js"></script>


{{-- *********************  MAIN APP ************************ --}}
<script type="text/javascript">
    /*-----------------------------------------------------------------------
     *      cnf variables de configuracion  del modulo, como coleres, iconos y otros
     */
    var cnf = {
        m : {   // m menu
            activoPri : 'activoPri',
            activoSub : 'activoSub',
            bgSub : 'bg-dark-dark',
            bgHeaderSub : 'bg-dark-light',
            bgTituloSub : 'bg-default-light tituloDetail',
            img : {
                '01' : '/img/priori-1.png',
                '02' : '/img/priori-2.png',
                '03' : '/img/priori-3.png',
                '04' : '/img/priori-4.png',
                '05' : '/img/priori-5.png',
            },
        },
        c : {  // c contenido
            img: {  // buscara si key departamento existe en r_departamento de configuracion.campos_predefinidos.campo, con contains 
                'imagen_por_default':'/img/icon-graf/3.png',
                '1':'/img/icon-graf/1.png',
                '2':'/img/icon-graf/2.png',
                '3':'/img/icon-graf/3.png',
                '4':'/img/icon-graf/4.png',
                '5':'/img/icon-graf/5.png',
                '6':'/img/icon-graf/6.png',
                'departamento':'/img/icon-graf/r_departamento.png',  
                'urbano_rural':'/img/icon-graf/r_urbano_rural.png',
                'genero':'/img/icon-graf/genero.png',
                'pobreza_extrema':'/img/icon-graf/pex.png',
                'pobreza_moderada':'/img/icon-graf/pmo.png',
                'desempleo':'/img/icon-graf/desem.png',
            },            
        },

    }

    /*-----------------------------------------------------------------------
     *      ctxG variable que contiene el contexto global, variables globales
     */
    var ctxG = {
        nodos : [],
        nodoSel : {},  // elemento menu  nodo seleccionado
        varEstActual : {},    // objeto JSON VariableEstadisticaActual del nodoSel.configuracion 
        collection : [],
        indicadorActual: {},
        pivotInstancia:{},
        pivot:{
            data : [], // Datos del pivot  en formato collection 
            dataGraph : [],
            dimColumna : [],
            dimFila : [],
            total: 0, t_cols : {}, t_filas : {}, total_p : 0, tp_cols : {}, tp_filas: {},
        },
    }

    /*-----------------------------------------------------------------------
     *      ctxM variable que contiene el contexto del menu , 
     */
    var ctxM = {
        menuPrincipal : $("#menuPrincipal"), 
        menuDetalle : $("#menuDetalle"),
        btnmenu : $("#btnmenu"), // boton de abrir y cerrar
        menup_estado : 1, // { 1: abierto, 2: cerrado}
        abrirCerrarMenu : function(){
            if(ctxM.menup_estado == 1)
                ctxM.menuPrincipal.css('width', "70px");        
            else if(ctxM.menup_estado == 0)        
                ctxM.menuPrincipal.css('width', "300px");
            ctxM.menup_estado = Math.abs(ctxM.menup_estado - 1);
        },
        creaMenuBaseHtml : function(){
            $.get('/api/modulopriorizacion/menustablero', function(res){
                ctxG.nodos = res.nodosMenu;
                for(i=0; i< ctxG.nodos.length; i++ )
                {
                    var menu = ctxG.nodos[i];
                    var html = '<a href="#" id="' + menu.cod_str + '"  cod_str="' +  menu.cod_str + '" \
                                    class="list-group-item m-0 row p-0 p-t-10 p-b-10 w300 nodo_menu" style="overflow:hidden;" title="' + menu.nombre + '">\
                                        <div class="col-md-3">\
                                            <img src="' + cnf.m.img[menu.cod_str] + '" class="img-circle" style="width:50px; height:50px">\
                                        </div>\
                                        <div class="col-md-9" ><span class="align-middle">' + menu.nombre + '</span></div>\
                                </a>';
                    $("#menuPrincipal").append(html);
                }

                ctxM.menuDetalle.addClass(cnf.m.bgSub);
            })                     
        },
        crearSubmenusHtml : function(itemSel){
            if(itemSel != null)
            {
                ctxM.menuDetalle.html('');
                var submenusN2 = itemSel.hijos;
                htmlHeaderCollapse = (submenusN2.length > 1) ? 'collapse' : '';
                for(i=0; i< submenusN2.length; i++)
                {
                    subN2 = submenusN2[i];
                    // cabecera del menu desplegable
                    var htmlHeader = "<div class='panel-heading p-t-10 p-b-10 mt-1  " + cnf.m.bgHeaderSub +" ' style='cursor:pointer;'\
                                        data-toggle='collapse' href='#" + subN2.id + "' > " + subN2.nombre + "\
                                      </div>"
                    // contenido de cada menu desplegable , elementos nivel 3 que pueden ser del tipo titulo o link
                    htmlContent = "<div id='" + subN2.id + "' class='panel-collapse " + htmlHeaderCollapse + " ' >\
                                        <ul class='list-group m-0'>";

                    for(j=0; j< subN2.hijos.length; j++)
                    {
                        var elem = subN2.hijos[j];
                        if (elem.tipo == 'titulo')
                            htmlContent += "<div class='list-group-item " + cnf.m.bgTituloSub + " ' >" + elem.nombre + "</div>";
                        else if (elem.tipo == 'link')
                            htmlContent += "<a class='list-group-item nodo_menu' href='#'  id='" + elem.cod_str + "'   >" + elem.nombre + "</a>";
                    }
                    htmlContent += "</ul></div>";
                    ctxM.menuDetalle.append(/*"<div class='panel panel-info m-b-5'>"  + */ htmlHeader + htmlContent /* + "</div>" */ );
                }
            }
        },
        activarElem: function(elem)
        {
            if(elem.nivel == 1)
            {
                $("#menuPrincipal a.nodo_menu").removeClass(cnf.m.activoPri);
                $("#menuPrincipal #" + elem.cod_str).addClass(cnf.m.activoPri);
            }
            else if(elem.nivel == 3)
            {
                $("#menuDetalle a.nodo_menu").removeClass(cnf.m.activoSub);
                $("#menuDetalle #" + elem.cod_str).addClass(cnf.m.activoSub);
            }
        },
        obtenerNodo :  function(cod_str){
            interacciones = cod_str.length / 2;
            var elem = {};
            arr = ctxG.nodos;
            for(i = 0 ; i< interacciones; i++ ) {
                elem = arr.find(function(item){                  
                    return  (item.cod_str == cod_str.substring(0, item.nivel * 2 ))
                });
                if(elem.cod_str == cod_str)
                    return elem;

                if(elem && elem.hijos && elem.hijos.length > 0)
                    arr = elem.hijos;
            }
            return null;

        },
    }

    /*-----------------------------------------------------------------------
     *      ctxC variable que contiene el contexto del Contenido, contenedorPredefinidos, titulos, 
     */
    var ctxC = {
        contenedorPredefinidos: $("#contenedorPredefinidos"),
        contenedorDatos : $("#contenedorDatos"),
        divDatos : $("#divDatos"),
        divGrafico : $("#divGrafico"),
        modalConfig : $("#modalConfig"),
        titulo: $("#titulo"),
        tituloGrafico: $("#tituloGrafico"),
        tituloDatos: $("#tituloDatos"),        
        cargarHTMLPredefinidos: function(variableEst){
            ctxC.contenedorPredefinidos.html('');
            predef = variableEst.sets_predefinidos;
            for(i=0; i< predef.length; i++)
            {
                item = predef[i];
                imagen = cnf.c.img['imagen_por_default'];
                for(key in cnf.c.img)
                {                     
                    if(key.indexOf(item.imagen) !== -1 && item.imagen != '')  //Si existe la coincidencia que alguna imagen en cnf.c.img contenga la imagen del predefido entonces se asigna esa imagen
                        imagen = cnf.c.img[key]; 
                }

                var divImghtml = '<div id="' + i + '" class="stat-item item_campo_predefinido containertipoimg"  title="' + item.etiqueta + '"  style="cursor:pointer;">\
                                        <img  src="' + imagen +'" alt="' + item.etiqueta + '" class="image" style="width:80px;height:60px">\
                                        <div class="filt" >\
                                            <div class="text">' + item.etiqueta + '</div>\
                                        </div>\
                                    </div>';
                ctxC.contenedorPredefinidos.append(divImghtml);
            }
        },
        crearRequest: function(varEst)  {
            objVE = {
                id_indicador : varEst.id_indicador,
                variable_estadistica : varEst.variable_estadistica,
                tabla_vista: varEst.tabla_vista,                
                campo_agregacion: varEst.campo_agregacion,
                campo_defecto: varEst.campo_defecto,
                condicion_sql: varEst.condicion_sql,
                campos_disponibles: varEst.campos_disponibles,
                porcentaje: varEst.porcentaje ? true : null,
                // _token : $('input[name=_token]').val(),
            }
            return objVE;
        },    
        obtenerData: function(varEst){
            objRequest = ctxC.crearRequest(varEst);
            $.get('/api/modulopriorizacion/datosVariableEstadistica', objRequest, function(res){                
                ctxG.collection = res.collection;
                ctxG.varEstActual.valor_unidad_medida = res.unidad_medida.valor_unidad_medida;
                ctxG.varEstActual.valor_tipo = res.unidad_medida.valor_tipo;
                $.get('/api/modulopriorizacion/datosIndicadoresMeta', {id_indicador : ctxG.varEstActual.id_indicador}, function(r){
                    if(r.mensaje=='ok')
                    {
                        ctxG.indicadorActual = r.indicador;
                        ctxG.indicadorActual.metas = r.metasIndicador
                    }
                    else
                        ctxG.indicadorActual = {};
                    ctxC.mostrarData(ctxG.collection);
                } )
                
            })
        },
        mostrarData: function(collection){
            ctxPiv.pivottable();
            ctxGra.colocarOpcionesPredefinidas();
            ctxGra.graficarH();
        },
        actualizaTitulos: function(){
            this.titulo.html('<h4>'  + ctxG.nodoSel.padre + ': ' + ctxG.nodoSel.nombre + '</h4>');
            this.tituloDatos.html('');
            this.tituloGrafico.html( '');
        },
        mostrarPantallas: function(op){
            $("#divTitulo a").removeClass('disabled');
            $("#btn_" + op).addClass('disabled'); 
            if(op == 'grafico')
            {                
                this.contenedorDatos.show();
                this.divGrafico.show();
                this.divDatos.hide();
            }
            else if (op=='tabla')
            {
                this.contenedorDatos.show();
                this.divGrafico.hide();
                this.divDatos.show();
            }
            else
            {
                ctxC.contenedorDatos.hide();
            }
        },
        mostrarModal: function(op){

            this.modalConfig.fadeIn(500).modal();
            var oculta = op == 'del';
            $('#predefNewUpdate').attr('hidden', oculta);
            $('#predefDel').attr('hidden', !oculta);
            if(op == 'del'){
                $("#predefDel #imagen").attr("src",cnf.c.img[ctxG.varEstActual.set_predefinido.imagen]);
                $("#predefDel #dixTextoImagen").html(ctxG.varEstActual.set_predefinido.etiqueta);
            }
            if(op=='update' || op == 'new')
            {
                var html = '<div>';
                cnf.c.img.keys(function(key){
                    console.log(key)
                })
            }


        },
        guardarPredef: function(){

        }

    };

    /*-----------------------------------------------------------------------
     *      ctxPiv variable que contiene el contexto del Pivot  
     */
    var ctxPiv = {
        pivotTable: $("#pvtTable"),
        configParaPivotT : function(set_predefinido){
            var config = {}
            config.columns = set_predefinido.x;
            config.rows = set_predefinido.y;
            config.inclusions = _.chain(set_predefinido.filtros)
                                .map(function(item){                    
                                    condicion = item.split("==").map(function(s){ return s.toString().trim();});
                                    _datafield =  condicion[0];
                                    _values = condicion[1].split(",").map(function(o){ return o.toString().trim().replace(/'/g,"");});
                                    filtro = {};
                                    filtro[_datafield] = _values        
                                    return filtro;
                                }).reduce(function(carry, item){
                                    return $.extend(true, carry, item);                                
                                }, {}).value();
            var existeAgregacion = $.pivotUtilities.locales.es.aggregators[set_predefinido.agregacion]; 
            config.aggregatorName = existeAgregacion ?  set_predefinido.agregacion : "Suma de enteros";
            config.vals = ["valor"];         
            return config;
        },
        pivottable: function()
        {
            var pivotConfig = ctxPiv.configParaPivotT(ctxG.varEstActual.set_predefinido);
            ctxPiv.pivotTable.pivotUI(ctxG.collection, {
                cols: pivotConfig.columns, 
                rows: pivotConfig.rows,
                aggregatorName: pivotConfig.aggregatorName,
                vals: pivotConfig.vals,
                inclusions: pivotConfig.inclusions,
                onRefresh: function(p) {
                    ctxG.pivotInstancia = p;
                    ctxPiv.trnDatosDePivot();
                    ctxGra.graficarH();
                    console.log(ctxG)
                }
            }, true, "es");
        }, 
        trnDatosDePivot: function(){
            var tree = ctxG.pivotInstancia.pivotData.tree;
            dim_columna = ctxG.pivotInstancia.cols.join(' - ');
            dim_fila = ctxG.pivotInstancia.rows.join(' - ');
            ctxG.pivot.data = [];
            for (row in tree){
                for(col in tree[row])
                {
                    var item = {};  
                    arg =   tree[row][col];                   
                    item['valor'] =arg.value();
                    item[dim_columna] = col;
                    item[dim_fila] = row;
                    ctxG.pivot.data.push(item); 
                }
            }
            ctxG.pivot.dimColumna = dim_columna;
            ctxG.pivot.dimFila = dim_fila;
            ctxPiv.obtenerTotales();
            ctxGra.transformarDatosParaGrafico();            
        },
        obtenerTotales: function(){
            var t_cols = {},  t_filas = {}, tp_cols = {}, tp_filas = {};            
            total = ctxG.pivot;
            dimCol = ctxG.pivot.dimColumna;
            dimFil = ctxG.pivot.dimFila;
            _.each(ctxG.collection, function(item){
                t_cols[item[dimCol]] = ( isNaN( t_cols[item[dimCol]])  ? 0 : t_cols[item[dimCol]]) + Number(item.valor );
                t_filas[item[dimFil]] = ( isNaN(t_filas[item[dimFil]]) ? 0 : t_filas[item[dimFil]] ) + Number(item.valor); 
            });
            total.t_cols = t_cols;
            total.t_filas = t_filas;
            total.total = Object.keys(t_cols).reduce(function(total, key){
                return total + t_cols[key];
            }, 0);

            /* Totales Sumas parciales */
            _.each(ctxG.pivot.data, function(item){
                tp_cols[item[dimCol]] = ( isNaN( tp_cols[item[dimCol]])  ? 0 : tp_cols[item[dimCol]]) + Number(item.valor );
                tp_filas[item[dimFil]] = ( isNaN(tp_filas[item[dimFil]]) ? 0 : tp_filas[item[dimFil]] ) + Number(item.valor); 
            });
            total.tp_cols = tp_cols;
            total.tp_filas = tp_filas;
            total.total_p =  Object.keys(tp_cols).reduce(function(total, key){
                return total + tp_cols[key];
            }, 0);
        }, 
    }

    /*-----------------------------------------------------------------------
     *      ctxGra variable que contiene el contexto del grafico  
     */
    var ctxGra = {
        colocarOpcionesPredefinidas: function()
        {
            try { $("#opcionesGrafico").val(ctxG.varEstActual.set_predefinido.grafico.tipo);}
            catch(e)/* si no existe le asigna el primer grafico*/           
                { $('#opcionesGrafico option')[0].selected = true; }
        },
        transformarDatosParaGrafico: function()
        {
            var datosGraph = {};
            var pivotData = ctxG.pivotInstancia.pivotData;            
            var pivot = ctxG.pivot;
            var factorPorcentual = ctxG.pivotInstancia.aggregatorName[0] == '%' ? 100 : 1;
            datosGraph.categorias = pivotData.colKeys.map(function(cat, key){
                return cat.join(' - ');
            });
            
            datosGraph.series = _.chain(pivot.data).groupBy(function(item){
                                        return item[pivot.dimFila]
                                    }).map(function(setDatos, key){
                                        serie = {};
                                        serie.name = key;
                                        serie.data = setDatos.map(function(elem){  
                                            var num;
                                            if(ctxG.pivotInstancia.aggregatorName[0] == "%")                
                                                num =  parseFloat((Math.round( elem.valor * 100 * 10 )/10 ).toString()) ;
                                            else 
                                                num = elem.valor;
                                            return [elem[pivot.dimColumna], num];
                                        });
                                        return serie;
                                    }).value();
            ctxG.pivot.dataGraph = datosGraph;

        },
        graficarH : function()
        {
            var tituloChart = ctxG.varEstActual.variable_estadistica;
            var unidadMedida = ctxG.varEstActual.porcentaje  ? ' (porcentaje) ' : '(' + ctxG.varEstActual.valor_tipo +': ' + ctxG.varEstActual.valor_unidad_medida + ') ';
            var subtituloChart = ctxG.pivot.dimFila + ' vs. ' + ctxG.pivot.dimColumna;
            var tipo = $("#opcionesGrafico").val().split('-');
            var stacked = (tipo[1]  == 'stacked') ? 'normal' : (tipo[1]  == 'stackedp') ? 'percent': '';
            var tipo3d = false;


            var chart={}, title={}, subtitle={}, xAxis={}, yAxis={}, tooltip={}, plotOptions={}, series={};

            chart = {
                type: tipo[0],
                options3d: {
                    enabled: tipo3d,
                    alpha: tipo=='pie' ? 45 : 23, 
                    beta: 0, depth: 60
                },
            };
            title = {
                text: tituloChart   
            };   
            subtitle = {
                text: subtituloChart
            };  
            xAxis = {
                categories: ctxG.pivot.dataGraph.categorias
            };
            yAxis = {
                title: {
                    text: unidadMedida
                }
            };
            // tooltip =   {
            //     pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>categ {point.category} </br> total {point.total} </br>y {point.y}'
            // };
            plotOptions = {
                // pies donas
                pie: {
                    innerSize: 100,
                    depth: 45,
                    allowPointSelect: true,
                    cursor: 'pointer',
                    // depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.category}'
                    }
                },
                column: {
                    stacking: stacked,
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                },
                //bars
                series: {
                    stacking: stacked
                },
                area: {
                    stacking: stacked,
                    lineColor: '#ffffff',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 1,
                        lineColor: '#ffffff'
                    }
                }
            };

            series = ctxG.pivot.dataGraph.series;

            
            

            var json = {};   
            json.chart = chart; 
            json.title = title;       
            json.subtitle = subtitle; 
            json.xAxis = xAxis;
            json.yAxis = yAxis;
            json.tooltip = tooltip;
            json.plotOptions = plotOptions; 
            json.series = series;   
            $('#divChart').highcharts(json);

        }
    }

</script>

<script>
$(function(){

    ctxM.creaMenuBaseHtml();
    ctxC.mostrarPantallas();

    ctxM.btnmenu.click(function() {
        ctxM.abrirCerrarMenu();
    });

    $("#menuPrincipal, #menuDetalle").on('click', 'a.nodo_menu', function(event){
        str_cod = $(this).attr('id');
        ctxG.nodoSel = ctxM.obtenerNodo(str_cod);
        ctxM.activarElem(ctxG.nodoSel);
        if(ctxG.nodoSel.nivel == 1)
        {
            ctxM.crearSubmenusHtml(ctxG.nodoSel);
            if(ctxM.menup_estado == 1) //si esta abierto el menu al presionar que se cierre
                ctxM.abrirCerrarMenu();
        }
        else
        {
            ctxG.varEstActual = jQuery.parseJSON(ctxG.nodoSel.configuracion);
            ctxG.varEstActual.campo_tituloPredef = '';
            ctxG.varEstActual.porcentaje =  false;
            ctxG.varEstActual.set_predefinido = ctxG.varEstActual.sets_predefinidos[0]; // por defecto el primero
            ctxC.actualizaTitulos();
            ctxC.cargarHTMLPredefinidos(ctxG.varEstActual);            
            ctxC.obtenerData(ctxG.varEstActual);
            ctxC.mostrarPantallas('grafico');
        }
    }); 

    ctxC.contenedorPredefinidos.on('click', '.item_campo_predefinido', function(e){
        index =  $(this).attr('id');
        ctxG.varEstActual.campo_tituloPredef =  $(this).attr('title');
        ctxG.varEstActual.porcentaje =  false;
        ctxG.varEstActual.set_predefinido = ctxG.varEstActual.sets_predefinidos[index];
        ctxC.actualizaTitulos();
        ctxC.mostrarData(ctxG.collection);
    });

    $("#btn_tabla, #btn_grafico").click(function(){
        var op = $(this).attr('id').replace('btn_',''); // == 'btn_tabla' ? 'tabla' : 'grafico';
        ctxC.mostrarPantallas(op);
    });

    $("#predef_update, #predef_new, #predef_del").click(function(){
        var op = $(this).attr('id').replace('predef_','');
        ctxC.mostrarModal(op);        
    });



});


</script>


{{-- FUNCION POR DEFECTO: OCULTA MENU MENU LATERAL DE SISTEMA Y ACTIVA BOTON MODULO  --}}
<script type="text/javascript">
 $(function() {
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
    activarMenu('x','mp-9');
    menuModulosHideShow(1)
}) 
</script>
@endpush
