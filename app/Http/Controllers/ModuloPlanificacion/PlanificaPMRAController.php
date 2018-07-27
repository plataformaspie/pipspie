<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Models\ModuloPdes\Pilares;
use Illuminate\Http\Request;

class PlanificaPMRAController extends PlanificacionBaseController
{

    public function showPlanificacionPMRA(Request $request)
    {
        return view('ModuloPlanificacion.show-planificacion-pmra');
    }

 

    /*-----------------------------------------------------------------------------------------------------------
    |  Obtiene una lista de las acciones asociadas a un plan
    | $req = { p : id_plan }
     */
    public function listaPmraPlan(Request $req)
    {
        $listpmra = \DB::select("
                SELECT pmra.id, pmra.id_p, p.cod_p, p.nombre as nombre_p, 
                    p.descripcion as desc_p, p.logo as logo_p,
                    pmra.id_m, m.cod_m, m.nombre as nombre_m, m.descripcion as desc_m,
                    pmra.id_r, r.cod_r, r.nombre as nombre_r, r.descripcion as desc_r, r.sector,
                    pmra.id_a, a.cod_a, a.nombre as nombre_a, a.descripcion as desc_a, 
                    pmra.id_plan
                FROM sp_plan_articulacion_pdes pmra, pdes_pilares p, pdes_metas m, 
                            pdes_resultados r, pdes_acciones a, sp_planes pl
                WHERE pmra.id_a = a.id AND a.id_resultado = r.id AND r.id_meta = m.id AND m.id_pilar = p.id 
                AND pmra.id_plan = pl.id AND pmra.activo AND pl.activo 
                AND pmra.id_plan = ? 
                ORDER BY p.cod_p, m.cod_m, r.cod_r, a.cod_a ",[$req->p]);

        return response()->json([
            'data'=> $listpmra,
        ]);
    }

    /*-------------------------------------------------------------------------------------------------
    | Inserta una articulacion PDES a un plan en la tabla sp_plan_articulacion_pdes  (p,m,r,a, id_plan)
    | contiene $req{ id:id, id_a: id_accion, id_plan:id_plan, p: id_plan }
    | trae la propiedad $req->p: id_plan
     */
    public function savePMRA(Request $req)
    {
        //TODO verificar antes de modificar o eliminar que no se este utilizando
        $exist = \DB::select("SELECT * from sp_plan_articulacion_pdes WHERE id_plan = ? AND id_a = ? AND activo ", [$req->id_plan, $req->id_a]);
        if(count($exist)>0){
            return response()->json([
                'estado' => "error",
                'msg'    => 'La articulación entre la accion y el plan ya existe. ' 
            ]);
        }

        $arti = collect(\DB::select("SELECT p.id as id_p, m.id as id_m, r.id as id_r, a.id as id_a,
                                    p.cod_p, m.cod_m, r.cod_r, a.cod_a         
                            FROM pdes_pilares p, pdes_metas m, pdes_resultados r, pdes_acciones a
                            WHERE p.id = m.id_pilar AND m.id = r.id_meta AND r.id = a.id_resultado 
                            AND a.id = ? ", [$req->id_a]))->first();
        
        $plan_arti = new \stdClass();

        $plan_arti->id_p = $arti->id_p;
        $plan_arti->cod_p = $arti->cod_p;
        $plan_arti->id_m = $arti->id_m;
        $plan_arti->cod_m = $arti->cod_m;
        $plan_arti->id_r = $arti->id_r;
        $plan_arti->cod_r = $arti->cod_r;
        $plan_arti->id_a = $arti->id_a;
        $plan_arti->cod_a = $arti->cod_a;
        try {
            if ($req->id) // uPDATE
            {
                $plan_arti->id_user_updated = $this->user->id;
                $plan_arti->updated_at = \Carbon\Carbon::now(-4);
                \DB::table('sp_plan_articulacion_pdes')->where('id', $req->id)->update(get_object_vars($plan_arti));
            }
            else // INSERT
            {
                $plan_arti->id_plan = $req->id_plan;
                $plan_arti->activo = true;
                $plan_arti->id_user = $this->user->id;
                $plan_arti->created_at = \Carbon\Carbon::now(-4);                
                $plan_arti->id = \DB::table('sp_plan_articulacion_pdes')->insertGetId(get_object_vars($plan_arti));
            }

            return \Response::json([
                'accion' => $req->id ? 'update' : 'insert',
                'estado' => "success",
                'msg'    => "Se guardo con éxito."]);
        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'estado' => "error",
                'msg'    => $e->getMessage())
            );
        }
    }

    /*---------------------------------------------------------------------------------------
    | delete $req = {id: id_plan_articulacion_pdes}
     */
    public function deletePMRA(Request $req)
    {
        try{

            \DB::table('sp_plan_articulacion_pdes')->where('id', $req->id)->update(['activo'=>false]);
            return \Response::json([ 
                'estado' => "success",
                'msg' => "Se eliminó correctamente."
            ]);
        }
        catch (Exception $e) {
            return \Response::json([
                'estado' => "error",
                'msg' => $e->getMessage()
            ]);
        }
    }





}
