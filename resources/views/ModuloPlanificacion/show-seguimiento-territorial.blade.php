@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.dark.css" type="text/css" />
<link rel="stylesheet" href="/plugins/bower_components/select2/dist/css/select2.min.css" type="text/css"/>

@endsection

@section('title-topbar')

@endsection

@section('content')

<section id="content_wrapper">
   <th><h2>Sistema de Seguimiento Territorial</h2></th>
  <section id="content" class="table-layout animated fadeIn" style="min-height: 3500px;">
                  <div class="tray tray-center p40 va-t posr">
      <div class="row">

          <div class="col-md-12">
              <div class="panel panel-visible" >
                <div class="panel-heading bg-dark text-center">
                     <span class="panel-title"> Planificacion</span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="estructura" class="col-md-12" >
                          <div class="panel panel-visible">
                              <div id='jqxWidget'>
                              <button id="agregarseguimiento"  class="btn btn-sm btn-success dark m5 br4" name="agregarseguimiento"><i class='glyphicon glyphicon-plus'>Agregar</i></button>
                              <input class="btn btn-sm btn-info dark m5 br4" style="margin-top: 10px;" value="Limpiar Filtro" id="clearfilteringbutton" type="button" /><input class="btn btn-sm btn-warning dark m5 br4" style="margin-top: 10px;" value="Exportar" id="export" type="button" />
                              <p>
                                <div id="gridseguimiento" ></div>
                              </p>
                              </div>
                            </div>
                                                     
                      </div>
                    </div>
                </div>
                
                     
                     
                     
                
              </div>
          </div>
      </div>
  </div>
</section>
  </section>
 <!---------------cuerpo del modulo--------------------->
<!--table>
  <tr>    
      <th><h2>Sistema de Seguimiento Territorial</h2></th>
  </tr>        
  <tr>
    <tr>
      <td> </td>

    </tr>
    <td>
      <div id='contenedor' style="width: 100%" >
        
        <div style="margin-top: 30px;">
            <div id="cellbegineditevent"></div>
            <div style="margin-top: 10px;" id="cellendeditevent"></div>
        </div>       
      </div>
    </td>
  </tr>
</table-->
<!---------------modal Agregar--------------------->
<div id="modal-agregar-seguimiento"  class="darck-popup-block popup-basic admin-form mfp-with-anim mfp-hide popup-lg " >
  <div class="panel">
    <div style="background: #2a2a2c" class="panel-heading">
      <span  class="panel-title"><i style="color: white" class="glyphicon glyphicon-plus"></i>
      <font style="font-family: sans-serif;color: white">Formulario de Seguimiento</font>
      </span>
    </div>           
    
      {{ csrf_field() }}
      <input type="hidden" name="mod_id" id="mod_id" value=""/>
        
        <div class="panel-body mnw700 of-a">
          <div class="row">
            <div class="col-md-12 ">
              <div class="panel-body p20 pb10">
                <div class="tab-content pn br-n">
                  <section class="wizard-section">
                    <div class="section">
                      <div class="panel">
                        <div class="panel-body pn of-h">
                            
                          <table>
                            <tr>
                              <td colspan="2">

                                <p>
                                  <select id="etaseguimiento" class="form-control"><option value="0">Seleccione el ETA</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="tipoetaseguimiento" class="form-control"><option value="0">Seleccione el Tipo de ETA</option>
                                  </select>
                                </p>
                                <p>
                                  <table>
                                  <tr>
                                    <td><select id="depseguimiento"  class="form-control"><option value="0">Seleccione el Departamento</option>
                                  </select></td>
                                    <td><select id="provseguimiento"  name="provseguimiento" class="form-control"><option value="0">Seleccione la Provincia</option>
                                  </select></td>
                                    <td><select id="munseguimiento" class="form-control"><option value="0">Seleccione el Município</option>
                                  </select></td>
                                  </tr>
                                </table>
                                </p>  
                                <p>
                                  <select id="gasseguimiento"class="form-control input-lg"><option value="0">Seleccione la Programática de Gasto</option></select>
                                </p>
                                <p>
                                  <select id="tipseguimiento"class="form-control"><option value="0">Seleccione el Tipo</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="serseguimiento"class="form-control"><option value="0">Seleccione el Servicio</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="acci"class="form-control input-lg"><option value="0">Seleccione la Accion ETA</option>
                                  </select>
                                </p>
                                <p>
                                  <table border="2" width="100%">                                  
                                  <tr>
                                    <td style="background: #2a2a2c">
                                      <div class="form-group">
                                          <font color="white"><center>Descripción</center></font>                    
                                          <p> <textarea name="descripcion_accion_etaseguimiento" id="descripcion_accion_etaseguimiento" rows="2" cols="5" placeholder="descripción accion eta" style="width: 100%"></textarea></p>                   
                                      </div>      
                                    </td>
                                  </tr>
                                </table>
                                </p>
                                <p>
                                  <select id="pilar" disabled><option value="0">P</option>
                                  </select>
                                  <select id="metaseguimiento" disabled><option value="0">M</option>
                                  </select>
                                  <select id="resultado" disabled><option value="0">R</option>
                                  </select>
                                  <select id="accion" disabled><option value="0">A</option>
                                  </select>
                                  <select class="form-control input-lg" id="descaccion" disabled><option value="0">las acciones</option></select>
                                </p>
                              </td>
                            </tr>

                            <tr>
                              <td colspan="2">
                                <table border="2" width="100%">                                  
                                  <tr>
                                    <td style="background: #2a2a2c">
                                      <div class="form-group">
                                          <font color="white"><center>Indicador Procesos</center></font>                    
                                          <p> <textarea name="ind_proceso" id="ind_proceso" rows="5" cols="40" placeholder="Indicador Procesos" style="width: 100%"></textarea></p>                   
                                      </div>      
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>                              
                            </tr>
                            <tr>

                              <td>
                                <table border="3">                                  
                                  <tr >
                                    <td  colspan="2" style="background: #2a2a2c;"><font color="white"><center>Presupuesto</center></font></td></tr>
                                  <tr >
                                    <td style="background: #2a2a2c;"><font color="white">Presupuesto 2016-2020</font></td>
                                    <td><input type="number" name="txtpresu" id="txtpresu" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="presupuesto" onchange="sumarPresupu()"value="0.0" ></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2016</font></td>
                                    <td><input type="number" name="p2016" id="p2016" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="2016" onchange="sumarPresupu()" value="0.0" ></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2017</font></td>
                                    <td><input type="number" name="p2017" id="p2017" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="2017" onchange="sumarPresupu()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2018</font></td>
                                    <td><input type="number" name="p2018" id="p2018" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="2018" onchange="sumarPresupu()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2019</font></td>
                                    <td><input type="number" name="p2019" id="p2019" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="2019" onchange="sumarPresupu()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2020</font></td>
                                    <td><input type="number" name="p2020" id="p2020" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="2020" onchange="sumarPresupu()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">Resto</font></td>
                                    <td><input type="text" disabled placeholder="Total Presupuesto" value="0.0" id="totalp" name="totalp"></td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td>                              
                              <!--aqui se encuentra todo lo que se-->                
                                <div class="form-group">                                  
                  <input type="text" class="form-control" name ="txtetaseguimiento" id="txtetaseguimiento" placeholder="eta" required value="" style="display: none;" >
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name ="txttipoetaseguimiento" id="txttipoetaseguimiento" placeholder="eta" required value="" style="display: none;" >
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name ="txtdepseguimiento" id="txtdepseguimiento" placeholder="departamento" required value="" style="display:none ;" >
              </div>

              <div class="form-group">
              <input type="text" class="form-control" name="txtprovseguimiento" id="txtprovseguimiento" placeholder="provincia" required value="" style="display: none;">
              </div>

              <div class="form-group">
                <input type="text" class="form-control" name="txtmunseguimiento" id="txtmunseguimiento" placeholder="municipio" required value=""style="display: none;">
              </div>

              <div class="form-group">
                <input type="text"class="form-control" name="txtgasseguimiento" id="txtgasseguimiento" placeholder="programatica" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text"class="form-control" name="txtnomgasseguimiento" id="txtnomgasseguimiento" placeholder="nombre programatica"style="display:none ;" >
              </div>              
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtacci" id="txtacci" placeholder="accion" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtnomacci" id="txtnomacci" placeholder="descripcion accion" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txttiposeguimiento" id="txttiposeguimiento" placeholder="descripcion tipo" value="0"style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtservicioseguimiento" id="txtservicioseguimiento" placeholder="descripcion servicio" value="0"style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtpilar" id="txtpilar" placeholder="pilar" value=""style="display:none ;">
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtmetasseguimiento" id="txtmetasseguimiento" placeholder="meta" value=""style="display:none ;">
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtresul" id="txtresul" placeholder="resultados" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtaccion" id="txtaccion" placeholder="acciones" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="descripdes" id="descripdes" placeholder="pdes" value="" style="display:none ;">
              </div>

              <a class="btn btn-primary " href="#" role="button" id="verificaragregar" name="verificaragregar" style="display: inline;" onclick="verificaragregar()">Verificar</a>

              <button  class="btn btn-primary" id="guardar" name="guardar" style="display:none ;" >Agregar</button>
              <button type="button" class="btn btn-success" id="cerraragregar" name="cerraragregar">Atrás</button>
                              </td>
                            </tr>
                          </table> 
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>
        
    
  </div>  
