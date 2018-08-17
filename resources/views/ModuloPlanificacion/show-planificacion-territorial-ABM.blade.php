@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.dark.css" type="text/css" />
@endsection

@section('title-topbar')

@endsection

@section('content')
 
<table>
  <tr>    
      <th><h2>Sistema de Planificacion Territorial</h2></th>
  </tr>        
  <tr>
    <tr>
      <td><button id="agregarmatriz" name="agregarmatriz"><i class='glyphicon glyphicon-plus'>Agregar</i></button> </td>

    </tr>
    <td>
      <div id='contenedor'>
        <div id="grid2"></div>
        <div style="margin-top: 30px;">
            <div id="cellbegineditevent"></div>
            <div style="margin-top: 10px;" id="cellendeditevent"></div>
        </div>       
      </div>
    </td>
  </tr>
</table>
<div id="modal-editar"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide popup-lg " >
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
                                  <select id="etaedit" class="form-control"><option value="0">Seleccione el ETA</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="depedit" class="form-control"><option value="0">Seleccione el Departamento</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="provedit" name="provedit" class="form-control"><option value="0">Seleccione la Provincia</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="munedit"class="form-control"><option value="0">Seleccione el Município</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="gasedit"class="form-control input-lg"><option value="0">Seleccione la Programática de Gasto</option></select>
                                </p>
                                <p>
                                  <select id="tipedit"class="form-control"><option value="0">Seleccione el Tipo</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="seredit"class="form-control"><option value="0">Seleccione el Servicio</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="acciedit"class="form-control input-lg"><option value="0">Seleccione la Accion ETA</option>
                                  </select>
                                </p>
                                <div class="form-group">
  <p> <textarea name="descripcion_accion_eta_edit" id="descripcion_accion_eta_edit" rows="2" cols="5" placeholder="descripción accion eta" style="width: 50%"></textarea></p>    
</div>
                                <p>
                                  <select id="pilaredit" disabled><option value="0">P</option>
                                  </select>
                                  <select id="metaedit" disabled><option value="0">M</option>
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
                      <td style="background: #0074e8">
                        <div class="form-group">
                            <font color="white"><center>Linea Base</center></font>                    
                            <p> <textarea name="linea_baseedit" id="linea_baseedit" rows="10" cols="40" placeholder="Linea Base" style="width: 100%"></textarea></p>                   
                        </div>      
                      </td>
                      <td style="background: #0074e8">
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
                                    <td  colspan="2" style="background: #0074e8;"><font color="white"><center>Unidad</center> </font></td></tr>
                                  <tr >                           
                                  <tr>
                                    <td  style="background: #0074e8;"><font color="white">Cantidad de Unidad</font></td>
                                    <td><input type="text" name="cantidadedit" id="cantidadedit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="cantidad" onchange="sumaredit()"value="0"/></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2016</font></td>
                                    <td><input type="number" name="2016edit" id="2016edit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="2016" onchange="sumaredit()"value="0" ></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2017</font></td>
                                    <td><input type="number" name="2017edit" id="2017edit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="2017" onchange="sumaredit()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2018</font></td>
                                    <td><input type="number" name="2018edit" id="2018edit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="2018" onchange="sumaredit()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2019</font></td>
                                    <td><input type="number" name="2019edit" id="2019edit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="2019" onchange="sumaredit()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2020</font></td>
                                    <td><input type="number" name="2020edit" id="2020edit" onKeyDown="sumaredit();" onKeyUp="sumaredit();" onkeypress="sumaredit();" placeholder="2020" onchange="sumaredit()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">Resto</font></td>
                                    <td><input type="text" value="0" disabled placeholder="total" id="totaledit"></td>
                                    
                                  </tr>
                                </table>
                              </td>
                              <td>
                                <table border="3">                                  
                                  <tr >
                                    <td  colspan="2" style="background: #0074e8;"><font color="white"><center>Presupuesto</center></font></td></tr>
                                  <tr >
                                    <td style="background: #0074e8;"><font color="white">Presupuesto 2016-2020</font></td>
                                    <td><input type="number" name="txtpresuedit" id="txtpresuedit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2016" onchange="sumarPresupuedit()"value="0.0" ></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2016</font></td>
                                    <td><input type="number" name="p2016edit" id="p2016edit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2016" onchange="sumarPresupuedit()" value="0.0" ></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2017</font></td>
                                    <td><input type="number" name="p2017edit" id="p2017edit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2017" onchange="sumarPresupuedit()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2018</font></td>
                                    <td><input type="number" name="p2018edit" id="p2018edit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2018" onchange="sumarPresupuedit()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2019</font></td>
                                    <td><input type="number" name="p2019edit" id="p2019edit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2019" onchange="sumarPresupuedit()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2020</font></td>
                                    <td><input type="number" name="p2020edit" id="p2020edit" onKeyDown="sumarPresupuedit();" onKeyUp="sumarPresupuedit();" onkeypress="sumarPresupuedit();" placeholder="2020" onchange="sumarPresupuedit()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">Resto</font></td>
                                    <td><input type="text" disabled placeholder="Total Presupuesto" value="0.0" id="totalpedit" name="totalpedit"></td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                              <div class="form-group">
                  <input type="text" class="form-control" name ="idcorreedit" id="idcorreedit" placeholder="id" required value="" style="display:none ;" >
              </div>
                                <div class="form-group">
                  <input type="text" class="form-control" name ="txtetaedit" id="txtetaedit" placeholder="eta" required value="" style="display:none ;" >
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name ="txtdepedit" id="txtdepedit" placeholder="departamento" required value="" style="display:none ;" >
              </div>
              <div class="form-group">
                <!--label for="prov">provincia</label-->
              <input type="text" class="form-control" name="txtprovedit" id="txtprovedit" placeholder="provincia" required value="" style="display:none ;">
              </div>

              <div class="form-group">
                <!--label for="mun">municipio</label-->
                <input type="text" class="form-control" name="txtmunedit" id="txtmunedit" placeholder="municipio" required value=""style="display:none ;">
              </div>

              <div class="form-group">
                <!--label for="prog">programatica</label-->
                <input type="text"class="form-control" name="txtgasedit" id="txtgasedit" placeholder="programatica" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <!--label for="nom_prog">detalle programatica</label-->
                <input type="text"class="form-control" name="txtnomgasedit" id="txtnomgasedit" placeholder="nombre programatica"style="display:none ;" >
              </div>              
              <div class="form-group">
                <!--label for="acc">accion</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtacciedit" id="txtacciedit" placeholder="accion" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <!--label for="descrip_acc">descripcion accion</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtnomacciedit" id="txtnomacciedit" placeholder="descripcion accion" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txttipoedit" id="txttipoedit" placeholder="descripcion tipo" value="0"style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtservicioedit" id="txtservicioedit" placeholder="descripcion servicio" value="0"style="display: none;">
              </div>
              <div class="form-group">
                <!--label for="idpilar"> pilar</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtpilaredit" id="txtpilaredit" placeholder="pilar" value=""style="display:none ;">
              </div>
              <div class="form-group">
                  <!--label for="metas">pdes</label-->
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtmetasedit" id="txtmetasedit" placeholder="meta" value=""style="display: none;">
              </div>
              <div class="form-group">
                  <!--label for="resultados">pdes</label-->
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtresuledit" id="txtresuledit" placeholder="resultados" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <!--label for="acciones">pdes</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtaccionedit" id="txtaccionedit" placeholder="acciones" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <!--label for="acciones">pdes</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="descripaccionedit" id="descripaccionedit" placeholder="pdes" value="" style="display:none ;">
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
        <!--div class="panel-footer">
          <button type="submit" class="button btn-primary">Validar y Guardar</button>
        </div-->
    
  </div>  
