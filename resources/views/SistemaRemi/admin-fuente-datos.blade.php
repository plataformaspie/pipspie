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
        height:500px;
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
            <p class="text-muted m-b-30">Fuente de Datos registrados
              <button id ="btn-new" type="button" class="btn btn-info btn-lg" style="float: right;margin-top: -26px;"><i class="fa fa-plus"></i> Agregar Nuevo</button>
            </p>
            <div class="row">
              <div id="FilterAdvanced" class="col-lg-3 hidden">
                  <div style="margin-top: 30px;">
                      <div>Filtrado por:</div>
                      <div id="columnchooser"></div>
                      <div style="float: left;  margin-top: 10px;" id="filterbox"></div>
                      <div style="float: left; margin-left: 20px; margin-top: 10px;">
                          <input type="button" id="applyFilter" value="Aplicar filtro" />
                          <input type="button" id="clearfilter" style="margin-top:20px;" value="Limpiar" />
                      </div>
                  </div>
              </div>
              <div id="exportarData" class="col-lg-3 hidden">
                  <div style="margin-top: 30px;">
                      <div>Exportar a:</div>
                      <select class="form-control">
                          <option value="excel">Excel</option>
                      </select>
                      <label>
                        <input name="option_data" value="1" type="radio"> Contenido de tabla
                      </label>
                      <label>
                        <input name="option_data" value="2" type="radio"> Registro seleccionado
                      </label>
                      <div style="float: left; margin-left: 20px; margin-top: 10px;">
                        <button id="generarExport" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Generar Reporte</button>
                      </div>
                  </div>
              </div>
              <div id="jqxDataTable" class="col-lg-12">
                <p class="m-b-5">
                  <button onclick="showFilterAdvanced();" type="button" class="btn btn-warning btn-sm "><i class="fa fa-filter"></i> Filtrar por</button>
                  <!--button onclick="showExportarData();" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Exportar a</button-->
                </p>
                <div id="dataTable"></div>
              </div>
            </div>
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
                        <button id ="btn-back" type="button" class="btn btn-info btn-lg" style="float: right;margin-top: -26px;">
                          <i class="fa fa-arrow-left"> Atras</i>
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
                                          <p class="m-t-10"><h5 class="text-info">*Para cada caso puede seleccionar mas de una opción si fuera necesario.</h3></p>
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

                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-6 p-l-0 p-r-0">
                                                    <a class="mytooltip" href="javascript:void(0)">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Cobertura Geográfica de la Fuente de Datos <label class="text-danger">(o)</label></label>
                                                      <span class="tooltip-content5" style="">
                                                        <span class="tooltip-text3">
                                                          <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                            Áreas geográficas que cubre la operación estadística: urbana, rural, región departamento, municipio, macrodistrito, unidad vecinal (UV), zona, localidad, comunidad, etc.
                                                            Elegir la(s) alternativa(s) que apliquen del listado proporcionado.
                                                          </span>
                                                        </span>
                                                      </span>
                                                    </a>
                                                 </div>
                                                 <div class="col-md-12 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <ul class="checkbox">
                                                         <li><input type="checkbox" id="c1" name="cobertura[]" value="1" /><label> Internacional</label></li>
                                                         <li>
                                                           <input type="checkbox" id="c2" name="cobertura[]" value="2" class="padreck" /><label> Nacional (Todo el país)</label>
                                                           <ul class="">
                                                             <li><input type="checkbox" id="c3" name="cobertura[]" value="3" class="hijo2" /><label> Nacional Urbano (Ciudades Capitales)</label></li>
                                                             <li><input type="checkbox" id="c4" name="cobertura[]" value="4" class="hijo2" /><label> Nacional Urbano (Conurbaciones, Regiones Metropolitanas)</label></li>
                                                             <li><input type="checkbox" id="c5" name="cobertura[]" value="5" class="hijo2" /><label> Nacional  Resto Urbano</label></li>
                                                             <li><input type="checkbox" id="c6" name="cobertura[]" value="6" class="hijo2"/><label> Nacional Rural</label></li>
                                                           </ul>
                                                         </li>
                                                         <li>
                                                           <input type="checkbox" id="c7" name="cobertura[]" value="7" class="padreck" /><label> Departamental (Todos los Departamentos)</label>
                                                           <ul class="">
                                                             <li>
                                                               <input type="checkbox" id="c8" name="cobertura[]" value="8" class="hijo2" /><label> Departamental Urbano (Todas las Ciudades Capitales)</label>
                                                               <ul class="">
                                                                 <li><input type="checkbox" id="c9" name="cobertura[]" value="9" class="hijo2" /><label> Chuquisaca (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="c10" name="cobertura[]" value="10" class="hijo2" /><label> La Paz (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="c11" name="cobertura[]" value="11" class="hijo2" /><label> El Alto (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="c12" name="cobertura[]" value="12" class="hijo2"/><label> Cochabamba (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="c13" name="cobertura[]" value="13" class="hijo2"/><label> Santa Cruz (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="c14" name="cobertura[]" value="14" class="hijo2"/><label> Tarija (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="c15" name="cobertura[]" value="15" class="hijo2"/><label> Oruro (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="c16" name="cobertura[]" value="16" class="hijo2"/><label> Potosí (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="c17" name="cobertura[]" value="17" class="hijo2"/><label> Beni (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="c18" name="cobertura[]" value="18" class="hijo2"/><label> Pando (Ciudad Capital)</label></li>
                                                               </ul>
                                                             </li>


                                                             <li>
                                                               <input type="checkbox" id="c19" name="cobertura[]" value="19" class="hijo2" /><label> Departamental Urbano (Conurbaciones, Regiones Metropolitanas)</label>
                                                             </li>
                                                             <li>
                                                               <input type="checkbox" id="c20" name="cobertura[]" value="20" class="hijo2" /><label> Departamental Resto Urbano</label>
                                                             </li>
                                                             <li>
                                                               <input type="checkbox" id="c21" name="cobertura[]" value="21" class="hijo2" /><label> Departamental Rural</label>
                                                             </li>

                                                           </ul>
                                                         </li>
                                                         <li>
                                                           <input type="checkbox" id="c22" name="cobertura[]" value="22" class="hijo2"/><label> Municipal (Todos los municipios)</label>
                                                           <ul class="">
                                                             <li><input type="checkbox" id="c23" name="cobertura[]" value="23" class="hijo2" /><label> Municipal Urbano </label></li>
                                                             <li><input type="checkbox" id="c29" name="cobertura[]" value="29" class="hijo2" /><label> Municipal Rural</label></li>
                                                           </ul>
                                                         </li>
                                                       </ul>
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>



                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-6 p-l-0 p-r-0">
                                                    <a class="mytooltip" href="javascript:void(0)">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nivel de Desagregación Geográfica<label class="text-danger">(o)</label></label>
                                                      <span class="tooltip-content5" style="">
                                                        <span class="tooltip-text3">
                                                          <span class="tooltip-inner2 p-10 text-left" style="font-size:10px;">
                                                            Nivel más pequeño cubierto por los datos. Equivale a mencionar a qué nivel son representativos los datos. El nivel de desagregación geográfica más desagregada suele coincidir con el nivel geográfico al que se registra la unidad de análisis.
                                                            Elegir la(s) alternativa(s) que apliquen del listado proporcionado

                                                          </span>
                                                        </span>
                                                      </span>
                                                    </a>
                                                 </div>
                                                 <div class="col-md-12 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <ul class="checkbox">
                                                         <li><input type="checkbox" id="d1" name="desagregacion[]" value="1" /><label> Internacional</label></li>
                                                         <li>
                                                           <input type="checkbox" id="d2" name="desagregacion[]" value="2" class="padreck" /><label> Nacional (Todo el país)</label>
                                                           <ul class="">
                                                             <li><input type="checkbox" id="d3" name="desagregacion[]" value="3" class="hijo2" /><label> Nacional Urbano (Ciudades Capitales)</label></li>
                                                             <li><input type="checkbox" id="d4" name="desagregacion[]" value="4" class="hijo2" /><label> Nacional Urbano (Conurbaciones, Regiones Metropolitanas)</label></li>
                                                             <li><input type="checkbox" id="d5" name="desagregacion[]" value="5" class="hijo2" /><label> Nacional  Resto Urbano</label></li>
                                                             <li><input type="checkbox" id="d6" name="desagregacion[]" value="6" class="hijo2"/><label> Nacional Rural</label></li>
                                                           </ul>
                                                         </li>
                                                         <li>
                                                           <input type="checkbox" id="d7" name="desagregacion[]" value="7" class="padreck" /><label> Departamental (Todos los Departamentos)</label>
                                                           <ul class="">
                                                             <li>
                                                               <input type="checkbox" id="d8" name="desagregacion[]" value="8" class="hijo2" /><label> Departamental Urbano (Todas las Ciudades Capitales)</label>
                                                               <ul class="">
                                                                 <li><input type="checkbox" id="d9" name="desagregacion[]" value="9" class="hijo2" /><label> Chuquisaca (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="d10" name="desagregacion[]" value="10" class="hijo2" /><label> La Paz (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="d11" name="desagregacion[]" value="11" class="hijo2" /><label> El Alto (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="d12" name="desagregacion[]" value="12" class="hijo2"/><label> Cochabamba (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="d13" name="desagregacion[]" value="13" class="hijo2"/><label> Santa Cruz (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="d14" name="desagregacion[]" value="14" class="hijo2"/><label> Tarija (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="d15" name="desagregacion[]" value="15" class="hijo2"/><label> Oruro (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="d16" name="desagregacion[]" value="16" class="hijo2"/><label> Potosí (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="d17" name="desagregacion[]" value="17" class="hijo2"/><label> Beni (Ciudad Capital)</label></li>
                                                                 <li><input type="checkbox" id="d18" name="desagregacion[]" value="18" class="hijo2"/><label> Pando (Ciudad Capital)</label></li>
                                                               </ul>
                                                             </li>


                                                             <li>
                                                               <input type="checkbox" id="d19" name="desagregacion[]" value="19" class="hijo2" /><label> Departamental Urbano (Conurbaciones, Regiones Metropolitanas)</label>
                                                             </li>
                                                             <li>
                                                               <input type="checkbox" id="d20" name="desagregacion[]" value="20" class="hijo2" /><label> Departamental Resto Urbano</label>
                                                             </li>
                                                             <li>
                                                               <input type="checkbox" id="d21" name="desagregacion[]" value="21" class="hijo2" /><label> Departamental Rural</label>
                                                             </li>

                                                           </ul>
                                                         </li>
                                                         <li>
                                                           <input type="checkbox" id="d22" name="desagregacion[]" value="22" class="hijo2"/><label> Municipal (Todos los municipios)</label>
                                                           <ul class="">
                                                             <li>
                                                               <input type="checkbox" id="d23" name="desagregacion[]" value="23" class="hijo2" /><label> Municipal Urbano </label>
                                                               <ul class="">
                                                                 <li><input type="checkbox" id="d24" name="desagregacion[]" value="24" class="hijo2" /><label for="cb3"> Macrodistrito/Distrito</label></li>
                                                                 <li><input type="checkbox" id="d25" name="desagregacion[]" value="25" class="hijo2" /><label for="cb4"> Unidad Vecinal</label></li>
                                                                 <li><input type="checkbox" id="d26" name="desagregacion[]" value="26" class="hijo2" /><label for="cb5"> Zona</label></li>
                                                                 <li><input type="checkbox" id="d27" name="desagregacion[]" value="27" class="hijo2"/><label for="cb6"> Manzano</label></li>
                                                                 <li><input type="checkbox" id="d28" name="desagregacion[]" value="28" class="hijo2"/><label for="cb6"> Lote</label></li>
                                                               </ul>
                                                             </li>
                                                             <li>
                                                               <input type="checkbox" id="d29" name="desagregacion[]" value="29" class="hijo2" /><label> Municipal Rural</label>
                                                               <ul class="">
                                                                 <li><input type="checkbox" id="d30" name="desagregacion[]" value="30" class="hijo2" /><label for="cb3"> Predio/Lote</label></li>
                                                                 <li><input type="checkbox" id="d31" name="desagregacion[]" value="31" class="hijo2" /><label for="cb4"> Localidad</label></li>
                                                                 <li><input type="checkbox" id="d32" name="desagregacion[]" value="32" class="hijo2" /><label for="cb5"> Comunidad</label></li>
                                                                 <li><input type="checkbox" id="d33" name="desagregacion[]" value="33" class="hijo2"/><label for="cb6"> Zona</label></li>
                                                               </ul>
                                                             </li>
                                                           </ul>
                                                         </li>
                                                       </ul>
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
                                                   <li role="presentation" class="active nav-item disUpdateRS ">
                                                     <a href="#lista" class="nav-link panelIniRs" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">
                                                       <span class="visible-xs"><i class="ti-user"></i></span>
                                                       <span class="hidden-xs">Lista </span>
                                                       <span id="cont_resp"class="label label-warning" style="font-size:15px;font-weight:bold;">0</span></a>
                                                   </li>
                                                   <li role="presentation" class="nav-item disUpdateRS">
                                                     <a href="#registro" class="nav-link" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                                                       <span class="visible-xs"><i class="ti-home"></i></span>
                                                       <span class="hidden-xs"> Registrar</span>
                                                     </a>
                                                   </li>
                                                   <li id="tab_modificar" role="modificar" class="nav-item hidden">
                                                     <a href="#modificar" class="nav-link tab_modificar" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                                                       <span class="visible-xs"><i class="ti-home"></i></span>
                                                       <span class="hidden-xs"> Modificar</span>
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

                                                       <div role="tabpanel" class="tab-pane" id="modificar">
                                                             <div class="row">
                                                                 <div class="col-md-12">
                                                                   <div class="row">
                                                                         <div class="col-md-4 p-l-0 p-r-0">
                                                                           <a class="mytooltip" href="javascript:void(0)">
                                                                             <label for="textarea" class="col-form-label control-label list-group-item-warning" style="width: 100%;padding: 15px 0px 7px 3px;" >Institución Propietaria/Custodia<label class="text-danger">(o)</label></label>
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
                                                                           <input type="hidden" name="mod_index" value="">
                                                                           <input id="mod_responsable_1" name="mod_responsable_1" type="text" class="form-control"  placeholder="Institución Propietaria/Custodia" required>
                                                                           <div class="help-block with-errors"></div>
                                                                         </div>

                                                                         <div class="col-md-4 p-l-0 p-r-0 text-right">
                                                                           <a class="mytooltip" href="javascript:void(0)">
                                                                             <label for="textarea" class="col-form-label control-label list-group-item-warning" style="width: 100%;padding: 15px 0px 7px 3px;">Dependencia Ejecutiva<label class="text-danger">(o)</label></label>
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
                                                                           <input id="mod_responsable_2" name="mod_responsable_2" type="text" class="form-control"  placeholder="Dependencia Ejecutiva" required>
                                                                           <div class="help-block with-errors"></div>
                                                                         </div>

                                                                         <div class="col-md-4 p-l-0 p-r-0 text-right">
                                                                           <a class="mytooltip" href="javascript:void(0)">
                                                                             <label for="textarea" class="col-form-label control-label list-group-item-warning" style="width: 100%;padding: 15px 0px 7px 3px;">Dependencia Técnica<label class="text-danger">(o)</label></label>
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
                                                                           <input id="mod_responsable_3" name="mod_responsable_3" type="text" class="form-control"  placeholder="Dependencia Técnica" required>
                                                                           <div class="help-block with-errors"></div>
                                                                         </div>
                                                                         <div class="col-md-4 p-l-0 p-r-0 text-right">
                                                                           <a class="mytooltip" href="javascript:void(0)">
                                                                             <label for="textarea" class="col-form-label control-label list-group-item-warning" style="width: 100%;padding: 15px 0px 7px 3px;">Dependencia Informática<label class="text-success">(r)</label></label>
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
                                                                           <input id="mod_responsable_4" name="mod_responsable_4" type="text" class="form-control"  placeholder="Dependencia Informática" required>
                                                                           <div class="help-block with-errors"></div>
                                                                         </div>

                                                                         <div class="col-md-4 p-l-0 p-r-0">
                                                                           <a class="mytooltip" href="javascript:void(0)">
                                                                             <label for="textarea" class="col-form-label control-label list-group-item-warning" style="width: 100%;padding: 15px 0px 7px 3px;">Teléfono de referencia<label class="text-danger">(o)</label></label>
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
                                                                           <input id="mod_referencia" name="mod_referencia" type="text" class="form-control"  placeholder="Teléfono de referencia" required>
                                                                           <div class="help-block with-errors"></div>
                                                                         </div>
                                                                   </div>
                                                                 </div>
                                                             </div>
                                                             <div class="col-md-12 p-l-0 text-center">
                                                                 <button type="button" class="btn btn-info btn-sm  m-t-5 updateRS"><i class="fa fa-plus-square"></i> Actualizar datos</button>
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
                                             <h3 class="box-title m-b-0">Cargar documentos(menor a 300Mb)</h3>
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
                                                       <input type="file" id ="arc_archivo_input" name="arc_archivo_input" class="form-control p-t-0" accept="all">
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                                 <div class="col-md-12 p-l-0 text-center">
                                                     <p>
                                                       <button type="button" class="btn btn-info btn-sm agregarARC m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                       <i id="icoLoad" class="fa fa-spin fa-spinner hidden" style="font-size:30px;"></i>
                                                      </p>

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
              { name: 'responsable', type: 'string' }
          ],
          id: 'id',
          url: url
      };
      var dataAdapter = new $.jqx.dataAdapter(source);
      $("#dataTable").jqxDataTable(
      {
          source: dataAdapter,
          width:"100%",
          height:"400px",
          theme:theme,
          columnsResize: true,
          filterable: true,
          filterMode: 'simple',
          selectionMode: 'multipleRows',
          //pageable: true,
          //pagerButtonsCount: 10,
          sortable: true,
          //ready:function(){
          //$("#filterdataTable").append('<p><button onclick="showFilterAdvanced();" type="button" class="btn btn-warning btn-circle"><i class="fa fa-filter"></i></button></p>');
          //},
          localization: getLocalization('es'),
          //pageSize: 100,
          columns: [
            { text: 'Estado', width: 100, dataField: 'estado' },
            { text: 'Nombre fuente', minWidth: 200,dataField: 'nombre' },
            { text: 'Tipo', width: 150,dataField: 'tipo' },
            { text: 'Responsable', width: 200, dataField: 'responsable' },
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



      // create buttons, listbox and the columns chooser dropdownlist.
            $("#applyFilter").jqxButton();
            $("#clearfilter").jqxButton();
            $("#filterbox").jqxListBox({
              checkboxes: true,
              filterable: false,
              //searchMode: 'containsignorecase',
              width: "100%",
              height: 150
            });
            $("#columnchooser").jqxDropDownList({
                autoDropDownHeight: true, selectedIndex: 0, width: 160, height: 25,
                source: [
                  { label: 'Responsable', value: 'responsable' },
                  { label: 'Estado', value: 'estado' },
                  { label: 'Nombre', value: 'nombre' },
                  { label: 'Tipo', value: 'tipo' }

                ]
            });
            // updates the listbox with unique records depending on the selected column.
            var updateFilterBox = function (dataField) {

                $("#dataTable").jqxDataTable('clearFilters');
                var filterBoxAdapter = new $.jqx.dataAdapter(source,
                {
                    uniqueDataFields: [dataField],
                    autoBind: true,
                    async:false
                });
                var uniqueRecords = filterBoxAdapter.records;
                uniqueRecords.splice(0, 0, '(Todo)');
                $("#filterbox").jqxListBox({ source: uniqueRecords, displayMember: dataField });
                $("#filterbox").jqxListBox('checkAll');
            }
            updateFilterBox('responsable');
            // handle select all item.
            var handleCheckChange = true;
            $("#filterbox").on('checkChange', function (event) {
                if (!handleCheckChange)
                    return;

                if (event.args.label != '(Todo)') {
                    // update the state of the "Select All" listbox item.
                    handleCheckChange = false;
                    $("#filterbox").jqxListBox('checkIndex', 0);
                    var checkedItems = $("#filterbox").jqxListBox('getCheckedItems');
                    var items = $("#filterbox").jqxListBox('getItems');
                    if (checkedItems.length == 1) {
                        $("#filterbox").jqxListBox('uncheckIndex', 0);
                    }
                    else if (items.length != checkedItems.length) {
                        $("#filterbox").jqxListBox('indeterminateIndex', 0);
                    }
                    handleCheckChange = true;
                }
                else {
                    // check/uncheck all items if "Select All" is clicked.
                    handleCheckChange = false;
                    if (event.args.checked) {
                        $("#filterbox").jqxListBox('checkAll');
                    }
                    else {
                        $("#filterbox").jqxListBox('uncheckAll');
                    }
                    handleCheckChange = true;
                }
            });
            // handle columns selection.
            $("#columnchooser").on('select', function (event) {
                updateFilterBox(event.args.item.value);
            });
            // builds and applies the filter.
            var applyFilter = function (dataField) {
                $("#dataTable").jqxDataTable('clearFilters');
                var filtertype = 'stringfilter';
                if (dataField == 'date') filtertype = 'datefilter';
                if (dataField == 'price' || dataField == 'quantity') filtertype = 'numericfilter';
                // create a new group of filters.
                var filtergroup = new $.jqx.filter();
                // get listbox's checked items.
                var checkedItems = $("#filterbox").jqxListBox('getCheckedItems');
                if (checkedItems.length == 0) {
                    var filter_or_operator = 1;
                    var filtervalue = "Empty";
                    var filtercondition = 'equal';
                    var filter = filtergroup.createfilter(filtertype, filtervalue, filtercondition);
                    filtergroup.addfilter(filter_or_operator, filter);
                }
                else {
                    for (var i = 0; i < checkedItems.length; i++) {
                        var filter_or_operator = 1;
                        // set filter's value.
                        var filtervalue = checkedItems[i].label;
                        // set filter's condition.
                        var filtercondition = 'equal';
                        // create new filter.
                        var filter = filtergroup.createfilter(filtertype, filtervalue, filtercondition);
                        // add the filter to the filter group.
                        filtergroup.addfilter(filter_or_operator, filter);
                    }
                }
                // add the filters.
                $("#dataTable").jqxDataTable('addFilter', dataField, filtergroup);
                // apply the filters.
                $("#dataTable").jqxDataTable('applyFilters');
            }
            // clears the filter.
            $("#clearfilter").click(function () {
                $("#dataTable").jqxDataTable('clearFilters');
            });
            // applies the filter.
            $("#applyFilter").click(function () {
                var dataField = $("#columnchooser").jqxDropDownList('getSelectedItem').value;
                applyFilter(dataField);
            });



    $(".ctrl-btn").click(function () {
      validarSession();
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
      $(".panelIniRs" ).trigger( "click" );
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

            $(".panelIniRs" ).trigger( "click" );
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
        $('#icoLoad').removeClass('hidden');
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
                          var filepath = data.item.archivo;
                          var ico = filepath.split(".");
                          var iconoSel = iconos(ico[1]);
                          var html = '<tr id="ARC'+ nombre +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id[]" value="" />'+
                                              '<input type="hidden" name="arc_nombre[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;" title="Descargar Archivos respaldo" target="_blank">'+
                                              '<p>'+
                                                '<i class="fa '+iconoSel+'"  style="font-size: 30px;"></i> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARC > tbody").append(html);
                            $('input[name=arc_nombre_input]').val('');
                            $('input[name=arc_archivo_input]').val('');
                            $('#icoLoad').addClass('hidden');
                          }else{
                              $('#icoLoad').addClass('hidden');
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
                      $('#icoLoad').addClass('hidden');
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al cargar el documento. Verifique que el tamaño sea menor a 300Mb',
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



      $("#generarExport").click(function() {
          //cantidad de datos
          var selection = $("#dataTable").jqxDataTable('getSelection');
          var optionSel = $('input:radio[name=option_data]:checked').val();
          var orden = false;//agregar configuracion de la tabla
          var direccion = 'ASC';//agregar configuracion de la tabla
          var ids = "";
          switch(optionSel) {
              case "1":
                  $('#tabledataTable > tbody > tr').each(function() {
                     ids += $(this).attr("data-key")+",";
                  });
                  location.href = "{{ url('/api/sistemarime/apiExportData') }}?ids=" + ids + "&orden=" + orden + "&dir=" + direccion;
                  break;
              case "2":
                  if(selection.length > 0){
                    if (selection && selection.length > 0) {
                        var rows = $("#dataTable").jqxDataTable('getRows');
                        for (var i = 0; i < selection.length; i++) {
                            var rowData = selection[i];
                            ids += rowData.id;
                            if (i < selection.length - 1) {
                              ids += ", ";
                            }
                        }
                      location.href = "{{ url('/api/sistemarime/apiExportData') }}?ids=" + ids + "&orden=" + orden + "&dir=" + direccion;
                    }
                  }else{
                    $.toast({
                      heading: 'Error:',
                      text: 'Seleccione algún registro de la tabla.',
                      position: 'top-right',
                      loaderBg:'#ff6849',
                      icon: 'error',
                      hideAfter: 3500
                    });
                  }
              break;
              default:
                $.toast({
                  heading: 'Error:',
                  text: 'Configure su reporte.',
                  position: 'top-right',
                  loaderBg:'#ff6849',
                  icon: 'error',
                  hideAfter: 3500
                });
              break;
          }





      });





    });
    //fin document






    $('#btn-back, .btn-back').click(function() {
       validarSession();
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
       $(".panelIniRs" ).trigger( "click" );
    });

    $('#btn-new, .btn-new ').click(function() {
        validarSession();
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

                  if(data.fuente[0].nombre_formulario){
                    var setForms = form.split('|');
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
                  }

                  $('input[name="cobertura_rraa"]').val(data.fuente[0].cobertura_rraa);
                  $('textarea[name="cobertura_rraa_descripcion"]').val(data.fuente[0].cobertura_rraa_descripcion);


                  if(data.fuente[0].cobertura_geografica){
                    var cobertura = data.fuente[0].cobertura_geografica;
                    var setCobe = cobertura.split(',');
                    $.each(setCobe, function(index, item) {
                          document.getElementById("c"+item).checked=true;
                    });
                  }
                  if(data.fuente[0].nivel_representatividad_datos){
                    var desagregacion = data.fuente[0].nivel_representatividad_datos;
                    var setCobe = desagregacion.split(',');
                    $.each(setCobe, function(index, item) {
                          //$("#d"+item).attr('checked',true);
                          document.getElementById("d"+item).checked = true;
                    });
                  }

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
                      var filepath = data.archivo;
                      var ico = filepath.split(".");
                      var iconoSel = iconos(ico[1]);

                      var nombre = data.nombre.replace(/\s/g,"_");
                      var html = '<tr id="ARC'+ nombre +'" class="">'+
                                      '<td>'+
                                          '<input type="hidden" name="arc_id[]" value="'+data.id+'" />'+
                                          '<input type="hidden" name="arc_nombre[]" value="'+ data.nombre +'" />'+
                                          '<input type="hidden" name="arc_archivo[]" value="'+ data.archivo +'" />'+
                                          '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                          '<a href="/respaldos/'+data.archivo+'" style="cursor: pointer;" title="Descargar Archivos respaldo" target="_blank">'+
                                          '<p>'+
                                            '<i class="fa '+iconoSel+'"  style="font-size: 30px;"></i> '+
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
      validarSession();
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
                                              '<p><a data-toggle="tooltip" data-original-title="Borrar" onclick="quitarRS('+cav+','+data.index+');" style="cursor: pointer;"> <i class="fa fa-close text-danger"></i> </a></p>'+
                                              '<p><a data-toggle="tooltip" data-original-title="Borrar" onclick="showUpdateRS('+cav+','+data.index+');" style="cursor: pointer;"> <i class="fa fa-pencil text-danger"></i> </a></p>'+
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
    function showUpdateRS(ele,index){
      $('#tab_modificar').removeClass('hidden');
      $(".tab_modificar" ).trigger( "click" );
      $('input[name="mod_index"]').val(index);
      $('input[name="mod_responsable_1"]').val($('input[name="responsable_nivel_1[]"]:eq('+index+')').val());
      $('input[name="mod_responsable_2"]').val($('input[name="responsable_nivel_2[]"]:eq('+index+')').val());
      $('input[name="mod_responsable_3"]').val($('input[name="responsable_nivel_3[]"]:eq('+index+')').val());
      $('input[name="mod_responsable_4"]').val($('input[name="responsable_nivel_4[]"]:eq('+index+')').val());
      $('input[name="mod_referencia"]').val($('input[name="numero_referencia[]"]:eq('+index+')').val());

    }
    $(".disUpdateRS").click(function () {
      $('#tab_modificar').removeClass('hidden');
      $('#tab_modificar').addClass('hidden');
    });

    $(".updateRS").click(function () {
        $(".disUpdateRS" ).trigger( "click" );
        $(".panelIniRs" ).trigger( "click" );
        var index = $('input[name="mod_index"]').val();
        responsable1A[index] = $('input[name="mod_responsable_1"]').val();
        responsable2A[index] = $('input[name="mod_responsable_2"]').val();
        responsable3A[index] = $('input[name="mod_responsable_3"]').val();
        responsable4A[index] = $('input[name="mod_responsable_4"]').val();
        referenciaA[index] = $('input[name="mod_referencia"]').val();
        actualizarListaResponsable();
    });

    function quitarARC(ele,archivo,tipo){
      validarSession();
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

    function validarSession(){
      $.ajax({
            type: "GET",
            dataType: 'json',
            url: "{{ url('/apiValidateSession') }}",
            data: {"1": 1},
            success: function(data){
                console.log("todo perfecto");
            },
            error:function(data){
              if(data.status != 401){
                console.log("se persive algun error");
              }else{
                window.location = '/login';
              }
            }
        });
    }

    function showFilterAdvanced() {

      if ($('#FilterAdvanced').hasClass('hidden')){
            $('#exportarData').removeClass('hidden')
            $('#exportarData').addClass('hidden')
            $("#dataTable").jqxDataTable({filterable: false});
            $('#FilterAdvanced').removeClass('hidden')
            $('#jqxDataTable').removeClass('col-lg-12');
            $('#jqxDataTable').fadeIn(500).addClass('col-lg-9');
      }else{
        $("#dataTable").jqxDataTable({filterable: true});
          $('#FilterAdvanced').addClass('hidden')
          $('#jqxDataTable').removeClass('col-lg-9');
          $('#jqxDataTable').fadeIn(500).addClass('col-lg-12');
        }
    }
    function showExportarData() {

      if ($('#exportarData').hasClass('hidden')){
            $("#dataTable").jqxDataTable({filterable: true});
            $('#FilterAdvanced').removeClass('hidden')
            $('#FilterAdvanced').addClass('hidden')

            $('#exportarData').removeClass('hidden')
            $('#jqxDataTable').removeClass('col-lg-12');
            $('#jqxDataTable').fadeIn(1000).addClass('col-lg-9');

      }else{

          $('#exportarData').addClass('hidden')
          $('#jqxDataTable').removeClass('col-lg-9');
          $('#jqxDataTable').fadeIn(1000).addClass('col-lg-12');
        }
    }

  function iconos(ele){
      switch(ele) {
          case 'xls':
              return 'fa-file-excel-o';
              break;
          case 'xlsx':
              return 'fa-file-excel-o';
              break;
          case 'doc':
              return 'fa-file-word-o';
              break;
          case 'docx':
              return 'fa-file-word-o';
              break;
          case 'txt':
              return 'fa-file-text-o';
              break;
          case 'ppt':
              return 'fa-file-powerpoint-o';
              break;
          case 'pptx':
              return 'fa-file-powerpoint-o';
              break;
          case 'rar':
              return 'fa-file-zip-o';
              break;
          case 'zip':
              return 'fa-file-zip-o';
              break;
          case 'pdf':
              return 'fa-file-pdf-o';
              break;
          case 'jpg':
              return 'fa-file-image-o';
              break;
          case 'jpgeg':
              return 'fa-file-image-o';
              break;
          case 'png':
              return 'fa-file-image-o';
              break;
          case 'gif':
              return 'fa-file-image-o';
              break;
          default:
              return 'fa-file-o';
      }
  }




  </script>
@endpush
