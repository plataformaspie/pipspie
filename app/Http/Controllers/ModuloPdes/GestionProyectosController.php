<?php

namespace App\Http\Controllers\ModuloPdes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ModuloPdes\ProyectoPdes as Proyecto;

class GestionProyectosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
       // $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user= \Auth::user();
            return $next($request);
        });
    }


    public function index()
    {
        $this->user= \Auth::user();
        $rol = (int) $this->user->id_rol;
        $sql = \DB::select("SELECT  m.* FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol = ".$rol." ORDER BY orden ASC");
        $this->modulos = array();
        foreach ($sql as $mn) {
            array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html));
        }

        $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 1 ORDER BY m.orden ASC");
        $this->menus = array();

        foreach ($sql as $mn) {
            $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." ORDER BY orden ASC");
            array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'submenus' => $submenu));
        }

        \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);

        return view('ModuloPdes.gestion_proyectos_pdes');
    }


    public function insertar(Request $request)
    {
        $estado = '';
        $proyecto = null;
        if ($request->id == null)
        {
            $proyNuevo = new Proyecto();
            $proyNuevo->nombre_proyecto = strtoupper(trim($request->nombre_proyecto));
            $proyNuevo->codigo = $request->codigo;
            $proyNuevo->sector = strtoupper(trim($request->sector));
            $proyNuevo->costo_total = $request->costo_total;
            $proyNuevo->responsable = ($request->responsable == null) ? '' : $request->responsable;
            $proyNuevo->save();
            $estado = 'insertado';
            $proyecto = $proyNuevo;
        }
        else
        {
            $proyExist = Proyecto::find($request->id);
            $proyExist->nombre_proyecto = strtoupper(trim($request->nombre_proyecto));
            $proyExist->codigo = $request->codigo;
            $proyExist->sector = strtoupper(trim($request->sector));
            $proyExist->costo_total = $request->costo_total;            
            $proyExist->responsable = ($request->responsable == null) ? '' : $request->responsable;
            $proyExist->save();
            $estado = 'actualizado';
            $proyecto = $proyExist;
        }

        if(count($request->resultados) > 0)
        {
            \DB::table('spie_resultados_proyectos_pdes')->where('id_proyecto_pdes', $proyecto->id )->delete();
            for($i=0; $i<count($request->resultados); $i++)             
                \DB::table('spie_resultados_proyectos_pdes')->insert(['id_proyecto_pdes' => $proyecto->id, 'id_resultado' => $request->resultados[$i]]);  
        }

        if(count($request->sisinweb > 0) )
        {
            \DB::table('spie_proyectos_pdes_sisinweb')->where('id_proyecto_pdes', $proyecto->id )->delete();
            for($i=0; $i<count($request->sisinweb); $i++)
                \DB::table('spie_proyectos_pdes_sisinweb')->insert(['id_proyecto_pdes' => $proyecto->id, 'id_sisinweb' => $request->sisinweb[$i]]);
        }

        return response()->json([
                        'mensaje' => 'ok',
                        'estado' => $estado,
                        'data' => $proyecto
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function obtieneProyecto($id)
    {
        $proyecto = Proyecto::find($id);
        return response()->json([
                        'mensaje' => 'ok',
                        'data' => $proyecto
        ]);
    }




    public function listarProyectosPdesAsociados()
    {
        $proyectosRes = collect(\DB::select("SELECT p.id as id_proyecto, p.nombre_proyecto, p.codigo, p.sector, p.costo_total, p.responsable,
                            pi.cod_p, pi.descripcion as desc_p, m.cod_m, m.descripcion as desc_m, r.cod_r, r.descripcion as desc_r, r.id as id_r,
                            pi.cod_p||'.'||m.cod_m||'.'||r.cod_r as cod_pmr
                            FROM spie_proyectos_pdes p 
                            LEFT JOIN spie_resultados_proyectos_pdes rp ON p.id = rp.id_proyecto_pdes
                            LEFT JOIN spie_resultados r ON rp.id_resultado = r.id
                            LEFT JOIN spie_metas m ON r.meta = m.id
                            LEFT JOIN spie_pilares pi ON pi.id = m.pilar 
                            OrDER BY p.id -- pi.cod_p, m.cod_m, r.cod_r, p.nombre_proyecto "));                     
        
        $proyectosResGroup = $proyectosRes->groupBy('id_proyecto');

        $proyectosSisin = collect(\DB::select("SELECT pry.id as id_proyecto, --pry.nombre_proyecto, pry.codigo, pry.costo_total,
                            s.id as id_sisinweb, s.nombre_proyecto as sw_nombre_proyecto, s.codigo_sisin as sw_codigo, s.entidad as sw_entidad, 
                            s.n_pilar as sw_cod_p, s.n_meta as sw_cod_m, s.n_resultado as sw_cod_r, 
                            s.n_pilar||'.'||s.n_meta||'.'||s.n_resultado  as sw_cod_pmr,
                            s.monto_presupuestado as sw_monto_presupuestado, s.depto as sw_depto, s.prov as sw_prov, s.mun as sw_mun  
                            FROM spie_proyectos_pdes pry, spie_proyectos_pdes_sisinweb ps, sisin_web s 
                            WHERE pry.id = ps.id_proyecto_pdes 
                            AND ps.id_sisinweb = s.id"));

        $proyectoSisinGroup = $proyectosSisin->groupBy('id_proyecto');

        $respuesta = array();
        foreach ($proyectosResGroup as $keyP => $valP) 
        {
            $id_proyectoPDES = $keyP;
 
            $existeProySisin =  $proyectoSisinGroup->contains(function($item, $key) use ($id_proyectoPDES){
                return $key == $id_proyectoPDES;
            });

            $sisinAsoc = ($existeProySisin) ? $proyectoSisinGroup[$id_proyectoPDES] : [];

            $proy = $valP[0];  
            //TODO optimizar la respuesta de salida de los ResultadosAsoc  para que no ocupe tanto espacio           
            $resultadosAsoc = $valP[0]->cod_r == null ? [] : $valP; 
            $item = [
                'id'                =>  $proy->id_proyecto,
                'nombre_proyecto'   =>  $proy->nombre_proyecto,
                'codigo'            =>  $proy->codigo,
                'sector'            =>  $proy->sector,
                'costo_total'       =>  $proy->costo_total,
                'responsable'       =>  $proy->responsable,
                'resultados_count'  =>  count($resultadosAsoc),
                'resultados'        =>  $resultadosAsoc,
                'sisinweb_count'    =>  count($sisinAsoc),
                'sisinweb'          =>  $sisinAsoc,
            ];

            $respuesta[] = $item;
        }

        return response()->json([
            'mensaje' => 'ProyectosPdes',
            'estado' => 'ok',
            'datos' => $respuesta
        ]);
    }

    // public function listarSectores()
    // {
    //     $sectores = \DB::table('spie_proyectos_pdes')->select('sector')->distinct()->orderBy('sector')->get();
    //     return response()->json([
    //         'mensaje'=>'Sectores',
    //         'estado'=>'ok',
    //         'datos' => $sectores]);
    // } 

    // public function listarResultados(Request $request)
    // {

    //     $resultados = \DB::select("SELECT r.id as id_r, p.cod_p, m.cod_m, r.cod_r, (p.cod_p|| '.' || m.cod_m||'.'|| r.cod_r) as cod_pmr, 
    //         r.descripcion, (p.cod_p|| '.' || m.cod_m||'.'|| r.cod_r||' - '|| r.descripcion) as  descripcion_pmr 
    //         FROM spie_pilares p, spie_metas m, spie_resultados r 
    //         WHERE p.id = m.pilar AND m.id = r.meta 
    //         ORDER BY p.cod_p, m.cod_m, r.cod_r");
    //     return response()->json([
    //         'mensaje'=>'Resultados',
    //         'estado'=>'ok',
    //         'datos' => $resultados
    //     ]);
    // }

    // public function listarsisinweb()
    // {                 
    //     $sisin = \DB::select("SELECT s.id, s.nombre_proyecto, s.entidad, s.sector, s.cod_accion_plan 
    //         FROM sisin_web s order by s.nombre_proyecto");
    //     return response()->json([
    //         'mensaje'=>'Proyectos_SISINWEB',
    //         'estado'=>'ok',
    //         'datos' => $sisin
    //     ]);
    // }

    // public function listarInstituciones()
    // {              
    //     $instituciones = \DB::select("SELECT s.id, s.nombre, s.codigo, s.sigla, (s.codigo || ' - ' || s.nombre) as descripcion
    //         FROM spie_instituciones s order by s.codigo");
    //     return response()->json([
    //         'mensaje'=>'Instituciones',
    //         'estado'=>'ok',
    //         'datos' => $instituciones
    //     ]);  
    // }

    /*------------------------------------
    op:['sectores','instituciones','sisinweb','resultados']
    */
    public function listar($op)
    {
        $op = strtolower($op);
        if(str_contains('sectores', $op))
        {
            $sectores = \DB::table('spie_proyectos_pdes')->select('sector')->distinct()->orderBy('sector')->get();
            return response()->json([
                'mensaje'=>'Sectores',
                'estado'=>'ok',
                'datos' => $sectores]);
        }

        if(str_contains('resultados', $op))
        {
            $resultados = \DB::select("SELECT r.id as id_r, p.cod_p, m.cod_m, r.cod_r, (p.cod_p|| '.' || m.cod_m||'.'|| r.cod_r) as cod_pmr, 
                r.descripcion, (p.cod_p|| '.' || m.cod_m||'.'|| r.cod_r||' - '|| r.descripcion) as  descripcion_pmr 
                FROM spie_pilares p, spie_metas m, spie_resultados r 
                WHERE p.id = m.pilar AND m.id = r.meta 
                ORDER BY p.cod_p, m.cod_m, r.cod_r");
            return response()->json([
                'mensaje'=>'Resultados',
                'estado'=>'ok',
                'datos' => $resultados
            ]);
        }
        if(str_contains('instituciones', $op))
        {
            $instituciones = \DB::select("SELECT s.id, s.nombre, s.codigo, s.sigla, (s.codigo || ' - ' || s.nombre) as descripcion
                FROM spie_instituciones s order by s.codigo");
            return response()->json([
                'mensaje'=>'Instituciones',
                'estado'=>'ok',
                'datos' => $instituciones
            ]); 
        }
        if(str_contains('sisinweb', $op))
        {
            $sisin = \DB::select("SELECT s.id, s.nombre_proyecto, s.entidad, s.sector, s.cod_accion_plan, 
                s.codigo_sisin , s.depto, s.prov, s.mun
                FROM sisin_web s order by s.nombre_proyecto");
            return response()->json([
                'mensaje'=>'Proyectos_SISINWEB',
                'estado'=>'ok',
                'datos' => $sisin
            ]); 

        }

    }

}
