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


    public function saveEjecuciones(Request $req)
    {
        $ejecuciones = $req->ejecuciones;
        foreach ($ejecuciones as $ej) {
            $ej = (object)$ej;
            $ej->id_arti_indicador = $req->id_arti_indicador;
            $ej->codp_nivel_pmra = $req->codp_nivel_pmra;
            $this->saveObjectTabla($ej, 'sp_indicadores_ejecucion');
        }
        return \Response::json([
                'error' => false,
                'estado' => "Success",
                'msg'   => "Se guardó con exito.",
                // 'data'  => $plan,
        ]);
       
    }


    /*--------------------------------------------------------------------------------------------------------------
    |   Funcion Generica para incsertar o modificar las tablas
     */
    private function saveObjectTabla($obj, $tabla)
    {
        try{
            if ($obj->id) // UPDATE 
            {
                $obj->activo =  true;
                $obj->id_user_updated = $this->user->id;
                $obj->updated_at = \Carbon\Carbon::now(-4);
                \DB::table($tabla)->where('id', $obj->id)->update(get_object_vars($obj));
                return $obj->id;
            }
            else // INSERT
            {
                unset($obj->id);
                $obj->activo = true;
                $obj->id_user =  $this->user->id;
                $obj->created_at = \Carbon\Carbon::now(-4);
                return \DB::table($tabla)->insertGetId(get_object_vars($obj));
            }
        }
        catch (Exception $e)
        {
            return response()->json(array(
                'estado' => "error",
                'msg'    => $e->getMessage())
            );
        }
    }
 


}
