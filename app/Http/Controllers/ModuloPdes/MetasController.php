<?php

namespace App\Http\Controllers\ModuloPdes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ModuloPdes\Metas;

class MetasController extends Controller
{
  public function listarMetas(Request $request)
  {
   if($request->ajax()) {
        $metas = Metas::select("id", \DB::raw("'M'||cod_m as nombre"),"pilar")->orderBy('cod_m','asc')->get();
        return \Response::json($metas);
    }
  }

  public function datosMeta(Request $request)
  {

   if($request->ajax()) {

        $dMeta = \DB::select("select p.nombre as pilar_nombre,
                                  p.descripcion as pilar_desc,
                                  m.*
                                  from spie_metas m
                                  inner join spie_pilares p ON m.pilar = p.id
                                  where m.id = ?", [$request->get('meta')]);
      $html = '<div class="row">';
        foreach ($dMeta as $m) {
          $html .='<div class="col-md-4 col-sm-4 col-xs-12">
                      <b>'.$m->pilar_nombre.'</b>: '.$m->pilar_desc.'</br>
                      <b>'.$m->nombre.'</b>: '.$m->descripcion.'
                  </div>';
        }
      $totalesFiltro = \DB::select("SELECT tab.numero_proyectos,
                                    tab.total_costo,
                                    (
                                    SELECT SUM(monto)
                                    FROM spie_presupuesto_proyectos_pdes
                                    INNER JOIN spie_proyectos_pdes ON spie_presupuesto_proyectos_pdes.id_proyecto_pdes = spie_proyectos_pdes.id
                                    WHERE spie_proyectos_pdes.cod_p = ".$dMeta[0]->pilar."
                                    AND spie_proyectos_pdes.cod_m = ".$dMeta[0]->cod_m."
                                    ) as total_quinquenio
                                    FROM(
                                    SELECT count(*) as numero_proyectos,SUM(costo_total) total_costo
                                    FROM spie_proyectos_pdes
                                    WHERE spie_proyectos_pdes.cod_p = ".$dMeta[0]->pilar."
                                    AND spie_proyectos_pdes.cod_m = ".$dMeta[0]->cod_m."
                                    ) as tab");

      foreach ($totalesFiltro as $t) {
        $html .= '<div class="col-md-2 col-sm-4 col-xs-12">
                    <b>Nº Total Proyectos: </b>'.$t->numero_proyectos.'
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <b>Costo Total: </b>Bs.'.number_format($t->total_costo,2).'
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <b>Costo quinquenio: </b>Bs.'.number_format($t->total_quinquenio,2).'
                </div>';
      }

        $html .= '</div>';
        return \Response::json($html);
    }
  }
}
