@extends('layouts.sisgri')

@section('header')
  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
  <style media="screen">

  </style>
@endsection

@section('title-topbar')
  <div class="topbar-left">
      <ol class="breadcrumb">
          <li class="crumb-active">
              <a href="dashboard.html">Clasificador</a>
          </li>
          <li class="crumb-icon">
              <a href="/sistemasisgri/index">
                  <span class="glyphicon glyphicon-home"></span>
              </a>
          </li>
          <li class="crumb-link">
              <a href="/sistemasisgri/index">Home</a>
          </li>
          <li class="crumb-trail">Clasificador</li>
      </ol>
  </div>
  <div class="topbar-right">
      <div class="ml15 ib va-m" id="toggle_sidemenu_r">
          <a href="#" class="pl5"> <i class="fa fa-sign-in fs22 text-primary"></i>
              <span class="badge badge-hero badge-danger">3</span>
          </a>
      </div>
  </div>
@endsection

@section('content')

  <div class="tray tray-center p25 va-t posr">
      <!-- create new order panel -->
      <div class="panel mb25 mt5">
          <div class="panel-heading">
              <span class="panel-title"> Clasificadores </span>
          </div>


          <div class="panel-body p20 pb10">
              <div class="tab-content pn br-n admin-form">
                  <button id="nuevo" type="button" class="btn btn-success m5"><i class="glyphicons glyphicons-circle_plus"></i> Nuevo Clasificador</button>
                  <button id="editar" type="button" class="btn btn-success m5"><i class="fa fa-edit"></i> Editar Clasificador</button>
                  <button id="eliminar" type="button" class="btn btn-success m5"><i class="glyphicons glyphicons-bin"></i> Eliminar Categoria </button>
                  <button id="categorias" type="button" class="btn btn-success m5"><i class="glyphicons glyphicons-eye_open"></i> Ver Categoria </button>

                  <div id="dataTable"></div>

              </div>
          </div>
      </div>
  </div>



  <!-- Admin Form Popup -->
  <div id="modal-editar" class=" popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Modificar Clasificador</span>
          </div>
          <!-- end .panel-heading section -->

          <form method="post" action="/" id="form-edit" name="form-edit" enctype="multipart/form-data">
            {{ csrf_field() }}
              <input type="hidden" name="mod_id" id="mod_id" value="">
              <div class="panel-body p25">

                  <div class="section row">
                      <div class="col-md-12">
                          <label for="mod_cod_p" class="field prepend-icon">
                            <select id="mod_cod_p" name="mod_cod_p" class="field prepend-icon" style="width:100%;">

                            </select>
                          </label>
                      </div>
                  </div>

                  <div class="section row">
                      <div class="col-md-12">
                          <label for="mod_cod_m" class="field prepend-icon">
                              <input type="text" name="mod_cod_m" id="mod_cod_m" class="gui-input" placeholder="Codigo...">
                              <label for="mod_cod_m" class="field-icon"><i class="fa fa-barcode"></i>
                              </label>
                          </label>
                      </div>
                  </div>

                  <div class="section">
                      <label for="mod_descripcion" class="field prepend-icon">
                          <textarea class="gui-textarea" id="mod_descripcion" name="mod_descripcion" placeholder="Nombre metas..."></textarea>
                          <label for="mod_descripcion" class="field-icon"><i class="fa fa-comments"></i>
                          </label>
                          <span class="input-footer">
                              <strong>Nota: </strong>Registre el nombre oficial de la Meta.</span>
                      </label>
                  </div>


              </div>


              <div class="panel-footer">
                  <button type="submit" class="button btn-primary">Validar y Guardar</button>
              </div>

          </form>
      </div>
      <!-- end: .panel -->
  </div>
  <!-- end: .admin-form -->


  <!-- Admin Form Popup -->
  <div id="modal-categorias" class=" popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Categorias</span>
          </div>
          <!-- end .panel-heading section -->

          <form method="post" action="/" id="form-categorias" name="form-categorias" enctype="multipart/form-data">
            {{ csrf_field() }}
              <input type="hidden" name="cat_id" id="cat_id" value="">
              <div class="panel-body p25">




              </div>


              <div class="panel-footer">
                  -
              </div>

          </form>
      </div>
      <!-- end: .panel -->
  </div>
  <!-- end: .admin-form -->

@endsection

