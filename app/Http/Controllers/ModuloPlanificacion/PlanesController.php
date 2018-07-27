<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Http\Controllers\Controller;
use App\Models\ModuloPlanificacion\Entidades;
use App\Models\ModuloPlanificacion\Planes;
use App\Models\ModuloPlanificacion\TiposEntidades;
use Illuminate\Http\Request;

class PlanesController extends PlanificacionBaseController
{

    public function showPlanesInstitucion(Request $request)
    {
        return view('ModuloPlanificacion.show-planes');
    }

    public function listPlanes(Request $request)
    {
        $idEntidadFoco = $this->getIdEntidadFoco($request);
        $planes = \DB::select("SELECT p.id, p.id_tipo_plan, p.descripcion as descripcion_plan, per.valor as gestion_inicio, per.valor2 as gestion_fin, per.descripcion as periodo_descripcion, p.etapas_completadas, e.nombre as nombre_entidad, e.sigla as sigla_entidad, tp.codigo as cod_tipo_plan
                                        FROM sp_planes p, sp_entidades e, sp_parametros tp, sp_parametros per
                                        WHERE p.activo = true AND p.id_entidad = e.id
                                        AND  p.id_tipo_plan = tp.id AND tp.categoria = 'tipo_plan'
                                        AND per.categoria = 'periodo_plan' AND per.activo AND per.codigo = p.cod_periodo_plan
                                        AND e.institucion = {$idEntidadFoco}
                                        ORDER BY p.id_tipo_plan");
        $periodoVigente = \DB::select("SELECT * from sp_parametros WHERE categoria = 'periodo_plan' AND activo ")[0];
        return \Response::json([
            'data' => $planes,
            'periodo_vigente' => $periodoVigente
        ]);
    }

    public function savePlan(Request $request)
    {
        $accion  = $request->id == null ? 'insert' : 'update';
        $plan = new \stdClass();
        $plan->id_entidad = $this->user->id_institucion;
        $plan->id_tipo_plan = $request->id_tipo_plan;
        $plan->descripcion = $request->descripcion;

        // $plan->gestion_inicio = $request->gestion_inicio;
        // $plan->gestion_fin = $request->gestion_fin;

        try
        {
            if($accion == 'insert')
            {
                $periodoVigente = \DB::select("SELECT * from sp_parametros WHERE categoria = 'periodo_plan' AND activo ")[0];
                $plan->id_user = $this->user->id;
                $plan->activo = true;
                $plan->etapas_completadas = '';
                $plan->cod_periodo_plan = $periodoVigente->codigo;
                $plan->created_at = \Carbon\Carbon::now(-4);
                $plan->id  = \DB::table('sp_planes')->insertGetId(get_object_vars($plan));
            }
            if($accion == 'update')
            {
                $plan->updated_at = \Carbon\Carbon::now(-4);
                $plan->id_user_updated = $this->user->id;
                \DB::table('sp_planes')->where('id', $request->id)->update(get_object_vars($plan));
            }

            return \Response::json([
                'error' => false,
                'accion'=> $accion,
                'estado' => "Success",
                'msg'   => "Se guardó con exito.",
                'data'  => $plan,
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

    public function deletePlan(Request $request)
    {
        try{

            $plan = Planes::find($request->id);
            $plan->activo = false;
            $plan->save()    ;
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

    /*
    |------------------------------------------------------------------
    | Actualiza el vector de la columna estapas_completadas en la tabla sp_planes
    |                   req = { p: id_plan, id_menu: id_menu, agregar: true }
    | remove por defecto es false; si se manda true entonces quitara el elemento si es que existe
     */
    public function actualizaEtapas(Request $req)
    {

        $plan = \DB::table('sp_planes')->where('id', $req->p)->get()->first();
        $etapasComp = collect(array_where(explode('|', $plan->etapas_completadas), function ($idm) {
                                                        return $idm != '';
                                                    }));
        if($req->agregar == '1'){
            $etapasComp[] = $req->id_menu;
            $etapasComp = $etapasComp->unique();
        }
        else{
            $etapasComp = $etapasComp->filter(
                function($val,$key) use ($req){
                    return $val != $req->id_menu;
                });
        }

        $etapasCompletadas = $etapasComp->reduce(
            function($carry, $elem){
                return $carry . $elem . '|';
            }, '|');

        \DB::table('sp_planes')->where('id', $req->p)->update(['etapas_completadas' => $etapasCompletadas]);
        return response()->json([
            'r'=>$etapasCompletadas]);
    }


    public function showReviewPlanesInstitucion(Request $request)
    {
        return view('ModuloPlanificacion.show-review-planes');
    }




}
