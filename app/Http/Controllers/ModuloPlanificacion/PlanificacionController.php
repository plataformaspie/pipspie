<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ModuloPlanificacion\Diagnosticos;
use App\Models\ModuloPlanificacion\DiagnosticosComparativos;
use App\Models\ModuloPlanificacion\Metricas;
use App\Models\ModuloPlanificacion\EnfoquesPoliticos;
use App\Models\ModuloPlanificacion\Entidades;
use App\Models\ModuloPdes\Pilares;

class PlanificacionController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    // $this->middleware('auth');
   $this->middleware(function ($request, $next)
   {
    $user    = \Auth::user();
    $ModulosMenus = IndexController::GeneraMenus($user);

    \View::share($ModulosMenus);

    return $next($request);
  });
 }
  
  public function showDiagnostico()
  {
      $metricas = Metricas::orderBy('simbolo','asc')->get();
      return view('ModuloPlanificacion.show-diagnostico',['metricas' => $metricas]);
  }
  public function showEnfoque(Request $request)
  {
      if($request->id_entidad)
      {
        $idEntidad = $request->id_entidad;
      }
      else
      {
        $this->user = \Auth::user();
        $idEntidad = $this->user->id_institucion;
      }


      $pilares = Pilares::orderBy('cod_p','asc')->get();
      $enfoque = EnfoquesPoliticos::where('id_entidad',$idEntidad)->get();

       return view('ModuloPlanificacion.show-enfoque',['pilares' => $pilares,'enfoque' => $enfoque[0]->enfoque_politico]);
  }

  public function setDiagnostico(Request $request)
  {
    if($request->id_entidad)
    {
      $idEntidad = $request->id_entidad;
    }
    else
    {
      $this->user = \Auth::user();
      $idEntidad = $this->user->id_institucion;
    }


    $diagnostico = \DB::select("SELECT *,
                                    (
                                    SELECT dato
                                    FROM sp_diagnostico_comparativo
                                    WHERE diagnostico_id = tab.id
                                    AND gestion = 2011
                                    ) as _2011,
                                    (
                                    SELECT dato
                                    FROM sp_diagnostico_comparativo
                                    WHERE diagnostico_id = tab.id
                                    AND gestion = 2012
                                    ) as _2012,
                                    (
                                    SELECT dato
                                    FROM sp_diagnostico_comparativo
                                    WHERE diagnostico_id = tab.id
                                    AND gestion = 2013
                                    ) as _2013,
                                    (
                                    SELECT dato
                                    FROM sp_diagnostico_comparativo
                                    WHERE diagnostico_id = tab.id
                                    AND gestion = 2014
                                    ) as _2014,
                                    (
                                    SELECT dato
                                    FROM sp_diagnostico_comparativo
                                    WHERE diagnostico_id = tab.id
                                    AND gestion = 2015
                                    ) as _2015
                                    FROM (

                                    SELECT d.*, m.simbolo
                                    FROM sp_diagnostico d
                                    INNER JOIN sp_metricas m ON d.unidad = m.id
                                    WHERE d.entidad = ".$idEntidad."
                                    AND d.activo = true
                                    ) tab");
    $i=1;
    $datos = array();
    foreach ($diagnostico as $d) {
      $datos[$i] = array(
                'id' => $d->id,
                'contador' => $i,
                'entidad' => $d->entidad,
                'indicador' => $d->indicador,
                'fuente_verificacion' => $d->fuente_verificacion,
                'variable' => $d->variable,
                'simbolo' => $d->simbolo,
                'grafica' =>$d->grafica,
                '2011' =>$d->_2011." ".$d->simbolo,
                '2012' =>$d->_2012." ".$d->simbolo,
                '2013' =>$d->_2013." ".$d->simbolo,
                '2014' =>$d->_2014." ".$d->simbolo,
                '2015' =>$d->_2015." ".$d->simbolo,
                'grafica' =>array($d->_2011,$d->_2012,$d->_2013,$d->_2014,$d->_2015)
                //'grafica' =>[11,7,3,8,6,2,2,4,3,8,5,11,7,11,11,4,5,6,5,9,9,5,11,2,8,9,14,12,9,8]
      );
      $i++;
    }
    return \Response::json(array_values($datos));
  }

  public function dataSetDiagnostico(Request $request)
  {
    $diagnostico = Diagnosticos::find($request->id);
    $evolucion = DiagnosticosComparativos::where('diagnostico_id',$diagnostico->id)->orderBy('gestion', 'asc')->get();


    $datos["diagnostico"] = $diagnostico;
    $datos["evolucion"] = $evolucion;

    return \Response::json($datos);
  }

  public function saveDataEdit(Request $request)
  {
    $periodo = array(2011,2012,2013,2014,2015);

    try{
          $diagnostico = Diagnosticos::find($request->mod_id);
          $diagnostico->variable = $request->mod_variable;
          $diagnostico->indicador = $request->mod_indicador;
          $diagnostico->unidad = $request->mod_unidad;
          $diagnostico->save();

          foreach ($periodo as $key => $value) {
            $evoluacion = DiagnosticosComparativos::where('gestion', $value)->where('diagnostico_id', $diagnostico->id)->first();
            $evoluacion->dato = $request->input('mod_dato_'.$value);
            $evoluacion->save();
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

  public function saveDataNew(Request $request)
  {
    if($request->id_entidad)
    {
      $idEntidad = $request->id_entidad;
    }
    else
    {
      $this->user = \Auth::user();
      $idEntidad = $this->user->id_institucion;
    }

    $periodo = array(2011,2012,2013,2014,2015);
    //$this->user= \Auth::user();

    try{
          $diagnostico = new Diagnosticos();
          $diagnostico->entidad = $idEntidad;
          $diagnostico->variable = $request->variable;
          $diagnostico->indicador = $request->indicador;
          $diagnostico->unidad = $request->unidad;
          $diagnostico->user_id = $this->user->id;
          $diagnostico->activo = true;
          $diagnostico->save();

          foreach ($periodo as $key => $value) {
            $evoluacion = new DiagnosticosComparativos();
            $evoluacion->gestion = $value;
            $evoluacion->dato = ($request->input('dato_'.$value))?$request->input('dato_'.$value):0;
            $evoluacion->diagnostico_id = $diagnostico->id;
            $evoluacion->save();
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

  public function deleteDiagnostico(Request $request)
  {
    $periodo = array(2011,2012,2013,2014,2015);

    try{
          $diagnostico = Diagnosticos::find($request->id);
          $diagnostico->activo = false;
          $diagnostico->save();

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



  public function dataEntidadEnfoque(Request $request)
  {
    if($request->id_entidad)
    {
      $idEntidad = $request->id_entidad;
    }
    else
    {
      $this->user = \Auth::user();
      $idEntidad = $this->user->id_institucion;
    }

    $enfoque = EnfoquesPoliticos::where('id_entidad', $idEntidad)->first();
    return \Response::json($enfoque);
  }

  public function saveEnfoqueEdit(Request $request)
  {
    if($request->id_entidad)
    {
      $idEntidad = $request->id_entidad;
    }
    else
    {
      $this->user = \Auth::user();
      $idEntidad = $this->user->id_institucion;
    }
    $periodo = array(2011,2012,2013,2014,2015);

    try{
          if($request->mod_id){
          $enfoque = EnfoquesPoliticos::find($request->mod_id);
          $enfoque->enfoque_politico = $request->mod_enfoque_politico;
          $enfoque->save();
        }else{
          $enfoque = new EnfoquesPoliticos();
          $enfoque->entidad = $idEntidad;
          $enfoque->periodo = 1;
          $enfoque->enfoque_politico = $request->mod_enfoque_politico;
          $enfoque->activo = true;
          $enfoque->save();
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










  /*public function dataSetDiagnostico(Request $request)
  {
    $diagnostico = Diagnosticos::find($request->id);
    $i=1;
    $datos = array();
    foreach ($diagnostico as $d) {

      //$evolucion = DiagnosticosComparativos::find($request->id);
      $datos[$i] = array(
                'id' => $d->id,
                'contador' => $i,
                'entidad' => $d->entidad,
                'variable' =>  $d->variable,
                'indicador' => $d->indicador,
                'unidad' => $d->unidad,
                'fuente_verificacion' => $d->fuente_verificacion,
                //'evoluacion' => $evolucion

      );
      $i++;
    }
    return \Response::json($datos);
  }*/



}
