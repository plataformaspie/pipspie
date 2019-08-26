<template>
  <div style="font-size:10px !important;">
    <div class="row">
      <div class="col-lg-12 " >
        <div class=" p-l-25" style="background-color:#edf1f5;">
          <h2 style="color:#2488b5"class="p-l-20 p-t-10 m-0">EVALUACION DE MEDIO TERMINO</h2> 
          <h5 style="color:#2488b5" class="p-l-20 m-t-5">PLAN : PDES(2016-2020)</h5>   
          <h5 style="color:#2488b5" class="p-l-20 m-t-5">GESTION : 2016, 2017, 2018</h5>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body p-b-0" style="margin:5px 15px;">
                
                <!--h4 class="card-title">Pdes 2016-2020</h4-->
                <!--h6 class="card-subtitle">Gestion 2016,2017,2018 <code>gestion 2018</code></h6-->
            <!-- Nav tabs -->
            <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#proyecto" role="tab" aria-selected="true">
                    <span class="hidden-sm-up">
                      <i class="fa fa-money"></i>
                    </span>
                     <span class="hidden-xs-down">RECURSOS</span>
                  </a>
                 </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#concurrenciaeta" role="tab" aria-selected="false">
                    <span class="hidden-sm-up">
                      <i class="fa fa-tasks"></i>
                    </span>
                    <span class="hidden-xs-down">ACCIONES</span>
                  </a> </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#concurrenciaentidades" role="tab" aria-selected="false">
                    <span class="hidden-sm-up">
                      <i class="fa fa-university"></i>
                    </span>
                    <span class="hidden-xs-down">FISICO - FINANCIERO</span>
                  </a>
                </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#entidadejecutora" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="fa fa-area-chart"></i></span> <span class="hidden-xs-down">PROYECTOS DE INVERSION</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#gestionriesgos" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="fa fa-bar-chart"></i></span> <span class="hidden-xs-down">GESTION RIESGOS</span></a> </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="proyecto" role="tabpanel">
                    <div class="col-lg-12">
                      <div class="p-20">
                        <div class="table-responsive">
                          <div class="tableFixHead">
                            <table class="table table-bordered " >
                              <thead style="color:#fff; background:rgb(36, 136, 181);">
                                <tr style="vertical-align:middle">
                                  
                                  <td  style="vertical-align:middle" colspan="" rowspan="2">FUENTE DE INGRESOS</td>
                                  <td  style="vertical-align:middle; horizontal-align:middle" colspan="6">PTDI/PGTC</td>
                                  <td  style="vertical-align:middle" colspan="6">PEI</td>
                                  <td  style="vertical-align:middle" colspan="4">POA</td>
                                  <td style="vertical-align:middle;"  rowspan="2" width="20%">CAUSAS DE VARIACION</td>
                                  
                                </tr>
                                <tr>

                                  <td style="vertical-align:middle" >2016 (Prog)</td>
                                  <td style="vertical-align:middle" >2017 (Prog)</td>
                                  <td style="vertical-align:middle" >2018 (Prog)</td>
                                  <td style="vertical-align:middle" >TOTAL (2016-2018)</td>
                                  <td style="vertical-align:middle" >DIF A POA % </td>
                                  <td style="vertical-align:middle" >DIF %</td>
                                  <td style="vertical-align:middle" >2016 (Prog)</td>
                                  <td style="vertical-align:middle" >2017 (Prog)</td>
                                  <td style="vertical-align:middle" >2018 (Prog)</td>
                                  <td style="vertical-align:middle" >TOTAL (2016-2018)</td>
                                  <td style="vertical-align:middle" >DIF A POA % </td>
                                  <td style="vertical-align:middle" >DIF %</td>
                                  <td style="vertical-align:middle" >2016 (Prog)</td>
                                  <td style="vertical-align:middle" >2017 (Prog)</td>
                                  <td style="vertical-align:middle" >2018 (Prog)</td>
                                  <td style="vertical-align:middle" >TOTAL (2016-2018)</td>

                                </tr>
                              </thead>
                              <tbody style="color:#000">
                                <tr v-for="r in recursos">
                                  <td>{{ r.nombre }}</td>
                                  <td class="text-right">{{ formatPrice(r.planificacion_2016) }}</td>
                                  <td class="text-right">{{ formatPrice(r.planificacion_2017) }}</td>
                                  <td class="text-right">{{ formatPrice(r.planificacion_2018) }}</td>
                                  <td class="text-right">{{ formatPrice(r.total_recurso_2016_2018) }}</td>
                                  <td class="text-right">{{ formatPrice(r.total_diferencia_ptdi_poa) }}</td>
                                  <td class="text-right">{{ formatPrice(r.total_diferencia_porcentaje_ptdi_poa )}} </td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">{{ formatPrice(r.poa_2016) }}</td>
                                  <td class="text-right">{{ formatPrice(r.poa_2017) }}</td>
                                  <td class="text-right">{{ formatPrice(r.poa_2018) }}</td>
                                  <td class="text-right">{{ formatPrice(r.total_recurso_poa_2016_2018) }}</td>
                                  <td >
                                    <div :class="['form-group',(r.clase).trim()?'has-'+r.clase:'']" style="width:200px">
                                      <label class="form-control-label" for="inputSuccess1">POA</label>
                                      <textarea type="text"  
                                                id="inputSuccess1" 
                                                v-model="r.input" 
                                                :class="['form-control',(r.clase).trim()?'form-control-' + r.clase:'']"
                                                @keyup="validarComentario(r)"
                                                rows="5" 
                                                cols="50"
                                      ></textarea>
                                      <div class="form-control-feedback" v-text="r.mensaje"></div>
                                      
                                    </div>
                                  </td>
                                </tr>
                                <tr v-for="o in otros">
                                  <td>{{ o.nombre }}</td>
                                  <td class="text-right">{{ formatPrice(o.planificacion_2016) }}</td>
                                  <td class="text-right">{{ formatPrice(o.planificacion_2017) }}</td>
                                  <td class="text-right">{{ formatPrice(o.planificacion_2018) }}</td>
                                  <td class="text-right">{{ formatPrice(o.total_recurso_2016_2018) }}</td>
                                  <td class="text-right">{{ formatPrice(o.total_diferencia_ptdi_poa) }}</td>
                                  <td class="text-right">{{ formatPrice(o.total_diferencia_porcentaje_ptdi_poa )}} </td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">{{ formatPrice(o.poa_2016) }}</td>
                                  <td class="text-right">{{ formatPrice(o.poa_2017) }}</td>
                                  <td class="text-right">{{ formatPrice(o.poa_2018) }}</td>
                                  <td class="text-right">{{ formatPrice(o.total_recurso_poa_2016_2018) }}</td>
                                  
                                  <td >
                                    <div :class="['form-group',(o.clase).trim()?'has-'+o.clase:'']" style="width:200px">
                                      <label class="form-control-label" for="inputSuccess1">POA</label>
                                      <textarea type="text"  
                                                id="inputSuccess1" 
                                                v-model="o.input" 
                                                :class="['form-control',(o.clase).trim()?'form-control-' + o.clase:'']"
                                                @keyup="validarComentario(o)"
                                                rows="5" 
                                                cols="50"
                                      ></textarea>
                                      <div class="form-control-feedback" v-text="o.mensaje"></div>
                                      
                                    </div>
                                  </td>
                                  
                                </tr>
                                <tr v-for="t in totales">
                                  <td>TOTALES</td>
                                  <td class="text-right">{{ formatPrice(t.total_gestion_2016) }}</td>
                                  <td class="text-right">{{ formatPrice(t.total_gestion_2016) }}</td>
                                  <td class="text-right">{{ formatPrice(t.total_gestion_2016) }}</td>
                                  <td class="text-right">{{ formatPrice(t.total_gestion_2016_2018) }}</td>
                                  <td class="text-right">{{ formatPrice(t.total_diferencia_ptdi_poa_2016_2018) }}</td>
                                  <td class="text-right">{{ formatPrice(t.total_diferencia_porcentaje_ptdi_poa_2016_2018) }}</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">0</td>
                                  <td class="text-right">{{ formatPrice(t.total_poa_2016) }}</td>
                                  <td class="text-right">{{ formatPrice(t.total_poa_2017) }}</td>
                                  <td class="text-right">{{ formatPrice(t.total_poa_2018) }}</td>
                                  <td class="text-right">{{ formatPrice(t.total_gestion_poa_2016_2018) }}</td>
                                  <td></td>
                                </tr>
                              </tbody>
                            </table>
                          </div> 
                          
                        </div>
                      </div>
                      <!--button class="btn btn-primary" @click="ReporteExcel">Reporte Excel</button-->
                      <button v-show="btnReporteRecursos" @click="ReporteExcel" type="button" class="btn waves-effect waves-light btn-success">Exportar Excel<i class="fa fa-file-excel-o" aria-hidden="true" ></i></button>
                      <button v-show="btnReporteRecursos" type="submit" class="btn btn-danger" @click="reporteRecursosMedioPdf">Exportar Pdf <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
                      <button class="btn btn-info" @click="saveReporte">Guardar Reporte</button>
                    </div>
                </div>
                <div class="tab-pane p-20" id="concurrenciaeta" role="tabpanel">
                  <div class="col-lg-12">
                    <div class="p-20">
                      <div class="p-20">
                        <div class="tableFixHead">
                          <table class="table table-bordered">
                            <thead >
                              <tr style="color:#fff; background:rgb(36, 136, 181);">
                                <td  style="vertical-align:middle" colspan="4">ARTICULACION PDES</td>
                                <td  style="vertical-align:middle; width:200px" rowspan="2">INSCRITO EN EL PTDI/PGTC<br/>
                                ACCION ETA
                                </td>
                                <td  style="vertical-align:middle" rowspan="2">INSCRITO EN EL PEI</td>
                                <td  style="vertical-align:middle" rowspan="2" colspan="4">PROYECTOS POA</td>
                              </tr>
                              <tr style="color:#fff; background:rgb(36, 136, 181);">
                                <td>P</td>
                                <td>M</td>
                                <td>R</td>
                                <td>A</td>
                                
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="a in acciones">
                                <td>{{ a.cod_p}}</td>
                                <td>{{ a.cod_m}}</td>
                                <td>{{ a.cod_r}}</td>
                                <td>{{ a.cod_a}}</td>
                                <td>{{ a.nombre_accion_eta }}</td>
                                <td>{{ a.nombre_accion_eta }}</td>
                                <td>
                                  <table >
                                    <tr style="background:#01c0c8; color:#fff">
                                      
                                      <td  style="vertical-align:middle" rowspan="2">INSCRITO EN EL POA</td>
                                      <td style="vertical-align:middle" rowspan="2" >COD. CAT.<br/> PROGRAMATICA</td>
                                      <td colspan="3" >GESTION</td>
                                    </tr>
                                    <tr style="background:#01c0c8; color:#fff">
                                      <td style="vertical-align:middle" >2016 (Prog)</td>
                                      <td style="vertical-align:middle" >2017 (Prog)</td>
                                      <td style="vertical-align:middle" >2018 (Prog)</td>
                                    </tr>
                                    <tr v-for="p in a.poa">
                                      <td>{{ p.nombre }}</td>
                                      <td>{{ p.categoria_programatica }}</td>
                                      <td v-if="p.gestion == 2016">X</td>
                                      <td v-else></td>
                                      <td v-if="p.gestion == 2017">X</td>
                                      <td v-else></td>
                                      <td v-if="p.gestion == 2018">X</td>
                                      <td v-else></td>
                                    </tr>
                                  </table>  
                                </td>
                                
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        
                      </div>
                    </div>
                    <button  @click="reporteAccionesExcel" type="button" class="btn waves-effect waves-light btn-success">Exportar Excel<i class="fa fa-file-excel-o" aria-hidden="true" ></i></button>
                    <button  type="submit" class="btn btn-danger" @click="reporteAccionesMedioPdf">Exportar Pdf <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
                  </div>
                </div>
                <div class="tab-pane p-20" id="concurrenciaentidades" role="tabpanel">
                  <div class="col-lg-12">
                    <div class="p-20">
                      <div class="table-responsive ">
                        <div class="tableFixHead financiero">
                          <table class="table table-bordered " >
                            <thead >
                              <tr style="color:#fff; background:rgb(36, 136, 181);">
                                <td rowspan="3"></td>
                                <td  style="vertical-align:middle" rowspan="3" colspan="2">ACCION DE MEDIANO PLAZO ETA</td>
                                <td  style="vertical-align:middle" rowspan="2" colspan="3">PLANIFICACION</td>
                                <td  style="vertical-align:middle" colspan="11" >EN RELACION A LA PROGRAMACION DE RECURSOS</td>
                                <td  style="vertical-align:middle" colspan="11" >EN RELACION A LA PROGRAMACION DE ACCIONES</td>
                                <td style="vertical-align:middle" rowspan="3" >CAUSAS DE VARIACION</td>
                              </tr>
                              <tr style="color:#fff; background:rgb(36, 136, 181);">
                                <td class="text-center" colspan="2" >2016</td>
                                <td class="text-center" colspan="2" >2017</td>
                                <td class="text-center" colspan="2" >2018</td>
                                <td style="vertical-align:middle" rowspan="2" >TOTAL<br/>PRES. PROGRAMADO<br/>(2016-2018)</td>
                                <td style="vertical-align:middle" rowspan="2">TOTAL<br/> PRES. EJECUTADO<br/>(2016-2018)</td>
                                <td style="vertical-align:middle" rowspan="2">% EJEC.</td>
                                <td style="vertical-align:middle" rowspan="2">META AL<br/> 2020</td>
                                <td style="vertical-align:middle" rowspan="2">% EJEC. <br/>AL 2020</td>
                                <td class="text-center" colspan="2">2016</td>
                                <td class="text-center" colspan="2">2017</td>
                                <td class="text-center" colspan="2">2018</td>
                                <td style="vertical-align:middle" rowspan="2" >TOTAL <br/>PROGRAMACION DE ACCIONES<br/>(2016-2018)</td>
                                <td style="vertical-align:middle" rowspan="2">TOTAL<br/> ACCIONES EJECUTADO<br/>(2016-2018)</td>
                                <td style="vertical-align:middle" rowspan="2">% EJEC.</td>
                                <td style="vertical-align:middle" rowspan="2">META <br/>AL 2020</td>
                                <td style="vertical-align:middle" rowspan="2">% EJEC. <br/>AL 2020</td>
                              </tr>
                              <tr style="color:#fff; background:rgb(36, 136, 181);">
                                <td>PTDI/<br/>PGTC</td>
                                <td>PEI</td>
                                <td>POA</td>
                                <td class="text-center">P</td>
                                <td class="text-center">E</td>
                                <td class="text-center">P</td>
                                <td class="text-center" >E</td>
                                <td class="text-center" >P</td>
                                <td class="text-center" >E</td>
                                <td class="text-center">P</td>
                                <td class="text-center">E</td>
                                <td class="text-center">P</td>
                                <td class="text-center" >E</td>
                                <td class="text-center" >P</td>
                                <td class="text-center" >E</td>
                               
                              </tr>
                            </thead>
                            <tbody >
                              <template v-for="(f,key) in financiero" >
                                <template v-if="f.cantidad_objetivos >1">
                                  <tr>
                                    <td>
                                      <p class="btn btn-info btn-sm" @click="toggle(f)"><i :class="[f.ver ? 'fa fa-plus fa-lg' : 'fa fa-arrow-right fa-lg']" ></i></p>
                                    </td>
                                    <td colspan="2" class="text-center"><strong>{{ f.nombre_programa }}</strong></td>
                                    <td></td> 
                                    <td></td>
                                    <td></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_recurso_gestion_2016_recurso']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_recurso_poa_2016']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_recurso_gestion_2017_recurso']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_recurso_poa_2017']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_recurso_gestion_2018_recurso'] ) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_recurso_poa_2018']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_total_recurso_programado'] ) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_total_recurso_poa']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_recurso_porcentaje_ejecutado']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_meta_recurso_2020']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_recurso_porcentaje_ejecutado_meta_2020']) }}</strong></td>

                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_indicador_gestion_2016_indicador']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_indicador_poa_2016']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_indicador_gestion_2017_indicador']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_indicador_poa_2017']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_indicador_gestion_2018_indicador'] ) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_indicador_poa_2018']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_total_indicador_programado'] ) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_total_indicador_poa']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_indicador_porcentaje_ejecutado']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_meta_indicador_2020']) }}</strong></td>
                                    <td class="text-right"><strong>{{ formatPrice(f.totales_programa['total_programa_indicador_porcentaje_ejecutado_meta_2020']) }}</strong></td>
                                    
                                    
                                    
                                  </tr>
                                  <tr v-show="f.ver" v-for="r in f.objetivos_eta">
                                      <td colspan="2"></td>
                                      
                                      <td >{{ r.catalogo_accion_eta}}</td>
                                      <td class="text-center">X</td>
                                      <td class="text-center"></td>
                                      <td class="text-center">X</td>
                                      <td class="text-right">{{ formatPrice(r.recurso_gestion_2016_recurso) }}</td>
                                      <td class="text-right">{{ formatPrice(r.recurso_poa_2016) }}</td>
                                      <td class="text-right">{{ formatPrice(r.recurso_gestion_2017_recurso) }}</td>
                                      <td class="text-right">{{ formatPrice(r.recurso_poa_2017) }}</td>
                                      <td class="text-right">{{ formatPrice(r.recurso_gestion_2018_recurso) }}</td>
                                      <td class="text-right">{{ formatPrice(r.recurso_poa_2018) }}</td>
                                      <td class="text-right">{{ formatPrice(r.total_recurso_programado) }}</td>
                                      <td class="text-right">{{ formatPrice(r.total_recurso_poa) }}</td>
                                      <td class="text-right">{{ formatPrice(r.recurso_porcentaje_ejecutado) }}</td>
                                      <td class="text-right">{{ formatPrice(r.meta_recurso_2020 ) }}</td>
                                      <td class="text-right">{{ formatPrice(r.recurso_porcentaje_ejecutado_meta_2020) }}</td>
                                      <td class="text-right">{{ formatPrice(r.indicador_gestion_2016_indicador) }}</td>
                                      <td class="text-right">{{ formatPrice(r.indicador_poa_2016) }}</td>
                                      <td class="text-right">{{ formatPrice(r.indicador_gestion_2017_indicador) }}</td>
                                      <td class="text-right">{{ formatPrice(r.indicador_poa_2017) }}</td>
                                      <td class="text-right">{{ formatPrice(r.indicador_gestion_2018_indicador) }}</td>
                                      <td class="text-right">{{ formatPrice(r.indicador_poa_2018) }}</td>
                                      <td class="text-right">{{ formatPrice(r.total_indicador_programado) }}</td>
                                      <td class="text-right">{{ formatPrice(r.total_indicador_poa) }}</td>
                                      <td class="text-right">{{ formatPrice(r.indicador_porcentaje_ejecutado) }}</td>
                                      <td class="text-right">{{ formatPrice(r.meta_indicador_2020) }}</td>
                                      <td class="text-right">{{ formatPrice(r.indicador_porcentaje_ejecutado_meta_2020) }}</td>
                                      <td>
                                        <div :class="['form-group',(r.clase).trim()?'has-'+r.clase:'']" style="width:200px">
                                          <label class="form-control-label" for="inputSuccess1">Causas de Variacion</label>
                                          <textarea type="text"  
                                                    id="inputSuccess1" 
                                                    v-model="r.input" 
                                                    :class="['form-control',(r.clase).trim()?'form-control-' + r.clase:'']"
                                                    class="input-sm"
                                                    @keyup="validarComentario(r)"
                                                    rows="5" 
                                                    cols="50"
                                          ></textarea>
                                          <div class="form-control-feedback" v-text="r.mensaje"></div>
                                          <!--small class="form-text text-muted">Example help text that remains unchanged.</small-->
                                        </div>
                                      </td>
                                  </tr>
                                  
                                </template>
                                <template v-else>
                                  <tr v-for="r in f.objetivos_eta">
                                    <td><p class="btn btn-info btn-sm" @click="toggle(f)"><i class='fa fa-minus fa-lg' ></i></p></td>
                                    <td>{{ f.nombre_programa}}</td>
                                    <td >{{ r.catalogo_accion_eta}}</td>
                                    <td class="text-center">X</td>
                                    <td class="text-center"></td>
                                    <td class="text-center">X</td>
                                    <td class="text-right">{{ formatPrice(r.recurso_gestion_2016_recurso) }}</td>
                                    <td class="text-right">{{ formatPrice(r.recurso_poa_2016) }}</td>
                                    <td class="text-right">{{ formatPrice(r.recurso_gestion_2017_recurso) }}</td>
                                    <td class="text-right">{{ formatPrice(r.recurso_poa_2017) }}</td>
                                    <td class="text-right">{{ formatPrice(r.recurso_gestion_2018_recurso) }}</td>
                                    <td class="text-right">{{ formatPrice(r.recurso_poa_2018) }}</td>
                                    <td class="text-right">{{ formatPrice(r.total_recurso_programado) }}</td>
                                    <td class="text-right">{{ formatPrice(r.total_recurso_poa) }}</td>
                                    <td class="text-right">{{ formatPrice(r.recurso_porcentaje_ejecutado) }}</td>
                                    <td class="text-right">{{ formatPrice(r.meta_recurso_2020 ) }}</td>
                                    <td class="text-right">{{ formatPrice(r.recurso_porcentaje_ejecutado_meta_2020) }}</td>
                                    <td class="text-right">{{ formatPrice(r.indicador_gestion_2016_indicador) }}</td>
                                    <td class="text-right">{{ formatPrice(r.indicador_poa_2016) }}</td>
                                    <td class="text-right">{{ formatPrice(r.indicador_gestion_2017_indicador) }}</td>
                                    <td class="text-right">{{ formatPrice(r.indicador_poa_2017) }}</td>
                                    <td class="text-right">{{ formatPrice(r.indicador_gestion_2018_indicador) }}</td>
                                    <td class="text-right">{{ formatPrice(r.indicador_poa_2018) }}</td>
                                    <td class="text-right">{{ formatPrice(r.total_indicador_programado) }}</td>
                                    <td class="text-right">{{ formatPrice(r.total_indicador_poa) }}</td>
                                    <td class="text-right">{{ formatPrice(r.indicador_porcentaje_ejecutado) }}</td>
                                    <td class="text-right">{{ formatPrice(r.meta_indicador_2020) }}</td>
                                    <td class="text-right">{{ formatPrice(r.indicador_porcentaje_ejecutado_meta_2020) }}</td>
                                    <td>
                                      <div :class="['form-group',(r.clase).trim()?'has-'+r.clase:'']" style="width:200px">
                                        <label class="form-control-label" for="inputSuccess1">Causas de Variacion</label>
                                        <textarea type="text"  
                                                  id="inputSuccess1" 
                                                  v-model="r.input" 
                                                  :class="['form-control',(r.clase).trim()?'form-control-' + r.clase:'']"
                                                  class="input-sm"
                                                  @keyup="validarComentario(r)"
                                                  rows="5" 
                                                  cols="50"
                                        ></textarea>
                                        <div class="form-control-feedback" v-text="r.mensaje"></div>
                                        <!--small class="form-text text-muted">Example help text that remains unchanged.</small-->
                                      </div>
                                    </td>
                                  </tr>
                                  
                                  
                                </template>
                                
                              </template>
                            </tbody>
                          </table>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <button v-show="btnReporteFinanciero" @click="reporteFinancieroExcel" type="button" class="btn waves-effect waves-light btn-success"><i class="fa fa-file-excel-o" aria-hidden="true" ></i>Exportar  Excel</button>
                  <button  v-show="btnReporteFinanciero" type="submit" class="btn btn-danger" @click="reporteFinancieroMedioPdf">Exportar Pdf <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
                  <button class="btn btn-info" @click="saveReporteFinanciero">Guardar Reporte</button>
                </div>
                <div class="tab-pane p-20" id="entidadejecutora" role="tabpanel">
                  <div class="col-lg-12">
                    <div class="p-20">
                      <h4>PROYECTOS DE INVERSION</h4>
                      <div class="table-responsive ">
                        <div class="tableFixHead">
                          <table class="table table-bordered table-info scroll-table">
                            <thead>
                              <tr>
                                <td>ACCION ETA</td>
                                <td>PROYECTO INVERSION</td>
                              </tr>  
                            </thead>
                            <tbody class="my-tbody">
                              <tr v-for="(eta,index) in inversion" :key="index">
                                <td>{{ eta.nombre_accion_eta}}</td>
                                <td>
                                  <div class="table-responsive">
                                    <table class="table table-bordered" >
                                      <thead >
                                        <tr style="color:#fff; background:rgb(36, 136, 181);">
                                          <td  style="vertical-align:middle; text-align:center;" rowspan="2" colspan="3">PLANIFICACION</td>
                                          <td  style="vertical-align:middle; text-align:center;" colspan="5" >INSCRITO EN EL VIPFE</td>
                                          <td  style="vertical-align:middle; text-align:center;" colspan="9" >CONCURRENCIA ETA</td>
                                          <td style="vertical-align:middle; text-align:center;" colspan="5" >TOTAL CONCURRENCIA ENTIDADES</td>
                                        </tr>
                                        <tr style="color:#fff; background:rgb(36, 136, 181);">
                                          <td style="vertical-align:middle" rowspan="2" >COD. SISIN</td>
                                          <td style="vertical-align:middle" rowspan="2" >PROYECTO</td>
                                          <td style="vertical-align:middle" rowspan="2" >COSTO TOTAL <br/>PROYECTO</td>
                                          <td style="vertical-align:middle" colspan="2">PERIODO<br/>DE EJECUCION</td>
                                          <td class="text-center" colspan="2">2016</td>
                                          <td class="text-center" colspan="2">2017</td>
                                          <td class="text-center" colspan="2">2018</td>
                                          <td style="vertical-align:middle" colspan="3">TOTALES</td>
                                          <td style="vertical-align:middle" rowspan="2">PROG.</td>
                                          <td style="vertical-align:middle" rowspan="2">EJEC.</td>
                                          <td style="vertical-align:middle" rowspan="2">% EJEC.</td>
                                          <td style="vertical-align:middle" rowspan="2">META <br/>AL 2020</td>
                                          <td style="vertical-align:middle" rowspan="2">% EJEC. <br/>AL 2020</td>
                                        </tr>
                                        <tr style="color:#fff; background:rgb(36, 136, 181);">
                                          <td>PTDI/<br/>PGTC</td>
                                          <td>PEI</td>
                                          <td>POA</td>
                                          <td>DEL</td>
                                          <td>AL</td>
                                          <td style="vertical-align:middle">PROG.</td>
                                          <td style="vertical-align:middle">EJEC.</td>
                                          <td style="vertical-align:middle">PROG.</td>
                                          <td style="vertical-align:middle">EJEC.</td>
                                          <td style="vertical-align:middle">PROG.</td>
                                          <td style="vertical-align:middle">EJEC.</td>
                                          <td style="vertical-align:middle">PROG.</td>
                                          <td style="vertical-align:middle" >EJEC.</td>
                                          <td style="vertical-align:middle" >%EJEC</td>
                                        </tr>
                                      </thead>
                                      <tbody >
                                        <tr v-for="(inv,clave) in eta.proyectosInversion" :key="clave">
                                          <td>X</td>
                                          <td></td>
                                          <td>X</td>
                                          <td>{{ inv.codigo_sisin }}</td>
                                          <td>{{ inv.nombre }}</td>
                                          <td>{{ inv.costo_total_proyecto }}</td>
                                          <td v-if="inv.periodo_ejecucion_del" v-text="formatYear(inv.periodo_ejecucion_del)"></td>
                                          <td v-else></td>
                                          <td v-if="inv.periodo_ejecucion_al" v-text="formatYear(inv.periodo_ejecucion_al)"></td>
                                          <td v-else></td>
                                          <td>{{ inv.programado_2016 }}</td>
                                          <td>{{ inv.ejecutado_2016 }}</td>
                                          <td>{{ inv.programado_2017 }}</td>
                                          <td>{{ inv.ejecutado_2017 }}</td>
                                          <td>{{ inv.programado_2018 }}</td>
                                          <td>{{ inv.ejecutado_2018 }}</td>
                                          <td>{{ inv.total_programado }}</td>
                                          <td>{{ inv.total_ejecutado }}</td>
                                          <td v-if="inv.total_porcentaje_ejecutado" v-text="formatPrice(inv.total_porcentaje_ejecutado)"></td>
                                          <td v-else></td>
                                          <td>{{ inv.concurrencia_entidades_programado }}</td>
                                          <td>{{ inv.concurrencia_entidades_ejecutado }}</td>
                                          <td v-if="inv.concurrencia_entidades_porcentaje_ejecutado" v-text="formatPrice(inv.concurrencia_entidades_porcentaje_ejecutado)"></td>
                                          <td v-else></td>
                                          <td>{{ inv.meta_recurso_2020 }}</td>
                                          <td v-if="inv.concurrencia_entidades_porcentaje_al_2020" v-text="formatPrice(inv.concurrencia_entidades_porcentaje_al_2020)"></td>
                                          <td v-else></td>
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
                    <button  @click="reporteInversionExcel" type="button" class="btn waves-effect waves-light btn-success">Exportar Excel<i class="fa fa-file-excel-o" aria-hidden="true" ></i></button>
                    <button  @click="reporteInversionMedioPdf" type="button" class="btn waves-effect waves-light btn-danger" >Exportar Pdf <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
                  </div>
                </div>
                <div class="tab-pane p-20" id="gestionriesgos" role="tabpanel">
                  <div class="col-lg-12">
                    <div class="p-20">
                      <div class="table-responsive">
                        <div class="tableFixHead">
                          <table class="table table-bordered" >
                            <thead >
                              <tr style="color:#fff; background:rgb(36, 136, 181);">
                                <td  style="vertical-align:middle" rowspan="3">ACCION ETA</td>
                                <td  style="vertical-align:middle" rowspan="2" colspan="3">PLANIFICACION</td>
                                <td  style="vertical-align:middle" colspan="11" >EN RELACION A LA PROGRAMACION DE RECURSOS</td>
                                <td  style="vertical-align:middle" colspan="11" >EN RELACION A LA PROGRAMACION DE ACCIONES</td>
                                <td style="vertical-align:middle" rowspan="3" >CAUSAS DE VARIACION</td>
                              </tr>
                              <tr style="color:#fff; background:rgb(36, 136, 181);">
                                <td style="vertical-align:middle" colspan="2" >2016</td>
                                <td style="vertical-align:middle" colspan="2" >2017</td>
                                <td style="vertical-align:middle" colspan="2" >2018</td>
                                <td style="vertical-align:middle" rowspan="2" >TOTAL<br/>PRES. PROGRAMADO<br/>(2016-2018)</td>
                                <td style="vertical-align:middle" rowspan="2">TOTAL<br/> PRES. EJECUTADO<br/>(2016-2018)</td>
                                <td style="vertical-align:middle" rowspan="2">% EJEC.</td>
                                <td style="vertical-align:middle" rowspan="2">META AL<br/> 2020</td>
                                <td style="vertical-align:middle" rowspan="2">% EJEC. <br/>AL 2020</td>
                                <td style="vertical-align:middle" colspan="2">2016</td>
                                <td style="vertical-align:middle" colspan="2">2017</td>
                                <td style="vertical-align:middle" colspan="2">2018</td>
                                <td style="vertical-align:middle" rowspan="2" >TOTAL <br/>PROGRAMACION DE ACCIONES<br/>(2016-2018)</td>
                                <td style="vertical-align:middle" rowspan="2">TOTAL<br/> ACCIONES EJECUTADO<br/>(2016-2018)</td>
                                <td style="vertical-align:middle" rowspan="2">% EJEC.</td>
                                <td style="vertical-align:middle" rowspan="2">META <br/>AL 2020</td>
                                <td style="vertical-align:middle" rowspan="2">% EJEC. <br/>AL 2020</td>
                              </tr>
                              <tr style="color:#fff; background:rgb(36, 136, 181);">
                                <td>PTDI/<br/>PGTC</td>
                                <td>PEI</td>
                                <td>POA</td>
                                <td class="align-middle">P</td>
                                <td class="align-middle">E</td>
                                <td class="align-middle">P</td>
                                <td class="align-middle" >E</td>
                                <td class="align-middle" >P</td>
                                <td class="align-middle" >E</td>
                                <td class="align-middle">P</td>
                                <td class="align-middle">E</td>
                                <td class="align-middle">P</td>
                                <td class="align-middle" >E</td>
                                <td class="align-middle" >P</td>
                                <td class="align-middle" >E</td>
                               
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="f in riesgos">
                                <td>{{ f.catalogo_accion_eta}}</td>
                                <td class="text-center">X</td>
                                <td class="text-center"></td>
                                <td class="text-center">X</td>
                                <td class="text-center">{{ f.recurso_gestion_2016 }}</td>
                                <td class="text-center">{{ f.recurso_poa_2016 }}</td>
                                <td class="text-center">{{ f.recurso_gestion_2017}}</td>
                                <td class="text-center">{{ f.recurso_poa_2017 }}</td>
                                <td class="text-center">{{ f.recurso_gestion_2018 }}</td>
                                <td class="text-center">{{ f.recurso_poa_2018 }}</td>
                                <td class="text-center">{{ f.total_recurso_programado }}</td>
                                <td class="text-center">{{ f.total_recurso_poa}}</td>
                                <td class="text-center">{{ formatPrice(f.recurso_porcentaje_ejecutado) }}</td>
                                <td class="text-center">{{ f.meta_recurso_2020 }}</td>
                                <td class="text-center">{{ formatPrice(f.recurso_porcentaje_ejecutado_meta_2020) }}</td>
                                <td class="text-center">{{ f.indicador_gestion_2016 }}</td>
                                <td class="text-center">{{ f.indicador_poa_2016 }}</td>
                                <td class="text-center">{{ f.indicador_gestion_2017}}</td>
                                <td class="text-center">{{ f.indicador_poa_2017 }}</td>
                                <td class="text-center">{{ f.indicador_gestion_2018 }}</td>
                                <td class="text-center">{{ f.indicador_poa_2018 }}</td>
                                <td class="text-center">{{ f.total_indicador_programado }}</td>
                                <td class="text-center">{{ f.total_indicador_poa}}</td>
                                <td class="text-center">{{ formatPrice(f.indicador_porcentaje_ejecutado) }}</td>
                                <td class="align-middle">{{ f.meta_indicador_2020 }}</td>
                                <td class="align-middle">{{ formatPrice(f.indicador_porcentaje_ejecutado_meta_2020) }}</td>
                                <td>
                                  <div :class="['form-group',(f.clase).trim()?'has-'+f.clase:'']" style="width:200px">
                                      <label class="form-control-label" for="inputSuccess1">Causas de Variacion</label>
                                      <textarea type="text"  
                                                id="inputSuccess1" 
                                                v-model="f.input" 
                                                :class="['form-control',(f.clase).trim()?'form-control-' + f.clase:'']"
                                                @keyup="validarComentario(f)"
                                                rows="5" 
                                                cols="50"
                                                disabled="disabled"
                                      ></textarea>
                                      <div class="form-control-feedback" v-text="f.mensaje"></div>
                                      <!--small class="form-text text-muted">Example help text that remains unchanged.</small-->
                                    </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <button  @click="reporteRiesgosExcel" type="button" class="btn waves-effect waves-light btn-success">Exportar Excel  <i class="fa fa-file-excel-o" aria-hidden="true" ></i></button>
                    <button  type="button" class="btn btn-danger" @click="reporteRiesgosMedioPdf">Exportar Pdf  <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
                    <!--button class="btn btn-primary" @click="saveReporte">Guardar Reporte</button-->
                  </div>
                </div>
            </div>
          </div>
        </div>  
      </div>
    </div>
    <!--div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;" :class="{'show': modal}">
      <div class="modal-dialog" style="max-width:600px;">
        <div class="modal-content">
          <div class="modal-header">
             <button type="button" class="close"  aria-hidden="true" @click="cerrarModal()">×</button>
             <h4 class="modal-title"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>Agregar Causas de Desviacion</h4>
          </div>
          <div class="modal-body">
            <form action="">
              <div :class="['form-group',(causas_desviacion.clase).trim()?'has-'+causas_desviacion.clase:'']">
                <label class="form-control-label" for="inputSuccess1">Causas de Desviacion</label>
                <input type="text"  id="inputSuccess1" v-model="causas_desviacion.input" 
                    :class="['form-control',(causas_desviacion.clase).trim()?'form-control-' + causas_desviacion.clase:'']"
                        @keyup="escribir(causas_desviacion)"
                >
                <div class="form-control-feedback" v-text="causas_desviacion.mensaje"></div>
                <small class="form-text text-muted">Example help text that remains unchanged.</small>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" @click="cerrarModal()">Cancelar</button>
            <button type="button" class="btn btn-info waves-effect waves-light" @click="validarCausas()">Guardar</button>
          </div>
        </div>
      </div>
      
    </div-->
  </div>
