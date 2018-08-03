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
  </tr>    
  
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
<div id="modal-editar"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide popup-lg " >
  <div class="panel">
    <div class="panel-heading">
      <span class="panel-title"><i class="fa fa-pencil"></i>
      <font style="font-family: sans-serif;color: black">Formulario de Actualización</font>
      </span>
    </div>            <!-- end .panel-heading section -->
    <form method="post" action="/" id="form-edit" name="form-edit">
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
                  <input type="text" class="form-control" name ="txteta" id="txteta" placeholder="eta" required value="" style="display: ;" >
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name ="txtdep" id="txtdep" placeholder="departamento" required value="" style="display: ;" >
              </div>
              <div class="form-group">
                <!--label for="prov">provincia</label-->
              <input type="text" class="form-control" name="txtprov" id="txtprov" placeholder="provincia" required value="" style="display: ;">
              </div>

              <div class="form-group">
                <!--label for="mun">municipio</label-->
                <input type="text" class="form-control" name="txtmun" id="txtmun" placeholder="municipio" required value=""style="display: ;">
              </div>

              <div class="form-group">
                <!--label for="prog">programatica</label-->
                <input type="text"class="form-control" name="txtgas" id="txtgas" placeholder="programatica" value=""style="display: ;">
              </div>
              <div class="form-group">
                <!--label for="nom_prog">detalle programatica</label-->
                <input type="text"class="form-control" name="txtnomgas" id="txtnomgas" placeholder="nombre programatica"style="display: ;" >
              </div>              
              <div class="form-group">
                <!--label for="acc">accion</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtacci" id="txtacci" placeholder="accion" value=""style="display: ;">
              </div>
              <div class="form-group">
                <!--label for="descrip_acc">descripcion accion</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtnomacci" id="txtnomacci" placeholder="descripcion accion" value=""style="display: ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txttipo" id="txttipo" placeholder="descripcion tipo" value="0"style="display: ;">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" maxlength="15" size="15" name="txtservicio" id="txtservicio" placeholder="descripcion servicio" value="0"style="display: ;">
              </div>
              <div class="form-group">
                <!--label for="idpilar"> pilar</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtpilar" id="txtpilar" placeholder="pilar" value=""style="display: ;">
              </div>
              <div class="form-group">
                  <!--label for="metas">pdes</label-->
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtmetas" id="txtmetas" placeholder="meta" value=""style="display: ;">
              </div>
              <div class="form-group">
                  <!--label for="resultados">pdes</label-->
                  <input type="text" class="form-control" maxlength="15" size="15" name="txtresul" id="txtresul" placeholder="resultados" value=""style="display: ;">
              </div>
              <div class="form-group">
                <!--label for="acciones">pdes</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="txtaccion" id="txtaccion" placeholder="acciones" value=""style="display: ;">
              </div>
              <div class="form-group">
                <!--label for="acciones">pdes</label-->
                <input type="text" class="form-control" maxlength="15" size="15" name="descripaccion" id="descripaccion" placeholder="pdes" value="" style="display: ;">
              </div>

              <a class="btn btn-primary " href="#" role="button" id="verificar" name="verificar" style="display: inline;" onclick="verificar()">Verificar</a>

              <button  class="btn btn-primary" id="actualizar" name="actualizar" style="display: ;">Modificar</button>
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
<!----------------------------------------------------------------->

