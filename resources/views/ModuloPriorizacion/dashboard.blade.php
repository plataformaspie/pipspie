@extends('layouts.plataforma')

@section('header')
  <link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.base.css') }}" type="text/css"/>
  <link rel="stylesheet" href="{{ asset('jqwidgets4.4.0/jqwidgets/styles/jqx.light.css') }}" type="text/css"/>
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
  </style>
@endsection


@section('content')
<div id="opciones-padre" class="row">
  <div class="col-lg-12 col-md-12">
      <div class="">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                  <div class="white-box analytics-info p-10">
                      <div class="message-center">
                          <a href="javascript:void(0);" class="detallar" aria-controls="1">
                              <div class="user-img" style="width: 57px;"> <img src="{{ asset('img/priori-1.png') }}" alt="user" class="img-circle"> </div>
                              <div class="mail-contnet">
                                  <h4>DATOS MACROECONOMICOS Y SOCIALES</h4>
                              </div>
                          </a>
                      </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="white-box analytics-info p-10">
                        <div class="message-center">
                          <a href="javascript:void(0);" class="detallar" aria-controls="2">
                              <div class="user-img" style="width: 57px;"> <img src="{{ asset('img/priori-2.png') }}" alt="user" class="img-circle"></div>
                              <div class="mail-contnet">
                                  <h4>PROYECTOS ESPECIALES</h4>
                              </div>
                          </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                  <div class="white-box analytics-info p-10">
                      <div class="message-center">
                        <a href="javascript:void(0);" class="detallar" aria-controls="3">
                            <div class="user-img" style="width: 57px;"> <img src="{{ asset('img/priori-3.png') }}" alt="user" class="img-circle">  </div>
                            <div class="mail-contnet">
                                <h4>INVERSION PUBLICA</h4>
                            </div>
                        </a>
                      </div>
                  </div>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                  <div class="white-box center p-10">
                      <div class="message-center">
                        <a href="javascript:void(0);" class="detallar" aria-controls="4">
                            <div class="user-img" style="width: 57px;"> <img src="{{ asset('img/priori-4.png') }}" alt="user" class="img-circle"> </div>
                            <div class="mail-contnet">
                                <h4>RED VIAL FUNDAMENTAL</h4>
                            </div>
                        </a>
                      </div>
                  </div>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="white-box analytics-info p-10">
                        <div class="message-center">
                          <a href="javascript:void(0);" class="detallar" aria-controls="5">
                              <div class="user-img" style="width: 57px;"> <img src="{{ asset('img/priori-5.png') }}" alt="user" class="img-circle"> </div>
                              <div class="mail-contnet">
                                  <h4>INFORMES</h4>
                              </div>
                          </a>
                        </div>
                    </div>
                </div>
            </div>

      </div>
  </div>
