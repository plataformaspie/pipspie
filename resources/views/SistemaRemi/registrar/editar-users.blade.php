@extends('layouts.sistemaremi')

@section('header')
<link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

@endsection

@section('content')

  <div class="row">
      <div class="col-sm-12">
          <div class="white-box">
              <h3 class="box-title m-b-0">Actualizar una Cuenta de Usuario</h3>
              <p class="text-muted m-b-30 font-13"> Formulario para Actualizar una Cuenta de Usuario </p>
                    <a href="{{ route('mostrarReg') }}" class="btn btn-info"><font color="#fff"><i class="fa fa-plus-circle"></i> Detalles de Cuentas de Usuarios</font>
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
              <form id="formAdd" name="formAdd" method="POST" action="{{ route('SistemaRemi.registrar.actualizarUser',$user->id) }}">
                {{ csrf_field() }}

                  <div class="form-group row">
                      <label for="example-text-input" class="col-2 col-form-label">Nombre Completo :</label>
                      <div class="col-10">
                          <input type="text" name="name" class="form-control" value="{{$user->name}}" placeholder="Nombre Completo" required >
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="example-text-input" class="col-2 col-form-label">Cargo que Ocupa :</label>
                      <div class="col-10">
                          <input type="text" name="cargo" class="form-control" value="{{$user->cargo}}" placeholder="Nombre del Cargo" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="example-text-input" class="col-2 col-form-label">Cedula de Identidad :</label>
                      <div class="col-10">
                          <input type="text" name="carnet" class="form-control" value="{{$user->carnet}}" placeholder="Nùmero de Identidad" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="example-text-input" class="col-2 col-form-label">Celular :</label>
                      <div class="col-10">
                          <input type="text" id="telefono" name="telefono" class="form-control" value="{{$user->telefono}}" placeholder="Nùmero de Celular" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="example-email-input" class="col-2 col-form-label">Correo :</label>
                      <div class="col-10">
                          <input type="email" id="email" name="email" class="form-control" value="{{$user->email}}" placeholder="Nombre de Correo" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="example-email-input" class="col-2 col-form-label">Institución :</label>
                      <div class="col-10">
                                <select id="modent" name="modent" class="custom-select col-12 form-control enabledCampos" required>
                                      <option value="">Selecciona Institución......</option>
                                      @foreach ($Modifinstitucion as  $entidad)
                                          @if($entidad->id == $user->id_institucion)
                                          <option value="{{ $entidad->id }}" selected="">{{ $entidad->denominacion }}</option>
                                          @else
                                          <option value="{{ $entidad->id }}">{{ $entidad->denominacion }}</option>
                                          @endif
                                      @endforeach
                                </select>
                              <div class="help-block with-errors"></div>
                      </div>
                  </div>



                  <div class="form-group row">
                      <label for="example-email-input" class="col-2 col-form-label">Usuario :</label>
                      <div class="col-10">
                          <input type="text" id="username" name="username" class="form-control" value="{{$user->username}}" placeholder="Nombre de Usuario" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="example-email-input" class="col-2 col-form-label">Tipos de Rol :</label>
                      <div class="col-10">
               <!--        <div class="form-group col-md-4 p-l-0 m-b-0">  --> <!-- class="col-md-9 p-l-0"> -->
                                <select id="roles" name="roles" class="custom-select col-12 form-control enabledCampos" required>
                                      <option value="">Selecciona Rol......</option>
                                      @foreach ($mis_roles as  $rol)
                                          @if($rol->id_roles == $user->id_rol)
                                          <option value="{{ $rol->id_roles }}" selected="">{{ $rol->nombre_rol }}</option>
                                          @else
                                          <option value="{{ $rol->id_roles }}">{{ $rol->nombre_rol }}</option>
                                          @endif
                                      @endforeach

                                </select>

                              <div class="help-block with-errors"></div>
                       <!--    </div> -->
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="example-password-input" class="col-2 col-form-label">Password</label>
                      <div class="col-10">
                          <div class="form-check">
                              <label class="custom-control custom-checkbox">
                                  <input type="checkbox" id="activarpass" name="activarpass" class="custom-control-input activarcambio">
                                  <span class="custom-control-indicator"></span>
                                  <span class="custom-control-description">Cambiar contraseña</span>
                              </label>
                          </div>
                          <div id="form_pass" class="row hidden">
                                <div class="col-12">
                                  <h5>Nueva contraseña</h5>
                                  <input class="form-control" type="password" value="" id="password_nuevo_1" name="password_nuevo_1" >
                                  <h5>Confirmar contraseña</h5>
                                  <input class="form-control" type="password" value="" id="password_nuevo_2" name="password_nuevo_2" >

                                </div>
                          </div>
                      </div>
                  </div>

<!--                   <div class="form-group row">
                      <label for="example-password-input" class="col-2 col-form-label">Password :</label>
                      <div class="col-10">
                      	   <input class="form-control" type="password" value="" id="password" name="password" required>
                      </div>
                  </div> -->
                  <center><button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Actualizar Cuenta de Usuario</button></center>
              </form>
          </div>
      </div>
  </div>


@endsection
@push('script-head')
  <script type="text/javascript">
    $(document).ready(function(){
      $(".activarcambio").click(function () {
        if( $(this).is(':checked') ) {
          $("#form_pass").removeClass('hidden');
          $("#password_nuevo_1, #password_nuevo_2").val('');
        }else{
          $("#form_pass").addClass('hidden');
          $("#password_nuevo_1, #password_nuevo_2").val('');
        }

      });
    });

  </script>
@endpush
