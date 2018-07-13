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
        array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'tipo_menu'=>$mn->tipo_menu,'class'=>$mn->class,'submenus' => $submenu));
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
      $dataFuente = FuenteDatos::join('remi_estados as et', 'remi_fuente_datos.estado', '=', 'et.id')
                  ->where('remi_fuente_datos.activo', true)
                  ->orderBy('nombre','ASC')
                  ->select('remi_fuente_datos.*','et.nombre as estado','et.id as id_estado')
                  ->get();
      /*foreach ($dataFuente as $value) {
        $data[$value->id] = $value->nombre;
      }*/
      $this->listFuente = array();
      foreach ($dataFuente as $item) {
          $responsable = \DB::select("SELECT string_agg(responsable_nivel_1, ',') as responsable FROM remi_fuente_datos_responsable WHERE id_fuente = ".$item->id." AND activo = true");
          array_push($this->listFuente, array('id' => $item->id,
                                              'codigo' => $item->codigo,
                                              'nombre' => $item->nombre,
                                              'acronimo' => $item->acronimo,
                                              'tipo' => $item->tipo,
                                              'estado' => $item->estado,
                                              'id_estado'=>$item->id_estado,
                                              'responsable' => $responsable[0]->responsable));
      }
      return \Response::json($this->listFuente);

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

            $fuente->cobertura_rraa = $request->cobertura_rraa;
            $fuente->cobertura_rraa_descripcion = $request->cobertura_rraa_descripcion;

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


          $fuente->cobertura_rraa = $request->cobertura_rraa;
          $fuente->cobertura_rraa_descripcion = $request->cobertura_rraa_descripcion;

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
    //ini_set('max_execution_time', 300);
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


}
