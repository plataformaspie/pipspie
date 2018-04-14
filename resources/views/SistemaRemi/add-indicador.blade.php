@extends('layouts.sistemaremi')

@section('header')

  <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}"  type="text/css" />
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
          <h4 class="page-title">Registrar nuevo indicador</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/index') }}">Indicadores</a></li>
              <li class="active">Registrar nuevo</li>
          </ol>
      </div>
      <!-- /.breadcrumb -->
  </div>
  <form id="formAdd" name="formAdd" data-toggle="validator">
  <!-- .row -->
  <div class="row">
      <div class="col-sm-12">
          <div class="white-box">
              <h3 class="box-title m-b-0">Información del Indicador</h3>
              <p class="text-muted m-b-30">Completar todos los datos solicitados</p>

              <div class="form-group row m-b-10">
                <div class="col-md-1 p-l-0 p-r-0">
                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 7px 95px 7px 3px;">Nombre</label>
                </div>
                <div class="col-md-11 p-l-0">
                    <input type="text" class="form-control" id="inputName1" placeholder="Nombre del indicador" required>
                    <div class="help-block with-errors"></div>
                </div>
              </div>

              <div class="form-group row m-b-10">
                <div class="col-md-1 p-l-0 p-r-0">
                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 7px 95px 7px 3px;">Definición</label>
                </div>
                <div class="col-md-11 p-l-0">
                    <textarea id="textarea" class="form-control" placeholder="Definición del indicador" required></textarea>
                    <div class="help-block with-errors"></div>
                </div>
              </div>

            <hr>
            <div class="row">
              <div class="col-lg-12 col-sm-12 col-xs-12 p-l-0">
                      <div class="vtabs">
                          <ul class="nav tabs-vertical media p-t-0 p-l-0 p-r-0" style="width:300px;">
                              <li class="tab nav-item">
                                  <a data-toggle="tab" class="nav-link active" href="#info1" aria-expanded="true">
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
                                  <a data-toggle="tab" class="nav-link" href="#info2" aria-expanded="false">
                                    <span class="visible-xs"><i class="fa fa-info-circle" style="font-size: 25px"></i></span>
                                    <span class="hidden-xs"><i class="fa fa-info-circle" style="font-size: 25px"></i> Información adicional</span>
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
                                                    <option value="{{ $item->id }}">{{$item->nombre}}</option>
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
                                                    <option value="{{ $item->id }}">{{$item->nombre}}</option>
                                              @endforeach
                                          </select>
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
                                            <select name="variables_desagregacion" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2">
                                                @foreach ($variables as  $item)
                                                      <option value="{{ $item->id }}">{{$item->nombre}}</option>
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
                                          <input name="fecha_lb"type='text' class="form-control" placeholder="mm/yyyy"/>
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
                                          <input type="text" class="form-control input" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;" >
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

                                  </div>
                              </div>
                              <div id="info2" class="tab-pane">
                                  <div class="col-md-12 list-group-item-success">
                                      <h4 style="width:100%;">Información adicional </h4>
                                  </div>
                                  <div class="col-md-12">
                                      <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                        <div class="col-md-2 p-l-0 p-r-0">
                                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Serie disponible</label>
                                        </div>
                                        <div class="col-md-9 p-l-0">
                                            <input id="serie_disponible" name="serie_disponible" type="text" class="form-control" placeholder="Tipo de indicador" >
                                            <div class="help-block with-errors"></div>
                                        </div>
                                      </div>
                                      <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                        <div class="col-md-2 p-l-0 p-r-0">
                                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Observaciones</label>
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

                                          <div class="col-md-2 p-l-0">
                                              <button type="button" class="btn btn-info">Agregar</button>
                                          </div>
                                      </div>
                                      <hr/>
                                      <div class="form-group row m-b-5 m-l-5 m-t-5" >

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
                                             <input id="meta_2020" name="meta_2020" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                             <div class="help-block with-errors"></div>
                                         </div>
                                       </div>
                                       <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                         <div class="col-md-3 p-l-0 p-r-0">
                                           <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2025</label>
                                         </div>
                                         <div class="col-md-3 p-l-0">
                                             <input id="meta_2025" name="meta_2025" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                             <div class="help-block with-errors"></div>
                                         </div>
                                       </div>
                                       <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                         <div class="col-md-3 p-l-0 p-r-0">
                                           <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2030</label>
                                         </div>
                                         <div class="col-md-3 p-l-0">
                                             <input id="meta_2030" name="meta_2030" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
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
                      <button type="submit" class="btn btn-default">Cancelar</button>
                    </div>
            </div>

          </div>
      </div>


  </div>
  <!-- /.row -->
  </form>





@endsection

@push('script-head')
  <!-- ... -->

    <script type="text/javascript" src="{{ asset('plugins/bower_components/moment/min/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bower_components/moment/min/locales.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>



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
    });
  </script>
@endpush
