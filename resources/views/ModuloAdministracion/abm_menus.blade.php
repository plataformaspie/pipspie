@extends('layouts.plataforma')

@section('header')

<link rel="stylesheet" href="{{ asset('jqwidgets5.4.0/jqwidgets/styles/jqx.base.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets5.4.0/jqwidgets/styles/jqx.ui-start.css') }}" type="text/css" />

@endsection

@section('content')
  <div class="container" id="miContenedor"> 

    <div style="width: 1000px; height: 100%; margin-left: auto; margin-right: auto;"> <!-- Centrador --> 

        <h2>Listado de Menús</h2>
        <div id="MenusGrid">
        </div>
        <div id="mensajesMenus" style="width: 1000px; min-height:20px;"></div>

        <h4>Listado de Submenús</h4>
        <div id="SubMenusGrid">
        </div>

    </div> <!-- Centrador --> 

    <div id="popupMenu">
       <div>Menú</div>
       <div style="overflow: hidden;">
         <div id="mensajes"></div>
         <form id="formMenu" target="iframeInexistente"  method="post" action="guardarmenu" >
             <table class="tabla-ventana">
                 <tr>
                     <td align="right" style="color:#000000; width: 40%;">Título del Menú:</td>
                     <td><input name="titulo" type="text" id="tituloInput" /></td>
                     <input type="hidden" name="id" id="idInput" value="">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000">Descripción:</td>
                     <td><input name="descripcion" type="text" id="descripcionInput" /></td>
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000">Url:</td>
                     <td><input name="url" type="text" id="urlInput" /></td>
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000">Ícono:</td>
                     <td><input name="icono" type="text" id="iconoInput" /></td>
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000">Tipo Menú:</td>
                     <td><input name="tipo_menu" type="text" id="tipo_menuInput" /></td>
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000">Modulo:</td>
                     <td align="left"><div name="id_modulo"  id="id_moduloComboBox"></div></td>
                 </tr>
                 <tr>
                     <td align="right" style="color:#000000">Orden:</td>
                     <td align="left"><div name="orden"  id="ordenNumberInput"></div></td>
                 </tr> 
                 <tr>
                     <td align="right" style="color:#000000">Activo:</td>
                     <td align="left"><div name="activo"  id="activoCheckBox"></div></td>
                 </tr>
                 <tr>
                     <td align="right"></td>
                     <td style="padding-top: 10px;" align="right">
                         <input style="margin-right: 5px;" type="button" id="Save" value="Guardar" />
                         <input id="Cancel" type="button" value="Cerrar" />
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


    <div id="popupSubmenu">
        <div>Submenú</div>
        <div style="overflow: hidden;">
          <div id="mensajes"></div>
          <form id="formSubmenu" target="iframeInexistente"  method="post" action="guardarsubmenu" >
              <table class="tabla-ventana">
                  <tr>
                      <td align="right" style="color:#000000; width: 40%;">Título del Submenú:</td>
                      <td><input name="titulo" type="text" id="tituloInputSM" /></td>
                      <input type="hidden" name="id" id="idInputSM" value="">
                      <input type="hidden" name="id_menu" id="id_menuInputSM" value="">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </tr>
                  <tr>
                      <td align="right" style="color:#000000">Descripción:</td>
                      <td><input name="descripcion" type="text" id="descripcionInputSM" /></td>
                  </tr>
                  <tr>
                      <td align="right" style="color:#000000">Url:</td>
                      <td><input name="url" type="text" id="urlInputSM" /></td>
                  </tr>
                  <tr>
                      <td align="right" style="color:#000000">Ícono:</td>
                      <td><input name="icono" type="text" id="iconoInputSM" /></td>
                  </tr>
                  <tr>
                      <td align="right" style="color:#000000">Tipo Menú:</td>
                      <td><input name="tipo_menu" type="text" id="tipo_menuInputSM" /></td>
                  </tr>
                  <tr>
                      <td align="right" style="color:#000000">Orden:</td>
                      <td align="left"><div name="orden"  id="ordenNumberInputSM"></div></td>
                  </tr> 
                  <tr>
                      <td align="right" style="color:#000000">Activo:</td>
                      <td align="left"><div name="activo"  id="activoCheckBoxSM"></div></td>
                  </tr>
                  <tr>
                      <td align="right"></td>
                      <td style="padding-top: 10px;" align="right">
                          <input style="margin-right: 5px;" type="button" id="SaveSM" value="Guardar" />
                          <input id="CancelSM" type="button" value="Cerrar" />
                      </td>
                  </tr>
              </table>
          </form>
        </div>
    </div>

    <div id="popupDeleteConfirmSM">
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
              <input type="button" id="okDeleteSM" value="OK" style="margin-right: 10px" />
              <input type="button" id="cancelDeleteSM" value="Cancelar" />
          </div>
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
    
    .text-input-popup {
        height: 23px;
        width: 150px;
    }    
    
    .clase-iframe {
        border: none;
        clear: both;
        /*display: none;*/
        height: 50px;
        width: 100px;
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

    .container{
        width: 100% !important; /* para que en los celulares salga mas optimizada la pantalla */
    }

    #pagerMenusGrid > div{
        width: 400px !important;
    }

  </style>

