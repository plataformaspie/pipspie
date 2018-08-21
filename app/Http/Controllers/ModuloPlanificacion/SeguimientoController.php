<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Http\Controllers\Controller;
use App\Models\ModuloPlanificacion\Entidades;
use App\Models\ModuloPlanificacion\Planes;
use App\Models\ModuloPlanificacion\TiposEntidades;
use Illuminate\Http\Request;

class SeguimientoController extends PlanificacionBaseController
{

    public function showSeguimiento(Request $request)
    {
        return view('ModuloPlanificacion.show-seguimiento');
    }

    public function listIndicadores(Request $req)
    {
        $indR = collect(\DB::select("SELECT distinct pa.id as id_pmra, pa.cod_p, pa.cod_m, pa.cod_r, pa.cod_a, ari.id as id_arti_indicador, 
                            i.id as id_indicador, i.nombre as nombre_indicador, i.codp_nivel_pmra as nivel_indicador, um.nombre as unidad_medida, um.codigo as cod_unidad_medida,
                            i.alcance, i.variable , pl.cod_periodo_plan, pper.valor as gestion_ini, pper.valor2 as gestion_fin  
                            FROM sp_plan_articulacion_pdes pa, sp_arti_resultado_indicador ari, sp_indicadores i,
                            sp_parametros um, sp_planes pl, sp_parametros pper
                            WHERE pa.id = ari.id_plan_articulacion_pdes  
                            AND ari.id_indicador = i.id AND um.id = i.idp_unidad AND pl.cod_periodo_plan = pper.codigo AND pper.categoria='periodo_plan'
                            AND pa.activo AND ari.activo AND i.activo 
                            AND pa.codp_nivel_articulacion = 'r' AND i.codp_nivel_pmra = 'r'
                            AND pa.id_plan = ? ORDER BY i.nombre", [$req->p]) );

        $indA = collect(\DB::select(" SELECT distinct pa.id as id_pmra, pa.cod_p, pa.cod_m, pa.cod_r, pa.cod_a, appi.id as id_arti_indicador, 
                                i.id as id_indicador, i.nombre as nombre_indicador, i.codp_nivel_pmra as nivel_indicador, um.nombre as unidad_medida, um.codigo as cod_unidad_medida,
                                i.alcance, i.variable , pl.cod_periodo_plan, pper.valor as gestion_ini, pper.valor2 as gestion_fin  
                                FROM sp_plan_articulacion_pdes pa, sp_arti_pdes_proyecto app, sp_arti_pdes_proyecto_indicador appi, sp_indicadores i,
                                sp_parametros um, sp_planes pl, sp_parametros pper
                                WHERE pa.id = app.id_plan_articulacion_pdes AND app.id = appi.id_arti_pdes_proyecto 
                                AND appi.id_indicador = i.id AND um.id = i.idp_unidad AND pl.cod_periodo_plan = pper.codigo AND pper.categoria='periodo_plan'
                                AND pa.activo AND app.activo AND appi.activo AND i.activo 
                                AND pa.codp_nivel_articulacion = 'a' AND i.codp_nivel_pmra = 'a'
                                AND pa.id_plan = ? ORDER BY i.nombre", [$req->p]) );
        $inds = $indR;

        foreach ($indA as $key => $value) {
            $inds[] = $value;
        };
        foreach ($inds as $key => $elem) {
            $lineabase = collect(\DB::select("SELECT ie.id as id_indicador_ejecucion, ie.gestion, ie.dato 
                    FROM sp_indicadores_ejecucion ie WHERE ie.id_arti_indicador = {$elem->id_arti_indicador} AND ie.codp_nivel_pmra = '{$elem->nivel_indicador}' AND ie.gestion < {$elem->gestion_ini} AND ie.dato is not null 
                    ORDER BY gestion desc "))->first() ; 
            if($lineabase) { 
                    $elem->id_indicador_ejecucion = $lineabase->id_indicador_ejecucion;
                    $elem->linea_base = $lineabase->dato;
                    $elem->linea_base_gestion = $lineabase->gestion;
                }
        }
        
        return \Response::json([
            'data' => $inds,
        ]);
    }

    public function datosIndicador(Request $req){
        $prog = \DB::select("SELECT id , gestion, dato, id_arti_indicador, codp_nivel_pmra from sp_indicadores_programacion WHERE id_arti_indicador = ? AND activo order by gestion" , [$req->id_arti_indicador]);
        $ej = \DB::select("SELECT id , gestion, dato, id_arti_indicador, codp_nivel_pmra from sp_indicadores_ejecucion WHERE id_arti_indicador = ? AND activo order by gestion" , [$req->id_arti_indicador]);
        return response()->json([
            'programacion' => $prog, 
            'ejecucion' => $ej
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


}
