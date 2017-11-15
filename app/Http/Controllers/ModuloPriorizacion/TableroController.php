<?php

namespace App\Http\Controllers\ModuloPriorizacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TableroController extends Controller
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
        $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 5  AND activo = true ORDER BY m.orden ASC");
        $this->menus = array();
        foreach ($sql as $mn) {
            $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id."  AND activo = true ORDER BY orden ASC");
            array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'submenus' => $submenu));
        }
        \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);
        return view('ModuloPriorizacion.tablero');
    }

    public function menusTablero()
    {
        $user = \Auth::user();
        $id_rol = $user->id_rol;
        $listaMenus = collect(\DB::select("SELECT m.id, m.cod_num, m.cod_str, m.nombre, m.descripcion, 
                                m.nivel, m.tipo, m.orden FROM  dash_menu m, dash_menu_rol mr 
                                WHERE m.id = mr.id_dash_menu  AND mr.id_rol = $id_rol AND m.activo 
                                ORDER BY orden
                                "));

        $nodosMenu = $listaMenus->where('nivel',1)->sortBy('orden')->values();
        // $nodosMenu = $listaMenus->filter(function($item, $key){
        //     if ($item->nivel == 1) 
        //         return [ (string)$item->cod_str => $item];
        // });
        // return response()->json($nodosMenu);
        foreach ($nodosMenu as $nivel1) {
            $codigo = $nivel1->cod_str;
            $niveles2 = $listaMenus->where('nivel', '2')->filter(function($item, $key) use ($codigo){
                return (substr($item->cod_str, 0, 2) == $codigo);
            })->sortBy('orden')->values();

            $nivel1->hijos = $niveles2;
            foreach ($niveles2 as $nivel2) {
                $cod2 = $nivel2->cod_str;
                $niveles3 =  $listaMenus->where('nivel', '3')->filter(function($item, $key) use ($cod2){
                    return (substr($item->cod_str, 0, 4) == $cod2);
                })->sortBy('orden')->values();

                $nivel2->hijos = $niveles3;
            }

        }
                   
        return response()->json([
            'mensaje' => 'ok',
            'nodosMenu'=> $nodosMenu,
            'listaMenu' => $listaMenus,
        ]);
    }







    public function  obtenerDatosFiltro(Request $req)
    {
        // return response()->json([
        //   'round2decimal' => round(12.123456,2),
        //   'round2ent' => round(12123459,2),
        //   'round2entdec' => round(128.999,2),
        // ]);
        $datos = [];
        $totales = [];
        $resultado = [];
        $tabla = '';
        $campoDefecto = '';
        $query = '';

        if(strpos($req->variableEstadistica, 'extrem') ) {
            $tabla = 'v_ve0001_p_pobreza_extrema';
            $campoDefecto = 'pobreza_extrema';
        }
        if(strpos($req->variableEstadistica, 'moderad')) {
            $tabla = 'v_ve0002_p_pobreza_moderada';
            $campoDefecto = 'pobreza_moderada';
        }
        if(strpos($req->variableEstadistica, 'desempleo')) {
            $tabla = 'v_ve0003_p_desempleo';
            $campoDefecto = 'po_pd';
        }


        /////////// En caso de que sea el mismo campo, se muestra este sin filtrar por nivel
        $condicion = "";
        if($req->campo <> $campoDefecto)
        {
            $condicion = " AND " . $campoDefecto . "  = '" . $req->nivel . "' ";
        }

        if($tabla <> '') {


            if($req->porcentaje)
            {
                $totales = collect(\DB::connection('dbentreparentesys')->select("
                  SELECT t_ano AS gestion, SUM(valor_cargado)  AS total_ano
                  FROM " . $tabla . "
                  GROUP BY t_ano"))->groupBy('gestion');
            }

            // si es no es filtrado por ningun campo, pantalla principal devuelve Gestion y valo  (sin dimensiones)
            if($req->campo == '' || $req->campo == null)
            {
              $query = "SELECT t_ano as gestion,  SUM(valor_cargado) AS valor
                      FROM " .$tabla . "
                      WHERE 1 = 1 " . $condicion . "
                      GROUP BY t_ano
                      ORDER BY t_ano " ;
               $datos = collect(\DB::connection('dbentreparentesys')->select($query));
               foreach ($datos as $key => $anoObjetos) {
                    $elem = [];
                    $factorPorcentual = ($req->porcentaje) ?  100 / $totales[$anoObjetos->gestion][0]->total_ano : 1;
                    $anoObjetos->valor = round ($anoObjetos->valor * $factorPorcentual,2);
                    $resultado[] = $anoObjetos;
                }

               return response()->json($resultado);
            }

            $query = "SELECT " .$req->campo. " AS dimension, t_ano as gestion,  SUM(valor_cargado) AS valor
                      FROM " .$tabla . "
                      WHERE 1 = 1 " . $condicion . "
                      GROUP BY " .$req->campo . ", t_ano
                      ORDER BY t_ano, dimension " ;

            $datos = collect(\DB::connection('dbentreparentesys')->select($query))->groupBy('gestion');

            foreach ($datos as $key => $anoObjetos) {
                $elem = [];
                $factorPorcentual = ($req->porcentaje) ?  100 / $totales[$key][0]->total_ano : 1;
                // $factorPorcentual = 1;
                foreach ($anoObjetos as $objeto) {
                    $dimension = ($objeto->dimension == null)? 'otros' : $objeto->dimension;
                    $elem[$dimension] = round($objeto->valor * $factorPorcentual,2) ;
                    $elem['gestion'] = $objeto->gestion;
                }
                $resultado[] = $elem;
            }

        }

        return Response()->json($resultado);
        // return response()->json([
        //   'datos' => $datos,
        //   'sql' => $query,
        //   'resultado' => $resultado,
        //   'totales' => $totales
        //   ]);
    }
}
