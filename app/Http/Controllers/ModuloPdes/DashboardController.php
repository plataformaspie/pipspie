<?php

namespace App\Http\Controllers\ModuloPdes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware(function ($request, $next) {
        $this->user= \Auth::user();
        $rol = (int) $this->user->id_rol;
        $sql = \DB::select("SELECT  m.* FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol = ".$rol." ORDER BY orden ASC");
        $this->modulos = array();
        foreach ($sql as $mn) {
            array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html));
        }


        $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 1 AND activo = true ORDER BY m.orden ASC");
        $this->menus = array();
        foreach ($sql as $mn) {

            $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." AND activo = true ORDER BY orden ASC");
            array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'submenus' => $submenu));
        }



        \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);



        return $next($request);

        });

    }
    public function index()
    {
      return view('ModuloPdes.indicadores');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function listaIndicadores(Request $request)
    {

     if($request->ajax()) {
         $dIndicadores = \DB::select('SELECT *
                                      FROM spie_indicadores i
                                      INNER JOIN spie_resultado_indicadores ri ON i.id = ri.id_indicador
                                      WHERE ri.id_resultado = ?
                                      AND i.estado = true
                                      AND ri.punto_medicion = ?
                                      ORDER BY i.id DESC', [$request->get('resultado'),$request->get('tipo')]);
         return \Response::json($dIndicadores);
      }
    }

    public function GraficaIndicador(Request $request)
    {
      // if($request->ajax()) {
      //     if($request->vista == "v_ve00014_p_pobreza_extrema"){
      //       $filtro = " pext0 = 'POBRE EXTREMO'";
      //     }
      //     else {
      //       $filtro = " p0 = 'POBRE'";
      //     }
      //
      //     $datos = \DB::connection('dbestadistica')
      //               ->select("SELECT t_ano as datacolumn, SUM(valor_cargado) as valor
      //                         FROM ".$request->vista."
      //                         WHERE ".$filtro."
      //                         GROUP BY datacolumn
      //                         ORDER BY datacolumn ASC");
      //     return \Response::json($datos);
      // }

      if($request->ajax()) {
        $idVariable = \DB::connection('dbestadistica')->select("SELECT id_variable FROM ".$request->vista." LIMIT 1");

        $colsSel = explode(",", trim($request->cols, ','));
        $camposCols = \DB::connection('dbestadistica')
                    ->table('be_dimensions')->whereIn('id', $colsSel)->get();
        $selectCol = " ";
        $tituloCol = "";
        foreach ($camposCols as $cc) {
            $selectCol.= $cc->column.",";
            $tituloCol.= $cc->column."||'\n'||";
        }
        $selectCol = trim($selectCol, ',');
        $tituloCol = trim($tituloCol, "||'\n'||");


        $selectFilter = " ";
        $filterSel = explode(",", trim($request->filter, ','));
        if($filterSel[0]!=""){
            $filterCols = \DB::connection('dbestadistica')
                        ->table('be_domains')
                        ->join('be_dimensions', 'be_domains.dimension_id', '=', 'be_dimensions.id')
                        ->whereIn('be_domains.id', $filterSel)
                        ->select('be_dimensions.column', 'be_domains.name')->get();
            $sw = 0;
            $whIn ="";
            $cv = 0;
            foreach ($filterCols as $f) {
              // ESTA FUNCION SE DEBE MEJORAR SI SE AUMENTA COMBOS FILTROS EN LA VISTA DE FILTROS(DIMENSIONES)
                if(substr_count($filterCols, $f->column) > 1){
                  $cv ++;
                  if($sw == 0){
                    $counValor = substr_count($filterCols, $f->column);
                    $whIn.= " AND ".$f->column." IN ('".$f->name."',";
                    $sw = 1;
                  }else{
                    if($cv == $counValor){
                      $whIn.="'".$f->name."')";
                    }else{
                      $whIn.="'".$f->name."',";
                    }
                  }

                }else{
                  $selectFilter.= " AND ".$f->column." = "."'".$f->name."'";
                }

            }
            $selectFilter.= $whIn;

        }


          $datos = \DB::connection('dbestadistica')
                      ->select("SELECT".$selectCol.", SUM(valor_cargado) as valor,(".$tituloCol.") as titulo, valor_unidad_medida as unidad
                                FROM valores_produccion
                                WHERE id_variable = ?
                                ".$selectFilter."
                                GROUP BY".$selectCol.", valor_unidad_medida
                                ORDER BY".$selectCol." ASC",[$idVariable[0]->id_variable]);
          return \Response::json($datos);
      }

    }


    public function graficaProyecto(Request $request)
    {
      if($request->ajax()) {


        $colsSel = explode(",", trim($request->cols, ','));
        $camposCols = \DB::table('spie_dimensiones')->whereIn('id', $colsSel)->get();
        $selectCol = " ";
        $tituloCol = "";
        foreach ($camposCols as $cc) {
            $selectCol.= $cc->column.",";
            $tituloCol.= $cc->column."||'\n'||";
        }
        $selectCol = trim($selectCol, ',');
        $tituloCol = trim($tituloCol, "||'\n'||");


        $selectFilter = " ";
        $filterSel = explode(",", trim($request->filter, ','));
        if($filterSel[0]!=""){
            $filterCols = \DB::connection('dbestadistica')
                        ->table('be_domains')
                        ->join('be_dimensions', 'be_domains.dimension_id', '=', 'be_dimensions.id')
                        ->whereIn('be_domains.id', $filterSel)
                        ->select('be_dimensions.column', 'be_domains.name')->get();
            $sw = 0;
            $whIn ="";
            $cv = 0;
            foreach ($filterCols as $f) {
              // ESTA FUNCION SE DEBE MEJORAR SI SE AUMENTA COMBOS FILTROS EN LA VISTA DE FILTROS(DIMENSIONES)
                if(substr_count($filterCols, $f->column) > 1){
                  $cv ++;
                  if($sw == 0){
                    $counValor = substr_count($filterCols, $f->column);
                    $whIn.= " AND ".$f->column." IN ('".$f->name."',";
                    $sw = 1;
                  }else{
                    if($cv == $counValor){
                      $whIn.="'".$f->name."')";
                    }else{
                      $whIn.="'".$f->name."',";
                    }
                  }

                }else{
                  $selectFilter.= " AND ".$f->column." = "."'".$f->name."'";
                }

            }
            $selectFilter.= $whIn;

        }


          $datos = \DB::select("SELECT".$selectCol.", SUM(monto) as valor,(".$tituloCol.") as titulo, 'Bs.' as unidad
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE pp.id = ?
                                ".$selectFilter."
                                GROUP BY".$selectCol."
                                ORDER BY".$selectCol." ASC",[$request->idProy]);
          return \Response::json($datos);
      }

    }




    public function comboFiltros(Request $request)
    {
      if($request->ajax()) {
        $idVariable = \DB::connection('dbestadistica')->select("SELECT id_variable FROM ".$request->vista." LIMIT 1");
        $datos = \DB::connection('dbestadistica')
                 ->select("SELECT bd.id as valor, bd.name as nombre
                           FROM be_dimensions bd
                           INNER JOIN dimension_variable dv ON bd.id = dv.dimension_id
                           WHERE dv.variable_id = ?",[$idVariable[0]->id_variable]);
        return \Response::json($datos);
      }
    }

    public function comboFiltrosHijos(Request $request)
    {
      if($request->ajax()) {
        $idVariable = \DB::connection('dbestadistica')->select("SELECT id_variable FROM ".$request->vista." LIMIT 1");
        $dimensiones = \DB::connection('dbestadistica')
                       ->select("SELECT bd.id
                                 FROM be_dimensions bd
                                 INNER JOIN dimension_variable dv ON bd.id = dv.dimension_id
                                 WHERE dv.variable_id = ?",[$idVariable[0]->id_variable]);
        $dim = "";
        foreach ($dimensiones as $dm) {
          $dim .= $dm->id.",";
        }
        $dimPadre = explode(",", trim($dim, ','));

        $datos = \DB::connection('dbestadistica')
                    ->table('be_domains')->whereIn('dimension_id', $dimPadre)->select('id as valor', 'name as nombre', 'dimension_id as padre')->get();
        return \Response::json($datos);
      }
    }

    public function configComboFiltros(Request $request)
    {
      if($request->ajax()) {
        $idVariable = \DB::connection('dbestadistica')->select("SELECT id_variable FROM ".$request->vista." LIMIT 1");
        $datos = \DB::connection('dbestadistica')
                    ->table('be_variables')->where('id', $idVariable[0]->id_variable)->first();
        $chkCols = explode(",", $datos->cols);
        $chkRows = explode(",", $datos->rows);

        //dd(intval(preg_replace('/[^0-9]+/', '', $datos->filter), 10));
        $filter = str_replace('"=",', "", $datos->filter);
        $filter = json_decode($filter);

        $chkDim = array();
        $chkDimVal = array();

        if($filter){
          foreach ($filter as $aP) {
            foreach ($aP as $i=>$data) {
              if($i==0){
                $chkDim[]=$data;
              }else{
                $idValorH = \DB::connection('dbestadistica')->table('be_domains')->where('name',$data)->first();
                $chkDimVal[]=$idValorH->id;
              }

            }
          }
        }


        //dd($filter);


        return \Response::json(array('cols'=>$chkCols,'rows'=>$chkRows,'dim'=>$chkDim,'dimval'=>$chkDimVal));
      }
    }


    public function indicadoresClasificados()
    {
      return view('ModuloPdes.indicadores_clasificados');
    }


    //______________________________PROYECTOS

    public function proyectos()
    {
      return view('ModuloPdes.proyectos');
    }

    public function graficaAll(Request $request)
    {
      if($request->ajax()) {


        $colsSel = explode(",", trim($request->cols, ','));
        $camposCols = \DB::table('spie_dimensiones')->whereIn('id', $colsSel)->get();
        $selectCol = " ";
        $tituloCol = "";
        foreach ($camposCols as $cc) {
            $selectCol.= $cc->column.",";
            $tituloCol.= $cc->column."||'\n'||";
        }
        $selectCol = trim($selectCol, ',');
        $tituloCol = trim($tituloCol, "||'\n'||");


        $selectFilter = " ";
        $filterSel = explode(",", trim($request->filter, ','));
        if($filterSel[0]!=""){
            $filterCols = \DB::table('spie_dimensiones_valores')
                        ->join('spie_dimensiones', 'spie_dimensiones_valores.id_dimension', '=', 'spie_dimensiones.id')
                        ->whereIn('spie_dimensiones_valores.id', $filterSel)
                        ->select('spie_dimensiones.column', 'spie_dimensiones_valores.name','spie_dimensiones.and')->get();
            $sw = 0;
            $whIn ="";
            $cv = 0;
            foreach ($filterCols as $f) {
              // ESTA FUNCION SE DEBE MEJORAR SI SE AUMENTA COMBOS FILTROS EN LA VISTA DE FILTROS(DIMENSIONES)
                if(substr_count($filterCols, $f->column) > 1){
                  $cv ++;
                  if($sw == 0){
                    $counValor = substr_count($filterCols, $f->column);
                    $whIn.= "".$f->and;
                    $whIn.= " AND ".$f->column." IN ('".$f->name."',";
                    $sw = 1;
                  }else{
                    if($cv == $counValor){
                      $whIn.="'".$f->name."')";
                    }else{
                      $whIn.="'".$f->name."',";
                    }
                  }

                }else{
                  $selectFilter.= " AND ".$f->column." = "."'".$f->name."'";
                  $selectFilter.= "".$f->and;
                }

            }
            $selectFilter.= $whIn;

        }

          if($request->resultado!=""){
            $datos = \DB::select("SELECT".$selectCol.", SUM(monto) as valor,(".$tituloCol.") as titulo, 'Bs.' as unidad
                                  FROM spie_proyectos_pdes pp
                                  INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                  INNER JOIN spie_resultados_proyectos_pdes rp ON pp.id = rp.id_proyecto_pdes
                                  WHERE rp.id_resultado=?
                                  ".$selectFilter."
                                  GROUP BY".$selectCol."
                                  ORDER BY".$selectCol." ASC",[$request->resultado]);

          }elseif($request->meta!=""){
            $datosM = \DB::table('spie_metas')->where('id',$request->meta)->first();
            $datos = \DB::select("SELECT".$selectCol.", SUM(monto) as valor,(".$tituloCol.") as titulo, 'Bs.' as unidad
                                  FROM spie_proyectos_pdes pp
                                  INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                  WHERE pp.cod_p=?
                                  AND pp.cod_m=?
                                  ".$selectFilter."
                                  GROUP BY".$selectCol."
                                  ORDER BY".$selectCol." ASC",[$datosM->pilar,$datosM->cod_m]);

          }elseif($request->pilar!=""){

            $datos = \DB::select("SELECT".$selectCol.", SUM(monto) as valor,(".$tituloCol.") as titulo, 'Bs.' as unidad
                                  FROM spie_proyectos_pdes pp
                                  INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                  WHERE pp.cod_p=?
                                  ".$selectFilter."
                                  GROUP BY".$selectCol."
                                  ORDER BY".$selectCol." ASC",[$request->pilar]);

          }else{
            $datos = \DB::select("SELECT".$selectCol.", SUM(monto) as valor,(".$tituloCol.") as titulo, 'Bs.' as unidad
                                  FROM spie_proyectos_pdes pp
                                  INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                  WHERE 1=1
                                  ".$selectFilter."
                                  GROUP BY".$selectCol."
                                  ORDER BY".$selectCol." ASC");

          }
            return \Response::json($datos);

      }

    }
    public function listaProyectos(Request $request)
    {
     if($request->ajax()) {

        //$proyectos = \DB::table('spie_proyectos_pdes')->get();
        $selectFilter = " ";
        $filterSel = explode(",", trim($request->filter, ','));
        if($filterSel[0]!=""){
            $filterCols = \DB::table('spie_dimensiones_valores')
                        ->join('spie_dimensiones', 'spie_dimensiones_valores.id_dimension', '=', 'spie_dimensiones.id')
                        ->whereIn('spie_dimensiones_valores.id', $filterSel)
                        ->select('spie_dimensiones.column', 'spie_dimensiones_valores.name','spie_dimensiones.and')->get();
            $sw = 0;
            $whIn ="";
            $cv = 0;
            foreach ($filterCols as $f) {
              // ESTA FUNCION SE DEBE MEJORAR SI SE AUMENTA COMBOS FILTROS EN LA VISTA DE FILTROS(DIMENSIONES)
                if(substr_count($filterCols, $f->column) > 1){
                  $cv ++;
                  if($sw == 0){
                    $counValor = substr_count($filterCols, $f->column);
                    $whIn.= "".$f->and;
                    $whIn.= " AND ".$f->column." IN ('".$f->name."',";
                    $sw = 1;
                  }else{
                    if($cv == $counValor){
                      $whIn.="'".$f->name."')";
                    }else{
                      $whIn.="'".$f->name."',";
                    }
                  }

                }else{
                  $selectFilter.= " AND ".$f->column." = "."'".$f->name."'";
                  $selectFilter.= "".$f->and;
                }

            }
            $selectFilter.= $whIn;

        }

        if($request->resultado!=""){
          $datos = \DB::select("SELECT pp.*
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                INNER JOIN spie_resultados_proyectos_pdes rp ON pp.id = rp.id_proyecto_pdes
                                WHERE rp.id_resultado = ?
                                ".$selectFilter."
                                GROUP BY pp.id",[$request->resultado]);

        }elseif($request->meta!=""){
          $datosM = \DB::table('spie_metas')->where('id',$request->meta)->first();
          $datos = \DB::select("SELECT pp.*
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE pp.cod_p = ?
                                AND pp.cod_m = ?
                                ".$selectFilter."
                                GROUP BY pp.id",[$datosM->pilar,$datosM->cod_m]);

        }elseif($request->pilar!=""){

          $datos = \DB::select("SELECT pp.*
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE pp.cod_p=?
                                ".$selectFilter."
                                GROUP BY pp.id",[$request->pilar]);

        }else{
          $datos = \DB::select("SELECT pp.*
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE 1=1
                                ".$selectFilter."
                                GROUP BY pp.id");
        }

         return \Response::json($datos);
      }
    }



    public function totalesProyectosDetalle(Request $request)
    {
     if($request->ajax()) {

       $selectFilter = " ";
       $filterSel = explode(",", trim($request->filter, ','));
       if($filterSel[0]!=""){
           $filterCols = \DB::table('spie_dimensiones_valores')
                       ->join('spie_dimensiones', 'spie_dimensiones_valores.id_dimension', '=', 'spie_dimensiones.id')
                       ->whereIn('spie_dimensiones_valores.id', $filterSel)
                       ->select('spie_dimensiones.column', 'spie_dimensiones_valores.name','spie_dimensiones.and')->get();
           $sw = 0;
           $whIn ="";
           $cv = 0;
           foreach ($filterCols as $f) {
             // ESTA FUNCION SE DEBE MEJORAR SI SE AUMENTA COMBOS FILTROS EN LA VISTA DE FILTROS(DIMENSIONES)
               if(substr_count($filterCols, $f->column) > 1){
                 $cv ++;
                 if($sw == 0){
                   $counValor = substr_count($filterCols, $f->column);
                   $whIn.= "".$f->and;
                   $whIn.= " AND ".$f->column." IN ('".$f->name."',";
                   $sw = 1;
                 }else{
                   if($cv == $counValor){
                     $whIn.="'".$f->name."')";
                   }else{
                     $whIn.="'".$f->name."',";
                   }
                 }

               }else{
                 $selectFilter.= " AND ".$f->column." = "."'".$f->name."'";
                 $selectFilter.= "".$f->and;
               }

           }
           $selectFilter.= $whIn;

       }

       if($request->resultado!=""){


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
              $html .='<div class="col-md-3 col-sm-3 col-xs-12">
                          <b>'.$r->pilar_nombre.'</b>: '.$r->pilar_desc.'</br>
                          <b>'.$r->meta_nombre.'</b>: '.$r->meta_desc.'</br>
                          <b>'.$r->nombre.'</b>: '.$r->descripcion.'
                      </div>';
            }
         $totales = \DB::select("SELECT tab.numero_proyectos,
                                (
                                  SELECT SUM(sub_grupo.costo_total)
                                  FROM(
                                    SELECT costo_total
                                    FROM spie_proyectos_pdes pp
                                    INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                    INNER JOIN spie_resultados_proyectos_pdes rp ON pp.id = rp.id_proyecto_pdes
                                    WHERE rp.id_resultado = ".$request->resultado."
                                    ".$selectFilter."
                                    GROUP BY pp.id
                                  ) as sub_grupo
                                ) as total_costo,
                                (
                                SELECT SUM(monto)
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                INNER JOIN spie_resultados_proyectos_pdes rp ON pp.id = rp.id_proyecto_pdes
                                WHERE rp.id_resultado = ".$request->resultado."
                                ".$selectFilter."
                                ) as total_quinquenio
                                FROM(
                                SELECT count(DISTINCT pp.id) as numero_proyectos
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                INNER JOIN spie_resultados_proyectos_pdes rp ON pp.id = rp.id_proyecto_pdes
                                WHERE rp.id_resultado = ".$request->resultado."
                                ".$selectFilter."
                                ) as tab");
           foreach ($totales as $t) {
             $html .= '<div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Nº Total Proyectos: </b>'.$t->numero_proyectos.'
                       </div>
                       <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo Total: </b>Bs.'.number_format($t->total_costo,2).'
                       </div>
                           <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo quinquenio: </b>Bs.'.number_format($t->total_quinquenio,2).'
                       </div>';
           }
           $html .= '</div>';






       }elseif($request->meta!=""){

         $dMeta = \DB::select("select p.nombre as pilar_nombre,
                                   p.descripcion as pilar_desc,
                                   m.*
                                   from spie_metas m
                                   inner join spie_pilares p ON m.pilar = p.id
                                   where m.id = ?", [$request->get('meta')]);
         $html = '<div class="row">';
         foreach ($dMeta as $m) {
           $html .='<div class="col-md-3 col-sm-3 col-xs-12">
                       <b>'.$m->pilar_nombre.'</b>: '.$m->pilar_desc.'</br>
                       <b>'.$m->nombre.'</b>: '.$m->descripcion.'
                   </div>';
         }
         $totales = \DB::select("SELECT tab.numero_proyectos,
                                (
                                  SELECT SUM(sub_grupo.costo_total)
                                  FROM(
                                    SELECT costo_total
                                    FROM spie_proyectos_pdes pp
                                    INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                    WHERE pp.cod_p = ".$dMeta[0]->pilar."
                                    AND pp.cod_m = ".$dMeta[0]->cod_m."
                                    ".$selectFilter."
                                    GROUP BY pp.id
                                  ) as sub_grupo
                                ) as total_costo,
                                (
                                SELECT SUM(monto)
                                FROM spie_presupuesto_proyectos_pdes prp
                                INNER JOIN spie_proyectos_pdes pp ON prp.id_proyecto_pdes = pp.id
                                WHERE pp.cod_p = ".$dMeta[0]->pilar."
                                AND pp.cod_m = ".$dMeta[0]->cod_m."
                                ".$selectFilter."
                                ) as total_quinquenio
                                FROM(
                                SELECT count(DISTINCT pp.id) as numero_proyectos
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE pp.cod_p = ".$dMeta[0]->pilar."
                                AND pp.cod_m = ".$dMeta[0]->cod_m."
                                ".$selectFilter."
                                ) as tab");
           foreach ($totales as $t) {
             $html .= '<div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Nº Total Proyectos: </b>'.$t->numero_proyectos.'
                       </div>
                       <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo Total: </b>Bs.'.number_format($t->total_costo,2).'
                       </div>
                           <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo quinquenio: </b>Bs.'.number_format($t->total_quinquenio,2).'
                       </div>';
           }
           $html .= '</div>';






       }elseif($request->pilar!=""){

         $dpilar = \DB::select("select p.*
                                   from spie_pilares p
                                   where p.id = ?", [$request->get('pilar')]);

         $html = '<div class="row">';
         foreach ($dpilar as $p) {
           $html .='<div class="col-md-3 col-sm-3 col-xs-12">
                       <b>'.$p->nombre.'</b>: '.$p->descripcion.'
                   </div>';
         }
         $totales = \DB::select("SELECT tab.numero_proyectos,
                                (
                                  SELECT SUM(sub_grupo.costo_total)
                                  FROM(
                                    SELECT costo_total
                                    FROM spie_proyectos_pdes pp
                                    INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                    WHERE pp.cod_p = ".$request->pilar."
                                    ".$selectFilter."
                                    GROUP BY pp.id
                                  ) as sub_grupo
                                ) as total_costo,
                                (
                                SELECT SUM(monto)
                                FROM spie_presupuesto_proyectos_pdes prp
                                INNER JOIN spie_proyectos_pdes pp ON prp.id_proyecto_pdes = pp.id
                                WHERE pp.cod_p = ".$request->pilar."
                                ".$selectFilter."
                                ) as total_quinquenio
                                FROM(
                                SELECT count(DISTINCT pp.id) as numero_proyectos
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE pp.cod_p = ".$request->pilar."
                                ".$selectFilter."
                                ) as tab");
           foreach ($totales as $t) {
             $html .= '<div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Nº Total Proyectos: </b>'.$t->numero_proyectos.'
                       </div>
                       <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo Total: </b>Bs.'.number_format($t->total_costo,2).'
                       </div>
                           <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo quinquenio: </b>Bs.'.number_format($t->total_quinquenio,2).'
                       </div>';
           }
           $html .= '</div>';


       }else{
           $totales = \DB::select("SELECT tab.numero_proyectos,
                                  (
                                  	SELECT SUM(sub_grupo.costo_total)
                                  	FROM(
                                  		SELECT costo_total
                                  		FROM spie_proyectos_pdes pp
                                  		INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                  		WHERE 1 = 1
                                      ".$selectFilter."
                                  		GROUP BY pp.id
                                  	) as sub_grupo
                                  ) as total_costo,
                                  (
                                  SELECT SUM(monto)
                                  FROM spie_presupuesto_proyectos_pdes prp
                                  INNER JOIN spie_proyectos_pdes pp ON prp.id_proyecto_pdes = pp.id
                                  WHERE 1 = 1
                                  ".$selectFilter."
                                  ) as total_quinquenio
                                  FROM(
                                  SELECT count(DISTINCT pp.id) as numero_proyectos
                                  FROM spie_proyectos_pdes pp
                                  INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                  WHERE 1 = 1
                                  ".$selectFilter."
                                  ) as tab");
             $html = '<div class="row">';
             foreach ($totales as $t) {
               $html .= '<div class="col-md-4 col-sm-4 col-xs-12">
                             <b>Nº Total Proyectos: </b>'.$t->numero_proyectos.'
                         </div>
                         <div class="col-md-4 col-sm-4 col-xs-12">
                               <b>Costo Total: </b>Bs.'.number_format($t->total_costo,2).'
                         </div>
                         <div class="col-md-4 col-sm-4 col-xs-12">
                              <b>Costo quinquenio: </b>Bs.'.number_format($t->total_quinquenio,2).'
                         </div>';
             }
             $html .= '</div>';
       }


         return \Response::json($html);

      }
    }



    public function datosProyecto(Request $request)
    {
      if($request->ajax()) {

        $datospdesProy = \DB::select("SELECT rp.id_proyecto_pdes,vc.*,('P'||cod_p||'.M'||cod_m||'.R'||cod_r) as cod_tex,
                                      ('<b>'||pilar||':</b> '||desc_p||'<br/><b>'||meta||':</b> '||desc_m||'<br/><b>'||resultado||':</b> '||desc_r) as descripcion
                                      FROM spie_resultados_proyectos_pdes rp
                                      INNER JOIN spie_vista_catalogo_pmr vc ON rp.id_resultado = vc.id_resultado
                                      WHERE id_proyecto_pdes = ?",[$request->idProy]);
          $proyecto = \DB::table('spie_proyectos_pdes')->where('id',$request->idProy)->first();
          $html = '<div class="row">
                      <div class="col-md-3 col-sm-4 col-xs-12">
                          <b>Nombre Proyecto: </b><br/>
                          '.$proyecto->nombre_proyecto.'
                      </div>';
              $html .='<div class="col-md-3 col-sm-4 col-xs-12">
                          <b>Articulación PDES: </b><br/>';
                foreach ($datospdesProy as $dp) {
                  $html .='<button title="'.$dp->descripcion.'" rel="tooltip">'.$dp->cod_tex.'</button>';
                  //<a href="#" data-toggle="popover" data-placement="bottom" title="Popover Header" data-content="Some content inside the popover">Toggle popover</a>

                }
              $html.= '</div>';

              $html .= '<div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Sector: </b>'.$proyecto->sector.'<br/>
                            <b>Entidad Responsable: </b>'.$proyecto->responsable.'<br/>
                            <b>Lugar: </b></br>
                            <b>Inicio: </b> - <b> Fin: </b> -

                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Estado: </b></br>
                            <b>Presupuesto Programado: </b></br>
                            <b>Presupuesto Reprogramado: </b></br>
                            <b>Presupuesto Ejecutado: </b></br>
                        </div>';
          $html .= '</div>';
      }

      return \Response::json($html);

    }


    public function comboFiltrosHijosProyectos(Request $request)
    {
      if($request->ajax()) {

        $datos = \DB::table('spie_dimensiones_valores')->whereIn('id_dimension', [1,2,3,4])->select('id as valor', 'name as nombre', 'id_dimension as padre')->get();
        return \Response::json($datos);
      }
    }



    //_______________________________PRESUPUESTO

    public function presupuesto()
    {
      return view('ModuloPdes.presupuesto');
    }


    public function totalesPresupuestoDetalle(Request $request)
    {
     if($request->ajax()) {
       $colsSel = explode(",", trim($request->cols, ','));
       $camposCols = \DB::table('spie_dimensiones')->whereIn('id', $colsSel)->get();
       $selectCol = " ";
       $tituloCol = "";
       foreach ($camposCols as $cc) {
           $selectCol.= $cc->column.",";
           $tituloCol.= $cc->titgraf."||'\n'||";
       }
       $selectCol = trim($selectCol, ',');
       $tituloCol = trim($tituloCol, "||'\n'||");


       $selectFilter = " ";
       $filterSel = explode(",", trim($request->filter, ','));
       if($filterSel[0]!=""){
           $filterCols = \DB::table('spie_dimensiones_valores')
                       ->join('spie_dimensiones', 'spie_dimensiones_valores.id_dimension', '=', 'spie_dimensiones.id')
                       ->whereIn('spie_dimensiones_valores.id', $filterSel)
                       ->select('spie_dimensiones.column', 'spie_dimensiones_valores.name','spie_dimensiones.and')->get();
           $sw = 0;
           $whIn ="";
           $cv = 0;
           foreach ($filterCols as $f) {
             // ESTA FUNCION SE DEBE MEJORAR SI SE AUMENTA COMBOS FILTROS EN LA VISTA DE FILTROS(DIMENSIONES)
               if(substr_count($filterCols, $f->column) > 1){
                 $cv ++;
                 if($sw == 0){
                   $counValor = substr_count($filterCols, $f->column);
                   $whIn.= "".$f->and;
                   $whIn.= " AND ".$f->column." IN ('".$f->name."',";
                   $sw = 1;
                 }else{
                   if($cv == $counValor){
                     $whIn.="'".$f->name."')";
                   }else{
                     $whIn.="'".$f->name."',";
                   }
                 }

               }else{
                 $selectFilter.= " AND ".$f->column." = "."'".$f->name."'";
                 $selectFilter.= "".$f->and;
               }

           }
           $selectFilter.= $whIn;

       }

       if($request->resultado!=""){


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
              $html .='<div class="col-md-3 col-sm-3 col-xs-12">
                          <b>'.$r->pilar_nombre.'</b>: '.$r->pilar_desc.'</br>
                          <b>'.$r->meta_nombre.'</b>: '.$r->meta_desc.'</br>
                          <b>'.$r->nombre.'</b>: '.$r->descripcion.'
                      </div>';
            }
         $totales = \DB::select("SELECT tab.numero_proyectos,
                                (
                                  SELECT SUM(sub_grupo.costo_total)
                                  FROM(
                                    SELECT costo_total
                                    FROM spie_proyectos_pdes pp
                                    INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                    INNER JOIN spie_resultados_proyectos_pdes rp ON pp.id = rp.id_proyecto_pdes
                                    WHERE rp.id_resultado = ".$request->resultado."
                                    ".$selectFilter."
                                    GROUP BY pp.id
                                  ) as sub_grupo
                                ) as total_costo,
                                (
                                SELECT SUM(monto)
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                INNER JOIN spie_resultados_proyectos_pdes rp ON pp.id = rp.id_proyecto_pdes
                                WHERE rp.id_resultado = ".$request->resultado."
                                ".$selectFilter."
                                ) as total_quinquenio
                                FROM(
                                SELECT count(DISTINCT pp.id) as numero_proyectos
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                INNER JOIN spie_resultados_proyectos_pdes rp ON pp.id = rp.id_proyecto_pdes
                                WHERE rp.id_resultado = ".$request->resultado."
                                ".$selectFilter."
                                ) as tab");
           foreach ($totales as $t) {
             $html .= '<div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Nº Total Proyectos: </b>'.$t->numero_proyectos.'
                       </div>
                       <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo Total: </b>Bs.'.number_format($t->total_costo,2).'
                       </div>
                           <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo quinquenio: </b>Bs.'.number_format($t->total_quinquenio,2).'
                       </div>';
           }
           $html .= '</div>';






       }elseif($request->meta!=""){

         $dMeta = \DB::select("select p.nombre as pilar_nombre,
                                   p.descripcion as pilar_desc,
                                   m.*
                                   from spie_metas m
                                   inner join spie_pilares p ON m.pilar = p.id
                                   where m.id = ?", [$request->get('meta')]);
         $html = '<div class="row">';
         foreach ($dMeta as $m) {
           $html .='<div class="col-md-3 col-sm-3 col-xs-12">
                       <b>'.$m->pilar_nombre.'</b>: '.$m->pilar_desc.'</br>
                       <b>'.$m->nombre.'</b>: '.$m->descripcion.'
                   </div>';
         }
         $totales = \DB::select("SELECT tab.numero_proyectos,
                                (
                                  SELECT SUM(sub_grupo.costo_total)
                                  FROM(
                                    SELECT costo_total
                                    FROM spie_proyectos_pdes pp
                                    INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                    WHERE pp.cod_p = ".$dMeta[0]->pilar."
                                    AND pp.cod_m = ".$dMeta[0]->cod_m."
                                    ".$selectFilter."
                                    GROUP BY pp.id
                                  ) as sub_grupo
                                ) as total_costo,
                                (
                                SELECT SUM(monto)
                                FROM spie_presupuesto_proyectos_pdes prp
                                INNER JOIN spie_proyectos_pdes pp ON prp.id_proyecto_pdes = pp.id
                                WHERE pp.cod_p = ".$dMeta[0]->pilar."
                                AND pp.cod_m = ".$dMeta[0]->cod_m."
                                ".$selectFilter."
                                ) as total_quinquenio
                                FROM(
                                SELECT count(DISTINCT pp.id) as numero_proyectos
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE pp.cod_p = ".$dMeta[0]->pilar."
                                AND pp.cod_m = ".$dMeta[0]->cod_m."
                                ".$selectFilter."
                                ) as tab");
           foreach ($totales as $t) {
             $html .= '<div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Nº Total Proyectos: </b>'.$t->numero_proyectos.'
                       </div>
                       <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo Total: </b>Bs.'.number_format($t->total_costo,2).'
                       </div>
                           <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo quinquenio: </b>Bs.'.number_format($t->total_quinquenio,2).'
                       </div>';
           }
           $html .= '</div>';






       }elseif($request->pilar!=""){

         $dpilar = \DB::select("select p.*
                                   from spie_pilares p
                                   where p.id = ?", [$request->get('pilar')]);

         $html = '<div class="row">';
         foreach ($dpilar as $p) {
           $html .='<div class="col-md-3 col-sm-3 col-xs-12">
                       <b>'.$p->nombre.'</b>: '.$p->descripcion.'
                   </div>';
         }
         $totales = \DB::select("SELECT tab.numero_proyectos,
                                (
                                  SELECT SUM(sub_grupo.costo_total)
                                  FROM(
                                    SELECT costo_total
                                    FROM spie_proyectos_pdes pp
                                    INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                    WHERE pp.cod_p = ".$request->pilar."
                                    ".$selectFilter."
                                    GROUP BY pp.id
                                  ) as sub_grupo
                                ) as total_costo,
                                (
                                SELECT SUM(monto)
                                FROM spie_presupuesto_proyectos_pdes prp
                                INNER JOIN spie_proyectos_pdes pp ON prp.id_proyecto_pdes = pp.id
                                WHERE pp.cod_p = ".$request->pilar."
                                ".$selectFilter."
                                ) as total_quinquenio
                                FROM(
                                SELECT count(DISTINCT pp.id) as numero_proyectos
                                FROM spie_proyectos_pdes pp
                                INNER JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE pp.cod_p = ".$request->pilar."
                                ".$selectFilter."
                                ) as tab");
           foreach ($totales as $t) {
             $html .= '<div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Nº Total Proyectos: </b>'.$t->numero_proyectos.'
                       </div>
                       <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo Total: </b>Bs.'.number_format($t->total_costo,2).'
                       </div>
                           <div class="col-md-3 col-sm-3  col-xs-12">
                           <b>Costo quinquenio: </b>Bs.'.number_format($t->total_quinquenio,2).'
                       </div>';
           }
           $html .= '</div>';


       }else{
           $totales = \DB::select("SELECT tab.total_conteo,
                                  (
                                    SELECT SUM(tabC.valor) as costo_total
                                    FROM(
                                    SELECT  ".$selectCol.",SUM(costo_total) as valor
                                    FROM spie_vista_catalogo_pmr c
                                    LEFT JOIN spie_resultados_proyectos_pdes rp ON c.id_resultado = rp.id_resultado
                                    LEFT JOIN spie_proyectos_pdes pp ON rp.id_proyecto_pdes = pp.id
                                    WHERE 1=1
                                    ".$selectFilter."
                                    GROUP BY  ".$selectCol."
                                    ORDER BY  ".$selectCol." ASC
                                    ) as tabC
                                  ) as total_costo,
                                  (
                                    SELECT SUM(tabC.valor) as total_quinquenio
                                    FROM(
                                    SELECT ".$selectCol.",SUM(monto) as valor
                                    FROM spie_vista_catalogo_pmr c
                                    LEFT JOIN spie_resultados_proyectos_pdes rp ON c.id_resultado = rp.id_resultado
                                    LEFT JOIN spie_proyectos_pdes pp ON rp.id_proyecto_pdes = pp.id
                                    LEFT JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                    WHERE 1=1
                                    ".$selectFilter."
                                    GROUP BY ".$selectCol."
                                    ORDER BY ".$selectCol." ASC
                                    ) as tabC
                                  ) as total_quinquenio
                                  FROM(
                                    SELECT count(tabC.*) as total_conteo
                                    FROM(
                                    SELECT ".$selectCol."
                                    FROM spie_vista_catalogo_pmr c
                                    LEFT JOIN spie_resultados_proyectos_pdes rp ON c.id_resultado = rp.id_resultado
                                    LEFT JOIN spie_proyectos_pdes pp ON rp.id_proyecto_pdes = pp.id
                                    WHERE 1=1
                                    ".$selectFilter."
                                    GROUP BY ".$selectCol."
                                    ORDER BY ".$selectCol." ASC
                                    ) as tabC
                                  ) as tab");
             $html = '<div class="row">';
             foreach ($totales as $t) {
               $html .= '<div class="col-md-4 col-sm-4 col-xs-12">
                             <b>Nº Total: </b>'.$t->total_conteo.'
                         </div>
                         <div class="col-md-4 col-sm-4 col-xs-12">
                               <b>Costo Total: </b>Bs.'.number_format($t->total_costo,2).'
                         </div>
                         <div class="col-md-4 col-sm-4 col-xs-12">
                              <b>Costo quinquenio: </b>Bs.'.number_format($t->total_quinquenio,2).'
                         </div>';
             }
             $html .= '</div>';
       }


         return \Response::json($html);

      }
    }


    public function graficaPresupuestoAll(Request $request)
    {
      if($request->ajax()) {


        $colsSel = explode(",", trim($request->cols, ','));
        $camposCols = \DB::table('spie_dimensiones')->whereIn('id', $colsSel)->get();
        $selectCol = " ";
        $tituloCol = "";
        foreach ($camposCols as $cc) {
            $selectCol.= $cc->column.",";
            $tituloCol.= $cc->column."||'.'||";
        }
        $selectCol = trim($selectCol, ',');
        $tituloCol = trim($tituloCol, "||'.'||");


        $selectFilter = " ";
        $filterSel = explode(",", trim($request->filter, ','));
        if($filterSel[0]!=""){
            $filterCols = \DB::table('spie_dimensiones_valores')
                        ->join('spie_dimensiones', 'spie_dimensiones_valores.id_dimension', '=', 'spie_dimensiones.id')
                        ->whereIn('spie_dimensiones_valores.id', $filterSel)
                        ->select('spie_dimensiones.column', 'spie_dimensiones_valores.name','spie_dimensiones.and')->get();
            $sw = 0;
            $whIn ="";
            $cv = 0;
            foreach ($filterCols as $f) {
              // ESTA FUNCION SE DEBE MEJORAR SI SE AUMENTA COMBOS FILTROS EN LA VISTA DE FILTROS(DIMENSIONES)
                if(substr_count($filterCols, $f->column) > 1){
                  $cv ++;
                  if($sw == 0){
                    $counValor = substr_count($filterCols, $f->column);
                    $whIn.= "".$f->and;
                    $whIn.= " AND ".$f->column." IN ('".$f->name."',";
                    $sw = 1;
                  }else{
                    if($cv == $counValor){
                      $whIn.="'".$f->name."')";
                    }else{
                      $whIn.="'".$f->name."',";
                    }
                  }

                }else{
                  $selectFilter.= " AND ".$f->column." = "."'".$f->name."'";
                  $selectFilter.= "".$f->and;
                }

            }
            $selectFilter.= $whIn;

        }

          if($request->resultado!=""){
            $datos = \DB::select("SELECT".$selectCol.",SUM(monto) as valor,(".$tituloCol.") as titulo, 'Bs.' as unidad
                                  FROM spie_vista_catalogo_pmr c
                                  LEFT JOIN spie_resultados_proyectos_pdes rp ON c.id_resultado = rp.id_resultado
                                  LEFT JOIN spie_proyectos_pdes pp ON rp.id_proyecto_pdes = pp.id
                                  LEFT JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                  WHERE c.id_resultado = ?
                                  GROUP BY".$selectCol."
                                  ORDER BY".$selectCol." ASC",[$request->resultado]);

          }elseif($request->meta!=""){

            $datos = \DB::select("SELECT".$selectCol.",SUM(monto) as valor,(".$tituloCol.") as titulo, 'Bs.' as unidad
                                  FROM spie_vista_catalogo_pmr c
                                  LEFT JOIN spie_resultados_proyectos_pdes rp ON c.id_resultado = rp.id_resultado
                                  LEFT JOIN spie_proyectos_pdes pp ON rp.id_proyecto_pdes = pp.id
                                  LEFT JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                  WHERE c.id_meta = ?
                                  GROUP BY".$selectCol."
                                  ORDER BY".$selectCol." ASC",[$request->meta]);

          }elseif($request->pilar!=""){

            $datos = \DB::select("SELECT".$selectCol.",SUM(monto) as valor,(".$tituloCol.") as titulo, 'Bs.' as unidad
                                  FROM spie_vista_catalogo_pmr c
                                  LEFT JOIN spie_resultados_proyectos_pdes rp ON c.id_resultado = rp.id_resultado
                                  LEFT JOIN spie_proyectos_pdes pp ON rp.id_proyecto_pdes = pp.id
                                  LEFT JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                  WHERE c.id_pilar = ?
                                  GROUP BY".$selectCol."
                                  ORDER BY".$selectCol." ASC",[$request->pilar]);

          }else{
            $datos = \DB::select("SELECT".$selectCol.",SUM(monto) as valor,(".$tituloCol.") as titulo, 'Bs.' as unidad
                                  FROM spie_vista_catalogo_pmr c
                                  LEFT JOIN spie_resultados_proyectos_pdes rp ON c.id_resultado = rp.id_resultado
                                  LEFT JOIN spie_proyectos_pdes pp ON rp.id_proyecto_pdes = pp.id
                                  LEFT JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                  WHERE 1=1
                                  GROUP BY".$selectCol."
                                  ORDER BY".$selectCol." ASC");

          }
            return \Response::json($datos);

      }

    }


    public function listaDatosPdes(Request $request)
    {
     if($request->ajax()) {


       $colsSel = explode(",", trim($request->cols, ','));
       $camposCols = \DB::table('spie_dimensiones')->whereIn('id', $colsSel)->get();
       $selectCol = " ";
       $tituloCol = "";
       foreach ($camposCols as $cc) {

           $selectCol.= $cc->column.",";
           $tituloCol.= $cc->titgraf."||'.'||";
           $descripcion = $cc->detalle;
       }
       $selectCol = trim($selectCol, ',');
       $tituloCol = trim($tituloCol, "||'.'||");





        $selectFilter = " ";
        $filterSel = explode(",", trim($request->filter, ','));
        if($filterSel[0]!=""){
            $filterCols = \DB::table('spie_dimensiones_valores')
                        ->join('spie_dimensiones', 'spie_dimensiones_valores.id_dimension', '=', 'spie_dimensiones.id')
                        ->whereIn('spie_dimensiones_valores.id', $filterSel)
                        ->select('spie_dimensiones.column', 'spie_dimensiones_valores.name','spie_dimensiones.and')->get();
            $sw = 0;
            $whIn ="";
            $cv = 0;
            foreach ($filterCols as $f) {
              // ESTA FUNCION SE DEBE MEJORAR SI SE AUMENTA COMBOS FILTROS EN LA VISTA DE FILTROS(DIMENSIONES)
                if(substr_count($filterCols, $f->column) > 1){
                  $cv ++;
                  if($sw == 0){
                    $counValor = substr_count($filterCols, $f->column);
                    $whIn.= "".$f->and;
                    $whIn.= " AND ".$f->column." IN ('".$f->name."',";
                    $sw = 1;
                  }else{
                    if($cv == $counValor){
                      $whIn.="'".$f->name."')";
                    }else{
                      $whIn.="'".$f->name."',";
                    }
                  }

                }else{
                  $selectFilter.= " AND ".$f->column." = "."'".$f->name."'";
                  $selectFilter.= "".$f->and;
                }

            }
            $selectFilter.= $whIn;

        }

        if($request->resultado!=""){
          $datos = \DB::select("SELECT".$selectCol.",(".$tituloCol.") as codigo,".$descripcion." as descripcion_pdes
                                FROM spie_vista_catalogo_pmr c
                                LEFT JOIN spie_resultados_proyectos_pdes rp ON c.id_resultado = rp.id_resultado
                                LEFT JOIN spie_proyectos_pdes pp ON rp.id_proyecto_pdes = pp.id
                                LEFT JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE c.id_resultado = ?
                                GROUP BY".$selectCol.",".$descripcion."
                                ORDER BY".$selectCol." ASC",[$request->resultado]);

        }elseif($request->meta!=""){

          $datos = \DB::select("SELECT".$selectCol.",(".$tituloCol.") as codigo,".$descripcion." as descripcion_pdes
                                FROM spie_vista_catalogo_pmr c
                                LEFT JOIN spie_resultados_proyectos_pdes rp ON c.id_resultado = rp.id_resultado
                                LEFT JOIN spie_proyectos_pdes pp ON rp.id_proyecto_pdes = pp.id
                                LEFT JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE c.id_meta = ?
                                GROUP BY".$selectCol.",".$descripcion."
                                ORDER BY".$selectCol." ASC",[$request->meta]);

        }elseif($request->pilar!=""){

          $datos = \DB::select("SELECT".$selectCol.",(".$tituloCol.") as codigo,".$descripcion." as descripcion_pdes
                                FROM spie_vista_catalogo_pmr c
                                LEFT JOIN spie_resultados_proyectos_pdes rp ON c.id_resultado = rp.id_resultado
                                LEFT JOIN spie_proyectos_pdes pp ON rp.id_proyecto_pdes = pp.id
                                LEFT JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE c.id_pilar = ?
                                GROUP BY".$selectCol.",".$descripcion."
                                ORDER BY".$selectCol." ASC",[$request->pilar]);

        }else{
          $datos = \DB::select("SELECT".$selectCol.",(".$tituloCol.") as codigo,".$descripcion." as descripcion_pdes
                                FROM spie_vista_catalogo_pmr c
                                LEFT JOIN spie_resultados_proyectos_pdes rp ON c.id_resultado = rp.id_resultado
                                LEFT JOIN spie_proyectos_pdes pp ON rp.id_proyecto_pdes = pp.id
                                LEFT JOIN spie_presupuesto_proyectos_pdes prp ON pp.id = prp.id_proyecto_pdes
                                WHERE 1=1
                                GROUP BY".$selectCol.",".$descripcion."
                                ORDER BY".$selectCol." ASC");
        }

         return \Response::json($datos);
      }
    }



    public function tableroSiep()
    {
      return view('ModuloPdes.tablero_siep');
    }


    public function participacion()
    {
      return view('ModuloPdes.participacion');
    }


    public function datosGraficaParticipacion(Request $request)
    {
      if($request->ajax()) {

        $participacion = \DB::table('spie_participacion_niveles_gobierno_competencia')
                       ->where(' pnv.id_pilar', $request->pilar)
                       ->get();
        foreach ($participacion as $par) {

        }


        return \Response::json(array('cols'=>$chkCols,'rows'=>$chkRows,'dim'=>$chkDim,'dimval'=>$chkDimVal));
      }
    }

}
