<?php

namespace App\Http\Controllers\SistemaRemi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SistemaRemi\Indicadores;
use App\Models\SistemaRemi\TiposMedicion;

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

    $graficaAvanceMeta20 = \DB::select("SELECT 'Igual a 0' as titulo, COUNT(*) as valor
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
                              SELECT 'Entre 1 a 60' as titulo, COUNT(*) as valor
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
                              SELECT 'Entre 60 al 90 ' as titulo, COUNT(*) as valor
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
                              SELECT 'Entre 90 al 100 ' as titulo, COUNT(*) as valor
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
                              SELECT 'Mas de 100' as titulo, COUNT(*) as valor
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
                              WHERE ABS(tabla.datos_avance) > 100");

    $tipoindicadores = json_encode($tipoindicadores);
    $graficaAvanceMeta20 = json_encode($graficaAvanceMeta20);
    return view('SistemaRemi.index',compact('pdes','tipoindicadores','graficaAvanceMeta20'));
  }


  public function desagregarTipo(Request $request, $dato)
  {
    $sw=0;
    $sb=0;
    $tipo = "";
    $where = array();
    $orwhere = array();

    $tipo = TiposMedicion::where('id',$dato)->get();
    //$indicadores = Indicadores::orwhere($orwhere)->where($where)->where('activo',true)->appends("tipo",$request->tipo)->appends("unidad",$request->unidad)->appends("buscar",$request->buscar)->paginate(5);
    if($dato==0){
       $indicadores = Indicadores::where('activo',true)->whereNull('tipo')->paginate(5);
    }else{
       $indicadores = Indicadores::where('activo',true)->where('tipo',$tipo[0]->nombre)->paginate(5);
    }
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


    return view('SistemaRemi.indicador-desagregar-tipo',compact('indicadores','arrayDatosExtras'));
  }
}
