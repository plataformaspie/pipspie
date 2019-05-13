@extends('layouts.sistemaremi')

@section('header')

  <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}"  type="text/css" />
  <link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">


  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />
  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.ui-lightness.css') }} " type="text/css" />
  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.darkblue.css') }} " type="text/css" />

  <style media="screen">
    .select2-container-multi{
      padding-left: 0px;padding-right: 0px;padding-top: 0px;
    }

    table.scroll , .scroll tr td{
    border:1px solid #E4E7EA;
    }
    .scroll tbody {
        display:block;
        height:200px;
        overflow:auto;
    }
    .scroll thead, .scroll tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }
    .scroll thead {
        width: calc( 100% - 1em )
    }
    table.scroll {
        width:100%;
    }


input[type=checkbox] + label {
  display: block;
  margin: 0.1em;
  cursor: pointer;
  padding: 0.1em;
}

input[type=checkbox] {
  display: none;
}

input[type=checkbox] + label:before {
  content: "\2714";
  border: 0.1em solid #FE642E;   /*   #000; */
  border-radius: 0.1em;
  display: inline-block;
  width: 1.3em;
  height: 1.3em;
  padding-left: 0.2em;
  padding-bottom: 0.5em;
  margin-right: 0.2em;
  vertical-align: bottom;
  color: transparent;
  transition: .2s;
}

input[type=checkbox] + label:active:before {
  transform: scale(0);
}

input[type=checkbox]:checked + label:before {
  background-color: #FEAE17;   /*MediumSeaGreen;*/
  border-color: #FE642E;   /* MediumSeaGreen; */
  color: #fff;
}

input[type=checkbox]:disabled + label:before {
  transform: scale(1);
  border-color: #aaa;
}

input[type=checkbox]:checked:disabled + label:before {
  transform: scale(1);
  background-color: #bfb;
  border-color: #bfb;
}

.modal-dialog1 {
    position: relative;
    width: 500px;
    margin: auto;
    top: 130px;
}

  </style>
@endsection

