@extends('layouts.sistemaremi')

@section('header')
<link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

@endsection

@section('content')

  <div class="row">
      <div class="col-sm-12">
          <div class="white-box">
              <h3 class="box-title m-b-0">Modificacion de Roles</h3>
              <p class="text-muted m-b-30 font-13"> Formulario para crear roles y Permisos </p>      
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
              <form id="formAdd" name="formAdd" method="POST" action="{{ route('actualizarUserRol') }}" data-toggle="validator">
                {{ csrf_field() }}

                      <div class="form-group row m-b-5 m-l-5 m-t-5" >
                          <div class="col-md-3 p-l-0 p-r-0">
                              <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Usuarios:</label>
                          </div>
                          <div class="form-group col-md-4 p-l-0">
                                <select id="cod_inst" name="cod_inst" class="custom-select col-12 form-control enabledCampos" required>
                                      <option value="">Seleccionar Usuario.......</option>
                                      @foreach ( $codinstitucion as $inst)
                                          <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                                      @endforeach
                                </select> 
                                <div class="help-block with-errors"></div>
                          </div> 
                        </div>

                      <div class="form-group row m-b-5 m-l-5 m-t-5" >
                          <div class="col-md-3 p-l-0 p-r-0">
                              <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Tipos de Rol:</label>
                          </div>
                          <div  class="form-group col-md-4 p-l-0">   <!-- class="col-md-9 p-l-0"> -->
                              <select id="roles" name="roles" class="custom-select col-12 form-control" required >
                                    <option value="">Seleccionar Rol...</option>
                                    <option value="13">Super Administrador</option>
                                    <option value="14">Administrador</option>
                                    <option value="17">Visualizador</option>                                    
                              </select>
                              <div class="help-block with-errors"></div>
                          </div>

                      </div>

                  <center><button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Guardar Cuenta de Usuario</button></center>
              </form>
          </div>
      </div>
  </div>


@endsection