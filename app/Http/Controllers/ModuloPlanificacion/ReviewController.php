<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Controllers\Controller;
use App\Models\ModuloPlanificacion\Entidades;
use App\Models\ModuloPlanificacion\EntidadPlan;
use App\Models\ModuloPlanificacion\TiposEntidades;
use Illuminate\Http\Request;

class ReviewController extends PlanificacionBaseController
{

      public function showReviewPlanesInstitucion(Request $request)
      {
          return view('ModuloPlanificacion.show-review-planes');
      }


      public function apiSetListMinisterios(Request $request)
      {
          //listado de Entidades nivel Ministerio
          $entidades = \DB::select("SELECT e.id, e.nombre as nombre_entidad,
                                    e.sigla as sigla_entidad, te.descripcion,
                                    e.codigo_mef, pr.descripcion as periodo_descripcion,
                                    pr_tp.descripcion as descripcion_plan,pr_tp.codigo as cod_tipo_plan,
                                    pr.valor as gestion_inicio, pr.valor2 as gestion_fin,
                                    pl.id as id_plan
                                    FROM sp_entidades e
                                    INNER JOIN sp_tipos_entidades  te ON e.id_tipo = te.id
                                    LEFT JOIN sp_planes pl ON e.id = pl.id_entidad
                                    LEFT JOIN sp_parametros pr ON pl.cod_periodo_plan = pr.codigo
                                    LEFT JOIN sp_parametros pr_tp ON pl.id_tipo_plan = pr_tp.id
                                    WHERE te.id = 1
                                    AND e.activo = true
                                    ORDER BY e.codigo_mef ASC");
          $periodoVigente = \DB::select("SELECT * from sp_parametros WHERE categoria = 'periodo_plan' AND activo ")[0];
          //dd($periodoVigente);
          return \Response::json([
              'data' => $entidades,
              'periodo_vigente' => $periodoVigente
          ]);
      }
      public function apiSetListSinCabeza(Request $request)
      {
          //listado de Entidades nivel Ministerio
          $entidades = \DB::select("SELECT e.id, e.nombre as nombre_entidad,
                                    e.sigla as sigla_entidad, te.descripcion,
                                    e.codigo_mef, pr.descripcion as periodo_descripcion,
                                    pr_tp.descripcion as descripcion_plan,pr_tp.codigo as cod_tipo_plan,
                                    pr.valor as gestion_inicio, pr.valor2 as gestion_fin,
                                    pl.id as id_plan
                                    FROM sp_entidades e
                                    INNER JOIN sp_tipos_entidades  te ON e.id_tipo = te.id
                                    LEFT JOIN sp_planes pl ON e.id = pl.id_entidad
                                    LEFT JOIN sp_parametros pr ON pl.cod_periodo_plan = pr.codigo
                                    LEFT JOIN sp_parametros pr_tp ON pl.id_tipo_plan = pr_tp.id
                                    WHERE te.id = 10
                                    AND e.activo = true
                                    ORDER BY e.codigo_mef ASC");
          $periodoVigente = \DB::select("SELECT * from sp_parametros WHERE categoria = 'periodo_plan' AND activo ")[0];
          //dd($periodoVigente);
          return \Response::json([
              'data' => $entidades,
              'periodo_vigente' => $periodoVigente
          ]);
      }
      public function apiSetListMultis(Request $request)
      {
          //listado de Entidades nivel Ministerio
          $entidades = \DB::select("SELECT e.id, e.nombre as nombre_entidad,
                                    e.sigla as sigla_entidad, te.descripcion,
                                    e.codigo_mef, pr.descripcion as periodo_descripcion,
                                    pr_tp.descripcion as descripcion_plan,pr_tp.codigo as cod_tipo_plan,
                                    pr.valor as gestion_inicio, pr.valor2 as gestion_fin,
                                    pl.id as id_plan
                                    FROM sp_entidades e
                                    INNER JOIN sp_tipos_entidades  te ON e.id_tipo = te.id
                                    LEFT JOIN sp_planes pl ON e.id = pl.id_entidad
                                    LEFT JOIN sp_parametros pr ON pl.cod_periodo_plan = pr.codigo
                                    LEFT JOIN sp_parametros pr_tp ON pl.id_tipo_plan = pr_tp.id
                                    WHERE te.id = 11
                                    AND e.activo = true
                                    ORDER BY e.codigo_mef ASC");
          $periodoVigente = \DB::select("SELECT * from sp_parametros WHERE categoria = 'periodo_plan' AND activo ")[0];
          //dd($periodoVigente);
          return \Response::json([
              'data' => $entidades,
              'periodo_vigente' => $periodoVigente
          ]);
      }

}
