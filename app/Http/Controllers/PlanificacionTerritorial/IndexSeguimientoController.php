<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Plataforma\Instituciones;
use App\Models\Plataforma\Regiones;
use App\Models\PlanificacionTerritorial\EtapasEstadoSeguimiento;
use App\Models\PlanificacionTerritorial\Parametros;
use App\Models\PlanificacionTerritorial\SeguimientoGestiones;
use App\Models\PlanificacionTerritorial\GestionSeleccionada;


class IndexSeguimientoController extends BasecontrollerController
{

 
  public function index()
  {
      return view('PlanificacionTerritorial.indexseguimiento');
      //return view('PlanificacionTerritorial.indexevaluacion');
  }
  public function indexevaluacion()
  {
      return view('PlanificacionTerritorial.indexevaluacion');
      //return view('PlanificacionTerritorial.indexevaluacion');
  }
  public function cargarGestiones(Request $request){
    $user = \Auth::user();
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();
    
    $arrayGestiones = [2016,2017,2018,2019,2020];

    $verificarExiste = SeguimientoGestiones::where('id_institucion', $user->id_institucion)
                                          ->where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->orderBy('orden')
                                          ->get();
    
    if($verificarExiste->count()>0){

      $listaGestiones = SeguimientoGestiones::where('id_institucion', $user->id_institucion)
                                          ->where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->orderBy('orden')
                                          ->get();
      
    }else{
      //dd($arrayGestiones);
      $i = 0;
      foreach ($arrayGestiones as $val) {
        $nuevaGestion = new SeguimientoGestiones();
        $nuevaGestion->gestion = $val;
        $nuevaGestion->id_periodo_plan = $planActivo->id;
        $nuevaGestion->activo = true;
        $nuevaGestion->orden = $i;
        $nuevaGestion->estado ="activo";
        $nuevaGestion->id_institucion = $user->id_institucion;
        $nuevaGestion->save();
        $i++;
      }
      $listaGestiones = SeguimientoGestiones::where('id_institucion', $user->id_institucion)
                                          ->where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->orderBy('orden')
                                          ->get();
    }
    

    /*select * from sp_eta_gestiones
        where id_institucion = 560

        and id_periodo_plan = 6
        and activo = true
        ORDER BY orden*/
    return \Response::json([
        'gestiones' => $listaGestiones,
    ]);
  }
  public function cambiarVista(Request $request){
    $user = \Auth::user();
    $gestion = $request->gestion;
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();
    
    $activarGestion = GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                           ->get();
    if($activarGestion->count()>0){
      $gestionInstitucion = GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                           ->update(['gestion'=>$gestion]);
    }else{
      $gestionInstitucion = new GestionSeleccionada();
      $gestionInstitucion->id_institucion = $user->id_institucion;
      $gestionInstitucion->gestion = $gestion;
      $gestionInstitucion->activo = true;
      $gestionInstitucion->save();

    }
    
    

    return \Response::json([
        'error' => false,
        'gestionActiva'=>$gestionInstitucion
    ]);
  }

