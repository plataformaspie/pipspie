<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlanificacionTerritorial\Parametros;
use App\Models\PlanificacionTerritorial\Recursos;

class RecursosController extends Controller
{
  public function listaTipoRecursos(Request $request)
  {
      $user = \Auth::user();
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

      $periodo = Array();
      $gestionInicial = 2016;
      $gestionFinal = 2020;
      for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
        $periodo[] = $i;
      }

      $totales = \DB::select("
      SELECT fuente.nombre as gestion,
      (
        SELECT SUM(monto)
        FROM sp_eta_recursos_eta
        WHERE activo = true
        AND id_institucion = ".$user->id_institucion."
        AND gestion = fuente.codigo::int
      ) as total
      FROM(
        SELECT *
        from sp_parametros pa
        WHERE activo = TRUE
        AND categoria = 'gestiones'
        AND codigo BETWEEN '".$gestionInicial."' AND '".$gestionFinal."'
        ORDER BY codigo ASC
      ) as fuente");


      return \Response::json([
        'parametros' => $parametros,
        'grupos' => $grupos,
        'periodoActivo' => $periodo,
        'totales' => $totales
      ]);

  }

  public function saveRecursoTipo(Request $request)
  {
    $periodo = Array();
    $gestionInicial = 2016;
    $gestionFinal = 2020;
    for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
      $periodo[] = $i;
    }
    $user = \Auth::user();

    try{
        foreach ($request->datos as $k => $v) {
            $recurso = new Recursos();
            $recurso->id_institucion = $user->id_institucion;
            $recurso->id_tipo_recurso = $request->tipo_recurso;
            $recurso->gestion = $periodo[$k];
            $recurso->monto = $v;
            $recurso->activo = true;
            $recurso->save();
        }
          // foreach ($request->arc_archivo as $k => $v) {
          //       $archivos = new FuenteArchivosRespaldos();
          //       $archivos->id_fuente = $fuente->id;
          //       $archivos->nombre =  $request->arc_nombre[$k];
          //       $archivos->archivo = $request->arc_archivo[$k];
          //       $archivos->activo = true;
          //       $archivos->id_user = $this->user->id;
          //       $archivos->save();
          // }


        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se guardo con exito.")
        );

      }
      catch (Exception $e) {
          return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'msg' => $e->getMessage())
          );
      }


      return 1;

  }
}
