@extends('layouts.plataforma')

@section('header')

<link rel="stylesheet" href="{{ asset('jqwidgets5.4.0/jqwidgets/styles/jqx.base.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets5.4.0/jqwidgets/styles/jqx.ui-start.css') }}" type="text/css" />

@endsection

@section('content')
  <div class="container" id="miContenedor"> 


    <div style="width: 800px; height: 100%; margin-left: auto; margin-right: auto;"> <!-- Centrador --> 
      <h2>Listado de Dash Menu</h2>

      <div id="DashMenuGrid">
      </div>

      <div id="mensajesDashMenu" style="width: 800px; min-height:20px;"></div>

    </div> <!-- Centrador --> 


    <div id="popupDashMenu" style="min-height: 346px;">
       <div>Dash Menú</div>
       <div style="overflow: hidden; min-height: 310px;">
         <div id="mensajes"></div>
         <form class="form" id="form" target="form-iframe"  method="post" action="guardardashmenu" >
             <table class="tabla-ventana">
                 <tr>
                     <td align="right" style="color:#000000; width: 150px;">Nombre:</td>
                     <td colspan="2"><input name="nombre" type="text" id="nombreInput" /></td>
                     <input type="hidden" name="id" id="idInput" value="">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000;">Descripción:</td>
                     <td colspan="2"><input name="descripcion" type="text" id="descripcionInput" /></td>
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000;">Código:</td>
                     <td colspan="2"><input name="cod_str" type="text" id="cod_strInput" /></td>
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000;">Nivel:</td>
                     <td><input name="nivel" type="text" id="nivelInput" /></td>
                     <td rowspan="7" style="padding: 6px;">
                      <fieldset style="width: 100%;padding: 6px; border-style:solid; border-width:1px; border-color:#B0B0B0; border-radius: 5px;">
                        <legend style="width: auto; margin-bottom: 0px; padding: 2px; font-size: 12px;border-style:solid;border-width:1px; border-color:#B0B0B0;border-radius: 3px;">
                        Configuración:
                        </legend>                     
                         <table  style="width: 100%;">
                           <tr>
                             <td colspan="2" style="white-space:nowrap;">
                               <div name="id_dash_config"  id="id_dash_configComboBox"></div>
                               <button onClick="abrirVentanaConfirmacion(this,'Editar Configuración','¿Está Ud. seguro que desea modificar la configuración?',funcionOk,funcionCancel);" type='button' title='Editar Configuración' id='btnEditConfig' class='jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-fill-state-fred-ui-start' style='margin: 0px; height: 25px; width: 25px; padding: 0px 0px 0px 1px; display: inline-block; vertical-align: top;'><i id="iconoEditConfig" class='glyphicon glyphicon-edit'></i></button>
                             </td>
                           </tr>
                           <tr>
                             <td colspan="2">
                               <textarea id="configuracionTextArea" readonly></textarea>  
                               <input type="hidden" id="txtIdDashConfig"/>                            
                             </td>
                             <style type="text/css">
                                #id_dash_configComboBox{ 
                                    display: inline-block;
                                }
                                #configuracionTextAreaTextArea{ 
                                    background-color: #eeeeee !important;
                                    background-image: none !important;
                                    color: #777777;
                                    /* white-space: nowrap;
                                    overflow-x: auto; */
                                }
                             </style>
                           </tr>
                           <tr>
                             <td style="width: 80px; overflow:hidden;">Indicador:</td>
                             <td> <input type="text" id="txtIndicador" style="border-style:solid; border-width:1px; border-color:#c7c7c7;background-color:#eeeeee;border-radius: 4px; moz-border-radius: 4px; webkit-border-radius: 4px; width: 160px;" readonly/> <input type="hidden" id="txtIdIndicador"/> </td>
                           </tr>
                           <tr>
                             <td>Variable:</td>
                             <td> <input type="text" id="txtVariable_estadistica" style="border-style:solid; border-width:1px; border-color:#c7c7c7; background-color:#eeeeee; border-radius: 4px; moz-border-radius: 4px; webkit-border-radius: 4px; width: 160px;" readonly/> </td>
                           </tr>
                           <tr>
                             <td>Descripción:</td>
                             <td> <input type="text" id="txtDescripcion" style="border-style:solid; border-width:1px; border-color:#c7c7c7; background-color:#eeeeee; border-radius: 4px; moz-border-radius: 4px; webkit-border-radius: 4px; width: 160px;" readonly/> 
    <div id="messageNotification">
        <div>
            Welcome to our website.
        </div>
    </div>
                             </td>
                           </tr>

                         </table>
                      </fieldset>
                     </td>
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000;">Tipo:</td>
                     <td><input name="tipo" type="text" id="tipoInput" /></td>
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000;">Orden:</td>
                     <td><div name="orden"  id="ordenNumberInput"></div></td>
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000">Activo:</td>
                     <td><div name="activo"  id="activoCheckBox"></div></td>
                 </tr>
                 <tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                 </tr>
                 <tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                 </tr>
                 <tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                 </tr>
                 <tr>
                     <td align="right"></td>
                     <td  colspan="2" style="padding-top: 10px;" align="right">
                         <input style="margin-right: 5px;" type="button" id="btnSavePopup" value="Guardar" />                            
                         <input id="btnCancelPopup" type="button" value="Cerrar" />
                     </td>
                 </tr>
             </table>
         </form>
       </div>
    </div>


    <div id="popupDeleteConfirm">
      <div>
          <img width="14" height="14" src="../../images/help.png" alt="" />
          ¿Borrar Datos?
      </div>
      <div>
        <div>
            ¿Realmente desea borrar el Registro?, una vez borrados los datos no es posible deshacer la acción, para borrar presione el boton "OK", para cancelar el borrado precione "Cancelar".
        </div>
        <div>
          <div style="float: right; margin-top: 15px;">
              <input type="button" id="okDelete" value="OK" style="margin-right: 10px" />
              <input type="button" id="cancelDelete" value="Cancelar" />
          </div>
        </div>
      </div>
    </div>


    <div id='ConfirmPopup'>
        <div id="cpHeader">Cabecera</div>
        <div> <span id="cpContent">¿Está Ud. Seguro?</span>
            <div style="margin: 0; position:absolute; bottom:8px; left:0px; text-align:center; width:100%;">
                <input type="button" id="btnOkConfirm" value="OK" style="margin-right: 10px" />
                <input type="button" id="btnCancelConfirm" value="Cancel" />
            </div>
        </div>
    </div>


  </div> <!--  id="miContenedor" -->
