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
      <!--div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="white-box p-0 m-0 p-l-10 p-r-10 p-t-10 p-b-10"  >

          <div class="row list-group-item-info">
            <ul class="feeds ">
                <li class="m-t-10 m-l-10 m-r-10 m-b-10 p-0">
                    <div class="bg-inverse" style="width: 25px;height: 25px;"><i class="fa  fa-institution text-white " style="line-height: 25px;"></i></div>
                      <h4 class="m-t-0" style="display:inline-block; line-height: 25px">Vinculacion Accion ETA al PDES</h4>
                </li>
            </ul>

          </div>

        </div>
      </div-->
    </div>
    <div class="mipanel">
      <div class="row p-t-10 mipanelx">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="white-box p-0 m-0 p-l-10 p-r-10 p-t-10 p-b-10">
            <h4 class="m-t-0">VINCULACION ACCION ETA AL PDES</h4>
            <div class="" >
              <div>
                <!--button type="button" class="btn btn-info waves-effect waves-light mb-3 btn pull-right" @click="showProyectosPoa()"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>Agregar Otros Proyectos Poa</button-->
                <div class="table-responsive">
                  <div class="tableFixHead ">
                    <table id="art" class="table table-bordered color-table info-table">
                      <thead>
                        <tr>
                          <th colspan="4" class="text-center" style="align:center"><strong>ARTICULACION PDES</strong></th>
                          <th rowspan="2" class="text-center"><strong>INSCRITO PTDI/PGTC ACCION ETA</strong></th>
                          <th  rowspan="2" class="text-center"><strong>INSCRITO PEI</strong></th>
                          <th rowspan="2" class="text-center"><strong>ACCION</strong></th>
                          <th rowspan="2" class="text-center"><strong>PROYECTOS POA</strong></th>
                        </tr>
                        <tr>
                          <th class="text-center"><strong>P</strong></th>
                          <th class="text-center"><strong>M</strong></th>
                          <th class="text-center"><strong>R</strong></th>
                          <th class="text-center"><strong>A</strong></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(eta,index) in arrayObjetivoEta"
                            :key="index">
                          <td data-toggle="tooltip" title="Default tooltip">  <img :src="eta.logo"  class="img-rounded" alt="Cinque Terre" width="50" height="50"></td>
                          <td>{{ eta.cod_m}}</td>
                          <td>{{ eta.cod_r}}</td>
                          <td>{{ eta.cod_a}}</td>
                          <td  style="width: 200px; word-wrap: break-word;"> {{ eta.nombre_accion_eta}}</td>
                          <td style=" width: 200px; word-wrap: break-word;">  {{ eta.nombre_accion_eta}}</td>
                          
                          <td >
                            <div class="text-center">
                              
                              <a v-show="estado_modulo==true" href="#" @click="abrirModalProyPoa(index,1)" class="btn btn-dark" style="color:#000;"> <i class="fa fa-plus-circle  fa-2x   "></i> </a>  
                              
                            </div>
                          </td>
                          <td>
                            <div class="responsive">
                              <table class="color-table dark-table" style="width:100%">
                                <thead >
                                  <tr>
                                    <th>Proyecto POA</th>
                                    <th>Avance Fisico</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(proyPoa,index2) in eta.poa">
                                    <td style="list-group-item-success !important ">{{ proyPoa.nombre}}</td>
                                    <td>{{ proyPoa.avance_fisico}}</td>
                                    <td class="text-nowrap">
                                      
                                        <a v-show="estado_modulo==true" href="#" > <i class="fa fa-edit text-inverse m-r-10" @click="updateProyPoa(index,index2,2)"title="Editar Proyecto" style="font-size:20px;color:#000;"></i> </a>
                                        <a v-show="estado_modulo==true" href="#" > <i class="fa fa-trash text-inverse m-r-10" @click="deleteProyPoa(proyPoa.id)" title="Eliminar Proyecto"style="font-size:20px;" ></i> </a>
                                      
                                    </td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                              
                            </div>
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
      </div>
    </div>
    
    
    
    
   
    <div class="row">
      
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="white-box p-0 m-0 p-t-10 ">
          <div class="form-group text-center p-0 m-0">
                <button v-show="estado_modulo==true" type="submit" class="btn btn-success" @click="reporteAccionesGestionExcel">Exportar <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
                <button v-show="estado_modulo==true" type="submit" class="btn btn-danger" @click="reporteAccionesGestionPdf">Exportar <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
                <button v-show="estado_modulo==true" type="submit" class="btn btn-info" @click="finalizarModulo(7)">Salir y Finalizar</button>
                <button type="submit" class="btn btn-default" @click="salirModulo()">Salir</button>
          </div>
        </div>
      </div>
    </div>
      
    <div class="modal fade" :class="{'show':modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-content">
          <div class="modal-header">
               <button type="button" class="close" @click="cerrarModal()" aria-hidden="true">×</button>
               <h4 class="modal-title">PROYECTOS POA</h4>
          </div>
          <form method="post" id="form-otro" name="form-otro" @submit.prevent="validatePoa">

            <div class="modal-body">
              <div class="row">
                <div class="col-lg-6">
                  
                  <div :class="['form-group',(proyPoa.nombre.clase).trim()?'has-'+proyPoa.nombre.clase:'']">
                    <label  class="control-label" >Nombre Proyecto Poa:</label>
                    <input type="text"  id="inputSuccess1" v-model="proyPoa.nombre.input" 
                        :class="['form-control',(proyPoa.nombre.clase).trim()?'form-control-' + proyPoa.nombre.clase:'']"
                         @keyup="todoTexto(proyPoa.nombre)"   
                    >
                    <div class="form-control-feedback" v-text="proyPoa.nombre.mensaje"></div>
                    <!--small class="form-text text-muted">La "," es separador de decimales.</small-->
                  </div>
                  <div :class="['form-group',(proyPoa.avance_fisico.clase).trim()?'has-'+proyPoa.avance_fisico.clase:'']">
                    <label  class="control-label" >Avance Fisico:</label>
                    <input type="text"  id="inputSuccess1" v-model="proyPoa.avance_fisico.input" 
                        :class="['form-control',(proyPoa.avance_fisico.clase).trim()?'form-control-' + proyPoa.avance_fisico.clase:'']"
                         @keyup="midecimal(proyPoa.avance_fisico)"   
                    >
                    <div class="form-control-feedback" v-text="proyPoa.avance_fisico.mensaje"></div>
                    <small class="form-text text-muted">La "," es separador de decimales</small>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div :class="['form-group',(proyPoa.monto.clase).trim()?'has-'+proyPoa.monto.clase:'']">
                    <label  class="control-label" >Monto Proyecto POA:</label>
                    <input type="text"  id="inputSuccess1" v-model="proyPoa.monto.input" 
                        :class="['form-control',(proyPoa.monto.clase).trim()?'form-control-' + proyPoa.monto.clase:'']"
                         @keyup="midecimal(proyPoa.monto)"   
                    >
                    <div class="form-control-feedback" v-text="proyPoa.monto.mensaje"></div>
                    <small class="form-text text-muted">La "," es separador de decimales.</small>
                  </div>
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" v-model="es_vipfe">
                      <label class="checkbox-inline" for="defaultCheck1">
                        Es un proyecto VIPFE?
                      </label>
                    </div>
                  </div>
                  <div :class="['form-group',(proyPoa.codigo_sisin.clase).trim()?'has-'+proyPoa.codigo_sisin.clase:'']" v-show="es_vipfe == true">
                    <label  class="control-label" >CODIGO SISIN:</label>
                    <input type="text"  id="inputSuccess1" v-model="proyPoa.codigo_sisin.input" 
                        :class="['form-control',(proyPoa.codigo_sisin.clase).trim()?'form-control-' + proyPoa.codigo_sisin.clase:'']"
                         @keyup="validateNumberSisin(proyPoa.codigo_sisin)"   
                    >
                    <div class="form-control-feedback" v-text="proyPoa.codigo_sisin.mensaje"></div>
                    <!--small class="form-text text-muted">La "," es separador de decimales.</small-->
                  </div>
                  <div :class="['form-group',(proyPoa.inscrito_ptdi.clase).trim()?'has-'+proyPoa.inscrito_ptdi.clase:'']">
                      <div class=" radio-inline form-check-label">
                        <h5  class="form-check control-label" >Inscrito PTDI:</h5>
                        <label class="radio-inline form-check-label"><input class="form-check-input ptdi " type="radio" value="true" name="radioPtdi"  v-model ="proyPoa.inscrito_ptdi.input"  @change="validateRatio(proyPoa.inscrito_ptdi)" >Si</label>
                        <label class="radio-inline form-check-label"><input class="form-check-input ptdi " type="radio" value="false" name="radioPtdi"  v-model ="proyPoa.inscrito_ptdi.input" @change="validateRatio(proyPoa.inscrito_ptdi)" >No</label>
                        <div class="form-control-feedback" v-text="proyPoa.inscrito_ptdi.mensaje"></div>
                      </div>
                  </div> 
                  <div :class="['form-group',(proyPoa.inscrito_pei.clase).trim()?'has-'+proyPoa.inscrito_pei.clase:'']">
                    <div class=" radio-inline form-check-label">
                      <h5  class="form-check control-label" >Inscrito PEI:</h5>
                      <label class="radio-inline"><input type="radio" name="radioPei" value="true" v-model ="proyPoa.inscrito_pei.input"  @change="validateRatio(proyPoa.inscrito_pei)">Si</label>
                      <label class="radio-inline"><input type="radio"  name="radioPei" value="false" v-model ="proyPoa.inscrito_pei.input" @change="validateRatio(proyPoa.inscrito_pei)">No</label>  
                      <div class="form-control-feedback" v-text="proyPoa.inscrito_pei.mensaje"></div>
                    </div>
                  </div>
                  <div :class="['form-group',(proyPoa.inscrito_poa.clase).trim()?'has-'+proyPoa.inscrito_poa.clase:'']">
                    <div class=" radio-inline form-check-label">
                      <h5  class="form-check control-label" >Inscrito POA:</h5>
                      <label class="radio-inline radio-inline"><input type="radio" value="true" name="radioPoa"  v-model ="proyPoa.inscrito_poa.input" @change="validateRatio(proyPoa.inscrito_poa)" >Si</label>
                      <label class="radio-inline radio-inline"><input type="radio" value="false" name="radioPoa"  v-model ="proyPoa.inscrito_poa.input" @change="validateRatio(proyPoa.inscrito_poa)" >No</label>  
                      <div class="form-control-feedback" v-text="proyPoa.inscrito_poa.mensaje"></div>
                    </div>
                  </div>

                </div> 
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" @click="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn btn-info waves-effect waves-light" >Guardar</button>
              </div>
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
          arrayPOA:[],
          modal:0,
          modalProyectos:0,
          

          proyPoa:{
            id_accion_eta:'',
            id_proyecto_poa:'',
            nombre:{
              input:"",
              clase:"",
              mensaje:""
            },
            categoria_programatica:{
              input:"",
              clase:"",
              mensaje:""
            },
            monto:{
              input:"",
              clase:"",
              mensaje:""
            },
            avance_fisico:{
              input:"",
              clase:"",
              mensaje:""
            },
            codigo_sisin:{
              input:"",
              clase:"",
              mensaje:""
            },
            inscrito_ptdi:{
              input:"",
              clase:"",
              mensaje:""
            },
            inscrito_pei:{
              input:"",
              clase:"",
              mensaje:""
            },
            inscrito_poa:{
              input:"",
              clase:"",
              mensaje:""
            }
          },
          
          
          por_ptdi:false,
          checkTipo:'',
          idObjEta:'',
          nombre_indicador:'',
          unidad_indicador:'',
          cantidad_indicador:'',
          valor_indicador:'',
          gestion_indicador:'',

          
          arrayObjetivoEta:[],
          proyectosPoa:true,
          prueba:"prueba",
          radioPtdi :"",
          radioPei:"",
         
          
          listaProyectosAjuste:[],
          arrayInstitucion:[],
          listaCategoria:[],
          estado_modulo:"",
          plan_activo:"",
          gestion_activa:"",
          es_vipfe:false,
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
      
      listaObjetivosEta(){

        let me = this;
          axios.get('/api/planesTerritoriales/listaObjetivosEta').then(function (response) {
            me.arrayObjetivoEta = response.data.objEta;
            me.estado_modulo = response.data.estado_modulo;
            me.plan_activo = response.data.plan_activo;
            me.gestion_activa = response.data.gestion_activa;
            console.log(me.arrayObjetivoEta);
            $.each( me.arrayObjetivoEta, function( key, value ) {
              //console.log("hola"+value.cod_p);
              switch(value.cod_p){
                case 1:{
                  value.logo = "/img/PILAR_1.JPG";
                  break;
                };
                case 2:{
                  value.logo = "/img/PILAR_2.JPG";
                  break;
                };
                case 3:{
                  value.logo = "/img/PILAR_3.JPG";
                  break;
                };
                case 4:{
                  value.logo = "/img/PILAR_4.JPG";
                  break;
                };
                case 5:{
                  value.logo = "/img/PILAR_5.JPG";
                  break;
                };
                case 6:{
                  value.logo = "/img/PILAR_6.JPG";
                  break;
                };
                case 7:{
                  value.logo = "/img/PILAR_7.JPG";
                  break;
                };
                case 8:{
                  value.logo = "/img/PILAR_8.JPG";
                  break;
                };
                case 9:{
                  value.logo = "/img/PILAR_9.JPG";
                  break;
                };
                case 10:{
                  value.logo = "/img/PILAR_10.JPG";
                  break;
                };
                case 11:{
                  value.logo = "/img/PILAR_11.JPG";
                  break;
                };
                case 12:{
                  value.logo = "/img/PILAR_12.JPG";
                  break;
                };
                case 13:{
                  value.logo = "/img/PILAR_13.JPG";
                  break;
                };


              }
            });
           
            
          })
          .catch(function (error) {
           // handle error
           console.log(error);
          });
      },
      
      formatPrice(value) {
        let val = (value/1).toFixed(2).replace(',', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
      },
      
      saveProyPoa(){
        //alert("hola saveProyPoa");
        //
        //
        //
        let me = this;
        var proyPoaEnviar = {
          id_proyecto_poa:"",
          id_accion_eta:"",
          nombre:"",
          categoria_programatica:"",
          monto:"",
          avance_fisico:"",
          codigo_sisin:"",
          inscrito_ptdi:"",
          inscrito_pei:"",
          inscrito_poa:"",
        }

        console.log(me.idObjEta);
        //console.log(me.arrayObjetivoEta[me.idObjEta]);
        console.log(me.proyPoa.id_proyecto_poa);
        if(!me.proyPoa.id_proyecto_poa){
          proyPoaEnviar.id_proyecto_poa = 0; 
          

        }else{
           proyPoaEnviar.id_proyecto_poa = me.proyPoa.id_proyecto_poa;        
        }
        proyPoaEnviar.id_accion_eta =  me.arrayObjetivoEta[me.idObjEta].id;
        proyPoaEnviar.nombre = me.proyPoa.nombre.input;
        proyPoaEnviar.categoria_programatica = me.proyPoa.categoria_programatica.input;
        var monto = (me.replaceAll(me.proyPoa.monto.input,".","")).split(',').join('.');
        proyPoaEnviar.monto = monto;
        var avance_fisico = (me.replaceAll(me.proyPoa.avance_fisico.input,".","")).split(',').join('.');
        proyPoaEnviar.avance_fisico = avance_fisico
        if(!me.es_vipfe){
          proyPoaEnviar.codigo_sisin = "";
        }else{
          proyPoaEnviar.codigo_sisin = me.proyPoa.codigo_sisin.input;
        }
         
        proyPoaEnviar.inscrito_ptdi = me.proyPoa.inscrito_ptdi.input;
        proyPoaEnviar.inscrito_pei = me.proyPoa.inscrito_pei.input;
        proyPoaEnviar.inscrito_poa = me.proyPoa.inscrito_poa.input;
        console.log(proyPoaEnviar);
        
        axios({
          method: 'post',
          url: '/api/planesTerritoriales/saveProyectoPoa',
          data: {
            datos:proyPoaEnviar,
          }
        }).then(function (response) {
          
          swal("Datos guardados", "Los datos se guardaron correctamente", "success");
          me.listaObjetivosEta();
          me.proyPoa = {
            id_accion_eta:'',
            id:0,
            nombre:{
              input:"",
              clase:"",
              mensaje:""
            },
            categoria_programatica:{
              input:"",
              clase:"",
              mensaje:""
            },
            monto:{
              input:"",
              clase:"",
              mensaje:""
            },
            avance_fisico:{
              input:"",
              clase:"",
              mensaje:""
            },
            codigo_sisin:{
              input:"",
              clase:"",
              mensaje:""
            },
            inscrito_ptdi:{
              input:"",
              clase:"",
              mensaje:""
            },
            inscrito_pei:{
              input:"",
              clase:"",
              mensaje:""
            },
            inscrito_poa:{
              input:"",
              clase:"",
              mensaje:""
            }
          }
          /*me.proyPoa.id_accion_eta = "";
          me.proyPoa.categoria_programatica = "";
          me.proyPoa.nombre = "";
          me.proyPoa.monto = "";
          me.proyPoa.avance_fisico="";
          me.proyPoa.codigo_sisin="";
          me.proyPoa.inscrito_ptdi="";
          me.proyPoa.inscrito_pei="";
          me.proyPoa.inscrito_poa="";*/

          me.idObjEta = "";  
          me.nombre_indicador='';
          me.unidad_indicador='';
          me.cantidad_indicador='';
          me.valor_indicador='';
          me.gestion_indicador='';
          me.cerrarModal();
        }).catch(function (error) {
          console.log(error);
        });

      },
      abrirModalProyPoa(idEta,e){

        console.log("idEta"+idEta);
        let me = this;
        switch (e) {
          case 1:
            this.modal = 1;

            break;
          case 2:
            //recuperar datos par aupdate con axios
            this.modal = 1;
            ;
            break;
          default:
         }
          me.idObjEta = idEta;
          me.nombre_indicador=me.arrayObjetivoEta[me.idObjEta].nombre_indicador;
          me.unidad_indicador=me.arrayObjetivoEta[me.idObjEta].unidad;
          me.cantidad_indicador=me.arrayObjetivoEta[me.idObjEta].cantidad_indicador;
          me.valor_indicador=me.arrayObjetivoEta[me.idObjEta].valor;
          me.gestion_indicador=me.arrayObjetivoEta[me.idObjEta].gestion;
        
      },
      updateProyPoa(id1,id2,ventana){
        //console.log("hola desde POa");
        let me = this;
        console.log(id1);
        console.log(id2);
        console.log(ventana);
        me.proyPoa.id_proyecto_poa = me.arrayObjetivoEta[id1].poa[id2].id;
        console.log(me.proyPoa.id_proyecto_poa);

        me.proyPoa.categoria_programatica.input = me.arrayObjetivoEta[id1].poa[id2].categoria_programatica;
        me.proyPoa.nombre.input = me.arrayObjetivoEta[id1].poa[id2].nombre;
        me.proyPoa.monto.input = me.convertirFormato(me.arrayObjetivoEta[id1].poa[id2].monto);
        me.proyPoa.avance_fisico.input = me.convertirFormato(me.arrayObjetivoEta[id1].poa[id2].avance_fisico);

        me.proyPoa.codigo_sisin.input = me.arrayObjetivoEta[id1].poa[id2].codigo_sisin;
        me.proyPoa.inscrito_ptdi.input = me.arrayObjetivoEta[id1].poa[id2].inscrito_ptdi;
        me.proyPoa.inscrito_pei.input = me.arrayObjetivoEta[id1].poa[id2].inscrito_pei;
        me.proyPoa.inscrito_poa.input = me.arrayObjetivoEta[id1].poa[id2].inscrito_poa;
        me.abrirModalProyPoa(id1,2);
        

      },
      cerrarModal(){
        this.modal = 0;
        let me = this;
        me.proyPoa = {
            id_accion_eta:'',
            id:0,
            nombre:{
              input:"",
              clase:"",
              mensaje:""
            },
            categoria_programatica:{
              input:"",
              clase:"",
              mensaje:""
            },
            monto:{
              input:"",
              clase:"",
              mensaje:""
            },
            avance_fisico:{
              input:"",
              clase:"",
              mensaje:""
            },
            codigo_sisin:{
              input:"",
              clase:"",
              mensaje:""
            },
            inscrito_ptdi:{
              input:"",
              clase:"",
              mensaje:""
            },
            inscrito_pei:{
              input:"",
              clase:"",
              mensaje:""
            },
            inscrito_poa:{
              input:"",
              clase:"",
              mensaje:""
            }
          }
      },
      abrirOtrosProyPoa(e){
        //alert("hola desde otros proyectos POA");
        let me = this;
        switch (e) {
          case 1:
            this.modalProyectos = 1;
            break;
          case 2:
            //recuperar datos par aupdate con axios
            this.modalProyectos = 1;
            break;
          default:
         }
        
      },
      cerrarModalOtrosProyPoa(){
        this.modalProyectos = 0;
      },
      showProyectosPoa(){
        let me = this;
        me.proyectosPoa=false;
      },
      hideProyectosPoa(){
        let me = this;
        me.proyectosPoa=true;
      },
      
      deleteProyPoa(id){
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
                  url: '/api/planesTerritoriales/deleteProyPoa',
                  data: {
                    id : id
                  }
                }).then(function (response) {
                   me.listaObjetivosEta();
                   console.log(response);
                   console.log(me.listaObjetivosEta);
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
        //window.location = "/planesTerritoriales/indexseguimiento";
      },
      listaCategoriaProgramatica(){
        //console.log('hola estoy en la funcion categoria programatica');
        let me = this;
        axios.get('/api/planesTerritoriales/listaCategoriaProgramatica')
        .then(function(response){

          me.listaCategoria = response.data.categoria;
          //console.log(me.listaCategoria);
        }).catch(function(error){
          console.log(error);
        })

      },
      validatePoa(){

        let me = this;
        me.errors = [];
          
          /*if(!me.proyPoa.categoria_programatica.input){
            me.proyPoa.categoria_programatica.clase = "warning";
            me.proyPoa.categoria_programatica.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }*/
          if(!me.proyPoa.nombre.input){
            me.proyPoa.nombre.clase = "warning";
            me.proyPoa.nombre.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          if(!me.proyPoa.avance_fisico.input){
            me.proyPoa.avance_fisico.clase = "warning";
            me.proyPoa.avance_fisico.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          if(!me.proyPoa.monto.input){
            me.proyPoa.monto.clase = "warning";
            me.proyPoa.monto.mensaje = "El campo esta vacio";
            me.errors.push('Valid email required.');
          }
          if(me.es_vipfe === true){
            if(!me.proyPoa.codigo_sisin.input ){
              console.log(me.proyPoa.codigo_sisin.clase);
              me.proyPoa.codigo_sisin.clase = "warning";
              me.proyPoa.codigo_sisin.mensaje = "El campo esta vacio";
              
            }else{
              if(me.proyPoa.codigo_sisin.clase === "danger"){

                me.proyPoa.codigo_sisin.clase = "danger";
                me.proyPoa.codigo_sisin.mensaje = "Codigo SISIN debe tener 14 DIGITOS";
              }
            }
          }
          //////////////////////
          var checked_ptdi = $('input:radio[name=radioPtdi]:checked').val()
          console.log("es ptdi"+checked_ptdi);
          if(!checked_ptdi){
            me.proyPoa.inscrito_ptdi.clase = "warning";
            me.proyPoa.inscrito_ptdi.mensaje = "Debe elegir un opcion";
            me.errors.push('Valid email required.');
          }
          var checked_pei = $('input:radio[name=radioPei]:checked').val()
          console.log("es pei"+checked_pei);
           if(!checked_pei){
            me.proyPoa.inscrito_pei.clase = "warning";
            me.proyPoa.inscrito_pei.mensaje = "Debe elegir un opcion";
            me.errors.push('Valid email required.');
          }
          var checked_poa = $('input:radio[name=radioPoa]:checked').val()
          console.log("es poa"+checked_poa);
           if(!checked_poa){
            me.proyPoa.inscrito_poa.clase = "warning";
            me.proyPoa.inscrito_poa.mensaje = "Debe elegir un opcion";
            me.errors.push('Valid email required.');
          }
          if (me.errors.length>0) {
            console.log("datos Con errores");
            me.errors=[];
            return false;
          }else{
            console.log("datos sin errores, ENVIAR AL SERVIDOR");
            me.saveProyPoa();
          }
      },
      validateNumber:function(){
          let me = this;
          const isValid = me.isValidNumber(me.proyPoa.monto);

          //console.log(isValid);
          me.errors.monto = !isValid;
      },
      validateSisin(data){
          let me = this;
        var components = data.input.toString();  
        console.log(components.length);
        if(components.length > 14){
          
        //var re = /^(?:\D*\d){14}\D*$/;
          components = components.replace(/\D/g, "")
          console.log("mayor a 14");

        }else{
          console.log("menor igual  a 14");
        }
        
      

      },
      isValidNumber(numero){
        var re = /^\d*(\,\d{0,2})?$/;
                /*/d{1,3}(?=(d{3})+(?!d))/g*/
        return re.test(numero); 
      },
      
      onChange(event){
        let me = this;
        console.log(event.target.value)
        me.proyPoa.categoria_programatica.clase = "success";
        me.proyPoa.categoria_programatica.mensaje = "Eligio categoria programatica";
      },
      todoTexto(data){
        let me = this;
        if(data.input){
          me.proyPoa.nombre.clase = "success";
          me.proyPoa.nombre.mensaje = "Escribio un nombre de Proyecto";
        }else{
          me.proyPoa.nombre.clase = "warning";
          me.proyPoa.nombre.mensaje = "Escribio un nombre de Proyecto no puede estar vacio";
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
      validateNumberSisin(data){
          let me = this;
          var patron = /^\d{14}/;
          //const isValid = me.isValidNumberSisin(data);
          if(patron.test(data.input) && data.input.length === 14){//comoprobando que sea digito y tenga 14
            
              //console.log("Es cumple con el formato a 14 TRUE");
              data.clase = "success";
              data.mensaje = "Formato correcto ";
            
            
          }else{
            //console.log("Es el digito es mayor a 14 ELSE");
            data.clase = "danger";
            data.mensaje = "Codigo SISIN debe tener 14 DIGITOS";

          }
          if(data.input.length === 0){
            data.clase = "warning";
            data.mensaje = "Campo vacio";            
          }
          
      },
      
      isValidNumberSisin(data){

        var num = /^\d{14}/;
        if(num.test(data.input)){
          

          var re = /^(?:\D*\d){15}\D*$/;  
          return re.test(data.input);
        }else{

          data.input = data.input.slice(0, -1);
          
          var re = /^(?:\D*\d){15}\D*$/;  
          return re.test(data.input);
        }
        
        
      },
      validateRatio(data){
        if(!data.input){
          data.clase = 'warning';
          data.mensaje = "Debe seleccionar una oopcion";  

        }else{
          data.clase = 'success';
          data.mensaje = "Eligio una opcion";  

        }
      },
      convertirFormato(data){
        var components = data.toString().split(".");
        var completa = components[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".")+","+components[1];
        return completa;
        
      },
      reporteAccionesGestionExcel(){
        location.href = '/api/planesTerritoriales/reporteAccionesGestionExcel';
      },
      reporteAccionesGestionPdf(){
        location.href = '/api/planesTerritoriales/reporteAccionesGestionPdf';
      }

    },
    mounted() {
        
      this.listaObjetivosEta();
      //this.listaProyectosPoaAjuste();
      this.listaCategoriaProgramatica();
      this.arrayProyPoa;
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
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */{
  opacity: 0;
}
.mipanel{
  flex:1 1 auto;
  padding:10px;
  width:100%;
  max-height:500px;
  min-height:200px;
  background:rgba(#fafafa,0.75);
  overflow:auto;

}
.mipanelx{
  overflow-x:auto
}
button, input, optiongroup,select, textarea{
  margin-bottom:15px;
}


.card {
    margin-bottom: 20px;
}
.card-body {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0px solid transparent;
    border-radius: 0px;
}
.modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}
.tableFixHead          { overflow-y: auto; height: 400px; }
.tableFixHead thead th { position: sticky; top: 0; }




 
</style>
