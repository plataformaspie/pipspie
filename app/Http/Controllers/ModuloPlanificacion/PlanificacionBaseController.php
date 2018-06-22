<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Http\Controllers\Controller;

class PlanificacionBaseController extends Controller
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
            $ModulosMenus = PlanificacionBaseController::GeneraMenus($this->user);

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

    public function getMenus()
    {
        $menus         = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = {$this->user->id_rol} AND id_modulo = 7 AND activo = true ORDER BY m.orden ASC");

        foreach ($menus as $mn)
            $mn->submenus = \DB::select("SELECT * FROM sub_menus WHERE id_menu = " . $mn->id . " AND activo = true ORDER BY orden ASC");

        $planes = \DB::table('sp_entidad_plan')->where('id_entidad', $this->user->id_institucion)->get();

        if(count($planes) == 0)
            $menus = array_where($menus, function($menu){ return $menu->tipo_menu == 'Estructuración';});

        return response()->json([
            'estaod' => 'success',
            'data' => $menus,
        ]);
    }

    public  function getIdEntidadFoco($req)
    {
        $idEntidad = -1;
        if($this->user->id_rol == 4){
            $idEntidad = $this->user->id_institucion;
        }
        if($this->user->id_rol == 3){
            $idEntidad = $req->id_entidad;
        }
        return $idEntidad;
    }

    public function getParametros($categoria, $a = null, $b = null)
    {
        $params = \DB::table("sp_parametros")->where('activo', true)->where("categoria", $categoria);
        if($a && $b)
        {
            $params = $params->where($a, $b);
        } 

        $params = $params->orderBy("orden")->get();
        return response()->json([
                "estado" => "success", 
                "data"=> $params, 
            ]);
    }


}
