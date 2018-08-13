@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.dark.css" type="text/css" />
@endsection

@section('title-topbar')

@endsection

@section('content')
<table>
  <!--tr>    
      <th><h2>Actualizador</h2></th>
  </tr>        
  <tr>
    <td>
      <div id='contenedor'>
        <div id="grid2"></div>
        <div style="margin-top: 30px;">
            <div id="cellbegineditevent"></div>
            <div style="margin-top: 10px;" id="cellendeditevent"></div>
        </div>       
      </div>
    </td>
  </tr-->    
  
  <tr>
    <th><h2>Departamentos Registrados</h2></th>
  </tr>
  <tr>
    <td>
      <div id='jqxWidget'>
        <div id="grid1"></div>        
      </div>
    </td>
  </tr>
  <tr>
     <td>
        <div id="grid"></div>        
     </td>
  </tr>
  <tr>
    <th><h2>Filtro Matrices</h2></th>
  </tr>
  <tr>
     <td><input style="margin-top: 10px;" value="Limpiar Filtro" id="clearfilteringbutton" type="button" /></td>
     <td><input style="margin-top: 10px;" value="Exportar" id="export" type="button" /></td>
  </tr>
  <tr >
     <td colspan="2"><p><div id='matrices'></div></p></td>
  </tr>
</table>
<!--div id="modal-editar"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide popup-lg " >
  <div class="panel">
    <div class="panel-heading">
      <span class="panel-title"><i class="fa fa-pencil"></i>
      <font style="font-family: sans-serif;color: black">Formulario de Actualización</font>
      </span>
    </div>
    <form method="post" action="/" id="form-edit" name="form-edit">
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
                                              <div class="form-group">
                  <input type="text" class="form-control" name ="idcorre" id="idcorre" placeholder="id" required value="" style="display: ;" >
              </div>
                                <div class="form-group">
                  <input type="text" class="form-control" name ="txteta" id="txteta" placeholder="eta" required value="" style="display: ;" >
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name ="txtdep" id="txtdep" placeholder="departamento" required value="" style="display: ;" >
              </div>
              <div class="form-group">
               
              <input type="text" class="form-control" name="txtprov" id="txtprov" placeholder="provincia" required value="" style="display: ;">
              </div>

              <div class="form-group">
               
                <input type="text" class="form-control" name="txtmun" id="txtmun" placeholder="municipio" required value=""style="display: ;">
              </div>

              <div class="form-group">
               
                <input type="text"class="form-control" name="txtgas" id="txtgas" placeholder="programatica" value=""style="display: ;">
              </div>
              <div class="form-group">
               
                <input type="text"class="form-control" name="txtnomgas" id="txtnomgas" placeholder="nombre programatica"style="display: ;" >
              </div>              
              <div class="form-group">
               
                <input type="text" class="form-control" maxlength="15" size="15" name="txtacci" id="txtacci" placeholder="accion" value=""style="display: ;">
              </div>
              <div class="form-group">
               
                <input type="text" class="form-control" maxlength="15" size="15" name="txtnomacci" id="txtnomacci" placeholder="descripcion accion" value=""style="display: ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txttipo" id="txttipo" placeholder="descripcion tipo" value="0"style="display: ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtservicio" id="txtservicio" placeholder="descripcion servicio" value="0"style="display: ;">
              </div>
              <div class="form-group">
               
                <input type="text" class="form-control" maxlength="15" size="15" name="txtpilar" id="txtpilar" placeholder="pilar" value=""style="display: ;">
              </div>
              <div class="form-group">
                
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtmetas" id="txtmetas" placeholder="meta" value=""style="display: ;">
              </div>
              <div class="form-group">
                
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtresul" id="txtresul" placeholder="resultados" value=""style="display: ;">
              </div>
              <div class="form-group">
                
                <input type="text" class="form-control" maxlength="15" size="15" name="txtaccion" id="txtaccion" placeholder="acciones" value=""style="display: ;">
              </div>
              <div class="form-group">
                
                <input type="text" class="form-control" maxlength="15" size="15" name="descripaccion" id="descripaccion" placeholder="pdes" value="" style="display: ;">
              </div>

              <a class="btn btn-primary " href="#" role="button" id="verificar" name="verificar" style="display: inline;" onclick="verificar()">Verificar</a>

              <button  class="btn btn-primary" id="actualizar" name="actualizar" >Modificar</button>
              <button type="button" class="btn btn-success">Atrás</button>
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
        <div class="panel-footer">
          <button type="submit" class="button btn-primary">Validar y Guardar</button>
        </div>
    </form>
  </div>  
