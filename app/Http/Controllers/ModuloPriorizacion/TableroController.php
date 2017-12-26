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
        return view('ModuloPriorizacion.tablero2');
    }

    // public function index2()
    // {
    //     $this->user= \Auth::user();
    //     $rol = (int) $this->user->id_rol;
    //     $sql = \DB::select("SELECT  m.* FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol = ".$rol." ORDER BY orden ASC");
    //     $this->modulos = array();
    //     foreach ($sql as $mn) {
    //         array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html));
    //     }
    //     $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 5  AND activo = true ORDER BY m.orden ASC");
    //     $this->menus = array();
    //     foreach ($sql as $mn) {
    //         $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id."  AND activo = true ORDER BY orden ASC");
    //         array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'submenus' => $submenu));
    //     }
    //     \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);
    //     return view('ModuloPriorizacion.tablero2');
    // }

    public function menusTablero()
    {
        $user = \Auth::user();
        $id_rol = $user->id_rol;
        $listaMenus = collect(\DB::select("SELECT m.id, m.cod_str, m.nombre,  m.descripcion, 
                                            m.nivel, m.tipo, m.orden, c.variable_estadistica, c.configuracion
                                            FROM  dash_menu m JOIN dash_menu_rol mr ON m.id = mr.id_dash_menu  AND m.activo AND mr.id_rol = {$id_rol}
                                            LEFT JOIN dash_config c ON m.id_dash_config = c.id
                                            ORDER BY m.cod_str
                                "));

        $nodosMenu = $listaMenus->where('nivel',1)->sortBy('cod_str')->values();

        foreach ($nodosMenu as $nivel1) {
            $codigo = $nivel1->cod_str;
            $nombre = $nivel1->nombre;
            $niveles2 = $listaMenus->where('nivel', '2')->filter(function($item, $key) use ($codigo, $nombre){
                if(substr($item->cod_str, 0, 2) == $codigo)
                {
                    $item->padre = $nombre;
                    return $item;
                }

            })->sortBy('cod_str')->values();

            $nivel1->hijos = $niveles2;
            foreach ($niveles2 as $nivel2) {
                $cod2 = $nivel2->cod_str;
                $nombre = $nivel2->nombre;
                $niveles3 =  $listaMenus->where('nivel', '3')->filter(function($item, $key) use ($cod2, $nombre){
                    if(substr($item->cod_str, 0, 4) == $cod2)
                    {
                        $item->padre = $nombre;
                        return $item;
                    }
                    // return (substr($item->cod_str, 0, 4) == $cod2);
                })->sortBy('cod_str')->values();

                $nivel2->hijos = $niveles3;
            }
        }
                   
        return response()->json([
            'mensaje' => 'ok',
            'nodosMenu'=> $nodosMenu,
        ]);
    }



    /**
     * [datosVariableEstadistica description]
     * @param  Request $req [description]
     * @return [type]       [description]
     */
    public function datosVariableEstadistica(Request $req)
    {
        $id_indicador = $req->id_indicador;
        $variable_estadistica = $req->variable_estadistica;
        $campo_defecto = $req->campo_defecto;
        $campo_agregacion = $req->campo_agregacion;
        $condicion_sql = $req->condicion_sql;
        $campo = ($req->campo == '' )? $req->campo_defecto : $req->campo;
        $campos_disponibles = implode(', ', $req->campos_disponibles);
        // $porcentaje =   $req->porcentaje;
        // $es_consulta_principal_de_variable = ($req->campo == '' || $req->campo == null );

        $datos = [];
        $totales = [];
        $qrySelect = $qryCondicion = $qryGroupBy = '';

        $tablas = collect(\DB::connection("dbestadistica")->select("select table_name from information_schema.tables 
                                where table_schema='public' and table_type='VIEW'
                                and table_name ilike '%{$req->tabla_vista}%' "));
        if($tablas->count()<=0)
           return response()->json([ 'mensaje' => "No existe ninguna tabla o vista que coincida con {$req->tabla_vista}"]) ;

        $tabla = $tablas->first()->table_name;

        $qrySelect = "SELECT {$campos_disponibles}, t_ano as gestion,  SUM( {$campo_agregacion} ) AS valor
                    FROM {$tabla} 
                    WHERE 1 = 1 " ; 

        $qryCondicion = trim($condicion_sql) == '' ? '' : ' AND ' . $condicion_sql . ' ' ;


        $qryGroupBy = " GROUP BY {$campos_disponibles}, t_ano
              ORDER BY t_ano, {$campos_disponibles} " ;

        // if($porcentaje)
        // {
        //     $totales = collect(\DB::connection('dbestadistica')->select("
        //         SELECT t_ano AS gestion, SUM(valor_cargado)  AS total_ano
        //         FROM {$tabla}  
        //         WHERE 1 = 1  {$qryCondicion}  
        //         GROUP BY t_ano"))->groupBy('gestion');
        // }

        $query = $qrySelect . $qryCondicion . $qryGroupBy;
        $collection  =   collect(\DB::connection('dbestadistica')->select($query));      

        $unidadesMedida = collect(\DB::connection('dbestadistica')->select("
                            SELECT valor_unidad_medida, valor_tipo FROM {$tabla} LIMIT 1"))->first();

        $indicador = collect(\DB::connection('pgsql')->select("
                    SELECT * FROM spie_indicadores where id = {$id_indicador} "))->first();

        $metasPeriodo = collect(\DB::connection('pgsql')->select("
                    SELECT to_char(fecha, 'YYYY')::int as gestion, meta_del_periodo 
                    FROM spie_indicadores_metas 
                    WHERE id_indicador = {$id_indicador}
                    ORDER BY fecha"));
        

        return Response()->json([ 
                    'mensaje'   => 'ok',
                    'collection'=> $collection,
                    'unidad_medida' => $unidadesMedida,
                    'indicador' => $indicador,
                    'metas'     => $metasPeriodo,
                    'query'     => $query
        ]);

    }


    public function datosIndicadoresMeta(Request $req)
    {
        $id_indicador = $req->id_indicador;
        $indicadores = \DB::select("SELECT nombre,  linea_base_gestion, linea_base_valor, linea_base_unidad, 
                                    linea_base_descripcion, meta_gestion, meta_valor, frecuencia
                                    FROM spie_indicadores i
                                    WHERE  i.estado AND i.id = {$id_indicador} ");
        $existeIndicador = count($indicadores);

        $metasIndicador = \DB::select("SELECT  fecha, EXTRACT(YEAR FROM fecha) as gestion, meta_del_periodo, variacion_programada, variacion_acumulada
                                        FROM spie_indicadores_metas im
                                        WHERE im.id_indicador = {$id_indicador}  ");

        return response()->json([
            'mensaje' => $existeIndicador ? 'ok' : 'no_existe',
            'indicador'=> $indicadores[0],
            'metasIndicador' => $metasIndicador,
        ]);


    }

    public function guardaConfiguracion(Request $req)
    {
        $id_dach_menu = $req->id_dash_menu;
        $configuracionString = $req->configuracionString;
        $dash_menu = collect(\DB::select("SELECT * from dash_menu where id = {$id_dach_menu} " ));
        $id_config = $dash_menu->first()->id_dash_config;

        \DB::select(" UPDATE dash_config set configuracion = '{$configuracionString}'    where id = {$id_config}");

        return response()->json([
            "mensaje"=>"ok"
        ]);


    }
}
