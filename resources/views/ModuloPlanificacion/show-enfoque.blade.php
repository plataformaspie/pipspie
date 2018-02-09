@extends('layouts.moduloplanificacion')
@section('headerIni')
  <link rel="stylesheet" type="text/css" href="{{ asset('sty-mode-2/vendor/editors/summernote/summernote.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('sty-mode-2/vendor/editors/summernote/summernote-bs3.css') }}">
@endsection
@section('header')
  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
  <link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

<style media="screen">
.popup-basic {
  position: relative;
  background: #FFF;
  width: auto;
  max-width: 900px;
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
.dina4 {
    width: auto;
    max-width: 210mm;
    padding: 20px 60px;
    border: 1px solid #D2D2D2;
    background: #fff;
    margin: 10px auto;
}

</style>

@endsection

@section('title-topbar')
  <div class="topbar-left">
      <ol class="breadcrumb">
          <li class="crumb-active">
              <a href="dashboard.html">Enfoque Político</a>
          </li>
          <li class="crumb-icon">
              <a href="/sistemasisgri/index">
                  <span class="glyphicon glyphicon-home"></span>
              </a>
          </li>
          <li class="crumb-link">
              <a href="/sistemasisgri/index">Home</a>
          </li>
          <li class="crumb-trail">Enfoque Político</li>
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
  <!--div class="tray tray-center p25 va-t posr">

      <div class="panel mb25 mt5">
          <div class="panel-heading">
              <span class="panel-title"> Enfoque Político </span>
          </div>

          <section class="wizard-section">
            <div class="section">
              <div class="panel mb40">
                  <div class="panel-body pn of-h">
                      <textarea class="summernote" style="height: 400px;"></textarea>
                  </div>
              </div>

            </div>
          </section>
      </div>
  </div-->

  <!--div class="tray tray-center p25 va-t posr">

      <div class="panel mb25 mt5">
          <div class="panel-heading">
              <span class="panel-title"> Registro de Enfoque Polìtico</span>
          </div>
          <div class="panel-body p20 pb10">
              <div class="tab-content pn br-n">
                <section class="wizard-section">
                  <div class="section">
                    <label for="enfoque_politico" class="field">
                        <div class="panel mb40">
                            <div class="panel-body pn of-h">
                                <textarea class="summernote"  name="enfoque_politico">{{ $enfoque }}</textarea>
                            </div>
                        </div>
                   </label>
                  </div>
                </section>
              </div>
          </div>


      </div>
  </div-->
  <div class="tray tray-center p25 va-t posr">

      <div class="panel mb5 mt5">
          <div class="panel-heading">
              <span class="panel-title"> Registro de Enfoque Polìtico </span>
          </div>

          <div class=" ">
              <div class="tab-content pn br-n admin-form">
                  <button id="editar" type="button" class="btn btn-default m5"><i class="fa fa-edit icon-warning"></i> Editar</button>
              </div>
          </div>

      </div>
          <div class="panel-body">
              <div class="tab-content pn br-n">
                  <div class="dina4">{{ $enfoque }}</div>
              </div>
          </div>


  </div>



  <!-- Admin Form Popup -->
  <div id="modal-editar"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Modificar Enfoque Politico</span>
          </div>
          <!-- end .panel-heading section -->
          <form method="post" action="/" id="form-edit" name="form-edit">
            {{ csrf_field() }}

              <input type="hidden" name="mod_id" id="mod_id" value="">



              <div class="panel-body mnw700 of-a">
                  <div class="row">
                      <!-- Icon Column -->
                      <div class="col-md-12 ">
                        <div class="panel-body p20 pb10">
                            <div class="tab-content pn br-n">
                              <section class="wizard-section">
                                <div class="section">
                                     <div class="panel">
                                          <div class="panel-body pn of-h">
                                              <textarea id="mod_enfoque_politico" class="summernote" name="mod_enfoque_politico"> </textarea>
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
      <!-- end: .panel -->
  </div>
  <!-- end: .admin-form -->

@endsection

@push('script-head')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
  <script type="text/javascript" src="{{ asset('sty-mode-2/vendor/editors/summernote/summernote.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcore.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxbuttons.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxscrollbar.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdata.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdatatable.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdraw.js') }}"></script>
  <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxchart.core.js') }} "></script>

  <script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
  <script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
        activarMenu('1','2');
        // Init Summernote
        $('.summernote').summernote({
            height: 350, //set editable area's height
            focus: false, //set focus editable area after Initialize summernote
            toolbar: [
              ['style', ['bold', 'italic', 'underline', 'clear']],
              ['font', ['strikethrough', 'superscript', 'subscript']],
              ['fontsize', ['fontsize']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['height', ['height']]
            ],
            oninit: function() {},
            onChange: function(contents, $editable) {},

        });

        $(document).keydown(function(tecla){
              if (tecla.keyCode == 113) {



              }
        });



            $('#editar').on('click', function(event) {
                  $.ajax({
                          url: "{{ url('/api/moduloplanificacion/dataEntidadEnfoque') }}",
                          type: "GET",
                          dataType: 'json',
                          success: function(data){

                            $("#form-edit em").remove();
                            $('#mod_enfoque_politico').html(data.enfoque_politico);
                            $('.summernote').summernote({
                                callbacks: {
                                    onChange: function (contents, $editable) {
                                        $(this).val(contents);
                                    }
                                }
                            });


                              //$('.note-editable').html(data.enfoque_politico);
                          },
                          error:function(data){
                            console("Error recuperar los datos.");
                          }
                  });
                  // Inline Admin-Form example
                  $.magnificPopup.open({
                      removalDelay: 500, //delay removal by X to allow out-animation,
                      focus: '#focus-blur-loop-select',
                      items: {
                          src: "#modal-editar"
                      },

                      callbacks: {
                          beforeOpen: function(e) {
                              var Animation = "mfp-zoomOut";
                              this.st.mainClass = Animation;
                          }
                      },
                      midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
                  });

            });




            /* @custom validation method (smartCaptcha)
            ------------------------------------------------------------------ */
            $( "#form-edit" ).validate({

                    /* @validation states + elements
                    ------------------------------------------- */

                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    /* @validation rules
                    ------------------------------------------ */

                    rules: {
                            mod_variable: {
                                    required: true
                            },
                            mod_indicador:  {
                                    required: true
                            },
                            mod_unidad: {
                                    required: true
                            }


                    },

                    /* @validation error messages
                    ---------------------------------------------- */

                    messages:{
                            mod_variable: {
                                    required: 'Ingresar la Variable'
                            },
                            mod_indicador:  {
                                    required: 'Ingresar el Indicador'
                            },
                            mod_unidad:  {
                                    required: 'Por favor, selecciones una opcion'
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
                      saveFormEdit();
                    }


            });

            $( "#form-nuevo" ).validate({

                    /* @validation states + elements
                    ------------------------------------------- */

                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    /* @validation rules
                    ------------------------------------------ */

                    rules: {
                            variable: {
                                    required: true
                            },
                            indicador:  {
                                    required: true
                            },
                            unidad: {
                                    required: true
                            }


                    },

                    /* @validation error messages
                    ---------------------------------------------- */

                    messages:{
                            variable: {
                                    required: 'Ingresar la Variable'
                            },
                            indicador:  {
                                    required: 'Ingresar el Indicador'
                            },
                            unidad:  {
                                    required: 'Por favor, selecciones una opcion'
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
                      saveFormNew();
                    }


            });


    });
    function saveFormNew(){

    var formData = new FormData($("#form-nuevo")[0]);
      $.ajax({
              url: "{{ url('/api/moduloplanificacion/saveDataNew') }}",
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
              url: "{{ url('/api/moduloplanificacion/saveDataEdit') }}",
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
