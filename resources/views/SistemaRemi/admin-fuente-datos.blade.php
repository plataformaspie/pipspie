@extends('layouts.sistemaremi')

@section('header')

  <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}"  type="text/css" />
  <link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">


  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />
  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.darkblue.css') }} " type="text/css" />

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
          <h4 class="page-title">Administrador Fuente de Datos</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/index') }}">Fuente Datos</a></li>
              <li class="active">Administrar fuente de datos</li>
          </ol>
      </div>
      <!-- /.breadcrumb -->
  </div>

  <div id="option1" class="row">
      <div class="col-lg-12 ">
          <div class="white-box">
            <h3 class="box-title m-b-0">Lista de Fuente de datos</h3>
            <p class="text-muted m-b-30">Fuente de Datos registrados <button id ="btn-new" type="button" class="btn btn-info btn-circle btn-lg" style="float: right;margin-top: -26px;"><i class="fa fa-plus"></i></button></p>
            <div id="dataTable"></div>
          </div>
      </div>
  </div>
  <div id="option2" class="row hidden">
      <div class="col-lg-12 ">
          <form id="formAdd" name="formAdd" action="javascript:save();" data-toggle="validator" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id_fuente" value="">
            <!-- .row -->
            <div class="row">
              <div class="col-sm-12">
                  <div class="white-box">
                      <h3 class="box-title m-b-0">Información de Fuente de Datos</h3>
                      <p class="text-muted m-b-30">Completar todos los datos solicitados<button id ="btn-back" type="button" class="btn btn-info btn-circle btn-lg" style="float: right;margin-top: -26px;"><i class="fa fa-arrow-left"></i></button></p>

                      <div class="form-group row m-b-10">
                        <div class="col-md-2 p-l-0 p-r-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 7px 95px 7px 3px;">Nombre</label>
                        </div>
                        <div class="col-md-10 p-l-0">
                            <textarea class="form-control" placeholder="Ingrese nombre fuente de datos" rows="2" id="nombre" name="nombre" required></textarea>
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
                                            <span class="hidden-xs"><i class="fa fa-sitemap" style="font-size: 25px"></i> Identificación</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini2" data-toggle="tab" class="nav-link ctrl-btn" href="#info2" aria-expanded="true">
                                            <span class="visible-xs"><i class="fa fa-book" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-book" style="font-size: 25px"></i> Categoria Temática  </span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini3" aria-expanded="false" class="nav-link ctrl-btn" data-toggle="tab" href="#info3">
                                            <span class="visible-xs"><i class="fa fa-building-o" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-building-o" style="font-size: 25px"></i> Captura de información</span>
                                          </a>
                                      </li>

                                      <li class="tab nav-item">
                                          <a id="tab-ini4" data-toggle="tab" class="nav-link ctrl-btn" href="#info4" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-eye" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-eye" style="font-size: 25px"></i> Cobertura</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini5" data-toggle="tab" class="nav-link ctrl-btn" href="#info5" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-briefcase" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-briefcase" style="font-size: 25px"></i> Responsables</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini6" data-toggle="tab" class="nav-link ctrl-btn" href="#info6" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-cloud-upload" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-cloud-upload" style="font-size: 25px"></i> Documentos respaldo</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini7" data-toggle="tab" class="nav-link ctrl-btn" href="#info7" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-cloud-upload" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-cloud-upload" style="font-size: 25px"></i> Acceso a la información</span>
                                          </a>
                                      </li>

                                  </ul>
                                  <div class="tab-content media p-t-0 p-l-0 p-r-0" style="width: 80%;">
                                      <div id="info1" class="tab-pane active">
                                          <div class="col-md-12 list-group-item-success" style="margin-top: -9px;">
                                              <h4 style="width:100%;">Identificación  </h4>
                                          </div>

                                          <div class="col-md-12">
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Abreviación</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <input id="acronimo" name="acronimo" type="text" class="form-control" placeholder="Abreviación de la Fuente de Datos " >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Tipo</label>
                                              </div>
                                              <div class="form-group col-md-4 p-l-0">
                                                  <select id="tipo" name="tipo" class="custom-select col-12 form-control" required>
                                                      <option value="">Seleccionar...</option>
                                                      @foreach ($fuente_tipos as  $item)
                                                            <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                      @endforeach
                                                  </select>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Objetivo</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <div class="select2-wrapper">
                                                    <textarea id="objetivo" name="objetivo" class="form-control" placeholder="Objetivo"></textarea>
                                                  </div>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                  <div class="col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Serie disponible</label>
                                                  </div>
                                                  <div class="col-md-9 p-l-0">
                                                      <input id="serie_datos" name="serie_datos" type="text" class="form-control" placeholder="Serie disponible" >
                                                      <div class="help-block with-errors"></div>
                                                  </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Periodicidad</label>
                                              </div>
                                              <div class="form-group col-md-4 p-l-0">
                                                  <select id="periodicidad" name="periodicidad" class="custom-select col-12 form-control">
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
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Variables/Campos clave</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <div class="select2-wrapper">
                                                    <textarea id="variable" name="variable" class="form-control" placeholder="Variables"></textarea>
                                                  </div>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Modo de recolección de Datos</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <select id="modo_recoleccion_datos" name="modo_recoleccion_datos" class="custom-select col-12 form-control controlOtro" >
                                                      <option value="">Seleccionar...</option>
                                                      @foreach ($recoleccion as  $item)
                                                            <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                      @endforeach
                                                  </select>
                                                  <input id="modo_recoleccion_datos_otro" name="modo_recoleccion_datos_otro" type="text" class="form-control hidden m-t-10 otros" placeholder="Detallar otro" >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de análisis</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <div class="select2-wrapper">
                                                    <textarea id="unidad_analisis" name="unidad_analisis" class="form-control" placeholder="Unidad de análisis"></textarea>
                                                  </div>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Universo de estudio</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <div class="select2-wrapper">
                                                    <textarea id="universo_estudio" name="universo_estudio" class="form-control" placeholder="Universo estudio"></textarea>
                                                  </div>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Diseño y tamaño de muestra</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <div class="select2-wrapper">
                                                    <textarea id="disenio_tamanio_muestra" name="disenio_tamanio_muestra" class="form-control" placeholder="Diseño y tamaño de muestra"></textarea>
                                                  </div>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Tasa de respuesta</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <div class="select2-wrapper">
                                                    <textarea id="tasa_respuesta" name="tasa_respuesta" class="form-control" placeholder="Tasa de respuesta"></textarea>
                                                  </div>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>


                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Observaciones</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <div class="select2-wrapper">
                                                    <textarea id="observacion" name="observacion" class="form-control" placeholder="Observaciones"></textarea>
                                                  </div>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>
                                          </div>
                                      </div>

                                      <div id="info2" class="tab-pane ">
                                          <div class="col-md-12 list-group-item-success">
                                              <h4 style="width:100%;"> Categoria Temática </h4>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Demografia y estadisticas sociales</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <select id="demografia_estadistica_social" name="demografia_estadistica_social[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple controlOtroMulti">
                                                      @foreach ($demografia as  $item)
                                                            <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                      @endforeach
                                                  </select>
                                                  <input id="demografia_estadistica_social_otro" name="demografia_estadistica_social_otro" type="text" class="form-control hidden m-t-10 otros" placeholder="Detallar otro" >
                                                  <div class="help-block with-errors"></div>
                                              </div>

                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Estadisticas Económicas</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <select id="estadistica_economica" name="estadistica_economica[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple controlOtroMulti">
                                                      @foreach ($economicas as  $item)
                                                            <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                      @endforeach
                                                  </select>
                                                  <input id="estadistica_economica_otro" name="estadistica_economica_otro" type="text" class="form-control hidden m-t-10 otros" placeholder="Detallar otro" >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Estadisticas Medioambientales</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <select id="estadistica_medioambiental" name="estadistica_medioambiental[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple controlOtroMulti">
                                                      @foreach ($medioambientales as  $item)
                                                            <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                      @endforeach
                                                  </select>
                                                  <input id="estadistica_medioambiental_otro" name="estadistica_medioambiental_otro" type="text" class="form-control hidden m-t-10 otros" placeholder="Detallar otro" >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                  <div class="col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Informacion Geoespacial</label>
                                                  </div>
                                                  <div class="col-md-9 p-l-0">
                                                      <select id="informacion_geoespacial" name="informacion_geoespacial[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple controlOtroMulti">
                                                          @foreach ($geoespacial as  $item)
                                                                <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                          @endforeach
                                                      </select>
                                                      <input id="informacion_geoespacial_otro" name="informacion_geoespacial_otro" type="text" class="form-control hidden m-t-10 otros" placeholder="Detallar otro" >
                                                      <div class="help-block with-errors"></div>
                                                  </div>
                                            </div>


                                          </div>

                                      </div>

                                      <div id="info3" class="tab-pane">
                                          <div class="col-md-12 list-group-item-success">
                                              <h4 style="width:100%;">Captura de información (Formularios/Cuestionarios)</h4>
                                          </div>
                                          <div class="col-md-12">
                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-5 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Cantidad de Cuestionarios/Formularios</label>
                                                </div>
                                                <div class="col-md-7 p-l-0">
                                                    <div class="select2-wrapper">
                                                      <input id="numero_total_formulario" name="numero_total_formulario" type="text" class="form-control" placeholder="Numero" >
                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>



                                            <h5>Lista de formularios/cuestionarios agregados</h5>
                                            <table id="datosForm" class="table table-hover">
                                               <thead>
                                                   <tr>
                                                    <th>-</th>
                                                    <th>Nombre</th>
                                                    <th>-</th>
                                                  </tr>
                                              </thead>
                                              <tbody>

                                              </tbody>
                                            </table>
                                          </div>

                                      </div>

                                      <div id="info4" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Cobertura</h4>
                                           </div>



                                       </div>


                                       <div id="info5" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;"> Responsables</h4>
                                           </div>

                                           <div class="col-md-12">
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
                                                                       <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;" >Institución Propietaria/Custodia</label>
                                                                     </div>
                                                                     <div class="col-md-8 p-l-0">
                                                                       <input id="responsable_1" name="responsable_1" type="text" class="form-control"  placeholder="Institución Propietaria/Custodia" required>
                                                                       <div class="help-block with-errors"></div>
                                                                     </div>

                                                                     <div class="col-md-4 p-l-0 p-r-0 text-right">
                                                                       <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Dependencia Ejecutiva</label>
                                                                     </div>
                                                                     <div class="col-md-8 p-l-0">
                                                                       <input id="responsable_2" name="responsable_2" type="text" class="form-control"  placeholder="Dependencia Ejecutiva" required>
                                                                       <div class="help-block with-errors"></div>
                                                                     </div>

                                                                     <div class="col-md-4 p-l-0 p-r-0 text-right">
                                                                       <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Dependencia Técnica</label>
                                                                     </div>
                                                                     <div class="col-md-8 p-l-0">
                                                                       <input id="responsable_3" name="responsable_3" type="text" class="form-control"  placeholder="Dependencia Técnica" required>
                                                                       <div class="help-block with-errors"></div>
                                                                     </div>
                                                                     <div class="col-md-4 p-l-0 p-r-0 text-right">
                                                                       <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Dependencia Informática</label>
                                                                     </div>
                                                                     <div class="col-md-8 p-l-0">
                                                                       <input id="responsable_4" name="responsable_4" type="text" class="form-control"  placeholder="Dependencia Informática" required>
                                                                       <div class="help-block with-errors"></div>
                                                                     </div>

                                                                     <div class="col-md-4 p-l-0 p-r-0">
                                                                       <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Teléfono de referencia</label>
                                                                     </div>
                                                                     <div class="col-md-8 p-l-0">
                                                                       <input id="referencia" name="referencia" type="text" class="form-control"  placeholder="Teléfono de referencia" required>
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

                                       <div id="info6" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Documentos respaldo</h4>
                                           </div>
                                           <div class="col-md-12">

                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Nombre de Archivo</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input id="arc_nombre_input" name="arc_nombre_input" type="text" class="form-control" placeholder="Nombre de respaldo" >
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Adjuntar</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input type="file" id ="arc_archivo_input" name="arc_archivo_input" class="form-control p-t-0" accept=".xls,.xlsx,.cvs">
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                                 <div class="col-md-12 p-l-0 text-center">
                                                     <button type="button" class="btn btn-info btn-sm agregarARC m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                 </div>
                                               </div>


                                             <h5>Archivos subidos</h5>
                                             <table id="datosARC" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                     <th>Descripcion de archivos</th>
                                                     <th>-</th>
                                                   </tr>
                                               </thead>
                                               <tbody >

                                               </tbody>
                                             </table>
                                           </div>
                                       </div>


                                       <div id="info7" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Acceso a la información</h4>
                                           </div>
                                           <div class="col-md-12">
                                               <div class="form-group row m-b-5 m-l-5 m-t-5">
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Confidencialidad</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <select id="confidencialidad" name="confidencialidad" class="custom-select col-12 form-control" >
                                                         <option value="">Seleccionar...</option>
                                                         <option value="Uso Público">Uso Público</option>
                                                         <option value="Bajo licencia o convenio">Bajo licencia o convenio</option>
                                                         <option value="Confidencial">Confidencial</option>
                                                     </select>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Notas legales</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <textarea id="notas_legales" name="notas_legales" class="form-control" rows="8" placeholder="Notas legales"></textarea>
                                                     </div>
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
  var responsable4A = [];
  var referenciaA = [];
  var idAV = [];
  var total_form = 0;
    $(document).ready(function(){
      //$(".select2").select2();
      var theme = 'darkblue';

      $("#formAdd .select2").select2().attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);');
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


      var url = '{{ url('api/sistemarime/apiSetListFuenteDatos') }}';
      // prepare the data
      var source =
      {
          dataType: "json",
          dataFields: [
              { name: 'id', type: 'int' },
              { name: 'codigo', type: 'string' },
              { name: 'nombre', type: 'string' },
              { name: 'acronimo', type: 'string' },
              { name: 'tipo', type: 'string' },
              { name: 'responsable_nivel_1', type: 'string' }
          ],
          id: 'id',
          url: url
      };
      var dataAdapter = new $.jqx.dataAdapter(source);
      $("#dataTable").jqxDataTable(
      {
          source: dataAdapter,
          width:"100%",
          theme:theme,
          columnsResize: true,
          filterable: true,
          filterMode: 'simple',
          pageable: true,
          pagerButtonsCount: 10,
          localization: getLocalization('es'),
          pageSize: 5,
          columns: [
            { text: 'Codigo', dataField: 'codigo', width: 120, cellsAlign: 'center' },
            { text: 'Nombre fuente', minWidth: 200,dataField: 'nombre' },
            { text: 'Tipo', width: 150,dataField: 'tipo' },
            { text: 'Responsable', width: 200, dataField: 'responsable_nivel_1' },
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
      if(next == 7){
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
      if(next == 7){
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
     //createElements();

     $( "#numero_total_formulario" ).keyup(function( event ) {
      //alert($(this).val());


        var arrayForm = [];
        for(i=1;i<=total_form;i++){
          arrayForm[i] = $('#frm-nom-'+i).val();
        }
        $("#datosForm > tbody").html('');
        total_form = $(this).val();
        $("#datosForm > tbody").html("");
         for(i=1; i<= $(this).val();i++){
           if(arrayForm[i]){
             var valorNombre = arrayForm[i];
           }else{
             var valorNombre = "";
           }
           var html = '<tr id="FRM'+ i +'" class="">'+
                           '<td>'+
                             'Nombre formulario <input type="text" name="formulario_correlativo[]" class="text-center" value="'+i+'" style="width:30px;" /> :'+
                           '</td>'+
                           '<td>'+
                             '<input type="text" id="frm-nom-'+i+'" name="nombre_formulario[]" value="'+valorNombre+'" class="form-control"/>'+
                           '</td>'+
                           '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarFRM('+i+');"> <i class="fa fa-close text-danger"></i> </a></td>'+
                      '</tr>';
           $("#datosForm > tbody").append(html);
         }


     });

     $(".agregarRS").click(function () {

       if( $("input[name=responsable_1]").val() != ""){

             responsable1A.push($('input[name=responsable_1]').val());
             responsable2A.push($('input[name=responsable_2]').val());
             responsable3A.push($('input[name=responsable_3]').val());
             responsable4A.push($('input[name=responsable_4]').val());
             referenciaA.push($('input[name=referencia]').val());

             actualizarListaResponsable();

             $('input[name=responsable_1]').val('');
             $('input[name=responsable_2]').val('');
             $('input[name=responsable_3]').val('');
             $('input[name=responsable_4]').val('');
             $('input[name=referencia]').val('');


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



     $(".controlOtro").change(function () {
       var ele = $(this).attr('name');
       if($(this).val()=='Otro'){
         $('#'+ele+'_otro').val("");
         $('#'+ele+'_otro').removeClass('hidden');
         $('#'+ele+'_otro').addClass('show');
       }else{
         $('#'+ele+'_otro').removeClass('show');
         $('#'+ele+'_otro').addClass('hidden');
       }
     });

     $(".controlOtroMulti").change(function () {
         var ele = $(this).attr('id');
         var str = $(this).val();
         //alert(str.indexOf("Otro"));
         if(str){
           if(str.indexOf("Otro") >= 0){
             $('#'+ele+'_otro').val("");
             $('#'+ele+'_otro').removeClass('hidden');
             $('#'+ele+'_otro').addClass('show');
           }else{
             $('#'+ele+'_otro').removeClass('show');
             $('#'+ele+'_otro').addClass('hidden');
           }
         }
      });


    });
    //fin document






    $('#btn-back, .btn-back').click(function() {
       $('#option1').removeClass('hidden');
       //$('#nivel_1').addClass('show');
       $('#option2').removeClass('show');
       $('#option2').addClass('hidden');

       $("#formAdd")[0].reset();
       $('.with-errors').html('');
       $('.form-group').removeClass('has-error');

      $('.otros').removeClass('show');
      $('.otros').removeClass('hidden');
      $('.otros').addClass('hidden');

      $("#demografia_estadistica_social").val(null).trigger('change');
      $("#estadistica_economica").val(-1).trigger('change');
      $("#estadistica_medioambiental").val(null).trigger('change');
      $("#informacion_geoespacial").val(null).trigger('change');

       $("#cont_resp").html(0);

       fechaAV = [];
       valorAV = [];
       estadoAV = [];
       origenAV = [];
       responsable1A = [];
       responsable2A = [];
       responsable3A = [];
       responsable4A = [];
       referenciaA = [];
       idAV = [];
       total_form = 0;
       $("#datosARC > tbody").html("");
       $("#datosForm > tbody").html("");

       $("#set_responsables > tbody").html("");
       $('input[name="id_fuente"]').val(null);
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
                   /*if(data.indicador[0].variables_desagregacion){
                     $("#variables_desagregacion").val(data.indicador[0].variables_desagregacion.split(",")).trigger('change');
                   }*/
                   $('textarea[name="variables_desagregacion"]').val(data.indicador[0].variables_desagregacion);

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


                  $.each(data.archivos, function(i, data) {
                      var nombre = data.nombre.replace(/\s/g,"_");
                      var html = '<tr id="ARC'+ nombre +'" class="">'+
                                      '<td>'+
                                          '<input type="hidden" name="arc_id[]" value="'+data.id+'" />'+
                                          '<input type="hidden" name="arc_nombre[]" value="'+ data.nombre +'" />'+
                                          '<input type="hidden" name="arc_archivo[]" value="'+ data.archivo +'" />'+
                                          '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                          '<a href="/respaldos/'+data.archivo+'" style="cursor: pointer;">'+
                                          '<p>'+
                                            '<img src="/img/icono_indicadores/xls.png" title="Descargar Archivos respaldo "> '+
                                             data.nombre +
                                          '</p>'+
                                          '</a>'+
                                      '</td>'+
                                      '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.archivo+'\',2);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                  '</tr>';
                       $("#datosARC > tbody").append(html);
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
               if(data.status != 401){
                 $.toast({
                   heading: 'Error:',
                   text: 'Error al recuperar los datos.',
                   position: 'top-right',
                   loaderBg:'#ff6849',
                   icon: 'error',
                   hideAfter: 3500
                 });
               }else{
                 window.location = '/login';
               }
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
                     if(data.status != 401){
                       alert("Error recuperar los datos.");
                     }else{
                       window.location = '/login';
                     }

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
                  url: "{{ url('/api/sistemarime/apiSaveFuenteDatos') }}",
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
                    if(data.status != 401){
                      $.toast({
                        heading: 'Error:',
                        text: 'Error al recuperar los datos.',
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'error',
                        hideAfter: 3500

                      });
                    }else{
                      window.location = '/login';
                    }

                  }
            });
      });
    }


    function quitarFRM(ele){
      var res = confirm("Esta seguro de quitar el formulario?");
          if (res == true) {
                 $('#FRM'+ele).remove();
          }
          var value = $('#numero_total_formulario').val();
          value = value - 1;
          total_form = value;
          $('#numero_total_formulario').val(value);

    }



    function actualizarListaResponsable(){
      var cav= 1;
      $("#set_responsables > tbody").html("");

      $.ajax({
            url: "{{ url('/api/sistemarime/apiSourceOrderbyArray2') }}",
            type: "GET",
            dataType: 'json',
            data:{'responsable1':responsable1A,'responsable2':responsable2A,'responsable3':responsable3A,'responsable4':responsable4A,'referencia':referenciaA},
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
                                                 '<input type="hidden" name="responsable_nivel_4[]" value="'+ responsable4A[data.index] +'" />'+
                                                 '<input type="hidden" name="numero_referencia[]" value="'+ referenciaA[data.index] +'" />'+
                                                 '<b>Institución Propietaria/Custodia:</b> '+responsable1A[data.index]+'<br/>'+
                                                 '<b>Dependencia Ejecutiva:</b> '+ responsable2A[data.index]+'<br/>'+
                                                 '<b>Dependencia Técnica:</b> '+ responsable3A[data.index] +'<br/>'+
                                                 '<b>Dependencia Informática:</b> '+ responsable4A[data.index] +'<br/>'+
                                                 '<b>Teléfono de referencia:</b> '+ referenciaA[data.index]+
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
    function quitarRS(ele,index){

          $('#RS'+ele).remove();
          responsable1A.splice(index, 1);
          responsable2A.splice(index, 1);
          responsable3A.splice(index, 1);
          responsable4A.splice(index, 1);
          referenciaA.splice(index, 1);

        actualizarListaResponsable();
    }






  </script>
@endpush
