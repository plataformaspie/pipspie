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
    <div class="card">
      <div class="table-responsive white-box" >
        <h4 class="m-t-0">SEGUIMIENTO A PROYECTOS DE INVERSION</h4>
        <table id="art" class="table table-bordered color-table info-table miTabla">
          <thead>
            <tr>
              <th>Accion ETA</th>
              <th>Actividad</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(inv,clave) in arrayListaObjetivosInversion" :key="clave" >
              <td>{{ inv.nombre_accion_eta}}</td>
              <td>
                  <!--div class="text-center">
                    <a href="#" @click="abrirModalProyPoa(index,1)" class="btn btn-dark" style="color:#000;"> <i class="fa fa-plus-circle  fa-2x   "></i> </a>  
                  </div-->
                <table> 
                    <thead>
                          <tr>
                            <th  rowspan="3"  class="align-middle">Accion</th>
                            <th  class="align-middle" colspan="3">Planificacion</th>
                            <th  class="align-middle" colspan="5">Inscrito en el VIPFE</th>
                            <th  class="align-middle" colspan="3">Concurrencia ETA</th>
                            <th  class="align-middle"  colspan="2">Entidad Ejecutora</th>
                            <th  class="align-middle"  rowspan="3" colspan="7">Entidades Concurrencia</th>
                          </tr> 
                          <tr>
                            
                            <th  class="align-middle" rowspan="2">PTDI</th>
                            <th  class="align-middle" rowspan="2">PEI</th>
                            <th  class="align-middle" rowspan="2">POA</th>
                            <th  class="align-middle" rowspan="2">Codigo SISIN</th>
                            <th  class="align-middle" rowspan="2">Proyecto</th>
                            <th  class="align-middle" rowspan="2">Costo Total del Proyecto</th>
                            <th  class="align-middle" colspan="2">Periodo de Ejecucion</th>
                            <th  class="align-middle" rowspan="2">Prog.</th>
                            <th  class="align-middle" rowspan="2">Ejec.</th>
                            <th  class="align-middle" rowspan="2">%Ejec</th>
                            <th  class="align-middle" rowspan="2" >Cod. Ent.</th>
                            <th  class="align-middle" rowspan="2">Denominacion entidad</th>
                          </tr> 
                          <tr>
                            <th class="align-middle" >Del</th>
                            <th class="align-middle" >Al</th>
                          </tr> 
                    </thead>             
                    <tbody> 
                      <tr v-for="(vip, index) in inv.proyectosInversion" :key="index">
                        <td v-if="vip.verificar_existe_proyectos_inversion =='si hay'" class="text-nowrap">
                          <a v-show="estado_modulo"  style="display:inline-block;" href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar Proyecto Inversion" @click="abrirModal(2,clave,index)"><i class="fa fa-edit fa-lg fa-2x    " style="color:#0973E8"></i></a> 
                        </td>
                        <td v-else class="text-nowrap">
                          <a v-show="estado_modulo"  style="display:inline-block;" href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" title="Agregar POA " @click="abrirModal(1,clave,index)"><i class="fa fa-plus fa-lg fa-2x   text-info " style="color:#0973E8"></i></a> 
                        </td>
                        <td v-if="vip.inscrito_ptdi==true">X</td>
                        <td v-else></td>
                        <td v-if="vip.inscrito_pei==true">X</td>
                        <td v-else></td>
                        <td v-if="vip.inscrito_poa==true">X</td>
                        <td v-else></td>
                        <td>{{ vip.codigo_sisin}}</td>
                        <td>{{ vip.nombre}}</td>
                        <td>{{ vip.costo_total_proyecto }}</td>
                        <td v-if="vip.periodo_ejecucion_del" v-text="formatYear(vip.periodo_ejecucion_del)"></td>
                        <td v-else></td>
                        <td v-if="vip.periodo_ejecucion_al" v-text="formatYear(vip.periodo_ejecucion_al)"></td>
                        <td v-else></td>

                        <td>{{ vip.monto_poa_planificado }}</td>
                        <td>{{ vip.monto_poa_ejecutado }}</td>
                        <td>{{ vip.monto_poa_porcentaje }}</td>
                        <td>{{ vip.entidad_ejecutora_cod }}</td>
                        <td>{{ vip.entidad_ejecutora_denominacion }}</td>
                        <template v-if="vip.verificar_existe_proyectos_inversion == 'si hay'">
                            <td>
                              <button  v-show="estado_modulo" 
                                      id="agregarColor" 
                                      class=" btn btn-info m-l-10 m-r-10 m-t-10 sel_edit" 
                                      @click="abrirModalConcurrencia(1,clave,index,-1)" 
                                      title="Agregar Entidades Concurrentes" 
                                      style="border-radius:100%;" ><i class="fa fa-plus fa-xs "></i>
                              </button>
                            </td>
                            <td v-if="vip.verificar_existe_entidades_concurrencia == 'si hay'">
                              <div class="table-responsive">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <td>Accion</td>
                                      <td>Nombre<br/>Entidad</td>
                                      <td>Monto<br/>Programado</td>
                                      <td>Monto <br/>Ejecutado</td>
                                      <td>% De<br/>Ejecucion</td>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(ent, key) in vip.entidadesConcurrencia" :key="key" >
                                      <td class="text-nowrap">
                                        <a v-show="estado_modulo==true" href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" @click="abrirModalConcurrencia(2,clave,index,key)" title="Editar Entidades " ><i class="fa fa-edit fa-lg  text-warning "></i></a> 
                                        <a v-show="estado_modulo==true" href="#" class="m-l-10 m-r-10 m-t-10 sel_edit"> <i class="fa fa-trash fa-lg text-danger" @click="deleteEntidad(ent.id)" title="Eliminar Entidad"></i> </a>
                                        <!--a href="#"  class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger " @click="abrirModalConcurrencia(1,clave,index)"></i></a-->
                                      </td>
                                      <td>{{ ent.nombre_entidad }} </td>
                                      <td>{{ ent.programacion_entidad }}</td>
                                      <td>{{ ent.ejecucion_entidad }}</td>
                                      <td v-text="formatPrice(ent.porcentaje_ejecucion_entidad)"></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </td>
                            <td v-else><p>No tiene registrado Entidades</p></td>
                        </template>
                        <template v-else>
                          <td>
                            <button  v-show="estado_modulo" id="agregarColor" disabled="disabled" class=" btn btn-info m-l-10 m-r-10 m-t-10 sel_edit" @click="abrirModalConcurrencia(1,clave,index)" title="Entidades Sin Proyectos" style="border-radius:100%;" ><i class="fa fa-plus fa-xs "></i>
                            </button>
                          </td>
                          <td ><p>Debe registrar datos del Proyecto Inversion</p></td>
                        </template>
                      </tr>
                    </tbody>
                </table> 
              </td>

            </tr>
          </tbody>
        </table>
      </div>  
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="white-box p-0 m-0 p-t-10 ">
          <div class="form-group text-center p-0 m-0">
                <button v-show="estado_modulo==true" type="submit" class="btn btn-success" @click="reporteInversionGestionExcel">Exportar <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
                <button v-show="estado_modulo==true" type="submit" class="btn btn-danger" @click="reporteInversionGestionPdf">Exportar <i class="fa fa-file-pdf-o " aria-hidden="true"></i></button>
                <button v-show="estado_modulo==true" type="submit" class="btn btn-info" @click="finalizarModulo(9)">Salir y Finalizar</button>
                <button type="submit" class="btn btn-default" @click="salirModulo()">Salir</button>
          </div>
        </div>
      </div>
    </div>

    <!--Ventana Modal para los proyectos de Inversiones-->
    <div class="modal fade" :class="{'show':modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
       <div class="modal-dialog" style="max-width: 600px;">
           <div class="modal-content">
              <form method="post" id="form-otro" name="form-otro" @submit.prevent="">
                 <div class="modal-header">
                     <button type="button" class="close" @click="cerrarModal()" aria-hidden="true">×</button>
                     <h4 class="modal-title">Proyectos de Inversion</h4>
                 </div>
                 <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card-body p-b-0">
                          <div class="col-lg-12">
                            <form>
                              <div class="form-group">
                                <h4 class="separador">Proyecto inscrito VIPFE</h4>
                                <div class="form-group">
                                  <label for="concepto" class="control-label">Nombre Proyecto</label>
                                  <input type="text" name="concepto" class="form-control" v-model="objProyecto.nombre_proyecto" disabled="disabled">
                                </div>
                                <div :class="['form-group',(objProyecto.costo_total_proyecto.clase).trim()?'has-'+objProyecto.costo_total_proyecto.clase:'']">
                                  <label for="fuente_financiamiento" class="control-label">Costo Total:</label>
                                  <input type="text" name="fuente_financiamiento"  
                                        :class="['form-control',(objProyecto.costo_total_proyecto.clase).trim()?'form-control-' + objProyecto.costo_total_proyecto.clase:'']" 
                                        v-model="objProyecto.costo_total_proyecto.input"
                                        @keyup="midecimal(objProyecto.costo_total_proyecto)" >
                                  <div class="form-control-feedback" v-text="objProyecto.costo_total_proyecto.mensaje"></div>
                                </div>
                                
                                <h6>Periodo de Ejecucion</h6>
                                <div :class="['form-group',(objProyecto.periodo_ejecucion_del.clase).trim()?'has-'+objProyecto.periodo_ejecucion_del.clase:'']">
                                  <label for="organismo_financiador" class="form-control-label">Del:</label>
                                  <input type="date" name="organismo_financiador" 
                                        :class="['form-control',(objProyecto.periodo_ejecucion_del.clase).trim()?'form-control-' + objProyecto.periodo_ejecucion_del.clase:'']" 
                                        v-model="objProyecto.periodo_ejecucion_del.input"
                                        @change="onchange($event,objProyecto.periodo_ejecucion_del)">
                                  <div class="form-control-feedback" v-text="objProyecto.periodo_ejecucion_del.mensaje"></div> 
                                </div> 
                                <div :class="['form-group',(objProyecto.periodo_ejecucion_al.clase).trim()?'has-'+objProyecto.periodo_ejecucion_al.clase:'']">
                                  <label for="rubro" class="form-control-label">Al:</label>
                                  <input  type="date" name="rubro"  
                                          :class="['form-control',(objProyecto.periodo_ejecucion_al.clase).trim()?'form-control-' + objProyecto.periodo_ejecucion_al.clase:'']" 
                                          v-model="objProyecto.periodo_ejecucion_al.input"
                                          @change="onFechas($event,objProyecto.periodo_ejecucion_al)">
                                  <div class="form-control-feedback" v-text="objProyecto.periodo_ejecucion_al.mensaje"></div> 
                                </div>  
                                <!--h4 class="separador">Concurrencia ETA</h4>
                                <label for="fuente_financiamiento" class="control-label">Programacion:</label>
                                <input type="text" name="fuente_financiamiento"  class="form-control" v-model="objProyecto.concurrencia_eta_programacion" required="required">

                                <label for="fuente_financiamiento" class="control-label">Ejecucion:</label>
                                <input type="text" name="fuente_financiamiento"  class="form-control" v-model="objProyecto.concurrencia_eta_ejecucion">
                                <label for="fuente_financiamiento" class="control-label">% Ejecucion:</label>
                                <p v-if="(objProyecto.concurrencia_eta_programacion == '')||(objProyecto.concurrencia_eta_ejecucion == '')">Debe llenar los campos Programacion y Ejecucion para hallar el porcentaje</p>
                                <p v-else class="text-danger" style="font-size:16px"  v-text="formatPrice((objProyecto.concurrencia_eta_ejecucion/objProyecto.concurrencia_eta_programacion)*100)+'%'" v-model="objProyecto.concurrencia_porcentaje_ejecutado"></p-->

                                <h4 class="separador">Entidad Ejecutora</h4>
                                <!--div :class="['form-group',(objProyecto.entidad_ejecutora_cod.clase).trim()?'has-'+objProyecto.entidad_ejecutora_cod.clase:'']">
                                  <label for="" class="form-control-label">Seleccione Entidad Ejecutora</label>
                                  <select

                                          :class="['form-control',(objProyecto.entidad_ejecutora_cod.clase).trim()?'form-control-' + objProyecto.entidad_ejecutora_cod.clase:'']"   
                                          v-model="selected"
                                          
                                          >
                                    <option>Seleccione Entidad Ejecutora</option>
                                    <option 
                                            v-for="(ejecutora,index) in listaEntidades"
                                            
                                             >{{ ejecutora.id_institucion_ejecutora}}
                                    </option>
                                  </select>
                                  
                                  <div class="form-control-feedback" v-text="objProyecto.entidad_ejecutora_cod.mensaje"></div> 
                                </div-->
                                <div :class="['form-group',(entidad.clase).trim()?'has-'+entidad.clase:'']">
                                  <select v-model="entidad.valores"
                                          @change="onchangeEjecutora($event,entidad)"
                                          :class="['form-control',(entidad.clase).trim()?'form-control-' + entidad.clase:'']"   >
                                    <option v-for="product in listaEntidades" 
                                            v-bind:value="{ id: product.id_entidad_ejecutora, denominacion: product.descripcion_entidad_ejecutora }">{{ product.id_entidad_ejecutora }}
                                   </option>
                                  </select>
                                  <div class="form-control-feedback" v-text="entidad.mensaje"></div>
                                </div>
                               <!--h1>Value:
                                 {{selected.id}}
                                 </h1>
                                 <h1>Text:
                                 {{selected.text}}
                                 </h1-->
                                <div class="form-group">
                                  <input type="text" class="form-control" v-model="entidad.valores.denominacion" disabled="disabled">
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default waves-effect" @click="cerrarModal()">Cancelar</button>
                     <button type="submit" class="btn btn-info waves-effect waves-light" @click="validateProyectoInversion()">Guardar Proyecto Inversion</button>
                 </div>
              </form>
           </div>
       </div>
    </div>
    <!--Fin Ventana Modal para los proyectos de Inversiones-->
    <!--Ventana Modal para los entidades Concurrencia-->
    <div class="modal fade" :class="{'show':modalConcurrencia}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog" style="max-width: 600px;">
         <div class="modal-content">
            <form method="post" id="form-otro" name="form-otro" @submit.prevent="">
               <div class="modal-header">
                   <button type="button" class="close" @click="cerrarModalConcurrencia()" aria-hidden="true">×</button>
                   <h4 class="separador">Concurrencia Entidades</h4>
               </div>
               <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card-body p-b-0">
                        <!--h4 class="separador">Concurrencia Entidades</h4-->
                        <div class="col-lg-12" >
                          <div class="p-20" >
                            <div :class="['form-group',(objEntidad.nombre_entidad.clase).trim()?'has-'+ objEntidad.nombre_entidad.clase:'']">
                              <label for="nombre_entidad" class="form-control-label" >Nombre Entidad </label>
                              <input type="text" 
                                      name="nombre_entidad" 
                                      v-model="objEntidad.nombre_entidad.input"
                                      :class="['form-control',(objEntidad.nombre_entidad.clase).trim()?'form-control-' + objEntidad.nombre_entidad.clase:'']"
                                      @keyup="todoTexto(objEntidad.nombre_entidad)"
                                      >
                              <div class="form-control-feedback" v-text="objEntidad.nombre_entidad.mensaje"></div>
                            </div>
                            <!--div :class="['form-group',(objEntidad.programacion_entidad.clase).trim()?'has-'+ objEntidad.programacion_entidad.clase:'']">
                              <label for="programacion" class="form-control-label">Programacion:</label>

                              <div class="input-group m-b-10">
                                <span class="input-group-addon">Bs.</span>
                                <input type="number" 
                                      name="programacion"   
                                      :class="['form-control',(objEntidad.programacion_entidad.clase).trim()?'form-control-' + objEntidad.programacion_entidad.clase:'']"
                                      v-model="objEntidad.programacion_entidad.input"
                                      @keyup="midecimal(objEntidad.programacion_entidad)">
                              </div>
                              <div class="form-control-feedback" v-text="objEntidad.programacion_entidad.mensaje"></div>
                            </div-->
                            <div :class="['form-group',(objEntidad.programacion_entidad.clase).trim()?'has-'+objEntidad.programacion_entidad.clase:'']">
                              <label class="form-control-label" for="inputSuccess1">Programacion</label>
                              <div class="input-group">
                                <span class="input-group-addon">Bs.</span>
                                <input type="text"  id="inputSuccess1" v-model="objEntidad.programacion_entidad.input" 
                                    :class="['form-control',(objEntidad.programacion_entidad.clase).trim()?'form-control-' + objEntidad.programacion_entidad.clase:'']"
                                     @keyup="midecimal(objEntidad.programacion_entidad);porcentajeConcurrencia()"   
                                >
                              </div>
                              <div class="form-control-feedback" v-text="objEntidad.programacion_entidad.mensaje"></div>
                              <small class="form-text text-muted">La "," es separador de decimales.</small>
                            </div>
                            <div :class="['form-group',(objEntidad.ejecucion_entidad.clase).trim()?'has-'+objEntidad.ejecucion_entidad.clase:'']">
                              <label class="form-control-label" for="inputSuccess1">Ejecucion</label>
                              <div class="input-group">
                                <span class="input-group-addon">Bs.</span>
                                <input type="text"  id="inputSuccess1" v-model="objEntidad.ejecucion_entidad.input" 
                                    :class="['form-control',(objEntidad.ejecucion_entidad.clase).trim()?'form-control-' + objEntidad.ejecucion_entidad.clase:'']"
                                     @keyup="midecimal(objEntidad.ejecucion_entidad);porcentajeConcurrencia()"   
                                >
                              </div>
                              <div class="form-control-feedback" v-text="objEntidad.ejecucion_entidad.mensaje"></div>
                              <small class="form-text text-muted">La "," es separador de decimales.</small>
                            </div>
                            <!--div :class="['form-group',(objEntidad.ejecucion_entidad.clase).trim()?'has-'+ objEntidad.ejecucion_entidad.clase:'']">
                              <label for="fuente_financiamiento" class="form-control-label">Ejecucion:</label>
                              <div class="input-group m-b-10">
                                <span class="input-group-addon">Bs.</span>
                                <input  type="text" name="fuente_financiamiento"  class="form-control" 
                                        v-model="objEntidad.ejecucion_entidad.input"
                                        :class="['form-control',(objEntidad.ejecucion_entidad.clase).trim()?'form-control-' + objEntidad.ejecucion_entidad.clase:'']"
                                        @keyup="midecimal(objEntidad.ejecucion_entidad)">
                              </div>
                              <div class="form-control-feedback" v-text="objEntidad.ejecucion_entidad.mensaje"></div>
                            </div-->
                              <label for="fuente_financiamiento" class="control-label">% Ejecucion:</label>
                              <p v-if="((!objEntidad.programacion_entidad.input) || (!objEntidad.ejecucion_entidad.input))">Debe llenar los campos Programacion y Ejecucion para hallar el porcentaje
                              </p>
                              <p v-else 
                                class="text-info" 
                                style="font-size:16px"  
                                v-model = "objEntidad.porcentaje_ejecucion_entidad"
                                >
                                {{ objEntidad.porcentaje_ejecucion_entidad + '%' }}
                              </p>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default waves-effect" @click="cerrarModalConcurrencia()">Cancelar</button>
                   <button type="submit" class="btn btn-info waves-effect waves-light" @click="validateEntidadConcurrencia()" v-show="!accionFormEntidad">Guardar Entidad</button>
                   <button type="button" class="btn btn-warning waves-effect waves-light" @click="validateEntidadConcurrencia()" v-show="accionFormEntidad">Actualizar Entidad</button>
               </div>
            </form>
         </div>
     </div>
    </div>
