@extends('layouts.sisgri')

@section('header')
  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />

<style media="screen">
.select2-dropdown {
  z-index: 9001;
}
</style>
@endsection

@section('title-topbar')
  <div class="topbar-left">
      <ol class="breadcrumb">
          <li class="crumb-active">
              <a href="dashboard.html">Resultados</a>
          </li>
          <li class="crumb-icon">
              <a href="/sistemasisgri/index">
                  <span class="glyphicon glyphicon-home"></span>
              </a>
          </li>
          <li class="crumb-link">
              <a href="/sistemasisgri/index">Home</a>
          </li>
          <li class="crumb-trail">Resultados</li>
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
              <span class="panel-title"> Resultados Valores </span>
          </div>


          <div class="panel-body p20 pb10">
              <div class="tab-content pn br-n admin-form">
                  <!--button id="nuevo" type="button" class="btn btn-success m5"><i class="glyphicons glyphicons-circle_plus"></i> </button-->
                  <button id="editar" type="button" class="btn btn-success m5"><i class="fa fa-edit"></i> Editar</button>
                  <!--button id="eliminar" type="button" class="btn btn-success m5"><i class="glyphicons glyphicons-bin"></i> </button-->

                  <div id="dataTable"></div>

              </div>
          </div>
      </div>
  </div>



  <!-- Admin Form Popup -->
  <div id="modal-editar" class=" popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Modificar Resultado</span>
          </div>
          <!-- end .panel-heading section -->

          <form method="post" action="/" id="form-edit" name="form-edit" enctype="multipart/form-data">
            {{ csrf_field() }}
              <input type="hidden" name="mod_id" id="mod_id" value="">
              <div class="panel-body p25">

                  <div class="section row">
                      <div class="col-md-12">
                          <label for="mod_cod_m" class="field prepend-icon">
                            <select id="mod_cod_m" name="mod_cod_m" class="field prepend-icon" style="width:100%;">
                              @foreach($metas as $m)
                                <option value="{{$m->id_meta}}"> {{$m->cod_p}}.{{$m->cod_m}} {{$m->desc_m}} </option>
                              @endforeach
                            </select>
                          </label>
                      </div>
                  </div>

                  <div class="section row">
                      <div class="col-md-12">
                          <label for="mod_cod_r" class="field prepend-icon">
                              <input type="text" name="mod_cod_r" id="mod_cod_r" class="gui-input" placeholder="Codigo...">
                              <label for="mod_cod_r" class="field-icon"><i class="fa fa-barcode"></i>
                              </label>
                          </label>
                      </div>
                  </div>

                  <div class="section">
                      <label for="mod_descripcion" class="field prepend-icon">
                          <textarea class="gui-textarea" id="mod_descripcion" name="mod_descripcion" placeholder="Nombre resultado..."></textarea>
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
        activarMenu('1','3');
        $(document).keydown(function(tecla){
              if (tecla.keyCode == 113) {
                var rowindex = $('#dataTable').jqxDataTable('getSelection');
                if (rowindex.length > 0)
                {
                    var rowData = rowindex[0];
                    $.ajax({
                            url: "{{ url('/api/sistemasisgri/dataSetResultado') }}",
                            type: "GET",
                            dataType: 'json',
                            data:{'id':rowData.id},
                            success: function(data){
                                $("#form-edit em").remove();
                                $("#mod_cod_m").val(data.meta).trigger('change');
                                $('input[name="mod_id"]').val(data.id);

                                $('textarea[name="mod_descripcion"]').val(data.descripcion);
                                $('input[name="mod_cod_r"]').val(data.cod_r);
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
              }
        });

        $("#mod_cod_m").select2({
          placeholder: "Seleccione Meta"
        });


        var url = '{{ url('api/sistemasisgri/setResultados') }}';
        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'cod_r', type: 'int' },
                { name: 'codigo', type: 'string' },
                { name: 'nombre', type: 'string' },
                { name: 'descripcion', type: 'string' },
                { name: 'meta', type: 'int' }
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
              { text: 'Pilar-Meta', dataField: 'codigo', width: 100,cellsAlign: 'center' },
              { text: 'Codigo', dataField: 'cod_r', width: 100,cellsAlign: 'center' },
              { text: 'Descripción', dataField: 'descripcion' }
          ]
        });

        $('#editar').on('click', function(event) {
          var rowindex = $('#dataTable').jqxDataTable('getSelection');
          if (rowindex.length > 0)
          {
              var rowData = rowindex[0];
              $.ajax({
                      url: "{{ url('/api/sistemasisgri/dataSetResultado') }}",
                      type: "GET",
                      dataType: 'json',
                      data:{'id':rowData.id},
                      success: function(data){
                          $("#form-edit em").remove();
                          $("#mod_cod_m").val(data.meta).trigger('change');
                          $('input[name="mod_id"]').val(data.id);

                          $('textarea[name="mod_descripcion"]').val(data.descripcion);
                          $('input[name="mod_cod_r"]').val(data.cod_r);
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
                        mod_cod_m: {
                                required: true
                        },
                        mod_cod_r: {
                                required: true
                        },
                        mod_descripcion:  {
                                required: true
                        }


                },

                /* @validation error messages
                ---------------------------------------------- */

                messages:{
                        mod_cod_m: {
                                required: 'Seleccione un valor'
                        },
                        mod_cod_r: {
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
              url: "{{ url('/api/sistemasisgri/saveDataResultado') }}",
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
