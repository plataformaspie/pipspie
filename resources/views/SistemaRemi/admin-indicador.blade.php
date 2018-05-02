@extends('layouts.sistemaremi')

@section('header')

  <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}"  type="text/css" />
  <link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">


  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />

  <style media="screen">
    .select2-container-multi{
      padding-left: 0px;padding-right: 0px;padding-top: 0px;
    }

    table.scroll , .scroll tr td{
    border:1px solid #E4E7EA;
    }
    .scroll tbody {
        display:block;
        height:200px;
        overflow:auto;
    }
    .scroll thead, .scroll tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }
    .scroll thead {
        width: calc( 100% - 1em )
    }
    table.scroll {
        width:100%;
    }
  </style>
@endsection

@section('content')

  <div class="row bg-title">
      <!-- .page title -->
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Administrador de indicadores</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/index') }}">Indicadores</a></li>
              <li class="active">Administrar indicadores</li>
          </ol>
      </div>
      <!-- /.breadcrumb -->
  </div>

  <div id="option1" class="row">
      <div class="col-lg-12 ">
          <div class="white-box">
            <h3 class="box-title m-b-0">Lista de indicadores</h3>
            <p class="text-muted m-b-30">Indicadores registrados por su usuario<button id ="btn-new" type="button" class="btn btn-info btn-circle btn-lg" style="float: right;margin-top: -26px;"><i class="fa fa-plus"></i></button></p>
            <div id="dataTable"></div>
          </div>
      </div>
  </div>
  <div id="option2" class="row hidden">
      <div class="col-lg-12 ">
          <form id="formAdd" name="formAdd" action="javascript:save();" data-toggle="validator">
            {{ csrf_field() }}
            <input type="hidden" name="id_indicador" value="">
            <!-- .row -->
            <div class="row">
              <div class="col-sm-12">
                  <div class="white-box">
                      <h3 class="box-title m-b-0">Información del Indicador</h3>
                      <p class="text-muted m-b-30">Completar todos los datos solicitados<button id ="btn-back" type="button" class="btn btn-info btn-circle btn-lg" style="float: right;margin-top: -26px;"><i class="fa fa-arrow-left"></i></button></p>

                      <div class="form-group row m-b-10">
                        <div class="col-md-1 p-l-0 p-r-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 7px 95px 7px 3px;">Nombre</label>
                        </div>
                        <div class="col-md-11 p-l-0">
                            <input id="nombre" name="nombre" type="text" class="form-control"  placeholder="Nombre del indicador" required>
                            <div class="help-block with-errors"></div>
                        </div>
                      </div>

                      <div class="form-group row m-b-10">
                        <div class="col-md-1 p-l-0 p-r-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 7px 95px 7px 3px;">Definición</label>
                        </div>
                        <div class="col-md-11 p-l-0">
                            <textarea id="definicion" name="definicion" class="form-control" placeholder="Definición del indicador" required></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                      </div>

                    <hr>
                    <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 p-l-0">
                              <div class="vtabs">
                                  <ul class="nav tabs-vertical media p-t-0 p-l-0 p-r-0" style="width:300px;">
                                    <li class="tab nav-item">
                                        <a id="tab-ini1" data-toggle="tab" class="nav-link ctrl-btn active" href="#info1" aria-expanded="false">
                                          <span class="visible-xs"><i class="fa fa-sitemap" style="font-size: 25px"></i></span>
                                          <span class="hidden-xs"><i class="fa fa-sitemap" style="font-size: 25px"></i> Alinear al PDES</span>
                                        </a>
                                    </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini2" data-toggle="tab" class="nav-link ctrl-btn" href="#info2" aria-expanded="true">
                                            <span class="visible-xs"><i class="fa fa-book" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-book" style="font-size: 25px"></i> Información básica </span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini3" aria-expanded="false" class="nav-link ctrl-btn" data-toggle="tab" href="#info3">
                                            <span class="visible-xs"><i class="fa fa-building-o" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-building-o" style="font-size: 25px"></i> Método de cálculo</span>
                                          </a>
                                      </li>

                                      <li class="tab nav-item">
                                          <a id="tab-ini4" data-toggle="tab" class="nav-link ctrl-btn" href="#info4" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-eye" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-eye" style="font-size: 25px"></i> Metas y avances</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini5" data-toggle="tab" class="nav-link ctrl-btn" href="#info5" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-eye" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-eye" style="font-size: 25px"></i> Fuente de datos</span>
                                          </a>
                                      </li>

                                  </ul>
                                  <div class="tab-content media p-t-0 p-l-0 p-r-0" style="width: 80%;">
                                      <div id="info1" class="tab-pane active">
                                          <div class="col-md-12 list-group-item-success" style="margin-top: -9px;">
                                              <h4 style="width:100%;">Alinar al PDES </h4>
                                          </div>
                                          <p><h5>Ingrese los codigos PDES para agregar la articulación</h5></p>
                                          <div class="col-md-12">
                                                <div class="row m-b-5 m-l-5 m-t-5" >
                                                    <div class="form-group col-md-2 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Pilar</label>
                                                    </div>
                                                    <div class="form-group col-md-1 p-l-0">
                                                        <input id="cod_pilar" name="cod_pilar" type="text" class="form-control input" placeholder="Pilar" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group col-md-2 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta</label>
                                                    </div>
                                                    <div class="form-group col-md-1 p-l-0">
                                                        <input id="cod_meta" name="cod_meta" type="text" class="form-control input" placeholder="Meta" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group col-md-2 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Resultado</label>
                                                    </div>
                                                    <div class="form-group col-md-2 p-l-0">
                                                        <input id="cod_resultado" name="cod_resultado" type="text" class="form-control input" placeholder="Resultado" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="col-md-2 p-l-0 text-center">
                                                        <button type="button" class="btn btn-info btn-sm agregarART m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                    </div>
                                                </div>
                                                <h5>Detalle de articulación</h5>
                                                <hr/>
                                                <div id="datosART">
                                                    <div></div>
                                                </div>

                                            </div>
                                      </div>

                                      <div id="info2" class="tab-pane ">
                                          <div class="col-md-12 list-group-item-success">
                                              <h4 style="width:100%;">Información Básica del indicador </h4>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Etapa</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <select id="etapa" name="etapa" class="custom-select col-12 form-control" >
                                                      <option value="">Seleccionar...</option>
                                                      <option value="Etapa 1">Etapa 1</option>
                                                      <option value="Etapa 2">Etapa 2</option>
                                                      <option value="Etapa 3">Etapa 3</option>
                                                  </select>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Tipo</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">
                                                    <select id="tipo" name="tipo" class="custom-select col-12 form-control">
                                                        <option value="">Seleccionar...</option>
                                                        @foreach ($tipos as  $item)
                                                              <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>

                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de medida</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">
                                                    <select id="unidad_medida" name="unidad_medida" class="custom-select col-12 form-control" >
                                                        <option value="">Seleccionar...</option>
                                                        @foreach ($unidades as  $item)
                                                              <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>


                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Frecuencia de reporte</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">
                                                    <select id="frecuencia" name="frecuencia" class="custom-select col-12 form-control">
                                                        <option value="">Seleccionar...</option>
                                                        @foreach ($frecuencia as  $item)
                                                              <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>

                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                    <div class="col-md-3 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Serie disponible</label>
                                                    </div>
                                                    <div class="col-md-9 p-l-0">
                                                        <input id="serie_disponible" name="serie_disponible" type="text" class="form-control" placeholder="Tipo de indicador" >
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                              </div>
                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Variables de desagregación</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">
                                                    <div class="select2-wrapper">
                                                      <select id="variables_desagregacion" name="variables_desagregacion[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                          @foreach ($variables as  $item)
                                                                <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                          @endforeach
                                                      </select>
                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>


                                              <h5>Linea base del indicador</h5>
                                              <hr>
                                              <div class="row m-b-5 m-l-5 m-t-5" >
                                                  <div class="form-group col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fecha linea base</label>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0">
                                                    <div class='input-group date' id='dateLB'>
                                                      <input name="linea_base_fecha" type='text' class="form-control" placeholder="mm/yyyy"/>
                                                      <span class="input-group-addon">
                                                          <span class="glyphicon glyphicon-calendar">
                                                          </span>
                                                      </span>
                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Valor linea base</label>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0">
                                                      <input name="linea_base_valor" type="text" class="form-control input" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;" value="0.00">
                                                      <div class="help-block with-errors"></div>
                                                  </div>
                                              </div>

                                          </div>
                                      </div>

                                      <div id="info3" class="tab-pane">
                                          <div class="col-md-12 list-group-item-success">
                                              <h4 style="width:100%;">Método de cálculo del indicador</h4>
                                          </div>
                                          <div class="col-md-12">

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fórmula</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                <textarea id="formula" name="formula" class="form-control" placeholder="Fórmula" rows="2" ></textarea>
                                                <div class="help-block with-errors"></div>
                                              </div>
                                            </div>
                                            <h5>Detallar fórmula</h5>
                                            <hr/>
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Numerador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="numerador_detalle" name="numerador_detalle" class="form-control" placeholder="Numerador" rows="2" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fuente numerador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <input id="numerador_fuente" name="numerador_fuente" type="text" class="form-control"  placeholder="Tipo de indicador" >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Denominador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="denominador_detalle" name="denominador_detalle" class="form-control" placeholder="Denominador" rows="2" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fuente denominador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <input id="denominador_fuente" name="denominador_fuente" type="text" class="form-control" placeholder="Tipo de indicador" >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Observaciones a la fuente de datos</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="observacion" name="observacion" class="form-control" placeholder="Observaciones al indicador" rows="8" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                          </div>
                                      </div>

                                      <div id="info4" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Metas y avances</h4>
                                           </div>
                                           <div class="col-md-12">
                                               <h5>Metas macro</h5>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="col-md-1 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2020</label>
                                                   </div>
                                                   <div class="col-md-2 p-l-0">
                                                       <input id="id_meta_2020" name="id_meta_2020" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2020" name="meta_2020" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>

                                                   <div class="col-md-1 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2025</label>
                                                   </div>
                                                   <div class="col-md-2 p-l-0">
                                                       <input id="id_meta_2025" name="id_meta_2025" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2025" name="meta_2025" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>


                                                   <div class="col-md-1 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2030</label>
                                                   </div>
                                                   <div class="col-md-2 p-l-0">
                                                       <input id="id_meta_2030" name="id_meta_2030" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2030" name="meta_2030" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',',  'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-12">
                                             <hr/>
                                               <h5>Metas Parciales</h5>
                                               <div class="row m-b-5 m-l-5 m-t-5" >
                                                   <div class="form-group col-md-2 p-l-0 p-r-0 m-b-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2016</label>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0 m-b-0">
                                                       <input id="id_meta_2016" name="id_meta_2016" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2016" name="meta_2016" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                              </div>
                                              <div class="row m-l-5" >
                                                   <div class="form-group col-md-2 p-l-0 p-r-0 m-b-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2017</label>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0 m-b-0">
                                                       <input id="id_meta_2017" name="id_meta_2017" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2017" name="meta_2017" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                              </div>
                                              <div class="row  m-l-5" >
                                                   <div class="form-group col-md-2 p-l-0 p-r-0 m-b-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2018</label>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0 m-b-0">
                                                       <input id="id_meta_2018" name="id_meta_2018" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2018" name="meta_2018" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                               </div>
                                               <div class="row m-l-5" >
                                                    <div class="form-group col-md-2 p-l-0 p-r-0 m-b-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2019</label>
                                                    </div>
                                                    <div class="form-group col-md-3 p-l-0 m-b-0">
                                                        <input id="id_meta_2019" name="id_meta_2019" type="hidden" class="form-control oculto" required>
                                                        <input id="meta_2019" name="meta_2019" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                           </div>

                                           <div class="col-md-12">
                                             <hr/>
                                               <h4>Reportar avances</h4>
                                               <div class="row m-b-5 m-l-5 m-t-5" >
                                                   <div class="form-group col-md-2 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fecha reporte</label>
                                                   </div>
                                                   <div class="form-group col-md-2 p-l-0">
                                                     <div class='input-group date' id='dateAV'>
                                                       <input name="avance_fecha_input" type='text' class="form-control" placeholder="mes/Año"/>
                                                       <span class="input-group-addon">
                                                           <span class="glyphicon glyphicon-calendar">
                                                           </span>
                                                       </span>
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                   </div>
                                                   <div class="form-group col-md-2 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Valor a reportar</label>
                                                   </div>
                                                   <div class="form-group col-md-2 p-l-0">
                                                       <input name="avance_valor_input" type="text" class="form-control input" placeholder="Valor"  value="0" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;" >
                                                       <div class="help-block with-errors"></div>
                                                   </div>

                                                   <div class="col-md-2 p-l-0 text-center">
                                                       <button type="button" class="btn btn-info btn-sm agregarAV m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-8">
                                             <h5>Listado de avances reportados</h5>
                                               <div class="row m-b-5 m-l-5 m-t-5" >
                                                 <table id="set_avance" class="table table-hover scroll ">
                                                     <thead>
                                                         <tr>
                                                             <th class="col-sm-1">#</th>
                                                             <th class="col-sm-5">Fecha reportado</th>
                                                             <th class="col-sm-4">Valor reportado</th>
                                                             <th class="col-sm-1"> - </th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>
                                                     </tbody>
                                                 </table>
                                              </div>
                                           </div>

                                           <div class="col-md-12">
                                               <br/>
                                               <br/>
                                               <br/>
                                           </div>
                                       </div>


                                       <div id="info5" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Fuente de datos del indicador</h4>
                                           </div>
                                           <div class="col-md-12">



                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Fuente</label>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <div class="select2-wrapper">
                                                     <select id="fuente_datos" name="fuente_datos[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                         @foreach ($fuente_datos as  $item)
                                                               <option value="{{ $item->id }}">{{$item->nombre}}</option>
                                                         @endforeach
                                                     </select>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>
                                             <h5>Detalle fuente de datos seleccionado(s)</h5>
                                             <hr/>
                                             <div id="datosFD">

                                             </div>

                                           </div>
                                       </div>

                                  </div>
                              </div>

                      </div>
                    </div>

                    <div class="col-sm-12">
                            <div class="form-group text-center">
                              <button id="bt_guardar" type="submit" class="btn btn-info hidden tap-btn">Guardar</button>
                              <button id="bt_siguiente" type="button" class="btn btn-info tap-btn">Siguiente</button>
                              <button type="button" class="btn btn-default btn-back">Cancelar</button>
                            </div>
                    </div>

                  </div>
              </div>


            </div>
            <!-- /.row -->
          </form>
      </div>
  </div>

  <div id="window" class="white-popup-block popup-basic admin-form mfp-with-anim" style="display: none;">
      <div class="panel panel-heading" >
        <section><span class="panel-title"><i class="fa fa-pencil"></i> Fuente de datos</span></section>
      </div>
      <div id="divcon">

        <form id="formAddFuente" name="formAddFuente" action="javascript:saveFuente();" data-toggle="validator">
          {{ csrf_field() }}
          <input type="hidden" name="id_indicador" value="">
          <!-- .row -->
          <div class="row" style="margin-right: 0px;">
            <div class="col-sm-12">
                <div class="white-box p-t-0">
                    <h3 class="box-title m-b-0">Registro de fuente de datos</h3>
                    <p class="text-muted m-b-10">Completar los datos solicitados en el formulario <button id ="btn-new-fuente" type="submit" class="btn btn-info btn-sm" style="float: right;margin-top: -26px;"><i class="fa fa-plus"></i>Guardar</button></p>

                    <div class="form-group row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Nombre</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                          <input id="fd_nombre" name="fd_nombre" type="text" class="form-control"  placeholder="Nombre de la fuente" required>
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class=" row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Acrónimo</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0">
                          <input id="fd_acronimo" name="fd_acronimo" type="text" class="form-control"  placeholder="Acrónimo" required>
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Tipo</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0">
                          <select id="fd_tipo" name="fd_tipo" class="custom-select col-12 form-control" required>
                              <option value="">Seleccionar...</option>
                              @foreach ($fuente_tipos as  $item)
                                    <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                              @endforeach
                          </select>
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class=" row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="fd_periodicidad" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Periodicidad</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0">
                          <select id="fd_periodicidad" name="fd_periodicidad" class="custom-select col-12 form-control">
                              <option value="">Seleccionar...</option>
                              @foreach ($frecuencia as  $item)
                                    <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                              @endforeach
                          </select>
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="fd_serie_datos" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Serie_datos</label>
                      </div>
                      <div class=" form-group col-md-4 p-l-0">
                          <input id="fd_serie_datos" name="fd_serie_datos" type="text" class="form-control"  placeholder="Serie datos disponible">
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Cobertura</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                          <select id="fd_cobertura_geografica" name="fd_cobertura_geografica[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                              @foreach ($dimensiones as  $item)
                                    <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                              @endforeach
                          </select>
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group row m-b-10 p-t-20">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Representatividad</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                          <input id="fd_nivel_representatividad_datos" name="fd_nivel_representatividad_datos" type="text" class="form-control"  placeholder="Nivel representatividad de datos">
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Variables</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                          <select id="fd_variable" name="fd_variable[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                              @foreach ($variables as  $item)
                                    <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                              @endforeach
                          </select>
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <div class="form-group row m-b-10 p-t-20">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Observaciones</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                        <textarea id="fd_observacion" name="fd_observacion" class="form-control" placeholder="Observaciones"></textarea>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <h3 class="box-title m-b-0">Relacionar Responsables</h3>



                    <ul class="nav nav-tabs" role="tablist">

                        <li role="presentation" class="active nav-item">
                          <a href="#lista" class="nav-link" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">
                            <span class="visible-xs"><i class="ti-user"></i></span>
                            <span class="hidden-xs">Lista </span>
                            <span id="cont_resp"class="label label-warning" style="font-size:15px;font-weight:bold;">0</span></a>
                        </li>
                        <li role="presentation" class="nav-item">
                          <a href="#registro" class="nav-link" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                            <span class="visible-xs"><i class="ti-home"></i></span>
                            <span class="hidden-xs"> Registrar</span>
                          </a>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="lista">
                          <table id="set_responsables" class="table table-hover scroll ">
                              <thead>
                                  <tr>
                                      <th style="width: 5%;">#</th>
                                      <th style="width: 90%;">Detalle responsable</th>
                                      <th style="width: 5%;"> - </th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="registro">

                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="row">
                                          <div class="col-md-4 p-l-0 p-r-0">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;" >Nombre entidad cabeza</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="responsable_1" name="responsable_1" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>

                                          <div class="col-md-4 p-l-0 p-r-0">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Nombre sub entidad</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="responsable_2" name="responsable_2" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>

                                          <div class="col-md-4 p-l-0 p-r-0">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Nombre sub entidad</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="responsable_3" name="responsable_3" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>

                                          <div class="col-md-4 p-l-0 p-r-0">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Número de referencia</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="referencia" name="referencia" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-12 p-l-0 text-center">
                                  <button type="button" class="btn btn-info btn-sm agregarRS m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                              </div>


                            </div>

                        </div>


                    </div>



                </div>
            </div>
        </div>

      </div>
  </div>









