<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Plataforma\Instituciones;
use App\Models\Plataforma\Regiones;
use App\Models\PlanificacionTerritorial\EtapasEstado;
use App\Models\PlanificacionTerritorial\FinancieroPoa;
use App\Models\PlanificacionTerritorial\ProyectoPoa;
use App\Models\PlanificacionTerritorial\Parametros;
use App\Models\PlanificacionTerritorial\SeguimientoGestiones;
use App\Models\PlanificacionTerritorial\ProyectoInversion;
use App\Models\PlanificacionTerritorial\EntidadesConcurrencia;
use App\Models\PlanificacionTerritorial\GestionSeleccionada;




class InversionController extends BasecontrollerController
{
  public function listaObjetivosProyectosInversion(){
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    /*$gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first();*/

    $user = \Auth::user();

    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                          ->where('activo',true)
                                           ->first();

    $estadoModulo = \DB::select("select estado_etapa from sp_eta_estado_etapas_seguimiento
                                                    where id_institucion =  $user->id_institucion
                                                    and valor_campo_etapa = 'sProyectosInversion'
                                                    and gestion = $gestionActiva->gestion");
    //dd($estadoModulo);
    if($estadoModulo[0]->estado_etapa == "En Elaboración"){
      $estado_etapa = true;
    }else{
      $estado_etapa = false;
    }
    
    
    //$gestion = '2018';
    /*$objetivoProyectos =\DB::select("select * from sp_eta_planes as plan,
                                      sp_eta_objetivos_eta as objetivos,
                                      sp_eta_articulacion_objetivo_indicador as arti,
                                      sp_eta_indicadores as indi,
                                      sp_eta_programacion_indicador as p_indi,
                                      sp_eta_catalogo_acciones_eta as catEta,
                                      sp_eta_articulacion_catalogos as artPmra
                        where plan.id_institucion = $user->id_institucion
                        and objetivos.id_plan = plan.id
                        and objetivos.id = arti.id_objetivo_eta
                        and objetivos.id_accion_eta = catEta.id
                        and objetivos.id_accion_eta = artPmra.id_accion_eta
                        and arti.id_indicador = indi.id
                        and arti.id = p_indi.id_articulacion_objetivo_indicador
                        and p_indi.gestion = '$gestionActiva->gestion'");*/
    
    $objetivoProyectos= \DB::select("select obj.id as id_accion_eta,
                                            obj.nombre_objetivo as nombre_accion_eta
                                    from sp_eta_etapas_plan as plan,
                                          sp_eta_objetivos_eta as obj
                                    where id_institucion = $user->id_institucion
                                    and valor_campo_etapa = 'PTDI'
                                    and obj.id_etapas_plan = plan.id
                                    and id_categoria_accion in (2,3)");
    foreach ($objetivoProyectos as $obj) {
      $poa = ProyectoPoa::where('id_accion_eta',$obj->id_accion_eta)
                          ->where('id_institucion',$user->id_institucion)
                          ->where('gestion',$gestionActiva->gestion)
                          ->where('activo',true)
                          ->whereNotNull('codigo_sisin')
                          ->get();
                          
      foreach ($poa as $p) {
        $inv = ProyectoInversion::where('id_proyecto_poa',$p->id)
                            ->where('id_institucion',$user->id_institucion)
                            ->where('gestion',$gestionActiva->gestion)
                            ->where('activo',true)
                            ->first();
                            //dd('Inversion',$inv->count());
                            //
          if($inv){
            //dd('costo',$inv->costo_total_proyecto);
            $p->id_proyecto_inversion = $inv->id;
            $p->costo_total_proyecto = $inv->costo_total_proyecto;
            $p->periodo_ejecucion_al = $inv->periodo_ejecucion_al;
            $p->periodo_ejecucion_del = $inv->periodo_ejecucion_del;
            $p->concurrencia_eta_programado = $inv->concurrencia_eta_programado;
            $p->concurrencia_eta_ejecutado = $inv->concurrencia_eta_ejecutado;
            $p->concurrencia_porcentaje_ejecutado = $inv->concurrencia_porcentaje_ejecutado;
            $p->entidad_ejecutora_cod = $inv->entidad_ejecutora_cod;
            $p->entidad_ejecutora_denominacion = $inv->entidad_ejecutora_denominacion;
            $p->verificar_existe_proyectos_inversion = "si hay";

            $ent = EntidadesConcurrencia::select('id','nombre_entidad','programacion_entidad','ejecucion_entidad','porcentaje_ejecucion_entidad')
                                        ->where('id_proyecto_inversion', $inv->id_proyecto_poa)
                                        ->where('id_institucion',$user->id_institucion)
                                        ->where('gestion',$gestionActiva->gestion)
                                        ->where('activo',true)
                                        ->get();
            if($ent){

              $p->entidadesConcurrencia = $ent;
              $p->verificar_existe_entidades_concurrencia ="si hay";

            }else{
              $p->verificar_existe_entidades_concurrencia ="no hay";              
            }
          }else{
            $p->verificar_existe_proyectos_inversion = "no hay";
          }
          $financiero = \DB::select("select * from sp_eta_financiero_poa
                                      where id_intitucion = $user->id_institucion
                                      and id_accion_eta = $obj->id_accion_eta
                                      and gestion = $gestionActiva->gestion");
          /*FinancieroPoa::where('id_intitucion', $user->id_institucion)
                                      ->where('id_accion_eta',$obj->id_accion_eta)
                                      ->where('gestion',$gestionActiva->gestion)
                                      ->first();*/
                                      //dd($financiero);
          $p->monto_poa_ejecutado = $financiero[0]->monto_poa_ejecutado;
          $p->monto_poa_planificado = $financiero[0]->monto_poa_planificado;
          $p->monto_poa_porcentaje = $financiero[0]->monto_poa_porcentaje;
      }

      $obj->proyectosInversion = $poa;
    }


    return \Response::json(['objetivoProyectos'=>$objetivoProyectos,
                            'estado_modulo'=>$estado_etapa,
                            'plan_activo'=>$planActivo->descripcion,
                            'gestion_activa'=>$gestionActiva->gestion]);
  }
  public function saveProyectoInversion(Request $request){

    
    //dd("hola desde el controlador save");
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    /*$gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first(); */

    $user = \Auth::user();

    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                          ->where('activo',true)
                                           ->first();

    $p = $request->proyecto;
    //dd($p);
    $inversion = $p['id_proyecto_inversion'];
    //dd($inversion);
    $e = $request->entidades;
    if($inversion == "nuevo"){
      try{
        $proyecto = new ProyectoInversion();
        $proyecto->id_accion_eta =  $p['id_accion_eta'];
        $proyecto->id_proyecto_poa = $p['id_proyecto_poa'];
        $proyecto->costo_total_proyecto = $p['costo_total_proyecto'];
        $proyecto->periodo_ejecucion_al = $p['periodo_ejecucion_al'];
        $proyecto->periodo_ejecucion_del = $p['periodo_ejecucion_del'];
        $proyecto->concurrencia_eta_programado = $p['concurrencia_eta_programacion'];
        $proyecto->concurrencia_eta_ejecutado = $p['concurrencia_eta_ejecucion'];
        $proyecto->concurrencia_porcentaje_ejecutado = $p['concurrencia_porcentaje_ejecutado'];
        $proyecto->entidad_ejecutora_cod = $p['entidad_ejecutora_cod'];
        $proyecto->entidad_ejecutora_denominacion = $p['entidad_ejecutora_denominacion'];
        $proyecto->gestion = $gestionActiva->gestion;
        $proyecto->id_institucion = $user->id_institucion;
        $proyecto->activo = true;
        $proyecto->save();

        return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se guardo con exito.",
              
            )
          );
      }catch(Exception $e){
         return \Response::json(array(
              'error' => true,
              'title' => "Error!",
              'msg' => $e->getMessage())
            );
      }

    }else{
      //ACTUALIZAR
      $id = $p['id_proyecto_inversion'];
      try{
        $proyecto = ProyectoInversion::find($id);
        $proyecto->id_accion_eta =  $p['id_accion_eta'];
        $proyecto->id_proyecto_poa = $p['id_proyecto_poa'];
        $proyecto->costo_total_proyecto = $p['costo_total_proyecto'];
        $proyecto->periodo_ejecucion_al = $p['periodo_ejecucion_al'];
        $proyecto->periodo_ejecucion_del = $p['periodo_ejecucion_del'];
        $proyecto->concurrencia_eta_programado = $p['concurrencia_eta_programacion'];
        $proyecto->concurrencia_eta_ejecutado = $p['concurrencia_eta_ejecucion'];
        $proyecto->concurrencia_porcentaje_ejecutado = $p['concurrencia_porcentaje_ejecutado'];
        $proyecto->entidad_ejecutora_cod = $p['entidad_ejecutora_cod'];
        $proyecto->entidad_ejecutora_denominacion = $p['entidad_ejecutora_denominacion'];
        $proyecto->gestion = $gestionActiva->gestion;
        $proyecto->id_institucion = $user->id_institucion;
        $proyecto->activo = true;
        $proyecto->save();

        return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se actualizo correctamente.",
              
            )
          );
      }catch(Exception $e){
         return \Response::json(array(
              'error' => true,
              'title' => "Error!",
              'msg' => $e->getMessage())
            );
      }

    }

    
  }
  public function saveEntidadesConcurrencia(Request $request ){

    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    /*$gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first();*/

    $user = \Auth::user();

    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                          ->where('activo',true)
                                           ->first();
            
    $concurrente = $request->entidadConcurrente;
    
    //dd('hhh',$planActivo);  
    try{

      $ent = new EntidadesConcurrencia();
      $ent->id_proyecto_inversion = $concurrente['id_proyecto_poa'];
      $ent->nombre_entidad = $concurrente['nombre_entidad'];
      $ent->programacion_entidad = $concurrente['programacion_entidad'];
      $ent->ejecucion_entidad = $concurrente['ejecucion_entidad'];
      $ent->porcentaje_ejecucion_entidad  = $concurrente['porcentaje_ejecucion_entidad'];
      $ent->activo = true;
      $ent->gestion = $gestionActiva->gestion;
      $ent->id_institucion = $user->id_institucion;
      $ent->save();

      return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se guardo con exito.",
            
          )
        );      

  
    }catch(Exception $e){
      return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'msg' => $e->getMessage())
          );
    }
  }
  public function updateEntidadesConcurrencia(Request $request){

    $updateConcurrencia = $request->updateEntidad;
    $id = $updateConcurrencia['id_entidad_concurrencia'];

    try{

      $ent = EntidadesConcurrencia::find($id);
      $ent->nombre_entidad = $updateConcurrencia['nombre_entidad'];
      $ent->programacion_entidad = $updateConcurrencia['programacion_entidad'];
      $ent->ejecucion_entidad = $updateConcurrencia['ejecucion_entidad'];
      $ent->porcentaje_ejecucion_entidad = $updateConcurrencia['porcentaje_ejecucion_entidad'];
      $ent->save();

      return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se guardo con exito.",
            
          ));

    }catch(Exception $e){
      return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'msg' => $e->getMessage())
          );
    }

  }
  public function listaEntidadesEjecutoras(){
    $user = \Auth::user();
    $entidades = \DB::select("select * from sp_eta_entidades_ejecutoras");
    return \Response::json(array(
            'entidadesEjecutoras' => $entidades,
            ));
          
  }
  public function deleteEntidad(Request $request)
  {

    $user = \Auth::user();
    if($request->id){
      try{
        
          $proyPoa = EntidadesConcurrencia::find($request->id);
          $proyPoa->activo = false;
          //$proyPoa->id_user_updated = $user->id;
          $proyPoa->save();
        
        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se elimino con exito.")
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
