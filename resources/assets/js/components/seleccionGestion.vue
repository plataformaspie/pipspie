<template>
  <div class="">
    <div class="row p-t-10 " style="font-size:13px !important;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="white-box">
            <h4 class="font-bold m-t-0">Bienvenido al Sistema de Seguimiento.</h4>
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
                  <hr class="p-0 m-0"/>
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
              <div class="row">
                <div class="centrado">
                  <div class="col-md-12">
                      <div class="card el-overlay btn-outline ">
                        <h3 class="card-title">Gestiones</h3>
                        <form method="post" id="form-otro" name="form-otro" @submit.prevent="validarGestion(gestion)">
                          <div :class="['form-group',(gestion.clase).trim()?'has-'+gestion.clase:'']">
                            <label  class="control-label" >Seleccione la gestion a realizar seguimiento:</label>
                            <select 
                                    v-model="gestion.input" 
                                    class="form-control" 
                                    @change="onChange($event)"
                                    :class="['form-control',(gestion.clase).trim()?'form-control-' + gestion.clase:'']" >
                              <option value="">Seleccione Gestion</option>
                              <option v-for="gestion in arrayGestiones" v-bind:value="gestion.gestion" >
                                {{ gestion.gestion}}  
                              </option>
                            </select>
                            <div class="form-control-feedback" v-text="gestion.mensaje"></div>
                            <!--small class="form-text text-muted">La "," es separador de decimales.</small-->
                          </div>

                           <center><button class="btn btn-circle btn-outline btn-info btn-xl m-t-5"><i class="fa fa-arrow-right" style="font-size:30px"></i></button></center>
                         </form>
                          
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
      arrayInstitucion :[],
      arrayUser :[],
      arrayGestiones:[],
      gestion:{
        input:"",
        clase:"",
        mensaje:""
      },
      errors:[] 
    }
  },
  methods:{
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
       let me = this;
        axios.get('/api/planesTerritoriales/verificarEtapaSeguimiento?modulo='+e).then(function (response) {//este axios nos sirve para verificar en que etapa esta los modulos
          //console.log("verificar modulo respuesta");
          if(response.data.accion == 1){
            swal({
              title: response.data.title,
              text: response.data.msg,
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-success",
              confirmButtonText: "Si, Activar!",
              closeOnConfirm: false
            },
            function(){
              axios({
                 method: 'post',
                 url: '/api/planesTerritoriales/activarEtapaSeguimiento',
                 data: { etapa: response.data.accion,
                         vista: e}
               }).then(function (response) {
                 swal("Activado!", "Puede cargar los Recursos para este gestion.", "success");
                 me.$root.$data.views = e;
               }).catch(function (error) {
                 console.log(error);
               });

            });
          }
          if(response.data.accion == 2){
            me.$root.$data.views = e;
            console.log(me.$root.$data.views);
          }

          if(response.data.accion == 3){
            /*swal("Cerrado!", "Ya no puede modificar el módulo de Recursos ya que se concluyó el mismo", "info")*/
            ///////////77***************
            swal({
              title: response.data.title,
              text: response.data.msg,
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-success",
              confirmButtonText: "Si, Continuar!",
              closeOnConfirm: true
            },
            function(){
              me.$root.$data.views = e;
              /*axios({
                 method: 'post',
                 url: '/api/planesTerritoriales/activarEtapaSeguimiento',
                 data: { etapa: response.data.accion,
                         vista: e}
               }).then(function (response) {
                 swal("Activado!", "Puede cargar los Recursos para este gestion.", "success");
                 me.$root.$data.view = e;
               }).catch(function (error) {
                 console.log(error);
               });*/

            });
            //////////******************
          }

        }).catch(function (error) {
          // handle error
          console.log(error);
        });
    },
    cargarGestiones(){
      let me = this;
      //?modulo='+e
      axios.get('/api/planesTerritoriales/cargarGestiones').then(function(response){
        console.log(response);
        me.arrayGestiones = response.data.gestiones;
      })
      .catch(function(error){
        console.log(error);
      })
    },
    validarGestion(data){
      let me = this;
      if(!data.input){
        data.clase="warning";
        data.mensaje = "seleccione una gestion"
        me.errors.gestion= 'Error gestion.';
      }else{

        me.cambiarVista();
        
      }
      


    },
    cambiarVista(){
      let me = this;
      axios.get('/api/planesTerritoriales/cambiarVista?gestion='+ me.gestion.input).then(function(response){
       //window.location = "/planesTerritoriales/indexseguimiento";
        me.$root.$data.views = 5

      })
      .catch(function(error){
        console.log(error);
      })
    },
    onChange(event){
        let me = this;
        console.log(event.target.value)
        me.gestion.clase = "success";
        me.gestion.mensaje = "Selecciono Gestion";
        
      },
  },
  mounted() {
      this.datosUsuario();
      this.cargarGestiones();
  }
}

</script>
<style>
      .map{
        height: 420px;
        width: 100%;
      }
      #marker {
        width: 20px;
        height: 20px;
        border: 1px solid #088;
        border-radius: 10px;
        background-color: #0FF;
        opacity: 0.5;
      }
      .title_point {
        text-decoration: none;
        color: white;
        font-size: 11pt;
        font-weight: bold;
        text-shadow: black 0.1em 0.1em 0.2em;
      }
      .title_point:hover{
        text-decoration: none;
        color: #32A0D3;
        font-size: 11pt;
        font-weight: bold;
        text-shadow: #79EFEE 0.1em 0.1em 0.2em;
      }
      .push_button {
            position: relative;
            width: 120px;
            color: #FFF;
            display: block;
            text-decoration: none;
            margin: 0 auto;
                margin-right: auto;
                margin-left: auto;
            border-radius: 5px;
            border: solid 1px #2196F3;
            text-align: center;
            padding: 2px 2px;
            -webkit-transition: all 0.1s;
            -moz-transition: all 0.1s;
            transition: all 0.1s;
            -webkit-box-shadow: 0px 9px 0px #1EA4EE;
            -moz-box-shadow: 0px 9px 0px #1EA4EE;
            box-shadow: 0px 9px 0px #1EA4EE;
      }
      .push_button:active{
          -webkit-box-shadow: 0px 2px 0px #1EA4EE; /*color box-shadow  84261a  /  1565C0   color border  D94E3B  /   2196F3     */
          -moz-box-shadow: 0px 2px 0px #1EA4EE;
          box-shadow: 0px 2px 0px #1EA4EE;
          position:relative;
          top:7px;
      }
      .centrado{
        width:500px;
        margin: 0 auto;
        background-color:#fff;
      }

      

    </style>
