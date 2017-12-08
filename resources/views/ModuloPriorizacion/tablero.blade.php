@extends('layouts.plataforma')

@section('header')
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.light.css" type="text/css"/>
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.darkblue.css" type="text/css"/>
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.energyblue.css" type="text/css"/>
<link rel="stylesheet" href="/jqwidgets5.4.0/jqwidgets/styles/jqx.ui-overcast.css" type="text/css"/>

<link rel="stylesheet" href="/plugins/amcharts3.21.8/plugins/export/export.css" type="text/css" media="all" />
<link rel="stylesheet" href="/css/visores.css" type="text/css" />
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
    
        <div id="contenido" class="col-md-9 ">
            <div id="contenedorPredefinidos" class="row stats-row m-0 bg-white p-3" >
            </div>
            <div class="row m-0">              

                <div id="contenedorDatos" style="height: 1000px; width: 100%"  class="bg-white p15 mt-1" style="overflow-y: scroll;"> 

                    <div class="">
                        <div id=tituloDatos></div>
                        <table>
                            <tr>
                                <td class='align-top'>
                                   <div id="divPivotGridDesigner" class=""  style="height: 400px; width: 200px;"></div> 
                                </td>
                                <td class='align-top'>
                                    <div id="divPivotGrid" class="ml15"  style="height: 400px;  background-color: white;"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="separador"><hr/></div>
                    <div>
                        <div id="tituloGrafico"></div>
                        <div id="chartdiv"></div>
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

