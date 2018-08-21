

@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="/plugins/bower_components/select2/dist/css/select2.min.css" type="text/css"/>
<link rel="stylesheet" href="/plugins/bower_components/sweetalert/sweetalert.css" type="text/css">
<link rel="stylesheet" href="/jqwidgets5.5.0/jqwidgets/styles/jqx.energyblue.css" type="text/css" />






<style media="screen">
.popup-basic {
  position: relative;
  background: #FFF;
  width: auto;
  max-width: 500px;
  margin: 40px auto;
}
.icon-danger {
    color: #E63F24;
}
.icon-primary {
    color: #5BC24C;
}
.icon-warning {
    color: #F5B025;
}
##.admin-form .panel-heading{
    background-color: #fafafa;
    border-color: transparent -moz-use-text-color #ddd;
    border-radius: 0;
    border-style: solid none;
    border-width: 1px 0;
    color: #999;
    height: auto;
    overflow: hidden;
    padding: 3px 15px 2px;
    position: relative;
}

</style>
@endsection

{{-- @section('title-topbar')
  <div class="topbar-left">
      <ol class="breadcrumb">
          <li class="crumb-active">
              <a href="dashboard.html">Estructura Institucional</a>
          </li>
          <li class="crumb-icon">
              <a href="/sistemasisgri/index">
                  <span class="glyphicon glyphicon-home"></span>
              </a>
          </li>
          <li class="crumb-link">
              <a href="/sistemasisgri/index">Home</a>
          </li>
          <li class="crumb-trail">Estructura Institucional</li>
      </ol>
  </div>
  <div class="topbar-right">
      <div class="ml15 ib va-m" id="toggle_sidemenu_r">
          <a href="#" class="pl5"> <i class="fa fa-sign-in fs22 text-primary"></i>
              <span class="badge badge-hero badge-danger">3</span>
          </a>
      </div>
  </div>
@endsection --}}

@section('content')
<div class="tray tray-center p40 va-t posr">
      <div class="row">

          <div class="col-md-12">
              <div class="panel panel-visible" >
                <div class="panel-heading bg-dark text-center">
                     <span class="panel-title">Administracion Clasificador Institucional</span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="clasificador" class="col-md-12" >
                            <button id="nuevo" type="button" class="btn btn-sm btn-success dark m5  br6"><i class="fa fa-plus-circle text-white"></i> Agregar Entidad</button>
                            <!--button id="editar" type="button" class="btn btn-sm btn-warning dark m5 br6 "><i class="fa fa-edit text-white"></i> Editar</button>
                            <button id="eliminar" type="button" class="btn btn-sm btn-danger dark m5 br6 "><i class="fa fa-minus-circle text-white"></i> Eliminar</button-->
                             
                            <div  id="treeGrid">

                            </div>
                        </div>


                       
                    </div>
                </div>
              </div>
          </div>
      </div>
  </div>
