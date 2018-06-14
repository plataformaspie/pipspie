@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
<link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

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

@section('title-topbar')
<div class="topbar-left">
    <ol class="breadcrumb">
        <li class="crumb-active">
            <a href="dashboard.html">Planes de su Institucion</a>
        </li>
        <li class="crumb-icon">
            <a href="/sistemasisgri/index">
                <span class="glyphicon glyphicon-home"></span>
            </a>
        </li>
        <li class="crumb-link">
            <a href="/sistemasisgri/index">Home</a>
        </li>
        <li class="crumb-trail">Administrar Planes</li>
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


<div class="tray tray-center p40 va-t posr">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-visible" >
                <div class="panel-heading text-center">
                    <span class="panel-title"> Listado de Entidades con Planes</span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="estructura" class="col-md-12" >
                            <button id="nuevo" type="button" class="btn btn-sm btn-default m5 btn-alt  "   data-effect="mfp-zoomIn"><i class="fa fa-edit icon-primary"></i> Agregar Plan</button>
                            <button id="editar" type="button" class="btn btn-sm btn-default m5 btn-alt"><i class="fa fa-edit icon-warning"></i> Editar</button>
                            <button id="eliminar" type="button" class="btn btn-sm btn-default m5 btn-alt"><i class="glyphicons glyphicons-bin icon-danger"></i> Eliminar</button>
                            <div id="dataTable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Admin Form Popup -->
<div id="modal-nuevo"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide ">
    <div class="panel">
      <div class="panel-heading">
          <span class="panel-title" id="tituloModal"><i class="fa fa-pencil"></i> <span> </span></span>
      </div>
          <!-- end .panel-heading section -->
      <form method="post" action="/" id="form-nuevo" name="form-nuevo">
        {{ csrf_field() }}

          <div class="panel-body mnw700 of-a">
              <div class="row">

                  <!-- Chart Column -->
                  <div class="col-md-7 pln br-r mvn15">
                      <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Datos del plan<small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>
                      <div class="section">
                          <label class="field-label" for="nombre">Nombre</label>
                          <label for="nombre" class="field prepend-icon">
                              <input type="text" class="gui-input" id="nombre" name="indicador" placeholder="Nombre corto">
                              <label for="nombre" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                              </label>
                          </label>
                      </div>
                      <div class="section">
                          <label class="field-label" for="tipoPlan">Tipo de Plan</label>
                          <label for="tipoPlan" class="field prepend-icon">
                              <select id="tipoPlan" name="unidad" class="field prepend-icon" style="width:100%;">
                                <option value="1">Plan Sectorial de Desarrollo Integral para Vivir Bien</option>
                                <option value="2">Plan Territorial de Desarrollo Integral para Vivir Bien</option>
                                <option value="3">Plan Estratégico Ministerial</option>
                                <option value="4">Plan Estratégico Institucional</option>
                                </select>
                              {{-- <label for="variable" class="field-icon"><i class=" glyphicons glyphicons-notes"></i> --}}
                              {{-- </label> --}}
                          </label>
                      </div>
                      <div class="section">
                          <label class="field-label" for="descripcion">Descripción</label>
                          <label for="descripcion" class="field prepend-icon">
                              <textarea class="gui-textarea" id="descripcion" name="variable"  placeholder="Descripción" rows="2"></textarea>
                              <label for="descripcion" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                              </label>
                          </label>
                      </div>

                      <div class="section">
                        <label class="field-label" for="gestionInicio">Gestión inicio</label>
                          <label for="gestionInicio" class="field prepend-icon">
                              <input type="text" class="gui-input" id="gestionInicio" name="indicador" placeholder="Gestión inicio">
                              <label for="gestionInicio" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                              </label>
                          </label>
                      </div>
                      <div class="section">
                        <label class="field-label" for="gestionFin">Gestión fin</label>
                          <label for="gestionFin" class="field prepend-icon">
                              <input type="text" class="gui-input" id="gestionFin" name="indicador" placeholder="Gestión fin">
                              <label for="gestionFin" class="field-icon"><i class="glyphicons glyphicons-riflescope"></i>
                              </label>
                          </label>
                      </div>
                  </div>
              </div>
          </div>

          <div class="panel-footer">
              <button type="submit" class="button btn-primary">Guardar</button>
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
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdraw.js') }}"></script>
<script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxtreegrid.js') }} "></script>

