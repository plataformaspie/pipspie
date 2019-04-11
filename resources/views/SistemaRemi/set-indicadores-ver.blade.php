@extends('layouts.sistemaremi')

@section('header')
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}"  type="text/css" />
  <link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">


  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />
  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.darkblue.css') }} " type="text/css" />

@endsection

@section('content')
  <div id="option1"><!--opcion 1-->
      <div class="row bg-title">
          <!-- .page title -->
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Lista de Indicadores de Datos</h4>
          </div>
          <!-- /.page title -->
          <!-- .breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/sistemaremi/index') }}">Indicadores Datos</a></li>
                  <li class="active">Lista de Indicadores de Datos</li>
              </ol>
          </div>
          <!-- /.breadcrumb -->
      </div>
      <!-- .row -->
      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse ">
                <div class="panel-heading"> Lista
                    <div class="pull-right">
                        <a href="#" data-perform="panel-collapse">
                          <i class="ti-minus"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <div id="dataTable"></div>
                    </div>
                </div>
            </div>

        </div>
      </div>
  </div><!--fin opcion 1-->
  <div id="option2" class="hidden"><!-- opcion 2-->
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Detalle de la Fuente de Datos</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/sistemaremi/index') }}">Fuente Datos</a></li>
                <li class="active">Detalle fuente de datos</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
    <!-- .row -->
    <div class="row">
      <div class="col-md-3"><!--iNFORMACION IZQUIERDA-->
          <div class="row" style="margin-right:6px;margin-left:6px;" > <!--style="padding-right: 0px;padding-top: 0px;padding-left: 0px;"-->
              <div class="panel panel-success" style="border: 1px solid transparent;border-color: #d6e9c6;width:100%">
                  <div class="panel-heading panel-heading-c2" style="color: #fff; background-color: #468E9B;border-color: #d6e9c6;"><b> Titulo de la Fuente de Datos:</b></div>
                  <div class="panel-wrapper collapse in" aria-expanded="true">
                      <div class="panel-body text-left">
                          <p><label id="nombre" style="color:#000000;font-weight: bold;"></label></p>
                      </div>
                  </div>
              </div>
          </div>

          <div class="row" style="margin-right:6px;margin-left:6px;" > <!--style="padding-right: 0px;padding-top: 0px;padding-left: 0px;"-->
              <div class="panel panel-success" style="border: 1px solid transparent;border-color: #d6e9c6;width:100%">
                  <div class="panel-heading panel-heading-c2" style="color: #3c763d; background-color: #dff0d8;border-color: #d6e9c6;"> Documentos respaldo </div>
                  <div class="panel-wrapper collapse in" aria-expanded="true">
                    <table id="datosARC" class="table table-hover">
                       <thead>
                           <tr>
                            <th>-</th>
                          </tr>
                      </thead>
                      <tbody >

                      </tbody>
                    </table>

                  </div>
              </div>
          </div>
          <div class="row" style="margin-right:6px;margin-left:6px;" > <!--style="padding-right: 0px;padding-top: 0px;padding-left: 0px;"-->
              <div class="panel panel-success" style="border: 1px solid transparent;border-color: #d6e9c6;width:100%">
                  <div class="panel-heading panel-heading-c2" style="color: #3c763d; background-color: #dff0d8;border-color: #d6e9c6;"> Obtener fuente </div>
                  <div class="panel-wrapper collapse in" aria-expanded="true">
                      <div class="panel-body text-center">


                          <a href="javascript:myFunction('You clicked!')"><i class="fa fa-file-excel-o"  style="font-size: 30px;" title="Descargar Metadato"></i> Metadato</a>


                          <!--Aqui hay que cambiar AQUI HAY QUE EMPEZAR AQUI EMPEZAR-->
                      </div>
                  </div>
              </div>
          </div>

      </div><!--FIN iNFORMACION IZQUIERDA-->
      <div class="col-sm-9 center"><!--iNFORMACION DERECHA-->
          <div class="white-box">
              <h3 class="box-title m-b-0">Información de Fuente de Datos</h3>
              <p class="text-muted m-b-30">
                <button id ="btn-back" type="button" class="btn btn-info btn-circle btn-lg" style="float: right;margin-top: -26px;">
                  <i class="fa fa-arrow-left"></i>
                </button>
              </p>
              <div class="col-lg-12 col-sm-12">
                  <div class="panel panel-success">
                      <div class="panel-heading" style="background-color: #468E9B;">

                          <div class="pull-left" style="margin-top: -9px;">
                            <a href="#" data-perform="panel-collapse">
                              <i class="ti-minus"></i> Identificación
                            </a>
                          </div>
                      </div>

                      <div class="panel-wrapper collapse in" aria-expanded="true">
                          <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Abreviación</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="acronimo"></span></p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Tipo</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="tipo"></span> </p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Objetivo</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="objetivo"></span></p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Serie disponible</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="serie_datos"></span></p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Periodicidad</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="periodicidad"></span></p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Variables/Campos clave</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="variable"></span></p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Modo de recolección de Datos</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="modo_recoleccion_datos"></span>
                                           <br/>
                                           <span id="modo_recoleccion_datos_otro" class="tagHidden hidden"></span>
                                      </p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Unidad de análisis</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="unidad_analisis"></span></p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Universo de estudio</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="universo_estudio"></span></p>
                                    </div>
                              </div>
                              <div class="tagHidden row encuesta hidden">
                                      <div class="col-lg-4 col-sm-6">
                                        <b>Diseño y tamaño de muestra</b>
                                      </div>
                                      <div class="col-lg-8 col-sm-6">
                                        <p>: <span id="disenio_tamanio_muestra"></span></p>
                                      </div>

                                      <div class="col-lg-4 col-sm-6">
                                        <b>Tasa de respuesta</b>
                                      </div>
                                      <div class="col-lg-8 col-sm-6">
                                        <p>: <span id="tasa_respuesta"></span></p>
                                      </div>

                               </div>
                              <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Observaciones</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="observacion"></span></p>
                                    </div>
                                </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-12 col-sm-12">
                  <div class="panel panel-success">
                      <div class="panel-heading" style="background-color: #468E9B;">

                          <div class="pull-left" style="margin-top: -9px;">
                            <a href="#" data-perform="panel-collapse">
                              <i class="ti-minus"></i> Categoria Temática
                            </a>
                          </div>
                      </div>

                      <div class="panel-wrapper collapse in" aria-expanded="true">
                          <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Demografia y estadisticas sociales</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="demografia_estadistica_social"></span>
                                           <br/>
                                           <span id="demografia_estadistica_social_otro" class="tagHidden hidden"></span>
                                      </p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Estadisticas Económicas</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="estadistica_economica"></span>
                                           <br/>
                                           <span id="estadistica_economica_otro" class="tagHidden hidden"></span>
                                      </p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Estadisticas Medioambientales</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="estadistica_medioambiental"></span>
                                           <br/>
                                           <span id="estadistica_medioambiental_otro" class="tagHidden hidden"></span>
                                      </p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Informacion Geoespacial</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="informacion_geoespacial"></span>
                                           <br/>
                                           <span id="informacion_geoespacial_otro" class="tagHidden hidden"></span>
                                      </p>
                                    </div>

                                </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-12 col-sm-12">
                  <div class="panel panel-success">
                      <div class="panel-heading" style="background-color: #468E9B;">

                          <div class="pull-left" style="margin-top: -9px;">
                            <a href="#" data-perform="panel-collapse">
                              <i class="ti-minus"></i> Cuestionarios y Formularios
                            </a>
                          </div>
                      </div>

                      <div class="panel-wrapper collapse in" aria-expanded="true">
                          <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Cantidad de Cuestionarios/Formularios</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="numero_total_formulario"></p>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                      <br/>
                                    </div>
                                    <div class="col-lg-12">
                                        <h5><b>Detalle de Formularios</b></h5>
                                        <hr/>
                                    </div>
                                    <table id="datosForm" class="table table-hover">
                                       <thead>
                                           <tr>
                                            <th style="width:30%">-</th>
                                            <th>Nombre</th>
                                          </tr>
                                      </thead>
                                      <tbody>

                                      </tbody>
                                    </table>


                                </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-12 col-sm-12">
                  <div class="panel panel-success">
                      <div class="panel-heading" style="background-color: #468E9B;">

                          <div class="pull-left" style="margin-top: -9px;">
                            <a href="#" data-perform="panel-collapse">
                              <i class="ti-minus"></i> Cobertura
                            </a>
                          </div>
                      </div>

                      <div class="panel-wrapper collapse in" aria-expanded="true">
                          <div class="panel-body">
                                <div class="tagHidden row registro hidden">
                                      <div class="col-lg-4 col-sm-6">
                                        <b>Cobertura del RRAA</b>
                                      </div>
                                      <div class="col-lg-8 col-sm-6">
                                        <p>:<span id="cobertura_rraa"></p>
                                        <p>:<span id="cobertura_rraa_descripcion"></p>
                                      </div>
                                </div>
                                <div class="row">


                                    <div class="col-lg-4 col-sm-6">
                                      <b>Cobertura Geográfica de la Fuente de Datos </b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="cobertura_geografica"></p>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                      <br/>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Nivel de Desagregación Geográfica </b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="nivel_representatividad_datos"></p>
                                    </div>

                                </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-12 col-sm-12">
                  <div class="panel panel-success">
                      <div class="panel-heading" style="background-color: #468E9B;">

                          <div class="pull-left" style="margin-top: -9px;">
                            <a href="#" data-perform="panel-collapse">
                              <i class="ti-minus"></i> Responsables
                            </a>
                          </div>
                      </div>

                      <div class="panel-wrapper collapse in" aria-expanded="true">
                          <div class="panel-body">
                            <div id="set_responsables" class="row">
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-12 col-sm-12">
                  <div class="panel panel-success">
                      <div class="panel-heading" style="background-color: #468E9B;">

                          <div class="pull-left" style="margin-top: -9px;">
                            <a href="#" data-perform="panel-collapse">
                              <i class="ti-minus"></i> Acceso a la Información
                            </a>
                          </div>
                      </div>

                      <div class="panel-wrapper collapse in" aria-expanded="true">
                          <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Confidencialidad</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="confidencialidad"></p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Notas legales</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <span id="notas_legales"></p>
                                    </div>
                                </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div><!--FIN iNFORMACION IZQUIERDA-->

    </div>
  </div><!-- fin opcion 2-->