@endsection


@push('script-head')
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxcore.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxdata.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxbuttons.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxscrollbar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxmenu.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxgrid.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxgrid.selection.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxgrid.filter.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxlistbox.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxcombobox.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxdropdownlist.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxcheckbox.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxwindow.js') }}"></script>

  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxgrid.sort.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxgrid.pager.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxgrid.columnsresize.js') }}"></script>

  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxgrid.edit.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxpanel.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxcalendar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxdatetimeinput.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxnumberinput.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxinput.js') }}"></script>
  
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxgrid.columnsresize.js') }}"></script>

  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/globalization/globalize.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/jqwidgets-localization.js') }}"></script>

  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxdata.export.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxgrid.export.js') }}"></script>

  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxmaskedinput.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxvalidator.js') }}"></script>

  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxtextarea.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxnotification.js') }}"></script>

  <style type="text/css">

    html, body, #wrapper, .container-fluid {
      height:100% !important;
      padding: 0 0 0 0 !important;
    }

    #page-wrapper{
      height: calc(100% - 60px) !important;
      /*min-height: calc(100% - 160px) !important; - 60px -60px (100 80 60) cabecera y piede pagina*/
    }

    ul {
      margin: 0 !important;
    }

    h1, h2, h3, h4, h5, h6 {
      margin: 0 !important;
      padding: 10px 0 !important;
    }

    #miContenedor { /* para que en los celulares salga mas optimizada la pantalla */
      overflow:auto; 
      width: 100% !important; 
      /*height:calc(100% - 42px);*/
      min-height:calc(100% - 60px);
    }

    .jqx-validator-hint {  /* Cambiamos el color guindo de los mensajes del validador*/
      border: 1px solid #DEABA0;
      background-color: #de857b;
      opacity: 0.85;
    }

    .jqx-validator-hint-arrow{ /* creamos otro rombo */  
      margin: 3px 0px 0px 0px;
      width: 8px; 
      height: 8px; 
      border: 1px solid; 
      border-top-color: #de857b;
      border-right-color: #de857b;
      border-bottom-color: #DEABA0;
      border-left-color: #DEABA0;
      background: #de857b;
      -webkit-transform: rotate(45deg);
      -moz-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      -o-transform: rotate(45deg);
      transform: rotate(45deg);
      opacity: 0.85;
    }

    .jqx-validator-hint-arrow img {display: none;} /* ya no mostramos el rombo del validador*/ 
       .text-input-popup
        {
            height: 23px;
            width: 150px;
        }    
    
    .tabla-ventana {
      width:100%;
    } 
    .tabla-ventana td {
      padding: 3px 0px 3px 2px;
    }   



    .jqx-fill-state-fred-ui-start{
      border-color: #77d5f7; 
      background: #0078ae url(../jqwidgets5.4.0/jqwidgets/styles/images/start/ui-bg_glass_45_0078ae_1x400.png) 50% 50% repeat-x; 
      font-family: Verdana,Arial,sans-serif; 
      font-style: normal; 
      font-size: 12px; 
      font-weight: normal; 
      color: #ffffff;
    }

    .jqx-fill-state-fred-ui-start:hover{
      border-color: #448dae;
      background: #79c9ec url(../jqwidgets5.4.0/jqwidgets/styles/images/start/ui-bg_glass_75_79c9ec_1x400.png) 50% 50% repeat-x; 
      font-weight: normal; 
      color: #026890;
    }


    #pagerDashMenuGrid > div{
        width: 400px !important;
    }

    .container{
        width: 100% !important; /* para que en los celulares salga mas optimizada la pantalla */
    }

  </style>

