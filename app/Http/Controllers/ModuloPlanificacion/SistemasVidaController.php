<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ModuloPlanificacion\SistemasVida;
use App\Models\ModuloPlanificacion\Planes;

class SistemasVidaController extends PlanificacionBaseController
{

  public function setSistemasVida(Request $request)
  {
      $sistemasVida = SistemasVida::where('id_plan',$request->p)->where('activo', true)->orderBy('jurisdiccion_territorial', 'asc')->get();
      return \Response::json($sistemasVida);
  }

  public function saveSistemasVida(Request $request)
  {
    $this->user= \Auth::user();

    if ($request->sv_id_plan)
    {
        //$idEntidad = $request->id_entidad;
        $planActivo = Planes::where('id', $request->sv_id_plan)->first();
        $idEntidad =$planActivo->id_entidad;
    }
    else
    {
        $this->user = \Auth::user();
        $idEntidad  = $this->user->id_institucion;
    }

    if(!$request->sv_id_sis_vida){
        try{
            $sisVida = new SistemasVida();
            $sisVida->jurisdiccion_territorial = $request->sv_jurisdiccion_territorial;
            $sisVida->unidades_socioculturales = $request->sv_unidades_socioculturales;
            $sisVida->funciones_ambientales = $request->sv_funciones_valor;
            $sisVida->sis_produc_sustentables = $request->sv_sistemas_valor;
            $sisVida->pobreza = $request->sv_pobreza_valor;
            $sisVida->funciones_desc = $request->sv_funciones_desc;
            $sisVida->sistemas_desc = $request->sv_sistemas_desc;
            $sisVida->pobreza_desc = $request->sv_pobreza_desc;
            $sisVida->id_entidad = $idEntidad;
            $sisVida->id_user = $this->user->id;
            $sisVida->id_plan = $request->sv_id_plan;
            $sisVida->activo = true;
            $sisVida->save();
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
          $sisVida = SistemasVida::find($request->sv_id_sis_vida);
          $sisVida->jurisdiccion_territorial = $request->sv_jurisdiccion_territorial;
          $sisVida->unidades_socioculturales = $request->sv_unidades_socioculturales;
          $sisVida->funciones_ambientales = $request->sv_funciones_valor;
          $sisVida->sis_produc_sustentables = $request->sv_sistemas_valor;
          $sisVida->pobreza = $request->sv_pobreza_valor;
          $sisVida->funciones_desc = $request->sv_funciones_desc;
          $sisVida->sistemas_desc = $request->sv_sistemas_desc;
          $sisVida->pobreza_desc = $request->sv_pobreza_desc;
          $sisVida->id_entidad = $idEntidad;
          $sisVida->id_user = $this->user->id;
          $sisVida->id_plan = $request->sv_id_plan;
          $sisVida->save();


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



  public function dataSetSistemaVida(Request $request)
  {
      $sistemasVida = SistemasVida::find($request->id);
      return \Response::json($sistemasVida);
  }



  public function deleteSistemasVida(Request $request)
  {

        try{
            $sisVida = SistemasVida::find($request->id);
            $sisVida->activo = false;
            $sisVida->save();
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