<div id="modal-nuevo"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
    <div class="panel">
    <div class="panel-heading bg-dark  ">
      <span class="panel-title"><i class="fa fa-pencil"></i>Agregar Entidad</span>
    </div>
    <!-- end .panel-heading section -->
    <form method="post" action="/" id="form-nuevo" name="form-nuevo" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="panel-body mnw500 of-a">
            <div class="row">
                <!-- Chart Column -->
                <div class="col-md-12">
                    <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Complete los datos requeridos por el sistema <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>

                    <div class="section">
                        <label class="field-label" for="username">Nombre</label>
                        <label for="nombre" class="field prepend-icon">
                        <textarea class="gui-textarea" id="nombre" name="nombre"  placeholder="Nombre de la entidad..." rows="2"></textarea>
                        <label for="nombre" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                        </label>
                        </label>
                    </div>

                    <div class="section">
                        <label class="field-label" for="username">Sigla</label>
                        <label for="sigla" class="field prepend-icon">
                            <input type="text" name="sigla" id="sigla" class="gui-input" placeholder="Sigla">
                            <label for="sigla" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                            </label>
                        </label>
                    </div>
                    <div class="section">
                        <label class="field-label" for="username">Código MEF</label>
                        <label for="codigo_mef" class="field prepend-icon">
                            <input type="text" name="codigo_mef" id="codigo_mef" class="gui-input" placeholder="codigo">
                            <label for="codigo_mef" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                            </label>
                        </label>
                    </div>
                    ç

                    <div class="section">
                        <label class="field-label" for="username">Código GEO</label>
                        <label for="codigo_geografico" class="field prepend-icon">
                            <input type="text" name="codigo_geografico" id="codigo_geografico" class="gui-input" placeholder="codigo">
                            <label for="codigo_mef" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                            </label>
                        </label>
                    </div>
                 
                    
              </div>
            </div>
      </div>

      <div class="panel-footer">
        <button type="submit" class="button btn-primary dark br6">Validar y Guardar</button>
          <a href="#"   class="button btn-danger dark br6 ml25 sp_cancelar">Cancelar</a>
      </div>
    </form>
</div>

</div>

<div id="modal-editar"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
  <div class="panel">
      <div class="panel-heading bg-dark">
          <span class="panel-title"><i class="fa fa-pencil"></i>Modificar Entidad</span>
      </div>
      <!-- end .panel-heading section -->
      <form method="post" action="/" id="form-edit" name="form-edit" enctype="multipart/form-data">
        {{ csrf_field() }}
          <input type="hidden" name="mod_id" id="mod_id" value="">
          <div class="panel-body mnw500 of-a">
            <div class="row">
              <div class="col-md-12">
                  <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Modifique los datos que sean necesarios <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>

                  <div class="section">
                      <label class="field-label" for="username">Nombre</label>
                      <label for="mod_nombre" class="field prepend-icon">
                          <textarea class="gui-textarea" id="mod_nombre" name="mod_nombre"  placeholder="Nombre de la entidad..." rows="2"></textarea>
                          <label for="mod_nombre" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                          </label>
                      </label>
                  </div>

                  <div class="section">
                      <label class="field-label" for="username">Sigla</label>
                      <label for="mod_sigla" class="field prepend-icon">
                          <input type="text" name="mod_sigla" id="mod_sigla" class="gui-input" placeholder="Sigla">
                          <label for="mod_sigla" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                          </label>
                      </label>
                  </div>
                  <div class="section">
                      <label class="field-label" for="username">Código MEF</label>
                      <label for="mod_codigo_mef" class="field prepend-icon">
                          <input type="text" name="mod_codigo_mef" id="mod_codigo_mef" class="gui-input" placeholder="codigo">
                          <label for="mod_codigo_mef" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                          </label>
                      </label>
                  </div>
                  <div class="section">
                      <label class="field-label" for="username">Código GEO</label>
                      <label for="mod_codigo_geografico" class="field prepend-icon">
                          <input type="text" name="mod_codigo_geografico" id="mod_codigo_geografico" class="gui-input" placeholder="codigo">
                          <label for="mod_codigo_mef" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                          </label>
                      </label>
                  </div>
                  
              </div>
            </div>
         <div class="panel-footer">
            <button type="submit" class="button btn-primary dark br6">Validar y Guardar</button>
            <a href="#"   class="button btn-danger dark br6 ml25 sp_cancelar">Cancelar</a>
         </div>

        </form>
  </div>
  <!-- end: .panel -->
</div>



@endsection

@push('script-head')
{{--       <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script> --}}

<script src="/plugins/bower_components/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcore.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxbuttons.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxscrollbar.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdata.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdatatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdraw.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxtreegrid.js') }} "></script>

<script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets-localization.js') }}"></script>

<!--librerias para el tree grid-->