<script type="text/javascript">
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
                  { name: 'id_clasificador', type: 'int'},
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
              width:1000,// getWidth('Grid'),
              source: dataAdapter,
              pageable: true,
              autoheight: true,
              theme: 'energyblue',
              columns:
               [                
                //  { text: 'tarea', filtertype: 'checkedlist', datafield: 'id_tarea_eta', width: 50},
                 { text: 'DEPARTAMENTO', filtertype: 'checkedlist', datafield: 'descripcion_departamento', width: 150},
                 { text: 'PROVINCIA', filtertype: 'checkedlist',datafield: 'descripcion_provincia',   width: 150 },
                 { text: 'MUNICIPIO', filtertype: 'checkedlist',datafield: 'descripcion_municipio',   width: 150 },
                 { text: 'PROG', filtertype: 'checkedlist',datafield: 'id_programa',   width: 150 },               
                 { text: 'Edit', datafield: 'id_correlativo', cellsRenderer: function (row, column, value, rowData)  
                    {
                      return "<button id='"+value+"'><i class='fa fa-pencil'></i> editar </button> ";
                    },                 
                 }
               ]
             });
        $("#grid2").on("click", "button", function()
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
            var id = $(this).attr('id');
            $(".state-error").removeClass("state-error");
            var getselectedrowindexes = $('#grid2').jqxGrid('getselectedrowindexes');
            if (getselectedrowindexes.length > 0)
            {
             filaseleccionada = $('#grid2').jqxGrid('getrowdata', getselectedrowindexes[0]);
             $("#dep").val(filaseleccionada.id_departamento);
             $("#eta").val(filaseleccionada.id_tarea_eta); 
             $("#eta").trigger( "change");             
             setTimeout(function(){
                $("#dep").trigger( "change");
             }, 300);
             setTimeout(function(){
                var x=filaseleccionada.id_provincia;
                $("#prov").val(x);    
                $("#prov").trigger( "change");
             }, 850);
             setTimeout(function(){
                var y=filaseleccionada.id_municipio;
                 $("#mun").val(y);    
                 $("#mun").trigger( "change");
             }, 1250);

             setTimeout(function(){
                var y=filaseleccionada.id_programa;
                 $("#gas").val(y);    
                 $("#gas").trigger( "change");
             }, 1850);
             if (filaseleccionada.id_tarea_eta==1||filaseleccionada.id_tarea_eta==2) {

             }else{
              if (filaseleccionada.id_programa==11) {
              setTimeout(function(){
              var c=filaseleccionada.id_clasificador;                 
              $("#tip").val(c);    
              $("#tip").trigger( "change");
              }, 2250);

             setTimeout(function(){
             var s=filaseleccionada.id_servicio;               
             $("#ser").val(s);    
             $("#ser").trigger( "change");
             }, 2750);
             setTimeout(function(){
              var z=filaseleccionada.id_accion_eta;
              $("#acci").val(z);    
              $("#acci").trigger( "change");
              }, 3250);
              setTimeout(function(){
               var y=filaseleccionada.idser;
              $("#pilar").val(y);    
              $("#pilar").trigger( "change");
              }, 3750);
             }
             else
             {
              setTimeout(function(){
              var z=filaseleccionada.id_accion_eta;
              $("#acci").val(z);    
              $("#acci").trigger( "change");
              }, 2750);
              setTimeout(function(){
               var y=filaseleccionada.idser;
              $("#pilar").val(y);    
              $("#pilar").trigger( "change");
              }, 3250);
             }
            }
            setTimeout(function(){
               var a=filaseleccionada.linea_base;
              $("#linea_base").val(a);
              var b=filaseleccionada.proceso_indicador;
              $("#ind_proceso").val(b);
              var z=filaseleccionada.unidad_indicador;
              $("#tipocantidad").val(z);
              var c=filaseleccionada.cantidad_indicador;
              $("#cantidad").val(c);
              var d=filaseleccionada.indicador2016;
              $("#2016").val(d);
              var e=filaseleccionada.indicador2017;
              $("#2017").val(e);
              var f=filaseleccionada.indicador2018;
              $("#2018").val(f);
              var g=filaseleccionada.indicador2019;
              $("#2019").val(g);
              var h=filaseleccionada.indicador2020;
              $("#2020").val(h);
              var i=filaseleccionada.cantidad_presupuesto;
              $("#txtpresu").val(i);
              var j=filaseleccionada.presupuesto2016;
              $("#p2016").val(j);
              var k=filaseleccionada.presupuesto2017;
              $("#p2017").val(k);
              var l=filaseleccionada.presupuesto2018;
              $("#p2018").val(l);
              var m=filaseleccionada.presupuesto2019;
              $("#p2019").val(m);
              var n=filaseleccionada.presupuesto2020;
              $("#p2020").val(n);
              }, 3450);            
          }
          console.log(filaseleccionada);
          $("#form-plan em").remove();
         });        
        $.get("listarEtasEditar", function(respuesta)
          {
              var etas = respuesta.etas;
              for(var i=0; i<etas.length; i++)
              {
                var eta = etas[i];
                var opcion = "<option value=" + eta.id_eta + ">" + eta.descripcion_eta + "</option>";
                $("#eta").append(opcion);
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
                $("#dep").append(opcion);
              }
              console.log(departamentos);
          });


        });
    })