<script type="text/javascript">

// ==================================================================================================

var Global_offsetFila = 0;  // en este caso tiene que ser global para todo el html
var Global_offsetFilaSM = 0;  // en este caso tiene que ser global para todo el html
var Global_rowSM;
var Global_rowIndexSM = -1;

$(document).ready(function () {

    var Tema = 'ui-start';
    var Global_rowIndex = -1;
    var modifButton;
    var deleteButton;
    var Registros;
    var url = "./listamenus2";

    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id', type: 'string' },
            { name: 'descripcion', type: 'string' },
            { name: 'url', type: 'string' },
            { name: 'activo', type: 'bool' },
            { name: 'titulo', type: 'string' },
            { name: 'icono', type: 'string' },
            { name: 'tipo_menu', type: 'string' },
            { name: 'orden', type: 'int' },
            { name: 'id_modulo', type: 'int' },
            { name: 'modulo', type: 'string' }

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

    $("#MenusGrid").jqxGrid(
    {
        width: 1000,
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
            // $("#MenusGrid").jqxGrid('sortby', 'name', 'asc'); ya no es necesario, se hace desde la BD
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
                    $("#idInput").val(0); 
                    $("#tituloInput").val('');
                    $("#descripcionInput").val('');
                    $("#urlInput").val('');
                    $("#iconoInput").val('');
                    $("#tipo_menuInput").val(''); 
                    $('#ordenNumberInput').jqxNumberInput('clear');
                    $("#id_moduloComboBox").jqxComboBox('clearSelection'); 
                    $("#activoCheckBox").jqxCheckBox({ checked: false });                 


                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                    var offsetTabla = $("#MenusGrid").offset();
                    var anchoTabla = $("#MenusGrid").width();
                    var anchoPopup = $("#popupMenu").width(); 
                    var altoPopup = $("#popupMenu").height();
                    var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                    var posicionYpopup = parseInt(100+offsetTabla.top+80) - parseInt(altoPopup/2);
                    $("#popupMenu").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                    // show the popup window.
                    $("#popupMenu").jqxWindow('open');
            });

            modifButton.click(function (event) {
                if (Global_rowIndex > -1) {

                    // get the clicked row's data and initialize the input fields.
                    var dataRecord = $("#MenusGrid").jqxGrid('getrowdata', Global_rowIndex);
                    $("#idInput").val(dataRecord.id);
                    $("#tituloInput").val(dataRecord.titulo);
                    $("#descripcionInput").val(dataRecord.descripcion);
                    $("#urlInput").val(dataRecord.url);
                    $("#iconoInput").val(dataRecord.icono);
                    $("#tipo_menuInput").val(dataRecord.tipo_menu); 
                    $('#ordenNumberInput').val(dataRecord.orden); 
                    $("#id_moduloComboBox").jqxComboBox('selectItem', dataRecord.id_modulo ); 
                    $("#activoCheckBox").jqxCheckBox({ checked: (dataRecord.activo.toString() === "true") }); // aveces dataRecord.activo es objeto


                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                    var offsetTabla = $("#MenusGrid").offset();
                    var anchoTabla = $("#MenusGrid").width();
                    var anchoPopup = $("#popupMenu").width(); 
                    var altoPopup = $("#popupMenu").height();
                    var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                    var posicionYpopup = parseInt(Global_offsetFila+offsetTabla.top+80) - parseInt(altoPopup/2);
                    $("#popupMenu").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                    // show the popup window.
                    $("#popupMenu").jqxWindow('open');
                }
            });

            deleteButton.click(function (event) {
                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                var offsetTabla = $("#MenusGrid").offset();
                var anchoTabla = $("#MenusGrid").width();
                var anchoPopup = $("#popupDeleteConfirm").width(); 
                var altoPopup = $("#popupDeleteConfirm").height();
                var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                var posicionYpopup = parseInt(Global_offsetFila+offsetTabla.top+80) - parseInt(altoPopup/2);
                $("#popupDeleteConfirm").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                // show the popup window.
                $("#popupDeleteConfirm").jqxWindow('open');

/*   Este codigo ya esta en el boton de confirmacion de boprrado                
                var selectedrowindex = $("#MenusGrid").jqxGrid('getselectedrowindex');
                var rowscount = $("#MenusGrid").jqxGrid('getdatainformation').rowscount;
                var idRow = $("#MenusGrid").jqxGrid('getrowid', selectedrowindex);

                var dataRecord = $("#MenusGrid").jqxGrid('getrowdata', selectedrowindex);

                $("#MenusGrid").jqxGrid('deleterow', idRow);
                disableDelButtonAndAnothers();

                var parametros = { "id" : dataRecord.id,
                                   "_token" : "{{ csrf_token() }}"
                };                
                $.ajax({
                  type: "POST",
                  url: "./borrarmenu",
                  data: parametros,
                  success: function(datos){
                    $("#mensajesMenus").html(datos);
                  },
                  error: function(result) {
                    $("#mensajesMenus").html(result.responseText);
                  }
                });
*/
            });

            reloadButton.click(function (event) {
                disableDelButtonAndAnothers();
                $('#MenusGrid').jqxGrid('updatebounddata','data');
            });

            searchButton.click(function (event) {
                disableDelButtonAndAnothers();
                $("#MenusGrid").jqxGrid('showfilterrow', true);

                var filter = $("#MenusGrid").jqxGrid('filterable');
                $("#MenusGrid").jqxGrid('filterable', !filter); // sw
                $("#MenusGrid").jqxGrid('clearfilters');

            });

            excelButton.click(function (event) {
                $("#MenusGrid").jqxGrid('exportdata', 'xls', 'Menus');
            });

            pdfButton.click(function (event) {
                $("#MenusGrid").jqxGrid('exportdata', 'pdf', 'Menus');
            });

        },
        columns: [
            { text: 'Nombre Menú', dataField: 'titulo', width: 175, filtertype: 'input' },
            { text: 'Url', dataField: 'url', width: 195 },
            { text: 'Descripción', dataField: 'descripcion', width: 145 },
            { text: 'Ícono', dataField: 'icono', width: 95 },
            { text: 'Tipo', dataField: 'tipo_menu', width: 75, filtertype: 'checkedlist' },
            { text: 'Orden', dataField: 'orden', width: 55, cellsalign: 'center' },
            { text: 'Módulo', datafield: 'modulo', width: 145, filtertype: 'checkedlist' },            
            { text: 'Estado', dataField: 'activo', columntype: 'checkbox', filtertype: 'bool', cellsalign: 'center' },
            { text: '<i class="glyphicon glyphicon-th-list"></i>', columntype: 'custom', datafield: 'id', width: 36, cellsalign: 'center', filterable: false,
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                        return "<button onClick='abriryconfigurarPopupSubmenu(" + value + ",-1);' type='button' title='Adicionar Submenú' id='btnAddSubmenu' class='jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-fill-state-fred-ui-start' style='margin-top: 2px; margin-left: 4px; height: 25px; width: 25px; padding: 0px 0px 0px 1px;'><i class='glyphicon glyphicon-plus'></i></button>";
                    }, 
            }                    

        ],
        theme: Tema
    });


    $('#MenusGrid').on('rowclick', function (event) { // solo para obtener la coordenada Y de la fila
          var args = event.args;
          var boundIndex = args.rowindex;
          var visibleIndex = args.visibleindex;
          var rightclick = args.rightclick; 
          var ev = args.originalEvent; 

          Global_offsetFila = parseInt(event.args.row.top);

    /*    // Inspecciona un Objeto de javascript 
        var msg = '';
        for (var property in obj )
        {
          if (typeof obj[property] == 'function')
          {
            var inicio = obj[property].toString().indexOf('function');
            var fin = obj[property].toString().indexOf(')')+1;
            var propertyValue=obj[property].toString().substring(inicio,fin);
            msg +=(typeof obj[property])+' '+property+' : '+propertyValue+' ;\n';
          }
          else if (typeof obj[property] == 'unknown')
          {
            msg += 'unknown '+property+' : unknown ;\n';
          }
          else
          {
            msg +=(typeof obj[property])+' '+property+' : '+obj[property]+' ;\n';
          }
        }
        alert(msg);
    */        
    });   
    
    function disableDelButtonAndAnothers(){
        if (deleteButton !== undefined) deleteButton.jqxButton({disabled: true });
        if (modifButton !== undefined) modifButton.jqxButton({disabled: true });
        var index = $("#MenusGrid").jqxGrid('getselectedrowindex');
        $('#MenusGrid').jqxGrid('unselectrow', index);
        $("#mensajesMenus").html('');
        Global_rowIndex = -1;
    };
   
    $('#MenusGrid').on('rowselect', function (event) { 
          var args = event.args;
          var rowBoundIndex = args.rowindex;
          var rowData = args.row;
          
          if (Global_Popup_listo) {
              deleteButton.jqxButton({disabled: false });  // Mostramos Boton Borrar
              modifButton.jqxButton({disabled: false });  // Mostramos Boton Modificar
          } else { 
            alert('faltan cargar datos...'); // es importante por que evita errores cuando los datos no esta bien cargados
          }

          Global_rowIndex = rowBoundIndex;
          $("#mensajesMenus").html("");             
    });   

    $('#MenusGrid').on('filter', function (event) {
        disableDelButtonAndAnothers();
    });   

    $('#MenusGrid').on('pagechanged', function (event) {
        disableDelButtonAndAnothers();
    });   

    $('#MenusGrid').on('sort', function (event) {  // esta evento se ejecuta antes que los botones esten creados 
        disableDelButtonAndAnothers();
    });   

