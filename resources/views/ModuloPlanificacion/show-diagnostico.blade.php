@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/plugins/bower_components/select2/dist/css/select2.min.css" type="text/css"/>
<link rel="stylesheet" href="/plugins/bower_components/sweetalert/sweetalert.css" type="text/css">

<style media="screen">
.popup-basic {
  position: relative;
  background: #FFF;
  width: auto;
  max-width: 900px;
  margin: 40px auto;
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



@section('content')
  <!-- begin: .tray-left -->
  <aside class="tray tray-left tray225 va-t pn" data-tray-height="match">

    <div class="animated-delay p20" data-animate='["300","fadeIn"]'>
        <h4 class="mt5 mb20"> Información </h4>
        <ul class="fs14 list-unstyled list-spacing-10 mb10 pl5">
            <li>
             {{--    <i class="fa fa-exclamation-circle text-warning fa-lg pr10"></i>
                Llene la información solicitada por el sistema --}}
            </li>
        </ul>
    </div>
      <div id="nav-spy">
          <ul class="nav tray-nav tray-nav-border custom-nav-animation " data-spy="affix" data-offset-top="200" style="width: 225px" >
              <li class="active">
                  <a href="#spy1">
                    <span class="fa fa-check fa-lg"></span>  Diagnóstico</a>
              </li>
              <li>
                  <a href="#spy2">
                    <span class="fa fa-check fa-lg"></span>  Sistemas de Vida</a>
              </li>
              <li>
                  <a href="#spy3">
                    <span class="fa fa-check fa-lg"></span>  Gestion de Riesgos</a>
              </li>

          </ul>
      </div>

  </aside>
  <!-- end: .tray-left -->

  <!-- begin: .tray-center -->
  <div class="tray tray-center p40 va-t posr">

      <div class="row">
          <div class="col-md-12">
              <div class="panel panel-visible" id="spy1">
                  <div class="panel-heading bg-dark">
                      <div class="panel-title hidden-xs">
                         <span class="fa  fa-lightbulb-o"></span>Diagnóstico
                         <div class="pull-right">
                           <button id="nuevo"  class="btn btn-sm btn-success dark m5  br6"><i class="fa fa-plus-circle text-white"></i> Agregar variable</button>
                           <button id="editar"  class="btn btn-sm btn-warning dark m5 br6  "><i class="fa fa-edit text-white"></i> Editar</button>
                           <button id="eliminar"  class="btn btn-sm btn-danger dark m5 br6 "><i class="fa fa-minus-circle text-white"></i> Eliminar</button>
                         </div>
                      </div>
                  </div>
                  <div class="panel-body pn">
                      <div id="dataTable"></div>
                  </div>
              </div>
          </div>

          <div class="col-md-12">
              <div class="panel panel-visible" id="spy2">
                <div class="panel-heading bg-dark">
                    <div class="panel-title hidden-xs">
                       <span class="fa  fa-lightbulb-o"></span>Sistemas de Vida
                       <div class="pull-right">
                         <button id="nuevoSv"  class="btn btn-sm btn-success dark m5  br6"><i class="fa fa-plus-circle text-white"></i> Agregar</button>
                         <button id="editarSv"  class="btn btn-sm btn-warning dark m5 br6  "><i class="fa fa-edit text-white"></i> Editar</button>
                         <button id="eliminarSv"  class="btn btn-sm btn-danger dark m5 br6 "><i class="fa fa-minus-circle text-white"></i> Eliminar</button>
                       </div>
                    </div>
                </div>
                  <div class="panel-body pn">
                  </div>
              </div>
          </div>

          <div class="col-md-12">
              <div class="panel panel-visible" id="spy3">
                  <div class="panel-heading bg-dark">
                      <div class="panel-title hidden-xs">
                         <span class="fa  fa-lightbulb-o"></span>Riesgos
                         <div class="pull-right">
                           <button id="nuevoRi"  class="btn btn-sm btn-success dark m5  br6"><i class="fa fa-plus-circle text-white"></i> Agregar</button>
                           <button id="editarRi"  class="btn btn-sm btn-warning dark m5 br6  "><i class="fa fa-edit text-white"></i> Editar</button>
                           <button id="eliminarRi"  class="btn btn-sm btn-danger dark m5 br6 "><i class="fa fa-minus-circle text-white"></i> Eliminar</button>
                         </div>
                      </div>
                  </div>
                  <div class="panel-body pn">
                  </div>
              </div>
          </div>


      </div>

  </div>
  <!-- end: .tray-center -->


{{-- ============================================================================modal NUEVO =================================================================================== --}}
  <!-- Admin Form Popup -->
  <div id="modal-nuevo"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading bg-dark">
              <span class="panel-title text-white"><i class="fa fa-pencil"></i>Agregar variable</span>
          </div>
          <!-- end .panel-heading section -->
          <form method="post" action="/" id="form-nuevo" name="form-nuevo">
              <input type="hidden" name="id_plan" id="id_plan" value="">
              {{ csrf_field() }}
              <div class="panel-body mnw700 of-a">
                  <div class="row">

                      <!-- Chart Column -->
                      <div class="col-md-6 pln br-r mvn15">
                          <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Datos <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>
                          <div class="section">
                              <label class="field-label" for="producto_final">Producto final</label>
                              <label for="producto_final" class="field prepend-icon">
                                  <input class="gui-input" id="producto_final" name="producto_final"  placeholder="Producto final "></textarea>
                                  <label for="producto_final" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                  </label>
                              </label>
                          </div>

                          <div class="section">
                              <label class="field-label" for="variable">Variable</label>
                              <label for="variable" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="variable" name="variable"  placeholder="Nombre de Variable..." rows="2"></textarea>
                                  <label for="variable" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                                  </label>
                              </label>
                          </div>

                          <div class="section">
                            <label class="field-label" for="indicador">Indicador</label>
                              <label for="indicador" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="indicador" name="indicador" placeholder="Nombre del Indicador..." rows="2"></textarea>
                                  <label for="indicador" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                  </label>
                              </label>
                          </div>
                          <div class="section">
                              <label class="field-label" for="unidad">Unidad de medida</label>
                              <label for="unidad" class="field select ">
                                  <select id="unidad" name="unidad" class="required"  style="width:100%;">
                                      @foreach($metricas as $m)
                                          <option value="{{$m->id}}"> {{$m->codigo}} </option>                                
                                      @endforeach
                                  </select>
                                  <i class="arrow"> </i> 
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
                  <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
              </div>

          </form>
      </div>
      <!-- end: .panel -->
  </div>
  <!-- end: .admin-form -->

{{-- ============================================================================modal NUEVO =================================================================================== --}}
  <!-- Admin Form Popup -->
  <div id="modal-editar"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading bg-dark">
              <span class="panel-title text-white" ><i class="fa fa-pencil"></i>Modificar variable</span>
          </div>
          <!-- end .panel-heading section -->
          <form method="post" action="/" id="form-edit" name="form-edit">
              
  
              <input type="hidden" name="mod_id" id="mod_id" value="">
              <input type="hidden" name="mod_id_plan" id="mod_id_plan" value="">
              {{ csrf_field() }}

              <div class="panel-body mnw700 of-a">
                  <div class="row">

                      <!-- Chart Column -->
                      <div class="col-md-6 pln br-r mvn15">
                          <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Datos <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>
                          <div class="section">
                              <label class="field-label" for="mod_producto_final">Producto final</label>
                              <label for="mod_producto_final" class="field prepend-icon">
                                  <input class="gui-input" id="mod_producto_final" name="mod_producto_final"  placeholder="Producto final "></textarea>
                                  <label for="mod_producto_final" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                  </label>
                              </label>
                          </div>
                          <div class="section">
                              <label class="field-label" for="mod_variable">Variable</label>
                              <label for="mod_variable" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="mod_variable" name="mod_variable"  placeholder="Nombre de Variable..." rows="2"></textarea>
                                  <label for="mod_variable" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                                  </label>
                              </label>
                          </div>

                          <div class="section">
                            <label class="field-label" for="mod_indicador">Indicador</label>
                              <label for="mod_indicador" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="mod_indicador" name="mod_indicador" placeholder="Indicador..." rows="2"></textarea>
                                  <label for="mod_indicador" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                  </label>
                              </label>
                          </div>
                          <div class="section">
                            <label class="field-label" for="mod_unidad">Unidad de Medida</label>
                                 <label for="mod_unidad" class="field ">
                                    <select id="mod_unidad" name="mod_unidad" class="field prepend-icon" style="width:100%;">
                                        @foreach($metricas as $m)
                                          <option value="{{$m->id}}"> {{$m->codigo}} </option>
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
                  <a href="#"  id="atr_cancelar"  class="button btn-danger ml25 sp_cancelar">Cancelar</a>
              </div>

          </form>
      </div>
      <!-- end: .panel -->
  </div>
  <!-- end: .admin-form -->
@endsection

@push('script-head')




<script src="/plugins/bower_components/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdata.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdatatable.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdraw.js"></script>
<script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxchart.core.js "></script>
<script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>

<script type="text/javascript">
$(document).ready(function(){

    // $(document).keydown(function(tecla){
    //     if (tecla.keyCode == 113) {

    //         var rowindex = $('#dataTable').jqxDataTable('getSelection');
    //         if (rowindex.length > 0)
    //         {
    //             var rowData = rowindex[0];
    //             $.ajax({
    //                     url: "{{ url('/api/moduloplanificacion/dataSetDiagnostico') }}",
    //                     type: "GET",
    //                     dataType: 'json',
    //                     data:{'id':rowData.id},
    //                     success: function(data){
    //                         $("#form-edit em").remove();
    //                         $("#mod_unidad").val(data.diagnostico.unidad).trigger('change');
    //                         $('input[name="mod_id"]').val(data.diagnostico.id);
    //                         $('textarea[name="mod_variable"]').val(data.diagnostico.variable);
    //                         $('textarea[name="mod_indicador"]').val(data.diagnostico.indicador);
    //                         //$('input[name="mod_cod_p"]').val(data.cod_p);

    //                         $.each(data.evolucion, function (index, item) {
    //                               $('#mod_dato_'+item.gestion).val(item.dato);
    //                         });
    //                     },
    //                     error:function(data){
    //                         console("Error recuperar los datos.");
    //                     }
    //             });



    //             // Inline Admin-Form example
    //             $.magnificPopup.open({
    //                 removalDelay: 500, //delay removal by X to allow out-animation,
    //                 focus: '#focus-blur-loop-select',
    //                 items: {
    //                     src: "#modal-editar"
    //                 },
    //                 // overflowY: 'hidden', //
    //                 callbacks: {
    //                     beforeOpen: function(e) {
    //                         var Animation = "mfp-zoomIn";
    //                         this.st.mainClass = Animation;
    //                     }
    //                 },
    //                 midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
    //             });
    //         }else {
    //             alert("Seleccione el registro a modificar.");
    //         }

    //     }
    // });


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
            { name: 'producto_final', type: 'string' },
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
        url: '/api/moduloplanificacion/setDiagnostico'
    };

    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#dataTable").jqxDataTable(
    {
        source: dataAdapter,
        width:"100%",
        columnsResize: true,
        columns: [
            { text: '#', dataField: 'contador' },
            { text: 'Producto final', dataField: 'producto_final',width: 150 },
            { text: 'Variable', dataField: 'variable',width: 250 },
            { text: 'Indicador', dataField: 'indicador',width: 250 },
            //{ text: 'Unidad de Medida', dataField: 'simbolo', width: 100,cellsAlign: 'center' },
            { text: '2011', dataField: '2011',cellsAlign: 'center', width: 100 },
            { text: '2012', dataField: '2012',cellsAlign: 'center', width: 100 },
            { text: '2013', dataField: '2013',cellsAlign: 'center', width: 100 },
            { text: '2014', dataField: '2014',cellsAlign: 'center', width: 100 },
            { text: '2015', dataField: '2015',cellsAlign: 'center', width: 100 },
            {
                text: 'Gráfica', align: 'center', dataField: 'grafica',width: 300,
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
          $("#form-nuevo input:text, #form-nuevo textarea").val('');
          $(" #form-nuevo select").val('').change();
          
          $("#id_plan").val(globalSP.idPlanActivo);
          // Inline Admin-Form example
          $.magnificPopup.open({
              removalDelay: 500, //delay removal by X to allow out-animation,
              focus: '#producto_final',
              items: {
                  src: "#modal-nuevo"
              },
              // overflowY: 'hidden', //
              callbacks: {
                  beforeOpen: function(e) {
                      var Animation = "mfp-zoomIn";
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
                    $("#mod_id").val(data.diagnostico.id);
                    $("#id_plan").val(globalSP.idPlanActivo);
                    $("#mod_producto_final").val(data.diagnostico.producto_final);
                    $("#mod_variable").val(data.diagnostico.variable);
                    $("#mod_indicador").val(data.diagnostico.indicador);
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
                        var Animation = "mfp-zoomIn";
                        this.st.mainClass = Animation;
                    }
                },
                midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
            });
        }else {
            swal("Seleccione el registro para modificar.");
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
            swal("Seleccione el registro que desea eliminar.");
        }
    });


    $( "#form-edit" ).validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                    mod_producto_final: { required: true },
                    mod_variable: { required: true },
                    mod_indicador:  { required: true },
                    mod_unidad: { required: true }
            },

            messages:{
                    mod_producto_final: { required: 'Ingresar el producto final' },
                    mod_variable: { required: 'Ingresar la Variable' },
                    mod_indicador:  { required: 'Ingresar el Indicador' },
                    mod_unidad:  { required: 'Por favor, selecciones una opción' }

            },

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
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                    producto_final: { required: true },
                    variable: { required: true },
                    indicador:  { required: true },
                    unidad: { required: true }
            },

            messages:{
                    producto_final: { required: 'Ingresar el producto final' },
                    variable: { required: 'Ingresar la Variable' },
                    indicador:  { required: 'Ingresar el Indicador' },
                    unidad:  { required: 'Por favor, selecciones una opción' }
            },

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
                    $.magnificPopup.close(); 
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

    function saveFormEdit(){        var formData = new FormData($("#form-edit")[0]);
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
                  $.magnificPopup.close(); 
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

    $(".sp_cancelar").click((function(){
        $.magnificPopup.close(); 
    }))


    globalSP.activarMenu(globalSP.menu.Diagnostico);
    globalSP.cargarGlobales();
    globalSP.setBreadcrumb('Diagnóstico', 'Diagnóstico');

    //TODO: no sale el placeholder del select 2 y la validacion no funciona en estos select2 ????????????????????
    $("#mod_unidad").select2({
        placeholder: "Seleccione Unidad de Medida"
    });
    $("#unidad").select2({
        placeholder: "Seleccione Unidad de Medida",
        // dropdownParent: $('#modal-nuevo'),
        // cache: false,
        // language: "es",

    });


});
</script>

@endpush