@endsection

@push('script-head')
  <!-- ... -->

    <script type="text/javascript" src="{{ asset('plugins/bower_components/moment/min/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bower_components/moment/min/locales.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxwindow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxbuttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxscrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdata.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdatatable.js') }}"></script>
    <script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script type="text/javascript" src="{{ asset('js/jqwidgets-localization.js') }}"></script>

  <!-- Date Picker Plugin JavaScript -->

  <script type="text/javascript">
  var fechaAV = [];
  var valorAV = [];
  var estadoAV = [];
  var origenAV = [];

  var responsable1A = [];
  var responsable2A = [];
  var responsable3A = [];
  var referenciaA = [];
  var idAV = [];
    $(document).ready(function(){
      //$(".select2").select2();

      $("#formAdd .select2").select2().attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);');
      $("#formAddFuente .select2").select2().attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);');
      $(".input").inputmask();
      $(function () {
                  $('#dateLB').datetimepicker({
                      viewMode: 'years',
                      format: 'MM/YYYY',
                      locale: 'es'
                  });
                  $('#dateAV').datetimepicker({
                      viewMode: 'years',
                      format: 'MM/YYYY',
                      locale: 'es'
                  });
      });



      $(".agregarART").click(function () {
         var codigo = $('input[name=cod_pilar]').val()+$('input[name=cod_meta]').val()+$('input[name=cod_resultado]').val();
         if(!$('#datosART').find("#ART"+codigo).length){
        $.ajax({
                url: "{{ url('/api/sistemaremi/setDataPdes') }}",
                data: { 'p': $('input[name=cod_pilar]').val(),'m':$('input[name=cod_meta]').val(),'r':$('input[name=cod_resultado]').val() },
                type: "get",
                dataType: 'json',
                success: function(data){
                  if(data.error == false){
                    //ip_id--;
                    var html = '<div id="ART'+codigo+'" class="row">'+
                                  '<div class="media row col-lg-12 ">'+
                                      '<div class="col-lg-2 text-center">'+
                                          '<img src="/img/'+data.set[0].logo+'" alt="Pliar" width="100">'+
                                          '<a class="btn btn-block btn-info btn-sm m-t-10" onclick="quitarART('+codigo+',1);">Quitar</a>'+
                                      '</div>'+
                                      '<div class="row col-lg-10">'+
                                          '<input type="hidden" name="id_resultado_articulado[]" value="" />'+
                                          '<input type="hidden" name="resultado_articulado[]" value="'+data.set[0].id_resultado+'" />'+
                                          '<input type="hidden" id="EST'+codigo+'" name="estado_resultado_articulado[]" value="1" />'+
                                          '<div class="col-12"><b>'+data.set[0].pilar+':</b> '+data.set[0].desc_p+
                                          '</div>'+
                                          '<div class="col-12"><b>'+data.set[0].meta+':</b> '+data.set[0].desc_m+
                                          '</div>'+
                                          '<div class="col-12"><b>'+data.set[0].resultado+':</b> '+data.set[0].desc_r+
                                          '</div>'+
                                      '</div>'+
                                  '</div>'+
                                '</div>';
                    $("#datosART").append(html);
                  }else{
                      $.toast({
                       heading: data.title,
                       text: data.msg,
                       position: 'top-right',
                       loaderBg:'#ff6849',
                       icon: 'warning',
                       hideAfter: 3500

                     });
                  }
                },
                error:function(data){
                  $.toast({
                   heading: 'Error:',
                   text: 'Error al recuperar los datos.',
                   position: 'top-right',
                   loaderBg:'#ff6849',
                   icon: 'error',
                   hideAfter: 3500

                 });
                }
          });
          // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe la relación solicitada.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });



      var ip_id = -1000;

      $(".agregarAV").click(function () {

        if( $("input[name=avance_fecha_input]").val() != ""){

           var idAV = $('input[name=avance_fecha_input]').val().replace('/', '');
           var valor = ( $("input[name=avance_valor_input]").val() ? $("input[name=avance_valor_input]").val():0);
           if(!$('#set_avance').find("#AV"+idAV).length){

              fechaAV.push($('input[name=avance_fecha_input]').val());
              valorAV.push(valor);
              estadoAV.push(1);
              origenAV.push(1);
              actualizarListaAvance();

          }else{
              $.toast({
               heading: 'Alerta:',
               text: 'Ya existe valor en la fecha reportada.',
               position: 'top-right',
               loaderBg:'#ff6849',
               icon: 'warning',
               hideAfter: 3500
             });
            }
        }else{
          $.toast({
           heading: 'Error:',
           text: 'Llene los campos para agregar avance.',
           position: 'top-right',
           loaderBg:'#ff6849',
           icon: 'error',
           hideAfter: 3500
         });

        }
      });


      $(".agregarRS").click(function () {

        if( $("input[name=responsable_1]").val() != ""){

              responsable1A.push($('input[name=responsable_1]').val());
              responsable2A.push($('input[name=responsable_2]').val());
              responsable3A.push($('input[name=responsable_3]').val());
              referenciaA.push($('input[name=referencia]').val());

              actualizarListaResponsable();


        }else{
          $.toast({
           heading: 'Error:',
           text: 'Llene los campos para agregar responsable.',
           position: 'top-right',
           loaderBg:'#ff6849',
           icon: 'error',
           hideAfter: 3500
         });

        }
      });


    var url = '{{ url('api/sistemaremi/apiSetIndicadores') }}';
    // prepare the data
    var source =
    {
        dataType: "json",
        dataFields: [
            { name: 'id', type: 'int' },
            { name: 'codigo', type: 'string' },
            { name: 'nombre', type: 'string' },
            { name: 'tipo', type: 'string' },
            { name: 'logo', type: 'string' }
        ],
        id: 'id',
        url: url
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#dataTable").jqxDataTable(
    {
        source: dataAdapter,
        width:"100%",
        columnsResize: true,
        filterable: true,
        filterMode: 'simple',
        pageable: true,
        pagerButtonsCount: 10,
        localization: getLocalization('es'),
        pageSize: 5,
        columns: [
          { text: 'Logo', dataField: 'logo', width: 100,
                cellsRenderer: function (row, column, value, rowData) {
                    if(rowData.logo){
                        var image = "<div style='margin: 5px; margin-bottom: 3px;'>";
                        var imgurl = rowData.logo ;
                        var img = '<img width="60" height="60" style="display: block;" src="/img/icono_indicadores/' + imgurl + '"/>';
                        image += img;
                        image += "</div>";
                        return image;
                    }else{
                      return "";
                    }

                }
          },
          { text: 'Nombre del indicador', minWidth: 300,dataField: 'nombre' },
          { text: 'Codigo', dataField: 'codigo', width: 200,cellsAlign: 'center' },
          { text: 'Opciones', width: 120,
                cellsRenderer: function (row, column, value, rowData) {
                        var abm = "<div style='margin: 5px; margin-bottom: 3px;'>";
                        var inputEdit = '<button onclick="btn_update('+rowData.id+')" class="btn btn-sm btn-info "><span>Gestionar</span> <i class="fa fa-pencil m-l-5"></i></button>';
                        var inputDelete = '<button onclick="btn_delete('+rowData.id+')" class="btn btn-sm btn-info  m-t-10"><span>Eliminar &nbsp; &nbsp;</span> <i class="fa fa-trash-o m-l-5"></i></button>';
                        abm += inputEdit;
                        abm += inputDelete;
                        abm += "</div>";
                        return abm;

                }
          },
      ]
    });



    $(".ctrl-btn").click(function () {
      var activo = $(this).attr('href');
      var next =  activo.substr(-1,1) ;
      if(next == 5){
        $("#bt_siguiente").addClass('hidden');
        $("#bt_guardar").removeClass('hidden');
      }else{
        $("#bt_siguiente").removeClass('hidden');
        $("#bt_guardar").addClass('hidden');
      }
    });


    $(".tap-btn").click(function () {
      var activo = $(".nav-item a.active").attr('href');

      var next =  activo.substr(-1,1) ;
      next++;
      if(next == 5){
        $("#bt_siguiente").addClass('hidden');
        $("#bt_guardar").removeClass('hidden');
      }
      $("#tab-ini"+next ).trigger( "click" );

    });


    function createElements() {
         $('#window').jqxWindow({
             resizable: false,
             isModal: true,
             autoOpen: false,
             width: '40%',
             height: '45%',
             minWidth: 330,
             minHeight: '10%',
             //cancelButton: $("#Cancel"),
             modalOpacity: 0.01,
             draggable: true
         });
         $('#window').jqxWindow('focus');
     }
     createElements();




     $("#fuente_datos").change(function () {
       $("#datosFD").html('');
       $.ajax({
             url: "{{ url('/api/sistemaremi/apiSetFuenteDatos') }}",
             data: { 'fuente': $(this).val()},
             type: "get",
             dataType: 'json',
             success: function(date){
               $.each(date.item, function(i, data) {
                   var html= '<div class="row">'+
                                   '<div class="media row col-lg-12 ">'+
                                       '<div class="row col-lg-12">'+
                                            '<div class="col-12" style="font-size:20px"><b>Nombre:</b> '+data.nombre+' ('+data.acronimo+')</div>'+
                                            '<div class="col-6"><b>Tipo:</b> '+data.tipo+'</div>'+
                                            '<div class="col-6"><b>Periodicidad:</b> '+data.periodicidad+'.</div>'+
                                            '<div class="col-6"><b>Serie de datos:</b> '+data.serie_datos+'.</div>'+
                                            '<div class="col-6"><b>Cobertura geográfica:</b>'+data.cobertura_geografica+'</div>'+
                                            '<div class="col-6"><b>Principales variables:</b> '+data.variable+'.</div>'+
                                            '<div class="col-6"><b>Nivel de representatividad de datos:</b> '+data.nivel_representatividad_datos+'</div>'+
                                            '<div class="col-12"><b>Observaciones:</b> '+data.observacion+'.</div>'+
                                      '</div>'+
                                  '</div>'+
                               '</div>';
                   $("#datosFD").append(html);
               });

             },
             error:function(data){
               console.log("no se recupero nada");
             }
       });


     });











    });
    //fin document
    function actualizarListaAvance(){
      var cav= 1;
      $("#set_avance > tbody").html("");
      $.ajax({
            url: "{{ url('/api/sistemaremi/apiSourceOrderbyArray') }}",
            type: "GET",
            dataType: 'json',
            data:{'fechas':fechaAV,'valores':valorAV,'estados':estadoAV},
            success: function(date){
                  if(date.error == false){
                      $.each(date.item, function(i, data) {
                        if(estadoAV[data.index]==1){
                            var html = '<tr id="AV'+ data.valor.replace('/', '') +'">'+
                                            '<td>'+
                                               '<input type="hidden" name="id_avance[]" value="'+ (idAV[data.index] ? idAV[data.index] : "") +'" /><input type="hidden" id="AVEST'+data.valor.replace('/', '')+'" name="avance_estado[]" value="1" />'+cav+
                                            '</td>'+
                                            '<td>'+
                                              '<input type="hidden" name="avance_fecha[]" value="'+ data.valor +'" />'+
                                               data.valor+
                                            '</td>'+
                                            '<td>'+
                                              '<input type="hidden" name="avance_valor[]" value="'+ valorAV[data.index]+'" />'+
                                               valorAV[data.index]+
                                            '</td>'+
                                            '<td>'+
                                              '<a data-toggle="tooltip" data-original-title="Borrar" onclick="quitarAV(\''+ data.valor.replace('/', '')+'\','+origenAV[data.index]+','+data.index+');" style="cursor: pointer;"> <i class="fa fa-close text-danger"></i> </a>'+
                                            '</td>'+
                                      '</tr>';
                            $("#set_avance > tbody").append(html);
                            cav++;
                          }else{
                            var html = '<tr id="0AV'+ data.valor.replace('/', '') +'" class="hidden">'+
                                            '<td>'+
                                               '<input type="hidden" name="id_avance[]" value="'+ (idAV[data.index] ? idAV[data.index] : "") +'" /><input type="hidden" id="AVEST'+data.valor.replace('/', '')+'" name="avance_estado[]" value="0" />'+cav+
                                            '</td>'+
                                            '<td>'+
                                              '<input type="hidden" name="avance_fecha[]" value="'+ data.valor +'" />'+
                                               data.valor+
                                            '</td>'+
                                            '<td>'+
                                              '<input type="hidden" name="avance_valor[]" value="'+ valorAV[data.index]+'" />'+
                                               valorAV[data.index]+
                                            '</td>'+
                                            '<td>'+
                                              '<a data-toggle="tooltip" data-original-title="Borrar" onclick="quitarAV(\''+ data.valor.replace('/', '')+'\','+origenAV[data.index]+','+data.index+');"> <i class="fa fa-close text-danger"></i> </a>'+
                                            '</td>'+
                                      '</tr>';
                            $("#set_avance > tbody").append(html);
                          }

                     });

               }
            },
            error:function(data){
              alert("Error recuperar los datos.");
            }
      });



    }

    function actualizarListaResponsable(){
      var cav= 1;
      $("#set_responsables > tbody").html("");

      $.ajax({
            url: "{{ url('/api/sistemaremi/apiSourceOrderbyArray2') }}",
            type: "GET",
            dataType: 'json',
            data:{'responsable1':responsable1A,'responsable2':responsable2A,'responsable3':responsable3A,'referencia':referenciaA},
            success: function(date){
                  if(date.error == false){
                      $.each(date.item, function(i, data) {
                            var html = '<tr id="RS'+cav+'">'+
                                            '<td style="width: 5%;">'+
                                               cav+
                                            '</td>'+
                                            '<td style="width: 90%;">'+
                                                 '<input type="hidden" name="responsable_nivel_1[]" value="'+ responsable1A[data.index] +'" />'+
                                                 '<input type="hidden" name="responsable_nivel_2[]" value="'+ responsable2A[data.index] +'" />'+
                                                 '<input type="hidden" name="responsable_nivel_3[]" value="'+ responsable3A[data.index] +'" />'+
                                                 '<input type="hidden" name="numero_referencia[]" value="'+ referenciaA[data.index] +'" />'+
                                                 '<b>Entidad Cabeza:</b> '+responsable1A[data.index]+'<br/>'+
                                                 '<b>Sub entidad:</b> '+ responsable2A[data.index]+'<br/>'+
                                                 '<b>Sub entidad:</b> '+ responsable3A[data.index] +'<br/>'+
                                                 '<b>Número referencia:</b> '+ referenciaA[data.index]+
                                            '</td>'+
                                            '<td style="width: 5%;">'+
                                              '<a data-toggle="tooltip" data-original-title="Borrar" onclick="quitarRS('+cav+','+data.index+');" style="cursor: pointer;"> <i class="fa fa-close text-danger"></i> </a>'+
                                            '</td>'+
                                      '</tr>';
                            $("#set_responsables > tbody").append(html);
                            cav++;
                     });
                    $("#cont_resp").html(cav-1);
               }else{
                 $("#cont_resp").html(0);
               }
            },
            error:function(data){
              alert("Error recuperar los datos.");
            }
      });



    }
    function quitarART(ele,tipo){
        if(tipo == 1){
          $('#ART'+ele).remove();
        }else{
          $('#ART'+ele).addClass('hidden');
          $('#EST'+ele).val(0);
          $('#ART'+ele).attr("id",'0ART'+ele);
        }

    }
    function quitarAV(ele,tipo,index){

        if(tipo == 1){
          $('#AV'+ele).remove();
          fechaAV.splice(index, 1);
          valorAV.splice(index, 1);
          estadoAV.splice(index, 1);
          origenAV.splice(index, 1);
        }else{
          estadoAV[index] = 0;
        }

        actualizarListaAvance();
    }
    function quitarRS(ele,index){


          $('#RS'+ele).remove();
          responsable1A.splice(index, 1);
          responsable2A.splice(index, 1);
          responsable3A.splice(index, 1);
          referenciaA.splice(index, 1);

        actualizarListaResponsable();
    }
    function editarI(ele){
       alert(ele);
    }

    function deleteI(ele){
       alert(ele);
    }

    $('#btn-back, .btn-back').click(function() {
       $('#option1').removeClass('hidden');
       //$('#nivel_1').addClass('show');
       $('#option2').removeClass('show');
       $('#option2').addClass('hidden');

       $("#formAdd")[0].reset();
       $("#formAddFuente")[0].reset();
       $('.with-errors').html('');
       $('.form-group').removeClass('has-error');
       $("#variables_desagregacion").val('').trigger('change');
       $("#datosART").html("");
       $("#fuente_datos").val('').trigger('change');
       $("#fd_cobertura_geografica").val('').trigger('change');
       $("#fd_variable").val('').trigger('change');
       $("#cont_resp").html(0);
       $("#datosFD").html("");
       fechaAV = [];
       valorAV = [];
       estadoAV = [];
       origenAV = [];
       responsable1A = [];
       responsable2A = [];
       responsable3A = [];
       referenciaA = [];
       idAV = [];
       $("#set_avance > tbody").html("");
       $("#set_responsables > tbody").html("");
       $('input[name="id_indicador"]').val(null);
       $("#tab-ini1" ).trigger( "click" );
    });
    $('#btn-new, .btn-new ').click(function() {
       $('#option2').removeClass('hidden');
       $('#option1').removeClass('show');
       $('#option1').addClass('hidden');
    });
    function btn_update(ele) {
      $("#btn-new" ).trigger( "click" );
       $.ajax({
             url: "{{ url('/api/sistemaremi/apiDataSetIndicador') }}",
             type: "GET",
             dataType: 'json',
             data:{'id':ele},
             success: function(data){
               if(data.error == false){

                   //$("#mod_cod_m").val(data.meta).trigger('change');
                   $('input[name="id_indicador"]').val(data.indicador[0].id);
                   $('input[name="nombre"]').val(data.indicador[0].nombre);
                   $('textarea[name="definicion"]').val(data.indicador[0].definicion);
                   $('select[name=etapa]').val(data.indicador[0].etapa);
                   $('select[name=tipo]').val(data.indicador[0].tipo);
                   $('select[name=unidad_medida]').val(data.indicador[0].unidad_medida);
                   $('select[name=frecuencia]').val(data.indicador[0].frecuencia);
                   if(data.indicador[0].variables_desagregacion){
                     $("#variables_desagregacion").val(data.indicador[0].variables_desagregacion.split(",")).trigger('change');
                   }
                   if(data.indicador[0].linea_base_mes){
                     $('input[name="linea_base_fecha"]').val(data.indicador[0].linea_base_mes+'/'+data.indicador[0].linea_base_anio);
                   }
                   $('input[name="linea_base_valor"]').val(data.indicador[0].linea_base_valor);
                   $('textarea[name="formula"]').val(data.indicador[0].formula);
                   $('textarea[name="numerador_detalle"]').val(data.indicador[0].numerador_detalle);
                   $('input[name="numerador_fuente"]').val(data.indicador[0].numerador_fuente);
                   $('textarea[name="denominador_detalle"]').val(data.indicador[0].denominador_detalle);
                   $('input[name="denominador_fuente"]').val(data.indicador[0].denominador_fuente);
                   $('input[name="serie_disponible"]').val(data.indicador[0].serie_disponible);
                   $('textarea[name="observacion"]').val(data.indicador[0].observacion);

                   if(data.indicador[0].fuente_datos){
                     $("#fuente_datos").val(data.indicador[0].fuente_datos.split(",")).trigger('change');
                   }


                  $.each(data.pdes, function(i, data) {
                   var html = '<div id="ART'+data.cod_p+data.cod_m+data.cod_r+'" class="row">'+
                                 '<div class="media row col-lg-12 ">'+
                                     '<div class="col-lg-2 text-center">'+
                                         '<img src="/img/'+data.logo+'" alt="Pliar" width="100">'+
                                         '<a class="btn btn-block btn-info btn-sm m-t-10" onclick="quitarART('+data.cod_p+data.cod_m+data.cod_r+',2);">Quitar</a>'+
                                     '</div>'+
                                     '<div class="row col-lg-10">'+
                                         '<input type="hidden" name="id_resultado_articulado[]" value="'+data.id+'" />'+
                                         '<input type="hidden" name="resultado_articulado[]" value="'+data.id_resultado+'" />'+
                                         '<input type="hidden" id="EST'+data.cod_p+data.cod_m+data.cod_r+'" name="estado_resultado_articulado[]" value="1" />'+
                                         '<div class="col-12"><b>'+data.pilar+':</b> '+data.desc_p+
                                         '</div>'+
                                         '<div class="col-12"><b>'+data.meta+':</b> '+data.desc_m+
                                         '</div>'+
                                         '<div class="col-12"><b>'+data.resultado+':</b> '+data.desc_r+
                                         '</div>'+
                                     '</div>'+
                                 '</div>'+
                               '</div>';
                   $("#datosART").append(html);
                  });
                  $.each(data.metas, function(i, data) {
                     $('input[name="id_meta_'+data.gestion+'"]').val(data.id);
                     $('input[name="meta_'+data.gestion+'"]').val(data.valor);
                  });


                  $.each(data.avances, function(i, data) {
                      fechaAV.push(data.fecha_generado_mes+'/'+data.fecha_generado_anio);
                      valorAV.push(data.valor);
                      estadoAV.push(1);
                      origenAV.push(2);
                      idAV.push(data.id);
                  });
                  actualizarListaAvance();

               }else{
                   $.toast({
                    heading: data.title,
                    text: data.msg,
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'warning',
                    hideAfter: 3500
                  });
               }
             },
             error:function(data){
               $.toast({
                heading: 'Error:',
                text: 'Error al recuperar los datos.',
                position: 'top-right',
                loaderBg:'#ff6849',
                icon: 'error',
                hideAfter: 3500

              });
             }
       });

    }

    function btn_delete(ele) {
        swal({
          title: "Está seguro?",
          text: "No podrá recuperar este registro!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si, eliminar!",
          closeOnConfirm: false
        }, function(){
             $.ajax({
                   url: "{{ url('/api/sistemaremi/apiDeleteIndicador') }}",
                   data: { '_token': $('input[name=_token]').val(),'id_indicador': ele },
                   type: "delete",
                   dataType: 'json',
                   success: function(date){
                       $("#dataTable").jqxDataTable("updateBoundData");
                       swal("Eliminado!", "Se ha eliminado tu registro.", "success");
                   },
                   error:function(data){
                     alert("Error recuperar los datos.");
                   }
             });
        });
    }


    function save(){
      swal({
        title: "Guardar?",
        text: "Se completo el llenado de los datos solicitados!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Guardar!",
        closeOnConfirm: false
      },function(){
            $.ajax({
                  type: "POST",
                  url: "{{ url('/api/sistemaremi/apiSaveIndicador') }}",
                  dataType: 'json',
                  data: $("#formAdd").serialize() , // Adjuntar los campos del formulario enviado.
                  success: function(data){
                    if(data.error == false){
                        $("#btn-back" ).trigger( "click" );
                        $("#dataTable").jqxDataTable("updateBoundData");
                        swal("Guardado!", "Se ha guardado correctamente.", "success");
                    }else{
                        $.toast({
                         heading: data.title,
                         text: data.msg,
                         position: 'top-right',
                         loaderBg:'#ff6849',
                         icon: 'warning',
                         hideAfter: 3500
                       });
                    }
                  },
                  error:function(data){
                    $.toast({
                     heading: 'Error:',
                     text: 'Error al recuperar los datos.',
                     position: 'top-right',
                     loaderBg:'#ff6849',
                     icon: 'error',
                     hideAfter: 3500

                   });
                  }
            });
      });
    }

    function saveFuente(){

      var r = confirm("Guardar la fuente de datos?");
      if (r == true) {
        $.ajax({
              type: "POST",
              url: "{{ url('/api/sistemaremi/apiSaveFuente') }}",
              dataType: 'json',
              data: $("#formAddFuente").serialize() , // Adjuntar los campos del formulario enviado.
              success: function(data){
                if(data.error == false){
                    updateComboFuente();
                }else{
                    $.toast({
                     heading: data.title,
                     text: data.msg,
                     position: 'top-right',
                     loaderBg:'#ff6849',
                     icon: 'warning',
                     hideAfter: 3500
                   });
                }
              },
              error:function(data){
                $.toast({
                 heading: 'Error:',
                 text: 'Error al recuperar los datos.',
                 position: 'top-right',
                 loaderBg:'#ff6849',
                 icon: 'error',
                 hideAfter: 3500

               });
              }
        });
      } else {
          txt = "You pressed Cancel!";
      }

    }

    //Evento del boton nuevo
    function win_fuente(){
      $('#divcon').animate({scrollTop : 0}, 500);
      var offset = $("#side-menu").offset();
      $("#window").jqxWindow({ position: { x: parseInt(offset.left) + 30  , y: parseInt(offset.top) + (180) } });
          $("#window").css('visibility', 'visible');
          $('#window').jqxWindow('open');
          $('#window').jqxWindow('focus');
          $("#formAddFuente")[0].reset();
          $("#fd_cobertura_geografica").val('').trigger('change');
          $("#fd_variable").val('').trigger('change');
          $("#set_responsables > tbody").html("");
          $("#cont_resp").html(0);
    }
    $(document).keydown(function(tecla){
          if (tecla.keyCode == 119) {
            var offset = $("#side-menu").offset();
            $("#window").jqxWindow({ position: { x: parseInt(offset.left) + 30  , y: parseInt(offset.top) + (180) } });
                $("#window").css('visibility', 'visible');
                $('#window').jqxWindow('open');
                $('#window').jqxWindow('focus');
                $("#formAddFuente")[0].reset();
                $("#fd_cobertura_geografica").val('').trigger('change');
                $("#fd_variable").val('').trigger('change');
                $("#set_responsables > tbody").html("");
                $("#cont_resp").html(0);
          }
    });

    function updateComboFuente(){
        $("#fuente_datos").empty();
        $.ajax({
              type: "get",
              url: "{{ url('/api/sistemaremi/apiUpdateComboFuente') }}",
              dataType: 'json',
              success: function(data){
                $.each(data.item, function(i, data) {
                    $("#fuente_datos").append('<option value="'+data.id+'">'+data.nombre+'</option>');
                    $('#window').jqxWindow('close');
                    $("#formAddFuente")[0].reset();
                    $("#fd_cobertura_geografica").val('').trigger('change');
                    $("#fd_variable").val('').trigger('change');
                    $("#set_responsables > tbody").html("");
                });
              },
              error:function(data){
                $.toast({
                 heading: 'Error:',
                 text: 'Error al recuperar los datos.',
                 position: 'top-right',
                 loaderBg:'#ff6849',
                 icon: 'error',
                 hideAfter: 3500

               });
              }
        });
    }

  </script>
@endpush