@push('script-head')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcore.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxbuttons.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxscrollbar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdata.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdatatable.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        activarMenu('3','1');
        $(document).keydown(function(tecla){
              if (tecla.keyCode == 113) {



              }
        });

        $("#mod_cod_p").select2({
          placeholder: "Seleccione Pilar"
        });


        var url = '{{ url('api/sistemasisgri/setClasificadores') }}';
        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'contador', type: 'int' },
                { name: 'nombre_clasificador', type: 'string' },
                { name: 'nombre_corto', type: 'string' },
                { name: 'nivel', type: 'string' },
                { name: 'padre', type: 'int' },
                { name: 'num_categorias', type: 'int' },
            ],
            id: 'id',
            url: url
        };
        var dataAdapter = new $.jqx.dataAdapter(source);
        $("#dataTable").jqxDataTable(
        {
            source: dataAdapter,
            width:"100%",
            columnsResize: true,
            columns: [
              { text: '#', dataField: 'contador', width: 100,cellsAlign: 'center' },
              { text: 'Nombre Clasificador', dataField: 'nombre_clasificador' },
              { text: 'Nombre Corto', dataField: 'nombre_corto' },
              { text: 'Num Categorias', dataField: 'num_categorias', cellsAlign: 'center' }


          ]
        });

        $('#editar').on('click', function(event) {
          var rowindex = $('#dataTable').jqxDataTable('getSelection');
          if (rowindex.length > 0)
          {
              var rowData = rowindex[0];
              $.ajax({
                      url: "{{ url('/api/sistemasisgri/dataSetMeta') }}",
                      type: "GET",
                      dataType: 'json',
                      data:{'id':rowData.id},
                      success: function(data){
                          $("#form-edit em").remove();
                          $("#mod_cod_p").val(data.pilar).trigger('change');
                          $('input[name="mod_id"]').val(data.id);

                          $('textarea[name="mod_descripcion"]').val(data.descripcion);
                          $('input[name="mod_cod_m"]').val(data.cod_m);
                      },
                      error:function(data){
                        console("Error recuperar los datos.");
                      }
              });

              // Inline Admin-Form example
              $.magnificPopup.open({
                  removalDelay: 500, //delay removal by X to allow out-animation,
                  items: {
                      src: "#modal-editar"
                  },
                  // overflowY: 'hidden', //
                  callbacks: {
                      beforeOpen: function(e) {
                          var Animation = "mfp-zoomOut";
                          this.st.mainClass = Animation;
                      }
                  },
                  midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
              });
          }else {
              alert("Seleccione el registro a modificar.");
          }
        });


        $('#categorias').on('click', function(event) {
          var rowindex = $('#dataTable').jqxDataTable('getSelection');
          if (rowindex.length > 0)
          {
              var rowData = rowindex[0];
              /*$.ajax({
                      url: "",
                      type: "GET",
                      dataType: 'json',
                      data:{'id':rowData.id},
                      success: function(data){
                          $("#form-edit em").remove();
                          $("#mod_cod_p").val(data.pilar).trigger('change');
                          $('input[name="mod_id"]').val(data.id);

                          $('textarea[name="mod_descripcion"]').val(data.descripcion);
                          $('input[name="mod_cod_m"]').val(data.cod_m);
                      },
                      error:function(data){
                        console("Error recuperar los datos.");
                      }
              });*/

              // Inline Admin-Form example
              $.magnificPopup.open({
                  removalDelay: 500, //delay removal by X to allow out-animation,
                  items: {
                      src: "#modal-categorias"
                  },
                  // overflowY: 'hidden', //
                  callbacks: {
                      beforeOpen: function(e) {
                          var Animation = "mfp-zoomOut";
                          this.st.mainClass = Animation;
                      }
                  },
                  midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
              });
          }else {
              alert("Seleccione clasificador para ver sus categorias.");
          }
        });


        /* @custom validation method (smartCaptcha)
        ------------------------------------------------------------------ */

        $.validator.methods.smartCaptcha = function(value, element, param) {
                return value == param;
        };

        $( "#form-edit" ).validate({

                /* @validation states + elements
                ------------------------------------------- */

                errorClass: "state-error",
                validClass: "state-success",
                errorElement: "em",

                /* @validation rules
                ------------------------------------------ */

                rules: {
                        mod_cod_p: {
                                required: true
                        },
                        mod_cod_m: {
                                required: true
                        },
                        mod_descripcion:  {
                                required: true
                        }


                },

                /* @validation error messages
                ---------------------------------------------- */

                messages:{
                        mod_cod_p: {
                                required: 'Seleccione un valor'
                        },
                        mod_cod_m: {
                                required: 'Ingresar el codigo'
                        },
                        mod_descripcion:  {
                                required: 'Ingresar el nombre'
                        }

                },

                /* @validation highlighting + error placement
                ---------------------------------------------------- */

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
                  saveData();
                }


        });








    });



    function saveData(){

    var formData = new FormData($("#form-edit")[0]);
      $.ajax({
              url: "{{ url('/api/sistemasisgri/saveDataMeta') }}",
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
                  $("#dataTable").jqxDataTable("updateBoundData");
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
