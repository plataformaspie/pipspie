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
use App\Models\SistemaRemi\IndicadorAvance;
use App\Models\SistemaRemi\Resultados;
use App\Models\SistemaRemi\VistaCatalogoPdespmr;
use App\Models\SistemaRemi\Frecuencia;
use App\Models\SistemaRemi\FuenteDatos;
use App\Models\SistemaRemi\FuenteDatosResponsable;
use App\Models\SistemaRemi\FuenteTipos;
use App\Models\SistemaRemi\IndicadoresArchivosRespaldos;

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
  /*public function setIndicadores(Request $request)
  {
    //$indicadores = Indicadores::paginate();
    $sw=0;
    $sb=0;
    $tipo = "";
    $unidad = "";
    $buscar = "";
    $where = array();
    $orwhere = array();

    if($request->has('buscar')){
        $sb=1;
        $orwhere[] = array(\DB::raw("upper(lower(nombre))"),'LIKE','%'.mb_strtoupper($request->buscar,'utf-8') .'%');
        $buscar = $request->buscar;
        $sw++;
    }
    if($request->has('tipo')){
        $where[] = array("tipo","=",$request->tipo);
        $tipo = $request->tipo;
        $sw++;
    }
    if($request->has('unidad')){
        $where[] = array("unidad_medida","=",$request->unidad);
        $unidad = $request->unidad;
        $sw++;
    }

    if($sw > 0){

          $indicadores = Indicadores::orwhere($orwhere)->where($where)->where('activo',true)->paginate(5)->appends("tipo",$request->tipo)->appends("unidad",$request->unidad)->appends("buscar",$request->buscar);

    }else{
          $indicadores = Indicadores::where('activo',true)->paginate(5);
    }



    $tiposMedicion = TiposMedicion::get();
    $unidadesMedidas = UnidadesMedidas::get();

    return view('SistemaRemi.set-indicadores',compact('indicadores','tipo','unidad','tiposMedicion','unidadesMedidas','buscar'));
  }*/

  public function setIndicadores(Request $request)
  {
    //$indicadores = Indicadores::paginate();
    $sw=0;
    $sb=0;
    $tipo = "";
    $unidad = "";
    $buscar = "";
    $pdes = 1;
    $where = array();
    $orwhere = array();

    if($request->has('buscar')){
        $sb=1;
        $orwhere[] = array(\DB::raw("upper(lower(nombre))"),'LIKE','%'.mb_strtoupper($request->buscar,'utf-8') .'%');
        $buscar = $request->buscar;
        $sw++;
    }
    if($request->has('tipo')){
        $where[] = array("tipo","=",$request->tipo);
        $tipo = $request->tipo;
        $sw++;
    }
    if($request->has('unidad')){
        $where[] = array("unidad_medida","=",$request->unidad);
        $unidad = $request->unidad;
        $sw++;
    }
    if($request->has('pdes')){
        $pdes = $request->pdes;
    }

    if($sw > 0){

          $indicadores = Indicadores::orwhere($orwhere)->where($where)->where('activo',true)->paginate(5)->appends("tipo",$request->tipo)->appends("unidad",$request->unidad)->appends("buscar",$request->buscar);

    }else{
          $indicadores = Indicadores::where('activo',true)->paginate(5);
    }


    $filtropdes = \DB::select("SELECT c.logo,pilar,meta,desc_m,resultado,desc_r,i.id as id_indicador,i.nombre
                              FROM pdes_vista_catalogo_pmr c
                              LEFT JOIN remi_indicador_pdes_resultado ir ON c.id_resultado = ir.id_resultado
                              LEFT JOIN remi_indicadores i ON ir.id_indicador = i.id
                              WHERE cod_p = ".$pdes."
                              ORDER BY cod_p,cod_m,cod_r ASC");

    $countPilar = \DB::select("SELECT count(i.id) as total
                          FROM pdes_vista_catalogo_pmr c
                          LEFT JOIN remi_indicador_pdes_resultado ir ON c.id_resultado = ir.id_resultado
                          LEFT JOIN remi_indicadores i ON ir.id_indicador = i.id AND i.activo = true
                          WHERE cod_p = ".$pdes);
    $countPilar =$countPilar[0];


    $tiposMedicion = TiposMedicion::get();
    $unidadesMedidas = UnidadesMedidas::get();

    return view('SistemaRemi.set-indicadores',compact('indicadores','tipo','unidad','tiposMedicion','unidadesMedidas','buscar','filtropdes','countPilar'));
  }


  public function dataIndicador($id)
  {
    $indicador = Indicadores::find($id);
    $pdes = \DB::select("SELECT c.*,ir.id
                         FROM remi_indicador_pdes_resultado ir
                         INNER JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                         WHERE ir.id_indicador = ".$id);
    $metas = Metas::where('id_indicador',$id)->orderBy('gestion', 'asc')->get();
    $avance = IndicadorAvance::where('id_indicador',$id)->orderBy('fecha_generado', 'DESC')->first();


    $dataMetasAvance = \DB::select("SELECT m.gestion as dimension, m.valor  as meta, av.valor as avance
                            FROM remi_metas m
                            LEFT JOIN remi_indicador_avance av ON m.id_indicador = av.id_indicador AND m.gestion = av.fecha_generado_anio
                            WHERE m.id_indicador = ".$id."
                            ORDER BY m.gestion ASC
                            LIMIT 5");
    $metasAvance = \DB::select("SELECT m.gestion as dimension, m.valor  as meta, av.valor as avance
                            FROM remi_metas m
                            LEFT JOIN remi_indicador_avance av ON m.id_indicador = av.id_indicador AND m.gestion = av.fecha_generado_anio
                            WHERE m.id_indicador = ".$id."
                            ORDER BY m.gestion ASC");
    $archivos = IndicadoresArchivosRespaldos::where('id_indicador',$id)->get();


    $grafica = json_encode($dataMetasAvance);

    return view('SistemaRemi.data-indicador',compact('indicador','metas','pdes','avance','grafica','metasAvance','archivos'));
  }

  public function adminIndicador()
  {
    $tipos = TiposMedicion::get();
    $unidades = UnidadesMedidas::where('activo',true)->get();
    $dimensiones = Dimensiones::where('id_variable',4)->get();
    $variables = Variables::get();
    $frecuencia = Frecuencia::get();
    $fuente_datos = FuenteDatos::get();
    $fuente_tipos = FuenteTipos::get();
    return view('SistemaRemi.admin-indicador',compact('tipos','unidades','variables','frecuencia','fuente_datos','fuente_tipos','dimensiones'));
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
    $codigo = "";
    if(!$request->id_indicador){

        if(isset($request->resultado_articulado)){
            $vistaPmr = VistaCatalogoPdespmr::where('id_resultado',$request->resultado_articulado[0])->first();
            $codigo = $vistaPmr->codigo_ext.($vistaPmr->correlativo_indicador+1);
            $resultado = Resultados::find($vistaPmr->id_resultado);
            $resultado->correlativo_indicador = ($vistaPmr->correlativo_indicador+1);
            $resultado->save();
        }

        try{
            $indicador = new Indicadores();
            $indicador->codigo = $codigo;
            $indicador->nombre = $request->nombre;
            $indicador->etapa = $request->etapa;
            $indicador->tipo = $request->tipo;
            $indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
            $indicador->unidad_medida = $request->unidad_medida;
            $indicador->frecuencia = $request->frecuencia;
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
            $indicador->linea_base_valor = ($request->linea_base_valor)?$this->format_numerica_db($request->linea_base_valor,','):0;
            $indicador->fuente_datos = ($request->fuente_datos)?implode(",", $request->fuente_datos):null;

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

            $metasList = array('1'=>2016,'2'=>2017,'3'=>2018,'4'=>2019,'5'=>2020,'6'=>2025,'7'=>2030);
            for($i=1; $i <= count($metasList); $i++){
                $metas = new Metas();
                $metas->id_indicador = $indicador->id;
                $metas->gestion = $metasList[$i];
                $metas->valor = ($request->input('meta_'.$metasList[$i]))?$this->format_numerica_db($request->input('meta_'.$metasList[$i]),',') : 0;
                $metas->save();
            }

            if(isset($request->avance_fecha)){
              foreach ($request->avance_fecha as $k => $v) {
                    $avance = new IndicadorAvance();
                    $avance->id_indicador = $indicador->id;
                    $fechaAV="";
                    if($request->avance_fecha[$k]){
                      list ( $mes, $anio ) = explode ( "/", $request->avance_fecha[$k] );
                      $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
              		    $fechaAV = $anio . "-" . $mes . "-" . $dia;
                    }
                    $avance->fecha_generado = $fechaAV;
                    $avance->fecha_generado_dia = $dia;
                    $avance->fecha_generado_mes = $mes;
                    $avance->fecha_generado_anio = $anio;
                    $avance->fecha_reportado = date('Y-m-d');
                    $avance->valor =  ($request->avance_valor[$k])?$this->format_numerica_db($request->avance_valor[$k],','):0;
                    $avance->save();
              }
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
            if($indicador->codigo == ""){
              if(isset($request->resultado_articulado)){
                  $vistaPmr = VistaCatalogoPdespmr::where('id_resultado',$request->resultado_articulado[0])->first();
                  $codigo = $vistaPmr->codigo_ext.($vistaPmr->correlativo_indicador+1);
                  $resultado = Resultados::find($vistaPmr->id_resultado);
                  $resultado->correlativo_indicador = ($vistaPmr->correlativo_indicador+1);
                  $resultado->save();
              }
              $indicador->codigo = $codigo;
            }

            $indicador->nombre = $request->nombre;
            $indicador->etapa = $request->etapa;
            $indicador->tipo = $request->tipo;
            $indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
            $indicador->unidad_medida = $request->unidad_medida;
            $indicador->frecuencia = $request->frecuencia;
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
            $indicador->linea_base_valor = ($request->linea_base_valor)?$this->format_numerica_db($request->linea_base_valor,','):0;
            $indicador->fuente_datos = ($request->fuente_datos)?implode(",", $request->fuente_datos):null;
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

            if(isset($request->avance_fecha)){
              foreach ($request->avance_fecha as $k => $v) {
                  if(!$request->id_avance[$k]){
                        $avance = new IndicadorAvance();
                        $avance->id_indicador = $indicador->id;
                        $fechaAV="";
                        if($request->avance_fecha[$k]){
                          list ( $mes, $anio ) = explode ( "/", $request->avance_fecha[$k] );
                          $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
                  		    $fechaAV = $anio . "-" . $mes . "-" . $dia;
                        }
                        $avance->fecha_generado = $fechaAV;
                        $avance->fecha_generado_dia = $dia;
                        $avance->fecha_generado_mes = $mes;
                        $avance->fecha_generado_anio = $anio;
                        $avance->fecha_reportado = date('Y-m-d');
                        $avance->valor = ($request->avance_valor[$k])?$this->format_numerica_db($request->avance_valor[$k],','):0;
                        $avance->save();
                   }else{
                        if($request->avance_estado[$k]==0){
                          $avance = IndicadorAvance::find($request->id_avance[$k]);
                          $avance->delete();
                        }
                   }
              }
            }

            $metasList = array('1'=>2016,'2'=>2017,'3'=>2018,'4'=>2019,'5'=>2020,'6'=>2025,'7'=>2030);
            for($i=1; $i <= count($metasList); $i++){
                $metas = Metas::find($request->input('id_meta_'.$metasList[$i]));
                $metas->valor = ($request->input('meta_'.$metasList[$i]))? $this->format_numerica_db($request->input('meta_'.$metasList[$i]),',') : 0;
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
      $avances = IndicadorAvance::where('id_indicador',$request->id)->get();
      $archivos = IndicadoresArchivosRespaldos::where('id_indicador',$request->id)->get();
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.",
          'indicador' => $indicador,
          'pdes' => $pdes,
          'metas' => $metas,
          'avances' => $avances,
          'archivos' => $archivos)
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

  public function apiSourceOrderbyArray(Request $request)
  {
      if($request->fechas){
          $array = $request->fechas;

          $orderByAr = Array();
          $i=0;
          foreach ($array as $key => $value) {
            $orderByAr[$i]['index'] = $key;
            list ( $mes, $anio ) = explode ( "/", $value );
            $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
            $fecha = $anio . "-" . $mes . "-" . $dia;
            $orderByAr[$i]['filtro'] = $fecha;
            $orderByAr[$i]['valor'] = $value;
            $i++;
          }

          $sortArray = array();

          foreach($orderByAr as $validate){
              foreach($validate as $key=>$value){
                  if(!isset($sortArray[$key])){
                      $sortArray[$key] = array();
                  }
                  $sortArray[$key][] = $value;
              }
          }

          $orderby = "filtro"; //change this to whatever key you want from the array
          array_multisort($sortArray[$orderby],SORT_DESC,$orderByAr);
          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se guardo con exito.",
              'item' =>$orderByAr)
          );
    }else{
      return \Response::json(array(
          'error' => true,
          'title' => "Vacio!",
          'msg' => "la matriz esta vacia.",
          'item' => [] )
      );
    }
  }

  public function ordenar_fecha($a, $b)
  {
     $a = strtotime($a);
     $b = strtotime($b);
     return strcmp($a, $b);
  }

  public function apiSetFuenteDatos(Request $request)
  {

      //$fuenteId = explode(",", $request->fuente);
      if($request->fuente){
      $dataFuente = FuenteDatos::whereIn('id',$request->fuente)->get();
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.",
          'item' =>$dataFuente)
      );
    }else{
      return \Response::json(array(
          'error' => true,
          'title' => "Alert!",
          'msg' => "No se recupero ningun codigo valido.",
          'item' => "")
      );
    }
  }


  public function apiSourceOrderbyArray2(Request $request)
  {
      if($request->responsable1){
          $array = $request->responsable1;

          $orderByAr = Array();
          $i=0;
          foreach ($array as $key => $value) {
            $orderByAr[$i]['index'] = $key;
            $orderByAr[$i]['filtro'] = $value;
            $orderByAr[$i]['valor'] = $value;
            $i++;
          }

          $sortArray = array();

          foreach($orderByAr as $validate){
              foreach($validate as $key=>$value){
                  if(!isset($sortArray[$key])){
                      $sortArray[$key] = array();
                  }
                  $sortArray[$key][] = $value;
              }
          }

          $orderby = "filtro"; //change this to whatever key you want from the array
          array_multisort($sortArray[$orderby],SORT_ASC,$orderByAr);
          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se guardo con exito.",
              'item' =>$orderByAr)
          );
    }else{
      return \Response::json(array(
          'error' => true,
          'title' => "Vacio!",
          'msg' => "la matriz esta vacia.",
          'item' => [] )
      );
    }
  }

  public function apiSaveFuente(Request $request)
  {

    if(!$request->id_fuente){

        try{
            $fuente = new FuenteDatos();
            $fuente->codigo = "";
            $fuente->acronimo = $request->fd_acronimo;
            $fuente->nombre = $request->fd_nombre;
            $fuente->tipo = $request->fd_tipo;
            $fuente->periodicidad = $request->fd_periodicidad;
            $fuente->serie_datos = $request->fd_serie_datos;
            $fuente->cobertura_geografica = ($request->fd_cobertura_geografica)?implode(",", $request->fd_cobertura_geografica):null;
            $fuente->nivel_representatividad_datos = $request->fd_nivel_representatividad_datos;
            $fuente->variable =($request->fd_variable)?implode(",", $request->fd_variable):null;
            $fuente->observacion = $request->fd_observacion;
            $fuente->activo = true;
            $fuente->save();


            if(isset($request->responsable_nivel_1)){
              foreach ($request->responsable_nivel_1 as $k => $v) {
                    $responsable = new FuenteDatosResponsable();
                    $responsable->id_fuente = $fuente->id;
                    $responsable->responsable_nivel_1 = $request->responsable_nivel_1[$k];
                    $responsable->responsable_nivel_2 = $request->responsable_nivel_2[$k];
                    $responsable->responsable_nivel_3 = $request->responsable_nivel_3[$k];
                    $responsable->numero_referencia = $request->numero_referencia[$k];
                    $responsable->save();
              }
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

          ///agregar el update

      }
  }

  public function apiUpdateComboFuente(Request $request)
  {
      $dataFuente = FuenteDatos::select('id','nombre')->get();
      /*foreach ($dataFuente as $value) {
        $data[$value->id] = $value->nombre;
      }*/
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.",
          'item' =>$dataFuente)
      );

  }
  public function setPdes(Request $request)
  {
      $pdes = VistaCatalogoPdespmr::get();
      $html = "";
      foreach ($pdes as $value) {
        $html .= '<tr>
                      <td>P'.$value["cod_p"].'</td>
                      <td>M'.$value["cod_m"].'</td>
                      <td>R'.$value["cod_r"].'</td>
                  </tr>';
      }
      return \Response::json($html);

  }

  public function format_numerica_db($numeric,$decimal){
    if($decimal == '.'){
      $formated = str_replace(',','',$numeric);
    }elseif($decimal == ','){
      $formated = str_replace('.','',$numeric);
      $formated = str_replace(',','.',$formated);
    }else{
      $formated = str_replace(',','',$numeric);
    }
    return $formated;
  }


}