<!--Fin Ventana Modal para los concurrencia Entidades-->

    

  </div>
</template>


<script>
import moment from 'moment'
export default {
    data(){
        return{
          arrayInstitucion:[],
          arrayListaObjetivosInversion:[],
          modal:0,
          modalConcurrencia:0,
          showEntidad:false,
          objEntidad:{
            id_entidad_concurrencia : "",
            nombre_entidad:{
              input:"",
              clase:"",
              mensaje:""
            },
            programacion_entidad:{
              input:"",
              clase:"",
              mensaje:""
            },
            ejecucion_entidad:{
              input:"",
              clase:"",
              mensaje:""
            },
            porcentaje_ejecucion_entidad:"",
          },
          arrayEntidades:[],
          
          objProyecto : {
            costo_total_proyecto:{
              input:"",
              clase:"",
              mensaje:"",
            },
            periodo_ejecucion_del:{
              input:"",
              clase:"",
              mensaje:""
            },
            periodo_ejecucion_al:{
              input:"",
              clase:"",
              mensaje:""
            },
            entidad_ejecutora_cod:{
              input:"",
              clase:"",
              mensaje:""
            },
            concurrencia_eta_programacion :"",
            concurrencia_eta_ejecucion : ""
          },
          id_proyecto_poa : "",
          id_accion_eta :"",
          id_arrayEntidades:0,
          accionFormEntidad : false,
          c :0,
          indexArrayEntidades:"",
          mensajeEntidades : false,
          mostrarEye :false,
          id_entidad_concurrencia:"",
          estado_modulo:"",
          plan_activo:"",
          gestion_activa:"",
          listaEntidades:[],
          descripcion_entidad_ejecutora:"",
          entidad: {
            valores:{
              id:'',
              denominacion:''
            },
            clase:'',
            mensaje:''
          },
          errorsConcurrencia:[]

          

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
      listaObjetivosProyectosInversion(){
        let me = this;
        axios.get('/api/planesTerritoriales/listaObjetivosProyectosInversion').then(function(response){
          
          me.arrayListaObjetivosInversion = response.data.objetivoProyectos;
          me.estado_modulo = response.data.estado_modulo;
          me.plan_activo = response.data.plan_activo;
          me.gestion_activa = response.data.gestion_activa;
          console.log(me.arrayListaObjetivosInversion);
          console.log(response);
        })
        .catch(function(error){
          console.log(error);
        })
      },
      formatPrice(value) {
        let val = (value/1).toFixed(2).replace(',', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
      },
      salirModulo(){
          let me = this;
          me.$root.$data.views = 5;
          //window.location = "/planesTerritoriales/index";
      },
      abrirModal(e,key,index){
        //console.log("llegue a abrir Modal");
        
        console.log(key,index);
         let me = this;
         me.id_proyecto_poa = key;
         me.id_accion_eta = index;
          switch (e) {
            case 1:
              me.objProyecto = {
            costo_total_proyecto:{
              input:"",
              clase:"",
              mensaje:"",
            },
            periodo_ejecucion_del:{
              input:"",
              clase:"",
              mensaje:""
            },
            periodo_ejecucion_al:{
              input:"",
              clase:"",
              mensaje:""
            },
            entidad_ejecutora_cod:{
              input:"",
              clase:"",
              mensaje:""
            },
            concurrencia_eta_programacion :"",
            concurrencia_eta_ejecucion : ""
          },
              me.objProyecto.nombre_proyecto = me.arrayListaObjetivosInversion[key].proyectosInversion[index].nombre;
              me.objProyecto.id_proyecto_inversion = "nuevo";
              //console.log(me.objProyecto.nombre_proyecto);

              this.modal = 1;
              break;
            case 2:
              //recuperar datos par aupdate con axios
              this.modal = 1;
              me.objProyecto.nombre_proyecto = me.arrayListaObjetivosInversion[key].proyectosInversion[index].nombre;
              
              var costo_total_proyecto = me.convertirFormato(me.arrayListaObjetivosInversion[key].proyectosInversion[index].costo_total_proyecto);
              console.log(costo_total_proyecto);
              me.objProyecto.costo_total_proyecto.input = costo_total_proyecto;
              me.objProyecto.periodo_ejecucion_del.input = me.arrayListaObjetivosInversion[key].proyectosInversion[index].periodo_ejecucion_del;
              me.objProyecto.periodo_ejecucion_al.input = me.arrayListaObjetivosInversion[key].proyectosInversion[index].periodo_ejecucion_al;
              //console.log(me.arrayListaObjetivosInversion[key].proyectosInversion[index].entidad_ejecutora_cod)
              
              me.entidad.valores.id  = me.arrayListaObjetivosInversion[key].proyectosInversion[index].entidad_ejecutora_cod;
              console.log(me.entidad.valores);
              me.entidad.valores.denominacion = me.arrayListaObjetivosInversion[key].proyectosInversion[index].entidad_ejecutora_denominacion;

              break;
            default:
           }
      },
      cerrarModal(){
        this.modal = 0;
      },
      abrirModalConcurrencia(e,clave,index,id_ent){
        
         let me = this;
         me.id_accion_eta = clave;
         me.id_proyecto_poa = index;
         if(id_ent == -1){
          console.log("entidad nueva");
         }else{
          me.id_entidad_concurrencia = clave;
         }
         
         me.objEntidad = {
            id_entidad_concurrencia : "",
            nombre_entidad : {
              input:"",
              clase:"",
              mensaje:""
            },
            programacion_entidad : {
              input:"",
              clase:"",
              mensaje:""
            },
            ejecucion_entidad : {
              input:"",
              clase:"",
              mensaje:""
            },
            porcentaje_ejecucion_entidad:""
          }

          switch (e) {
            case 1:
              //me.arrayEntidades = me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].entidadesConcurrencia;
              //console.log(me.objProyecto.nombre_proyecto);
              me.objEntidad.id_entidad_concurrencia ="nuevo";
              

              this.modalConcurrencia = 1;
              break;
            case 2:
              //recuperar datos par aupdate con axios
              this.modalConcurrencia = 1;
              //me.objProyecto.id_accion_eta = me.arrayListaObjetivosInversion[me.id_proyecto_poa].id_accion_eta;
              //me.objProyecto.id_proyecto_poa = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].id;
              me.objEntidad = {
                id_entidad_concurrencia : "",
                nombre_entidad:{
                  input:"",
                  clase:"",
                  mensaje:""
                },
                programacion_entidad:{
                  input:"",
                  clase:"",
                  mensaje:""
                },
                ejecucion_entidad:{
                  input:"",
                  clase:"",
                  mensaje:""
                },
                porcentaje_ejecucion_entidad:""
              };
              me.objEntidad.nombre_entidad.input = me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].entidadesConcurrencia[me.id_entidad_concurrencia].nombre_entidad;

              var programacion_entidad = me.convertirFormato(me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].entidadesConcurrencia[me.id_entidad_concurrencia].programacion_entidad);
              me.objEntidad.programacion_entidad.input = programacion_entidad;

              var ejecucion_entidad = me.convertirFormato(me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].entidadesConcurrencia[me.id_entidad_concurrencia].ejecucion_entidad);
              me.objEntidad.ejecucion_entidad.input = ejecucion_entidad;

              me.objEntidad.porcentaje_ejecucion_entidad = me.formatPrice(me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].entidadesConcurrencia[me.id_entidad_concurrencia].porcentaje_ejecucion_entidad);
              console.log(me.objEntidad.porcentaje_ejecucion_entidad);


              me.accionFormEntidad = true;

              me.objEntidad.id_entidad_concurrencia = me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].entidadesConcurrencia[me.id_entidad_concurrencia].id;


              break;
            default:
           }
      },
      cerrarModalConcurrencia(){
        this.modalConcurrencia = 0;
      },
      mostrarFormEntidad(){
        let me = this;
        
        me.showEntidad = true;
            me.objEntidad.nombre_entidad = "";
            me.objEntidad.programacion_entidad = "";
            me.objEntidad.ejecucion_entidad = "";
            me.objEntidad.porcentaje_ejecucion_entidad = "";
        //this.$refs.search.focus();
      },
      editarFormEntidad(clave){
        console.log(clave);
        let me = this;
        me.showEntidad = true;
        me.accionFormEntidad = true;
        me.indexArrayEntidades = clave;
        me.objEntidad.nombre_entidad = me.arrayEntidades[clave].nombre_entidad;
        me.objEntidad.programacion_entidad = me.arrayEntidades[clave].programacion_entidad;
        me.objEntidad.ejecucion_entidad = me.arrayEntidades[clave].ejecucion_entidad;
        me.objEntidad.porcentaje_ejecucion_entidad = me.arrayEntidades[clave].porcentaje_ejecucion_entidad;
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
      volverEntidades(){
        let me = this;
        me.showEntidad = false;
      },
      guardarEntidadesConcurrencia(){
        let me = this;
        var enviarEntidad = {};
        enviarEntidad.id_accion_eta = me.arrayListaObjetivosInversion[me.id_accion_eta].id_accion_eta;
        enviarEntidad.id_proyecto_poa = me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].id;
        
        enviarEntidad.nombre_entidad = me.objEntidad.nombre_entidad.input;
        var programacion_entidad = (me.replaceAll(me.objEntidad.programacion_entidad.input,".","")).split(',').join('.');
        enviarEntidad.programacion_entidad = programacion_entidad;
        var ejecucion_entidad = (me.replaceAll(me.objEntidad.ejecucion_entidad.input,".","")).split(',').join('.');
        enviarEntidad.ejecucion_entidad = ejecucion_entidad;
        enviarEntidad.porcentaje_ejecucion_entidad = (ejecucion_entidad/programacion_entidad)*100;
        console.log(enviarEntidad);
        axios({
          method:'post',
          url:'/api/planesTerritoriales/saveEntidadesConcurrencia',
          data:{
            entidadConcurrente : enviarEntidad
          }
        })
        .then(function(response){
          console.log(response);
          swal("Datos guardados", "Los datos se guardaron correctamente", "success");
          //me.id_proyecto_poa = key;
          //me.id_accion_eta = index;
          
          me.listaObjetivosProyectosInversion();
          me.modalConcurrencia = 0;
          me.objEntidad = {
            id_entidad_concurrencia : "",
            nombre_entidad : {
              input:"",
              clase:"",
              mensaje:""
            },
            programacion_entidad : {
              input:"",
              clase:"",
              mensaje:""
            },
            ejecucion_entidad : {
              input:"",
              clase:"",
              mensaje:""
            },
            porcentaje_ejecucion_entidad:""
          }
        })
        .catch(function(error){

        })

        
        me.showEntidad = false;
      },
      actualizarEntidadesConcurrencia(id){
        console.log("estoy en actualizar Concurrencia");
        let me = this;

        var enviarEntidad = {};
        enviarEntidad.id_accion_eta = me.arrayListaObjetivosInversion[me.id_proyecto_poa].id_accion_eta;
        enviarEntidad.id_proyecto_poa = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].id;
        
        enviarEntidad.nombre_entidad = me.objEntidad.nombre_entidad.input;
        var programacion_entidad = (me.replaceAll(me.objEntidad.programacion_entidad.input,".","")).split(',').join('.');
        enviarEntidad.programacion_entidad = programacion_entidad;
        var ejecucion_entidad = (me.replaceAll(me.objEntidad.ejecucion_entidad.input,".","")).split(',').join('.');
        enviarEntidad.ejecucion_entidad = ejecucion_entidad;
        enviarEntidad.porcentaje_ejecucion_entidad = (ejecucion_entidad/programacion_entidad)*100;
        console.log(enviarEntidad);

        enviarEntidad.id_entidad_concurrencia = me.objEntidad.id_entidad_concurrencia;
        axios({
          method:'post',
          url:'/api/planesTerritoriales/updateEntidadesConcurrencia',
          data:{
            updateEntidad : enviarEntidad
          }
        })
        .then(function(response){
          console.log(response);
          swal("Datos guardados", "Los datos se guardaron correctamente", "success");
          me.modalConcurrencia = 0;
          me.objEntidad = {
            id_entidad_concurrencia:"",
            nombre_entidad : {
              input:"",
              clase:"",
              mensaje:""
            },
            programacion_entidad : {
              input:"",
              clase:"",
              mensaje:""
            },
            ejecucion_entidad : {
              input:"",
              clase:"",
              mensaje:""
            },
            porcentaje_ejecucion_entidad:""

          }

          me.listaObjetivosProyectosInversion();
        })
        .catch(function(error){
          console.log(error);
        })
      },
      mostrarMensajeEntidades(){
        let me = this;
        
        /*setTimeout(function(){
          me.mensajeEntidades = true;
        },2000)
        me.mensajeEntidades = false;*/
        me.showEntidad = false;
      },
      guardarProyectoInversion(){
        
        let me = this;
        var enviarInversion = {};
        enviarInversion.id_accion_eta = me.arrayListaObjetivosInversion[me.id_proyecto_poa].id_accion_eta;
        enviarInversion.id_proyecto_poa = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].id;
        if(me.objProyecto.id_proyecto_inversion == "nuevo"){
          enviarInversion.id_proyecto_inversion = "nuevo";
        }else{
          enviarInversion.id_proyecto_inversion = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].id_proyecto_inversion;
        }
        
        var costo_total_proyecto = (me.replaceAll(me.objProyecto.costo_total_proyecto.input,".","")).split(',').join('.');
        enviarInversion.costo_total_proyecto = costo_total_proyecto;
        enviarInversion.periodo_ejecucion_al = me.objProyecto.periodo_ejecucion_al.input;
        enviarInversion.periodo_ejecucion_del = me.objProyecto.periodo_ejecucion_del.input;
        enviarInversion.concurrencia_eta_programacion = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].monto_poa_planificado;
        enviarInversion.concurrencia_eta_ejecucion = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].monto_poa_ejecutado;
        enviarInversion.concurrencia_porcentaje_ejecutado = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].monto_poa_porcentaje;
        enviarInversion.entidad_ejecutora_cod = me.entidad.valores.id;
        enviarInversion.entidad_ejecutora_denominacion = me.entidad.valores.denominacion; 
        //me.objProyecto.id_accion_eta = me.arrayListaObjetivosInversion[me.id_proyecto_poa].id_accion_eta;
        //me.objProyecto.id_proyecto_poa = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].id;
        //me.objProyecto.concurrencia_porcentaje_ejecutado = (me.objProyecto.concurrencia_eta_ejecucion/me.objProyecto.concurrencia_eta_programacion)*100;
        
        me.arrayEntidades.id_accion_eta = me.arrayListaObjetivosInversion[me.id_proyecto_poa].id_accion_eta;
        me.arrayEntidades.id_proyecto_poa = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].id;
        console.log(enviarInversion);
        axios({
          method:'post',
          url: '/api/planesTerritoriales/saveProyectoInversion',
          data:{
            proyecto:enviarInversion,
            entidades:me.arrayEntidades

          }
        })
        .then(function(response){
          console.log(response);
          swal("Datos guardados", "Los datos se guardaron correctamente", "success");
          me.listaObjetivosProyectosInversion();
          me.cerrarModal();
          enviarInversion = {};
          me.objProyecto = {
            costo_total_proyecto:{
              input:"",
              clase:"",
              mensaje:"",
            },
            periodo_ejecucion_del:{
              input:"",
              clase:"",
              mensaje:""
            },
            periodo_ejecucion_al:{
              input:"",
              clase:"",
              mensaje:""
            },
            entidad_ejecutora_cod:{
              input:"",
              clase:"",
              mensaje:""
            },
            concurrencia_eta_programacion :"",
            concurrencia_eta_ejecucion : ""
          };
        })
        .catch(function(error){
          console.log(error)
        })
      },
      verEntidades(id){
        let me = this;
        
        $("#eye_'+ id +'").show();
        //me.mostrarEye = !me.mostrarEye ;
      },
      formatYear(value){
        return moment(String(value)).format("MM/DD/YYYY");
      },
      listaEntidadesEjecutoras(){
        let me = this;

        axios.get('/api/planesTerritoriales/listaEntidadesEjecutoras').then(function(response){

          console.log(response);
          me.listaEntidades = response.data.entidadesEjecutoras;
        })
        .catch(function(error){
          console.log(error);
        })
      },
      mostrarEntidad(event){
        console.log(event.target.value)
      },
      validateProyectoInversion(){

        console.log("hola desde validateProyectoInversion");
        let me = this;
        me.errors = [];
          
          if(!me.objProyecto.costo_total_proyecto.input){
            me.objProyecto.costo_total_proyecto.clase = "warning";
            me.objProyecto.costo_total_proyecto.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          if(!me.objProyecto.periodo_ejecucion_del.input){
            me.objProyecto.periodo_ejecucion_del.clase = "warning";
            me.objProyecto.periodo_ejecucion_del.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          if(!me.objProyecto.periodo_ejecucion_al.input){
            me.objProyecto.periodo_ejecucion_al.clase = "warning";
            me.objProyecto.periodo_ejecucion_al.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          if(!me.entidad.valores){
            me.entidad.clase = "warning";
            me.entidad.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          
          if (me.errors.length>0) {
            console.log("datos Con errores");
            me.errors=[];
            return false;
          }else{
            console.log("datos sin errores, ENVIAR AL SERVIDOR");
            me.guardarProyectoInversion();
          }
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
          //console.log("components"+components);

          if (components.length === 1){
            //quiere decir que no hay decimales
            components[0] = yourNumber;
            components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            //console.log("hola replaceCommas primer if");
            data.clase = "success";
            data.mensaje = "formato correcto";
          } 
            
          if (components.length === 2){
            //si hay decimales
            components[1] = components[1].replace(/\D/g, "");
            //console.log("hola replaceCommas segundo if");
            data.clase = "success";
            data.mensaje = "formato correcto";
          }
              
          //return components.join(".");
          return components.join(",");
      },
      replaceAll( text, busca, reemplaza ){
        while (text.toString().indexOf(busca) != -1)
            text = text.toString().replace(busca,reemplaza);
        return text;
      },
      onchange(event,data){
        let me = this;
        
        data.clase = "success";
        data.mensaje = "Eligio una opcion";
      },
      onchangeEjecutora(event,data){
        let me = this;
          console.log(data);
          
        me.entidad.clase = "success";
        me.entidad.mensaje = "Eligio una opcion";
      },
      onFechas(event,data){
        let me = this;
        var inicio = me.objProyecto.periodo_ejecucion_del.input;
        var fin = me.objProyecto.periodo_ejecucion_al.input;
        console.log(me.objProyecto.periodo_ejecucion_del.input);
        console.log(me.objProyecto.periodo_ejecucion_al.input);
        if(!inicio){
          me.objProyecto.periodo_ejecucion_del.clase= "warning";
          me.objProyecto.periodo_ejecucion_del.input= "Debe escribir una fecha";
        }else{
          if(inicio < fin){
            data.clase = "success";
            data.mensaje = "Eligio una opcion";
          }else{
            data.clase = "danger";
            data.mensaje = "Esta fecha no puede ser menor al Periodo de Ejecucion Inicial";
          }
        }
      },
      todoTexto(data){
        let me = this;
        if(data.input){
          data.clase = "success";
          data.mensaje = "Escribio un nombre de Proyecto";
        }else{
          data.clase = "warning";
          data.mensaje = "Escribio nombre Entidad no puede estar vacio";
        }
      },
      convertirFormato(data){
        var components = data.toString().split(".");
        var completa = components[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".")+","+components[1];
        return completa;
        
      },
      validateEntidadConcurrencia(){
        console.log("hola desde validateEntidadConcurrencia");
        let me = this;
        me.errorsConcurrencia = [];
          
          if(!me.objEntidad.nombre_entidad.input){
            me.objEntidad.nombre_entidad.clase = "warning";
            me.objEntidad.nombre_entidad.mensaje = "El campo esta vacio";
            me.errorsConcurrencia.push('Valid email required.');
          }
          if(!me.objEntidad.programacion_entidad.input){
            me.objEntidad.programacion_entidad.clase = "warning";
            me.objEntidad.programacion_entidad.mensaje = "El campo esta vacio";
            me.errorsConcurrencia.push('Valid email required.');
          }
          if(!me.objEntidad.ejecucion_entidad.input){
            me.objEntidad.ejecucion_entidad.clase = "warning";
            me.objEntidad.ejecucion_entidad.mensaje = "El campo esta vacio";
            me.errorsConcurrencia.push('Valid email required.');
          }
          
          
          if (me.errorsConcurrencia.length>0) {
            console.log("datos Con errores");
            me.errorsConcurrencia=[];
            return false;
          }else{
            console.log("datos sin errores, ENVIAR AL SERVIDOR");
            if(me.objEntidad.id_entidad_concurrencia == 'nuevo'){
              me.guardarEntidadesConcurrencia();
              console.log("crear concurrencia");
            }else{
              me.actualizarEntidadesConcurrencia();
              console.log("actualizar concurrencia");
            }
            
          }
      },
      reporteInversionGestionExcel(){
        location.href = '/api/planesTerritoriales/reporteInversionGestionExcel';
      },
      reporteInversionGestionPdf(){
       location.href = '/api/planesTerritoriales/reporteInversionGestionPdf'; 
      },
      porcentajeConcurrencia(){
        let me = this;
        if(me.objEntidad.programacion_entidad || me.objEntidad.programacion_entidad){
          var programacion_entidad = (me.replaceAll(me.objEntidad.programacion_entidad.input,".","")).split(',').join('.');
          var ejecucion_entidad = (me.replaceAll(me.objEntidad.ejecucion_entidad.input,".","")).split(',').join('.');
          if(ejecucion_entidad){
            var por = (ejecucion_entidad/programacion_entidad)*100;
            me.objEntidad.porcentaje_ejecucion_entidad = me.formatPrice(por);
            console.log(por);  
          }
        }
      },
      deleteEntidad(id){
        //alert("hola desde delete");
        //console.log(id);
         let me = this;
         swal({
           title: "Está seguro?",
           text: "No podrá recuperar este registro!",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: "#DD6B55",
           confirmButtonText: "Si, eliminar!",
           closeOnConfirm: false
         }, function(){
               axios({
                  method: 'post',
                  url: '/api/planesTerritoriales/deleteEntidad',
                  data: {
                    id : id
                  }
                }).then(function (response) {
                   me.listaObjetivosProyectosInversion();
                   console.log(response);
                   swal("Eliminado!", "Se ha eliminado tu registro.", "success");
                }).catch(function (error) {
                  console.log(error);
                });
         });
      },
      
     

    },
    mounted() {
        this.listaObjetivosProyectosInversion();
        this.listaEntidadesEjecutoras();
        this.datosUsuario();

        $(".panel-left").resizable({
          handleSelector: ".splitter",
          resizeHeight: false
        });
    }
}


</script>
<style media="screen">
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
input{
  margin-bottom:15px;
}


/* Important part */
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 500px;
    overflow-y: auto;
}
.separador{
    line-height: 22px;
    font-size: 18px;
    margin-bottom: 30px;
    color: #FB9678;
    border-bottom: 2px solid #FB9678;
    padding-bottom: 5px;
    margin-top: 30px;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fb9678a3;
    opacity: 1;
}
input {
    margin-bottom: 25px;
}
#agregarColor {
    color: #fff;
    
    
}
.modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}
.miTabla{
  width:90%;
  max-width:700px;
  min-width:520px;
  margin:auto;
}




</style>