</div>
<!---------------modal Editar--------------------->
<div id="modal-editar-seguimiento"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide popup-lg " >
  <div class="panel">
    <div class="panel-heading">
      <span class="panel-title"><i class="fa fa-pencil"></i>
      <font style="font-family: sans-serif;color: black">Formulario de Actualización</font>
      </span>
    </div>            <!-- end .panel-heading section -->
    
      {{ csrf_field() }}
      <input type="hidden" name="mod_id" id="mod_id" value=""/>
        <!--div id="titulo"></div> 
        <div id="titulo1"></div--> 
        <div class="panel-body mnw700 of-a">
          <div class="row">
            <div class="col-md-12 ">
              <div class="panel-body p20 pb10">
                <div class="tab-content pn br-n">
                  <section class="wizard-section">
                    <div class="section">
                      <div class="panel">
                        <div class="panel-body pn of-h">
                            
                          <table>
                            <tr>
                              <td colspan="2">
                                <p>
                                  <select id="etaseguimientoedit" class="form-control"><option value="0">Seleccione el ETA</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="tipoetaseguimientoedit" class="form-control"><option value="0">Seleccione el Tipo de ETA</option>
                                  </select>
                                </p>
                                <p>
                                  <table>
                                  <tr>
                                    <td><select id="depseguimientoedit" disabled="true" class="form-control"><option value="0">Seleccione el Departamento</option>
                                  </select></td>
                                    <td><select id="provseguimientoedit" disabled="true" name="provseguimientoedit" class="form-control"><option value="0">Seleccione la Provincia</option>
                                  </select></td>
                                    <td><select id="munseguimientoedit" disabled="true" class="form-control"><option value="0">Seleccione el Município</option>
                                  </select></td>
                                  </tr>
                                </table>
                                </p> 
                                <p>
                                  <select id="gasseguimientoedit"class="form-control input-lg"><option value="0">Seleccione la Programática de Gasto</option></select>
                                </p>
                                <p>
                                  <select id="tipseguimientoedit"class="form-control"><option value="0">Seleccione el Tipo</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="serseguimientoedit"class="form-control"><option value="0">Seleccione el Servicio</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="acciseguimientoedit"class="form-control input-lg"><option value="0">Seleccione la Accion ETA</option>
                                  </select>
                                </p>
                                <div class="form-group">
  <p> <textarea name="descripcion_accion_etaseguimiento_edit" id="descripcion_accion_etaseguimiento_edit" rows="2" cols="5" placeholder="descripción accion eta" style="width: 50%"></textarea></p>    
</div>
                                <p>
                                  <select id="pilaredit" disabled><option value="0">P</option>
                                  </select>
                                  <select id="metaseguimientoedit" disabled><option value="0">M</option>
                                  </select>
                                  <select id="resultadoedit" disabled><option value="0">R</option>
                                  </select>
                                  <select id="accionedit" disabled><option value="0">A</option>
                                  </select>
                                  <select class="form-control input-lg" id="descaccionedit" disabled><option value="0">las acciones</option></select>
                                </p>
                              </td>
                            </tr>

                            <tr>
                              <td colspan="2">
                                <table border="2" width="100%">
                                  
                    <tr>
                      <td style="background: #2a2a2c">
                        <div class="form-group">
                            <font color="white"><center>Linea Base</center></font>                    
                            <p> <textarea name="linea_baseedit" id="linea_baseedit" rows="10" cols="40" placeholder="Linea Base" style="width: 100%"></textarea></p>                   
                        </div>      
                      </td>
                      <td style="background: #2a2a2c">
                        <div class="form-group"><font color="white"><center>
                         Indicador de Proceso:</center></font>                    
                          <p> <textarea name="ind_procesoedit" id="ind_procesoedit" rows="10" cols="40" placeholder="Indicador de Proceso" style="width: 100%"></textarea></p>                   
                        </div>                        
                      </td>
                    </tr>
                  </table>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <tr>
                                    <td colspan="2">
                                      <font style="font-family: sans-serif;color: white">Programación Anualizada del Indicador de Proceso
                                     </font>
                                     <p>Tipo de Unidad:
                                      <input type="text" name="tipocantidadedit" id="tipocantidadedit" maxlength="5" >
                                     </p>
                                    </td>
                                  </tr>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <table border="3">    
                                   <tr >
                                    <td  colspan="2" style="background: #2a2a2c;"><font color="white"><center>Unidad</center> </font></td></tr>
                                  <tr >                           
                                  <tr>
                                    <td  style="background: #2a2a2c;"><font color="white">Cantidad de Unidad</font></td>
                                    <td><input type="text" name="cantidadedit" id="cantidadedit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="cantidad" onchange="sumaredit()"value="0"/></td>
                                    
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2016</font></td>
                                    <td><input type="number" name="2016edit" id="2016edit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="2016" onchange="sumaredit()"value="0" ></td>
                                    
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2017</font></td>
                                    <td><input type="number" name="2017edit" id="2017edit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="2017" onchange="sumaredit()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2018</font></td>
                                    <td><input type="number" name="2018edit" id="2018edit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="2018" onchange="sumaredit()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2019</font></td>
                                    <td><input type="number" name="2019edit" id="2019edit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="2019" onchange="sumaredit()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2020</font></td>
                                    <td><input type="number" name="2020edit" id="2020edit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="2020" onchange="sumaredit()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">Resto</font></td>
                                    <td><input type="text" value="0" disabled placeholder="total" id="totaledit"></td>
                                    
                                  </tr>
                                </table>
                              </td>
                              <td>
                                <table border="3">                                  
                                  <tr >
                                    <td  colspan="2" style="background: #2a2a2c;"><font color="white"><center>Presupuesto</center></font></td></tr>
                                  <tr >
                                    <td style="background: #2a2a2c;"><font color="white">Presupuesto 2016-2020</font></td>
                                    <td><input type="number" name="txtpresuedit" id="txtpresuedit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2016" onchange="sumarPresupuedit()"value="0.0" ></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2016</font></td>
                                    <td><input type="number" name="p2016edit" id="p2016edit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2016" onchange="sumarPresupuedit()" value="0.0" ></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2017</font></td>
                                    <td><input type="number" name="p2017edit" id="p2017edit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2017" onchange="sumarPresupuedit()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2018</font></td>
                                    <td><input type="number" name="p2018edit" id="p2018edit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2018" onchange="sumarPresupuedit()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2019</font></td>
                                    <td><input type="number" name="p2019edit" id="p2019edit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2019" onchange="sumarPresupuedit()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">2020</font></td>
                                    <td><input type="number" name="p2020edit" id="p2020edit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2020" onchange="sumarPresupuedit()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #2a2a2c;">
                                    <td><font color="white">Resto</font></td>
                                    <td><input type="text" disabled placeholder="Total Presupuesto" value="0.0" id="totalpedit" name="totalpedit"></td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                              <div class="form-group">
                  <input type="text" class="form-control" name ="idcorreedit" id="idcorreedit" placeholder="id" required value="" style="display: ;" >
              </div>
                                <div class="form-group">
                  <input type="text" class="form-control" name ="txtetaseguimientoedit" id="txtetaseguimientoedit" placeholder="eta" required value="" style="display: ;" >
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name ="txttipoetaseguimientoedit" id="txttipoetaseguimientoedit" placeholder="eta" required value="" style="display: ;" >
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name ="txtdepseguimientoedit" id="txtdepseguimientoedit" placeholder="departamento" required value="" style="display: ;" >
              </div>
              <div class="form-group">
                <!--label for="prov">provincia</label-->
              <input type="text" class="form-control" name="txtprovseguimientoedit" id="txtprovseguimientoedit" placeholder="provincia" required value="" style="display: ;">
              </div>

              <div class="form-group">
                <!--label for="mun">municipio</label-->
                <input type="text" class="form-control" name="txtmunseguimientoedit" id="txtmunseguimientoedit" placeholder="municipio" required value=""style="display: ;">
              </div>

              <div class="form-group">
                <!--label for="prog">programatica</label-->
                <input type="text"class="form-control" name="txtgasseguimientoedit" id="txtgasseguimientoedit" placeholder="programatica" value=""style="display: ;">
              </div>
              <div class="form-group">
                <!--label for="nom_prog">detalle programatica</label-->
                <input type="text"class="form-control" name="txtnomgasseguimientoedit" id="txtnomgasseguimientoedit" placeholder="nombre programatica"style="display: ;" >
              </div>              
              <div class="form-group">
                <!--label for="acc">accion</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtacciseguimientoedit" id="txtacciseguimientoedit" placeholder="accion" value=""style="display: ;">
              </div>
              <div class="form-group">
                <!--label for="descrip_acc">descripcion accion</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtnomacciseguimientoedit" id="txtnomacciseguimientoedit" placeholder="descripcion accion" value=""style="display: ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txttiposeguimientoedit" id="txttiposeguimientoedit" placeholder="descripcion tipo" value="0"style="display: ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtservicioseguimientoedit" id="txtservicioseguimientoedit" placeholder="descripcion servicio" value="0"style="display: ;">
              </div>
              <div class="form-group">
                <!--label for="idpilar"> pilar</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtpilaredit" id="txtpilaredit" placeholder="pilar" value=""style="display: ;">
              </div>
              <div class="form-group">
                  <!--label for="metas">pdes</label-->
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtmetasseguimientoedit" id="txtmetasseguimientoedit" placeholder="meta" value=""style="display: ;">
              </div>
              <div class="form-group">
                  <!--label for="resultados">pdes</label-->
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtresuledit" id="txtresuledit" placeholder="resultados" value=""style="display: ;">
              </div>
              <div class="form-group">
                <!--label for="acciones">pdes</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtaccionedit" id="txtaccionedit" placeholder="acciones" value=""style="display: ;">
              </div>
              <div class="form-group">
                <!--label for="acciones">pdes</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="descripaccionedit" id="descripaccionedit" placeholder="pdes" value="" style="display: ;">
              </div>

              <a class="btn btn-primary " href="#" role="button" id="verificaredit" name="verificaredit" style="display: inline;" onclick="verificaredit()">Verificar</a>

              <button  class="btn btn-primary" id="actualizaredit" name="actualizaredit"  style="display: none;" >Modificar</button>
              <button  class="btn btn-success" id="cerraredit" name="cerraredit"  >Cerrar</button>
              
                              </td>
                            </tr>
                          </table> 
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>
            
  </div>  
</div>


@endsection

@push('script-head')


    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.edit.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.selection.js"></script> 
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.aggregates.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxinput.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.pager.js"></script> 
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.grouping.js"></script> 
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxdata.export.js"></script> 
    <script type="text/javascript" src="/jqwidgets5.5.0/jqwidgets/jqxgrid.export.js"></script> 
