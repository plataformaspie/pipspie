@extends('layouts.plataforma_home')

@section('header')

<link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

  <div class="row bg-title">
      <!-- .page title -->
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Cambiar contraseña.</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/home') }}">Setting</a></li>
              <li class="active">Cambiar contraseña</li>
          </ol>
      </div>
      <!-- /.breadcrumb -->
  </div>
  <!-- .row -->
  <div id="formulario" class="row">
      <div class="col-sm-12">
          <div class="white-box">
              <h3 class="box-title m-b-0">Cambiar contraseña</h3>
              <p class="text-muted m-b-30 font-13">Ingrese su nueva contraseña </p>
              <form id="formAdd" name="formAdd" action="javascript:save();" data-toggle="validator">
                {{ csrf_field() }}
                  <div class="form-group row">
                      <label for="example-text-input" class="col-2 col-form-label">Nueva contraseña</label>
                      <div class="col-10">
                          <input class="form-control" type="password" value="" id="password_nuevo_1" name="password_nuevo_1" required>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label for="example-text-input" class="col-2 col-form-label">Confirmar contraseña</label>
                      <div class="col-10">
                          <input class="form-control" type="password" value="" id="password_nuevo_2" name="password_nuevo_2" required>
                      </div>
                  </div>

                  <center><button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Guardar</button></center>
              </form>
          </div>
      </div>
  </div>

  <div id="message" class="row hidden">
      <div class="col-sm-12">
          <div class="white-box">
              <h3 class="box-title m-b-0">Contraseña modificada con éxito <a href="/home">Ir a pagina principal</a></h3>
          </div>
      </div>
  </div>
  <!-- /.row -->





@endsection

@push('script-head')
  <script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
  <script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
  <script type="text/javascript">

      function save(){
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
                          url: "{{ url('/apiSavePassword') }}",
                          dataType: 'json',
                          data: $("#formAdd").serialize() , // Adjuntar los campos del formulario enviado.
                          success: function(data){
                            if(data.error == false){
                              $.toast({
                                 heading: 'Existo.!',
                                 text: 'Se modificó correctamente su contraseña.',
                                 position: 'top-right',
                                 loaderBg:'#ff6849',
                                 icon: 'success',
                                 hideAfter: 3500,
                                 stack: 6
                               });
                               $("#formulario").addClass('hidden');
                               $("#message").removeClass('hidden');
                               swal("Modificado!", "Se ha modificado tu contraseña.", "success");

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
                 text: "Verifique la igualdad de los campos requeridos.",
                 position: 'top-right',
                 loaderBg:'#ff6849',
                 icon: 'warning',
                 hideAfter: 3500
               });
            }


      }

  </script>
@endpush
