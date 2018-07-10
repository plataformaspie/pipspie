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
            $autorizado = $modulosMenus = $this->GeneraMenus($this->user, $req);    
            if(!$autorizado)
                return response()->view('ModuloPlanificacion.error',['mensaje' => 'No tiene autorización para ingresar a este módulo']); 
                  
            \View::share($modulosMenus);

            return $next($request);
        });
    }

    /*---------------------------------------------------------------------------------
    | Devuelve la vista Index
    */
    public function index()
    {
        return view('ModuloPlanificacion.index');
    }


    /*-------------------------------------------------------------------------------
    | Obtiene los menus segun el plan, mediante ruta devuelve REST, 
    | para generacion de menus AJAX
     */
    public function getMenu(Request $request)
    {
        $id_plan = $request->p;
        $menus = $this->menus($this->user, $id_plan);
        return response()->json([
            'data'   => $menus,
        ]);
    }

    /**-------------------------------------------------------------------------------
    | obtiene los parametros en orden de una categoria
    | se puede filtrar segun los campos a y b : 
    | Where a = b
     */
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

    /*-----------------------------------------------------------------------------
    | Obtiene el contexto del user
     */
    public function getUser()
    {
        return response()->json([
            'data' => $this->user,
        ]);
    }

    /*-----------------------------------------------------------------------------
    | Obtiene el contexto del plan
     */
    public function getPlan(Request $req)
    {
        $id_p = $req->p;
        $planes = \DB::select("SELECT ep.id, ep.id_entidad, ep.id_tipo_plan, per.valor as gestion_inicio, per.valor2 as gestion_fin,
                                ep.etapas_completadas, p.nombre AS tipo_plan, p.codigo AS cod_tipo_plan,
                                e.nombre AS nombre_entidad, e.sigla AS sigla_entidad
                                FROM sp_planes ep, sp_parametros p, sp_entidades e, sp_parametros per
                                WHERE ep.id_tipo_plan = p.id AND p.categoria = 'tipo_plan'
                                AND per.codigo = ep.cod_periodo_plan AND per.activo AND per.categoria = 'periodo_plan'
                                and ep.id_entidad = e.id AND ep.id = ?  ", [$id_p]);
        $plan = (count($planes) > 0)  ? $planes[0] : '';
        return response()->json([
            'estado' => 'success',
            'data' => $plan
        ]);
    }
    /*-----------------------------------------------------------------------------
    | Obtiene los pilares activos
     */
    public function getPilares()
    {
        $pilares = \DB::select('SELECT * from pdes_pilares order by cod_p');
        return response()->json(['data' => $pilares]);
    }


    // ================================================= Funciones privadas y protegidas=====================================================
    // ======================================================================================================================================
     
    
    private function GeneraMenus($user, $req)
    {
        // Verifica los modulos del usuario y verifica si puede acceder al modulo que corresponde ejmp: de planificacion = 7
        $modulos = \DB::select("SELECT m.id, m.titulo, m.descripcion, m.url, m.icono, m.target, m.id_html FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol =  {$user->id_rol} ORDER BY orden ASC");
        
        $autorizado = count(array_where($modulos, function ($value){
                                    return $value->id == 7;
                            })) > 0;
        if (!$autorizado)
            return false;
        

        $menus = $this->menus($user, $req->p);
        return ['modulos' => $modulos, 'menus' => $menus, 'id_plan' => $req->p];
    }

    private function menus($user, $idplan)
    {
        $condicion = "  m.tipo_menu = 'Estructuración' "; 
        $plan = '';
        if ($idplan)
        {
            $plan = \DB::select("SELECT pl.*, p.nombre AS tipo_plan, p.codigo AS cod_tipo_plan                                
                                FROM sp_planes pl, sp_parametros p
                                WHERE pl.id_tipo_plan = p.id AND p.categoria = 'tipo_plan'
                                AND pl.id = ? AND pl.id_entidad = ? ", [$idplan, $user->id_institucion]);
            if(count($plan) >0)
                  $condicion = $plan[0]->cod_tipo_plan == 'PSDI' ? " 1=1 " : "  m.tipo_menu != 'Documentación' " ;
        }         
        
        $menus = \DB::select("SELECT m.* FROM menus m, roles_menu rm
                         WHERE  m.id = rm.id_menu AND rm.id_rol = {$user->id_rol}
                         AND id_modulo = 7 AND activo = true AND {$condicion} 
                         ORDER BY m.orden ASC");

        foreach ($menus as $mn){
            $mn->submenus = \DB::select("SELECT * FROM sub_menus WHERE id_menu = " . $mn->id . " AND activo = true ORDER BY orden ASC");
        }
        return $menus;
    }


    private function complementaUser($req = null)
    {
        $id_entidad = $this->user->id_institucion == null ? -9991 : $this->user->id_institucion; 
        $inst                    = \DB::select("SELECT id, nombre, sigla FROM sp_entidades WHERE id = " . $id_entidad);
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
