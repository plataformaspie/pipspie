<?php

namespace App\Http\Controllers\SistemaSisgri;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Controllers\Controller;


use App\Models\SistemaSisgri\Pilares;
use App\Models\SistemaSisgri\Metas;
use App\Models\SistemaSisgri\Resultados;

class PdesController extends Controller
{
  public function __construct()
  {
      // $this->middleware('auth');
      $this->middleware(function ($request, $next) {
      $this->user= \Auth::user();
      $rol = (int) $this->user->id_rol;
      $sql = \DB::select("SELECT  m.* FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol = ".$rol." ORDER BY orden ASC");
      $this->modulos = array();
      foreach ($sql as $mn) {
          array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'target' => $mn->target,'id_html' => $mn->id_html));
      }


      $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 31 AND activo = true ORDER BY m.orden ASC");
      $this->menus = array();
      foreach ($sql as $mn) {

          $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." AND activo = true ORDER BY orden ASC");
          array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'submenus' => $submenu));
      }



      \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);



      return $next($request);

      });

  }
  public function showPilares()
  {

    return view('Sistemasisgri.pdes-pilares');
  }
  public function showMetas()
  {
    $pilares = Pilares::select("id", "cod_p",\DB::raw("CONCAT(cod_p||'. '||descripcion) AS descripcion"))->orderBy('cod_p','asc')->get();
    return view('Sistemasisgri.pdes-metas',['pilares' => $pilares]);
  }
  public function showResultados()
  {
    $metas = \DB::table('spie_vista_catalogo_pm')->orderBy('cod_p','asc')->orderBy('cod_m','asc')->get();
    return view('Sistemasisgri.pdes-resultados',['metas' => $metas]);
  }
  public function adminClasificador()
  {
    return view('Sistemasisgri.admin-clasificador');
  }


  public function setPilares(Request $request)
  {
    $pilares = Pilares::orderBy('cod_p','asc')->get();
    return \Response::json($pilares);
  }

  public function setMetas(Request $request)
  {
    //DB::raw("CONCAT(cod_p||'.'||cod_m) AS codigo")
   $metas = Metas::join('spie_pilares', 'spie_metas.pilar', '=', 'spie_pilares.id')
            ->select('spie_metas.id', 'spie_metas.cod_m', 'spie_metas.descripcion','spie_metas.pilar','cod_p as codigo')
            ->orderBy('cod_p')->orderBy('cod_m','asc')->get();
    return \Response::json($metas);
  }

  public function setResultados(Request $request)
  {
    //DB::raw("CONCAT(cod_p||'.'||cod_m) AS codigo")
    $metas = \DB::table('spie_vista_catalogo_pmr')
              ->select('id_resultado as id', 'cod_r', \DB::raw("CONCAT(cod_p||'.'||cod_m) AS codigo"),'resultado as nombre','desc_r as descripcion','id_meta as meta')
              ->orderBy('cod_p','asc')->orderBy('cod_m','asc')->get();
    return \Response::json($metas);
  }

  public function setClasificadores(Request $request)
  {
    //DB::raw("CONCAT(cod_p||'.'||cod_m) AS codigo")
    $clasificadores = \DB::select("SELECT *,
                                    (SELECT count(*) as num_categorias FROM spie_clasificador WHERE padre = tab.id)
                                  FROM
                                   ( SELECT *
                                     FROM spie_clasificador
                                     WHERE activo = TRUE
                                     AND nivel = 'n1'
                                   ) tab");
    $i=1;
    $datos = array();
    foreach ($clasificadores as $c) {
      $datos[$i] = array(
                'id' => $c->id,
                'contador' => $i,
                'nombre_clasificador' => $c->nombre_clasificador,
                'nombre_corto' => $c->nombre_corto,
                'nivel' => $c->nivel,
                'padre' => $c->padre,
                'num_categorias' =>$c->num_categorias
      );
      $i++;
    }
    return \Response::json(array_values($datos));
  }

  public function dataSetPilar(Request $request)
  {
    $pilar = Pilares::find($request->id);
    return \Response::json($pilar);
  }
  public function dataSetMeta(Request $request)
  {
    $meta = Metas::find($request->id);
    return \Response::json($meta);
  }
  public function dataSetResultado(Request $request)
  {
    $resultado = Resultados::find($request->id);
    return \Response::json($resultado);
  }

  public function saveDataPilar(Request $request)
  {

    $carpeta = "img/";
    $nombreDataBase = $request->logo_load;
    try{
          if ( $request->mod_logo )
          {
              $file = $request->mod_logo;

              $nombre = $file->getClientOriginalName();
              $tipo = $file->getMimeType();
              $extension = $file->getClientOriginalExtension();
              $ruta_provisional = $file->getPathName();
              $size = $file->getSize();

              $nombreSystem = "PILAR_".$request->mod_cod_p;
              $src = $carpeta.$nombreSystem.'.'.$extension;
              if(move_uploaded_file($ruta_provisional, $src)){
                  $msgFile ="Archivo Subido Correctamente.";
                  $nombreDataBase = $nombreSystem.'.'.$extension;
              }else{
                  $msgFile = "Error al Subir el Archivo.";
              }
          }
          $pilar = Pilares::find($request->mod_id);
          $pilar->cod_p = $request->mod_cod_p;
          $pilar->nombre = "Pilar ".$request->mod_cod_p;
          $pilar->descripcion = $request->mod_descripcion;
          $pilar->logo = $nombreDataBase;
          $pilar->save();
          return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msgFile' => $msgFile,
              'msg' => "Se guardo con exito.")
          );

      }
      catch (Exception $e) {
          return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'msgFile' => $msgFile,
            'msg' => $e->getMessage())
          );
      }
  }



  public function saveDataMeta(Request $request)
  {
    try{
          $meta = Metas::find($request->mod_id);
          $meta->pilar = $request->mod_cod_p;
          $meta->cod_m = $request->mod_cod_m;
          $meta->nombre = "Meta ".$request->mod_cod_m;
          $meta->descripcion = $request->mod_descripcion;
          $meta->save();
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

  public function saveDataResultado(Request $request)
  {
    try{
          $resultado = Resultados::find($request->mod_id);
          $resultado->meta = $request->mod_cod_m;
          $resultado->cod_r = $request->mod_cod_r;
          $resultado->nombre = "Resultado ".$request->mod_cod_r;
          $resultado->descripcion = $request->mod_descripcion;
          $resultado->save();
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
