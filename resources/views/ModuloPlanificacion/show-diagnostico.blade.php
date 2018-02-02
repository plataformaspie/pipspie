@extends('layouts.moduloplanificacion')

@section('header')
  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
  <link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

<style media="screen">
.popup-basic {
  position: relative;
  background: #FFF;
  width: auto;
  max-width: 900px;
  margin: 40px auto;
}
.icon-danger {
    color: #E63F24;
}
.icon-primary {
    color: #5BC24C;
}
.icon-warning {
    color: #F5B025;
}
##.admin-form .panel-heading{
    background-color: #fafafa;
    border-color: transparent -moz-use-text-color #ddd;
    border-radius: 0;
    border-style: solid none;
    border-width: 1px 0;
    color: #999;
    height: auto;
    overflow: hidden;
    padding: 3px 15px 2px;
    position: relative;
}

</style>

@endsection

@section('title-topbar')
  <div class="topbar-left">
      <ol class="breadcrumb">
          <li class="crumb-active">
              <a href="dashboard.html">Diagnostico</a>
          </li>
          <li class="crumb-icon">
              <a href="/sistemasisgri/index">
                  <span class="glyphicon glyphicon-home"></span>
              </a>
          </li>
          <li class="crumb-link">
              <a href="/sistemasisgri/index">Home</a>
          </li>
          <li class="crumb-trail">Diagnóstico</li>
      </ol>
  </div>
  <div class="topbar-right">
      <div class="ml15 ib va-m" id="toggle_sidemenu_r">
          <a href="#" class="pl5"> <i class="fa fa-sign-in fs22 text-primary"></i>
              <span class="badge badge-hero badge-danger">3</span>
          </a>
      </div>
  </div>
@endsection

