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
        <table id="art" class="table table-bordered color-table info-table">
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
                        <td class="text-nowrap">
                          <a v-show="estado_modulo" href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" @click="abrirModal(1,clave,index)" title="Editar " ><i class="fa fa-edit fa-lg    text-warning "></i></a> 
                          <!--a href="#"  class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger " @click="abrirModalConcurrencia(1,clave,index)"></i></a-->
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
                        <td>{{ vip.concurrencia_eta_programado }}</td>
                        <td>{{ vip.concurrencia_eta_ejecutado }}</td>
                        <td>{{ vip.concurrencia_porcentaje_ejecutado }}</td>
                        <td>{{ vip.entidad_ejecutora_cod }}</td>
                        <td>{{ vip.entidad_ejecutora_denominacion }}</td>
                        <td><button v-show="estado_modulo" id="agregarColor" :disabled="vip.verificar_existe_proyectos_inversion == 'no hay'"href="#"  class=" btn btn-info m-l-10 m-r-10 m-t-10 sel_edit" @click="abrirModalConcurrencia(1,clave,index)" title="Entidades" style="border-radius:100%;" ><i class="fa fa-plus fa-xs "></i></button></td>
                        <!--td><a href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" @click="verEntidades(vip.id)" title="Ver Entidades " ><i class="fa fa-eye fa-lg    text-info "></i></a></td-->

                        <transition name="fade">
                          <td v-if="vip.verificar_existe_proyectos_inversion == 'si hay'">
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
                                      <a v-show="estado_modulo" href="#"  class="m-l-10 m-r-10 m-t-10 sel_edit" @click="abrirModalConcurrencia(2,clave,index,key)" title="Editar " ><i class="fa fa-edit fa-lg    text-warning "></i></a> 
                                      <!--a href="#"  class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="fa fa-minus-circle fa-lg text-danger " @click="abrirModalConcurrencia(1,clave,index)"></i></a-->
                                    </td>
                                    <td>{{ ent.nombre_entidad}} </td>
                                    <td>{{ ent.programacion_entidad}}</td>
                                    <td>{{ ent.ejecucion_entidad}}</td>
                                    <td v-text="formatPrice(ent.porcentaje_ejecucion_entidad)"></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </td>
                          <td v-else><p>No tiene registrado Entidades<br/> Debe registrar Datos del proyecto de inversion</p></td>
                        </transition>
                        
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
                                  <label for="concepto" class="control-label">Nombre Proyecto</label>
                                  <input type="text" name="concepto" class="form-control" v-model="objProyecto.nombre_proyecto" disabled="disabled">
                                  <label for="fuente_financiamiento" class="control-label">Costo Total:</label>
                                  <input type="text" name="fuente_financiamiento"  class="form-control" v-model="objProyecto.costo_total_proyecto" >
                                  <h6>Periodo de Ejecucion</h6>
                                  <label for="organismo_financiador" class="control-label">Del:</label>
                                  <input type="date" name="organismo_financiador" v class="form-control" v-model="objProyecto.periodo_ejecucion_del" required="required">  
                                  <label for="rubro" class="control-label">Al:</label>
                                  <input type="date" name="rubro"  class="form-control" v-model="objProyecto.periodo_ejecucion_al" required="required">  
                                  <h4 class="separador">Concurrencia ETA</h4>
                                  <label for="fuente_financiamiento" class="control-label">Programacion:</label>
                                  <input type="text" name="fuente_financiamiento"  class="form-control" v-model="objProyecto.concurrencia_eta_programacion" required="required">

                                  <label for="fuente_financiamiento" class="control-label">Ejecucion:</label>
                                  <input type="text" name="fuente_financiamiento"  class="form-control" v-model="objProyecto.concurrencia_eta_ejecucion">
                                  <label for="fuente_financiamiento" class="control-label">% Ejecucion:</label>
                                  <p v-if="(objProyecto.concurrencia_eta_programacion == '')||(objProyecto.concurrencia_eta_ejecucion == '')">Debe llenar los campos Programacion y Ejecucion para hallar el porcentaje</p>
                                  <p v-else class="text-danger" style="font-size:16px"  v-text="formatPrice((objProyecto.concurrencia_eta_ejecucion/objProyecto.concurrencia_eta_programacion)*100)+'%'" v-model="objProyecto.concurrencia_porcentaje_ejecutado"></p>
                                  <h4 class="separador">Entidad Ejecutora</h4>
                                  <label for="organismo_financiador" class="control-label">Codigo Entidad:</label>
                                  <input type="text" name="organismo_financiador"  class="form-control" v-model="objProyecto.entidad_ejecutora_cod">
                                  <label for="rubro" class="control-label">Denominacion Entidad:</label>
                                  <input type="text" name="rubro"  class="form-control" v-model="objProyecto.entidad_ejecutora_denominacion">
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-default waves-effect" @click="cerrarModal()">Cancelar</button>
                       <button type="submit" class="btn btn-info waves-effect waves-light" @click="guardarProyectoInversion()">Guardar Proyecto Inversion</button>
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
                            <div class="form-group">
                              <label for="nombre_entidad" class="control-label" >Nombre Entidad </label>
                              <input type="text" name="nombre_entidad" class="form-control" v-model="objEntidad.nombre_entidad" autofocus="autofocus">
                              <label for="programacion" class="control-label">Programacion:</label>
                              <input type="number" name="programacion"  class="form-control" v-model="objEntidad.programacion_entidad">
                              <label for="fuente_financiamiento" class="control-label">Ejecucion:</label>
                              <input type="number" name="fuente_financiamiento"  class="form-control" v-model="objEntidad.ejecucion_entidad">
                              <label for="fuente_financiamiento" class="control-label">% Ejecucion:</label>
                              <p v-if="(objEntidad.programacion_entidad == '')||(objEntidad.ejecucion_entidad == '')">Debe llenar los campos Programacion y Ejecucion para hallar el porcentaje</p>
                              <p v-else class="text-info" style="font-size:16px"  v-text="formatPrice((objEntidad.ejecucion_entidad/objEntidad.programacion_entidad)*100)+'%'" v-model="objEntidad.pocentaje_ejecucion_entidad"></p>
                               
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default waves-effect" @click="cerrarModalConcurrencia()">Cancelar</button>
                   <button type="submit" class="btn btn-info waves-effect waves-light" @click="guardarEntidadesConcurrencia()" v-show="!accionFormEntidad">Guardar Entidad</button>
                   <button type="button" class="btn btn-warning waves-effect waves-light" @click="actualizarEntidadesConcurrencia(objEntidad.id)" v-show="accionFormEntidad">Actualizar Entidad</button>
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
            id_objEntidad : "",
            nombre_entidad:"",
            programacion_entidad:"",
            ejecucion_entidad:"",
            porcentaje_ejecucion_entidad:""
          },
          arrayEntidades:[],
          objProyecto : {
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
          gestion_activa:""
          

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
          window.location = "/planesTerritoriales/index";
      },
      abrirModal(e,key,index){
        //console.log("llegue a abrir Modal");
        
        console.log(key,index);
         let me = this;
         me.id_proyecto_poa = key;
         me.id_accion_eta = index;
          switch (e) {
            case 1:
              me.objProyecto.nombre_proyecto = me.arrayListaObjetivosInversion[key].proyectosInversion[index].nombre;
              console.log(me.objProyecto.nombre_proyecto);

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
      
      abrirModalConcurrencia(e,key,index,clave){
        
         let me = this;
         me.id_proyecto_poa = key;
         me.id_accion_eta = index;
         me.id_entidad_concurrencia = clave
          switch (e) {
            case 1:
              me.arrayEntidades = me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].entidadesConcurrencia;
              //console.log(me.objProyecto.nombre_proyecto);

              this.modalConcurrencia = 1;
              break;
            case 2:
              //recuperar datos par aupdate con axios
              this.modalConcurrencia = 1;
              //me.objProyecto.id_accion_eta = me.arrayListaObjetivosInversion[me.id_proyecto_poa].id_accion_eta;
              //me.objProyecto.id_proyecto_poa = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].id;
              me.objEntidad.nombre_entidad = me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].entidadesConcurrencia[me.id_entidad_concurrencia].nombre_entidad;
              me.objEntidad.programacion_entidad = me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].entidadesConcurrencia[me.id_entidad_concurrencia].programacion_entidad;
              me.objEntidad.ejecucion_entidad = me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].entidadesConcurrencia[me.id_entidad_concurrencia].ejecucion_entidad;
              me.objEntidad.porcentaje_ejecucion_entidad = me.arrayListaObjetivosInversion[me.id_accion_eta].proyectosInversion[me.id_proyecto_poa].entidadesConcurrencia[me.id_entidad_concurrencia].porcentaje_ejecucion_entidad;
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
        
        me.objEntidad.id_accion_eta = me.arrayListaObjetivosInversion[me.id_proyecto_poa].id_accion_eta;
        me.objEntidad.id_proyecto_poa = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].id;
        me.objEntidad.porcentaje_ejecucion_entidad = (me.objEntidad.ejecucion_entidad/me.objEntidad.programacion_entidad)*100; 
        axios({
          method:'post',
          url:'/api/planesTerritoriales/saveEntidadesConcurrencia',
          data:{
            entidadConcurrente : me.objEntidad
          }
        })
        .then(function(response){
          console.log(response);
          //me.id_proyecto_poa = key;
          //me.id_accion_eta = index;
          me.listaObjetivosProyectosInversion();
          me.modalConcurrencia = 0;
        })
        .catch(function(error){

        })

        
        me.showEntidad = false;

      },
      actualizarEntidadesConcurrencia(id){
        console.log("estoy en actualizar Concurrencia");
        let me = this;
        me.objEntidad.porcentaje_ejecucion_entidad = (me.objEntidad.ejecucion_entidad/me.objEntidad.programacion_entidad)*100; 
        axios({
          method:'post',
          url:'/api/planesTerritoriales/updateEntidadesConcurrencia',
          data:{
            updateEntidad : me.objEntidad
          }
        })
        .then(function(response){
          console.log(response);
          swal("Datos guardados", "Los datos se guardaron correctamente", "success");
          me.modalConcurrencia = 0;
          me.objEntidad.nombre_entidad = "";
          me.objEntidad.programacion_entidad = "";
          me.objEntidad.ejecucion_entidad = "";
          me.objEntidad.porcentaje_ejecucion_entidad = "";

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
        me.objProyecto.id_accion_eta = me.arrayListaObjetivosInversion[me.id_proyecto_poa].id_accion_eta;
        me.objProyecto.id_proyecto_poa = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].id;
        me.objProyecto.concurrencia_porcentaje_ejecutado = (me.objProyecto.concurrencia_eta_ejecucion/me.objProyecto.concurrencia_eta_programacion)*100;
        me.arrayEntidades.id_accion_eta = me.arrayListaObjetivosInversion[me.id_proyecto_poa].id_accion_eta;
        me.arrayEntidades.id_proyecto_poa = me.arrayListaObjetivosInversion[me.id_proyecto_poa].proyectosInversion[me.id_accion_eta].id;

        
        console.log(me.objProyecto.id_proyecto_poa);
        
        
        axios({
          method:'post',
          url: '/api/planesTerritoriales/saveProyectoInversion',
          data:{
            proyecto:me.objProyecto,
            entidades:me.arrayEntidades

          }
        })
        .then(function(response){
          console.log(response);
          swal("Datos guardados", "Los datos se guardaron correctamente", "success");
          me.listaObjetivosProyectosInversion();
          me.modal = 0;
          /*me.arrayPoa.monto_poa = "";
          me.arrayPoa.ejecutado = "";
          me.arrayPoa.causas_variacion = "";
          me.arrayPoa.programado_accion = "";
          me.arrayPoa.ejecutado_accion = "";*/
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
      }
 

    },
    
    mounted() {
        this.listaObjetivosProyectosInversion();
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




</style>