</template>

<script>
import moment from 'moment'
export default {
    data(){
        return{
          recursos:[],
          otros:[],
          totales:{},
          acciones:[],
          financiero:[],
          inversion:[],
          riesgos:[],
          modalEvaRe:0,
          modal:0,
          comentario:{
              input:"",
              mensaje:"",
              clase:""
          },
          btnReporteRecursos:false,
          btnReporteFinanciero:false,
          primer_obj:[],
          resto_obj:[]
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
      formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
      },
      abrirModal(e,r){
         let me = this;
         switch (e) {
           case 1:
             
              //console.log("dentro del modal");
              me.recurso = r;
              me.recurso.monto_pei_gestion =  me.recurso.monto_pei_gestion.split('.').join('');
              me.recurso.monto_poa_gestion =  me.recurso.monto_poa_gestion.split('.').join('');
              //console.log(me.recurso);
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
        window.location = "/planesTerritoriales/index";
      },
      /************************ RECUPERANDO DATOS ******************************************/
      listaRecursos(){
        let me = this;
        axios.get('/api/planesTerritoriales/evaluacionListaRecursos')
        .then(function(response){
          console.log(response);
          me.recursos = response.data.recursos_medio;
          //console.log(me.recursos);
          me.otros = response.data.otros_medio;
          me.totales = response.data.totales;
        })
        .catch(function(error){
          console.log(error);
        })
      },
      listaAcciones(){
        let me = this;
        axios.get('/api/planesTerritoriales/evaluacionListaAcciones')
        .then(function(response){
          console.log(response);
          me.acciones = response.data.objEta;
        })
        .catch(function(error){
          console.log(error);
        })
      },
      listaFinanciero(){
        let me = this;
        axios.get('/api/planesTerritoriales/evaluacionListaFinanciero')
        .then(function(response){
          console.log(response);
          me.financiero = response.data.financiero;
          me.primer_obj = response.data.primer_obj;
          me.resto_obj  = response.data.resto_obj;
          //console.log(me.financiero);
        })
        .catch(function(error){
          console.log(error);
        })
      },
      listaInversion(){
        let me = this;
        axios.get('/api/planesTerritoriales/evaluacionListaInversion')
        .then(function(response){
          console.log(response);
          me.inversion  = response.data.objetivoInversion;
          //console.log(me.inversion);
        })
        .catch(function(error){
          console.log(error);
        })
      },
      listaRiesgos(){
        let me = this;

        axios.get('/api/planesTerritoriales/evaluacionListaRiesgos')
        .then(function(response){
          console.log(response);
          //riesgos
          me.riesgos = response.data.riesgos;
          //console.log(me.riesgos);
        })
        .catch(function(error){
          console.log(error);
        })
      },
      formatYear(value){
        return moment(String(value)).format("MM/DD/YYYY");
      },
      ReporteExcel(){
        //alert("este es un mensaje");
        //location.href = 'http://www.google.com';
        location.href = '/api/planesTerritoriales/reporteRecursos';
        //location.href=
        //reporteRecursos
      },
      abrirModalEvaRe(e){
        //alert("hola desde abrirModalEvaRe");
        let me = this;
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
      cerrarModal(){
        let me = this;
        this.modal = 0;
      },
      validarCausas(){
        alert("Validar Causas");
      },
      validarComentario:function(data){
        //var comentario = $('[name="textarea_'+ item.recurso_id+'"]').val();
        //fconsole.log(data.input);
        
        /*if(!((data.input).trim())){
          data.mensaje = "El campo se encuentra en blanco";
          data.clase = 'warning';
        }else if(data.input.search(/^[a-zA-Z\s]*$/)){
          data.mensaje = "El campo debe contener solo letras";
          data.clase = 'danger';
        }else{
          data.mensaje = "Se encuentra bien!";
          data.clase = "success";
        }*/
        if(!((data.input).trim())){
          data.mensaje = "El campo se encuentra en blanco";
          data.clase = 'warning';
        }else{
          data.mensaje = "Se encuentra bien!";
          data.clase = "success";
        }
        
      },
      saveReporte(){
        //alert("Save reporte");
        let me = this;
          axios({
             method: 'post',
             url: '/api/planesTerritoriales/saveReporteRecursos',
             data: {
              reporte_recursos: me.recursos,
              reporte_otros:me.otros
               
             }
           }).then(function (response) {
              /*me.listaTipoRecursos();
              me.cerrarModal();*/
              swal("Guardado!", "Se ha guardado correctamente.", "success");
              me.listaRecursos();
              me.btnReporteRecursos=true;

              //console.log(response);
           }).catch(function (error) {
             console.log(error);
           });

      },
      reporteAccionesExcel(){
        //alert("hola desde reporteAccionesexcel");
        location.href = '/api/planesTerritoriales/reporteAccionesExcel';
      },
      saveReporteFinanciero(){
        //alert("hola desde saveReporteFinanciero");
        
        let me = this;
          axios({
             method: 'post',
             url: '/api/planesTerritoriales/saveReporteFinanciero',
             data: {
              reporte_financiero: me.financiero
               
             }
          }).then(function (response) {
              
              swal("Guardado!", "Se ha guardado correctamente.", "success");
              me.listaFinanciero();
              me.btnReporteFinanciero = true;

              //console.log(response);
           }).catch(function (error) {
             console.log(error);
           });
      },
      reporteFinancieroExcel(){
        //alert("hola desde ReporteFinancieroExcel");
        location.href = '/api/planesTerritoriales/reporteFinancieroExcel';
      },
      reporteRiesgosExcel(){
        //alert("hola desde ReporteRiesgosExcel");
        location.href = '/api/planesTerritoriales/reporteRiesgosExcel';
      },
      reporteInversionExcel(){
        //alert("hola desde ReporteInversionExcel");
        location.href = '/api/planesTerritoriales/reporteInversionExcel'; 
      },
      reporteRecursosMedioPdf(){
        location.href = '/api/planesTerritoriales/reporteRecursosMedioPdf'; 
      },
      reporteAccionesMedioPdf(){
       location.href = '/api/planesTerritoriales/reporteAccionesMedioPdf';  
      },
      reporteFinancieroMedioPdf(){
        location.href = '/api/planesTerritoriales/reporteFinancieroMedioPdf';  
      },
      reporteInversionMedioPdf(){
        location.href = '/api/planesTerritoriales/reporteInversionMedioPdf';  
      },
      reporteRiesgosMedioPdf(){
        location.href = '/api/planesTerritoriales/reporteRiesgosMedioPdf';  
      },
      toggle(folder){
        console.log("hola desde toggle");
        /*
        console.log(document.getElementById(idname).style.display);
        if(document.getElementById(idname).style.display == "none"){
          document.getElementById(idname).style.display = "inline-block";
        }else{
          document.getElementById(idname).style.display = "none";
        }*/
        folder.ver = !folder.ver;
        //console.log(folder.ver );
      },

    },
    mounted() {

        //this.datosUsuario();
        this.listaRecursos();
        this.listaAcciones();
        this.listaFinanciero();
        this.listaInversion();
        this.listaRiesgos();


        $(".panel-left").resizable({
          handleSelector: ".splitter",
          resizeHeight: false
        });
    }
}


</script>
<style media="screen">
:root{
    --width-inputs:80%;
    --bg-color-main:#35495E;
    --color-ok:#418883;
    --color-error:#EF5350;
    --font-main:sans-serif;
  }
  

  .ContactForm[required]:valid{
    border:thin solid var(--color-ok);
    outline: thin solid var(--color-ok);
  }
  .ContactForm[required]:invalid{
    border:thin solid var(--color-error);
    outline: thin solid var(--color-errot);
  }  
  .ContactForm[required]:focus{
    border:thin solid var(--color-main);
    outline: thin solid var(--color-main);
  }


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
.bg-success {
    background-color: #00c292!important;
}
.progress-bar {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
     color:#000000;
    text-align: center;
    white-space: nowrap;
    /*background-color: #ff0a0aaf  !important;*/
    -webkit-transition: width 0.6s ease;
    -o-transition: width 0.6s ease;
    transition: width 0.6s ease;
    height:30px;
    font-size: 10px
}
.progress {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    height: auto;
    overflow: hidden;
    font-size: 0.65625rem;
    background-color: rgb(222, 230, 221) !important;
    border-radius: 0.25rem;
    /*background-color:#3dee10de*/
   
}
input{
  font-size:12px !important
}
textarea {
  width: 100%;
  height: 100%;
  resize: none;
  -webkit-box-sizing: border-box; /* <=iOS4, <= Android  2.3 */
      -moz-box-sizing: border-box; /* FF1+ */
           box-sizing: border-box; /* Chrome, IE8, Opera, Safari 5.1*/
}


.tableFixHead          { overflow-y: auto; height: 400px; }
.tableFixHead thead th { position: sticky; top: 0; }





</style>