<script type="text/javascript">

// ==================================================================================================

$(document).ready(function () {

    var Tema = 'ui-start';
    var Global_editrow = -1;
    var Global_nuevo = false;
    var Global_offsetFila = 0;
    var modifButton;
    var deleteButton;
    var Registros;
    var url = "./listadashmenu";

    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id', type: 'int' },
            { name: 'cod_str', type: 'string' },
            { name: 'nombre', type: 'string' },
            { name: 'descripcion', type: 'string' },
            { name: 'nivel', type: 'int' },
            { name: 'tipo', type: 'string' },
            { name: 'orden', type: 'int' },
            { name: 'activo', type: 'bool' },
            { name: 'id_dash_config', type: 'int' }            
        ],
        id: 'id',
        url: url,
        root: '',

        updaterow: function (rowid, rowdata, commit) { // esto servira para cuando editen en la fila
            // synchronize with the server - send update command
            // call commit with parameter true if the synchronization with the server is successful
            // and with parameter false if the synchronization failed.
            commit(true);
        },
        loadComplete: function () { // get data records.
            Registros = dataAdapter.records; // records.length  record.username
        }        
     };

    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#DashMenuGrid").jqxGrid(
    {
        width: 800,
        source: dataAdapter,
        sortable: true,
        pageable: true,
        autoheight: true,
        showfilterrow: false, ///
        filterable: false, ///
        editable: false,
        localization: getLocalization('es'),
        selectionmode: 'singlerow', // singlecell multiplerows multiplerowsextended multiplerowsadvanced
        columnsresize: true,

        ready: function () {
            // $("#DashMenuGrid").jqxGrid('sortby', 'name', 'asc'); ya no es necesario, se hace desde la BD
        },
        showtoolbar: true,
        rendertoolbar: function (statusbar) {
            // appends buttons to the status bar.
            var container = $("<div style='overflow: hidden; position: relative; margin: 2px;'></div>");
            var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../../images/add.png' width='16px' height='16px'/><span style='margin-left: 4px; position: relative; top: 2px !important;'>Adicionar</span></div>");
            modifButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../../images/modif.png' width='16px' height='16px'/><span style='margin-left: 4px; position: relative; top: 2px !important;'>Editar</span></div>");
            deleteButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../../images/del.png' width='16px' height='16px'/><span style='margin-left: 4px; position: relative; top: 2px !important;'>Borrar</span></div>");
            var reloadButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../../images/refresh.png' width='16px' height='16px'/><span style='margin-left: 4px; position: relative; top: 2px !important;'>Recargar</span></div>");
            var searchButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='../../images/search.png' width='16px' height='16px'/><span style='margin-left: 4px; position: relative; top: 2px !important;'>Buscar</span></div>");

            var pdfButton = $("<div style='float: right; margin-right: 5px;'><img style='position: relative; margin-top: 2px;' src='../../images/pdf.png' width='16px' height='16px'/></div>");
            var excelButton = $("<div style='float: right; margin-right: 5px;'><img style='position: relative; margin-top: 2px;' src='../../images/excel.png' width='16px' height='16px'/></div>");
            container.append(addButton);
            container.append(modifButton);                    
            container.append(deleteButton);
            container.append(reloadButton);
            container.append(searchButton);
            container.append(pdfButton);
            container.append(excelButton);
            statusbar.append(container);
            addButton.jqxButton({  width: 100, height: 20, theme: Tema });
            modifButton.jqxButton({  width: 100, height: 20, disabled: true, theme: Tema }); 
            deleteButton.jqxButton({  width: 100, height: 20, disabled: true, theme: Tema }); 
            reloadButton.jqxButton({  width: 100, height: 20, theme: Tema });
            searchButton.jqxButton({  width: 100, height: 20, theme: Tema }); 
            pdfButton.jqxButton({  width: 25, height: 20, theme: Tema }); 
            excelButton.jqxButton({  width: 25, height: 20, theme: Tema }); 

            addButton.click(function (event) {

                    // get the clicked row's data and initialize the input fields.
                    $("#idInput").val('');
                    $("#nombreInput").val('');
                    $("#descripcionInput").val('');
                    $("#cod_strInput").val('');
                    $("#tipoInput").val('');
                    $("#nivelInput").val('');
                    $('#ordenNumberInput').jqxNumberInput('clear');
                    $("#activoCheckBox").jqxCheckBox({ checked: false });  
                    $("#id_dash_configComboBox").jqxComboBox('clearSelection'); 
                    $("#id_dash_configComboBox").jqxComboBox('selectItem', 0 ); 
                      $('#configuracionTextArea').val('');
                      $('#txtIdDashConfig').val('');
                      $('#txtIndicador').val('');
                      $('#txtIdIndicador').val('');                      
                      $('#txtVariable_estadistica').val('');
                      $('#txtDescripcion').val('');

                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                    var offsetTabla = $("#DashMenuGrid").offset();
                    var anchoTabla = $("#DashMenuGrid").width();
                    var anchoPopup = $("#popupDashMenu").width(); 
                    var altoPopup = $("#popupDashMenu").height();
                    var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                    var posicionYpopup = parseInt(100+offsetTabla.top+80) - parseInt(altoPopup/2);
                    $("#popupDashMenu").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                    // show the popup window.
                    $("#popupDashMenu").jqxWindow('open');
                    Global_nuevo=true;
            });

            modifButton.click(function (event) {
                if (Global_editrow > -1) {

                    // get the clicked row's data and initialize the input fields.
                    var dataRecord = $("#DashMenuGrid").jqxGrid('getrowdata', Global_editrow);
                    $("#idInput").val(dataRecord.id);
                    $("#nombreInput").val(dataRecord.nombre);
                    $("#descripcionInput").val(dataRecord.descripcion);
                    $("#cod_strInput").val(dataRecord.cod_str);
                    $("#tipoInput").val(dataRecord.tipo); 
                    $("#nivelInput").val(dataRecord.nivel); 
                    $('#ordenNumberInput').val(dataRecord.orden); 
                    $("#activoCheckBox").jqxCheckBox({ checked: (dataRecord.activo.toString() === "true") }); // aveces dataRecord.activo es objeto

                      $('#configuracionTextArea').val('');
                      $('#txtIdDashConfig').val('');
                      $('#txtIndicador').val('');
                      $('#txtIdIndicador').val('');                      
                      $('#txtVariable_estadistica').val('');
                      $('#txtDescripcion').val('');
                    $("#id_dash_configComboBox").jqxComboBox('selectItem', dataRecord.id_dash_config ); 

                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                    var offsetTabla = $("#DashMenuGrid").offset();
                    var anchoTabla = $("#DashMenuGrid").width();
                    var anchoPopup = $("#popupDashMenu").width(); 
                    var altoPopup = $("#popupDashMenu").height();
                    var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                    var posicionYpopup = parseInt(Global_offsetFila+offsetTabla.top+80) - parseInt(altoPopup/2);
                    $("#popupDashMenu").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                    // show the popup window.
                    $("#popupDashMenu").jqxWindow('open');
                }
            });

            deleteButton.click(function (event) {
                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                var offsetTabla = $("#DashMenuGrid").offset();
                var anchoTabla = $("#DashMenuGrid").width();
                var anchoPopup = $("#popupDeleteConfirm").width(); 
                var altoPopup = $("#popupDeleteConfirm").height();
                var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                var posicionYpopup = parseInt(Global_offsetFila+offsetTabla.top+80) - parseInt(altoPopup/2);
                $("#popupDeleteConfirm").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                // show the popup window.
                $("#popupDeleteConfirm").jqxWindow('open');

            });

            reloadButton.click(function (event) {
                disableDelButtonAndAnothers();
                $('#DashMenuGrid').jqxGrid('updatebounddata','data');
            });

            searchButton.click(function (event) {
                disableDelButtonAndAnothers();
                $("#DashMenuGrid").jqxGrid('showfilterrow', true);

                var filter = $("#DashMenuGrid").jqxGrid('filterable');
                $("#DashMenuGrid").jqxGrid('filterable', !filter); // sw
                $("#DashMenuGrid").jqxGrid('clearfilters');

            });

            excelButton.click(function (event) {
                $("#DashMenuGrid").jqxGrid('exportdata', 'xls', 'Modulos');
            });

            pdfButton.click(function (event) {
                $("#DashMenuGrid").jqxGrid('exportdata', 'pdf', 'Modulos');
            });

        },
        columns: [
            { text: 'Nombre', dataField: 'nombre', width: 200, filtertype: 'input' },
            { text: 'Descripción', dataField: 'descripcion', width: 300 },
            { text: 'Tipo', dataField: 'tipo', width: 60 },
            { text: 'Código', dataField: 'cod_str', width: 100 },
            { text: 'Orden', dataField: 'orden', width: 60, cellsalign: 'center' },
            { text: 'Estado', dataField: 'activo', columntype: 'checkbox', filtertype: 'bool', cellsalign: 'center' }
        ],
        theme: Tema
    });



    $('#DashMenuGrid').on('rowclick', function (event) { // solo para obtener la coordenada Y de la fila
          var args = event.args;
          var boundIndex = args.rowindex;
          var visibleIndex = args.visibleindex;
          var rightclick = args.rightclick; 
          var ev = args.originalEvent; 

          Global_offsetFila = parseInt(event.args.row.top);
      
    });   
    
    function disableDelButtonAndAnothers(){
        if (deleteButton !== undefined) deleteButton.jqxButton({disabled: true });
        if (modifButton !== undefined) modifButton.jqxButton({disabled: true });
        var index = $("#DashMenuGrid").jqxGrid('getselectedrowindex');
        $('#DashMenuGrid').jqxGrid('unselectrow', index);
        $("#mensajesDashMenu").html('');
        Global_editrow = -1;
    };
   
    $('#DashMenuGrid').on('rowselect', function (event) { 
          var args = event.args;
          var rowBoundIndex = args.rowindex;
          var rowData = args.row;
          
          if (Global_Popup_listo) {
              deleteButton.jqxButton({disabled: false });  // Mostramos Boton Borrar
              modifButton.jqxButton({disabled: false });  // Mostramos Boton Modificar
          } else { 
            alert('faltan cargar datos...'); // es importante por que evita errores cuando los datos no esta bien cargados
          }

          Global_editrow = rowBoundIndex;
          $("#mensajesDashMenu").html("");             
    });   

    $('#DashMenuGrid').on('filter', function (event) {
        disableDelButtonAndAnothers();
    });   

    $('#DashMenuGrid').on('pagechanged', function (event) {
        disableDelButtonAndAnothers();
    });   

    $('#DashMenuGrid').on('sort', function (event) {  // esta evento se ejecuta antes que los botones esten creados 
        disableDelButtonAndAnothers();
    });   


