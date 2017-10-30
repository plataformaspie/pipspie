<?php

namespace App\Http\Controllers\ModuloPdes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ModuloPdes\Pilares;

class PilaresController extends Controller
{
  public function listarPilares(Request $request)
  {

   if($request->ajax()) {
        $pilares = Pilares::select("id", \DB::raw("'P'||cod_p as nombre"))->where('cod_p','1')->orderBy('cod_p','asc')->get();
        return \Response::json($pilares);
    }
  }

  public function listarPilares2(Request $request)
  {

   if($request->ajax()) {
        $pilares = Pilares::select("id", \DB::raw("'P'||cod_p as nombre"))->orderBy('cod_p','asc')->get();
        return \Response::json($pilares);
    }
  }

  public function datosPilar(Request $request)
  {

   if($request->ajax()) {

        $dpilar = \DB::select("select p.*
                                  from spie_pilares p
                                  where p.id = ?", [$request->get('pilar')]);

      $html = '<div class="row">';
        foreach ($dpilar as $p) {
          $html .='<div class="col-md-4 col-sm-4 col-xs-12">
                      <b>'.$p->nombre.'</b>: '.$p->descripcion.'
                  </div>';
        }
      $totalesFiltro = \DB::select("SELECT tab.numero_proyectos,
                                    tab.total_costo,
                                    (
                                    SELECT SUM(monto)
                                    FROM spie_presupuesto_proyectos_pdes
                                    INNER JOIN spie_proyectos_pdes ON spie_presupuesto_proyectos_pdes.id_proyecto_pdes = spie_proyectos_pdes.id
                                    WHERE spie_proyectos_pdes.cod_p = ".$request->get('pilar')."
                                    ) as total_quinquenio
                                    FROM(
                                    SELECT count(*) as numero_proyectos,SUM(costo_total) total_costo
                                    FROM spie_proyectos_pdes
                                    WHERE spie_proyectos_pdes.cod_p = ".$request->get('pilar')."
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

  public function detallePilares(Request $request)
  {

   if($request->ajax()) {
        $pilares = Pilares::orderBy('cod_p','asc')->get();
        return \Response::json($pilares);
    }
  }
}