</script>

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
    $(function()
    {
//--------------botonguardar
      $("#actualizar").click(function()
      {          
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
        objeto._token = $('input[name=_token]').val()
        console.log(objeto);
        //---------------------aqui esta el try de la insercion
        var message;
        message = document.getElementById("p01");
        message.innerHTML = "";
        
        try {        
            if (objeto) 
            {
             $.post("actualizarmatriz", objeto, function(respuesta)
             {
              alert('informacion actualizada');
              location.reload();
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
//--------------cargar eta
     /* $.get("listarEtas", function(respuesta)
      {
        var etas = respuesta.etas;
        for(var i=0; i<etas.length; i++)
        {
          var eta = etas[i];
          var opcion = "<option value=" + eta.id_eta + ">" + eta.descripcion_eta + "</option>";
          $("#eta").append(opcion);
        }
        console.log(etas);
      });*/
///--------------cuando cambia el departamento
      $("#dep").change(function()
      {
        iddepar = $("#dep").val();
        $("#txtdep").val(iddepar);
        if (iddepar==0) {
          $("#prov").html('<option>Seleccione la Provincia</option>');
          $("#mun").html('<option>Seleccione la Município</option>');          
        }
        else
        {
          //alert(iddepar);
           $.get("listarProvinciasEditar/" + iddepar, function(respuesta){
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
        }
        else
        {
          $.get("listarMunicipios/" + iddepar+"/"+idprov, function(respuesta)
          {
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
      $("#eta").change(function()
      {
        ideta = $("#eta").val();   
        $("#txteta").val(ideta);   
        if (ideta==0) 
        {
          $("#gas").html('<option >Seleccione la Programática de Gasto</option>');
          $("#tip").html('');
          $("#txttipo").val('0');
          $("#ser").html('');
          $("#txtservicio").val('0');
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
              $.get("listarGastos1" , function(respuesta)
              {
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
              $.get("listarGastos2" , function(respuesta)
              {
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
      $("#gas").change(function()
      {
        idgasto = $("#gas").val();
        idnomgasto = $('#gas').find('option:selected').text();
        //alert(idnomgasto);
        ideta = $("#eta").val();
        $("#txtgas").val(idgasto);
        $("#txtnomgas").val(idnomgasto);
        if (idgasto==-1) 
        {
          $("#tip").html('');
          $("#txttipo").val('0');
          $("#ser").html('');
          $("#txtservicio").val('0');
          $("#acci").html('');         
          $("#pilar").html('');
          $("#meta").html('');
          $("#resultado").html('');
          $("#accion").html('');          
        }
        else
        {
          if (ideta==1||ideta==2) 
          {
            $("#tip").html('');
            $("#txttipo").val('0');
            $("#ser").html('');
            $("#txtservicio").val('0');
            $.get("listarAcciones/" + idgasto, function(respuesta)
            {
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
                    $.get("listarTiposEditar", function(respuesta){
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
                  $.get("listarAcciones2/" + idgasto, function(respuesta)
                  {
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
      $("#tip").change(function()
      {
        idgasto = $("#gas").val();
        idtip = $("#tip").val();
        $("#txttipo").val(idtip);
        if (idtip==0) 
        {
          $("#ser").html('');
          $("#txtservicio").val('0');
          $("#acci").html('');
          $("#pilar").html('');
          $("#meta").html('');
          $("#resultado").html('');
          $("#accion").html('');
        }
        else
        {
          $.get("listarServiciosEditar" , function(respuesta)
          {
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
        if (idtip==0) 
        {          
          $("#acci").html('');
          $("#pilar").html('');
          $("#meta").html('');
          $("#resultado").html('');
          $("#accion").html('');
        }
        else
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
      $("#acci").change(function()
      {
        idaccion = $("#acci").val();
        idnomaccion = $('#acci').find('option:selected').text();
        $("#txtacci").val(idaccion);
        $("#txtnomacci").val(idnomaccion);        
        if (idaccion==0) 
        {
          $("#pilar").html('');
          $("#meta").html('');
          $("#resultado").html('');
          $("#accion").html('');
          $("#descripaccion").html('');
        }
        else
        {
            $.get("listarPilares/" + idaccion, function(respuesta)
            {
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
            $.get("listarMetas/" + idaccion, function(respuesta)
            {
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
            $.get("listarResultados/" + idaccion, function(respuesta)
            {
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
            $.get("listarAccionesEtas/" + idaccion, function(respuesta)
            {
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
      $("#accion").change(function()
      {
        idpilar=$("#txtpilar").val();        
        idmeta=$("#txtmetas").val();
        idresultado=$("#txtresul").val();
        idaccion=$("#txtaccion").val();
        //alert(idpilar+" "+ idmeta+" "+idresultado+" "+idaccion);
        $.get("listarPMRAs/"+ idpilar+"/"+idmeta+"/"+idresultado+"/"+idaccion, function(respuesta)
        {
          var acciones = respuesta.acciones;
          $("#descaccion").html('');
          for(var i=0; i<acciones.length; i++)
          {
            var accion = acciones[i];              
            var opcion = "<option value=" + accion.id_correlativo + ">" + accion.descripcion_directriz + "</option>";           
            $("#descaccion").append(opcion);
            nomaccio =  $('#descaccion').find('option:selected').text();
            $("#descripaccion").val(nomaccio);
          }
        });        
      });
    });
 </script> 
 <script>
function verificar()
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
                                    var y = document.getElementById('verificar');
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
