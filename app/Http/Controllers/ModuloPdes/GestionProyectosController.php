<?php

namespace App\Http\Controllers\ModuloPdes;

use App\Http\Controllers\Controller;
use App\Models\ModuloPdes\ProyectoPdes as Proyecto;
use Illuminate\Http\Request;

class GestionProyectosController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware(function ($request, $next)
        {
            $this->user = \Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $this->user    = \Auth::user();
        $rol           = (int) $this->user->id_rol;
        $sql           = \DB::select("SELECT  m.* FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol = " . $rol . " ORDER BY orden ASC");
        $this->modulos = array();
        foreach ($sql as $mn)
        {
            array_push($this->modulos, array('id' => $mn->id, 'titulo' => $mn->titulo, 'descripcion' => $mn->descripcion, 'url' => $mn->url, 'icono' => $mn->icono, 'target' => $mn->target, 'id_html' => $mn->id_html));
        }

        $sql         = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = " . $rol . " AND id_modulo = 1 ORDER BY m.orden ASC");
        $this->menus = array();

        foreach ($sql as $mn)
        {
            $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = " . $mn->id . " ORDER BY orden ASC");
            array_push($this->menus, array('id' => $mn->id, 'titulo' => $mn->titulo, 'descripcion' => $mn->descripcion, 'url' => $mn->url, 'icono' => $mn->icono, 'id_html' => $mn->id_html, 'submenus' => $submenu));
        }

        \View::share(['modulos' => $this->modulos, 'menus' => $this->menus]);

        return view('ModuloPdes.gestion_proyectos_pdes');
    }

    public function insertar(Request $request)
    {
        $estado   = '';
        $proyecto = null;
        if ($request->id == null)
        {
            $proyNuevo                  = new Proyecto();
            $proyNuevo->nombre_proyecto = strtoupper(trim($request->nombre_proyecto));
            $proyNuevo->codigo          = $request->codigo;
            $proyNuevo->sector          = strtoupper(trim($request->sector));
            $proyNuevo->costo_total     = $request->costo_total;
            $proyNuevo->responsable     = ($request->responsable == null) ? '' : $request->responsable;
            $proyNuevo->save();
            $estado   = 'insertado';
            $proyecto = $proyNuevo;
        }
        else
        {
            $proyExist                  = Proyecto::find($request->id);
            $proyExist->nombre_proyecto = strtoupper(trim($request->nombre_proyecto));
            $proyExist->codigo          = $request->codigo;
            $proyExist->sector          = strtoupper(trim($request->sector));
            $proyExist->costo_total     = $request->costo_total;
            $proyExist->responsable     = ($request->responsable == null) ? '' : $request->responsable;
            $proyExist->save();
            $estado   = 'actualizado';
            $proyecto = $proyExist;
        }

        if (count($request->resultados) > 0)
        {
            \DB::table('spie_resultados_proyectos_pdes')->where('id_proyecto_pdes', $proyecto->id)->delete();
            for ($i = 0; $i < count($request->resultados); $i++)
            {
                \DB::table('spie_resultados_proyectos_pdes')->insert(['id_proyecto_pdes' => $proyecto->id, 'id_resultado' => $request->resultados[$i]]);
            }

        }

        if (count($request->sisinweb > 0))
        {
            \DB::table('spie_proyectos_pdes_sisinweb')->where('id_proyecto_pdes', $proyecto->id)->delete();
            for ($i = 0; $i < count($request->sisinweb); $i++)
            {
                \DB::table('spie_proyectos_pdes_sisinweb')->insert(['id_proyecto_pdes' => $proyecto->id, 'id_sisinweb' => $request->sisinweb[$i]]);
            }

        }

        return response()->json([
            'mensaje' => 'ok',
            'estado'  => $estado,
            'data'    => $proyecto,
        ]);
    }

    public function obtieneProyecto($id)
    {
        $proyecto = Proyecto::find($id);
        return response()->json([
            'mensaje' => 'ok',
            'data'    => $proyecto,
        ]);
    }

    /*---------------------------------------------------------------------------------------------------------------------
    |   Funcion que devuelve los proyectos PDES con su pilar y meta y si tiene resultados asociados,
    |   para lueogg obtener el conteo de estos y de los proyectos sisinweb
    |
     */
    public function listarProyectosPdesAsociados()
    {
        $proyectosRes = collect(\DB::select("   SELECT  p.id as id_proyecto, p.nombre_proyecto, p.codigo, p.sector,
                                                trim(to_char(p.costo_total,'999G999G999G999D99')) as costo_total, p.responsable,
                                                pi.cod_p, m.cod_m, pi.descripcion as desc_p,  m.descripcion as desc_m, r.cod_r, r.descripcion as desc_r, r.id as id_r,
                                                pi.cod_p||'.'||m.cod_m||'.'||r.cod_r as cod_pmr, (pi.cod_p||'.'||m.cod_m) as cod_pm, rp.updated_at
                                                FROM spie_proyectos_pdes p
                                                LEFT JOIN spie_pilares pi ON p.cod_p = pi.cod_p
                                                LEFT JOIN spie_metas m ON p.cod_m = m.cod_m AND m.pilar = pi.id
                                                LEFT JOIN spie_resultados_proyectos_pdes rp ON p.id = rp.id_proyecto_pdes
                                                LEFT JOIN spie_resultados r ON rp.id_resultado = r.id
                                                ORDER BY pi.cod_p, m.cod_m, p.codigo  "));

        $proyectosResGroup = $proyectosRes->groupBy('id_proyecto');

        $proyectosSisin = collect(\DB::select("SELECT ps.id_proyecto_pdes, ps.codigo_sisin
                                                FROM spie_proyectos_pdes_sisinweb ps "));

        // $proyectosSisin = collect(\DB::select("SELECT pry.id as id_proyecto, --pry.nombre_proyecto, pry.codigo, pry.costo_total,
        //                     s.id as id_sisinweb,
        //                     -- s.nombre_proyecto as sw_nombre_proyecto, s.codigo_sisin as sw_codigo, s.entidad as sw_entidad,
        //                     -- s.cod_accion_plan as sw_cod_pmra,  trim(to_char(s.monto_presupuestado,'999G999G999G999D99')) as sw_monto_presupuestado,
        //                     -- s.depto as sw_depto, s.prov as sw_prov, s.mun as sw_mun
        //                     FROM spie_proyectos_pdes_sisinweb ps --, spie_proyectos_pdes pry,  sisin_web s
        //                     -- WHERE pry.id = ps.id_proyecto_pdes AND ps.id_sisinweb = s.id
        //                     "));

        $proyectoSisinGroup = $proyectosSisin->groupBy('id_proyecto_pdes');

        $respuesta = array();
        foreach ($proyectosResGroup as $keyP => $valP)
        {
            $id_proyectoPDES = $keyP;
            $existeProySisin = $proyectoSisinGroup->contains(function ($item, $key) use ($id_proyectoPDES)
            {
                return $key == $id_proyectoPDES;
            });

            $sisinAsoc = ($existeProySisin) ? $proyectoSisinGroup[$id_proyectoPDES] : [];

            $proy = $valP[0];

            $resultadosAsoc = ($valP[0]->id_r == null) ? [] : $valP->map(function ($item)
            {
                return [
                    'cod_r'   => $item->cod_r,
                    'desc_r'  => $item->desc_r,
                    'id_r'    => $item->id_r,
                    'cod_pmr' => $item->cod_pmr,
                ];
            });
            $item = [
                'id'               => $proy->id_proyecto,
                'cod_pm'           => $proy->cod_pm,
                'nombre_proyecto'  => $proy->nombre_proyecto,
                'codigo'           => $proy->codigo,
                'sector'           => $proy->sector,
                'costo_total'      => $proy->costo_total,
                'responsable'      => $proy->responsable,
                'cod_p'            => $proy->cod_p,
                'desc_p'           => $proy->desc_p,
                'cod_m'            => $proy->cod_m,
                'desc_m'           => $proy->desc_m,
                'resultados_count' => count($resultadosAsoc),
                'resultados'       => $resultadosAsoc,
                'sisinweb_count'   => count($sisinAsoc),
                // 'sisinweb'          =>  $sisinAsoc,
            ];

            $respuesta[] = $item;
        }

        return response()->json([
            'mensaje' => 'ProyectosPdes',
            'estado'  => 'ok',
            'datos'   => $respuesta,
        ]);
    }

   

    /*--------------------------------------------------------------------------------------
    |   Obtiene el proyecto asosciado al SP , con codigo PMRA
    |
     */
    public function obtenerProyectoSP($codigoDemanda)
    {
        $proyectoSP = collect(\DB::connection('dbsp')->select("SELECT  id, sector, codigo, nombre_proyecto, format(total_costo,2) as total_costo
                                    FROM proyectos where estado = 1 AND  codigo = {$codigoDemanda} "))->first();

        $contextoProyecto = array();
        $ctxProyecto      = collect(\DB::connection('dbsp')->select("SELECT distinct
                                p.cod_p, m.cod_m, r.cod_r, a.cod_a,
                                pr.codigo, pr.nombre_proyecto, r.descripcion AS desc_r, a.descripcion AS desc_a,
                                concat(p.cod_p,'.',m.cod_m,'.',r.cod_r,'.',a.cod_a) AS cod_pmra,
                                ai.id as id_accion, ai.sisin, ai.desc_indicador_proceso,
                                 e.nombre as ejecutor, sb.nombre as responsable
                                FROM
                                pilar AS p
                                JOIN meta AS m ON m.pilar = p.id
                                JOIN resultado AS r ON r.meta = m.id
                                JOIN acciones AS a ON a.resultado = r.id
                                LEFT JOIN accion AS ai ON ai.accion = a.id AND ai.estado = 1 AND ai.tipo <> 1
                                LEFT JOIN entidad AS e ON ai.entidad = e.id AND e.tipo <> -1
                                LEFT JOIN entidad_responsable AS er ON er.accion = ai.id
                                LEFT JOIN sub_entidad AS sb ON er.entidad_responsable = sb.id
                                LEFT JOIN proyectos as pr ON ai.proyecto = pr.id
                                WHERE pr.codigo = {$codigoDemanda}"));

        /*-----------------------------------------------------------------------------------------------------------
        |   un proyecto puede estar en mas de un pmra, solo tiene un ejecutor y puede tener varios responsables,
        |   por lo tanto se hace un groupBy por la tabla accion que es el vinculante, y se transforman las collectiones resultantes
         */
        if ($ctxProyecto->count() > 0)
        {
            $groups           = $ctxProyecto->groupBy('id_accion')->values();
            $transfomadoPMRAA = $groups->map(function ($items)
            {
                $item                          = $items->first();
                $pmraa                         = new \stdClass();
                $pmraa->id_accion              = $item->id_accion;
                $pmraa->cod_p                  = $item->cod_p;
                $pmraa->cod_m                  = $item->cod_m;
                $pmraa->cod_r                  = $item->cod_r;
                $pmraa->cod_a                  = $item->cod_a;
                $pmraa->desc_r                 = $item->desc_r;
                $pmraa->desc_a                 = $item->desc_a;
                $pmraa->cod_pmra               = $item->cod_pmra;
                $pmraa->sisin                  = $item->sisin;
                $pmraa->desc_indicador_proceso = $item->desc_indicador_proceso;
                $pmraa->ejecutor               = $item->ejecutor;
                $responsables                  = $items->reduce(function ($carry, $item)
                {
                    if ($carry == null)
                    {
                        $carry = array();
                    }

                    if ($item->responsable != null)
                    {
                        $carry[] = $item->responsable;
                    }

                    return $carry;
                });
                $pmraa->responsables = $responsables;

                return $pmraa;
            });
            $proyectoSP->contextoProyecto = $transfomadoPMRAA;
        }

        $mensaje = ($proyectoSP == null) ? 'No existe el Proyecto en SP' : 'ok';
        return response()->json([
            'estado'  => 'ok',
            'mensaje' => $mensaje,
            'data'    => $proyectoSP,
        ]);
    }

    /**------------------------------------------------------------------------------------------------
    |   Funcion que obtiene los proyectos sisinweb segun la busqueda en varios campos de la tabla.
    |   Usada en la busqueda ajax de la APP
    |   $params->term para buscar una coincidencia con un termino,
    |   $params->id_proyecto_pdes para buscar proyectos sisin asociados a u proyecto_pdes
     */
    public function buscarSisin(Request $params)
    {
        $sisin = [];
        if ($params->term)
        {
            $term  = $params->term;
            $sisin = \DB::select("SELECT s.id as id_sisinweb, s.codigo_sisin,  s.nombre_proyecto, s.entidad, s.sector, s.cod_accion_plan as cod_pmra

                -- s.depto, s.prov, s.mun, s.monto_presupuestado
                FROM sisin_web s -- , sisin_web_datos d
                WHERE  s.codigo_sisin || ' ' ||  s.nombre_proyecto || ' ' || s.entidad || ' ' || s.sector || ' ' || s.cod_accion_plan
                -- || ' ' || s.depto || ' ' || s.prov  || ' ' || s.mun || ' ' || s.monto_presupuestado
                ilike '%{$term}%'
                order by s.nombre_proyecto");
        }
        if ($params->id_proyecto_pdes)
        {
            $id_proyecto_pdes = $params->id_proyecto_pdes;
            $sisin            = \DB::select("SELECT s.id as id_sisinweb, s.nombre_proyecto, s.entidad, s.sector, s.cod_accion_plan as cod_pmra,
                n_pilar as cod_p, n_meta as cod_m, n_resultado as cod_r, n_accion as cod_a,
                s.codigo_sisin, d.depto, d.prov, d.mun, d.monto_presupuestado
                FROM sisin_web s, sisin_web_datos d, spie_proyectos_pdes_sisinweb ps
                WHERE s.codigo_sisin = d.codigo_sisin AND  s.codigo_sisin = ps.codigo_sisin AND ps.id_proyecto_pdes = {$params->id_proyecto_pdes} ");
        }

        return response()->json([
            'mensaje' => 'Proyectos_SISINWEB',
            'estado'  => 'ok',
            'datos'   => $sisin,
        ]);
    }

    /*--------------------------------------------------------------------------
    |   Funcion que devuelve lista segun la Op que se envie, mediante GET.
    |   Usada para cargar los combos de la aplicacion
    |   op:['sectores','instituciones','sisinweb','resultados']
     */
    public function listar($op)
    {
        $op = strtolower($op);
        if (str_contains('sectores', $op))
        {
            $sectores = \DB::table('spie_proyectos_pdes')->select('sector')->distinct()->orderBy('sector')->get();
            return response()->json([
                'mensaje' => 'Sectores',
                'estado'  => 'ok',
                'datos'   => $sectores]);
        }

        if (str_contains('resultados', $op))
        {
            $resultados = \DB::select("SELECT r.id as id_r, p.cod_p, m.cod_m, r.cod_r, (p.cod_p|| '.' || m.cod_m||'.'|| r.cod_r) as cod_pmr,
                r.descripcion, (p.cod_p|| '.' || m.cod_m||'.'|| r.cod_r||' - '|| r.descripcion) as  descripcion_pmr
                FROM spie_pilares p, spie_metas m, spie_resultados r
                WHERE p.id = m.pilar AND m.id = r.meta
                ORDER BY p.cod_p, m.cod_m, r.cod_r");
            return response()->json([
                'mensaje' => 'Resultados',
                'estado'  => 'ok',
                'datos'   => $resultados,
            ]);
        }
        if (str_contains('instituciones', $op))
        {
            $instituciones = \DB::select("SELECT s.id, s.nombre, s.codigo, s.sigla, (s.codigo || ' - ' || s.nombre) as descripcion
                FROM spie_instituciones s order by s.codigo");
            return response()->json([
                'mensaje' => 'Instituciones',
                'estado'  => 'ok',
                'datos'   => $instituciones,
            ]);
        }
        // if(str_contains('sisinweb', $op))
        // {
        //     $sisin = \DB::select("SELECT s.id, s.nombre_proyecto, s.entidad, s.sector, s.cod_accion_plan,
        //         s.codigo_sisin , s.depto, s.prov, s.mun
        //         FROM sisin_web s order by s.nombre_proyecto");
        //     return response()->json([
        //         'mensaje'=>'Proyectos_SISINWEB',
        //         'estado'=>'ok',
        //         'datos' => $sisin
        //     ]);

        // }

    }

    /*--------------------------------------------------------------------------
    |   Funcion para exportar EXCEL
    |   
     */
    public function exportExcel()
    {
 
        $proyectos = collect(\DB::connection('dbsp')->select("SELECT distinct  pr.id, pr.codigo AS codigo_demanda, pr.nombre_proyecto, pr.sector, pr.pilar, pr.meta
                                                    , sp.cod_p AS P, sp.cod_m AS M, sp.cod_r AS R, sp.cod_a AS A, sp.descripcion_accion
                                                    , sp.desc_indicador_proceso, sp.entidad
                                                    FROM proyectos pr LEFT JOIN
                                                    (   SELECT p.cod_p , m.cod_m , r.cod_r , a.cod_a , a.descripcion AS descripcion_accion
                                                        , ai.desc_indicador_proceso, ai.proyecto, e.nombre AS entidad
                                                        FROM accion ai LEFT JOIN acciones a on ai.accion = a.id 
                                                        LEFT JOIN resultado r on a.resultado = r.id
                                                        LEFT JOIN meta m on m.id = r.meta
                                                        LEFT JOIN pilar p on p.id = m.pilar
                                                        LEFT JOIN entidad e on ai.entidad = e.id  -- and e.tipo <> -1

                                                        WHERE 1 = 1   and e.tipo <> -1 and ai.estado = 1 and ai.tipo <> 1 
                                                    ) AS sp 
                                                    ON sp.proyecto = pr.id
                                                    where 1 = 1 and LENGTH(pr.codigo) >= 9
                                                    ORDER BY pr.sector, pr.codigo " ));

        // //////////////////////////////////////
        // $proyGroup = $proyectos->groupBy('codigo_demanda');
        //         //////////////////////////////////
         // return response()->json(['data' => $proyGroup])      ;
            
        \Excel::create('proyectos_pdes_vinculaciones', function ($excel) use ($proyectos)
        {
            $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
            $excel->sheet('ProyPDES-SP', function ($hoja) use($proyectos, $paletaColor)
            {   
                $fila = 1;
                $codDemanda = 0;  
                $color = 0;       
                $cabecera =  ['COD_DEMANDA', 'NOMBRE_PROYECTO', 'SECTOR', 'PILAR', 'META', 'P', 'M', 'R', 'A', 'DESCRIPCION_ACCION', 'INDICADOR_PROCESO', 'ENTIDAD', 'N sisin'];
                $hoja->row( $fila, $cabecera );
                $hoja->row($fila, function($row) { 
                    $row->setBackground('#22CC33'); 
                    $row->setAlignment('center');
                    $row->setFontWeight('bold');
                });

                foreach ($proyectos as $index => $proy) {
                     $valoresFila = array( $proy->codigo_demanda, $proy->nombre_proyecto,
                                    $proy->sector, $proy->pilar, $proy->meta,
                                    $proy->P, $proy->M, $proy->R, $proy->A, $proy->descripcion_accion,
                                    $proy->desc_indicador_proceso, $proy->entidad  );                    

                    $sisin = \DB::select("SELECT sw.codigo_sisin, sw.cod_entidad, sw.entidad, sw.nombre_proyecto, sw.fecha_inicio_proyecto, 
                                        sw.fecha_termino_proyecto, sw.sector, sw.n_pilar, sw.n_meta, sw.n_resultado, sw.n_accion, sw.codigo_proyectos
                                        -- , sd.depto, sd.prov, sd.mun, sd.fte_presup, sd.fte_sigla, 
                                        -- sd.org_presup, sd.org_sigla, sd.monto_presupuestado
                                        FROM spie_proyectos_pdes_sisinweb ps, sisin_web sw -- , sisin_web_datos sd
                                        WHERE ps.codigo_sisin = sw.codigo_sisin -- AND sw.codigo_sisin = sd.codigo_sisin
                                        AND ps.codigo_demanda = {$proy->codigo_demanda}
                                        ORDER BY  sw.codigo_sisin ");

                    if(count($sisin) > 0)
                        $valoresFila[] = count($sisin);
                    
                    if($codDemanda != $proy->codigo_demanda)
                    {
                        $codDemanda = $proy->codigo_demanda;
                        $color++;
                    }
                    $hoja->row(++$fila, $valoresFila);
                    $hoja->row($fila, function($row) use ($color, $paletaColor)
                    {
                        $row->setBackground($paletaColor[$color % count($paletaColor)]); 
                    });
                }

                // $endCell = str_repeat(chr(count($cabecera) % 26 + 64), ceil(count($cabecera)/26)) . (count($proyectos)+1);
                $hoja->setBorder('A1:L'  . $fila, 'thin');  
                $hoja->setAutoSize(true);   
                $hoja->setWidth(array('B'=>50, 'J'=>50, 'K'=>50, 'L'=>30, 'F'=>3,'G'=>3,'H'=>5,'I'=>3 )) ;      
            });

            $excel->sheet('Proy_PDES-SISIN', function($hoja) use ($proyectos, $paletaColor)
            {
                $fila = 1;
                $codDemanda = 0;  
                $color = 0;     
                $cabecera =  ['COD_DEMANDA', 'NOMBRE_PROYECTO', 'SECTOR', 'PILAR', 'META', 'CODIGO_SISIN', 'NOMBRE_PROYECTO_Sisin', 'Pi', 'Me', 'Re', 'Ac', 'SECTOR_Sisin', 'COD_ENTIDAD', 'ENTIDAD_Sisin', 'FECHA_INICIO_PROYECTO', 'FECHA_FIN_PROYECTO', 'CODIGO_PROYECTOS'];
                $cabecera =  ['COD_DEMANDA', 'NOMBRE_PROYECTO', 'SECTOR', 'PILAR', 'META', 'P', 'M', 'R', 'A', 'DESCRIPCION_ACCION', 'INDICADOR_PROCESO', 'ENTIDAD', 'N sisin'];
                $hoja->row( $fila, $cabecera );
                $hoja->row($fila, function($row) { 
                    $row->setBackground('#226699'); 
                    $row->setAlignment('center');
                    $row->setFontWeight('bold');
                });
                // $data[] = $cabecera;

                $proys = collect(\DB::connection('dbsp')->select("SELECT distinct  pr.id, pr.codigo AS codigo_demanda, pr.nombre_proyecto, pr.sector, pr.pilar, pr.meta
                                                             FROM proyectos pr 
                                                            where 1 = 1 and LENGTH(pr.codigo) >= 9
                                                            ORDER BY pr.sector, pr.codigo "));
                foreach ($proys as $index => $value) 
                {
                    $proy = $value;
                    $color++;
                    $valoresProy = array($proy->codigo_demanda, $proy->nombre_proyecto, $proy->sector, $proy->pilar, $proy->meta );

                    $sisin = \DB::select("SELECT sw.codigo_sisin, sw.cod_entidad, sw.entidad, sw.nombre_proyecto, sw.fecha_inicio_proyecto, 
                                        sw.fecha_termino_proyecto, sw.sector, sw.n_pilar, sw.n_meta, sw.n_resultado, sw.n_accion, sw.codigo_proyectos
                                        -- , sd.depto, sd.prov, sd.mun, sd.fte_presup, sd.fte_sigla, 
                                        -- sd.org_presup, sd.org_sigla, sd.monto_presupuestado
                                        FROM spie_proyectos_pdes_sisinweb ps, sisin_web sw -- , sisin_web_datos sd
                                        WHERE ps.codigo_sisin = sw.codigo_sisin -- AND sw.codigo_sisin = sd.codigo_sisin
                                        AND ps.codigo_demanda = {$proy->codigo_demanda}
                                        ORDER BY  sw.codigo_sisin ");

                    if(count($sisin) > 0)
                    {
                        foreach ($sisin as $sw) 
                        {
                            $sisindata = array($sw->codigo_sisin, $sw->nombre_proyecto, $sw->n_pilar, $sw->n_meta, $sw->n_resultado, $sw->n_accion,  $sw->sector, $sw->cod_entidad, $sw->entidad,  
                              $sw->fecha_inicio_proyecto, $sw->fecha_termino_proyecto, $sw->codigo_proyectos);

                            $hoja->row(++$fila, array_collapse([$valoresProy , $sisindata]) );   
                            $hoja->row($fila, function($row) use ($color, $paletaColor)  {
                                $row->setBackground($paletaColor[$color % count($paletaColor)]); 
                            });
                        }
                    }
                    else{
                        $hoja->row(++$fila, $valoresProy);
                        $hoja->row($fila, function($row) use ($color, $paletaColor)  {
                                $row->setBackground($paletaColor[$color % count($paletaColor)]); 
                            });
                    }
                } 

                 // $endCell = str_repeat(chr(count($cabecera) % 26 + 64), ceil(count($cabecera)/26)) . (count($proyectos)+1);
                $hoja->setBorder('A1:Q'  . $fila, 'thin');  
                $hoja->setAutoSize(true);
                $hoja->setWidth(array('B'=>50, 'C'=>25, 'G'=>50, 'N'=>25, 'H'=>3,'I'=>3,'J'=>5,'K'=>3 )) ;     
            });

        })->export('xlsx');
    }

    /**-----------------------------------------------------------------------------------------------------------------------
    |  NO EJECUTAR, solo la primera vez o con suma observacion , TODO: modificar para solo insertar los nuevos datos ????
    |  Funcion para introducir en la tabla spie_resultados_proyectos_pdes en los campos id_proyecto_pdes y id_resultado ,
    |  la vinculacion que se tiene en el SP entre las tablas proyectos, accion, acciones y resultado
     */
    public function insertarResultadosProyectosPdes()
    {
        $proyectosResultadosSP = collect(\DB::connection("dbsp")->select(" SELECT DISTINCT pr.id AS id_proyecto, r.id AS id_resultado
                                                FROM proyectos pr, accion ai, acciones a, resultado r
                                                WHERE ai.proyecto = pr.id AND ai.estado = 1 AND ai.tipo <> 1
                                                AND ai.accion = a.id AND a.resultado = r.id "));

        foreach ($proyectosResultadosSP as $item)
        {
            \DB::table('spie_resultados_proyectos_pdes')->insert(['id_proyecto_pdes' => $item->id_proyecto, 'id_resultado' => $item->id_resultado]);
        }

        $datosNuevos = \DB::select("SELECT * from spie_resultados_proyectos_pdes");

        return response()->json([
            'msg'  => 'Insertados en spie_resultado_proyecto_pdes',
            'data' => $datosNuevos,
        ]);

    }

}
