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
             <div class="col-md-6">
                 <div class="white-box">
                   <h3 class="box-title  p-0 m-0">Ubicación Geografica.</h3>
                      <div class="row">
                          <div class="col-md-9">
                            <div id="map" class="map"></div>
                          </div>
                          <div class="col-md-3 text-center">
                            <h5>Detalle:</h5>
                            <p class="m-b-0">Departamento: </p>
                            <a class="overlay title_point"  href="javascript:void(0);" v-text="title_dep"></a>
                            <p class="m-b-0 m-t-10">Provincia: </p>
                            <a class="overlay title_point" href="javascript:void(0);" v-text="title_prov"></a>
                            <p class="m-b-0 m-t-10">Municipio: </p>
                            <a class="overlay title_point"  href="javascript:void(0);" v-text="title_mun"></a>
                          </div>
                      </div>
                      <div style="display: none;">
                        <div id="marker" :title="title_mun"></div>
                      </div>
                 </div>
            </div>
            <div class="col-md-6">
                <div class="white-box">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="card el-overlay btn-outline ">

                               <center><button class="btn btn-circle btn-outline btn-info btn-xl m-t-5" @click="cambioView(1)"><i class="fa fa-money" style="font-size:30px"></i></button></center>
                                <div class="card-block text-center">
                                    <h4 class="card-title">Registro de Recursos</h4>
                                    <p class="card-text">Asignación Techos Presupuestarios.</p>
                                    <p class="card-text">Estado: <span :class="(estadoRecursos=='Inactivo') ? 'text-default':(estadoRecursos=='Concluido')?'text-success':'text-danger'" v-text="estadoRecursos"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <center><button class="btn btn-circle btn-outline btn-info btn-xl m-t-5" @click="cambioView(2)" ><i class="fa fa-cubes" style="font-size:30px"></i></button></center>
                                <div class="card-block text-center">
                                    <h4 class="card-title">Registro de Deudas</h4>
                                    <p class="card-text">Registre deudas del Municipio.</p>
                                    <p class="card-text">Estado: <span :class="(estadoDeudas=='Inactivo') ? 'text-default':(estadoDeudas=='Concluido')?'text-success':'text-danger'" v-text="estadoDeudas"></span></p>

                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-12">
                            <div class="card">
                                <center><button class="btn btn-circle btn-outline btn-info btn-xl m-t-5" @click="cambioView(3)"><i class="fa fa-list-alt" style="font-size:30px"></i></button></center>
                                <div class="card-block text-center">
                                    <h4 class="card-title">Determinación de Recuros</h4>
                                    <p class="card-text">Registre la Planificación de su Municipio.</p>
                                    <p class="card-text">Estado: <span class="text-danger">No Concluido</span></p>

                                </div>
                            </div>
                        </div> -->
                    </div>
                    <h3 class="box-title  p-0 m-0">Asignacion de Recuros</h3>
                    <div class="row">
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
                    </div>
                </div>
           </div>
        </div>


         <!-- <div class="row" style="font-size:13px !important;">
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

                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div> -->


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
              estadoDeudas:'Inactivo'
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
              axios.get('/api/planesTerritoriales/verificarEtapa?modulo='+e).then(function (response) {//este axios nos sirve para verificar en que etapa esta los modulos
                if(response.data.accion == 1){
                  swal({
                    title: "Activar cargado de Recursos?",
                    text: "Se activara el cargado de Recursos para este Periodo!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Si, Activar!",
                    closeOnConfirm: false
                  },
                  function(){
                    axios({
                       method: 'post',
                       url: '/api/planesTerritoriales/activarEtapa',
                       data: {etapa: response.data.accion}
                     }).then(function (response) {
                       swal("Activado!", "Puede cargar los Recursos para este Periodo.", "success");
                       me.$root.$data.view = e;
                     }).catch(function (error) {
                       console.log(error);
                     });

                  });
                }
                if(response.data.accion == 2){
                  me.$root.$data.view = e;
                }

                if(response.data.accion == 3){
                  swal("Cerrado!", "Ya no puede modificar el módulo de Recursos ya que se concluyó el mismo", "info")
                }

              }).catch(function (error) {
                // handle error
                console.log(error);
              });

           },
           estadoActualModulos(){
             let me = this;
             axios.get('/api/planesTerritoriales/estadoActualModulos').then(function (response) {
                // handle success
                me.estadoRecursos = response.data.moduloRecursosEstado;

              })
              .catch(function (error) {
                // handle error
                console.log(error);
              });
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
            this.estadoActualModulos();
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