<script type="text/javascript">
$(function()
{
  $("#agregarseguimiento").click(function()
    { 
       //location.href ="/moduloplanificacion/AgregarPlanificacionTerritorial";
       $.magnificPopup.open(
              {
               removalDelay: 500,                     
               focus: '#nombreinput',
               items: 
                {
                  src: "#modal-agregar-seguimiento"
                },                
               callbacks: 
                {
                 beforeOpen: function(e) 
                  {
                   var Animation = "mfp-zoomOut";
                   this.st.mainClass = Animation;
                  }
                },
               midClick: true 
              });

    });
  $("#cerraragregar").click(function()
    { 
      location.reload();

    });
  $("#cerraredit").click(function()
    { 
      location.reload();

    });
});
</script>
 <script>
  
  
function sumar(){
  tot = parseInt(document.getElementById('cantidad').value);
    a = parseInt(document.getElementById('2016').value);
    b = parseInt(document.getElementById('2017').value);
    c = parseInt(document.getElementById('2018').value);
    d = parseInt(document.getElementById('2019').value);
    e = parseInt(document.getElementById('2020').value);
    tsum=a+b+c+d+e;
    document.getElementById('total').value = tot-tsum;

    
}
function sumarPresupu(){
  totpre = parseFloat(document.getElementById('txtpresu').value);
    pa = parseFloat(document.getElementById('p2016').value);
    pb = parseFloat(document.getElementById('p2017').value);
    pc = parseFloat(document.getElementById('p2018').value);
    pd = parseFloat(document.getElementById('p2019').value);
    pe = parseFloat(document.getElementById('p2020').value);
    tsumpre=pa+pb+pc+pd+pe;
    document.getElementById('totalp').value = totpre-tsumpre;

    
}

</script> 
 <script type="text/javascript">
    $(function(){

      $("#guardar").click(function(){  
        
        objeto = {};
        objeto.id_eta = $("#txtetaseguimiento").val();
        objeto.id_tipo_eta = $("#txttipoetaseguimiento").val();       
        objeto.id_departamento = $("#txtdepseguimiento").val();
        objeto.id_provincia = $("#txtprovseguimiento").val();
        objeto.id_municipio = $("#txtmunseguimiento").val();
        objeto.pilar = $("#txtpilar").val();
        objeto.meta = $("#txtmetasseguimiento").val();
        objeto.resultado = $("#txtresul").val();
        objeto.accion = $("#txtaccion").val();        
        objeto.descripcion_pdes = $("#descripdes").val();
        objeto.id_programa = $("#txtgasseguimiento").val();
        objeto.descripcion_programa = $("#txtnomgasseguimiento").val();        
        objeto.id_accion_eta = $("#txtacci").val();
        objeto.descripcion_accion_eta = $("#txtnomacci").val();
        objeto.indicador_procesos = $("#ind_proceso").val();
        objeto.descripcion_accion_eta_prog = $("#descripcion_accion_etaseguimiento").val();
         objeto.cantidad_presupuesto = $("#txtpresu").val();
        objeto.presupuesto2016 = $("#p2016").val();
        objeto.presupuesto2017 = $("#p2017").val();
        objeto.presupuesto2018 = $("#p2018").val();
        objeto.presupuesto2019 = $("#p2019").val();
        objeto.presupuesto2020 = $("#p2020").val();
        objeto.id_clasificador = $("#txttiposeguimiento").val();
        objeto.id_servicio = $("#txtservicioseguimiento").val();        
        objeto._token = $('input[name=_token]').val()
        console.log(objeto);
        //---------------------aqui esta el try de la insercion
        var message;
    //message = document.getElementById("p01");
    //message.innerHTML = "";
    
    try { 
        if (objeto) {
         $.post("insertarseguimiento", objeto, function(respuesta){
          alert('informacion guardada');
          location.reload();
          location.href ="/moduloplanificacion/showSeguimientoTerritorial";
        }); 

        }
         else{
          alert('informacion no guardada');
         }
    }
    catch(err) {
        message.innerHTML = "Input is " + err;
    }
//---------------------aqui esta el try de la insercion
        

      });


      //--------------cargar eta
      $.get("listarEtas", function(respuesta){
        var etas = respuesta.etas;
        for(var i=0; i<etas.length; i++)
        {
          var eta = etas[i];
          var opcion = "<option value=" + eta.id_eta + ">" + eta.descripcion_eta + "</option>";
          $("#etaseguimiento").append(opcion);
        }
        console.log(etas);
      });
//--------------cargar departamentos
      $.get("listarDepartamentos", function(respuesta){
        var departamentos = respuesta.departamentos;
        for(var i=0; i<departamentos.length; i++)
        {
          var departamento = departamentos[i];
          var opcion = "<option value=" + departamento.id_departamento + ">" + departamento.descripcion_departamento + "</option>";
          $("#depseguimiento").append(opcion);
        }
        console.log(departamentos);
      });
      //--------------cuando cambia tipo eta
      $("#tipoetaseguimiento").change(function(){
        idtipeta=$("#tipoetaseguimiento").val();
        $("#txttipoetaseguimiento").val(idtipeta);
        idgasto = $("#gasseguimiento").val();
        idtipo = $("#tipseguimiento").val();
        idser = $("#serseguimiento").val();
        $("#txtservicioseguimiento").val(idser);
        if (idtipeta==0) {
          
          
          $("#gasseguimiento").val('0');
          $("#tipseguimiento").html('');
          $("#serseguimiento").html('');
          $("#acci").html('');
          $("#pilar").html('');
          $("#metaseguimiento").html('');
          $("#resultado").html('');
          $("#accion").html('');
        }else
        {
          $.get("TipoEtas/" +idtipeta, function(respuesta){
                  var etas = respuesta.etas;
                  
                  for(var i=0; i<etas.length; i++)
                  {
                    var eta = etas[i];              
                    
                    $("#depseguimiento").val(eta.id_departamento);
                    $("#depseguimiento").trigger( "change");
                    setTimeout(function(){
                     $("#provseguimiento").val(eta.id_provincia);
                     $("#provseguimiento").trigger( "change");
                    }, 1100);
                    setTimeout(function(){
                     $("#munseguimiento").val(eta.id_municipio);
                     $("#munseguimiento").trigger( "change");
                    }, 1900);
                  }
                  
                }); 
        }
        
      });
      //--------------
//--------------cuando cambia el departamento
      $("#depseguimiento").change(function(){
        iddepar = $("#depseguimiento").val();
        $("#txtdepseguimiento").val(iddepar);
        if (iddepar==0) {
          $("#provseguimiento").html('<option>Seleccione la Provincia</option>');
          $("#munseguimiento").html('<option>Seleccione la Município</option>');
          
        }else
        {
           $.get("listarProvincias/" + iddepar, function(respuesta){
              var provincias = respuesta.provincias;
              $("#provseguimiento").html('');

                var opcion0 = "<option value=0>Seleccione la Provincia</option>";
                $("#provseguimiento").append(opcion0);
              for(var i=0; i<provincias.length; i++)
              {
                var provincia = provincias[i];
                var opcion = "<option value=" + provincia.id_provincia + ">" + provincia.descripcion_provincia + "</option>";
                $("#provseguimiento").append(opcion);
              }
          }); 
        }
      });
  //--------------cuando cambia la provincias
      $("#provseguimiento").change(function(){
        iddepar = $("#depseguimiento").val();
        idprov = $("#provseguimiento").val();
        $("#txtprovseguimiento").val(idprov);
        if (idprov==0) {
          $("#munseguimiento").html('<option>Seleccione la Município</option>');
        }else
        {
            $.get("listarMunicipios/" + iddepar+"/"+idprov, function(respuesta){
              var municipios = respuesta.municipios;
              $("#munseguimiento").html('');
              var opcion0 = "<option value=0>Seleccione el Municipio</option>";
              $("#munseguimiento").append(opcion0);
              for(var i=0; i<municipios.length; i++)
              {
                var municipio = municipios[i];              
                var opcion = "<option value=" + municipio.id_municipio + ">" + municipio.descripcion_municipio + "</option>";           
                $("#munseguimiento").append(opcion);
                
              }
            });
        }        
      });
      //--------------cuando cambia la municipios
      $("#munseguimiento").change(function(){
        
        idmun = $("#munseguimiento").val();
        $("#txtmunseguimiento").val(idmun);
               
      });
      //--------------cuando cambia la eta
      $("#etaseguimiento").change(function(){
        ideta = $("#etaseguimiento").val();    
        $("#txtetaseguimiento").val(ideta);      
        if (ideta==0) 
        {
          $("#tipoetaseguimiento").html('Seleccione el Tipo de ETA');
          $("#gasseguimiento").html('<option >Seleccione la Programática de Gasto</option>');
          $("#tipseguimiento").html('');
          $("#serseguimiento").html('');
          $("#acci").html('');
          $("#pilar").html('');
          $("#metaseguimiento").html('');
          $("#resultado").html('');
          $("#accion").html('');
        }
        else        
        {
          $.get("listarTipoEtas/"+ideta , function(respuesta){
              var etas = respuesta.etas;
              $("#tipoetaseguimiento").html('');
              var opcion0 = "<option value='0'>Seleccione el Tipo de ETA</option>";
              $("#tipoetaseguimiento").append(opcion0);
              for(var i=0; i<etas.length; i++)
              {
                var eta = etas[i];              
                var opcion = "<option value=" + eta.id_eta + ">" + eta.descripcion_eta + "</option>";           
                $("#tipoetaseguimiento").append(opcion);
              }
            });
          if(ideta==1||ideta==2)
          {
            var a=document.getElementById('serseguimiento');
            a.disabled=true;
            var b=document.getElementById('tipseguimiento');
            b.disabled=true;
              $.get("listarGastos1" , function(respuesta){
              var gastos = respuesta.gastos;
              $("#gasseguimiento").html('');
              var opcion0 = "<option value='-1'>Seleccione la Programática de Gasto</option>";
              $("#gasseguimiento").append(opcion0);
              for(var i=0; i<gastos.length; i++)
              {
                var gasto = gastos[i];              
                var opcion = "<option value=" + gasto.id_programa + ">" + gasto.descripcion_gasto + "</option>";           
                $("#gasseguimiento").append(opcion);
              }
            });
          }
          else 
          {
            var a=document.getElementById('serseguimiento');
            a.disabled=false;
            var b=document.getElementById('tipseguimiento');
            b.disabled=false;
              $.get("listarGastos2" , function(respuesta){
              var gastos = respuesta.gastos;
              $("#gasseguimiento").html('');
              var opcion0 = "<option value='-1'>Seleccione la Programática de Gasto</option>";
              $("#gasseguimiento").append(opcion0);
              for(var i=0; i<gastos.length; i++)
              {
                var gasto = gastos[i];              
                var opcion = "<option value=" + gasto.codigo + ">" + gasto.descripcion_gasto + "</option>";           
                $("#gasseguimiento").append(opcion);
              }
            });

          }
            
        }
        
      });

      //--------------cuando cambia la gasto
      $("#gasseguimiento").change(function(){
        idgasto = $("#gasseguimiento").val();
        idnomgasto = $('#gasseguimiento').find('option:selected').text();
        //alert(idnomgasto);
        ideta = $("#etaseguimiento").val();
        $("#txtgasseguimiento").val(idgasto);
        $("#txtnomgasseguimiento").val(idnomgasto);
        if (idgasto==-1) {
          $("#tipseguimiento").html('');
          $("#serseguimiento").html('');
          $("#acci").html('');         
          $("#pilar").html('');
          $("#metaseguimiento").html('');
          $("#resultado").html('');
          $("#accion").html('');
          
        }else
        {
          if (ideta==1||ideta==2) 
          {
            $("#tipseguimiento").html('');
           $("#txttiposeguimiento").val('0');
            $("#serseguimiento").html('');
            $("#txtservicioseguimiento").val('0');
            $.get("listarAcciones/" + idgasto, function(respuesta){
              var acciones = respuesta.acciones;
              $("#acci").html('');
              var opcion0 = "<option value=0>Seleccione la Acción ETA</option>";
              $("#acci").append(opcion0);
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_programa + ">" + accion.descripcion_gasto + "</option>";
                $("#acci").append(opcion);
              }
            });
          }
          else
          {
              if (idgasto==11) 
              {
var a=document.getElementById('serseguimiento');
            a.disabled=false;
            var b=document.getElementById('tipseguimiento');
            b.disabled=false;
                    $.get("listarTipos/" + idgasto, function(respuesta){
                  var tipos = respuesta.tipos;
                  $("#tipseguimiento").html('');
                  $("#pilar").html('<option>P</option>');
                  $("#metaseguimiento").html('<option>M</option>');
                  $("#resultado").html('<option>R</option>');
                  $("#accion").html('<option>A</option>');          
                  $("#descaccion").html('');
                  var opcion0 = "<option value=0>Seleccione el Tipo </option>";
                  $("#tipseguimiento").append(opcion0);
                  for(var i=0; i<tipos.length; i++)
                  {
                    var tipo = tipos[i];              
                    var opcion = "<option value=" + tipo.id_clasificador + ">" + tipo.descripcion_clasificador + "</option>";
                    $("#tipseguimiento").append(opcion);
                  }
                });
              }
              else
              {
                var a=document.getElementById('serseguimiento');
            a.disabled=true;
            var b=document.getElementById('tipseguimiento');
            b.disabled=true;
                  $.get("listarAcciones2/" + idgasto, function(respuesta){
                  var acciones = respuesta.acciones;
                  $("#acci").html('');
                  $("#tipseguimiento").html('');
                  $("#txttiposeguimiento").val('0');
                  $("#serseguimiento").html('');
                  $("#txtservicioseguimiento").val('0');
                  $("#pilar").html('<option>P</option>');
                  $("#metaseguimiento").html('<option>M</option>');
                  $("#resultado").html('<option>R</option>');
                  $("#accion").html('<option>A</option>');          
                  $("#descaccion").html('');
                  var opcion0 = "<option value=0>Seleccione la Acción ETA</option>";
                  $("#acci").append(opcion0);
                  for(var i=0; i<acciones.length; i++)
                  {
                    var accion = acciones[i];              
                    var opcion = "<option value=" + accion.id_correlativo + ">" + accion.accion_eta + "</option>";
                    $("#acci").append(opcion);
                  }
                });

              }
            
          }
            
        }        
      });
      //--------------cuando cambia el tipo
      $("#tipseguimiento").change(function(){
        idgasto = $("#gasseguimiento").val();
        idtip = $("#tipseguimiento").val();
        $("#txttiposeguimiento").val(idtip);
        if (idtip==0) {
          $("#serseguimiento").html('');
          $("#txtservicioseguimiento").val('0');
          $("#acci").html('');
          $("#pilar").html('');
          $("#metaseguimiento").html('');
          $("#resultado").html('');
          $("#accion").html('');
        }else
        {
          $.get("listarServicios/" + idgasto+"/"+idtip, function(respuesta){
                  var servicios = respuesta.servicios;
                  $("#acci").html('');                  
                  $("#serseguimiento").html('');
                  var opcion0 = "<option value=0>Seleccione el Servicio</option>";
                  $("#serseguimiento").append(opcion0);
                  for(var i=0; i<servicios.length; i++)
                  {
                    var servicio = servicios[i];              
                    var opcion = "<option value=" + servicio.id_servicio + ">" + servicio.descripcion_servicio + "</option>";
                    $("#serseguimiento").append(opcion);
                  }
                }); 
        }
        
      });
      //--------------cuando cambia la servico
      $("#serseguimiento").change(function(){
        idgasto = $("#gasseguimiento").val();
        idtipo = $("#tipseguimiento").val();
        idser = $("#serseguimiento").val();
        $("#txtservicioseguimiento").val(idser);
        if (idtip==0) {
          
          $("#acci").html('');
          $("#pilar").html('');
          $("#metaseguimiento").html('');
          $("#resultado").html('');
          $("#accion").html('');
          
        }else
        {
          $.get("listarAcciones3/" + idgasto+"/"+idtipo+"/"+idser, function(respuesta){
                  var acciones = respuesta.acciones;
                  $("#acci").html('');                  
                  var opcion0 = "<option value=0>Seleccione la Acción</option>";
                  $("#acci").append(opcion0);
                  for(var i=0; i<acciones.length; i++)
                  {
                    var accion = acciones[i];              
                    var opcion = "<option value=" + accion.id_correlativo + ">" + accion.accion_eta + "</option>";
                    $("#acci").append(opcion);
                  }
                }); 
        }
        
      });
      //--------------cuando cambia la acciones eta
      $("#acci").change(function(){
        idaccion = $("#acci").val();
        idnomaccion = $('#acci').find('option:selected').text();
        $("#txtacci").val(idaccion);
        
        $("#txtnomacci").val(idnomaccion);
        
        if (idaccion==0) {
          $("#pilar").html('');
          $("#metaseguimiento").html('');
          $("#resultado").html('');
          $("#accion").html('');
          $("#descripdes").html('');
        }
        else
        {
            $.get("listarPilares/" + idaccion, function(respuesta){
              var acciones = respuesta.acciones;
              $("#pilar").html('');
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_pilar + "</option>";           
                $("#pilar").append(opcion);
                numpil =  $('#pilar').find('option:selected').text();
                $("#txtpilar").val(numpil);
              }
            });
            $.get("listarMetas/" + idaccion, function(respuesta){
              var acciones = respuesta.acciones;
              $("#metaseguimiento").html('');
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_meta + "</option>";           
                $("#metaseguimiento").append(opcion);
                nummeta =  $('#metaseguimiento').find('option:selected').text();
                $("#txtmetasseguimiento").val(nummeta);
              }
            });
            $.get("listarResultados/" + idaccion, function(respuesta){
              var acciones = respuesta.acciones;
              $("#resultado").html('');
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_resultado + "</option>";           
                $("#resultado").append(opcion);
                 numresul =  $('#resultado').find('option:selected').text();
                $("#txtresul").val(numresul);
              }
            });
            $.get("listarAccionesEtas/" + idaccion, function(respuesta){
              var acciones = respuesta.acciones;
              $("#accion").html('');
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_accion + "</option>";           
                $("#accion").append(opcion);
                numaccion =  $('#accion').find('option:selected').text();
                $("#txtaccion").val(numaccion);
                
              }
              $("#accion").trigger( "change" );  
            });  

        }       
      });