//===========================================
//===== Desde aqui el Detalle: Submenus ===== 
//===========================================

    var url = "./listasubmenus";
    // preparacion de los datos
    var Global_dataFieldsSubmenus = [
            { name: 'id', type: 'string' },
            { name: 'descripcion', type: 'string' },
            { name: 'url', type: 'string' },
            { name: 'activo', type: 'string' },
            { name: 'titulo', type: 'string' },
            { name: 'icono', type: 'string' },
            { name: 'tipo_menu', type: 'string' },
            { name: 'orden', type: 'int' },
            { name: 'id_menu', type: 'int' }
    ];

    var sourceSubmenus = {
        datatype: "json",
        datafields: Global_dataFieldsSubmenus,
        id: 'id',
        url: url
    };

    var dataAdapterSubmenus = new $.jqx.dataAdapter(sourceSubmenus);

    dataAdapterSubmenus.dataBind();

    $("#SubMenusGrid").jqxGrid(
    {
        width: 1000,
        //source: dataAdapterSubmenus,
        autoheight: true,
        keyboardnavigation: false,
        columns: [
            { text: 'Nombre Submenú', dataField: 'titulo', width: 180 },
            { text: 'Url', dataField: 'url', width: 250 },
            { text: 'Descripción', dataField: 'descripcion', width: 200 },
            { text: 'Ícono', dataField: 'icono', width: 100 },
            { text: 'Tipo', dataField: 'tipo_menu', width: 80 },
            { text: 'Orden', dataField: 'orden', width: 60, cellsalign: 'center' },
            { text: 'Estado', dataField: 'activo', cellsalign: 'center' },
            { text: 'Acción', columntype: 'custom', datafield: 'id', width: 62, cellsalign: 'center',
                    cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
                        return "<button onClick='abriryconfigurarPopupSubmenu(0," + row + ");' type='button' title='Editar Submenú' id='btnEditSubmenu' class='jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-fill-state-fred-ui-start' style='margin-top: 2px; margin-left: 5px; height: 25px; width: 25px; padding: 0px 0px 0px 1px;'><i class='glyphicon glyphicon-pencil'></i></button><button onClick='abrirPopupBorrar(" + row + ");' type='button' title='Borrar Submenú' id='btnDelSubmenu' class='jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-fill-state-fred-ui-start' style='margin-top: 2px; margin-left: 3px; height: 25px; width: 25px; padding: 0px 0px 0px 1px;'><i class='glyphicon glyphicon-remove'></i></button>";
                    }, 
            }                    
        ],
        localization: getLocalization('es'),
        theme: Tema
    });

    $('#SubMenusGrid').on('rowclick', function (event) { // solo para obtener la coordenada Y de la fila
          Global_offsetFilaSM = parseInt(event.args.row.top);
    });  

    $('#SubMenusGrid').on('rowselect', function (event) { 
        Global_rowIndexSM = event.args.rowindex;
        //$("#mensajesMenus").html("");             
    }); 

    $("#MenusGrid").on('rowselect', function (event) {  // Esto hace el Master/Detalle
        var padreID = event.args.row.id;  // id padre
        var records = new Array();
        var length = dataAdapterSubmenus.records.length;
        for (var i = 0; i < length; i++) {
            var record = dataAdapterSubmenus.records[i];
            if (record.id_menu == padreID) {
                records[records.length] = record;
            }
        }
        var dataSource = {
            datafields: Global_dataFieldsSubmenus,
            localdata: records
        }        
        var adapter = new $.jqx.dataAdapter(dataSource);
   
        // update data source.
        $("#SubMenusGrid").jqxGrid({ source: adapter });
    });


