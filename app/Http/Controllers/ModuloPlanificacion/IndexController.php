<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    // propiedades publicas
    public $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        // $middleware('auth');
        $this->middleware(function ($request, $next)
        {
            $this->user = \Auth::user();
            $ModulosMenus = IndexController::GeneraMenus($this->user);

            \View::share($ModulosMenus);

            return $next($request);
        });
    }

    public function index()
    {
        return view('ModuloPlanificacion.index');
    }

    public static function GeneraMenus($user)
    {
        $modulos = \DB::select("SELECT m.id, m.titulo, m.descripcion, m.url, m.icono, m.target, m.id_html FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol =  {$user->id_rol} ORDER BY orden ASC");

        $autorizado = count(array_where($modulos, function($value){
            return $value->id == 7;
        })) > 0;

        if(!$autorizado){                
        }

        $menus         = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = {$user->id_rol} AND id_modulo = 7 AND activo = true ORDER BY m.orden ASC");

        foreach ($menus as $mn)
            $mn->submenus = \DB::select("SELECT * FROM sub_menus WHERE id_menu = " . $mn->id . " AND activo = true ORDER BY orden ASC");

        $planes = \DB::table('sp_entidad_plan')->where('id_entidad', $user->id_institucion)->get();

        if(count($planes) == 0)
            $menus = array_where($menus, function($menu){ return $menu->tipo_menu == 'Estructuración';});

        return ['modulos' => $modulos, 'menus' => $menus];
    }


}
