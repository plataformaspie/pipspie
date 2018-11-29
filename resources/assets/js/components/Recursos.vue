<template>
    <div style="font-size:12px !important;">

      <div class="row p-t-10 ">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="white-box m-t-0 m-b-0 p-t-10 p-b-10" >

              <div class="row ">
                <ul class="feeds">
                    <li class="m-0 p-0">
                        <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa  fa-institution text-white" style="line-height: 25px;"></i></div>
                          Denominacion: <strong v-text="arrayInstitucion.denominacion"></strong>
                    </li>
                    <li class="m-0 p-0">
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



          <div class="row p-t-10 " style="">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                  <h4 class="font-bold m-t-0">Registre los recursos asignados a su municipio.</h4>
                  <hr class="p-0 m-0"/>
                  <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="vtabs">
                            <ul class="nav tabs-vertical" style="width:30%">
                                <li v-for="gruposRecursos in arrayGruposRecursos" :key="gruposRecursos.id" class="tab nav-item" >
                                      <a data-toggle="tab" class="nav-link"  :class="{'active': gruposRecursos.orden == 1}" :href="'#panel'+gruposRecursos.id" aria-expanded="true">
                                        <span class="visible-xs"><i class="fa fa-dot-circle-o"></i><span class="visible-xs" v-text="gruposRecursos.codigo"></span></span>
                                        <i class="hidden-xs fa fa-dot-circle-o"></i> <span class="hidden-xs" v-text="gruposRecursos.valor"></span>
                                      </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div v-for="gruposRecursos in arrayGruposRecursos"  :id="'panel'+gruposRecursos.id" class="tab-pane" :class="{'active': gruposRecursos.orden == 1}">
                                      <div v-if="gruposRecursos.valor !== 'Otros Ingresos'" class="table-responsive">
                                        <h4 v-text="gruposRecursos.valor" class="m-t-0"></h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                      <th>#</th>
                                                      <th>Tipo recurso</th>
                                                      <th>2016</th>
                                                      <th>2017</th>
                                                      <th>2018</th>
                                                      <th>2019</th>
                                                      <th>2020</th>
                                                      <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="tiposRecursos in arrayTipoRecursos" v-if="tiposRecursos.valor===gruposRecursos.valor " style="">

                                                        <td><input type="checkbox" :name="'chk'+tiposRecursos.id" @change="checkSw(tiposRecursos.id)"></td>
                                                        <td>{{ tiposRecursos.nombre }}</td>
                                                        <td>
                                                          <input type="text" :name="tiposRecursos.id+'_2016'" :class="'form-control dis'+tiposRecursos.id" value="0" disabled="disabled" style="height: 28px;text-align: right;" >
                                                        </td>
                                                        <td>
                                                          <input type="text" :name="tiposRecursos.id+'_2017'" :class="'form-control dis'+tiposRecursos.id" value="0" disabled="disabled" style="height: 28px;text-align: right;">
                                                        </td>
                                                        <td>
                                                          <input type="text" :name="tiposRecursos.id+'_2018'" :class="'form-control dis'+tiposRecursos.id" value="0" disabled="disabled" style="height: 28px;text-align: right;">
                                                        </td>
                                                        <td>
                                                          <input type="text" :name="tiposRecursos.id+'_2019'" :class="'form-control dis'+tiposRecursos.id" value="0" disabled="disabled" style="height: 28px;text-align: right;">
                                                        </td>
                                                        <td>
                                                          <input type="text" :name="tiposRecursos.id+'_2020'" :class="'form-control dis'+tiposRecursos.id" value="0" disabled="disabled" style="height: 28px;text-align: right;">
                                                        </td>
                                                        <td>
                                                          <a href="#" @click="save(tiposRecursos.id)"> <i class="fa fa-save text-inverse m-r-10" style="font-size:20px;"></i> </a>
                                                          <a href="#" @click=""> <i class="fa fa-trash-o text-inverse m-r-10" style="font-size:20px;"></i> </a>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div v-else>
                                          <h4 class="m-t-0">Otros Ingresos: <a href="#" @click="abrirModal(1)" data-original-title="Save"> <i class="fa fa-plus-square text-inverse m-r-10" style="font-size:30px;"></i> </a></h4>
                                        </div>


                                  </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                              <button type="submit" class="btn btn-info">Salir y Finalizar</button>
                              <button type="submit" class="btn btn-default" @click="salirModulo()">Salir</button>
                        </div>
                     </div>
                   </div>


                </div>
              </div>
           </div>

           <div class="modal fade" :class="{'show':modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
               <div class="modal-dialog" style="max-width: 600px;">
                   <div class="modal-content">
                      <form>
                         <div class="modal-header">
                             <button type="button" class="close" @click="cerrarModal()" aria-hidden="true">×</button>
                             <h4 class="modal-title">Otros Ingresos</h4>
                         </div>
                         <div class="modal-body">
                             <div class="row">
                                 <div class="col-lg-6">
                                   <h5>Detalle fuente de ingreso</h5>
                                   <div class="form-group">
                                       <label for="recipient-name" class="control-label">Concepto:</label>
                                       <input type="text" class="form-control" id="recipient-name">
                                       <label for="recipient-name" class="control-label">Fuente de Financiamiento:</label>
                                       <input type="text" class="form-control" id="recipient-name">
                                       <label for="recipient-name" class="control-label">Organismo Financiador:</label>
                                       <input type="text" class="form-control" id="recipient-name">
                                       <label for="recipient-name" class="control-label">Rubro:</label>
                                       <input type="text" class="form-control" id="recipient-name">
                                       <label for="recipient-name" class="control-label">Entidad Otorgante:</label>
                                       <input type="text" class="form-control" id="recipient-name">
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
                                        <tr>
                                          <td class="text-center" style="vertical-align: middle;">
                                              <span class="fa fa-newspaper-o text-info"></span>
                                          </td>
                                          <td class="text-muted" style="vertical-align: middle;">2016</td>
                                          <td class="text-muted text-right">
                                            <div class="input-group">
                                              <div class="input-group-addon">Bs.</div>
                                              <input type="text" class="form-control" id="recipient-name" style="text-align: right;">
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="text-center" style="vertical-align: middle;">
                                              <span class="fa fa-newspaper-o text-info"></span>
                                          </td>
                                          <td class="text-muted" style="vertical-align: middle;">2017</td>
                                          <td class="text-muted text-right">
                                            <div class="input-group">
                                              <div class="input-group-addon">Bs.</div>
                                              <input type="text" class="form-control" id="recipient-name" style="text-align: right;">
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="text-center" style="vertical-align: middle;">
                                              <span class="fa fa-newspaper-o text-info"></span>
                                          </td>
                                          <td class="text-muted" style="vertical-align: middle;">2018</td>
                                          <td class="text-muted text-right">
                                            <div class="input-group">
                                              <div class="input-group-addon">Bs.</div>
                                              <input type="text" class="form-control" id="recipient-name" style="text-align: right;">
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="text-center" style="vertical-align: middle;">
                                              <span class="fa fa-newspaper-o text-info"></span>
                                          </td>
                                          <td class="text-muted" style="vertical-align: middle;">2019</td>
                                          <td class="text-muted text-right">
                                            <div class="input-group">
                                              <div class="input-group-addon">Bs.</div>
                                              <input type="text" class="form-control" id="recipient-name" style="text-align: right;">
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td class="text-center" style="vertical-align: middle;">
                                              <span class="fa fa-newspaper-o text-info"></span>
                                          </td>
                                          <td class="text-muted" style="vertical-align: middle;">2020</td>
                                          <td class="text-muted text-right">
                                            <div class="input-group">
                                              <div class="input-group-addon">Bs.</div>
                                              <input type="text" class="form-control" id="recipient-name" style="text-align: right;">
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
                             <button type="button" class="btn btn-info waves-effect waves-light">Guardar</button>
                         </div>
                      </form>
                   </div>
               </div>
           </div>

           <div class="row p-t-10 ">
               <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                 <div class="white-box">
                     <strong>Total recursos determinados</strong>
                     <div class="user-btm-box">
                         <template v-for="totales in arrayTotales">
                         <div  class="row text-center m-t-10">
                             <div class="col-md-3 b-r">
                                 <p v-text="totales.gestion"></p>
                             </div>
                             <div class="col-md-9">
                               <strong v-text="totales.total">0</strong>
                             </div>
                         </div>
                         <hr class="m-0">
                       </template>
                     </div>



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
          modal:0,
          checkTipo:''

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
           })
           .catch(function (error) {
             // handle error
             console.log(error);
           });
       },
       salirModulo(){
          window.location = "/planesTerritoriales/index";
       },
       abrirModal(e){
         switch (e) {
           case 1:
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
             let valor = '';
             $.each(me.arrayPeriodoActivo, function(index, item) {
                  valor = $('[name="'+id+'_'+item+'"]').val();
                  arrayDatosAxios.push(valor);
             });
             console.log(arrayDatosAxios);
             axios({
                method: 'post',
                url: '/api/planesTerritoriales/saveRecursoTipo',
                data: {
                  tipo_recurso: id,
                  datos: arrayDatosAxios
                }
              }).then(function (response) {
                 me.listaTipoRecursos();
              }).catch(function (error) {
                console.log(error);
              });

         }
       },
       cerrarModal(){
           this.modal = 0;
       },
       checkSw(id){
          console.log(id);
          if($('[name="chk'+id+'"]').prop('checked') == true){
            $( ".dis"+id ).attr('disabled',false);
          }else{
            $( ".dis"+id ).attr('disabled',true);
          }
       }
    },
    mounted() {
        this.listaTipoRecursos();
        this.datosUsuario();
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
</style>