//===========================================
//===== Hasta aqui el Detalle: Submenus ===== 
//===========================================



//===========================================
//===== Desde aqui la ventana de Pop-up ===== 
//===========================================
    // initialize the input fields.
    // $("#name").jqxInput({ width: 150, height: 23, theme: Tema }); // no funca :(((

    $("#tituloInput").jqxInput({ theme: Tema });
    $("#tituloInput").width(240);
    $("#tituloInput").height(23);

    $("#descripcionInput").jqxInput({ theme: Tema });
    $("#descripcionInput").width(240);
    $("#descripcionInput").height(23);

    $("#urlInput").jqxInput({ theme: Tema });
    $("#urlInput").width(240);
    $("#urlInput").height(23);

    $("#iconoInput").jqxInput({ theme: Tema });
    $("#iconoInput").width(240);
    $("#iconoInput").height(23);

    $("#tipo_menuInput").jqxInput({ theme: Tema });
    $("#tipo_menuInput").width(240);
    $("#tipo_menuInput").height(23);

    $("#ordenNumberInput").jqxNumberInput({spinMode: 'simple', width: 50, height: 23, min: 0, decimalDigits: 0, digits: 2, spinButtons: false, theme: Tema , promptChar: ' '});

    // Datos del Combobox
    var rolesSourcePopup =
    {
        dataType: "json",
        dataFields: [
            { name: 'modulo'},
            { name: 'id'}
        ],
        url: './listamodulos_mnu' //, async: false
    };

    var Global_Popup_listo = false; // evita que se habra el popup sin no estan sus datos listos
    var modulosAdapterPopup = new $.jqx.dataAdapter(rolesSourcePopup, {
        loadComplete: function () {  // no deberia abrirse el popup su no estan estos datos
            Global_Popup_listo = true; 
        }
    });

    $('#id_moduloComboBox').jqxComboBox({ selectedIndex: 0,  source: modulosAdapterPopup, displayMember: "modulo", valueMember: "id", height: 23, width: 200, theme: Tema });

    $("#activoCheckBox").jqxCheckBox({ width: 120, height: 25, theme: Tema });   

    // initialize validator.
    $('#formMenu').jqxValidator({
               // hintType: 'label',
                animationDuration: 500, // milisegundos
                theme: Tema,    
      rules: [
        { input: '#tituloInput', message: '¡El Nombre del Menú es necesario!', action: 'keyup, blur', rule: 'required' },
        { input: '#descripcionInput', message: '¡La Descripción es necesaria!', action: 'keyup, blur', rule: 'required' },
        { input: '#descripcionInput', message: '¡Debe contener entre 3 y 100 caracteres!', action: 'keyup', rule: 'length=3,100' },
        { input: '#urlInput', message: '¡El Url es necesario!', action: 'keyup, blur', rule: 'required' },
        { input: '#urlInput', message: '¡La Url es necesaria!', action: 'keyup, blur', rule: 'required' },
        { input: '#iconoInput', message: '¡El Ícono es necesario!', action: 'keyup, blur', rule: 'required' },
        { input: '#tipo_menuInput', message: '¡El Tipo es necesario!', action: 'keyup, blur', rule: 'required' },        
        { input: '#id_moduloComboBox', message: '¡El Módulo es necesario!', action: 'change', rule: 
            function (input, commit) {
              if (input.val() == '' ) {
                return false;
              }
              return true;
            }
        }

      ]
    });

    // initialize the popup window and buttons.
    $("#popupMenu").jqxWindow({
        width: 450, resizable: false,  isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.1, theme: Tema         
    });

    $("#popupMenu").on('open', function () {
        //$("#name").jqxInput('selectAll');
    });

    $("#popupMenu").on('close', function () {
        $('#formMenu').jqxValidator('hide');
    });

 
    $("#Cancel").jqxButton({ width: 70, theme: Tema });
    $("#Save").jqxButton({ width: 70, theme: Tema });
    // update the edited row when the user clicks the 'Save' button.
    var Global_row;
    $("#Save").click(function () {

     //   if (Global_rowIndex >= 0 || Global_nuevo) {

          var validationResult = function (isValid) {
            if (isValid) {
              $("#formMenu").submit();

              var selIndex = $('#id_moduloComboBox').jqxComboBox('selectedIndex');
              var itemMO = $("#id_moduloComboBox").jqxComboBox('getItem', selIndex ); 

              if ( $("#idInput").val()=='0' ) { // Nuevo

                  var row = { id:0, titulo: $("#tituloInput").val(), descripcion: $("#descripcionInput").val(), url: $("#urlInput").val(), icono: $("#iconoInput").val(), tipo_menu: $("#tipo_menuInput").val(), orden: $('#ordenNumberInput').jqxNumberInput('getDecimal'), id_modulo: itemMO.value, modulo: itemMO.label, activo: $("#activoCheckBox").jqxCheckBox('checked')
                  };
                  
                  // YA NO SE LO AÑADE AQUI POR QUE CAUSA PROBLEMAS POR QUE NO TIENE ID AUN   
                  //$("#MenusGrid").jqxGrid('addrow', null, row); // no tiene aun ID... se lo pondra cuando el sumit (asincrono) nos devuelva la respuesta

                  Global_row = row;
              } else {  // Modificacion

                  var row = { titulo: $("#tituloInput").val(), descripcion: $("#descripcionInput").val(), url: $("#urlInput").val(), icono: $("#iconoInput").val(), tipo_menu: $("#tipo_menuInput").val(), orden: $('#ordenNumberInput').jqxNumberInput('getDecimal'), id_modulo: itemMO.value, modulo: itemMO.label, activo: $("#activoCheckBox").jqxCheckBox('checked')
                  };

                  var rowID = $('#MenusGrid').jqxGrid('getrowid', Global_rowIndex);
                  $('#MenusGrid').jqxGrid('updaterow', rowID, row);
              }
              $("#popupMenu").jqxWindow('hide');
            }
         }
          
          $('#formMenu').jqxValidator('validate', validationResult);

    //    }

    });

    // adjuntamos un manejador del submit al form
    $("#formMenu").submit(function(event) {

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
          $("#mensajesMenus").html(mensaje);      

          Global_row.id = parseInt(ID);  
          //$('#MenusGrid').jqxGrid('updaterow', 0, Global_row); // buscamos al que le pusimos 0 por ID

          $("#MenusGrid").jqxGrid('addrow', null, Global_row); // aqui nomas va tiene que ser la insercion al grip del registro, una vez que tenemos el ID

        } else {
          $("#mensajesMenus").html(data);   
        }
      });

      // evento: si hubo algun error
      posting.error(function( data ) {
          $("#mensajesMenus").html(data.responseText);   
      });

    });