<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdata.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxbuttons.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxscrollbar.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdatatable.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxtreegrid.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxtreegrid.js') }} "></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxlistbox.js') }} "></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdropdownlist.js') }} "></script>



  <script type="text/javascript">
    var id_seleccionado = "";
    var fila_seleccionada = "";
    var si_adiciona = "";
  
 $(document).ready(function () {
  ctxEnt = {
              
        nuevaEntidad: function(){
          if(id_seleccionado!=""){

            swal({
              title: "Clasificador Seleccionado:"  ,
              text: "Usted Adicionara una institucion a:" + fila_seleccionada.denominacion ,
              type: "info",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Si, Agregar!",
              closeOnConfirm: true
            }, function(){
                //alert(fila_seleccionada.denominacion);

                $(".state-error").removeClass("state-error")
                  $("#form-nuevo em").remove();
                  $.magnificPopup.open({
                        removalDelay: 500, //delay removal by X to allow out-animation,
                        focus: '#focus-blur-loop-select',
                        items: {
                            src: "#modal-nuevo"
                        },
                        // overflowY: 'hidden', //
                        callbacks: {
                            beforeOpen: function(e) {
                                var Animation = "mfp-zoomIn";
                                this.st.mainClass = Animation;
                            }
                        },
                        midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                  });

            });
            
          }else{
            swal("Seleccione la Clasificador!!");
          }  
      
        },
        reglasValidacionEntidad :  function(accion){
            reglas = {
                errorClass: "state-error",
                validClass: "state-success",
                errorElement: "em",
                rules: {
                        nombre: { required: true },
                        sigla:  { required: true },
                        tipo: { required: true },
                        tuicion: { required: true }
                },

                messages:{
                        nombre: { required: 'Ingresar nombre de la Entidad'},
                        sigla:  { required: 'Ingresarla sigla'},
                        tipo:  { required: 'Por favor, selecciones una opcion'},
                        tuicion:  { required: 'Por favor, selecciones una opcion'}
                },

                highlight: function(element, errorClass, validClass) {
                        $(element).closest('.field').addClass(errorClass).removeClass(validClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                        $(element).closest('.field').removeClass(errorClass).addClass(validClass);
                },
                errorPlacement: function(error, element) {
                   if (element.is(":radio") || element.is(":checkbox")) {
                            element.closest('.option-group').after(error);
                   } else {
                            error.insertAfter(element.parent());
                   }
                },
                submitHandler: function(form) {
                    accion == 'insert' ? saveFormNew() : saveFormEdit();
                }
            }
            return reglas;
        },
        editarEntidad : function(){
            
                  if (id_seleccionado!="")
                  {
                     
                      $.ajax({
                              url:'/moduloplanificacion/dataSetInstitucion',
                              type: "GET",
                              dataType: 'json',
                              data:{'id':id_seleccionado},
                              success: function(data){

                                  $("#form-edit em").remove();
                                  $('input[name="mod_id"]').val(data.id_clasificador);
                                  $('textarea[name="mod_nombre"]').val(data.denominacion);
                                  $('input[name="mod_sigla"]').val(data.sigla);
                                  $('input[name="mod_codigo_mef"]').val(data.codigo_mef);
                                  $('input[name="mod_codigo_geografico"]').val(data.codigo_geografico);

                              },
                              error:function(data){
                                console.log("Error recuperar los datos.");
                              }
                      });
                      $.magnificPopup.open({
                          removalDelay: 500, //delay removal by X to allow out-animation,
                          focus: '#focus-blur-loop-select',
                          items: {
                              src: "#modal-editar"
                          },
                          // overflowY: 'hidden', //
                          callbacks: {
                              beforeOpen: function(e) {
                                  var Animation = "mfp-zoomIn";
                                  this.st.mainClass = Animation;
                              }
                          },
                          midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                      });
                  }else {
                      swal("Seleccione el registro que modificara.");
                  }
        },
        eliminarEntidad :  function(){
           
            if (id_seleccionado!="")
            {

                swal({
                      title: "Está seguro?",
                      text: "No podrá recuperar este registro!",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Si, eliminar!",
                      closeOnConfirm: false
                  }, function(){
                        
                        $.ajax({
                            url:'/moduloplanificacion/deleteInstitucion',
                            type: "GET",
                            dataType: 'json',
                            data:{'id':id_seleccionado},
                            success: function(data){
                              new PNotify({
                                  title: data.title,
                                  text: data.msg,
                                  shadow: true,
                                  opacity: 1,
                                  addclass: noteStack,
                                  type: "success",
                                  stack: Stacks[noteStack],
                                  width: findWidth(),
                                  delay: 1400
                              });
                              $("#treeGrid").jqxTreeGrid('updateBoundData');
                              $('#treeGrid').on('bindingComplete', function() {
                                      $("#treeGrid").jqxTreeGrid('expandAll');
                                  });

                              
                              swal("Eliminado!", "Se ha eliminado tu registro.", "success");
                          },
                          error:function(data){
                              new PNotify({
                                  title: data.title,
                                  text: data.msg,
                                  shadow: true,
                                  opacity: 1,
                                  addclass: noteStack,
                                  type: "danger",
                                  stack: Stacks[noteStack],
                                  width: findWidth(),
                                  delay: 1400
                              });
                          }
                        });
                    });

                }else {
                  swal("Seleccione el registro que eliminara.");
                }
        },
      }

            
            var cellClass = function (row, dataField, cellText, rowData) {
                var cellValue = rowData[dataField];
                if (cellValue < 100000) {
                    return "min";
                }
                if (cellValue < 200000) {
                    return "minavg";
                }
                if (cellValue < 400000) {
                    return "avg";
                }
                return "max";
            }

            var source =
            {
                dataType: "json",
                dataFields: [
                    { name: 'id_clasificador', type: 'number' },
                    { name: 'id_clasificador_dependiente', type: 'number' },
                    { name: 'denominacion', type: 'string' },
                    { name: 'sigla', type: 'string' },
                    { name: 'nivel', type: 'string' },
                    { name: 'si_adiciona_entidad', type: 'string' },
                    { name: 'depende_de', type: 'number' },
                    { name: 'detalle_de', type: 'string' },
                    { name: 'codigo_mef', type: 'string' },
                    { name: 'codigo_geografico', type: 'string' },
                    
                ],
                hierarchy:
                {
                    keyDataField: { name: 'id_clasificador' },
                    parentDataField: { name: 'id_clasificador_dependiente' }
                },
                id: 'id_clasificador',
                url:'/moduloplanificacion/setClasificador',
                sortcolumn: 'id_clasificador',
                sortdirection: 'asc',

            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            // create Tree Grid
            $("#treeGrid").jqxTreeGrid(
            {
               
                width: "100%",
                height: "500px",
                source: dataAdapter,
                theme: 'energyblue',
                filterable: true,
                ready: function () {
                    $("#treeGrid").jqxTreeGrid('expandRow', '3');
                },
                columns: [
                  { text: 'Denominacion', dataField: 'denominacion' },
                  { text: 'Sigla', dataField: 'sigla', width: 100 },
                  { text: 'Codigo MEF', dataField: 'codigo_mef', width: 100 },
                  { text: 'Codigo GEO', dataField: 'codigo_geografico', width: 100 },
                  { text: '', dataField:'id', width: 60, cellsalign: 'center',

                      //var cellsrenderer = function (row, column, value) {
                        //console.log()
                          //return '<div style="text-align: center; margin-top: 5px;">' + value + '</div>';
                      //}
                       cellsRenderer: function (row, column, value, dataField,rowData){
                          var cellValue = dataField.si_es_nominal_o_institucion;
                          
                          if(cellValue === true ){
                            return "";
                               
                          }else{
                            html = `<a href="#" id="edit-${value}" class="m-l-10 m-r-10 m-t-10 sel_edit" title="Editar" ><i class="fa fa-edit text-warning fa-lg"></i></a> 
                            <a href="#" id="del-${value}" class="m-l-10 m-r-10 m-t-10 sel_delete" title="Eliminar" ><i class="fa fa-minus-circle text-danger fa-lg"></i></a> ` 
                          return html; 
                          }
                          

                           
                       }
                  },
                 
                ]
            });

      /*$("#jqxbutton").jqxButton({
            theme: 'energyblue',
            height: 30
      });*/
      
      //funciones CRUD
      $('#nuevo').on('click', function(event) {
            ctxEnt.nuevaEntidad();
            
      });
      $("#clasificador").on('click', "#editar, .sel_edit", function(){
          ctxEnt.editarEntidad();
      });
      $("#clasificador").on('click', '#eliminar, .sel_delete', function(){
          ctxEnt.eliminarEntidad();
      });

         
      //fila seleccionada
      $('#treeGrid').on('rowSelect', function (event) {
        var args = event.args;
        var row = args.row;
        id_seleccionado=row.id_clasificador;
        nivel_seleccionado = row.nivel;
        si_adiciona = row.si_adiciona_entidad;
        fila_seleccionada = row;
        //alert("The row you selected is: " + row.si_adiciona_entidad + " " + row.id_clasificador);
      });
     
      $("#form-nuevo").validate(ctxEnt.reglasValidacionEntidad('insert'));  
      $( "#form-edit" ).validate(ctxEnt.reglasValidacionEntidad('edit'));         

      $('#treeGrid').on('bindingComplete', function (event) { 
        $("#treeGrid").jqxTreeGrid('expandAll');
      });




 })


    function saveFormNew(){
      
      console.log("saludos desde el saveFormNew");
      
      //alert("saludos desde el saveFormNew");
      
     
      var formData = new FormData($("#form-nuevo")[0]);
      formData.append("id_clasificador_dependiente", id_seleccionado);
      formData.append("nivel_seleccionado", nivel_seleccionado);
      
      $('#treeGrid').on('bindingComplete', function() {
                      $("#treeGrid").jqxTreeGrid('expandAll');
      });

      $.ajax({
              url: "{{ url('/moduloplanificacion/saveInstitucion') }}",
              type: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function(data){
                  new PNotify({
                      title: data.title,
                      text: data.msg,
                      shadow: true,
                      opacity: 1,
                      addclass: noteStack,
                      type: "success",
                      stack: Stacks[noteStack],
                      width: findWidth(),
                      delay: 1400
                  });
                  $("#treeGrid").jqxTreeGrid('updateBoundData');
                  $("#form-nuevo")[0].reset();

              },
              error:function(data){
                  new PNotify({
                      title: data.title,
                      text: data.msg,
                      shadow: true,
                      opacity: 1,
                      addclass: noteStack,
                      type: "danger",
                      stack: Stacks[noteStack],
                      width: findWidth(),
                      delay: 1400
                  });
              }
      });
    }
    function saveFormEdit(){

      var formData = new FormData($("#form-edit")[0]);
        $.ajax({
                url: "/moduloplanificacion/saveInstitucionEdit",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    new PNotify({
                        title: data.title,
                        text: data.msg,
                        shadow: true,
                        opacity: 1,
                        addclass: noteStack,
                        type: "success",
                        stack: Stacks[noteStack],
                        width: findWidth(),
                        delay: 1400
                    });
                    $("#treeGrid").jqxTreeGrid('updateBoundData');
                    
                  $("#form-edit")[0].reset();
                },
                error:function(data){
                    new PNotify({
                        title: data.title,
                        text: data.msg,
                        shadow: true,
                        opacity: 1,
                        addclass: noteStack,
                        type: "danger",
                        stack: Stacks[noteStack],
                        width: findWidth(),
                        delay: 1400
                    });
                }
        });
    }


  </script>
@endpush
