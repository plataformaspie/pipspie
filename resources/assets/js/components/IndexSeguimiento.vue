<template>
  <div class="">
        <div class="row p-t-10">

          <div class="col-lg-12  text-center  m-b-5 p-t-20" style="background-color:#fb9678;">
            <!--div class="alert alert-warning">This is an example top alert. You can edit what u wish. </div-->
            <h4 class="font-bold m-t-0 " style="color:#fff">Plan : {{ planActivo }}</h4>
            <h5 class="font-bold m-t-0 " style="color:#fff">Gestion : {{ gestionActiva }}</h5>
          </div>
        </div>
        <div class="row p-t-10 " style="font-size:13px !important;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="white-box">
                <h4 class="font-bold m-t-0">Bienvenido al Sistema de Seguimiento y Evaluacion.</h4>
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

                        <div class="col-md-3">
                            <div class="card el-overlay btn-outline ">

                               <center><button class="btn btn-circle btn-outline btn-info btn-xl m-t-5" @click="cambioView(6)"><i class="fa fa-money" style="font-size:30px"></i></button></center>
                                <div class="card-block text-center">
                                    <h4 class="card-title">Recursos</h4>
                                    <p class="card-text">Ejecucion de Recursos Planificado </p>
                                    <p class="card-text">Estado: <span :class="(estado_sRecursos=='Inactivo') ? 'text-default':(estado_sRecursos=='Concluido')?'text-success':'text-danger'" v-text="estado_sRecursos"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card el-overlay btn-outline ">

                               <center><button class="btn btn-circle btn-outline btn-info btn-xl m-t-5" @click="cambioView(7)"><i class="fa fa-clipboard" style="font-size:30px"></i></button></center>
                                <div class="card-block text-center">
                                    <h4 class="card-title">Vinculacion de Acciones</h4>
                                    <p class="card-text">PDES con Acciones ETA</p>
                                    <p class="card-text">Estado: <span :class="(estado_sAcciones=='Inactivo') ? 'text-default':(estado_sAcciones=='Concluido')?'text-success':'text-danger'" v-text="estado_sAcciones"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card el-overlay btn-outline ">

                               <center><button class="btn btn-circle btn-outline btn-info btn-xl m-t-5" @click="cambioView(8)"><i class="fa fa-line-chart" style="font-size:30px"></i></button></center>
                                <div class="card-block text-center">
                                    <h4 class="card-title">Ejecucion Fisica - Financiera</h4>
                                    <p class="card-text">Acciones ETA</p>
                                    <p class="card-text">Estado: <span :class="(estado_sFisicaFinanciera =='Inactivo') ? 'text-default':(estado_sFisicaFinanciera=='Concluido')?'text-success':'text-danger'" v-text="estado_sFisicaFinanciera"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card el-overlay btn-outline ">

                               <center><button class="btn btn-circle btn-outline btn-info btn-xl m-t-5" @click="cambioView(9)"><i class="fa fa-building-o" style="font-size:30px"></i></button></center>
                                <div class="card-block text-center">
                                    <h4 class="card-title">Proyectos de Inversion Publica</h4>
                                    <p class="card-text">Planificados en el PTDI/PEI.</p>
                                    <p class="card-text">Estado: <span :class="(estado_sProyectosInversion=='Inactivo') ? 'text-default':(estado_sProyectosInversion=='Concluido')?'text-success':'text-danger'" v-text="estado_sProyectosInversion"></span></p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <h3 class="box-title  p-0 m-0"></h3>
                    <!--div class="row">
                        <div class="card col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                  <a href="#" class="">
                                      <img alt="PTDI" title="PTDI" src="/img/ico_PTDI.png" class="push_button">
                                      <div class="stats-row col-md-12 m-t-20 m-b-0 text-center">
                                          <div class="stat-item">
                                              <h6>Detalle</h6> <b><i class="fa fa-archive"></i> Plan Territorial de Desarrollo Integral</b>
                                          </div>
                                      </div>
                                  </a>
                                </div>
                                <div class="col-md-6">
                                  <a href="#" class="">
                                      <img alt="PTDI" title="PTDI" src="/img/ico_PEI.png" class="push_button">
                                      <div class="stats-row col-md-12 m-t-20 m-b-0 text-center">
                                          <div class="stat-item">
                                              <h6>Detalle</h6> <b><i class="fa fa-archive"></i> Plan Estratégico Institucional</b>
                                          </div>
                                      </div>
                                  </a>
                                </div>
                            </div>
                        </div>
                    </div-->
                </div>
            </div>
        </div>
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="white-box p-0 m-0 p-t-10 ">
          <div class="form-group text-center p-0 m-0">
                <button v-show="estado_modulo==true" type="submit" class="btn btn-info" @click="finalizarModulo(7)">Salir y Finalizar</button>
                <button type="submit" class="btn btn-default" @click="salirSeguimiento()">Salir</button>
          </div>
        </div>
      </div>
    </div>    
  </div>
</template>