//===========================================
//===== Hasta aqui la ventana de Pop-up ===== 
//===========================================


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
        var selectedrowindex = $("#MenusGrid").jqxGrid('getselectedrowindex');
        var rowscount = $("#MenusGrid").jqxGrid('getdatainformation').rowscount;
        var idRow = $("#MenusGrid").jqxGrid('getrowid', selectedrowindex);

        var dataRecord = $("#MenusGrid").jqxGrid('getrowdata', selectedrowindex);

        $("#MenusGrid").jqxGrid('deleterow', idRow);
        disableDelButtonAndAnothers();

        var parametros = { "id" : dataRecord.id,
                       "_token" : "{{ csrf_token() }}"
        };                
        
        $.ajax({
            type: "POST",
            url: "./borrarmenu",
            data: parametros,
            success: function(datos){
                $("#mensajesMenus").html(datos);
            },
            error: function(result) {
                $("#mensajesMenus").html(result.responseText);
            }
        });
    });
//===================================================================
//===== Hasta aqui la ventana de Confirmacion de borrado Pop-up ===== 
//===================================================================


//=======================================================
//===== Desde aqui la ventana de Pop-up del Submenu ===== 
//=======================================================
    // initialize the input fields.
    // $("#name").jqxInput({ width: 150, height: 23, theme: Tema }); // no funca :(((

    $("#tituloInputSM").jqxInput({ theme: Tema });
    $("#tituloInputSM").width(240);
    $("#tituloInputSM").height(23);

    $("#descripcionInputSM").jqxInput({ theme: Tema });
    $("#descripcionInputSM").width(240);
    $("#descripcionInputSM").height(23);

    $("#urlInputSM").jqxInput({ theme: Tema });
    $("#urlInputSM").width(240);
    $("#urlInputSM").height(23);

    $("#iconoInputSM").jqxInput({ theme: Tema });
    $("#iconoInputSM").width(240);
    $("#iconoInputSM").height(23);

    $("#tipo_menuInputSM").jqxInput({ theme: Tema });
    $("#tipo_menuInputSM").width(240);
    $("#tipo_menuInputSM").height(23);

    $("#ordenNumberInputSM").jqxNumberInput({spinMode: 'simple', width: 50, height: 23, min: 0, decimalDigits: 0, digits: 2, spinButtons: false, theme: Tema , promptChar: ' '});

    $("#activoCheckBoxSM").jqxCheckBox({ width: 120, height: 25, theme: Tema });   

    // initialize validator.
    $('#formSubmenu').jqxValidator({
               // hintType: 'label',
                animationDuration: 500, // milisegundos
                theme: Tema,    
      rules: [
        { input: '#tituloInputSM', message: '¡El Nombre del Submenú es necesario!', action: 'keyup, blur', rule: 'required' },
        { input: '#descripcionInputSM', message: '¡La Descripción es necesaria!', action: 'keyup, blur', rule: 'required' },
        { input: '#descripcionInputSM', message: '¡Debe contener entre 3 y 100 caracteres!', action: 'keyup', rule: 'length=3,100' },
        { input: '#urlInputSM', message: '¡El Url es necesario!', action: 'keyup, blur', rule: 'required' },
        { input: '#urlInputSM', message: '¡La Url es necesaria!', action: 'keyup, blur', rule: 'required' },
        { input: '#iconoInputSM', message: '¡El Ícono es necesario!', action: 'keyup, blur', rule: 'required' },
        { input: '#tipo_menuInputSM', message: '¡El Tipo es necesario!', action: 'keyup, blur', rule: 'required' }

      ]
    });

    // initialize the popup window and buttons.
    $("#popupSubmenu").jqxWindow({
        width: 450, resizable: false,  isModal: true, autoOpen: false, cancelButton: $("#CancelSM"), modalOpacity: 0.1, theme: Tema         
    });

    $("#popupSubmenu").on('open', function () {
        //$("#name").jqxInput('selectAll');
    });

    $("#popupSubmenu").on('close', function () {
        $('#formSubmenu').jqxValidator('hide');
    });

 
    $("#CancelSM").jqxButton({ width: 70, theme: Tema });
    $("#SaveSM").jqxButton({ width: 70, theme: Tema });
    // update the edited row when the user clicks the 'Save' button.

    $("#SaveSM").click(function () { 

          var validationResult = function (isValid) {
            if (isValid) {
              $("#formSubmenu").submit();

              if ( $("#idInputSM").val() == '0' ) {

                  var row = { id:0, titulo: $("#tituloInputSM").val(), descripcion: $("#descripcionInputSM").val(), url: $("#urlInputSM").val(), icono: $("#iconoInputSM").val(), tipo_menu: $("#tipo_menuInputSM").val(), orden: $('#ordenNumberInputSM').jqxNumberInput('getDecimal'), id_menu: $("#id_menuInputSM").val(), activo: $("#activoCheckBoxSM").jqxCheckBox('checked')
                  };
                  
                  // YA NO SE LO AÑADE AQUI POR QUE CAUSA PROBLEMAS POR QUE NO TIENE ID AUN   
                  //$("#MenusGrid").jqxGrid('addrow', null, row); // no tiene aun ID... se lo pondra cuando el sumit (asincrono) nos devuelva la respuesta

                  Global_rowSM = row;
              } else {

                  var row = { id: $("#idInputSM").val(), 
                              titulo: $("#tituloInputSM").val(), descripcion: $("#descripcionInputSM").val(), url: $("#urlInputSM").val(), icono: $("#iconoInputSM").val(), tipo_menu: $("#tipo_menuInputSM").val(), orden: $('#ordenNumberInputSM').jqxNumberInput('getDecimal'), id_menu: $("#id_menuInputSM").val(), activo: $("#activoCheckBoxSM").jqxCheckBox('checked')
                  };

                  var rowID = $('#SubMenusGrid').jqxGrid('getrowid', Global_rowIndexSM);
                  $('#SubMenusGrid').jqxGrid('updaterow', rowID, row);

                  // Remplazamos registro a la lista temporal de submenus
                  var length = dataAdapterSubmenus.records.length;
                  for (var i = 0; i < length; i++) {
                      var record = dataAdapterSubmenus.records[i];
                      if (record.id == row.id) {
                          dataAdapterSubmenus.records[i] = row;
                          break;
                      }
                  }

              }
              $("#popupSubmenu").jqxWindow('hide');
            }
         }
          
          $('#formSubmenu').jqxValidator('validate', validationResult);

    });

    // adjuntamos un manejador del submit al form
    $("#formSubmenu").submit(function(event) {

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
          $("#mensajesMenus").html(mensaje);      

          Global_rowSM.id = parseInt(ID);  
          //$('#SubMenusGrid').jqxGrid('updaterow', 0, Global_rowSM); // buscamos al que le pusimos 0 por ID

          $("#SubMenusGrid").jqxGrid('addrow', null, Global_rowSM); // aqui nomas va tiene que ser la insercion al grip del registro, una vez que tenemos el ID

          // Adicionamos a la lista temporal de submenus
          var length = dataAdapterSubmenus.records.length;
          dataAdapterSubmenus.records[length] = Global_rowSM;

        } else {
          $("#mensajesMenus").html(data);   
        }
      });

      // evento: si hubo algun error
      posting.error(function( data ) {
          $("#mensajesMenus").html(data.responseText);   
      });

    });