  public function datosUsuario(Request $request)
  {
      $user = \Auth::user();
      $institucion = Instituciones::find($user->id_institucion);
      $region = \DB::select("SELECT *
                             FROM v_pip_catalogo_regiones_nivel_3
                             WHERE muni_codigo = ?",[$institucion->codigo_geografico]);
      return \Response::json([
        'user' => $user,
        'institucion' => $institucion,
        'region' => $region[0]

      ]);

  }

  public function mapaMunicipio(Request $request)
  {
      $user = \Auth::user();
      $mapa = Regiones::select('geojson')->where('codigo_numerico', $request->codigo)->get();
      return $mapa[0]->geojson;
  }
  public function mapaDepartamento(Request $request)
  {
      $user = \Auth::user();
      $mapa = Regiones::select('geojson')->where('codigo_numerico', $request->codigo)->get();
      return $mapa[0]->geojson;
  }

  public function verificarEtapaSeguimiento(Request $request)
  {
        //$gestion = 2018;
        //$planActivo->id = 6;
        $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

        /*********Verificar Gestion Activa**************/
        $gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                              ->where('activo',true)
                                              ->first(); 
              $user = \Auth::user();
        switch ($request->modulo) {
          case 6:
              $etapasEstado = EtapasEstadoSeguimiento::where('valor_campo_etapa', 'sRecursos')
                                            ->where('id_institucion', $user->id_institucion)
                                            ->where('id_periodo_plan',$planActivo->id)
                                            ->where('gestion',$gestionActiva->gestion)
                                            ->get();
              if($etapasEstado->count() > 0){
                if($etapasEstado[0]->estado_etapa != 'Concluido'){
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 2,
                      'msg' => "Ingresar a Modificar.")
                  );
                }else{
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 3,
                      'title'=>'Modulo Concluido',
                      'msg' => "No puede modificar solo puede ver los datos.")
                  );
                }
              }else{
                return \Response::json(array(
                    'error' => true,
                    'accion' => 1,
                    'title' => "Activar Recursos?",
                    'msg' => "Activar el Cargado de los Recursos.")
                );
              }
          break;
          case 7:
              $etapasEstado = EtapasEstadoSeguimiento::where('valor_campo_etapa', 'sAcciones')
                                            ->where('id_institucion', $user->id_institucion)
                                            ->where('id_periodo_plan',$planActivo->id)
                                            ->where('gestion',$gestionActiva->gestion)
                                            ->get();
              if($etapasEstado->count() > 0){
                if($etapasEstado[0]->estado_etapa != 'Concluido'){
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 2,
                      'msg' => "Ingresar a Modificar.")
                  );
                }else{
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 3,
                      'title'=>'Modulo Concluido',
                      'msg' => "No puede modificar, solo ver los datos.")
                  );
                }
              }else{
                return \Response::json(array(
                    'error' => true,
                    'accion' => 1,
                    'title' => "Activar Acciones?",
                    'msg' => "Activar el Cargado del Vinculacion de Acciones para la gestion: ".$gestionActiva->gestion)
                );
              }

            // code...
          break;
          case 8:
              $etapasEstado = EtapasEstadoSeguimiento::where('valor_campo_etapa', 'sFisicaFinanciera')
                                            ->where('id_institucion', $user->id_institucion)
                                            ->where('id_periodo_plan',$planActivo->id)
                                            ->where('gestion',$gestionActiva->gestion)
                                            ->get();
              if($etapasEstado->count() > 0){
                if($etapasEstado[0]->estado_etapa != 'Concluido'){
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 2,
                      'msg' => "Ingresar a Modificar.")
                  );
                }else{
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 3,
                      'title'=>'Modulo Concluido',
                      'msg' => "No puede modificar, solo ver los datos.")
                  );
                }
              }else{
                return \Response::json(array(
                    'error' => true,
                    'accion' => 1,
                    'title' => "Activar Fisica - Financiera ?",
                    'msg' => "Activar el Cargado de la Ejecucion Fisica-Financiera para la gesstion:." .$gestionActiva->gestion)
                );
              }

            // code...
          break;
          case 9:
              $etapasEstado = EtapasEstadoSeguimiento::where('valor_campo_etapa', 'sProyectosInversion')
                                            ->where('id_institucion', $user->id_institucion)
                                            ->where('id_periodo_plan',$planActivo->id)
                                            ->where('gestion',$gestionActiva->gestion)
                                            ->get();
              if($etapasEstado->count() > 0){
                if($etapasEstado[0]->estado_etapa != 'Concluido'){
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 2,
                      'msg' => "Ingresar a Modificar.")
                  );
                }else{
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 3,
                      'title'=>'Modulo Concluido',
                      'msg' => "No puede modificar, solo ver los datos.")
                  );
                }
              }else{
                return \Response::json(array(
                    'error' => true,
                    'accion' => 1,
                    'title' => "Activar Proyectos Inversion?",
                    'msg' => "Activar el Cargado de los Proyectos de Inversion para la gestion:." .$gestionActiva->gestion)
                );
              }

            // code...
          break;
        }

        // return \Response::json(array(
        //     'error' => false,
        //     'title' => "Alerta!",
        //     'msg' => "Iniciar el Cargado de los Recursos.")
        // );

  }


  public function activarEtapaSeguimiento(Request $request)
  {
        $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

        /*********Verificar Gestion Activa**************/
        $gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                              ->where('activo',true)
                                              ->first(); 
        $periodo = Array();
        //$planActivo->id = 6;
        //$gestionActiva->gestion = 2018;
        
        $user = \Auth::user();
        //Aqui le manda la numero de accione y el numero de vista
        switch ($request->etapa) {
          case 1:{
            switch($request->vista){
              case 6:
                $etapa = new EtapasEstadoSeguimiento();
                $etapa->id_institucion = $user->id_institucion;
                $etapa->campo_etapa = 'detalle';
                $etapa->valor_campo_etapa = "sRecursos";
                $etapa->descripcion_campo_etapa = 'Este registro ayuda a controlar el estado del modulo de Seguimiento Recursos de la gestion: '. $gestionActiva->gestion;
                $etapa->estado_etapa = "En Elaboración";
                $etapa->gestion = $gestionActiva->gestion;
                $etapa->id_periodo_plan = $planActivo->id;
                $etapa->save();
                return \Response::json(array(
                    'error' => false,
                    'accion' => 1,
                    'msg' => "Se activo el control de estados del módulo seleccionado.")
                );
                break;
              case 7:
                $etapa = new EtapasEstadoSeguimiento();
                $etapa->id_institucion = $user->id_institucion;
                $etapa->campo_etapa = 'detalle';
                $etapa->valor_campo_etapa = "sAcciones";
                $etapa->descripcion_campo_etapa = 'Este registro ayuda a controlar el estado del modulo de Acciones vinculadas al PTDI de la gestion '.$gestionActiva->gestion;
                $etapa->estado_etapa = "En Elaboración";
                $etapa->gestion = $gestionActiva->gestion;
                $etapa->id_periodo_plan = $planActivo->id;
                $etapa->save();
                return \Response::json(array(
                    'error' => false,
                    'accion' => 1,
                    'msg' => "Se activo el control de estados del módulo seleccionado.")
                );
                break;
                case 8:
                $etapa = new EtapasEstadoSeguimiento();
                $etapa->id_institucion = $user->id_institucion;
                $etapa->campo_etapa = 'detalle';
                $etapa->valor_campo_etapa = "sFisicaFinanciera";
                $etapa->descripcion_campo_etapa = 'Este registro ayuda a controlar la ejecucion Fisica Financiera PTDI de la gestion: '.$gestionActiva->gestion;
                $etapa->estado_etapa = "En Elaboración";
                $etapa->gestion = $gestionActiva->gestion;
                $etapa->id_periodo_plan = $planActivo->id;
                $etapa->save();
                return \Response::json(array(
                    'error' => false,
                    'accion' => 1,
                    'msg' => "Se activo el control de estados del módulo seleccionado.")
                );
                break;
                case 9:
                $etapa = new EtapasEstadoSeguimiento();
                $etapa->id_institucion = $user->id_institucion;
                $etapa->campo_etapa = 'detalle';
                $etapa->valor_campo_etapa = "sProyectosInversion";
                $etapa->descripcion_campo_etapa = 'Este registro ayuda a controlar la ejecucion de los Proyectos de Inversion de la gestion '.$gestionActiva->gestion;
                $etapa->estado_etapa = "En Elaboración";
                $etapa->gestion = $gestionActiva->gestion;
                $etapa->id_periodo_plan = $planActivo->id;
                $etapa->save();
                return \Response::json(array(
                    'error' => false,
                    'accion' => 1,
                    'msg' => "Se activo el control de estados del módulo seleccionado.")
                );
                break;
             }
            
            break;
          }
          
          case 4:{
            $etapa = new EtapasEstado();
            $etapa->id_institucion = $user->id_institucion;
            $etapa->campo_etapa = 'detalle';
            $etapa->valor_campo_etapa = "Seguimiento";
            $etapa->descripcion_campo_etapa = 'Este registro ayuda a controlar el estado del modulo de Recursos de un periodo';
            $etapa->estado_etapa = "En Elaboración";
            $etapa->id_periodo_plan = $planActivo->id;
            $etapa->save();
            return \Response::json(array(
                'error' => false,
                'accion' => 1,
                'msg' => "Se activo el control de estados del módulo seleccionado.")
            );
            break;
          }

        }


  }

  public function estadoActualModulosSeguimiento(Request $request)
  {
        //$planActivo->id = 6;
        $user = \Auth::user();
        /*
        sRecursos
        sAcciones
        sFisicaFinanciera
        sProyectosInversion

        * */
      /*********Verificar Plan Activo**************/
      
      $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

      /*********Verificar Gestion Activa**************/
      /*$gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                            ->where('activo',true)
                                            ->first();  */ 
      $gestionActiva = GestionSeleccionada::where('id_institucion',$user->id_institucion)                             
                                            ->first();            




        $modulos=[];
        //$gestion=2018;
        $sRecursos = EtapasEstadoSeguimiento::where('valor_campo_etapa', 'sRecursos')
                                                  ->where('id_institucion', $user->id_institucion)
                                                  ->where('id_periodo_plan',$planActivo->id)
                                                  ->where('gestion',$gestionActiva->gestion)
                                                  ->first();
        if($sRecursos){
          if($sRecursos->count()>0)
            $r = $sRecursos->estado_etapa;
        }else{
          $r = 'Inactivo';
        }
        $sAcciones = EtapasEstadoSeguimiento::where('valor_campo_etapa', 'sAcciones')
                                                  ->where('id_institucion', $user->id_institucion)
                                                  ->where('id_periodo_plan',$planActivo->id)
                                                  ->where('gestion',$gestionActiva->gestion)
                                                  ->first();
        if($sAcciones){
          if($sAcciones->count()>0)
            $a = $sAcciones->estado_etapa;
        }else{
          $a = 'Inactivo';
        }
        $sFisicaFinanciera = EtapasEstadoSeguimiento::where('valor_campo_etapa', 'sFisicaFinanciera')
                                                  ->where('id_institucion', $user->id_institucion)
                                                  ->where('id_periodo_plan',$planActivo->id)
                                                  ->where('gestion',$gestionActiva->gestion)
                                                  ->first();
        if($sFisicaFinanciera){
          if($sFisicaFinanciera->count()>0)
            $f = $sFisicaFinanciera->estado_etapa;
        }else{
          $f = 'Inactivo';
        }
        $sProyectosInversion = EtapasEstadoSeguimiento::where('valor_campo_etapa', 'sProyectosInversion')
                                                  ->where('id_institucion', $user->id_institucion)
                                                  ->where('id_periodo_plan',$planActivo->id)
                                                  ->where('gestion',$gestionActiva->gestion)
                                                  ->first();           
        if($sProyectosInversion){
          if($sProyectosInversion->count()>0)
            $p = $sProyectosInversion->estado_etapa;
        }else{
          $p = 'Inactivo';
        }                                      

        return \Response::json(array(
            'error' => false,
            'sRecursos' => $r, //($sRecursos->count() > 0 && !is_null($sRecursos))?$sRecursos->estado_etapa:'Inactivo',
            'sAcciones' => $a,//($sAcciones->count() > 0 && !is_null($sAcciones))?$sAcciones->estado_etapa:'Inactivo',
            'sFisicaFinanciera' =>$f, //($sFisicaFinanciera->count() > 0)?$sFisicaFinanciera->estado_etapa:'Inactivo',
            'sProyectosInversion' =>$p, //($sProyectosInversion->count() > 0)?$sProyectosInversion->estado_etapa:'Inactivo',
            'msg' => "Se activo el control de estados del módulo seleccionado.",
            'planActivo' => $planActivo->descripcion,
            'gestionActiva'=> $gestionActiva->gestion)
        );

  }

  public function finalizarModuloSeguimiento(Request $request)
  {
        
        
        //$planActivo->id = 6;
        //$gestionActiva->gestion = 2018;
        $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

        /*********Verificar Gestion Activa**************/
        $gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                              ->where('activo',true)
                                              ->first(); 
        $user = \Auth::user();
        switch ($request->modulo) {
          case 6:
            \DB::table('sp_eta_estado_etapas_seguimiento')->where('id_institucion', $user->id_institucion)
                                                ->where('valor_campo_etapa', 'sRecursos')
                                                ->where('id_periodo_plan', $planActivo->id)
                                                ->where('gestion',$gestionActiva->gestion)
                                                ->update(['estado_etapa' => 'Concluido']);
            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'alert' => "success",
                'msg' => "Se elimino con exito.")
            );
          break;
          case 7:
            \DB::table('sp_eta_estado_etapas_seguimiento')->where('id_institucion', $user->id_institucion)
                                                ->where('valor_campo_etapa', 'sAcciones')
                                                ->where('id_periodo_plan', $planActivo->id)
                                                ->where('gestion',$gestionActiva->gestion)
                                                ->update(['estado_etapa' => 'Concluido']);
            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'alert' => "success",
                'msg' => "Se elimino con exito.")
            );
          break;
          case 8:
            \DB::table('sp_eta_estado_etapas_seguimiento')->where('id_institucion', $user->id_institucion)
                                                ->where('valor_campo_etapa', 'sFisicaFinanciera')
                                                ->where('id_periodo_plan', $planActivo->id)
                                                ->where('gestion',$gestionActiva->gestion)
                                                ->update(['estado_etapa' => 'Concluido']);
            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'alert' => "success",
                'msg' => "Se elimino con exito.")
            );
          break;
          case 9:
            \DB::table('sp_eta_estado_etapas_seguimiento')->where('id_institucion', $user->id_institucion)
                                                ->where('valor_campo_etapa', 'sProyectosInversion')
                                                ->where('id_periodo_plan', $planActivo->id)
                                                ->where('gestion',$gestionActiva->gestion)
                                                ->update(['estado_etapa' => 'Concluido']);
            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'alert' => "success",
                'msg' => "Se elimino con exito.")
            );
          break;
          
        }


  }

}