@section('content')
  <div class="tray tray-center p25 va-t posr">
      <!-- create new order panel -->
      <div class="panel mb25 mt5">
          <div class="panel-heading">
              <span class="panel-title"> Diagnóstico valores </span>
          </div>


          <div class="panel-body p20 pb10">
              <div class="tab-content pn br-n admin-form">
                  <!--button id="nuevo" type="button" class="btn btn-success m5"><i class="glyphicons glyphicons-circle_plus"></i> </button-->
                  <button id="nuevo" type="button" class="btn btn-default m5"><i class="fa fa-edit icon-primary"></i> Agregar</button>
                  <button id="editar" type="button" class="btn btn-default m5"><i class="fa fa-edit icon-warning"></i> Editar</button>
                  <button id="eliminar" type="button" class="btn btn-default m5"><i class="glyphicons glyphicons-bin icon-danger"></i> Eliminar </button>

                  <div id="dataTable"></div>

              </div>
          </div>


      </div>
  </div>
  <!-- Admin Form Popup -->
  <div id="modal-nuevo"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Agregar variable</span>
          </div>
          <!-- end .panel-heading section -->
          <form method="post" action="/" id="form-nuevo" name="form-nuevo">
            {{ csrf_field() }}

              <div class="panel-body mnw700 of-a">
                  <div class="row">

                      <!-- Chart Column -->
                      <div class="col-md-6 pln br-r mvn15">
                          <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Datos <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>

                          <div class="section">
                              <label class="field-label" for="username">Variable</label>
                              <label for="variable" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="variable" name="variable"  placeholder="Nombre de Variable..." rows="2"></textarea>
                                  <label for="variable" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                                  </label>
                              </label>
                          </div>

                          <div class="section">
                            <label class="field-label" for="username">Indicador</label>
                              <label for="indicador" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="indicador" name="indicador" placeholder="Nombre del Indicador..." rows="2"></textarea>
                                  <label for="indicador" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                  </label>
                              </label>
                          </div>
                          <div class="section">
                            <label class="field-label" for="username">Unidad de Medida</label>
                                 <label for="unidad" class="field ">
                                    <select id="unidad" name="unidad" class="field prepend-icon" style="width:100%;">
                                        @foreach($metricas as $m)
                                          @if( $m->id == 0)
                                            <option value="{{$m->id}}" selected> {{$m->simbolo}} </option>
                                          @else
                                            <option value="{{$m->id}}"> {{$m->simbolo}} </option>
                                          @endif
                                        @endforeach
                                    </select>
                                  </label>
                          </div>
                      </div>


                      <!-- Icon Column -->
                      <div class="col-md-6 ">
                          <h5 class="mt5 ph10 pb5 br-b fw700">Evolución <small class="pull-right fw700 text-primary">- </small> </h5>
                          <table class="table mbn">
                              <thead>
                                  <tr class="hidden">
                                      <th class="mw30">#</th>
                                      <th>First Name</th>
                                      <th>Revenue</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td class="fs17 text-center w30">
                                        <span class="fa fa-newspaper-o text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">2011</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="dato_2011" class="field prepend-icon">
                                            <input type="text" name="dato_2011" id="dato_2011" class="gui-input" placeholder="Valor">
                                            <label for="dato_2011" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                        <span class="fa fa-newspaper-o text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">2012</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="dato_2012" class="field prepend-icon">
                                            <input type="text" name="dato_2012" id="dato_2012" class="gui-input" placeholder="Valor">
                                            <label for="dato_2012" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                          <span class="fa fa-newspaper-o text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">2013</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="dato_2013" class="field prepend-icon">
                                            <input type="text" name="dato_2013" id="dato_2013" class="gui-input" placeholder="Valor">
                                            <label for="dato_2013" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                          <span class="fa fa-newspaper-o text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">2014</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="dato_2014" class="field prepend-icon">
                                            <input type="text" name="dato_2014" id="dato_2014" class="gui-input" placeholder="Valor">
                                            <label for="dato_2014" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                        <span class="fa fa-newspaper-o text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">2015</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="dato_2015" class="field prepend-icon">
                                            <input type="text" name="dato_2015" id="dato_2015" class="gui-input" placeholder="Valor">
                                            <label for="dato_2015" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>



              <div class="panel-footer">
                  <button type="submit" class="button btn-primary">Validar y Guardar</button>
              </div>

          </form>
      </div>
      <!-- end: .panel -->
  </div>
  <!-- end: .admin-form -->

  <!-- Admin Form Popup -->
  <div id="modal-editar"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Modificar variable</span>
          </div>
          <!-- end .panel-heading section -->
          <form method="post" action="/" id="form-edit" name="form-edit">
            {{ csrf_field() }}

              <input type="hidden" name="mod_id" id="mod_id" value="">



              <div class="panel-body mnw700 of-a">
                  <div class="row">

                      <!-- Chart Column -->
                      <div class="col-md-6 pln br-r mvn15">
                          <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Datos <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>

                          <div class="section">
                              <label class="field-label" for="username">Variable</label>
                              <label for="mod_variable" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="mod_variable" name="mod_variable"  placeholder="Nombre de Variable..." rows="2"></textarea>
                                  <label for="mod_variable" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                                  </label>
                              </label>
                          </div>

                          <div class="section">
                            <label class="field-label" for="username">Indicador</label>
                              <label for="mod_indicador" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="mod_indicador" name="mod_indicador" placeholder="Indicador..." rows="2"></textarea>
                                  <label for="mod_indicador" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                  </label>
                              </label>
                          </div>
                          <div class="section">
                            <label class="field-label" for="username">Unidad de Medida</label>
                                 <label for="mod_unidad" class="field ">
                                    <select id="mod_unidad" name="mod_unidad" class="field prepend-icon" style="width:100%;">
                                        @foreach($metricas as $m)
                                          <option value="{{$m->id}}"> {{$m->simbolo}} </option>
                                        @endforeach
                                    </select>
                                  </label>
                          </div>
                      </div>


                      <!-- Icon Column -->
                      <div class="col-md-6 ">
                          <h5 class="mt5 ph10 pb5 br-b fw700">Evolución <small class="pull-right fw700 text-primary">- </small> </h5>
                          <table class="table mbn">
                              <thead>
                                  <tr class="hidden">
                                      <th class="mw30">#</th>
                                      <th>First Name</th>
                                      <th>Revenue</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td class="fs17 text-center w30">
                                        <span class="fa fa-newspaper-o text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">2011</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="mod_dato" class="field prepend-icon">
                                            <input type="text" name="mod_dato_2011" id="mod_dato_2011" class="gui-input" placeholder="Valor">
                                            <label for="mod_dato" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                        <span class="fa fa-newspaper-o text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">2012</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="mod_dato" class="field prepend-icon">
                                            <input type="text" name="mod_dato_2012" id="mod_dato_2012" class="gui-input" placeholder="Valor">
                                            <label for="mod_dato" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                          <span class="fa fa-newspaper-o text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">2013</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="mod_dato" class="field prepend-icon">
                                            <input type="text" name="mod_dato_2013" id="mod_dato_2013" class="gui-input" placeholder="Valor">
                                            <label for="mod_dato" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                          <span class="fa fa-newspaper-o text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">2014</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="mod_dato" class="field prepend-icon">
                                            <input type="text" name="mod_dato_2014" id="mod_dato_2014" class="gui-input" placeholder="Valor">
                                            <label for="mod_dato" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                        <span class="fa fa-newspaper-o text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">2015</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="mod_dato" class="field prepend-icon">
                                            <input type="text" name="mod_dato_2015" id="mod_dato_2015" class="gui-input" placeholder="Valor">
                                            <label for="mod_dato" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>



              <div class="panel-footer">
                  <button type="submit" class="button btn-primary">Validar y Guardar</button>
              </div>

          </form>
      </div>
      <!-- end: .panel -->
  </div>
  <!-- end: .admin-form -->

