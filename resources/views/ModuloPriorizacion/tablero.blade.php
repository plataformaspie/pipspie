@extends('layouts.plataforma')

@section('header')
<link rel="stylesheet" href="/jqwidgets4.4.0/jqwidgets/styles/jqx.base.css" type="text/css"/>
{{-- <link rel="stylesheet" href="/jqwidgets4.4.0/jqwidgets/styles/jqx.darkblue.css" type="text/css"/>
<link rel="stylesheet" href="/jqwidgets4.4.0/jqwidgets/styles/jqx.energyblue.css" type="text/css"/>
<link rel="stylesheet" href="/jqwidgets4.4.0/jqwidgets/styles/jqx.ui-overcast.css" type="text/css"/> --}}
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
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
    padding: 55px 2px 2px 72px ;
    overflow-y: scroll;
    /*transition: width 1s, margin-left 1s;*/
    font-size: 11px;
}
.sidenav a {
    text-decoration: none;
    color: #818181;
    display: block;
    /*transition: 3s;*/
}

.sidenav a:hover {
    color: #f1f1f1;
    background-color: #aab;
}

.tituloDetail{
    color: #333;
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
</style>
@endsection


@section('content')
<div class='container-fluid'>
    <div class=row>

        <div class="col-md-3">
            <div id="menuPrincipal"  class="sidenav list-group bordered border-default rounded-right w300" style="height: 558px">
                <div href="#" id='btnmenu' class="p5" style="cursor: pointer;">
                    <i class="fa fa-bars fa-3x pull-right"></i>
                </div>   
            </div>
            <div id="menuDetalle" class="menuDetail " style="height: 560px">
            </div>
        </div> 


        <div id="contenido" class="col-md-9 "> 
            <h4>Dashboard </h4>
        </div>
    </div>
</div>


@endsection

@push('script-head')
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxcore.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxnavigationbar.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxbuttons.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxscrollbar.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets4.4.0/jqwidgets/jqxlistbox.js') }}"></script>

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

{{-- *********************  MAIN APP ************************ --}}
<script type="text/javascript">
$(function(){   

    var cnf = {
        m : {   // m menu
            activoP : 'bg-dark-dark',
            activoS : 'bg-success-dark',
            bgSub : 'bg-dark-dark',
            bgHeaderSub : 'bg-primary-light',
            bgTituloSub : 'bg-default-light tituloDetail',
            img : {
                '01' : '/img/priori-1.png',
                '02' : '/img/priori-2.png',
                '03' : '/img/priori-3.png',
                '04' : '/img/priori-4.png',
                '05' : '/img/priori-5.png',
            },
        },
    }

    var ctxM = {
        menuPrincipal : $("#menuPrincipal"), 
        btnmenu : $("#btnmenu"),
        menuDetalle : $("#menuDetalle"),
        menup_estado : 1,
        nodos : [],
        lista : [],
        abrirCerrarMenu : function(){
            if(ctxM.menup_estado == 1)
                ctxM.menuPrincipal.css('width', "70px");        
            else if(ctxM.menup_estado == 0)        
                ctxM.menuPrincipal.css('width', "300px");

            ctxM.menup_estado = Math.abs(ctxM.menup_estado - 1);
        },
        creaMenuBaseHtml : function(){
            $.get('/api/modulopriorizacion/menustablero', function(res){
                ctxM.nodos = res.nodosMenu;
                ctxM.lista = res.listaMenu;
                for(i=0; i< ctxM.nodos.length; i++ )
                {
                    var menu = ctxM.nodos[i];
                    var html = '<a href="#" id="' + menu.cod_str + '"  cod_str="' +  menu.cod_str + '" \
                                    class="list-group-item m-0 row p-0 p-t-10 p-b-10 w300" style="overflow:hidden;" title="' + menu.nombre + '">\
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
        obtenerElemSel :  function(cod_str){
            for(i=0; i<ctxM.lista.length; i++) {
                if(cod_str == ctxM.lista[i].cod_str)
                    return ctxM.lista[i];
            }
        },
        // obtenerElemSel :  function(cod_str){
        //     for(i=0; i< ctxM.nodos.length; i++){
        //         if(cod_str == ctxM.nodos[i].cod_str)
        //             return ctxM.nodos[i];                
        //     };
        //     return [];
        // },
        crearSubmenusHtml : function(itemSel){
            if(itemSel != null)
            {
                $("#menuDetalle").html('');
                var submenusN2 = itemSel.hijos;
                for(i=0; i< submenusN2.length; i++)
                {
                    subN2 = submenusN2[i];
                    // cabecera del menu desplegable
                    var htmlHeader = "<div class='panel-heading p-t-10 p-b-10 mt-2  " + cnf.m.bgHeaderSub +" ' style='cursor:pointer;'\
                                        data-toggle='collapse' href='#" + subN2.id + "' >" + subN2.nombre + "\
                                      </div>"
                    // contenido de cada menu desplegable , elementos nivel 3 que pueden ser del tipo titulo o link
                    htmlContent = "<div id='" + subN2.id + "' class='panel-collapse collapse' >\
                                        <ul class='list-group m-0'>";

                    for(j=0; j< subN2.hijos.length; j++)
                    {
                        var elem = subN2.hijos[j];
                        if (elem.tipo == 'titulo')
                            htmlContent += "<div class='list-group-item " + cnf.m.bgTituloSub + " ' >" + elem.nombre + "</div>";
                        else if (elem.tipo == 'link')
                            htmlContent += "<a class='list-group-item' href='#'  id='" + elem.cod_str + "'   >" + elem.nombre + "</a>";
                    }
                    htmlContent += "</ul></div>";
                    ctxM.menuDetalle.append(/*"<div class='panel panel-info m-b-5'>"  + */ htmlHeader + htmlContent /* + "</div>" */ );
                }
            }
        },


    }

    ctxM.creaMenuBaseHtml();

    ctxM.btnmenu.click(function() {
        ctxM.abrirCerrarMenu();
    });

    $("#menuPrincipal, #menuDetalle").on('click', '.list-group-item', function(event){
        console.log ($(this).attr('id'));
        elemSel = ctxM.obtenerElemSel($(this).attr('id'));
        console.log(elemSel)
        ctxM.crearSubmenusHtml(elemSel);




    }); 
})

</script>


{{-- FUNCION POR DEFECTO >>>>> OCULTA MENU MENU LATERAL DE SISTEMA Y ACTIVA BOTON MODULO  --}}
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
