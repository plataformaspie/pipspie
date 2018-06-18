
<?php /*
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

</style>
@endsection

@section('title-topbar')
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
@endsection

@section('content')

  <aside class="tray tray-left tray230 va-t pn" data-tray-height="match">

    <div class="animated-delay p20" data-animate='["300","fadeIn"]'>
            <h4 class="mt5 mb20">Estructura Institucional -<span class="fs14 fw400 text-muted">Clasificado por Tipo</span></h4>

    </div>

    <div class="animated-delay animated-long" data-animate='["1000","fadeIn"]'>
        <div id="skin-switcher" class="row tray-bin alt-btns-hover br-b-n br-h-n mn">
            <div class="col-xs-4 pln">
                <button id="nuevo" type="button" class="btn btn-sm btn-default m5"><i class="fa fa-edit icon-primary"></i> Agregar nueva Entidad</button>
            </div>
            <
        </div>
    </div>

    <div id="nav-spy">
          <ul class="nav tray-nav tray-nav-border custom-nav-animation" data-spy="affix" data-offset-top="200" style="width:250px">
            @foreach ($tipos as $t)
              <li class="">
                  <a href="#BQ-{{ $t->clasificacion }}">
                    <span class="fa fa-check fa-lg"></span>  {{ $t->clasificacion }}</a>
              </li>
            @endforeach
          </ul>
      </div>

  </aside>
  <!-- begin: .tray-center -->
  <div class="tray tray-center p40 va-t posr">

      <div class="row">
        @foreach ($tipos as $t)
          <div class="col-md-12">
              <div class="panel panel-visible" id="BQ-{{ $t->clasificacion }}">
                <div class="panel-heading text-center">
                     <span class="panel-title"> {{ $t->clasificacion }}</span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                          <button id="editar" type="button" class="btn btn-sm btn-default m5"><i class="fa fa-edit icon-warning"></i> Editar</button>
                          <button id="eliminar" type="button" class="btn btn-sm btn-default m5"><i class="glyphicons glyphicons-bin icon-danger"></i> Eliminar </button>
                          <div id="tab-{{ $t->clasificacion }}"></div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
        @endforeach




      </div>

  </div>
  <!-- end: .tray-center -->


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

  <script type="text/javascript">
    $(document).ready(function(){
          activarMenu('1','24');
          activarMenu('2','0');

            // prepare the data
          @foreach ($tipos as $t)
            var source =
            {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'number' },
                { name: 'id_tuicion', type: 'number' },
                { name: 'nombre', type: 'string' },
                { name: 'sigla', type: 'string' },
                { name: 'codigo_mef', type: 'string' },
                { name: 'clasificacion', type: 'string' }
            ],
            id: 'id',
            data:{
              tipo:"{{ $t->clasificacion }}"
            },
              url:'{{ url('api/moduloplanificacion/setEstructuraEntidad') }}'
            };

            var dataAdapter = new $.jqx.dataAdapter(source);

            $("#tab-{{ $t->clasificacion }}").jqxDataTable(
            {
                source: dataAdapter,
                altRows: true,
                //filterable: true,
                //filterMode: 'simple',
                width: "100%",
                columns: [
                  { text: 'Nombre', dataField: 'nombre' },
                  { text: 'Sigla',  dataField: 'sigla', width: 300 },
                  { text: 'Codigo', dataField: 'codigo_mef', width: 90 },
                  { text: 'Clasificacion', dataField: 'clasificacion', width: 300 }
                ]
            });
          @endforeach




    });
  </script>
@endpush
*/?>

@extends('layouts.moduloplanificacion')

@section('header')
<link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />
<link rel="stylesheet" href="/plugins/bower_components/select2/dist/css/select2.min.css" type="text/css"/>
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
@endsection

