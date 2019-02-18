@extends('layouts.sistemaremi')

@section('header')
<link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

@endsection

@section('content')

  <div class="row bg-title">
      <!-- .page title -->
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Registrar Usuarios</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/index') }}">Setting</a></li>
              <li class="active">Perfil</li>
          </ol>
      </div>
      <!-- /.breadcrumb -->
  </div>
  <div class="row">
      <div class="col-sm-12">
          <div class="white-box">
              <h3 class="box-title m-b-0">Datos basicos de su cuenta</h3>
              <p class="text-muted m-b-30 font-13"> Formulario de su cuenta </p>
              <form id="formAdd" name="formAdd" action="javascript:save();" data-toggle="validator">
                {{ csrf_field() }}

                  <div class="form-group row">
                      <label for="example-text-input" class="col-2 col-form-label">Nombre completo</label>
                      <div class="col-10">
                          <input type="text" id="name" name="name" class="form-control" value="{{$users->name}}" required >
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="example-text-input" class="col-2 col-form-label">Usuario</label>
                      <div class="col-10">
                          <input type="text" id="cargo" name="cargo" class="form-control" value="{{$users->cargo}}" >
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="example-text-input" class="col-2 col-form-label">Contraseña</label>
                      <div class="col-10">
                          <input type="text" id="carnet" name="carnet" class="form-control" value="{{$users->carnet}}" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="example-text-input" class="col-2 col-form-label">Rol</label>
                      <div class="col-10">
                          <input type="text" id="telefono" name="telefono" class="form-control" value="{{$users->telefono}}" >
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="example-email-input" class="col-2 col-form-label">Correo</label>
                      <div class="col-10">
                          <input type="email" id="email" name="email" class="form-control"  value="{{$users->email}}" required>
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
                                <!--div class="col-12">
                                  <h5>Ingrese contraseña actual</h5>
                                  <input class="form-control" type="password" id="password_anterior" name="password_anterior" required>
                                </div>
                                <div class="col-12">
                                  <hr/>
                                </div-->
                                <div class="col-12">
                                  <h5>Nueva contraseña</h5>
                                  <input class="form-control" type="password" value="" id="password_nuevo_1" name="password_nuevo_1" required>
                                  <h5>Confirmar contraseña</h5>
                                  <input class="form-control" type="password" value="" id="password_nuevo_2" name="password_nuevo_2" required>

                                </div>
                          </div>
                      </div>
                  </div>
                  <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Guardar</button>
              </form>
          </div>
      </div>
  </div>
  <!-- /.row -->





@endsection

@push('script-head')
  <script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
  <script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
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


    function save(){
      if( $("#activarpass").is(':checked') ) {
          if($("#password_nuevo_1").val() == $("#password_nuevo_2").val()){

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
                        url: "{{ url('/api/sistemaremi/apiSavePerfil') }}",
                        dataType: 'json',
                        data: $("#formAdd").serialize() , // Adjuntar los campos del formulario enviado.
                        success: function(data){
                          if(data.error == false){
                              window.location = "/sistemaremi/settingPerfil";
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
                          $.toast({
                           heading: 'Error:',
                           text: 'Error al recuperar los datos.',
                           position: 'top-right',
                           loaderBg:'#ff6849',
                           icon: 'error',
                           hideAfter: 3500

                         });
                        }
                  });
            });
          }else{
              $.toast({
               heading: "Error",
               text: "La nueva contraseña no son iguales.",
               position: 'top-right',
               loaderBg:'#ff6849',
               icon: 'warning',
               hideAfter: 3500
             });
          }
      }else{
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
                    url: "{{ url('/api/sistemaremi/apiSavePerfil') }}",
                    dataType: 'json',
                    data: $("#formAdd").serialize() , // Adjuntar los campos del formulario enviado.
                    success: function(data){
                      if(data.error == false){
                          window.location = "/sistemaremi/settingPerfil";
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
                      $.toast({
                       heading: 'Error:',
                       text: 'Error al recuperar los datos.',
                       position: 'top-right',
                       loaderBg:'#ff6849',
                       icon: 'error',
                       hideAfter: 3500

                     });
                    }
              });
        });

      }

    }

  </script>
@endpush