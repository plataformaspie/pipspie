<template>
  <div style="font-size:12px !important;">

     <div class="row p-t-10 ">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="white-box p-0 m-0 p-l-10 p-r-10 p-t-10 p-b-0"  >

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
     <div class="row p-t-10 ">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="white-box p-t-10">
                <div class="row p-t-10 ">
                   <div class="col-lg-8">
                        <strong class="text-center" style="font-size:15px !important;">CATEGORIAS PARA ASIGNAR SUS RECURSOS.</strong>
                        <div class="row">
                          <div v-for="categoriasPadre in arrayCategoriasPadre" class="col-md-12 hover_card">
                              <div class="row show-grid" @click="cambioView(31,categoriasPadre.id)" style="cursor:pointer">
                                  <div class="col-xs-12 col-sm-6 col-md-2 ">
                                    <div class="card" style="bottom: -6px;">
                                       <center>
                                         <button class="btn btn-circle btn-outline btn-info btn-xl"  style="margin:15px;">
                                           <i class="fa" :class="categoriasPadre.icono" style="font-size:30px"></i>
                                         </button>
                                       </center>
                                    </div>
                                  </div>
                                  <div class="col-xs-12 col-md-10 card-block">
                                    <div class="col-md-8">
                                      <div class="text-left p-0">
                                          <h4 class="card-title" v-text="categoriasPadre.nombre_categoria"></h4>
                                          <p class="card-text" v-text="categoriasPadre.descripcion"></p>
                                          <p class="card-text">Estado: <span :class="(categoriasPadre.estado_etapa==null) ? 'text-default':(categoriasPadre.estado_etapa=='Concluido')?'text-success':'text-danger'" v-text="(categoriasPadre.estado_etapa==null)?'Inactivo':categoriasPadre.estado_etapa"></span></p>
                                      </div>
                                    </div>
                                    <div class="col-md-4 b-0">
                                      <p v-text="'TOTAL RECURSOS PROGRAMADOS:'"></p>
                                      <strong style="font-size:15px;"> Bs.{{ formatPrice(categoriasPadre.monto_prorgamado) }}</strong>
                                    </div>

                                  </div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="row">
                           <div class="col-lg-12" style="font-size:15px !important;">
                             <strong class="text-center">TOTALES.</strong>
                             <hr class="p-0 m-0"/>
                             <div class="row">
                                 <div class="col-lg-12 m-t-10" :class="alertaTotales">
                                   <p v-text="'TOTAL RECURSOS:'"></p>
                                 </div>
                                 <div class="col-lg-12 m-b-10 text-right" :class="alertaTotales">
                                   <strong style="font-size:20px;"> Bs.{{ formatPrice(totalRecursos) }}</strong>
                                 </div>

                                 <div class="col-lg-12" :class="alertaTotales">
                                   <p v-text="'TOTAL ASIGNACIÓN DE RECURSOS:'"></p>
                                 </div>
                                 <div class="col-lg-12 m-b-10 text-right" :class="alertaTotales">
                                   <strong style="font-size:20px;"> Bs.{{ formatPrice(totalRecursosAsignados) }}</strong>
                                 </div>

                                 <div class="col-lg-12" :class="alertaTotales">
                                   <p v-text="'SALDO TOTAL:'"></p>
                                 </div>
                                 <div class="col-lg-12 text-right" :class="alertaTotales">
                                   <strong style="font-size:20px;"> Bs.{{ formatPrice(saldoTotal) }}</strong>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12">
                             <div class="white-box p-0 m-0 p-l-10 p-r-10 p-t-10 p-b-0"  >
                               <strong class="text-center" style="font-size:15px !important;">GRÁFICA.</strong>
                               <div class="hello" ref="chartdiv"></div>
                            </div>
                          </div>
                      </div>
                    </div>
                </div>

            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="white-box p-0 m-0 p-t-10 ">
              <div class="form-group text-center p-0 m-0">
                    <button v-if="estadoViewComponente" type="submit" class="btn btn-info" @click="finalizarModulo(3)">Salir y Finalizar</button>
                    <button type="submit" class="btn btn-default" @click="salirModulo()">Salir</button>
              </div>
            </div>
          </div>
     </div>


</div>

</template>

