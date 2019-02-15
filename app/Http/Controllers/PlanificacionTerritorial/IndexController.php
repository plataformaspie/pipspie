<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Plataforma\Instituciones;
use App\Models\Plataforma\Regiones;
use App\Models\PlanificacionTerritorial\EtapasPlan;

class IndexController extends BasecontrollerController
{
  public function index()
  {
      return view('PlanificacionTerritorial.index');
  }

  public function datosUsuario(Request $request)
  {
      $user = \Auth::user();
      $periodoActual = $this->periodoActual();
      $institucion = Instituciones::find($user->id_institucion);
      $region = \DB::select("SELECT *
                             FROM v_pip_catalogo_regiones_nivel_3
                             WHERE muni_codigo = ?",[$institucion->codigo_geografico]);
      return \Response::json([
        'user' => $user,
        'institucion' => $institucion,
        'periodoActivo' => $periodoActual['gestionesPeriodo'],
        'gestionInicial' => $periodoActual['gestionInicial'],
        'gestionFinal' => $periodoActual['gestionFinal'],
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

  public function verificarEtapa(Request $request)
  {
        $periodoActual = $this->periodoActual();
        $user = \Auth::user();
        switch ($request->modulo) {
          case 1:
              $etapasEstado = EtapasPlan::where('valor_campo_etapa', 'Recursos')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan',$periodoActual['periodoId'])->get();
              if($etapasEstado->count() > 0){
                if($etapasEstado[0]->estado_etapa != 'Concluido'){
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 2,
                      'modulo' => 'Recursos',
                      'msg' => "Ingresar a Modificar.")
                  );
                }else{
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 3,
                      'modulo' => 'Recursos',
                      'msg' => "No puede modificar ya etapa concluida.")
                  );
                }
              }else{
                return \Response::json(array(
                    'error' => true,
                    'accion' => 1,
                    'modulo' => 'Recursos',
                    'msg' => "Activar el Cargado de los Recursos.")
                );
              }
          break;
          case 2:
           $etapaAnterior = EtapasPlan::where('valor_campo_etapa', 'Recursos')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->where('estado_etapa', 'Concluido')->get();
            if($etapaAnterior->count() > 0)
            {
                $etapasEstado = EtapasPlan::where('valor_campo_etapa', 'Deudas')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->get();
                if($etapasEstado->count() > 0){
                  if($etapasEstado[0]->estado_etapa != 'Concluido'){
                    return \Response::json(array(
                        'error' => false,
                        'accion' => 2,
                        'modulo' => 'Deudas',
                        'msg' => "Ingresar a Modificar.")
                    );
                  }else{
                    return \Response::json(array(
                        'error' => false,
                        'accion' => 3,
                        'modulo' => 'Deudas',
                        'msg' => "No puede modificar ya etapa concluida.")
                    );
                  }
                }else{
                  return \Response::json(array(
                      'error' => true,
                      'accion' => 1,
                      'modulo' => 'Deudas',
                      'msg' => "Activar el Cargado de los Recursos.")
                  );
                }
            }else{
              return \Response::json(array(
                  'error' => true,
                  'accion' => 0,
                  'modulo' => 'Recursos',
                  'msg' => "Debe concluir el módulo de Recursos para continuar.")
              );
            }
          break;
          case 3:
          $etapaAnterior = EtapasPlan::where('valor_campo_etapa', 'Deudas')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->where('estado_etapa', 'Concluido')->get();
           if($etapaAnterior->count() > 0)
           {
               $etapasEstado = EtapasPlan::where('valor_campo_etapa', 'PTDI')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->get();
               if($etapasEstado->count() > 0){
                 if($etapasEstado[0]->estado_etapa != 'Concluido'){
                   return \Response::json(array(
                       'error' => false,
                       'accion' => 2,
                       'modulo' => 'PTDI',
                       'msg' => "Ingresar a Modificar.")
                   );
                 }else{
                   return \Response::json(array(
                       'error' => false,
                       'accion' => 3,
                       'modulo' => 'PTDI',
                       'msg' => "No puede modificar ya etapa concluida.")
                   );
                 }
               }else{
                 return \Response::json(array(
                     'error' => true,
                     'accion' => 1,
                     'modulo' => 'PTDI',
                     'msg' => "Activar el Cargado de los Recursos.")
                 );
               }
           }else{
             return \Response::json(array(
                 'error' => true,
                 'accion' => 0,
                 'modulo' => 'Deudas',
                 'msg' => "Debe concluir el módulo de Deudas para continuar.")
             );
           }
          break;
        }
  }


  public function activarEtapa(Request $request)
  {
        $periodoActual = $this->periodoActual();
        $user = \Auth::user();
        $etapa = new EtapasPlan();
        $etapa->id_institucion = $user->id_institucion;
        $etapa->campo_etapa = 'detalle';
        $etapa->valor_campo_etapa = $request->modulo;
        $etapa->descripcion_campo_etapa = 'Este registro ayuda a controlar el estado del modulo de Recursos de un periodo';
        $etapa->estado_etapa = "En Elaboración";
        $etapa->id_periodo_plan =  $periodoActual['periodoId'];
        $etapa->save();
        return \Response::json(array(
            'error' => false,
            'accion' => 1,
            'msg' => "Se activo el control de estados del módulo seleccionado.")
        );
  }

  public function estadoActualModulos(Request $request)
  {
        $periodoActual = $this->periodoActual();
        $user = \Auth::user();

        $moduloRecuros = EtapasPlan::where('valor_campo_etapa', 'Recursos')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->first();
        $moduloDeudas = EtapasPlan::where('valor_campo_etapa', 'Deudas')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->first();

        if($moduloRecuros){
          $etapaRecursos= $moduloRecuros->estado_etapa;
        }else{
          $etapaRecursos='Inactivo';
        }

        if($moduloDeudas){
          $etapaDeudas = $moduloDeudas->estado_etapa;
        }else{
          $etapaDeudas='Inactivo';
        }

        return \Response::json(array(
            'error' => false,
            'moduloRecursosEstado' => $etapaRecursos,
            'moduloDeudasEstado' => $etapaDeudas,
            'msg' => "Se activo el control de estados del módulo seleccionado.")
        );
  }

  public function finalizarModulo(Request $request)
  {
    $periodoActual = $this->periodoActual();
    $user = \Auth::user();
    switch ($request->modulo) {
      case 1:
        \DB::table('sp_eta_etapas_plan')->where('id_institucion', $user->id_institucion)->where('valor_campo_etapa', 'Recursos')->where('id_periodo_plan',  $periodoActual['periodoId'])->update(['estado_etapa' => 'Concluido']);
        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'alert' => "success",
            'msg' => "Se Cambio la etapa con exito.")
        );
      break;
      case 2:
        \DB::table('sp_eta_etapas_plan')->where('id_institucion', $user->id_institucion)->where('valor_campo_etapa', 'Deudas')->where('id_periodo_plan',  $periodoActual['periodoId'])->update(['estado_etapa' => 'Concluido']);
        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'alert' => "success",
            'msg' => "Se Cambio la etapa con exito.")
        );
      break;
      case 3:
        \DB::table('sp_eta_etapas_plan')->where('id_institucion', $user->id_institucion)->where('valor_campo_etapa', 'PTDI')->where('id_periodo_plan',  $periodoActual['periodoId'])->update(['estado_etapa' => 'Concluido']);
        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'alert' => "success",
            'msg' => "Se Cambio la etapa con exito.")
        );
      break;
    }
  }

}
