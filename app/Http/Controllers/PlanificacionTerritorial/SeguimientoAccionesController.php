<?php

namespace App\Http\Controllers\PlanificacionTerritorial;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlanificacionTerritorial\Parametros;
use App\Models\PlanificacionTerritorial\RecursosPoa;
use App\Models\PlanificacionTerritorial\ProyectoPoa;
use App\Models\PlanificacionTerritorial\ProyectoPoaAjuste;
use App\Models\PlanificacionTerritorial\CategoriaProgramatica;
use App\Models\PlanificacionTerritorial\SeguimientoGestiones;
use App\Models\PlanificacionTerritorial\GestionSeleccionada;



class SeguimientoAccionesController  extends BasecontrollerController
{

  public function listaCategoriaProgramatica(){
    $user = \Auth::user();
    $tipo_entidad = 'municipio';
    switch($tipo_entidad){
      case 'municipio':{
        $listaProgramatica = CategoriaProgramatica::get();
        return \Response::json(array('categoria'=>$listaProgramatica));
        break;
      }
      case 'gobernacion':{
        break;
      }
    }
  }
  public function listaObjetivosEta(){

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
                                                    and valor_campo_etapa = 'sAcciones'
                                                    and gestion = $gestionActiva->gestion");
    //dd($estadoModulo);
    if($estadoModulo[0]->estado_etapa == "En Elaboración"){
      $estado_etapa = true;
    }else{
      $estado_etapa = false;
    }
    
    
    /*$objetivo_indicador =\DB::select("select 
                                  obj.id,
                                  obj.descripcion as nombre_accion_eta,
                                  obj.id_accion_eta,
                                  pdes.codigo_pdes as codigo_pdes
                                from sp_eta_planes as plan,
                                     sp_eta_objetivos_eta as obj,
                                     sp_eta_articulacion_catalogos as pdes
                                where id_institucion = 560
                                and plan.activo = true
                                and obj.id_plan = plan.id
                                and obj.activo = true
                                and obj.id_accion_eta = pdes.id_accion_eta
                                and pdes.activo = true");*/
    $objetivo_indicador = \DB::select("select 
                                            obj.id,
                                            obj.nombre_objetivo as nombre_accion_eta,
                                            obj.id_accion_eta,
                                            pdes.codigo_pdes as codigo_pdes
                                          from sp_eta_etapas_plan as plan,
                                               sp_eta_objetivos_eta as obj,
                                               sp_eta_articulacion_catalogos as pdes
                                          where plan.id_institucion = $user->id_institucion
                                          and plan.valor_campo_etapa = 'PTDI'
                                          and plan.id = obj.id_etapas_plan
                                          and obj.id_accion_eta = pdes.id_accion_eta
                                          and pdes.activo = true");

//dd($objetivo_indicador);
    foreach ($objetivo_indicador as $obj) {

      $pmra=explode(".",$obj->codigo_pdes);
      $pilar = $pmra[0];

      $meta = $pmra[1];
      $resultado = $pmra[2];
      $accion = $pmra[3];

       $arrayPmra =[];
       //pilar
      $p = \DB::select("select * from pdes_pilares
                        where cod_p = ".$pilar."");

      $id_pilar = $p[0]->id;
      //meta

      $m = \DB::select("select * from pdes_metas
                        where id_pilar = ".$id_pilar."
                        and cod_m =".$meta."");
      $id_meta = $m[0]->id;

      //resultados

      $r = \DB::select("select * from pdes_resultados
                          where id_meta = ".$id_meta."
                          and cod_r = ".$resultado."");
      $id_resultado = $r[0]->id;


      $a = \DB::select("select * from pdes_acciones
                          where id_resultado = ".$id_resultado."
                          and cod_a=".$accion."");


      $obj->cod_p = $p[0]->cod_p;
      $obj->nombre_p = $p[0]->nombre;
      $obj->descripcion_p = $p[0]->descripcion;
      $obj->logo_p = $p[0]->logo;

      $obj->cod_m = $m[0]->cod_m;
      $obj->nombre_m = $m[0]->nombre;
      $obj->descripcion_m = $m[0]->descripcion;

      $obj->cod_r = $r[0]->cod_r;
      $obj->nombre_r = $r[0]->nombre;
      $obj->descripcion_r = $r[0]->descripcion;

      $obj->cod_a = $a[0]->cod_a;
      $obj->nombre_a = $a[0]->nombre;
      $obj->descripcion_a = $a[0]->descripcion;

      /*$poa = \DB::select("select * from sp_eta_proyectos_poa
                                where id_accion_eta = 1");*/
      /*$poa = ProyectoPoa::where('id_accion_eta',$obj->id_accion_eta)
                          ->where('activo',true)
                          ->get();*/
      /*select * from sp_eta_proyectos_poa
            where id_accion_eta = 57
            and id_institucion = 567
            and gestion = 2018
            and activo = true*/
      $poa = ProyectoPoa::where('id_accion_eta',$obj->id)
      ->where('id_institucion',$user->id_institucion)
      ->where('gestion',$gestionActiva->gestion)
      ->where('activo',true)
      ->get();

      $obj->poa = $poa;


    }

    return \Response::json([
                            'objEta'=>$objetivo_indicador,
                            'estado_modulo'=>$estado_etapa,
                            'plan_activo'=>$planActivo->descripcion,
                            'gestion_activa'=>$gestionActiva->gestion
                            ]);
  }
  public function saveProyectoPoa(Request $request){
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
    //$gestion=2018;
    $p=$request->datos;
    //dd($p);
    if($p['id_proyecto_poa'] === 0 ){
      try{

        $proyPoa = new ProyectoPoa();
        $proyPoa->id_accion_eta = $p['id_accion_eta'];
        $proyPoa->nombre = $p['nombre'];
        $proyPoa->categoria_programatica = $p['categoria_programatica'];
        $proyPoa->gestion = $gestionActiva->gestion;
        $proyPoa->id_institucion = $user->id_institucion;
        $proyPoa->activo = true;
        $proyPoa->monto = $p['monto'];
        $proyPoa->avance_fisico = $p['avance_fisico'];
        $proyPoa->codigo_sisin = $p['codigo_sisin'];
        $proyPoa->inscrito_ptdi = $p['inscrito_ptdi'];
        $proyPoa->inscrito_pei = $p['inscrito_pei'];
        $proyPoa->inscrito_poa = $p['inscrito_poa'];
        $proyPoa->id_user_updated = $user->id;
        $proyPoa->save();

        return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se guardo con exito."
        ));
      }catch(Exception $e){
        return \Response::json(array(
              'error' => true,
              'title' => "Error!",
              'msg' => $e->getMessage())
            );
      }
    }else{
      try{

          $proyPoa =  ProyectoPoa::find($p['id_proyecto_poa']);
          $proyPoa->id_accion_eta = $p['id_accion_eta'];
          $proyPoa->nombre = $p['nombre'];
          $proyPoa->categoria_programatica = $p['categoria_programatica'];
          $proyPoa->gestion = $gestionActiva->gestion;
          $proyPoa->id_institucion = $user->id_institucion;
          $proyPoa->activo = true;
          $proyPoa->monto = $p['monto'];
          $proyPoa->avance_fisico = $p['avance_fisico'];
          $proyPoa->codigo_sisin = $p['codigo_sisin'];
          $proyPoa->inscrito_ptdi = $p['inscrito_ptdi'];
          $proyPoa->inscrito_pei = $p['inscrito_pei'];
          $proyPoa->inscrito_poa = $p['inscrito_poa'];
          
          $proyPoa->save();
          
          
          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'alert' => "success",
              'msg' => "Se guardo con exito.")
          );
      }
      catch (Exception $e) {
          return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'alert' => "error",
            'msg' => $e->getMessage())
          );
      }

    }
  }
  public function deleteProyPoa(Request $request)
  {

    $user = \Auth::user();
    if($request->id){
      try{
        
          $proyPoa = ProyectoPoa::find($request->id);
          $proyPoa->activo = false;
          $proyPoa->id_user_updated = $user->id;
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
