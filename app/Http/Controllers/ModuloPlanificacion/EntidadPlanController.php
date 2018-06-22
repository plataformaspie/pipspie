<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Http\Controllers\Controller;
use App\Models\ModuloPlanificacion\Entidades;
use App\Models\ModuloPlanificacion\EntidadPlan;
use App\Models\ModuloPlanificacion\TiposEntidades;
use Illuminate\Http\Request;

class EntidadPlanController extends PlanificacionBaseController
{     

    public function showPlanesInstitucion(Request $request)
    {
        return view('ModuloPlanificacion.show-planes-institucion');
    }

    public function listEntidadPlan(Request $request)
    {
        $idEntidad = $this->getIdEntidadFoco($request);
        $entidadPlanes = \DB::select("SELECT ep.id, ep.id_tipo_plan, ep.gestion_inicio, ep.gestion_fin, e.nombre, e.sigla, tp.sigla as plan
                                        FROM sp_entidad_plan ep, sp_entidades e, sp_tipos_planes tp 
                                        WHERE ep.activo = true AND ep.id_entidad = e.id 
                                        AND  ep.id_tipo_plan = tp.id AND e.institucion = {$idEntidad} 
                                        ORDER BY ep.id_tipo_plan"); 
        return \Response::json($entidadPlanes);
    }

    public function saveEntidadPlan(Request $request)
    {   
        $accion  = $request->id == null ? 'insert' : 'update';
        $entidadPlan = new \stdClass();
        $entidadPlan->id_entidad = $this->user->id_institucion;
        $entidadPlan->id_tipo_plan = $request->id_tipo_plan;
        $entidadPlan->gestion_inicio = $request->gestion_inicio;
        $entidadPlan->gestion_fin = $request->gestion_fin;

        try
        {
            if($accion == 'insert')
            {
                $entidadPlan->id_user = $this->user->id;
                $entidadPlan->activo = true;
                $entidadPlan->etapas_completadas = '';
                $entidadPlan->created_at = \Carbon\Carbon::now();
                $entidadPlan->id             = \DB::table('sp_entidad_plan')->insertGetId(get_object_vars($entidadPlan));
            }
            if($accion == 'update')
            {
                $entidadPlan->updated_at = \Carbon\Carbon::now();
                \DB::table('sp_entidad_plan')->where('id', $request->id)->update(get_object_vars($entidadPlan));
            }

            return \Response::json([
                'error' => false,
                'accion'=> $accion,
                'estado' => "Success",
                'msg'   => "Se guardó con exito.",
                'data'  => $entidadPlan,
            ]);
        }
        catch (Exception $e) 
        {
            return \Response::json(array(
              'error' => true,
              'estado' => "Error!",
              'msg' => $e->getMessage())
            );
        }
    }

    public function deleteEntidadPlan(Request $request)
    {
        try{
            $entidadPlan = EntidadPlan::find($request->id);
            $entidadPlan->activo = false;
            $entidadPlan->save()    ;
            return \Response::json([ 
                'error' => false,
                'estado' => "Success",
                'msg' => "Se eliminó el plan."
            ]);
        }
        catch (Exception $e) {
            return \Response::json([
                'error' => true,
                'estado' => "Error",
                'msg' => $e->getMessage()
            ]);
        }
    }


}