//=======================================================
//===== Hasta aqui la ventana de Pop-up del Submenu ===== 
//=======================================================


//===========================================================================
//===== Desde aqui la ventana de Confirmacion de borrado Pop-up Submenu ===== 
//===========================================================================
    $('#popupDeleteConfirmSM').jqxWindow({
        position: { x: 50, y: 50},
        theme: Tema,
        maxHeight: 160, maxWidth: 280, minHeight: 30, minWidth: 250, height: 155, width: 270,
        resizable: false, isModal: true, autoOpen: false, modalOpacity: 0.3,
        okButton: $('#okDeleteSM'), cancelButton: $('#cancelDeleteSM'),
        initContent: function () {
            $('#okDeleteSM').jqxButton({ width: '65px', theme: Tema });
            $('#cancelDeleteSM').jqxButton({ width: '65px', theme: Tema });
            
        }
    }); 
    $('#popupDeleteConfirmSM').on('open', function (event) { $('#cancelDeleteSM').focus(); }); // no esta funcando :(
        
    $("#okDeleteSM").click(function () {
        var selectedrowindex = $("#SubMenusGrid").jqxGrid('getselectedrowindex');
        var rowscount = $("#SubMenusGrid").jqxGrid('getdatainformation').rowscount;
        var idRow = $("#SubMenusGrid").jqxGrid('getrowid', selectedrowindex);

        var dataRecord = $("#SubMenusGrid").jqxGrid('getrowdata', selectedrowindex);

        $("#SubMenusGrid").jqxGrid('deleterow', idRow);

        // Eliminamos registro a la lista temporal de submenus
        var length = dataAdapterSubmenus.records.length;
        for (var i = 0; i < length; i++) {
            var record = dataAdapterSubmenus.records[i];
            if (record.id == dataRecord.id) {
                dataAdapterSubmenus.records.splice(i, 1);
                break;
            }
        }

        disableDelButtonAndAnothers();

        var parametros = { "id" : dataRecord.id,
                       "_token" : "{{ csrf_token() }}"
        };                
        
        $.ajax({
            type: "POST",
            url: "./borrarsubmenu",
            data: parametros,
            success: function(datos){
                $("#mensajesMenus").html(datos);
            },
            error: function(result) {
                $("#mensajesMenus").html(result.responseText);
            }
        });
    });
