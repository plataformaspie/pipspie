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




class SeguimientoController extends Controller
{

  public function saveUpdateRecursoPoa(Request $request)
  {
    //dd("hola desde el controlador save");
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    $gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first(); 

    $user = \Auth::user();
    $recursopoa = $request->datos;
    //dd($recursopoa);
    $id_recurso = $recursopoa['id_tipo_recurso'];
    
    //$gestion_seguimiento = 2018;
    
    $verificarExiste = RecursosPoa::where('id_tipo_recurso',$id_recurso)
                                  ->where('gestion',$gestionActiva->gestion)
                                  ->where('id_institucion',$user->id_institucion)
                                  ->get();
    if($verificarExiste->count()>0){
      try{
        
        $updateRecurso = RecursosPoa::find(intval($recursopoa['id_recurso_poa']));
        $updateRecurso->refresh();
        
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
      //crear
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
  public function listaRecursosGestion(){
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    $gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first(); 

    $user = \Auth::user();
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
      //dd($recursos);

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
      //$gestion = 2018;
      $total_ptdi = 0;
      $diferencia_ptdi_poa = 0;
      $diferencia_porcentaje_ptdi = 0;
      $total_pei = 0;
      $diferencia_pei_poa = 0;
      $diferencia_porcentaje_pei_poa = 0;
      $total_poa = 0;


      foreach ($recursos as $value) {
        $recurso_Poa = RecursosPoa::where('id_tipo_recurso',$value->id_tipo_recurso)
                                ->where('gestion',$gestionActiva->gestion)
                                ->where('id_institucion',$user->id_institucion)
                                ->get();
        //dd( $recurso_Poa[0]->diferencia_ptdi_poa);
        $poa = new \stdClass();
        $pei = new \stdClass();
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
        'total_ptdi'=>$total_ptdi,
        'diferencia_ptdi_poa'=>$diferencia_ptdi_poa,
        'diferencia_porcentaje_ptdi'=>$diferencia_porcentaje_ptdi,
        'total_pei'=>$total_pei,
        'diferencia_pei_poa'=>$diferencia_pei_poa,
        'diferencia_porcentaje_pei_poa'=>$diferencia_porcentaje_pei_poa,
        'total_poa'=>$total_poa,

      ]);
  }
 
}
