<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="sty-mode-3/bootstrap/dist/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" > --}}
    {{-- <link rel="stylesheet" href="sty-mode-3/css/colors/megna.css" > --}}
  </head>
  <body>


    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
              <div class="row">
                  <div id="HTMLtoPDF" class="col-md-12">
                    <div class="row media" style="margin-right:6px;margin-left:6px;" >
                        <div class="col-lg-2 col-xs-12">
                          <center>
                                <img class="media-object" src="img/icono_indicadores/IND_1.png"  style="width: auto; height: auto;">
                          </center>
                        </div>
                        <div class="col-lg-10 col-xs-12">
                          <div class="row">
                              <div class="col-lg-12 ">
                                    <label style="color:#000000;font-weight: bold;">{{ $indicador->nombre }}</label>
                              </div>
                              <div class="col-lg-12">
                                    <label><b><u>Definicion:</u></b> {{$indicador->definicion}}</label>
                              </div>
                          </div>
                        </div>
                        <div class="col-lg-12 col-xs-12">
                          <div class="row">
                              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center">
                                  <p class="text-muted card-footer" >Último valor reportado:</p>
                                  @if(isset($avance->valor))
                                      <p> {{ $avance->valor }} </p>
                                      <p> {{ $avance->fecha_generado_dia }}/{{ $avance->fecha_generado_mes }}/{{ $avance->fecha_generado_anio }} </p>
                                  @endif
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center">
                                  <p class="text-muted card-footer"> Unidad de medida: </p>
                                  <p> {{$indicador->unidad_medida}} </p>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center">
                                  <p class="text-muted card-footer">Meta PDES al 2020</p>
                                  @foreach ($metas as $item)
                                    @if ($item->gestion == 2020)
                                        <p>{{number_format($item->valor,4,',','.')}}</p>
                                    @endif
                                  @endforeach

                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </div>



  </body>
</html>
