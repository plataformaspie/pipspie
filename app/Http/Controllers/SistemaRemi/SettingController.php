<?php

namespace App\Http\Controllers\Sistemaremi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ModuloAdministracion\Users;

class SettingController extends Controller
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
    public function settingPerfil()
    {
      $this->user= \Auth::user();
      $users = Users::find($this->user->id);
      return view('SistemaRemi.setting-perfil',compact('users'));
    }
    public function settingPassword()
    {
      return view('SistemaRemi.setting-password');
    }

    public function apiSavePerfil(Request $request)
    {
        $this->user= \Auth::user();
        $users = Users::find($this->user->id);
        $users->name = $request->name;
        $users->cargo = $request->cargo;
        $users->carnet = $request->carnet;
        $users->telefono = $request->telefono;
        $users->email = $request->email;

        if($request->password_nuevo_1){
          $users->password  = bcrypt($request->input('password_nuevo_1'));
          $users->remember_token = str_random(60);
        }


        $users->save();
        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se guardo con exito.")
        );
    }

    public function apiSavePassword(Request $request)
    {
        $this->user= \Auth::user();
        $users = Users::find($this->user->id);
        $users->password  = bcrypt($request->input('password_nuevo_1'));
        $users->remember_token = str_random(60);
        $users->save();
        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se guardo con exito.")
        );
    }
}
