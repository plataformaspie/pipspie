@extends('layouts.sisgri')

@section('header')
    <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />

@endsection

@section('title-topbar')
  <div class="topbar-left">
      <ol class="breadcrumb">
          <li class="crumb-active">
              <a href="dashboard.html">Pilares</a>
          </li>
          <li class="crumb-icon">
              <a href="/sistemasisgri/index">
                  <span class="glyphicon glyphicon-home"></span>
              </a>
          </li>
          <li class="crumb-link">
              <a href="/sistemasisgri/index">Home</a>
          </li>
          <li class="crumb-trail">Pilares</li>
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
              <span class="panel-title"> Pilares Valores </span>
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
  <div id="modal-form" class=" popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Registrar Pilar</span>
          </div>
          <!-- end .panel-heading section -->

          <form method="post" action="/" id="comment">
              <div class="panel-body p25">
                  <div class="section row">
                      <div class="col-md-12">
                          <label for="firstname" class="field prepend-icon">
                              <input type="text" name="firstname" id="firstname" class="gui-input" placeholder="Codigo...">
                              <label for="firstname" class="field-icon"><i class="fa fa-barcode"></i>
                              </label>
                          </label>
                      </div>
                      <!-- end section -->
                  </div>
                  <!-- end section row section -->
                  <div class="section">
                      <label for="comment" class="field prepend-icon">
                          <textarea class="gui-textarea" id="comment" name="comment" placeholder="Nombre pilar..."></textarea>
                          <label for="comment" class="field-icon"><i class="fa fa-comments"></i>
                          </label>
                          <span class="input-footer">
                              <strong>Nota: </strong>Registre el nombre oficial del Pilar.</span>
                      </label>
                  </div>

                  <div class="row">
                    <div class="col-xs-12">
                      <div class="fileupload fileupload-new admin-form" data-provides="fileupload">
                          <div class="fileupload-preview thumbnail mb15">
                              <img data-src="holder.js/400x300"  alt="holder">
                          </div>
                          <span class="button btn-system btn-file btn-block ph5">
                             <span class="fileupload-new">Seleccione logo</span>
                             <span class="fileupload-exists">Seleccione logo</span>
                             <input type="file">
                          </span>
                      </div>
                    </div>
                  </div>
