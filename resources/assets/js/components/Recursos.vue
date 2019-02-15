<template>
    <div style="font-size:12px !important;">

      <div class="row p-t-10 ">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="white-box p-0 m-0 p-l-10 p-r-10 p-t-10 p-b-10"  >

              <div class="row list-group-item-info">
                <ul class="feeds ">
                    <li class="m-t-10 m-l-10 m-r-10 m-b-10 p-0">
                        <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa  fa-institution text-white" style="line-height: 25px;"></i></div>
                          Denominacion: <strong v-text="arrayInstitucion.denominacion"></strong>
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
                 <strong class="text-center">Total recursos determinados</strong>
                 <hr class="p-0 m-0"/>
                 <div class="user-btm-box p-t-0">
                   <div  class="row m-t-10 p-t-10 list-group-item-info">
                       <template v-for="totales in arrayTotales">
                           <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 b-r">
                             <p v-text="totales.gestion+':'" class="m-b-0"></p>
                             <strong v-text="'Bs.'+formatPrice(totales.total)"></strong>
                           </div>
                       </template>
                       <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 b-r">
                         <p v-text="'TOTAL PRESUPUESTO:'" class="m-b-0"></p>
                         <strong style="font-size:20px;"> Bs.{{ formatPrice(totalPresupuesto) }}</strong> <!--  @{{total}}-->
                       </div>
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
                            <li v-for="gruposRecursos in arrayGruposRecursos" :key="gruposRecursos.id" class="tab nav-item" >
                                  <a data-toggle="tab" class="nav-link"  :class="{'active': gruposRecursos.orden == 1}" :href="'#panel'+gruposRecursos.id" aria-expanded="true">
                                    <i class="hidden-xs fa fa-dot-circle-o"></i> <span class="hidden-xs" v-text="gruposRecursos.valor"></span>
                                  </a>
                            </li>
                        </ul>
                      </div>

                      <div class="splitter">
                      </div>

                      <div class="panel-right">
                          <transition name="fade">
                            <div class="row" style="position:absolute; top:5;" v-if="auxiliar">
                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="white-box p-10 m-b-0">
                                      <input type="hidden" name="id_auxiliar" v-model="id_auxiliar">
                                      <ul class="list-unstyled weather-days row">
                                          <li class="col-xs-4 col-sm-3" style="border-right: 1px solid rgba(120,130,140,.13);"><span class="m-b-10">Gestiones</span><br/>
                                            <b>2016</b><br/>
                                            <b>2017</b><br/>
                                            <b>2018</b><br/>
                                            <b>2019</b><br/>
                                            <b>2020</b>
                                          </li>
                                          <li class="col-xs-4 col-sm-6"><span>Montos</span>
                                              <textarea name="montos_auxiliar" v-model="montos_auxiliar" rows="5" cols="22"></textarea>
                                          </li>
                                          <li class="col-xs-4 col-sm-3">
                                              <br/><br/><br/>
                                              <button @click="transformarAuxiliar" class="btn btn-outline btn-default btn-sm">Enviar</button>
                                          </li>
                                      </ul>
                                </div>
                              </div>
                            </div>
                          </transition>
                          <div class="tab-content" style="min-width:900px">
                              <div v-for="gruposRecursos in arrayGruposRecursos"  :id="'panel'+gruposRecursos.id" class="tab-pane" :class="{'active': gruposRecursos.orden == 1}">
                                    <div v-if="gruposRecursos.valor !== 'Otros Ingresos'" class="table-responsive">
                                      <h4 v-text="gruposRecursos.valor" class="m-t-0"></h4> <!--i class="fa fa-info-circle"></i> Para decimales usar <b>","</b> coma.-->
                                          <table class="table table-bordered list-group-item-warning">
                                              <thead>
                                                  <tr>
                                                    <th>#</th>
                                                    <th>Tipo recurso</th>
                                                    <th v-for="periodo in  arrayPeriodoActivo" class="text-center"> {{ periodo }}</th>
                                                    <th>Action</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <tr v-for="tiposRecursos in arrayTipoRecursos" v-if="tiposRecursos.valor===gruposRecursos.valor " style="">
                                                      <template v-if="arrayRecursosCreados.includes(tiposRecursos.id)">
                                                          <td></td>
                                                          <td>{{ tiposRecursos.nombre }}</td>
                                                          <td v-for="periodo in arrayPeriodoActivo">
                                                            <input type="hidden" :name="'id_'+tiposRecursos.id+'_'+periodo" class="form-control " :value="arrayRecursosCreadosGestiones['id'][tiposRecursos.id][periodo]" style="height: 28px;text-align: right;" >
                                                            <input type="text" :name="tiposRecursos.id+'_'+periodo" :class="'form-control dis'+tiposRecursos.id" :value="formatPrice(arrayRecursosCreadosGestiones['monto'][tiposRecursos.id][periodo])" style="height: 28px;text-align: right;" @blur="formatInput" :disabled="estadoViewComponente ? disabled : ''">
                                                          </td>
                                                          <td class="text-nowrap">
                                                            <template v-if="estadoViewComponente">
                                                              <a href="#" @click="saveUpdate(tiposRecursos.id)"> <i class="fa fa-save text-inverse m-r-10" style="font-size:20px;"></i> </a>
                                                              <a href="#" @click="deleteRecurso(tiposRecursos.id)"> <i class="fa fa-trash-o text-inverse m-r-10" style="font-size:20px;"></i> </a>
                                                            </template>
                                                          </td>
                                                      </template>
                                                      <template v-else>
                                                          <td>
                                                            <template v-if="estadoViewComponente">
                                                              <input type="checkbox" :name="'chk'+tiposRecursos.id" @change="checkSw(tiposRecursos.id)">
                                                            </template>
                                                          </td>
                                                          <td>{{ tiposRecursos.nombre }}</td>
                                                          <td v-for="periodo in arrayPeriodoActivo">
                                                            <!-- @keyup.ctrl.86="cargarDatosExcel" -->
                                                            <input type="text" :name="tiposRecursos.id+'_'+periodo" :class="'form-control dis'+tiposRecursos.id" value="0" disabled="disabled" style="height: 28px;text-align: right;" @blur="formatInput" >
                                                          </td>
                                                          <td class="text-nowrap">
                                                              <template v-if="estadoViewComponente">
                                                                <a href="#" @click="save(tiposRecursos.id)"> <i class="fa fa-save text-inverse m-r-10" style="font-size:20px;"></i> </a>
                                                                <a href="#" @click="acitvarAux(tiposRecursos.id)"> <i class="fa fa-copy text-inverse m-r-10" style="font-size:20px;"></i> </a>
                                                              </template>
                                                          </td>
                                                      </template>
                                                  </tr>
                                              </tbody>
                                          </table>
                                      </div>
                                      <div v-else>
                                        <h4 class="m-t-0">Otros Ingresos:
                                          <template v-if="estadoViewComponente">
                                            <a href="#" @click="abrirModal(1)" data-original-title="Save"> <i class="fa fa-plus-square text-inverse m-r-10" style="font-size:30px;"></i></a>
                                          </template>
                                        </h4>
                                        <table class="table table-bordered list-group-item-warning">
                                            <thead>
                                                <tr>
                                                  <th>Descripción</th>
                                                  <th v-for="periodo in  arrayPeriodoActivo" class="text-center"> {{ periodo }}</th>
                                                  <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="otrosIngresos in arrayOtrosIngresos">
                                                    <td>
                                                      <p><b>Concepto:</b><br/>{{ otrosIngresos.concepto }}</p>
                                                      <p><b>Fuente Financiamiento:</b><br/>{{ otrosIngresos.fuente_financiamiento }}</p>
                                                      <p><b>Organismo Financiador:</b><br/>{{ otrosIngresos.organismo_financiador }}</p>
                                                      <p><b>Rubro:</b><br/>{{ otrosIngresos.rubro }}</p>
                                                      <p><b>Entidad Otorgante:</b><br/>{{ otrosIngresos.entidad_otorgante }}</p>
                                                    </td>
                                                     <td v-for="periodo in arrayPeriodoActivo"> <!-- DO= dETALLEoTRO -->
                                                      <input type="text" :name="'DO_'+periodo" class="form-control" :value="formatPrice(arrayOtrosIngresosRecursosCreadosGestiones['datos'][otrosIngresos.id][periodo])" disabled="disabled" style="height: 28px;text-align: right;">
                                                    </td>
                                                    <td>
                                                      <template v-if="estadoViewComponente">
                                                        <a href="#" @click="updateOtro(otrosIngresos.id)"> <i class="fa fa-edit text-inverse m-r-10" style="font-size:20px;"></i> </a>
                                                        <a href="#" @click="deleteOtro(otrosIngresos.id)"> <i class="fa fa-trash-o text-inverse m-r-10" style="font-size:20px;"></i> </a>
                                                      </template>
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
                    <button v-if="estadoViewComponente" type="submit" class="btn btn-info" @click="finalizarModulo(1)">Salir y Finalizar</button>
                    <button type="submit" class="btn btn-default" @click="salirModulo()">Salir</button>
              </div>
            </div>
          </div>
      </div>




           <div class="modal fade" :class="{'show':modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
               <div class="modal-dialog" style="max-width: 600px;">
                   <div class="modal-content">
                      <form method="post" id="form-otro" name="form-otro" @submit.prevent="saveOtro">
                         <div class="modal-header">
                             <button type="button" class="close" @click="cerrarModal()" aria-hidden="true">×</button>
                             <h4 class="modal-title">Otros Ingresos</h4>
                         </div>
                         <div class="modal-body">
                             <div class="row">
                                 <div class="col-lg-6">
                                   <h5>Detalle fuente de ingreso</h5>
                                   <input type="hidden" name="id_otro" v-model="id_otro">
                                   <div class="form-group">
                                       <label for="concepto" class="control-label">Concepto:</label>
                                       <input type="text" name="concepto" v-model="concepto" class="form-control">
                                       <label for="fuente_financiamiento" class="control-label">Fuente de Financiamiento:</label>
                                       <input type="text" name="fuente_financiamiento" v-model="fuente_financiamiento" class="form-control">
                                       <label for="organismo_financiador" class="control-label">Organismo Financiador:</label>
                                       <input type="text" name="organismo_financiador" v-model="organismo_financiador" class="form-control">
                                       <label for="rubro" class="control-label">Rubro:</label>
                                       <input type="text" name="rubro" v-model="rubro" class="form-control">
                                       <label for="entidad_otorgante" class="control-label">Entidad Otorgante:</label>
                                       <input type="text" name="entidad_otorgante" v-model="entidad_otorgante" class="form-control">
                                   </div>
                                 </div>
                                 <div class="col-lg-6">
                                   <h5>Montos por gestión</h5>
                                   <table class="table">
                                      <thead>
                                          <tr class="hidden">
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <tr v-for="periodo in  arrayPeriodoActivo" >
                                          <td class="text-center" style="vertical-align: middle;">
                                              <span class="fa fa-newspaper-o text-info"></span>
                                          </td>
                                          <td class="text-muted" style="vertical-align: middle;">{{ periodo }}</td>
                                          <td class="text-muted text-right">
                                            <div class="input-group">
                                              <div class="input-group-addon">Bs.</div>
                                              <input type="hidden" :name="'id_otro_'+periodo" class="form-control " style="text-align: right;">
                                              <input type="text" class="form-control" :name="'otro_'+periodo" style="text-align: right;" @blur="formatInput">
                                            </div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                 </div>
                             </div>
                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-default waves-effect" @click="cerrarModal()">Cancelar</button>
                             <button type="submit" class="btn btn-info waves-effect waves-light">Guardar</button>
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
          arrayInstitucion: [],
          arrayUser: [],
          arrayTipoRecursos: [],
          arrayGruposRecursos: [],
          arrayPeriodoActivo:[],
          arrayTotales:[],
          arrayRecursosCreados: [],
          arrayRecursosCreadosGestiones: [],
          modal:0,
          checkTipo:'',
          id_otro:0,
          concepto:'',
          fuente_financiamiento:'',
          organismo_financiador:'',
          rubro:'',
          entidad_otorgante:'',
          arrayOtrosIngresos:[],
          arrayOtrosIngresosRecursosCreadosGestiones:[],
          totalPresupuesto:0,
          auxiliar:false,
          id_auxiliar:0,
          estadoViewComponente:true,
          montos_auxiliar:''
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
       listaTipoRecursos(){
         let me = this;
          axios.get('/api/planesTerritoriales/listaTipoRecursos').then(function (response) {
             me.arrayTipoRecursos = response.data.parametros;
             me.arrayGruposRecursos = response.data.grupos;
             me.arrayPeriodoActivo = response.data.periodoActivo;
             me.arrayTotales = response.data.totales;
             me.totalPresupuesto = response.data.totalPresupuesto;
             me.arrayRecursosCreados = response.data.recursosCreados;
             me.arrayRecursosCreadosGestiones = response.data.recursosCreadosGestiones;
             me.arrayOtrosIngresos = response.data.otrosIngresos;
             me.arrayOtrosIngresosRecursosCreadosGestiones = response.data.otrosIngresosRecursosCreadosGestiones;
           })
           .catch(function (error) {
             // handle error
             console.log(error);
           });
       },

       salirModulo(){
          window.location = "/planesTerritoriales/index";
       },
       transformarAuxiliar(){
         let me = this;
         let salto = this.montos_auxiliar.split("\n");
         $.each(me.arrayPeriodoActivo, function(index, item) {
             $('[name="'+me.id_auxiliar+'_'+item+'"]').val(salto[index]);
         });
         me.id_auxiliar = 0;
         me.auxiliar = false;

       },
       acitvarAux(id){
         if($('[name="chk'+id+'"]').prop('checked') == true){
            let me = this;
            if(me.auxiliar == true){
              me.id_auxiliar = 0;
              me.auxiliar = false;
            }else{
              me.id_auxiliar = id;
              me.auxiliar = true;
            }
          }
       },
       abrirModal(e){
         let me = this;
         switch (e) {
           case 1:
             me.id_otro=0;
             me.concepto= '';
             me.fuente_financiamiento= '';
             me.organismo_financiador= '';
             me.rubro= '';
             me.entidad_otorgante= '';
             $.each(me.arrayPeriodoActivo, function(index, item) {
                  $('[name="otro_'+item+'"]').val('');
                  $('[name="id_otro_'+item+'"]').val('');
             });
              this.modal = 1;
             break;
           case 2:
              //recuperar datos par aupdate con axios
              this.modal = 1;
            break;
           default:

         }
       },
       save(id){
         let arrayDatosAxios = [];
         let me = this;
         if($('[name="chk'+id+'"]').prop('checked') == true){
             swal({
               title: "Guardar?",
               text: "Se guardara los datos registrados!",
               type: "warning",
               showCancelButton: true,
               confirmButtonColor: "#DD6B55",
               confirmButtonText: "Si, Guardar!",
               closeOnConfirm: false
             },function(){
               let valor = '';
               $.each(me.arrayPeriodoActivo, function(index, item) {
                    valor = $('[name="'+id+'_'+item+'"]').val();
                    arrayDatosAxios.push(valor);
               });
               axios({
                  method: 'post',
                  url: '/api/planesTerritoriales/saveRecursoTipo',
                  data: {
                    tipo_recurso: id,
                    datos: arrayDatosAxios
                  }
                }).then(function (response) {
                   me.listaTipoRecursos();
                   swal("Guardado!", "Se ha guardado correctamente.", "success");
                }).catch(function (error) {
                  console.log(error);
                });
            });
         }
       },
       saveUpdate(id_tipo){

             let arrayDatosAxios = [];
             let arrayIdAxios = [];
             let me = this;
             let valor = '';
             let valorId = '';

             swal({
               title: "Guardar?",
               text: "Se guardara los datos registrados!",
               type: "warning",
               showCancelButton: true,
               confirmButtonColor: "#DD6B55",
               confirmButtonText: "Si, Guardar!",
               closeOnConfirm: false
             },function(){

                 $.each(me.arrayPeriodoActivo, function(index, item) {
                      valor = $('[name="'+id_tipo+'_'+item+'"]').val();
                      arrayDatosAxios.push(valor);
                      valorId = $('[name="id_'+id_tipo+'_'+item+'"]').val();
                      arrayIdAxios.push(valorId);
                 });
                 axios({
                    method: 'post',
                    url: '/api/planesTerritoriales/saveUpdateRecursoTipo',
                    data: {
                      datos: arrayDatosAxios,
                      id: arrayIdAxios
                    }
                  }).then(function (response) {
                     me.listaTipoRecursos();
                     swal("Guardado!", "Se ha guardado correctamente.", "success");
                  }).catch(function (error) {
                    console.log(error);
                  });
            });

       },
       deleteRecurso(id_tipo){
           let arrayIdAxios = [];
           let me = this;
           let valorId = '';
           swal({
             title: "Está seguro?",
             text: "No podrá recuperar este registro!",
             type: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: "Si, eliminar!",
             closeOnConfirm: false
           }, function(){
                 $.each(me.arrayPeriodoActivo, function(index, item) {
                      valorId = $('[name="id_'+id_tipo+'_'+item+'"]').val();
                      arrayIdAxios.push(valorId);
                 });
                 axios({
                    method: 'post',
                    url: '/api/planesTerritoriales/deleteRecurso',
                    data: {
                      id: arrayIdAxios
                    }
                  }).then(function (response) {
                     me.listaTipoRecursos();
                     swal("Eliminado!", "Se ha eliminado tu registro.", "success");
                  }).catch(function (error) {
                    console.log(error);
                  });
           });
       },
       cerrarModal(){
           this.modal = 0;
       },
       checkSw(id){
          if($('[name="chk'+id+'"]').prop('checked') == true){
            $( ".dis"+id ).attr('disabled',false);
          }else{
            $( ".dis"+id ).attr('disabled',true);
          }
       },
      formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
      },
      formatInput(event){
        let value = event.target.value;
        value = value.toString();
        let count = value.split(",").length-1;
        if(count > 1){
          event.target.value = Number(value.replace(/,/g,''));
        }
      },
      cargarDatosExcel(event){
        console.log(window.clipboardData.getData("Text"));

      },
      saveOtro(){
        let arrayOtrosRecursosGestiones = [];
        let arrayIdOtrosRecursosGestiones = [];
        let me = this;

        swal({
          title: "Guardar?",
          text: "Se guardara los datos registrados!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si, Guardar!",
          closeOnConfirm: false
        },function(){
          let valor = '';
          let valorID = '';
          $.each(me.arrayPeriodoActivo, function(index, item) {
               valor = $('[name="otro_'+item+'"]').val();
               arrayOtrosRecursosGestiones.push(valor);
               if(me.id_otro > 0){
                 valorID = $('[name="id_otro_'+item+'"]').val();
                 arrayIdOtrosRecursosGestiones.push(valorID);
               }
          });
          axios({
             method: 'post',
             url: '/api/planesTerritoriales/saveOtro',
             data: {
               id_otro : me.id_otro,
               concepto: me.concepto,
               fuente_financiamiento: me.fuente_financiamiento,
               organismo_financiador: me.organismo_financiador,
               rubro: me.rubro,
               entidad_otorgante: me.entidad_otorgante,
               datos: arrayOtrosRecursosGestiones,
               ids: arrayIdOtrosRecursosGestiones
             }
           }).then(function (response) {
              me.listaTipoRecursos();
              me.cerrarModal();
              swal("Guardado!", "Se ha guardado correctamente.", "success");
           }).catch(function (error) {
             console.log(error);
           });
       });
     },
     updateOtro(id){
        let me = this;
       $.each(me.arrayOtrosIngresos, function(index, item) {
            if(item.id == id){
              me.id_otro = item.id;
              me.concepto = item.concepto;
              me.fuente_financiamiento = item.fuente_financiamiento;
              me.organismo_financiador = item.organismo_financiador;
              me.rubro = item.rubro;
              me.entidad_otorgante = item.entidad_otorgante;
              me.abrirModal(2);
              $.each(me.arrayPeriodoActivo, function(index, item) {
                  $('[name="id_otro_'+item+'"]').val(me.arrayOtrosIngresosRecursosCreadosGestiones['ids'][id][item]);
                  $('[name="otro_'+item+'"]').val(me.formatPrice(me.arrayOtrosIngresosRecursosCreadosGestiones['datos'][id][item]));
              });
            }
       });

     },
     deleteOtro(id){
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
                  url: '/api/planesTerritoriales/deleteOtro',
                  data: {
                    id_otro: id
                  }
                }).then(function (response) {
                   me.listaTipoRecursos();
                   swal("Eliminado!", "Se ha eliminado tu registro.", "success");
                }).catch(function (error) {
                  console.log(error);
                });
         });
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
          axios.get('/api/planesTerritoriales/finalizarModulo?modulo='+m).then(function (response) {
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
        this.listaTipoRecursos();
        this.datosUsuario();
        if(this.$root.$data.modulo_estado == 'Concluido')
        {
          this.estadoViewComponente = false;
        }else{
          this.estadoViewComponente = true;
        }

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










</style>