</div>

<div id="modal-agregar"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide popup-lg " >
  <div class="panel">
    <div class="panel-heading">
      <span class="panel-title"><i class="fa fa-pencil"></i>
      <font style="font-family: sans-serif;color: black">Formulario de Actualización</font>
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
                                  <select id="eta" class="form-control"><option value="0">Seleccione el ETA</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="dep" class="form-control"><option value="0">Seleccione el Departamento</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="prov" name="prov" class="form-control"><option value="0">Seleccione la Provincia</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="mun"class="form-control"><option value="0">Seleccione el Município</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="gas"class="form-control input-lg"><option value="0">Seleccione la Programática de Gasto</option></select>
                                </p>
                                <p>
                                  <select id="tip"class="form-control"><option value="0">Seleccione el Tipo</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="ser"class="form-control"><option value="0">Seleccione el Servicio</option>
                                  </select>
                                </p>
                                <p>
                                  <select id="acci"class="form-control input-lg"><option value="0">Seleccione la Accion ETA</option>
                                  </select>
                                </p>
                                <div class="form-group">
  <p> <textarea name="descripcion_accion_eta" id="descripcion_accion_eta" rows="2" cols="5" placeholder="descripción accion eta" style="width: 50%"></textarea></p>    
</div>
                                <p>
                                  <select id="pilar" disabled><option value="0">P</option>
                                  </select>
                                  <select id="meta" disabled><option value="0">M</option>
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
                      <td style="background: #0074e8">
                        <div class="form-group">
                            <font color="white"><center>Linea Base</center></font>                    
                            <p> <textarea name="linea_base" id="linea_base" rows="10" cols="40" placeholder="Linea Base" style="width: 100%"></textarea></p>                   
                        </div>      
                      </td>
                      <td style="background: #0074e8">
                        <div class="form-group"><font color="white"><center>
                         Indicador de Proceso:</center></font>                    
                          <p> <textarea name="ind_proceso" id="ind_proceso" rows="10" cols="40" placeholder="Indicador de Proceso" style="width: 100%"></textarea></p>                   
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
                                      <input type="text" name="tipocantidad" id="tipocantidad" maxlength="5" >
                                     </p>
                                    </td>
                                  </tr>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <table border="3">    
                                   <tr >
                                    <td  colspan="2" style="background: #0074e8;"><font color="white"><center>Unidad</center> </font></td></tr>
                                  <tr >                           
                                  <tr>
                                    <td  style="background: #0074e8;"><font color="white">Cantidad de Unidad</font></td>
                                    <td><input type="text" name="cantidad" id="cantidad" onKeyDown="sumar();" onKeyUp="sumar();" onkeypress="sumar();" placeholder="cantidad" onchange="sumar()"value="0"/></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2016</font></td>
                                    <td><input type="number" name="2016" id="2016" onKeyDown="sumar();" onKeyUp="sumar();" onkeypress="sumar();" placeholder="2016" onchange="sumar()"value="0" ></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2017</font></td>
                                    <td><input type="number" name="2017" id="2017" onKeyDown="sumar();" onKeyUp="sumar();" onkeypress="sumar();" placeholder="2017" onchange="sumar()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2018</font></td>
                                    <td><input type="number" name="2018" id="2018" onKeyDown="sumar();" onKeyUp="sumar();" onkeypress="sumar();" placeholder="2018" onchange="sumar()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2019</font></td>
                                    <td><input type="number" name="2019" id="2019" onKeyDown="sumar();" onKeyUp="sumar();" onkeypress="sumar();" placeholder="2019" onchange="sumar()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2020</font></td>
                                    <td><input type="number" name="2020" id="2020" onKeyDown="sumar();" onKeyUp="sumar();" onkeypress="sumar();" placeholder="2020" onchange="sumar()"value="0"></td>
                                    
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">Resto</font></td>
                                    <td><input type="text" value="0" disabled placeholder="total" id="total"></td>
                                    
                                  </tr>
                                </table>
                              </td>
                              <td>
                                <table border="3">                                  
                                  <tr >
                                    <td  colspan="2" style="background: #0074e8;"><font color="white"><center>Presupuesto</center></font></td></tr>
                                  <tr >
                                    <td style="background: #0074e8;"><font color="white">Presupuesto 2016-2020</font></td>
                                    <td><input type="number" name="txtpresu" id="txtpresu" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="2016" onchange="sumarPresupu()"value="0.0" ></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2016</font></td>
                                    <td><input type="number" name="p2016" id="p2016" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="2016" onchange="sumarPresupu()" value="0.0" ></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2017</font></td>
                                    <td><input type="number" name="p2017" id="p2017" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="2017" onchange="sumarPresupu()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2018</font></td>
                                    <td><input type="number" name="p2018" id="p2018" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="2018" onchange="sumarPresupu()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2019</font></td>
                                    <td><input type="number" name="p2019" id="p2019" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="2019" onchange="sumarPresupu()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
                                    <td><font color="white">2020</font></td>
                                    <td><input type="number" name="p2020" id="p2020" onKeyDown="sumarPresupu();" onKeyUp="sumarPresupu();" onkeypress="sumarPresupu();" placeholder="2020" onchange="sumarPresupu()" value="0.0"></td>
                                  </tr>
                                  <tr style="background: #0074e8;">
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
                  <input type="text" class="form-control" name ="txteta" id="txteta" placeholder="eta" required value="" style="display: none;" >
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name ="txtdep" id="txtdep" placeholder="departamento" required value="" style="display:none ;" >
              </div>

              <div class="form-group">
              <input type="text" class="form-control" name="txtprov" id="txtprov" placeholder="provincia" required value="" style="display: none;">
              </div>

              <div class="form-group">
                <input type="text" class="form-control" name="txtmun" id="txtmun" placeholder="municipio" required value=""style="display:none ;">
              </div>

              <div class="form-group">
                <input type="text"class="form-control" name="txtgas" id="txtgas" placeholder="programatica" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text"class="form-control" name="txtnomgas" id="txtnomgas" placeholder="nombre programatica"style="display:none ;" >
              </div>              
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtacci" id="txtacci" placeholder="accion" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtnomacci" id="txtnomacci" placeholder="descripcion accion" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txttipo" id="txttipo" placeholder="descripcion tipo" value="0"style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtservicio" id="txtservicio" placeholder="descripcion servicio" value="0"style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtpilar" id="txtpilar" placeholder="pilar" value=""style="display:none ;">
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtmetas" id="txtmetas" placeholder="meta" value=""style="display:none ;">
              </div>
              <div class="form-group">
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtresul" id="txtresul" placeholder="resultados" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtaccion" id="txtaccion" placeholder="acciones" value=""style="display:none ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="descripaccion" id="descripaccion" placeholder="pdes" value="" style="display:none ;">
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
@endsection