</div-->
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
<!----------------------------------------------------------------->



<script type="text/javascript">     
   $(function()
          {
            $.get("listarRegistroMatrices",function(respuesta)
              {
                var source =
                 {
                  localdata: respuesta.registros,
                  datafields:
                  [
                    { name: 'descripcion_departamento',type:'datafield'},
                    { name: 'descripcion_provincia', type: 'datafield' },
                    { name: 'descripcion_municipio', type: 'datafield'},
                    { name: 'registros1', type: 'int' }
                  ],
                  datatype: "json"
                 };
                var dataAdapter = new $.jqx.dataAdapter(source);
                $("#grid").jqxGrid(
                  {
                    width:600,// getWidth('Grid'),
                    source: dataAdapter,
                    groupable: true,
                    pageable: true,
                    autoheight: true,                    
                    columns: 
                    [
                      { text: 'DEPARTAMENTO', datafield: 'descripcion_departamento', width: 250 },
                      { text: 'PROVINCIA', datafield: 'descripcion_provincia', width: 120 },
                      { text: 'MUNICIPIO', datafield: 'descripcion_municipio', width: 120 },
                      { text: 'CANTIDAD', datafield: 'registros1', width: 80 }

                    ],
                    groups: ['descripcion_departamento']
                  });                     
                $("#expand").on('click', function () 
                {
                  var groupnum = parseInt($("#groupnum").val());
                  if (!isNaN(groupnum)) 
                  {
                      $("#grid").jqxGrid('expandgroup', groupnum);
                  }
                });
                $("#collapse").on('click', function () 
                {
                  var groupnum = parseInt($("#groupnum").val());
                  if (!isNaN(groupnum)) 
                   {
                      $("#grid").jqxGrid('collapsegroup', groupnum);
                   }
                });                
                $("#expandall").on('click', function () 
                {
                  $("#grid").jqxGrid('expandallgroups');
                });
                      // collapse all groups.
                $("#collapseall").on('click', function () 
                {
                  $("#grid").jqxGrid('collapseallgroups');
                });
                      // trigger expand and collapse events.
                $("#grid").on('groupexpand', function (event) 
                {
                  var args = event.args;
                  $("#expandedgroup").text("Group: " + args.group + ", Level: " + args.level);
                });
                $("#grid").on('groupcollapse', function (event) 
                {
                  var args = event.args;
                  $("#collapsedgroup").text("Group: " + args.group + ", Level: " + args.level);
                });
              });
          });
</script>
    
