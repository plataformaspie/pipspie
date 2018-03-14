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
                              <button id="nuevo" type="button" class="btn btn-sm btn-default m5"><i class="fa fa-edit icon-primary"></i> Agregar nueva Entidad</button>
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

  <script type="text/javascript">
    $(document).ready(function(){
        activarMenu('1','0');
        activarMenu('2','0');
    });
  </script>
@endpush