@push('script-head')
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />
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
  $("#agregarmatriz").click(function()
    { 
       //location.href ="/moduloplanificacion/AgregarPlanificacionTerritorial";
       $.magnificPopup.open(
              {
               removalDelay: 500,                     
               focus: '#nombreinput',
               items: 
                {
                  src: "#modal-agregar"
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
        objeto.id_tarea_eta = $("#txteta").val();
        objeto.id_departamento = $("#txtdep").val();
        objeto.id_provincia = $("#txtprov").val();
        objeto.id_municipio = $("#txtmun").val();
        objeto.id_programa = $("#txtgas").val();
        objeto.id_clasificador = $("#txttipo").val();
        objeto.id_servicio = $("#txtservicio").val();
        objeto.descripcion_programa = $("#txtnomgas").val();
        objeto.id_accion_eta = $("#txtacci").val();
        objeto.accion_eta = $("#txtnomacci").val();
        objeto.linea_base = $("#linea_base").val();
        objeto.proceso_indicador = $("#ind_proceso").val();
        objeto.unidad_indicador = $("#tipocantidad").val();
        objeto.cantidad_indicador = $("#cantidad").val();
        objeto.indicador2016 = $("#2016").val();
        objeto.indicador2017 = $("#2017").val();
        objeto.indicador2018 = $("#2018").val();
        objeto.indicador2019 = $("#2019").val();
        objeto.indicador2020 = $("#2020").val();
        objeto.cantidad_presupuesto = $("#txtpresu").val();
        objeto.presupuesto2016 = $("#p2016").val();
        objeto.presupuesto2017 = $("#p2017").val();
        objeto.presupuesto2018 = $("#p2018").val();
        objeto.presupuesto2019 = $("#p2019").val();
        objeto.presupuesto2020 = $("#p2020").val();
        objeto.pilar = $("#txtpilar").val();
        objeto.meta = $("#txtmetas").val();
        objeto.resultado = $("#txtresul").val();
        objeto.accion = $("#txtaccion").val();        
        objeto.descripcion_accion = $("#descripaccion").val();        
        objeto.descripcion_accion_eta = $("#descripcion_accion_eta").val();  
        objeto._token = $('input[name=_token]').val()
        console.log(objeto);
        //---------------------aqui esta el try de la insercion
        var message;
    //message = document.getElementById("p01");
    //message.innerHTML = "";
    
    try { 
        if (objeto) {
         $.post("insertarmatriz", objeto, function(respuesta){
          alert('informacion guardada');
          location.reload();
          location.href ="/moduloplanificacion/showPlanificacionTerritorial";
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
          $("#eta").append(opcion);
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
          $("#dep").append(opcion);
        }
        console.log(departamentos);
      });
//--------------cuando cambia el departamento
      $("#dep").change(function(){
        iddepar = $("#dep").val();
        $("#txtdep").val(iddepar);
        if (iddepar==0) {
          $("#prov").html('<option>Seleccione la Provincia</option>');
          $("#mun").html('<option>Seleccione la Município</option>');
          
        }else
        {
           $.get("listarProvincias/" + iddepar, function(respuesta){
              var provincias = respuesta.provincias;
              $("#prov").html('');

                var opcion0 = "<option value=0>Seleccione la Provincia</option>";
                $("#prov").append(opcion0);
              for(var i=0; i<provincias.length; i++)
              {
                var provincia = provincias[i];
                var opcion = "<option value=" + provincia.id_provincia + ">" + provincia.descripcion_provincia + "</option>";
                $("#prov").append(opcion);
              }
          }); 
        }
      });
  //--------------cuando cambia la provincias
      $("#prov").change(function(){
        iddepar = $("#dep").val();
        idprov = $("#prov").val();
        $("#txtprov").val(idprov);
        if (idprov==0) {
          $("#mun").html('<option>Seleccione la Município</option>');
        }else
        {
            $.get("listarMunicipios/" + iddepar+"/"+idprov, function(respuesta){
              var municipios = respuesta.municipios;
              $("#mun").html('');
              var opcion0 = "<option value=0>Seleccione el Municipio</option>";
              $("#mun").append(opcion0);
              for(var i=0; i<municipios.length; i++)
              {
                var municipio = municipios[i];              
                var opcion = "<option value=" + municipio.id_municipio + ">" + municipio.descripcion_municipio + "</option>";           
                $("#mun").append(opcion);
                
              }
            });
        }        
      });
      //--------------cuando cambia la provincias
      $("#mun").change(function(){
        
        idmun = $("#mun").val();
        $("#txtmun").val(idmun);
               
      });
      //--------------cuando cambia la eta
      $("#eta").change(function(){
        ideta = $("#eta").val();    
        $("#txteta").val(ideta);      
        if (ideta==0) 
        {
          $("#gas").html('<option >Seleccione la Programática de Gasto</option>');
          $("#tip").html('');
          $("#ser").html('');
          $("#acci").html('');
          $("#pilar").html('');
          $("#meta").html('');
          $("#resultado").html('');
          $("#accion").html('');
        }
        else        
        {
          if(ideta==1||ideta==2)
          {
              $.get("listarGastos1" , function(respuesta){
              var gastos = respuesta.gastos;
              $("#gas").html('');
              var opcion0 = "<option value='-1'>Seleccione la Programática de Gasto</option>";
              $("#gas").append(opcion0);
              for(var i=0; i<gastos.length; i++)
              {
                var gasto = gastos[i];              
                var opcion = "<option value=" + gasto.id_programa + ">" + gasto.descripcion_gasto + "</option>";           
                $("#gas").append(opcion);
              }
            });
          }
          else 
          {
              $.get("listarGastos2" , function(respuesta){
              var gastos = respuesta.gastos;
              $("#gas").html('');
              var opcion0 = "<option value='-1'>Seleccione la Programática de Gasto</option>";
              $("#gas").append(opcion0);
              for(var i=0; i<gastos.length; i++)
              {
                var gasto = gastos[i];              
                var opcion = "<option value=" + gasto.codigo + ">" + gasto.descripcion_gasto + "</option>";           
                $("#gas").append(opcion);
              }
            });

          }
            
        }
        
      });
      //--------------cuando cambia la gasto
      $("#gas").change(function(){
        idgasto = $("#gas").val();
        idnomgasto = $('#gas').find('option:selected').text();
        //alert(idnomgasto);
        ideta = $("#eta").val();
        $("#txtgas").val(idgasto);
        $("#txtnomgas").val(idnomgasto);
        if (idgasto==-1) {
          $("#tip").html('');
          $("#ser").html('');
          $("#acci").html('');         
          $("#pilar").html('');
          $("#meta").html('');
          $("#resultado").html('');
          $("#accion").html('');
          
        }else
        {
          if (ideta==1||ideta==2) 
          {
            $("#tip").html('');
           $("#txttipo").val('0');
            $("#ser").html('');
            $("#txtservicio").val('0');
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
                    $.get("listarTipos/" + idgasto, function(respuesta){
                  var tipos = respuesta.tipos;
                  $("#tip").html('');
                  $("#pilar").html('<option>P</option>');
                  $("#meta").html('<option>M</option>');
                  $("#resultado").html('<option>R</option>');
                  $("#accion").html('<option>A</option>');          
                  $("#descaccion").html('');
                  var opcion0 = "<option value=0>Seleccione el Tipo </option>";
                  $("#tip").append(opcion0);
                  for(var i=0; i<tipos.length; i++)
                  {
                    var tipo = tipos[i];              
                    var opcion = "<option value=" + tipo.id_clasificador + ">" + tipo.descripcion_clasificador + "</option>";
                    $("#tip").append(opcion);
                  }
                });
              }
              else
              {
                  $.get("listarAcciones2/" + idgasto, function(respuesta){
                  var acciones = respuesta.acciones;
                  $("#acci").html('');
                  $("#tip").html('');
                  $("#txttipo").val('0');
                  $("#ser").html('');
                  $("#txtservicio").val('0');
                  $("#pilar").html('<option>P</option>');
                  $("#meta").html('<option>M</option>');
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
      $("#tip").change(function(){
        idgasto = $("#gas").val();
        idtip = $("#tip").val();
        $("#txttipo").val(idtip);
        if (idtip==0) {
          $("#ser").html('');
          $("#txtservicio").val('0');
          $("#acci").html('');
          $("#pilar").html('');
          $("#meta").html('');
          $("#resultado").html('');
          $("#accion").html('');
        }else
        {
          $.get("listarServicios/" + idgasto+"/"+idtip, function(respuesta){
                  var servicios = respuesta.servicios;
                  $("#acci").html('');                  
                  $("#ser").html('');
                  var opcion0 = "<option value=0>Seleccione el Servicio</option>";
                  $("#ser").append(opcion0);
                  for(var i=0; i<servicios.length; i++)
                  {
                    var servicio = servicios[i];              
                    var opcion = "<option value=" + servicio.id_servicio + ">" + servicio.descripcion_servicio + "</option>";
                    $("#ser").append(opcion);
                  }
                }); 
        }
        
      });
      //--------------cuando cambia la servico
      $("#ser").change(function(){
        idgasto = $("#gas").val();
        idtipo = $("#tip").val();
        idser = $("#ser").val();
        $("#txtservicio").val(idser);
        if (idtip==0) {
          
          $("#acci").html('');
          $("#pilar").html('');
          $("#meta").html('');
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
          $("#meta").html('');
          $("#resultado").html('');
          $("#accion").html('');
          $("#descripaccion").html('');
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
              $("#meta").html('');
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_meta + "</option>";           
                $("#meta").append(opcion);
                nummeta =  $('#meta').find('option:selected').text();
                $("#txtmetas").val(nummeta);
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
        idmeta=$("#txtmetas").val();
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
                $("#descripaccion").val(nomaccio);
              }
            });        
      });
        

    })


 </script> 
 <script>
function verificaragregar()
  {
    departam1 = $("#txtdep").val();
    provincia1 = $("#txtprov").val();
    municipio1 = $("#txtmun").val();
    progra1 = $("#txtgas").val();
    nomprogra1 = $("#txtnomgas").val();
    accion1 = $("#txtacci").val();
    nomaccion1 = $("#txtnomacci").val();
    pilar1 = $("#txtpilar").val();
    meta1 = $("#txtmetas").val();
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
                                var x = document.getElementById('guardar');
                                    var y = document.getElementById('verificaragregar');
                                    y.style.display = 'none';
                                      x.style.display = 'inline';
                                      var x=$("#txtpresu").val();
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


    <script type="text/javascript">
      $(function(){
        $("#actualizaredit").click(function()
      {  
        
        objeto = {};
        objeto.id_correlativo = $("#idcorreedit").val();
        objeto.id_tarea_eta = $("#txtetaedit").val();
        objeto.id_departamento = $("#txtdepedit").val();
        objeto.id_provincia = $("#txtprovedit").val();
        objeto.id_municipio = $("#txtmunedit").val();
        objeto.id_programa = $("#txtgasedit").val();
        objeto.id_clasificador = $("#txttipoedit").val();
        objeto.id_servicio = $("#txtservicioedit").val();
        objeto.descripcion_programa = $("#txtnomgasedit").val();
        objeto.id_accion_eta = $("#txtacciedit").val();
        objeto.accion_eta = $("#txtnomacciedit").val();
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
        objeto.meta = $("#txtmetasedit").val();
        objeto.resultado = $("#txtresuledit").val();
        objeto.accion = $("#txtaccionedit").val();        
        objeto.accion = $("#txtaccionedit").val();        
        objeto.descripcion_accion_eta = $("#descripcion_accion_eta_edit").val();       
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
      $.get("listarMatricesEditar",function(respuesta)
        {
          var source =
            {
                localdata: respuesta.matrices,
                datafields:
                [
                  { name: 'id_correlativo', type: 'int' },
                  { name: 'id_tarea_eta', type: 'int' },
                  { name: 'id_departamento',type:'datafield'},
                  { name: 'descripcion_departamento',type:'datafield'},
                  { name: 'id_provincia',type:'datafield'},
                  { name: 'descripcion_provincia', type: 'datafield' },
                  { name: 'id_municipio',type:'datafield'},
                  { name: 'descripcion_municipio', type: 'datafield'},
                  { name: 'id_programa', type: 'int' },
                  { name: 'descripcion_programa', type: 'datafield'},
                  { name: 'id_accion_eta', type: 'datafield'},
                  { name: 'accion_eta', type: 'datafield'},
                  { name: 'linea_base', type: 'datafield'},
                  { name: 'proceso_indicador', type: 'datafield'},
                  { name: 'unidad_indicador', type: 'datafield'},
                  { name: 'cantidad_indicador', type: 'numeric'},
                  { name: 'indicador2016', type: 'numeric'},
                  { name: 'indicador2017', type: 'numeric'},
                  { name: 'indicador2018', type: 'numeric'},
                  { name: 'indicador2019', type: 'numeric'},
                  { name: 'indicador2020', type: 'numeric'},
                  { name: 'cantidad_presupuesto', type: 'numeric'},
                  { name: 'presupuesto2016', type: 'numeric'},
                  { name: 'presupuesto2017', type: 'numeric'},
                  { name: 'presupuesto2018', type: 'numeric'},
                  { name: 'presupuesto2019', type: 'numeric'},
                  { name: 'presupuesto2020', type: 'numeric'},
                  { name: 'pilar', type: 'int'},
                  { name: 'meta', type: 'int'},
                  { name: 'resultado', type: 'int'},
                  { name: 'accion', type: 'int'},
                  { name: 'descripcion_directriz', type: 'datafield'},
                  { name: 'estado', type: 'datafield'},
                  { name: 'id_clasificador', type: 'int'},
                  { name: 'descripcion_accion_eta', type: 'datafield'},
                  { name: 'id_servicio', type: 'int'}                  
                ],
                datatype: "json",
                updaterow: function (rowid, rowdata, commit) {
                    commit(true);
                }
            };   
          var dataAdapter = new $.jqx.dataAdapter(source);           
          $("#grid2").jqxGrid(
            {
              width: '1050',
              source: dataAdapter,
              theme: 'energyblue',
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
                 { text: 'DEP', filtertype: 'checkedlist', datafield: 'descripcion_departamento', width: 80},
                 { text: 'PROV', filtertype: 'checkedlist',datafield: 'descripcion_provincia',   width: 80 },
                 { text: 'MUN', filtertype: 'checkedlist',datafield: 'descripcion_municipio',   width: 80 },
                 { text: 'PROG', filtertype: 'checkedlist',datafield: 'id_programa',   width: 70 },
                 { text: 'DESCRIPCIÓN', filtertype: 'checkedlist',datafield: 'descripcion_programa',   width: 270 },
                 { text: 'ACCION ETA', filtertype: 'checkedlist',datafield: 'accion_eta',   width: 270 },
                 { text: 'LINEA BASE', filtertype: 'checkedlist',datafield: 'linea_base',   width: 200 },
                 { text: 'PROCESO INDICADOR', filtertype: 'checkedlist',datafield: 'proceso_indicador',   width: 200 },
                 { text: 'UNIDAD', filtertype: 'checkedlist',datafield: 'unidad_indicador',   width: 70 },               
                
                 { text: 'ACCIONES', datafield: 'id_correlativo',   width: 180, cellsRenderer: function (row, column, value, rowData)  
                    {
                      return "<button id='e"+value+"'><i class='glyphicon glyphicon-pencil'></i> Editar </button><button id='d"+value+"'><i class='glyphicon glyphicon-minus'></i> Eliminar </button> ";
                    }, 
                 }
                
               ]
            });
          $("#grid2").on("click", "button", function()
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
                  src: "#modal-editar"
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
              var getselectedrowindexes = $('#grid2').jqxGrid('getselectedrowindexes');
              if (getselectedrowindexes.length>0) 
              {
                 filaseleccionada=$('#grid2').jqxGrid('getrowdata',getselectedrowindexes[0]);
                 $("#depedit").val(filaseleccionada.id_departamento);
                 $("#etaedit").val(filaseleccionada.id_tarea_eta); 
                 $("#etaedit").trigger( "change");
                 setTimeout(function(){
                 $("#depedit").trigger( "change");
                 }, 370);
                 setTimeout(function(){
                    var x=filaseleccionada.id_provincia;
                    $("#provedit").val(x);    
                    $("#provedit").trigger( "change");
                 }, 920);
                 setTimeout(function(){
                    var y=filaseleccionada.id_municipio;
                     $("#munedit").val(y);    
                     $("#munedit").trigger( "change");
                 }, 1320);
                 setTimeout(function(){
                    var y=filaseleccionada.id_programa;
                     $("#gasedit").val(y);    
                     $("#gasedit").trigger( "change");
                 }, 1920);
                 if (filaseleccionada.id_tarea_eta!=1||filaseleccionada.id_tarea_eta!=2) 
                    {
                      if (filaseleccionada.id_programa==11) 
                        {
                          setTimeout(function()
                           {
                              var c=filaseleccionada.id_clasificador;                 
                              $("#tipedit").val(c);    
                              $("#tipedit").trigger( "change");
                           }, 2320); 
                          setTimeout(function()
                           {
                              var s=filaseleccionada.id_servicio;               
                              $("#seredit").val(s);    
                              $("#seredit").trigger( "change");
                           }, 2820);
                          setTimeout(function(){
                              var z=filaseleccionada.id_accion_eta;
                              $("#acciedit").val(z);    
                              $("#acciedit").trigger( "change");
                          }, 3320);
                          setTimeout(function(){
                              var y=filaseleccionada.idser;
                              $("#pilaredit").val(y);    
                              $("#pilaredit").trigger( "change");
                          }, 3820);
                        }
                      else
                        {
                          setTimeout(function(){
                              var z=filaseleccionada.id_accion_eta;
                              $("#acciedit").val(z);    
                              $("#acciedit").trigger( "change");
                          }, 2820);
                          setTimeout(function(){
                              var y=filaseleccionada.idser;
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
                      $("#descripcion_accion_eta_edit").val(o);    
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
                $("#etaedit").append(opcion);
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
                $("#depedit").append(opcion);
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
      

      $("#depedit").change(function()
      {
        iddepar = $("#depedit").val();
        $("#txtdepedit").val(iddepar);
        if (iddepar==0) {
          $("#provedit").html('<option>Seleccione la Provincia</option>');
          $("#munedit").html('<option>Seleccione la Município</option>');          
        }
        else
        {
          //alert(iddepar);
           $.get("listarProvinciasEditar/" + iddepar, function(respuesta){
              var provincias = respuesta.provincias;
              $("#provedit").html('');

                var opcion0 = "<option value=0>Seleccione la Provincia</option>";
                $("#provedit").append(opcion0);
              for(var i=0; i<provincias.length; i++)
              {
                var provincia = provincias[i];
                var opcion = "<option value=" + provincia.id_provincia + ">" + provincia.descripcion_provincia + "</option>";
                $("#provedit").append(opcion);
              }
          }); 
        }
      });
  //--------------cuando cambia la provincias
      $("#provedit").change(function(){
        iddepar = $("#depedit").val();
        idprov = $("#provedit").val();
        $("#txtprovedit").val(idprov);
        if (idprov==0) {
          $("#munedit").html('<option>Seleccione la Município</option>');
        }
        else
        {
          $.get("listarMunicipios/" + iddepar+"/"+idprov, function(respuesta)
          {
            var municipios = respuesta.municipios;
            $("#munedit").html('');
            var opcion0 = "<option value=0>Seleccione el Municipio</option>";
            $("#munedit").append(opcion0);
            for(var i=0; i<municipios.length; i++)
              {
                  var municipio = municipios[i];              
                  var opcion = "<option value=" + municipio.id_municipio + ">" + municipio.descripcion_municipio + "</option>";           
                  $("#munedit").append(opcion);
              }
          });
        }        
      });
      //--------------cuando cambia la provincias
      $("#munedit").change(function(){
        
        idmun = $("#munedit").val();
        $("#txtmunedit").val(idmun);
      });
      //--------------cuando cambia la eta
      $("#etaedit").change(function()
      {
        ideta = $("#etaedit").val();   
        $("#txtetaedit").val(ideta);   
        if (ideta==0) 
        {
          $("#gasedit").html('<option >Seleccione la Programática de Gasto</option>');
          $("#tipedit").html('');
          $("#txttipoedit").val('0');
          $("#seredit").html('');
          $("#txtservicioedit").val('0');
          $("#acciedit").html('');
          $("#pilaredit").html('');
          $("#metaedit").html('');
          $("#resultadoedit").html('');
          $("#accionedit").html('');
        }
        else        
        {
          if(ideta==1||ideta==2)
          {
              $.get("listarGastos1" , function(respuesta)
              {
                var gastos = respuesta.gastos;
                $("#gasedit").html('');
                var opcion0 = "<option value='-1'>Seleccione la Programática de Gasto</option>";
                $("#gasedit").append(opcion0);
                for(var i=0; i<gastos.length; i++)
                {
                 var gasto = gastos[i];              
                 var opcion = "<option value=" + gasto.id_programa + ">" + gasto.descripcion_gasto + "</option>";        
                  $("#gasedit").append(opcion);
                }
              });
          }
          else 
          {
              $.get("listarGastos2" , function(respuesta)
              {
                var gastos = respuesta.gastos;
                $("#gasedit").html('');
                var opcion0 = "<option value='-1'>Seleccione la Programática de Gasto</option>";
                $("#gasedit").append(opcion0);
                for(var i=0; i<gastos.length; i++)
                {
                  var gasto = gastos[i];              
                  var opcion = "<option value=" + gasto.codigo + ">" + gasto.descripcion_gasto + "</option>";           
                  $("#gasedit").append(opcion);
                }
              });
          }            
        }
      });
      //--------------cuando cambia la gasto
      $("#gasedit").change(function()
      {
        idgasto = $("#gasedit").val();
        idnomgasto = $('#gasedit').find('option:selected').text();
        //alert(idnomgasto);
        ideta = $("#etaedit").val();
        $("#txtgasedit").val(idgasto);
        $("#txtnomgasedit").val(idnomgasto);
        if (idgasto==-1) 
        {
          $("#tipedit").html('');
          $("#txttipoedit").val('0');
          $("#seredit").html('');
          $("#txtservicioedit").val('0');
          $("#acciedit").html('');         
          $("#pilaredit").html('');
          $("#metaedit").html('');
          $("#resultadoedit").html('');
          $("#accionedit").html('');          
        }
        else
        {
          if (ideta==1||ideta==2) 
          {
            $("#tipedit").html('');
            $("#txttipoedit").val('0');
            $("#seredit").html('');
            $("#txtservicioedit").val('0');
            $.get("listarAcciones/" + idgasto, function(respuesta)
            {
              var acciones = respuesta.acciones;
              $("#acciedit").html('');
              var opcion0 = "<option value=0>Seleccione la Acción ETA</option>";
              $("#acciedit").append(opcion0);
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_programa + ">" + accion.descripcion_gasto + "</option>";
                $("#acciedit").append(opcion);
              }
            });
            
          }
          else
          {
              if (idgasto==11) 
              {
                    $.get("listarTiposEditar", function(respuesta){
                  var tipos = respuesta.tipos;
                  $("#tipedit").html('');
                  $("#pilaredit").html('<option>P</option>');
                  $("#metaedit").html('<option>M</option>');
                  $("#resultadoedit").html('<option>R</option>');
                  $("#accionedit").html('<option>A</option>');          
                  $("#descaccionedit").html('');
                  var opcion0 = "<option value=0>Seleccione el Tipo </option>";
                  $("#tipedit").append(opcion0);
                  for(var i=0; i<tipos.length; i++)
                  {
                    var tipo = tipos[i];              
                    var opcion = "<option value=" + tipo.id_clasificador + ">" + tipo.descripcion_clasificador + "</option>";
                    $("#tipedit").append(opcion);

                  }
                });
              }
              else
              {
                  $.get("listarAcciones2/" + idgasto, function(respuesta)
                  {
                    var acciones = respuesta.acciones;
                    $("#acciedit").html('');
                    $("#tipedit").html('');
                    $("#txttipoedit").val('0');
                    $("#seredit").html('');
                    $("#txtservicioedit").val('0');
                    $("#pilaredit").html('<option>P</option>');
                    $("#metaedit").html('<option>M</option>');
                    $("#resultadoedit").html('<option>R</option>');
                    $("#accionedit").html('<option>A</option>');          
                    $("#descaccionedit").html('');
                    var opcion0 = "<option value=0>Seleccione la Acción ETA</option>";
                    $("#acciedit").append(opcion0);
                    for(var i=0; i<acciones.length; i++)
                    {
                      var accion = acciones[i];              
                      var opcion = "<option value=" + accion.id_correlativo + ">" + accion.accion_eta + "</option>";
                      $("#acciedit").append(opcion);
                    }
                  });            
              }            
          }  
        }       
      });
      //--------------cuando cambia el tipo
      $("#tipedit").change(function()
      {
        idgasto = $("#gasedit").val();
        idtip = $("#tipedit").val();
        $("#txttipoedit").val(idtip);
        if (idtip==0) 
        {
          $("#seredit").html('');
          $("#txtservicioedit").val('0');
          $("#acciedit").html('');
          $("#pilaredit").html('');
          $("#metaedit").html('');
          $("#resultadoedit").html('');
          $("#accionedit").html('');
        }
        else
        {
          $.get("listarServiciosEditar" , function(respuesta)
          {
                  var servicios = respuesta.servicios;
                  $("#acciedit").html('');                  
                  $("#seredit").html('');
                  var opcion0 = "<option value=0>Seleccione el Servicio</option>";
                  $("#seredit").append(opcion0);
                  for(var i=0; i<servicios.length; i++)
                  {
                    var servicio = servicios[i];              
                    var opcion = "<option value=" + servicio.id_servicio + ">" + servicio.descripcion_servicio + "</option>";
                    $("#seredit").append(opcion);
                  }
          }); 
        }
      });
      //--------------cuando cambia la servico
      $("#seredit").change(function(){
        idgasto = $("#gasedit").val();
        idtipo = $("#tipedit").val();
        idser = $("#seredit").val();
        $("#txtservicioedit").val(idser);
        if (idtip==0) 
        {          
          $("#acciedit").html('');
          $("#pilaredit").html('');
          $("#metaedit").html('');
          $("#resultadoedit").html('');
          $("#accionedit").html('');
        }
        else
        {
          $.get("listarAcciones3/" + idgasto+"/"+idtipo+"/"+idser, function(respuesta){
              var acciones = respuesta.acciones;
              $("#acciedit").html('');                  
              var opcion0 = "<option value=0>Seleccione la Acción</option>";
              $("#acciedit").append(opcion0);
              for(var i=0; i<acciones.length; i++)
                {
                  var accion = acciones[i];              
                  var opcion = "<option value=" + accion.id_correlativo + ">" + accion.accion_eta + "</option>";
                  $("#acciedit").append(opcion);
                }
            }); 
        }
      });
      //--------------cuando cambia la acciones eta
      $("#acciedit").change(function()
      {
        idaccion = $("#acciedit").val();
        idnomaccion = $('#acciedit').find('option:selected').text();
        $("#txtacciedit").val(idaccion);
        $("#txtnomacciedit").val(idnomaccion);        
        if (idaccion==0) 
        {
          $("#pilaredit").html('');
          $("#metaedit").html('');
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
              $("#metaedit").html('');
              for(var i=0; i<acciones.length; i++)
              {
                var accion = acciones[i];              
                var opcion = "<option value=" + accion.id_correlativo + ">" + accion.id_meta + "</option>";           
                $("#metaedit").append(opcion);
                nummeta =  $('#metaedit').find('option:selected').text();
                $("#txtmetasedit").val(nummeta);
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
        idmeta=$("#txtmetasedit").val();
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
    departam1 = $("#txtdepedit").val();
    provincia1 = $("#txtprovedit").val();
    municipio1 = $("#txtmunedit").val();
    progra1 = $("#txtgasedit").val();
    nomprogra1 = $("#txtnomgasedit").val();
    accion1 = $("#txtacciedit").val();
    nomaccion1 = $("#txtnomacciedit").val();
    pilar1 = $("#txtpilaredit").val();
    meta1 = $("#txtmetasedit").val();
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