<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxdata.js"></script> 
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxmenu.js"></script>
{{-- <script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxpivot.js"></script> 
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxpivotgrid.js"></script> --}}


<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxcheckbox.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxinput.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxwindow.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxdropdownlist.js"></script>
<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxdragdrop.js"></script>
{{-- <script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxpivot.js"></script>  --}}
{{-- <script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxpivotgrid.js"></script> --}}
{{-- <script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/jqxpivotdesigner.js"></script> --}}
<script type="text/javascript" src="/plugins/modify/jqxpivot___.js"></script> 
<script type="text/javascript" src="/plugins/modify/jqxpivotgrid___.js"></script>
<script type="text/javascript" src="/plugins/modify/jqxpivotdesigner___.js"></script>

<script type="text/javascript" src="/jqwidgets5.4.0/jqwidgets/globalization/globalize.js"></script>
<script type="text/javascript" src="/js/jqwidgets-localization.js"></script>

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
        instanciaPivotGrid : {},
        pivot: {
            dataAll:[],
            data : [], // Datos del pivot  en formato collection 
            dataGraph : [],
            dimColumna : [],
            dimFila : [],
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
            ctxPiv.cargarPivot(collection);
            ctxGra.graficar();

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
        getConfigDePivot : function(collection, set_predefinido){
            var fields = [];
            var columnas = [];
            var filas = [];
            var filtros = [];

            if(collection.length > 0)
                fields = _.chain(collection).first().map(function(value, key){
                    return {name: key, type : (key == 'valor') ? 'number' : 'string' }
                }).value();

            columnas = _.map(set_predefinido.x, function(item){
                return {dataField : item};
            });
            filas = _.map(set_predefinido.y, function(item){
                return {dataField : item};
            });

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
        cargarPivot: function() {            
            var pivotElems = ctxPiv.getConfigDePivot(ctxG.collection, ctxG.varEstActual.set_predefinido);
            var source = {
                localdata: ctxG.collection, // los datos en el formato que requiere el pivot son del tipo collection, array de objetos similares
                datatype: "json",
                datafields: pivotElems.fields
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            dataAdapter.dataBind();

            var pivotSettings = {
                        pivotValuesOnRows: false,
                        columns: pivotElems.columns,/* [{ dataField: 'gestion'}], */
                        rows: pivotElems.rows,/* [{ dataField: 'r_departamento'}], */
                        filters: [],
                        /*  Ejemplo de filtro, cuando la condicion es true se filtra, se excluye, 
                            en el caso se quiere solo los valores de 2013 y 2015, por lo tanto la comparacion es , si no esta en el array se excluye                        
                            filters: [
                            {
                                dataField: 'gestion',
                                filterFunction: function (value) {
                                    if (['2013', '2015'].indexOf(value.toString()) == -1)
                                        return true;
                                    return false;
                                }
                            },
                        */
                        values: [
                            { dataField: 'valor', 'function': 'sum', text: 'cantidad'},
                        ]
                    };

            
            function implementaPivotGrid(dataAdapter, pivotSettings)
            {
                var pivotDataSource = new $.jqx.pivot(dataAdapter, pivotSettings);
                $('#divPivotGrid').jqxPivotGrid(
                {
                    source: pivotDataSource,
                    treeStyleRows: true,
                    autoResize: true,
                    // theme: cnf.c.themePivot,
                    multipleSelectionEnabled: true,
                    localization: getLocalization('es')
                });
                var instanciaPivotGrid = $('#divPivotGrid').jqxPivotGrid('getInstance'); 
                return instanciaPivotGrid;
            }
            var pivotGridInstancia =  implementaPivotGrid(dataAdapter, pivotSettings);
            ctxG.pivot.dataAll = pivotGridInstancia._pivotCells.cellProperties.namedPropertyTables.CellValue;

            if(pivotElems.filters.length > 0)
            {
                pivotSettings.filters = pivotElems.filters;
                pivotGridInstancia =  implementaPivotGrid(dataAdapter, pivotSettings);
            }
            pivotGridInstancia.refresh();
            ctxG.pivotGridInstancia = pivotGridInstancia;     
            ctxPiv.tranformarDatosDePivot();

            $('#divPivotGridDesigner').jqxPivotDesigner(
            {
                type: 'pivotGrid',
                target: pivotGridInstancia
            });
            var pivotDesignerInstance =  $('#divPivotGridDesigner').jqxPivotDesigner('getInstance');
            pivotDesignerInstance.refresh();
        },
        tranformarDatosDePivot: function()     {   
            datos = [];
            var cellValuesObj = ctxG.pivotGridInstancia._pivotCells.cellProperties.namedPropertyTables.CellValue; //Contiene los valores de las celdas como un obj
            var pivotColumns = ctxG.pivotGridInstancia._pivotColumns.items;
            var pivotRows = ctxG.pivotGridInstancia._pivotRows.items;   

            datosPivotObj = _.chain(cellValuesObj).map(function(item, key){ item.key = key; return item}).sortBy('key').value(); // transforma el obj a una lista ordenada por su key (key mantiene el orden ) 
            ctxG.pivot.dimColumna = pivotColumns.length > 0 ?  pivotColumns[0].adapterItem.boundField.dataField : 'cantidad'; 
            ctxG.pivot.dimFila = pivotRows.length > 0 ?  pivotRows[0].adapterItem.boundField.dataField : 'cantidad';
            columnas = pivotColumns.map(function(col){
                return col.adapterItem.text;
            });
            filas = pivotRows.map(function(row){
                return row.adapterItem.text;
            })
            
            k = 0;
            for(i=0; i< columnas.length; i++){ 
                for(j=0; j<filas.length; j++)
                {
                    item = {};
                    item[ctxG.pivot.dimColumna] = columnas[i];
                    item[ctxG.pivot.dimFila] = filas[j];
                    item['valor'] = datosPivotObj[k].value;
                    datos.push(item);
                    k++;
                }
            }
            ctxG.pivot.data = datos;
            console.log(datos);
            ctxGra.transformarDatosParaGrafico(datos);
            return datos;
        },       
    }

    /*-----------------------------------------------------------------------
     *      ctxGra variable que contiene el contexto del grafico  
     */
    var ctxGra = {
        graficar: function()   {
            data = ctxG.pivot.dataGraph;
            tituloChart = ctxG.varEstActual.variable_estadistica;
            unidad = ctxG.varEstActual.porcentaje  ? ' (expresado en porcentaje) ' : ' (expresado en ' + ctxG.varEstActual.valor_tipo +': ' + ctxG.varEstActual.valor_unidad_medida + ') '
            subtituloChart = (ctxG.varEstActual.campo == '') ? unidad : 'Por ' + ctxG.varEstActual.campo_titulo + unidad;
            var graphs = [];
            if(data.length > 0)
            {
                for(key in data[0])  //Si existen elemntos se recorren los indices (key) del primer elemento. ej data[0] = { hombre:12, mujer:11, gestion:2015 }
                {
                    if(key != ctxG.pivot.dimColumna)
                    {
                        var graph = {
                            id: key,
                            title: key,
                            valueField: key,
                            // labelText: "[[percents]] %",
                            // "labelPosition": "inside",
                            type: 'smoothedLine',
                            balloonText: key + ": <b>[[value]]</b><br><b>[[percents]] % </b>",
                            balloon : {
                                adjustBorderColor: false,                                
                                color: "#333",
                                borderColor : '#000',
                                borderAlpha: 0.2,
                                borderThickness: 0,
                                cornerRadius: 5,
                                fillColor : '#fff',
                                fillAlpha:0.2,
                                shadowColor: '#000',
                                fontSize : 10,
                                animationDuration: 0.7,
                            },
                            bullet: "round",
                            bulletBorderAlpha: 1,
                            hideBulletsCount: 50,
                            useLineColorForBulletBorder: true,     
                            lineThickness : 3,
                            lineAlpha: 0.8,                     
                        };
                        graphs.push(graph);
                    }
                }
            }

            chart = AmCharts.makeChart("chartdiv", {
                    type: "serial",
                    theme: "light",
                    addClassNames: true,
                    marginRight: 80,
                    autoMarginOffset: 20,
                    marginTop: 7,
                    graphs: graphs,
                    dataProvider: data,
                    // startEffect : 'easeOutSine',
                    // startDuration: 1.5,
                    // sequencedAnimation: false, 
                    titles: [
                            {
                                color : "#333",
                                size: 11,
                                text: tituloChart,
                                // "align": "right",
                                // x: 40, y:30,
                            },
                            {
                                color : "#333",
                                size: 10,
                                text: subtituloChart,
                                bold: false,
                            }
                    ],
                   "valueAxes": [{
                        "axisAlpha": 0.5,
                        "dashLength": 1,
                        "position": "left"
                    }],
                    "mouseWheelZoomEnabled": false,
                    // "chartScrollbar": {
                    //     "autoGridCount": true,
                    //     "scrollbarHeight": 40
                    // },
                    legend: {
                        useGraphSettings: true,
                        borderColor: "#aaa",
                        borderAlpha: 0.8,
                        horizontalGap: 10,
                        align: 'center'
                    },
                    chartCursor: {
                        oneBalloonOnly: true,
                        graphBulletSize:1,
                    },
                    categoryField: ctxG.pivot.dimColumna,
                    "categoryAxis": {
                        "axisColor": "#DADADA",
                        "dashLength": 1,
                        "minorGridEnabled": true
                    },
                    "export": {
                        "enabled": true
                    }
                });
                // chart.addListener("rendered", zoomChart);
                // zoomChart(data);
                
                // function zoomChart(data) {
                //     chart.zoomToIndexes(data.length - 40, data.length - 1);
                // }

                chart.timeout;
                chart.addListener( "rollOverGraph", function( event ) {
                    hightLightItem( event.graph, 'in' );
                } );
                chart.addListener( "rollOutGraph", function( event ) {
                    hightLightItem( event.graph, 'out' );
                } );

                function hightLightItem( graph, op ) {
                    var className = "amcharts-graph-" + graph.id;
                    var items = document.getElementsByClassName( className );
                    if ( undefined === items )
                        return;
                    for ( var x in items ) {
                        if ( "object" !== typeof items[x] )
                            continue;
                        var path = items[x].getElementsByTagName( "path" )[ 0 ];
                        if ( undefined !== path )
                        {
                            if(op == 'in')
                            {
                               path.style.strokeWidth = 4; 
                               path.style.strokeOpacity = 1;
                            }
                            if(op == 'out')
                            {
                                path.style.strokeWidth = 3; 
                                path.style.strokeOpacity = 0.8;
                            }                            
                        }
                    }
                }
                chart.addListener("init", function () {
                    chart.legend.addListener("rollOverItem", function (event) {
                        hightLightItem( event.chart.graphs[event.dataItem.index], 4 );
                    });

                    chart.legend.addListener("rollOutItem", function (event) {
                        hightLightItem( event.chart.graphs[event.dataItem.index], 2 );
                    });
                });
        },  
        transformarDatosParaGrafico: function()
        {
            datosGraph = [];
            if(ctxG.pivot.data.length > 0)
            {
                datosGraph = _.chain(ctxG.pivot.data)
                .groupBy(ctxG.pivot.dimColumna)
                .map(function(el, k){
                    elemNew = {};
                    _.each(el, function(item){
                        elemNew[ctxG.pivot.dimColumna] = item[ctxG.pivot.dimColumna];
                        elemNew[item[ctxG.pivot.dimFila]] = item.valor;
                        return true;
                    })
                    return elemNew;
                }).value();
            }
            ctxG.pivot.dataGraph = datosGraph;
            return datosGraph;
        }
    }

    function funcionDespuesDePivotear(){
        ctxPiv.tranformarDatosDePivot();
        ctxGra.graficar();
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
            ctxC.tituloGrafico.html('<h4>'  + ctxG.nodoSel.padre + ': ' + ctxG.nodoSel.nombre + '</h4>');
            ctxC.tituloDatos.html('Datos para ' +ctxG.varEstActual.variable_estadistica);
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
