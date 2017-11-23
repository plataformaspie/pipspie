@extends('layouts.plataforma')

@section('header')

<link rel="stylesheet" href="{{ asset('jqwidgets5.4.0/jqwidgets/styles/jqx.base.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets5.4.0/jqwidgets/styles/jqx.ui-start.css') }}" type="text/css" />

@endsection

@section('content')
  <div class="container">
    <h2>Listado de Roles</h2>
    <div id='jqxWidget2'>
        <div id="RolesGrid">
        </div>

       <div id="mensajesRoles" style="width: 800px; min-height:20px;"></div>

       <div id="popupRol">
          <div>Rol</div>
          <div style="overflow: hidden;">
            <div id="mensajes"></div>
            <form class="form" id="form" target="form-iframe"  method="post" action="guardarrol" >
                <table class="tabla-ventana">
                    <tr>
                        <td align="right" style="color:#000000; width: 40%;">Rol:</td>
                        <td><input name="rol" type="text" id="rolInput" /></td>
                        <input type="hidden" name="id" id="idInput" value="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </tr>
                    <tr>
                        <td align="right" style="color:#000000">Descripción:</td>
                        <td><input name="descripcion" type="text" id="descripcionInput" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 10px;" align="right">
                            <input style="margin-right: 5px;" type="button" id="Save" value="Guardar" />
                            <input id="Cancel" type="button" value="Cerrar" />
                        </td>
                    </tr>

                </table>
            </form>
          </div>
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


    <div id="popupRolMenus">
        <div>Menus</div>
        <div style="overflow: hidden;">
          <div id="mensajesMenus"></div>
          <div id='menusListBox'> </div>
          <div style="padding-top: 10px; width:100%;" align="right">
              <input style="margin-right: 5px;" type="button" id="SaveMenus" value="Guardar" />
              <input id="CancelMenus" type="button" value="Cerrar" />
          </div>
        </div>
    </div>


    <div id="popupRolModulos">
        <div>Módulos</div>
        <div style="overflow: hidden;">
          <div id="mensajesModulos"></div>
          <div id='modulosListBox'> </div>
          <div style="padding-top: 10px; width:100%;" align="right">
              <input style="margin-right: 5px;" type="button" id="SaveModulos" value="Guardar" />
              <input id="CancelModulos" type="button" value="Cerrar" />
          </div>
        </div>
    </div>



  </div>
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
    var url = "./listaroles";

    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id', type: 'string' },
            { name: 'rol', type: 'string' },
            { name: 'descripcion', type: 'string' }
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

    $("#RolesGrid").jqxGrid(
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
            // $("#RolesGrid").jqxGrid('sortby', 'name', 'asc'); ya no es necesario, se hace desde la BD
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
                    $("#rolInput").val('');
                    $("#descripcionInput").val('');


                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                    var offsetTabla = $("#RolesGrid").offset();
                    var anchoTabla = $("#RolesGrid").width();
                    var anchoPopup = $("#popupRol").width(); 
                    var altoPopup = $("#popupRol").height();
                    var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                    var posicionYpopup = parseInt(100+offsetTabla.top+80) - parseInt(altoPopup/2);
                    $("#popupRol").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                    // show the popup window.
                    $("#popupRol").jqxWindow('open');
                    Global_nuevo=true;
            });

            modifButton.click(function (event) {
                if (Global_editrow > -1) {

                    // get the clicked row's data and initialize the input fields.
                    var dataRecord = $("#RolesGrid").jqxGrid('getrowdata', Global_editrow);
                    $("#idInput").val(dataRecord.id);
                    $("#rolInput").val(dataRecord.rol);
                    $("#descripcionInput").val(dataRecord.descripcion);


                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                    var offsetTabla = $("#RolesGrid").offset();
                    var anchoTabla = $("#RolesGrid").width();
                    var anchoPopup = $("#popupRol").width(); 
                    var altoPopup = $("#popupRol").height();
                    var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                    var posicionYpopup = parseInt(Global_offsetFila+offsetTabla.top+80) - parseInt(altoPopup/2);
                    $("#popupRol").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                    // show the popup window.
                    $("#popupRol").jqxWindow('open');
                }
            });

            deleteButton.click(function (event) {
                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                var offsetTabla = $("#RolesGrid").offset();
                var anchoTabla = $("#RolesGrid").width();
                var anchoPopup = $("#popupDeleteConfirm").width(); 
                var altoPopup = $("#popupDeleteConfirm").height();
                var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                var posicionYpopup = parseInt(Global_offsetFila+offsetTabla.top+80) - parseInt(altoPopup/2);
                $("#popupDeleteConfirm").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                // show the popup window.
                $("#popupDeleteConfirm").jqxWindow('open');

/*   Este codigo ya esta en el boton de confirmacion de boprrado                
                var selectedrowindex = $("#RolesGrid").jqxGrid('getselectedrowindex');
                var rowscount = $("#RolesGrid").jqxGrid('getdatainformation').rowscount;
                var idRow = $("#RolesGrid").jqxGrid('getrowid', selectedrowindex);

                var dataRecord = $("#RolesGrid").jqxGrid('getrowdata', selectedrowindex);

                $("#RolesGrid").jqxGrid('deleterow', idRow);
                disableDelButtonAndAnothers();

                var parametros = { "id" : dataRecord.id,
                                   "_token" : "{{ csrf_token() }}"
                };                
                $.ajax({
                  type: "POST",
                  url: "./borrarrol",
                  data: parametros,
                  success: function(datos){
                    $("#mensajesRoles").html(datos);
                  },
                  error: function(result) {
                    $("#mensajesRoles").html(result.responseText);
                  }
                });
*/                
            });

            reloadButton.click(function (event) {
                disableDelButtonAndAnothers();
                $('#RolesGrid').jqxGrid('updatebounddata','data');
            });

            searchButton.click(function (event) {
                disableDelButtonAndAnothers();
                $("#RolesGrid").jqxGrid('showfilterrow', true);

                var filter = $("#RolesGrid").jqxGrid('filterable');
                $("#RolesGrid").jqxGrid('filterable', !filter); // sw
                $("#RolesGrid").jqxGrid('clearfilters');

            });

            excelButton.click(function (event) {
                $("#RolesGrid").jqxGrid('exportdata', 'xls', 'Rol');
            });

            pdfButton.click(function (event) {
                $("#RolesGrid").jqxGrid('exportdata', 'pdf', 'Rol');
            });

        },
        columns: [
            { text: 'Rol', dataField: 'rol', width: 200, filtertype: 'input'  },
            { text: 'Descripción', dataField: 'descripcion'},
            { text: 'Editar Menús', datafield: 'Edit', width: 100, columntype: 'button', filterable: false, 
                cellsrenderer: function () {
                    return "Menús";
                }, 
                buttonclick: function (row) {  //abrira un popup cuando se haga click
                    editrow = row;

                    var dataRecord = $("#RolesGrid").jqxGrid('getrowdata', editrow);
                  
                    var parametros = {  "id_rol" : dataRecord.id, // 3
                                      "_token" : "{{ csrf_token() }}"
                    };                

                    $("#menusListBox").jqxListBox('uncheckAll');
                    $("#mensajesMenus").html("Cargando...<img src='../../images/loader.gif'>");
                    $.ajax({
                        type: "POST",
                        url: "./listamenusroles",
                        data: parametros,
                        success: function(datos){
                            $("#menusListBox").jqxListBox('uncheckAll'); // por si acaso :p
                            $("#mensajesMenus").html('');
                            $.each(datos, function(id,value){
                                itemAux = $("#menusListBox").jqxListBox('getItemByValue', value.id_menu);
                                $("#menusListBox").jqxListBox('checkItem', itemAux );
                                //itemAux.label - gets item's label.   itemAux.value - gets the item's value.
                            });
                        },
                        error: function(result) {
                            $("#mensajesRoles").html(result.responseText);
                        }
                    });
                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                    var offsetTabla = $("#RolesGrid").offset();
                    var anchoTabla = $("#RolesGrid").width();
                    var anchoPopup = $("#popupRolMenus").width(); 
                    var altoPopup = $("#popupRolMenus").height();
                    var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                    var posicionYpopup = parseInt(Global_offsetFila+offsetTabla.top+80) - parseInt(altoPopup/2);
                    $("#popupRolMenus").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                    // show the popup window.
                    $("#popupRolMenus").jqxWindow('open');
                }
            },
            { text: 'Editar Módulos', datafield: 'Edit2', width: 100, columntype: 'button', filterable: false, 
                cellsrenderer: function () {
                    return "Módulos";
                }, 
                buttonclick: function (row) {  //abrira un popup cuando se haga click
                    editrow = row;

                    var dataRecord = $("#RolesGrid").jqxGrid('getrowdata', editrow);
                  
                    var parametros = {  "id_rol" : dataRecord.id, // 3
                                      "_token" : "{{ csrf_token() }}"
                    };                

                    $("#modulosListBox").jqxListBox('uncheckAll');
                    $("#mensajesModulos").html("Cargando...<img src='../../images/loader.gif'>");
                    $.ajax({
                        type: "POST",
                        url: "./listamodulosroles",
                        data: parametros,
                        success: function(datos){
                            $("#modulosListBox").jqxListBox('uncheckAll');  // por si acaso :p
                            $("#mensajesModulos").html('');
                            $.each(datos, function(id,value){
                                itemAux = $("#modulosListBox").jqxListBox('getItemByValue', value.id_modulo);
                                $("#modulosListBox").jqxListBox('checkItem', itemAux );
                            });
                        },
                        error: function(result) {
                            $("#mensajesRoles").html(result.responseText);
                        }
                    });
                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                    var offsetTabla = $("#RolesGrid").offset();
                    var anchoTabla = $("#RolesGrid").width();
                    var anchoPopup = $("#popupRolModulos").width(); 
                    var altoPopup = $("#popupRolModulos").height();
                    var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                    var posicionYpopup = parseInt(Global_offsetFila+offsetTabla.top+80) - parseInt(altoPopup/2);
                    $("#popupRolModulos").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                    // show the popup window.
                    $("#popupRolModulos").jqxWindow('open');
                }
            }
        ],
        theme: Tema
    });


    $('#RolesGrid').on('rowclick', function (event) { // solo para obtener la coordenada Y de la fila
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
        var index = $("#RolesGrid").jqxGrid('getselectedrowindex');
        $('#RolesGrid').jqxGrid('unselectrow', index);
        $("#mensajesRoles").html('');
        Global_editrow = -1;
    };
   
    $('#RolesGrid').on('rowselect', function (event) { 
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
          $("#mensajesRoles").html("");             
    });   

    $('#RolesGrid').on('filter', function (event) {
        disableDelButtonAndAnothers();
    });   

    $('#RolesGrid').on('pagechanged', function (event) {
        disableDelButtonAndAnothers();
    });   

    $('#RolesGrid').on('sort', function (event) {  // esta evento se ejecuta antes que los botones esten creados 
        disableDelButtonAndAnothers();
    });   



//===========================================
//===== Desde aqui la ventana de Pop-up ===== 
//===========================================
    // initialize the input fields.
    // $("#name").jqxInput({ width: 150, height: 23, theme: Tema }); // no funca :(((

    $("#rolInput").jqxInput({ theme: Tema });
    $("#rolInput").width(240);
    $("#rolInput").height(23);

    $("#descripcionInput").jqxInput({ theme: Tema });
    $("#descripcionInput").width(240);
    $("#descripcionInput").height(23);

    var Global_Popup_listo = true; // evita que se habra el popup sin no estan sus datos listos

    // initialize validator.
    $('#form').jqxValidator({
               // hintType: 'label',
                animationDuration: 500, // milisegundos
                theme: Tema,    
      rules: [
        { input: '#rolInput', message: '¡El Rol es necesario!', action: 'keyup, blur', rule: 'required' },

        { input: '#descripcionInput', message: '¡La Descripción es necesaria!', action: 'keyup, blur', rule: 'required' }
  
      ]
    });

    // initialize the popup window and buttons.
    $("#popupRol").jqxWindow({
        width: 350, resizable: false,  isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.1, theme: Tema         
    });

    $("#popupRol").on('open', function () {
        //$("#name").jqxInput('selectAll');
    });

    $("#popupRol").on('close', function () {
        Global_nuevo=false;
        $('#form').jqxValidator('hide');
    });

 
    $("#Cancel").jqxButton({ width: 70, theme: Tema });
    $("#Save").jqxButton({ width: 70, theme: Tema });
    // update the edited row when the user clicks the 'Save' button.
    var Global_row;
    $("#Save").click(function () {

        if (Global_editrow >= 0 || Global_nuevo) {

          var validationResult = function (isValid) {
            if (isValid) {
              $("#form").submit();

              if (Global_nuevo) {

                  var row = { id:0, rol: $("#rolInput").val(), descripcion: $("#descripcionInput").val() };
                  
                  // YA NO SE LO AÑADE AQUI POR QUE CAUSA PROBLEMAS POR QUE NO TIENE ID AUN   
                  //$("#RolesGrid").jqxGrid('addrow', null, row); // no tiene aun ID... se lo pondra cuando el sumit (asincrono) nos devuelva la respuesta

                  Global_row = row;
              } else {

                  var row = { rol: $("#rolInput").val(), descripcion: $("#descripcionInput").val() };

                  var rowID = $('#RolesGrid').jqxGrid('getrowid', Global_editrow);
                  $('#RolesGrid').jqxGrid('updaterow', rowID, row);
              }
              $("#popupRol").jqxWindow('hide');
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
          $("#mensajesRoles").html(mensaje);      

          Global_row.id = parseInt(ID);  
          //$('#RolesGrid').jqxGrid('updaterow', 0, Global_row); // buscamos al que le pusimos 0 por ID

          $("#RolesGrid").jqxGrid('addrow', null, Global_row); // aqui nomas va tiene que ser la insercion al grip del registro, una vez que tenemos el ID

        } else {
          $("#mensajesRoles").html(data);   
        }
      });

      // evento: si hubo algun error
      posting.error(function( data ) {
          $("#mensajesRoles").html(data.responseText);   
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
        var selectedrowindex = $("#RolesGrid").jqxGrid('getselectedrowindex');
        var rowscount = $("#RolesGrid").jqxGrid('getdatainformation').rowscount;
        var idRow = $("#RolesGrid").jqxGrid('getrowid', selectedrowindex);

        var dataRecord = $("#RolesGrid").jqxGrid('getrowdata', selectedrowindex);

        $("#RolesGrid").jqxGrid('deleterow', idRow);
        disableDelButtonAndAnothers();

        var parametros = { "id" : dataRecord.id,
                       "_token" : "{{ csrf_token() }}"
        };                
        
        $.ajax({
            type: "POST",
            url: "./borrarrol",
            data: parametros,
            success: function(datos){
                $("#mensajesRoles").html(datos);
            },
            error: function(result) {
                $("#mensajesRoles").html(result.responseText);
            }
        });
    });
//===================================================================
//===== Hasta aqui la ventana de Confirmacion de borrado Pop-up ===== 
//===================================================================



//=================================================
//===== Desde aqui la ventana de Pop-up Menus ===== 
//=================================================
var url = "./listamenus_rol";
// preparacion de los datos
var sourceMenusRol = {
    datatype: "json",
    datafields: [
        { name: 'id' },
        { name: 'menu' }
    ],
    id: 'id',
    url: url
};

var dataAdapterMenusRol = new $.jqx.dataAdapter(sourceMenusRol);

// Creamos el jqxListBox
$("#menusListBox").jqxListBox({ source: dataAdapterMenusRol, displayMember: "menu", valueMember: "id", multiple: true, checkboxes: true, width: 500, height: 300});

$("#CancelMenus").jqxButton({ width: 70, theme: Tema });
$("#SaveMenus").jqxButton({ width: 70, theme: Tema });

$("#SaveMenus").click(function () {
    var info = [];
    var items = $("#menusListBox").jqxListBox('getCheckedItems'); 

    for (var i = 0; i < items.length; i++) {
        info[i] = items[i].value;
    }
    
    var parametros = {  "id_rol" : $('#RolesGrid').jqxGrid('getrowid', Global_editrow), // 3
                        "_token" : "{{ csrf_token() }}",
                        "ids_menus": info
                      };
    // Enviamos los datos usando post
    var posting = $.post( "./guardarmenusroles", parametros );

    // evento: cuando los resultados son devueltos
    posting.done(function( data ) {
        $("#mensajesRoles").html(data);   
    });

    // evento: si hubo algun error
    posting.error(function( data ) {
        $("#mensajesRoles").html(data.responseText);   
    });

    $("#popupRolMenus").jqxWindow('hide');
});

$("#popupRolMenus").jqxWindow({
    width: 520, resizable: false,  isModal: true, autoOpen: false, cancelButton: $("#CancelMenus"), modalOpacity: 0.1, theme: Tema         
});
//=================================================
//===== Hasta aqui la ventana de Pop-up Menus ===== 
//=================================================




//===================================================
//===== Desde aqui la ventana de Pop-up Modulos ===== 
//===================================================
var url = "./listamodulos_rol";
// preparacion de los datos
var sourceModulosRol = {
    datatype: "json",
    datafields: [
        { name: 'id' },
        { name: 'modulo' }
    ],
    id: 'id',
    url: url
};

var dataAdapterModulosRol = new $.jqx.dataAdapter(sourceModulosRol);

// Creamos el jqxListBox
$("#modulosListBox").jqxListBox({ source: dataAdapterModulosRol, displayMember: "modulo", valueMember: "id", multiple: true, checkboxes: true, width: 500, height: 300});

$("#CancelModulos").jqxButton({ width: 70, theme: Tema });
$("#SaveModulos").jqxButton({ width: 70, theme: Tema });

$("#SaveModulos").click(function () {
    var info = [];
    var items = $("#modulosListBox").jqxListBox('getCheckedItems'); 

    for (var i = 0; i < items.length; i++) {
        info[i] = items[i].value;
    }
    
    var parametros = {  "id_rol" : $('#RolesGrid').jqxGrid('getrowid', Global_editrow), // 3
                        "_token" : "{{ csrf_token() }}",
                        "ids_modulos": info
                      };
    // Enviamos los datos usando post
    var posting = $.post( "./guardarmodulosroles", parametros );

    // evento: cuando los resultados son devueltos
    posting.done(function( data ) {
        $("#mensajesRoles").html(data);   
    });

    // evento: si hubo algun error
    posting.error(function( data ) {
        $("#mensajesRoles").html(data.responseText);   
    });

    $("#popupRolModulos").jqxWindow('hide');
});

$("#popupRolModulos").jqxWindow({
    width: 520, resizable: false,  isModal: true, autoOpen: false, cancelButton: $("#CancelModulos"), modalOpacity: 0.1, theme: Tema         
});
//===================================================
//===== Hasta aqui la ventana de Pop-up Modulos ===== 
//===================================================





});  // FIN: $(document).ready(function () {
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