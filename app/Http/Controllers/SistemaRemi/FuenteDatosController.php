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
use App\Models\SistemaRemi\FuenteArchivosRespaldos;
use App\Models\SistemaRemi\FuenteTiposCobertura;
use App\Models\ModuloPdes\ProyectoPdes as Proyecto;
use Excel;



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
                  ->join('remi_estados as et', 'remi_fuente_datos.estado', '=', 'et.id')
                  ->where('remi_fuente_datos.activo', true)
                  ->orderBy('nombre','ASC')
                  ->select('remi_fuente_datos.id','remi_fuente_datos.codigo','remi_fuente_datos.nombre', 'remi_fuente_datos.acronimo','remi_fuente_datos.tipo','fdr.responsable_nivel_1','remi_fuente_datos.estado','et.nombre as estado','et.id as id_estado')
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

          $orderby = "index"; //change this to whatever key you want from the array
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
            $fuente->nombre = $request->nombre;
            $fuente->acronimo = $request->acronimo;
            $fuente->tipo = $request->tipo;
            //$indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
            $fuente->objetivo = $request->objetivo;
            $fuente->serie_datos = $request->serie_datos;
            $fuente->periodicidad = $request->periodicidad;
            $fuente->variable = $request->variable;
            $fuente->modo_recoleccion_datos = $request->modo_recoleccion_datos;
            $fuente->modo_recoleccion_datos_otro = $request->modo_recoleccion_datos_otro;
            $fuente->unidad_analisis = $request->unidad_analisis;
            $fuente->universo_estudio = $request->universo_estudio;
            $fuente->disenio_tamanio_muestra = $request->disenio_tamanio_muestra;
            $fuente->tasa_respuesta = $request->tasa_respuesta;
            $fuente->observacion = $request->observacion;

            $fuente->demografia_estadistica_social = ($request->demografia_estadistica_social)?implode(",", $request->demografia_estadistica_social):null;
            $fuente->demografia_estadistica_social_otro = $request->demografia_estadistica_social_otro;
            $fuente->estadistica_economica = ($request->estadistica_economica)?implode(",", $request->estadistica_economica):null;
            $fuente->estadistica_economica_otro = $request->estadistica_economica_otro;
            $fuente->estadistica_medioambiental = ($request->estadistica_medioambiental)?implode(",", $request->estadistica_medioambiental):null;
            $fuente->estadistica_medioambiental_otro = $request->estadistica_medioambiental_otro;
            $fuente->informacion_geoespacial = ($request->informacion_geoespacial)?implode(",", $request->informacion_geoespacial):null;
            $fuente->informacion_geoespacial_otro = $request->informacion_geoespacial_otro;

            $fuente->cobertura_geografica = ($request->cobertura)?implode(",", $request->cobertura):null;
            $fuente->nivel_representatividad_datos = ($request->desagregacion)?implode(",", $request->desagregacion):null;

            $fuente->numero_total_formulario = $request->numero_total_formulario;
            $fuente->nombre_formulario = ($request->nombre_formulario)?implode("|", $request->nombre_formulario):null;

            $fuente->confidencialidad = $request->confidencialidad;
            $fuente->notas_legales = $request->notas_legales;
            $fuente->id_user = $this->user->id;
            $fuente->estado = 1;
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
                    $responsable->activo = true;
                    $responsable->save();
              }
            }

            if(isset($request->arc_archivo)){
              foreach ($request->arc_archivo as $k => $v) {
                    $archivos = new FuenteArchivosRespaldos();
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
          $fuente = FuenteDatos::find($request->id_fuente);
          $fuente->nombre = $request->nombre;
          $fuente->acronimo = $request->acronimo;
          $fuente->tipo = $request->tipo;
          //$indicador->variables_desagregacion = ($request->variables_desagregacion)?implode(",", $request->variables_desagregacion):null;
          $fuente->objetivo = $request->objetivo;
          $fuente->serie_datos = $request->serie_datos;
          $fuente->periodicidad = $request->periodicidad;
          $fuente->variable = $request->variable;
          $fuente->modo_recoleccion_datos = $request->modo_recoleccion_datos;
          $fuente->modo_recoleccion_datos_otro = $request->modo_recoleccion_datos_otro;
          $fuente->unidad_analisis = $request->unidad_analisis;
          $fuente->universo_estudio = $request->universo_estudio;
          $fuente->disenio_tamanio_muestra = $request->disenio_tamanio_muestra;
          $fuente->tasa_respuesta = $request->tasa_respuesta;
          $fuente->observacion = $request->observacion;

          $fuente->demografia_estadistica_social = ($request->demografia_estadistica_social)?implode(",", $request->demografia_estadistica_social):null;
          $fuente->demografia_estadistica_social_otro = $request->demografia_estadistica_social_otro;
          $fuente->estadistica_economica = ($request->estadistica_economica)?implode(",", $request->estadistica_economica):null;
          $fuente->estadistica_economica_otro = $request->estadistica_economica_otro;
          $fuente->estadistica_medioambiental = ($request->estadistica_medioambiental)?implode(",", $request->estadistica_medioambiental):null;
          $fuente->estadistica_medioambiental_otro = $request->estadistica_medioambiental_otro;
          $fuente->informacion_geoespacial = ($request->informacion_geoespacial)?implode(",", $request->informacion_geoespacial):null;
          $fuente->informacion_geoespacial_otro = $request->informacion_geoespacial_otro;

          $fuente->numero_total_formulario = $request->numero_total_formulario;
          $fuente->nombre_formulario = ($request->nombre_formulario)?implode("|", $request->nombre_formulario):null;

          $fuente->cobertura_geografica = ($request->cobertura)?implode(",", $request->cobertura):null;
          $fuente->nivel_representatividad_datos = ($request->desagregacion)?implode(",", $request->desagregacion):null;

          $fuente->confidencialidad = $request->confidencialidad;
          $fuente->notas_legales = $request->notas_legales;
          $fuente->id_user_updated = $this->user->id;
          $fuente->estado =  $request->estado;

          $fuente->save();



          if(isset($request->responsable_nivel_1)){
            foreach ($request->responsable_nivel_1 as $k => $v) {
                  if(!$request->id_responsable[$k]){
                    $responsable = new FuenteDatosResponsable();
                    $responsable->id_fuente = $fuente->id;
                    $responsable->responsable_nivel_1 = $request->responsable_nivel_1[$k];
                    $responsable->responsable_nivel_2 = $request->responsable_nivel_2[$k];
                    $responsable->responsable_nivel_3 = $request->responsable_nivel_3[$k];
                    $responsable->responsable_nivel_4 = $request->responsable_nivel_4[$k];
                    $responsable->numero_referencia = $request->numero_referencia[$k];
                    $responsable->id_user = $this->user->id;
                    $responsable->activo = true;
                    $responsable->save();
                  }else{
                    if($request->responsable_estado[$k]==0){
                      $responsable = FuenteDatosResponsable::find($request->id_responsable[$k]);
                      $responsable->activo = false;
                      $responsable->id_user_updated = $this->user->id;
                      $responsable->save();
                    }else{
                      $responsable = FuenteDatosResponsable::find($request->id_responsable[$k]);
                      $responsable->responsable_nivel_1 = $request->responsable_nivel_1[$k];
                      $responsable->responsable_nivel_2 = $request->responsable_nivel_2[$k];
                      $responsable->responsable_nivel_3 = $request->responsable_nivel_3[$k];
                      $responsable->responsable_nivel_4 = $request->responsable_nivel_4[$k];
                      $responsable->numero_referencia = $request->numero_referencia[$k];
                      $responsable->id_user_updated = $this->user->id;
                      $responsable->save();
                    }

                  }

            }
          }

          if(isset($request->arc_archivo)){
              foreach ($request->arc_archivo as $k => $v) {
                    if(!$request->arc_id[$k]){
                        $archivos = new FuenteArchivosRespaldos();
                        $archivos->id_fuente= $fuente->id;
                        $archivos->nombre =  $request->arc_nombre[$k];
                        $archivos->archivo = $request->arc_archivo[$k];
                        $archivos->activo = true;
                        $archivos->id_user = $this->user->id;
                        $archivos->save();
                    }else{
                        if($request->arc_estado[$k]==0){
                          $archivos = FuenteArchivosRespaldos::find($request->arc_id[$k]);
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



  public function apiUploadArchivoRespaldo(Request $request)
  {
    $carpeta = "respaldos/";
    $nombreDataBase = "";
    $msgFile = "";
      if ( $request->arc_archivo_input )
      {
          $file = $request->arc_archivo_input;
          $nombre = $file->getClientOriginalName();
          $tipo = $file->getMimeType();
          $extension = $file->getClientOriginalExtension();
          $ruta_provisional = $file->getPathName();
          $size = $file->getSize();
          $nombreSystem = uniqid('FTD-');
          $src = $carpeta.$nombreSystem.'.'.$extension;
          if(move_uploaded_file($ruta_provisional, $src)){
              $msgFile ="Archivo Subido Correctamente.";
              $nombreDataBase = $nombreSystem.'.'.$extension;
          }else{
              $msgFile = "Error al Subir el Archivo.";
          }
          $resp['archivo'] = $nombreDataBase;
          $resp['nombre'] = $request->arc_nombre_input;

          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'item' => $resp,
              'msg' => $msgFile)
          );
      }else{
        return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'item' => "",
            'msg' => $request->arc_nombre_input)
        );
      }



  }

  public function apiDeleteArchivo(Request $request)
  {
      unlink('respaldos/'.$request->input('archivo'));
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Archivo eliminado")
      );

  }

  public function apiDataSetFuente(Request $request)
  {
      $fuente = FuenteDatos::join('remi_estados as et', 'remi_fuente_datos.estado', '=', 'et.id')
                          ->where('remi_fuente_datos.id',$request->id)
                          ->select('remi_fuente_datos.*','et.nombre as estado','et.id as id_estado')
                          ->get();
      $resposables = FuenteDatosResponsable::where('id_fuente',$request->id)->where('activo', true)->get();
      $archivos = FuenteArchivosRespaldos::where('id_fuente',$request->id)->where('activo', true)->get();
      $tiposCobertura = FuenteTiposCobertura::where('activo', true)->get();

      

      $cobertura = Array();
      foreach ($tiposCobertura as $item) {
        $cobertura[$item->id] = $item->nombre;
      }

      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.",
          'fuente' => $fuente,
          'responsables' => $resposables,
          'cobertura' => $cobertura,
          'archivos' => $archivos)
      );
  }


  public function apiRecuperarFuente(Request $request)
  {
      $this->user= \Auth::user();
      $indicador = FuenteDatos::find($request->id_fuente);
      $indicador->estado = 1;
      $indicador->id_user_updated = $this->user->id;
      $indicador->save();
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.")
      );
  }


  public function apiDeleteFuente(Request $request)
  {
      $this->user= \Auth::user();
      $indicador = FuenteDatos::find($request->id_fuente);
      $indicador->activo = false;
      $indicador->id_user_updated = $this->user->id;
      $indicador->save();
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.")
      );
  }

   

   public function descagarExcel(Request $request)
   { 
      $id = $request->id;
      $fuente = FuenteDatos::join('remi_estados as et', 'remi_fuente_datos.estado', '=', 'et.id')
                          ->where('remi_fuente_datos.id',$request->id)
                          ->select('remi_fuente_datos.*','et.nombre as estado','et.id as id_estado')
                          ->get();
        $fuenteTipo = $fuente;
        $fuenteDatos = array();
        $cadenaAdministrativo = "Registro Administrativo";
        $cadenaEncuesta = "Encuesta";

        $identificacion = array();
        $categoriaTematica = array();
        $formularios = array();
        $cobertura = array();
        $responsables = array();
        $accesoInformacion = array();

        

      foreach ($fuenteTipo as $ft){
         if($ft->tipo == $cadenaAdministrativo){
            $cabeceraIdentificacion =  [
                                'TITULO FUENTE DATOS',
                                'ABREVIACION',
                                'TIPO',
                                'OBJETIVO',
                                'SERIE DISPONIBL',
                                'PERIODICIDAD',
                                'VARIABLES/CAMPO CLAVE',
                                'MODO RECOLECCION DATOS',
                                'UNIDAD DE ANALISIS',
                                'UNIVERSO DE ESTUDIO',
                                'OBSERVACIONES'];
            $cabeceraCategoriaTematica =[                    
                                'DEMOGRAFIA Y ESTADISTICAS SOCIALES',
                                'ESTADISTICAS ECONOMICAS',
                                'ESTADISTICAS MEDIOAMBIENTALES',
                                'INFORMACION GEOESPACIAL'];

            $cabeceraFormularios = array(); 
            $cabeceraCobertura = array();
            $cabeceraResponsables = array();
            $cabeceraAccesoInformacion = array();  
            $cabeceraTitulos = array();                 
                                
            foreach ($fuente as $f) {
                   $identificacion['Titulo_Fuente_Datos']           = $f->nombre;
                   $identificacion['Abreviacion']                   = $f->acronimo;
                   $identificacion['Tipo']                          = $f->tipo;
                   $identificacion['Objetivo']                      = $f->objetivo;
                   $identificacion['Serie_Disponible']              = $f->serie_datos;
                   $identificacion['Periodicidad']                  = $f->periodicidad;
                   $identificacion['Variable_campo_clave']          = $f->variable;
                   $identificacion['recoleccion_datos']             = $f->modo_recoleccion_datos;
                   $identificacion['unidad_analisis']               = $f->unidad_analisis;
                   $identificacion['universo_estudio']              = $f->universo_estudio;
                   $identificacion['observacion']                   = $f->observacion;

                   array_push($cabeceraTitulos, 'IDENTIFICACION');

                   $categoriaTematica['demografia_estadistica_social'] = $f->demografia_estadistica_social;
                   $categoriaTematica['estadistica_economica']         = $f->estadistica_economica;
                   $categoriaTematica['estadistica_medioambiental']    = $f->estadistica_medioambiental;
                   $categoriaTematica['informacion_geoespacial']       = $f->informacion_geoespacial;

                   array_push($cabeceraTitulos, 'CATEGORIA TEMATICA');
                   //trabajando numero de formulario
                   array_push($formularios,$f->numero_total_formulario);
                          

                   
                   array_push($cabeceraFormularios,'CANTIDAD FORMULARIOS');
                   $formulario = explode("|",$f->nombre_formulario);
                   $varFor = 1;
                   for($i=0;$i<count($formulario);$i++){
                     $key = 'FORM_'.$varFor;
                     
                     array_push($formularios, $formulario[$i]);
                     array_push($cabeceraFormularios, $key);
                     $varFor++;
                   }

                   array_push($cabeceraTitulos, 'FORMULARIOS');

                   $cobertura['cobertura_rraa']                = $f->cobertura_rraa;
                   $cobertura['cobertura_rraa_descripcion']    = $f->cobertura_rraa_descripcion;
                   array_push($cabeceraCobertura,'COBERTURA DEL RRAA');
                   array_push($cabeceraCobertura,'DESCRIPCION DEL RRAA');
                   ///trabajando cobertura 'COBERTURA GEOGRAFICA DE LA FUENTE',
                   
                  $cober = explode(",", $f->cobertura_geografica);
                  $co = FuenteTiposCobertura::whereIn('id', $cober)->get();
                  $cadenaCobertura = "";
                  foreach ($co as $c) {
                     $cadenaCobertura = '-'.$cadenaCobertura.$c->nombre;
                  }
                  $cobertura['cobertura_geografica'] = $cadenaCobertura;
                  array_push($cabeceraCobertura,'COBERTURA GEOGRAFICA');

                  //trabajando  nivel de representatividad/nivel de desagregacion
                  $nivelDesagregacion = explode(",", $f->cobertura_geografica);
                  $co = FuenteTiposCobertura::whereIn('id', $nivelDesagregacion)->get();
                  $cadenaDesagregacion = "";
                  foreach ($co as $c) {
                     $cadenaDesagregacion = '-'.$cadenaDesagregacion.$c->nombre;
                  }
                   
                  $cobertura['nivel_Desagregacion'] = $cadenaDesagregacion;
                  array_push($cabeceraCobertura,'NIVEL DE DESAGREGACION'); 

                  array_push($cabeceraTitulos, 'COBERTURA');

                   //TRABAJANDO RESPONSANBLE
                 
                  $responsablesCuantos = FuenteDatosResponsable::where('id_fuente',$request->id)->where('activo', true)->get();
                  
                  $varRes = 1;
                  foreach ($responsablesCuantos as $r) 
                  {
                     $key = 'RESPONSABLE_'.$varRes;
                     array_push($cabeceraResponsables,$key );
                     array_push($responsables, $r->responsable_nivel_1,$r->responsable_nivel_2,$r->responsable_nivel_3,$r->responsable_nivel_4,$r->numero_referencia);
                    
                     array_push($cabeceraTitulos, $key);
                     $varRes++;
                  }
                  $cabeceraAccesoInformacion = [
                                'CONFIDENCIALIDAD',
                                'NOTAS LEGALES'
                                ];

                  $confidencialidad['confidencialidad'] = $f->confidencialidad;
                  $confidencialidad['notas_legales'] = $f->notas_legales;
                  array_push($cabeceraTitulos, 'ACCESO INFORMACION');
                  //dd($cabeceraTitulos);
                  $cabeceraDatos = array();
                  $cabeceraDatos['cIdentificacion'] = $cabeceraIdentificacion;
                  $cabeceraDatos['cTematica'] = $cabeceraCategoriaTematica;
                  $cabeceraDatos['cFormularios'] = $cabeceraFormularios;
                  $cabeceraDatos['cCobertura'] = $cabeceraCobertura;
                  $cabeceraDatos['cResponsables'] = $cabeceraResponsables;
                  $cabeceraDatos['cAccesoInformacion'] = $cabeceraAccesoInformacion;
                  $contenido = array();
                  $contenido['identificacion'] = $identificacion;
                  $contenido['categoriaTematica'] = $categoriaTematica;
                  $contenido['formularios'] = $formularios;
                  $contenido['cobertura'] = $cobertura;
                  $contenido['responsables'] = $responsables;
                  //dd($responsables);
                  $contenido['accesoInformacion'] = $confidencialidad;


                  self::contruirExcel($cabeceraDatos,$contenido,$cabeceraTitulos);

            }


         //ENCUESTA   
         }elseif($ft->tipo == $cadenaEncuesta){
            $cabeceraIdentificacion =  [
                                'TITULO FUENTE DATOS',
                               'ABREVIACION',
                               'TIPO',
                               'OBJETIVO',
                               'SERIE DISPONIBLE',
                               'PERIODICIDAD',
                               'VARIABLES/CAMPO CLAVE',
                               'MODO RECOLECCION DATOS',
                               'UNIDAD DE ANALISIS',
                               'UNIVERSO DE ESTUDIO',
                               'DISEÑO Y TAMAÑO DE MUESTRA',
                               'TASA DE RESPUESTA',
                               'OBSERVACIONEs'];
            $cabeceraCategoriaTematica =[                    
                                 'DEMOGRAFIA Y ESTADISTICAS SOCIALES',
                                 'ESTADISTICAS ECONOMICAS',
                                 'ESTADISTICAS MEDIOAMBIENTALES',
                                 'INFORMACION GEOESPACIAL'];

            $cabeceraFormularios = array(); 
            $cabeceraCobertura = array();
            $cabeceraResponsables = array();
            $cabeceraAccesoInformacion = array();  
            $cabeceraTitulos = array();  

            foreach ($fuente as $f) {
               $identificacion['Titulo_Fuente_Datos'] = $f->nombre;
               $identificacion['Abreviacion'] = $f->acronimo;
               $identificacion['Tipo'] = $f->tipo;
               $identificacion['Objetivo'] = $f->objetivo;
               $identificacion['Serie_Disponible'] = $f->serie_datos;
               $identificacion['Periodicidad'] = $f->periodicidad;
               $identificacion['Variable_campo_clave'] = $f->variable;
               $identificacion['recoleccion_datos'] = $f->modo_recoleccion_datos;


               $identificacion['unidad_analisis'] = $f->unidad_analisis;
               $identificacion['universo_estudio'] = $f->universo_estudio;
               $identificacion['disenio_tamanio_muestra'] = $f->disenio_tamanio_muestra;
               $identificacion['tasa_respuesta'] = $f->tasa_respuesta;
               $identificacion['observacion'] = $f->observacion;
               array_push($cabeceraTitulos,'IDENTIFICACION');

               $categoriaTematica['demografia_estadistica_social'] = $f->demografia_estadistica_social;
               $categoriaTematica['estadistica_economica'] = $f->estadistica_economica;
               $categoriaTematica['estadistica_medioambiental'] = $f->estadistica_medioambiental;
               $categoriaTematica['informacion_geoespacial'] = $f->informacion_geoespacial;

               array_push($cabeceraTitulos, 'CATEGORIA TEMATICA');

               array_push($formularios,$f->numero_total_formulario);
               array_push($cabeceraFormularios,'CANTIDAD FORMULARIOS');
                   $formulario = explode("|",$f->nombre_formulario);
                   $varFor = 1;
                   for($i=0;$i<count($formulario);$i++){
                     $key = 'FORM_'.$varFor;
                     
                     array_push($formularios, $formulario[$i]);
                     array_push($cabeceraFormularios, $key);
                     $varFor++;
                   }

               array_push($cabeceraTitulos, 'FORMULARIOS');

                     
               ///trabajando cobertura 'COBERTURA GEOGRAFICA DE LA FUENTE',
                
                  $cober = explode(",", $f->cobertura_geografica);
                  $co = FuenteTiposCobertura::whereIn('id', $cober)->get();
                  $cadenaCobertura = "";
                  foreach ($co as $c) {
                     $cadenaCobertura = $cadenaCobertura.$c->nombre.',';
                  }
                  $cadenaCobertura = trim($cadenaCobertura, ','); 
                  $cobertura['cobertura_geografica'] = $cadenaCobertura;
                  array_push($cabeceraCobertura,'COBERTURA GEOGRAFICA');

                  //trabajando  nivel de representatividad/nivel de desagregacion
                  $nivelDesagregacion = explode(",", $f->cobertura_geografica);
                  $co = FuenteTiposCobertura::whereIn('id', $nivelDesagregacion)->get();
                  $cadenaDesagregacion = "";
                  foreach ($co as $c) {
                     $cadenaDesagregacion = $cadenaDesagregacion.$c->nombre.',';
                  }
                  $cadenaDesagregacion = trim($cadenaDesagregacion, ','); 
                  $cobertura['nivel_Desagregacion'] = $cadenaDesagregacion;
                  array_push($cabeceraCobertura,'NIVEL DE DESAGREGACION'); 

                  array_push($cabeceraTitulos, 'COBERTURA');

                  //TRABAJANDO RESPONSANBLE
                 
                  $responsablesCuantos = FuenteDatosResponsable::where('id_fuente',$request->id)->where('activo', true)->get();
                  
                  $varRes = 1;
                  foreach ($responsablesCuantos as $r) 
                  {
                     $key = 'RESPONSABLE_'.$varRes;
                     array_push($cabeceraResponsables,$key );
                     array_push($responsables, $r->responsable_nivel_1,$r->responsable_nivel_2,$r->responsable_nivel_3,$r->responsable_nivel_4,$r->numero_referencia);
                    
                     array_push($cabeceraTitulos, $key);
                     $varRes++;
                  }
                  //ACCESO INFORMACION
                  $cabeceraAccesoInformacion = [
                                'CONFIDENCIALIDAD',
                                'NOTAS LEGALES'
                                ];

                  $confidencialidad['confidencialidad'] = $f->confidencialidad;
                  $confidencialidad['notas_legales'] = $f->notas_legales;
                  array_push($cabeceraTitulos, 'ACCESO INFORMACION');

                  //enviando informacion ENCUESTA
                  $cabeceraDatos = array();
                  $cabeceraDatos['cIdentificacion'] = $cabeceraIdentificacion;
                  $cabeceraDatos['cTematica'] = $cabeceraCategoriaTematica;
                  $cabeceraDatos['cFormularios'] = $cabeceraFormularios;
                  $cabeceraDatos['cCobertura'] = $cabeceraCobertura;
                  $cabeceraDatos['cResponsables'] = $cabeceraResponsables;
                  $cabeceraDatos['cAccesoInformacion'] = $cabeceraAccesoInformacion;
                  $contenido = array();
                  $contenido['identificacion'] = $identificacion;
                  $contenido['categoriaTematica'] = $categoriaTematica;
                  $contenido['formularios'] = $formularios;
                  $contenido['cobertura'] = $cobertura;
                  $contenido['responsables'] = $responsables;
                  
                  $contenido['accesoInformacion'] = $confidencialidad;

                  //dd($cabeceraDatos);
                  self::contruirExcel($cabeceraDatos,$contenido,$cabeceraTitulos);
            }
           
         }else{
            
            $cabeceraIdentificacion =  [
                                'TITULO FUENTE DATOS',
                               'ABREVIACION',
                               'TIPO',
                               'OBJETIVO',
                               'SERIE DISPONIBLE',
                               'PERIODICIDAD',
                               'VARIABLES/CAMPO CLAVE',
                               'MODO RECOLECCION DATOS',
                               'UNIDAD DE ANALISIS',
                               'UNIVERSO DE ESTUDIO',
                               'OBSERVACIONEs'];
            $cabeceraCategoriaTematica =[                    
                                 'DEMOGRAFIA Y ESTADISTICAS SOCIALES',
                                 'ESTADISTICAS ECONOMICAS',
                                 'ESTADISTICAS MEDIOAMBIENTALES',
                                 'INFORMACION GEOESPACIAL'];

            $cabeceraFormularios = array(); 
            $cabeceraCobertura = array();
            $cabeceraResponsables = array();
            $cabeceraAccesoInformacion = array();  
            $cabeceraTitulos = array();  

            foreach ($fuente as $f) {
               $identificacion['Titulo_Fuente_Datos'] = $f->nombre;
               $identificacion['Abreviacion'] = $f->acronimo;
               $identificacion['Tipo'] = $f->tipo;
               $identificacion['Objetivo'] = $f->objetivo;
               $identificacion['Serie_Disponible'] = $f->serie_datos;
               $identificacion['Periodicidad'] = $f->periodicidad;
               $identificacion['Variable_campo_clave'] = $f->variable;
               $identificacion['recoleccion_datos'] = $f->modo_recoleccion_datos;


               $identificacion['unidad_analisis'] = $f->unidad_analisis;
               $identificacion['universo_estudio'] = $f->universo_estudio;
              
               $identificacion['observacion'] = $f->observacion;
               array_push($cabeceraTitulos,'IDENTIFICACION');

               $categoriaTematica['demografia_estadistica_social'] = $f->demografia_estadistica_social;
               $categoriaTematica['estadistica_economica'] = $f->estadistica_economica;
               $categoriaTematica['estadistica_medioambiental'] = $f->estadistica_medioambiental;
               $categoriaTematica['informacion_geoespacial'] = $f->informacion_geoespacial;

               array_push($cabeceraTitulos, 'CATEGORIA TEMATICA');

               array_push($formularios,$f->numero_total_formulario);
               array_push($cabeceraFormularios,'CANTIDAD FORMULARIOS');
                   $formulario = explode("|",$f->nombre_formulario);
                   $varFor = 1;
                   for($i=0;$i<count($formulario);$i++){
                     $key = 'FORM_'.$varFor;
                     
                     array_push($formularios, $formulario[$i]);
                     array_push($cabeceraFormularios, $key);
                     $varFor++;
                   }

               array_push($cabeceraTitulos, 'FORMULARIOS');

                     
               ///trabajando cobertura 'COBERTURA GEOGRAFICA DE LA FUENTE',
                
                  $cober = explode(",", $f->cobertura_geografica);
                  $co = FuenteTiposCobertura::whereIn('id', $cober)->get();
                  $cadenaCobertura = "";
                  foreach ($co as $c) {
                     $cadenaCobertura = $cadenaCobertura.$c->nombre.',';
                  }
                  $cadenaCobertura = trim($cadenaCobertura, ','); 
                  $cobertura['cobertura_geografica'] = $cadenaCobertura;
                  array_push($cabeceraCobertura,'COBERTURA GEOGRAFICA');

                  //trabajando  nivel de representatividad/nivel de desagregacion
                  $nivelDesagregacion = explode(",", $f->cobertura_geografica);
                  $co = FuenteTiposCobertura::whereIn('id', $nivelDesagregacion)->get();
                  $cadenaDesagregacion = "";
                  foreach ($co as $c) {
                     $cadenaDesagregacion = $cadenaDesagregacion.$c->nombre.',';
                  }
                  $cadenaDesagregacion = trim($cadenaDesagregacion, ','); 
                  $cobertura['nivel_Desagregacion'] = $cadenaDesagregacion;
                  array_push($cabeceraCobertura,'NIVEL DE DESAGREGACION'); 

                  array_push($cabeceraTitulos, 'COBERTURA');

                  //TRABAJANDO RESPONSANBLE
                 
                  $responsablesCuantos = FuenteDatosResponsable::where('id_fuente',$request->id)->where('activo', true)->get();
                  
                  $varRes = 1;
                  foreach ($responsablesCuantos as $r) 
                  {
                     $key = 'RESPONSABLE_'.$varRes;
                     array_push($cabeceraResponsables,$key );
                     array_push($responsables, $r->responsable_nivel_1,$r->responsable_nivel_2,$r->responsable_nivel_3,$r->responsable_nivel_4,$r->numero_referencia);
                    
                     array_push($cabeceraTitulos, $key);
                     $varRes++;
                  }
                  //ACCESO INFORMACION
                  $cabeceraAccesoInformacion = [
                                'CONFIDENCIALIDAD',
                                'NOTAS LEGALES'
                                ];

                  $confidencialidad['confidencialidad'] = $f->confidencialidad;
                  $confidencialidad['notas_legales'] = $f->notas_legales;
                  array_push($cabeceraTitulos, 'ACCESO INFORMACION');

                  //enviando informacion ENCUESTA
                  $cabeceraDatos = array();
                  $cabeceraDatos['cIdentificacion'] = $cabeceraIdentificacion;
                  $cabeceraDatos['cTematica'] = $cabeceraCategoriaTematica;
                  $cabeceraDatos['cFormularios'] = $cabeceraFormularios;
                  $cabeceraDatos['cCobertura'] = $cabeceraCobertura;
                  $cabeceraDatos['cResponsables'] = $cabeceraResponsables;
                  $cabeceraDatos['cAccesoInformacion'] = $cabeceraAccesoInformacion;
                  $contenido = array();
                  $contenido['identificacion'] = $identificacion;
                  $contenido['categoriaTematica'] = $categoriaTematica;
                  $contenido['formularios'] = $formularios;
                  $contenido['cobertura'] = $cobertura;
                  $contenido['responsables'] = $responsables;
                  
                  $contenido['accesoInformacion'] = $confidencialidad;

                  
                  self::contruirExcel($cabeceraDatos,$contenido,$cabeceraTitulos);
            }
         }
      }//fin foreach
   }//fin descargarExcel()
   static function contruirExcel($cabeceraDatos,$contenido,$cabeceraTitulos){
      
      

      \Excel::create('INFORMACION FUENTE', function ($excel) use ($cabeceraDatos,$contenido,$cabeceraTitulos)
        {
            
            $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
            $excel->sheet('Fuente_datos', function ($hoja) use($cabeceraDatos,$contenido,$cabeceraTitulos,$paletaColor)
            {   
                $fila = 1;
                $codDemanda = 0;  
                $color = 0;       
                $cabeceraExcel = [
                  'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
                  'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
                  'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
                  'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
                  'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
                  'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
                  'FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ','FK','FL','FM','FN','FO','FP','FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ',
                  'GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ','GK','GL','GM','GN','GO','GP','GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ',
                  'HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ','HK','HL','HM','HN','HO','HP','HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ',
                  'IA','IB','IC','ID','IE','IF','IG','IH','II','IJ','IK','IL','IM','IN','IO','IP','IQ','IR','IS','IT','IU','IV','IW','IX','IY','IZ'
                  ];
                //saber cuanto es el array cabeceraIdentificacion
               //dd($cabeceraExcel);
               //dd($cabeceraDatos);
               $tamanoCabecera = array();
               foreach ($cabeceraDatos as $key => $longitud) {
                  if($key=='cResponsables'){
                     
                     for ($i=0; $i < sizeof($longitud) ; $i++) { 
                        array_push($tamanoCabecera, 5);
                     }
                   
                  }else{
                     array_push($tamanoCabecera, sizeof($longitud));
                  }
                  
               }
               //dd($tamanoCabecera[3]);                 


               $fila = 1;
               $ri = 'A1';
               $rf = 0;
               $aunTamano = 0;
               $color = 0;
               for ($i=0; $i <= sizeof($tamanoCabecera) ; $i++) { 
                  
                  $color++;
                  if(isset($tamanoCabecera[$i])){
                     $rf = $rf + $tamanoCabecera[$i];
                     
                     $uTamano = $cabeceraExcel[$rf-1];

                     $rUnido = $ri.':'.$uTamano.$fila;
                     
                    
                     
                     $hoja->cells($rUnido, function($cells)use ($color, $paletaColor) {
                      $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                      $cells->setBackground($paletaColor[$color % count($paletaColor)]);

                     });
                     $hoja->mergeCells($rUnido);//combinanado
                   
                     $hoja->setCellValue($ri, $cabeceraTitulos[$i]);//colocando el valor inicial


                     $ri=$cabeceraExcel[$rf].$fila;
                     
                  }
                  
                  
               }
               $filaCabecera = array();
               $i=0;
               //dd($cabeceraDatos);
               foreach ($cabeceraDatos as $key => $value) {
                  if($key == 'cResponsables'){
                     for ($i=0; $i < sizeof($value); $i++) { 
                        array_push($filaCabecera,
                           'INSTITUCION PROPIETARIA/CUSTODIA',
                           'DEPENDENCIA EJECUTIVA',
                           'DEPENDENCIA TECNICA',
                           'DEPENDENCIA INFORMATICA',
                           'TELEFONO DE REFERENCIA');
                     }
                  }else{
                     $i=0;
                    foreach ($value as $key => $r) {
                       array_push($filaCabecera, $r);
                    }
                     //dd($filaCabecera);

                  }
               }
               $hoja->row($fila, function($row) { 
                 
                 $row->setAlignment('center');
                 
               });
               /*$hoja->row($fila, function($row) use ($color, $paletaColor)  {
                    $row->setBackground($paletaColor[$color % count($paletaColor)]); 
                });*/



               //dd($contenido);
               $hoja->row( ++$fila, $filaCabecera );
               $hoja->row($fila, function($row) { 
                 
                 $row->setAlignment('center');
                 
               });
               $filaContenido = [];
               //dd($contenido);
               foreach ($contenido as $iden => $miValor ) {
                  if($iden == 'responsables'){
                     for ($i=0; $i < sizeof($miValor); $i++) { 
                        array_push($filaContenido,$miValor[$i]);
                     }
                  }else{
                     foreach ($miValor as $key => $value) {
                        array_push($filaContenido, $value);
                     }
                     
                  }
               }
               
               $hoja->row( ++$fila, $filaContenido );
               /*$hoja->row($fila, function($row) { 
                 
                 $row->setAlignment('center');
                 
               });*/

                // $endCell = str_repeat(chr(count($cabecera) % 26 + 64), ceil(count($cabecera)/26)) . (count($proyectos)+1);
                //$hoja->setBorder('A1:L'  . $fila, 'thin');  
                $hoja->setAutoSize(true);   
                //$hoja->setWidth(array('B'=>50, 'J'=>50, 'K'=>50, 'L'=>30, 'F'=>3,'G'=>3,'H'=>5,'I'=>3 )) ;      
            });

            

        })->export('xlsx');
   }


}