@section('content')
  <?php  /*
  <aside class="tray tray-left tray230 va-t pn" data-tray-height="match">

    <div class="animated-delay p20" data-animate='["300","fadeIn"]'>
            <h4 class="mt5 mb20">Estructura Institucional -<span class="fs14 fw400 text-muted">Clasificado por Tipo</span></h4>

    </div>

    <div class="animated-delay animated-long" data-animate='["1000","fadeIn"]'>
        <div id="skin-switcher" class="row tray-bin alt-btns-hover br-b-n br-h-n mn">
            <div class="col-xs-4 pln">

            </div>
        </div>
    </div>

    <div id="nav-spy">

    </div>

  </aside>
  <!-- begin: .tray-center -->
 */ ?>
  <div class="tray tray-center p40 va-t posr">
      <div class="row">

          <div class="col-md-12">
              <div class="panel panel-visible" >
                <div class="panel-heading text-center">
                     <span class="panel-title"> Listado de Entidades dentro su Institucion</span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="estructura" class="col-md-12" >
                            <button id="nuevo" type="button" class="btn btn-sm btn-default m5"><i class="fa fa-edit icon-primary"></i> Agregar nueva Entidad</button>
                            <button id="editar" type="button" class="btn btn-sm btn-default m5"><i class="fa fa-edit icon-warning"></i> Editar</button>
                            <button id="eliminar" type="button" class="btn btn-sm btn-default m5"><i class="glyphicons glyphicons-bin icon-danger"></i> Eliminar</button>
                            <div id="dataTable"></div>
                        </div>


                        <div id="organigrama" class="col-md-12 hide">
                            <div class="col-xs-2">
                                <button id="change-panelOrg" type="button" class="btn btn-warning btn-sm mt5"><b><i class="glyphicons glyphicons-unshare"></i> Atras</b></button>
                            </div>
                            <div id="title-entidad"class="well well-sm text-center">-</div>
                            <button id="nuevo-ofi" type="button" class="btn btn-sm btn-default m5"><i class="fa fa-edit icon-primary"></i> Agregar Oficina</button>
                            <button id="editar-ofi" type="button" class="btn btn-sm btn-default m5"><i class="fa fa-edit icon-warning"></i> Editar</button>
                            <button id="eliminar-ofi" type="button" class="btn btn-sm btn-default m5"><i class="glyphicons glyphicons-bin icon-danger"></i> Eliminar</button>

                            <div id="dataTableSecond"></div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
      </div>
  </div>
  <!-- end: .tray-center -->


  <!-- Admin Form Popup -->
  <div id="modal-nuevo"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Agregar entidad</span>
          </div>
          <!-- end .panel-heading section -->
          <form method="post" action="/" id="form-nuevo" name="form-nuevo">
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
                              <label class="field-label" for="username">Código</label>
                              <label for="codigo_mef" class="field prepend-icon">
                                  <input type="text" name="codigo_mef" id="codigo_mef" class="gui-input" placeholder="codigo">
                                  <label for="codigo_mef" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                                  </label>
                              </label>
                          </div>

                          <div class="section">
                            <label class="field-label" for="username">Tipo</label>
                                 <label for="tipo" class="field ">
                                    <select id="tipo" name="tipo" class="field prepend-icon" style="width:100%;">
                                        @foreach($tipo as $t)
                                            <option value="{{$t->id}}"> {{$t->descripcion}} </option>
                                        @endforeach
                                    </select>
                                  </label>
                          </div>

                          <div class="section hide">
                            <label class="field-label" for="username">Tuición</label>
                                 <label for="tuicion" class="field ">
                                    <select id="tuicion" name="tuicion" class="field prepend-icon" style="width:100%;">
                                        <option value="-1"> Ninguno </option>
                                        @foreach($estructura as $e)
                                            @if($e->id == $idEntidad)
                                              <option value="{{$e->id}}" selected> {{$e->nombre}} </option>
                                            @else
                                              <option value="{{$e->id}}"> {{$e->nombre}} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                  </label>
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



  <!-- Admin Form Popup -->
  <div id="modal-editar"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Modificar Entidad</span>
          </div>
          <!-- end .panel-heading section -->
          <form method="post" action="/" id="form-edit" name="form-edit">
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
                            <label class="field-label" for="username">Código</label>
                            <label for="mod_codigo_mef" class="field prepend-icon">
                                <input type="text" name="mod_codigo_mef" id="mod_codigo_mef" class="gui-input" placeholder="codigo">
                                <label for="mod_codigo_mef" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                                </label>
                            </label>
                        </div>

                        <div class="section">
                          <label class="field-label" for="username">Tipo</label>
                               <label for="mod_tipo" class="field ">
                                  <select id="mod_tipo" name="mod_tipo" class="field prepend-icon" style="width:100%;">
                                      @foreach($tipo as $t)
                                          <option value="{{$t->id}}"> {{$t->descripcion}} </option>
                                      @endforeach
                                  </select>
                                </label>
                        </div>

                        <div class="section">
                          <label class="field-label" for="username">Tuición</label>
                               <label for="mod_tuicion" class="field ">
                                  <select id="mod_tuicion" name="mod_tuicion" class="field prepend-icon" style="width:100%;">
                                      <option value="-1"> Ninguno </option>
                                      @foreach($estructura as $e)
                                          <option value="{{$e->id}}"> {{$e->nombre}} </option>
                                      @endforeach
                                  </select>
                                </label>
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






  <!-- Admin Form Popup -->
  <div id="modal-nuevo-ofi"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Agregar Oficina_</span>
          </div>
          <!-- end .panel-heading section -->
          <form method="post" action="/" id="form-nuevo-ofi" name="form-nuevo-ofi">
            {{-- {{ csrf_field() }} --}}

              <div class="panel-body mnw500 of-a">
                  <div class="row">
                      <!-- Chart Column -->
                      <div class="col-md-12">
                          <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Complete los datos requeridos por el sistema <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>

                          <div class="section">
                              <label class="field-label" for="username">Nombre</label>
                              <label for="nombre_ofi" class="field prepend-icon">
                                  <textarea class="gui-textarea" id="nombre_ofi" name="nombre_ofi"  placeholder="Nombre de la entidad..." rows="2"></textarea>
                                  <label for="nombre_ofi" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                                  </label>
                              </label>
                          </div>

                          <div class="section">
                              <label class="field-label" for="username">Sigla</label>
                              <label for="sigla_ofi" class="field prepend-icon">
                                  <input type="text" name="sigla_ofi" id="sigla_ofi" class="gui-input" placeholder="Sigla">
                                  <label for="sigla_ofi" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                                  </label>
                              </label>
                          </div>
                          <div class="section">
                            <label class="field-label" for="username">Tipo</label>
                                 <label for="tipo_ofi" class="field ">
                                    <select id="tipo_ofi" name="tipo_ofi" class="field prepend-icon" style="width:100%;">
                                        @foreach($tipoOfi as $t)
                                            <option value="{{$t->id}}"> {{$t->descripcion}} </option>
                                        @endforeach
                                    </select>
                                  </label>
                           </div>

                          <div class="section">
                              <label class="field-label" for="username">Tuición</label>
                                 <label for="tuicion_ofi" class="field ">
                                    <select id="tuicion_ofi" name="tuicion_ofi" class="field prepend-icon" style="width:100%;"></select>
                                 </label>
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



  <!-- Admin Form Popup -->
  <div id="modal-editar-ofi"  class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide">
      <div class="panel">
          <div class="panel-heading">
              <span class="panel-title"><i class="fa fa-pencil"></i>Modificar variable</span>
          </div>
          <!-- end .panel-heading section -->
          <form method="post" action="/" id="form-edit-ofi" name="form-edit-ofi">
            {{ csrf_field() }}
              <input type="hidden" name="mod_id_ofi" id="mod_id_ofi" value="">
              <div class="panel-body mnw500 of-a">
                  <div class="row">
                    <div class="col-md-12">
                        <h5 class="ml5 mt20 ph10 pb5 br-b fw700">Modifique los datos que sean necesarios <small class="pull-right fw600"> <span class="text-primary">-</span> </small> </h5>

                        <div class="section">
                            <label class="field-label" for="username">Nombre</label>
                            <label for="mod_nombre_ofi" class="field prepend-icon">
                                <textarea class="gui-textarea" id="mod_nombre_ofi" name="mod_nombre_ofi"  placeholder="Nombre de la entidad..." rows="2"></textarea>
                                <label for="mod_nombre_ofi" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                                </label>
                            </label>
                        </div>

                        <div class="section">
                            <label class="field-label" for="username">Sigla</label>
                            <label for="mod_sigla_ofi" class="field prepend-icon">
                                <input type="text" name="mod_sigla_ofi" id="mod_sigla_ofi" class="gui-input" placeholder="Sigla">
                                <label for="mod_sigla_ofi" class="field-icon"><i class=" glyphicons glyphicons-notes"></i>
                                </label>
                            </label>
                        </div>

                        <div class="section">
                          <label class="field-label" for="username">Tipo</label>
                               <label for="mod_tipo_ofi" class="field ">
                                  <select id="mod_tipo_ofi" name="mod_tipo_ofi" class="field prepend-icon" style="width:100%;">
                                      @foreach($tipoOfi as $t)
                                          <option value="{{$t->id}}"> {{$t->descripcion}} </option>
                                      @endforeach
                                  </select>
                                </label>
                        </div>

                        <div class="section">
                          <label class="field-label" for="username">Tuición</label>
                               <label for="mod_tuicion_ofi" class="field ">
                                  <select id="mod_tuicion_ofi" name="mod_tuicion_ofi" class="field prepend-icon" style="width:100%;"></select>
                                </label>
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

  <script type="text/javascript">

    var idSelectedEntidad;
    $(document).ready(function(){
          activarMenu('1','24');
          activarMenu('2','0');
            // prepare the data
            var source =
            {
              dataType: "json",
              dataFields: [
                  { name: 'id', type: 'number' },
                  { name: 'id_tuicion', type: 'number' },
                  { name: 'nombre', type: 'string' },
                  { name: 'sigla', type: 'string' },
                  { name: 'codigo_mef', type: 'string' },
                  { name: 'orden', type: 'number' },
                  { name: 'tipo', type: 'string' }
              ],
              id: 'id',
              url: '{{ url('api/moduloplanificacion/setEstructuraEntidad') }}',
              sortcolumn: 'orden',
              sortdirection: 'asc'
            };
            //Configuracion de la tabla
            var dataAdapter = new $.jqx.dataAdapter(source);


            var NoteRenderer = function (row, datafield, value) {
                var html = '<button type="button" class="btn btn-sm btn-default m5" onclick="change_panelEstOrg();"><i class="fa fa-sitemap icon-danger"></i></button>';
                return html;
            }

            $("#dataTable").jqxDataTable({
                source: dataAdapter,
                altRows: false,
                sortable: true,
                groups: ['tipo'],
                width: "100%",
                filterable: true,
                filterMode: 'simple',
                localization: getLocalization('es'),
                groupsRenderer: function(value, rowData, level)
                {
                    return "<CENTER><b>" + value + "</b></CENTER>";
                },
                columns: [
                  { text: '-', cellsrenderer: NoteRenderer, width: 50 },
                  { text: 'Nombre', dataField: 'nombre' },
                  { text: 'Sigla',  dataField: 'sigla', width: 100 },
                  { text: 'Codigo', dataField: 'codigo_mef', width: 60 },
                  { text: 'Tipo', dataField: 'tipo', width: 150 }
                ]
            });

            //Configuracion de combo tuicion
            $("#tipo").select2({
              placeholder: "Ninguno"
            });
            $("#tuicion").select2({
              placeholder: "Ninguno"
            });
            $("#mod_tipo").select2({
              placeholder: "Ninguno"
            });
            $("#mod_tuicion").select2({
              placeholder: "Ninguno"
            });

            $("#tipo_ofi").select2({
              placeholder: "Ninguno"
            });
            $("#tuicion_ofi").select2({
              placeholder: "Ninguno"
            });
            $("#mod_tipo_ofi").select2({
              placeholder: "Ninguno"
            });
            $("#mod_tuicion_ofi").select2({
              placeholder: "Ninguno"
            });

            //Evento del boton nuevo
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
                              var Animation = "mfp-zoomOut";
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
                            nombre: {
                                    required: true
                            },
                            sigla:  {
                                    required: true
                            },
                            tipo: {
                                    required: true
                            },
                            tuicion: {
                                    required: true
                            }


                    },

                    /* @validation error messages
                    ---------------------------------------------- */

                    messages:{
                            nombre: {
                                    required: 'Ingresar nombre de la Entidad'
                            },
                            sigla:  {
                                    required: 'Ingresarla sigla'
                            },
                            tipo:  {
                                    required: 'Por favor, selecciones una opcion'
                            },
                            tuicion:  {
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

            $('#editar').on('click', function(event) {
              var rowindex = $('#dataTable').jqxDataTable('getSelection');
              if (rowindex.length > 0)
              {
                  var rowData = rowindex[0];
                  $.ajax({
                          url: "{{ url('/api/moduloplanificacion/dataSetEntidad') }}",
                          type: "GET",
                          dataType: 'json',
                          data:{'id':rowData.id},
                          success: function(data){
                              $("#form-edit em").remove();
                              $('input[name="mod_id"]').val(data.id);
                              $('textarea[name="mod_nombre"]').val(data.nombre);
                              $('input[name="mod_sigla"]').val(data.sigla);
                              $('input[name="mod_codigo_mef"]').val(data.codigo_mef);
                              $("#mod_tipo").val(data.id_tipo).trigger('change');
                              $("#mod_tuicion").val(data.id_tuicion).trigger('change');
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
                  swal("Seleccione el registro que modificara.");
              }
            });

            $( "#form-edit" ).validate({

                    /* @validation states + elements
                    ------------------------------------------- */

                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    /* @validation rules
                    ------------------------------------------ */

                    rules: {
                            mod_nombre: {
                                    required: true
                            },
                            mod_sigla:  {
                                    required: true
                            },
                            mod_tipo: {
                                    required: true
                            }

                    },

                    /* @validation error messages
                    ---------------------------------------------- */

                    messages:{
                            mod_nombre: {
                                    required: 'Ingresar nombre de la Entidad'
                            },
                            mod_sigla:  {
                                    required: 'Ingresarla sigla'
                            },
                            mod_tipo:  {
                                    required: 'Por favor, selecciones una opcion'
                            },
                            mod_tuicion:  {
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

            $('#eliminar').on('click', function(event) {
              var rowindex = $('#dataTable').jqxDataTable('getSelection');
              if (rowindex.length > 0)
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
                    var rowData = rowindex[0];
                    $.ajax({
                            url: "{{ url('/api/moduloplanificacion/deleteEntidad') }}",
                            type: "GET",
                            dataType: 'json',
                            data:{'id':rowData.id},
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
            });

            $('#change-panelOrg').on('click', function(event) {
                $("#organigrama").hide();
                $('#estructura').removeClass('hide');
                $("#estructura").show();
                $("#dataTableSecond").jqxDataTable('clear');
                clearComboOficinas();
            });


            //Configuracion de Panel de Oficinas
            $('#nuevo-ofi').on('click', function(event) {
                  $(".state-error").removeClass("state-error")
                  $("#form-nuevo-ofi em").remove();



                  // Inline Admin-Form example
                  $.magnificPopup.open({
                      removalDelay: 500, //delay removal by X to allow out-animation,
                      focus: '#focus-blur-loop-select',
                      items: {
                          src: "#modal-nuevo-ofi"
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

            $( "#form-nuevo-ofi" ).validate({

                    /* @validation states + elements
                    ------------------------------------------- */

                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    /* @validation rules
                    ------------------------------------------ */

                    rules: {
                            nombre_ofi: {
                                    required: true
                            },
                            sigla_ofi:  {
                                    required: true
                            },
                            tipo_ofi: {
                                    required: true
                            },
                            tuicion_ofi: {
                                    required: true
                            }


                    },

                    /* @validation error messages
                    ---------------------------------------------- */

                    messages:{
                            nombre_ofi: {
                                    required: 'Ingresar nombre de la Entidad'
                            },
                            sigla_ofi:  {
                                    required: 'Ingresarla sigla'
                            },
                            tipo_ofi:  {
                                    required: 'Por favor, selecciones una opcion'
                            },
                            tuicion_ofi:  {
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
                      saveFormOfiNew();
                    }


            });


            $('#editar-ofi').on('click', function(event) {
              var rowindex = $('#dataTableSecond').jqxDataTable('getSelection');
              if (rowindex.length > 0)
              {
                  var rowData = rowindex[0];
                  $.ajax({
                          url: "{{ url('/api/moduloplanificacion/dataSetEntidad') }}",
                          type: "GET",
                          dataType: 'json',
                          data:{'id':rowData.id},
                          success: function(data){
                              $("#form-edit-ofi em").remove();
                              $('input[name="mod_id_ofi"]').val(data.id);
                              $('textarea[name="mod_nombre_ofi"]').val(data.nombre);
                              $('input[name="mod_sigla_ofi"]').val(data.sigla);
                              $("#mod_tipo_ofi").val(data.id_tipo).trigger('change');
                              $("#mod_tuicion_ofi").val(data.id_tuicion).trigger('change');
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
                          src: "#modal-editar-ofi"
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
                  swal("Seleccione el registro que modificara.");
              }
            });

            $( "#form-edit-ofi" ).validate({

                    /* @validation states + elements
                    ------------------------------------------- */

                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    /* @validation rules
                    ------------------------------------------ */

                    rules: {
                            mod_nombre_ofi: {
                                    required: true
                            },
                            mod_sigla_ofi:  {
                                    required: true
                            },
                            mod_tipo_ofi: {
                                    required: true
                            }

                    },

                    /* @validation error messages
                    ---------------------------------------------- */

                    messages:{
                            mod_nombre_ofi: {
                                    required: 'Ingresar nombre de la Entidad'
                            },
                            mod_sigla_ofi:  {
                                    required: 'Ingresarla sigla'
                            },
                            mod_tipo_ofi:  {
                                    required: 'Por favor, selecciones una opcion'
                            },
                            mod_tuicion_ofi:  {
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
                      saveFormOfiEdit();
                    }


            });

            $('#eliminar-ofi').on('click', function(event) {
              var rowindex = $('#dataTableSecond').jqxDataTable('getSelection');
              if (rowindex.length > 0)
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
                    var rowData = rowindex[0];
                    $.ajax({
                            url: "{{ url('/api/moduloplanificacion/deleteOficina') }}",
                            type: "GET",
                            dataType: 'json',
                            data:{'id':rowData.id},
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
                              $("#dataTableSecond").jqxDataTable("updateBoundData");
                              swal("Eliminado!", "Se ha eliminado tu registro.", "success");
                              setComboOficinas(idSelectedEntidad);
                              clearComboOficinas(idSelectedEntidad);
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
            });

    });

    var change_panelEstOrg = function(){
       var rowindex = $('#dataTable').jqxDataTable('getSelection');
       if (rowindex.length > 0)
       {
         $('body,html').animate({scrollTop : 0}, 500);

         var rowData = rowindex[0];
         $("#estructura").hide();
         $('#organigrama').removeClass('hide');
         $("#organigrama").show();
         $("#title-entidad").html("Entidad seleccionada: <b>" + rowData.nombre + "</b>");
         //cargamos combo para tuision
         setComboOficinas(rowData.id);
         setEntidadSelec(rowData.id);
       }
       else
       {
           swal("Seleccione una Entidad.");
       }
    };

    var setComboOficinas = function(id_selected){
      $.ajax({
              url: "{{ url('/api/moduloplanificacion/setEstructuraOfi') }}",
              type: "GET",
              dataType: 'json',
              data:{'id_selected':id_selected},
              success: function(data){
                  $("#tuicion_ofi").html(data.set);
                  $("#mod_tuicion_ofi").html(data.set);
              },
              error:function(data){
                console("Error recuperar los datos.");
              }
      });
    };

    var clearComboOficinas = function(){
        $('#tuicion_ofi').empty().trigger('change')
        $("#mod_tuicion_ofi").empty().trigger('change')
    };

    var setEntidadSelec = function(idEntSel){
      idSelectedEntidad = idEntSel;
      var sourceTwo =
      {
        dataType: "json",
        dataFields: [
            { name: 'id', type: 'number' },
            { name: 'id_padre', type: 'number' },
            { name: 'nombre', type: 'string' },
            { name: 'sigla', type: 'string' },
            { name: 'codigo_mef', type: 'string' },
            { name: 'orden', type: 'number' },
            { name: 'tipo', type: 'string' }
        ],
        id: 'id',
        data:{'id':idEntSel},
        url: '{{ url('api/moduloplanificacion/setEntidadOrganigrama') }}',
        sortcolumn: 'orden',
        sortdirection: 'ASC'
      };

      var dataAdapterTwo = new $.jqx.dataAdapter(sourceTwo);
      $("#dataTableSecond").jqxDataTable(
      {
          source: dataAdapterTwo,
          altRows: false,
          sortable: true,
          groups: ['tipo'],
          width: "100%",
          filterable: true,
          filterMode: 'simple',
          localization: getLocalization('es'),
          groupsRenderer: function(value, rowData, level)
          {
              return "<CENTER><b>" + value + "</b></CENTER>";
          },
          columns: [
            { text: 'Nombre', dataField: 'nombre' },
            { text: 'Sigla',  dataField: 'sigla', width: 100 },
            { text: 'Tipo', dataField: 'tipo', width: 150 }
          ]
      });
    };


  //Funciones para enviar al controlador
  function saveFormNew(){

  var formData = new FormData($("#form-nuevo")[0]);
    $.ajax({
            url: "{{ url('/api/moduloplanificacion/saveEntidadNew') }}",
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

  function saveFormOfiNew(){

  var formData = new FormData($("#form-nuevo-ofi")[0]);
      formData.append("id_selected", idSelectedEntidad);
    $.ajax({
            url: "{{ url('/api/moduloplanificacion/saveOficinaNew') }}",
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
                $("#dataTableSecond").jqxDataTable("updateBoundData");
                $("#form-nuevo-ofi")[0].reset();
                setComboOficinas(idSelectedEntidad);
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
            url: "{{ url('/api/moduloplanificacion/saveEntidadEdit') }}",
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
                setComboOficinas(idSelectedEntidad);
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


  function saveFormOfiEdit(){

  var formData = new FormData($("#form-edit-ofi")[0]);
      formData.append("id_selected", idSelectedEntidad);
    $.ajax({
            url: "{{ url('/api/moduloplanificacion/saveOficinaEdit') }}",
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
                $("#dataTableSecond").jqxDataTable("updateBoundData");
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
