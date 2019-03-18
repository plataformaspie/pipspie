@extends('layouts.sistemaremi')

@section('header')

<style>
a:hover {
text-decoration: underline;
}
.box {
  position: relative;
  display: inline-block;
  width: 80%;
  height: 90%;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
  transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.box::after {
  content: "";
  border-radius: 5px;
  position: absolute;
  z-index: -1;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  opacity: 0;
  -webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
  transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.box:hover {
  -webkit-transform: scale(1.25, 1.25);
  transform: scale(1.25, 1.25);
  cursor: pointer;
}

.box:hover::after {
    opacity: 1;
}

</style>
@endsection

@section('content')

  <div class="row bg-title">
      <!-- .page title -->
      <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Lista de indicadores alineados al PDES</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      <div class="col-lg-7 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/setIndicadores') }}">Indicadores</a></li>
              <li class="active">Lista de indicadores</li>
          </ol>
      </div>
      <!-- /.breadcrumb -->
  </div>
  <!-- .row -->

<!--   </br> -->
  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-inverse ">
              <div class="panel-heading"> Filtro de indicadores por pilares
                  <div class="pull-right">
                      <a href="#" data-perform="panel-collapse">
                        <i class="ti-minus">Presionar</i>
                      </a>
                  </div>
              </div>
              <div class="panel-wrapper collapse in" aria-expanded="true">
                  <div class="panel-body">
                      <?php /*
                      <div class="row p-b-20">
                          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <input type="text" name="buscar_sel" class="form-control buscar" value="{{ $buscar }}" placeholder="Buscar...">
                          </div>
                          <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                            <select name="tipo" class="form-control filter">
                                <option value="">-Tipo Indicador-</option>
                                @foreach ($tiposMedicion as $item)
                                  <option value="{{ $item->nombre }}" {{ $tipo === $item->nombre  ? "selected" : "" }}>{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                          </div>

                          <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4">
                            <select name="unidad" class="form-control filter">
                                <option value="">-Unidad de Medida-</option>
                                @foreach ($unidadesMedidas as $item)
                                  <option value="{{ $item->nombre }}" {{ $unidad === $item->nombre  ? "selected" : "" }}>{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                          </div>
                      </div>
                      <h4 class="font-bold m-t-0">Filtrar por Pilar</h4>
                      <hr>*/ ?>
                      <div class="form-group row m-b-5 m-l-5 m-t-5" >
                         <div class="col-md-3 p-l-0 p-r-0">
                              <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Filtrar por Entidad</label>
                          </div>

                          <div class="form-group col-md-4 p-l-0">
                                <select id="pcod_ent" name="pcod_ent" class="custom-select col-12 form-control enabledCampos" required>
                                      <option value="">Selecciona una Entidad.......</option>
                                      @foreach ($filindpil as  $entidad)
                                          @if($entidad->id == $pent)
                                          <option value="{{ $entidad->codigo_entidad }}" selected="">{{ $entidad->nombre_entidad }}</option>
                                          @else
                                          <option value="{{ $entidad->codigo_entidad }}">{{ $entidad->nombre_entidad }}</option>
                                          @endif
                                      @endforeach
                                </select> 
                                <div class="help-block with-errors"></div>
                          </div>  
                          <div  id="Pilares" class="col-lg-2 p-l-0 text-center">
                                <button type="button" id="btn_ent" class="btn btn-block btn-info btn-sm m-t-5"><i class="fa fa-plus-square"></i> Mostrar Pilares</button>
                          </div>
                       
                      </div>                      
                      <h5>Entidad Filtrada: <b>{{$nom_ent}} – Nro. de Entidad: {{$pent}}</b></h5>
                      <div class="row">
                      @if($swp == 2)  
                        @foreach ($filindent as  $ent_pilar)                        
                         @if($ent_pilar->cod_p == 1)
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_1.jpg" height="50" alt="-"  class="box" onclick="filtrarPdes(1)"/>
                            </div>
                          @endif
                          @if($ent_pilar->cod_p == 2)                          
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_2.jpg" height="50" alt="-"  class="box" onclick="filtrarPdes(2)"/>
                            </div>                           
                          @endif          
                          @if($ent_pilar->cod_p == 3 ) 
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_3.jpg" height="50" alt="-" class="box"  onclick="filtrarPdes(3)"/>
                            </div>                            
                          @endif          
                          @if($ent_pilar->cod_p == 4 )                           
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_4.jpg" height="50" alt="-"  class="box" onclick="filtrarPdes(4)"/>
                            </div>                           
                          @endif          
                          @if($ent_pilar->cod_p == 5 )                             
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_5.jpg" height="50" alt="-"  class="box" onclick="filtrarPdes(5)"/>
                            </div>                           
                          @endif          
                          @if($ent_pilar->cod_p == 6)                             
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_6.jpg" height="50" alt="-"  class="box" onclick="filtrarPdes(6)"/>
                            </div>                           
                          @endif          
                          @if($ent_pilar->cod_p == 7)                             
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_7.jpg" height="50" alt="-"  class="box" onclick="filtrarPdes(7)"/>
                            </div>                            
                          @endif          
                          @if($ent_pilar->cod_p == 8)                             
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_8.jpg" height="50" alt="-" class="box"  onclick="filtrarPdes(8)"/>
                            </div>                           
                          @endif          
                          @if($ent_pilar->cod_p == 9) 
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_9.jpg" height="50" alt="-"  class="box" onclick="filtrarPdes(9)"/>
                            </div>                           
                          @endif          
                          @if($ent_pilar->cod_p == 10)                             
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_10.jpg" height="50" alt="-"  class="box" onclick="filtrarPdes(10)"/>
                            </div>                           
                          @endif          
                          @if($ent_pilar->cod_p == 11)                             
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_11.jpg" height="50" alt="-"  class="box" onclick="filtrarPdes(11)"/>
                            </div>                            
                          @endif          
                          @if($ent_pilar->cod_p == 12)                            
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_12.jpg" height="50" alt="-"  class="box" onclick="filtrarPdes(12)" />
                            </div>                          
                          @endif          
                          @if($ent_pilar->cod_p == 13)                            
                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-12 m-b-10">
                              <img src="/img/PILAR_13.jpg" height="50" alt="-"  class="box" onclick="filtrarPdes(13)"/>
                            </div>                          
                          @endif                                  
                         @endforeach
                       @else
                            <label id="mej" type="label"><font color="#FF0000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No existe indicadores y pilares para la Entidad !!!</font></label>
                       @endif    
                      </div>
                  </div>
              </div>
          </div>

      </div>
  </div>
@if($swp == 2) 
  <div class="row">
      <div class="col-lg-12">
          <div class="panel">
              <div class="panel-body">
                <h5>Reporte del Total de Resultados del {{$nom_ent}}</b></h5>
                <div style="color:#3177AE">Total Indicadores: <b style="color:#3177AE">{{ $totalPilar->totalp  }}</b></div>
                <div style="color:#3177AE">Total Resultados Con Indicadores: <b>{{ $countPilar->total  }}</b></div>
                <div style="color:#3177AE">Total Resultados Sin Indicadores: <b>{{ $totalResPilar->totalgral  }}</b></div>
                <div>
                      <?php
                      $pilar = "";
                      $meta = "";
                      $resultado = "";
                      $p = "";
                      $p1 = "";
                      $p2 = "";
                      $k = "";
                      $t = "";
                      $h = "";
                      $c = "";
                      $h = "";
                      ?>
                  @if($countPilar->total != 0)   
                     @foreach ($filtropdes as $itemP)
                        @if($itemP->pilar != $pilar)
                            <?php $pilar =  $itemP->pilar; ?>
                            <div class="row show-grid " style="padding-right: 0px;padding-top: 0px;padding-left: 0px;">
                                <div class="col-lg-1 col-xs-12">
                                  <center>
                                    <a href="#">
                                        <img class="media-object" src="/img/{{$itemP->logo}}"  style="width: 100px; height: 100px;">
                                    </a>
                                  </center>
                                </div>

                                <div class="col-lg-11 col-xs-12">
                                  <div class="row">
                                      <div class="col-lg-12">
                                            <div class="row show-grid m-t-0">
                                                  {{ $meta = ""}}
                                                   @foreach ($filtropdes as $itemM)
                                                     @if($itemM->meta != $meta and $itemP->pilar == $itemM->pilar)
                                                           <?php $meta =  $itemM->meta; ?>
                                                            <div class="col-lg-1">
                                                              <a class="mytooltip" style="color:#3177AE" href="javascript:void(0)"> <?php $p++; ?> 
                                                                  {{$itemM->meta}} <?php $p1=""; $p2=""; ?>
                                                                <span class="tooltip-content5">
                                                                    <span class="tooltip-text3">
                                                                      <span class="tooltip-inner2 p-10" style="font-size:10px;">{{$itemM->meta}}<br /> {{$itemM->desc_m}}</span>
                                                                    </span>
                                                                  </span>
                                                              </a>
                                                            </div>                                               
                                                            <div class="col-lg-11 p-t-0 p-b-0">
                                                              <div class="row">
                                                                <div class="col-lg-12 p-t-0 p-b-0">
                                                                  <div class="row">
                                                                    {{ $resultado = ""}} <?php $pos=0 ?> 
                                                                     @foreach ($filtropdes as $itemR)
                                                                       @if($itemR->resultado != $resultado and $itemM->meta == $itemR->meta)
                                                                             <?php $resultado =  $itemR->resultado; ?>
                                                                                  <div class="col-lg-2 p-t-0 p-b-0" @if($itemR->nombre != "") style="background-color: #E0F1D7" <?php ?> @else style="background-color: #F0D8D8" <?php ?> @endif>
                                                                                    <a class="mytooltip" @if($itemR->nombre != "") style="color: #55773D" <?php $p1++; ?> @else style="color: #A94456" <?php $p2++; ?> @endif  href="javascript:void(0)">
                                                                                        {{$itemR->resultado}} 
                                                                                      <span class="tooltip-content5">
                                                                                          <span class="tooltip-text3">
                                                                                            <span class="tooltip-inner2 p-10" style="font-size:10px;">{{$itemR->resultado}}<br /> {{$itemR->desc_r}}</span>
                                                                                          </span>
                                                                                        </span>
                                                                                    </a>

                                                                                  </div>
                                                                                  <div class="col-lg-10 p-t-0 p-b-0">
                                                                                    <div class="row">
                                                                                      {{ $indicador = ""}}
                                                                                       @foreach ($filtropdes as $itemI)
                                                                                         @if($itemI->nombre != $indicador and $itemR->resultado == $itemI->resultado)
                                                                                               <?php $indicador =  $itemI->nombre; $k++; ?>
                                                                                              <div class="col-lg-12 text-muted">
                                                                                                  <a href="/sistemaremi/dataIndicador/{{ $itemI->id_indicador }}" style="color:#000000;font-weight: bold;">{{ $itemI->nombre }} {{$k}} </a>
                                                                                              </div>
                                                                                          @endif                   
                                                                                        @endforeach
                                                                                        <?php $h=$k;$k=""; ?>
                                                                                    </div>
                                                                                  </div>
                                                                        @endif
                                                                      @endforeach


                                                                  </div>

                                                                </div>
                                                              </div>
                                                            </div>
                                                @endif
                                              @endforeach
                                           </div>

                                      </div>

                                  </div>
                                </div>
                            </div>
                        @endif
                      @endforeach
                  @endif    
                </div>


            </div>
         </div>
      </div>
  </div>
@endif    
  <?php /*
  <div class="row">
      <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
              <div>
                <p>
                  {{ $indicadores->total() }} registros | página {{ $indicadores->currentPage() }} de {{ $indicadores->lastPage() }}
                </p>
                {!! $indicadores->render() !!}
              @foreach ($indicadores as $item)
                    <div class="row media" style="padding-right: 0px;padding-top: 0px;padding-left: 0px;">
                        <div class="col-lg-1 col-xs-12">
                          <center>
                            <a href="/sistemaremi/dataIndicador/{{ $item->id }}">
                                <img class="media-object" src="/img/icono_indicadores/{{ $item->logo }}"  style="width: 90px; height: 100px;">
                            </a>
                          </center>
                        </div>
                        <div class="col-lg-11 col-xs-12">
                          <div class="row">
                              <div class="col-lg-12 card-footer">
                                    <a href="/sistemaremi/dataIndicador/{{ $item->id }}" style="color:#000000;font-weight: bold;">{{ $item->nombre }}</a>
                              </div>
                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                  <p class="text-muted">Tipo:</p>
                                  <p> {{ $item->tipo }} </p>
                              </div>
                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                  <p class="text-muted">Unidad de medida:</p>
                                  <p>{{ $item->unidad_medida }}</p>
                              </div>
                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                  <p class="text-muted">Serie disponible:</p>
                                  <p>{{ $item->serie_disponible }}</p>
                              </div>
                              <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 text-center">
                                  <p class="text-muted">Linea base:</p>
                                  <p>{{ $item->linea_base_valor }}</p>
                              </div>

                          </div>
                        </div>
                    </div>
              @endforeach
              </div>
              {!! $indicadores->render() !!}

          </div>
       </div>





      </div>
  </div>

  */ ?>

@endsection

@push('script-head')

  <script type="text/javascript">
    $(document).ready(function(){

      $( ".filter" ).change(function() {
            var tipo = $( "select[name*='tipo']" ).val();
            var unidad = $( "select[name*='unidad']" ).val();
            var buscar = $('input[name="buscar_sel"]').val();
            var concat = "";
            if(tipo){
              concat += "tipo="+tipo+"&";
            }
            if(unidad){
              concat += "unidad="+unidad+"&";
            }
            if(buscar){
              concat += "buscar="+buscar+"&";
            }
            $(location).attr('href', '/sistemaremi/setIndicadores/?'+concat);
      });


      $(".buscar").keypress(function(e) {
          var code = (e.keyCode ? e.keyCode : e.which);
          if(code==13){
              $(".filter" ).trigger( "change" );
          }
      });
    });

    $(document).ready(function(){
       $('#btn_ent').click(function(){
         filtra_Entidad();
      });
    });    

    function filtra_Entidad(){
        var cod_ent1=$('#pcod_ent').val();  
       var concat1 = "";
        concat1 += "cod_ent="+cod_ent1+"&";
      $(location).attr('href', '/sistemaremi/setIndicadores/?'+concat1);
    }

    function filtrarPdes(ele){
       // var cod_ent1=$('#ent').val();  
       // var concat1 = "";
       // concat1 += "cod_ent="+cod_ent1+"&";

      var concat = "";
      concat += "cod_ent={{$pent}}&";
      concat += "pdes="+ele;
      $(location).attr('href', '/sistemaremi/setIndicadores/?'+concat);
      // console.log("ent_pdes",concat1,concat);
    }

 /*   function filtrarPdesEntidad(ent){
      console.log("ENTIDADES1",ent);
      var unir = "";
      unir += "pent="+ent+"&";
      $(location).attr('href', '/sistemaremi/setIndicadores/?'+unir);
    }  */

  </script>
@endpush