//===========================================================================
//===== Hasta aqui la ventana de Confirmacion de borrado Pop-up Submenu ===== 
//===========================================================================


});  // FIN: $(document).ready(function () {


    function abriryconfigurarPopupSubmenu(idPadre,editRow){

        if ( editRow < 0 ) {  // Nuevo
            // get the clicked row's data and initialize the input fields.
            $("#idInputSM").val(0);
            $("#id_menuInputSM").val(idPadre);
            $("#tituloInputSM").val('');
            $("#descripcionInputSM").val('');
            $("#urlInputSM").val('');
            $("#iconoInputSM").val('');
            $("#tipo_menuInputSM").val(''); 
            $('#ordenNumberInputSM').jqxNumberInput('clear');
            $("#activoCheckBoxSM").jqxCheckBox({ checked: false });                 

            // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
            var offsetTabla = $("#MenusGrid").offset();
            var anchoTabla = $("#MenusGrid").width();
            var anchoPopup = $("#popupSubmenu").width(); 
            var altoPopup = $("#popupSubmenu").height();
            var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
            var posicionYpopup = parseInt(Global_offsetFila+offsetTabla.top+80) - parseInt(altoPopup/2);
        } else { // Edicion/modificar
            // get the clicked row's data and initialize the input fields.
            var dataRecord = $("#SubMenusGrid").jqxGrid('getrowdata', editRow);
            $("#idInputSM").val(dataRecord.id);
            $("#id_menuInputSM").val(dataRecord.id_menu);
            $("#tituloInputSM").val(dataRecord.titulo);
            $("#descripcionInputSM").val(dataRecord.descripcion);
            $("#urlInputSM").val(dataRecord.url);
            $("#iconoInputSM").val(dataRecord.icono);
            $("#tipo_menuInputSM").val(dataRecord.tipo_menu); 
            $('#ordenNumberInputSM').val(dataRecord.orden); 
            $("#activoCheckBoxSM").jqxCheckBox({ checked: (dataRecord.activo.toString() === "true") }); // aveces dataRecord.activo es objeto

            // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
            var offsetTabla = $("#SubMenusGrid").offset();
            var anchoTabla = $("#SubMenusGrid").width();
            var anchoPopup = $("#popupSubmenu").width(); 
            var altoPopup = $("#popupSubmenu").height();
            var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
            var posicionYpopup = parseInt(Global_offsetFilaSM+offsetTabla.top+80) - parseInt(altoPopup/2);
        }
        
        $("#popupSubmenu").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
        // show the popup window.
        $("#popupSubmenu").jqxWindow('open');
    }

    function abrirPopupBorrar(Row) {
        // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
        var offsetTabla = $("#SubMenusGrid").offset();
        var anchoTabla = $("#SubMenusGrid").width();
        var anchoPopup = $("#popupDeleteConfirmSM").width();
        var altoPopup = $("#popupDeleteConfirmSM").height();
        var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
        var posicionYpopup = parseInt(Global_offsetFilaSM+offsetTabla.top+80) - parseInt(altoPopup/2);
        $("#popupDeleteConfirmSM").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
        // show the popup window.
        $("#popupDeleteConfirmSM").jqxWindow('open');

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