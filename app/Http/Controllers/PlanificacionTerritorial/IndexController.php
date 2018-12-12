<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Plataforma\Instituciones;
use App\Models\Plataforma\Regiones;
use App\Models\PlanificacionTerritorial\EtapasEstado;

class IndexController extends BasecontrollerController
{
  public function index()
  {
      return view('PlanificacionTerritorial.index');
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

  public function verificarEtapa(Request $request)
  {
        $periodo = Array();
        $periodoId = 6;
        $gestionInicial = 2016;
        $gestionFinal = 2020;
        for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
          $periodo[] = $i;
        }
        $user = \Auth::user();
        switch ($request->modulo) {
          case 1:
              $etapasEstado = EtapasEstado::where('valor_campo_etapa', 'Recursos')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan',$periodoId)->get();
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
                      'msg' => "No puede modificar ya etapa concluida.")
                  );
                }
              }else{
                return \Response::json(array(
                    'error' => true,
                    'accion' => 1,
                    'msg' => "Activar el Cargado de los Recursos.")
                );
              }
          break;
          case 2:
            // code...
          break;
        }

        // return \Response::json(array(
        //     'error' => false,
        //     'title' => "Alerta!",
        //     'msg' => "Iniciar el Cargado de los Recursos.")
        // );

  }


  public function activarEtapa(Request $request)
  {
        $periodo = Array();
        $periodoId = 6;
        $gestionInicial = 2016;
        $gestionFinal = 2020;
        for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
          $periodo[] = $i;
        }
        $user = \Auth::user();
        switch ($request->etapa) {
          case 1:
            $etapa = new EtapasEstado();
            $etapa->id_institucion = $user->id_institucion;
            $etapa->campo_etapa = 'detalle';
            $etapa->valor_campo_etapa = "Recursos";
            $etapa->descripcion_campo_etapa = 'Este registro ayuda a controlar el estado del modulo de Recursos de un periodo';
            $etapa->estado_etapa = "En Elaboración";
            $etapa->id_periodo_plan = $periodoId;
            $etapa->save();
            return \Response::json(array(
                'error' => false,
                'accion' => 1,
                'msg' => "Se activo el control de estados del módulo seleccionado.")
            );
          break;
          case 2:

          break;
        }


  }

  public function estadoActualModulos(Request $request)
  {
        $periodo = Array();
        $periodoId = 6;
        $gestionInicial = 2016;
        $gestionFinal = 2020;
        for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
          $periodo[] = $i;
        }
        $user = \Auth::user();

        $moduloRecuros = EtapasEstado::where('valor_campo_etapa', 'Recursos')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan',$periodoId)->first();

        return \Response::json(array(
            'error' => false,
            'moduloRecursosEstado' => ($moduloRecuros->count() > 0)?$moduloRecuros->estado_etapa:'Inactivo',
            'msg' => "Se activo el control de estados del módulo seleccionado.")
        );



  }

  public function finalizarModulo(Request $request)
  {
        $periodo = Array();
        $periodoId = 6;
        $gestionInicial = 2016;
        $gestionFinal = 2020;
        for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
          $periodo[] = $i;
        }
        $user = \Auth::user();
        switch ($request->modulo) {
          case 1:
            \DB::table('sp_eta_estado_etapas')->where('id_institucion', $user->id_institucion)->where('valor_campo_etapa', 'Recursos')->where('id_periodo_plan', $periodoId)->update(['estado_etapa' => 'Concluido']);
            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'alert' => "success",
                'msg' => "Se elimino con exito.")
            );
          break;
          case 2:

          break;
        }


  }

}
