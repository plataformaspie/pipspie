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

.pvtTotal, .pvtTotalLabel, .pvtGrandTotal {display: none}
</style>
@endsection


@section('content')
<div class='container-fluid'>
    T2
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
    
        <div id="contenido" class="col-md-9 ">
            <div id="contenedorPredefinidos" class="row stats-row m-0 bg-white p-3" >
            </div>

            <div class="row m-0">
                <div id="contenedorDatos" style="height: 1000px; width: 100%"  class="bg-white p15 mt-1" style="overflow-y: scroll;"> 

                    <div class="">
                        <div id=tituloDatos></div>
                        <div class="row m-0 bg-white mt-2" style="overflow: scroll; width: 100%; height: 400px;">
                            <div id="pvtTable"></div>                
                        </div>
                    </div>

                    <div id="separador"><hr/></div>
                    
                    <div>
                        <div id="tituloGrafico"></div>

                        <select id="opcionesGrafico" onchange="ctxGra.graficarH(this);" >
                            <option value="line">Linea</option>
                            <option value="column">Columna</option>                            
                            <option value="bar">Barras</option>                            
                            <option value="area">Area</option>
                            <option value="pie" >Dona</option>
                        </select>
                        <div id="container" style="font-family: arial; width: 90%; min-height: 600px; max-height: auto; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('script-head')
<script src="/plugins/amcharts3.21.8/amcharts.js"></script>
<script src="/plugins/amcharts3.21.8/serial.js"></script>
<script src="/plugins/amcharts3.21.8/plugins/export/export.min.js"></script>
<script src="/plugins/amcharts3.21.8/themes/light.js"></script>

{{-- <script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script> --}}
<script type="text/javascript" src="/plugins/Highcharts-6.0.4/code/highcharts.js"></script>
<script type="text/javascript" src="/plugins/Highcharts-6.0.4/code/highcharts-3d.js"></script>

