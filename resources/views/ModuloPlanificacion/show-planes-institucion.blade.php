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
                              <button id="nuevo" type="button" class="btn btn-sm btn-default m5"><i class="fa fa-edit icon-primary"></i> Agregar Plan</button>
                              <button id="editar" type="button" class="btn btn-sm btn-default m5"><i class="fa fa-edit icon-warning"></i> Editar</button>
                              <button id="eliminar" type="button" class="btn btn-sm btn-default m5"><i class="glyphicons glyphicons-bin icon-danger"></i> Eliminar</button>
                              <div id="dataTable"></div>
                          </div>
                     </div>
                  </div>
              </div>
          </div>
      </div>
  </div>




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
    $(document).ready(function(){
          activarMenu('1','30');
          var source =
          {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'number' },
                { name: 'gestion_inicio', type: 'number' },
                { name: 'gestion_fin', type: 'number' },
                { name: 'nombre', type: 'string' },
                { name: 'sigla', type: 'string' },
                { name: 'plan', type: 'string' }
            ],
            id: 'id',
            url: '{{ url('api/moduloplanificacion/setEntidadPlan') }}'
          };
          //Configuracion de la tabla
          var dataAdapter = new $.jqx.dataAdapter(source);

          var NoteRenderer = function (row, datafield, value) {
              var html = '<button type="button" class="btn btn-sm btn-default m5" onclick="change_panelEstOrg();"><i class="glyphicons glyphicons-eye_open icon-primary"></i> ver</button>';
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
                { text: '*', cellsrenderer: NoteRenderer, width: 75 },
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
  </script>
@endpush
