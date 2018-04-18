<?php

namespace App\Http\Controllers\SistemaRemi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SistemaRemi\Indicadores;
use App\Models\SistemaRemi\TiposMedicion;
use App\Models\SistemaRemi\UnidadesMedidas;
use App\Models\SistemaRemi\Dimensiones;
use App\Models\SistemaRemi\Variables;
use App\Models\SistemaRemi\IndicadorResultado;
use App\Models\SistemaRemi\Metas;

class IndicadorController extends Controller
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

        $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." AND activo = true ORDER BY orden ASC");
        array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'tipo_menu'=>$mn->tipo_menu,'submenus' => $submenu));
    }



    \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);



    return $next($request);

    });

  }
  public function setIndicadores(Request $request)
  {
    //$indicadores = Indicadores::paginate();
    $sw=0;
    $tipo = "";
    $unidad = "";

    if($request->has('buscar')){
        dd($request->buscar);
    }
    if($request->has('tipo')){
        $where[] = array("tipo","=",$request->tipo);
        $append[] = array("tipo",$request->tipo);
        $tipo = $request->tipo;
        $sw++;
    }
    if($request->has('unidad')){
        $where[] = array("unidad_medida","=",$request->unidad);
        $append[] = array("unidad",$request->unidad);
        $unidad = $request->unidad;
        $sw++;
    }

    if($sw>0){

        $indicadores = Indicadores::where($where)->where('activo',true)->paginate(5)->appends("tipo",$request->tipo)->appends("unidad",$request->unidad);

    }else{

      $indicadores = Indicadores::where('activo',true)->paginate(5);

    }
    // $indicadores = \DB::select("SELECT *
    //                             FROM remi_indicadores")->paginate(5);

    return view('SistemaRemi.set-indicadores',compact('indicadores','tipo','unidad'));
  }


  public function dataIndicador($id)
  {

    $indicador = Indicadores::find($id);

    // $indicadores = \DB::select("SELECT *
    //                             FROM remi_indicadores")->paginate(5);
    return view('SistemaRemi.data-indicador',compact('indicador'));
  }

  public function adminIndicador()
  {
    $tipos = TiposMedicion::get();
    $unidades = UnidadesMedidas::where('activo',true)->get();
    $dimensiones = Dimensiones::get();
    $variables = Variables::get();
    return view('SistemaRemi.admin-indicador',compact('tipos','unidades','variables'));
  }

  public function setDataPdes(Request $request)
  {
    try{
        $sql = \DB::select("SELECT  *
                            FROM pdes_vista_catalogo_pmr
                            where cod_p = ".$request->p."
                            AND cod_m = ".$request->m."
                            AND cod_r = '".$request->r."'");

        if($sql){
          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se recupero datos con exito.",
              'set' => $sql)
          );
        }else{
          return \Response::json(array(
              'error' => true,
              'title' => "Alerta!",
              'msg' => "No existe la articulación solicitada.",
              'set' => "")
          );
        }
    }
    catch (Exception $e) {
        return \Response::json(array(
          'error' => true,
          'title' => "Error!",
          'msg' => $e->getMessage())
        );
    }

  }


  public function apiSetIndicadores(Request $request)
  {
      $indicadores = Indicadores::where('activo',true)->orderBy('id','asc')->get();
      return \Response::json($indicadores);
  }

  public function apiSaveIndicador(Request $request)
  {

    if(!$request->id_indicador){
        try{

            $indicador = new Indicadores();
            $indicador->codigo = "";
            $indicador->nombre = $request->nombre;
            $indicador->tipo = $request->tipo;
            $indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
            $indicador->unidad_medida = $request->unidad_medida;
            $indicador->definicion = $request->definicion;
            $indicador->formula = $request->formula;
            $indicador->numerador_detalle = $request->numerador_detalle;
            $indicador->numerador_fuente = $request->numerador_fuente;
            $indicador->denominador_detalle = $request->denominador_detalle;
            $indicador->denominador_fuente = $request->denominador_fuente;
            $indicador->serie_disponible = $request->serie_disponible;
            $indicador->observacion = $request->observacion;
            $indicador->estado = 1;
            $indicador->logo = "default.png";
            $dia = null;
            $mes = null;
            $anio = null;
            $fechaLB =null;
            if($request->linea_base_fecha){
              list ( $mes, $anio ) = explode ( "/", $request->linea_base_fecha );
              $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
      		    $fechaLB = $anio . "-" . $mes . "-" . $dia;
            }
            $indicador->linea_base_fecha = $fechaLB;
            $indicador->linea_base_anio = $anio;
            $indicador->linea_base_mes = $mes;
            $indicador->linea_base_dia = $dia;
            $indicador->linea_base_valor = $request->linea_base_valor;
            $indicador->activo = true;
            $indicador->save();


            if(isset($request->resultado_articulado)){
              foreach ($request->resultado_articulado as $k => $v) {
                    $indicadorPdes = new IndicadorResultado();
                    $indicadorPdes->id_indicador = $indicador->id;
                    $indicadorPdes->id_resultado = $request->resultado_articulado[$k];
                    $indicadorPdes->save();
              }
            }

            $metasList = array('1'=>2020,'2'=>2025,'3'=>2030);
            for($i=1; $i <= count($metasList); $i++){
                $metas = new Metas();
                $metas->id_indicador = $indicador->id;
                $metas->gestion = $metasList[$i];
                $metas->valor = $request->input('meta_'.$metasList[$i]);
                $metas->save();
            }

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg' => "Se guardo con exito.")
            );

          }
          catch (Exception $e) {
              return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg' => $e->getMessage())
              );
          }
      }else{
        try{
            $indicador = Indicadores::find($request->id_indicador);
            $indicador->codigo = "";
            $indicador->nombre = $request->nombre;
            $indicador->tipo = $request->tipo;
            $indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
            $indicador->unidad_medida = $request->unidad_medida;
            $indicador->definicion = $request->definicion;
            $indicador->formula = $request->formula;
            $indicador->numerador_detalle = $request->numerador_detalle;
            $indicador->numerador_fuente = $request->numerador_fuente;
            $indicador->denominador_detalle = $request->denominador_detalle;
            $indicador->denominador_fuente = $request->denominador_fuente;
            $indicador->serie_disponible = $request->serie_disponible;
            $indicador->observacion = $request->observacion;
            $indicador->logo = "default.png";
            $dia = null;
            $mes = null;
            $anio = null;
            $fechaLB =null;
            if($request->linea_base_fecha){
              list ( $mes, $anio ) = explode ( "/", $request->linea_base_fecha );
              $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
              $fechaLB = $anio . "-" . $mes . "-" . $dia;
            }
            $indicador->linea_base_fecha = $fechaLB;
            $indicador->linea_base_anio = $anio;
            $indicador->linea_base_mes = $mes;
            $indicador->linea_base_dia = $dia;
            $indicador->linea_base_valor = $request->linea_base_valor;
            $indicador->save();


            if(isset($request->resultado_articulado)){
              foreach ($request->resultado_articulado as $k => $v) {
                    if(!$request->id_resultado_articulado[$k]){
                        $indicadorPdes = new IndicadorResultado();
                        $indicadorPdes->id_indicador = $indicador->id;
                        $indicadorPdes->id_resultado = $request->resultado_articulado[$k];
                        $indicadorPdes->save();
                    }else{
                        if($request->estado_resultado_articulado[$k]==0){
                          $indicadorPdes = IndicadorResultado::find($request->id_resultado_articulado[$k]);
                          $indicadorPdes->delete();
                        }
                    }
              }
            }

            $metasList = array('1'=>2020,'2'=>2025,'3'=>2030);
            for($i=1; $i <= count($metasList); $i++){
                $metas = Metas::find($request->input('id_meta_'.$metasList[$i]));
                $metas->valor = $request->input('meta_'.$metasList[$i]);
                $metas->save();
            }

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg' => "Se guardo con exito.")
            );

          }
          catch (Exception $e) {
              return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg' => $e->getMessage())
              );
          }
      }
  }


  public function apiDataSetIndicador(Request $request)
  {
      $indicador = Indicadores::where('id',$request->id)->get();
      $pdes = \DB::select("SELECT c.*,ir.id
                           FROM remi_indicador_pdes_resultado ir
	                         INNER JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                           WHERE ir.id_indicador = ".$request->id);
      $metas = Metas::where('id_indicador',$request->id)->get();
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.",
          'indicador' => $indicador,
          'pdes' => $pdes,
          'metas' => $metas)
      );
  }

  public function apiDeleteIndicador(Request $request)
  {
      $indicador = Indicadores::find($request->id_indicador);
      $indicador->activo = false;
      $indicador->save();
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.")
      );
  }

}