</div>
<div id="opciones-hijos" style="display:none;">
  <div class="row" >
    <div id="titulo-hijo" class="col-lg-12 col-md-12" style="height: 66px;">
          
    </div>
  </div>

  <div class="row">
      <div class="col-lg-12">
          <div class="white-box p-10" style="margin-bottom: 1px;">
            <div class="row">
               <div id="desc_resultado" class="col-lg-12 list-group-item-warning font-normal" style="height: 36px;">
                 <!-- Nav tabs -->
                 <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="nav-item">
                       <a href="javascript:void(0);" class="nav-link panel-menu active" aria-controls="m-p-datos">
                         <span class="visible-xs"><i class=" fa fa-book"></i></span>
                         <span class="hidden-xs"><i class=" fa  fa-book "></i> Datos</span></a>
                     </li>
                     <li role="presentation" class="nav-item">
                       <a href="javascript:void(0);" class="nav-link panel-menu" aria-controls="m-p-filtros">
                         <span class="visible-xs"><i class=" ti-filter "></i></span>
                         <span class="hidden-xs"><i class=" ti-filter "></i> Filtros</span></a>
                     </li>
                     <li role="presentation" class="nav-item">
                       <a href="javascript:void(0);" class="nav-link panel-menu" aria-controls="m-p-detalles">
                         <span class="visible-xs"><i class="fa fa-info-circle"></i></span>
                         <span class="hidden-xs"><i class="fa fa-info-circle"></i> Detalles</span>
                       </a>
                     </li>
                     <li role="presentation" class="nav-item">
                       <a href="javascript:void(0);" class="nav-link panel-menu" aria-controls="m-p-graficas">
                         <span class="visible-xs"><i class="fa fa-bar-chart-o"></i></span>
                         <span class="hidden-xs"><i class="fa fa-bar-chart-o"></i> Graficas</span>
                       </a>
                     </li>



                 </ul>
               </div>
            </div>
          </div>
      </div>
  </div>

  <div id="cont-panel-menu" class="row" style="display:none;" >
      <div class="col-lg-12">
          <div class="white-box p-10" style="background-color: #fcf8e3;color: #8a6d3b;">
            <!-- Tab panes -->
            <div class="tab-content m-0">
                <div role="tabpanel" class="tab-pane" id="m-p-detalles">
                  <div class="stats-row m-0">
                      <div class="stat-item containertipoimg">
                        Sector:<br/>
                        Institucion:<br/>
                        Lugar:<br/>
                        Inicio:<br/>
                        Fin:
                      </div>
                      <div class="stat-item containertipoimg">
                        Estado:<br/>
                        Presupuesto Programado:<br/>
                        Presupuesto Reprogramado:<br/>
                        Presupuesto Efectuado:<br/>
                        Fin:
                      </div>
                  </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="m-p-graficas">

                  <div class="stats-row m-0">
                      <div class="stat-item containertipoimg">
                          <img name="column" src="{{ asset('img/icon-graf/11.png') }}" alt="11" class="image imgsel">
                          <div class="middle">
                            <div class="text">Usar</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="serial" src="{{ asset('img/icon-graf/1.png') }}" alt="1" class="image">
                          <div class="middle">
                            <div class="text">Usar</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="line" src="{{ asset('img/icon-graf/3.png') }}" alt="3" class="image">
                          <div class="middle">
                            <div class="text">Usar</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="pie" src="{{ asset('img/icon-graf/8.png') }}" alt="8" class="image">
                          <div class="middle">
                            <div class="text">Usar</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="area" src="{{ asset('img/icon-graf/4.png') }}" alt="4" class="image">
                          <div class="middle">
                            <div class="text">Usar</div>
                          </div>
                      </div>

                  </div>

                </div>
                <div role="tabpanel" class="tab-pane" id="m-p-filtros" aria-expanded="true">
                  <div class="row">
                      <div class="col-lg-6">

                      </div>
                      <div class="col-lg-6">


                      </div>
                  </div>
                </div>

            </div>

          </div>
      </div>
  </div>
  <div class="row" >
        <div id="contenido_datos" class="col-lg-3 col-md-12">
          <div class="white-box">
                <div id='jqxNavigationBar'>


                </div>
           </div>
        </div>

        <div id="contenido_detalle" class="col-lg-9 col-md-12 block">

            <div class="white-box p-10 block-content">
                <div style="height: 500px;">
                  <div id="chartdiv"></div>

                </div>
            </div>

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
    activarMenu('x','mp-9');
    menuModulosHideShow(1)
    var theme = 'light';




    $("#jqxNavigationBar").jqxNavigationBar({ theme:theme,width: "100%", expandMode: 'toggle'});



    $('.detallar').click(function() {
        $('#opciones-hijos').show();
        $('#opciones-padre').hide();

        $('#titulo-hijo').html('');
        $('#jqxNavigationBar').html('');

        var padre = $(this).attr("aria-controls");

        $.ajax({
                url: "{{url("/modulopriorizacion/ajax/cargarhijos")}}",
                data: {'padre': padre },
                type: "GET",
                dataType: 'json',
                success: function(date){
                  $.each(date, function(i, item) {
                    if(i=='titulo'){
                      $('#titulo-hijo').html(item);
                    }
                    if(i=='hijos'){
                      $('#jqxNavigationBar').html(item);
                      //$('#jqxNavigationBar').jqxNavigationBar({ source: item});
                    }

                  });
                  $('#jqxNavigationBar').jqxNavigationBar('add','-', ' ');
                  //$('#jqxNavigationBar').jqxNavigationBar('update', 1, 'Header', 'Content');
                  //$('#jqxNavigationBar').jqxNavigationBar('collapseAt', 0);
                  //$('#jqxNavigationBar').jqxNavigationBar('insert', 1, '-', '-');
                  //$('#jqxNavigationBar').jqxNavigationBar('refresh');

                },
                error:function(data){
                  console("Error recuperando configuracion de filtro de combos.");
                }
         });
    });







    var pressHistorico = "m-p-datos";
    $('.panel-menu').click(function() {
      //configuramos y activamos el menu del panel
      $('.panel-menu').removeClass('active');
      var panel = $(this).attr("aria-controls");
      $(this).addClass('active');
      if(panel != "m-p-datos"){
          if(pressHistorico == panel && $('#cont-panel-menu').is(":visible")){
              $('#cont-panel-menu').hide();
          }else{
            pressHistorico = panel;
            //configuramos y activamos el panel
            $('#cont-panel-menu').show();
            $('.tab-pane').removeClass('active');
            $('#'+panel).addClass('active');

            if($('#contenido_datos').is(":visible") && $('.mobile-main').is(":visible")){
              $('#contenido_datos').hide();
            }
          }
      }else{

          if(pressHistorico == panel && $('#contenido_datos').is(":visible")){
              //$('#contenido_datos').hide();
              $('#contenido_datos').attr('style','display:none !important');
          }else{
            pressHistorico = panel;
            $('#contenido_datos').show();
            $('#cont-panel-menu').hide();
          }

      }

    });

    function limpiarPaneles(){
      //LIMPIAMOS LOS PANELS SECUNDARIOS ANTES DE VARGAR ALGUN DATO
      $('#cont-panel-menu').hide();
      $('.panel-menu').removeClass('active');
      $('.tab-pane').removeClass('active');
    }


  });

  function back(){
      $('#opciones-padre').show();
      $('#opciones-hijos').hide();
  }

  </script>
@endpush
