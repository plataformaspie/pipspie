<template>
  <div style="font-size:12px !important;">
    <div class="row p-t-10 ">
        <div class="col-lg-12  text-center  m-b-5 p-t-20" style="background-color:#fb9678;">
          <!--div class="alert alert-warning">This is an example top alert. You can edit what u wish. </div-->
          <h4 class="font-bold m-t-0 " style="color:#fff">Plan : {{ plan_activo }}</h4>
          <h5 class="font-bold m-t-0 " style="color:#fff">Gestion : {{ gestion_activa }}</h5>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="white-box p-0 m-0 p-l-10 p-r-10 p-t-10 p-b-10"  >
            <div class="row list-group-item-info">
              <ul class="feeds ">
                  <li class="m-t-10 m-l-10 m-r-10 m-b-10 p-0">
                      <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa  fa-institution text-white" style="line-height: 25px;"></i></div>
                        Denominacion Recursos: <strong v-text="arrayInstitucion.denominacion"></strong>
                      <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa  fa-info text-white" style="line-height: 25px;"></i></div>
                        Sigla: <strong v-text="arrayInstitucion.sigla"></strong>
                      <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa fa-qrcode text-white" style="line-height: 25px;"></i></div>
                        Codigo: <strong v-text="arrayInstitucion.codigo"></strong>
                  </li>
              </ul>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="white-box  p-0 m-0 p-l-10 p-r-10">
          <strong class="text-center">Totales</strong> 
          <hr class="p-0 m-0"> 
          <div class="user-btm-box p-t-0">
            <div class="row m-t-10 p-t-10 list-group-item-info">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 b-r list-group-item-success">
                <p class="m-b-0">Total PTDI:</p> <strong style="font-size:15px;">Bs. {{ total_ptdi }}</strong>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 b-r list-group-item-success">
                <p class="m-b-0">Total PEI:</p> 
                <strong style="font-size:15px;">Bs. {{ total_pei }}</strong>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 b-r list-group-item-success">
                <p class="m-b-0">TOTAL POA:</p> 
                <strong style="font-size:15px;">Bs. {{ total_poa }}</strong>
              </div>
              <!--div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 b-r">
                <p class="m-b-0">2019:</p> 
                <strong>Bs.4.571.501,00</strong>
              </div>
              <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 b-r">{{ total_pei }}
                <p class="m-b-0">2020:</p> 
                <strong>Bs.4.571.501,00</strong>
              </div> 
              <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 b-r">
                <p class="m-b-0">TOTAL PRESUPUESTO:</p> 
                <strong style="font-size: 20px;"> Bs.25.075.535,00</strong>
              </div-->
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
          <div class="panel-container vtabs">
            <div class="panel-left">
              <ul class="nav tabs-vertical" >
                <li v-for="gruposRecursos in arrayGrupos" :key="gruposRecursos.id" class="tab nav-item" >
                      <a data-toggle="tab" class="nav-link"  :class="{'active': gruposRecursos.orden == 1}" :href="'#panel'+gruposRecursos.id" aria-expanded="true">
                        <!-- <span class="visible-xs"><i class="fa fa-dot-circle-o"></i><span class="visible-xs" v-text="gruposRecursos.codigo"></span></span> -->
                        <i class="hidden-xs fa fa-dot-circle-o"></i> <span class="hidden-xs" v-text="gruposRecursos.valor"></span>
                      </a>
                </li>
              </ul>
            </div>

            <div class="splitter">
            </div>

            <div class="panel-right">

              <!--div class="tab-content" style="min-width:900px">
                <div v-for="gruposRecursos in arrayRecursos"  :id="'panel'+gruposRecursos.id" class="tab-pane" :class="{'active': gruposRecursos.orden == 1}">
                  <div class="table-responsive">
                    <h4 v-text="gruposRecursos.valor" class="m-t-0"></h4>
                      <table class="table table-bordered table-warning">
                          <thead>
                              <tr>
                                <th rowspan="2">#</th>
                                <th rowspan="2" class="text-middle"><strong>TIPO RECURSO</strong></th>
                                <th colspan="2" class="text-center"><strong>PTDI ( {{ gestion_activa}} )</strong></th>
                                <th colspan="2" class="text-center"><strong>PEI ( {{ gestion_activa}} )</strong> </th>
                                <th class="text-center"><strong>POA ( {{ gestion_activa}} )</strong></th>
                                <th class="text-center"><strong>Causas Variacion</strong></th>
                                <th rowspan="2" class="text-center"><strong>ACCION</strong></th>
                              </tr>
                              <tr>
                                
                                <th class="text-center"><strong>MONTO</strong></th>
                                <th class="text-center"><strong>(-)POA</strong></th>
                                <th class="text-center"><strong>MONTO</strong></th>
                                <th class="text-center"><strong>(-)POA</strong></th>
                                <th class="text-center"><strong>MONTO</strong></th>
                                
                              </tr>
                          </thead>
                          <tbody>
                              <tr class="ContactForm" v-for="(tiposRecursos,index) in arrayRecursos" v-if="tiposRecursos.valor===gruposRecursos.valor " :key="index" style="font-size=10px !important" >
                                  <td></td>
                                  <td v-text="tiposRecursos.nombre">
                                  </td>
                                  <td>
                                    <div class="col-md-12 text-right">
                                      {{ formatPrice(tiposRecursos.monto) }}
                                    </div>
                                  </td>
                                  <td>
                                    <div class="row text-right">
                                          <input   type="text"
                                            :class="'form-control dis'+tiposRecursos.id"
                                            :name="'monto_pei_gestion'+tiposRecursos.id"
                                            
                                            style="height: 28px;text-align: right;"
                                            @blur="formatInput"
                                            v-model="tiposRecursos.diferencia_ptdi_poa"
                                            disabled="disabled"
                                            >
                                    </div>
                                    <transition name="fade" v-if="tiposRecursos.diferencia_porcentaje_ptdi_poa">
                                      <div class="progress m-t-20">
                                        <div class="progress-bar" :style="{ 'width':tiposRecursos.diferencia_porcentaje_ptdi_poa +'%','background':tiposRecursos.color_porcentaje_ptdi_poa+'!important'}" role="progressbar">{{ formatPrice(tiposRecursos.diferencia_porcentaje_ptdi_poa) }}%</div>
                                      </div>
                                    </transition>
                                  </td>
                                  <td>
                                    <div class="row text-right">
                                          <input 
                                            
                                            type="text"
                                            :class="'form-control dis'+tiposRecursos.id"
                                            :name="'monto_pei_gestion'+tiposRecursos.id"
                                            
                                            style="height: 28px;text-align: right;"
                                            @blur="formatInput"
                                            v-model="tiposRecursos.monto_pei_gestion.input"
                                            pattern="\d(,\d{1,2})?"
                                            title="tu monto Pei"
                                            disabled="disabled">
                                           
                                          
                                    </div>
                                    
                                  </td>
                                  <td>
                                    <div class="row text-right">
                                          <input
                                            
                                            type="text"
                                            :class="'form-control dis'+tiposRecursos.id"
                                            :name="'input_pei_'+tiposRecursos.id"
                                            
                                            style="height: 28px;text-align: right;"
                                            @blur="formatInput"
                                            v-model="tiposRecursos.diferencia_pei_poa"
                                            disabled=disabled>
                                    </div>
                                    <transition name="fade" v-if="tiposRecursos.diferencia_porcentaje_pei_poa">
                                      <div class="progress m-t-20">
                                        <div class="progress-bar" :style="{ 'width': tiposRecursos.diferencia_porcentaje_pei_poa +'%','background':tiposRecursos.color_porcentaje_pei_poa+'!important'}" role="progressbar">{{ formatPrice(tiposRecursos.diferencia_porcentaje_pei_poa) }}%</div>
                                      </div>
                                    </transition>
                                  </td>
                                  
                                  <td>
                                    <div class="row">
                                      <input 
                                           type="text"
                                            :class="'form-control dis'+ tiposRecursos.id"
                                            :name="'input_poa_'+ tiposRecursos.id"
                                            v-model="tiposRecursos.monto_poa_gestion.input"
                                            style="height: 28px;text-align: right;"
                                            @blur="formatInput"
                                            pattern="\d(,\d{1,2})?"
                                            disabled="disabled">
                                                      
                                    </div>
                                    
                                  </td>
                                  <td>
                                    <div class="row">
                                      <input 
                                           type="text"
                                            :class="'form-control dis'+ tiposRecursos.id"
                                            :name="'input_poa_'+ tiposRecursos.id"
                                            v-model="tiposRecursos.causas_variacion.input"
                                            style="height: 28px;text-align: right;"
                                            @blur="formatInput"
                                            pattern="\d(,\d{1,2})?"
                                            disabled="disabled">
                                    </div>
                                  </td>
                                  <td class="text-nowrap">
                                    <a v-show="estado_modulo==true" href="#" @click="abrirModal(1,tiposRecursos)"> <i class="fa fa-edit text-inverse m-r-10" style="font-size:20px;"></i> </a>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                  
                </div>
              </div-->
              <div class="tab-content" style="min-width:900px">
                <div v-for="gruposRecursos in arrayGrupos"  :id="'panel'+gruposRecursos.id" class="tab-pane" :class="{'active': gruposRecursos.orden == 1}">
                  <div v-if="gruposRecursos.valor !== 'Otros Ingresos'" class="table-responsive">
                    <h4 v-text="gruposRecursos.valor" class="m-t-0"></h4> 
                    <table class="table table-bordered table-warning">
                        <thead>
                            <tr>
                              <th rowspan="2">#</th>
                              <th rowspan="2" class="text-middle"><strong>TIPO RECURSO</strong></th>
                              <th colspan="2" class="text-center"><strong>PTDI ( {{ gestion_activa}} )</strong></th>
                              <th colspan="2" class="text-center"><strong>PEI ( {{ gestion_activa}} )</strong> </th>
                              <th class="text-center"><strong>POA ( {{ gestion_activa}} )</strong></th>
                              <th class="text-center"><strong>Causas Variacion</strong></th>
                              <th rowspan="2" class="text-center"><strong>ACCION</strong></th>
                            </tr>
                            <tr>
                              
                              <th class="text-center"><strong>MONTO</strong></th>
                              <th class="text-center"><strong>(-)POA</strong></th>
                              <th class="text-center"><strong>MONTO</strong></th>
                              <th class="text-center"><strong>(-)POA</strong></th>
                              <th class="text-center"><strong>MONTO</strong></th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="ContactForm" v-for="(tiposRecursos,index) in arrayRecursos" v-if="tiposRecursos.valor===gruposRecursos.valor " :key="index" style="font-size=10px !important" >
                                <td></td>
                                <td v-text="tiposRecursos.nombre">
                                </td>
                                <td>
                                  <div class="col-md-12 text-right">
                                    {{ formatPrice(tiposRecursos.monto) }}
                                  </div>
                                </td>
                                <td>
                                  <div class="row text-right">
                                        <input   type="text"
                                          :class="'form-control dis'+tiposRecursos.id"
                                          :name="'monto_pei_gestion'+tiposRecursos.id"
                                          
                                          style="height: 28px;text-align: right;"
                                          @blur="formatInput"
                                          v-model="tiposRecursos.diferencia_ptdi_poa"
                                          disabled="disabled"
                                          >
                                  </div>
                                  <transition name="fade" v-if="tiposRecursos.diferencia_porcentaje_ptdi_poa">
                                    <div class="progress m-t-20">
                                      <div class="progress-bar" :style="{ 'width':tiposRecursos.diferencia_porcentaje_ptdi_poa +'%','background':tiposRecursos.color_porcentaje_ptdi_poa+'!important'}" role="progressbar">{{ formatPrice(tiposRecursos.diferencia_porcentaje_ptdi_poa) }}%</div>
                                    </div>
                                  </transition>
                                </td>
                                <td>
                                  <div class="row text-right">
                                        <input 
                                          
                                          type="text"
                                          :class="'form-control dis'+tiposRecursos.id"
                                          :name="'monto_pei_gestion'+tiposRecursos.id"
                                          
                                          style="height: 28px;text-align: right;"
                                          @blur="formatInput"
                                          v-model="tiposRecursos.monto_pei_gestion.input"
                                          pattern="\d(,\d{1,2})?"
                                          title="tu monto Pei"
                                          disabled="disabled">
                                         
                                        
                                  </div>
                                </td>
                                <td>
                                  <div class="row text-right">
                                        <input
                                          
                                          type="text"
                                          :class="'form-control dis'+tiposRecursos.id"
                                          :name="'input_pei_'+tiposRecursos.id"
                                          
                                          style="height: 28px;text-align: right;"
                                          @blur="formatInput"
                                          v-model="tiposRecursos.diferencia_pei_poa"
                                          disabled=disabled>
                                  </div>
                                  <transition name="fade" v-if="tiposRecursos.diferencia_porcentaje_pei_poa">
                                    <div class="progress m-t-20">
                                      <div class="progress-bar" :style="{ 'width': tiposRecursos.diferencia_porcentaje_pei_poa +'%','background':tiposRecursos.color_porcentaje_pei_poa+'!important'}" role="progressbar">{{ formatPrice(tiposRecursos.diferencia_porcentaje_pei_poa) }}%</div>
                                    </div>
                                  </transition>
                                </td>
                                <td>
                                  <div class="row">
                                    <input 
                                         type="text"
                                          :class="'form-control dis'+ tiposRecursos.id"
                                          :name="'input_poa_'+ tiposRecursos.id"
                                          v-model="tiposRecursos.monto_poa_gestion.input"
                                          style="height: 28px;text-align: right;"
                                          @blur="formatInput"
                                          pattern="\d(,\d{1,2})?"
                                          disabled="disabled">
                                                    
                                  </div>
                                </td>
                                <td>
                                  <div class="row">
                                    <input 
                                         type="text"
                                          :class="'form-control dis'+ tiposRecursos.id"
                                          :name="'input_poa_'+ tiposRecursos.id"
                                          v-model="tiposRecursos.causas_variacion.input"
                                          style="height: 28px;text-align: right;"
                                          @blur="formatInput"
                                          pattern="\d(,\d{1,2})?"
                                          disabled="disabled">
                                                    
                                  </div>
                                </td>
                                <td class="text-nowrap">
                                  <a v-show="estado_modulo==true" href="#" @click="abrirModal(1,tiposRecursos)"> <i class="fa fa-edit text-inverse m-r-10" style="font-size:20px;"></i> </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                  <div v-else>
                    <h4 class="m-t-0">Otros Ingresos:</h4>
                    <table class="table table-bordered table-warning">
                      <thead>
                          <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2" class="text-middle"><strong>TIPO RECURSO</strong></th>
                            <th colspan="2" class="text-center"><strong>PTDI ( {{ gestion_activa}} )</strong></th>
                            <th colspan="2" class="text-center"><strong>PEI ( {{ gestion_activa}} )</strong> </th>
                            <th class="text-center"><strong>POA ( {{ gestion_activa}} )</strong></th>
                            <th class="text-center"><strong>Causas Variacion</strong></th>
                            <th rowspan="2" class="text-center"><strong>ACCION</strong></th>
                          </tr>
                          <tr>
                            
                            <th class="text-center"><strong>MONTO</strong></th>
                            <th class="text-center"><strong>(-)POA</strong></th>
                            <th class="text-center"><strong>MONTO</strong></th>
                            <th class="text-center"><strong>(-)POA</strong></th>
                            <th class="text-center"><strong>MONTO</strong></th>
                            
                          </tr>
                      </thead>
                      <tbody>
                          
                          <tr v-for="(otros,key) in arrayOtrosIngresos" >
                            <td></td>
                            <td v-text="otros.concepto">
                            </td>
                            <td>
                              <div class="col-md-12 text-right">
                                {{ formatPrice(otros.monto) }}
                              </div>
                            </td>
                            <td>
                              <div class="row text-right">
                                    <input   type="text"
                                      class="form-control"
                                      name="monto_pei_gestion"
                                      
                                      style="height: 28px;text-align: right;"
                                      @blur="formatInput"
                                      v-model="otros.diferencia_ptdi_poa"
                                      disabled="disabled"
                                      >
                              </div>
                              <transition name="fade" v-if="otros.diferencia_porcentaje_ptdi_poa">
                                <div class="progress m-t-20">
                                  <div class="progress-bar" :style="{ 'width':otros.diferencia_porcentaje_ptdi_poa +'%','background':otros.color_porcentaje_ptdi_poa+'!important'}" role="progressbar">{{ formatPrice(otros.diferencia_porcentaje_ptdi_poa) }}%</div>
                                </div>
                              </transition>
                            </td>
                            <td>
                              <div class="row text-right">
                                <input 
                                  
                                  type="text"
                                  class="form-control"
                                  name="monto_pei_gestion"
                                  
                                  style="height: 28px;text-align: right;"
                                  @blur="formatInput"
                                  v-model="otros.monto_pei_gestion.input"
                                  pattern="\d(,\d{1,2})?"
                                  title="tu monto Pei"
                                  disabled="disabled">
                              </div>
                            </td>
                            <td>
                              <div class="row text-right">
                                <input
                                  
                                  type="text"
                                  class="form-control"
                                  name="input_pei"
                                  
                                  style="height: 28px;text-align: right;"
                                  @blur="formatInput"
                                  v-model="otros.diferencia_pei_poa"
                                  disabled=disabled>
                              </div>
                              <transition name="fade" v-if="otros.diferencia_porcentaje_pei_poa">
                                <div class="progress m-t-20">
                                  <div class="progress-bar" :style="{ 'width': otros.diferencia_porcentaje_pei_poa +'%','background':otros.color_porcentaje_pei_poa+'!important'}" role="progressbar">{{ formatPrice(otros.diferencia_porcentaje_pei_poa) }}%</div>
                                </div>
                              </transition>
                            </td>
                            <td>
                              <div class="row">
                                <input 
                                     type="text"
                                      class="form-control"
                                      name='input_poa'
                                      v-model="otros.monto_poa_gestion.input"
                                      style="height: 28px;text-align: right;"
                                      @blur="formatInput"
                                      pattern="\d(,\d{1,2})?"
                                      disabled="disabled">
                              </div>
                            </td>
                            <td>
                              <div class="row">
                                <input 
                                     type="text"
                                      class="form-control"
                                      name="input_poa"
                                      v-model="otros.causas_variacion.input"
                                      style="height: 28px;text-align: right;"
                                      @blur="formatInput"
                                      pattern="\d(,\d{1,2})?"
                                      disabled="disabled">
                                                
                              </div>
                            </td>
                            <td class="text-nowrap">
                                <a v-show="estado_modulo==true" href="#" @click="abrirModal(1,otros)"> <i class="fa fa-edit text-inverse m-r-10" style="font-size:20px;"></i> </a>
                              </td>
                          </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>




      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="white-box p-0 m-0 p-t-10 ">
          <div class="form-group text-center p-0 m-0">
                <button v-show="estado_modulo==true" type="submit" class="btn btn-success" @click="reporteRecursosGestionExcel">Exportar <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
                <button v-show="estado_modulo==true" type="submit" class="btn btn-danger" @click="reporteRecursosGestionPdf">Exportar <i class="fa fa-file-pdf-o " aria-hidden="true"></i></button>
                <button v-show="estado_modulo==true" type="submit" class="btn btn-info" @click="finalizarModulo(6)">Salir y Finalizar</button>
                <button type="submit" class="btn btn-default" @click="salirModulo()">Salir</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" :class="{'show':modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog" style="max-width: 600px;">
          <div class="modal-content">
            <form method="post" id="form-otro" name="form-otro" @submit.prevent="validateRecurso">
                <div class="modal-header">
                    <button type="button" class="close" @click="cerrarModal()" aria-hidden="true">×</button>
                    <h4 class="modal-title">Seguimiento al Presupuesto</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-12">
                          <!--h5>{{ recurso.nombre }}</h5-->
                          
                          <div class="form-group">
                              <label for="montoPoa" class="control-label">Monto:</label>
                              <input type="text" name="montoPoa"  class="form-control"  :value ="formatPrice(recurso_monto_planificado)" @blur="formatInput" disabled="disabled" style="margin-bottom:15px">
                          </div>
                          <div :class="['form-group',(recurso_poa.clase).trim()?'has-'+recurso_poa.clase:'']">
                            <label class="form-control-label" for="inputSuccess1">POA</label>
                            <input type="text"  id="inputSuccess1" v-model="recurso_poa.input" 
                                :class="['form-control',(recurso_poa.clase).trim()?'form-control-' + recurso_poa.clase:'']"
                                 @keyup="midecimal(recurso_poa)"   
                            >
                            <div class="form-control-feedback" v-text="recurso_poa.mensaje"></div>
                            <small class="form-text text-muted">La "," es separador de decimales.</small>
                          </div>
                          <div :class="['form-group',(recurso_pei.clase).trim()?'has-'+ recurso_pei.clase:'']">
                            <label class="form-control-label" for="inputSuccess1">PEI</label>
                            <input type="text"  id="inputSuccess1" v-model="recurso_pei.input" 
                                :class="['form-control',(recurso_pei.clase).trim()?'form-control-' + recurso_pei.clase:'']"
                                 @keyup="midecimal(recurso_pei)"   
                            >
                            <div class="form-control-feedback" v-text="recurso_pei.mensaje"></div>
                            <small class="form-text text-muted">La "," es separador de decimales.</small>
                          </div>
                          <div :class="['form-group',(causas_variacion.clase).trim()?'has-'+ causas_variacion.clase:'']">
                              <label for="nombre_entidad" class="form-control-label" >Causas de Variacion</label>
                              <input type="text" 
                                      name="nombre_entidad" 
                                      v-model="causas_variacion.input"
                                      :class="['form-control',(causas_variacion.clase).trim()?'form-control-' + causas_variacion.clase:'']"
                                      @keyup="todoTexto(causas_variacion)"
                                      >
                              <div class="form-control-feedback" v-text="causas_variacion.mensaje"></div>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" @click="cerrarModal()">Cancelar</button>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Calcular y Guardar</button>
                </div>
            </form>
          </div>
      </div>
    </div>  

  </div><!--ultimo div-->

</template>

<script>
export default {
    data(){
        return{
          arrayGrupos: [],
          arrayRecursos:[],
          arrayInstitucion:[],
          arrayOtrosIngresos:[],
          arrayUser:[],
          width:0,
          semaforo:[
            {'id':1, 'color':'red'},
            {'id':2, 'color':'yellow'},
            {'id':3, 'color':'green'},
          ],
          
          monto_pei:"",
          monto_poa:"",
          modal:0,
          recurso_poa:{
            input:"",
            clase:"",
            mensaje:""
          },
          recurso_pei:{
            input:"",
            clase:"",
            mensaje:"" 
          },
          causas_variacion:{
            input:"",
            clase:"",
            mensaje:""
          },
          recurso_monto_planificado:"",
          recurso_id_recurso_poa:"",
          recurso_id_tipo_recurso:"",
          recurso_id_otro_ingreso:"",
          errors : [],
          estado_modulo:"",
          plan_activo:"",
          gestion_activa:"",
          total_ptdi:0,
          diferencia_ptdi_poa:0,
          diferencia_porcentaje_ptdi_poa:0,
          total_pei:0,
          diferencia_pei_poa:0,
          diferencia_porcentaje_pei_poa:0,
          total_poa:0


        }
    },
    methods: {
        datosUsuario(){
          let me = this;
           axios.get('/api/planesTerritoriales/datosUsuario').then(function (response) {
              // handle success
              me.arrayInstitucion = response.data.institucion;
              me.arrayUser = response.data.user;
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            });
        },
        listaRecursosGestion(){
        let me = this;
          axios.get('/api/planesTerritoriales/listaRecursosGestion').then(function (response) {
            me.arrayGrupos = response.data.grupos;
            me.arrayRecursos = response.data.recursos;
            me.estado_modulo = response.data.estado_modulo;
            me.plan_activo = response.data.plan_activo;
            me.gestion_activa = response.data.gestion_activa;
            me.arrayOtrosIngresos = response.data.otrosIngresos;


          //CALCULANDO TOTALES
            
            me.total_ptdi = me.formatPrice(response.data.total_ptdi);
            me.diferencia_ptdi_poa = response.data.diferencia_ptdi_poa;
            me.diferencia_porcentaje_ptdi_ = response.data.diferencia_porcentaje_ptdi;
            me.total_pei = me.formatPrice(response.data.total_pei);
            me.diferencia_pei_poa = response.data.diferencia_pei_poa;
            me.diferencia_porcentaje_pei_poa = response.data.diferencia_porcentaje_pei_poa;
            me.total_poa = me.formatPrice(response.data.total_poa);

            //console.log(response);
            
            $.each(me.arrayRecursos,function(index,r){
              if(r.diferencia_ptdi_poa){
                r.diferencia_ptdi_poa = me.formatPrice(r.diferencia_ptdi_poa);
                //console.log(r.diferencia_ptdi_poa); 
              }else if(r.diferencia_ptdi_poa == 0){
                //console.log("el valor no existe");
              }
              
              r.diferencia_pei_poa = me.formatPrice(r.diferencia_pei_poa) ;
              r.monto_pei_gestion.input=me.formatPrice(r.monto_pei_gestion.input);
              r.monto_poa_gestion.input=me.formatPrice(r.monto_poa_gestion.input);
              //console.log(r.monto_poa_gestion.clase);
              
            })

          })

          .catch(function (error) {
           // handle error
           console.log(error);
          });
        },
        formatInput(event){
          let value = event.target.value;
          value = value.toString();
          let count = value.split(",").length-1;
          if(count > 1){
            event.target.value = Number(value.replace(/,/g,''));
          }
          // let val = 1
          // event.target.value = val;
        },
        formatPrice(value) {
          let val = (value/1).toFixed(2).replace('.', ',')
          return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        formato(value){
           value.replace(/\D/g, "")
          .replace(/([0-9])([0-9]{2})$/, '$1,$2')
          .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
          
        },
        saveUpdateRecurso(){

          let me = this;
          
          var monto = me.recurso_monto_planificado;
          var poa = (me.replaceAll(me.recurso_poa.input,".","")).split(',').join('.');
          var pei = (me.replaceAll(me.recurso_pei.input,".","")).split(',').join('.');
          var d_ptdi_poa = monto - poa;
          var d_pei_poa = pei - poa;
          var por_ptdi = (d_ptdi_poa/monto)*100;
          var por_pei = (d_pei_poa/pei)*100; 

          var recurso_enviar = {};

          recurso_enviar.monto_pei_gestion = pei
          recurso_enviar.monto_poa_gestion = poa
          recurso_enviar.diferencia_ptdi_poa = d_ptdi_poa;
          recurso_enviar.diferencia_pei_poa = d_pei_poa;
          recurso_enviar.diferencia_porcentaje_ptdi_poa = por_ptdi
          recurso_enviar.diferencia_porcentaje_pei_poa = por_pei
          recurso_enviar.id_recurso_poa = me.recurso_id_recurso_poa;
          recurso_enviar.id_tipo_recurso =  me.recurso_id_tipo_recurso;
          if(me.recurso_id_tipo_recurso == null){
            recurso_enviar.id_otro_ingreso = me.recurso_id_otro_ingreso;
          }

          recurso_enviar.causas_variacion = me.causas_variacion.input;

          
          
          if(por_ptdi<51){
            recurso_enviar.color_porcentaje_ptdi_poa = '#31D63C';
          }else{
            recurso_enviar.color_porcentaje_ptdi_poa = '#5893D4';
          }
          if(por_pei<51){
            recurso_enviar.color_porcentaje_pei_poa = '#31D63C';
          }else{
            recurso_enviar.color_porcentaje_pei_poa = '#5893D4';
          }
          //console.log(recurso_enviar);

          swal({
                 title: "Guardar?",
                 text: "Se guardara los datos registrados!",
                 type: "warning",
                 showCancelButton: true,
                 confirmButtonColor: "#DD6B55",
                 confirmButtonText: "Si, Guardar!",
                 closeOnConfirm: true
               },function(){
                   axios({
                      method: 'post',
                      url: '/api/planesTerritoriales/saveUpdateRecursoPoa',
                      data: {
                        datos: recurso_enviar,
                      }
                    }).then(function (response) {
                      swal("Guardado!", "Se ha guardado correctamente.", "success");
                      me.cerrarModal();
                      me.listaRecursosGestion();
                      me.recurso_pei = {
                        input:"",
                        clase:"",
                        mensaje:""
                      };
                      me.recurso_poa = {
                        input:"",
                        clase:"",
                        mensaje:""
                      };
                      me.causas_variacion = {
                        input:"",
                        clase:"",
                        mensaje:""
                      };
                      recurso_id_recurso_poa = "";
                      recurso_id_tipo_recurso = "";
                      recurso_id_otro_ingreso = "";
                       
                    }).catch(function (error) {
                      console.log(error);
                    });
              });
        },
        abrirModal(e,r){
           let me = this;
           switch (e) {
             case 1:
                

                me.recurso_poa.input = r.monto_poa_gestion.input;//.split('.'),join('');
                me.recurso_pei.input = r.monto_pei_gestion.input;//.split('.'),join('');
                me.recurso_monto_planificado = r.monto;//planificador
                //console.log(r.causas_variacion.input);
                me.causas_variacion.input = r.causas_variacion.input;
                me.recurso_id_recurso_poa = r.id_recurso_poa;
                me.recurso_id_tipo_recurso = r.id_tipo_recurso;
                if(r.id_tipo_recurso == null){
                  me.recurso_id_otro_ingreso = r.id_otro_ingreso;
                  console.log(me.recurso_id_otro_ingreso);
                }
                
                this.modal = 1;
               break;
             case 2:
                //recuperar datos par aupdate con axios
                this.modal = 1;
              break;
             default:

           }
        },
        cerrarModal(){
             this.modal = 0;
        },
        finalizarModulo(m){
          let me = this;
          swal({
            title: "Está seguro?",
            text: "No podrá realizar más modificaciones!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, finalizar!",
            closeOnConfirm: false
          }, function(){
              axios.get('/api/planesTerritoriales/finalizarModuloSeguimiento?modulo='+m).then(function (response) {
                  swal("Finalizado!", "Se ha finalizado el cargado del módulo.", "success");
                  me.salirModulo();
            }).catch(function (error) {
                // handle error
                console.log(error);
            });
          });
        },
        salirModulo(){
          let me = this;
          me.$root.$data.views = 5;
          //window.location = "/planesTerritoriales/index";
        },
        midecimal(data){

          if(data.input){
            var currentVal = data.input;
            var testDecimal = this.testDecimals(currentVal);//verifica con un contador si hay una coma o mas
            if (testDecimal.length > 1) {//si el contador es mayor a uno mensaje
                //console.log("You cannot enter more than one decimal point");
                data.clase = "danger";
                data.mensaje = "No puede introducir mas de punto decimal";
                //console.log(currentVal);//123.4.
                currentVal = currentVal.slice(0, -1);//devuelve todo el array menos el ultimo 
                //console.log(currentVal);//123.4

            }
            //$(this).val(replaceCommas(currentVal));
            data.input = this.replaceCommas(currentVal,data);  
          }else{
            data.clase = "warning";
            data.mensaje = "Este campo esta vacio";
          }
        },
        testDecimals(currentVal) {
          //verifica si hay mas de dos comas
        var count;
        //currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
        currentVal.match(/\,/g) === null ? count = 0 : count = currentVal.match(/\,/g);
        return count;
        //console.log("hola testDecimales");
        },

        replaceCommas(yourNumber,data) {
          //console.log(yourNumber);
          //console.log(data);
          //console.log("hola replaceCommas");

            //var components = yourNumber.toString().split(".");
            var components = yourNumber.toString().split(",");
            //console.log("Valor de components 0  "+ components[0]);

            /*
            if(components.length === 0){
              data.clase = "warning";
              data.mensaje = "Campo vacio";
            }
            if (components.length === 1){
              //quiere decir que no hay decimales
              components[0] = yourNumber;
              components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
              //console.log("hola replaceCommas primer if");
              
                data.clase = "success";
                data.mensaje = "formato correcto"  
            } 
              
            if (components.length === 2){
              //si hay decimales
              components[1] = components[1].replace(/\D/g, "");
              //console.log("hola replaceCommas segundo if");
              data.clase = "succes";
              data.mensaje = "formato correcto";
            }*/

            switch(components.length){
              case 1:

                components[0] = yourNumber;
                components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                //console.log("hola replaceCommas primer if");
              
                data.clase = "success";
                data.mensaje = "formato correcto" 
                //console.log('Esta introducioendo LETRAS');
                break;
              
              case 2:
                components[1] = components[1].replace(/\D/g, "");
                //console.log("hola replaceCommas segundo if");
                data.clase = "success";
                data.mensaje = "formato correcto"

                break;
            }

            
                
            //return components.join(".");
            return components.join(",");
        },
        replaceAll( text, busca, reemplaza ){
          while (text.toString().indexOf(busca) != -1)
              text = text.toString().replace(busca,reemplaza);
          return text;
        },
        validateRecurso(){
          //console.log("hola desde validate Recurso");
          let me = this;
          
          
          if(!me.recurso_poa.input){
            me.recurso_poa.clase = "warning";
            me.recurso_poa.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          if(!me.recurso_pei.input){
            me.recurso_pei.clase = "warning";
            me.recurso_pei.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          //console.log(me.errors.length);
          if (me.errors.length>0) {
            return false;
          }else{

            
            me.saveUpdateRecurso();
          }

          

          
        },
        todoTexto(data){
          let me = this;
          if(data.input){
            data.clase = "success";
            data.mensaje = "";
          }
        },
        reporteRecursosGestionExcel(){
          
          location.href = '/api/planesTerritoriales/reporteRecursosGestionExcel';
        },
        reporteRecursosGestionPdf(){
          location.href = '/api/planesTerritoriales/reporteRecursosGestionPdf';
        } 
    },
    computed: {
       
    },
    mounted() {

        this.datosUsuario();
        this.listaRecursosGestion();


        $(".panel-left").resizable({
          handleSelector: ".splitter",
          resizeHeight: false
        });
    }
}


</script>
<style media="screen">
:root{
    --width-inputs:80%;
    --bg-color-main:#35495E;
    --color-ok:#418883;
    --color-error:#EF5350;
    --font-main:sans-serif;
  }
  

  .ContactForm[required]:valid{
    border:thin solid var(--color-ok);
    outline: thin solid var(--color-ok);
  }
  .ContactForm[required]:invalid{
    border:thin solid var(--color-error);
    outline: thin solid var(--color-errot);
  }  
  .ContactForm[required]:focus{
    border:thin solid var(--color-main);
    outline: thin solid var(--color-main);
  }

////////***/////
.modal-content{
  width: 100% !important;
  position: absolute !important;
}
.mostrar{
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important;
}

/* horizontal panel*/

.panel-container {
  display: flex;
  flex-direction: row;
  border: 1px solid silver;
  overflow: hidden;

  /* avoid browser level touch actions */
  xtouch-action: none;
}

.panel-left {
  flex: 0 0 auto;
  /* only manually resize */
  padding: 10px;
  width: 300px;
  max-height: 500px;
  min-width: 150px;
  white-space: nowrap;
  background: #ffffff;
  
  color: white;
  overflow: auto;
}

.splitter {
  flex: 0 0 auto;
  width: 9px;
  background: url(https://raw.githubusercontent.com/RickStrahl/jquery-resizable/master/assets/vsizegrip.png) center center no-repeat #adadad;
  min-height: 200px;
  cursor: col-resize;
}

.panel-right {
  flex: 1 1 auto;
  /* resizable */
  padding: 10px;
  width: 100%;
  max-height: 500px;
  min-width: 200px;
  background: rgba(#fafafa, 0.75);
  overflow: auto;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.bg-success {
    background-color: #00c292!important;
}
.progress-bar {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
     color:#000000;
    text-align: center;
    white-space: nowrap;
    /*background-color: #ff0a0aaf  !important;*/
    -webkit-transition: width 0.6s ease;
    -o-transition: width 0.6s ease;
    transition: width 0.6s ease;
    height:30px;
    font-size: 10px
}
.progress {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    height: auto;
    overflow: hidden;
    font-size: 0.65625rem;
    background-color: rgb(222, 230, 221) !important;
    border-radius: 0.25rem;
    /*background-color:#3dee10de*/
   
}
input{
  font-size:12px !important
}



</style>
