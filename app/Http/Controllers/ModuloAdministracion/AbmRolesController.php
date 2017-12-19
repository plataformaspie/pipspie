<?php

namespace App\Http\Controllers\ModuloAdministracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ModuloAdministracion\Roles;


class AbmRolesController extends Controller
{
  public function index()
  {
    return view('ModuloAdministracion.abm_roles');
  }

// ======================================================================================================
// ======================================================================================================
// ======================================================================================================
  
  public function listarRoles(Request $request)
  {
    if($request->ajax()) {
        $roles = Roles::all();
        return \Response::json($roles);
    }
  }

  public function listarRoles2(Request $request)
  {
   //if($request->ajax()) {
        $roles = \DB::select("SELECT U.id, U.name, U.email, U.password, U.remember_token, U.username, U.id_rol,R.rol, U.permisos_abm 
FROM users AS U LEFT JOIN roles AS R ON U.id_rol=R.id ORDER BY U.name ASC");
        return \Response::json($roles);
   // }
  }

  public function listarMenusRoles(Request $request)
  {
   //if($request->ajax()) {
      $id_rol = $request->input('id_rol');
      $mr = \DB::select("SELECT id_menu FROM roles_menu WHERE id_rol = ? ", [$id_rol]);
        return \Response::json($mr);
   // }
  }

  public function listarModulosRoles(Request $request)
  {
   //if($request->ajax()) {
      $id_rol = $request->input('id_rol');
      $mr = \DB::select("SELECT id_modulo FROM roles_modulos WHERE id_rol = ? ", [$id_rol]);
        return \Response::json($mr);
   // }
  }

  public function listarMenus_rol(Request $request)
  {
   //if($request->ajax()) {
        $menus = \DB::select("SELECT id, titulo || ' (' || url  || ') [' || (select count(*) from sub_menus as SM where M.id=SM.id_menu) || ']' as menu FROM menus AS M ORDER BY url, titulo ASC");
        return \Response::json($menus);
   // }
  }

  public function listarModulos_rol(Request $request)
  {
   //if($request->ajax()) {
        $menus = \DB::select("SELECT id, titulo || ' (' || url  || ')' as modulo FROM modulos ORDER BY url, titulo ASC");
        return \Response::json($menus);
   // }
  }

  public function guardarRol(Request $request)
  {
      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id = $request->input('id');
      $rol = $request->input('rol');
      $descripcion = $request->input('descripcion');

      if ( intval($id) > 0 ) {
          $affected = \DB::update('UPDATE roles SET rol = ?, descripcion = ? WHERE id = ?', [$rol, $descripcion, $id]);
          echo "Se actualizó satisfactoriamente ($affected)...<br/>";
      } elseif( $id == '' ) {
          \DB::insert('insert into roles (rol, descripcion) values(?, ?)', [$rol, $descripcion]);
          $lastInsertId = app('db')->getPdo()->lastInsertId();
          echo "ID=$lastInsertId\nSe guardó satisfactoriamente ($lastInsertId)...<br/>";
      } else {
          echo "No se guardó nada :(<br/>";
      }
  }

  public function guardarMenusRoles(Request $request)
  {
      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id_rol = $request->input('id_rol');
      $ids_menus = $request->input('ids_menus');
      $tam = sizeof($ids_menus);

      $affected = \DB::delete('delete from roles_menu where id_rol = ?', [$id_rol]);

      for ( $i=0; $i<=( $tam - 1 ); $i++) {
          \DB::insert('insert into roles_menu(id_rol, id_menu) values(?, ?)', [$id_rol, $ids_menus[$i]]);
      }
      echo "Se guardo los Roles-Menus satisfactoriamente ($affected, $tam)...<br/>"; 
  }


  public function guardarModulosRoles(Request $request)
  {
      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id_rol = $request->input('id_rol');
      $ids_modulos = $request->input('ids_modulos');
      $tam = sizeof($ids_modulos);

      $affected = \DB::delete('delete from roles_modulos where id_rol = ?', [$id_rol]);

      for ( $i=0; $i<=( $tam - 1 ); $i++) {
          \DB::insert('insert into roles_modulos(id_rol, id_modulo) values(?, ?)', [$id_rol, $ids_modulos[$i]]);
      }
      echo "Se guardo los Roles-Modulos satisfactoriamente ($affected, $tam)...<br/>"; 
  }


  public function borrarRol(Request $request)
  {
      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id = $request->input('id');

      $affected1 = \DB::delete('delete from roles_menu where id_rol = ?', [$id]);
      $affected2 = \DB::delete('delete from roles_modulos where id_rol = ?', [$id]);
      $affected3 = \DB::delete('delete from roles where id = ?', [$id]);
      echo "Se borro satisfactoriamente ($affected1,$affected2,$affected3)...<br/>";
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