<script type="text/javascript">
    $(function()
    {      
      $("#export").click(function()
      {   
        $("#matrices").jqxGrid('exportdata', 'xls', 'matrices', true, null, true);
      });
      $.get("listarMatrices",function(respuesta)
      {
        var source =
        {
          localdata: respuesta.matrices,
          datafields:
          [
            { name: 'id_correlativo', type: 'int' },
            { name: 'descripcion_departamento',type:'datafield'},
            { name: 'descripcion_provincia', type: 'datafield' },
            { name: 'descripcion_municipio', type: 'datafield'},
            { name: 'id_programa', type: 'int' },
            { name: 'descripcion_programa', type: 'datafield'},
            { name: 'accion_eta', type: 'datafield'},
            { name: 'linea_base', type: 'datafield'},
            { name: 'proceso_indicador', type: 'datafield'},
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
            { name: 'descripcion_directriz', type: 'datafield'}
          ],
          datatype: "json"
        };
        var dataAdapter = new $.jqx.dataAdapter(source);
        $("#matrices").jqxGrid(
          {
            width: '1050',
            source: dataAdapter,
            theme: 'energyblue',
            altrows: true,
            pageable: true,
            autoheight: true,
            selectionmode: 'multiplecellsextended',
            showgroupaggregates: true,
            showstatusbar: true,
            showaggregates: true,
            statusbarheight: 40,
            source: dataAdapter,
            showfilterrow: true,
            filterable: true,
            autorowheight: true,
            columns: 
            [
              { text: 'DEPARTAMENTO', filtertype: 'checkedlist', datafield: 'descripcion_departamento', width: 150},
             { text: 'PROVINCIA', filtertype: 'checkedlist',datafield: 'descripcion_provincia',   width: 150 },
             { text: 'MUNICIPIO', filtertype: 'checkedlist',datafield: 'descripcion_municipio',   width: 150 },
             { text: 'PROG', filtertype: 'checkedlist',datafield: 'id_programa',   width: 50 },
             { text: 'PROGRAMATÍCA', filtertype: 'checkedlist',datafield: 'descripcion_programa',   width: 215 },
             { text: 'ACCIÓN ETA', filtertype: 'checkedlist',datafield: 'accion_eta',   width: 250 },
             { text: 'LINEA BASE', filtertype: 'checkedlist',datafield: 'linea_base',   width: 215 },
             { text: 'PROCESO INDICADOR', filtertype: 'checkedlist',datafield: 'proceso_indicador',   width: 215 },
             { text: 'INDICADOR', filtertype: 'checkedlist',datafield: 'cantidad_indicador',   width: 50 },
             { text: '2016', filtertype: 'checkedlist',datafield: 'indicador2016',   width: 50 },
             { text: '2017', filtertype: 'checkedlist',datafield: 'indicador2017',   width: 50 },
             { text: '2018', filtertype: 'checkedlist',datafield: 'indicador2018',   width: 50 },
             { text: '2019', filtertype: 'checkedlist',datafield: 'indicador2019',   width: 50 },
             { text: '2020', filtertype: 'checkedlist',datafield: 'indicador2020',   width: 50 },
             { text: 'PRESUPUESTO', datafield: 'cantidad_presupuesto', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: 'c2' },
             { text: '2016', datafield: 'presupuesto2016', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: 'c2' },
             { text: '2017', datafield: 'presupuesto2017', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: 'c2' },
             { text: '2018', datafield: 'presupuesto2018', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: 'c2' },
             { text: '2019', datafield: 'presupuesto2019', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: 'c2' },
             { text: '2020', datafield: 'presupuesto2020', aggregates: ["sum"], cellsalign: 'right', width: 180, cellsformat: '' },
             { text: 'P',filtertype: 'checkedlist', datafield: 'pilar',  cellsalign: 'right', width: 50 },
             { text: 'M',filtertype: 'checkedlist', datafield: 'meta',  cellsalign: 'right', width: 50 },
             { text: 'R',filtertype: 'checkedlist', datafield: 'resultado',  cellsalign: 'right', width: 50 },
             { text: 'A',filtertype: 'checkedlist', datafield: 'accion',filtertype: 'checkedlist',  cellsalign: 'right', width: 50 },
             { text: 'DESCRIPCIÓN', filtertype: 'checkedlist', datafield: 'descripcion_directriz', width: 250},
            ]
          });
        $('#clearfilteringbutton').jqxButton({ height: 25});
        $('#clearfilteringbutton').click(function () 
          {
              $("#matrices").jqxGrid('clearfilters');
          });            
      });
    })
 </script>

 
@endpush
