@extends('layouts.plataforma')

@section('header')

<link rel="stylesheet" href="{{ asset('jqwidgets5.4.0/jqwidgets/styles/jqx.base.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('jqwidgets5.4.0/jqwidgets/styles/jqx.ui-start.css') }}" type="text/css" />

@endsection

@section('content')
  <div class="container">
    <h2>Listado de Módulos</h2>
    <div id='jqxWidget'>
        <div id="ModulosGrid">
        </div>

       <div id="mensajesModulos" style="width: 800px; min-height:20px;"></div>

       <div id="popupModulo">
          <div>Módulo</div>
          <div style="overflow: hidden;">
            <div id="mensajes"></div>
            <form class="form" id="form" target="form-iframe"  method="post" action="guardarmodulo" >
                <table class="tabla-ventana">
                    <tr>
                        <td align="right" style="color:#000000; width: 40%;">Nombre del Módulo:</td>
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
                        <td align="right" style="color:#000000">Tipo Menú:</td>
                        <td><input name="tipo_menu" type="text" id="tipo_menuInput" /></td>
                    </tr>
                    <tr>
                        <td align="right" style="color:#000000">Ícono:</td>
                        <td><input name="icono" type="text" id="iconoInput" /></td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <table style="width: 100%;">
                          <tr>
                            <td align="right" style="color:#000000; width: 40%;">Orden:</td>
                            <td><div name="orden"  id="ordenNumberInput"></div></td>
                            <td rowspan="3">
                              <img id="imagenCargada" src="" alt="Imagen No Cargada" width="106" height="81">
                              <input type="file" id="image_uploads" accept="image/x-png, image/gif, image/jpeg, image/jpg" />
                              <label for="image_uploads" class="jqx-rc-all-ui-start jqx-button jqx-button-ui-start jqx-fill-state-fred-ui-start labelUpload">Cargar imagen</label>                              
                            </td>
                          </tr>
                          <tr>
                            <td align="right" style="color:#000000">Activo:</td>
                            <td><div name="activo"  id="activoCheckBox"></div></td>
                          </tr>
                          <tr>
                            <td align="right" style="color:#000000">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
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

  <script type="text/javascript" src="{{ asset('jqwidgets5.4.0/jqwidgets/jqxfileupload.js') }}"></script>

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

    #image_uploads{
        opacity: 0;
        width: 1px;
        height: 1px;
    }

    .labelUpload {
        padding: 5px 10px;
        font-size: 10px !important;
    }
  

    #imagenCargada{
        background-color: #D0D0D0;
        border-color: #C0C0C0 #E0E0E0 #E0E0E0 #C0C0C0;
        border-width: 3px;
        border-style: solid;
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
    var url = "./listamodulos";

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
            { name: 'orden', type: 'int' } 
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

    $("#ModulosGrid").jqxGrid(
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
            // $("#ModulosGrid").jqxGrid('sortby', 'name', 'asc'); ya no es necesario, se hace desde la BD
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
                    $("#tituloInput").val('');
                    $("#descripcionInput").val('');
                    $("#urlInput").val('');
                    $("#iconoInput").val('');
                    $("#tipo_menuInput").val(''); 
                    $('#ordenNumberInput').jqxNumberInput('clear');
                    $("#activoCheckBox").jqxCheckBox({ checked: false });    
                    $('#imagenCargada').attr('src', '../img/uploads/no-image.png');

                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                    var offsetTabla = $("#ModulosGrid").offset();
                    var anchoTabla = $("#ModulosGrid").width();
                    var anchoPopup = $("#popupModulo").width(); 
                    var altoPopup = $("#popupModulo").height();
                    var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                    var posicionYpopup = parseInt(100+offsetTabla.top+80) - parseInt(altoPopup/2);
                    $("#popupModulo").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                    // show the popup window.
                    $("#popupModulo").jqxWindow('open');
                    Global_nuevo=true;
            });

            modifButton.click(function (event) {
                if (Global_editrow > -1) {

                    // get the clicked row's data and initialize the input fields.
                    var dataRecord = $("#ModulosGrid").jqxGrid('getrowdata', Global_editrow);
                    $("#idInput").val(dataRecord.id);
                    $("#tituloInput").val(dataRecord.titulo);
                    $("#descripcionInput").val(dataRecord.descripcion);
                    $("#urlInput").val(dataRecord.url);
                    $("#iconoInput").val(dataRecord.icono);
                    $("#tipo_menuInput").val(dataRecord.tipo_menu); 
                    $('#ordenNumberInput').val(dataRecord.orden); 
                    $("#activoCheckBox").jqxCheckBox({ checked: (dataRecord.activo.toString() === "true") }); // aveces dataRecord.activo es objeto
                    $('#imagenCargada').attr('src', '../img/' + dataRecord.icono);

                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                    var offsetTabla = $("#ModulosGrid").offset();
                    var anchoTabla = $("#ModulosGrid").width();
                    var anchoPopup = $("#popupModulo").width(); 
                    var altoPopup = $("#popupModulo").height();
                    var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                    var posicionYpopup = parseInt(Global_offsetFila+offsetTabla.top+80) - parseInt(altoPopup/2);
                    $("#popupModulo").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                    // show the popup window.
                    $("#popupModulo").jqxWindow('open');
                }
            });

            deleteButton.click(function (event) {
                    // optiene la posision donde se desplegara la ventana pop-up en funcion de la fila y centro de la tabla.
                var offsetTabla = $("#ModulosGrid").offset();
                var anchoTabla = $("#ModulosGrid").width();
                var anchoPopup = $("#popupDeleteConfirm").width(); 
                var altoPopup = $("#popupDeleteConfirm").height();
                var posicionXpopup = parseInt(offsetTabla.left) + parseInt(anchoTabla/2) - parseInt(anchoPopup/2);
                var posicionYpopup = parseInt(Global_offsetFila+offsetTabla.top+80) - parseInt(altoPopup/2);
                $("#popupDeleteConfirm").jqxWindow({ position: { x: posicionXpopup, y: posicionYpopup } });
                // show the popup window.
                $("#popupDeleteConfirm").jqxWindow('open');

/*   Este codigo ya esta en el boton de confirmacion de boprrado                
                var selectedrowindex = $("#ModulosGrid").jqxGrid('getselectedrowindex');
                var rowscount = $("#ModulosGrid").jqxGrid('getdatainformation').rowscount;
                var idRow = $("#ModulosGrid").jqxGrid('getrowid', selectedrowindex);

                var dataRecord = $("#ModulosGrid").jqxGrid('getrowdata', selectedrowindex);

                $("#ModulosGrid").jqxGrid('deleterow', idRow);
                disableDelButtonAndAnothers();

                var parametros = { "id" : dataRecord.id,
                                   "_token" : "{{ csrf_token() }}"
                };                
                $.ajax({
                  type: "POST",
                  url: "./borrarmodulo",
                  data: parametros,
                  success: function(datos){
                    $("#mensajesModulos").html(datos);
                  },
                  error: function(result) {
                    $("#mensajesModulos").html(result.responseText);
                  }
                });
*/
            });

            reloadButton.click(function (event) {
                disableDelButtonAndAnothers();
                $('#ModulosGrid').jqxGrid('updatebounddata','data');
            });

            searchButton.click(function (event) {
                disableDelButtonAndAnothers();
                $("#ModulosGrid").jqxGrid('showfilterrow', true);

                var filter = $("#ModulosGrid").jqxGrid('filterable');
                $("#ModulosGrid").jqxGrid('filterable', !filter); // sw
                $("#ModulosGrid").jqxGrid('clearfilters');

            });

            excelButton.click(function (event) {
                $("#ModulosGrid").jqxGrid('exportdata', 'xls', 'Modulos');
            });

            pdfButton.click(function (event) {
                $("#ModulosGrid").jqxGrid('exportdata', 'pdf', 'Modulos');
            });

        },
        columns: [
            { text: 'Nombre Módulo', dataField: 'titulo', width: 200, filtertype: 'input' },
            { text: 'Url', dataField: 'url', width: 250 },
            { text: 'Descripción', dataField: 'descripcion', width: 200 },
            { text: 'Ícono', dataField: 'icono', width: 150 },
            { text: 'Tipo', dataField: 'tipo_menu', width: 60 },
            { text: 'Orden', dataField: 'orden', width: 60, cellsalign: 'center' },
            { text: 'Estado', dataField: 'activo', columntype: 'checkbox', filtertype: 'bool', cellsalign: 'center' }
        ],
        theme: Tema
    });



    $('#ModulosGrid').on('rowclick', function (event) { // solo para obtener la coordenada Y de la fila
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
        var index = $("#ModulosGrid").jqxGrid('getselectedrowindex');
        $('#ModulosGrid').jqxGrid('unselectrow', index);
        $("#mensajesModulos").html('');
        Global_editrow = -1;
    };
   
    $('#ModulosGrid').on('rowselect', function (event) { 
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
          $("#mensajesModulos").html("");             
    });   

    $('#ModulosGrid').on('filter', function (event) {
        disableDelButtonAndAnothers();
    });   

    $('#ModulosGrid').on('pagechanged', function (event) {
        disableDelButtonAndAnothers();
    });   

    $('#ModulosGrid').on('sort', function (event) {  // esta evento se ejecuta antes que los botones esten creados 
        disableDelButtonAndAnothers();
    });   


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

    var Global_Popup_listo = true; // evita que se habra el popup sin no estan sus datos listos

    $("#activoCheckBox").jqxCheckBox({ width: 120, height: 25, theme: Tema });   


    // initialize validator.
    $('#form').jqxValidator({
        // hintType: 'label',
        animationDuration: 500, // milisegundos
        theme: Tema,    
        rules: [
          { input: '#tituloInput', message: '¡El Nombre del Módulo es necesario!', action: 'keyup, blur', rule: 'required' },
          { input: '#descripcionInput', message: '¡La Descripción es necesaria!', action: 'keyup, blur', rule: 'required' },
          { input: '#descripcionInput', message: '¡Debe contener entre 3 y 100 caracteres!', action: 'keyup', rule: 'length=3,100' },
          { input: '#urlInput', message: '¡La Url es necesaria!', action: 'keyup, blur', rule: 'required' }
        ]
    });

    // initialize the popup window and buttons.
    $("#popupModulo").jqxWindow({
        width: 450, resizable: false,  isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.1, theme: Tema         
    });

    $("#popupModulo").on('open', function () {
        //$("#name").jqxInput('selectAll');
    });

    $("#popupModulo").on('close', function () {
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
                  var row = { id:0, titulo: $("#tituloInput").val(), descripcion: $("#descripcionInput").val(), url: $("#urlInput").val(), icono: $("#iconoInput").val(), tipo_menu: $("#tipo_menuInput").val(), orden: $('#ordenNumberInput').jqxNumberInput('getDecimal'), activo: $("#activoCheckBox").jqxCheckBox('checked')
                  };
                  
                  // YA NO SE LO AÑADE AQUI POR QUE CAUSA PROBLEMAS POR QUE NO TIENE ID AUN   
                  //$("#ModulosGrid").jqxGrid('addrow', null, row); // no tiene aun ID... se lo pondra cuando el sumit (asincrono) nos devuelva la respuesta

                  Global_row = row;
              } else {

                  var row = { titulo: $("#tituloInput").val(), descripcion: $("#descripcionInput").val(), url: $("#urlInput").val(), icono: $("#iconoInput").val(), tipo_menu: $("#tipo_menuInput").val(), orden: $('#ordenNumberInput').jqxNumberInput('getDecimal'), activo: $("#activoCheckBox").jqxCheckBox('checked')
                  };

                  var rowID = $('#ModulosGrid').jqxGrid('getrowid', Global_editrow);
                  $('#ModulosGrid').jqxGrid('updaterow', rowID, row);
              }
              $("#popupModulo").jqxWindow('hide');
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
          $("#mensajesModulos").html(mensaje);      

          Global_row.id = parseInt(ID);  
          //$('#ModulosGrid').jqxGrid('updaterow', 0, Global_row); // buscamos al que le pusimos 0 por ID

          $("#ModulosGrid").jqxGrid('addrow', null, Global_row); // aqui nomas va tiene que ser la insercion al grip del registro, una vez que tenemos el ID

        } else {
          $("#mensajesModulos").html(data);   
        }
      });

      // evento: si hubo algun error
      posting.error(function( data ) {
          $("#mensajesModulos").html(data.responseText);   
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
        var selectedrowindex = $("#ModulosGrid").jqxGrid('getselectedrowindex');
        var rowscount = $("#ModulosGrid").jqxGrid('getdatainformation').rowscount;
        var idRow = $("#ModulosGrid").jqxGrid('getrowid', selectedrowindex);

        var dataRecord = $("#ModulosGrid").jqxGrid('getrowdata', selectedrowindex);

        $("#ModulosGrid").jqxGrid('deleterow', idRow);
        disableDelButtonAndAnothers();

        var parametros = { "id" : dataRecord.id,
                       "_token" : "{{ csrf_token() }}"
        };                
        
        $.ajax({
            type: "POST",
            url: "./borrarmodulo",
            data: parametros,
            success: function(datos){
                $("#mensajesModulos").html(datos);
            },
            error: function(result) {
                $("#mensajesModulos").html(result.responseText);
            }
        });
    });


    $( "#image_uploads" ).change(function() {
        var formElement = document.getElementById('image_uploads');
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('imagen_modulo', formElement.files[0]);

        $('#imagenCargada').attr('src', '../images/loader.gif');

        $.ajax({
            url:    './imagenupload',
            type:   'POST',
            data:   formData,
            cache:  false,
            dataType: 'json',
            processData: false,
            contentType: false, 
            success: function(data){
                $('#imagenCargada').attr('src', '../img/' + data.url_imagen);
                if ( data.status == 'OK' ) {
                    $("#iconoInput").val(data.url_imagen);
                }
            },
            error: function(result) {
                $('#imagenCargada').attr('src', '');
                $('#mensajesModulos').html(result.responseText);
            }
        });
    });    
//===================================================================
//===== Hasta aqui la ventana de Confirmacion de borrado Pop-up ===== 
//===================================================================


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