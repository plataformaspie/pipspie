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
                                          <a id="tab-ini" data-toggle="tab" class="nav-link active" href="#info1" aria-expanded="true">
                                            <span class="visible-xs"><i class="fa fa-book" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-book" style="font-size: 25px"></i> Información básica </span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a aria-expanded="false" class="nav-link" data-toggle="tab" href="#info3">
                                            <span class="visible-xs"><i class="fa fa-building-o" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-building-o" style="font-size: 25px"></i> Método de cálculo</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a data-toggle="tab" class="nav-link" href="#info5" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-sitemap" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-sitemap" style="font-size: 25px"></i> Alinear a PDES</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a data-toggle="tab" class="nav-link" href="#info4" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-eye" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-eye" style="font-size: 25px"></i> Metas</span>
                                          </a>
                                      </li>

                                  </ul>
                                  <div class="tab-content media p-t-0 p-l-0 p-r-0" style="width: 80%;">
                                      <div id="info1" class="tab-pane active">
                                          <div class="col-md-12 list-group-item-success">
                                              <h4 style="width:100%;">Información Básica </h4>
                                          </div>
                                          <div class="col-md-12">

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
                                                  <!--select class="select2 m-b-10 select2-multiple" multiple="multiple" data-placeholder="Seleccionar" required>

                                                  </select-->
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
                                                  <input name="linea_base_valor" type="text" class="form-control input" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;" >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                          </div>
                                      </div>
                                      <div id="info3" class="tab-pane">
                                          <div class="col-md-12 list-group-item-success">
                                              <h4 style="width:100%;">Método de cálculo </h4>
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

                                      <div id="info5" class="tab-pane">
                                          <div class="col-md-12 list-group-item-success">
                                              <h4 style="width:100%;">Alinar a PDES </h4>
                                          </div>
                                          <div class="col-md-12">
                                              <div class="row m-b-5 m-l-5 m-t-5" >
                                                  <div class="form-group col-md-2 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Pilar</label>
                                                  </div>
                                                  <div class="form-group col-md-1 p-l-0">
                                                      <input id="cod_pilar" name="cod_pilar" type="text" class="form-control input" placeholder="Pilar" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                      <div class="help-block with-errors"></div>
                                                  </div>

                                                  <div class="form-group col-md-2 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta</label>
                                                  </div>
                                                  <div class="form-group col-md-1 p-l-0">
                                                      <input id="cod_meta" name="cod_meta" type="text" class="form-control input" placeholder="Meta" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                      <div class="help-block with-errors"></div>
                                                  </div>

                                                  <div class="form-group col-md-2 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Resultado</label>
                                                  </div>
                                                  <div class="form-group col-md-2 p-l-0">
                                                      <input id="cod_resultado" name="cod_resultado" type="text" class="form-control input" placeholder="Resultado" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                      <div class="help-block with-errors"></div>
                                                  </div>

                                                  <div class="col-md-2 p-l-0 text-center">
                                                      <button type="button" class="btn btn-info btn-circle agregarART"><i class="fa fa-plus-square"></i></button>
                                                  </div>
                                              </div>
                                              <h5>Detalle de articulación</h5>
                                              <hr/>
                                              <div id="datosART">
                                                  <div></div>
                                              </div>

                                          </div>
                                       </div>
                                       <div id="info4" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Metas </h4>
                                           </div>
                                           <div class="col-md-12">
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2020</label>
                                                 </div>
                                                 <div class="col-md-3 p-l-0">
                                                     <input id="id_meta_2020" name="id_meta_2020" type="hidden" class="form-control oculto" required>
                                                     <input id="meta_2020" name="meta_2020" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2025</label>
                                                 </div>
                                                 <div class="col-md-3 p-l-0">
                                                     <input id="id_meta_2025" name="id_meta_2025" type="hidden" class="form-control oculto" required>
                                                     <input id="meta_2025" name="meta_2025" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2030</label>
                                                 </div>
                                                 <div class="col-md-3 p-l-0">
                                                     <input id="id_meta_2030" name="id_meta_2030" type="hidden" class="form-control oculto" required>
                                                     <input id="meta_2030" name="meta_2030" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>

                                           </div>
                                       </div>

                                  </div>
                              </div>

                      </div>
                    </div>

                    <div class="col-sm-12">
                            <div class="form-group text-center">
                              <button type="submit" class="btn btn-info">Aceptar</button>
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











@endsection

@push('script-head')
  <!-- ... -->

    <script type="text/javascript" src="{{ asset('plugins/bower_components/moment/min/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bower_components/moment/min/locales.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxbuttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxscrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdata.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdatatable.js') }}"></script>
    <script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script type="text/javascript" src="{{ asset('js/jqwidgets-localization.js') }}"></script>

  <!-- Date Picker Plugin JavaScript -->

  <script type="text/javascript">
    $(document).ready(function(){
      //$(".select2").select2();
      $("#formAdd .select2").select2().attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);');
      $(".input").inputmask();
      $(function () {
                  $('#dateLB').datetimepicker({
                      viewMode: 'years',
                      format: 'MM/YYYY',
                      locale: 'es'
                  });
      });

      var ip_id = -100;
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


    var url = '{{ url('api/sistemaremi/apiSetIndicadores') }}';
    // prepare the data
    var source =
    {
        dataType: "json",
        dataFields: [
            { name: 'id', type: 'int' },
            { name: 'codigo', type: 'int' },
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




    });
    function quitarART(ele,tipo){
        if(tipo == 1){
          $('#ART'+ele).remove();
        }else{
          $('#ART'+ele).addClass('hidden');
          $('#EST'+ele).val(0);
          $('#ART'+ele).attr("id",'0ART'+ele);
        }

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
       $('.with-errors').html('');
       $('.form-group').removeClass('has-error');
       $("#variables_desagregacion").val('').trigger('change');
       $("#datosART").html("");
       $('input[name="id_indicador"]').val(null);
       $("#tab-ini" ).trigger( "click" );
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
                   $('select[name=tipo]').val(data.indicador[0].tipo);
                   $('select[name=unidad_medida]').val(data.indicador[0].unidad_medida);
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
  </script>
@endpush