//--------------cuando cambia la provincias

      $("#accion").change(function(){
        idpilar=$("#txtpilar").val();        
        idmeta=$("#txtmetasseguimiento").val();
        idresultado=$("#txtresul").val();
        idaccion=$("#txtaccion").val();
        //alert(idpilar+" "+ idmeta+" "+idresultado+" "+idaccion);
        $.get("listarPMRAs/"+ idpilar+"/"+idmeta+"/"+idresultado+"/"+idaccion, function(respuesta){
          var acciones = respuesta.acciones;
          $("#descaccion").html('');
          for(var i=0; i<acciones.length; i++){
            var accion = acciones[i];              
            var opcion = "<option value=" + accion.id_correlativo + ">" + accion.descripcion_directriz + "</option>";           
            $("#descaccion").append(opcion);
                nomaccio =  $('#descaccion').find('option:selected').text();
                $("#descripdes").val(nomaccio);
              }
            });        
      });
        

    })


 </script> 
 <script>
function verificaragregar()
  {
    departam1 = $("#txtdepseguimiento").val();
    provincia1 = $("#txtprovseguimiento").val();
    municipio1 = $("#txtmunseguimiento").val();
    progra1 = $("#txtgasseguimiento").val();
    nomprogra1 = $("#txtnomgasseguimiento").val();
    accion1 = $("#txtacci").val();
    nomaccion1 = $("#txtnomacci").val();
    pilar1 = $("#txtpilar").val();
    meta1 = $("#txtmetasseguimiento").val();
    resultado1 = $("#txtresul").val();
    acci1 = $("#txtaccion").val();
    totu=$("#total").val();
    totp=$("#totalp").val();
    
    lineabase=$("#linea_base").val();
    indipro=$("#ind_proceso").val();
    indican=$("#tipocantidad").val();
   // alert(departam1+"" +provincia1+"" +municipio1+"" +progra1+"" +nomprogra1+"" +accion1+"" +nomaccion1+"" +pilar1+"" +meta1+"" +resultado1+"" +acci1);

    if (departam1==undefined||departam1=='0'||departam1=='') {
    alert('Seleccione un Departamento.');  
    }
    else{
      if (provincia1==undefined||provincia1=='0'||provincia1=='') {
        alert('Seleccione una Provincia.');
      }
      else{
        if (municipio1==undefined||municipio1=='0'||municipio1=='') {
          alert('Seleccione una Municipio.');
        }else{
          if (progra1==undefined||progra1=='-1'||progra1=='') {
            alert('Seleccione una Programática de Gasto.');
          }else{
            if (nomprogra1==undefined||nomprogra1=='0'||nomprogra1=='') {
              alert('Seleccione una Programática de Gasto.');
            }else{
              if (accion1==undefined||accion1=='0'||accion1=='') {
                alert('Seleccione una Acción ETA.');
              }else{
                if (nomaccion1==undefined||nomaccion1=='0'||nomaccion1=='') {
                  alert('Seleccione una Acción.');
                }
                else
                {
                  if (pilar1==undefined||pilar1=='0'||pilar1=='') {
                    alert('Seleccione una Accion ETA con datos Pilar, Meta, Resultado, Acción.');
                  }
                  else
                  {
                    
                      if (indipro=='') 
                        {
                          alert("El Indicador de Proceso esta vacio");  
                        }
                      else
                        {
                              if (totp==''||totp!=0) {
                                alert("Verifique su resto Presupuesto");

                               }
                               else
                               {
                                var x = document.getElementById('guardar');
                                    var y = document.getElementById('verificaragregar');
                                    y.style.display = 'none';
                                      x.style.display = 'inline';
                                      var a=document.getElementById('etaseguimiento');
                                a.disabled=true; 
                                var b=document.getElementById('depseguimiento');
                                b.disabled=true;
                                var c=document.getElementById('provseguimiento');
                                c.disabled=true;
                                var d=document.getElementById('munseguimiento');
                                d.disabled=true;
                                var e=document.getElementById('gasseguimiento');
                                e.disabled=true;
                                var f=document.getElementById('tipseguimiento');
                                f.disabled=true;
                                var g=document.getElementById('serseguimiento');
                                g.disabled=true;     
                                var h=document.getElementById('acci');
                                h.disabled=true;
                                var i=document.getElementById('descripcion_accion_etaseguimiento');
                                i.disabled=true;
                                
                                var k=document.getElementById('ind_proceso');
                                k.disabled=true;
                               ;
                                var s=document.getElementById('txtpresu');
                                s.disabled=true;
                                var t=document.getElementById('p2016');
                                t.disabled=true;
                                var u=document.getElementById('p2017');
                                u.disabled=true;
                                var v=document.getElementById('p2018');
                                v.disabled=true;
                                var w=document.getElementById('p2019');
                                w.disabled=true;
                                var p20=document.getElementById('p2020');
                                p20.disabled=true;
                                 var tet=document.getElementById('tipoetaseguimiento');
                                tet.disabled=true;


                               }
                              
                            
                          
                          

                          
                        }
                    
                  }
                }
              }
            }
          }
        }
      }
    }    
  }
