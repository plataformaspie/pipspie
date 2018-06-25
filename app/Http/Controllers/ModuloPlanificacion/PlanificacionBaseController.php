<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanificacionBaseController extends Controller
{
    // propiedades publicas
    public $user;

    public function __construct(Request $req)
    {
        // $middleware('auth');
        
        $this->middleware(function ($request, $next) use ($req)
        {
            $this->user = \Auth::user();
            $this->complementaUser();
            $ModulosMenus = PlanificacionBaseController::GeneraMenus($this->user, $req);
            \View::share($ModulosMenus);

            return $next($request);
        });
    }

    public function index()
    {
        return view('ModuloPlanificacion.index');
    }

    public function getMenuPlan(Request $request)
    {
        $id_plan = $request->id_plan;
        $condicion = '';
        $plan = '';
        if ($id_plan)
        {
            $plan = \DB::select("SELECT ep.id, ep.id_entidad, ep.id_tipo_plan, ep.gestion_inicio, ep.gestion_fin,
                                ep.etapas_completadas, p.nombre AS tipo_plan, p.codigo AS cod_tipo_plan,
                                e.nombre AS nombre_entidad, e.sigla AS sigla_entidad
                                FROM sp_entidad_plan ep, sp_parametros p, sp_entidades e
                                WHERE ep.id_tipo_plan = p.id AND p.categoria = 'tipo_plan'
                                and ep.id_entidad = e.id AND ep.id = ?  ", [$id_plan])[0];
            $condicion = $plan->cod_tipo_plan == 'PSDI' ? " 1=1 " : "  m.tipo_menu != 'Documentación' " ;
        }
        else
           $condicion = "  m.tipo_menu = 'Estructuración' "; 
        
       $menus = \DB::select("SELECT m.* FROM menus m, roles_menu rm
                         WHERE  m.id = rm.id_menu AND rm.id_rol = {$this->user->id_rol}
                         AND id_modulo = 7 AND activo = true AND {$condicion} 
                         ORDER BY m.orden ASC");
        

        foreach ($menus as $mn)
        {
            $mn->submenus = \DB::select("SELECT * FROM sub_menus WHERE id_menu = " . $mn->id . " AND activo = true ORDER BY orden ASC");
        }       

        return response()->json([
            'estado' => 'success',
            'menu'   => $menus,
            'plan' => $plan
        ]);
    }

    public function getParametros($categoria, $a = null, $b = null)
    {
        $params = \DB::table("sp_parametros")->where('activo', true)->where("categoria", $categoria);
        if ($a && $b)
        {
            $params = $params->where($a, $b);
        }

        $params = $params->orderBy("orden")->get();
        return response()->json([
            "estado" => "success",
            "data"   => $params,
        ]);
    }

    public function getUser()
    {
        return response()->json([
            'data' => $this->user,
        ]);
    }

    public function getPlan(Request $req)
    {
        $id_p = $req->p;

        $planes = \DB::select("SELECT ep.id, ep.id_entidad, ep.id_tipo_plan, ep.gestion_inicio, ep.gestion_fin,
                                ep.etapas_completadas, p.nombre AS tipo_plan, p.codigo AS cod_tipo_plan,
                                e.nombre AS nombre_entidad, e.sigla AS sigla_entidad
                                FROM sp_entidad_plan ep, sp_parametros p, sp_entidades e
                                WHERE ep.id_tipo_plan = p.id AND p.categoria = 'tipo_plan'
                                and ep.id_entidad = e.id AND ep.id = ?  ", [$id_p]);
        $plan = (count($planes) > 0)  ? $planes[0] : '';
        return response()->json([
            'estado' => 'success',
            'data' => $plan
        ]);


    }

    private static function GeneraMenus($user, $req)
    {
        $modulos = \DB::select("SELECT m.id, m.titulo, m.descripcion, m.url, m.icono, m.target, m.id_html FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol =  {$user->id_rol} ORDER BY orden ASC");

        $autorizado = count(array_where($modulos, function ($value)
        {
            return $value->id == 7;
        })) > 0;

        if (!$autorizado)
        {
        }

        $condicion = "  m.tipo_menu = 'Estructuración' "; 
        if ($req->p)
        {
            $id_plan = $req->p;

            $plan = \DB::select("SELECT ep.*, p.nombre AS tipo_plan, p.codigo AS cod_tipo_plan                                
                                FROM sp_entidad_plan ep, sp_parametros p, sp_entidades e
                                WHERE ep.id_tipo_plan = p.id AND p.categoria = 'tipo_plan'
                                AND ep.id = ? AND ep.id_entidad = ? ", [$id_plan, $user->id_institucion]);
            if(count($plan) >0)
            {
                  $condicion = $plan[0]->cod_tipo_plan == 'PSDI' ? " 1=1 " : "  m.tipo_menu != 'Documentación' " ;
            }
        }
         
        
        $menus = \DB::select("SELECT m.* FROM menus m, roles_menu rm
                         WHERE  m.id = rm.id_menu AND rm.id_rol = {$user->id_rol}
                         AND id_modulo = 7 AND activo = true AND {$condicion} 
                         ORDER BY m.orden ASC");

        foreach ($menus as $mn)
        {
            $mn->submenus = \DB::select("SELECT * FROM sub_menus WHERE id_menu = " . $mn->id . " AND activo = true ORDER BY orden ASC");
        }

        return ['modulos' => $modulos, 'menus' => $menus, 'id_plan' => $req->p];
    }


    private function complementaUser($req = null)
    {
        $inst                    = \DB::select("SELECT id, nombre, sigla FROM sp_entidades WHERE id = {$this->user->id_institucion} ");
        $this->user->institucion = count($inst) > 0 ? $inst[0] : null;
        // $idInstFoco = $this->getIdEntidadFoco($req);
        // $instFoco = \DB::select("SELECT id, nombre, sigla FROM sp_entidades WHERE id = {$idInstFoco} ");
        // $this->user->institucion_foco = $instFoco;
    }

    protected function getIdEntidadFoco($req)
    {
        $idEntidad = -1;
        if ($this->user->id_rol == 4)
            $idEntidad = $this->user->id_institucion;
        
        if ($this->user->id_rol == 3)
            $idEntidad = $req->id_entidad;
        
        return $idEntidad;
    }


}