@section('content')

  <div class="row bg-title">
      <!-- .page title -->
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        @if($filtData == 0 )
          <h4 class="page-title">Administrar Indicadores CIMPDS</h4>
        @else
          <h4 class="page-title">Administrar Mis Indicadores</h4>
        @endif
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      {{-- <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/index') }}">Indicadores</a></li>
              <li class="active">Administrar indicadores</li>
          </ol>
      </div> --}}
      <!-- /.breadcrumb -->
  </div>

  <div id="option1" class="row">
      <div class="col-lg-12 ">
          <div class="white-box">
            <h3 class="box-title m-b-0">Lista de indicadores</h3>
            <p class="text-muted m-b-30">Indicadores registrados por su usuario<button id ="btn-new" type="button" class="btn btn-info btn-lg" style="float: right;margin-top: -26px;"><i class="fa fa-plus"></i>Agregar Nuevo</button></p>

            <div class="row">
              <div id="jqxDataTable" class="col-lg-12">
                <p class="m-b-5">
                  <button onclick="showFilterAdvanced();" type="button" class="btn btn-outline btn-warning btn-sm "><i class="fa fa-filter"></i> Filtro avanzado</button>
                  <button onclick="showExportarData();" type="button" class="btn btn-outline btn-info btn-sm"><i class="fa fa-plus-square"></i> Exportar a</button>
                </p>
              </div>
              <form id="filtroForm" name="filtroForm" action="javascript:filtrar();" data-toggle="validator">
                {{-- {{ csrf_field() }} --}}
                <div id="FilterAdvanced" class="col-lg-12 hidden">
                  <div class="white-box p-10" style="background-color: #fcf8e3;color: #8a6d3b;">
                      <div class="row">
                          <div class="col-lg-2 col-sm-3">
                            <label><i class="fa fa-filter gly-rotate-90"></i>Estado:</label>
                            <select id="fil_estados" name="fil_estados" class="" style="width:100%">
                              <option value="0">Todos</option>
                              @foreach ($estados as  $item)
                                    <option value="{{ $item->id }}">{{$item->nombre}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-lg-2 col-sm-3">
                            <label><i class="fa fa-filter gly-rotate-90"></i>Compartidos:</label>
                            <select id="fil_compartidos" name="fil_compartidos" class="" style="width:100%">
                                 <option value="0">Todos</option>
                                 <option value="Si">Si</option>
                                 <option value="No">No</option>
                            </select>
                          </div>
                          <div class="col-lg-2 col-sm-3">
                            <label><i class="fa fa-filter gly-rotate-90"></i>Tipo:</label>
                            <select id="fil_tipos" name="fil_tipos" class="" style="width:100%">
                              <option value="0">Todos</option>
                              @foreach ($tipos as  $item)
                                    <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-lg-3 col-sm-6">
                            <label><i class="fa fa-filter gly-rotate-90"></i>Dimensiones SPIE:</label>
                            <select id="fil_dimensiones" name="fil_dimensiones[]" placeholder="Todos..."  multiple="multiple" class="select2 multiple">
                                @foreach ($dimensionesSpie as  $item)
                                      <option value="{{ $item }}">{{$item}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="col-lg-3 col-sm-6">
                            <label><i class="fa fa-filter gly-rotate-90"></i>Subdimensiones SPIE:</label>
                            <select id="fil_subdimensiones" name="fil_subdimensiones[]" placeholder="Todos..."  multiple="multiple" class="select2 multiple">
                                @foreach ($subdimensiones as  $item)
                                      <option value="{{ $item }}">{{$item}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="col-lg-12 col-sm-12">
                            <label><i class="fa fa-filter gly-rotate-90"></i>Sector relacionado:</label>
                            <select id="fil_sectores" name="fil_sectores[]" placeholder="Todos..."  multiple="multiple" class="select2 multiple">
                                @foreach ($instituciones as  $item)
                                      <option value="{{ $item->id }}">{{$item->codigo}}: {{$item->denominacion}}</option>
                                @endforeach
                            </select>
                          </div>


                          <div class="col-lg-4 col-sm-4 m-t-10">
                            <label><i class="fa fa-filter gly-rotate-90"></i>PDES:</label><br/>
                            Pilar:<select id="fil_pdes_pilar" name="fil_pdes_pilar[]" placeholder="Todos..."  multiple="multiple" class=" select2 multiple">
                                @foreach ($setPP as  $item)
                                      <option value="{{ $item->cod_p }}"> {{$item->nombre}}</option>
                                @endforeach
                            </select>
                            Meta:<select id="fil_pdes_meta" name="fil_pdes_meta[]" placeholder="Todos..."  multiple="multiple" class=" select2 multiple">
                                @foreach ($setPM as  $item)
                                      <option value="{{ $item->cod_m }}"> {{$item->nombre}}</option>
                                @endforeach
                            </select>
                            Resultado:<select id="fil_pdes_resultado" name="fil_pdes_resultado[]" placeholder="Todos..."  multiple="multiple" class=" select2 multiple">
                                @foreach ($setPR as  $item)
                                      <option value="{{ $item->cod_r }}"> {{$item->nombre}}</option>
                                @endforeach
                            </select>
                          </div>

                          <div class="col-lg-4 col-sm-4 m-t-10">
                            <label><i class="fa fa-filter gly-rotate-90"></i>ODS:</label><br/>
                            Objetivo:<select id="fil_ods_objetivo" name="fil_ods_objetivo[]" placeholder="Todos..."  multiple="multiple" class=" select2 multiple">
                                @foreach ($setOO as  $item)
                                      <option value="{{ $item->cod_o }}"> {{$item->nombre}}</option>
                                @endforeach
                            </select>
                            Meta:<select id="fil_ods_meta" name="fil_ods_meta[]" placeholder="Todos..."  multiple="multiple" class=" select2 multiple">
                                @foreach ($setOM as  $item)
                                      <option value="{{ $item->cod_m }}"> {{$item->nombre}}</option>
                                @endforeach
                            </select>
                            Indicador:<select id="fil_ods_indicador" name="fil_ods_indicador[]" placeholder="Todos..."  multiple="multiple" class=" select2 multiple">
                                @foreach ($setOI as  $item)
                                      <option value="{{ $item->cod_i }}"> {{$item->nombre}}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                      <hr style="margin-top: 8px; margin-bottom: 8px;"/>
                      <div class="row">
                          <div class="col-lg-3">
                              <button type="submit" class="btn btn-block btn-danger btn-outline"><i class="fa fa-filter m-l-5"></i> Aplicar Filtro </button>
                          </div>
                          <div class="col-lg-3">
                              <button id="limpiarfiltros" type="button" class="btn btn-block btn-info btn-outline"><i class="fa fa-eraser m-l-5"></i> Limpiar Filtro </button>
                          </div>
                      </div>
                  </div>
                </div>
              </form>
              <div id="exportarData" class="col-lg-12 hidden">
                  <div class="row white-box" style="background-color: #fcf8e3;color: #8a6d3b;">
                      <div class="col-sm-3">
                        <label>Exportar a:</label>
                        <select class="form-control ">
                            <option value="excel">Excel</option>
                        </select>
                      </div>
                      <div class="col-lg-2 col-sm-5">
                        <label>Seleccione opcion:</label>
                        <br/>
                        <input name="option_data" value="1" type="radio"/> Contenido de tabla
                        <br/>
                        <input name="option_data" value="2" type="radio"/> Registro seleccionado

                      </div>
                      <div class="col-sm-3 ">
                        <div style="float: left; margin-top: 20px;">
                          <button id="generarExport" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Generar Reporte</button>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-12">
                <label style="float: right;margin-top: -27px;">Total registros: <span id="total_registros" style="font-weight:bold;"></span></label>
                <div id="dataTable"></div>
              </div>
            </div>

          </div>
      </div>
  </div>
  <div id="option2" class="row hidden">
      <div class="col-lg-12 ">
          <form id="formAdd" name="formAdd" action="javascript:save();" data-toggle="validator" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id_indicador" value="">
            <input type="hidden" name="tap_next" value="">
            <!-- .row -->
            <div class="row">
              <div class="col-sm-12">
                  <div class="white-box">
                      <h3 class="box-title m-b-0">Información del Indicador</h3>
                      <p class="text-muted m-b-30">Completar todos los datos solicitados<button id ="btn-back" type="button" class="btn btn-info btn-lg" style="float: right;margin-top: -26px;"><i class="fa fa-arrow-left">Atras</i></button></p>
                      <div style="font-size:15px;">
                        <div class="form-group row m-b-10">
                          <div class="col-md-1 p-l-0 p-r-0">
                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 7px 95px 7px 3px;">Indicador</label>
                          </div>
                          <div class="col-md-11 p-l-0">
                             <label id="nombreDesc" name="dosCaja" for="label" class="" style="width: 100%;padding: 7px 95px 7px 3px;background-color: #fcf8e3;color: #8a6d3b;"></label>
                          </div>
                        </div>
                        <div class="form-group row m-b-10">
                          <div class="col-md-1 p-l-0 p-r-0">
                            <label for="label" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 7px 20px 7px 3px;">Estado </label>

                          </div>
                          <div class="col-md-10 p-l-0">
                              <label id="estado_indicadorDesc" for="label" class=""> </label>
                              <input id="estado" type="hidden" name="estado" value="1">
                          </div>
                        </div>
                        <div class="form-group row m-b-10">
                          <div class="col-md-1 p-l-0 p-r-0">
                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 7px 95px 7px 3px;">Etapa</label>
                          </div>
                          <div class="col-md-11 p-l-0">
                            <label id="etapaDesc" name="unaCaja" for="label" class="" style="width: 100%;padding: 7px 95px 7px 3px;"></label>
                          </div>
                        </div>

                      </div>
<!-- <form>
  <input type="checkbox" id="fruit1" name="fruit-1" value="Apple">
  <label for="fruit1">Apple</label>
  <input type="checkbox" id="fruit2" name="fruit-2" value="Banana" disabled>
  <label for="fruit2">Banana</label>
  <input type="checkbox" id="fruit3" name="fruit-3" value="Cherry" checked disabled>
  <label for="fruit3">Cherry</label>
  <input type="checkbox" id="fruit4" name="fruit-4" value="Strawberry">
  <label for="fruit4">Strawberry</label>
</form>  -->


                    <hr>
                    <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 p-l-0">
                              <div class="vtabs">
                                  <ul class="nav tabs-vertical media p-t-0 p-l-0 p-r-0" style="width:300px;">
                                    <li class="tab nav-item">
                                        <a id="tab-ini1" data-toggle="tab" class="nav-link ctrl-btn active" href="#info1" aria-expanded="false">
                                          <span class="visible-xs"><i class="fa fa-sitemap" style="font-size: 25px"></i></span>
                                          <span class="hidden-xs"><i class="fa fa-sitemap" style="font-size: 25px"></i> Alinear al PDES</span>
                                        </a>
                                    </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini2" data-toggle="tab" class="nav-link ctrl-btn" href="#info2" aria-expanded="true">
                                            <span class="visible-xs"><i class="fa fa-book" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-book" style="font-size: 25px"></i> Información básica </span>
                                          </a>
                                      </li>
 <!--                                      <li class="tab nav-item" hidden="hidden">
                                          <a id="tab-ini3" aria-expanded="false" class="nav-link ctrl-btn" data-toggle="tab" href="#info3">
                                            <span class="visible-xs"><i class="fa fa-building-o" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-building-o" style="font-size: 25px"></i> Método de cálculo</span>
                                          </a>
                                      </li> -->

                                      <li class="tab nav-item">
                                          <a id="tab-ini3" data-toggle="tab" class="nav-link ctrl-btn" href="#info3" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-eye" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-eye" style="font-size: 25px"></i> Metas y avances</span>
                                          </a>
                                      </li>
<!--                                       <li class="tab nav-item" hidden="hidden">
                                          <a id="tab-ini5" data-toggle="tab" class="nav-link ctrl-btn" href="#info5" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-briefcase" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-briefcase" style="font-size: 25px"></i> Fuente de datos</span>
                                          </a>
                                      </li> -->
                                      {{-- <li class="tab nav-item">
                                          <a id="tab-ini4" data-toggle="tab" class="nav-link ctrl-btn" href="#info4" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-cloud-upload" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-cloud-upload" style="font-size: 25px"></i> Archivos respaldo</span>
                                          </a>
                                      </li> --}}
                                      <li class="tab nav-item">
                                          <a id="tab-ini4" data-toggle="tab" class="nav-link ctrl-btn" href="#info4" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-file-text" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-file-text" style="font-size: 25px"></i> Viabilidad del Indicador</span>
                                          </a>
                                      </li>
                                     <li class="tab nav-item">
                                          <a id="tab-ini5" data-toggle="tab" class="nav-link ctrl-btn" href="#info5" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-cog" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-cog" style="font-size: 25px"></i> Secretaria Técnica CIMPDS</span>
                                          </a>
                                      </li>
                                  </ul>
                                  <div class="tab-content media p-t-0 p-l-0 p-r-0" style="width: 80%;">
                                      <div id="info1" class="tab-pane active">
<!--
                                          <div class="form-group row m-b-5 m-l-5 m-t-5">
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre</label>
                                              </div>
                                            <div class="col-md-9 p-l-0">
                                                <input id="nombre" name="nombre" type="text" class="form-control"  placeholder="Nombre del indicador" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                          </div>

                                          <div class="form-group row m-b-5 m-l-5 m-t-5">
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Definición</label>
                                              </div>
                                            <div class="col-md-9 p-l-0">
                                                <textarea id="definicion" name="definicion" class="form-control" placeholder="Definición del indicador" required></textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                          </div> -->

                                          <div class="col-md-12 list-group-item-success" style="margin-top: -9px;">
                                              <h4 style="width:100%;">Alinear al PDES</h4>
                                          </div>
                                          <p><h5>Ingrese los codigos PDES para agregar la articulación (Ayuda F9)</h5></p>
                                          <div class="col-md-12">

                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                    <div  id="Pilares" class="col-lg-2 p-l-0 text-center">
                                                          <button type="button" id="activa1" class="btn waves-effect waves-light btn-outline-info"><span class="glyphicon glyphicon-plus"></span></button>
                                                    </div>
                                                </div>
                                              <div id="cod2">
                                                <div class="row m-b-5 m-l-5 m-t-5" >
                                                    <div class="form-group col-md-2 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Pilar</label>
                                                    </div>
                                                    <div class="form-group col-md-1 p-l-0">
                                                        <input id="cod_pilar" name="cod_pilar" type="text" class="form-control input" placeholder="Pilar" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group col-md-2 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta</label>
                                                    </div>
                                                    <div class="form-group col-md-1 p-l-0">
                                                        <input id="cod_meta" name="cod_meta" type="text" class="form-control input" placeholder="Meta" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group col-md-2 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Resultado</label>
                                                    </div>
                                                    <div class="form-group col-md-2 p-l-0">
                                                        <input id="cod_resultado" name="cod_resultado" type="text" class="form-control input" placeholder="Resultado" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="col-md-2 p-l-0 text-center">
                                                        <button type="button" class="btn btn-info btn-sm agregarART m-t-5"><i class="fa fa-plus-square"></i> Agregar PDES</button>
                                                    </div>
                                                </div>
                                              </div>
                                                <h5>Detalle de articulación</h5>
                                                <div id="datosART">
                                                    <div></div>
                                                </div><br/>

                                          <div class="col-md-12 list-group-item-success" style="margin-top: -9px;">
                                              <h4 style="width:100%;">Alinear al ODS</h4>
                                          </div>
                                          <p><h5>Cargue los códigos en cada campo</h5></p>
                                                <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                    <div  id="Pilares" class="col-lg-2 p-l-0 text-center">
                                                          <button type="button" id="activa" class="btn waves-effect waves-light btn-outline-info"><span class="glyphicon glyphicon-plus"></span></button>
                                                    </div>
                                                </div>
                                              <div id="cod">
                                                <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="col-md-3 p-l-0 p-r-0 m-b-0">
                                                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Comparabilidad ODS/PDES</label>
                                                    </div>

                                                    <div class="form-group col-md-4 p-l-0 m-b-0">
                                                          <select id="relac" name="relac" class="custom-select col-12 form-control enabledCampos">
                                                                <option value="No Disponible">No Disponible</option>
                                                                @foreach ($relacop as  $ind_op)
                                                                    <option value="{{ $ind_op->relacion_pdes_ods }}">{{ $ind_op->relacion_pdes_ods }} - {{$ind_op->descripcion}}</option>
                                                                @endforeach
                                                          </select>
                                                          <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div id="cod1">
                                                  <div class="row m-b-5 m-l-5 m-t-5" >
                                                      <div class="form-group col-md-2 p-l-0 p-r-0">
                                                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Objetivo</label>
                                                      </div>
                                                      <div class="form-group col-md-2 p-l-0">
                                                          <input id="cod_obj" name="cod_obj" type="text" class="form-control input" placeholder="Objetivo" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                          <div class="help-block with-errors"></div>
                                                      </div>

                                                      <div class="form-group col-md-1 p-l-0 p-r-0">
                                                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta</label>
                                                      </div>
                                                      <div class="form-group col-md-1 p-l-0">
                                                          <input id="cod_metaods" name="cod_metaods" type="text" class="form-control input" placeholder="Meta" data-inputmask=" 'pattern':'w', 'data-charset':'_', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0 o A'" style="text-align: right;">
                                                          <div class="help-block with-errors"></div>
                                                      </div>

                                                      <div class="form-group col-md-2 p-l-0 p-r-0">
                                                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Indicador</label>
                                                      </div>
                                                      <div class="form-group col-md-2 p-l-0">
                                                          <input id="cod_resultadods" name="cod_resultadods" type="text" class="form-control input" placeholder="indicador" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                          <div class="help-block with-errors"></div>
                                                      </div>
                                                      <div class="col-md-2 p-l-0 text-left">
                                                          <button type="button" class="btn btn-info btn-sm agregarART1 m-t-5"><i class="fa fa-plus-square"></i> Agregar ODS</button>
                                                      </div>
                                                  </div>
                                                </div>
                                              </div>


                                                <h5>Detalle de articulación</h5>
                                                <div id="datosART1">
                                                    <div></div>
                                                </div>

                                            </div>
                                      </div>

                                      <div id="info2" class="tab-pane ">
                                          <div class="col-md-12 list-group-item-success">
                                              <h4 style="width:100%;">Información Básica del indicador </h4>
                                          </div>
                                          <div class="col-md-12">
                                          <div class="form-group row m-b-5 m-l-5 m-t-5">
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre</label>
                                              </div>
                                            <div class="col-md-9 p-l-0">
                                                <input id="nombre" name="nombre" type="text" class="form-control"  placeholder="Nombre del indicador" onkeyup="actualizarcampo(this);">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                          </div>
                                          <div class="form-group row m-b-5 m-l-5 m-t-5">
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Definición</label>
                                              </div>
                                            <div class="col-md-9 p-l-0">
                                                <textarea id="definicion" name="definicion" class="form-control" placeholder="Definición del indicador"></textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                          </div>



                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Tipo</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">
                                                    <select id="tipo" name="tipo" class="custom-select col-12 form-control">
                                                        <option value="">Seleccionar...</option>
                                                        @foreach ($tipos as  $item)
                                                              <option value="{{ $item->nombre }}">{{$item->nombre}} - {{$item->descripcion}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>
                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de medida</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">
                                                    <select id="unidad_medida" name="unidad_medida" class="custom-select col-12 form-control" onchange="actualizarcomboUnidad(this);">
                                                      <option value="">Seleccionar...</option>
                                                        @foreach ($unidades as  $item)
                                                              <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>




                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                    <div class="col-md-3 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Serie disponible</label>
                                                    </div>
                                                    <div class="col-md-9 p-l-0">
                                                        <input id="serie_disponible" name="serie_disponible" type="text" class="form-control" placeholder="Tipo de indicador" >
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                              </div>

                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Variables de desagregación</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">
                                                    <div class="select2-wrapper">
                                                      <?php /*
                                                      <select id="variables_desagregacion" name="variables_desagregacion[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                          @foreach ($variables as  $item)
                                                                <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                          @endforeach
                                                      </select>
                                                      */ ?>
                                                      <textarea id="variables_desagregacion" name="variables_desagregacion" class="form-control" placeholder="Variables"></textarea>

                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>

                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Selecione variable y cargue su respaldo</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">

                                                  <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                                                       <div class="col-md-3 p-l-0">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="desagregacion_sexo" value="1" id="desagregacion_sexo">
                                                            <label class="custom-control-label" for="desagregacion_sexo">Sexo</label>
                                                        </div>
                                                      </div>
                                                   </div>
                                                  <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                                                       <div class="col-md-3 p-l-0">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="desagregacion_edad" value="1" id="desagregacion_edad">
                                                            <label class="custom-control-label" for="desagregacion_edad">Edad</label>
                                                        </div>
                                                      </div>
                                                   </div>
                                                  <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                                                       <div class="col-md-3 p-l-0">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="desagregacion_nac" value="1" id="desagregacion_nac">
                                                            <label class="custom-control-label" for="desagregacion_nac">Nacional</label>
                                                        </div>
                                                      </div>
                                                   </div>
                                                  <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                                                       <div class="col-md-3 p-l-0">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="desagregacion_deptal" value="1" id="desagregacion_deptal">
                                                            <label class="custom-control-label" for="desagregacion_deptal">Deptal</label>
                                                        </div>
                                                      </div>
                                                   </div>
                                                  <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                                                       <div class="col-md-3 p-l-0">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="desagregacion_munic" value="1" id="desagregacion_munic">
                                                            <label class="custom-control-label" for="desagregacion_munic">Municipal</label>
                                                        </div>
                                                      </div>
                                                   </div>





                                                </div>
                                              </div>



































<!--                                               <h5>Linea base del indicador</h5>
                                              <hr>
                                              <div class="row m-b-5 m-l-5 m-t-5" >
                                                  <div class="form-group col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fecha linea base</label>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0">
                                                    <div class='input-group date' id='dateLB'>
                                                      <input name="linea_base_fecha" type='text' class="form-control" placeholder="mm/yyyy"/>
                                                      <span class="input-group-addon">
                                                          <span class="glyphicon glyphicon-calendar">
                                                          </span>
                                                      </span>
                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Valor linea base</label>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0">
                                                      <input name="linea_base_valor" type="text" class="form-control input" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;" value="0.00">
                                                      <div class="help-block with-errors"></div>
                                                  </div>
                                              </div>  -->

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fórmula</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                <textarea id="formula" name="formula" class="form-control" placeholder="Fórmula" rows="2" ></textarea>
                                                <div class="help-block with-errors"></div>
                                              </div>
                                            </div>
  <!--                                           <h5>Detallar fórmula</h5>
                                            <hr/>  -->
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Numerador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="numerador_detalle" name="numerador_detalle" class="form-control" placeholder="Numerador" rows="2" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>


                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Fuente Numerador</label>
                                                 <h5>(<b>F8</b> agregar uno nuevo a la lista)</h5>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <div class="select2-wrapper">
                                              <select id="fuente_datos" name="fuente_datos[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                         @foreach ($fuente_datos as  $item)
                                                               <option value="{{ $item->id }}">{{$item->nombre}}</option>
                                                         @endforeach
                                                     </select>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>
<!--                                              <h5>Detalle fuente de datos seleccionado(s)</h5>
                                             <hr/> -->
                                             <div id="datosFDN">
                                             </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Denominador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="denominador_detalle" name="denominador_detalle" class="form-control" placeholder="Denominador" rows="2" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>
                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Fuente Denominador</label>
                                                 <h5>(<b>F8</b> agregar uno nuevo a la lista)</h5>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <div class="select2-wrapper">
                                          <select id="fuente_datos_d" name="fuente_datos_d[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                         @foreach ($fuente_datos as  $item)
                                                               <option value="{{ $item->id }}">{{$item->nombre}}</option>
                                                         @endforeach
                                                     </select>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>
<!--                                              <h5>Detalle fuente de datos seleccionado(s)</h5>
                                             <hr/> -->
                                             <div id="datosFDD">
                                             </div>
                                   <!--         </div> -->

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Observaciones a la fuente de datos</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="observacion" name="observacion" class="form-control" placeholder="Observaciones al indicador" rows="8" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                          </div>
                                      </div>


    <!--                                   <div id="info3" class="tab-pane">
                                          <div class="col-md-12 list-group-item-success">
                                              <h4 style="width:100%;">Método de cálculo del indicador</h4>
                                          </div>
                                          <div class="col-md-12"> -->

 <!--                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fórmula</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                <textarea id="formula" name="formula" class="form-control" placeholder="Fórmula" rows="2" ></textarea>
                                                <div class="help-block with-errors"></div>
                                              </div>
                                            </div>
                                            <h5>Detallar fórmula</h5>
                                            <hr/>
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Numerador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="numerador_detalle" name="numerador_detalle" class="form-control" placeholder="Numerador" rows="2" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div> -->
<!--                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fuente numerador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <input id="numerador_fuente" name="numerador_fuente" type="text" class="form-control"  placeholder="Tipo de indicador" >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div> -->
  <!--                                           <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Denominador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="denominador_detalle" name="denominador_detalle" class="form-control" placeholder="Denominador" rows="2" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div> -->
<!--                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fuente denominador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <input id="denominador_fuente" name="denominador_fuente" type="text" class="form-control" placeholder="Tipo de indicador" >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div> -->

                                   <!--        <div class="col-md-12"> -->
 <!--                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-2 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Fuente</label>
                                                 <h5>(<b>F8</b> agregar uno nuevo a la lista)</h5>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <div class="select2-wrapper">
                                                     <select id="fuente_datos" name="fuente_datos[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                         @foreach ($fuente_datos as  $item)
                                                               <option value="{{ $item->id }}">{{$item->nombre}}</option>
                                                         @endforeach
                                                     </select>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div> -->
<!--                                              <h5>Detalle fuente de datos seleccionado(s)</h5>
                                             <hr/> -->
<!--                                              <div id="datosFD">
                                             </div> -->
                                   <!--         </div> -->

<!--                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Observaciones a la fuente de datos</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="observacion" name="observacion" class="form-control" placeholder="Observaciones al indicador" rows="8" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div> -->

                     <!--                      </div>
                                      </div> -->

                                      <div id="info3" class="tab-pane">  <!--  ANTES ERA 4 -->
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Metas y avances</h4>
                                           </div>
                                            <div class="col-md-12">
                                              <h5>Linea base del indicador</h5>
                                        <!--       <hr> -->
                                              <div class=" form-group row m-b-5 m-l-5 m-t-5" >
                                                  <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                      <div class="col-md-2 p-l-0 p-r-0">
                                                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Dia linea base</label>
                                                      </div>
                                                      <div class="col-md-2 p-l-0">
                                                        <div class='input-group date' id='diaLB'>
                                                          <input name="base_linea_dia" type='text' class="form-control" placeholder="dia"/>
                                                          <span class="input-group-addon">
                                                              <span class="glyphicon glyphicon-calendar">
                                                              </span>
                                                          </span>
                                                        </div>
                                                        <div class="help-block with-errors"></div>
                                                      </div>

                                                      <div class="col-md-2 p-l-0 p-r-0">
                                                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Mes linea base</label>
                                                      </div>
                                                      <div class="col-md-2 p-l-0">
                                                        <div class='input-group date' id='mesLB'>
                                                          <input name="base_linea_mes" type='text' class="form-control" placeholder="mes"/>
                                                          <span class="input-group-addon">
                                                              <span class="glyphicon glyphicon-calendar">
                                                              </span>
                                                          </span>
                                                        </div>
                                                        <div class="help-block with-errors"></div>
                                                      </div>


                                                      <div class="col-md-2 p-l-0 p-r-0">
                                                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Año linea base</label>
                                                      </div>
                                                      <div class="col-md-2 p-l-0">
                                                        <div class='input-group date' id='anioLBA'>
                                                          <input name="base_linea_anio" type='text' class="form-control" placeholder="año"/>
                                                          <span class="input-group-addon">
                                                              <span class="glyphicon glyphicon-calendar">
                                                              </span>
                                                          </span>
                                                        </div>
                                                        <div class="help-block with-errors"></div>
                                                      </div>
                                                  </div>

                                                  <div class="form-group col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Valor linea base</label>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0">
                                                      <input name="linea_base_valor" type="text" class="form-control input" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': true, 'digits': 4, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;" value="0.0000">
                                                      <div class="help-block with-errors"></div>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Plazo en Años</label>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0">
                                                      <input name="plazo_anios" type="number" class="form-control input"  style="text-align: right;" value="">
                                                      <div class="help-block with-errors"></div>
                                                  </div>
                                              </div>


                                            </div>
                                           <div class="col-md-12">
                                               <h5>Metas macro</h5>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="col-md-2 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2020</label>
                                                   </div>
                                                   <div class="col-md-2 p-l-0">
                                                       <input id="id_meta_2020" name="id_meta_2020" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2020" name="meta_2020" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>

                                                   <div class="col-md-2 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2025</label>
                                                   </div>
                                                   <div class="col-md-2 p-l-0">
                                                       <input id="id_meta_2025" name="id_meta_2025" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2025" name="meta_2025" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>


                                                   <div class="col-md-2 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2030</label>
                                                   </div>
                                                   <div class="col-md-2 p-l-0">
                                                       <input id="id_meta_2030" name="id_meta_2030" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2030" name="meta_2030" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',',  'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-12">
                                       <!--       <hr/> -->
                                               <h5>Metas Parciales</h5>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2016</label>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0 m-b-0">
                                                       <input id="id_meta_2016" name="id_meta_2016" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2016" name="meta_2016" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                               <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de medida</label>
                                                </div>
                                                  <div class="form-group col-md-3 p-l-0 m-b-0">
                                                      <label for="label" class="form-control unidad_medidaDesc"></label>
                                                      <div class="help-block with-errors"></div>
                                                </div>
                                              </div>
                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2017</label>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0 m-b-0">
                                                       <input id="id_meta_2017" name="id_meta_2017" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2017" name="meta_2017" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                              <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de medida</label>
                                                </div>
                                                  <div class="form-group col-md-3 p-l-0 m-b-0">
                                                      <label for="label" class="form-control unidad_medidaDesc"></label>
                                                      <div class="help-block with-errors"></div>
                                                </div>
                                              </div>
                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2018</label>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0 m-b-0">
                                                       <input id="id_meta_2018" name="id_meta_2018" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2018" name="meta_2018" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                              <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de medida</label>
                                                </div>
                                                  <div class="form-group col-md-3 p-l-0 m-b-0">
                                                      <label for="label" class="form-control unidad_medidaDesc"></label>
                                                      <div class="help-block with-errors"></div>
                                                </div>
                                               </div>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                    <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2019</label>
                                                    </div>
                                                    <div class="form-group col-md-3 p-l-0 m-b-0">
                                                        <input id="id_meta_2019" name="id_meta_2019" type="hidden" class="form-control oculto" required>
                                                        <input id="meta_2019" name="meta_2019" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                              <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de medida</label>
                                                </div>
                                                  <div class="form-group col-md-3 p-l-0 m-b-0">
                                                      <label for="label" class="form-control unidad_medidaDesc"></label>
                                                      <div class="help-block with-errors"></div>
                                                  </div>
                                                </div>
                                           </div>

                                           <div class="col-md-12">
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-lg-2 p-l-0 p-r-0">
                                                     <label  style="width: 100%;padding: 9px 0px 4px 3px;"><font color="#FF8000"> REPORTAR AVANCES</font></label>
                                                 </div>
                                                 <div class="col-md-2 p-l-0">
                                                   <div class=" form-group row m-b-5 m-l-5 m-t-5" >
                                                       <div  id="Avances" class="col-lg-2 p-l-0 text-center">
                                                             <button type="button" id="activa4" class="btn waves-effect waves-light btn-outline-info"><span class="glyphicon glyphicon-plus"></span></button>
                                                       </div>
                                                   </div>
                                                 </div>
                                            </div>

                                            <div id="cod5">
                                              <div class="row m-b-5 m-l-5 m-t-5" >

                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                  <div class="col-md-2 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Reporte Dia</label>
                                                  </div>
                                                  <div class="col-md-2 p-l-0">
                                                   <div class='input-group date' id='diaAV'>
                                                     <input name="avance_fecha_dia" type='text' class="form-control" placeholder="dia"/>
                                                     <span class="input-group-addon">
                                                         <span class="glyphicon glyphicon-calendar">
                                                         </span>
                                                     </span>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                                  </div>

                                                  <div class="col-md-2 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Reporte Mes</label>
                                                  </div>
                                                  <div class="col-md-2 p-l-0">
                                                   <div class='input-group date' id='mesAV'>
                                                     <input name="avance_fecha_mes" type='text' class="form-control" placeholder="mes"/>
                                                     <span class="input-group-addon">
                                                         <span class="glyphicon glyphicon-calendar">
                                                         </span>
                                                     </span>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                                  </div>


                                                  <div class="col-md-2 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Reporte Año</label>
                                                  </div>
                                                  <div class="col-md-2 p-l-0">
                                                   <div class='input-group date' id='anioAV'>
                                                     <input name="avance_fecha_anio" type='text' class="form-control" placeholder="año"/>
                                                     <span class="input-group-addon">
                                                         <span class="glyphicon glyphicon-calendar">
                                                         </span>
                                                     </span>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                                  </div>
                                              </div>

                                                    <div class="form-group col-md-5 p-l-0 p-r-0 m-b-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Valor a reportar</label>
                                                    </div>
                                                    <div class="form-group col-md-7 p-l-0 m-b-0">
                                                        <input name="avance_valor_input" type="text" class="form-control input" placeholder="Valor"  value="0" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;" >
                                                        <div class="help-block with-errors"></div>
                                                    </div>


                                              </div>
                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                    Detallar Avance:
                                                   <textarea id="detalle_avance" name="detalle_avance" class="form-control" placeholder="Explique los avances"></textarea>
                                                   </div>

                                               <div class="row m-b-5 m-l-5 m-t-5" >
                                                  <div class="col-md-12 p-l-0 text-center">
                                                      <button type="button" class="btn btn-info btn-sm agregarAV m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                  </div>
                                               </div>

                                             </div>
                                           </div>
                                           <div class="col-md-10">
                                             <h5>Listado de avances reportados</h5>
                                               <div class="row m-b-5 m-l-5 m-t-5" >
                                                 <table id="set_avance" class="table table-hover scroll table color-table danger-table table-hover table-bordered text-center">
                                                     <thead>
                                                         <tr>
                                                             <th class="col-sm-1"><center>#</center></th>
                                                             <th class="col-sm-3"><center>Fecha reportado</center></th>
                                                             <th class="col-sm-3"><center>Valor reportado</center></th>
                                                             <th class="col-sm-8"><center>Detalle avance</center></th>
    <!--                                                          <th class="col-sm-8"><center>Explicaciòn</center></th>  -->
                                                             <th class="col-sm-1"><center> - </center></th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>
                                                     </tbody>
                                                 </table>
                                              </div>
                                           </div>

                                           <div class="col-md-12">
                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Cargue archivo respaldo</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                  <div  id="cod_sexo">
                                                      <div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog1">
                                                          <div class="modal-content">
                                                              <div class="modal-header">
                                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true">&times;</span></button><h5 class="modal-title" id="myModalLabel2">Archivo de Respaldo Sexo</h5></div>
                                                                    <div class="modal-body">
                                                                           <form>
                                                                                <div class="form-group" >
                                                                                     <div class="col-md-3 p-l-0 p-r-0">
                                                                                       <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre :</label>
                                                                                     </div>
                                                                                     <div class="col-md-9 p-l-0">
                                                                                         <div class="select2-wrapper">
                                                                                           <input id="arc_nombre_sexo" name="arc_nombre_sexo" type="text" class="form-control" placeholder="Nombre del Archivo de Respaldo" >
                                                                                         </div>
                                                                                         <div class="help-block with-errors"></div>
                                                                                     </div>
                                                                                   </div>
                                                                                   <div class="form-group" >
                                                                                     <div class="col-md-3 p-l-0 p-r-0">
                                                                                       <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar :</label>
                                                                                     </div>
                                                                                     <div class="col-md-9 p-l-0">
                                                                                         <div class="select2-wrapper">
                                                                                           <input type="file" id ="arc_archivo_sexo" name="arc_archivo_sexo" class="form-control p-t-0" accept=".xls,.xlsx,.cvs">
                                                                                         </div>
                                                                                         <div class="help-block with-errors"></div>
                                                                                     </div>
                                                                                     <div class="col-md-12 p-l-0 text-center">
                                                                                         <button type="button" class="btn btn-info btn-sm agregarARCS m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                                                     </div>
                                                                                   </div>
                                                                          </form>
                                                                      </div>
                                                                      <div class="modal-footer">
                                                                          <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cerrar</button>
                                                                      </div>
                                                              </div>
                                                            </div>
                                                        </div>

                                                          <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                                                               <div class="col-md-3 p-l-0">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" id="chkCodeudor2">
                                                                    <label class="custom-control-label" for="chkCodeudor2">Sexo</label>
                                                                </div>
                                                              </div>
                                                               <div class="col-md-9 p-l-0">
                                                                    <!-- <h5>Archivos subidos</h5> -->
                                                                       <table id="datosARCS" class="table table-hover">
                                                                          <thead>
                                                                              <tr>
                                                                             </tr>
                                                                         </thead>
                                                                         <tbody >

                                                                         </tbody>
                                                                       </table>
                                                                </div>
                                                              </div>
                                                    </div>

                                                  <div  id="cod_edad">
                                                    <div id="myModal3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="display: none;">
                                                      <div class="modal-dialog1">
                                                          <div class="modal-content">
                                                              <div class="modal-header">
                                                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true">&times;</span></button><h5 class="modal-title" id="myModalLabel3">Archivo de Respaldo Edad</h5></div>
                                                                    <div class="modal-body">
                                                                           <form id="formMod" name="formMod">
                                                                                {{ csrf_field() }}
                                                                            <div class="form-group" >
                                                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre :</label>
                                                                                 </div>
                                                                                 <div class="col-md-9 p-l-0">
                                                                                     <div class="select2-wrapper">
                                                                                       <input id="arc_nombre_ing2" name="arc_nombre_ing2" type="text" class="form-control" placeholder="Nombre del Archivo de Respaldo" >
                                                                                     </div>
                                                                                     <div class="help-block with-errors"></div>
                                                                                 </div>
                                                                               </div>
                                                                               <div class="form-group" >
                                                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar :</label>
                                                                                 </div>
                                                                                 <div class="col-md-9 p-l-0">
                                                                                     <div class="select2-wrapper">
                                                                                       <input type="file" id ="arc_archivo_ing2" name="arc_archivo_ing2" class="form-control p-t-0" accept=".xls,.xlsx,.cvs">
                                                                                     </div>
                                                                                     <div class="help-block with-errors"></div>
                                                                                 </div>
                                                                                 <div class="col-md-12 p-l-0 text-center">
                                                                                     <button type="button" class="btn btn-info btn-sm agregarARCED m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                                                 </div>
                                                                               </div>
                                                                              </form>
                                                                        </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cerrar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                          <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                                                               <div class="col-md-3 p-l-0">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" id="chkCodeudor3">
                                                                    <label class="custom-control-label" for="chkCodeudor3">Edad</label>
                                                                </div>
                                                              </div>
                                                               <div class="col-md-9 p-l-0">
                                                                    <!-- <h5>Archivos subidos</h5> -->
                                                                       <table id="datosARCED" class="table table-hover">
                                                                          <thead>
                                                                              <tr>
                                          <!--                                                      <th>Descripcion de archivos</th>
                                                                               <th>-</th> -->
                                                                             </tr>
                                                                         </thead>
                                                                         <tbody >

                                                                         </tbody>
                                                                       </table>
                                                                </div>

                                                              </div>
                                                    </div>

                                                  <div  id="cod_nac">
                                                    <div id="myModal4" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true" style="display: none;">
                                                                            <div class="modal-dialog1">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true">&times;</span></button><h5 class="modal-title" id="myModalLabel4">Archivo de Respaldo Nacional</h5></div>
                                                                    <div class="modal-body">
                                                                           <form id="formNac" name="formNac">
                                                                                        {{ csrf_field() }}
                                                                                    <div class="form-group" >
                                                                                         <div class="col-md-3 p-l-0 p-r-0">
                                                                                           <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre :</label>
                                                                                         </div>
                                                                                         <div class="col-md-9 p-l-0">
                                                                                             <div class="select2-wrapper">
                                                                                               <input id="arc_nombre_ing_n" name="arc_nombre_ing_n" type="text" class="form-control" placeholder="Nombre del Archivo de Respaldo" >
                                                                                             </div>
                                                                                             <div class="help-block with-errors"></div>
                                                                                         </div>
                                                                                       </div>
                                                                                       <div class="form-group" >
                                                                                         <div class="col-md-3 p-l-0 p-r-0">
                                                                                           <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar :</label>
                                                                                         </div>
                                                                                         <div class="col-md-9 p-l-0">
                                                                                             <div class="select2-wrapper">
                                                                                               <input type="file" id ="arc_archivo_ing_n" name="arc_archivo_ing_n" class="form-control p-t-0" accept=".xls,.xlsx,.cvs">
                                                                                             </div>
                                                                                             <div class="help-block with-errors"></div>
                                                                                         </div>
                                                                                         <div class="col-md-12 p-l-0 text-center">
                                                                                             <button type="button" class="btn btn-info btn-sm agregarARCN m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                                                         </div>
                                                                                       </div>
                                                                              </form>
                                                                        </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cerrar</button>
                                                                                  </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                          <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                                                              <div class="col-md-3 p-l-0">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" id="chkCodeudor4">
                                                                    <label class="custom-control-label" for="chkCodeudor4">Nacional</label>
                                                                </div>
                                                              </div>
                                                               <div class="col-md-9 p-l-0">
                                                                    <!-- <h5>Archivos subidos</h5> -->
                                                                       <table id="datosARCN" class="table table-hover">
                                                                          <thead>
                                                                              <tr>
                                          <!--                                                      <th>Descripcion de archivos</th>
                                                                               <th>-</th> -->
                                                                             </tr>
                                                                         </thead>
                                                                         <tbody >

                                                                         </tbody>
                                                                       </table>
                                                                </div>

                                                              </div>
                                                   </div>

                                                  <div  id="cod_deptal">
                                                    <div id="myModal5" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true" style="display: none;">
                                                                            <div class="modal-dialog1">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true">&times;</span></button><h5 class="modal-title" id="myModalLabel5">Archivo de Respaldo Departamental</h5></div>
                                                                                          <div class="modal-body">
                                                                                                 <form id="formDptal" name="formDptal">
                                                                                                              {{ csrf_field() }}
                                                                                                          <div class="form-group" >
                                                                                                               <div class="col-md-3 p-l-0 p-r-0">
                                                                                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre :</label>
                                                                                                               </div>
                                                                                                               <div class="col-md-9 p-l-0">
                                                                                                                   <div class="select2-wrapper">
                                                                                                                     <input id="arc_nombre_ing_d" name="arc_nombre_ing_d" type="text" class="form-control" placeholder="Nombre del Archivo de Respaldo" >
                                                                                                                   </div>
                                                                                                                   <div class="help-block with-errors"></div>
                                                                                                               </div>
                                                                                                             </div>
                                                                                                             <div class="form-group" >
                                                                                                               <div class="col-md-3 p-l-0 p-r-0">
                                                                                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar :</label>
                                                                                                               </div>
                                                                                                               <div class="col-md-9 p-l-0">
                                                                                                                   <div class="select2-wrapper">
                                                                                                                     <input type="file" id ="arc_archivo_ing_d" name="arc_archivo_ing_d" class="form-control p-t-0" accept=".xls,.xlsx,.cvs">
                                                                                                                   </div>
                                                                                                                   <div class="help-block with-errors"></div>
                                                                                                               </div>
                                                                                                               <div class="col-md-12 p-l-0 text-center">
                                                                                                                   <button type="button" class="btn btn-info btn-sm agregarARCD m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                                                                               </div>
                                                                                                             </div>
                                                                                                    </form>
                                                                                              </div>
                                                                                    <div class="modal-footer">
                                                                                      <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cerrar</button>
                                                                                  </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                      <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                                                           <div class="col-md-3 p-l-0">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="chkCodeudor5">
                                                                <label class="custom-control-label" for="chkCodeudor5">Deptal</label>
                                                            </div>
                                                          </div>
                                                           <div class="col-md-9 p-l-0">
                                                                <!-- <h5>Archivos subidos</h5> -->
                                                                   <table id="datosARCD" class="table table-hover">
                                                                      <thead>
                                                                          <tr>
                                          <!--                                                      <th>Descripcion de archivos</th>
                                                                           <th>-</th> -->
                                                                         </tr>
                                                                     </thead>
                                                                     <tbody >

                                                                     </tbody>
                                                                   </table>
                                                            </div>

                                                          </div>
                                                  </div>

                                                  <div  id="cod_munic">
                                                        <div id="myModal6" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel6" aria-hidden="true" style="display: none;">
                                                              <div class="modal-dialog1">
                                                                  <div class="modal-content">
                                                                      <div class="modal-header">
                                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true">&times;</span></button><h5 class="modal-title" id="myModalLabel6">Archivo de Respaldo Municipal</h5></div>
                                                                        <div class="modal-body">
                                                                               <form id="formMunic" name="formMunic">
                                                                                            {{ csrf_field() }}
                                                                                        <div class="form-group" >
                                                                                             <div class="col-md-3 p-l-0 p-r-0">
                                                                                               <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre :</label>
                                                                                             </div>
                                                                                             <div class="col-md-9 p-l-0">
                                                                                                 <div class="select2-wrapper">
                                                                                                   <input id="arc_nombre_ing_m" name="arc_nombre_ing_m" type="text" class="form-control" placeholder="Nombre del Archivo de Respaldo" >
                                                                                                 </div>
                                                                                                 <div class="help-block with-errors"></div>
                                                                                             </div>
                                                                                           </div>
                                                                                           <div class="form-group" >
                                                                                             <div class="col-md-3 p-l-0 p-r-0">
                                                                                               <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar :</label>
                                                                                             </div>
                                                                                             <div class="col-md-9 p-l-0">
                                                                                                 <div class="select2-wrapper">
                                                                                                   <input type="file" id ="arc_archivo_ing_m" name="arc_archivo_ing_m" class="form-control p-t-0" accept=".xls,.xlsx,.cvs">
                                                                                                 </div>
                                                                                                 <div class="help-block with-errors"></div>
                                                                                             </div>
                                                                                             <div class="col-md-12 p-l-0 text-center">
                                                                                                 <button type="button" class="btn btn-info btn-sm agregarARCM m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                                                             </div>
                                                                                           </div>
                                                                                  </form>
                                                                            </div>
                                                              <div class="modal-footer">
                                                                  <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cerrar</button>
                                                                    </div>
                                                                  </div>
                                                              </div>
                                                          </div>

                                                          <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                                                               <div class="col-md-3 p-l-0">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" id="chkCodeudor6">
                                                                    <label class="custom-control-label" for="chkCodeudor6">Municipal</label>
                                                                </div>
                                                              </div>
                                                               <div class="col-md-9 p-l-0">
                                                                    <!-- <h5>Archivos subidos</h5> -->
                                                                       <table id="datosARCM" class="table table-hover">
                                                                          <thead>
                                                                              <tr>
                                          <!--                                                      <th>Descripcion de archivos</th>
                                                                               <th>-</th> -->
                                                                             </tr>
                                                                         </thead>
                                                                         <tbody >

                                                                         </tbody>
                                                                       </table>
                                                                </div>

                                                            </div>
                                                     </div>

                                            </div> <!--  COL-MD-9 -->
                                              </div>
                                           </div>





                                           <div class="col-md-12">
                                               <br/>
                                               <br/>
                                               <br/>
                                           </div>
                                       </div>


<!--                                        <div id="info4" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Fuente de datos del indicador</h4>
                                           </div>
                                           <div class="col-md-12">
                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >

                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Fuente</label>
                                                 <h5>(<b>F8</b> agregar uno nuevo a la lista)</h5>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <div class="select2-wrapper">
                                                     <select id="fuente_datos" name="fuente_datos[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                         @foreach ($fuente_datos as  $item)
                                                               <option value="{{ $item->id }}">{{$item->nombre}}</option>
                                                         @endforeach
                                                     </select>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>
                                             <h5>Detalle fuente de datos seleccionado(s)</h5>
                                             <hr/>
                                             <div id="datosFD">
                                             </div>
                                           </div>
                                       </div> -->

                                       {{-- <div id="info4" class="tab-pane"> <!--  ERA ANTES 6 -->
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Archivos respaldo</h4>
                                           </div>
                                           <div class="col-md-12">



                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Nombre de Respaldo</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input id="arc_nombre_input" name="arc_nombre_input" type="text" class="form-control" placeholder="Nombre de respaldo" >
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Adjuntar</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input type="file" id ="arc_archivo_input" name="arc_archivo_input" class="form-control p-t-0" accept=".xls,.xlsx,.cvs">
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                                 <div class="col-md-12 p-l-0 text-center">
                                                     <button type="button" class="btn btn-info btn-sm agregarARC m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                 </div>
                                               </div>


                                             <h5>Archivos subidos</h5>
                                             <table id="datosARC" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                     <th>Descripcion de archivos</th>
                                                     <th>-</th>
                                                   </tr>
                                               </thead>
                                               <tbody >

                                               </tbody>
                                             </table>
                                           </div>
                                       </div> --}}

                                     <div id="info4" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Viabilidad de Indicador</h4>
                                           </div>
                                           <div class="col-md-12">

                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Estado</label>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                     <select id="estado_indicador" name="estado_indicador" class="custom-select col-12 form-control" onchange="actualizarcombo(this);">
                                                         <option value="">Seleccionar...</option>
                                                         @foreach ($estado as $key => $value)
                                                               <option value="{{ $key }}">{{$value}}</option>
                                                         @endforeach
                                                     </select>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>


                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Etapa</label>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                     <select id="etapa" name="etapa" class="custom-select col-12 form-control" onchange="actualizarcombo(this);">
                                                         <option value="">Seleccionar...</option>
                                                         @foreach ($etapas as  $items)
                                                               <option value="{{ $items->nombre }}">{{$items->nombre}} - {{$items->descripcion}}</option>
                                                         @endforeach
                                                     </select>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>

                                             <h3>Tipo de Brecha para Reportar el Indicador</h3>
                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Brecha de Datos</label>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <select id="brecha_datos" name="brecha_datos" class="custom-select col-12 form-control">
                                                       <option value="9">Seleccionar...</option>
                                                       @foreach ($brechaDatos as $key => $value)
                                                             <option value="{{ $key }}">{{ $key }}: {{$value}}</option>
                                                       @endforeach
                                                   </select>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>

                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Brecha de Metodología</label>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <select id="brecha_metodologia" name="brecha_metodologia" class="custom-select col-12 form-control">
                                                       <option value="9">Seleccionar...</option>
                                                       @foreach ($brechaMetodologia as $key => $value)
                                                             <option value="{{ $key }}">{{ $key }}: {{$value}}</option>
                                                       @endforeach
                                                   </select>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>

                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Brecha de Capacitación</label>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <select id="brecha_capacitacion" name="brecha_capacitacion" class="custom-select col-12 form-control">
                                                       <option value="9">Seleccionar...</option>
                                                       @foreach ($brechaCapacitacion as $key => $value)
                                                             <option value="{{ $key }}">{{ $key }}: {{$value}}</option>
                                                       @endforeach
                                                   </select>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>

                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Brecha de Financiamiento</label>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <select id="brecha_financiamiento" name="brecha_financiamiento" class="custom-select col-12 form-control">
                                                       <option value="9">Seleccionar...</option>
                                                       @foreach ($brechaFinanciamiento as $key => $value)
                                                             <option value="{{ $key }}">{{ $key }}: {{$value}}</option>
                                                       @endforeach
                                                   </select>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>



                                           </div>
                                       </div>
                                     <div id="info5" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Secretaria Técnica CIMPDES</h4>
                                           </div>
                                           <div class="col-md-12">
                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Frecuencia de reporte</label>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <select id="frecuencia" name="frecuencia" class="custom-select col-12 form-control">
                                                       <option value="">Seleccionar...</option>
                                                       @foreach ($frecuencia as  $item)
                                                             <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                       @endforeach
                                                   </select>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>

                                             <div class="form-group row m-b-5 m-l-5 m-t-5" style="@if($filtData>0)pointer-events:none; @endif" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Sectores Relacionados </label>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <select id="sectores" name="sectores[]" placeholder="Seleccionar..."  multiple="multiple" class=" select2 multiple">
                                                       @foreach ($instituciones as  $item)
                                                             <option value="{{ $item->id }}">{{$item->codigo}}: {{$item->denominacion}}</option>
                                                       @endforeach
                                                   </select>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>

                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Asistencia Tecnica</label>
                                                 </div>
                                                 <div class="col-md-1 p-l-0 p-r-0">
                                                    <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="checkbox10" value="1" id="customSwitch10">
                                                            <label class="custom-control-label" for="customSwitch10" style="width:100px;">Si</label>
                                                        </div>

                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" id="customSwitch9" class="custom-control-input" name="checkbox20">
                                                            <label class="custom-control-label" for="customSwitch9" style="width:200px;">No</label>
                                                        </div>
                                                    </div>
                                                  </div>
                                                  <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="col-lg-12 p-l-0">
                                                     <div id="datosTEC">
                                                     </div>
                                                   </div>
                                                  </div>
                                             </div>


                                           </div>
                                      </div>

                                  </div>
                              </div>

                      </div>
                    </div>

                    <div class="col-sm-12">
                            <div class="form-group text-center">
                              <button id="bt_guardar" type="submit" class="btn btn-info">Guardar</button>
                              <button id="bt_siguiente" type="button" class="btn btn-info tap-btn">Siguiente</button>
                              <button type="button" class="btn btn-default btn-back">Cancelar</button>
                            </div>
                    </div>

                  </div>
              </div>


            </div>
            <!-- /.row -->
          </form>
      </div>
  </div>

  <div id="window" class="white-popup-block popup-basic admin-form mfp-with-anim" style="display: none;">
      <div class="panel panel-heading" >
        <section><span class="panel-title"><i class="fa fa-pencil"></i> Fuente de datos</span></section>
      </div>
      <div id="divcon">

        <form id="formAddFuente" name="formAddFuente" action="javascript:saveFuente();" data-toggle="validator">
          {{ csrf_field() }}
          <input type="hidden" name="id_indicador" value="">
          <!-- .row -->
          <div class="row" style="margin-right: 0px;">
            <div class="col-sm-12">
                <div class="white-box p-t-0 p-b-0 m-b-0">

                  <h3 class="box-title m-b-0">Registro de fuente de datos</h3>
                  <p class="text-muted m-b-10">Completar los datos minimos de la Fuente de Datos. <button id ="btn-new-fuente" type="submit" class="btn btn-info btn-sm" style="float: right;margin-top: -26px;"><i class="fa fa-plus"></i> Guardar</button></p>
                  <p class="text-warning m-t-0">Debe completar la informacion en Administracion de Fuente de Datos</p>
                  <div class="form-group row m-b-10">
                    <div class="col-md-2 p-l-0 p-r-0">
                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Nombre</label>
                    </div>
                    <div class="col-md-10 p-l-0">
                        <!--input id="fd_nombre" name="fd_nombre" type="text" class="form-control"  placeholder="Nombre de la fuente" !-->
                        <textarea id="fd_nombre" name="fd_nombre" class="form-control" placeholder="Nombre de la fuente" required></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class=" row m-b-10">
                    <div class="col-md-2 p-l-0 p-r-0">
                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Serie</label>
                    </div>
                    <div class="form-group col-md-4 p-l-0">
                        <input id="fd_serie" name="fd_serie" type="text" class="form-control"  placeholder="Serie de Datos" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-2 p-l-0 p-r-0">
                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Tipo</label>
                    </div>
                    <div class="form-group col-md-4 p-l-0">
                        <select id="fd_tipo" name="fd_tipo" class="custom-select col-12 form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($fuente_tipos as  $item)
                                  <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                            @endforeach
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group row m-b-10">
                    <div class="col-md-2 p-l-0 p-r-0">
                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Sectorial</label>
                    </div>
                    <div class="col-md-10 p-l-0">
                        <textarea id="sectorial" name="sectorial" class="form-control" placeholder="Nombre del Sector" required></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group row m-b-10">
                    <div class="col-md-2 p-l-0 p-r-0">
                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Productor</label>
                    </div>
                    <div class="col-md-10 p-l-0">
                        <textarea id="fd_resp_2" name="fd_resp_2" class="form-control" placeholder="Nombre de la fuente" required></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                  </div>


                    <?php /*
                    <div class=" row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="fd_periodicidad" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Periodicidad</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0">
                          <select id="fd_periodicidad" name="fd_periodicidad" class="custom-select col-12 form-control">
                              <option value="">Seleccionar...</option>
                              @foreach ($frecuencia as  $item)
                                    <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                              @endforeach
                          </select>
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="fd_serie_datos" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Serie_datos</label>
                      </div>
                      <div class=" form-group col-md-4 p-l-0">
                          <input id="fd_serie_datos" name="fd_serie_datos" type="text" class="form-control"  placeholder="Serie datos disponible">
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Cobertura</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                          <select id="fd_cobertura_geografica" name="fd_cobertura_geografica[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                              @foreach ($dimensiones as  $item)
                                    <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                              @endforeach
                          </select>
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group row m-b-10 p-t-20">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Representatividad</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                          <input id="fd_nivel_representatividad_datos" name="fd_nivel_representatividad_datos" type="text" class="form-control"  placeholder="Nivel representatividad de datos">
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Variables</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                          <textarea id="fd_variable" name="fd_variable" class="form-control" placeholder="Variables"></textarea>
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <div class="form-group row m-b-10 p-t-20">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Observaciones</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                        <textarea id="fd_observacion" name="fd_observacion" class="form-control" placeholder="Observaciones"></textarea>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <h3 class="box-title m-b-0">Relacionar Responsables</h3>



                    <ul class="nav nav-tabs" role="tablist">

                        <li role="presentation" class="active nav-item">
                          <a href="#lista" class="nav-link" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">
                            <span class="visible-xs"><i class="ti-user"></i></span>
                            <span class="hidden-xs">Lista </span>
                            <span id="cont_resp"class="label label-warning" style="font-size:15px;font-weight:bold;">0</span></a>
                        </li>
                        <li role="presentation" class="nav-item">
                          <a href="#registro" class="nav-link" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                            <span class="visible-xs"><i class="ti-home"></i></span>
                            <span class="hidden-xs"> Registrar</span>
                          </a>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="lista">
                          <table id="set_responsables" class="table table-hover scroll ">
                              <thead>
                                  <tr>
                                      <th style="width: 5%;">#</th>
                                      <th style="width: 90%;">Detalle responsable</th>
                                      <th style="width: 5%;"> - </th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="registro">

                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="row">
                                          <div class="col-md-4 p-l-0 p-r-0">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;" >Nombre entidad cabeza</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="responsable_1" name="responsable_1" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>

                                          <div class="col-md-4 p-l-0 p-r-0 text-right">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Nombre sub entidad</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="responsable_2" name="responsable_2" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>

                                          <div class="col-md-4 p-l-0 p-r-0 text-right">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Nombre sub entidad</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="responsable_3" name="responsable_3" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>

                                          <div class="col-md-4 p-l-0 p-r-0">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Número de referencia</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="referencia" name="referencia" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-12 p-l-0 text-center">
                                  <button type="button" class="btn btn-info btn-sm agregarRS m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                              </div>


                            </div>

                        </div>


                        */ ?>
                    </div>



                </div>
            </div>
        </div>

      </div>
  </div>









@endsection

@push('script-head')
  <!-- ... -->

    <script type="text/javascript" src="{{ asset('plugins/bower_components/moment/min/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bower_components/moment/min/locales.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxwindow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxbuttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxscrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdata.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdatatable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcheckbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxlistbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdropdownlist.js') }}"></script>
    <script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script type="text/javascript" src="{{ asset('js/jqwidgets-localization.js') }}"></script>

  <!-- Date Picker Plugin JavaScript -->

  <script type="text/javascript">
  var fechaAV = [];
  var valorAV = [];
  var estadoAV = [];
  var origenAV = [];
  var detalleAV = [];

  var responsable1A = [];
  var responsable2A = [];
  var responsable3A = [];
  var referenciaA = [];
  var idAV = [];
    $(document).ready(function(){
      //$(".select2").select2();
      $("#cod").hide();

      $("#cod_sexo").hide();
      $("#cod_edad").hide();
      $("#cod_nac").hide();
      $("#cod_deptal").hide();
      $("#cod_munic").hide();
      $('#customSwitch9').prop("checked",true);

     $('#relac').on('change',function(){
         var SelectValor=$(this).val();
         console.log("sdsdgf",SelectValor);
         if(SelectValor === "No Disponible"){
           $('#cod').hide();
         }else{
           $('#cod').show();
         }
     });
     $("#cod2").hide();
   $('#activa1').click(function(){
         $('#cod2').toggle();
   });

   $("#cod").hide();
   $('#activa').click(function(){
         $('#cod').toggle();
   });

    $("#cod1").hide();
   $('#relac').on('change',function(){
       var SelectValor=$(this).val();
       if(SelectValor === "No Disponible"){
         $('#cod1').hide();
       }else{
         $('#cod1').show();
       }
   });

     $("#cod4").hide();
    $('#activa3').click(function(){
          $('#cod4').toggle();
    });

    $("#cod5").hide();
    $('#activa4').click(function(){
          $('#cod5').toggle();
    });


   $('#diaLB').datetimepicker({
          format: 'DD',
         locale: 'es'
     });

     $('#mesLB').datetimepicker({
         //viewMode: 'month',
          format: 'MM',
         locale: 'es'
     });

     $('#anioLBA').datetimepicker({
         format: 'YYYY',
         locale: 'es'
     });

     $('#dateLB').datetimepicker({
         viewMode: 'years',
         format: 'DD/MM/YYYY',
         locale: 'es'
     });

     $('#diaAV').datetimepicker({
          format: 'DD',
         locale: 'es'
     });

     $('#mesAV').datetimepicker({
         //viewMode: 'month',
          format: 'MM',
         locale: 'es'
     });

     $('#anioAV').datetimepicker({
         format: 'YYYY',
         locale: 'es'
     });

     $('#dateAV').datetimepicker({
         viewMode: 'years',
         format: 'MM/YYYY',
         locale: 'es'
     });

      var filterData = {{$filtData}};
      if(filterData == 0)
      var theme = 'ui-lightness';
      else
      var theme = 'darkblue';
      $("#FilterAdvanced .select2").select2().attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);');
      $("#formAdd .select2").select2().attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);');
      $("#formAddFuente .select2").select2().attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);');
      $(".input").inputmask();
      $(function () {
                  $('#dateLB').datetimepicker({
                      viewMode: 'years',
                      format: 'DD/MM/YYYY',
                      locale: 'es'
                  });
                  $('#dateAV').datetimepicker({
                      viewMode: 'years',
                      format: 'MM/YYYY',
                      locale: 'es'
                  });
      });

$('#chkCodeudor2').click(function()
      {
          if ($('#chkCodeudor2').is(":checked")) {
              $('#myModal2').modal('show');
          }else {
              $('#myModal2').modal('hide');
          }
      });

  $('#chkCodeudor3').click(function()
      {
          if ($('#chkCodeudor3').is(":checked")) {
              $('#myModal3').modal('show');
          }else {
              $('#myModal3').modal('hide');
          }
      });

  $('#chkCodeudor4').click(function()
      {
          if ($('#chkCodeudor4').is(":checked")) {
              $('#myModal4').modal('show');
          }else {
              $('#myModal4').modal('hide');
          }
      });

  $('#chkCodeudor5').click(function()
      {
          if ($('#chkCodeudor5').is(":checked")) {
              $('#myModal5').modal('show');
          }else {
              $('#myModal5').modal('hide');
          }
      });

  $('#chkCodeudor6').click(function()
      {
          if ($('#chkCodeudor6').is(":checked")) {
              $('#myModal6').modal('show');
          }else {
              $('#myModal6').modal('hide');
          }
      });
  $('#customSwitch10').click(function(){
    var result = $('input[name="checkbox10"]:checked');
    $('#customSwitch9').prop("checked",false);
    if(result.length>0){
      var html =  '<textarea id="asistencia" name="asistencia" required class="form-control"'+
                  'placeholder="Describa la Asistencia Técnica" rows="7" style="width:100%;"></textarea>'+
                  '<div class="help-block with-errors"></div>';
      $("#datosTEC").html(html);
    }
    else{
      $("#datosTEC").html("");
    }
  });

  $('#customSwitch9').click(function(){
    var result = $('input[name="checkbox20"]:checked');
    $('#customSwitch10').prop("checked",false);
    if(result.length>0){
          $("#datosTEC").html("");
    }
  });
$('#customSwitch1').click(function(){
  var result = $('input[name="checkbox1"]:checked');
  if(result.length>0){


              var html =  '<div class="form-group row m-b-5 m-l-5 m-t-5" >'+
                              '<div class="col-md-2 p-l-0 p-r-0">'+
                              '<label for="textarea" class="col-form-label control-label list-group-item-info"'+
                              'style="width: 100%;padding: 9px 0px 9px 3px;"> Nombre</label>'+
                                '</div>'+
                                    '<div class="col-md-9 p-l-0">'+
                                        '<div class="select2-wrapper">'+
                                            '<input id="arc_nombre_input" name="arc_nombre_input" type="text"'+
                                            'class="form-control" placeholder="Nombre de respaldo" >'+
                                                '</div>'+
                                                  '<div class="help-block with-errors"></div>'+
                                                '</div>'+
                                        '</div>'+
             '<div id="customSwitch12" class="form-group row m-b-5 m-l-5 m-t-5">'+
                          '<div class="col-md-2 p-l-0 p-r-0">'+
                          '<label for="textarea" class="col-form-label control-label list-group-item-info"'+ 'style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar</label>'+
                          '</div>'+
                            '<div class="col-md-9 p-l-0">'+
                                '<div class="select2-wrapper">'+
                                   '<input type="file" id ="arc_archivo_inputs" name="arc_archivo_inputs"'+
                                    'class="form-control p-t-0" accept=".xls,.xlsx,.cvs">'+
                                '</div>'+
                                '<div class="help-block with-errors">'+'</div>'+
                              '</div>'+
                              '<div class="col-md-1 p-l-0">'+
                              '<button type="button" class="btn btn-info btn-sm agregarARCS m-t-5">'+
                                '<i class="fa fa-plus-square">'+'</i>'+' Agregar Sexo</button>'+
                                '</div>'+
                          '</div>';
            // $("#datosARC1 > tbody").append(html);

            //         var html= '<div class="form-group col-md-3 p-l-0">&nbsp;HHHHHHHH</div>';
                    $("#datosAFD").append(html);
  }
  else{
                    $("#datosAFD").html("");
  }
});

$('#customSwitch2').click(function(){
  var result = $('input[name="checkbox2"]:checked');
  if(result.length>0){

            var html =  '<div id="customSwitch12" class="form-group row m-b-5 m-l-5 m-t-5">'+
                          '<div class="col-md-2 p-l-0 p-r-0">'+
                          '<label for="textarea" class="col-form-label control-label list-group-item-info"'+ 'style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar</label>'+
                          '</div>'+
                            '<div class="col-md-9 p-l-0">'+
                                '<div class="select2-wrapper">'+
                                   '<input type="file" id ="arc_archivo_input" name="arc_archivo_input"'+
                                    'class="form-control p-t-0" accept=".xls,.xlsx,.cvs">'+
                                '</div>'+
                                '<div class="help-block with-errors">'+'</div>'+
                              '</div>'+
                              '<div class="col-md-1 p-l-0">'+
                              '<button type="button" class="btn btn-info btn-sm agregarARC1 m-t-5">'+
                                '<i class="fa fa-plus-square">'+'</i>'+' Agregar Edad</button>'+
                                '</div>'+
                          '</div>';
            // $("#datosARC1 > tbody").append(html);

            //         var html= '<div class="form-group col-md-3 p-l-0">&nbsp;HHHHHHHH</div>';
                    $("#datosAFD2").append(html);
  }
  else{
                    $("#datosAFD2").html("");
  }
});

      $(".agregarART").click(function () {
         var codigo = $('input[name=cod_pilar]').val()+$('input[name=cod_meta]').val()+$('input[name=cod_resultado]').val();
         if(!$('#datosART').find("#ART"+codigo).length){
        $.ajax({
                url: "{{ url('/api/sistemaremi/setDataPdes') }}",
                data: { 'p': $('input[name=cod_pilar]').val(),'m':$('input[name=cod_meta]').val(),'r':$('input[name=cod_resultado]').val() },
                type: "get",
                dataType: 'json',
                success: function(data){
                  if(data.error == false){
                    //ip_id--;
                    var html = //'<h5>Detalle de Articulación</h5>'+  //'<hr/>'+
                                '<div id="ART'+codigo+'" class="row">'+
                                  '<div class="media row col-lg-12 ">'+
                                      '<div class="col-lg-2 text-center">'+
                                          '<img src="/img/'+data.set[0].logo+'" alt="Pilar" width="100">'+
                                          '<a class="btn btn-block btn-info btn-sm m-t-10" onclick="quitarART('+codigo+',1);">Quitar</a>'+
                                      '</div>'+
                                      '<div class="row col-lg-10">'+
                                          '<input type="hidden" name="id_resultado_articulado[]" value="" />'+
                                          '<input type="hidden" name="resultado_articulado[]" value="'+data.set[0].id_resultado+'" />'+
                                          '<input type="hidden" id="EST'+codigo+'" name="estado_resultado_articulado[]" value="1" />'+
                                          '<div class="col-12"><b>'+data.set[0].pilar+':</b> '+data.set[0].desc_p+
                                          '</div>'+
                                             '<div class="col-12"><b>'+data.set[0].meta+':</b> '+data.set[0].desc_m+
                                          '</div>'+
                                          '<div class="col-12"><b>'+data.set[0].resultado+':</b> '+data.set[0].desc_r+
                                          '</div>'+
                                      '</div>'+
                                  '</div>'+
                                '</div>';
                    $("#datosART").append(html);

                  }else{
                      $.toast({
                       heading: data.title,
                       text: data.msg,
                       position: 'top-right',
                       loaderBg:'#ff6849',
                       icon: 'warning',
                       hideAfter: 3500

                     });
                  }
                },
                error:function(data){
                  if(data.status != 401){
                    $.toast({
                      heading: 'Error:',
                      text: 'Error al recuperar los datos.',
                      position: 'top-right',
                      loaderBg:'#ff6849',
                      icon: 'error',
                      hideAfter: 3500

                    });
                  }else{
                    window.location = '/login';
                  }
                }
          });
          // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe la relación solicitada.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });


      $(".agregarART1").click(function () {
         var codigo = $('input[name=cod_obj]').val()+$('input[name=cod_metaods]').val()+$('input[name=cod_resultadods]').val();
         var relacion = $('input[name=relac]').val();
         if(!$('#datosART1').find("#ART1"+codigo).length){
        $.ajax({
                url: "{{ url('/api/sistemaremi/setDataODS') }}",
                data: { 'o': $('input[name=cod_obj]').val(),'m':$('input[name=cod_metaods]').val(),'i':$('input[name=cod_resultadods]').val(),'rel':relacion },
                type: "get",
                dataType: 'json',
                success: function(data){
                  if(data.error == false){
                    //ip_id--;
                    var html = //'<h5>Detalle de Articulación</h5>'+  //'<hr/>'+
                                '<div id="ART1'+codigo+'" class="row">'+
                                  '<div class="media row col-lg-12 ">'+
                                      '<div class="col-lg-2 text-center">'+
                                          '<img src="/img/'+data.set[0].logo+'" alt="ODS" width="100">'+
                                          '<a class="btn btn-block btn-info btn-sm m-t-10" onclick="quitarART1(\''+codigo+'\',1);">Quitar</a>'+
                                      '</div>'+
                                      '<div class="row col-lg-10">'+
                                          '<input type="hidden" name="id_resultado_articuladods[]" value="" />'+
                                          '<input type="hidden" name="resultado_articuladods[]" value="'+data.set[0].id_indicador+'" />'+
                                          '<input type="hidden" name="relacion_ods[]" value="'+data.set[0].id_indicador+'" />'+
                                          '<input type="hidden" id="EST1'+codigo+'" name="estado_resultado_articuladods[]" value="1" />'+
                                          // '<div class="col-12"><b>Relacion:</b>'+relacion+
                                          // '</div>'+
                                          '<div class="col-12"><b>Comparabilidad: </b> '+relacion+
                                          '<div class="col-12"><b>'+data.set[0].objetivo+':</b> '+data.set[0].desc_o+
                                          '</div>'+
                                             '<div class="col-12"><b>'+data.set[0].meta+':</b> '+data.set[0].desc_m+
                                          '</div>'+
                                          '<div class="col-12"><b>'+data.set[0].indicador+':</b> '+data.set[0].desc_i+
                                          '</div>'+
                                      '</div>'+
                                  '</div>'+
                                '</div>';
                    $("#datosART1").append(html);

                  }else{
                      $.toast({
                       heading: data.title,
                       text: data.msg,
                       position: 'top-right',
                       loaderBg:'#ff6849',
                       icon: 'warning',
                       hideAfter: 3500

                     });
                  }
                },
                error:function(data){
                  if(data.status != 401){
                    $.toast({
                      heading: 'Error:',
                      text: 'Error al recuperar los datos.',
                      position: 'top-right',
                      loaderBg:'#ff6849',
                      icon: 'error',
                      hideAfter: 3500

                    });
                  }else{
                    window.location = '/login';
                  }
                }
          });
          // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe la relación solicitada.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });


      $(".agregarARCS").click(function () {
         var nombre = $('input[name=arc_nombre_sexo]').val();
         nombre = nombre.replace(/\s/g,"_");
        // console.log("datos",nombre);
         var formData = new FormData($("#formAdd")[0]);
         if(!$('#datosARCS').find("#ARCS"+nombre).length){
            $.ajax({
                    url: "{{ url('/api/sistemaremi/apiUploadArchivosRespaldos') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARCS'+ nombre +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id_s[]" value="" />'+
                                              '<input type="hidden" name="arc_sexo[]" value="2" />'+
                                              '<input type="hidden" name="arc_nombre_s[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo_s[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST_s'+nombre+'"name="arc_estado_s[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARCS(\''+nombre+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger" alt="Eliminar"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARCS > tbody").append(html);
                            $('input[name=arc_nombre_sexo]').val('');
                            $('input[name=arc_archivo_sexo]').val('');
                          }else{
                              $.toast({
                               heading: data.title,
                               text: data.msg,
                               position: 'top-right',
                               loaderBg:'#ff6849',
                               icon: 'warning',
                               hideAfter: 3500
                             });
                          }
                    },
                    error:function(data){
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al recuperar los datos.',
                          position: 'top-right',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                      }else{
                        window.location = '/login';
                      }
                    }
          });
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });


      $(".agregarARCED").click(function () {
         var nombrewe = $('input[name=arc_nombre_ing2]').val();
         nombrewe = nombrewe.replace(/\s/g,"_");
         //console.log("DATOS",nombre);
         var formData = new FormData($("#formMod")[0]);
         if(!$('#datosARCED').find("#ARCE"+nombrewe).length){
            $.ajax({
                    url: "{{ url('/api/sistemaremi/apiUploadArchivoRespaldoEdad') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARCE'+ nombrewe +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id_e[]" value="" />'+
                                              '<input type="hidden" name="arc_edad[]" value="1" />'+
                                              '<input type="hidden" name="arc_nombre_e[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo_e[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST_e'+nombrewe+'"name="arc_estado_e[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARCE(\''+nombrewe+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger" alt="Eliminar"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARCED > tbody").append(html);
                            $('input[name=arc_nombre_ing2]').val('');
                            $('input[name=arc_archivo_ing2]').val('');
                          }else{
                              $.toast({
                               heading: data.title,
                               text: data.msg,
                               position: 'top-right',
                               loaderBg:'#ff6849',
                               icon: 'warning',
                               hideAfter: 3500
                             });
                          }
                    },
                    error:function(data){
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al recuperar los datos.',
                          position: 'top-right',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                      }else{
                        window.location = '/login';
                      }
                    }
          });
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });

      $(".agregarARCN").click(function () {
         var nombrewe = $('input[name=arc_nombre_ing_n]').val();
         nombrewe = nombrewe.replace(/\s/g,"_");
         //console.log("DATOS",nombre);
         var formData = new FormData($("#formNac")[0]);
         if(!$('#datosARCN').find("#ARCN"+nombrewe).length){
            $.ajax({
                    url: "{{ url('/api/sistemaremi/apiUploadArchivoRespaldoNac') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARCN'+ nombrewe +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id_n[]" value="" />'+
                                              '<input type="hidden" name="arc_nac[]" value="3" />'+
                                              '<input type="hidden" name="arc_nombre_n[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo_n[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST_n'+nombrewe+'"name="arc_estado_n[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARCN(\''+nombrewe+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger" alt="Eliminar"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARCN > tbody").append(html);
                            $('input[name=arc_nombre_ing_n]').val('');
                            $('input[name=arc_archivo_ing_n]').val('');
                          }else{
                              $.toast({
                               heading: data.title,
                               text: data.msg,
                               position: 'top-right',
                               loaderBg:'#ff6849',
                               icon: 'warning',
                               hideAfter: 3500
                             });
                          }
                    },
                    error:function(data){
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al recuperar los datos.',
                          position: 'top-right',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                      }else{
                        window.location = '/login';
                      }
                    }
          });
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });

      $(".agregarARCD").click(function () {
         var nombrewe = $('input[name=arc_nombre_ing_d]').val();
         nombrewe = nombrewe.replace(/\s/g,"_");
         //console.log("DATOS",nombre);
         var formData = new FormData($("#formDptal")[0]);
         if(!$('#datosARCD').find("#ARCD"+nombrewe).length){
            $.ajax({
                    url: "{{ url('/api/sistemaremi/apiUploadArchivoRespaldoDptal') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARCD'+ nombrewe +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id_d[]" value="" />'+
                                              '<input type="hidden" name="arc_dptal[]" value="4" />'+
                                              '<input type="hidden" name="arc_nombre_d[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo_d[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST_n'+nombrewe+'"name="arc_estado_d[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARCD(\''+nombrewe+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger" alt="Eliminar"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARCD > tbody").append(html);
                            $('input[name=arc_nombre_ing_d]').val('');
                            $('input[name=arc_archivo_ing_d]').val('');
                          }else{
                              $.toast({
                               heading: data.title,
                               text: data.msg,
                               position: 'top-right',
                               loaderBg:'#ff6849',
                               icon: 'warning',
                               hideAfter: 3500
                             });
                          }
                    },
                    error:function(data){
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al recuperar los datos.',
                          position: 'top-right',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                      }else{
                        window.location = '/login';
                      }
                    }
          });
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });

      $(".agregarARCM").click(function () {
         var nombrewe = $('input[name=arc_nombre_ing_m]').val();
         nombrewe = nombrewe.replace(/\s/g,"_");
         //console.log("DATOS",nombre);
         var formData = new FormData($("#formMunic")[0]);
         if(!$('#datosARCM').find("#ARCM"+nombrewe).length){
            $.ajax({
                    url: "{{ url('/api/sistemaremi/apiUploadArchivoRespaldoMunic') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARCM'+ nombrewe +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id_m[]" value="" />'+
                                              '<input type="hidden" name="arc_munic[]" value="5" />'+
                                              '<input type="hidden" name="arc_nombre_m[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo_m[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST_m'+nombrewe+'"name="arc_estado_m[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARCM(\''+nombrewe+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger" alt="Eliminar"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARCM > tbody").append(html);
                            $('input[name=arc_nombre_ing_m]').val('');
                            $('input[name=arc_archivo_ing_m]').val('');
                          }else{
                              $.toast({
                               heading: data.title,
                               text: data.msg,
                               position: 'top-right',
                               loaderBg:'#ff6849',
                               icon: 'warning',
                               hideAfter: 3500
                             });
                          }
                    },
                    error:function(data){
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al recuperar los datos.',
                          position: 'top-right',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                      }else{
                        window.location = '/login';
                      }
                    }
          });
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });


      $(".agregarARC8").click(function () {
         var nombre = $('input[name=arc_nombre_mod]').val();
         nombre = nombre.replace(/\s/g,"_");
         //console.log("WWWW",nombre);
         var formData = new FormData($("#formUno")[0]);
         if(!$('#datosARC8').find("#ARC"+nombre).length){
            $.ajax({
                    url: "{{ url('/api/sistemaremi/apiUploadArchivoRespaldoMod') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARC'+ nombre +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id[]" value="" />'+
                                              '<input type="hidden" name="arc_nombre[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger" alt="Eliminar"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARC8 > tbody").append(html);
                            $('input[name=arc_nombre_mod]').val('');
                            $('input[name=arc_archivo_mod]').val('');
                          }else{
                              $.toast({
                               heading: data.title,
                               text: data.msg,
                               position: 'top-right',
                               loaderBg:'#ff6849',
                               icon: 'warning',
                               hideAfter: 3500
                             });
                          }
                    },
                    error:function(data){
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al recuperar los datos E001.',
                          position: 'top-right',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                      }else{
                        window.location = '/login';
                      }
                    }
          });
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });


      $(".agregarARC").click(function () {
         var nombre = $('input[name=arc_nombre_input]').val();
         nombre = nombre.replace(/\s/g,"_");

         var formData = new FormData($("#formAdd")[0]);
         if(!$('#datosARC').find("#ARC"+nombre).length){
            $.ajax({
                    url: "{{ url('/api/sistemaremi/apiUploadArchivoRespaldo') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARC'+ nombre +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id[]" value="" />'+
                                              '<input type="hidden" name="arc_nombre[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger" alt="Eliminar"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARC > tbody").append(html);
                            $('input[name=arc_nombre_input]').val('');
                            $('input[name=arc_archivo_input]').val('');
                          }else{
                              $.toast({
                               heading: data.title,
                               text: data.msg,
                               position: 'top-right',
                               loaderBg:'#ff6849',
                               icon: 'warning',
                               hideAfter: 3500
                             });
                          }
                    },
                    error:function(data){
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al recuperar los datos E002.',
                          position: 'top-right',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                      }else{
                        window.location = '/login';
                      }
                    }
          });
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });



      $("#generarExport").click(function() {
          //cantidad de datos
          var selection = $("#dataTable").jqxDataTable('getSelection');
          var optionSel = $('input:radio[name=option_data]:checked').val();
          var orden = false;//agregar configuracion de la tabla
          var direccion = 'ASC';//agregar configuracion de la tabla
          var ids = "";
          switch(optionSel) {
              case "1":
                  $('#tabledataTable > tbody > tr').each(function() {
                     ids += $(this).attr("data-key")+",";

                  });
                   console.log(ids);
                  location.href = "{{ url('/api/sistemaremi/apiExportDataindicador') }}?ids=" + ids + "&orden=" + orden + "&dir=" + direccion;
                  break;
              case "2":
                  if(selection.length > 0){
                    if (selection && selection.length > 0) {
                        var rows = $("#dataTable").jqxDataTable('getRows');
                        for (var i = 0; i < selection.length; i++) {
                            var rowData = selection[i];
                            ids += rowData.id;
                            if (i < selection.length - 1) {
                              ids += ", ";
                            }
                        }
                      location.href = "{{ url('/api/sistemaremi/apiExportDataindicador') }}?ids=" + ids + "&orden=" + orden + "&dir=" + direccion;
                    }
                  }else{
                    $.toast({
                      heading: 'Error:',
                      text: 'Seleccione algún registro de la tabla.',
                      position: 'top-right',
                      loaderBg:'#ff6849',
                      icon: 'error',
                      hideAfter: 3500
                    });
                  }
              break;
              default:
                $.toast({
                  heading: 'Error:',
                  text: 'Configure su reporte.',
                  position: 'top-right',
                  loaderBg:'#ff6849',
                  icon: 'error',
                  hideAfter: 3500
                });
              break;
          }

      });



      var ip_id = -1000;

      // $(".agregarAV").click(function () {
      //
      //   if( $("input[name=avance_fecha_input]").val() != ""){
      //
      //      var idAV = $('input[name=avance_fecha_input]').val().replace('/', '');
      //      var valor = ( $("input[name=avance_valor_input]").val() ? $("input[name=avance_valor_input]").val():0);
      //      //var explica = $("input[name=explica_avance]").val();
      //      if(!$('#set_avance').find("#AV"+idAV).length){
      //
      //         fechaAV.push($('input[name=avance_fecha_input]').val());
      //         valorAV.push(valor);
      //         //datosAV.push(explica);
      //         estadoAV.push(1);
      //         origenAV.push(1);
      //         detalleAV.push($('textarea[name="detalle_avance"]').val());
      //         actualizarListaAvance();
      //
      //     }else{
      //         $.toast({
      //          heading: 'Alerta:',
      //          text: 'Ya existe valor en la fecha reportada.',
      //          position: 'top-right',
      //          loaderBg:'#ff6849',
      //          icon: 'warning',
      //          hideAfter: 3500
      //        });
      //       }
      //   }else{
      //     $.toast({
      //      heading: 'Error:',
      //      text: 'Llene los campos para agregar avance.',
      //      position: 'top-right',
      //      loaderBg:'#ff6849',
      //      icon: 'error',
      //      hideAfter: 3500
      //    });
      //
      //   }
      // });

      $(".agregarAV").click(function () {

        if( $("input[name=avance_fecha_dia]").val() != ""){
            var idAV = $("input[name=avance_fecha_dia]").val().concat($("input[name=avance_fecha_mes]").val()).concat($("input[name=avance_fecha_anio]").val());
            var fecAV = $("input[name=avance_fecha_dia]").val().concat("/").concat($("input[name=avance_fecha_mes]").val()).concat("/").concat($("input[name=avance_fecha_anio]").val());
         }else {
            var idAV = $("input[name=avance_fecha_mes]").val().concat($("input[name=avance_fecha_anio]").val());
            var fecAV = $("input[name=avance_fecha_mes]").val().concat("/").concat($("input[name=avance_fecha_anio]").val());
         }

        if( idAV != ""){

           var valor = ( $("input[name=avance_valor_input]").val() ? $("input[name=avance_valor_input]").val():0);
           if(!$('#set_avance').find("#AV"+idAV).length){

              fechaAV.push(fecAV);
              valorAV.push(valor);
              estadoAV.push(1);
              origenAV.push(1);
              detalleAV.push($('textarea[name="detalle_avance"]').val());
              actualizarListaAvance();

          }else{
              $.toast({
               heading: 'Alerta:',
               text: 'Ya existe valor en la fecha reportada.',
               position: 'top-right',
               loaderBg:'#ff6849',
               icon: 'warning',
               hideAfter: 3500
             });
            }
        }else{
          $.toast({
           heading: 'Error:',
           text: 'Llene los campos para agregar avance.',
           position: 'top-right',
           loaderBg:'#ff6849',
           icon: 'error',
           hideAfter: 3500
         });

        }
      });


      $(".agregarRS").click(function () {

        if( $("input[name=responsable_1]").val() != ""){

              responsable1A.push($('input[name=responsable_1]').val());
              responsable2A.push($('input[name=responsable_2]').val());
              responsable3A.push($('input[name=responsable_3]').val());
              referenciaA.push($('input[name=referencia]').val());

              actualizarListaResponsable();


        }else{
          $.toast({
           heading: 'Error:',
           text: 'Llene los campos para agregar responsable.',
           position: 'top-right',
           loaderBg:'#ff6849',
           icon: 'error',
           hideAfter: 3500
         });

        }
      });


    var url = '{{ url('api/sistemaremi/apiSetIndicadores') }}';
    // prepare the data
    var source =
    {
        dataType: "json",
        dataFields: [
            { name: 'id', type: 'int' },
            { name: 'codigo_id', type: 'string' },
            { name: 'tipo', type: 'string' },
            { name: 'estado_desc', type: 'string' },
            { name: 'etapa', type: 'string' },
            { name: 'nombre', type: 'string' },
            { name: 'sectores', type: 'string' },
            { name: 'compartido', type: 'string' },
            { name: 'pdes', type: 'string' },
            { name: 'ods', type: 'string' },
            { name: 'dimension_spie', type: 'string' },
            { name: 'subdimension', type: 'string' }
        ],
        id: 'id',
        data:{'filter':'{{$filtData}}'},
        url: url
    };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#dataTable").jqxDataTable(
    {
        source: dataAdapter,
        width:"100%",
        height:"400px",
        sortable: true,
        //width:"100%",
        theme:theme,
        columnsResize: true,
        filterable: true,
        filterMode: 'simple',
        //pageable: true,
        //pagerButtonsCount: 10,
        localization: getLocalization('es'),
        rendered: function () {
          actualizar();
        },
        columns: [
          { text: 'Opciones', width: 120,
                cellsRenderer: function (row, column, value, rowData) {
                        var abm = "<div style='margin: 5px; margin-bottom: 3px;'>";
                        var inputEdit = '<a onclick="btn_update('+rowData.id+')" class="btn btn-sm btn-info" style="padding-left: 0px;padding-right: 3px;padding-top: 3px;padding-bottom: 3px;margin-right: 3px;"><i class="fa fa-pencil m-l-5"></i></a>';
                        var inputDelete = '<a onclick="btn_delete('+rowData.id+')" class="btn btn-sm btn-danger" style="padding-left: 0px;padding-right: 3px;padding-top: 3px;padding-bottom: 3px;margin-right: 3px;"><i class="fa fa-trash-o m-l-5"></i></a>';
                        var inputShow = '<a onclick="btn_mostrar('+rowData.id+')" class="btn btn-sm btn-info" style="padding-left: 0px;padding-right: 3px;padding-top: 3px;padding-bottom: 3px;"><i class="fa fa-eye m-l-5"></i></a>';
                        abm += inputEdit;
                        abm += inputDelete;
                        abm += inputShow;
                        abm += "</div>";
                        return abm;

                }
          },
          { text: 'ID_FICHA', dataField: 'codigo_id', width: 60, cellsAlign: 'left' },
          { text: 'Estado', dataField: 'estado_desc', width: 100, cellsAlign: 'center' },
          { text: 'Nombre del indicador', width: 330,dataField: 'nombre' },
          { text: 'Tipo', width: 80,dataField: 'tipo' },
          { text: 'Etapa', width: 100,dataField: 'etapa' },
          { text: 'Compartido', width: 100, dataField: 'compartido',cellsAlign: 'center' },
          { text: 'Sectores', width: 330, dataField: 'sectores',cellsAlign: 'left' },
          { text: 'PDES', width: 100, dataField: 'pdes',cellsAlign: 'left' },
          { text: 'ODS', width: 100, dataField: 'ods',cellsAlign: 'left' },
          { text: 'Dimensiones SPIE', width: 250, dataField: 'dimension_spie',cellsAlign: 'left' },
          { text: 'Subdimension SPIE', width: 300, dataField: 'subdimension',cellsAlign: 'left' }
      ]
    });

    $("#dataTable").on('filter', function (event) {
        var args = event.args;
        var filters = args.filters;
        if(filters==""){
          var visibleRows = $("#dataTable").jqxDataTable('getRows');
          var count = visibleRows.length;
          $('#total_registros').html(count);
        }
    });



    $(".ctrl-btn").click(function () {
      var activo = $(this).attr('href');
      var next =  activo.substr(-1,1) ;
    //  if(next == 6){
        //$("#bt_siguiente").addClass('hidden');
        $("#bt_siguiente").removeClass('hidden');
        $("#bt_guardar").removeClass('hidden');
   /*   }else{
        $("#bt_siguiente").removeClass('hidden');
        $("#bt_guardar").addClass('hidden');
      }  */
    });


    $(".tap-btn").click(function () {
      var activo = $(".nav-item a.active").attr('href');

      var next =  activo.substr(-1,1) ;
      next++;
      $('input[name="tap_next"]').attr("value",next);
      if(next == 6){
        $("#bt_siguiente").addClass('hidden');
        $("#bt_guardar").removeClass('hidden');
      }
      $("#tab-ini"+next).removeClass('disabled');
      $("#tab-ini"+next ).trigger( "click" );

    });


    function createElements() {
         $('#window').jqxWindow({
             resizable: false,
             isModal: true,
             autoOpen: false,
             width: '40%',
             height: '35%',
             minWidth: 330,
             minHeight: '10%',
             //cancelButton: $("#Cancel"),
             modalOpacity: 0.01,
             draggable: true
         });
         $('#window').jqxWindow('focus');
     }
     createElements();




     $("#fuente_datos").change(function () {
         $("#datosFDN").html('');
         $.ajax({
               url: "{{ url('/api/sistemaremi/apiSetFuenteDatos') }}",
               data: { 'fuente': $(this).val()},
               type: "get",
               dataType: 'json',
               success: function(date){
                 $.each(date.item, function(i, data) {
                     var html= '<div class="row">'+
                                     '<div class="media row col-lg-12 ">'+
                                         '<div class="row col-lg-12">'+
                                              '<h5>&nbsp;&nbsp;&nbsp;&nbsp;Detalle de la fuente de datos seleccionado(s)</h5>'+
                                              '<hr/>'+
                                              '<div class="col-12" style="font-size:20px"><b>Nombre:</b> '+data.nombre+' ('+data.acronimo+')</div>'+
                                              '<div class="col-6"><b>Tipo:</b> '+data.tipo+'</div>'+
                                              '<div class="col-6"><b>Periodicidad:</b> '+data.periodicidad+'.</div>'+
                                              '<div class="col-6"><b>Serie de datos:</b> '+data.serie_datos+'.</div>'+
                                              '<div class="col-6"><b>Cobertura geográfica:</b>'+data.cobertura_geografica+'</div>'+
                                              '<div class="col-6"><b>Principales variables:</b> '+data.variable+'.</div>'+
                                              '<div class="col-6"><b>Nivel de representatividad de datos:</b> '+data.nivel_representatividad_datos+'</div>'+
                                              '<div class="col-12"><b>Observaciones:</b> '+data.observacion+'.</div>'+
                                        '</div>'+
                                    '</div>'+
                                 '</div>';
                     $("#datosFDN").append(html);
                 });

               },
               error:function(data){
                 if(data.status != 401){
                   console.log("no se recupero nada");
                 }else{
                   window.location = '/login';
                 }
               }
         });
     });


     $("#fuente_datos_d").change(function () {
         $("#datosFDD").html('');
         $.ajax({
               url: "{{ url('/api/sistemaremi/apiSetFuenteDatos') }}",
               data: { 'fuente': $(this).val()},
               type: "get",
               dataType: 'json',
               success: function(date){
                 $.each(date.item, function(i, data) {
                     var html= '<div class="row">'+
                                     '<div class="media row col-lg-12 ">'+
                                         '<div class="row col-lg-12">'+
                                              '<h5>&nbsp;&nbsp;&nbsp;&nbsp;Detalle de la fuente de datos seleccionado(s)</h5>'+
                                              '<hr/>'+
                                              '<div class="col-12" style="font-size:20px"><b>Nombre:</b> '+data.nombre+' ('+data.acronimo+')</div>'+
                                              '<div class="col-6"><b>Tipo:</b> '+data.tipo+'</div>'+
                                              '<div class="col-6"><b>Periodicidad:</b> '+data.periodicidad+'.</div>'+
                                              '<div class="col-6"><b>Serie de datos:</b> '+data.serie_datos+'.</div>'+
                                              '<div class="col-6"><b>Cobertura geográfica:</b>'+data.cobertura_geografica+'</div>'+
                                              '<div class="col-6"><b>Principales variables:</b> '+data.variable+'.</div>'+
                                              '<div class="col-6"><b>Nivel de representatividad de datos:</b> '+data.nivel_representatividad_datos+'</div>'+
                                              '<div class="col-12"><b>Observaciones:</b> '+data.observacion+'.</div>'+
                                        '</div>'+
                                    '</div>'+
                                 '</div>';
                     $("#datosFDD").append(html);
                 });

               },
               error:function(data){
                 if(data.status != 401){
                   console.log("no se recupero nada");
                 }else{
                   window.location = '/login';
                 }
               }
         });
     });


    });
    //fin document
    function actualizarListaAvance(){
      var cav= 1;
      $("#set_avance > tbody").html("");
      $.ajax({
            url: "{{ url('/api/sistemaremi/apiSourceOrderbyArray') }}",
            type: "GET",
            dataType: 'json',
            data:{'fechas':fechaAV,'valores':valorAV,'estados':estadoAV},
            success: function(date){
                  if(date.error == false){
                      $.each(date.item, function(i, data) {
                        if(estadoAV[data.index]==1){
                            var html = '<tr id="AV'+ data.valor.replace('/', '') +'">'+
                                           '<td>'+
                                               '<input type="hidden" name="id_avance[]" value="'+ (idAV[data.index] ? idAV[data.index] : "") +'" /><input type="hidden" id="AVEST'+data.valor.replace('/', '')+'" name="avance_estado[]" value="1" />'+cav+
                                            '</td>'+
                                           '<td>'+
                                              '<input type="hidden" name="avance_fecha[]" value="'+ data.valor +'" />'+
                                               data.valor+
                                            '</td>'+
                                            '<td>'+
                                              '<input type="hidden" name="avance_valor[]" value="'+ valorAV[data.index]+'" />'+
                                               valorAV[data.index]+
                                            '</td>'+
                                            '<td>'+
                                              '<input type="hidden" name="avance_detalle[]" value="'+ detalleAV[data.index]+'" />'+
                                               detalleAV[data.index]+
                                            '</td>'+
                                            // '<td>'+
                                            //   "ddfdsf dfsdf dfs sdfs fasff"+
                                            // '</td>'+
                                            '<td>'+'<center>'+
                                              '<a data-toggle="tooltip" data-original-title="Borrar" onclick="quitarAV(\''+ data.valor.replace('/', '')+'\','+origenAV[data.index]+','+data.index+');" style="cursor: pointer;"> <i class="fa fa-close text-danger"></i> </a>'+
                                            '</center>'+'</td>'+
                                      '</tr>';
                            $("#set_avance > tbody").append(html);
                            cav++;
                          }else{
                            var html = '<tr id="0AV'+ data.valor.replace('/', '') +'" class="hidden">'+
                                            '<td>'+
                                               '<input type="hidden" name="id_avance[]" value="'+ (idAV[data.index] ? idAV[data.index] : "") +'" /><input type="hidden" id="AVEST'+data.valor.replace('/', '')+'" name="avance_estado[]" value="0" />'+cav+
                                            '</td>'+
                                             '<td>'+
                                              '<input type="hidden" name="avance_fecha[]" value="'+ data.valor +'" />'+
                                               data.valor+
                                            '</td>'+
                                             '<td>'+
                                              '<input type="hidden" name="avance_valor[]" value="'+ valorAV[data.index]+'" />'+
                                               valorAV[data.index]+
                                            '</td>'+
                                            '<td>'+
                                             '<input type="hidden" name="avance_detalle[]" value="'+ detalleAV[data.index]+'" />'+
                                              detalleAV[data.index]+
                                           '</td>'+
                                            //  '<td>'+
                                            //   'ddfdsf dfsdf dfs sdfs fasff'+
                                            // '</td>'+
                                             '<td>'+'<center>'+
                                              '<a data-toggle="tooltip" data-original-title="Borrar" onclick="quitarAV(\''+ data.valor.replace('/', '')+'\','+origenAV[data.index]+','+data.index+');"> <i class="fa fa-close text-danger"></i> </a>'+
                                            '</center>'+'</td>'+
                                      '</tr>';
                            $("#set_avance > tbody").append(html);
                          }

                     });

               }
            },
            error:function(data){
              alert("Error recuperar los datos. E003");
            }
      });



    }

    function actualizarListaResponsable(){
      var cav= 1;
      $("#set_responsables > tbody").html("");

      $.ajax({
            url: "{{ url('/api/sistemaremi/apiSourceOrderbyArray2') }}",
            type: "GET",
            dataType: 'json',
            data:{'responsable1':responsable1A,'responsable2':responsable2A,'responsable3':responsable3A,'referencia':referenciaA},
            success: function(date){
                  if(date.error == false){
                      $.each(date.item, function(i, data) {
                            var html = '<tr id="RS'+cav+'">'+
                                            '<td style="width: 5%;">'+
                                               cav+
                                            '</td>'+
                                            '<td style="width: 90%;">'+
                                                 '<input type="hidden" name="responsable_nivel_1[]" value="'+ responsable1A[data.index] +'" />'+
                                                 '<input type="hidden" name="responsable_nivel_2[]" value="'+ responsable2A[data.index] +'" />'+
                                                 '<input type="hidden" name="responsable_nivel_3[]" value="'+ responsable3A[data.index] +'" />'+
                                                 '<input type="hidden" name="numero_referencia[]" value="'+ referenciaA[data.index] +'" />'+
                                                 '<b>Entidad Cabeza:</b> '+responsable1A[data.index]+'<br/>'+
                                                 '<b>Sub entidad:</b> '+ responsable2A[data.index]+'<br/>'+
                                                 '<b>Sub entidad:</b> '+ responsable3A[data.index] +'<br/>'+
                                                 '<b>Número referencia:</b> '+ referenciaA[data.index]+
                                            '</td>'+
                                            '<td style="width: 5%;">'+
                                              '<a data-toggle="tooltip" data-original-title="Borrar" onclick="quitarRS('+cav+','+data.index+');" style="cursor: pointer;"> <i class="fa fa-close text-danger"></i> </a>'+
                                            '</td>'+
                                      '</tr>';
                            $("#set_responsables > tbody").append(html);
                            cav++;
                     });
                    $("#cont_resp").html(cav-1);
               }else{
                 $("#cont_resp").html(0);
               }
            },
            error:function(data){
              alert("Error recuperar los datos. E004");
            }
      });



    }
    function quitarART(ele,tipo){
        if(tipo == 1){
          $('#ART'+ele).remove();
        }else{
          $('#ART'+ele).addClass('hidden');
          $('#EST'+ele).val(0);
          $('#ART'+ele).attr("id",'0ART'+ele);
        }

    }

    function quitarART1(ele,tipo){
      //console.log("DFSFSD",ele);
        if(tipo == 1){
          $('#ART1'+ele).remove();
        }else{
          $('#ART1'+ele).addClass('hidden');
          $('#EST1'+ele).val(0);
          $('#ART1'+ele).attr("id",'0ART1'+ele);
        }

    }

    function quitarAV(ele,tipo,index){

        if(tipo == 1){
          $('#AV'+ele).remove();
          fechaAV.splice(index, 1);
          valorAV.splice(index, 1);
          estadoAV.splice(index, 1);
          origenAV.splice(index, 1);
          detalleAV.splice(index, 1);
        }else{
          estadoAV[index] = 0;
        }

        actualizarListaAvance();
    }
    function quitarRS(ele,index){


          $('#RS'+ele).remove();
          responsable1A.splice(index, 1);
          responsable2A.splice(index, 1);
          responsable3A.splice(index, 1);
          referenciaA.splice(index, 1);

        actualizarListaResponsable();
    }

    function quitarARC(ele,archivo,tipo){
      var res = confirm("Esta seguro de quitar el archivo?");
          if (res == true) {
            if(tipo == 1){
                 $.ajax({
                       type: "GET",
                       dataType: 'json',
                       url: "{{ url('/api/sistemaremi/apiDeleteArchivo') }}",
                       data: {archivo: archivo},
                       success: function(data){
                           $('#ARC'+ele).remove();
                       },
                       error:function(data){
                         if(data.status != 401){
                           alert("Error recuperar al eliminar.");
                         }else{
                           window.location = '/login';
                         }
                       }
                   });
            }else{
              $('#ARC'+ele).addClass('hidden');
              $('#EST'+ele).val(0);
              $('#ARC'+ele).attr("id",'0ARC'+ele);
            }
        }

    }


    function quitarARCS(ele,archivo,tipo){
    //dd("cdsdv",ele);
    var res = confirm("Esta seguro de quitar el archivo?");
        if (res == true) {
          if(tipo == 1){
               $.ajax({
                     type: "GET",
                     dataType: 'json',
                     url: "{{ url('/api/sistemaremi/apiDeleteArchivo_s') }}",
                     data: {archivo: archivo},
                     success: function(data){
                         $('#ARCS'+ele).remove();
                     },
                     error:function(data){
                       if(data.status != 401){
                         alert("Error recuperar al eliminar.");
                       }else{
                         window.location = '/login';
                       }
                     }
                 });
          }else{
            $('#ARCS'+ele).addClass('hidden');
            $('#EST_s'+ele).val(0);
            $('#ARCS'+ele).attr("id",'0ARCS'+ele);
          }
      }

  }

  function quitarARCE(ele,archivo,tipo){
    //dd("cdsdv",ele);
    var res = confirm("Esta seguro de quitar el archivo?");
        if (res == true) {
          if(tipo == 1){
               $.ajax({
                     type: "GET",
                     dataType: 'json',
                     url: "{{ url('/api/sistemaremi/apiDeleteArchivo_e') }}",
                     data: {archivo: archivo},
                     success: function(data){
                         $('#ARCE'+ele).remove();
                     },
                     error:function(data){
                       if(data.status != 401){
                         alert("Error recuperar al eliminar.");
                       }else{
                         window.location = '/login';
                       }
                     }
                 });
          }else{
            $('#ARCE'+ele).addClass('hidden');
            $('#EST_e'+ele).val(0);
            $('#ARCE'+ele).attr("id",'0ARCE'+ele);
          }
      }

  }

  function quitarARCN(ele,archivo,tipo){
    //dd("cdsdv",ele);
    var res = confirm("Esta seguro de quitar el archivo?");
        if (res == true) {
          if(tipo == 1){
               $.ajax({
                     type: "GET",
                     dataType: 'json',
                     url: "{{ url('/api/sistemaremi/apiDeleteArchivo_n') }}",
                     data: {archivo: archivo},
                     success: function(data){
                         $('#ARCN'+ele).remove();
                     },
                     error:function(data){
                       if(data.status != 401){
                         alert("Error recuperar al eliminar.");
                       }else{
                         window.location = '/login';
                       }
                     }
                 });
          }else{
            $('#ARCN'+ele).addClass('hidden');
            $('#EST_n'+ele).val(0);
            $('#ARCN'+ele).attr("id",'0ARCN'+ele);
          }
      }

  }


  function quitarARCD(ele,archivo,tipo){
    //dd("cdsdv",ele);
    alert(ele);
    var res = confirm("Esta seguro de quitar el archivo?");
        if (res == true) {
          if(tipo == 1){
               $.ajax({
                     type: "GET",
                     dataType: 'json',
                     url: "{{ url('/api/sistemaremi/apiDeleteArchivo_d') }}",
                     data: {archivo: archivo},
                     success: function(data){
                         $('#ARCD'+ele).remove();
                     },
                     error:function(data){
                       if(data.status != 401){
                         alert("Error recuperar al eliminar.");
                       }else{
                         window.location = '/login';
                       }
                     }
                 });
          }else{
            $('#ARCD'+ele).addClass('hidden');
            $('#EST_d'+ele).val(0);
            $('#ARCD'+ele).attr("id",'0ARCD'+ele);
          }
      }

  }


  function quitarARCM(ele,archivo,tipo){
    //dd("cdsdv",ele);
    var res = confirm("Esta seguro de quitar el archivo?");
        if (res == true) {
          if(tipo == 1){
               $.ajax({
                     type: "GET",
                     dataType: 'json',
                     url: "{{ url('/api/sistemaremi/apiDeleteArchivo_m') }}",
                     data: {archivo: archivo},
                     success: function(data){
                         $('#ARCM'+ele).remove();
                     },
                     error:function(data){
                       if(data.status != 401){
                         alert("Error recuperar al eliminar.");
                       }else{
                         window.location = '/login';
                       }
                     }
                 });
          }else{
            $('#ARCM'+ele).addClass('hidden');
            $('#EST_m'+ele).val(0);
            $('#ARCM'+ele).attr("id",'0ARCM'+ele);
          }
      }

  }


    function editarI(ele){
       alert(ele);
    }

    function deleteI(ele){
       alert(ele);
    }

    $('#btn-back, .btn-back').click(function() {
       $("#etapaDesc").html("");
       $("#nombreDesc").html("");
       $("#estado_indicadorDesc").html("");
       $('#option1').removeClass('hidden');
       //$('#nivel_1').addClass('show');
       $('#option2').removeClass('show');
       $('#option2').addClass('hidden');

       $("#formAdd")[0].reset();
       $("#formAddFuente")[0].reset();
       $('.with-errors').html('');
       $('.form-group').removeClass('has-error');
       //$("#variables_desagregacion").val('').trigger('change');
       $("#datosART").html("");
       $("#datosART1").html("");
       $("#fuente_datos").val('').trigger('change');
       $("#fuente_datos_d").val('').trigger('change');
       $("#fd_cobertura_geografica").val('').trigger('change');
       $("#sectores").val('').trigger('change');
       //$("#fd_variable").val('').trigger('change');
       $("#cont_resp").html(0);
       $("#datosFDN").html("");
       $("#datosFDD").html("");
       $("#datosTEC").html("");
       fechaAV = [];
       valorAV = [];
       estadoAV = [];
       origenAV = [];
       detalleAV = [];
       responsable1A = [];
       responsable2A = [];
       responsable3A = [];
       referenciaA = [];
       idAV = [];
       $("#set_avance > tbody").html("");
       $("#datosARC > tbody").html("");
       $("#datosARCS > tbody").html("");
       $("#datosARCED > tbody").html("");
       $("#datosARCN > tbody").html("");
       $("#datosARCD > tbody").html("");
       $("#datosARCM > tbody").html("");
       $("#set_responsables > tbody").html("");
       $('input[name="id_indicador"]').val(null);
       $("#tab-ini1" ).trigger( "click" );

       $("#cod2").hide();
       $("#cod").hide();
       $("#cod5").hide();
       $("#cod_sexo").hide();
       $("#cod_edad").hide();
       $("#cod_nac").hide();
       $("#cod_deptal").hide();
       $("#cod_munic").hide();
       $('#customSwitch9').prop("checked",true);
    });