//===========================================
//===== Desde aqui la ventana de Pop-up ===== 
//===========================================
    // initialize the input fields.
    // $("#name").jqxInput({ width: 150, height: 23, theme: Tema }); // no funca :(((

    $("#nombreInput").jqxInput({ theme: Tema });
    $("#nombreInput").width(320);
    $("#nombreInput").height(23);

    $("#descripcionInput").jqxInput({ theme: Tema });
    $("#descripcionInput").width(320);
    $("#descripcionInput").height(23);

    $("#cod_strInput").jqxInput({ theme: Tema });
    $("#cod_strInput").width(320);
    $("#cod_strInput").height(23);

    $("#tipoInput").jqxInput({ theme: Tema });
    $("#tipoInput").width(60);
    $("#tipoInput").height(23);

    $("#nivelInput").jqxInput({ theme: Tema });
    $("#nivelInput").width(60);
    $("#nivelInput").height(23);

    var quotes = [];
    quotes.push('algo');
    $('#configuracionTextArea').jqxTextArea({ placeHolder: 'Configuración', height: 90, width: 245, minLength: 1, source: quotes, theme: Tema });

    

    $("#ordenNumberInput").jqxNumberInput({spinMode: 'simple', width: 60, height: 23, min: 0, decimalDigits: 0, digits: 2, spinButtons: false, theme: Tema , promptChar: ' '});

    // Datos del Combobox
    var dashconfigsSourcePopup =
    {
        dataType: "json",
        dataFields: [
            { name: 'id', type: 'int' },
            { name: 'id_indicador', type: 'int' },
            { name: 'configuracion', type: 'string' },
            { name: 'variable_estadistica', type: 'string' },
            { name: 'descripcion', type: 'string' },
            { name: 'nombre_indicador', type: 'string' }
        ],
        url: './listadashconfigs' //, async: false
        
    };

    var Global_Popup_listo = false; // evita que se habra el popup sin no estan sus datos listos
    var dashconfigsAdapterPopup = new $.jqx.dataAdapter(dashconfigsSourcePopup, {
        loadComplete: function () {  // no deberia abrirse el popup su no estan estos datos
            Global_Popup_listo = true; 
        }
    });

    $('#id_dash_configComboBox').jqxComboBox({ selectedIndex: 0,  source: dashconfigsAdapterPopup, displayMember: "variable_estadistica", valueMember: "id", height: 23, width: 215, theme: Tema });

    $('#id_dash_configComboBox').on('change', function (event) {
        var args = event.args;
        if (args) {
            var source = $('#id_dash_configComboBox').jqxComboBox('source');
            var registros = source.getrecords();
            for(i=0; i<registros.length; i++) {
              if ( registros[i]['id'] == args.item.value ){
                $('#configuracionTextArea').val(registros[i]['configuracion']);
                $('#txtIdDashConfig').val(registros[i]['id']);
                $('#txtIndicador').val(registros[i]['nombre_indicador']);
                $('#txtIdIndicador').val(registros[i]['id_indicador']);
                $('#txtVariable_estadistica').val(registros[i]['variable_estadistica']);
                $('#txtDescripcion').val(registros[i]['descripcion']);
                break;
              }
            }
        }
       
    });

    $("#activoCheckBox").jqxCheckBox({ width: 25, height: 25, theme: Tema });   


    // initialize validator.
    $('#form').jqxValidator({
        // hintType: 'label',
        animationDuration: 500, // milisegundos
        theme: Tema,    
        rules: [
          { input: '#nombreInput', message: '¡El Nombre es necesario!', action: 'keyup, blur', rule: 'required' },
          { input: '#descripcionInput', message: '¡La Descripción es necesaria!', action: 'keyup, blur', rule: 'required' },
          { input: '#descripcionInput', message: '¡Debe contener entre 3 y 100 caracteres!', action: 'keyup', rule: 'length=3,100' },
          { input: '#cod_strInput', message: '¡El Código es necesario!', action: 'keyup, blur', rule: 'required' },
          { input: '#nivelInput', message: '¡El Nivel es necesario!', action: 'keyup, blur', rule: 'required' },
          { input: '#tipoInput', message: '¡El Tipo es necesario!', action: 'keyup, blur', rule: 'required' },
          
        ]
    });

    // initialize the popup window and buttons.
    $("#popupDashMenu").jqxWindow({
        width: 500, resizable: false,  isModal: true, autoOpen: false, cancelButton: $("#btnCancelPopup"), modalOpacity: 0.1, theme: Tema         
    });

    $("#popupDashMenu").on('open', function () {
        //$("#name").jqxInput('selectAll');
    });

    $("#popupDashMenu").on('close', function () {
        Global_nuevo=false;
        $('#form').jqxValidator('hide');
    });

 
    $("#btnCancelPopup").jqxButton({ width: 70, theme: Tema });
    $("#btnSavePopup").jqxButton({ width: 70, theme: Tema });
    // update the edited row when the user clicks the 'btnSavePopup' button.
    var Global_row;
    $("#btnSavePopup").click(function () {

        if (Global_editrow >= 0 || Global_nuevo) {

          var validationResult = function (isValid) {
            if (isValid) {
              $("#form").submit();

              var selIndex = $('#id_dash_configComboBox').jqxComboBox('selectedIndex');
              var itemCO = $("#id_dash_configComboBox").jqxComboBox('getItem', selIndex ); 

              if (Global_nuevo) {
  
                  var row = { id:0, cod_str: $("#cod_strInput").val(), nombre: $("#nombreInput").val(), descripcion: $("#descripcionInput").val(), nivel: $("#nivelInput").val(), tipo: $("#tipoInput").val(), orden: $('#ordenNumberInput').jqxNumberInput('getDecimal'), activo: $("#activoCheckBox").jqxCheckBox('checked'), id_dash_config: itemCO.value };
                  
                  // YA NO SE LO AÑADE AQUI POR QUE CAUSA PROBLEMAS POR QUE NO TIENE ID AUN   
                  //$("#DashMenuGrid").jqxGrid('addrow', null, row); // no tiene aun ID... se lo pondra cuando el sumit (asincrono) nos devuelva la respuesta

                  Global_row = row;
              } else {

                  var row = { cod_str: $("#cod_strInput").val(), nombre: $("#nombreInput").val(), descripcion: $("#descripcionInput").val(), nivel: $("#nivelInput").val(), tipo: $("#tipoInput").val(), orden: $('#ordenNumberInput').jqxNumberInput('getDecimal'), activo: $("#activoCheckBox").jqxCheckBox('checked'), id_dash_config: itemCO.value };

                  var rowID = $('#DashMenuGrid').jqxGrid('getrowid', Global_editrow);
                  $('#DashMenuGrid').jqxGrid('updaterow', rowID, row);
              }
              $("#popupDashMenu").jqxWindow('hide');
            }
         }
          
          $('#form').jqxValidator('validate', validationResult);

        }

    });

    // adjuntamos un manejador del submit al form
    $("#form").submit(function(event) {

      // Detenemos el envio normal del form
      event.preventDefault();

      // optenemos el atributo action del from ( <form action=""> )
      var $form = $( this ), url = $form.attr( 'action' );

      var parametros = $(this).serialize(); // serializamos los datos del form

      // Enviamos los datos usando post
      var posting = $.post( url, parametros );

      // evento: cuando los resultados son devueltos
      posting.done(function( data ) {
        var tipo_result = data.substring(0,2);
        if ( tipo_result == 'ID' ) {
          var ID = data.substring(3,data.indexOf("\n")) ;
          var mensaje = data.substring(data.indexOf("\n")+1, data.length-1);  
          $("#mensajesDashMenu").html(mensaje);      

          Global_row.id = parseInt(ID);  
          //$('#DashMenuGrid').jqxGrid('updaterow', 0, Global_row); // buscamos al que le pusimos 0 por ID

          $("#DashMenuGrid").jqxGrid('addrow', null, Global_row); // aqui nomas va tiene que ser la insercion al grip del registro, una vez que tenemos el ID

        } else {
          $("#mensajesDashMenu").html(data);   
        }
      });

      // evento: si hubo algun error
      posting.error(function( data ) {
          $("#mensajesDashMenu").html(data.responseText);   
      });

    });

