<?php

namespace App\Http\Controllers\ModuloPdes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ModuloPdes\Resultados;

class ResultadosController extends Controller
{
  public function listarResultados(Request $request)
  {

   if($request->ajax()) {
        $resultados = Resultados::select("id", \DB::raw("'R'||cod_r as nombre"),"meta")
                      ->where('cod_r','1')
                      ->orwhere('cod_r','2')
                      ->orwhere('cod_r','4')
                      ->orwhere('cod_r','140')
                      ->orwhere('cod_r','141')
                      ->orderBy('cod_r','asc')->get();
        return \Response::json($resultados);
    }
  }

  public function listarResultados2(Request $request)
  {

   if($request->ajax()) {
        $resultados = Resultados::select("id", \DB::raw("'R'||cod_r as nombre"),"meta")->orderBy('cod_r','asc')->get();
        return \Response::json($resultados);
    }
  }

  public function datosResultado(Request $request)
  {

   if($request->ajax()) {

        $dResultado = \DB::select("select p.nombre as pilar_nombre,
                                   p.descripcion as pilar_desc,
                                   m.nombre as meta_nombre,
                                   m.descripcion as meta_desc,
                                   r.*
                                   from spie_resultados r
                                   inner join spie_metas m ON r.meta = m.id
                                   inner join spie_pilares p ON m.pilar = p.id
                                   where r.id = ?", [$request->get('resultado')]);
        return \Response::json($dResultado);
    }
  }

  public function datosResultado2(Request $request)
  {

   if($request->ajax()) {

        $dResultado = \DB::select("select p.nombre as pilar_nombre,
                                   p.descripcion as pilar_desc,
                                   m.nombre as meta_nombre,
                                   m.descripcion as meta_desc,
                                   r.*
                                   from spie_resultados r
                                   inner join spie_metas m ON r.meta = m.id
                                   inner join spie_pilares p ON m.pilar = p.id
                                   where r.id = ?", [$request->get('resultado')]);
         $html = '<div class="row">';
           foreach ($dResultado as $r) {
             $html .='<div class="col-md-4 col-sm-4 col-xs-12">
                         <b>'.$r->pilar_nombre.'</b>: '.$r->pilar_desc.'</br>
                         <b>'.$r->meta_nombre.'</b>: '.$r->meta_desc.'</br>
                         <b>'.$r->nombre.'</b>: '.$r->descripcion.'
                     </div>';
           }
         $totalesFiltro = \DB::select("SELECT
                                      	tab.numero_proyectos,
                                      	tab.total_costo,
                                      	(
                                      		SELECT
                                      			SUM (monto)
                                      		FROM
                                      			spie_presupuesto_proyectos_pdes prp
                                      		INNER JOIN spie_resultados_proyectos_pdes rp ON prp.id_proyecto_pdes = rp.id_proyecto_pdes
                                      		WHERE rp.id_resultado = ".$dResultado[0]->id."
                                      	) AS total_quinquenio
                                      FROM
                                      	(
                                      		SELECT
                                      			COUNT (*) AS numero_proyectos,
                                      			SUM (costo_total) total_costo
                                      		FROM
                                      			spie_proyectos_pdes pp
                                      		INNER JOIN spie_resultados_proyectos_pdes rp ON pp.id = rp.id_proyecto_pdes
                                      		WHERE rp.id_resultado = ".$dResultado[0]->id."
                                      	) AS tab");

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
