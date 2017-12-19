<?php

namespace App\Http\Controllers\ModuloAdministracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ModuloAdministracion\Menus;


class AbmMenusController extends Controller
{
  public function index()
  {
    return view('ModuloAdministracion.abm_menus');
  }

// ======================================================================================================
// ======================================================================================================
// ======================================================================================================
  public function listarMenus(Request $request)
  {
   //if($request->ajax()) {
        $menus = Menus::all();
        return \Response::json($menus);
   // }
  }

  public function listarMenus2(Request $request) {
//      if($request->ajax()) {
          $menus = \DB::select("SELECT Mn.id, Mn.titulo,Mn.url,Mn.descripcion,Mn.activo,Mn.icono,Mn.tipo_menu,Mn.orden,Mn.id_modulo ,Mo.titulo as modulo 
FROM menus AS Mn LEFT JOIN modulos AS Mo ON Mn.id_modulo=Mo.id ORDER BY Mn.titulo ASC");
          return \Response::json($menus);
//      }
  }

  public function listarModulos(Request $request) {
//      if($request->ajax()) {
          $modu = \DB::select("SELECT id, titulo as modulo FROM modulos ORDER BY titulo ASC");
          return \Response::json($modu);
//      }
  }

  public function guardarMenu(Request $request)
  {
   
      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id = $request->input('id');
      $descripcion = $request->input('descripcion');
      $url = $request->input('url');
      $activo = ($request->input('activo')? $request->input('activo'):'false');
      $titulo = $request->input('titulo');
      $icono = $request->input('icono');
      $tipo_menu = $request->input('tipo_menu');
      $orden = $request->input('orden');
      $id_modulo = $request->input('id_modulo');
      $created_at = date('Y-m-d H:i:s');
      $updated_at = date('Y-m-d H:i:s');

      if ( intval($id) > 0 ) {
          $affected = \DB::update('UPDATE menus SET descripcion = ?, url = ?, activo = ?, titulo = ?, icono = ?, tipo_menu = ?, orden = ?, id_modulo = ?, updated_at = ? WHERE id = ?', [$descripcion, $url, $activo, $titulo, $icono, $tipo_menu, $orden, $id_modulo, $updated_at, $id]);
          echo "Se actualizó satisfactoriamente ($affected)...<br/>";
      } elseif( $id == '0' ) {
          \DB::insert('insert into menus (descripcion, url, activo, titulo, icono, tipo_menu, orden, id_modulo, created_at) values(?, ?, ?, ?, ?, ?, ?, ?, ?)', [$descripcion, $url, $activo, $titulo, $icono, $tipo_menu, $orden, $id_modulo, $created_at]);
          $lastInsertId = app('db')->getPdo()->lastInsertId();
          echo "ID=$lastInsertId\nSe guardó satisfactoriamente ($lastInsertId)...<br/>";
      } else {
          echo "No se guardó nada :(<br/>";
      }
      
  }

  public function borrarMenu(Request $request)
  {
   
      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id = $request->input('id');
      $affected = \DB::delete('delete from menus where id = ?', [$id]);
      echo "Se borro satisfactoriamente ($affected)...<br/>";
  }  

  public function listarSubmenus(Request $request) {
//      if($request->ajax()) {
          $smenus = \DB::select("SELECT id, titulo, url, descripcion, activo, icono, tipo_menu, orden, id_menu FROM sub_menus ORDER BY titulo ASC");
          return \Response::json($smenus);
//      }
  }

 public function guardarSubmenu(Request $request)
  {
   
      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id = $request->input('id');
      $descripcion = $request->input('descripcion');
      $url = $request->input('url');
      $activo = ($request->input('activo')? $request->input('activo'):'false');
      $titulo = $request->input('titulo');
      $icono = $request->input('icono');
      $tipo_menu = $request->input('tipo_menu');
      $orden = $request->input('orden');
      $id_menu = $request->input('id_menu');
      $created_at = date('Y-m-d H:i:s');
      $updated_at = date('Y-m-d H:i:s');

      if ( intval($id) > 0 ) {
          $affected = \DB::update('UPDATE sub_menus SET descripcion = ?, url = ?, activo = ?, titulo = ?, icono = ?, tipo_menu = ?, orden = ?, id_menu = ?, updated_at = ? WHERE id = ?', [$descripcion, $url, $activo, $titulo, $icono, $tipo_menu, $orden, $id_menu, $updated_at, $id]);
          echo "Se actualizó satisfactoriamente ($affected)...<br/>";
      } elseif( $id == '0' ) {
          \DB::insert('insert into sub_menus (descripcion, url, activo, titulo, icono, tipo_menu, orden, id_menu, created_at) values(?, ?, ?, ?, ?, ?, ?, ?, ?)', [$descripcion, $url, $activo, $titulo, $icono, $tipo_menu, $orden, $id_menu, $created_at]);
          $lastInsertId = app('db')->getPdo()->lastInsertId();
          echo "ID=$lastInsertId\nSe guardó satisfactoriamente ($lastInsertId)...<br/>";
      } else {
          echo "No se guardó nada :(<br/>";
      }
      
  }
  
  public function borrarSubmenu(Request $request)
  {
   
      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id = $request->input('id');
      $affected = \DB::delete('delete from sub_menus where id = ?', [$id]);
      echo "Se borro satisfactoriamente ($affected)...<br/>";
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
          array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html));
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