<script type="text/javascript" src="/plugins/pivottable/dist/jquery-ui.min.js"></script>
<script type="text/javascript" src="/plugins/modify/pivot___.js"></script>
<script type="text/javascript" src="/plugins/pivottable/dist/pivot.es.js"></script>

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
            themePivot : 'ui-overcast',
            img: {  // buscara si key departamento existe en r_departamento de configuracion.campos_predefinidos.campo, con contains 
                'imagen_por_default':'/img/icon-graf/3.png',
                'imagen_por_default_1':'/img/icon-graf/1.png',
                'imagen_por_default_2':'/img/icon-graf/2.png',
                'imagen_por_default_4':'/img/icon-graf/4.png',
                'imagen_por_default_5':'/img/icon-graf/5.png',
                'imagen_por_default_6':'/img/icon-graf/6.png',
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
     *      ctxC variable que contiene el contexto del Contenido, contenedorPredefinidos, graficos y tablas, contenidos dinamicos , 
     */
    var ctxC = {
        contenedorPredefinidos: $("#contenedorPredefinidos"),
        contenedorDatos : $("#contenedorDatos"),
        tituloGrafico: $("#tituloGrafico"),
        tituloDatos: $("#tituloDatos"),
        cargarHTMLCalculosPredefinidos: function(variableEst){
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
                campo: varEst.campo,
                campos_disponibles: varEst.campos_disponibles,
                porcentaje: varEst.porcentaje ? true : null,
                // _token : $('input[name=_token]').val(),
            }
            return objVE;
        },      
        mostrarData: function(collection){
            ctxPiv.pivottable();
            ctxGra.graficarH();
        },
        obtenerData: function(objRequest){
            $.get('/api/modulopriorizacion/datosVariableEstadistica', objRequest, function(res){                
                ctxG.collection = res.collection;
                ctxG.varEstActual.valor_unidad_medida = res.unidad_medida.valor_unidad_medida;
                ctxG.varEstActual.valor_tipo = res.unidad_medida.valor_tipo;
                ctxC.mostrarData(ctxG.collection);
            })
        },
    };

    /*-----------------------------------------------------------------------
     *      ctxPiv variable que contiene el contexto del Pivot  
     */
    var ctxPiv = {
        configParaPivotT : function(set_predefinido){
            var fields = [];
            var columnas = [];
            var filas = [];
            var filtros = [];

            columnas = set_predefinido.x;
            filas = set_predefinido.y;
            filtros = _.map(set_predefinido.filtros, 
                function(item){                    
                    condicion = item.split("==").map(function(s){ return s.toString().trim();});
                    _datafield =  condicion[0];
                    _values = condicion[1].split(",").map(function(o){ return o.toString().trim().replace(/'/g,"");});
                    filtro = {
                        dataField: _datafield,
                        filterFunction: function(value){
                            if(_values.indexOf(value.toString()) == -1)
                                return true;
                            return false;
                        }
                    };
                    return filtro;
            });
            return { fields: fields, columns: columnas, rows: filas, filters: filtros};
        },
        pivottable: function()
        {
            var pivotElems = ctxPiv.configParaPivotT(ctxG.varEstActual.set_predefinido);
            $("#pvtTable").pivotUI(ctxG.collection, {
                cols: pivotElems.columns, rows: pivotElems.rows,
                // aggregatorName: "intSum",
                // vals: ["valor"],
                onRefresh: function(p) {
                    ctxG.pivotInstancia = p;
                    ctxPiv.trnDatosDePivot();
                    ctxGra.graficarH();
                    console.log(ctxG)
                }
                
                // derivedAttributes: {
                //     "Age Bin": derivers.bin("Age", 10),
                //     "Gender Imbalance": function(mp) {
                //         return mp["Gender"] == "Male" ? 1 : -1;
                //     }
                // }
            }, false, "es");
            

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
        transformarDatosParaGrafico: function()
        {
            var datosGraph = {};
            var pivotData = ctxG.pivotInstancia.pivotData;
            var pivot = ctxG.pivot;
            datosGraph.categorias = pivotData.colKeys.map(function(cat, key){
                return cat.join(' - ');
            });
            
            datosGraph.series = _.chain(pivot.data).groupBy(function(item){
                return item[pivot.dimFila]
            }).map(function(setDatos, key){
                serie = {};
                serie.name = key;
                serie.data = setDatos.map(function(elem){
                    return elem.valor;
                });
                return serie;
            }).value();
            
            ctxG.pivot.dataGraph = datosGraph;

        },
        graficarH : function(){

            tituloChart = ctxG.varEstActual.variable_estadistica;
            unidad = ctxG.varEstActual.porcentaje  ? ' (expresado en porcentaje) ' : ' (expresado en ' + ctxG.varEstActual.valor_tipo +': ' + ctxG.varEstActual.valor_unidad_medida + ') '
            subtituloChart = (ctxG.varEstActual.campo == '') ? unidad : 'Por ' + ctxG.varEstActual.campo_titulo + unidad;
            var tipo = $("#opcionesGrafico").val();
            var chart = {
                type: tipo,
                options3d: {
                    enabled: true,
                    alpha: 30
                }
            };
            var title = {
              text: tituloChart   
            };   
            var subtitle = {
                text: subtituloChart
            };  
            var xAxis= {
                categories: ctxG.pivot.dataGraph.categorias
            };
            var yAxis= {
                title: {
                    text: ''
                }
            };
            var plotOptions = {
                pie: {
                    innerSize: 100,
                    depth: 45
                },
                column: {
                    depth: 40,
                    stacking: true,
                    grouping: false,
                    groupZPadding: 10
                }
            };

            var series = ctxG.pivot.dataGraph.series;

            var json = {};   
            json.chart = chart; 
            json.title = title;       
            json.subtitle = subtitle; 
            json.xAxis = xAxis;
            json.yAxis = yAxis;
            json.plotOptions = plotOptions; 
            json.series = series;   
            $('#container').highcharts(json);

        }
    }

</script>

<script>
$(function(){

    ctxM.creaMenuBaseHtml();

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
            ctxG.varEstActual = jQuery.parseJSON(ctxG.nodoSel.configuracion);// JSON.parse( ctxG.nodoSel.configuracion );
            ctxG.varEstActual.campo =  '';
            ctxG.varEstActual.campo_titulo = '';
            ctxG.varEstActual.porcentaje =  false;
            ctxG.varEstActual.set_predefinido = ctxG.varEstActual.sets_predefinidos[0]; // por defecto el primero
            ctxC.tituloDatos.html('<h4>'  + ctxG.nodoSel.padre + ': ' + ctxG.nodoSel.nombre + '</h4>');
            ctxC.tituloGrafico.html( 'Datos para ' + ctxG.varEstActual.variable_estadistica);
            ctxC.cargarHTMLCalculosPredefinidos(ctxG.varEstActual);
            objRequest = ctxC.crearRequest(ctxG.varEstActual);
            ctxC.obtenerData(objRequest);
        }
    }); 

    ctxC.contenedorPredefinidos.on('click', '.item_campo_predefinido', function(e){
        index =  $(this).attr('id');
        ctxG.varEstActual.campo_titulo =  $(this).attr('title');
        ctxG.varEstActual.porcentaje =  false;
        ctxG.varEstActual.set_predefinido = ctxG.varEstActual.sets_predefinidos[index];
        ctxC.tituloDatos.html('Datos para ' + ctxG.varEstActual.variable_estadistica +' por ' + ctxG.varEstActual.campo_titulo );
        ctxC.mostrarData(ctxG.collection);
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
