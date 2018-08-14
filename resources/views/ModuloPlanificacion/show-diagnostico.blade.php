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

.white-popup {
  position: relative;
  background: #FFF;
  width: auto;
  max-width:600px;
  margin: 20px auto;
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
                      <div id="dataTableSv"></div>
                  </div>
              </div>
          </div>

          <div class="col-md-12">
              <div class="panel panel-visible" id="spy3">
                  <<div class="panel-heading bg-dark">
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
                      <div id="dataTableRi"></div>
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
                                  <input class="gui-input" id="producto_final" name="producto_final"  placeholder="Producto final ">
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






  <!-- Admin Form Popup -->
  <div id="modal-sv"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading bg-dark">
              <span class="panel-title text-white"><i class="fa fa-pencil"></i>Sistema de Vida</span>
          </div>
          <!-- end .panel-heading section -->
          <form method="post" action="/" id="form-sv" name="form-sv">
              <input type="hidden" name="sv_id_plan" id="sv_id_plan" value="">
              <input type="hidden" name="sv_id_sis_vida" id="sv_id_sis_vida" value="">
              {{ csrf_field() }}
              <div class="panel-body mnw700 of-a">
                  <div class="row">

                      <!-- Chart Column -->
                      <div class="col-md-6 pln br-r mvn15">
                          <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Datos <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>
                          <div class="section">
                              <label class="field-label" for="sv_jurisdiccion_territorial">Jurisdiccion Territorial</label>
                              <label for="sv_jurisdiccion_territorial" class="field prepend-icon">
                                  <input class="gui-input" id="sv_jurisdiccion_territorial" name="sv_jurisdiccion_territorial"  placeholder="Jurisdiccion Territorial ">
                                  <label for="sv_jurisdiccion_territorial" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                  </label>
                              </label>
                          </div>

                          <div class="section">
                              <label class="field-label" for="sv_unidades_socioculturales">Unidades Socioculturales</label>
                              <label for="sv_unidades_socioculturales" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="sv_unidades_socioculturales" name="sv_unidades_socioculturales"  placeholder="Unidades Socioculturales..." rows="2"></textarea>
                                  <label for="sv_unidades_socioculturales" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                                  </label>
                              </label>
                          </div>
                          <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Descripción valores <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>
                          <div class="section">
                            <label class="field-label" for="sv_funciones_desc">Descripción valor Funciones ambientales</label>
                              <label for="sv_funciones_desc" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="sv_funciones_desc" name="sv_funciones_desc" placeholder="Descripción valor Funciones ambientales..." rows="1"></textarea>
                                  <label for="sv_funciones_desc" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                  </label>
                              </label>
                          </div>
                          <div class="section">
                            <label class="field-label" for="sv_sistemas_desc">Descripción valor Sistemas Productivos</label>
                              <label for="sv_sistemas_desc" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="sv_sistemas_desc" name="sv_sistemas_desc" placeholder="Descripción valor Sistemas Productivos..." rows="1"></textarea>
                                  <label for="sv_sistemas_desc" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                  </label>
                              </label>
                          </div>
                          <div class="section">
                            <label class="field-label" for="sv_pobreza_desc">Descripción valor Pobreza</label>
                              <label for="sv_pobreza_desc" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="sv_pobreza_desc" name="sv_pobreza_desc" placeholder="Descripción valor Pobreza..." rows="1"></textarea>
                                  <label for="sv_pobreza_desc" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                  </label>
                              </label>
                          </div>
                      </div>


                      <!-- Icon Column -->
                      <div class="col-md-6 ">
                          <h5 class="mt5 ph10 pb5 br-b fw700">Valores Triangulo de Equilibrio <small class="pull-right fw700 text-primary">- </small> </h5>
                          <table class="table mbn">
                              <thead>
                                  <tr class="hidden">
                                      <th class="mw30">#</th>
                                      <th></th>
                                      <th></th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td class="fs17 text-center w30">
                                        <span class="fa fa-arrow-circle-o-right text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">Funciones ambientales</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="sv_funciones_valor" class="field prepend-icon">
                                            <input type="text" name="sv_funciones_valor" id="sv_funciones_valor" class="gui-input valorSv" placeholder="Valor" value="0">
                                            <label for="sv_funciones_valor" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                        <span class="fa fa-arrow-circle-o-right text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">Sistemas productivos sutentables</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="sv_sistemas_valor" class="field prepend-icon">
                                            <input type="text" name="sv_sistemas_valor" id="sv_sistemas_valor" class="gui-input valorSv" placeholder="Valor" value="0">
                                            <label for="sv_sistemas_valor" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                          <span class="fa fa-arrow-circle-o-right text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">Pobreza</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="sv_pobreza_valor" class="field prepend-icon">
                                            <input type="text" name="sv_pobreza_valor" id="sv_pobreza_valor" class="gui-input valorSv" placeholder="Valor" value="0">
                                            <label for="sv_pobreza_valor" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>

                            <div id="containerTriangulo" style="min-width: 400px; max-width: 600px; height: 500px; margin: auto"></div>
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




  <!-- Admin Form Popup -->
  <div id="modal-ri"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide white-popup">
      <div class="panel">
          <div class="panel-heading bg-dark">
              <span class="panel-title text-white"><i class="fa fa-pencil"></i>Análisis de Riesgos</span>
          </div>
          <!-- end .panel-heading section -->
          <form method="post" action="/" id="form-ri" name="form-ri">
              <input type="hidden" name="ri_id_plan" id="ri_id_plan" value="">
              <input type="hidden" name="ri_id_riesgo" id="ri_id_riesgo" value="">
              {{ csrf_field() }}
              <div class="panel-body of-a">
                  <div class="row">

                      <!-- Chart Column -->
                      <div class="col-md-12 pln br-r mvn15">
                          <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Datos <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>
                          <div class="section">
                              <label class="field-label" for="ri_jurisdiccion_territorial">Jurisdiccion Territorial</label>
                              <label for="ri_jurisdiccion_territorial" class="field">
                                  <select id="ri_jurisdiccion_territorial" name="ri_jurisdiccion_territorial" style="width:100%;">
                                      @foreach($sistemasVida as $item)
                                          <option value="{{$item->jurisdiccion_territorial}}"> {{$item->jurisdiccion_territorial}} </option>
                                      @endforeach
                                  </select>
                                  <label for="ri_jurisdiccion_territorial" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                  </label>
                              </label>
                          </div>

                          <div class="section">
                              <label class="field-label" for="ri_sector">Sector</label>
                              <label for="ri_sector" class="field ">
                                  <select id="ri_sector" name="ri_sector" style="width:100%;">
                                      @foreach($sectores as $item)
                                          <option value="{{$item->id}}"> {{$item->sector}} </option>
                                      @endforeach
                                  </select>
                                  <label for="ri_sector" class="field-icon"><i class=" fa fa-dot-circle-o"></i>
                                  </label>
                              </label>
                          </div>
                          <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Valores de Análisis<small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>
                          <table class="table mbn">
                              <thead>
                                  <tr class="hidden">
                                      <th class="mw30">#</th>
                                      <th></th>
                                      <th></th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td class="fs17 text-center w30">
                                        <span class="fa fa-arrow-circle-o-right text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">Sensibilidad</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="ri_sensibilidad" class="field prepend-icon">
                                            <input type="text" name="ri_sensibilidad" id="ri_sensibilidad" class="gui-input valorRi" placeholder="Valor" value="0">
                                            <label for="ri_sensibilidad" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                        <span class="fa fa-arrow-circle-o-right text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">Amenaza</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="ri_amenaza" class="field prepend-icon">
                                            <input type="text" name="ri_amenaza" id="ri_amenaza" class="gui-input valorRi" placeholder="Valor" value="0">
                                            <label for="ri_amenaza" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                          <span class="fa fa-arrow-circle-o-right text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">Capacidad de Adaptacion</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="ri_adaptacion" class="field prepend-icon">
                                            <input type="text" name="ri_adaptacion" id="ri_adaptacion" class="gui-input valorRi" placeholder="Valor" value="0">
                                            <label for="ri_adaptacion" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="fs17 text-center">
                                          <span class="fa fa-arrow-circle-o-right text-info"></span>
                                      </td>
                                      <td class="va-m fw600 text-muted">Total Indice de Vulnerabilidad Sectorial</td>
                                      <td class="fs14 fw700 text-muted text-right">
                                        <label for="ri_vulnerabilidad" class="field prepend-icon">
                                            <input type="text" name="ri_vulnerabilidad" id="ri_vulnerabilidad" class="gui-input" placeholder="Valor" value="0" style="color:#000;" readonly>
                                            <label for="ri_vulnerabilidad" class="field-icon"><i class="glyphicon glyphicon-chevron-right"></i>
                                            </label>
                                        </label>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>

                          <div class="section">
                            <label class="field-label" for="ri_vulnerabilidad_desc">Interpretación del índice de vulnerabilidad</label>
                              <label for="ri_vulnerabilidad_desc" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="ri_vulnerabilidad_desc" name="ri_vulnerabilidad_desc" placeholder="Interpretación del índice de vulnerabilidad..." rows="1"></textarea>
                                  <label for="ri_vulnerabilidad_desc" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                                  </label>
                              </label>
                          </div>
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
                                      <th></th>
                                      <th></th>
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

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

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
        url: '/api/moduloplanificacion/setDiagnostico?p='+globalSP.idPlanActivo
    };

    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#dataTable").jqxDataTable(
    {
        source: dataAdapter,
        width:"100%",
        height: 450,
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


    var sourceSv =
    {
        dataType: "json",
        dataFields: [
            { name: 'id', type: 'int' },
            { name: 'jurisdiccion_territorial', type: 'string' },
            { name: 'unidades_socioculturales', type: 'string' },
            { name: 'funciones_ambientales', type: 'string' },
            { name: 'sis_produc_sustentables', type: 'string' },
            { name: 'pobreza', type: 'string' },
            { name: 'funciones_desc', type: 'string' },
            { name: 'sistemas_desc', type: 'string' },
            { name: 'pobreza_desc', type: 'string' }

        ],
        id: 'id',
        url: '/api/moduloplanificacion/setSistemasVida?p='+globalSP.idPlanActivo
    };

    var dataAdapterSv = new $.jqx.dataAdapter(sourceSv);
    $("#dataTableSv").jqxDataTable(
    {
        source: dataAdapterSv,
        width:"100%",
        height: 450,
        columnsResize: true,
        columns: [
            { text: '#', dataField: 'contador' },
            { text: 'Jurisdiccion Territorial', dataField: 'jurisdiccion_territorial',width: 250 },
            { text: 'Unidades Socioculturales', dataField: 'unidades_socioculturales' },
            { text: 'Funciones ambientales',dataField: 'funciones_ambientales',cellsAlign: 'left',width: 180,
                cellsRenderer: function (row, column, value, rowData) {
                    var container = `<div style="width: 100%; height: 100%;">
                                        <div style="float: left; width: 100%;">
                                        <div class="ml10"><b>Valor:</b> ${rowData.funciones_ambientales}</div>
                                        <div class="ml10"><b>Descripcion:</b> ${rowData.funciones_desc}</div>
                                    </div>`
                    return container;
                }
            },
            { text: 'Sistemas productivos sutentables', dataField: 'sis_produc_sustentables',cellsAlign: 'left',width: 180,
                cellsRenderer: function (row, column, value, rowData) {
                    var container = `<div style="width: 100%; height: 100%;">
                                        <div style="float: left; width: 100%;">
                                        <div class="ml10"><b>Valor:</b> ${rowData.sis_produc_sustentables}</div>
                                        <div class="ml10"><b>Descripcion:</b> ${rowData.sistemas_desc}</div>
                                    </div>`
                    return container;
                }
            },
            { text: 'Pobreza', dataField: 'pobreza', cellsAlign: 'left',width: 180,
                cellsRenderer: function (row, column, value, rowData) {
                    var container = `<div style="width: 100%; height: 100%;">
                                        <div style="float: left; width: 100%;">
                                        <div class="ml10"><b>Valor:</b> ${rowData.pobreza}</div>
                                        <div class="ml10"><b>Descripcion:</b> ${rowData.pobreza_desc}</div>
                                    </div>`
                    return container;
                }
            }

        ]
    });

    var sourceRi =
    {
        dataType: "json",
        dataFields: [
            { name: 'id', type: 'int' },
            { name: 'jurisdiccion_territorial', type: 'string' },
            { name: 'sector', type: 'string' },
            { name: 'sensibilidad', type: 'string' },
            { name: 'amenaza', type: 'string' },
            { name: 'adaptacion', type: 'string' },
            { name: 'vulnerabilidad', type: 'string' },
            { name: 'vulnerabilidad_desc', type: 'string' }
        ],
        id: 'id',
        url: '/api/moduloplanificacion/setRiesgos?p='+globalSP.idPlanActivo
    };

    var dataAdapterRi = new $.jqx.dataAdapter(sourceRi);
    $("#dataTableRi").jqxDataTable(
    {
        source: dataAdapterRi,
        width:"100%",
        height: 450,
        columnsResize: true,
        columns: [
            { text: '#', dataField: 'contador' },
            { text: 'Jurisdiccion Territorial', dataField: 'jurisdiccion_territorial',width: 250 },
            { text: 'Sector', dataField: 'sector' },
            { text: 'Sensibilidad', dataField: 'sensibilidad',
              cellsRenderer: function (row, column, value, rowData) {
                  var container = `<div style="width: 100%; height: 100%;">
                                      <div style="float: left; width: 100%;">
                                      <div class="ml10"><b>Valor:</b> ${rowData.sensibilidad}</div>
                                  </div>`
                  return container;
              }
            },
            { text: 'Amenaza', dataField: 'amenaza',cellsAlign: 'center',
              cellsRenderer: function (row, column, value, rowData) {
                  var container = `<div style="width: 100%; height: 100%;">
                                      <div style="float: left; width: 100%;">
                                      <div class="ml10"><b>Valor:</b> ${rowData.amenaza}</div>
                                  </div>`
                  return container;
              }
            },
            { text: 'Capacidad de Adaptacion', dataField: 'adaptacion',cellsAlign: 'center',
              cellsRenderer: function (row, column, value, rowData) {
                  var container = `<div style="width: 100%; height: 100%;">
                                      <div style="float: left; width: 100%;">
                                      <div class="ml10"><b>Valor:</b> ${rowData.adaptacion}</div>
                                  </div>`
                  return container;
              }
            },
            { text: 'Vulnerabilidad', dataField: 'vulnerabilidad',cellsAlign: 'left',
                cellsRenderer: function (row, column, value, rowData) {
                    var container = `<div style="width: 100%; height: 100%;">
                                        <div style="float: left; width: 100%;">
                                        <div class="ml10"><b>Valor:</b> ${rowData.vulnerabilidad}</div>
                                        <div class="ml10"><b>Descripcion:</b> ${rowData.vulnerabilidad_desc}</div>
                                    </div>`
                    return container;
                }
            }

        ]
    });


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

    $('#nuevoSv').on('click', function(event) {
          $(".state-error").removeClass("state-error")
          $("#form-sv em").remove();
          $("#form-sv input:text, #form-sv textarea").val('');
          $("#form-sv select").val('').change();

          $("#sv_id_plan").val(globalSP.idPlanActivo);


          trianguloGraf(0);

          // Inline Admin-Form example
          $.magnificPopup.open({
              removalDelay: 500, //delay removal by X to allow out-animation,
              focus: '#sv_jurisdiccion_territorial',
              items: {
                  src: "#modal-sv"
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

    $('#editarSv').on('click', function(event) {
          $(".state-error").removeClass("state-error")
          $("#form-sv em").remove();
          $("#form-sv input:text, #form-sv textarea").val('');
          $("#form-sv select").val('').change();
          $("#sv_id_plan").val(globalSP.idPlanActivo);
          var rowindex = $('#dataTableSv').jqxDataTable('getSelection');
          if (rowindex.length > 0)
          {
              var rowData = rowindex[0];
              $.ajax({
                  url: "{{ url('/api/moduloplanificacion/dataSetSistemaVida') }}",
                  type: "GET",
                  dataType: 'json',
                  data:{'id':rowData.id},
                  success: function(data){
                      //$("#mod_unidad").val(data.diagnostico.idp_unidad).trigger('change');
                      $("#sv_id_sis_vida").val(data.id);
                      $("#sv_jurisdiccion_territorial").val(data.jurisdiccion_territorial);
                      $("#sv_unidades_socioculturales").val(data.unidades_socioculturales);
                      $("#sv_funciones_desc").val(data.funciones_desc);
                      $("#sv_sistemas_desc").val(data.sistemas_desc);
                      $("#sv_pobreza_desc").val(data.pobreza_desc);
                      $("#sv_funciones_valor").val(data.funciones_ambientales);
                      $("#sv_sistemas_valor").val(data.sis_produc_sustentables);
                      $("#sv_pobreza_valor").val(data.pobreza);
                      trianguloGraf(1);
                  },
                  error:function(data){
                    console("Error recuperar los datos.");
                  }
              });
              // Inline Admin-Form example
              $.magnificPopup.open({
                  removalDelay: 500, //delay removal by X to allow out-animation,
                  focus: '#sv_jurisdiccion_territorial',
                  items: {
                      src: "#modal-sv"
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
    $('#eliminarSv').on('click', function(event) {
        var rowindex = $('#dataTableSv').jqxDataTable('getSelection');
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
                    url: "{{ url('/api/moduloplanificacion/deleteSistemasVida') }}",
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
                      $("#dataTableSv").jqxDataTable("updateBoundData");
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




    $('#nuevoRi').on('click', function(event) {
          $(".state-error").removeClass("state-error")
          $("#form-ri em").remove();
          $("#form-ri input:text, #form-ri textarea").val('');
          $("#form-ri select").val('').change();

          $("#ri_id_plan").val(globalSP.idPlanActivo);
          // Inline Admin-Form example
          $.magnificPopup.open({
              removalDelay: 500, //delay removal by X to allow out-animation,
              focus: '#ri_jurisdiccion_territorial',
              items: {
                  src: "#modal-ri"
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


    $('#editarRi').on('click', function(event) {
          $(".state-error").removeClass("state-error")
          $("#form-ri em").remove();
          $("#form-ri input:text, #form-ri textarea").val('');
          $("#form-ri select").val('').change();
          $("#sv_id_plan").val(globalSP.idPlanActivo);
          var rowindex = $('#dataTableRi').jqxDataTable('getSelection');
          if (rowindex.length > 0)
          {
              var rowData = rowindex[0];
              $.ajax({
                  url: "{{ url('/api/moduloplanificacion/dataSetRiesgo') }}",
                  type: "GET",
                  dataType: 'json',
                  data:{'id':rowData.id},
                  success: function(data){
                      //$("#mod_unidad").val(data.diagnostico.idp_unidad).trigger('change');
                      $("#ri_id_riesgo").val(data.id);
                      $('select[name=ri_jurisdiccion_territorial]').val(data.jurisdiccion_territorial).trigger('change');
                      $('select[name=ri_sector]').val(data.id_sector).trigger('change');
                      $("#ri_sensibilidad").val(data.sensibilidad);
                      $("#ri_amenaza").val(data.amenaza);
                      $("#ri_adaptacion").val(data.adaptacion);
                      $("#ri_vulnerabilidad").val(data.vulnerabilidad);
                      $("#ri_vulnerabilidad_desc").val(data.vulnerabilidad_desc);

                  },
                  error:function(data){
                    console("Error recuperar los datos.");
                  }
              });
              // Inline Admin-Form example
              $.magnificPopup.open({
                  removalDelay: 500, //delay removal by X to allow out-animation,
                  focus: '#ri_jurisdiccion_territorial',
                  items: {
                      src: "#modal-ri"
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

    $('#eliminarRi').on('click', function(event) {
        var rowindex = $('#dataTableRi').jqxDataTable('getSelection');
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
                    url: "{{ url('/api/moduloplanificacion/deleteRiesgo') }}",
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
                      $("#dataTableRi").jqxDataTable("updateBoundData");
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
                    $("#mod_unidad").val(data.diagnostico.idp_unidad).trigger('change');
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


    $( "#form-sv" ).validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                    sv_jurisdiccion_territorial: { required: true },
                    sv_unidades_socioculturales: { required: true },
                    sv_funciones_valor:  { required: true },
                    sv_sistemas_valor:  { required: true },
                    sv_pobreza_valor:  { required: true }
            },

            messages:{
                    sv_jurisdiccion_territorial: { required: 'Ingresar los datos' },
                    sv_unidades_socioculturales: { required: 'Ingresar los datos' },
                    sv_funciones_valor:  { required: 'Ingresar los datos' },
                    sv_sistemas_valor:  { required: 'Ingresar los datos' },
                    sv_pobreza_valor:  { required: 'Ingresar los datos' }
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
                saveFormSv();
            }
    });


    $( "#form-ri" ).validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                    ri_jurisdiccion_territorial: { required: true },
                    ri_sector: { required: true },
                    ri_sensibilidad:  { required: true },
                    ri_amenaza:  { required: true },
                    ri_adaptacion:  { required: true },
                    ri_vulnerabilidad_desc:  { required: true },
            },

            messages:{
                    ri_jurisdiccion_territorial: { required: 'Seleccione un registro' },
                    ri_sector: { required: 'Seleccione un registro' },
                    ri_sensibilidad:  { required: 'Ingresar los datos' },
                    ri_amenaza:  { required: 'Ingresar los datos' },
                    ri_adaptacion:  { required: 'Ingresar los datos' },
                    ri_vulnerabilidad_desc:  { required: 'Ingresar los datos' }
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
                saveFormRi();
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

    function saveFormSv(){
        var formData = new FormData($("#form-sv")[0]);
        $.ajax({
                url: "{{ url('/api/moduloplanificacion/saveSistemasVida') }}",
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
                    $("#dataTableSv").jqxDataTable("updateBoundData");
                    $("#form-sv")[0].reset();
                    $.magnificPopup.close();
                    updateComboJurisdiccionTerritorial();
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

    function saveFormRi(){
        var formData = new FormData($("#form-ri")[0]);
        $.ajax({
                url: "{{ url('/api/moduloplanificacion/saveRiesgo') }}",
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
                    $("#dataTableRi").jqxDataTable("updateBoundData");
                    $("#form-ri")[0].reset();
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

    $("#ri_jurisdiccion_territorial").select2({
        placeholder: "....Seleccione"
    });
    $("#ri_sector").select2({
        placeholder: "....Seleccione"
    })



 trianguloGraf(0);
});

$(".valorSv").keyup(function() {
  if($(this).val()>=0 && $(this).val()<=5){
    trianguloGraf(1);
  }else{
    $(this).val(0);
    new PNotify({
        title: "Error",
        text: "Los valores deben ser entre 0 y 5.",
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

$(".valorRi").keyup(function() {
  if($(this).val()>=0 && $(this).val()<=5){
       var a = parseFloat($("#ri_sensibilidad").val());
       var b = parseFloat($("#ri_amenaza").val());
       var c = parseFloat($("#ri_adaptacion").val());
       var n = a + b - c;
      $("#ri_vulnerabilidad").val(n);
  }else{
    $(this).val(0);
    var a = parseFloat($("#ri_sensibilidad").val());
    var b = parseFloat($("#ri_amenaza").val());
    var c = parseFloat($("#ri_adaptacion").val());
    var n = a + b - c;
    $("#ri_vulnerabilidad").val(n);
    new PNotify({
        title: "Error",
        text: "Los valores deben ser entre 0 y 5.",
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
function trianguloGraf(ele){
        var escala = {0:"",1:"Bajas", 2:"Moderadamente Baja", 3:"Media", 4:"Moderadamente Alta",5:"Altas"};
        $('#containerTriangulo').highcharts({
           chart: {
               polar: true,
               type: 'line'
           },
           credits: {
                enabled: false
           },
           title: {
               text: 'EVALUACIÓN INTEGRAL DE LOS SISTEMAS DE VIDA'
           },
           pane: {
               size: '80%'
           },
           xAxis: {
               categories: ['Funciones ambientales', 'Sistemas productivos sustentables', 'Pobreza'],
               tickmarkPlacement: 'on',
               lineWidth: 0
           },
           yAxis: {
               gridLineInterpolation: 'polygon',
               lineWidth: 0,
               min: 0,
               max: 6,
               tickInterval: 1
           },
           tooltip: {
               shared: true,
               pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.2f}</b><br/>'
           },
           legend: {
                    layout: 'vertical',
                    align: 'center',
                    verticalAlign: 'bottom',
                    borderWidth: 1
           },
           series: [{
               name: 'Triangulo de equilibrio',
               data: (function () {
                var a =  parseFloat($("#sv_funciones_valor").val());
                var b =  parseFloat($("#sv_sistemas_valor").val());
                var c =  parseFloat($("#sv_pobreza_valor").val());
                if(ele==0){
                  var data = [0,0,0];
                }else{
                  var data = [a,b,c];
                }

                return data;
               }()),
               pointPlacement: 'on'
           }]
       });
    }
    function updateComboJurisdiccionTerritorial(){
        $.ajax({
              type: "get",
              url: "{{ url('/api/moduloplanificacion/updateComboJurisdiccionTerritorial') }}",
              dataType: 'json',
              data:{'p':globalSP.idPlanActivo},
              success: function(data){
                  $("#ri_jurisdiccion_territorial").empty();
                  $.each(data, function(i, item) {
                        $("#ri_jurisdiccion_territorial").append('<option value="'+item.jurisdiccion_territorial+'">'+item.jurisdiccion_territorial+'</option>');
                  });
              },
              error:function(data){
                if(data.status != 401){
                  $.toast({
                    heading: 'Error:',
                    text: 'Error al Actualizar combo Jurisdiccion territorial(Riesgo).',
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




</script>

@endpush