</script>

<!---------------todo lo de edicion--------------->
    <script type="text/javascript">
      $(function(){
        $("#actualizaredit").click(function()
      {  
        
        objeto = {};
        objeto.id_correlativo = $("#idcorreedit").val();
        objeto.id_tarea_eta = $("#txtetaseguimientoedit").val();
        objeto.id_departamento = $("#txtdepseguimientoedit").val();
        objeto.id_provincia = $("#txtprovseguimientoedit").val();
        objeto.id_municipio = $("#txtmunseguimientoedit").val();
        objeto.id_programa = $("#txtgasseguimientoedit").val();
        objeto.id_clasificador = $("#txttipoedit").val();
        objeto.id_servicio = $("#txtservicioseguimientoedit").val();
        objeto.descripcion_programa = $("#txtnomgasseguimientoedit").val();
        objeto.id_accion_eta = $("#txtacciseguimientoedit").val();
        objeto.accion_eta = $("#txtnomacciseguimientoedit").val();
        objeto.linea_base = $("#linea_baseedit").val();
        objeto.proceso_indicador = $("#ind_procesoedit").val();
        objeto.unidad_indicador = $("#tipocantidadedit").val();
        objeto.cantidad_indicador = $("#cantidadedit").val();
        objeto.indicador2016 = $("#2016edit").val();
        objeto.indicador2017 = $("#2017edit").val();
        objeto.indicador2018 = $("#2018edit").val();
        objeto.indicador2019 = $("#2019edit").val();
        objeto.indicador2020 = $("#2020edit").val();
        objeto.cantidad_presupuesto = $("#txtpresuedit").val();
        objeto.presupuesto2016 = $("#p2016edit").val();
        objeto.presupuesto2017 = $("#p2017edit").val();
        objeto.presupuesto2018 = $("#p2018edit").val();
        objeto.presupuesto2019 = $("#p2019edit").val();
        objeto.presupuesto2020 = $("#p2020edit").val();
        objeto.pilar = $("#txtpilaredit").val();
        objeto.meta = $("#txtmetasseguimientoedit").val();
        objeto.resultado = $("#txtresuledit").val();
        objeto.accion = $("#txtaccionedit").val();        
        objeto.accion = $("#txtaccionedit").val(); 
        objeto.accion = $("#txttipoetaseguimientoedit").val();       
        objeto.descripcion_accion_eta = $("#descripcion_accion_etaseguimiento_edit").val();   
        objeto.tipo_eta = $("#txttipoetaseguimientoedit").val();      
        objeto.descripcion_accion = $("#descripaccionedit").val();       
        objeto._token = $('input[name=_token]').val();
         
        try {        
            if (objeto) 
            {
             $.get("actualizarmatriz/"+objeto.id_correlativo, objeto, function(respuesta)
             {
              alert('informacion actualizada');
              location.reload();
              //$('#modal-editar').modal('toggle');
             }); 
            }
            else
             {
              alert('informacion no actualizada');
             }
            }
        catch(err) 
        {
            message.innerHTML = "Input is " + err;
        }
        
      });
      });
    </script>

    <script type="text/javascript">
      function eliminar(){
        //alert('aqui');
        
      }
    $(function()
    {
      $("#export").click(function()
      {   
        $("#gridseguimiento").jqxGrid('exportdata', 'xls', 'matrices', true, null, true);
      });
      $.get("listarMatricesSeguimiento",function(respuesta)
        {
          var source =
            {
                localdata: respuesta.matrices,
                datafields:
                [
                  { name: 'id_correlativo', type: 'int' },
                  { name: 'id_eta', type: 'int' },
                  { name: 'id_tipo_eta', type: 'int'},
                  { name: 'id_departamento',type:'datafield'},
                  { name: 'descripcion_departamento',type:'datafield'},
                  { name: 'id_provincia',type:'datafield'},
                  { name: 'descripcion_provincia', type: 'datafield' },
                  { name: 'id_municipio',type:'datafield'},
                  { name: 'descripcion_municipio', type: 'datafield'},
                  { name: 'pilar', type: 'int'},
                  { name: 'meta', type: 'int'},
                  { name: 'resultado', type: 'int'},
                  { name: 'accion', type: 'int'},
                  { name: 'descripcion_pdes', type: 'datafield'},                  
                  { name: 'id_programa', type: 'int' },
                  { name: 'descripcion_programa', type: 'datafield'},
                  { name: 'id_accion_eta', type: 'datafield'},
                  { name: 'descripcion_accion_eta', type: 'datafield'},
                  { name: 'indicador_procesos', type: 'datafield'},
                  { name: 'descripcion_accion_eta_prog', type: 'datafield'},
                  { name: 'cantidad_presupuesto', type: 'numeric'},
                  { name: 'presupuesto2016', type: 'numeric'},
                  { name: 'presupuesto2017', type: 'numeric'},
                  { name: 'presupuesto2018', type: 'numeric'},
                  { name: 'presupuesto2019', type: 'numeric'},
                  { name: 'presupuesto2020', type: 'numeric'},
                  { name: 'competencia', type: 'numeric'},
                  { name: 'NCE', type: 'numeric'},
                  { name: 'GAD', type: 'numeric'},
                  { name: 'GAM', type: 'numeric'},                  
                  { name: 'id_clasificador', type: 'datafield'},       
                  { name: 'id_servicio', type: 'datafield'},       
                  { name: 'estado', type: 'datafield'}                  
                ],
                datatype: "json",
                updaterow: function (rowid, rowdata, commit) {
                    commit(true);
                }
            };   
          var dataAdapter = new $.jqx.dataAdapter(source);           
          $("#gridseguimiento").jqxGrid(
            {
              width: '100%',
              source: dataAdapter,
              theme: 'dark',
              altrows: true,
              pageable: true,
              autoheight: true,
              //selectionmode: 'multiplecellsextended',
              showgroupaggregates: true,
              showstatusbar: true,
              showaggregates: true,
              statusbarheight: 40,                            
              showfilterrow: true,
              filterable: true,
              sortable: true,
              autorowheight: true,
              columns:
               [                
                 { text: 'DEP', filtercondition: 'starts_with', datafield: 'descripcion_departamento', width: 80},
                 { text: 'PROV', filtercondition: 'starts_with',datafield: 'descripcion_provincia',   width: 80 },
                 { text: 'MUN', filtercondition: 'starts_with',datafield: 'descripcion_municipio',   width: 80 },
                 { text: 'PIL', filtercondition: 'starts_with',datafield: 'pilar',   width: 80 },
                 { text: 'MET', filtercondition: 'starts_with',datafield: 'meta',   width: 80 },
                 { text: 'RES', filtercondition: 'starts_with',datafield: 'resultado',   width: 80 },
                 { text: 'ACC', filtercondition: 'starts_with',datafield: 'accion',   width: 80 },
                 { text: 'DESCRIPCION', filtercondition: 'starts_with',datafield: 'descripcion_pdes',   width: 180 },
                 { text: 'PROG', filtertype: 'checkedlist',datafield: 'id_programa',   width: 70 },
                 { text: 'DESCRIPCIÓN', filtercondition: 'starts_with',datafield: 'descripcion_programa',   width: 270 },
                 { text: 'ACCION ETA', filtercondition: 'starts_with',datafield: 'id_accion_eta',   width: 70 },
                 { text: 'DESCRIPCION', filtercondition: 'starts_with',datafield: 'descripcion_accion_eta',   width: 270 },
                 { text: 'INDICADOR PROCESO', filtercondition: 'starts_with',datafield: 'indicador_procesos',   width: 200 },
                 { text: 'DESCRIPCION ETA', filtercondition: 'starts_with',datafield: 'descripcion_accion_eta_prog',   width: 200 },
                 { text: 'PRESUPUESTO', filtertype: 'checkedlist',datafield: 'cantidad_presupuesto', aggregates: ["sum"],   width: 100 },
                 { text: '2016', filtertype: 'checkedlist', aggregates: ["sum"],datafield: 'presupuesto2016',   width: 100 },               
                 { text: '2017', filtertype: 'checkedlist',datafield: 'presupuesto2017', aggregates: ["sum"],   width: 100 },               
                 { text: '2018', filtertype: 'checkedlist',datafield: 'presupuesto2018', aggregates: ["sum"],   width: 100 },               
                 { text: '2019', filtertype: 'checkedlist',datafield: 'presupuesto2019', aggregates: ["sum"],   width: 100 },               
                 { text: '2020', filtertype: 'checkedlist',datafield: 'presupuesto2020', aggregates: ["sum"],   width: 100 },               
                 { text: 'clasificador', filtertype: 'checkedlist',datafield: 'id_clasificador',   width: 100 },               
                
                 { text: 'ACCIONES', datafield: 'id_correlativo',   width: 180, cellsRenderer: function (row, column, value, rowData)  
                    {
                      return "<button class='btn btn-sm btn-warning dark m5 br6' id='e"+value+"'><i class='glyphicon glyphicon-pencil'></i> Editar </button><button class='btn btn-sm btn-danger dark m5 br6' id='d"+value+"'><i class='glyphicon glyphicon-minus'></i> Eliminar </button> ";
                    }, 
                 }
                
               ]
            });
          $('#clearfilteringbutton').jqxButton({ height: 25});
        $('#clearfilteringbutton').click(function () 
          {
              $("#gridseguimiento").jqxGrid('clearfilters');
          });
          $("#gridseguimiento").on("click", "button", function()
          {
            var codigo = $(this).attr('id');
            var letra = codigo.substr(0,1);
            var id= codigo.substr(1,10); 
            if (letra=='e') 
            {
              $.magnificPopup.open(
              {
               removalDelay: 500,                     
               focus: '#nombreinput',
               items: 
                {
                  src: "#modal-editar-seguimiento"
                },                
               callbacks: 
                {
                 beforeOpen: function(e) 
                  {
                   var Animation = "mfp-zoomOut";
                   this.st.mainClass = Animation;
                  }
                },
               midClick: true 
              });
              $("#idcorreedit").val(id);
              $(".state-error").removeClass("state-error");
              var getselectedrowindexes = $('#gridseguimiento').jqxGrid('getselectedrowindexes');
              if (getselectedrowindexes.length>0) 
              {
                 filaseleccionada=$('#gridseguimiento').jqxGrid('getrowdata',getselectedrowindexes[0]);
                 $("#depseguimientoedit").val(filaseleccionada.id_departamento);
                 $("#etaseguimientoedit").val(filaseleccionada.id_eta); 
                 $("#etaseguimientoedit").trigger( "change");
                 setTimeout(function(){
                  $("#tipoetaseguimientoedit").val(filaseleccionada.id_tipo_eta); 
                 $("#tipoetaseguimientoedit").trigger( "change");
                 }, 370);            
                 setTimeout(function(){
                 $("#depseguimientoedit").trigger( "change");
                 }, 530);
                 setTimeout(function(){
                    var x=filaseleccionada.id_provincia;
                    $("#provseguimientoedit").val(x);    
                    $("#provseguimientoedit").trigger( "change");
                 }, 920);
                 setTimeout(function(){
                    var y=filaseleccionada.id_municipio;
                     $("#munseguimientoedit").val(y);    
                     $("#munseguimientoedit").trigger( "change");
                 }, 1320);
                 setTimeout(function(){
                    var y=filaseleccionada.id_programa;
                     $("#gasseguimientoedit").val(y);    
                     $("#gasseguimientoedit").trigger( "change");
                 }, 1920);
                 
                 if (filaseleccionada.id_eta!=1||filaseleccionada.id_eta!=2) 
                    {
                      if (filaseleccionada.id_programa==11) 
                        {
                          setTimeout(function()
                           {
                              var c=filaseleccionada.id_clasificador;          
                              $("#tipseguimientoedit").val(c);    
                              $("#tipseguimientoedit").trigger( "change");
                           }, 2320); 
                          setTimeout(function()
                           {
                              var s=filaseleccionada.id_servicio; 

                              $("#serseguimientoedit").val(s);    
                              $("#serseguimientoedit").trigger( "change");
                           }, 2820);
                          setTimeout(function(){
                              var z=filaseleccionada.id_accion_eta;
                              $("#acciseguimientoedit").val(z);    
                              $("#acciseguimientoedit").trigger( "change");
                          }, 3320);
                          setTimeout(function(){
                              var y=filaseleccionada.id_servicio;
                              $("#pilaredit").val(y);    
                              $("#pilaredit").trigger( "change");
                          }, 3820);

                        }
                      else
                        {
                          setTimeout(function(){
                              var z=filaseleccionada.id_accion_eta;
                              $("#acciseguimientoedit").val(z);    
                              $("#acciseguimientoedit").trigger( "change");
                          }, 2820);
                          setTimeout(function(){
                              var y=filaseleccionada.id_servicio;
                              $("#pilaredit").val(y);    
                              $("#pilaredit").trigger( "change");
                          }, 3320);
                          
                        }
                    }
                 else
                 { 
                 alert('no existen registros')                     ;
                 }
                 setTimeout(function(){
                      var o=filaseleccionada.descripcion_accion_eta;
                      $("#descripcion_accion_etaseguimiento_edit").val(o);    
                      var a=filaseleccionada.linea_base;
                      $("#linea_baseedit").val(a);
                      var b=filaseleccionada.proceso_indicador;
                      $("#ind_procesoedit").val(b);
                      var z=filaseleccionada.unidad_indicador;
                      $("#tipocantidadedit").val(z);
                      var c=filaseleccionada.cantidad_indicador;
                      $("#cantidadedit").val(c);
                      var d=filaseleccionada.indicador2016;
                      $("#2016edit").val(d);
                      var e=filaseleccionada.indicador2017;
                      $("#2017edit").val(e);
                      var f=filaseleccionada.indicador2018;
                      $("#2018edit").val(f);
                      var g=filaseleccionada.indicador2019;
                      $("#2019edit").val(g);
                      var h=filaseleccionada.indicador2020;
                      $("#2020edit").val(h);
                      var i=filaseleccionada.cantidad_presupuesto;
                      $("#txtpresuedit").val(i);
                      var j=filaseleccionada.presupuesto2016;
                      $("#p2016edit").val(j);
                      var k=filaseleccionada.presupuesto2017;
                      $("#p2017edit").val(k);
                      var l=filaseleccionada.presupuesto2018;
                      $("#p2018edit").val(l);
                      var m=filaseleccionada.presupuesto2019;
                      $("#p2019edit").val(m);
                      var n=filaseleccionada.presupuesto2020;
                      $("#p2020edit").val(n);
                  }, 3470);

              }
              console.log(filaseleccionada);
          $("#form-plan em").remove();

            }
            else{
               var codigo = $(this).attr('id');
               var letra = codigo.substr(0,1);
               var id= codigo.substr(1,10);
               objeto = {};  
               objeto.id_correlativo = id;         
               objeto._token = $('input[name=_token]').val();
               var opcion = confirm("¿Esta seguro de eliminar esta información?");
    if (opcion == true) {
         try 
                {        
                    if (objeto) 
                      {
                       $.get("eliminarmatriz/"+objeto.id_correlativo, objeto, function(respuesta)
                       {
                          alert('informacion eliminada');
                          location.reload();
                          //$('#modal-editar').modal('toggle');
                       }); 
                      }
                    else
                      {
                        alert('informacion no eliminada');
                      }
                }
                catch(err) 
                {
                    message.innerHTML = "Input is " + err;
                }
  } 
             /* */

            }

          });
          
                   
        $.get("listarEtasEditar", function(respuesta)
          {
              var etas = respuesta.etas;
              for(var i=0; i<etas.length; i++)
              {
                var eta = etas[i];
                var opcion = "<option value=" + eta.id_eta + ">" + eta.descripcion_eta + "</option>";
                $("#etaseguimientoedit").append(opcion);
              }
              console.log(etas);
          });

        $.get("listarDepartamentosEditar", function(respuesta)
          {
              var departamentos = respuesta.departamentos;
              for(var i=0; i<departamentos.length; i++)
              {
                var departamento = departamentos[i];
                var opcion = "<option value=" + departamento.id_departamento + ">" + departamento.descripcion_departamento + "</option>";
                $("#depseguimientoedit").append(opcion);
              }
              console.log(departamentos);
          });


        });
    })

