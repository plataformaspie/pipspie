<?php

namespace App\Http\Controllers\ModuloAdministracion;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use App\Models\ModuloAdministracion\DashMenu;


class AbmDashMenuController extends Controller
{
  public function index()
  {
    return view('ModuloAdministracion.abm_dashmenu');
  }

// ======================================================================================================
// ======================================================================================================
// ======================================================================================================
  public function listarDashMenu(Request $request)
  {
   //if($request->ajax()) {
        $dm = DashMenu::all();
        return \Response::json($dm);
   // }
  }


  public function listarDashConfigs(Request $request) {
//      if($request->ajax()) {
          $dcs = \DB::select("SELECT A.id, A.id_indicador, A.configuracion, A.variable_estadistica, A.descripcion, B.id AS id_indicador, B.nombre AS nombre_indicador FROM dash_config AS A LEFT JOIN spie_indicadores AS B ON A.id_indicador=B.id UNION SELECT 0,null,'','  ::Seleccione/Nuevo::','',null,'' ORDER BY 1");
          return \Response::json($dcs);
//      }
  }

  public function guardarDashMenu(Request $request)
  {

      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id = $request->input('id');
      $cod_str = $request->input('cod_str');
      $nombre = $request->input('nombre');
      $descripcion = $request->input('descripcion');
      $nivel = $request->input('nivel');
      $tipo = $request->input('tipo');
      $orden = $request->input('orden');
      $activo = $request->input('activo');
      $id_dash_config = $request->input('id_dash_config');

      //$created_at = date('Y-m-d H:i:s');
      //$updated_at = date('Y-m-d H:i:s');

      if ( intval($id) > 0 ) {
          $affected = \DB::update('UPDATE dash_menu SET cod_str = ?, nombre = ?, descripcion = ?, nivel = ?, tipo = ?, orden = ?, activo = ?, id_dash_config = ? WHERE id = ?', [$cod_str, $nombre, $descripcion, $nivel, $tipo, $orden, $activo, $id_dash_config, $id]);
          echo "Se actualizó satisfactoriamente ($affected)...<br/>";
      } elseif( $id == '' ) {
          \DB::insert('INSERT INTO dash_menu(cod_str, nombre, descripcion, nivel, tipo, orden, activo, id_dash_config) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', [$cod_str, $nombre, $descripcion, $nivel, $tipo, $orden, $activo, $id_dash_config]);
          $lastInsertId = app('db')->getPdo()->lastInsertId();

          echo "ID=$lastInsertId\nSe guardó satisfactoriamente ($lastInsertId)...<br/>";
      } else {
          echo "No se guardó nada :(<br/>";
      }

  }

  public function borrarDashMenu(Request $request)
  {

      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id = $request->input('id');
      $affected = \DB::delete('delete from dash_menu where id = ?', [$id]);
      echo "ID=OK\nSe borro satisfactoriamente ($affected)...<br/>";
  }





// ======================================================================================================
// ======================================================================================================
// ======================================================================================================

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


      $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 3 ORDER BY m.orden ASC");
      $this->menus = array();
      foreach ($sql as $mn) {

          $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." ORDER BY orden ASC");
          array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'submenus' => $submenu));
      }

      \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);

      return $next($request);

      });

  }

}