<script>
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
am4core.useTheme(am4themes_animated);
export default {
      data(){
          return{
            arrayInstitucion: [],
            arrayCategoriasPadre: [],
            arrayUser: [],
            name: 'HelloWorld',
            totalDeuda:0,
            totalRecursos:0,
            totalRecursosAsignados:0,
            saldoTotal: 0,
            estadoViewComponente:true,
            alertaTotales:"list-group-item-success"
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
        listaCategorias(){
          let me = this;
           axios.get('/api/planesTerritoriales/categoriasPadreAcciones').then(function (response) {
              // handle success
              me.arrayCategoriasPadre = response.data.categoriasPadre;
              me.totalDeuda = response.data.totalDeuda;
              me.totalRecursos = response.data.totalRecursos;
              me.totalRecursosAsignados = response.data.totalRecursosAsignados;
              me.saldoTotal = (me.totalRecursos - me.totalDeuda - me.totalRecursosAsignados);
              if(me.saldoTotal < 0){
                me.alertaTotales = "list-group-item-danger";
              }else if(me.saldoTotal < 50000) {
                me.alertaTotales = "list-group-item-warning";
              }else{
                me.alertaTotales = "list-group-item-success";
              }
              me.cargarGrafica();
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            });
        },
        cambioView(e,id){
          let me = this;
           axios.get('/api/planesTerritoriales/verificarEtapaCategoria?categoria='+id).then(function (response) {//este axios nos sirve para verificar en que etapa esta los modulos
             if(response.data.accion == 1){
               swal({
                 title: "Activar esta Categoria?",
                 text: "Se activara la categoria para su llenado!",
                 type: "warning",
                 showCancelButton: true,
                 confirmButtonClass: "btn-success",
                 confirmButtonText: "Si, Activar!",
                 closeOnConfirm: false
               },
               function(){
                 axios({
                    method: 'post',
                    url: '/api/planesTerritoriales/activarCategoria',
                    data: {categoria: response.data.categoria}
                  }).then(function (response) {
                    me.$root.$data.view = e;
                    me.$root.$data.categoria = id;
                    me.$root.$data.categoria_estado = response.data.accion;
                    swal("Activado!", "Puede cargar datos a esta categoria.", "success");
                  }).catch(function (error) {
                    console.log(error);
                  });

               });
             }
             if(response.data.accion == 2){
               me.$root.$data.view = e;
               me.$root.$data.categoria = id;
               me.$root.$data.categoria_estado = response.data.accion;
             }

             if(response.data.accion == 3){
               me.$root.$data.view = e;
               me.$root.$data.categoria = id;
               me.$root.$data.categoria_estado = response.data.accion;

             }
             if(response.data.accion == 0){
               swal("Alerta!", response.data.msg, "info")
             }

           }).catch(function (error) {
             // handle error
             console.log(error);
           });

        },
        cargarGrafica(){
          let me = this;
          let chart = am4core.create(me.$refs.chartdiv, am4charts.XYChart);
          chart.paddingRight = 20;
          let data = [];
          data = [{
                    "variable": "RECURSOS",
                    "valor": me.totalRecursos
                  }, {
                    "variable": "ASIGNACIÓN\nDE RECURSOS",
                    "valor": me.totalRecursosAsignados
                  }, {
                    "variable": "SALDO",
                    "valor": me.saldoTotal
                  }];

          chart.data = data;

          let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
          categoryAxis.dataFields.category = "variable";
          categoryAxis.renderer.grid.template.location = 0;
          categoryAxis.renderer.minGridDistance = 30;
          let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

          // Create series
          let series = chart.series.push(new am4charts.ColumnSeries());
          series.dataFields.valueY = "valor";
          series.dataFields.categoryX = "variable";
          series.name = "Visits";
          series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
          series.columns.template.fillOpacity = .8;

          let columnTemplate = series.columns.template;
          columnTemplate.strokeWidth = 2;
          columnTemplate.strokeOpacity = 1;

          this.chart = chart;
        },
        formatPrice(value) {
          let val = (value/1).toFixed(2).replace('.', ',')
          return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        salirModulo(){
           window.location = "/planesTerritoriales/index";
        },
        finalizarModulo(m){
            let me = this;
            if(me.saldoTotal >= 0){

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
           }else{
                 swal("Alerta!", "Tiene un saldo negativo, verificar montos para poder finalizar módulo.", "warning");
           }
        }
      },
      mounted() {
          this.datosUsuario();
          this.listaCategorias();
          if(this.$root.$data.modulo_estado == 'Concluido')
          {
            this.estadoViewComponente = false;
          }else{
            this.estadoViewComponente = true;
          }
      },
      beforeDestroy() {
        if (this.chart) {
          this.chart.dispose();
        }
      }
    }
</script>



<style media="screen">
  .hover_card:hover{
    opacity: .8;
    border: 1px solid #e4e7ea;
    background: #e4e7ea;
  }

  .hello {
    width: 100%;
    height: 250px;
  }
</style>
