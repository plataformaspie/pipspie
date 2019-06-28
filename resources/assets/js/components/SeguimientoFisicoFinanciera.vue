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
    <!--div class="row">
      <div class="col-lg-12 " style="background-color:#FB9678;">
        <div class=" p-l-25" >
        <h2 style="color:#FFF"class="p-l-20 p-t-10 m-0">SEGUIMIENTO FISICO FINANCIERO</h2> 
        <h5 style="color:#FFF" class="p-l-20 m-t-5">PLAN :{{ planActivo}}</h5>   
        <h5 style="color:#FFF" class="p-l-20 m-t-5">GESTION : {{ gestionActiva}}</h5>
        </div>
      </div>
    </div-->
    <div class="row p-t-10 mipanelx">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="white-box p-0 m-0 p-l-10 p-r-10 p-t-10 p-b-10">
            <h4 class="m-t-0">SEGUIMIENTO FISICO FINANCIERO</h4>
            <div class="card">
              <div class="table-responsive white-box" >
                <h4 class="m-t-0"></h4>
                <table id="art" class="table table-bordered color-table info-table">
                  <thead>
                    <tr>
                      <th  style="background:#0AF3D3; color:#fff" rowspan="3" class="text-center"  ><strong></strong>GESTION RIESGO</th>
                      <th  style="background:#0AF3D3; color:#fff" rowspan="3" class="text-center"  ><strong></strong></th>
                      
                      <th  style="background:#0AF3D3; color:#fff; vertical-align:middle;" rowspan="3"><strong  >ACCION ETA</strong></th>
                      <th  style="background:#0AF3D3; color:#fff; vertical-align:middle;" rowspan="3"><strong>LINEA BASE</strong></th>
                      <th  style="background:#0AF3D3; color:#fff; vertical-align:middle;" rowspan="3"><strong>INDICADOR DE PROCESO</strong></th>
                      <th  style="background:#09D4E8; color:#fff" colspan="4" class="text-center"><strong>PROGRAMACION PTDI</strong></th>
                      <th  style="background:#03B1FF; color:#fff" colspan="4" class="text-center"><strong>PROGRAMACION PEI</strong></th>
                      <th  style="background:#0973E8; color:#fff" colspan="6" class="text-center"><strong>PROGRAMACION POA</strong></th>
                      <th  style="background:#0973E8; color:#fff; vertical-align:middle;" rowspan="3" class="text-center"><strong>CAUSAS DESVIACION</strong></th>
                      
                    </tr>
                    <tr>
                      
                      <th style="background:#09D4E8; color:#fff" colspan="2" class="text-center"><strong>FINANCIERA</strong></th>
                      <th style="background:#09D4E8; color:#fff" colspan="2" class="text-center"><strong>ACCION</strong></th>
                      <th style="background:#03B1FF; color:#fff" colspan="2" class="text-center"><strong>FINANCIERA</strong></th>
                      <th style="background:#03B1FF; color:#fff" colspan="2" class="text-center"><strong>ACCION</strong></th>
                      <th style="background:#0973E8; color:#fff" colspan="3" class="text-center"><strong>FINANCIERA</strong></th>
                      <th style="background:#0973E8; color:#fff; " colspan="3" class="text-center"><strong>ACCION</strong></th>

                    </tr>
                    <tr>
                      
                      <th style="background:#09D4E8; color:#fff"   class="text-center"><strong>Pf</strong></th>
                      <!--th style="background:#09D4E8; color:#fff"   class="text-center"><strong>E</strong></th-->
                      <th style="background:#09D4E8; color:#fff"   class="text-center"><strong>%Ef</strong></th>
                      <th style="background:#09D4E8; color:#fff"  class="text-center"><strong>Pa</strong></th>
                      <!--th style="background:#09D4E8; color:#fff"  class="text-center"><strong>E</strong></th-->
                      <th style="background:#09D4E8; color:#fff"  class="text-center"><strong>%Ea</strong></th>
                      <th style="background:#03B1FF; color:#fff" class="text-center"><strong>Pf</strong></th>
                      <!--th style="background:#03B1FF; color:#fff" class="text-center"><strong>E</strong></th-->
                      <th style="background:#03B1FF; color:#fff" class="text-center"><strong>%Ef</strong></th>
                      <th style="background:#03B1FF; color:#fff" class="text-center"><strong>Pf</strong></th>
                      <!--th style="background:#03B1FF; color:#fff" class="text-center"><strong>E</strong></th-->
                      <th style="background:#03B1FF; color:#fff" class="text-center"><strong>%Ef</strong></th>
                      <th style="background:#0973E8; color:#fff"class="text-center"><strong>Pf</strong></th>
                      <th style="background:#0973E8; color:#fff"class="text-center"><strong>E</strong></th>
                      <th style="background:#0973E8; color:#fff"class="text-center"><strong>%Ef</strong></th>
                      <th style="background:#0973E8; color:#fff"class="text-center"><strong>Pf</strong></th>
                      <th style="background:#0973E8; color:#fff"class="text-center"><strong>E</strong></th>
                      <th style="background:#0973E8; color:#fff"class="text-center"><strong>%Ef</strong></th>

                    </tr>

                  </thead>
                  <tbody>
                    <tr v-for="(eta, index) in arrayObjetivoEta">
                      <td>
                        
                          <input type="checkbox"  v-model="eta.es_gestion_riesgos" value="" name="check'+ eta.id_accion_eta +'" disabled="disabled">
                          
                          
                      </td>
                      <td class="text-nowrap">
                        <a v-show="estado_modulo" v-if="eta.id_financiero_poa != ''" style="display:inline-block;" href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar POA" @click="abrirModal(index, 2)"><i class="fa fa-edit fa-lg fa-2x    " style="color:#0973E8"></i></a> 
                        <a v-show="estado_modulo" v-else  style="display:inline-block;" href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" title="Agregar POA " @click="abrirModal(index, 1)"><i class="fa fa-plus fa-lg fa-2x   text-info " style="color:#0973E8"></i></a> 
                        <!--a href="#"  class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-info "></i></a-->
                      </td>
                      
                      
                      <td style="width: 200px; word-wrap: break-word;"> {{ eta.descripcion}}</td>
                      <td style="width: 200px; word-wrap: break-word;">  {{ eta.linea_base }}</td>
                      
                      <td>
                        {{ eta.nombre_indicador}}

                      </td>
                      <td>{{ eta.monto }}</td>
                      <td>{{ eta.porcentaje_ptdi * 100}} %</td>
                      <td>{{ eta.valor}}</td>
                      <td>{{ eta.porcentaje_ptdi * 100 }}  %</td>
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
                  </tbody>
                </table>
                
              </div>
            </div>
          </div>
        </div>  
      </div>
    
    <div class="row">
      
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="white-box p-0 m-0 p-t-10 ">
          <div class="form-group text-center p-0 m-0">
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
          <form id="formPoa" class="formPoa" @submit.prevent="savePoa()">
            <div class="modal-body">
            
              <div class="row">
                <div class="col-lg-12">
                  <div role="tabpanel">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"> <a class="nav-link show" data-toggle="tab" href="#messages2" role="tab" aria-selected="false"><span><i class="fa fa-files-o"></i></span> <span class="hidden-xs-down">POA</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane p-20 show" id="messages2" role="tabpanel">
                          <div class="form-group">
                            <div class="row">
                              <div class="col-lg-6" >
                                <h5 class="m-b-10">FINANCIERA</h5>
                                <section>
                                  <label  class="control-label" >Programado POA:</label>
                                  <input type="text" class="form-control m-b-10" name="fisico" id="fisico" placeholder="Programado"  required="required"  title="Avance Fisico" pattern="^[0-9]+$"  v-model="arrayPoa.monto_poa">
                                </section>
                                <section>
                                  <label  class="control-label" >Ejecutado POA:</label>
                                  <input type="text" class="form-control m-b-10" name="fisico" id="fisico" placeholder="Ejecutado"  required="required"  title="Ejecutado" pattern="^[0-9]+$" v-model="arrayPoa.ejecutado">
                                </section>
                                <section>
                                    <label  class="control-label" >Causas de Desviacion:</label>
                                    <input type="text" class="form-control m-b-10" name="fisico" id="fisico" placeholder="Causas de Desviacion"  required="required"  title="Causas de Desviacion"  v-model="arrayPoa.causas_variacion">
                                </section>
                               </div>
                              <div class="col-lg-6">
                                <h5 class="m-b-10">ACCION</h5>
                                
                                  <section>
                                    <label  class="control-label" >Programado Accion POA:</label>
                                    <input type="text" class="form-control m-b-10" name="fisico" id="fisico" placeholder="Programado"  required="required"  title="Programado" pattern="^[0-9]+$"  v-model="arrayPoa.programado_accion">
                                  </section>
                                  <section>
                                    <label  class="control-label" >Ejecutado Accion POA:</label>
                                    <input type="text" class="form-control m-b-10" name="fisico" id="fisico" placeholder="Avance Fisico"  required="required"  title="Ejecutado" pattern="^[0-9]+$" v-model="arrayPoa.ejecutado_accion">
                                  </section>
                                  <section class="m-b-15">
                                    <label  class="control-label" >ACCION ETA ES: UNA ACCION DE GESTION DE RIEGOS:</label>
                                    <label class="radio-inline">
                                    <input type="radio" value="true" name="radioPtdi"  v-model ="arrayPoa.gestion_riesgos" required="required">Si</label>
                                    <label class="radio-inline">
                                    <input type="radio" value="false" name="radioPtdi"  v-model ="arrayPoa.gestion_riesgos" required="required">No</label>
                                    
                                  </section>
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
          arrayPoa:{},
          idEta:"",
          planActivo:"",
          gestionActiva:"",
          estado_modulo:"",
          plan_activo:"",
          gestion_activa:""
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
            console.log(response);
            console.log(me.arrayObjetivoEta);
            me.planActivo = response.data.planActivo;
            me.gestionActiva = response.data.gestionActiva;
            me.estado_modulo = response.data.estado_modulo;
            me.plan_activo = response.data.plan_activo; 
            me.gestion_activa = response.data.gestion_activa;            
            
          })
          .catch(function (error) {
           // handle error
           console.log(error);
          });
      },

      savePoa(){
        let me = this;

        console.log(me.arrayPoa);
        //*************PTDI*********************//
        //Ptdi monto programado
        me.arrayPoa.monto_programado = me.arrayObjetivoEta[me.idEta].monto;
         //diferencia Ptdi financiera porcentaje poa/ejecutado*100
        me.arrayPoa.porcentaje_ptdi = (me.arrayPoa.monto_poa/me.arrayObjetivoEta[me.idEta].monto)*100;
         //accion programado ptdi
        me.arrayPoa.accion_programado = me.arrayObjetivoEta[me.idEta].valor; 
         // Ptdi accion porcentaje
        me.arrayPoa.accion_porcentaje = (me.arrayPoa.valor/me.arrayObjetivoEta[me.idEta].valor)*100;
        //************* FIN PTDI********************

        //**************ASUMIENDO QUE EL PTDI = PEI *************************//
        //Ptdi monto programado
        me.arrayPoa.monto_programado_pei = me.arrayObjetivoEta[me.idEta].monto;
         //diferencia Ptdi financiera porcentaje poa/ejecutado*100
        me.arrayPoa.porcentaje_pei = (me.arrayPoa.monto_poa/me.arrayObjetivoEta[me.idEta].monto)*100;
         //accion programado ptdi
        me.arrayPoa.accion_programado_pei = me.arrayObjetivoEta[me.idEta].valor;
         // Ptdi accion porcentaje
        me.arrayPoa.accion_porcentaje_pei = (me.arrayPoa.valor/me.arrayObjetivoEta[me.idEta].valor)*100;

        //**************FIN ASUMIENDO QUE EL PTDI = PEI *************************//
        
        //**************POA******************************************************// 
        //POA planificado
        //me.arrayPOA.monto_poa
        //POA ejecutado
        //POA porcentaje
        
        //POA accion planificado
        //POA accion ejecutado
        //POA accion porcentaje
        //
        //porcentaje_poa_programado
        me.arrayPoa.porcentaje_poa_programado = (me.arrayPoa.monto_poa/me.arrayPoa.ejecutado)*100;
        //porcentaje_poa_accion
        me.arrayPoa.porcentaje_poa_accion = (me.arrayPoa.monto_poa/me.arrayPoa.ejecutado)*100;
        me.arrayPoa.id_accion_eta_objetivo = me.arrayObjetivoEta[me.idEta].id_accion_eta_objetivo;//***** id del Objetivo ETA ****//
        me.arrayPoa.id_financiero_poa = me.arrayObjetivoEta[me.idEta].id_financiero_poa;
        //id gestion de riesgos id
        me.arrayPoa.id_gestion_riesgos = me.arrayObjetivoEta[me.idEta].id_gestion_riesgos;

        /*if(me.arrayPoa.gestion_riesgos == true){
          //VERIFICANDO VALOR DE GESTION DE RIESGO
          //enviando el id de la accion eta para guardar en la tabla 
          me.arrayPoa.id_gestion_riesgo = me.arrayObjetivoEta[me.idEta].id_financiero_poa;

        }else{
          me.arrayPoa.id_gestion_riesgo = "NO";
        }
        
        console.log(me.arrayPoa,);
        console.log(me.arrayObjetivoEta);*/

        //
        //**************FIN POA******************************************************//

        axios({
          method: 'post',
          url: '/api/planesTerritoriales/saveFinancieroPoa',
          data: {
            datos:me.arrayPoa,
            eta_gestion_riegos:me.arrayObjetivoEta
          }
        }).then(function(response){
          swal("Datos guardados", "Los datos se guardaron correctamente", "success");
          me.listaObjetivoEta();
          me.modal = 0;
          me.arrayPoa.monto_poa = "";
          me.arrayPoa.ejecutado = "";
          me.arrayPoa.causas_variacion = "";
          me.arrayPoa.programado_accion = "";
          me.arrayPoa.ejecutado_accion = "";
        }).catch(function(error){

        });
         
         

        console.log(me.arrayPoa);
      },
      abrirModal(idEta,e){
        console.log("abri el modal para agregar POA...." + idEta);
        let me = this;
        me.idEta = idEta;//es la index del array en donde esta el campo id_accion_eta_ob
        console.log("el id "+ me.arrayObjetivoEta[idEta].id_accion_eta_objetivo);
        //me.arrayPoa.monto = me.arrayObjetivoEta[idEta].monto;
        //me.arrayPoa.valor = me.arrayObjetivoEta[idEta].valor;
        
        switch (e) {
          case 1:
            this.modal = 1;
            break;
          case 2:
            //recuperar datos par aupdate con axio
            
            me.arrayPoa.monto_poa = me.arrayObjetivoEta[idEta].monto_poa_planificado;
            me.arrayPoa.ejecutado = me.arrayObjetivoEta[idEta].monto_poa_ejecutado;
            me.arrayPoa.causas_variacion = me.arrayObjetivoEta[idEta].causas_variacion;
            me.arrayPoa.programado_accion = me.arrayObjetivoEta[idEta].accion_poa_programado;
            me.arrayPoa.ejecutado_accion = me.arrayObjetivoEta[idEta].accion_poa_ejecutado;
            me.arrayPoa.gestion_riesgos = me.arrayObjetivoEta[idEta].es_gestion_riesgos;
            
            this.modal = 1;
            break;
          default:
         }
         
         
      },
      cerrarModal(){
        this.modal = 0;
      },
      salirModulo(){
            window.location = "/planesTerritoriales/index";
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
      }
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




</style>