//===========================================
//===== Hasta aqui la ventana de Pop-up ===== 
//===========================================

    $("#messageNotification").jqxNotification({ width: 250, position: "top-right", opacity: 0.9, autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info" });


//===================================================================
//===== Desde aqui la ventana de Confirmacion de borrado Pop-up ===== 
//===================================================================
    $('#popupDeleteConfirm').jqxWindow({
        position: { x: 50, y: 50},
        theme: Tema,
        maxHeight: 160, maxWidth: 280, minHeight: 30, minWidth: 250, height: 155, width: 270,
        resizable: false, isModal: true, autoOpen: false, modalOpacity: 0.3,
        okButton: $('#okDelete'), cancelButton: $('#cancelDelete'),
        initContent: function () {
            $('#okDelete').jqxButton({ width: '65px', theme: Tema });
            $('#cancelDelete').jqxButton({ width: '65px', theme: Tema });
            
        }
    }); 
    $('#popupDeleteConfirm').on('open', function (event) { $('#cancelDelete').focus(); }); // no esta funcando :(
        
    $("#okDelete").click(function () {
        var selectedrowindex = $("#DashMenuGrid").jqxGrid('getselectedrowindex');
        var rowscount = $("#DashMenuGrid").jqxGrid('getdatainformation').rowscount;
        var idRow = $("#DashMenuGrid").jqxGrid('getrowid', selectedrowindex);

        var dataRecord = $("#DashMenuGrid").jqxGrid('getrowdata', selectedrowindex);

        $("#DashMenuGrid").jqxGrid('deleterow', idRow);
        disableDelButtonAndAnothers();

        var parametros = { "id" : dataRecord.id,
                       "_token" : "{{ csrf_token() }}"
        };                
        
        $.ajax({
            type: "POST",
            url: "./borrardashmenu",
            data: parametros,
            success: function(datos){
                $("#mensajesDashMenu").html(datos);
            },
            error: function(result) {
                $("#mensajesDashMenu").html(result.responseText);
            }
        });
    });
 
//===================================================================
//===== Hasta aqui la ventana de Confirmacion de borrado Pop-up ===== 
//===================================================================

function guardarConfig(){
    $("#messageNotification").jqxNotification("open");
}

});  // FIN: $(document).ready(function () {