@endsection

@push('script-head')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcore.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxbuttons.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxscrollbar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdata.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdatatable.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdraw.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxchart.core.js') }} "></script>

  <script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
  <script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
        activarMenu('1','3');
        $(document).keydown(function(tecla){
              if (tecla.keyCode == 113) {

                var rowindex = $('#dataTable').jqxDataTable('getSelection');
                if (rowindex.length > 0)
                {
                    var rowData = rowindex[0];
                    $.ajax({
                            url: "{{ url('/api/moduloplanificacion/dataSetDiagnostico') }}",
                            type: "GET",
                            dataType: 'json',
                            data:{'id':rowData.id},
                            success: function(data){
                                $("#form-edit em").remove();
                                $("#mod_unidad").val(data.diagnostico.unidad).trigger('change');
                                $('input[name="mod_id"]').val(data.diagnostico.id);
                                $('textarea[name="mod_variable"]').val(data.diagnostico.variable);
                                $('textarea[name="mod_indicador"]').val(data.diagnostico.indicador);
                                //$('input[name="mod_cod_p"]').val(data.cod_p);

                                $.each(data.evolucion, function (index, item) {
                                      $('#mod_dato_'+item.gestion).val(item.dato);
                                });
                            },
                            error:function(data){
                              console("Error recuperar los datos.");
                            }
                    });



                    // Inline Admin-Form example
                    $.magnificPopup.open({
                        removalDelay: 500, //delay removal by X to allow out-animation,
                        focus: '#focus-blur-loop-select',
                        items: {
                            src: "#modal-editar"
                        },
                        // overflowY: 'hidden', //
                        callbacks: {
                            beforeOpen: function(e) {
                                var Animation = "mfp-zoomOut";
                                this.st.mainClass = Animation;
                            }
                        },
                        midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                    });
                }else {
                    alert("Seleccione el registro a modificar.");
                }

              }
        });
        $("#mod_unidad").select2({
          placeholder: "Seleccione Unidad de Medida"
        });
        $("#unidad").select2({
          placeholder: "Seleccione Unidad de Medida"
        });

        var url = '{{ url('api/moduloplanificacion/setDiagnostico') }}';
        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'contador', type: 'int' },
                { name: 'entidad', type: 'int' },
                { name: 'indicador', type: 'string' },
                { name: 'fuente_verificacion', type: 'string' },
                { name: 'variable', type: 'string' },
                { name: 'simbolo', type: 'string' },
                { name: 'grafica', type: 'int' },
                { name: '2011', type: 'string' },
                { name: '2012', type: 'string' },
                { name: '2013', type: 'string' },
                { name: '2014', type: 'string' },
                { name: '2015', type: 'string' },
                { name: 'grafica'},

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
            columns: [
              { text: '#', dataField: 'contador' },
              { text: 'Variable', dataField: 'variable',width: 300 },
              { text: 'Indicador', dataField: 'indicador',width: 300 },
              //{ text: 'Unidad de Medida', dataField: 'simbolo', width: 100,cellsAlign: 'center' },
              { text: '2011', dataField: '2011',cellsAlign: 'center', width: 100 },
              { text: '2012', dataField: '2012',cellsAlign: 'center', width: 100 },
              { text: '2013', dataField: '2013',cellsAlign: 'center', width: 100 },
              { text: '2014', dataField: '2014',cellsAlign: 'center', width: 100 },
              { text: '2015', dataField: '2015',cellsAlign: 'center', width: 100 },
              {
                text: 'Gráfica', align: 'center', dataField: 'grafica',
                cellsRenderer: function (row, column, value, rowData) {
                    var div = "<div id=sparklineContainer" + row + " style='margin: 0px; margin-bottom: 0px; width: 100%; height: 40px;'></div>";
                    return div;
                }
             }
          ],
          rendering: function () {
              if ($(".jqx-chart").length > 0) {
                  $(".jqx-chart").jqxChart('destroy');
              }
          },
          rendered: function () {
              for (var i = 0; i < dataAdapter.records.length; i++) {
                  createSparkline('#sparklineContainer' + i, dataAdapter.records[i].grafica,'area');
              }
          }
        });

        function createSparkline(selector, data, type)
            {
                var settings = {
                    title: '',
                    description: '',
                    showLegend: false,
                    enableAnimations: true,
                    showBorderLine: false,
                    showToolTips: false,
                    backgroundColor: 'transparent',
                    padding: { left: 0, top: 0, right: 0, bottom: 0 },
                    titlePadding: { left: 0, top: 0, right: 0, bottom: 0 },
                    source: data,
                    xAxis:
                    {
                        visible: false,
                        valuesOnTicks: false
                    },
                    colorScheme: 'scheme01',
                    seriesGroups:
                        [
                           {
                               type: type,
                               columnsGapPercent: 50,
                               columnsMaxWidth: 50,

                               valueAxis:
                               {
                                    minValue: 0,
                                    visible: false
                               },
                               series: [

                                        {
                                            linesUnselectMode: 'click',
                                            //lineWidth: 1,
                                            colorFunction: '#4A89DC',
                                            //displayText: 'Price per kWh',
                                            //showLabels: true,
                                            symbolType: 'circle'
                                        }
                                    ]
                            }
                        ]
                };

                $(selector).jqxChart(settings);
            } // createSparkline

            $('#nuevo').on('click', function(event) {
                  $(".state-error").removeClass("state-error")
                  $("#form-nuevo em").remove();
                  // Inline Admin-Form example
                  $.magnificPopup.open({
                      removalDelay: 500, //delay removal by X to allow out-animation,
                      focus: '#focus-blur-loop-select',
                      items: {
                          src: "#modal-nuevo"
                      },
                      // overflowY: 'hidden', //
                      callbacks: {
                          beforeOpen: function(e) {
                              var Animation = "mfp-zoomOut";
                              this.st.mainClass = Animation;
                          }
                      },
                      midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                  });

            });

            $('#editar').on('click', function(event) {
              var rowindex = $('#dataTable').jqxDataTable('getSelection');
              if (rowindex.length > 0)
              {
                  var rowData = rowindex[0];
                  $.ajax({
                          url: "{{ url('/api/moduloplanificacion/dataSetDiagnostico') }}",
                          type: "GET",
                          dataType: 'json',
                          data:{'id':rowData.id},
                          success: function(data){
                              $("#form-edit em").remove();
                              $("#mod_unidad").val(data.diagnostico.unidad).trigger('change');
                              $('input[name="mod_id"]').val(data.diagnostico.id);
                              $('textarea[name="mod_variable"]').val(data.diagnostico.variable);
                              $('textarea[name="mod_indicador"]').val(data.diagnostico.indicador);
                              //$('input[name="mod_cod_p"]').val(data.cod_p);

                              $.each(data.evolucion, function (index, item) {
                                    $('#mod_dato_'+item.gestion).val(item.dato);
                              });
                          },
                          error:function(data){
                            console("Error recuperar los datos.");
                          }
                  });



                  // Inline Admin-Form example
                  $.magnificPopup.open({
                      removalDelay: 500, //delay removal by X to allow out-animation,
                      focus: '#focus-blur-loop-select',
                      items: {
                          src: "#modal-editar"
                      },
                      // overflowY: 'hidden', //
                      callbacks: {
                          beforeOpen: function(e) {
                              var Animation = "mfp-zoomOut";
                              this.st.mainClass = Animation;
                          }
                      },
                      midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                  });
              }else {
                  swal("Seleccione el registro que modificara.");
              }
            });

            $('#eliminar').on('click', function(event) {
              var rowindex = $('#dataTable').jqxDataTable('getSelection');
              if (rowindex.length > 0)
              {

                swal({
                  title: "Está seguro?",
                  text: "No podrá recuperar este registro!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Si, eliminar!",
                  closeOnConfirm: false
                }, function(){
                    var rowData = rowindex[0];
                    $.ajax({
                            url: "{{ url('/api/moduloplanificacion/deleteDiagnostico') }}",
                            type: "GET",
                            dataType: 'json',
                            data:{'id':rowData.id},
                            success: function(data){
                              new PNotify({
                                  title: data.title,
                                  text: data.msg,
                                  shadow: true,
                                  opacity: 1,
                                  addclass: noteStack,
                                  type: "success",
                                  stack: Stacks[noteStack],
                                  width: findWidth(),
                                  delay: 1400
                              });
                              $("#dataTable").jqxDataTable("updateBoundData");
                              swal("Eliminado!", "Se ha eliminado tu registro.", "success");
                            },
                            error:function(data){
                              new PNotify({
                                  title: data.title,
                                  text: data.msg,
                                  shadow: true,
                                  opacity: 1,
                                  addclass: noteStack,
                                  type: "danger",
                                  stack: Stacks[noteStack],
                                  width: findWidth(),
                                  delay: 1400
                              });
                            }
                    });
                });








              }else {
                  swal("Seleccione el registro que eliminara.");
              }
            });

            /* @custom validation method (smartCaptcha)
            ------------------------------------------------------------------ */
            $( "#form-edit" ).validate({

                    /* @validation states + elements
                    ------------------------------------------- */

                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    /* @validation rules
                    ------------------------------------------ */

                    rules: {
                            mod_variable: {
                                    required: true
                            },
                            mod_indicador:  {
                                    required: true
                            },
                            mod_unidad: {
                                    required: true
                            }


                    },

                    /* @validation error messages
                    ---------------------------------------------- */

                    messages:{
                            mod_variable: {
                                    required: 'Ingresar la Variable'
                            },
                            mod_indicador:  {
                                    required: 'Ingresar el Indicador'
                            },
                            mod_unidad:  {
                                    required: 'Por favor, selecciones una opcion'
                            }

                    },

                    /* @validation highlighting + error placement
                    ---------------------------------------------------- */

                    highlight: function(element, errorClass, validClass) {
                            $(element).closest('.field').addClass(errorClass).removeClass(validClass);
                    },
                    unhighlight: function(element, errorClass, validClass) {
                            $(element).closest('.field').removeClass(errorClass).addClass(validClass);
                    },
                    errorPlacement: function(error, element) {
                       if (element.is(":radio") || element.is(":checkbox")) {
                                element.closest('.option-group').after(error);
                       } else {
                                error.insertAfter(element.parent());
                       }
                    },
                    submitHandler: function(form) {
                      saveFormEdit();
                    }


            });

            $( "#form-nuevo" ).validate({

                    /* @validation states + elements
                    ------------------------------------------- */

                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    /* @validation rules
                    ------------------------------------------ */

                    rules: {
                            variable: {
                                    required: true
                            },
                            indicador:  {
                                    required: true
                            },
                            unidad: {
                                    required: true
                            }


                    },

                    /* @validation error messages
                    ---------------------------------------------- */

                    messages:{
                            variable: {
                                    required: 'Ingresar la Variable'
                            },
                            indicador:  {
                                    required: 'Ingresar el Indicador'
                            },
                            unidad:  {
                                    required: 'Por favor, selecciones una opcion'
                            }

                    },

                    /* @validation highlighting + error placement
                    ---------------------------------------------------- */

                    highlight: function(element, errorClass, validClass) {
                            $(element).closest('.field').addClass(errorClass).removeClass(validClass);
                    },
                    unhighlight: function(element, errorClass, validClass) {
                            $(element).closest('.field').removeClass(errorClass).addClass(validClass);
                    },
                    errorPlacement: function(error, element) {
                       if (element.is(":radio") || element.is(":checkbox")) {
                                element.closest('.option-group').after(error);
                       } else {
                                error.insertAfter(element.parent());
                       }
                    },
                    submitHandler: function(form) {
                      saveFormNew();
                    }


            });


    });
    function saveFormNew(){

    var formData = new FormData($("#form-nuevo")[0]);
      $.ajax({
              url: "{{ url('/api/moduloplanificacion/saveDataNew') }}",
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function(data){
                  new PNotify({
                      title: data.title,
                      text: data.msg,
                      shadow: true,
                      opacity: 1,
                      addclass: noteStack,
                      type: "success",
                      stack: Stacks[noteStack],
                      width: findWidth(),
                      delay: 1400
                  });
                  $("#dataTable").jqxDataTable("updateBoundData");
                  $("#form-nuevo")[0].reset();
              },
              error:function(data){
                  new PNotify({
                      title: data.title,
                      text: data.msg,
                      shadow: true,
                      opacity: 1,
                      addclass: noteStack,
                      type: "danger",
                      stack: Stacks[noteStack],
                      width: findWidth(),
                      delay: 1400
                  });
              }
      });
    }

    function saveFormEdit(){

    var formData = new FormData($("#form-edit")[0]);
      $.ajax({
              url: "{{ url('/api/moduloplanificacion/saveDataEdit') }}",
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function(data){
                  new PNotify({
                      title: data.title,
                      text: data.msg,
                      shadow: true,
                      opacity: 1,
                      addclass: noteStack,
                      type: "success",
                      stack: Stacks[noteStack],
                      width: findWidth(),
                      delay: 1400
                  });
                  $("#dataTable").jqxDataTable("updateBoundData");
              },
              error:function(data){
                  new PNotify({
                      title: data.title,
                      text: data.msg,
                      shadow: true,
                      opacity: 1,
                      addclass: noteStack,
                      type: "danger",
                      stack: Stacks[noteStack],
                      width: findWidth(),
                      delay: 1400
                  });
              }
      });
    }

  </script>

@endpush
