@extends('layouts.plataforma')

@section('header')
<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.base.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.light.css') }}" type="text/css"/>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<link rel="stylesheet" href="{{ asset('css/visores.css') }}" type="text/css" />
<style>
#chartdiv {
    width: 100%;
    height: 450px;
}
.panel-heading{
    background: #D9EDF7;
    padding: 0 5px;
}
.row{
    margin-left:0px;
    margin-right:0px;
}

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 20;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 1s;
    padding-top: 20px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover {
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

#contenido {
    transition: margin-left 1s;
    padding: 16px;
}

@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
}


</style>
@endsection


@section('content')

  

<div class="row">
    <div id="menuPrincipal"  class="sidenav list-group">
        <a href="#" id='btnclose'>_<i class="fa fa-bars pull-right"></i></a>
    </div>   

    <div id="contenido">     
        <span id='btnopen' style="font-size:30px;cursor:pointer">  open</span>

        <h4>Dashboard</h4>

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

<script type="text/javascript">
$(function(){

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

    cnf = {
        img : {
            '01' : 'img/priori-1.png',
            '02' : 'img/priori-2.png',
            '03' : 'img/priori-3.png',
            '04' : 'img/priori-4.png',
            '05' : 'img/priori-5.png',
        }
    }

    ctxMenu = {
        obtenerMenus = function(){
            
        }
    }

    $("#btnopen").click(function() {
        $("#menuPrincipal").css('width', "250px");
        $("#contenido").css('marginLeft', "250px");
    })

    $("#btnclose").click(function() {
        $("#menuPrincipal").css('width', "0");
        $("#contenido").css('marginLeft', "0");
    })


})

</script>
@endpush