//========================================================
//===== Desde aqui la ventana de Confirmacion Pop-up ===== 
//========================================================
$(document).ready(function () {

  var Tema = 'ui-start';

  $('#ConfirmPopup').jqxWindow({ height: 110, theme: Tema, isModal: true, resizable: false, autoOpen: false,
      okButton: $('#btnOkConfirm'), cancelButton: $('#btnCancelConfirm'),
      initContent: function () {
          $('#btnOkConfirm').jqxButton({ width: '65px', theme: Tema });
          $('#btnCancelConfirm').jqxButton({ width: '65px', theme: Tema });
          $('#btnCancelConfirm').focus();
      }
  });

  $('#ConfirmPopup').on('close', function (event) {
      var obj = document.getElementById('ConfirmPopup');
      if (event.args.dialogResult.OK) {
        if ( typeof obj.functOk === 'function' ) obj.functOk();
      } else {
        if ( typeof obj.functCancel === 'function' ) obj.functCancel();
      }
  }); 
});

function abrirVentanaConfirmacion(elemento, txtCabecera, txtContenido, funcion_Ok, funcion_Cancel){
    if ( typeof txtCabecera === 'string' ) $("#cpHeader").html(txtCabecera);
    if ( typeof txtContenido === 'string' ) $("#cpContent").html(txtContenido);
    var obj = document.getElementById('ConfirmPopup');
    if ( typeof funcion_Ok === 'function' ) obj.functOk = funcion_Ok;
    if ( typeof funcion_Cancel === 'function' ) obj.functCancel = funcion_Cancel;
    $("#ConfirmPopup").jqxWindow('open');
}

