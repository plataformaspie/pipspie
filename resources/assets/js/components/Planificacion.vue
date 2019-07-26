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
                 <div class="user-btm-box p-t-0 p-b-5">
                   <div  class="row m-0 p-0" >
                       <div class="col-lg-5 col-md-4 col-sm-1 col-xs-12 b-r">
                       </div>
                       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 b-r text-right" :class="alertaTotales">
                         <p v-text="'TOTAL RECURSOS:'" class="m-b-0"></p>
                       </div>
                       <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 b-r text-right" :class="alertaTotales">
                         <strong style="font-size:15px;"> Bs.{{ formatPrice(totalRecursos) }}</strong>
                       </div>
                       <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12 b-r text-right" :class="alertaTotales">
                         <p v-text="'SALDO TOTAL:'" class="m-b-0"></p>
                       </div>
                       <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 b-r text-right" :class="alertaTotales">
                         <strong style="font-size:15px;"> Bs.{{ formatPrice(saldoTotal) }}</strong>
                       </div>
                   </div>
                 </div>
                 <strong class="text-center">Total recursos asignados en esta categoria. </strong>
                 <div class="user-btm-box p-t-0 p-b-5">
                   <div  class="row m-t-0 p-t-0 list-group-item-info">
                       <template v-for="totales in arrayTotales">
                           <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 b-r">
                             <p v-text="totales.gestion+':'" class="m-b-0"></p>
                             <strong v-text="'Bs.'+formatPrice(totales.total)"></strong>
                           </div>
                       </template>
                       <!-- <div class="col-lg-1"></div> -->
                       <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 b-r">
                         <p v-text="'TOTAL CATEGORIA:'" class="m-b-0"></p>
                         <strong style="font-size:20px;"> Bs.{{ formatPrice(totalCategoriaSelec) }}</strong>
                       </div>
                   </div>
                 </div>



             </div>
          </div>
        </div>
       <div class="row">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
             <div class="white-box  p-0 m-0 p-l-10 p-r-10">
                 <div class="row button-box">
                    <div class="col-lg-2 col-sm-4 col-xs-12">
                        <button v-if="estadoViewComponente" class="btn btn-info waves-effect waves-light" @click="activarOptions" type="button">
                          <span class="btn-label"><i class="fa " :class="iconoAg"></i></span> Agregar
                        </button>
                    </div>
                </div>
             </div>
          </div>
        </div>
       <div class="row">
           <div class="col-lg-12">
                 <div class="panel-container vtabs">
                      <div class="white-box panel-left" v-show="options">
                            <p class="tree" v-text="titulo_nombre_categoria"></p>
                            <div class="row">
                               <div class="col-lg-12  p-0 m-0 p-l-10 p-r-10 p-t-10">
                                     <ul class="tree" v-html="categoriasHijos" @click="agregarDato">
                                     </ul>
                               </div>
                            </div>


                      </div>
                      <div class="splitter" v-show="options">
                      </div>

                      <div class="panel-right">
                          <input id="categorial_sel" type="hidden" name="categorial_sel" v-model="categorial_sel" @keyup.enter="agregarDato()" >
                          <div class="table-responsive">
                            <h4 class="m-t-0">Lista de Acciones</h4> <!--i class="fa fa-info-circle"></i> Para decimales usar <b>","</b> coma.-->
                                <table class="table table-bordered list-group-item-warning">
                                    <thead>
                                        <tr>
                                          <th v-if="estadoViewComponente" >#</th>
                                          <th>EP</th>
                                          <th width="200">Descripcion</th>
                                          <th>P</th>
                                          <th>M</th>
                                          <th>R</th>
                                          <th>A</th>
                                          <th>Accion Territorial Mediano Plazo</th>
                                          <th>Descripción de la Accion Territorial</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="objetivosEta in arrayListaObjetivosEtaGenerados" style="">
                                            <td v-if="estadoViewComponente">
                                              <a href="#" @click="updateObjetivo(objetivosEta.id)" class="btn btn-default btn-outline btn-xs"> <i class="fa fa-edit text-inverse" style="font-size:20px;"></i> </a>
                                              <a href="#" @click="deleteObjetivo(objetivosEta.id)" class="btn btn-default btn-outline btn-xs"> <i class="fa fa-trash-o text-inverse" style="font-size:20px;"></i> </a>
                                            </td>
                                            <td v-text="objetivosEta.codigo_estructura_programatica"></td>
                                            <td v-text="objetivosEta.ep_descripcion"></td>
                                            <td v-text="objetivosEta.cod_p"></td>
                                            <td v-text="objetivosEta.cod_m"></td>
                                            <td v-text="objetivosEta.cod_r"></td>
                                            <td v-text="objetivosEta.cod_a"></td>
                                            <td v-text="objetivosEta.nombre_accion_eta"></td>
                                            <td v-text="objetivosEta.nombre_objetivo"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                      </div>
                </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="white-box p-0 m-0 p-t-10 ">
              <div class="form-group text-center p-0 m-0">
                    <button v-if="estadoViewComponente" type="submit" class="btn btn-info" @click="finalizarCategoria()">Salir y Finalizar</button>
                    <button type="submit" class="btn btn-default" @click="salirModulo(3)">Salir</button>
              </div>
            </div>
          </div>
      </div>




           <div class="modal fade" :class="{'show':modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
               <div class="modal-dialog" style="max-width: 900px;">
                   <div class="modal-content">
                      <form method="post" id="form-accion" name="form-accion" @submit.prevent="savePlanificacion">
                         <input type="hidden" name="id_objetivo" v-model="id_objetivo">
                         <div class="modal-header  p-b-0">
                             <button type="button" class="close" @click="cerrarModal()" aria-hidden="true">×</button>
                             <h4 class="modal-title" v-text="titulo_modal"></h4>
                             <p class="text-muted m-0">Complete la información solicitada <code>-</code></p>
                         </div>
                         <div class="modal-body p-0">
                           <div class="col-lg-12 col-sm-12 col-xs-12">
                               <div class="white-box p-0 m-0">
                                   <!-- Nav tabs -->
                                   <ul class="nav customtab nav-tabs" role="tablist">
                                       <li role="presentation" class="nav-item text-center"><a id="tab-ini-1" href="#tab1" @click="tab_active = 1" class="nav-link active" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Categoria Programática</span></a></li>
                                       <li role="presentation" class="nav-item text-center"><a id="tab-ini-2" href="#tab2" @click="tab_active = 2" class="nav-link" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Acción Territorial de Mediano Plazo</span></a></li>
                                       <li role="presentation" class="nav-item text-center"><a id="tab-ini-3" href="#tab3" @click="tab_active = 3" class="nav-link" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Detalles de Accion Territorial</span></a></li>
                                       <li role="presentation" class="nav-item text-center"><a id="tab-ini-4" href="#tab4" @click="tab_active = 4" class="nav-link" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Programación</span></a></li>
                                   </ul>
                                   <!-- Tab panes -->
                                   <div class="tab-content">
                                       <div role="tabpanel" class="tab-pane fade in active" id="tab1">
                                          <div class="row show-grid m-t-0">
                                             <div class="col-md-12">
                                                 <p class="text-muted m-0">Seleccione la Categoria Programatica</p>
                                                 <select class="form-control" data-placeholder="Seleccionar" style="width:100%;" v-model="estructura_programatica" @change="cargarDatosOtros">
                                                      <option v-for="estructuraProgramatica in arrayEstructuraProgramatica" :value="estructuraProgramatica.id"><b>Codigo:</b> {{estructuraProgramatica.codigo}} - {{estructuraProgramatica.descripcion}}</option>
                                                 </select>
                                             </div>

                                                <div class="col-md-12 col-sm-12 text-center">
                                                  <p class="text-muted m-0">Detalle de seleccion:</p>
                                                  <div v-html="datosEstructura"></div>
                                                </div>
                                           </div>
                                           <div class="clearfix"></div>
                                       </div>
                                       <div role="tabpanel" class="tab-pane fade " id="tab2">
                                         <div class="row show-grid m-t-0">
                                             <div class="col-md-12 col-sm-12">
                                                <p class="text-muted m-0">Seleccione acción territorial de mediano plazo</p>
                                                <select class="form-control" data-placeholder="Seleccionar" style="width:100%;" v-model="id_acciones_eta_mediano_plazo" name="id_acciones_eta_mediano_plazo" @change="cargarDatosCatalotoAccionEta">
                                                     <option v-for="catalogoAccionEta in arrayCatalogoAccionEta" :value="catalogoAccionEta.id"><b>Codigo:</b> {{catalogoAccionEta.id}} - {{catalogoAccionEta.nombre_accion_eta}}</option>
                                                </select>
                                             </div>

                                             <div class="col-md-12 col-sm-12 text-center">
                                                 <p class="text-muted m-0">Detalle de seleccion:</p>
                                                 <transition name="fade">
                                                   <div class="row text-left" v-html="datosCatalogoAccionEta">

                                                   </div>
                                                 </transition>
                                             </div>
                                          </div>
                                           <div class="clearfix"></div>
                                       </div>
                                       <div role="tabpanel" class="tab-pane fade " id="tab3">


                                             <template v-if="this.$root.$data.categoria == 1">
                                                 <div class="col-md-1 col-sm-12">
                                                   <p class="text-muted m-0">Tipo:</p>
                                                 </div>
                                                 <div class="col-md-4 col-sm-12">
                                                     <select class="form-control" v-model="tipo_objetivo" name="tipo_objetivo">
                                                         <option value="Proyecto">Proyecto</option>
                                                         <option value="Programa">Programa</option>
                                                         <option value="Actividad">Actividad</option>
                                                     </select>
                                                 </div>
                                                 <div class="col-md-2 col-sm-12 text-right">
                                                   <p class="text-muted m-0">Codigo SISIN:</p>
                                                 </div>
                                                 <div   class="col-md-5 col-sm-12">
                                                     <input type="text" class="form-control" v-model="codigo_sisin" name="codigo_sisin">
                                                 </div>
                                                 <div class="col-md-12 col-sm-12 p-t-10">
                                                   <p class="text-muted m-0">Nombre del Proyecto:</p>
                                                     <textarea class="form-control" rows="3" v-model="nombre_objetivo" name="nombre_objetivo"></textarea>
                                                 </div>
                                            </template>
                                            <template v-else="">
                                              <p class="p-l-10" >Describir acción territorial.?
                                                <label class="containerchk">
                                                  <input type="checkbox" v-model="detalleEta">
                                                  <span class="checkmark" v-text="detalleEta==true?'':'NO'"></span>
                                                </label>
                                              </p>
                                              <hr/>
                                              <template v-if="detalleEta == true">
                                                  <div class="col-md-1 col-sm-12">
                                                    <p class="text-muted m-0">Tipo:</p>
                                                  </div>
                                                  <div class="col-md-6 col-sm-12">
                                                      <select class="form-control" v-model="tipo_objetivo" name="tipo_objetivo">
                                                          <option value="Programa">Programa</option>
                                                          <option value="Proyecto">Proyecto</option>
                                                          <option value="Actividad">Actividad</option>
                                                      </select>
                                                  </div>
                                                 <div class="col-md-12 col-sm-12 p-t-10">
                                                   <p class="text-muted m-0">Descripción de la acción Territorial:</p>
                                                     <textarea class="form-control" rows="3" v-model="nombre_objetivo" name="nombre_objetivo"></textarea>
                                                 </div>
                                               </template>
                                            </template>


                                           <div class="col-md-6">
                                             <p class="text-muted m-0">Detalle de linea Base:</p>

                                               <div class="row show-grid m-t-0">
                                                  <div class="col-md-12 col-sm-12 text-center">
                                                    <h5>Detallar linea base:</h5>
                                                    <textarea class="form-control" rows="2" v-model="linea_base_descripcion" name="linea_base_descripcion"></textarea>
                                                  </div>
                                                  <div class="col-md-6 col-sm-6 text-center">
                                                    <h5>Unidad de medida:</h5>
                                                    <input class="form-control" type="text" v-model="linea_base_unidad" name="linea_base_unidad" >
                                                  </div>
                                                  <div class="col-md-6 col-sm-6 text-center">
                                                      <h5>Cantidad:</h5>
                                                      <!-- <input class="form-control text-right" type="text" v-model="linea_base_cantidad" name="linea_base_cantidad" > -->
                                                      <my-currency-input v-model="linea_base_cantidad"></my-currency-input>
                                                  </div>
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <p class="text-muted m-0">Detalles de Indicador :</p>
                                               <select class="form-control" data-placeholder="Seleccionar" v-model="indicador" name="indicador" @change="detalleIndicador">
                                                            <option v-for="indicador in arrayIndicadores" :value="indicador.id">{{indicador.nombre_indicador}}</option>
                                               </select>
                                               <div class="row show-grid">
                                                  <div class="col-md-12 col-sm-12 text-center">
                                                    <h5>Descripción:</h5>
                                                    <b v-text="detalle_indicador"></b>
                                                  </div>
                                                  <div class="col-md-6 col-sm-6 text-center">
                                                    <h5>Unidad de medida:</h5>
                                                    <b v-text="detalle_unidad_indicador" ></b>
                                                  </div>
                                                  <div class="col-md-6 col-sm-6 text-center">
                                                      <h5>Cantidad:</h5>
                                                      <!-- <input class="form-control text-right" type="text" v-model="indicador_cantidad" name="indicador_cantidad" > -->
                                                      <my-currency-input v-model="indicador_cantidad"></my-currency-input>
                                                  </div>
                                               </div>
                                           </div>
                                           <div class="clearfix"></div>
                                       </div>
                                       <div role="tabpanel" class="tab-pane fade " id="tab4">
                                         <transition name="fade">
                                           <div class="row show-grid" v-if="auxiliar">
                                             <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                               <div class="white-box p-10 m-b-0">
                                                     <input type="hidden" name="id_auxiliar" v-model="id_auxiliar">
                                                     <h4 v-text="titulo_auxiliar" class="m-0 p-0" :class="textcss"></h4>
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
                                                             <button type="button" @click="transformarAuxiliar" class="btn btn-outline btn-default btn-sm">Enviar</button>
                                                         </li>
                                                     </ul>
                                               </div>
                                             </div>
                                           </div>
                                         </transition>
                                           <div class="col-md-12">
                                             <div class="table-responsive">
                                               <p class="text-muted m-0">Programación de Indicador: <a href="#" @click="activarAux('prog')"> <i class="fa fa-copy text-inverse m-r-10" style="font-size:20px;"></i> </a></p>
                                                   <table class="table table-bordered list-group-item-info">
                                                       <thead>
                                                           <tr style="border:1px solid #A9A9A9;">
                                                             <th v-for="periodo in  arrayPeriodoActivo" class="text-center" style="border:1px solid #A9A9A9;">{{ periodo}}</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           <tr style="border:1px solid #A9A9A9;">
                                                               <td v-for="periodo in  arrayPeriodoActivo" style="border:1px solid #A9A9A9;">
                                                                 <input type="hidden" :name="'id_prog_'+periodo">
                                                                 <input class="form-control text-right" type="text" :name="'prog_'+periodo" @blur="formatInput">
                                                               </td>
                                                           </tr>
                                                       </tbody>
                                                   </table>
                                               </div>
                                           </div>
                                           <div class="col-md-12">
                                             <div class="table-responsive">
                                               <p class="text-muted m-0">Programación de Recursos: <a href="#" @click="activarAux('recursos')"> <i class="fa fa-copy text-inverse m-r-10" style="font-size:20px;"></i> </a></p>
                                                   <table class="table table-bordered list-group-item-warning">
                                                       <thead>
                                                           <tr class="text-center">
                                                             <th v-for="periodo in  arrayPeriodoActivo" class="text-center">{{ periodo}}</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>
                                                           <tr style="">
                                                               <td v-for="periodo in  arrayPeriodoActivo">
                                                                 <input type="hidden" :name="'id_recursos_'+periodo">
                                                                 <input class="form-control text-right" type="text" :name="'recursos_'+periodo" @blur="formatInput">
                                                               </td>
                                                           </tr>
                                                       </tbody>
                                                   </table>
                                               </div>
                                           </div>
                                           <div class="clearfix"></div>
                                       </div>
                                   </div>
                               </div>
                           </div>



                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-info waves-effect waves-light" v-show="tab_active > 1" @click="cambiarTab(-1)"><i class="fa fa-arrow-circle-left"></i></button>
                             <button type="button" class="btn btn-default waves-effect" @click="cerrarModal()">Cancelar</button>
                             <button type="button" class="btn btn-info waves-effect waves-light" v-show="tab_active < 4" @click="cambiarTab(1)"><i class="fa fa-arrow-circle-right"></i></button>
                             <button type="submit" class="btn btn-info waves-effect waves-light" v-show="tab_active == 4"><i class="fa fa-save"></i> Guardar</button>
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
          arrayListaObjetivosEtaGenerados:[],
          arrayPeriodoActivo:[],
          arrayEstructuraProgramatica:[],
          arrayCatalogoAccionEta:[],
          arrayIndicadores:[],
          categoriasHijos: '',
          arrayUser: [],
          estructura_programatica:'',
          datosEstructura:'',
          datosCatalogoAccionEta:'',
          titulo_nombre_categoria:'',
          detalle_indicador:'',
          detalle_unidad_indicador:'',
          categorial_sel:'',
          id_objetivo:0,
          id_articulacion:0,
          id_acciones_eta_mediano_plazo:'',
          codigo_sisin:'',
          nombre_objetivo:'',
          linea_base_descripcion:'',
          linea_base_unidad:'',
          linea_base_cantidad:0,
          indicador: '',
          indicador_cantidad:0,
          tipo_objetivo:'Proyecto',
          options:false,
          tab_active:1,
          iconoAg:'fa-plus-square',
          modal:0,
          //price:1234,
          arrayTotales:[],
          titulo_modal:'Nuevo Registro',
          totalRecursosAsignados: 0,
          totalDeuda:0,
          totalRecursos:0,
          totalCategoriaSelec:0,
          saldoTotal: 0,
          alertaTotales:"list-group-item-success",
          auxiliar:false,
          estadoViewComponente:true,
          id_auxiliar:0,
          montos_auxiliar:'',
          titulo_auxiliar:'',
          detalleEta:false,
          textcss:''

        }
    },
    methods: {
        datosUsuario(){
          let me = this;
           axios.get('/api/planesTerritoriales/datosUsuario').then(function (response) {
              // handle success
              me.arrayInstitucion = response.data.institucion;
              me.arrayUser = response.data.user;
              me.arrayPeriodoActivo = response.data.periodoActivo;
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            });
        },
        listaObjetivosEtaGenerados(){
          let me = this;
           axios.get('/api/planesTerritoriales/listaObjetivosEtaGenerados?categoria='+me.$root.$data.categoria).then(function (response) {
              me.arrayListaObjetivosEtaGenerados = response.data.listaObjetivosGenerados;
              me.arrayTotales = response.data.totalCategoriaGestiones;
              me.totalCategoriaSelec = response.data.totalCategoriaSelec;
              me.totalRecursos = response.data.totalRecursos;
              me.totalDeuda = response.data.totalDeuda;
              me.totalRecursosAsignados = response.data.totalRecursosAsignados;

              me.saldoTotal = (me.totalRecursos - (me.totalDeuda + me.totalRecursosAsignados));
              if(me.saldoTotal < 0){
                me.alertaTotales = "list-group-item-danger";
              }else if(me.saldoTotal < 1000000) {
                me.alertaTotales = "list-group-item-warning";
              }else{
                me.alertaTotales = "list-group-item-success";
              }

            })
            .catch(function (error) {
              // handle error
              console.log(error);
            });
        },
        categoriasHijosAccion(){
          let me = this;
           axios.get('/api/planesTerritoriales/categoriasHijosAccion?id_padre='+ me.$root.$data.categoria).then(function (response) {
              // handle success
              me.categoriasHijos = response.data.categoriasHijos;
              me.titulo_nombre_categoria = response.data.titulo_nombre_categoria;
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            });
        },
        listaEstructuraProgramaticaIndicadores(){
          let me = this;
           axios.get('/api/planesTerritoriales/listaEstructuraProgramaticaIndicadores').then(function (response) {
              // handle success
              me.arrayEstructuraProgramatica = response.data.estructuraProgramatica;
              me.arrayIndicadores = response.data.indicadores;
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            });
        },
        cargarDatosOtros(){
          let me = this;
          me.id_acciones_eta_mediano_plazo="";
          me.datosCatalogoAccionEta = "";
          const index = me.indexWhere(me.arrayEstructuraProgramatica, item => item.id === me.estructura_programatica)

          let html = '<p><strong>Codigo: </strong> <b><span style="font-size:13px">'+me.arrayEstructuraProgramatica[index]['codigo']+'</span></b></p>'+
                     '<p><strong>Descripcion: </strong> <span style="font-size:13px">'+me.arrayEstructuraProgramatica[index]['descripcion']+'</span></p>'+
                     '<p><strong>FIN-FUN: </strong> <span style="font-size:13px">'+me.arrayEstructuraProgramatica[index]['fin_fun']+'</span></p>'+
                     '<p><strong>Codigo Sector Económico: </strong> <span style="font-size:13px">'+me.arrayEstructuraProgramatica[index]['sector_economico']+'</span></p>';
          me.datosEstructura = html;

          me.listaCatalogoAccionEta();

        },
        listaCatalogoAccionEta(){
          let me = this;
           axios.get('/api/planesTerritoriales/listaCatalogoAccionEta?id_sel='+me.estructura_programatica).then(function (response) {
              // handle success
              me.arrayCatalogoAccionEta = response.data.catalogoAccionEta;
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            });
        },
        cargarDatosCatalotoAccionEta(){
          let me = this;
          axios.get('/api/planesTerritoriales/datosDetalleAccionEta?id_accion_eta='+me.id_acciones_eta_mediano_plazo).then(function (response) {

            let html =  '<div class="col-md-8 p-0">'+
                          '<div class="row  m-l-5">'+
                              '<div class="col-md-12 text-center">'+
                                     '<p class="text-muted m-0">Articulación PDES</p>'+
                              '</div>'+
                              '<div class="col-md-3 ">'+
                                     '<img src="/img/'+response.data.detalleAccionEta[0].img_p+'" alt="" width="115">'+
                              '</div>'+
                              '<div class="col-md-9">'+
                                 '<p><strong>'+response.data.detalleAccionEta[0].pilar+': </strong> <span style="font-size:13px"> '+response.data.detalleAccionEta[0].desc_p+'  </span></p>'+
                                 '<p><strong>'+response.data.detalleAccionEta[0].meta+': </strong> <span style="font-size:13px"> '+response.data.detalleAccionEta[0].desc_m+' </span></p>'+
                                 '<p><strong>'+response.data.detalleAccionEta[0].resultado+': </strong> <span style="font-size:13px"> '+response.data.detalleAccionEta[0].desc_r+' </span></p>'+
                                 '<p><strong>'+response.data.detalleAccionEta[0].accion+': </strong> <span style="font-size:13px">'+response.data.detalleAccionEta[0].desc_a+' </span></p>'+
                              '</div>'+
                           '</div>'+
                        '</div>'+
                        '<div class="col-md-4 p-0">'+
                          '<div class="row  m-l-5">'+
                              '<div class="col-md-12 text-center">'+
                                     '<p class="text-muted m-0">Articulación Competencial</p>'+
                              '</div>'+
                              '<div class="col-md-12">'+
                                  '<p><strong>Tipo competencia: </strong> <span style="font-size:13px"> '+response.data.detalleAccionEta[0].tipo_competencia+' </span></p>'+
                                  '<p><strong>CPE: </strong> <span style="font-size:13px"> '+response.data.detalleAccionEta[0].cpe+' </span></p>'+
                                  '<p><strong>LMAD: </strong> <span style="font-size:13px">  '+response.data.detalleAccionEta[0].lmad+' </span></p>'+
                              '</div>'+
                        '</div>';

              me.datosCatalogoAccionEta=html;
           })
           .catch(function (error) {
             // handle error
             console.log(error);
           });

        },
        indexWhere(array, conditionFn) {
          const item = array.find(conditionFn)
          return array.indexOf(item)
        },
        detalleIndicador(){
          let me = this;

          console.log(me.arrayIndicadores);
          const index = me.indexWhere(me.arrayIndicadores, item => item.id === this.indicador);


          me.detalle_indicador = me.arrayIndicadores[index]['nombre_indicador'];
          me.detalle_unidad_indicador = me.arrayIndicadores[index]['unidad'];
        },
        cambiarTab(e){
            let me = this;
            let tab = me.tab_active + (e);
            if(tab >=1 && tab <=4 ){
              me.tab_active = tab;
              $("#tab-ini-"+ tab).trigger( "click" );
            }
        },
        activarOptions(){
          if(this.options==true){
              this.options = false;
              this.iconoAg ='fa-plus-square'
          }else{
             this.options = true;
             this.iconoAg ='fa-minus-square'
          }

        },
        agregarDato(){
          if($('#categorial_sel').val()!=""){
            this.categorial_sel = $('#categorial_sel').val();
            this.titulo_modal="Nuevo Registro";
            this.abrirModal();
          }
        },
       salirModulo(e){
         let me = this;
         me.$root.$data.view = e;
         me.$root.$data.categoria = 0;
       },

       abrirModal(){
         let me = this;
         me.modal = 1;
       },
       cerrarModal(){
          this.id_objetivo = 0;
          this.modal = 0;
          this.categorial_sel = "";
          this.estructura_programatica= "";
          this.datosEstructura= "";
          this.id_acciones_eta_mediano_plazo= "";
          this.datosCatalogoAccionEta= "";
          this.codigo_sisin= "";
          this.nombre_objetivo= "";
          this.linea_base_descripcion= "";
          this.linea_base_unidad= "";
          this.linea_base_cantidad= "";
          this.indicador= "";
          this.detalle_indicador= "";
          this.detalle_unidad_indicador= "";
          this.indicador_cantidad= "";
          this.detalleEta=false;
          $.each(this.arrayPeriodoActivo, function(index, item) {
             $('[name="id_prog_'+item+'"]').val('');
             $('[name="prog_'+item+'"]').val('');
             $('[name="id_recursos_'+item+'"]').val('');
             $('[name="recursos_'+item+'"]').val('');
          });
          this.tab_active = 0;
          this.cambiarTab(1);
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
       activarAux(id){
          let me = this;
          if(me.auxiliar == true){
            me.titulo_auxiliar = "";
            me.id_auxiliar = 0;
            me.auxiliar = false;
          }else{
            me.titulo_auxiliar = (id=='prog')?'Datos para tabla Programación de Indicador':'Datos para tabla Programación de Recursos';
            me.textcss = (id=='prog')?'alert-info':'alert-warning';
            me.id_auxiliar = id;
            me.auxiliar = true;
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

      finalizarCategoria(){
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
            axios.get('/api/planesTerritoriales/finalizarCategoria?categoria='+ me.$root.$data.categoria).then(function (response) {
                me.salirModulo(3);
                swal("Finalizado!", "Se ha finalizado el cargado de la categoria", "success");
           }).catch(function (error) {
               // handle error
               console.log(error);
           });
         });
      },
      savePlanificacion(){
            let arrayIdsProgramacionIndicador = [];
            let arrayProgramacionIndicador = [];
            let arrayIdsProgramacionRecursos = [];
            let arrayProgramacionRecursos = [];
            let me = this;
            if(this.$root.$data.categoria==1)
              me.detalleEta = true


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
                 arrayIdsProgramacionIndicador.push($('[name="id_prog_'+item+'"]').val());
                 arrayProgramacionIndicador.push($('[name="prog_'+item+'"]').val());
                 arrayIdsProgramacionRecursos.push($('[name="id_recursos_'+item+'"]').val());
                 arrayProgramacionRecursos.push($('[name="recursos_'+item+'"]').val());
              });
              axios({
                 method: 'post',
                 url: '/api/planesTerritoriales/savePlanificacion',
                 data: {
                   id_objetivo : me.id_objetivo,
                   id_articulacion : me.id_articulacion,
                   id_acciones_eta_mediano_plazo: me.id_acciones_eta_mediano_plazo,
                   codigo_sisin: me.codigo_sisin,
                   nombre_objetivo: me.nombre_objetivo,
                   categoria_accion: me.categorial_sel,
                   linea_base_descripcion: me.linea_base_descripcion,
                   linea_base_unidad: me.linea_base_unidad,
                   linea_base_cantidad: me.linea_base_cantidad,
                   indicador: me.indicador,
                   indicador_cantidad: me.indicador_cantidad,
                   detalleEta:me.detalleEta,
                   tipo_objetivo:me.tipo_objetivo,
                   ids_programacion_indicador: arrayIdsProgramacionIndicador,
                   programacion_indicador: arrayProgramacionIndicador,
                   ids_programacion_recursos: arrayIdsProgramacionRecursos,
                   programacion_recursos: arrayProgramacionRecursos
                 }
               }).then(function (response) {
                  me.listaObjetivosEtaGenerados();
                  me.cerrarModal();
                  swal("Guardado!", "Se ha guardado correctamente.", "success");
               }).catch(function (error) {
                 console.log(error);
               });
           });
       },
       updateObjetivo(id){
         let me = this;
         me.titulo_modal="Modificando Registro";
         let arrayDatosObjetivo=[];
         let arrayProgramacionIndicador = [];
         let arrayProgramacionRecursos = [];
          axios.get('/api/planesTerritoriales/datosObjetivoSeleccionado?id_objetivo='+ id).then(function (response) {
             // handle success
             arrayDatosObjetivo = response.data.datosObjetivo;
             arrayProgramacionIndicador = response.data.programacionIndicadorObjetivo;
             arrayProgramacionRecursos = response.data.programacionRecursosObjetivo;
             me.id_objetivo = arrayDatosObjetivo[0]['id_objetivo'];
             me.id_articulacion = arrayDatosObjetivo[0]['id_articulacion'];
             me.estructura_programatica= arrayDatosObjetivo[0]['id_categoria_prog'];
             me.cargarDatosOtros();
             me.id_acciones_eta_mediano_plazo = arrayDatosObjetivo[0]['id_accion_eta'];
             me.cargarDatosCatalotoAccionEta();
             me.detalleEta = arrayDatosObjetivo[0]['desagregado'];
             me.tipo_objetivo = arrayDatosObjetivo[0]['tipo_objetivo'];
             me.codigo_sisin = arrayDatosObjetivo[0]['codigo_sisin'];
             me.nombre_objetivo = arrayDatosObjetivo[0]['nombre_objetivo'];
             me.linea_base_descripcion = arrayDatosObjetivo[0]['linea_base_descripcion'];
             me.linea_base_unidad = arrayDatosObjetivo[0]['linea_base_unidad'];
             me.linea_base_cantidad= arrayDatosObjetivo[0]['linea_base_cantidad'];
             me.indicador = arrayDatosObjetivo[0]['id_indicador'];
             if(me.indicador)
               me.detalleIndicador();

             me.indicador_cantidad = arrayDatosObjetivo[0]['indicador_cantidad'];

             $.each(me.arrayPeriodoActivo, function(index, item) {
                 $('[name="id_prog_'+item+'"]').val(arrayProgramacionIndicador['ids'][item]);
                 $('[name="prog_'+item+'"]').val(me.formatPrice(arrayProgramacionIndicador['datos'][item]));

                 $('[name="id_recursos_'+item+'"]').val(arrayProgramacionRecursos['ids'][item]);
                 $('[name="recursos_'+item+'"]').val(me.formatPrice(arrayProgramacionRecursos['datos'][item]));
             });
             me.abrirModal();
           })
           .catch(function (error) {
             // handle error
             console.log(error);
           });
       },
       deleteObjetivo(id){
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
                    url: '/api/planesTerritoriales/deleteObjetivo',
                    data: {
                      id_objetivo: id
                    }
                  }).then(function (response) {
                     me.listaObjetivosEtaGenerados();
                     me.cerrarModal();
                     swal("Eliminado!", "Se ha eliminado tu registro.", "success");
                  }).catch(function (error) {
                    console.log(error);
                  });
           });
       },
    },
    mounted() {

        this.datosUsuario();
        this.listaObjetivosEtaGenerados();
        this.categoriasHijosAccion();
        this.listaEstructuraProgramaticaIndicadores();

        if(this.$root.$data.categoria_estado == 3)
        {
          this.estadoViewComponente = false;
        }else{
          this.estadoViewComponente = true;
        }

        $(".panel-left").resizable({handleSelector: ".splitter",resizeHeight: false});
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
  background: rgba(#fafafa, 0.75);
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


p.tree,ul.tree, ul.tree ul {
    list-style: none;
     margin: 0;
     padding: 0;
   }
   ul.tree ul {
     margin-left: 10px;
   }
   ul.tree li {
     margin: 0;
     padding: 0 7px;
     line-height: 20px;
     color: #369;
     font-weight: bold;
     border-left:1px solid rgb(100,100,100);

   }
   ul.tree li:last-child {
       border-left:none;
   }
   ul.tree li:before {
      position:relative;
      top:-0.3em;
      height:1em;
      width:12px;
      color:white;
      border-bottom:1px solid rgb(100,100,100);
      content:"";
      display:inline-block;
      left:-7px;
   }
   ul.tree li:last-child:before {
      border-left:1px solid rgb(100,100,100);
   }


   /* The container */
   .containerchk {
     display: block;
     position: relative;
     padding-left: 35px;
     margin-bottom: 12px;
     cursor: pointer;
     font-size: 15px;
     -webkit-user-select: none;
     -moz-user-select: none;
     -ms-user-select: none;
     user-select: none;
   }

   /* Hide the browser's default checkbox */
   .containerchk input {
     position: absolute;
     opacity: 0;
     cursor: pointer;
     height: 0;
     width: 0;
   }

   /* Create a custom checkbox */
   .checkmark {
     /* position: absolute; */
     position: absolute;
     top: -23px;
     left: 170px;
     height: 25px;
     width: 25px;
     background-color: #eee;
   }

   /* On mouse-over, add a grey background color */
   .containerchk:hover input ~ .checkmark {
     background-color: #ccc;
   }

   /* When the checkbox is checked, add a blue background */
   .containerchk input:checked ~ .checkmark {
     background-color: #2196F3;
   }

   /* Create the checkmark/indicator (hidden when not checked) */
   .checkmark:after {
     content: "";
     position: absolute;
     display: none;
   }

   /* Show the checkmark when checked */
   .containerchk input:checked ~ .checkmark:after {
     display: block;
   }

   /* Style the checkmark/indicator */
   .containerchk .checkmark:after {
     left: 9px;
     top: 5px;
     width: 5px;
     height: 10px;
     border: solid white;
     border-width: 0 3px 3px 0;
     -webkit-transform: rotate(45deg);
     -ms-transform: rotate(45deg);
     transform: rotate(45deg);
   }


</style>
