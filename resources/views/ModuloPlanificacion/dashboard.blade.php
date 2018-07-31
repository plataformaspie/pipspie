@extends('layouts.plataforma')

@section('header')
    {{-- @parent --}}
    {{-- @yield('header-css') --}}
    <style>
    #menu_sp>.sidenav {
        position: absolute;
        z-index: 1;
        overflow-x: hidden;
        margin: 0px 0px 0px -20px;
        font-size: 16px;
        transition: width 1s;
    }
    #menu_sp>.menuDetail{
        position: absolute;
        margin: 0px 0px 0px -20px;
        padding: 55px 2px 5px 72px ;
        /*overflow-y: scroll;*/
        /*transition: width 1s, margin-left 1s;*/
        font-size: 12px;
    }
    #menu_sp > .sidenav a {
        text-decoration: none;
        color: #818181;
        display: block;
    }
    #menu_sp > .sidenav img{
        opacity: 0.7;
    }


    #menu_sp>.sidenav a:hover, #menu_sp>.menuDetail a:hover {
        /*color: #f1f1f1;*/
        background-color: #F5F5DC;
    }
    #menu_sp>.sidenav>a:hover img{
        opacity: 1;
    }

    #contenedor_sp{
        transition: margin-left 1s;
    }

    .activoPri{
        background-color: #34495E !important; /*17202A 34495E 4c5064 dark-dark  B5D6DE*/
        color: #f1f1f1 !important;
        border: #aed248 1px solid !important;; 
    }


    .activoSub{
        background-color: #ABEBC6   !important;
        border-color: #aed248;
    }  




    </style>

@endsection


@section('content')
<div class='container-fluid'>
    <div class='row'>
        <div id="menu_sp" >
            <div id="menu_nivel1"  class="sidenav list-group rounded-right " style="height: 550px; width: 300px; background: #17202A; color: #ddd">
                <div href="#" id='btnmenu'  style="cursor: pointer; padding: 5px">
                    <i class="fa fa-bars fa-2x pull-right"></i>
                </div>   
            </div>
{{--             <div id="menu_nivel2" class="menuDetail " style="height: 650px;" >

            </div> --}}
        </div> 
        <div id="contenedor_sp" style="margin-left: 300px; width: 100%">
            <div id="contenido"></div>
             {{-- @yield('contenido') --}}
           {{-- @include('ModuloPlanificacion.res') --}}
        </div>
    </div>
</div>
 
@endsection


@push('script-head')
<script>
 var x =  ( function(){  
    var cnfg = {
        menu : [
                { texto: "1. Entidades", ico: "/img/sp-icons/003-diagrama-1.png", ruta: '/moduloplanificacion/res', hijos: [] },
                { texto: "2. Enfoque Político", ico: "/img/sp-icons/013-contrato.png", ruta: '/moduloplanificacion/prueba', hijos: []},
                { texto: "3. Diagnóstico",    ico: "/img/sp-icons/007-grafico-circular.png", ruta: '/moduloplanificacion/tablero_', 
                    hijos: [
                        { texto: "3.1. Producto - VAriables - Sectorial", ico: "" },
                        { texto: "3.2. Sistema de Vida", ico: "" },
                        { texto: "3.3. Gestion de Riesgo y Cambio Climático", ico: "" },
                    ] 
                },
                { texto: "4. Política Sectorial", ico: "/img/sp-icons/009-rompecabezas.png",  ruta: '/moduloplanificacion/gestion_proyectos_pdes_',  hijos: [] },
                { texto: "5. Planificación", ico: "/img/sp-icons/008-objetivo.png",  
                    hijos: [
                        { texto: "5.1. Identificación PMRA", ico: "" },
                        { texto: "5.2. Programación de Resultado", ico: "" },
                        { texto: "5.3. Planificación de Acciones", ico: "" },
                    ] 
                },
                { texto: "6. Gestión Documental", ico: "/img/sp-icons/002-archivo.png",  hijos: [] },
        ],
        estilo : {
            bgMenu1 : "bg-white",
            bgMenu2 : "bg-success"
        }
    }

    
    /*-----------------------------------------------------------------------
     *      ctxMn variable que contiene el contexto del menu , 
     */
    var ctxMn = {
        menu_1 : $("#menu_sp #menu_nivel1"), 
        menu_2 : $("#menu_sp #menu_nivel2"),
        contenedor : $("#contenedor_sp"),
        btnmenu : $("#menu_sp #btnmenu"), 
        menup_estado : 1, // { 1: abierto, 0: cerrado}
        abrirCerrarMenu : function(){
            ctxMn.menu_1.css('width', ctxMn.menup_estado == 1 ? "80px" : "300px");
            ctxMn.contenedor.css('margin-left', ctxMn.menup_estado == 1 ? "80px" : "300px")     
            ctxMn.menup_estado = Math.abs(ctxMn.menup_estado - 1);
        },
        creaMenuBaseHtml : function(){
            cnfg.menu.map(function(m, k){
                var html = '<a href="#" id="' + k + '"  \
                class="list-group-item m-0 row p-0 p-t-10 p-b-10 " style="width:300px" title="' + m.texto + ' ">\
                <div class="col-md-3">\
                <img src="' + m.ico + '" class="img-circle" style="width:55px; height:55px">\
                </div>\
                <div class="col-md-9" ><span class="align-middle">' + m.texto + '</span></div>\
                </a>';
                ctxMn.menu_1.append(html);
            })

            // ctxMn.menu_2.addClass(cnfg.estilo.bgMenu2);

        },
        activarElem: function(elem)
        {
            $("#menu_sp #menu_nivel1 a").removeClass('activoPri');
            $("#menu_sp #menu_nivel1 img").css({'opacity': 0.7, "border" : "3px white "});
            $("#menu_sp #menu_nivel1 #" + elem.id).addClass('activoPri');
            $("#menu_sp #menu_nivel1 #" + elem.id + " img").css({'opacity': 0.8, "border" : "3px #E5E8E8   solid"});

        },
    }


    ctxMn.creaMenuBaseHtml();

    ctxMn.btnmenu.click(function() {
        ctxMn.abrirCerrarMenu();
    });


    /*  Click sobre elemento del menu 
    // */
    $("#menu_sp #menu_nivel1, #menu_sp #menu_nivel2").on('click', 'a', function(event){
        var index = $(this).attr("id");
        var elem_menu = cnfg.menu[index];
        elem_menu.id = index;
        ctxMn.activarElem(elem_menu);

        if(ctxMn.menup_estado == 1) //si esta abierto el menu al presionar que se cierre
            ctxMn.abrirCerrarMenu();
        $("#contenido").load(elem_menu.ruta );
        // $.get(elem_menu.ruta, function(view){
        //     $("#contenido").html(view);
        // })

    }); 
})();


</script>


<script type="text/javascript">
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
    $(document).ready(function(){
        activarMenu('x','mp-1');
        menuModulosHideShow(1)
    });
</script>
@endpush
