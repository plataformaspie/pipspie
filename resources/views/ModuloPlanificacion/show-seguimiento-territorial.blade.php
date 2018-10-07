@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.shinyblack.css" type="text/css" />

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
                     <span class="panel-title"> Seguimiento</span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="estructura" class="col-md-12" >
                          <div class="panel panel-visible">
                              <div id='jqxWidget'>
                              <button id="agregarseguimiento"  class="btn btn-sm btn-success dark m5 br4" name="agregarseguimiento"><i class='glyphicon glyphicon-plus'>Agregar</i></button>
                              <input class="btn btn-sm btn-success dark m5 br4" style="margin-top: 10px;" value="Limpiar Filtro" id="clearfilteringbutton" type="button" /><input class="btn btn-sm btn-success dark m5 br4" style="margin-top: 10px;" value="Exportar" id="export" type="button" />
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
      <font style="font-family: sans-serif;color: white">Formulario de Seguimiento Agregar</font>
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
                                  
                                      <select id="gestion" name="gestion" class="form-control">
                                      <option value="0">Gestion</option> 
                                      <option value="2016">2016</option>
                                      <option value="2017">2017</option>
                                      <option value="2018">2018</option>
                                      <option value="2019">2019</option>
                                      <option value="2020">2020</option>
                                    </select>
                                    
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
                              <td  colspan="2" style="background: #2a2a2c;"><font color="white"><center>Seguimiento de Presupuesto</center></font></td></tr>
                            </tr>
                            <tr>
                              <td  colspan="2" style="background: #2a2a2c;"><font color="white"><center>Descripción</center></font></td>
                            </tr>
                            <tr>
                             <td  colspan="2"><textarea name="txtTotalpresupuesto" id="txtTotalpresupuesto"value="" style="width: 100%" rows="2" cols="5" ></textarea></td>
                            </tr>
                            <tr>
                              <td style="background: #2a2a2c;"><font color="white">Presupuesto Ejecutado</font></td>
                              <td><input type="number" name="txtpresupuestoejecutado" id="txtpresupuestoejecutado" value="0.0" ></td>
                            </tr>
                            <tr>
                              
                                    
                            </tr>
                            <tr>
                              <td ><input type="text" disabled placeholder="Total Presupuesto" value="0.0" id="totalp" style="visibility: hidden;" name="totalp" width="100%"></td>
                            </tr>
                            
                            <tr>
                              <td>                              
                                              
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
              <div class="form-group">                                  
                  <input type="text" class="form-control" name ="txtgestion" id="txtgestion" placeholder="gestion" required value="" style="display: none;" >
              </div>

              <a class="btn btn-primary " href="#" role="button" id="verificaragregar" name="verificaragregar" style="display: inline;" onclick="verificaragregarseguimiento()">Verificar</a>

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
<div id="modal-editar-seguimiento"  class="darck-popup-block popup-basic admin-form mfp-with-anim mfp-hide popup-lg " >
  <div class="panel">
    <div style="background: #2a2a2c" class="panel-heading">
      <span  class="panel-title"><i style="color: white" class="glyphicon glyphicon-pencil"></i>
      <font style="font-family: sans-serif;color: white">Formulario de Actualización Seguimiento</font>
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
                                  <select id="gestionedit" name="gestion" class="form-control">
                                      <option value="0">Gestion</option> 
                                      <option value="2016">2016</option>
                                      <option value="2017">2017</option>
                                      <option value="2018">2018</option>
                                      <option value="2019">2019</option>
                                      <option value="2020">2020</option>
                                    </select>
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
                                    <td><select id="depseguimientoedit"  class="form-control"><option value="0">Seleccione el Departamento</option>
                                  </select></td>
                                    <td><select id="provseguimientoedit"  name="provseguimiento" class="form-control"><option value="0">Seleccione la Provincia</option>
                                  </select></td>
                                    <td><select id="munseguimientoedit" class="form-control"><option value="0">Seleccione el Município</option>
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
                                <p>
                                  <table border="2" width="100%">                                  
                                  <tr>
                                    <td style="background: #2a2a2c">
                                      <div class="form-group">
                                          <font color="white"><center>Descripción</center></font>                    
                                          <p> <textarea name="descripcion_accion_etaseguimiento_edit" id="descripcion_accion_etaseguimiento_edit" rows="2" cols="5" placeholder="descripción accion eta" style="width: 100%"></textarea></p>                   
                                      </div>      
                                    </td>
                                  </tr>
                                </table>
                                </p>
                                <p>
                                  <select id="pilarseguimientoedit" disabled><option value="0">P</option>
                                  </select>
                                  <select id="metaseguimientoedit" disabled><option value="0">M</option>
                                  </select>
                                  <select id="resultadoseguimientoedit" disabled><option value="0">R</option>
                                  </select>
                                  <select id="accionseguimientoedit" disabled><option value="0">A</option>
                                  </select>
                                  <select class="form-control input-lg" id="descaccionseguimientoedit" disabled><option value="0">las acciones</option></select>
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
                                          <p> <textarea name="ind_proceso_seguimientoedit" id="ind_proceso_seguimientoedit" rows="5" cols="40" placeholder="Indicador Procesos" style="width: 100%"></textarea></p>                   
                                      </div>      
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>                              
                            </tr>
                            <tr>
                              <td  colspan="2" style="background: #2a2a2c;"><font color="white"><center>Seguimiento Presupuesto</center></font></td></tr>
                            </tr>
                            <tr>
                              <td  style="background: #2a2a2c;"><font color="white"><center>Descripcion</center></font></td>
                                    <td><textarea name="txtTotalpresupuestoedit" id="txtTotalpresupuestoedit"value="" style="width: 100%" rows="2" cols="5" ></textarea></td> 
                            </tr>
                            <tr>
                             <td style="background: #2a2a2c;"><font color="white">Presupuesto Ejecutado</font></td>
                                    <td><input type="number" name="txtpresupuestoejecutadoedit" id="txtpresupuestoejecutadoedit"value="0.0" ></td> 
                            </tr>
                            <tr>
                              <td colspan="2"><input type="text" disabled placeholder="Total Presupuesto" value="0.0" id="totalpseguimientoedit" name="totalpseguimientoedit" width="100%" style="visibility: hidden;" ></td>
                            </tr>
                            
                            <tr>
                              <td>                              
                                    <div class="form-group">
                  <input type="text" class="form-control" name ="idcorreedit" id="idcorreedit" placeholder="id" required value="" style="display: none;" >
              </div>           
                                <div class="form-group">                                  
                  <input type="text" class="form-control" name ="txtetaseguimientoedit" id="txtetaseguimientoedit" placeholder="eta" required value="" style="display: none;" >
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" name ="txttipoetaseguimientoedit" id="txttipoetaseguimientoedit" placeholder="eta" required value="" style="display:none ;" >
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name ="txtdepseguimientoedit" id="txtdepseguimientoedit" placeholder="departamento" required value="" style="display:none ;" >
              </div>

              <div class="form-group">
              <input type="text" class="form-control" name="txtprovseguimientoedit" id="txtprovseguimientoedit" placeholder="provincia" required value="" style="display:none ;">
              </div>

              <div class="form-group">
                <input type="text" class="form-control" name="txtmunseguimientoedit" id="txtmunseguimientoedit" placeholder="municipio" required value=""style="display:none ;">
              </div>

              <div class="form-group">
                <input type="text"class="form-control" name="txtgasseguimientoedit" id="txtgasseguimientoedit" placeholder="programatica" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text"class="form-control" name="txtnomgasseguimientoedit" id="txtnomgasseguimientoedit" placeholder="nombre programatica"style="display:none ;" >
              </div>              
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtacciseguimientoedit" id="txtacciseguimientoedit" placeholder="accion" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtnomacciseguimientoedit" id="txtnomacciseguimientoedit" placeholder="descripcion accion" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txttiposeguimientoedit" id="txttiposeguimientoedit" placeholder="descripcion tipo" value="0"style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtservicioseguimientoedit" id="txtservicioseguimientoedit" placeholder="descripcion servicio" value="0"style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtpilarseguimientoedit" id="txtpilarseguimientoedit" placeholder="pilar" value=""style="display:none ;">
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtmetasseguimientoedit" id="txtmetasseguimientoedit" placeholder="meta" value=""style="display:none ;">
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtresulseguimientoedit" id="txtresulseguimientoedit" placeholder="resultados" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtaccionseguimientoedit" id="txtaccionseguimientoedit" placeholder="acciones" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="descripdesseguimientoedit" id="descripdesseguimientoedit" placeholder="pdes" value="" style="display: none;">
              </div>
              <div class="form-group">                                  
                  <input type="text" class="form-control" name ="txtgestionedit" id="txtgestionedit" placeholder="gestion" required value="" style="display:none ;" >
              </div>

             <a class="btn btn-primary " href="#" role="button" id="verificaragregarseguimientoEdit" name="verificaragregarseguimientoEdit" style="display: inline;" onclick="verificaragregarseguimientoEdit()">Verificar</a>

              <button  class="btn btn-primary" id="actualizarseguimientoedit" name="actualizarseguimientoedit" style="display: none;"  >Actualizar</button>
              <button type="button" class="btn btn-success" id="cerraredit" name="cerraredit">Atrás</button>
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
  $("#export").click(function()
      {   
        var hoy = new Date();
        fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
        var hora=hoy.getHours()+':'+hoy.getMinutes()+':'+hoy.getSeconds();
       // alert(fecha+ " "+hora);
        $("#gridseguimiento").jqxGrid('exportdata', 'xls', 'Seguimiento'+fecha+hora, true, null, true);

      });
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
  
 
function sumarPresupu(){
  totpre = parseFloat(document.getElementById('txtTotalpresupuesto').value);
    pa = parseFloat(document.getElementById('txtpresupuestoejecutado').value);
    /*pb = parseFloat(document.getElementById('p2017').value);
    pc = parseFloat(document.getElementById('p2018').value);
    pd = parseFloat(document.getElementById('p2019').value);
    pe = parseFloat(document.getElementById('p2020').value);*/
    tsumpre=pa;
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
         //objeto.cantidad_presupuesto = $("#txtpresu").val();
        objeto.gestion = $("#txtgestion").val();
        objeto.presupuestoejecutadogestion = $("#txtpresupuestoejecutado").val();
        objeto.descripcion_presupuesto_ejecutado = $("#txtTotalpresupuesto").val();        
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
       $("#gestion").change(function(){
        nomges = $("#gestion").val();
        $("#txtgestion").val(nomges);
        if (nomges==0) {
          alert('Seleccione una Gestión')
          
        }
        
      });

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
function verificaragregarseguimiento()
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
    
    totp=$("#totalp").val();
    gesti=$("#txtgestion").val();
    
    lineabase=$("#linea_base").val();
    indipro=$("#ind_proceso").val();
    indican=$("#tipocantidad").val();
   // alert(departam1+"" +provincia1+"" +municipio1+"" +progra1+"" +nomprogra1+"" +accion1+"" +nomaccion1+"" +pilar1+"" +meta1+"" +resultado1+"" +acci1);
if (gesti==undefined||gesti=='0'||gesti=='') {
alert('Seleccione una Gestión.');  
}
else{
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
                                var s=document.getElementById('gestion');
                                s.disabled=true;
                                var t=document.getElementById('txtTotalpresupuesto');
                                t.disabled=true;
                                var u=document.getElementById('txtpresupuestoejecutado');
                                u.disabled=true;
                                
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

    
  }
</script>

<!---------------todo lo de edicion--------------->
    <script type="text/javascript">
      $(function(){
        $("#actualizarseguimientoedit").click(function()
      {  
        
        objeto = {};
        objeto.id_correlativo = $("#idcorreedit").val();
         objeto.id_eta = $("#txtetaseguimientoedit").val();
        objeto.id_tipo_eta = $("#txttipoetaseguimientoedit").val();       
        objeto.id_departamento = $("#txtdepseguimientoedit").val();
        objeto.id_provincia = $("#txtprovseguimientoedit").val();
        objeto.id_municipio = $("#txtmunseguimientoedit").val();
        objeto.pilar = $("#txtpilarseguimientoedit").val();
        objeto.meta = $("#txtmetasseguimientoedit").val();
        objeto.resultado = $("#txtresulseguimientoedit").val();
        objeto.accion = $("#txtaccionseguimientoedit").val();        
        objeto.descripcion_pdes = $("#descripdesseguimientoedit").val();
        objeto.id_programa = $("#txtgasseguimientoedit").val();
        objeto.descripcion_programa = $("#txtnomgasseguimientoedit").val();        
        objeto.id_accion_eta = $("#txtacciseguimientoedit").val();
        objeto.descripcion_accion_eta = $("#txtnomacciseguimientoedit").val();
        objeto.indicador_procesos = $("#ind_proceso_seguimientoedit").val();
        objeto.descripcion_accion_eta_prog = $("#descripcion_accion_etaseguimiento_edit").val();
         objeto.gestion = $("#txtgestionedit").val();
        objeto.presupuestoejecutadogestion = $("#txtpresupuestoejecutadoedit").val();
        objeto.descripcion_presupuesto_ejecutado = $("#txtTotalpresupuestoedit").val();
        objeto.id_clasificador = $("#txttiposeguimientoedit").val();
        objeto.id_servicio = $("#txtservicioseguimientoedit").val();        
        objeto._token = $('input[name=_token]').val();
      // alert(objeto.id_eta);
         
        try {        
            if (objeto) 
            {
             $.get("actualizarmatrizSeguimiento/"+objeto.id_correlativo, objeto, function(respuesta)
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
    $(function()
    {
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
                  { name: 'descripcion_eta',type:'datafield'},
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
                  { name: 'gestion', type: 'int'},
                  { name: 'presupuestoejecutadogestion', type: 'numeric'},
                  { name: 'descripcion_presupuesto_ejecutado', type: 'numeric'},
                  
                  { name: 'competencia', type: 'numeric'},
                  { name: 'NCE', type: 'numeric'},
                  { name: 'GAD', type: 'numeric'},
                  { name: 'GAM', type: 'numeric'},                  
                  { name: 'id_clasificador', type: 'datafield'},       
                  { name: 'descripcion_clasificador', type: 'datafield'},
                  { name: 'id_servicio', type: 'datafield'}, 
                  { name: 'total_presupuestogestion', type: 'datafield'},       
                  { name: 'pagado', type: 'datafield'},  
                  { name: 'saldo_pagar', type: 'datafield'},  
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
              theme: 'shinyblack',
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
               { text: 'ETA', filtercondition: 'starts_with', datafield: 'descripcion_eta', width: 100},
                 { text: 'DEP',filtercondition: 'starts_with', datafield: 'descripcion_departamento', width: 80},
                 { text: 'PROV', filtercondition: 'starts_with',datafield: 'descripcion_provincia',   width: 80 },
                 { text: 'MUN', filtercondition: 'starts_with',datafield: 'descripcion_municipio',   width: 80 },
                { text: 'P', filtertype: 'checkedlist',datafield: 'pilar',   width: 40 },
                 { text: 'M', filtertype: 'checkedlist',datafield: 'meta',   width: 40 },
                 { text: 'R', filtertype: 'checkedlist',datafield: 'resultado',   width: 40 },
                 { text: 'A', filtertype: 'checkedlist',datafield: 'accion',   width: 40 },
                 { text: 'PDES', filtercondition: 'starts_with',datafield: 'descripcion_pdes',   width: 180 },
                 { text: '', filtercondition: 'starts_with',datafield: 'id_programa',   width: 40 },
                 { text: 'ESTRUCUTRA PROGRAMÁTICA', filtercondition: 'starts_with',datafield: 'descripcion_programa',   width: 270 },
                 { text: '', filtercondition: 'starts_with',datafield: 'id_accion_eta',   width: 40 },
                 { text: 'ACCION ESTANDAR ETA', filtercondition: 'starts_with',datafield: 'descripcion_accion_eta',   width: 270 },
                 { text: 'DESCRIPCION ACCION ESTANDAR ETA', filtercondition: 'starts_with',datafield: 'descripcion_accion_eta_prog',   width: 200 },
                 { text: 'INDICADOR PROCESO',filtercondition: 'starts_with',datafield: 'indicador_procesos',   width: 200 },
                 { text: 'SERVICIO',filtercondition: 'starts_with',datafield: 'descripcion_servicio',   width: 80 },
                 { text: 'CLASIFICADOR',filtercondition: 'starts_with',datafield: 'descripcion_clasificador',   width: 80 },
                 { text: 'GESTION',filtertype: 'checkedlist',datafield: 'gestion',   width: 100 },
                 { text: 'DESC PRES', filtercondition: 'starts_with',datafield: 'descripcion_presupuesto_ejecutado',   width: 100 }, 
                 { text: 'VIGENTE', filtercondition: 'starts_with',datafield: 'total_presupuestogestion',aggregates: ["sum"],   width: 100 },
                 { text: 'PAGADO', filtercondition: 'starts_with',datafield: 'pagado',aggregates: ["sum"],   width: 100 },
                 { text: 'SALDO', filtercondition: 'starts_with',datafield: 'saldo_pagar',aggregates: ["sum"],   width: 100 },

                 { text: 'EJECUTADO', filtercondition: 'starts_with',datafield: 'presupuestoejecutadogestion',aggregates: ["sum"],   width: 100 },
                  
                 { text: 'ACCIONES', datafield: 'id_correlativo',   width: 200, cellsRenderer: function (row, column, value, rowData)  
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
                 $("#gestionedit").val(filaseleccionada.gestion);
                 $("#gestionedit").trigger( "change");
                 $("#etaseguimientoedit").val(filaseleccionada.id_eta); 
                 $("#etaseguimientoedit").trigger( "change");
                 $("#depseguimientoedit").val(filaseleccionada.id_departamento);
                 setTimeout(function(){
                 $("#tipoetaseguimientoedit").val(filaseleccionada.id_tipo_eta);
                 $("#tipoetaseguimientoedit").trigger( "change");
                 }, 570);            
                 setTimeout(function(){
                 $("#depseguimientoedit").trigger( "change");
                 }, 730);
                 setTimeout(function(){
                    var x=filaseleccionada.id_provincia;
                    $("#provseguimientoedit").val(x);    
                    $("#provseguimientoedit").trigger( "change");
                 }, 920);
                 setTimeout(function(){
                    var y=filaseleccionada.id_municipio;
                     $("#munseguimientoedit").val(y);    
                     $("#munseguimientoedit").trigger( "change");
                 }, 1020);
                 setTimeout(function(){
                    var y=filaseleccionada.id_programa;
                     $("#gasseguimientoedit").val(y);    
                     $("#gasseguimientoedit").trigger( "change");
                 }, 1220);
                 
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
                              var y=filaseleccionada.pilar;
                              $("#pilarseguimientoedit").val(y);    
                              $("#pilarseguimientoedit").trigger( "change");
                          }, 3320);

                        }
                      else
                        {
                          setTimeout(function(){
                              var z=filaseleccionada.id_accion_eta;
                              $("#acciseguimientoedit").val(z);    
                              $("#acciseguimientoedit").trigger( "change");
                          }, 2820);
                          setTimeout(function(){
                              var y=filaseleccionada.pilar;
                              $("#pilarseguimientoedit").val(y);    
                              $("#pilarseguimientoedit").trigger( "change");
                          }, 3320);
                          
                        }
                    }
                 else
                 { 
                 alert('no existen registros')                     ;
                 }
                 setTimeout(function(){
                      var o=filaseleccionada.descripcion_accion_eta_prog;
                      $("#descripcion_accion_etaseguimiento_edit").val(o);    
                      
                      var b=filaseleccionada.indicador_procesos;
                      $("#ind_proceso_seguimientoedit").val(b);
                      var i=filaseleccionada.descripcion_presupuesto_ejecutado;
                      $("#txtTotalpresupuestoedit").val(i);
                      var j=filaseleccionada.presupuestoejecutadogestion;
                      $("#txtpresupuestoejecutadoedit").val(j);
                      /*var k=filaseleccionada.presupuesto2017;
                      $("#p2017seguimientoedit").val(k);
                      var l=filaseleccionada.presupuesto2018;
                      $("#p2018seguimientoedit").val(l);
                      var m=filaseleccionada.presupuesto2019;
                      $("#p2019seguimientoedit").val(m);
                      var n=filaseleccionada.presupuesto2020;
                      $("#p2020seguimientoedit").val(n);*/
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
                       $.get("eliminarmatrizSeguimiento/"+objeto.id_correlativo, objeto, function(respuesta)
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

function sumarPresupuesegdit(){
  totpre = parseFloat(document.getElementById('txtTotalpresupuestoedit').value);
    pa = parseFloat(document.getElementById('txtpresupuestoejecutadoedit').value);
    /*pb = parseFloat(document.getElementById('p2017seguimientoedit').value);
    pc = parseFloat(document.getElementById('p2018seguimientoedit').value);
    pd = parseFloat(document.getElementById('p2019seguimientoedit').value);
    pe = parseFloat(document.getElementById('p2020seguimientoedit').value);*/
    tsumpre=pa;//+pb+pc+pd+pe;
    document.getElementById('totalpseguimientoedit').value = totpre-tsumpre;
}
</script>
<script type="text/javascript">
    $(function()
    {
//--------------botonguardar
 $("#gestionedit").change(function(){
        nomges = $("#gestionedit").val();
        $("#txtgestionedit").val(nomges);
        if (nomges==0) {
          alert('Seleccione una Gestión')
          
        }
        
      });

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
                    }, 1300);
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
          $("#pilarseguimientoedit").html('');
          $("#metaseguimientoedit").html('');
          $("#resultadoseguimientoedit").html('');
          $("#accionseguimientoedit").html('');
          $("#descaccionseguimientoedit").html('');          
        }
        else
        {
          if (ideta==1||ideta==2) 
          {
            $("#tipseguimientoedit").html('');
            $("#txttiposeguimientoedit").val('0');
            $("#serseguimientoedit").html('');
            $("#txtservicioseguimientoedit").val('0');
            $("#pilarseguimientoedit").html('');
          $("#metaseguimientoedit").html('');
          $("#resultadoseguimientoedit").html('');
          $("#accionseguimientoedit").html('');
          $("#descaccionseguimientoedit").html('');  
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
                  $("#pilarseguimientoedit").html('<option>P</option>');
                  $("#metaseguimientoedit").html('<option>M</option>');
                  $("#resultadoseguimientoedit").html('<option>R</option>');
                  $("#accionseguimientoedit").html('<option>A</option>');       
                  $("#descaccionseguimientoedit").html('');
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
                    $("#pilarseguimientoedit").html('<option>P</option>');
                  $("#metaseguimientoedit").html('<option>M</option>');
                  $("#resultadoseguimientoedit").html('<option>R</option>');
                  $("#accionseguimientoedit").html('<option>A</option>');       
                    $("#descaccionseguimientoedit").html('');
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
          $("#pilarseguimientoedit").html('<option>P</option>');
                  $("#metaseguimientoedit").html('<option>M</option>');
                  $("#resultadoseguimientoedit").html('<option>R</option>');
                  $("#accionseguimientoedit").html('<option>A</option>');
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
          $("#pilarseguimientoedit").html('<option>P</option>');
                  $("#metaseguimientoedit").html('<option>M</option>');
                  $("#resultadoseguimientoedit").html('<option>R</option>');
                  $("#accionseguimientoedit").html('<option>A</option>');
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
          $("#pilarseguimientoedit").html('');
          $("#metaseguimientoedit").html('');
          $("#resultadoseguimientoedit").html('');
          $("#accionseguimientoedit").html('');
          $("#descaccionseguimientoedit").html('');
        }
        else
        {
            $.get("listarPilaresSeguimientoedit/" + idaccion, function(respuesta)
            {
              var acciones = respuesta.acciones;
              $("#pilarseguimientoedit").html('');
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_pilar + "</option>";           
                $("#pilarseguimientoedit").append(opcion);
                numpil =  $('#pilarseguimientoedit').find('option:selected').text();
                $("#txtpilarseguimientoedit").val(numpil);
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
                nummeta =  $('#metaseguimientoedit').find('option:selected').text();
                $("#txtmetasseguimientoedit").val(nummeta);
              }
            });
            $.get("listarResultados/" + idaccion, function(respuesta)
            {
            var acciones = respuesta.acciones;
            $("#resultadoseguimientoedit").html('');
            for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_resultado + "</option>";           
                $("#resultadoseguimientoedit").append(opcion);
                 numresul =  $('#resultadoseguimientoedit').find('option:selected').text();
                $("#txtresulseguimientoedit").val(numresul);
              }
            });
            $.get("listarAccionesEtas/" + idaccion, function(respuesta)
            {
              var acciones = respuesta.acciones;
              $("#accionseguimientoedit").html('');
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_accion + "</option>";           
                $("#accionseguimientoedit").append(opcion);
                numaccion =  $('#accionseguimientoedit').find('option:selected').text();
                $("#txtaccionseguimientoedit").val(numaccion);
                
              }
              $("#accionseguimientoedit").trigger( "change" );  
            });  
        }       
      });
//--------------cuando cambia la provincias
      $("#accionseguimientoedit").change(function()
      {
        idpilar=$("#txtpilarseguimientoedit").val();        
        idmeta=$("#txtmetasseguimientoedit").val();
        idresultado=$("#txtresulseguimientoedit").val();
        idaccion=$("#txtaccionseguimientoedit").val();
        //alert(idpilar+" "+ idmeta+" "+idresultado+" "+idaccion);
        $.get("listarSeguimientoPMRAs/"+ idpilar+"/"+idmeta+"/"+idresultado+"/"+idaccion, function(respuesta)
        {
          var acciones = respuesta.acciones;
          $("#descaccionseguimientoedit").html('');
          for(var i=0; i<acciones.length; i++)
          {
            var accion = acciones[i];              
            var opcion = "<option value=" + accion.id_correlativo + ">" + accion.descripcion_directriz + "</option>";           
            $("#descaccionseguimientoedit").append(opcion);
            nomaccio =  $('#descaccionseguimientoedit').find('option:selected').text();
            $("#descripdesseguimientoedit").val(nomaccio);
          }
        });        
      });
    });
 </script> 
 <script>
function verificaragregarseguimientoEdit()
  {
    departam1 = $("#txtdepseguimientoedit").val();
    provincia1 = $("#txtprovseguimientoedit").val();
    municipio1 = $("#txtmunseguimientoedit").val();
    progra1 = $("#txtgasseguimientoedit").val();
    nomprogra1 = $("#txtnomgasseguimientoedit").val();
    accion1 = $("#txtacciseguimientoedit").val();
    nomaccion1 = $("#txtnomacciseguimientoedit").val();
    pilar1 = $("#txtpilarseguimientoedit").val();
    meta1 = $("#txtmetasseguimientoedit").val();
    resultado1 = $("#txtresulseguimientoedit").val();
    acci1 = $("#txtaccionseguimientoedit").val();    
    totp=$("#totalpseguimientoedit").val();        
    indipro=$("#ind_proceso_seguimientoedit").val();
    gest=$("#txtgestionedit").val();
    
if (gest==undefined||gest=='0'||gest=='') {
    alert('Seleccione una Gestión.');  
    }
    else{
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
                                var x = document.getElementById('actualizarseguimientoedit');
                                var y = document.getElementById('verificaragregarseguimientoEdit');
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
                                
                               var k=document.getElementById('ind_proceso_seguimientoedit');
                                k.disabled=true;
                                
                                
                               var s=document.getElementById('gestionedit');
                                s.disabled=true;
                                var t=document.getElementById('txtTotalpresupuestoedit');
                                t.disabled=true;
                                var u=document.getElementById('txtpresupuestoejecutadoedit');
                                u.disabled=true;
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
</script>
@endpush
