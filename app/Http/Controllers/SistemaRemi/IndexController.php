<?php

namespace App\Http\Controllers\SistemaRemi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SistemaRemi\Indicadores;
use App\Models\SistemaRemi\TiposMedicion;
use App\Models\SistemaRemi\Etapas;

class IndexController extends Controller
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
        array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'target' => $mn->target,'id_html' => $mn->id_html,'sigla' => $mn->sigla));
    }


    $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 11 AND activo = true ORDER BY m.tipo_menu,m.orden ASC");
    $this->menus = array();
    foreach ($sql as $mn) {

        //$submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." AND activo = true ORDER BY orden ASC");
    $submenu = \DB::select("SELECT s.* FROM sub_menus s INNER JOIN roles_sub_menus rs ON s.id = rs.id_sub_menu
          WHERE rs.id_rol = ".$rol." AND s.id_menu = ".$mn->id." AND s.activo = true  ORDER BY orden ASC");
        array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'tipo_menu'=>$mn->tipo_menu,'class'=>$mn->class,'submenus' => $submenu));
    }



    \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);



    return $next($request);

    });

  }
  public function index()
  {
    $pdes = array();
    for($i=1;$i<=13;$i++){
      $countPilar = \DB::select("SELECT count(i.id) as total
                            FROM pdes_vista_catalogo_pmr c
                            inner JOIN remi_indicador_pdes_resultado ir ON c.id_resultado = ir.id_resultado
                            inner JOIN remi_indicadores i ON (ir.id_indicador = i.id AND i.activo = true)
                            WHERE cod_p = ".$i);
      $countPilar =$countPilar[0];
      $pdes[$i]=$countPilar->total;
    }

    $tipoindicadores = \DB::select("SELECT
                                    CASE
                                    WHEN i.tipo<>'' THEN i.tipo
                                    ELSE 'Sin clasificar'
                                    END AS titulo,
                                    COUNT(i.id) as valor,
                                    CASE
                                    WHEN tm.id > 0 THEN ('/sistemarime/desagregarTipo/'||tm.id)
                                    ELSE '/sistemarime/desagregarTipo/0'
                                    END AS url
                                    FROM remi_indicadores i
                                    LEFT JOIN remi_tipos_medicion tm ON i.tipo = tm.nombre
                                    WHERE i.activo = TRUE
                                    GROUP BY i.tipo,tm.id");

    $rangoAvance = Array('r1' =>'ABS(tabla.datos_avance) = 0',
                         'r2' =>'ABS(tabla.datos_avance) > 0 and ABS(tabla.datos_avance) <= 60',
                         'r3' =>'ABS(tabla.datos_avance) > 60 and ABS(tabla.datos_avance) <= 90',
                         'r4' =>'ABS(tabla.datos_avance) > 90 and ABS(tabla.datos_avance) <= 100',
                         'r5' =>'ABS(tabla.datos_avance) > 100');

    $graficaAvanceMeta20 = \DB::select("SELECT *
                          FROM(
                          SELECT 'Igual a 0' as titulo, COUNT(*) as valor,'/sistemarime/desagregarAvance/r1' as url, 1 as orden
                              FROM (
                              		SELECT fuente.id,
                              		fuente.avance,
                              		CASE
                              			 WHEN fuente.avance_2020 <> 0 THEN
                              				CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2020/fuente.brecha_2020)*100,4) ELSE 0 END
                              			 ELSE
                              			 CASE
                              				WHEN fuente.avance_2019 <> 0
                              				THEN
                              					CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2019/fuente.brecha_2020)*100,4) ELSE 0	END
                              				ELSE
                              				 CASE
                              					 WHEN fuente.avance_2018 <> 0
                              					 THEN
                              							CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2018/fuente.brecha_2020)*100,4) ELSE 0 END
                              					 ELSE
                              					 CASE
                              						 WHEN fuente.avance_2017 <> 0
                              						 THEN
                              								CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2017/fuente.brecha_2020)*100,4) ELSE	0	END
                              						 ELSE
                              						 CASE
                              							 WHEN fuente.avance_2016 <> 0
                              							 THEN
                              									CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2016/fuente.brecha_2020)*100,4) ELSE	0	END
                              							 ELSE
                              							   0
                              						 END
                              					 END
                              				 END
                              			 END
                              		END as datos_avance
                              		FROM(
                              		SELECT *
                              		FROM remi_vista_avances_totales
                              		) as fuente
                              ) as tabla
                              WHERE ABS(tabla.datos_avance) = 0
                              UNION
                              SELECT 'Entre 0 a 60' as titulo, COUNT(*) as valor,'/sistemarime/desagregarAvance/r2' as url, 2 as orden
                              FROM (
                              		SELECT fuente.id,
                              		fuente.avance,
                              		CASE
                              			 WHEN fuente.avance_2020 <> 0 THEN
                              				CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2020/fuente.brecha_2020)*100,4) ELSE 0 END
                              			 ELSE
                              			 CASE
                              				WHEN fuente.avance_2019 <> 0
                              				THEN
                              					CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2019/fuente.brecha_2020)*100,4) ELSE 0	END
                              				ELSE
                              				 CASE
                              					 WHEN fuente.avance_2018 <> 0
                              					 THEN
                              							CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2018/fuente.brecha_2020)*100,4) ELSE 0 END
                              					 ELSE
                              					 CASE
                              						 WHEN fuente.avance_2017 <> 0
                              						 THEN
                              								CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2017/fuente.brecha_2020)*100,4) ELSE	0	END
                              						 ELSE
                              						 CASE
                              							 WHEN fuente.avance_2016 <> 0
                              							 THEN
                              									CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2016/fuente.brecha_2020)*100,4) ELSE	0	END
                              							 ELSE
                              							   0
                              						 END
                              					 END
                              				 END
                              			 END
                              		END as datos_avance
                              		FROM(
                              		SELECT *
                              		FROM remi_vista_avances_totales
                              		) as fuente
                              ) as tabla
                              WHERE ABS(tabla.datos_avance) > 0 and ABS(tabla.datos_avance) <= 60
                              UNION
                              SELECT 'Entre 60 al 90 ' as titulo, COUNT(*) as valor,'/sistemarime/desagregarAvance/r3' as url, 3 as orden
                              FROM (
                              		SELECT fuente.id,
                              		fuente.avance,
                              		CASE
                              			 WHEN fuente.avance_2020 <> 0 THEN
                              				CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2020/fuente.brecha_2020)*100,4) ELSE 0 END
                              			 ELSE
                              			 CASE
                              				WHEN fuente.avance_2019 <> 0
                              				THEN
                              					CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2019/fuente.brecha_2020)*100,4) ELSE 0	END
                              				ELSE
                              				 CASE
                              					 WHEN fuente.avance_2018 <> 0
                              					 THEN
                              							CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2018/fuente.brecha_2020)*100,4) ELSE 0 END
                              					 ELSE
                              					 CASE
                              						 WHEN fuente.avance_2017 <> 0
                              						 THEN
                              								CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2017/fuente.brecha_2020)*100,4) ELSE	0	END
                              						 ELSE
                              						 CASE
                              							 WHEN fuente.avance_2016 <> 0
                              							 THEN
                              									CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2016/fuente.brecha_2020)*100,4) ELSE	0	END
                              							 ELSE
                              							   0
                              						 END
                              					 END
                              				 END
                              			 END
                              		END as datos_avance
                              		FROM(
                              		SELECT *
                              		FROM remi_vista_avances_totales
                              		) as fuente
                              ) as tabla
                              WHERE ABS(tabla.datos_avance) > 60 and ABS(tabla.datos_avance) <= 90
                              UNION
                              SELECT 'Entre 90 al 100 ' as titulo, COUNT(*) as valor,'/sistemarime/desagregarAvance/r4' as url, 4 as orden
                              FROM (
                              		SELECT fuente.id,
                              		fuente.avance,
                              		CASE
                              			 WHEN fuente.avance_2020 <> 0 THEN
                              				CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2020/fuente.brecha_2020)*100,4) ELSE 0 END
                              			 ELSE
                              			 CASE
                              				WHEN fuente.avance_2019 <> 0
                              				THEN
                              					CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2019/fuente.brecha_2020)*100,4) ELSE 0	END
                              				ELSE
                              				 CASE
                              					 WHEN fuente.avance_2018 <> 0
                              					 THEN
                              							CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2018/fuente.brecha_2020)*100,4) ELSE 0 END
                              					 ELSE
                              					 CASE
                              						 WHEN fuente.avance_2017 <> 0
                              						 THEN
                              								CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2017/fuente.brecha_2020)*100,4) ELSE	0	END
                              						 ELSE
                              						 CASE
                              							 WHEN fuente.avance_2016 <> 0
                              							 THEN
                              									CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2016/fuente.brecha_2020)*100,4) ELSE	0	END
                              							 ELSE
                              							   0
                              						 END
                              					 END
                              				 END
                              			 END
                              		END as datos_avance
                              		FROM(
                              		SELECT *
                              		FROM remi_vista_avances_totales
                              		) as fuente
                              ) as tabla
                              WHERE ABS(tabla.datos_avance) > 90 and ABS(tabla.datos_avance) <= 100
                              UNION
                              SELECT 'Mas de 100' as titulo, COUNT(*) as valor,'/sistemarime/desagregarAvance/r5' as url, 5 as orden
                              FROM (
                              		SELECT fuente.id,
                              		fuente.avance,
                              		CASE
                              			 WHEN fuente.avance_2020 <> 0 THEN
                              				CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2020/fuente.brecha_2020)*100,4) ELSE 0 END
                              			 ELSE
                              			 CASE
                              				WHEN fuente.avance_2019 <> 0
                              				THEN
                              					CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2019/fuente.brecha_2020)*100,4) ELSE 0	END
                              				ELSE
                              				 CASE
                              					 WHEN fuente.avance_2018 <> 0
                              					 THEN
                              							CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2018/fuente.brecha_2020)*100,4) ELSE 0 END
                              					 ELSE
                              					 CASE
                              						 WHEN fuente.avance_2017 <> 0
                              						 THEN
                              								CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2017/fuente.brecha_2020)*100,4) ELSE	0	END
                              						 ELSE
                              						 CASE
                              							 WHEN fuente.avance_2016 <> 0
                              							 THEN
                              									CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2016/fuente.brecha_2020)*100,4) ELSE	0	END
                              							 ELSE
                              							   0
                              						 END
                              					 END
                              				 END
                              			 END
                              		END as datos_avance
                              		FROM(
                              		SELECT *
                              		FROM remi_vista_avances_totales
                              		) as fuente
                              ) as tabla
                              WHERE ABS(tabla.datos_avance) > 100
                            ) as consolidado
                            ORDER BY consolidado.orden ASC");

    $tipoindicadores = json_encode($tipoindicadores);
    $graficaAvanceMeta20 = json_encode($graficaAvanceMeta20);

    $indicadoresEtapa = \DB::select("SELECT i.etapa as name, count(i.etapa) as value,('/sistemarime/desagregarEtapa/'||e.id) as url
                                    FROM remi_indicadores i
                                    INNER JOIN remi_etapas e ON i.etapa = e.nombre
                                    WHERE i.activo = true
                                    GROUP BY i.etapa,e.id
                                    ORDER BY e.id ASC");
    $indicadoresEtapa = json_encode($indicadoresEtapa);

     $pdesPilares = \DB::select("SELECT fuente.cod_p,
                                  CASE
                                  WHEN fuente.pilar is null
                                  THEN
                                  	'No Articulados'
                                  ELSE
                                  	fuente.pilar
                                  END as name,
                                  COUNT(*) as value,
                                  CASE
                                  WHEN fuente.cod_p is null
                                  THEN
                                  	'/sistemarime/desagregarEtapa/0'
                                  ELSE
                                  	('/sistemarime/desagregarEtapa/'||fuente.cod_p)
                                  END as url
                                  FROM (
                                  SELECT *
                                  FROM remi_indicadores i
                                  LEFT JOIN remi_indicador_pdes_resultado ir ON i.id = ir.id_indicador
                                  LEFT JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                                  WHERE i.activo = true
                                  ORDER BY i.id ASC
                                  ) fuente
                                  GROUP BY fuente.pilar,fuente.cod_p
                                  ORDER BY value DESC");
    $pdesPilares = json_encode($pdesPilares);

    $totalIndicadores = \DB::select("SELECT COUNT(*) as total
                                    FROM remi_indicadores
                                    WHERE activo = true");
    $totalIndicadores = $totalIndicadores[0]->total;

    return view('SistemaRemi.index',compact('pdes','tipoindicadores','graficaAvanceMeta20','indicadoresEtapa','pdesPilares','totalIndicadores'));
  }

  public function listaIndicadores()
  {
    $sw=0;
    $sb=0;
    $tipo = "";
    $where = array();
    $orwhere = array();
    $color="";


    $indicadores = Indicadores::where('activo',true)->orderBy('id','ASC')->paginate(5);

    $dataAvanceIds = '';
    foreach ($indicadores as  $value) {
        $dataAvanceIds.=$value->id.",";
    }
    $dataAvanceIds = trim($dataAvanceIds,',');
    $datosExtras = \DB::select("SELECT fuente.id,
                              (
                              	SELECT string_agg(DISTINCT c.logo,',')
                              	FROM remi_indicador_pdes_resultado ir
                              	INNER JOIN pdes_vista_catalogo_pmr c ON  ir.id_resultado = c.id_resultado
                              	WHERE id_indicador = fuente.id
                              ) as pdes_logo,
                              (
                              	SELECT string_agg(DISTINCT c.codigo,',')
                              	FROM remi_indicador_pdes_resultado ir
                              	INNER JOIN pdes_vista_catalogo_pmr c ON  ir.id_resultado = c.id_resultado
                              	WHERE id_indicador = fuente.id
                              ) as pdes_codigo,
                              (
                              	SELECT string_agg(DISTINCT c.logo,',')
                              	FROM remi_indicador_ods_indicador io
                              	INNER JOIN ods_vista_catalogo_omi c ON  io.id_resultado_ods = c.id_indicador
                              	WHERE io.id_indicador_ods = fuente.id
                              ) as ods_logo,
                              (
                              	SELECT string_agg(DISTINCT c.codigo,',')
                              	FROM remi_indicador_ods_indicador io
                              	INNER JOIN ods_vista_catalogo_omi c ON  io.id_resultado_ods = c.id_indicador
                              	WHERE io.id_indicador_ods = fuente.id
                              ) as ods_codigo
                              FROM(
                              SELECT id
                              FROM remi_indicadores
                              WHERE activo = true
                              AND id IN (".$dataAvanceIds.")
                              ORDER BY id ASC
                              ) as fuente
                              ");
  $arrayDatosExtras = Array();
  foreach ($datosExtras as $key => $value) {
    $arrayDatosExtras[$value->id]['pdes_logo']=explode(",",$value->pdes_logo);
    $arrayDatosExtras[$value->id]['pdes_codigo']=explode(",",$value->pdes_codigo);
    $arrayDatosExtras[$value->id]['ods_logo']=explode(",",$value->ods_logo);
    $arrayDatosExtras[$value->id]['ods_codigo']=explode(",",$value->ods_codigo);
  }
  $arrayDatosAvances = $this->datosAvances($dataAvanceIds);
  $arrayEjecutadoIndicadores = $this->ejecutadoIndicadores($dataAvanceIds,"");



  return view('SistemaRemi.indicador-desagregar-lista-indicadores',compact('indicadores','arrayDatosExtras','arrayDatosAvances',
    'arrayEjecutadoIndicadores','color'));
  }



  public function desagregarTipo(Request $request, $dato)
  {
    $sw=0;
    $sb=0;
    $tipo = "";
    $where = array();
    $orwhere = array();
    $color="";

    $tipo = TiposMedicion::where('id',$dato)->get();
    //$indicadores = Indicadores::orwhere($orwhere)->where($where)->where('activo',true)->appends("tipo",$request->tipo)->appends("unidad",$request->unidad)->appends("buscar",$request->buscar)->paginate(5);
    if($dato==0){
       $indicadores = Indicadores::where('activo',true)->whereNull('tipo')->orderBy('id','ASC')->paginate(5);
    }else{
       $indicadores = Indicadores::where('activo',true)->where('tipo',$tipo[0]->nombre)->orderBy('id','ASC')->paginate(5);
    }
    $dataAvanceIds = '';
    foreach ($indicadores as  $value) {
        $dataAvanceIds.=$value->id.",";
    }
    $dataAvanceIds = trim($dataAvanceIds,',');
    $datosExtras = \DB::select("SELECT fuente.id,
                              (
                              	SELECT string_agg(DISTINCT c.logo,',')
                              	FROM remi_indicador_pdes_resultado ir
                              	INNER JOIN pdes_vista_catalogo_pmr c ON  ir.id_resultado = c.id_resultado
                              	WHERE id_indicador = fuente.id
                              ) as pdes_logo,
                              (
                              	SELECT string_agg(DISTINCT c.codigo,',')
                              	FROM remi_indicador_pdes_resultado ir
                              	INNER JOIN pdes_vista_catalogo_pmr c ON  ir.id_resultado = c.id_resultado
                              	WHERE id_indicador = fuente.id
                              ) as pdes_codigo,
                              (
                              	SELECT string_agg(DISTINCT c.logo,',')
                              	FROM remi_indicador_ods_indicador io
                              	INNER JOIN ods_vista_catalogo_omi c ON  io.id_resultado_ods = c.id_indicador
                              	WHERE io.id_indicador_ods = fuente.id
                              ) as ods_logo,
                              (
                              	SELECT string_agg(DISTINCT c.codigo,',')
                              	FROM remi_indicador_ods_indicador io
                              	INNER JOIN ods_vista_catalogo_omi c ON  io.id_resultado_ods = c.id_indicador
                              	WHERE io.id_indicador_ods = fuente.id
                              ) as ods_codigo
                              FROM(
                              SELECT id
                              FROM remi_indicadores
                              WHERE activo = true
                              AND id IN (".$dataAvanceIds.")
                              ORDER BY id ASC
                              ) as fuente
                              ");
  $arrayDatosExtras = Array();
  foreach ($datosExtras as $key => $value) {
    $arrayDatosExtras[$value->id]['pdes_logo']=explode(",",$value->pdes_logo);
    $arrayDatosExtras[$value->id]['pdes_codigo']=explode(",",$value->pdes_codigo);
    $arrayDatosExtras[$value->id]['ods_logo']=explode(",",$value->ods_logo);
    $arrayDatosExtras[$value->id]['ods_codigo']=explode(",",$value->ods_codigo);
  }
  $arrayDatosAvances = $this->datosAvances($dataAvanceIds);
  $arrayEjecutadoIndicadores = $this->ejecutadoIndicadores($dataAvanceIds,"");



    return view('SistemaRemi.indicador-desagregar-tipo',compact('indicadores','arrayDatosExtras','arrayDatosAvances',
    'arrayEjecutadoIndicadores','color'));
  }



  public function desagregarEtapa(Request $request, $dato)
  {
    $sw=0;
    $sb=0;
    $etapa = "";
    $where = array();
    $orwhere = array();
    $color="";

    $etapa = Etapas::where('id',$dato)->get();
    //$indicadores = Indicadores::orwhere($orwhere)->where($where)->where('activo',true)->appends("tipo",$request->tipo)->appends("unidad",$request->unidad)->appends("buscar",$request->buscar)->paginate(5);

    $indicadores = Indicadores::where('activo',true)->where('etapa',$etapa[0]->nombre)->orderBy('id','ASC')->paginate(5);

    $dataAvanceIds = '';
    foreach ($indicadores as  $value) {
        $dataAvanceIds.=$value->id.",";
    }
    $dataAvanceIds = trim($dataAvanceIds,',');
    $datosExtras = \DB::select("SELECT fuente.id,
                              (
                              	SELECT string_agg(DISTINCT c.logo,',')
                              	FROM remi_indicador_pdes_resultado ir
                              	INNER JOIN pdes_vista_catalogo_pmr c ON  ir.id_resultado = c.id_resultado
                              	WHERE id_indicador = fuente.id
                              ) as pdes_logo,
                              (
                              	SELECT string_agg(DISTINCT c.codigo,',')
                              	FROM remi_indicador_pdes_resultado ir
                              	INNER JOIN pdes_vista_catalogo_pmr c ON  ir.id_resultado = c.id_resultado
                              	WHERE id_indicador = fuente.id
                              ) as pdes_codigo,
                              (
                              	SELECT string_agg(DISTINCT c.logo,',')
                              	FROM remi_indicador_ods_indicador io
                              	INNER JOIN ods_vista_catalogo_omi c ON  io.id_resultado_ods = c.id_indicador
                              	WHERE io.id_indicador_ods = fuente.id
                              ) as ods_logo,
                              (
                              	SELECT string_agg(DISTINCT c.codigo,',')
                              	FROM remi_indicador_ods_indicador io
                              	INNER JOIN ods_vista_catalogo_omi c ON  io.id_resultado_ods = c.id_indicador
                              	WHERE io.id_indicador_ods = fuente.id
                              ) as ods_codigo
                              FROM(
                              SELECT id
                              FROM remi_indicadores
                              WHERE activo = true
                              AND id IN (".$dataAvanceIds.")
                              ORDER BY id ASC
                              ) as fuente
                              ");
  $arrayDatosExtras = Array();
  foreach ($datosExtras as $key => $value) {
    $arrayDatosExtras[$value->id]['pdes_logo']=explode(",",$value->pdes_logo);
    $arrayDatosExtras[$value->id]['pdes_codigo']=explode(",",$value->pdes_codigo);
    $arrayDatosExtras[$value->id]['ods_logo']=explode(",",$value->ods_logo);
    $arrayDatosExtras[$value->id]['ods_codigo']=explode(",",$value->ods_codigo);
  }
  $arrayDatosAvances = $this->datosAvances($dataAvanceIds);
  $arrayEjecutadoIndicadores = $this->ejecutadoIndicadores($dataAvanceIds,"");



    return view('SistemaRemi.indicador-desagregar-etapa',compact('indicadores','arrayDatosExtras','arrayDatosAvances',
    'arrayEjecutadoIndicadores','color'));
  }


  public function desagregarAvance(Request $request, $dato)
  {
    $sw=0;
    $sb=0;
    $where = array();
    $orwhere = array();
    $titulo="";
    $color="";

    $rangoAvance = Array('r1' =>'ABS(tabla.datos_avance) = 0',
                         'r2' =>'ABS(tabla.datos_avance) > 0 and ABS(tabla.datos_avance) <= 60',
                         'r3' =>'ABS(tabla.datos_avance) > 60 and ABS(tabla.datos_avance) <= 90',
                         'r4' =>'ABS(tabla.datos_avance) > 90 and ABS(tabla.datos_avance) <= 100',
                         'r5' =>'ABS(tabla.datos_avance) > 100');
   $rangoTitulos = Array('r1' =>'Igual a 0',
                        'r2' =>'Entre 0 a 60',
                        'r3' =>'Entre 60 al 90',
                        'r4' =>'Entre 90 al 100',
                        'r5' =>'Mas de 100');

    $rangoColores = Array('r1' =>'#505050',
                         'r2' =>'#EF5A28',
                         'r3' =>'#F9AE40',
                         'r4' =>'#009245',
                         'r5' =>'#40A4F9');
   $titulo = $rangoTitulos[$dato];
   $color = $rangoColores[$dato];
    $listIndicadores = \DB::select("SELECT  string_agg(tabla.id::text,',') as indicadores
                                    FROM (
                                    		SELECT fuente.id,
                                    		fuente.avance,
                                    		CASE
                                    			 WHEN fuente.avance_2020 <> 0 THEN
                                    				CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2020/fuente.brecha_2020)*100,4) ELSE 0 END
                                    			 ELSE
                                    			 CASE
                                    				WHEN fuente.avance_2019 <> 0
                                    				THEN
                                    					CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2019/fuente.brecha_2020)*100,4) ELSE 0	END
                                    				ELSE
                                    				 CASE
                                    					 WHEN fuente.avance_2018 <> 0
                                    					 THEN
                                    							CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2018/fuente.brecha_2020)*100,4) ELSE 0 END
                                    					 ELSE
                                    					 CASE
                                    						 WHEN fuente.avance_2017 <> 0
                                    						 THEN
                                    								CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2017/fuente.brecha_2020)*100,4) ELSE	0	END
                                    						 ELSE
                                    						 CASE
                                    							 WHEN fuente.avance_2016 <> 0
                                    							 THEN
                                    									CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2016/fuente.brecha_2020)*100,4) ELSE	0	END
                                    							 ELSE
                                    								 0
                                    						 END
                                    					 END
                                    				 END
                                    			 END
                                    		END as datos_avance
                                    		FROM(
                                    		SELECT *
                                    		FROM remi_vista_avances_totales
                                    		) as fuente
                                    ) as tabla
                                    WHERE ".$rangoAvance[$dato]);


    $indicadoresId = explode(",", $listIndicadores[0]->indicadores);
    $indicadores = Indicadores::whereIn('id',$indicadoresId)->orderBy('id','ASC')->paginate(5);
    $dataAvanceIds = '';
    foreach ($indicadores as  $value) {
        $dataAvanceIds.=$value->id.",";
    }
    $dataAvanceIds = trim($dataAvanceIds,',');

    $datosExtras = \DB::select("SELECT fuente.id,
                              (
                              	SELECT string_agg(DISTINCT c.logo,',')
                              	FROM remi_indicador_pdes_resultado ir
                              	INNER JOIN pdes_vista_catalogo_pmr c ON  ir.id_resultado = c.id_resultado
                              	WHERE id_indicador = fuente.id
                              ) as pdes_logo,
                              (
                              	SELECT string_agg(DISTINCT c.codigo,',')
                              	FROM remi_indicador_pdes_resultado ir
                              	INNER JOIN pdes_vista_catalogo_pmr c ON  ir.id_resultado = c.id_resultado
                              	WHERE id_indicador = fuente.id
                              ) as pdes_codigo,
                              (
                              	SELECT string_agg(DISTINCT c.logo,',')
                              	FROM remi_indicador_ods_indicador io
                              	INNER JOIN ods_vista_catalogo_omi c ON  io.id_resultado_ods = c.id_indicador
                              	WHERE io.id_indicador_ods = fuente.id
                              ) as ods_logo,
                              (
                              	SELECT string_agg(DISTINCT c.codigo,',')
                              	FROM remi_indicador_ods_indicador io
                              	INNER JOIN ods_vista_catalogo_omi c ON  io.id_resultado_ods = c.id_indicador
                              	WHERE io.id_indicador_ods = fuente.id
                              ) as ods_codigo
                              FROM(
                              SELECT id
                              FROM remi_indicadores
                              WHERE activo = true
                              AND id IN (".$dataAvanceIds.")
                              ORDER BY id ASC
                              ) as fuente
                              ");



  $arrayDatosExtras = Array();
  foreach ($datosExtras as $key => $value) {
    $arrayDatosExtras[$value->id]['pdes_logo']=explode(",",$value->pdes_logo);
    $arrayDatosExtras[$value->id]['pdes_codigo']=explode(",",$value->pdes_codigo);
    $arrayDatosExtras[$value->id]['ods_logo']=explode(",",$value->ods_logo);
    $arrayDatosExtras[$value->id]['ods_codigo']=explode(",",$value->ods_codigo);
  }
  $arrayDatosAvances = $this->datosAvances($dataAvanceIds);
  $arrayEjecutadoIndicadores = $this->ejecutadoIndicadores($dataAvanceIds,$rangoAvance[$dato]);

    return view('SistemaRemi.indicador-desagregar-avance',compact('indicadores','arrayDatosExtras',
    'arrayDatosAvances','arrayEjecutadoIndicadores','titulo','color'));
  }


  private function datosAvances($dataAvanceIds){
    $datosAvances = \DB::select('SELECT * FROM remi_vista_avances_totales WHERE id IN ('.$dataAvanceIds.')');
    $arrayDatosAvances = Array();
    foreach ($datosAvances as $key => $value) {
      $arrayDatosAvances[$value->id]['plazo_anios']=$value->plazo_anios;
      $arrayDatosAvances[$value->id]['meta_2020']=$value->meta_2020;
      $arrayDatosAvances[$value->id]['gestion_reporte']=$value->gestion_reporte;
      $arrayDatosAvances[$value->id]['avance_2016']=$value->avance_2016;
      $arrayDatosAvances[$value->id]['avance_2017']=$value->avance_2017;
      $arrayDatosAvances[$value->id]['avance_2018']=$value->avance_2018;
      $arrayDatosAvances[$value->id]['avance_2019']=$value->avance_2019;
      $arrayDatosAvances[$value->id]['avance_2020']=$value->avance_2020;
    }
    return $arrayDatosAvances;
  }
  private function ejecutadoIndicadores($dataAvanceIds,$rango){
    if($rango!=""){
      $rango = "WHERE ".$rango;
    }else{
      $rango = "";
    }
    $ejecutadoIndicadores = \DB::select("SELECT tabla.id,tabla.avance,tabla.datos_avance,ABS(tabla.datos_avance) as ejecutado
                                        FROM (
                                            SELECT fuente.id,
                                            fuente.avance,
                                            CASE
                                               WHEN fuente.avance_2020 <> 0 THEN
                                                CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2020/fuente.brecha_2020)*100,4) ELSE 0 END
                                               ELSE
                                               CASE
                                                WHEN fuente.avance_2019 <> 0
                                                THEN
                                                  CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2019/fuente.brecha_2020)*100,4) ELSE 0	END
                                                ELSE
                                                 CASE
                                                   WHEN fuente.avance_2018 <> 0
                                                   THEN
                                                      CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2018/fuente.brecha_2020)*100,4) ELSE 0 END
                                                   ELSE
                                                   CASE
                                                     WHEN fuente.avance_2017 <> 0
                                                     THEN
                                                        CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2017/fuente.brecha_2020)*100,4) ELSE	0	END
                                                     ELSE
                                                     CASE
                                                       WHEN fuente.avance_2016 <> 0
                                                       THEN
                                                          CASE WHEN fuente.brecha_2020 <> 0 THEN ROUND((fuente.variacion_2016/fuente.brecha_2020)*100,4) ELSE	0	END
                                                       ELSE
                                                         0
                                                     END
                                                   END
                                                 END
                                               END
                                            END as datos_avance
                                            FROM(
                                            SELECT *
                                            FROM remi_vista_avances_totales
                                            WHERE id IN (".$dataAvanceIds.")
                                            ) as fuente
                                        ) as tabla ".$rango);
      $arrayEjecutadoIndicadores = Array();
      foreach ($ejecutadoIndicadores as $key => $value) {
        $arrayEjecutadoIndicadores[$value->id]['avance']= $value->avance;
        $arrayEjecutadoIndicadores[$value->id]['datos_avance']= $value->datos_avance;
        $arrayEjecutadoIndicadores[$value->id]['ejecutado']= $value->ejecutado;
      }

      return $arrayEjecutadoIndicadores;
  }
}