<script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
<script type="text/javascript" src="{{ asset('js/jqwidgets-localization.js') }}"></script>
<script type="text/javascript">
$(function(){
    var cnf = {
        urlBase : '/api/moduloplanificacion/',
    }

    var planes = {
        dataTable : $("#dataTable"),
        btnAgregar : $("#nuevo"),
        btnEditar : $("#editar"),
        btnEliminarr : $("#eliminar"),
        source : {},
        fillPlanes : function()
        {
            $.get('/api/moduloplanificacion/setEntidadPlan', function(resp)
            {
                this.source =
                {
                    dataType: "json",
                    localdata: resp,
                    dataFields: [
                        { name: 'id', type: 'number' },
                        { name: 'gestion_inicio', type: 'number' },
                        { name: 'gestion_fin', type: 'number' },
                        { name: 'nombre', type: 'string' },
                        { name: 'sigla', type: 'string' },
                        { name: 'plan', type: 'string' }
                    ],
                    id: 'id',
                    {{-- url: '{{ url('api/moduloplanificacion/setEntidadPlan') }}' --}}
                };
                //Configuracion de la tabla
                var dataAdapter = new $.jqx.dataAdapter(this.source);

                var NoteRenderer = function (row, datafield, value) {
                    var html = '<button type="button" class="btn btn-xs btn-primary btn-rounded  " onclick="change_panelEstOrg();"><i class="glyphicons glyphicons-eye_open icon-success"></i> ver</button>';
                    return html;
                }

                $("#dataTable").jqxDataTable({
                    source: dataAdapter,
                    altRows: false,
                    sortable: true,
                    width: "100%",
                    filterable: true,
                    filterMode: 'simple',
                    localization: getLocalization('es'),
                    columns: [
                    { text: '*', cellsRenderer: NoteRenderer, width: 75 },
                    { text: '-', width: 90,
                    cellsRenderer: function (row, column, value, rowData) {
                        var image = "<div style='margin: 5px; margin-bottom: 3px;'>";
                        var imgurl = '/img/ico_' + rowData.plan + '.png';
                        var img = '<img width="60" height="80" style="display: block;" src="' + imgurl + '"/>';
                        image += img;
                        image += "</div>";
                        return image;
                        }
                    },
                    { text: 'Descripcion', dataField: 'nombre', align: 'center',
                    cellsRenderer: function (row, column, value, rowData) {
                        var container = '<div style="width: 100%; height: 100%;">'
                        var leftcolumn = '<div style="float: left; width: 100%;">';


                        var nombre = "<div style='margin: 10px;'><b>Nombre Entidad:</b> " + rowData.nombre + "</div>";
                        var sigla = "<div style='margin: 10px;'><b>Sigla:</b> " + rowData.sigla + "</div>";
                        var periodo = "<div style='margin: 10px;'><b>Periodo Plan:</b> " + rowData.gestion_inicio + " - " + rowData.gestion_fin + "</div>";
                        var tipoPlan = "<div style='margin: 10px;'><b>Documento Planificación:</b> " + rowData.plan + "</div>";

                        leftcolumn += nombre;
                        leftcolumn += sigla;
                        leftcolumn += periodo;
                        leftcolumn += tipoPlan;
                        leftcolumn += "</div>";

                        container += leftcolumn;
                        container += "</div>";
                        return container;
                    }
            },
            { text: 'Sigla', dataField: 'sigla', hidden: true },
            { text: 'Inicio', dataField: 'gestion_inicio', hidden: true },
            { text: 'Fin', dataField: 'gestion_fin', hidden: true },
            { text: 'Plan', dataField: 'plan', hidden: true }
            ]
                });
            });

        }
    }


    activarMenu('1','30');
    planes.fillPlanes();

    $('#nuevo').on('click', function(event) {
      $(".state-error").removeClass("state-error")
      $("#form-nuevo em").remove();
                  // Inline Admin-Form example
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





    
});
</script>
@endpush