//------------------aqui
    function limpiarBasico(){
      $("#formAdd")[0].reset();
       $("#datosART").html("");
       $("#datosART1").html("");
       $("#datosTEC").html("");
       //$("#fuente_datos").val('').trigger('change');
       //$("#fuente_datos_d").val('').trigger('change');
       //$("#fd_cobertura_geografica").val('').trigger('change');


       $("#cont_resp").html(0);
       $("#datosFDN").html("");
       $("#datosFDD").html("");
       fechaAV = [];
       valorAV = [];
       estadoAV = [];
       origenAV = [];
       detalleAV = [];
       responsable1A = [];
       responsable2A = [];
       responsable3A = [];
       referenciaA = [];
       idAV = [];
       $("#set_avance > tbody").html("");
       $("#datosARC > tbody").html("");
       $("#datosARCS > tbody").html("");
       $("#datosARCED > tbody").html("");
       $("#datosARCN > tbody").html("");
       $("#datosARCD > tbody").html("");
       $("#datosARCM > tbody").html("");
       $("#set_responsables > tbody").html("");

       $("#cod2").hide();
       $("#cod").hide();
       $("#cod5").hide();
       $("#cod_sexo").hide();
       $("#cod_edad").hide();
       $("#cod_nac").hide();
       $("#cod_deptal").hide();
       $("#cod_munic").hide();
       $('#customSwitch9').prop("checked",true);


    }//------------------aqui fin


    $('#btn-new, .btn-new ').click(function() {
       $('#option2').removeClass('hidden');
       $('#option1').removeClass('show');
       $('#option1').addClass('hidden');
       $('#tab-ini2').addClass('disabled'); // desactiva boton de formulario
       $('#tab-ini3').addClass('disabled');
       $('#tab-ini4').addClass('disabled');
       $('#tab-ini5').addClass('disabled');
       $('#tab-ini6').addClass('disabled');

    });

    function agregarSexo() {


    }

    function btn_update(ele) {
      $("#btn-new" ).trigger( "click" );
       $.ajax({
             url: "{{ url('/api/sistemaremi/apiDataSetIndicador') }}",
             type: "GET",
             dataType: 'json',
             data:{'id':ele},
             success: function(data){
               if(data.error == false){
                    for(var i=1;i<data.indicador[0].form_activo+1;i++){
                        $('#tab-ini'+i).removeClass('disabled');
                    }

                  //------------------aqui
                    if(data.indicador[0].etapa){
                      var html= data.indicador[0].etapa+' - '+data.descripcion_etapa;
                      $("#etapaDesc").html(html);
                    }


                    var html= (data.indicador[0].nombre)?data.indicador[0].nombre:"";
                    $("#nombreDesc").html(html);


                    var html= data.indicador[0].unidad_medida;
                     $(".unidad_medidaDesc").html(html);

                    //------------------aqui fin

                   $('input[name="id_indicador"]').val(data.indicador[0].id);
                   $('input[name="estado"]').val(data.indicador[0].id);
                   //$('input[name="nombrev"]').val(data.indicador[0].nombre);
                   $('input[name="nombre"]').val(data.indicador[0].nombre);
                   $('textarea[name="definicion"]').val(data.indicador[0].definicion);
                   $('select[name=estado_indicador]').val(data.indicador[0].estado);
                   $("#estado_indicadorDesc").html($('select[name=estado_indicador] option:selected').text());
                   $('select[name=etapa]').val(data.indicador[0].etapa);
                   $('select[name=tipo]').val(data.indicador[0].tipo);
                   $('select[name=unidad_medida]').val(data.indicador[0].unidad_medida);
                   $('select[name=frecuencia]').val(data.indicador[0].frecuencia);

                   if(data.indicador[0].desagregacion_sexo==true){
                     $('#desagregacion_sexo').prop("checked",true);
                     $('#chkCodeudor2').prop("checked",false);
                     $("#cod_sexo").show();
                  }else {
                     $('#chkCodeudor2').prop("checked",false);
                     $("#cod_sexo").hide();
                  }

                  if(data.indicador[0].desagregacion_edad==true){
                     $('#desagregacion_edad').prop("checked",true);
                      $('#chkCodeudor3').prop("checked",false);
                      $("#cod_edad").show();
                  }else {
                     $('#chkCodeudor3').prop("checked",false);
                     $("#cod_edad").hide();
                  }

                  if(data.indicador[0].desagregacion_nac==true){
                     $('#desagregacion_nac').prop("checked",true);
                     $('#chkCodeudor4').prop("checked",false);
                     $("#cod_nac").show();
                  }else{
                     $('#chkCodeudor4').prop("checked",false);
                     $("#cod_nac").hide();
                  }

                  if(data.indicador[0].desagregacion_deptal==true){
                     $('#desagregacion_deptal').prop("checked",true);
                     $('#chkCodeudor5').prop("checked",false);
                     $("#cod_deptal").show();
                  }else{
                     $('#chkCodeudor5').prop("checked",false);
                     $("#cod_deptal").hide();
                  }

                  if(data.indicador[0].desagregacion_munic==true){
                     $('#desagregacion_munic').prop("checked",true);
                     $('#chkCodeudor6').prop("checked",false);
                     $("#cod_munic").show();
                  }else {
                     $('#chkCodeudor6').prop("checked",false);
                     $("#cod_munic").hide();
                  }





                   $('select[name=brecha_datos]').val(data.indicador[0].brecha_datos);
                   $('select[name=brecha_metodologia]').val(data.indicador[0].brecha_metodologia);
                   $('select[name=brecha_capacitacion]').val(data.indicador[0].brecha_capacitacion);
                   $('select[name=brecha_financiamiento]').val(data.indicador[0].brecha_financiamiento);
                   /*if(data.indicador[0].variables_desagregacion){
                     $("#variables_desagregacion").val(data.indicador[0].variables_desagregacion.split(",")).trigger('change');
                   }*/
                   $('textarea[name="variables_desagregacion"]').val(data.indicador[0].variables_desagregacion);
                   if(data.indicador[0].linea_base_dia>0 || data.indicador[0].linea_base_dia==null){
                      $('input[name="base_linea_dia"]').val(data.indicador[0].linea_base_dia);
                    }
                    if(data.indicador[0].linea_base_mes>0 || data.indicador[0].linea_base_mes==null){
                        $('input[name="base_linea_mes"]').val(data.indicador[0].linea_base_mes);
                    }
                    if(data.indicador[0].linea_base_anio>0 || data.indicador[0].linea_base_anio==null){
                        $('input[name="base_linea_anio"]').val(data.indicador[0].linea_base_anio);
                    }
                   // if(data.indicador[0].linea_base_mes){
                   //   $('input[name="linea_base_fecha"]').val(data.indicador[0].linea_base_dia+'/'+data.indicador[0].linea_base_mes+'/'+data.indicador[0].linea_base_anio);
                   // }


                   $('input[name="linea_base_valor"]').val(data.indicador[0].linea_base_valor);
                   $('input[name="plazo_anios"]').val(data.indicador[0].plazo_anios);
                   $('textarea[name="formula"]').val(data.indicador[0].formula);
                   $('textarea[name="numerador_detalle"]').val(data.indicador[0].numerador_detalle);
                   $('input[name="numerador_fuente"]').val(data.indicador[0].numerador_fuente);
                   $('textarea[name="denominador_detalle"]').val(data.indicador[0].denominador_detalle);
                   $('input[name="denominador_fuente"]').val(data.indicador[0].denominador_fuente);
                   $('input[name="serie_disponible"]').val(data.indicador[0].serie_disponible);
                   $('textarea[name="observacion"]').val(data.indicador[0].observacion);

                   if(data.indicador[0].fuente_datos){
                     $("#fuente_datos").val(data.indicador[0].fuente_datos.split(",")).trigger('change');
                   }

                   if(data.indicador[0].fuente_datos_d){
                     $("#fuente_datos_d").val(data.indicador[0].fuente_datos_d.split(",")).trigger('change');
                   }

                   if(data.sectores){
                     $("#sectores").val(data.sectores.split(",")).trigger('change');
                   }

                  $.each(data.pdes, function(i, data) {
                   var html = //'<h5>Detalle de Articulación</h5>'+'<hr/>'+
                               '<div id="ART'+data.cod_p+data.cod_m+data.cod_r+'" class="row">'+
                                 '<div class="media row col-lg-12 ">'+
                                     '<div class="col-lg-2 text-center">'+
                                         '<img src="/img/'+data.logo+'" alt="Pliar" width="100">'+
                                         '<a class="btn btn-block btn-info btn-sm m-t-10" onclick="quitarART('+data.cod_p+data.cod_m+data.cod_r+',2);">Quitar</a>'+
                                     '</div>'+
                                     '<div class="row col-lg-10">'+
                                         '<input type="hidden" name="id_resultado_articulado[]" value="'+data.id+'" />'+
                                         '<input type="hidden" name="resultado_articulado[]" value="'+data.id_resultado+'" />'+
                                         '<input type="hidden" id="EST'+data.cod_p+data.cod_m+data.cod_r+'" name="estado_resultado_articulado[]" value="1" />'+
                                         '<div class="col-12"><b>'+data.pilar+':</b> '+data.desc_p+
                                         '</div>'+
                                         '<div class="col-12"><b>'+data.meta+':</b> '+data.desc_m+
                                         '</div>'+
                                         '<div class="col-12"><b>'+data.resultado+':</b> '+data.desc_r+
                                         '</div>'+
                                     '</div>'+
                                 '</div>'+
                               '</div>';
                   $("#datosART").append(html);
                  });

                  $.each(data.ods, function(i, data) {
                   var html = //'<h5>Detalle de Articulación</h5>'+'<hr/>'+
                               '<div id="ART1'+data.cod_o+data.cod_m+data.cod_i+'" class="row">'+
                                 '<div class="media row col-lg-12 ">'+
                                     '<div class="col-lg-2 text-center">'+
                                         '<img src="/img/'+data.logo+'" alt="ODS" width="100">'+
                                         '<a class="btn btn-block btn-info btn-sm m-t-10" onclick="quitarART1(\''+data.cod_o+data.cod_m+data.cod_i+'\',2);">sQuitar</a>'+
                                     '</div>'+
                                     '<div class="row col-lg-10">'+
                                         '<input type="hidden" name="id_resultado_articuladods[]" value="'+data.id+'" />'+
                                         '<input type="hidden" name="resultado_articuladods[]" value="'+data.id_indicador+'" />'+
                                         '<input type="hidden" id="EST1'+data.cod_o+data.cod_m+data.cod_i+'" name="estado_resultado_articuladods[]" value="1" />'+
                                         '<div class="col-12"><b>Comparabilidad: </b> '+data.comparabilidad_ods_pdes+
                                         '</div>'+
                                         '<div class="col-12"><b>'+data.objetivo+':</b> '+data.desc_o+
                                         '</div>'+
                                         '<div class="col-12"><b>'+data.meta+':</b> '+data.desc_m+
                                         '</div>'+
                                         '<div class="col-12"><b>'+data.indicador+':</b> '+data.desc_i+
                                         '</div>'+
                                     '</div>'+
                                 '</div>'+
                               '</div>';
                   $("#datosART1").append(html);
                  });


                  $.each(data.metas, function(i, data) {
                     $('input[name="id_meta_'+data.gestion+'"]').val(data.id);
                     $('input[name="meta_'+data.gestion+'"]').val(data.valor);
                  });


                  // $.each(data.avances, function(i, data) {
                  //     fechaAV.push(data.fecha_generado_mes+'/'+data.fecha_generado_anio);
                  //     valorAV.push(data.valor);
                  //     estadoAV.push(1);
                  //     origenAV.push(2);
                  //     detalleAV.push((data.detalle_avance)?data.detalle_avance:'');
                  //     idAV.push(data.id);
                  // });

                  $.each(data.avances, function(i, data) {
                    if(data.avance_fecha_tam==7){
                      fechaAV.push(data.fecha_generado_mes+'/'+data.fecha_generado_anio);
                      valorAV.push(data.valor);
                      estadoAV.push(1);
                      origenAV.push(2);
                      detalleAV.push((data.detalle_avance)?data.detalle_avance:'');
                      idAV.push(data.id);
                    }else{
                      fechaAV.push(data.fecha_generado_dia+'/'+data.fecha_generado_mes+'/'+data.fecha_generado_anio);
                      valorAV.push(data.valor);
                      estadoAV.push(1);
                      origenAV.push(2);
                      detalleAV.push((data.detalle_avance)?data.detalle_avance:'');
                      idAV.push(data.id);
                    }
                  });
                  setTimeout(function(){
                      actualizarListaAvance();
                  }, 2000);



                  $.each(data.archivos, function(i, data) {
                      var nombre = data.nombre.replace(/\s/g,"_");
                      var html = '<tr id="ARC'+ nombre +'" class="">'+
                                      '<td>'+
                                          '<input type="hidden" name="arc_id[]" value="'+data.id+'" />'+
                                          '<input type="hidden" name="arc_nombre[]" value="'+ data.nombre +'" />'+
                                          '<input type="hidden" name="arc_archivo[]" value="'+ data.archivo +'" />'+
                                          '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                          '<a href="/respaldos/'+data.archivo+'" style="cursor: pointer;">'+
                                          '<p>'+
                                            '<img src="/img/icono_indicadores/xls.png" title="Descargar Archivos respaldo "> '+
                                             data.nombre +
                                          '</p>'+
                                          '</a>'+
                                      '</td>'+
                                      '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.archivo+'\',2);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                  '</tr>';
                       $("#datosARC > tbody").append(html);
                  });

                  $.each(data.archiv_ods, function(i, data) {
                    if(data.id_variable==2){
                      var nombre = data.nombre.replace(/\s/g,"_");
                      var html2 = '<tr id="ARCS'+ nombre +'" class="">'+
                                      '<td>'+
                                          '<input type="hidden" name="arc_id_s[]" value="'+data.id+'" />'+
                                          '<input type="hidden" name="arc_sexo[]" value="2" />'+
                                          '<input type="hidden" name="arc_nombre_s[]" value="'+ data.nombre +'" />'+
                                          '<input type="hidden" name="arc_archivo_s[]" value="'+ data.archivo +'" />'+
                                          '<input type="hidden" id="EST_s'+nombre+'"name="arc_estado_s[]" value="1" />'+
                                          '<a href="/respaldos/'+data.archivo+'" style="cursor: pointer;">'+
                                          '<p>'+
                                            '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                             data.nombre +
                                          '</p>'+
                                          '</a>'+
                                      '</td>'+
                                      '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARCS(\''+nombre+'\',\''+data.archivo+'\',2);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                  '</tr>';
                       $("#datosARCS > tbody").append(html2);
                       //$("#chkCodeudor2").prop('checked', true);
                     }

                  });

                  $.each(data.archiv_ods, function(i, data) {
                    if(data.id_variable==1){
                      var nombre = data.nombre.replace(/\s/g,"_");
                      var html3 = '<tr id="ARCE'+ nombre +'" class="">'+
                                      '<td>'+
                                          '<input type="hidden" name="arc_id_e[]" value="'+data.id+'" />'+
                                          '<input type="hidden" name="arc_edad[]" value="1" />'+
                                          '<input type="hidden" name="arc_nombre_e[]" value="'+ data.nombre +'" />'+
                                          '<input type="hidden" name="arc_archivo_e[]" value="'+ data.archivo +'" />'+
                                          '<input type="hidden" id="EST_e'+nombre+'"name="arc_estado_e[]" value="1" />'+
                                          '<a href="/respaldos/'+data.archivo+'" style="cursor: pointer;">'+
                                          '<p>'+
                                            '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                             data.nombre +
                                          '</p>'+
                                          '</a>'+
                                      '</td>'+
                                      '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARCE(\''+nombre+'\',\''+data.archivo+'\',2);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                  '</tr>';
                       $("#datosARCED > tbody").append(html3);
                       //$("#chkCodeudor3").prop('checked', true);
                     }

                  });

                  $.each(data.archiv_ods, function(i, data) {
                    if(data.id_variable==3){
                      var nombre = data.nombre.replace(/\s/g,"_");
                      var html3 = '<tr id="ARCN'+ nombre +'" class="">'+
                                      '<td>'+
                                          '<input type="hidden" name="arc_id_n[]" value="'+data.id+'" />'+
                                          '<input type="hidden" name="arc_nac[]" value="3" />'+
                                          '<input type="hidden" name="arc_nombre_n[]" value="'+ data.nombre +'" />'+
                                          '<input type="hidden" name="arc_archivo_n[]" value="'+ data.archivo +'" />'+
                                          '<input type="hidden" id="EST_n'+nombre+'"name="arc_estado_n[]" value="1" />'+
                                          '<a href="/respaldos/'+data.archivo+'" style="cursor: pointer;">'+
                                          '<p>'+
                                            '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                             data.nombre +
                                          '</p>'+
                                          '</a>'+
                                      '</td>'+
                                      '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARCN(\''+nombre+'\',\''+data.archivo+'\',2);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                  '</tr>';
                       $("#datosARCN > tbody").append(html3);
                       //$("#chkCodeudor4").prop('checked', true);
                     }

                  });


                 $.each(data.archiv_ods, function(i, data) {
                    if(data.id_variable==4){
                      var nombre = data.nombre.replace(/\s/g,"_");
                      var html3 = '<tr id="ARCD'+ nombre +'" class="">'+
                                      '<td>'+
                                          '<input type="hidden" name="arc_id_d[]" value="'+data.id+'" />'+
                                          '<input type="hidden" name="arc_dptal[]" value="4" />'+
                                          '<input type="hidden" name="arc_nombre_d[]" value="'+ data.nombre +'" />'+
                                          '<input type="hidden" name="arc_archivo_d[]" value="'+ data.archivo +'" />'+
                                          '<input type="hidden" id="EST_d'+nombre+'"name="arc_estado_d[]" value="1" />'+
                                          '<a href="/respaldos/'+data.archivo+'" style="cursor: pointer;">'+
                                          '<p>'+
                                            '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                             data.nombre +
                                          '</p>'+
                                          '</a>'+
                                      '</td>'+
                                      '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARCD(\''+nombre+'\',\''+data.archivo+'\',2);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                  '</tr>';
                       $("#datosARCD > tbody").append(html3);
                      // $("#chkCodeudor5").prop('checked', true);
                     }

                  });


                 $.each(data.archiv_ods, function(i, data) {
                    if(data.id_variable==5){
                      var nombre = data.nombre.replace(/\s/g,"_");
                      var html3 = '<tr id="ARCM'+ nombre +'" class="">'+
                                      '<td>'+
                                          '<input type="hidden" name="arc_id_m[]" value="'+data.id+'" />'+
                                          '<input type="hidden" name="arc_munic[]" value="5" />'+
                                          '<input type="hidden" name="arc_nombre_m[]" value="'+ data.nombre +'" />'+
                                          '<input type="hidden" name="arc_archivo_m[]" value="'+ data.archivo +'" />'+
                                          '<input type="hidden" id="EST_m'+nombre+'"name="arc_estado_m[]" value="1" />'+
                                          '<a href="/respaldos/'+data.archivo+'" style="cursor: pointer;">'+
                                          '<p>'+
                                            '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                             data.nombre +
                                          '</p>'+
                                          '</a>'+
                                      '</td>'+
                                      '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARCM(\''+nombre+'\',\''+data.archivo+'\',2);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                  '</tr>';
                       $("#datosARCM > tbody").append(html3);
                       //$("#chkCodeudor6").prop('checked', true);
                     }

                  });
                  if(data.indicador[0].asistencia_tec!==null){
                      $('#customSwitch10').prop("checked",true);
                      var html =  '<textarea id="asistencia" name="asistencia" required class="form-control"'+
                                  'placeholder="Describa la Asistencia Técnica" rows="7" style="width:100%;">'+data.indicador[0].asistencia_tec+'</textarea>'+
                                  '<div class="help-block with-errors"></div>';
                      // $('textarea[name="asistencia"]').val();
                      $("#datosTEC").html(html);
                      $('#customSwitch9').prop("checked",false);
                   }else{
                      $('#customSwitch10').prop("checked",false);
                      $('#customSwitch9').prop("checked",true);
                   }



               }else{
                   $.toast({
                    heading: data.title,
                    text: data.msg,
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'warning',
                    hideAfter: 3500
                  });
               }
             },
             error:function(data){
               if(data.status != 401){
                 $.toast({
                   heading: 'Error:',
                   text: 'Error al recuperar los datos 1111.',
                   position: 'top-right',
                   loaderBg:'#ff6849',
                   icon: 'error',
                   hideAfter: 3500
                 });
               }else{
                 window.location = '/login';
               }
             }
       });

    }

    function btn_delete(ele) {
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
                   url: "{{ url('/api/sistemaremi/apiDeleteIndicador') }}",
                   data: { '_token': $('input[name=_token]').val(),'id_indicador': ele },
                   type: "delete",
                   dataType: 'json',
                   success: function(date){
                       $("#dataTable").jqxDataTable("updateBoundData");
                       swal("Eliminado!", "Se ha eliminado tu registro.", "success");
                   },
                   error:function(data){
                     if(data.status != 401){
                       alert("Error recuperar los datos. E005");
                     }else{
                       window.location = '/login';
                     }

                   }
             });
        });
    }


    function save(){
      swal({
        title: "Guardar?",
        text: "Se completo el llenado de los datos solicitados!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Guardar!",
        closeOnConfirm: false
      },function(){
            $.ajax({
                  type: "POST",
                  url: "{{ url('/api/sistemaremi/apiSaveIndicador') }}",
                  dataType: 'json',
                  data: $("#formAdd").serialize() , // Adjuntar los campos del formulario enviado.
                  success: function(data){
                    if(data.error == false){

                        //------------------aqui
                        limpiarBasico();
                        $('input[name="id_indicador"]').attr("value",data.id_indicador);
                        var tap_next=0;
                        // $("#btn-back" ).trigger( "click" );
                        $("#dataTable").jqxDataTable("updateBoundData");
                        btn_update(data.id_indicador);
                        swal("Guardado!", "Se ha guardado correctamente.", "success");
                        //------------------aqui fin
                    }else{
                        $.toast({
                         heading: data.title,
                         text: data.msg,
                         position: 'top-right',
                         loaderBg:'#ff6849',
                         icon: 'warning',
                         hideAfter: 3500
                       });
                    }
                  },
                  error:function(data){
                    if(data.status != 401){
                      $.toast({
                        heading: 'Error:',
                        text: 'Error al recuperar los datos.',
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'error',
                        hideAfter: 3500

                      });
                    }else{
                      window.location = '/login';
                    }

                  }
            });
      });
    }

    function saveFuente(){

      var r = confirm("Guardar la fuente de datos?");
      if (r == true) {
        $.ajax({
              type: "POST",
              url: "{{ url('/api/sistemaremi/apiSaveFuente') }}",
              dataType: 'json',
              data: $("#formAddFuente").serialize() , // Adjuntar los campos del formulario enviado.
              success: function(data){
                if(data.error == false){
                    updateComboFuente();
                }else{
                    $.toast({
                     heading: data.title,
                     text: data.msg,
                     position: 'top-right',
                     loaderBg:'#ff6849',
                     icon: 'warning',
                     hideAfter: 3500
                   });
                }
              },
              error:function(data){
                if(data.status != 401){
                  $.toast({
                    heading: 'Error:',
                    text: 'Error al recuperar los datos.',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 3500

                  });
                }else{
                  window.location = '/login';
                }

              }
        });
      } else {
          txt = "You pressed Cancel!";
      }

    }

    //Evento del boton nuevo
    function win_fuente(){
      $('#divcon').animate({scrollTop : 0}, 500);
      var offset = $("#side-menu").offset();
      $("#window").jqxWindow({ position: { x: parseInt(offset.left) + 30  , y: parseInt(offset.top) + (180) } });
          $("#window").css('visibility', 'visible');
          $('#window').jqxWindow('open');
          $('#window').jqxWindow('focus');
          $("#formAddFuente")[0].reset();
          $("#fd_cobertura_geografica").val('').trigger('change');
          //$("#fd_variable").val('').trigger('change');
          $("#set_responsables > tbody").html("");
          $("#cont_resp").html(0);
    }
    $(document).keydown(function(tecla){
          if (tecla.keyCode == 119) {
            var offset = $("#side-menu").offset();
            $("#window").jqxWindow({ position: { x: parseInt(offset.left) + 30  , y: parseInt(offset.top) + (180) } });
                $("#window").css('visibility', 'visible');
                $('#window').jqxWindow('open');
                $('#window').jqxWindow('focus');
                $("#formAddFuente")[0].reset();
                $("#fd_cobertura_geografica").val('').trigger('change');
                //$("#fd_variable").val('').trigger('change');
                $("#set_responsables > tbody").html("");
                $("#cont_resp").html(0);
          }
    });

    function updateComboFuente(){
        var combo = $("#fuente_datos").val();
        var arraySel = JSON.parse("[" + combo + "]");
        $("#fuente_datos").empty();
        $.ajax({
              type: "get",
              url: "{{ url('/api/sistemaremi/apiUpdateComboFuente') }}",
              dataType: 'json',
              success: function(data){
                  $.each(data.item, function(i, data) {
                      if($.inArray(data.id, arraySel) == -1){
                        $("#fuente_datos").append('<option value="'+data.id+'">'+data.nombre+'</option>');
                      }else{
                        $("#fuente_datos").append('<option value="'+data.id+'" selected>'+data.nombre+'</option>');
                      }
                  });
                  $('#window').jqxWindow('close');
                  $("#formAddFuente")[0].reset();
                  $("#fd_cobertura_geografica").val('').trigger('change');
                  //$("#fd_variable").val('').trigger('change');
                  $("#set_responsables > tbody").html("");
              },
              error:function(data){
                if(data.status != 401){
                  $.toast({
                    heading: 'Error:',
                    text: 'Error al recuperar los datos.',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 3500
                  });
                }else{
                  window.location = '/login';
                }

              }
        });
    }



    function showFilterAdvanced() {

      if ($('#FilterAdvanced').hasClass('hidden')){
            $("#dataTable").jqxDataTable('clearFilters');
            $('#exportarData').removeClass('hidden')
            $('#exportarData').addClass('hidden')
            // $("#dataTable").jqxDataTable({filterable: false});
            $('#FilterAdvanced').removeClass('hidden')
            $('#jqxDataTable').removeClass('col-lg-12');
            $('#jqxDataTable').fadeIn(500).addClass('col-lg-9');
      }else{
            // $("#dataTable").jqxDataTable({filterable: true});
            $('#FilterAdvanced').addClass('hidden')
            $('#jqxDataTable').removeClass('col-lg-9');
            $('#jqxDataTable').fadeIn(500).addClass('col-lg-12');
        }
    }
    function showExportarData() {

      if ($('#exportarData').hasClass('hidden')){
            // $("#dataTable").jqxDataTable({filterable: true});
            $('#FilterAdvanced').removeClass('hidden')
            $('#FilterAdvanced').addClass('hidden')

            $('#exportarData').removeClass('hidden')
            $('#jqxDataTable').removeClass('col-lg-12');
            $('#jqxDataTable').fadeIn(1000).addClass('col-lg-9');

      }else{

          $('#exportarData').addClass('hidden')
          $('#jqxDataTable').removeClass('col-lg-9');
          $('#jqxDataTable').fadeIn(1000).addClass('col-lg-12');
        }
    }