</script>
 <script>
function sumaredit(){
  tot = parseInt(document.getElementById('cantidadedit').value);
    a = parseInt(document.getElementById('2016edit').value);
    b = parseInt(document.getElementById('2017edit').value);
    c = parseInt(document.getElementById('2018edit').value);
    d = parseInt(document.getElementById('2019edit').value);
    e = parseInt(document.getElementById('2020edit').value);
    tsum=a+b+c+d+e;
    document.getElementById('totaledit').value = tot-tsum;
}
function sumarPresupuedit(){
  totpre = parseFloat(document.getElementById('txtpresuedit').value);
    pa = parseFloat(document.getElementById('p2016edit').value);
    pb = parseFloat(document.getElementById('p2017edit').value);
    pc = parseFloat(document.getElementById('p2018edit').value);
    pd = parseFloat(document.getElementById('p2019edit').value);
    pe = parseFloat(document.getElementById('p2020edit').value);
    tsumpre=pa+pb+pc+pd+pe;
    document.getElementById('totalpedit').value = totpre-tsumpre;
}
</script>
<script type="text/javascript">
    $(function()
    {
//--------------botonguardar
      //--------------cuando cambia tipo eta
      $("#tipoetaseguimientoedit").change(function(){
        idtipeta=$("#tipoetaseguimientoedit").val();
        $("#txttipoetaseguimientoedit").val(idtipeta);        
        if (idtipeta==0) {
          
          
          $("#gasseguimientoedit").val('0');
          $("#tipseguimientoedit").html('');
          $("#serseguimientoedit").html('');
          $("#acciseguimientoedit").html('');
          $("#pilaredit").html('');
          $("#metaseguimientoedit").html('');
          $("#resultadoedit").html('');
          $("#accionedit").html('');
        }else
        {
          $.get("TipoEtasSeguimientoEdit/" +idtipeta, function(respuesta){
                  var etas = respuesta.etas;
                  
                  for(var i=0; i<etas.length; i++)
                  {
                    var eta = etas[i];              
                    
                    $("#depseguimientoedit").val(eta.id_departamento);
                    $("#depseguimientoedit").trigger( "change");
                    setTimeout(function(){
                     $("#provseguimientoedit").val(eta.id_provincia);
                     $("#provseguimientoedit").trigger( "change");
                    }, 1200);
                    setTimeout(function(){
                     $("#munseguimientoedit").val(eta.id_municipio);
                     $("#munseguimientoedit").trigger( "change");
                    }, 1900);
                  }
                  
                }); 
        }
        
      });
      //--------------

      $("#depseguimientoedit").change(function()
      {
        iddepar = $("#depseguimientoedit").val();
        $("#txtdepseguimientoedit").val(iddepar);
        if (iddepar==0) {
          $("#provseguimientoedit").html('<option>Seleccione la Provincia</option>');
          $("#munseguimientoedit").html('<option>Seleccione la Município</option>');          
        }
        else
        {
          //alert(iddepar);
           $.get("listarProvinciasEditar/" + iddepar, function(respuesta){
              var provincias = respuesta.provincias;
              $("#provseguimientoedit").html('');

                var opcion0 = "<option value=0>Seleccione la Provincia</option>";
                $("#provseguimientoedit").append(opcion0);
              for(var i=0; i<provincias.length; i++)
              {
                var provincia = provincias[i];
                var opcion = "<option value=" + provincia.id_provincia + ">" + provincia.descripcion_provincia + "</option>";
                $("#provseguimientoedit").append(opcion);
              }
          }); 
        }
      });
  //--------------cuando cambia la provincias
      $("#provseguimientoedit").change(function(){
        iddepar = $("#depseguimientoedit").val();
        idprov = $("#provseguimientoedit").val();
        $("#txtprovseguimientoedit").val(idprov);
        if (idprov==0) {
          $("#munseguimientoedit").html('<option>Seleccione la Município</option>');
        }
        else
        {
          $.get("listarMunicipios/" + iddepar+"/"+idprov, function(respuesta)
          {
            var municipios = respuesta.municipios;
            $("#munseguimientoedit").html('');
            var opcion0 = "<option value=0>Seleccione el Municipio</option>";
            $("#munseguimientoedit").append(opcion0);
            for(var i=0; i<municipios.length; i++)
              {
                  var municipio = municipios[i];              
                  var opcion = "<option value=" + municipio.id_municipio + ">" + municipio.descripcion_municipio + "</option>";           
                  $("#munseguimientoedit").append(opcion);
              }
          });
        }        
      });
      //--------------cuando cambia la provincias
      $("#munseguimientoedit").change(function(){
        
        idmun = $("#munseguimientoedit").val();
        $("#txtmunseguimientoedit").val(idmun);
      });
      //--------------cuando cambia la eta
      $("#etaseguimientoedit").change(function()
      {
        ideta = $("#etaseguimientoedit").val();   
        $("#txtetaseguimientoedit").val(ideta);   
        if (ideta==0) 
        {
          $("#tipoetaseguimientoedit").html('Seleccione el Tipo de ETA');
          $("#gasseguimientoedit").html('<option >Seleccione la Programática de Gasto</option>');
          $("#tipseguimientoedit").html('');
          $("#txttiposeguimientoedit").val('0');
          $("#serseguimientoedit").html('');
          $("#txtservicioseguimientoedit").val('0');
          $("#acciseguimientoedit").html('');
          $("#pilaredit").html('');
          $("#metaseguimientoedit").html('');
          $("#resultadoedit").html('');
          $("#accionedit").html('');
        }
        else        
        {
          $.get("listarTipoEtas/"+ideta , function(respuesta){
              var etas = respuesta.etas;
              $("#tipoetaseguimientoedit").html('');
              var opcion0 = "<option value='0'>Seleccione el Tipo de ETA</option>";
              $("#tipoetaseguimientoedit").append(opcion0);
              for(var i=0; i<etas.length; i++)
              {
                var eta = etas[i];              
                var opcion = "<option value=" + eta.id_eta + ">" + eta.descripcion_eta + "</option>";           
                $("#tipoetaseguimientoedit").append(opcion);
              }
            });
          if(ideta==1||ideta==2)
          {
              $.get("listarGastos1" , function(respuesta)
              {
                var gastos = respuesta.gastos;
                $("#gasseguimientoedit").html('');
                var opcion0 = "<option value='-1'>Seleccione la Programática de Gasto</option>";
                $("#gasseguimientoedit").append(opcion0);
                for(var i=0; i<gastos.length; i++)
                {
                 var gasto = gastos[i];              
                 var opcion = "<option value=" + gasto.id_programa + ">" + gasto.descripcion_gasto + "</option>";        
                  $("#gasseguimientoedit").append(opcion);
                }
              });
          }
          else 
          {
              $.get("listarGastos2" , function(respuesta)
              {
                var gastos = respuesta.gastos;
                $("#gasseguimientoedit").html('');
                var opcion0 = "<option value='-1'>Seleccione la Programática de Gasto</option>";
                $("#gasseguimientoedit").append(opcion0);
                for(var i=0; i<gastos.length; i++)
                {
                  var gasto = gastos[i];              
                  var opcion = "<option value=" + gasto.codigo + ">" + gasto.descripcion_gasto + "</option>";           
                  $("#gasseguimientoedit").append(opcion);
                }
              });
          }            
        }
      });
      //--------------cuando cambia la gasto
      $("#gasseguimientoedit").change(function()
      {
        idgasto = $("#gasseguimientoedit").val();
        idnomgasto = $('#gasseguimientoedit').find('option:selected').text();
        //alert(idnomgasto);
        ideta = $("#etaseguimientoedit").val();
        $("#txtgasseguimientoedit").val(idgasto);
        $("#txtnomgasseguimientoedit").val(idnomgasto);
        if (idgasto==-1) 
        {
          $("#tipseguimientoedit").html('');
          $("#txttiposeguimientoedit").val('0');
          $("#serseguimientoedit").html('');
          $("#txtservicioseguimientoedit").val('0');
          $("#acciseguimientoedit").html('');         
          $("#pilaredit").html('');
          $("#metaseguimientoedit").html('');
          $("#resultadoedit").html('');
          $("#accionedit").html('');          
        }
        else
        {
          if (ideta==1||ideta==2) 
          {
            $("#tipseguimientoedit").html('');
            $("#txttiposeguimientoedit").val('0');
            $("#serseguimientoedit").html('');
            $("#txtservicioseguimientoedit").val('0');
            $.get("listarAcciones/" + idgasto, function(respuesta)
            {
              var acciones = respuesta.acciones;
              $("#acciseguimientoedit").html('');
              var opcion0 = "<option value=0>Seleccione la Acción ETA</option>";
              $("#acciseguimientoedit").append(opcion0);
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_programa + ">" + accion.descripcion_gasto + "</option>";
                $("#acciseguimientoedit").append(opcion);
              }
            });
            
          }
          else
          {
              if (idgasto==11) 
              {
                    $.get("listarTiposEditar", function(respuesta){
                  var tipos = respuesta.tipos;
                  $("#tipseguimientoedit").html('');
                  $("#pilaredit").html('<option>P</option>');
                  $("#metaseguimientoedit").html('<option>M</option>');
                  $("#resultadoedit").html('<option>R</option>');
                  $("#accionedit").html('<option>A</option>');          
                  $("#descaccionedit").html('');
                  var opcion0 = "<option value=0>Seleccione el Tipo </option>";
                  $("#tipseguimientoedit").append(opcion0);
                  for(var i=0; i<tipos.length; i++)
                  {
                    var tipo = tipos[i];              
                    var opcion = "<option value=" + tipo.id_clasificador + ">" + tipo.descripcion_clasificador + "</option>";
                    $("#tipseguimientoedit").append(opcion);

                  }
                });
              }
              else
              {
                  $.get("listarAcciones2/" + idgasto, function(respuesta)
                  {
                    var acciones = respuesta.acciones;
                    $("#acciseguimientoedit").html('');
                    $("#tipseguimientoedit").html('');
                    $("#txttiposeguimientoedit").val('0');
                    $("#serseguimientoedit").html('');
                    $("#txtservicioseguimientoedit").val('0');
                    $("#pilaredit").html('<option>P</option>');
                    $("#metaseguimientoedit").html('<option>M</option>');
                    $("#resultadoedit").html('<option>R</option>');
                    $("#accionedit").html('<option>A</option>');          
                    $("#descaccionedit").html('');
                    var opcion0 = "<option value=0>Seleccione la Acción ETA</option>";
                    $("#acciseguimientoedit").append(opcion0);
                    for(var i=0; i<acciones.length; i++)
                    {
                      var accion = acciones[i];              
                      var opcion = "<option value=" + accion.id_correlativo + ">" + accion.accion_eta + "</option>";
                      $("#acciseguimientoedit").append(opcion);
                    }
                  });            
              }            
          }  
        }       
      });
      //--------------cuando cambia el tipo
      $("#tipseguimientoedit").change(function()
      {
        idgasto = $("#gasseguimientoedit").val();
        idtip = $("#tipseguimientoedit").val();
        $("#txttiposeguimientoedit").val(idtip);
        if (idtip==0) 
        {
          $("#serseguimientoedit").html('');
          $("#txtservicioseguimientoedit").val('0');
          $("#acciseguimientoedit").html('');
          $("#pilaredit").html('');
          $("#metaseguimientoedit").html('');
          $("#resultadoedit").html('');
          $("#accionedit").html('');
        }
        else
        {
          $.get("listarServiciosEditar" , function(respuesta)
          {
                  var servicios = respuesta.servicios;
                  $("#acciseguimientoedit").html('');                  
                  $("#serseguimientoedit").html('');
                  var opcion0 = "<option value=0>Seleccione el Servicio</option>";
                  $("#serseguimientoedit").append(opcion0);
                  for(var i=0; i<servicios.length; i++)
                  {
                    var servicio = servicios[i];              
                    var opcion = "<option value=" + servicio.id_servicio + ">" + servicio.descripcion_servicio + "</option>";
                    $("#serseguimientoedit").append(opcion);
                  }
          }); 
        }
      });
      //--------------cuando cambia la servico
      $("#serseguimientoedit").change(function(){
        idgasto = $("#gasseguimientoedit").val();
        idtipo = $("#tipseguimientoedit").val();
        idser = $("#serseguimientoedit").val();
        $("#txtservicioseguimientoedit").val(idser);
        if (idtip==0) 
        {          
          $("#acciseguimientoedit").html('');
          $("#pilaredit").html('');
          $("#metaseguimientoedit").html('');
          $("#resultadoedit").html('');
          $("#accionedit").html('');
        }
        else
        {
          $.get("listarAcciones3/" + idgasto+"/"+idtipo+"/"+idser, function(respuesta){
              var acciones = respuesta.acciones;
              $("#acciseguimientoedit").html('');                  
              var opcion0 = "<option value=0>Seleccione la Acción</option>";
              $("#acciseguimientoedit").append(opcion0);
              for(var i=0; i<acciones.length; i++)
                {
                  var accion = acciones[i];              
                  var opcion = "<option value=" + accion.id_correlativo + ">" + accion.accion_eta + "</option>";
                  $("#acciseguimientoedit").append(opcion);
                }
            }); 
        }
      });
      //--------------cuando cambia la acciones eta
      $("#acciseguimientoedit").change(function()
      {
        idaccion = $("#acciseguimientoedit").val();
        idnomaccion = $('#acciseguimientoedit').find('option:selected').text();
        $("#txtacciseguimientoedit").val(idaccion);
        $("#txtnomacciseguimientoedit").val(idnomaccion);        
        if (idaccion==0) 
        {
          $("#pilaredit").html('');
          $("#metaseguimientoedit").html('');
          $("#resultadoedit").html('');
          $("#accionedit").html('');
          $("#descripaccionedit").html('');
        }
        else
        {
            $.get("listarPilares/" + idaccion, function(respuesta)
            {
              var acciones = respuesta.acciones;
              $("#pilaredit").html('');
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_pilar + "</option>";           
                $("#pilaredit").append(opcion);
                numpil =  $('#pilaredit').find('option:selected').text();
                $("#txtpilaredit").val(numpil);
              }
            });
            $.get("listarMetas/" + idaccion, function(respuesta)
            {
              var acciones = respuesta.acciones;
              $("#metaseguimientoedit").html('');
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_meta + "</option>";           
                $("#metaseguimientoedit").append(opcion);
                nummeta =  $('#metaedit').find('option:selected').text();
                $("#txtmetasseguimientoedit").val(nummeta);
              }
            });
            $.get("listarResultados/" + idaccion, function(respuesta)
            {
            var acciones = respuesta.acciones;
            $("#resultadoedit").html('');
            for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_resultado + "</option>";           
                $("#resultadoedit").append(opcion);
                 numresul =  $('#resultadoedit').find('option:selected').text();
                $("#txtresuledit").val(numresul);
              }
            });
            $.get("listarAccionesEtas/" + idaccion, function(respuesta)
            {
              var acciones = respuesta.acciones;
              $("#accionedit").html('');
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_accion + "</option>";           
                $("#accionedit").append(opcion);
                numaccion =  $('#accionedit').find('option:selected').text();
                $("#txtaccionedit").val(numaccion);
                
              }
              $("#accionedit").trigger( "change" );  
            });  
        }       
      });
