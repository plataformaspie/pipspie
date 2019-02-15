<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlanificacionTerritorial\Parametros;
use App\Models\PlanificacionTerritorial\Deudas;
use App\Models\PlanificacionTerritorial\EntidadAcreedora;

class DeudasController extends BasecontrollerController
{
  public function listaTipoDeudas(Request $request)
  {
      $user = \Auth::user();
      $parametros = Parametros::where('categoria', 'tipo_deudas')
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
      $periodoActual = $this->periodoActual();
      $totalesGeneral = $this->totalesPlanificacion();

      $totalesDeudasGestion = \DB::select("
      SELECT fuente.nombre as gestion,
      (
        SELECT SUM(monto)
        FROM sp_eta_deudas_eta
        WHERE activo = true
        AND id_institucion = ".$user->id_institucion."
        AND gestion = fuente.codigo::int
      ) as total
      FROM(
        SELECT *
        from sp_parametros pa
        WHERE activo = TRUE
        AND categoria = 'gestiones'
        AND codigo BETWEEN '".$periodoActual['gestionInicial']."' AND '".$periodoActual['gestionFinal']."'
        ORDER BY codigo ASC
      ) as fuente");




      $arrayOtros = EntidadAcreedora::where('id_institucion',$user->id_institucion)->where('activo', true)->orderby('id', 'ASC')->get();
      $otrosIngresosRecursosGestiones = \DB::select("SELECT id,id_entidad_acreedora,gestion,monto
      FROM sp_eta_deudas_eta
      WHERE id_institucion = ".$user->id_institucion."
      and activo = true
      ORDER BY id_entidad_acreedora,gestion ASC");
      $arrayOtrosIngresosRecursosCreadosGestiones  = array();
      foreach ($otrosIngresosRecursosGestiones as $item) {
        $arrayOtrosIngresosRecursosCreadosGestiones['datos'][$item->id_entidad_acreedora][$item->gestion] = $item->monto;
        $arrayOtrosIngresosRecursosCreadosGestiones['ids'][$item->id_entidad_acreedora][$item->gestion] = $item->id;
      }

      return \Response::json([
        'parametros' => $parametros,
        'grupos' => $grupos,
        'periodoActivo' => $periodoActual['gestionesPeriodo'],
        'totales' => $totalesDeudasGestion,
        'totalRecursos' => $totalesGeneral['totalRecursos'],
        'totalDeuda' => $totalesGeneral['totalDeudas'],
        'otrosIngresos' => $arrayOtros,
        'otrosIngresosRecursosCreadosGestiones' => $arrayOtrosIngresosRecursosCreadosGestiones
      ]);

  }
  
  public function saveDeudas(Request $request)
    {
      $periodoActual = $this->periodoActual();
      $user = \Auth::user();

      if($request->id_otro == 0){
          try{

              $otro = new EntidadAcreedora();
              $otro->id_institucion = $user->id_institucion;
              $otro->entidad_acreedora = $request->entidad_acreedora;
              $otro->activo = true;
              $otro->id_user_created = $user->id;
              $otro->save();


              foreach ($request->datos as $k => $v) {
                  $recurso = new Deudas();
                  $recurso->id_institucion = $user->id_institucion;
                  $recurso->id_entidad_acreedora = $otro->id;
                  $recurso->id_tipo_deuda = $request->tipo_deuda;
                  $recurso->gestion = $periodoActual['gestionesPeriodo'][$k];
                  if($v){
                  $recurso->monto = $this->format_numerica_db($v,$this->decimal_simbolo($v));
                  }else{
                  $recurso->monto = 0;
                  }
                  $recurso->activo = true;
                  $recurso->id_user_created = $user->id;
                  $recurso->save();
              }
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
      }else{

          try{

              $otro =  EntidadAcreedora::find($request->id_otro);
              $otro->entidad_acreedora = $request->entidad_acreedora;
              $otro->id_user_updated= $user->id;
              $otro->save();

              foreach ($request->datos as $k => $v) {
                  $recurso = Deudas::find($request->ids[$k]);
                  $recurso->gestion = $periodoActual['gestionesPeriodo'][$k];
                  if($v){
                  $recurso->monto = $this->format_numerica_db($v,$this->decimal_simbolo($v));
                  }else{
                  $recurso->monto = 0;
                  }
                  $recurso->id_user_updated = $user->id;
                  $recurso->save();
              }
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


  public function deleteDeuda(Request $request)
  {

    $user = \Auth::user();
    try{
          $otro =  EntidadAcreedora::find($request->id_otro);
          $otro->activo = false;
          $otro->id_user_updated = $user->id;
          $otro->save();
          \DB::table('sp_eta_deudas_eta')->where('id_entidad_acreedora', $request->id_otro)->update(['activo' => false,'id_user_updated'=>$user->id]);
          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'alert' => "success",
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