//========================================================
//===== Hasta aqui la ventana de Confirmacion Pop-up ===== 
//========================================================



function funcionOk(){
    //Deshabilitamos los inputs del popup que no usaremos
    $("#nombreInput").prop('readonly', true); 
    $("#nombreInput").css("background", "#eeeeee");
    $("#descripcionInput").prop('readonly', true); 
    $("#descripcionInput").css("background", "#eeeeee");
    $("#cod_strInput").prop('readonly', true); 
    $("#cod_strInput").css("background", "#eeeeee");
    $("#nivelInput").prop('readonly', true); 
    $("#nivelInput").css("background", "#eeeeee");
    $("#tipoInput").prop('readonly', true); 
    $("#tipoInput").css("background", "#eeeeee");    
    $("#ordenNumberInput").jqxNumberInput({ disabled: true }); 
    $("#activoCheckBox").jqxCheckBox({ disabled: true });     
    $("#id_dash_configComboBox").jqxComboBox({ disabled: true }); 
    $("#btnSavePopup").jqxButton({ disabled: true }); 

    $("#iconoEditConfig").removeClass("glyphicon-edit").addClass( "glyphicon-saved" ); 
    $('#btnEditConfig').prop('title', 'Guardar Configuración'); //Editar Configuración

    //Habilitamos los inputs del popup que usaremos

    $("#configuracionTextAreaTextArea").prop('readonly', false);  
    var elem = document.getElementById('configuracionTextAreaTextArea'); 
    elem.style.setProperty('background-color', '#ffffff', 'important');
    $("#configuracionTextAreaTextArea").css("color", "#000000");

    $("#txtIndicador").prop('readonly', false);   
    $("#txtIndicador").css("background-color", "#ffffff");
    $("#txtIndicador").css("border-color", "#a6c9e2");
    $("#txtIndicador").css("color", "#000000");

    $('#txtVariable_estadistica').prop('readonly', false);  
    $("#txtVariable_estadistica").css("background-color", "#ffffff");
    $("#txtVariable_estadistica").css("border-color", "#a6c9e2");
    $("#txtVariable_estadistica").css("color", "#000000");

    $("#txtDescripcion").prop('readonly', false);  
    $("#txtDescripcion").css("background-color", "#ffffff");
    $("#txtDescripcion").css("border-color", "#a6c9e2");
    $("#txtDescripcion").css("color", "#000000");
     guardarConfig();

}

