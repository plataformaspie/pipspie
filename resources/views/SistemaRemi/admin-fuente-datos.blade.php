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
                      <p class="text-muted m-b-30">
                        La documentación de todos los elementos marcados con “<label class="text-danger">(o)</label>” es de carácter obligatorio.<br/>
                        La documentación de todos los elementos marcados con “<label class="text-success">(r)</label>” es de carácter recomendado
                        <button id ="btn-back" type="button" class="btn btn-info btn-circle btn-lg" style="float: right;margin-top: -26px;">
                          <i class="fa fa-arrow-left"></i>
                        </button>
                      </p>
                      <div class="form-group row m-b-10">
                        <div class="col-md-2 p-l-0 p-r-0">
                          <label for="label" class="col-form-label control-label list-group-item-info" style="width: 200px;padding: 7px 20px 7px 3px;">Estado </label>

                        </div>
                        <div class="col-md-10 p-l-0">
                            <label id="estado_view" for="label" class="">Preliminar </label>
                            <input id="estado" type="hidden" name="estado" value="1">
                        </div>

                      </div>
                      <div class="form-group row m-b-10">
                        <div class="col-md-2 p-l-0 p-r-0">
                            <a class="mytooltip" href="javascript:void(0)">
                              <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 200px;padding: 7px 20px 7px 3px;">Nombre de Fuente <label class="text-danger">(o)</label></label>
                              <span class="tooltip-content5">
                                <span class="tooltip-text3">
                                  <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                    Nombre oficial completo de la encuesta, censo o registro administrativo,
                                    incluyendo el año de referencia. No deben usarse abreviaciones en esta casilla.
                                    Utilizar solo mayúsculas. Formato adecuado del nombre, años (si más de uno en el caso de series)
                                    separados por guión.<br/>
                                    <b class="text-info">Ejemplo:</b> ENCUESTA DE HOGARES 2017.
                                    REGISTROS ADMINISTRATIVOS DEL PARQUE AUTOMOTOR 2006-2007
                                    CENSO  AGROPECUARIO 2013
                                    SISTEMA DE INFORMACIÓN EDUCATIVA 2006 - 2018
                                  </span>
                                </span>
                              </span>
                            </a>
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
                                            <span class="visible-xs"><i class="fa fa-book" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-book" style="font-size: 25px"></i> Identificación</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini2" data-toggle="tab" class="nav-link ctrl-btn" href="#info2" aria-expanded="true">
                                            <span class="visible-xs"><i class="icon-layers" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="icon-layers" style="font-size: 25px"></i> Categoria Temática  </span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini3" aria-expanded="false" class="nav-link ctrl-btn" data-toggle="tab" href="#info3">
                                            <span class="visible-xs"><i class="fa fa-building-o" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-building-o" style="font-size: 25px"></i> Cuestionarios y formularios</span>
                                          </a>
                                      </li>

                                      <li class="tab nav-item">
                                          <a id="tab-ini4" data-toggle="tab" class="nav-link ctrl-btn" href="#info4" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-globe " style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-globe " style="font-size: 25px"></i> Cobertura</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini5" data-toggle="tab" class="nav-link ctrl-btn" href="#info5" aria-expanded="false">
                                            <span class="visible-xs"><i class="icon-home " style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="icon-home " style="font-size: 25px"></i> Responsables</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini6" data-toggle="tab" class="nav-link ctrl-btn" href="#info6" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-briefcase" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-briefcase" style="font-size: 25px"></i> Documentos respaldo</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini7" data-toggle="tab" class="nav-link ctrl-btn" href="#info7" aria-expanded="false">
                                            <span class="visible-xs"><i class="icon-lock" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="icon-lock" style="font-size: 25px"></i> Acceso a la información</span>
                                          </a>
                                      </li>

                                  </ul>
                                  <div class="tab-content p-t-0 p-l-0 p-r-0" style="width: 80%;">
                                      <div id="info1" class="tab-pane active m-t-10">
                                          <div class="col-md-12 list-group-item-success" style="margin-top: -9px;">
                                              <h4 style="width:100%;">Identificación  </h4>
                                          </div>

                                          <div class="col-md-12">
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Abreviación <label class="text-success">(r)</label></label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        Abreviación o siglas de la Operación Estadística. Todas en mayúsculas; incluye el año de referencia. Si no existe, crear una abreviación oficialmente para identificar de forma única la Operación estadística.
                                                        <br/><b class="text-info">Ejemplo</b>: RPA-RUAT-2006-2007, EH-2017, CA-2013, SIE-2006-2018

                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <input id="acronimo" name="acronimo" type="text" class="form-control" placeholder="Abreviación de la Fuente de Datos " >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Tipo <label class="text-danger">(o)</label></label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        Tipo de fuente de datos: distingue las siguientes categorías
                                                        <br/><b class="text-info">Captura directa de datos estadísticos:</b> Censos, Encuestas, Conteos.
                                                        <br/><b class="text-info">Captura de fuentes administrativas:</b> Registros administrativos, Directorios, Inventarios, Padrones (Electoral/Biométrico/Contribuyentes, etc.)
                                                        <br/><b class="text-info">Estadísticas derivadas y recopilaciones:</b>
                                                        Agregados Nacionales (Cuentas Nacionales, Balanza de Pagos, Contabilidad Fiscal, Inversiones),
                                                        Indicadores,Bases integradas (por interoperabilidad)
                                                        <br/><b class="text-info">Infraestructura estadística:</b> Marcos Muestrales, Cartografía, Nomenclatura, Clasificadores/Nomenclaturas/Catálogos
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
                                              </div>
                                              <div class="form-group col-md-4 p-l-0">
                                                  <select id="tipo" name="tipo" class="custom-select col-12 form-control enabledCampos" required>
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
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Objetivo <label class="text-danger">(o)</label></label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        Síntesis del propósito, metodología y alcance de la fuente de datos. Destacar las características especiales de la operación estadística y las principales áreas de interés.
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
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
                                                    <a class="mytooltip" href="javascript:void(0)">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Serie disponible <label class="text-danger">(o)</label></label>
                                                        <span class="tooltip-content5" style="">
                                                        <span class="tooltip-text3">
                                                          <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                            Año de referencia de los datos es el periodo de tiempo al cual los datos se refieren, no las fechas de codificación o elaboración de documentos. Esta fecha puede coincidir con las fechas de recolección de los datos, pero no siempre.
                                                            Si existe la serie disponible, mencionar el año de inicio y fin de la serie.
                                                            <br/><b class="text-info">Ejemplo:</b> 2017, 2006 – 2007, 2013, 2006–2018
                                                          </span>
                                                        </span>
                                                      </span>
                                                    </a>
                                                  </div>
                                                  <div class="col-md-9 p-l-0">
                                                      <input id="serie_datos" name="serie_datos" type="text" class="form-control" placeholder="Serie disponible" >
                                                      <div class="help-block with-errors"></div>
                                                  </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Periodicidad <label class="text-danger">(o)</label></label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        Frecuencia con que se recopilan los datos.
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
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
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Variables/Campos clave<label class="text-success">(r)</label></label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        Lista de variables o campos clave que se recopilan en la fuente de datos. Mencionar secciones del registro o encuesta, variables o campos clave, indicadores derivados u otra información relevante, separados por comas.
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
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
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Modo de recolección de Datos <label class="text-success">(r)</label></label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        Información sobre la modalidad de recolección de datos. Elegir alternativa del listado proporcionado.
                                                        <br/>Para el campo (Otro): campo de captura abierta Formato Alfanumérico
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
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
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de análisis<label class="text-danger">(o)</label></label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        Descripción de la unidad de análisis bajo estudio de la fuente de datos (población, hogares, individuos, establecimientos, empresas, inmuebles, etc.).
                                                        <br/><b class="text-info">Ejemplo:</b> El registro administrativo de educación regular recopila información a nivel de Centros Educativos, por lo que su unidad de análisis son los centros educativos de educación regular
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
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
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Universo de estudio<label class="text-danger">(o)</label></label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        Descripción de la población bajo estudio de la fuente de datos (hogares, individuos, establecimientos, etc.). Este campo casi nunca deberá ser “Toda la población”. Por ejemplo, un censo no cubre a diplomáticos. Un registro administrativo no cubre a toda la población objetivo, sino a una porción de ella que,  normalmente,  acude para recibir un servicio.
                                                        <br/><b class="text-info">Ejemplo:</b> El universo de estudio del registro administrativo de educación regular son los estudiantes que asisten a centros educativos de educación regular, no siempre comprende a toda la población de niños y adolescentes.
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <div class="select2-wrapper">
                                                    <textarea id="universo_estudio" name="universo_estudio" class="form-control" placeholder="Universo estudio"></textarea>
                                                  </div>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5 encuestasShow hidden" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Diseño y tamaño de muestra<label class="text-success">(r)</label></label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        Información del marco muestral y los procedimientos utilizados para seleccionar a los encuestados. Indicar el tamaño de muestra seleccionado y su distribución.  No aplica a censos y RRAA.
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
                                              </div>
                                              <div class="col-md-9 p-l-0 ">
                                                  <div class="select2-wrapper">
                                                    <textarea id="disenio_tamanio_muestra" name="disenio_tamanio_muestra" class="form-control" placeholder="Diseño y tamaño de muestra"></textarea>
                                                  </div>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5 encuestasShow hidden" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Tasa de respuesta<label class="text-success">(r)</label></label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        El porcentaje de los miembros de la muestra que proveen información: rechazos, unidades no existentes, etc. No aplica a censos y RRAA.
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
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
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Observaciones<label class="text-success">(r)</label></label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <div class="select2-wrapper">
                                                    <textarea id="observacion" name="observacion" class="form-control" rows="7" placeholder="Observaciones"></textarea>
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
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Demografia y estadisticas sociales<label class="text-danger">(o)</label></label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        De preferencia, tomado de la lista provista. Seleccionar todas las temáticas que correspondan.
                                                        Se permite agregar una nueva temática si no estuviera reflejada en la lista sugerida tomando en cuenta temas a nivel agregado.
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
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
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Estadisticas Económicas<label class="text-danger">(o)</label></label>
                                                    <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        De preferencia, tomado de la lista provista. Seleccionar todas las temáticas que correspondan.
                                                        Se permite agregar una nueva temática si no estuviera reflejada en la lista sugerida tomando en cuenta temas a nivel agregado.
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
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
                                                <a class="mytooltip" href="javascript:void(0)">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Estadisticas Medioambientales<label class="text-danger">(o)</label></label>
                                                    <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        De preferencia, tomado de la lista provista. Seleccionar todas las temáticas que correspondan.
                                                        Se permite agregar una nueva temática si no estuviera reflejada en la lista sugerida tomando en cuenta temas a nivel agregado.
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
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
                                                    <a class="mytooltip" href="javascript:void(0)">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Informacion Geoespacial<label class="text-danger">(o)</label></label>
                                                        <span class="tooltip-content5" style="">
                                                        <span class="tooltip-text3">
                                                          <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                            De preferencia, tomado de la lista provista. Seleccionar todas las temáticas que correspondan.
                                                            Se permite agregar una nueva temática si no estuviera reflejada en la lista sugerida tomando en cuenta temas a nivel agregado.
                                                          </span>
                                                        </span>
                                                      </span>
                                                    </a>
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
                                              <h4 style="width:100%;">Cuestionarios y Formularios</h4>
                                          </div>
                                          <div class="col-md-12">
                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-5 p-l-0 p-r-0">
                                                  <a class="mytooltip" href="javascript:void(0)">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Cantidad de Cuestionarios/Formularios<label class="text-success">(r)</label></label>
                                                    <span class="tooltip-content5" style="">
                                                      <span class="tooltip-text3">
                                                        <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                          Mencionar la cantidad de cuestionarios/formularios/registros contemplados en la Fuente de Datos y completar y el nombre o la sección.
                                                          <br/><b class="text-info">Ejemplo:</b> El Sistema Nacional de Información Sobre Comercialización y Exportaciones Mineras (SINACOM) se alimenta  y/o integra de 3 registros básicos: FORM M-01 Formulario de Registro Único de Operadores Mineros, FORM M-02 Formulario de compra y venta  de Minerales y Metales y FORM M-03 Formulario Único de Exportación de Minerales y Metales.
                                                        </span>
                                                      </span>
                                                    </span>
                                                  </a>
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
                                           <div class="col-md-12">
                                               <div class="form-group row m-b-5 m-l-5 m-t-5 rraaShow hidden" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <a class="mytooltip" href="javascript:void(0)">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Cobertura del RRAA<label class="text-success">(r)</label></label>
                                                     <span class="tooltip-content5" style="">
                                                       <span class="tooltip-text3">
                                                         <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                           <br/><b class="text-info">Ejemplo Número:</b> 99
                                                           <br/><b class="text-info">Ejemplo Porcentaje:</b> 99%
                                                         </span>
                                                       </span>
                                                     </span>
                                                   </a>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input id="cobertura_rraa" name="cobertura_rraa" type="text" class="form-control " placeholder="Cobertura RRAA" >
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>

                                               <div class="form-group row m-b-5 m-l-5 m-t-5 rraaShow hidden" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                    <a class="mytooltip" href="javascript:void(0)">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Descripción del Supuesto</label>
                                                      <span class="tooltip-content5" style="">
                                                        <span class="tooltip-text3">
                                                          <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                            Relación porcentual del universo de estudio en relación a su universo objetivo (Solo para Registros Administrativos)
                                                            <br/><b class="text-info">Ejemplo: </b>El registro administrativo de conexiones de agua contempla una cobertura poblacional del <b class="text-info">91%</b>, tomando en cuenta que por cada conexión se considera un hogar promedio de 7 personas (Supuesto)

                                                          </span>
                                                        </span>
                                                      </span>
                                                    </a>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <textarea id="cobertura_rraa_descripcion" name="cobertura_rraa_descripcion" class="form-control" rows="4" placeholder="Descripción del Supuesto"></textarea>
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>

                                           </div>
                                      </div>

                                      <div id="info5" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success p-t-10">
                                               <h4 style="width:100%;"> Responsables</h4>
                                           </div>
                                           <!--div class="col-md-5 p-l-0 p-r-0 m-t-10 m-b-5 ">
                                               <a class="mytooltip" href="javascript:void(0)">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Relacionar Responsables</label>
                                                  <span class="tooltip-content5" style="">
                                                    <span class="tooltip-text3">
                                                      <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                        <b class="text-info">Institución Propietaria/Custodia:</b> Nombre de la Institución propietaria o custodia de la Fuente de Datos.
                                                        <br/><b class="text-info">Dependencia ejecutiva:</b> Nombre y Acrónimo de Viceministerio/Dirección a cargo de la fuente de datos.
                                                        <br/><b class="text-info">Dependencia técnica:</b> Nombre y Acrónimo de  Dirección/Unidad a cargo de la explotación/análisis de la fuente de datos (si corresponde)
                                                        <br/><b class="text-info">Dependencia informática:</b> Nombre y Acrónimo de  Dirección/Unidad a cargo de la gestión de la base de datos de la fuente de datos (si corresponde)
                                                        <br/><b class="text-info">Teléfono de referencia:</b> Teléfono de referencia de la Institución – interno de la Dependencia Ejecutiva.
                                                      </span>
                                                    </span>
                                                  </span>
                                                </a>
                                           </div-->
                                           <div class="col-md-12 m-t-5">
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
                                                                       <a class="mytooltip" href="javascript:void(0)">
                                                                         <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;" >Institución Propietaria/Custodia<label class="text-danger">(o)</label></label>
                                                                            <span class="tooltip-content5" style="">
                                                                            <span class="tooltip-text3">
                                                                              <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                                                <b class="text-info">Institución Propietaria/Custodia:</b> Nombre de la Institución propietaria o custodia de la Fuente de Datos.
                                                                              </span>
                                                                            </span>
                                                                          </span>
                                                                        </a>
                                                                     </div>
                                                                     <div class="col-md-8 p-l-0">
                                                                       <input id="responsable_1" name="responsable_1" type="text" class="form-control"  placeholder="Institución Propietaria/Custodia" required>
                                                                       <div class="help-block with-errors"></div>
                                                                     </div>

                                                                     <div class="col-md-4 p-l-0 p-r-0 text-right">
                                                                       <a class="mytooltip" href="javascript:void(0)">
                                                                         <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Dependencia Ejecutiva<label class="text-danger">(o)</label></label>
                                                                            <span class="tooltip-content5" style="">
                                                                            <span class="tooltip-text3">
                                                                              <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                                                  <b class="text-info">Dependencia ejecutiva:</b> Nombre y Acrónimo de Viceministerio/Dirección a cargo de la fuente de datos.
                                                                              </span>
                                                                            </span>
                                                                          </span>
                                                                        </a>
                                                                     </div>
                                                                     <div class="col-md-8 p-l-0">
                                                                       <input id="responsable_2" name="responsable_2" type="text" class="form-control"  placeholder="Dependencia Ejecutiva" required>
                                                                       <div class="help-block with-errors"></div>
                                                                     </div>

                                                                     <div class="col-md-4 p-l-0 p-r-0 text-right">
                                                                       <a class="mytooltip" href="javascript:void(0)">
                                                                         <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Dependencia Técnica<label class="text-danger">(o)</label></label>
                                                                            <span class="tooltip-content5" style="">
                                                                            <span class="tooltip-text3">
                                                                              <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                                                <b class="text-info">Dependencia técnica:</b> Nombre y Acrónimo de  Dirección/Unidad a cargo de la explotación/análisis de la fuente de datos (si corresponde)
                                                                              </span>
                                                                            </span>
                                                                          </span>
                                                                        </a>
                                                                     </div>
                                                                     <div class="col-md-8 p-l-0">
                                                                       <input id="responsable_3" name="responsable_3" type="text" class="form-control"  placeholder="Dependencia Técnica" required>
                                                                       <div class="help-block with-errors"></div>
                                                                     </div>
                                                                     <div class="col-md-4 p-l-0 p-r-0 text-right">
                                                                       <a class="mytooltip" href="javascript:void(0)">
                                                                         <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Dependencia Informática<label class="text-success">(r)</label></label>
                                                                            <span class="tooltip-content5" style="">
                                                                            <span class="tooltip-text3">
                                                                              <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                                                <b class="text-info">Dependencia informática:</b> Nombre y Acrónimo de  Dirección/Unidad a cargo de la gestión de la base de datos de la fuente de datos (si corresponde)
                                                                              </span>
                                                                            </span>
                                                                          </span>
                                                                        </a>
                                                                     </div>
                                                                     <div class="col-md-8 p-l-0">
                                                                       <input id="responsable_4" name="responsable_4" type="text" class="form-control"  placeholder="Dependencia Informática" required>
                                                                       <div class="help-block with-errors"></div>
                                                                     </div>

                                                                     <div class="col-md-4 p-l-0 p-r-0">
                                                                       <a class="mytooltip" href="javascript:void(0)">
                                                                         <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Teléfono de referencia<label class="text-danger">(o)</label></label>
                                                                            <span class="tooltip-content5" style="">
                                                                            <span class="tooltip-text3">
                                                                              <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                                                <b class="text-info">Teléfono de referencia:</b> Teléfono de referencia de la Institución – interno de la Dependencia Ejecutiva.
                                                                              </span>
                                                                            </span>
                                                                          </span>
                                                                        </a>
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
                                          <h5 class="m-l-10 m-t-10">Descargar las plantillas.</h5>

                                           <div class="col-md-12">
                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-6 p-l-0">
                                                 <p>
                                                   <a href="{{ url('plantillas/rime_plantilla_diccionario.xlsx')}}">
                                                     <img class="metro-icon" src="{{ asset('images/excel.png') }}" width="30" alt="" />
                                                     Plantilla Diccionario de Variables.
                                                   </a>
                                                 </p>
                                               </div>
                                               <div class="col-md-6 p-l-0">
                                                 <p>
                                                   <a href="{{ url('plantillas/rime_plantilla_documentacion_campos.xlsx')}}">
                                                     <img class="metro-icon" src="{{ asset('images/excel.png') }}" width="30" alt="" />
                                                     Plantilla Documentación de los campos.
                                                   </a>
                                                 </p>
                                               </div>
                                             </div>
                                             <hr/>
                                             <h3 class="box-title m-b-0">Cargar documentos</h3>
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
                                                   <a class="mytooltip" href="javascript:void(0)">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Confidencialidad<label class="text-success">(r)</label></label>
                                                      <span class="tooltip-content5" style="">
                                                      <span class="tooltip-text3">
                                                        <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                          Descripción de las Condiciones de acceso a la fuente de datos (De uso público, Bajo licencia o convenio, confidencial)
                                                        </span>
                                                      </span>
                                                    </span>
                                                  </a>
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
                                                    <a class="mytooltip" href="javascript:void(0)">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Notas legales<label class="text-danger">(o)</label></label>
                                                      <span class="tooltip-content5" style="">
                                                        <span class="tooltip-text3">
                                                          <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                            Información relativa al marco legal sobre el que se respalda el registro administrativo, encuestas, censos y la responsabilidad de los usuarios de las base de datos.
                                                          </span>
                                                        </span>
                                                      </span>
                                                    </a>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <textarea id="notas_legales" name="notas_legales" class="form-control" rows="8" placeholder="Notas legales" required></textarea>
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
                              <button id="bt_enviar" type="submit" class="btn btn-danger hidden tap-btn">Guardar y Enviar a revisión</button>
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
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcheckbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxlistbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdropdownlist.js') }}"></script>
    <script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script type="text/javascript" src="{{ asset('js/jqwidgets-localization.js') }}"></script>

  <!-- Date Picker Plugin JavaScript -->

  <script type="text/javascript">
  var fechaAV = [];
  var valorAV = [];
  var estadoAV = [];
  var origenAV = [];


  var responsableIDA = [];
  var responsableEstadoA = [];
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
              { name: 'estado', type: 'string' },
              { name: 'id_estado', type: 'int' },
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
          //filterMode: 'simple',
          pageable: true,
          pagerButtonsCount: 10,
          localization: getLocalization('es'),
          pageSize: 100,
          columns: [
            { text: 'Estado', width: 100, dataField: 'estado' },
            { text: 'Nombre fuente', minWidth: 200,dataField: 'nombre' },
            { text: 'Tipo', width: 150,dataField: 'tipo' },
            { text: 'Responsable', width: 200, dataField: 'responsable_nivel_1' },
            { text: 'Opciones', width: 120,
                  cellsRenderer: function (row, column, value, rowData) {
                          if(rowData.id_estado == 1 || rowData.id_estado == 3){
                              var abm = "<div style='margin: 5px; margin-bottom: 3px;'>";
                              var inputEdit = '<button onclick="btn_update('+rowData.id+')" class="btn btn-sm btn-info "><span>Gestionar</span> <i class="fa fa-pencil m-l-5"></i></button>';
                              var inputDelete = '<button onclick="btn_delete('+rowData.id+')" class="btn btn-sm btn-info  m-t-10"><span>Eliminar &nbsp; &nbsp;</span> <i class="fa fa-trash-o m-l-5"></i></button>';
                              abm += inputEdit;
                              abm += inputDelete;
                              abm += "</div>";
                              return abm;
                          }else{
                              if(rowData.id_estado == 4){
                                var abm = "<div style='margin: 5px; margin-bottom: 3px;'>";
                                var inputVer = '-';
                                abm += inputVer;
                                abm += "</div>";
                                return abm;
                              }

                              if(rowData.id_estado == 2){
                                var abm = "<div style='margin: 5px; margin-bottom: 3px;'>";
                                var inputCans = '<button onclick="btn_recuperar('+rowData.id+')" class="btn btn-sm btn-info "><span>Recuperar</span> <i class="fa fa-mail-reply-all m-l-5"></i></button>';
                                abm += inputCans;
                                abm += "</div>";
                                return abm;
                              }

                          }

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
        $("#bt_enviar").removeClass('hidden');
      }else{
        $("#bt_siguiente").removeClass('hidden');
        $("#bt_guardar").addClass('hidden');
        $("#bt_enviar").addClass('hidden');
      }
    });
    $(".tap-btn").click(function () {
      var activo = $(".nav-item a.active").attr('href');

      var next =  activo.substr(-1,1) ;
      next++;
      if(next == 7){
        $("#bt_siguiente").addClass('hidden');
        $("#bt_guardar").removeClass('hidden');
        $("#bt_enviar").removeClass('hidden');
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
        //$("#datosForm > tbody").html("");
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


             responsableIDA.push("");
             responsableEstadoA.push(1);
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

             $('#'+ele+'_otro').removeClass('hidden');
             $('#'+ele+'_otro').addClass('show');
           }else{
             $('#'+ele+'_otro').removeClass('show');
             $('#'+ele+'_otro').addClass('hidden');
           }
         }else{
           $('#'+ele+'_otro').removeClass('show');
           $('#'+ele+'_otro').addClass('hidden');
         }
      });



      $(".agregarARC").click(function () {
         var nombre = $('input[name=arc_nombre_input]').val();
         nombre = nombre.replace(/\s/g,"_");

         var formData = new FormData($("#formAdd")[0]);
         if(!$('#datosARC').find("#ARC"+nombre).length){
            $.ajax({
                    url: "{{ url('/api/sistemarime/apiUploadArchivoRespaldo') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARC'+ nombre +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id[]" value="" />'+
                                              '<input type="hidden" name="arc_nombre[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARC > tbody").append(html);
                            $('input[name=arc_nombre_input]').val('');
                            $('input[name=arc_archivo_input]').val('');
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
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });




      $('.enabledCampos').change(function() {
          if($(this).val() == 'Encuesta'){
             $('.encuestasShow').removeClass('hidden');
          }else{
             $('.encuestasShow').addClass('hidden');
          }

          if($(this).val() == 'Registro Administrativo'){
             $('.rraaShow').removeClass('hidden');
          }else{
             $('.rraaShow').addClass('hidden');
          }
      });


      $("#bt_enviar").click(function () {
        $("#estado").val(2);
      });
      $("#bt_guardar").click(function () {
        $("#estado").val(1);
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

       responsableIDA = [];
       responsableEstadoA = [];
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
             url: "{{ url('/api/sistemarime/apiDataSetFuente') }}",
             type: "GET",
             dataType: 'json',
             data:{'id':ele},
             success: function(data){
               if(data.error == false){

                   //$("#mod_cod_m").val(data.meta).trigger('change');
                   $('#estado_view').html(data.fuente[0].estado);
                   $('#estado').html(data.fuente[0].id_estado);
                   $('input[name="id_fuente"]').val(data.fuente[0].id);
                   $('textarea[name="nombre"]').val(data.fuente[0].nombre);
                   $('input[name="acronimo"]').val(data.fuente[0].acronimo);
                   $('select[name=tipo]').val(data.fuente[0].tipo);
                   $('textarea[name="objetivo"]').val(data.fuente[0].objetivo);
                   $('input[name="serie_datos"]').val(data.fuente[0].serie_datos);
                   $('select[name=periodicidad]').val(data.fuente[0].periodicidad);
                   $('textarea[name="variable"]').val(data.fuente[0].variable);
                   $('select[name=modo_recoleccion_datos]').val(data.fuente[0].modo_recoleccion_datos);
                   if(data.fuente[0].modo_recoleccion_datos == 'Otro'){
                     $('input[name="modo_recoleccion_datos_otro"]').removeClass('hidden');
                     $('input[name="modo_recoleccion_datos_otro"]').addClass('show');
                     $('input[name="modo_recoleccion_datos_otro"]').val(data.fuente[0].modo_recoleccion_datos_otro);
                   }
                   $('textarea[name="unidad_analisis"]').val(data.fuente[0].unidad_analisis);
                   $('textarea[name="universo_estudio"]').val(data.fuente[0].universo_estudio);

                   $('textarea[name="disenio_tamanio_muestra"]').val(data.fuente[0].disenio_tamanio_muestra);
                   $('textarea[name="tasa_respuesta"]').val(data.fuente[0].tasa_respuesta);

                   $('textarea[name="observacion"]').val(data.fuente[0].observacion);


                   if(data.fuente[0].demografia_estadistica_social){
                     $("#demografia_estadistica_social").val(data.fuente[0].demografia_estadistica_social.split(",")).trigger('change');
                     var str = data.fuente[0].demografia_estadistica_social;
                     //alert(str.indexOf("Otro"));
                     if(str){
                       if(str.indexOf("Otro") >= 0){
                         $('#demografia_estadistica_social_otro').val(data.fuente[0].demografia_estadistica_social_otro);
                         $('#demografia_estadistica_social_otro').removeClass('hidden');
                         $('#demografia_estadistica_social_otro').addClass('show');
                       }
                     }
                   }

                   if(data.fuente[0].estadistica_economica){
                     $("#estadistica_economica").val(data.fuente[0].estadistica_economica.split(",")).trigger('change');
                     var str = data.fuente[0].estadistica_economica;
                     //alert(str.indexOf("Otro"));
                     if(str){
                       if(str.indexOf("Otro") >= 0){
                         $('#estadistica_economica_otro').val(data.fuente[0].estadistica_economica_otro);
                         $('#estadistica_economica_otro').removeClass('hidden');
                         $('#estadistica_economica_otro').addClass('show');
                       }
                     }
                   }


                   if(data.fuente[0].estadistica_medioambiental){
                     $("#estadistica_medioambiental").val(data.fuente[0].estadistica_medioambiental.split(",")).trigger('change');
                     var str = data.fuente[0].estadistica_medioambiental;
                     //alert(str.indexOf("Otro"));
                     if(str){
                       if(str.indexOf("Otro") >= 0){
                         $('#estadistica_medioambiental_otro').val(data.fuente[0].estadistica_medioambiental_otro);
                         $('#estadistica_medioambiental_otro').removeClass('hidden');
                         $('#estadistica_medioambiental_otro').addClass('show');
                       }
                     }
                   }



                   if(data.fuente[0].informacion_geoespacial){
                     $("#informacion_geoespacial").val(data.fuente[0].informacion_geoespacial.split(",")).trigger('change');
                     var str = data.fuente[0].informacion_geoespacial;
                     //alert(str.indexOf("Otro"));
                     if(str){
                       if(str.indexOf("Otro") >= 0){
                         $('#informacion_geoespacial_otro').val(data.fuente[0].informacion_geoespacial_otro);
                         $('#informacion_geoespacial_otro').removeClass('hidden');
                         $('#informacion_geoespacial_otro').addClass('show');
                       }
                     }
                   }


                  $('input[name="numero_total_formulario"]').val(data.fuente[0].numero_total_formulario);
                  total_form = data.fuente[0].numero_total_formulario;

                  var form = data.fuente[0].nombre_formulario;
                  var setForms = form.split('|');
                  /*$.each(setForms, function(index, value) {
                    alert(index + ': ' + value);
                  });*/
                  $.each(setForms, function(index, item) {
                        var arrayForm = [];
                        for(i=1;i<=total_form;i++){
                          arrayForm[i] = $('#frm-nom-'+i).val();
                        }
                        var i = (index+1);
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
                                           '<input type="text" id="frm-nom-'+i+'" name="nombre_formulario[]" value="'+item+'" class="form-control"/>'+
                                         '</td>'+
                                         '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarFRM('+i+');"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                    '</tr>';
                         $("#datosForm > tbody").append(html);
                  });

                  $.each(data.responsables, function(index, item) {
                            responsableIDA.push(item.id);
                            responsableEstadoA.push(1);
                            responsable1A.push(item.responsable_nivel_1);
                            responsable2A.push(item.responsable_nivel_2);
                            responsable3A.push(item.responsable_nivel_3);
                            responsable4A.push(item.responsable_nivel_4);
                            referenciaA.push(item.numero_referencia);
                  });
                  actualizarListaResponsable();




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

                  $('select[name=confidencialidad]').val(data.fuente[0].confidencialidad);
                  $('textarea[name="notas_legales"]').val(data.fuente[0].notas_legales);
                  $(".enabledCampos" ).trigger( "change" );

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
                   url: "{{ url('/api/sistemarime/apiDeleteFuente') }}",
                   data: { '_token': $('input[name=_token]').val(),'id_fuente': ele },
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

    function btn_recuperar(ele) {
        swal({
          title: "Está seguro?",
          text: "Se cambiara el estado!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si, recuperar!",
          closeOnConfirm: false
        }, function(){
             $.ajax({
                   url: "{{ url('/api/sistemarime/apiRecuperarFuente') }}",
                   data: { '_token': $('input[name=_token]').val(),'id_fuente': ele },
                   type: "post",
                   dataType: 'json',
                   success: function(date){
                       $("#dataTable").jqxDataTable("updateBoundData");
                       swal("Recuperado!", "Se cambio el estado de la fuente.", "success");
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
      var totH = 0;
      $.ajax({
            url: "{{ url('/api/sistemarime/apiSourceOrderbyArray2') }}",
            type: "GET",
            dataType: 'json',
            data:{'responsable1':responsable1A,'responsable2':responsable2A,'responsable3':responsable3A,'responsable4':responsable4A,'referencia':referenciaA},
            success: function(date){
                  if(date.error == false){
                      $.each(date.item, function(i, data) {
                            if(responsableEstadoA[data.index] != 0){
                              var classE = "";
                            }else{
                              var classE = "hidden";
                              totH++;
                            }
                            var html = '<tr id="RS'+cav+'" class="'+classE+'">'+
                                            '<td style="width: 5%;">'+
                                               cav+
                                            '</td>'+
                                            '<td style="width: 90%;">'+
                                                 '<input type="hidden" name="id_responsable[]" value="'+ responsableIDA[data.index] +'" />'+
                                                 '<input type="hidden" name="responsable_estado[]" value="'+ responsableEstadoA[data.index] +'" />'+
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


                     $("#cont_resp").html((cav-1)-totH);

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

          if(responsableIDA[index] == ""){
            $('#RS'+ele).remove();
            responsableIDA.splice(index, 1);
            responsableEstadoA.splice(index, 1);
            responsable1A.splice(index, 1);
            responsable2A.splice(index, 1);
            responsable3A.splice(index, 1);
            responsable4A.splice(index, 1);
            referenciaA.splice(index, 1);
          }else{
            responsableEstadoA[index] = 0;
          }
        actualizarListaResponsable();
    }

    function quitarARC(ele,archivo,tipo){
      var res = confirm("Esta seguro de quitar el archivo?");
          if (res == true) {
            if(tipo == 1){
                 $.ajax({
                       type: "GET",
                       dataType: 'json',
                       url: "{{ url('/api/sistemarime/apiDeleteArchivo') }}",
                       data: {archivo: archivo},
                       success: function(data){
                           $('#ARC'+ele).remove();
                       },
                       error:function(data){
                         if(data.status != 401){
                           alert("Error recuperar al eliminar.");
                         }else{
                           window.location = '/login';
                         }
                       }
                   });
            }else{
              $('#ARC'+ele).addClass('hidden');
              $('#EST'+ele).val(0);
              $('#ARC'+ele).attr("id",'0ARC'+ele);
            }
        }

    }






  </script>
@endpush
