<?php

namespace App\Http\Controllers\SistemaRemi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SistemaRemi\TiposMedicion;
use App\Models\SistemaRemi\UnidadesMedidas;
use App\Models\SistemaRemi\Dimensiones;
use App\Models\SistemaRemi\FuenteDatos;
use App\Models\SistemaRemi\FuenteDatosResponsable;
use App\Models\SistemaRemi\FuenteTipos;
use App\Models\SistemaRemi\Frecuencia;
use App\Models\SistemaRemi\FuenteTiposRecoleccion;
use App\Models\SistemaRemi\FuenteTiposCategoriaTematica;



class FuenteDatosController extends Controller
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

  public function setFuenteDatos()
  {

    return view('SistemaRemi.set-fuente-datos');
  }

  public function adminFuenteDatos()
  {

    $tipos = TiposMedicion::get();
    $unidades = UnidadesMedidas::where('activo',true)->get();
    $dimensiones = Dimensiones::where('id_variable',4)->get();
    //$variables = Variables::get();
    $frecuencia = Frecuencia::get();
    $fuente_datos = FuenteDatos::get();
    $fuente_tipos = FuenteTipos::get();
    $recoleccion = FuenteTiposRecoleccion::get();
    $demografia = FuenteTiposCategoriaTematica::where('grupo','Demografía y Estadísticas Sociales')->get();
    $economicas = FuenteTiposCategoriaTematica::where('grupo','Estadísticas Económicas')->get();
    $medioambientales = FuenteTiposCategoriaTematica::where('grupo','Estadísticas Medioambientales')->get();
    $geoespacial = FuenteTiposCategoriaTematica::where('grupo','Información Geoespacial')->get();
    return view('SistemaRemi.admin-fuente-datos',compact('tipos','unidades','frecuencia','fuente_datos','fuente_tipos','dimensiones','recoleccion','demografia','economicas','medioambientales','geoespacial'));
  }

  public function apiSetListFuenteDatos(Request $request)
  {
      $dataFuente = FuenteDatos::join('remi_fuente_datos_responsable as fdr', 'remi_fuente_datos.id', '=', 'fdr.id_fuente')
                  ->orderBy('nombre','ASC')
                  ->select('remi_fuente_datos.id','remi_fuente_datos.codigo','remi_fuente_datos.nombre', 'remi_fuente_datos.acronimo','remi_fuente_datos.tipo','fdr.responsable_nivel_1')
                  ->get();
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


  public function apiSaveFuenteDatos(Request $request)
  {
    $this->user= \Auth::user();

    $codigo = "";
    if(!$request->id_fuente){

        try{
            $fuente = new FuenteDatos();
            $fuente->acronimo = $request->acronimo;
            $fuente->tipo = $request->tipo;
            //$indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
            $fuente->objetivo = $request->objetivo;
            $fuente->serie_datos = $request->serie_datos;
            $fuente->periodicidad = $request->periodicidad;
            $fuente->variable = $request->variable;
            $fuente->modo_recoleccion_datos = $request->modo_recoleccion_datos;
            $fuente->modo_recoleccion_datos_otro = $request->modo_recoleccion_datos_otro;
            $fuente->unidad_analisis = $request->numerador_detalle;
            $fuente->universo_estudio = $request->universo_estudio;
            $fuente->disenio_tamanio_muestra = $request->disenio_tamanio_muestra;
            $fuente->observacion = $request->observacion;

            $fuente->demografia_estadistica_social = ($request->demografia_estadistica_social)?implode(",", $request->fuente_datos):null;
            $fuente->demografia_estadistica_social_otro = $request->demografia_estadistica_social_otro;
            $fuente->estadistica_economica = ($request->estadistica_economica)?implode(",", $request->fuente_datos):null;
            $fuente->estadistica_economica_otro = $request->estadistica_economica_otro;
            $fuente->estadistica_medioambiental = ($request->estadistica_medioambiental)?implode(",", $request->fuente_datos):null;
            $fuente->estadistica_medioambiental_otro = $request->estadistica_medioambiental_otro;
            $fuente->informacion_geoespacial = ($request->informacion_geoespacial)?implode(",", $request->fuente_datos):null;
            $fuente->informacion_geoespacial_otro = $request->informacion_geoespacial_otro;

            $fuente->numero_total_formulario = $request->numero_total_formulario;
            $fuente->nombre_formulario = ($request->nombre_formulario)?implode("|", $request->nombre_formulario):null;







            $fuente->serie_disponible = $request->serie_disponible;
            $fuente->observacion = $request->observacion;
            $fuente->estado = 1;
            $fuente->logo = "default.png";
            $fuente->id_user = $this->user->id;
            $dia = null;
            $mes = null;
            $anio = null;
            $fechaLB =null;
            if($request->linea_base_fecha){
              list ( $mes, $anio ) = explode ( "/", $request->linea_base_fecha );
              $dia = date('t', mktime(0,0,0, $mes, 1, $anio));
      		    $fechaLB = $anio . "-" . $mes . "-" . $dia;
            }
            $fuente->linea_base_fecha = $fechaLB;
            $fuente->linea_base_anio = $anio;
            $fuente->linea_base_mes = $mes;
            $fuente->linea_base_dia = $dia;
            $fuente->linea_base_valor = ($request->linea_base_valor)?$this->format_numerica_db($request->linea_base_valor,','):0;
            $fuente->fuente_datos = ($request->fuente_datos)?implode(",", $request->fuente_datos):null;

            $fuente->activo = true;
            $fuente->save();



            if(isset($request->responsable_nivel_1)){
              foreach ($request->responsable_nivel_1 as $k => $v) {
                    $responsable = new FuenteDatosResponsable();
                    $responsable->id_fuente = $fuente->id;
                    $responsable->responsable_nivel_1 = $request->responsable_nivel_1[$k];
                    $responsable->responsable_nivel_2 = $request->responsable_nivel_2[$k];
                    $responsable->responsable_nivel_3 = $request->responsable_nivel_3[$k];
                    $responsable->responsable_nivel_4 = $request->responsable_nivel_4[$k];
                    $responsable->numero_referencia = $request->numero_referencia[$k];
                    $responsable->id_user = $this->user->id;
                    $responsable->save();
              }
            }






            if(isset($request->arc_archivo)){
              foreach ($request->arc_archivo as $k => $v) {
                    $archivos = new IndicadoresArchivosRespaldos();
                    $archivos->id_fuente = $fuente->id;
                    $archivos->nombre =  $request->arc_nombre[$k];
                    $archivos->archivo = $request->arc_archivo[$k];
                    $archivos->activo = true;
                    $archivos->id_user = $this->user->id;
                    $archivos->save();
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
            //$indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
            $indicador->variables_desagregacion = $request->variables_desagregacion;
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
            $indicador->id_user_updated = $this->user->id;
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
                        $indicadorPdes->id_user = $this->user->id;
                        $indicadorPdes->save();
                    }else{
                        if($request->estado_resultado_articulado[$k]==0){
                          $indicadorPdes = IndicadorResultado::find($request->id_resultado_articulado[$k]);
                          $indicadorPdes->id_user_updated = $this->user->id;
                          $indicadorPdes->save();
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
                        $avance->id_user = $this->user->id;
                        $avance->save();
                   }else{
                        if($request->avance_estado[$k]==0){
                          $avance = IndicadorAvance::find($request->id_avance[$k]);
                          $avance->id_user_updated = $this->user->id;
                          $avance->save();
                          $avance->delete();
                        }
                   }
              }
            }

            $metasList = array('1'=>2016,'2'=>2017,'3'=>2018,'4'=>2019,'5'=>2020,'6'=>2025,'7'=>2030);
            for($i=1; $i <= count($metasList); $i++){
                $metas = Metas::find($request->input('id_meta_'.$metasList[$i]));
                $metas->valor = ($request->input('meta_'.$metasList[$i]))? $this->format_numerica_db($request->input('meta_'.$metasList[$i]),',') : 0;
                $metas->id_user_updated = $this->user->id;
                $metas->save();
            }


            if(isset($request->arc_archivo)){
              foreach ($request->arc_archivo as $k => $v) {
                    if(!$request->arc_id[$k]){
                        $archivos = new IndicadoresArchivosRespaldos();
                        $archivos->id_indicador = $indicador->id;
                        $archivos->nombre =  $request->arc_nombre[$k];
                        $archivos->archivo = $request->arc_archivo[$k];
                        $archivos->activo = true;
                        $archivos->id_user = $this->user->id;
                        $archivos->save();
                    }else{
                        if($request->arc_estado[$k]==0){
                          $archivos = IndicadoresArchivosRespaldos::find($request->arc_id[$k]);
                          $archivos->activo = false;
                          $archivos->id_user_updated = $this->user->id;
                          $archivos->save();
                        }
                    }
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
      }
  }





}