function funcionCancel(){
    //Habilitamos los inputs del popup que usaremos
    $("#nombreInput").prop('readonly', false); 
    $("#nombreInput").css("background", "");
    $("#descripcionInput").prop('readonly', false); 
    $("#descripcionInput").css("background", "");
    $("#cod_strInput").prop('readonly', false); 
    $("#cod_strInput").css("background", "");
    $("#nivelInput").prop('readonly', false); 
    $("#nivelInput").css("background", "");
    $("#tipoInput").prop('readonly', false); 
    $("#tipoInput").css("background", "");

    $("#ordenNumberInput").jqxNumberInput({ disabled: false }); 
    $("#activoCheckBox").jqxCheckBox({ disabled: false });     
    $("#id_dash_configComboBox").jqxComboBox({ disabled: false }); 
    $("#btnSavePopup").jqxButton({ disabled: false }); 

    $("#iconoEditConfig").removeClass("glyphicon-saved").addClass( "glyphicon-edit" );  //glyphicon-ok
    $('#btnEditConfig').prop('title', 'Editar Configuración'); //

    //Dehabilitamos los inputs del popup que no usaremos
    $("#configuracionTextAreaTextArea").prop('readonly', true);  
    var elem = document.getElementById('configuracionTextAreaTextArea'); 
    elem.style.setProperty('background-color', '#eeeeee', 'important'); // es por que tiene que ser !important y el $().css no lo tiene
    $("#configuracionTextAreaTextArea").css("color", "#777777");

    $("#txtIndicador").prop('readonly', true);   
    $("#txtIndicador").css("background-color", "#eeeeee");
    $("#txtIndicador").css("border-color", "#c7c7c7");
    $("#txtIndicador").css("color", "#777777");
    
    $('#txtVariable_estadistica').prop('readonly', true);  
    $("#txtVariable_estadistica").css("background-color", "#eeeeee");
    $("#txtVariable_estadistica").css("border-color", "#c7c7c7");
    $("#txtVariable_estadistica").css("color", "#777777");

    $("#txtDescripcion").prop('readonly', true);  
    $("#txtDescripcion").css("background-color", "#eeeeee");
    $("#txtDescripcion").css("border-color", "#c7c7c7");
    $("#txtDescripcion").css("color", "#777777");

}

function guardarConfig1(){

                $("#messageNotification").jqxNotification("open");
/*
    var id $('#txtIdDashConfig').val();
    var id_indicador = $('#txtIdIndicador').val();
    var configuracion $('#configuracionTextArea').val();
    var variable_estadistica = $('#txtVariable_estadistica').val();
    var descripcion = $('#txtDescripcion').val();

    var parametros = {  "_token" : "{{ csrf_token() }}",
                        "id": id,
                        "id_indicador": id_indicador,
                        "configuracion": configuracion,
                        "variable_estadistica": variable_estadistica,
                        "descripcion": descripcion,
                      };
    // Enviamos los datos usando post
    var posting = $.post( "./guardarmodulosrolesxxx", parametros );

    // evento: cuando los resultados son devueltos
    posting.done(function( data ) {
        $("#msgConfiguracion").html(data);   

            // $("#openMessageNotification, #openTimeNotification").jqxButton({ width: 230, height: 30 });
                $("#messageNotification").jqxNotification("open");

    });

    // evento: si hubo algun error
    posting.error(function( data ) {
        $("#msgConfiguracion").html(data.responseText);   
    });

    $("#popupRolModulos").jqxWindow('hide');
    */
}



// ==================================================================================================



function activarMenu(id,aux){
    $('#'+id).addClass('active');
    $('#'+aux).addClass('activeaux');
}

function menuModulosHideShow(ele){
  //1 hide
  //2 show
  switch (ele) {
    case 1:
      $("body").addClass("content-wrapper")
      $(".open-close i").removeClass('icon-arrow-left-circle');
      $(".sidebar").css("overflow", "inherit").parent().css("overflow", "visible");
    break;
    case 2:
      $("body").removeClass('content-wrapper');
      $(".open-close i").addClass('icon-arrow-left-circle');
      $(".logo span").show();
      break;
  }
}

$(document).ready(function(){
  activarMenu('x','mp-7');
  menuModulosHideShow(1)
});

</script>
@endpush