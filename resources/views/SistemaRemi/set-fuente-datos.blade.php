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
  <div id="option1">
      <div class="row bg-title">
          <!-- .page title -->
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Lista de Fuente de Datos</h4>
          </div>
          <!-- /.page title -->
          <!-- .breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/sistemaremi/index') }}">Fuente Datos</a></li>
                  <li class="active">Lista de Fuente de Datos</li>
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
  </div>
  <div id="option2" class="hidden">
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
      <div class="col-sm-12">
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
                              <i class="ti-minus"></i> Método de cálculo
                            </a>
                          </div>
                      </div>

                      <div class="panel-wrapper collapse in" aria-expanded="true">
                          <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Formula de cálculo</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p><textarea name="name" rows="4" style="width:100%" readonly disabled></textarea></p>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                      <br/>
                                    </div>
                                    <div class="col-lg-12">
                                        <h5><b>Parámetros de la formula</b></h5>
                                        <hr/>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Numerador</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: </p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Fuente del numerador</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: </p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Denominador</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: </p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Fuente del denominador</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: </p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Observaciones a la fuente de datos</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: </p>
                                    </div>
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
    $(document).ready(function(){

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
          //filterMode: 'advanced',
          pageable: true,
          pagerButtonsCount: 10,
          localization: getLocalization('es'),
          pageSize: 50,
          columns: [
            { text: 'Codigo', dataField: 'codigo', width: 120, cellsAlign: 'center' },
            { text: 'Nombre fuente', minWidth: 200,dataField: 'nombre' },
            { text: 'Tipo', width: 150,dataField: 'tipo' },
            { text: 'Responsable', width: 200, dataField: 'responsable_nivel_1' },
            { text: 'Opciones', width: 120,
                  cellsRenderer: function (row, column, value, rowData) {
                          var abm = "<div style='margin: 5px; margin-bottom: 3px;'>";
                          var inputShow = '<button onclick="btn_show('+rowData.id+')" class="btn btn-sm btn-info "><span>Ver</span> <i class="fa fa-eye m-l-5"></i></button>';
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
      });

    });
    var show_panel = function(){
       $('#option2').removeClass('hidden');
       $('#option1').removeClass('show');
       $('#option1').addClass('hidden');
    };


    var btn_show = function(){
       show_panel();
    };
  </script>
@endpush
