<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlanificacionTerritorial\Parametros;
use App\Models\PlanificacionTerritorial\Recursos;
use App\Models\PlanificacionTerritorial\OtrosIngresos;

class RecursosController extends BasecontrollerController
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

      $periodoActual = $this->periodoActual();
      $totalesGeneral = $this->totalesPlanificacion();

      $totalesRecursosGestiones = \DB::select("
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
        AND codigo BETWEEN '".$periodoActual['gestionInicial']."' AND '".$periodoActual['gestionFinal']."'
        ORDER BY codigo ASC
      ) as fuente");


      $recursosCreados = \DB::select("SELECT id_tipo_recurso
      FROM sp_eta_recursos_eta
      WHERE id_institucion = ".$user->id_institucion."
      AND activo = true
      GROUP BY id_tipo_recurso
      ORDER BY id_tipo_recurso ASC");

      $arrayRecursosCreados = Array();
      foreach ($recursosCreados as $item) {
        $arrayRecursosCreados[] = $item->id_tipo_recurso;
      }


      $recursosCreadosGestiones = \DB::select("SELECT id,id_tipo_recurso,gestion,monto
      FROM sp_eta_recursos_eta
      WHERE id_institucion = ".$user->id_institucion."
      and activo = true
      ORDER BY id_tipo_recurso,gestion ASC");

      $arrayRecursosCreadosGestiones  = array();
      foreach ($recursosCreadosGestiones as $item) {
        $arrayRecursosCreadosGestiones['monto'][$item->id_tipo_recurso][$item->gestion] = $item->monto;
        $arrayRecursosCreadosGestiones['id'][$item->id_tipo_recurso][$item->gestion] = $item->id;
      }


      $arrayOtros = OtrosIngresos::where('id_institucion',$user->id_institucion)->where('activo', true)->orderby('id', 'ASC')->get();
      $otrosIngresosRecursosGestiones = \DB::select("SELECT id,id_otro_ingreso,gestion,monto
      FROM sp_eta_recursos_eta
      WHERE id_institucion = ".$user->id_institucion."
      and activo = true
      AND id_otro_ingreso is not null
      ORDER BY id_otro_ingreso,gestion ASC");
      $arrayOtrosIngresosRecursosCreadosGestiones  = array();
      foreach ($otrosIngresosRecursosGestiones as $item) {
        $arrayOtrosIngresosRecursosCreadosGestiones['datos'][$item->id_otro_ingreso][$item->gestion] = $item->monto;
        $arrayOtrosIngresosRecursosCreadosGestiones['ids'][$item->id_otro_ingreso][$item->gestion] = $item->id;
      }

      return \Response::json([
        'parametros' => $parametros,
        'grupos' => $grupos,
        'periodoActivo' => $periodoActual['gestionesPeriodo'],
        'totales' => $totalesRecursosGestiones,
        'totalPresupuesto' => $totalesGeneral['totalRecursos'],
        'recursosCreados' => $arrayRecursosCreados,
        'recursosCreadosGestiones' => $arrayRecursosCreadosGestiones,
        'otrosIngresos' => $arrayOtros,
        'otrosIngresosRecursosCreadosGestiones' => $arrayOtrosIngresosRecursosCreadosGestiones
      ]);

  }

  public function saveRecursoTipo(Request $request)
  {
    $periodoActual = $this->periodoActual();
    $user = \Auth::user();

    try{
        foreach ($request->datos as $k => $v) {
            $this->decimal_simbolo($v);
            $recurso = new Recursos();
            $recurso->id_institucion = $user->id_institucion;
            $recurso->id_tipo_recurso = $request->tipo_recurso;
            $recurso->gestion = $periodoActual['gestionesPeriodo'][$k];
            $recurso->monto = (trim($v)!='')?$this->format_numerica_db($v,$this->decimal_simbolo($v)):0;
            $recurso->activo = true;
            $recurso->id_user_created = $user->id;
            $recurso->save();
        }
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

  public function saveUpdateRecursoTipo(Request $request)
  {
    $user = \Auth::user();

    try{
        foreach ($request->datos as $k => $v) {
            $recurso = Recursos::find($request->id[$k]);
            $recurso->monto = (trim($v)!='')?$this->format_numerica_db($v,$this->decimal_simbolo($v)):0;
            $recurso->id_user_updated = $user->id;
            $recurso->save();
        }
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
  }



  public function deleteRecurso(Request $request)
  {

    $user = \Auth::user();
    try{
        foreach ($request->id as $k => $v) {
            $recurso = Recursos::find($v);
            $recurso->activo = false;
            $recurso->id_user_updated = $user->id;
            $recurso->save();
        }
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

  }



    public function saveOtro(Request $request)
    {
      $periodoActual = $this->periodoActual();
      $user = \Auth::user();

      if($request->id_otro == 0){
          try{

              $otro = new OtrosIngresos();
              $otro->id_institucion = $user->id_institucion;
              $otro->concepto = $request->concepto;
              $otro->fuente_financiamiento = $request->fuente_financiamiento;
              $otro->organismo_financiador = $request->organismo_financiador;
              $otro->rubro = $request->rubro;
              $otro->entidad_otorgante = $request->entidad_otorgante;
              $otro->activo = true;
              $otro->id_user_created = $user->id;
              $otro->save();


              foreach ($request->datos as $k => $v) {
                  $recurso = new Recursos();
                  $recurso->id_institucion = $user->id_institucion;
                  $recurso->id_otro_ingreso = $otro->id;
                  $recurso->gestion = $periodoActual['gestionesPeriodo'][$k];
                  $recurso->monto = (trim($v)!='')?$this->format_numerica_db($v,$this->decimal_simbolo($v)):0;
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

              $otro =  OtrosIngresos::find($request->id_otro);
              $otro->concepto = $request->concepto;
              $otro->fuente_financiamiento = $request->fuente_financiamiento;
              $otro->organismo_financiador = $request->organismo_financiador;
              $otro->rubro = $request->rubro;
              $otro->entidad_otorgante = $request->entidad_otorgante;
              $otro->id_user_updated= $user->id;
              $otro->save();

              foreach ($request->datos as $k => $v) {
                  $recurso = Recursos::find($request->ids[$k]);
                  $recurso->gestion = $periodoActual['gestionesPeriodo'][$k];
                  $recurso->monto = (trim($v)!='')?$this->format_numerica_db($v,$this->decimal_simbolo($v)):0;
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


  public function deleteOtro(Request $request)
  {

    $user = \Auth::user();
    try{
          $otro =  OtrosIngresos::find($request->id_otro);
          $otro->activo = false;
          $otro->id_user_updated = $user->id;
          $otro->save();
          \DB::table('sp_eta_recursos_eta')->where('id_otro_ingreso', $request->id_otro)->update(['activo' => false,'id_user_updated' => $user->id]);
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