//------------------aqui
   function actualizarcampo(ele){
     $('#'+ele.name+'Desc').html($('input[name="'+ele.name+'"]').val());
   }
   function actualizarcombo(ele){
     $('#'+ele.name+'Desc').html($('select[name="'+ele.name+'"] option:selected').text());
   }
   function actualizarcomboUnidad(ele){
     $('.'+ele.name+'Desc').html($('select[name="'+ele.name+'"] option:selected').text());
   }


   function btn_mostrar(ele){
      var idSeleccionar = ele;
      location.href = '/sistemaremi/dataIndicador/'+ idSeleccionar;
   }
//------------------aqui fin

function filtrar(){
   var url = '{{ url('/api/sistemarime/apiFiltroGrid') }}';
   var source2 =
   {
       dataType: "json",
       dataFields: [
           { name: 'id', type: 'int' },
           { name: 'codigo_id', type: 'string' },
           { name: 'tipo', type: 'string' },
           { name: 'estado_desc', type: 'string' },
           { name: 'etapa', type: 'string' },
           { name: 'nombre', type: 'string' },
           { name: 'sectores', type: 'string' },
           { name: 'compartido', type: 'string' },
           { name: 'pdes', type: 'string' },
           { name: 'ods', type: 'string' },
           { name: 'dimension_spie', type: 'string' },
           { name: 'subdimension', type: 'string' }
       ],
       id: 'id',
       data:{
             'fil_estados': $("#fil_estados").val(),
             'fil_compartidos':$("#fil_compartidos").val(),
             'fil_tipos':$("#fil_tipos").val(),
             'fil_sectores':$("#fil_sectores").val(),
             'fil_pdes_pilar':$("#fil_pdes_pilar").val(),
             'fil_pdes_meta':$("#fil_pdes_meta").val(),
             'fil_pdes_resultado':$("#fil_pdes_resultado").val(),
             'fil_ods_objetivo':$("#fil_ods_objetivo").val(),
             'fil_ods_meta':$("#fil_ods_meta").val(),
             'fil_ods_indicador':$("#fil_ods_indicador").val(),
             'fil_dimensiones':$("#fil_dimensiones").val(),
             'fil_subdimensiones':$("#fil_subdimensiones").val(),
             'filter':{{$filtData}},
            },
       url: url
   };
   var dataAdapter2 = new $.jqx.dataAdapter(source2);
   $("#dataTable").jqxDataTable({
       source: dataAdapter2,
       rendered: function () {
          actualizar();
       }
  });
   //$('#dataTable').jqxDataTable({});


}
function actualizar(){
  var visibleRows = $("#dataTable").jqxDataTable('getView');
  var count = visibleRows.length;
  $('#total_registros').html(count);
}

$('#limpiarfiltros').click(function () {
  $("#filtroForm")[0].reset();
  $("#fil_sectores").val('').trigger('change');
  $("#fil_pdes_pilar").val('').trigger('change');
  $("#fil_pdes_meta").val('').trigger('change');
  $("#fil_pdes_resultado").val('').trigger('change');
  $("#fil_ods_objetivo").val('').trigger('change');
  $("#fil_ods_meta").val('').trigger('change');
  $("#fil_ods_indicador").val('').trigger('change');
  $("#dataTable").jqxDataTable('clearFilters');
  filtrar();
  showFilterAdvanced();
});




  </script>
@endpush