<a href="#" class="btn btn-danger mb10 mr5 notification" data-note-style="danger">Danger</a>


              </div>
              <!-- end .form-body section -->

              <div class="panel-footer">
                  <button type="submit" class="button btn-primary">Validar y Guardar</button>
              </div>
              <!-- end .form-footer section -->
          </form>
      </div>
      <!-- end: .panel -->
  </div>
  <!-- end: .admin-form -->



  <!-- Admin Form Popup -->
  <div id="modal-editar" class=" popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Modificar Pilar</span>
          </div>
          <!-- end .panel-heading section -->

          <form method="post" action="/" id="form-edit" name="form-edit" enctype="multipart/form-data">
            {{ csrf_field() }}
              <input type="hidden" name="mod_id" id="mod_id" value="">
              <div class="panel-body p25">
                  <div class="section row">
                      <div class="col-md-12">
                          <label for="mod_cod_p" class="field prepend-icon">
                              <input type="text" name="mod_cod_p" id="mod_cod_p" class="gui-input" placeholder="Codigo...">
                              <label for="mod_cod_p" class="field-icon"><i class="fa fa-barcode"></i>
                              </label>
                          </label>
                      </div>


                  </div>

                  <div class="section">
                      <label for="mod_descripcion" class="field prepend-icon">
                          <textarea class="gui-textarea" id="mod_descripcion" name="mod_descripcion" placeholder="Nombre pilar..."></textarea>
                          <label for="mod_descripcion" class="field-icon"><i class="fa fa-comments"></i>
                          </label>
                          <span class="input-footer">
                              <strong>Nota: </strong>Registre el nombre oficial del Pilar.</span>
                      </label>

                  </div>

                  <div class="row">
                    <div class="col-xs-12">
                      <div class="fileupload fileupload-new admin-form" data-provides="fileupload">

                          <div class="fileupload-preview thumbnail mb15">
                              <img id="mod_img_logo" name="mod_img_logo" src="" alt="Logo">
                          </div>
                          <button id="cleanFile" type="button" class="btn btn-danger"><i class="glyphicons glyphicons-cleaning"></i> </button>
                          <span class="button btn-system btn-file btn-block ph5" style="width: 85%;">
                             <span class="fileupload-new">Buscar logo</span>
                             <span class="fileupload-exists">Buscar logo</span>
                             <input type="file" id ="mod_logo" name="mod_logo" accept=".jpg,.png,.gif,.jpeg">
                             <input type="hidden" id="logo_load" name="logo_load" value="">
                          </span>


                      </div>
                    </div>
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


  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcore.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxbuttons.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxscrollbar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdata.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdatatable.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function(){
        activarMenu('1','1');
        $(document).keydown(function(tecla){
              if (tecla.keyCode == 113) {
                var rowindex = $('#dataTable').jqxDataTable('getSelection');
                if (rowindex.length > 0)
                {
                    var rowData = rowindex[0];
                    $.ajax({
                            url: "{{ url('/api/sistemasisgri/dataSetPilar') }}",
                            type: "GET",
                            dataType: 'json',
                            data:{'id':rowData.id},
                            success: function(data){
                                $("#form-edit em").remove();

                                $('input[name="mod_id"]').val(data.id);
                                var input = $("#mod_logo");
                                input.replaceWith(input.val('').clone(true));
                                $('input[name="logo_load"]').val(data.logo);
                                if(data.logo){
                                  $("#mod_img_logo").attr("src","/img/"+data.logo);
                                }else{
                                  $("#mod_img_logo").attr("src","");
                                }




                                $('textarea[name="mod_descripcion"]').val(data.descripcion);
                                $('input[name="mod_cod_p"]').val(data.cod_p);
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




        var url = '{{ url('api/sistemasisgri/setPilares') }}';
        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'cod_p', type: 'int' },
                { name: 'descripcion', type: 'string' },
                { name: 'logo', type: 'string' }
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
              { text: 'Logo', dataField: 'logo', width: 100,
                    cellsRenderer: function (row, column, value, rowData) {
                        if(rowData.logo){
                            var image = "<div style='margin: 5px; margin-bottom: 3px;'>";
                            var imgurl = rowData.logo ;
                            var img = '<img width="60" height="60" style="display: block;" src="/img/' + imgurl + '"/>';
                            image += img;
                            image += "</div>";
                            return image;
                        }else{
                          return "";
                        }

                    }
              },
              { text: 'Codigo', dataField: 'cod_p', width: 100,cellsAlign: 'center' },
              { text: 'Descripción', dataField: 'descripcion' }
          ]
        });



        //MODAL Config
        // Form Skin Switcher
        $('#nuevo').on('click', function() {
            // Inline Admin-Form example
            $.magnificPopup.open({
                removalDelay: 500, //delay removal by X to allow out-animation,
                items: {
                    src: "#modal-form"
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

        });

        $('#editar').on('click', function(event) {
          var rowindex = $('#dataTable').jqxDataTable('getSelection');
          if (rowindex.length > 0)
          {
              var rowData = rowindex[0];
              $.ajax({
                      url: "{{ url('/api/sistemasisgri/dataSetPilar') }}",
                      type: "GET",
                      dataType: 'json',
                      data:{'id':rowData.id},
                      success: function(data){
                          $("#form-edit em").remove();

                          $('input[name="mod_id"]').val(data.id);
                          var input = $("#mod_logo");
                          input.replaceWith(input.val('').clone(true));
                          $('input[name="logo_load"]').val(data.logo);
                          if(data.logo){
                            $("#mod_img_logo").attr("src","/img/"+data.logo);
                          }else{
                            $("#mod_img_logo").attr("src","");
                          }





                          $('textarea[name="mod_descripcion"]').val(data.descripcion);
                          $('input[name="mod_cod_p"]').val(data.cod_p);
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


        //VISTA PREVIA ImG

        $('#mod_logo').change(function(e) {
          addImage(e);
        });

        function addImage(e){
          var file = e.target.files[0],
          imageType = /image.*/;

          if (!file.type.match(imageType))
           return;

          var reader = new FileReader();
          reader.onload = fileOnload;
          reader.readAsDataURL(file);
        }

        function fileOnload(e) {
          var result=e.target.result;
          $('#mod_img_logo').attr("src",result);
        }

        $('#cleanFile').on('click', function(event) {
            $('#mod_img_logo').attr("src","");
            $('#logo_load').val("");
            var input = $("#mod_logo");
            input.replaceWith(input.val('').clone(true));
        });
        ///Vista previa------------------

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
                        mod_descripcion:  {
                                required: true
                        },
                        mod_logo:  {
                                required: function(){
                                  if($("input[name=logo_load]").val() != ""){
                                      return false;
                                  }
                                  else
                                  {
                                      return true;
                                  }
                                },
                                extension:"jpg|png|gif|jpeg"
                        }


                },

                /* @validation error messages
                ---------------------------------------------- */

                messages:{
                        mod_cod_p: {
                                required: 'Ingresar el codigo'
                        },
                        mod_descripcion:  {
                                required: 'Ingresar el nombre'
                        },
                        mod_logo:  {
                                required: 'Por favor, busque un logo',
                                extension: 'Formato de archivo no soportado'
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
                  saveDataPilar();
                }


        });






    });

    function saveDataPilar(){

    var formData = new FormData($("#form-edit")[0]);
      $.ajax({
              url: "{{ url('/api/sistemasisgri/saveDataPilar') }}",
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