@endsection

@push('script-head')
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










  <script type="text/javascript">
    var idSeleccionar = "";
    $(document).ready(function(){


      var url = '{{ url('api/sistemaremi/apiSetIndicadores') }}';
      // prepare the data
      var source =
      {
          dataType: "json",
          dataFields: [
              { name: 'id', type: 'int' },
              { name: 'estado_desc', type: 'string' },
              { name: 'etapa', type: 'string' },
              { name: 'nombre', type: 'string' },
              { name: 'codigo', type: 'string' }
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
          localization: getLocalization('es'),
          columns: [
            { text: 'Estado', dataField: 'estado_desc', width: 100, cellsAlign: 'center' },
            { text: 'Nombre Indicador', minWidth: 250,dataField: 'nombre' },
            { text: 'Etapa', width: 150,dataField: 'etapa' },
            { text: 'Codigo', width: 150, dataField: 'codigo' },
            { text: 'Opciones', width: 150,
                  cellsRenderer: function (row, column, value, rowData) {
                          var abm = "<div style='margin: 5px; margin-bottom: 3px;'>";
                          var inputShow = '<button onclick="btn_mostrar('+rowData.id+')" class="btn btn-sm btn-info "><span>Ficha</span> <i class="fa fa-eye m-l-5"></i></button>';
                          abm += inputShow;
                          abm += "</div>";
                          return abm;


                  }
            },
        ]
      });


      $('#btn-back, .btn-back').click(function() {
         $('#option1').removeClass('hidden');
         $('#option2').removeClass('show');
         $('#option2').addClass('hidden');
         $('.tagHidden').removeClass('hidden');
         $('.tagHidden').addClass('hidden');
         $("#datosARC > tbody").html("");
      });


    });
    var show_panel = function(){
       $('#option2').removeClass('hidden');
       $('#option1').removeClass('show');
       $('#option1').addClass('hidden');
    };


    var btn_mostrar = function(ele){
       var idSeleccionar = ele;
       location.href = '/sistemaremi/dataIndicador/'+ idSeleccionar;
    }



function myFunction(){
  //alert("hola desde el link" + idSeleccionar);
  location.href = '/api/sistemarime/descagarExcelMetadatosOnly/'+ idSeleccionar;

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
