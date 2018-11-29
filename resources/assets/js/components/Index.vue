<template>
    <div class="">

        <div class="row p-t-10 " style="font-size:13px !important;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="white-box">
                <h4 class="font-bold m-t-0">Bienvenido al Sistema de Planificacion.</h4>
                <hr class="p-0 m-0"/>
                <div class="row ">

                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                        <h3 class="box-title  p-0 m-0">Datos del Municipio:</h3>
                        <ul class="feeds">
                            <li class="m-0 p-0">
                                <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa  fa-institution text-white" style="line-height: 25px;"></i></div>
                                  Denominacion: <strong v-text="arrayInstitucion.denominacion"></strong>
                            </li>
                            <li class="m-0 p-0">
                                <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa fa-info text-white" style="line-height: 25px;"></i></div>
                                  Sigla: <strong v-text="arrayInstitucion.sigla"></strong>
                            </li>
                            <li class="m-0 p-0">
                                <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa fa-qrcode text-white" style="line-height: 25px;"></i></div>
                                  Codigo: <strong v-text="arrayInstitucion.codigo"></strong>
                            </li>
                            <li class="m-0 p-0">
                                <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa fa-cubes text-white" style="line-height: 25px;"></i></div>
                                  Grupo Clasificador: <strong v-text="arrayInstitucion.clasificador"></strong>
                            </li>
                      </ul>
                  </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                          <h3 class="box-title p-0 m-0">Detalle de sessión:</h3>
                          <ul class="feeds">
                              <li class="m-0 p-0">
                                  <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa fa-user text-white" style="line-height: 25px;"></i></div>
                                    Nombre de Usuario: <strong v-text="arrayUser.name"></strong>
                              </li>
                              <li class="m-0 p-0">
                                  <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa fa-info text-white" style="line-height: 25px;"></i></div>
                                    Cargo: <strong v-text="arrayUser.cargo"></strong>
                              </li>
                              <li class="m-0 p-0">
                                  <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa fa-envelope text-white" style="line-height: 25px;"></i></div>
                                    Correo: <strong v-text="arrayUser.email"></strong>
                              </li>
                              <li class="m-0 p-0">
                                  <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa fa-terminal text-white" style="line-height: 25px;"></i></div>
                                    Documento Identidad: <strong v-text="arrayUser.carnet"></strong>
                              </li>
                        </ul>
                    </div>
                </div>

              </div>
            </div>
         </div>



         <div class="row" style="font-size:13px !important;">
             <div class="col-md-12">
                 <div class="white-box">
                     <h3 class="box-title">Módulos:</h3>
                     <div class="row">
                         <div class="col-md-4">
                             <div class="card el-overlay btn-outline ">

                                  <center><button class="btn btn-circle btn-outline btn-info btn-xl m-t-5" @click="cambioView(1)"><i class="fa fa-money" style="font-size:30px"></i></button></center>
                                 <div class="card-block text-center">
                                     <h4 class="card-title">Registro de Recursos</h4>
                                     <p class="card-text">Asignación Techos Presupuestarios.</p>
                                     <p class="card-text">Estado: <span class="text-danger">No Concluido</span></p>
                                     <!--  <a href="#" class="btn btn-primary">Ingresar</a> -->
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="card">
                                 <center><button class="btn btn-circle btn-outline btn-info btn-xl m-t-5" @click="cambioView(2)" ><i class="fa fa-cubes" style="font-size:30px"></i></button></center>
                                 <div class="card-block text-center">
                                     <h4 class="card-title">Registro de Deudas</h4>
                                     <p class="card-text">Registre deudas generadas por el Municipio.</p>
                                     <p class="card-text">Estado: <span class="text-danger">No Concluido</span></p>
                                     <!--  <a href="#" class="btn btn-primary">Ingresar</a>  -->
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="card">
                                 <center><button class="btn btn-circle btn-outline btn-info btn-xl m-t-5" @click="cambioView(3)"><i class="fa fa-list-alt" style="font-size:30px"></i></button></center>
                                 <div class="card-block text-center">
                                     <h4 class="card-title">Determinación de Recuros</h4>
                                     <p class="card-text">Registre la Planificación de su Municipio.</p>
                                     <p class="card-text">Estado: <span class="text-danger">No Concluido</span></p>
                                     <!--  <a href="#" class="btn btn-primary">Ingresar</a> -->
                                 </div>
                             </div>
                         </div>
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
              denominacion:'',
              sigla:'',
              codigo:'',
              grupo:'',
              nombre_usuario:'',
              cargo:'',
              correo:'',
              carnet:'',
              arrayInstitucion: [],
              arrayUser: [],
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
           cambioView(e){
             this.$root.$data.view = e;
           }
        },
        mounted() {
            this.datosUsuario();
        }
    }
</script>