<script>
// import 'ol/ol.css';
// import GeoJSON from 'ol/format/GeoJSON';
// import Map from 'ol/Map';
// import VectorLayer from 'ol/layer/Vector';
// import VectorSource from 'ol/source/Vector';
// import View from 'ol/View';
import 'ol/ol.css';
import Feature from 'ol/Feature.js';
import Map from 'ol/Map.js';
import Overlay from 'ol/Overlay.js';
import View from 'ol/View.js';
import GeoJSON from 'ol/format/GeoJSON.js';
import TileLayer from 'ol/layer/Tile';
import VectorLayer from 'ol/layer/Vector';
import VectorSource from 'ol/source/Vector';
import OSM  from 'ol/source/OSM';
import {fromLonLat} from 'ol/proj';
import {Fill, Stroke, Style, Text} from 'ol/style.js';
import XYZ from 'ol/source/XYZ.js';



    export default {
        data(){
            return{
              planActivo:'',
              gestionActiva:'',
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
              arrayRegion: [],
              codGeo:'',
              depto:'',
              title_mun:'',
              title_dep:'',
              title_prov:'',
              estadoRecursos:'Inactivo',
              estadoDeudas:'Inactivo',
              estado_sRecursos:'Inactivo',
              estado_sAcciones:'Inactivo',
              estado_sFisicaFinanciera:'Inactivo',
              estado_sProyectosInversion:'Inactivo',
              estado_modulo:''
            }
        },
        methods: {
           datosUsuario(){
             let me = this;
              axios.get('/api/planesTerritoriales/datosUsuario').then(function (response) {
                 // handle success
                 me.arrayInstitucion = response.data.institucion;
                 me.arrayUser = response.data.user;
                 me.arrayRegion = response.data.region;
                 me.codGeo = response.data.region.muni_codigo;
                 me.depto = response.data.region.depto_codigo;
                 me.title_mun = response.data.region.muni;
                 me.title_prov = response.data.region.prov;
                 me.title_dep = response.data.region.depto;
                 me.iniciarMapa();
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
           estadoActualModulosSeguimiento(){
             let me = this;
             axios.get('/api/planesTerritoriales/estadoActualModulosSeguimiento').then(function (response) {
                console.log(response);
                me.estado_sRecursos = response.data.sRecursos;
                me.estado_sAcciones = response.data.sAcciones;
                me.estado_sFisicaFinanciera = response.data.sFisicaFinanciera;
                me.estado_sProyectosInversion = response.data.sProyectosInversion;
                me.planActivo = response.data.planActivo;
                me.gestionActiva = response.data.gestionActiva;

              })
              .catch(function (error) {
                // handle error
                console.log(error);
              });
           },
           salirSeguimiento(){
              window.location = "/planesTerritoriales/index"
           },
           iniciarMapa(){
            var styles = {
                'Polygon': new Style({
                  stroke: new Stroke({
                    color: '#DA232C',
                    //lineDash: [4],
                    width: 2
                  }),
                  fill: new Fill({
                    color: 'rgba(241,215,215, 0.8)'
                  })
                })
            };

            var styleLimites = new Style({
                fill: new Fill({
                  color: 'rgba(255, 255, 255, 0.6)'
                }),
                stroke: new Stroke({
                  color: '#319FD3',
                  width: 1
                }),
                text: new Text()
              });

            var styleFunction = function(feature) {
              return styles[feature.getGeometry().getType()];
            };


            var vectorLayer = new VectorLayer({
               source: new VectorSource({
                 format: new GeoJSON(),
                 //url: '/geoData/PANDO_MUNICIPIOS.geojson'
                 url:'/api/planesTerritoriales/mapaMunicipio?codigo='+this.codGeo
               }),
               style : styleFunction

            });

            var vectorLayer2 = new VectorLayer({
               source: new VectorSource({
                 format: new GeoJSON(),
                 //url: '/geoData/PANDO_MUNICIPIOS.geojson'
                 url:'/api/planesTerritoriales/mapaDepartamento?codigo='+this.depto
               }),
               style: function(feature) {
                  styleLimites.getText().setText(feature.get('NOM_MUN'));
                  return styleLimites;
               }
            });

            // const PandoLonLat = [-67.2144, -11.0383];//Long---Lati
            const depLon = Number(this.arrayRegion.depto_lon);
            const depLat = Number(this.arrayRegion.depto_lat);
            const PandoLonLat = [depLon, depLat];//Long---Lati
            const PandoCenter = fromLonLat(PandoLonLat);

            var map = new Map({
                  target: 'map',
                  layers: [
                      // new TileLayer({
                      //   source: new OSM()
                      // }),
                      new TileLayer({
                        source: new XYZ({
                          attributions: 'Tiles © <a href="https://services.arcgisonline.com/ArcGIS/' +
                              'rest/services/World_Topo_Map/MapServer">ArcGIS</a>',
                          url: 'https://server.arcgisonline.com/ArcGIS/rest/services/' +
                              'World_Topo_Map/MapServer/tile/{z}/{y}/{x}'
                        })
                      }),
                      vectorLayer2,
                      vectorLayer
                  ],
                  view: new View({
                    center: PandoCenter,
                    zoom: 7
                  })
             });

              //Datos Del Municipio Actual
              const munLon = Number(this.arrayRegion.muni_lon);
              const munLat = Number(this.arrayRegion.muni_lat);

              const posMunLonLat = [munLon,munLat];
              // const posMunLonLat = [-67.18047222,-11.30708611];
              const posMunPoint = fromLonLat(posMunLonLat);

             // Vienna marker
            var marker = new Overlay({
              position: posMunPoint,
              positioning: 'center-center',
              element: document.getElementById('marker'),
              stopEvent: false
            });
            map.addOverlay(marker);
           }
        },
        mounted() {
            this.datosUsuario();
            this.estadoActualModulosSeguimiento();
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
      

    </style>
