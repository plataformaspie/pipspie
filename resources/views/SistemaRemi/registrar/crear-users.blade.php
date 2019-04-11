@extends('layouts.sistemaremi')

@section('header')
 <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
<link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

@endsection

@section('content')

  <div class="row">
      <div class="col-sm-12">
          <div class="white-box">
              <h3 class="box-title m-b-0">Crea Nueva Cuenta de Usuarios</h3>
              <p class="text-muted m-b-30 font-13"> Formulario para crear una cuenta </p>
                    <a href="{{ route('mostrarReg') }}" class="btn waves-effect waves-light btn-info"><font color="#fff"><span class="glyphicon glyphicon-th-list"></span> Detalles de las Cuentas de Usuarios</font>
                    </a>
                  @if(count($errors)>0)
                    <div class="alert alert-danger" role="alert">
                      <ul>
                      @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                      </ul>
                    </div>
                  @endif
                  <br/><br/>
              <form id="formAdd" name="formAdd" method="POST" action="{{ route('guardarUser') }}" data-toggle="validator">
                {{ csrf_field() }}

                  <div class="form-group row">
                      <label for="example-text-input" class="col-2 col-form-label">Nombre Completo :</label>
                      <div class="col-10">
                          <input type="text" id="name" name="name" class="form-control" placeholder="Nombre Completo" required >
                      </div>
                  </div>

                  <div class="form-group row m-b-5 m-l-5 m-t-5" >
                      <div class="form-group col-md-2 p-l-0 p-r-0 m-b-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Cargo que Ocupa :</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0 m-b-0">
                          <input type="text" id="cargo" name="cargo" class="form-control" placeholder="Nombre del Cargo" required>
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="form-group col-md-2 p-l-0 m-b-0">
                              <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Tipos de Rol:</label>
                          </div>
                      <div class="form-group col-md-4 p-l-0 m-b-0">  <!-- class="col-md-9 p-l-0"> -->
                                <select id="roles" name="roles" class="custom-select col-12 form-control enabledCampos" required>
                                      <option value="">Selecciona Rol......</option>
                                      @foreach ($tipo_rol as  $rol)
                                        <option value="{{ $rol->id_roles }}">{{ $rol->nombre_rol }}</option>
                                      @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                          </div>
                  </div>
                <div class="form-group row m-b-5 m-l-5 m-t-5" >
                      <div class="form-group col-md-2 p-l-0 p-r-0 m-b-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nro. Identidad</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0 m-b-0">
                          <input type="text" id="carnet" name="carnet" class="form-control" placeholder="Nùmero de Identidad" required>
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="form-group col-md-2 p-l-0 m-b-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Celular :</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0 m-b-0">
                          <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Nùmero de Celular" required>
                          <div class="help-block with-errors"></div>
                      </div>
                </div>
                <div class="form-group row m-b-5 m-l-5 m-t-5" >
                      <div class="form-group col-md-2 p-l-0 p-r-0 m-b-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Correo :</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0 m-b-0">
                          <input type="email" id="email" name="email" class="form-control" placeholder="Nombre de Correo" required>
                               <div class="help-block with-errors"></div>
                      </div>
                      <div class="form-group col-md-2 p-l-0 p-r-0 m-b-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Institucion :</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0 m-b-0">
                                <select id="pcod_ent" name="pcod_ent" class="custom-select col-12 form-control enabledCampos" required>
                                      <option value="">Selecciona una Entidad.......</option>
                                      @foreach ($filinstitucion as  $entidades)
                                          <option value="{{ $entidades->codigo }}">{{ $entidades->denominacion }}</option>
                                      @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                      </div>
                  </div>
                <div class="form-group row m-b-5 m-l-5 m-t-5" >
                      <div class="form-group col-md-2 p-l-0 p-r-0 m-b-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Usuario :</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0 m-b-0">
                          <input type="text" id="username" name="username" class="form-control" placeholder="Nombre de Usuario" required>
                      </div>
                      <div class="form-group col-md-2 p-l-0 p-r-0 m-b-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Password :</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0 m-b-0">
                         <input class="form-control" type="password" value="" id="password" name="password" required>
                            <div class="help-block with-errors"></div>
                      </div>
                </div>
                  <center><button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Guardar Cuenta de Usuario</button></center>
              </form>
          </div>
      </div>
  </div>


@endsection