//--------------cuando cambia la provincias
      $("#accionedit").change(function()
      {
        idpilar=$("#txtpilaredit").val();        
        idmeta=$("#txtmetasseguimientoedit").val();
        idresultado=$("#txtresuledit").val();
        idaccion=$("#txtaccionedit").val();
        //alert(idpilar+" "+ idmeta+" "+idresultado+" "+idaccion);
        $.get("listarPMRAs/"+ idpilar+"/"+idmeta+"/"+idresultado+"/"+idaccion, function(respuesta)
        {
          var acciones = respuesta.acciones;
          $("#descaccionedit").html('');
          for(var i=0; i<acciones.length; i++)
          {
            var accion = acciones[i];              
            var opcion = "<option value=" + accion.id_correlativo + ">" + accion.descripcion_directriz + "</option>";           
            $("#descaccionedit").append(opcion);
            nomaccio =  $('#descaccionedit').find('option:selected').text();
            $("#descripaccionedit").val(nomaccio);
          }
        });        
      });
    });
 </script> 
 <script>
function verificaredit()
  {
    departam1 = $("#txtdepseguimientoedit").val();
    provincia1 = $("#txtprovseguimientoedit").val();
    municipio1 = $("#txtmunseguimientoedit").val();
    progra1 = $("#txtgasseguimientoedit").val();
    nomprogra1 = $("#txtnomgasseguimientoedit").val();
    accion1 = $("#txtacciseguimientoedit").val();
    nomaccion1 = $("#txtnomacciseguimientoedit").val();
    pilar1 = $("#txtpilaredit").val();
    meta1 = $("#txtmetasseguimientoedit").val();
    resultado1 = $("#txtresuledit").val();
    acci1 = $("#txtaccionedit").val();
    totu=$("#totaledit").val();
    totp=$("#totalpedit").val();    
    lineabase=$("#linea_baseedit").val();
    indipro=$("#ind_procesoedit").val();
    indican=$("#tipocantidadedit").val();

    if (departam1==undefined||departam1=='0'||departam1=='') {
    alert('Seleccione un Departamento.');  
    }
    else{
      if (provincia1==undefined||provincia1=='0'||provincia1=='') {
        alert('Seleccione una Provincia.');
      }
      else{
        if (municipio1==undefined||municipio1=='0'||municipio1=='') {
          alert('Seleccione una Municipio.');
        }else{
          if (progra1==undefined||progra1=='-1'||progra1=='') {
            alert('Seleccione una Programática de Gasto.');
          }else{
            if (nomprogra1==undefined||nomprogra1=='0'||nomprogra1=='') {
              alert('Seleccione una Programática de Gasto.');
            }else{
              if (accion1==undefined||accion1=='0'||accion1=='') {
                alert('Seleccione una Acción ETA.');
              }else{
                if (nomaccion1==undefined||nomaccion1=='0'||nomaccion1=='') {
                  alert('Seleccione una Acción ETA.');
                }
                else
                {
                  if (pilar1==undefined||pilar1=='0'||pilar1=='') {
                    alert('Seleccione una Accion ETA con datos Pilar, Meta, Resultado, Acción.');
                  }
                  else
                  {
                    if (lineabase=='') 
                    {
                      alert("La Linea Base esta vacia");  
                    }
                    else
                    {
                      if (indipro=='') 
                        {
                          alert("El Indicador de Proceso esta vacio");  
                        }
                      else
                        {
                          if (indican=='') {
                            alert("La Unidad esta vacia");

                          }
                          else
                          {
                            
                            if (totu==''||totu!=0) {
                             alert("Verifique su Resto de Unidades");  
                            }
                            else{
                               if (totp==''||totp!=0) {
                                alert("Verifique su resto Presupuesto");

                               }
                               else
                               {
                                var x = document.getElementById('actualizaredit');
                                    var y = document.getElementById('verificaredit');
                                    y.style.display = 'none';
                                      x.style.display = 'inline';
                                var a=document.getElementById('etaseguimientoedit');
                                a.disabled=true;     
                                var b=document.getElementById('depseguimientoedit');
                                b.disabled=true;
                                var c=document.getElementById('provseguimientoedit');
                                c.disabled=true;
                                var d=document.getElementById('munseguimientoedit');
                                d.disabled=true;
                                var e=document.getElementById('gasseguimientoedit');
                                e.disabled=true;
                                var f=document.getElementById('serseguimientoedit');
                                f.disabled=true;
                                var g=document.getElementById('tipseguimientoedit');
                                g.disabled=true;     
                                var h=document.getElementById('acciseguimientoedit');
                                h.disabled=true;
                                var i=document.getElementById('descripcion_accion_etaseguimiento_edit');
                                i.disabled=true;
                                var j=document.getElementById('linea_baseedit');
                                j.disabled=true;
                                var k=document.getElementById('ind_procesoedit');
                                k.disabled=true;
                                var l=document.getElementById('tipocantidadedit');
                                l.disabled=true;
                                var m=document.getElementById('cantidadedit');
                                m.disabled=true;
                                var n=document.getElementById('2016edit');
                                n.disabled=true;
                                var o=document.getElementById('2017edit');
                                o.disabled=true;     
                                var p=document.getElementById('2018edit');
                                p.disabled=true;
                                var q=document.getElementById('2019edit');
                                q.disabled=true;
                                var r=document.getElementById('2020edit');
                                r.disabled=true;
                                var s=document.getElementById('txtpresuedit');
                                s.disabled=true;
                                var t=document.getElementById('p2016edit');
                                t.disabled=true;
                                var u=document.getElementById('p2017edit');
                                u.disabled=true;
                                var v=document.getElementById('p2018edit');
                                v.disabled=true;
                                var w=document.getElementById('p2019edit');
                                w.disabled=true;
                                var p20=document.getElementById('p2020edit');
                                p20.disabled=true;
                                var tet=document.getElementById('tipoetaseguimientoedit');
                                tet.disabled=true;


                               }
                              
                            }
                          
                          }

                          
                        }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }    
  }
</script>
@endpush
