<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlanificacionTerritorial\Parametros;
use App\Models\PlanificacionTerritorial\Recursos;
use App\Models\PlanificacionTerritorial\RecursosPoa;
use App\Models\PlanificacionTerritorial\ProyectoPoa;
use App\Models\PlanificacionTerritorial\ProyectoPoaAjuste;
use App\Models\PlanificacionTerritorial\SeguimientoGestiones;
use App\Models\PlanificacionTerritorial\GestionSeleccionada;
use App\Models\PlanificacionTerritorial\OtrosIngresos;





class SeguimientoController extends Controller
{

  public function saveUpdateRecursoPoa(Request $request)
  {
    $user = \Auth::user();
    //dd("hola desde el controlador save");
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    /*select * from sp_eta_gestiones
where id_institucion = 560

and id_periodo_plan = 6
and gestion_seleccionada = true
ORDER BY orden*/

    /*$gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('id_institucion',$user->id_institucion)
                                          ->where('activo',true)
                                          ->where('gestion_seleccionada',true)
                                          ->first(); */
    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                          ->where('activo',true)
                                           ->first();

    
    $recursopoa = $request->datos;
    //dd($recursopoa);
    //$id_recurso = $recursopoa['id_tipo_recurso'];
    
    //$gestion_seguimiento = 2018;
    //dd(is_null($recursopoa['id_tipo_recurso']));
    if(is_null($recursopoa['id_tipo_recurso'])){
      $id_recurso = $recursopoa['id_otro_ingreso'];
      $verificarExiste = RecursosPoa::where('id_otro_ingreso',$id_recurso)
                                  ->where('gestion',$gestionActiva->gestion)
                                  ->where('id_institucion',$user->id_institucion)
                                  ->get();
    }else{
      $id_recurso = $recursopoa['id_tipo_recurso'];
      $verificarExiste = RecursosPoa::where('id_tipo_recurso',$id_recurso)
                                  ->where('gestion',$gestionActiva->gestion)
                                  ->where('id_institucion',$user->id_institucion)
                                  ->get();
    }

    //dd($verificarExiste);
    if($verificarExiste->count()>0){
      try{
        
        //$updateRecurso = RecursosPoa::find(intval($recursopoa['id_recurso_poa']));
        
        $updateRecurso = RecursosPoa::find($verificarExiste[0]->id);
        //$updateRecurso->refresh();
        
        $updateRecurso->id_institucion = $user->id_institucion;
        $updateRecurso->id_tipo_recurso = $recursopoa['id_tipo_recurso'];
        $updateRecurso->gestion = $gestionActiva->gestion;
        
        $updateRecurso->monto_poa_gestion = $recursopoa['monto_poa_gestion'];
        $updateRecurso->monto_pei_gestion = $recursopoa['monto_pei_gestion'];
        $updateRecurso->diferencia_ptdi_poa =$recursopoa['diferencia_ptdi_poa'];
        $updateRecurso->diferencia_pei_poa = $recursopoa['diferencia_pei_poa'];
        $updateRecurso->diferencia_porcentaje_ptdi_poa = $recursopoa['diferencia_porcentaje_ptdi_poa'];
        $updateRecurso->diferencia_porcentaje_pei_poa = $recursopoa['diferencia_porcentaje_pei_poa'];
        $updateRecurso->color_porcentaje_ptdi_poa = $recursopoa['color_porcentaje_pei_poa'];
        $updateRecurso->color_porcentaje_pei_poa = $recursopoa['color_porcentaje_pei_poa'];
        $updateRecurso->causas_variacion = $recursopoa['causas_variacion'];
        $updateRecurso->save();

        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se guardo con exito.",
        ));
      
      }catch(Exception $e){
        return \Response::json(array(
          'error'=> true,
          'title'=>"Success!",
          'msg' => $e->getMessage()
        ));

      }                          
    }  //actualizar
    else{
      //dd($recursopoa);
      if(is_null($recursopoa['id_tipo_recurso'])){
        try{
          $recurso = new RecursosPoa();
          $recurso->id_institucion = $user->id_institucion;
          $recurso->id_tipo_recurso = null;
          $recurso->gestion = $gestionActiva->gestion;//$recursopoa['gestion'];
          $recurso->monto_poa_gestion = $recursopoa['monto_poa_gestion'];
          $recurso->diferencia_ptdi_poa = $recursopoa['diferencia_ptdi_poa'];
          $recurso->diferencia_porcentaje_ptdi_poa = $recursopoa['diferencia_porcentaje_ptdi_poa'];
          $recurso->diferencia_pei_poa = $recursopoa['diferencia_pei_poa'];
          $recurso->diferencia_porcentaje_pei_poa = $recursopoa['diferencia_porcentaje_pei_poa'];
          $recurso->color_porcentaje_ptdi_poa = $recursopoa['color_porcentaje_pei_poa'];
          $recurso->color_porcentaje_pei_poa = $recursopoa['color_porcentaje_pei_poa'];
          $recurso->causas_variacion = $recursopoa['causas_variacion'];
          $recurso->id_otro_ingreso = $recursopoa['id_otro_ingreso'];

          $recurso->save();

          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se guardo con exito.",
              
            )
          );
        }
        catch (Exception $e) {
            return \Response::json(array(
              'error' => true,
              'title' => "Error!",
              'msg' => $e->getMessage())
            );
        }
      }else{
        try{
          $recurso = new RecursosPoa();
          $recurso->id_institucion = $user->id_institucion;
          $recurso->id_tipo_recurso = $recursopoa['id_tipo_recurso'];
          $recurso->gestion = $gestionActiva->gestion;//$recursopoa['gestion'];
          $recurso->monto_poa_gestion = $recursopoa['monto_poa_gestion'];
          $recurso->diferencia_ptdi_poa = $recursopoa['diferencia_ptdi_poa'];
          $recurso->diferencia_porcentaje_ptdi_poa = $recursopoa['diferencia_porcentaje_ptdi_poa'];
          $recurso->diferencia_pei_poa = $recursopoa['diferencia_pei_poa'];
          $recurso->diferencia_porcentaje_pei_poa = $recursopoa['diferencia_porcentaje_pei_poa'];
          $recurso->color_porcentaje_ptdi_poa = $recursopoa['color_porcentaje_pei_poa'];
          $recurso->color_porcentaje_pei_poa = $recursopoa['color_porcentaje_pei_poa'];
          $recurso->causas_variacion = $recursopoa['causas_variacion'];
          $recurso->save();

          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se guardo con exito.",
              
            )
          );
        }
        catch (Exception $e) {
            return \Response::json(array(
              'error' => true,
              'title' => "Error!",
              'msg' => $e->getMessage())
            );
        }
      }
      
    }                                  
  }
  public function listaRecursosGestion(){
    $user = \Auth::user();
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    /*$gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first(); */
    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                          ->where('activo',true)
                                          ->first();

    
    $estadoModulo = \DB::select("select estado_etapa from sp_eta_estado_etapas_seguimiento
                                                    where id_institucion =  $user->id_institucion
                                                    and valor_campo_etapa = 'sRecursos'
                                                    and gestion = $gestionActiva->gestion");
    //dd($estadoModulo);
    if($estadoModulo[0]->estado_etapa == "En Elaboración"){
      $estado_etapa = true;
    }else{
      $estado_etapa = false;
    }

    $parametros = Parametros::where('categoria', 'tipo_recursos')
      ->where('activo', true)
      ->orderBy('orden', 'ASC')
      ->get();

      $grupos = Array();
      $sw="";
      $i=0;
      foreach ($parametros as $item) {
          if($item->valor != $sw){
              $sw=$item->valor;
              $grupos[$i]['id'] = $item->id;
              $grupos[$i]['valor'] = $item->valor;
              $grupos[$i]['orden'] = $item->orden;
              $grupos[$i]['codigo'] = $item->codigo;
              $i++;
          }
      }


      //$gestion_seguimiento = 2017;
      
      $recursos=\DB::select("select 
            eta.id_institucion,
            eta.id_tipo_recurso,
            eta.gestion,
            eta.monto,
            pa.valor,
            pa.nombre,
            pa.orden,
            pa.id,
            pa.codigo
      from sp_eta_recursos_eta as eta, sp_parametros as pa
      where eta.id_institucion = $user->id_institucion
      and eta.gestion = $gestionActiva->gestion
      and eta.activo = true
      and eta.id_tipo_recurso = pa.id");

    
    
      ///SOLO GRUPOS
      $grupos = Array();
      $sw="";
      $i=0;
      foreach ($recursos as $item) {
          if($item->valor != $sw){
              $sw=$item->valor;
              $grupos[$i]['id'] = $item->id;
              $grupos[$i]['valor'] = $item->valor;
              $grupos[$i]['orden'] = $item->orden;
              $grupos[$i]['codigo'] = $item->codigo;
              $i++;
          }
      }
      /// FIN GRUPOS
      
      $otrosRecursos = OtrosIngresos::where('id_institucion',$user->id_institucion)->where('activo', true)->orderby('id', 'ASC')->get();
        
          $diferencia_ptdi_poa_otros = 0;
          $diferencia_porcentaje_ptdi_otros = 0;

          $total_pei_otros = 0;
          $diferencia_pei_poa_otros = 0;
          $diferencia_porcentaje_pei_poa_otros = 0;
          $total_poa_otros = 0;
          $total_ptdi_otro_ingreso = 0;

      foreach ($otrosRecursos as $o) {

        $otro_gestion = Recursos::where('id_otro_ingreso',$o->id)
                                    ->where('gestion',$gestionActiva->gestion)
                                    ->first(); 
        $o->id = $otro_gestion->id;
        $o->id_institucion = $otro_gestion->id_institucion;
        $o->id_tipo_recurso = $otro_gestion->id_tipo_recurso; 
        $o->gestion = $otro_gestion->gestion; 
        $o->id_otro_ingreso = $otro_gestion->id_otro_ingreso;
        $o->monto= $otro_gestion->monto; 

        $datos_poa = RecursosPoa::where('id_otro_ingreso',$o->id_otro_ingreso)
                                ->where('gestion',$gestionActiva->gestion)
                                ->where('id_institucion',$user->id_institucion)
                                ->get();
        //dd($datos_poa);
        $poa = new \stdClass();
        $pei = new \stdClass();
        $causas_variacion = new \stdClass();
        $total_ptdi_otro_ingreso = $total_ptdi_otro_ingreso + $o->monto;

        if($datos_poa->count()>0){
          $o->diferencia_ptdi_poa = $datos_poa[0]->diferencia_ptdi_poa;
          $o->diferencia_porcentaje_ptdi_poa=$datos_poa[0]->diferencia_porcentaje_ptdi_poa;
          $o->diferencia_pei_poa=$datos_poa[0]->diferencia_pei_poa;
          $o->diferencia_porcentaje_pei_poa=$datos_poa[0]->diferencia_porcentaje_pei_poa;

          $poa->input = $datos_poa[0]->monto_poa_gestion;
          $poa->clase = '';
          $poa->mensaje = '';
          $o->monto_poa_gestion = $poa;
          
          $pei->input = $datos_poa[0]->monto_pei_gestion;
          $pei->clase = '';
          $pei->mensaje = '';
          $o->monto_pei_gestion = $pei;

          $causas_variacion->input = $datos_poa[0]->causas_variacion;
          $causas_variacion->clase = '';
          $causas_variacion->mensaje = '';
          $o->causas_variacion = $causas_variacion;
          

          $o->id_datos_poa = $datos_poa[0]->id;
          $o->color_porcentaje_ptdi_poa=$datos_poa[0]->color_porcentaje_ptdi_poa;
          $o->color_porcentaje_pei_poa=$datos_poa[0]->color_porcentaje_pei_poa;

          
          $diferencia_ptdi_poa_otros = $diferencia_ptdi_poa_otros + $datos_poa[0]->diferencia_porcentaje_ptdi_poa;
          $diferencia_porcentaje_ptdi_otros = $diferencia_porcentaje_ptdi_otros + $datos_poa[0]->diferencia_porcentaje_ptdi_poa;

          $total_pei_otros = $total_pei_otros + $datos_poa[0]->monto_pei_gestion;
          $diferencia_pei_poa_otros = $diferencia_pei_poa_otros + $datos_poa[0]->diferencia_pei_poa;
          $diferencia_porcentaje_pei_poa_otros = $diferencia_porcentaje_pei_poa_otros + $datos_poa[0]->diferencia_porcentaje_pei_poa;
          $total_poa_otros = $total_poa_otros + $datos_poa[0]->monto_poa_gestion;
        }else{
          
          $o->diferencia_ptdi_poa = 0;
          $o->diferencia_porcentaje_ptdi_poa=0;
          $o->diferencia_pei_poa=0;
          $o->diferencia_porcentaje_pei_poa=0;

          $poa->input = 0;
          $poa->clase = '';
          $poa->mensaje = '';
          $o->monto_poa_gestion = $poa;
          
          $pei->input = 0;
          $pei->clase = '';
          $pei->mensaje = '';
          $o->monto_pei_gestion = $pei;

          $causas_variacion->input = '';
          $causas_variacion->clase = '';
          $causas_variacion->mensaje = '';
          $o->causas_variacion = $causas_variacion;

          $o->id_recurso_poa = 0;
          $o->color_porcentaje_ptdi_poa=0;
          $o->color_porcentaje_pei_poa=0;
        }                          
      }
      $i++;
      if($otrosRecursos){
        $grupos[$i]['id'] = 232;
        $grupos[$i]['valor'] = 'Otros Ingresos';
        $grupos[$i]['orden'] = 13;
        $grupos[$i]['codigo'] = 'OI';
      }

      //$gestion = 2018;
      $total_ptdi = 0;
      $diferencia_ptdi_poa = 0;
      $diferencia_porcentaje_ptdi = 0;
      $total_pei = 0;
      $diferencia_pei_poa = 0;
      $diferencia_porcentaje_pei_poa = 0;
      $total_poa = 0;

      //añadiendo valores del POA
      foreach ($recursos as $value) {
        $recurso_Poa = RecursosPoa::where('id_tipo_recurso',$value->id_tipo_recurso)
                                ->where('gestion',$gestionActiva->gestion)
                                ->where('id_institucion',$user->id_institucion)
                                ->get();
        //dd( $recurso_Poa[0]->diferencia_ptdi_poa);
        $poa = new \stdClass();
        $pei = new \stdClass();
        $causas_variacion = new \stdClass();
        $total_ptdi = $total_ptdi + $value->monto;

        if($recurso_Poa->count()>0){
          $value->diferencia_ptdi_poa = $recurso_Poa[0]->diferencia_ptdi_poa;
          $value->diferencia_porcentaje_ptdi_poa=$recurso_Poa[0]->diferencia_porcentaje_ptdi_poa;
          $value->diferencia_pei_poa=$recurso_Poa[0]->diferencia_pei_poa;
          $value->diferencia_porcentaje_pei_poa=$recurso_Poa[0]->diferencia_porcentaje_pei_poa;

          $poa->input = $recurso_Poa[0]->monto_poa_gestion;
          $poa->clase = '';
          $poa->mensaje = '';
          $value->monto_poa_gestion = $poa;
          
          $pei->input = $recurso_Poa[0]->monto_pei_gestion;
          $pei->clase = '';
          $pei->mensaje = '';
          $value->monto_pei_gestion = $pei;

          $causas_variacion->input = $recurso_Poa[0]->causas_variacion;
          $causas_variacion->clase = '';
          $causas_variacion->mensaje = '';
          $value->causas_variacion = $causas_variacion;
          

          $value->id_recurso_poa = $recurso_Poa[0]->id;
          $value->color_porcentaje_ptdi_poa=$recurso_Poa[0]->color_porcentaje_ptdi_poa;
          $value->color_porcentaje_pei_poa=$recurso_Poa[0]->color_porcentaje_pei_poa;

          
          $diferencia_ptdi_poa = $diferencia_ptdi_poa + $recurso_Poa[0]->diferencia_porcentaje_ptdi_poa;
          $diferencia_porcentaje_ptdi = $diferencia_porcentaje_ptdi + $recurso_Poa[0]->diferencia_porcentaje_ptdi_poa;

          $total_pei = $total_pei + $recurso_Poa[0]->monto_pei_gestion;
          $diferencia_pei_poa = $diferencia_pei_poa + $recurso_Poa[0]->diferencia_pei_poa;
          $diferencia_porcentaje_pei_poa = $diferencia_porcentaje_pei_poa + $recurso_Poa[0]->diferencia_porcentaje_pei_poa;
          $total_poa = $total_poa + $recurso_Poa[0]->monto_poa_gestion;
        }else{
          
          $value->diferencia_ptdi_poa = 0;
          $value->diferencia_porcentaje_ptdi_poa=0;
          $value->diferencia_pei_poa=0;
          $value->diferencia_porcentaje_pei_poa=0;

          $poa->input = 0;
          $poa->clase = '';
          $poa->mensaje = '';
          $value->monto_poa_gestion = $poa;
          
          $pei->input = 0;
          $pei->clase = '';
          $pei->mensaje = '';
          $value->monto_pei_gestion = $pei;

          $causas_variacion->input = '';
          $causas_variacion->clase = '';
          $causas_variacion->mensaje = '';
          $value->causas_variacion = $causas_variacion;

          $value->id_recurso_poa = 0;
          $value->color_porcentaje_ptdi_poa=0;
          $value->color_porcentaje_pei_poa=0;
        }
      }

      return \Response::json([
        'grupos' => $grupos,
        'recursos' => $recursos,
        'estado_modulo' => $estado_etapa,
        'plan_activo' => $planActivo->descripcion,
        'gestion_activa' => $gestionActiva->gestion,
        'total_ptdi'=>$total_ptdi + $total_ptdi_otro_ingreso,
        'diferencia_ptdi_poa'=>$diferencia_ptdi_poa,
        'diferencia_porcentaje_ptdi'=>$diferencia_porcentaje_ptdi,
        'total_pei'=>0,
        'diferencia_pei_poa'=>$diferencia_pei_poa,
        'diferencia_porcentaje_pei_poa'=>$diferencia_porcentaje_pei_poa,
        'total_poa'=>$total_poa + $total_poa_otros,
        'otrosIngresos'=>$otrosRecursos

      ]);
  }
 
}
