<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ModuloPlanificacion\Riesgos;
use App\Models\ModuloPlanificacion\SistemasVida;
use App\Models\ModuloPlanificacion\Entidades;
use App\Models\ModuloPlanificacion\Planes;


class RiesgosController extends PlanificacionBaseController
{

  public function setRiesgos(Request $request)
  {
      $riesgos = Riesgos::join('sp_tipo_sectores as cs', 'cs.id', '=', 'sp_riesgos.id_sector')
                      ->where('sp_riesgos.id_plan',$request->p)
                      ->where('sp_riesgos.activo',true)
                      ->orderBy('jurisdiccion_territorial', 'asc')
                      ->select('sp_riesgos.*','cs.sector')
                      ->get();
      return \Response::json($riesgos);
  }

  public function saveRiesgo(Request $request)
  {
    $this->user= \Auth::user();

    if ($request->ri_id_plan)
    {
        //$idEntidad = $request->id_entidad;
        $planActivo = Planes::where('id', $request->ri_id_plan)->first();
        $idEntidad =$planActivo->id_entidad;
    }
    else
    {
        $this->user = \Auth::user();
        $idEntidad  = $this->user->id_institucion;
    }

    if(!$request->ri_id_riesgo){
        try{
            $riesgo = new Riesgos();
            $riesgo->jurisdiccion_territorial = $request->ri_jurisdiccion_territorial;
            $riesgo->id_sector = $request->ri_sector;
            $riesgo->sensibilidad = $request->ri_sensibilidad;
            $riesgo->amenaza = $request->ri_amenaza;
            $riesgo->adaptacion = $request->ri_adaptacion;
            $riesgo->vulnerabilidad = $request->ri_vulnerabilidad;
            $riesgo->vulnerabilidad_desc = $request->ri_vulnerabilidad_desc;
            $riesgo->id_entidad = $idEntidad;
            $riesgo->id_user = $this->user->id;
            $riesgo->id_plan = $request->ri_id_plan;
            $riesgo->activo = true;
            $riesgo->save();
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
      }else{
        try{
          $riesgo = Riesgos::find($request->ri_id_riesgo);
          $riesgo->jurisdiccion_territorial = $request->ri_jurisdiccion_territorial;
          $riesgo->id_sector = $request->ri_sector;
          $riesgo->sensibilidad = $request->ri_sensibilidad;
          $riesgo->amenaza = $request->ri_amenaza;
          $riesgo->adaptacion = $request->ri_adaptacion;
          $riesgo->vulnerabilidad = $request->ri_vulnerabilidad;
          $riesgo->vulnerabilidad_desc = $request->ri_vulnerabilidad_desc;
          $riesgo->id_user = $this->user->id;
          $riesgo->save();
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
  }


  public function dataSetRiesgo(Request $request)
  {
      $riesgo = Riesgos::find($request->id);
      return \Response::json($riesgo);
  }

  public function deleteRiesgo(Request $request)
  {

        try{
            $riesgo = Riesgos::find($request->id);
            $riesgo->activo = false;
            $riesgo->save();
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

  public function updateComboJurisdiccionTerritorial(Request $request)
  {
     $sistemasVida = SistemasVida::where('id_plan',$request->p )
                    ->where('activo',true )
                    ->groupBy('jurisdiccion_territorial')
                    ->orderBy('jurisdiccion_territorial','ASC')
                    ->select('jurisdiccion_territorial')
                    ->get();
      return \Response::json($sistemasVida);
  }

}
