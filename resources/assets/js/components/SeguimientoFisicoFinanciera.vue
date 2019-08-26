<template>
  <div>
    
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
      <div class="col-lg-12">
          <h4 class="m-t-0">SEGUIMIENTO FISICO FINANCIERO</h4>
           <div class="panel-container vtabs">
                <div class="panel-left">
                  <ul class="nav tabs-vertical" >
                      <li v-for="(pro, key) in distinc" :key="pro.agregador" class="tab nav-item" >
                            <a data-toggle="tab" class="nav-link"  :class="{'active': pro.orden == 1}" :href="'#panel'+pro.agregador" aria-expanded="true">
                              <i class="hidden-xs fa fa-dot-circle-o"></i> <span class="hidden-xs" v-text="pro.nombre_programa"></span>
                            </a>
                      </li>
                      
                  </ul>
                </div>
                <div class="splitter">
                </div>
                <div class="panel-right">
                  <div class="tab-content white-box p-10 m-b-0" style="min-width:900px">
                    <div v-for="pro in distinc"  :id="'panel'+ pro.agregador" class="tab-pane" :class="{'active': pro.orden == 1}">
                      <h4 v-text="pro.nombre_programa" class="m-t-0"></h4> <!--i class="fa fa-info-circle"></i> Para decimales usar <b>","</b> coma.-->
                      <div class="table-responsive">      
                        <table class="table"  >
                          <thead>
                            <tr>
                              <th   style="color:#fff" rowspan="3" class="text-center">GESTION RIESGO</th>
                              <th   style="color:#fff" rowspan="3" class="text-center"></th>
                              
                              <th   style="color:#fff" rowspan="3">ACCION ETA</th>
                              <th   style="color:#fff" rowspan="3">LINEA BASE</th>
                              <th   style="color:#fff" rowspan="3">INDICADOR DE PROCESO</th>
                              <th   style="color:#fff" colspan="4" class="text-center">PROGRAMACION PTDI</th>
                              <th   style="color:#fff" colspan="4" class="text-center">PROGRAMACION PEI</th>
                              <th   style="color:#fff" colspan="6" class="text-center">PROGRAMACION POA</th>
                              <th   style="color:#fff; vertical-align:middle;" rowspan="3" class="text-center">CAUSAS DESVIACION</th>
                              
                            </tr>
                            <tr>
                              
                              <th  style="color:#fff" colspan="2" class="text-center">FINANCIERA</th>
                              <th  style="color:#fff" colspan="2" class="text-center">ACCION</th>
                              <th  style="color:#fff" colspan="2" class="text-center">FINANCIERA</th>
                              <th  style="color:#fff" colspan="2" class="text-center">ACCION</th>
                              <th  style="color:#fff" colspan="3" class="text-center">FINANCIERA</th>
                              <th  style="color:#fff" colspan="3" class="text-center">ACCION</th>

                            </tr>
                            <tr>
                              <th style="color:#fff" class="text-center">Pf</th>
                              <th style="color:#fff" class="text-center">%Ef</th>
                              <th style="color:#fff" class="text-center">Pa</th>
                              <th style="color:#fff" class="text-center">%Ea</th>
                              <th style="color:#fff" class="text-center">Pf</th>
                              <th style="color:#fff" class="text-center">%Ef</th>
                              <th style="color:#fff" class="text-center">Pf</th>
                              <th style="color:#fff" class="text-center">%Ef</th>
                              <th style="color:#fff" class="text-center">Pf</th>
                              <th style="color:#fff" class="text-center">E</th>
                              <th style="color:#fff" class="text-center">%Ef</th>
                              <th style="color:#fff" class="text-center">Pf</th>
                              <th style="color:#fff" class="text-center">E</th>
                              <th style="color:#fff" class="text-center">%Ef</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                            <tr v-for="(eta, index) in arrayObjetivoEta" v-if="eta.agregador===pro.agregador " style="">
                              <td>
                                
                                  <input type="checkbox"  v-model="eta.es_gestion_riesgos" value="" name="check'+ eta.id_accion_eta +'" disabled="disabled">
                                  
                                  
                              </td>
                              <td class="text-nowrap">
                                <a v-show="estado_modulo" v-if="eta.id_financiero_poa != ''" style="display:inline-block;" href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar POA" @click="abrirModal(index,eta.agregador, 2)"><i class="fa fa-edit fa-lg" ></i></a> 
                                <a v-show="estado_modulo" v-else  style="display:inline-block;" href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" title="Agregar POA " @click="abrirModal(index,eta.agregador, 1)"><i class="fa fa-plus fa-lg " ></i></a> 
                                <!--a href="#"  class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-info "></i></a-->
                              </td>
                              
                              
                              <td style="width: 200px; word-wrap: break-word;"> {{ eta.descripcion}}</td>
                              <td style="width: 200px; word-wrap: break-word;">  {{ eta.linea_base }}</td>
                              
                              <td>
                                {{ eta.nombre_indicador}}

                              </td>
                              <td>{{ eta.monto }}</td>
                              <td>{{ eta.porcentaje_ptdi}} %</td>
                              <td>{{ eta.valor}}</td>
                              <td v-if="eta.porcentaje_accion_ptdi == ''"> </td>
                              <td v-else>{{ eta.porcentaje_accion_ptdi }} % </td>
                              
                              <td>0,00</td>
                              <td>0,00</td>
                              <td>0,00</td>
                              <td>0,00</td>
                              <td>{{ eta.monto_poa_planificado }}</td>
                              <td>{{ eta.monto_poa_ejecutado }}</td>
                              <td v-if="eta.monto_poa_porcentaje == ''"> </td>
                              <td v-else>{{ eta.monto_poa_porcentaje }} % </td>
                              <td>{{ eta.accion_poa_programado }}</td>
                              <td>{{ eta.accion_poa_ejecutado }}</td>
                              <td v-if="eta.accion_poa_porcentaje == ''"> </td>
                              <td v-else>{{ eta.accion_poa_porcentaje  }} %</td>
                              <td>{{ eta.causas_variacion}}</td>
                            </tr>
                            <tr style="background-color:#B33822; border:2px solid #B33822; color:#fff;"v-for="(totales, key) in totales_programa" v-if="totales.agregador===pro.agregador">
                              <td colspan="5">TOTALES</td>
                              <td >{{ formatPrice(totales.total_ptdi_planificado) }}</td>
                              <td >{{ formatPrice(totales.total_ptdi_porcentaje_ejecutado ) }}</td>
                              <td >{{ formatPrice(totales.total_accion_ptdi_planificado) }}</td>
                              <td >{{ formatPrice(totales.total_accion_ptdi_ejecutado) }}</td>
                              <td ></td>
                              <td ></td>
                              <td ></td>
                              <td ></td>
                              <td >{{ formatPrice(totales.total_monto_poa_planificado) }}</td>
                              <td >{{ formatPrice(totales.total_monto_poa_ejecutado) }}</td>
                              <td >{{ formatPrice(totales.total_monto_poa_porcentaje) }}</td>
                              <td >{{ formatPrice(totales.total_accion_poa_planificado) }}</td>
                              <td >{{ formatPrice(totales.total_accion_poa_ejecutado) }}</td>
                              <td >{{ formatPrice(totales.total_accion_poa_porcentaje) }}</td>
                             
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="white-box p-0 m-0 p-t-10 ">
          <div class="form-group text-center p-0 m-0">
                <button v-show="estado_modulo==true" type="submit" class="btn btn-success" @click="reporteFinancieroGestionExcel">Exportar <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
                <button v-show="estado_modulo==true" type="submit" class="btn btn-danger" @click="reporteFinancieroGestionPdf">Exportar <i class="fa fa-file-pdf-o " aria-hidden="true"></i></button>
                <button v-show="estado_modulo==true" type="submit" class="btn btn-info" @click="finalizarModulo(8)">Salir y Finalizar</button>
                <button type="submit" class="btn btn-default" @click="salirModulo()">Salir</button>
          </div>
        </div>
      </div>
    </div>
      <!-- Fin codigio CRIS-->
    <div class="modal fade" :class="{'show':modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-content">
          <div class="modal-header">
               <button type="button" class="close" @click="cerrarModal()" aria-hidden="true">×</button>
               <h4 class="modal-title">AVANCE GESTION </h4>
          </div>
          <form id="formPoa" class="formPoa" @submit.prevent="validarPoa()">
            <div class="modal-body">
            
              <div class="row">
                <div class="col-lg-12">
                  <div role="tabpanel">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"> <a class="nav-link show" data-toggle="tab" href="#messages2" role="tab" aria-selected="false"><span><i class="fa fa-files-o"></i></span> <span class="hidden-xs-down">POA</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show" id="messages2" role="tabpanel">
                          <div class="form-group">
                            <div class="row">
                              <div class="col-lg-6" >
                                <h5 class="m-b-10 ">FINANCIERA</h5>
                                <div :class="['form-group',(arrayPoa.monto_poa.clase).trim()?'has-'+arrayPoa.monto_poa.clase:'']">
                                
                                  <label  class="form-control-label" >Programado POA:</label>
                                  <div class="input-group m-b-10">
                                    <span class="input-group-addon">Bs.</span>
                                    <input type="text" :class="['form-control',(arrayPoa.monto_poa.clase).trim()?'form-control-' + arrayPoa.monto_poa.clase:'']" name="fisico" id="fisico" placeholder=""  title="Avance Fisico"   v-model="arrayPoa.monto_poa.input"
                                    @keyup="midecimal(arrayPoa.monto_poa)" >
                                    <!--div class="form-control-feedback" v-text="arrayPoa.monto_poa.mensaje"></div-->
                                  </div>
                                </div>
                                <div :class="['form-group',(arrayPoa.ejecutado.clase).trim()?'has-'+arrayPoa.ejecutado.clase:'']">
                                  <label  class="form-control-label" >Ejecutado POA:</label>
                                  <div class="input-group m-b-10">
                                    <span class="input-group-addon">Bs.</span>
                                    <input type="text" :class="['form-control',(arrayPoa.ejecutado.clase).trim()?'form-control-' + arrayPoa.ejecutado.clase:'']" name="fisico" id="fisico" placeholder=""    title="Ejecutado"  v-model="arrayPoa.ejecutado.input"
                                    @keyup="midecimal(arrayPoa.ejecutado)">
                                  </div>
                                </div>
                                <div :class="['form-group',(arrayPoa.causas_variacion.clase).trim()?'has-'+arrayPoa.causas_variacion.clase:'']">
                                  <label  class="form-control-label" >Causas de Variacion:</label>
                                  <input type="text"  id="inputSuccess1" v-model="arrayPoa.causas_variacion.input" 
                                      :class="['form-control',(arrayPoa.causas_variacion.clase).trim()?'form-control-' + arrayPoa.causas_variacion.clase:'']"
                                       @keyup="todoTexto(arrayPoa.causas_variacion)"   
                                  >
                                  <div class="form-control-feedback" v-text="arrayPoa.causas_variacion.mensaje"></div>
                                  <!--small class="form-text text-muted">La "," es separador de decimales.</small-->
                                </div>
                                
                               </div>
                              <div class="col-lg-6">
                                <h5 class="m-b-10 ">ACCION</h5>
                                
                                  <div :class="['form-group',(arrayPoa.programado_accion.clase).trim()?'has-'+arrayPoa.programado_accion.clase:'']">
                                    <label  class="form-control-label" >Programado Accion POA:</label>
                                    <div class="input-group m-b-10">
                                      <span class="input-group-addon"><i class="fa fa-building-o" aria-hidden="true"></i></span>
                                      <input type="text" :class="['form-control',(arrayPoa.programado_accion.clase).trim()?'form-control-' + arrayPoa.programado_accion.clase:'']" name="fisico" id="fisico" placeholder="Programado"    title="Programado"  v-model="arrayPoa.programado_accion.input"
                                      @keyup="midecimal(arrayPoa.programado_accion)">
                                    </div>
                                  </div>
                                  <div :class="['form-group',(arrayPoa.ejecutado_accion.clase).trim()?'has-'+arrayPoa.ejecutado_accion.clase:'']">
                                    <label  class="form-control-label" >Ejecutado Accion POA:</label>
                                    <div class="input-group m-b-10">
                                      <span class="input-group-addon"><i class="fa fa-line-chart" aria-hidden="true"></i></span>
                                      <input type="text" :class="['form-control',(arrayPoa.ejecutado_accion.clase).trim()?'form-control-' + arrayPoa.ejecutado_accion.clase:'']" name="fisico" id="fisico" placeholder="Avance Fisico"   title="Ejecutado" v-model="arrayPoa.ejecutado_accion.input"
                                      @keyup="midecimal(arrayPoa.ejecutado_accion)">
                                    </div>
                                  </div>
                                  <!--div :class="['form-group',(arrayPoa.gestion_riesgos.clase).trim()?'has-'+arrayPoa.gestion_riesgos.clase:'']">
                                    <label  class="control-label" >ACCION ETA ES: UNA ACCION DE GESTION DE RIEGOS:</label>
                                    <label class="radio-inline">
                                    <input @change="validateRatio(arrayPoa.gestion_riesgos)"type="radio" value="true" name="radioRiesgos"  v-model ="arrayPoa.gestion_riesgos" required="required">Si</label>
                                    <label class="radio-inline">
                                    <input @change="validateRatio(arrayPoa.gestion_riesgos)"type="radio" value="false" name="radioRiesgos"  v-model ="arrayPoa.gestion_riesgos" required="required">No</label>
                                    
                                  </div-->
                                  <div :class="['form-group',(arrayPoa.gestion_riesgos.clase).trim()?'has-'+arrayPoa.gestion_riesgos.clase:'']">
                                    <div class=" radio-inline form-check-label">
                                      <h5  class="form-check control-label" >ACCION ETA ES: UNA ACCION DE GESTION DE RIEGOS:</h5>
                                      <label class="radio-inline radio-inline"><input type="radio" value="true" name="radioRiesgos"  v-model ="arrayPoa.gestion_riesgos.input" @change="validateRatio(arrayPoa.gestion_riesgos)" >Si</label>
                                      <label class="radio-inline radio-inline"><input type="radio" value="false" name="radioRiesgos"  v-model ="arrayPoa.gestion_riesgos.input" @change="validateRatio(arrayPoa.gestion_riesgos)" >No</label>  
                                      <div class="form-control-feedback" v-text="arrayPoa.gestion_riesgos.mensaje"></div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div>  
                        </div><!--POA-->
                    </div>

                  </div>
                </div>
              </div>
            </div>  
            <div class="modal-footer">
             <button type="button" class="btn btn-default waves-effect" @click="cerrarModal()">Cancelar</button>
             <button type="submit" class="btn btn-info waves-effect waves-light" >Guardar</button>
            </div>
          </form>
        </div>      
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data(){
        return{
          arrayObjetivoEta:[],
          arrayInstitucion:[],
          show:false,
          arrayUser:[],
          editar:true,
          guardar:false,
          modal:0,
          arrayPoa:{
            causas_variacion:{
              input:"",
              clase:"",
              mensaje:""
            },
            monto_poa:{
              input:"",
              clase:"",
              mensaje:""
            },
            ejecutado:{
              input:"",
              clase:"",
              mensaje:""
            },
            programado_accion:{
              input:"",
              clase:"",
              mensaje:""
            },
            ejecutado_accion:{
              input:"",
              clase:"",
              mensaje:""
            },
            gestion_riesgos:{
              input:"",
              clase:"",
              mensaje:""
            }
          },
          idEta:"",
          planActivo:"",
          gestionActiva:"",
          estado_modulo:"",
          plan_activo:"",
          gestion_activa:"",
          errors:[],
          carpetas:[
            {
              id:1,
              name:"Search",
              ver:false,
              orden:1,
              pages :[
                { name:"Facebook" },
                { name:"Google" },
                { name:"Opera" }
              ]
            },
            {
              id:2,
              name:"Email",
              ver:false,
              orden:2,
              pages :[
                { name:"Gmail" },
                { name:"Outlook" },
                { name: "yahooo" }
              ]
            }
          ],
          distinc:[],
          programas:[],
          acciones_eta_programas:[],
          totales_programa:[]
        
      }
    },
    methods: {
      showModal(){
       this.show = true;
      },
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
      listaObjetivoEta(){

        let me = this;
          axios.get('/api/planesTerritoriales/listaAvanceObjetivos').then(function (response) {
            me.arrayObjetivoEta = response.data.objEta;
            //console.log(response);
            //console.log(response.data.distinc);
            me.distinc = response.data.distinc;
            //console.log(me.arrayObjetivoEta);
            me.planActivo = response.data.planActivo;
            me.gestionActiva = response.data.gestionActiva;
            me.estado_modulo = response.data.estado_modulo;
            me.plan_activo = response.data.plan_activo; 
            me.gestion_activa = response.data.gestion_activa;  
            me.programas = response.data.programas;
            me.acciones_eta_programas = response.data.distinc;  
            me.totales_programa = response.data.totales_programa;        
            
          })
          .catch(function (error) {
           // handle error
           console.log(error);
          });
      },

      savePoa(){
        let me = this;
          var enviarPoa = {};
        //console.log(me.arrayPoa);
        /*arrayPoa.causas_variacion.input

        arrayPoa.monto_poa.input
        arrayPoa.ejecutado.input
        arrayPoa.programado_accion.input      
        arrayPoa.ejecutado_accion.input 
        arrayPoa.gestion_riesgos.input */   
        

        enviarPoa.id_accion_eta_objetivo = me.arrayObjetivoEta[me.idEta].id_accion_eta_objetivo;
        var monto_poa = (me.replaceAll(me.arrayPoa.monto_poa.input,".","")).split(',').join('.');
        enviarPoa.monto_poa = monto_poa;
        var ejecutado = (me.replaceAll(me.arrayPoa.ejecutado.input,".","")).split(',').join('.');
        enviarPoa.ejecutado = ejecutado;
        enviarPoa.porcentaje_poa_programado = (monto_poa/ejecutado)*100;
        var programado_accion = (me.replaceAll(me.arrayPoa.programado_accion.input,".","")).split(',').join('.');
        enviarPoa.programado_accion = programado_accion;
        var ejecutado_accion = (me.replaceAll(me.arrayPoa.ejecutado_accion.input,".","")).split(',').join('.');
        enviarPoa.ejecutado_accion = ejecutado_accion;
        //console.log(ejecutado_accion);//20
        //console.log(ejecutado);//40
        enviarPoa.porcentaje_poa_accion = (ejecutado_accion/programado_accion)*100;
        enviarPoa.porcentaje_ptdi = (monto_poa/me.arrayObjetivoEta[me.idEta].monto)*100;
        //aumentadon accion_ptd
        enviarPoa.porcentaje_accion_ptdi = (ejecutado_accion/me.arrayObjetivoEta[me.idEta].valor)*100;
        //fin aumentadon accion_ptd
        enviarPoa.porcentaje_pei = 0;
        enviarPoa.causas_variacion = me.arrayPoa.causas_variacion.input;
        enviarPoa.id_financiero_poa = me.arrayObjetivoEta[me.idEta].id_financiero_poa;
        enviarPoa.gestion_riesgos= me.arrayPoa.gestion_riesgos.input;
        enviarPoa.id_gestion_riesgos = me.arrayObjetivoEta[me.idEta].id_gestion_riesgos;
        

        axios({
          method: 'post',
          url: '/api/planesTerritoriales/saveFinancieroPoa',
          data: {
            datos:enviarPoa,
            eta_gestion_riegos:me.arrayObjetivoEta
          }
        }).then(function(response){
          swal("Datos guardados", "Los datos se guardaron correctamente", "success");
          me.listaObjetivoEta();
          me.modal = 0;
          enviarPoa = {};
          me.arrayPoa = {
            causas_variacion:{
              input:"",
              clase:"",
              mensaje:""
            },
            monto_poa:{
              input:"",
              clase:"",
              mensaje:""
            },
            ejecutado:{
              input:"",
              clase:"",
              mensaje:""
            },
            programado_accion:{
              input:"",
              clase:"",
              mensaje:""
            },
            ejecutado_accion:{
              input:"",
              clase:"",
              mensaje:""
            },
            gestion_riesgos:{
              input:"",
              clase:"",
              mensaje:""
            }
          },
          me.errors = []
          /*me.arrayPoa.monto_poa = "";
          me.arrayPoa.ejecutado = "";
          me.arrayPoa.causas_variacion = "";
          me.arrayPoa.programado_accion = "";
          me.arrayPoa.ejecutado_accion = "";*/
        }).catch(function(error){
            console.log(error);
        });
         
         

        //console.log(me.arrayPoa);
      },
      abrirModal(idEta,idPro,e){
        //console.log("abri el modal para agregar POA...." + idEta);
        let me = this;
        me.idEta = idEta;//es la index del array en donde esta el campo id_accion_eta_ob
        //console.log("el id "+ me.arrayObjetivoEta[idEta].id_accion_eta_objetivo);
        var index = me.distinc.indexOf(idPro);
        const resultado = me.distinc.indexOf( fruta => fruta.agregador === idPro );
        //console.log("el id programa index"+ resultado );
        //folder.nombre_programa
        //me.arrayPoa.monto = me.arrayObjetivoEta[idEta].monto;
        //me.arrayPoa.valor = me.arrayObjetivoEta[idEta].valor;
        
        switch (e) {
          case 1:
            this.modal = 1;
            break;
          case 2:
            //recuperar datos par aupdate con axio
            
            
            me.arrayPoa.monto_poa.input = me.convertirFormato(me.arrayObjetivoEta[idEta].monto_poa_planificado);
            me.arrayPoa.ejecutado.input = me.convertirFormato(me.arrayObjetivoEta[idEta].monto_poa_ejecutado);
            me.arrayPoa.causas_variacion.input = me.arrayObjetivoEta[idEta].causas_variacion;
            me.arrayPoa.programado_accion.input = me.convertirFormato(me.arrayObjetivoEta[idEta].accion_poa_programado);
            me.arrayPoa.ejecutado_accion.input = me.convertirFormato(me.arrayObjetivoEta[idEta].accion_poa_ejecutado);
            me.arrayPoa.gestion_riesgos.input = me.arrayObjetivoEta[idEta].es_gestion_riesgos;

            /*me.arrayPoa.monto_poa.input = me.convertirFormato(me.distinc[idPro].objetivos_eta_programa[idEta].monto_poa_planificado);
            me.arrayPoa.ejecutado.input = me.convertirFormato(me.distinc[idPro].objetivos_eta_programa[idEta].monto_poa_ejecutado);
            me.arrayPoa.causas_variacion.input = me.arrayObjetivoEta[idEta].causas_variacion;
            me.arrayPoa.programado_accion.input = me.convertirFormato(me.distinc[idPro].objetivos_eta_programa[idEta].accion_poa_programado);
            me.arrayPoa.ejecutado_accion.input = me.convertirFormato(me.distinc[idPro].objetivos_eta_programa[idEta].accion_poa_ejecutado);
            me.arrayPoa.gestion_riesgos.input = me.distinc[idPro].objetivos_eta_programa[idEta].es_gestion_riesgos;*/
            
            this.modal = 1;
            break;
          default:
         }
         
         
      },
      cerrarModal(){
        this.modal = 0;
      },
      salirModulo(){
        let me = this;
        me.$root.$data.views = 5;
           // window.location = "/planesTerritoriales/index";
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
      todoTexto(data){
        let me = this;
        if(data.input){
          data.clase = "success";
          data.mensaje = "";
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
      validateRatio(data){
        if(!data.input){
          data.clase = 'warning';
          data.mensaje = "Debe seleccionar una oopcion";  

        }else{
          data.clase = 'success';
          data.mensaje = "";  

        }
      },
      validarPoa(){
        let me = this;
        me.errors = [];
          
          if(!me.arrayPoa.monto_poa.input){
            me.proyPoa.nombre.clase = "warning";
            me.proyPoa.nombre.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          if(!me.arrayPoa.ejecutado.input){
            me.proyPoa.avance_fisico.clase = "warning";
            me.proyPoa.avance_fisico.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          if(!me.arrayPoa.programado_accion.input){
            me.proyPoa.monto.clase = "warning";
            me.proyPoa.monto.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          if(!me.arrayPoa.ejecutado_accion.input){
            me.proyPoa.monto.clase = "warning";
            me.proyPoa.monto.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          
          //////////////////////
          var checked_gestion_riesgos = $('input:radio[name=radioRiesgos]:checked').val()
          //console.log("es ptdi"+ checked_gestion_riesgos);
          if(!checked_gestion_riesgos){
            me.arrayPoa.gestion_riesgos.clase = "warning";
            me.arrayPoa.gestion_riesgos.mensaje = "Debe elegir un opcion";
            me.errors.push('Valid email required.');
          }
          
          if (me.errors.length>0) {
            //console.log("datos Con errores");
            me.errors=[];
            return false;
          }else{
            //console.log("datos sin errores, ENVIAR AL SERVIDOR");
            me.savePoa();
          }

      },
      convertirFormato(data){
        var components = data.toString().split(".");
        var completa = components[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".")+","+components[1];
        return completa;
        
      },
      reporteFinancieroGestionExcel(){
        //location.href = '/api/planesTerritoriales/reporteFinancieroGestionExcel';
        location.href = '/api/planesTerritoriales/reporteFinancieroProgramaGestionExcel';
      },
      reporteFinancieroGestionPdf(){
        //location.href = '/api/planesTerritoriales/reporteFinancieroGestionPdf';
        location.href = '/api/planesTerritoriales/reporteFinancieroProgramaGestionPdf';
      },
      toggle(folder){
        console.log("hola desde toggle");
        /*
        console.log(document.getElementById(idname).style.display);
        if(document.getElementById(idname).style.display == "none"){
          document.getElementById(idname).style.display = "inline-block";
        }else{
          document.getElementById(idname).style.display = "none";
        }*/
        folder.ver = !folder.ver;
      },
      formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
      },
    },
    mounted() {
        
        this.listaObjetivoEta();
        this.datosUsuario();

        $(".panel-left").resizable({
          handleSelector: ".splitter",
          resizeHeight: false
        });
    }
}


</script>
<style>
.color1{
  background-color:#0AF3D3;
  color:#fff;
}
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
.show {

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
.custom-control {
    position: relative;
    display: block;
    min-height: 1.3125rem;
    padding-left: 1.5rem;
}





.custom-control-label {
    position: relative;
    vertical-align: top;
}
.btn-group-toggle>.btn, .btn-group-toggle>.btn-group>.btn, .custom-control-label, .custom-file, .dropdown-header, .input-group-text, .nav {
    margin-bottom: 0;
}
user agent stylesheet
label {
    cursor: default;
}
.custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #fb9678;
    background-color: #fb9678;
}
.custom-checkbox .custom-control-label::before {
    border-radius: .25rem;
}
.custom-control-label::after, .custom-control-label::before {
    top: .15rem;
}
.custom-control-label::before, .custom-file-label, .custom-select {
    transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.custom-control-label::before {
    pointer-events: none;
    background-color: #fff;
    border: 1px solid #adb5bd;
}
.custom-control-label::after, .custom-control-label::before {
    position: absolute;
    left: -1.5rem;
    display: block;
    width: 1rem;
    height: 1rem;
    content: "";
}
.custom-checkbox .custom-control-input:checked~.custom-control-label::after {
    background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8…M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e);
}
.modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}
miTabla{
  max-width:900px;
  max-height:560px;
}

.table{
  font:Poppins,sans-serif;
  font-size:14px;
  color:#ffffff;
}
.table thead {
  
  /*background-color: #fb9678;*/
  background-color: #FF654A
  
}
.table tbody{
  text-align: right;
}


</style>