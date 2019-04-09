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
                      <label for="example-email-input" class="col-2 col-form-label">Usuario :</label>
                      <div class="col-10">
                          <input type="text" id="username" name="username" class="form-control" value="{{$user->username}}" placeholder="Nombre de Usuario" required>
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

