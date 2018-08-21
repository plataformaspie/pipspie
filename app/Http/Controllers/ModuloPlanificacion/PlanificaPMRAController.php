<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Models\ModuloPdes\Pilares;
use Illuminate\Http\Request;

class PlanificaPMRAController extends PlanificacionBaseController
{

    public function showPlanificacionPMRA(Request $request)
    {
        return view('ModuloPlanificacion.show-planificacion-pmra');
    }

    /*
    |   POST: Para editar en los campos de tablas, llega un objeto con la especificacion de la tabla a modificar , el campo, y ekl valor
    |   estos parametros vienen codificados para que no sea visible para un usuario los nombres de tablas ni columnas
    | $req = { codtc : cod_tabla_columna, valor: valor, id: id_A_modificar }
     */
    public function modifyCampo(Request $req)
    {
        /*  Codificacion de la stablas y campos
            'ip-d': { sp_indicadores_prohgramacion  dato },
            'i-n': { sp_indicadores  nombre},
            'i-a': {sp_indicadores alcance},          
        */
        $cnf = [
            'ip_d' => (object)[ 'tabla'=>'sp_indicadores_programacion', 'col'=>'dato'],
            'i_n' => (object)[ 'tabla'=>'sp_indicadores', 'col'=>'nombre'],
            'i_a' => (object)[ 'tabla'=>'sp_indicadores', 'col'=>'alcance'],
        ];

        $tabla = $cnf[$req->codtc]->tabla;
        $col = $cnf[$req->codtc]->col;
        $val = $req->valor;

        $obj = new \stdClass();
        $obj->id = $req->id;
        $obj->$col = $val;
        $obj->id_user_updated = $this->user->id;
        $obj->updated_at = \Carbon\Carbon::now(-4);

        if($tabla == 'sp_indicadores'){
            \DB::table('sp_indicadores')->where('id', $obj->id)->update(get_object_vars($obj));
        }
        else if($tabla == 'sp_indicadores_programacion'){
            \DB::table('sp_indicadores_programacion')->where('id', $obj->id)->update(get_object_vars($obj));
        }


        return \Response::json([
            'accion' => 'update',
            'estado' => "success",
            'msg'    => "Se guardo con éxito.",
            'obj'   => $obj]);

    }



    /*-----------------------------------------------------------------------------------------------------------
    |  Obtiene una lista de las acciones asociadas a un plan
    | $req = { p : id_plan }
     */
    public function listaPmraPlan(Request $req)
    {
        $acciones = \DB::select("SELECT id, politica, id_plan, ids_pilares 
                                FROM sp_politica_pilares 
                                where activo AND id_plan =  ? ORDER BY id",[$req->p]);
        if (count($politicas) > 0)  {
            $pilares = collect(\DB::table('pdes_pilares')->orderBy('cod_p')->get())->groupBy('id');

            foreach ($politicas as $pol) {
                $pol->pilares = collect(explode('|', $pol->ids_pilares))
                                    ->filter(function($val){
                                        return $val != '';
                                    })->unique()->sort()->values()
                                    ->map(function($id, $key) use ($pilares){
                                        return $pilares[$id]->first();
                                    });
                $pol->ids_pilares = $pol->pilares->map(function($elem){
                    return $elem->id;
                });
            }

        }

        return response()->json([
            'data'=> $politicas,
        ]);
    }


    /*-------------------------------------------------------------------------------------------------
    | POST: Inserta una articulacion PDES a un plan en la tabla sp_plan_articulacion_pdes  (p,m,r,a, id_plan)
    | contiene $req{ id:id, id_a: id_accion, id_plan:id_plan, p: id_plan }
    | trae la propiedad $req->p: id_plan
     */
    public function savePolitica(Request $req)
    {
        //TODO verificar antes de modificar o eliminar que no se este utilizando
        $politica = new \stdClass();
        $politica->politica = $req->politica;
        $ids_pilares = collect($req->ids_pilares)
                                ->unique()->sort()->values()
                                ->reduce(function($carry, $id){
                                    return $carry . $id . '|';
                                },'|');

        $politica->ids_pilares = $ids_pilares;

        try {
            if ($req->id) // uPDATE
            {
                $politica->id_user_updated = $this->user->id;
                $politica->updated_at      = \Carbon\Carbon::now(-4);
                \DB::table('sp_politica_pilares')->where('id', $req->id)->update(get_object_vars($politica));
            }
            else // INSERT
            {
                $politica->activo     = true;
                $politica->id_plan    = $req->id_plan;
                $politica->id_user    = $this->user->id;
                $politica->created_at = \Carbon\Carbon::now(-4);
                $politica->id         = \DB::table('sp_politica_pilares')->insertGetId(get_object_vars($politica));
            }

            return \Response::json([
                'accion' => $req->id ? 'update' : 'insert',
                // 'data'   => $politica,
                'estado' => "success",
                'msg'    => "Se guardo con éxito."]);
        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'estado' => "error",
                'msg'    => $e->getMessage())
            );
        }
    }

    /*---------------------------------------------------------------------------------------
    | POST: delete $req = {id: id_plan_articulacion_pdes}
     */
    public function deletePolitica(Request $req)
    {
        try{

            \DB::table('sp_politica_pilares')->where('id', $req->id)->update(['activo'=>false]);
            return \Response::json([ 
                'estado' => "success",
                'msg' => "Se eliminó correctamente."
            ]);
        }
        catch (Exception $e) {
            return \Response::json([
                'estado' => "error",
                'msg' => $e->getMessage()
            ]);
        }
    }
    /*======================================================= PROGRAMACION DE RESULTADO ==============================================*/

    /*---------------------------------------------------------------------------------------
    | GET: lista las programaciones de los resultados de un plan $req = { p: id_plan }
     */    
    public function listaProgramacion(Request $req)
    {
        $listpmr = collect(\DB::select("
                SELECT pmra.id, pmra.id_p, p.cod_p, p.nombre as nombre_p, 
                    p.descripcion as desc_p, p.logo as logo_p,
                    pmra.id_m, m.cod_m, m.nombre as nombre_m, m.descripcion as desc_m,
                    pmra.id_r, r.cod_r, r.nombre as nombre_r, r.descripcion as desc_r, r.sector,
                    -- pmra.id_a, a.cod_a, a.nombre as nombre_a, a.descripcion as desc_a, 
                    pmra.id_plan, pl.cod_periodo_plan, pa.valor as gestion_ini, pa.valor2 as gestion_fin
                FROM sp_plan_articulacion_pdes pmra, pdes_pilares p, pdes_metas m, 
                            pdes_resultados r,  sp_planes pl, sp_parametros pa
                WHERE pmra.id_r = r.id AND  r.id_meta = m.id AND m.id_pilar = p.id 
                AND pmra.id_plan = pl.id AND pl.cod_periodo_plan = pa.codigo AND pa.categoria='periodo_plan' 
                AND pmra.activo AND pl.activo AND codp_nivel_articulacion = 'r'
                AND pmra.id_plan = ? 
                ORDER BY p.cod_p, m.cod_m, r.cod_r ", [$req->p]));


            $ariGroup = collect(\DB::select("SELECT ari.id as id_ari, i.id as id_i, i.nombre as nombre_indicador,  
                            i.variable, i.idp_unidad , p.codigo as unidad, i.alcance,ip.id as id_ip, ip.gestion, ip.dato
                             FROM sp_arti_resultado_indicador ari, sp_indicadores i, 
                             sp_parametros p, sp_indicadores_programacion ip
                            WHERE ari.id_indicador = i.id AND ari.activo AND i.activo 
                            AND ip.id_arti_indicador = ari.id AND ip.codp_nivel_pmra = 'r'
                            AND i.idp_unidad = p.id AND ari.id_plan_articulacion_pdes = {$elemPmr->id} 
                            ORDER BY ari.id, ip.gestion "))->groupBy('id_ari') ;
            $ariList = [];
            foreach ($ariGroup as $key => $arr) {
                $ind = $arr[0];
                $ari = new \stdClass();
                $ari->id_arti_resultado_indicador = $ind->id_ari;
                $ari->id_indicador = $ind->id_i;
                $ari->nombre_indicador = $ind->nombre_indicador;
                $ari->variable = $ind->variable;
                $ari->unidad = $ind->unidad;                
                $ari->idp_unidad = $ind->idp_unidad;                
                $ari->alcance = $ind->alcance;

                $lineabase = collect(\DB::select("SELECT ie.id as id_indicador_ejecucion, ie.gestion, ie.dato 
                    FROM sp_indicadores_ejecucion ie WHERE ie.id_arti_indicador = {$ind->id_ari} AND ie.codp_nivel_pmra = 'r' AND ie.gestion < {$elemPmr->gestion_ini} AND ie.dato is not null 
                    ORDER BY gestion desc "))->first() ; 
                if($lineabase) { 
                    $ari->id_indicador_ejecucion = $lineabase->id_indicador_ejecucion;
                    $ari->linea_base = $lineabase->dato;
                    $ari->linea_base_gestion = $lineabase->gestion;
                }
                $ari->programacion = $arr->map(function($prog){
                    return [
                        'id_ip' => $prog->id_ip,
                        'gestion' => $prog->gestion,
                        'dato' => $prog->dato
                    ];
                });
                $ariList[] = $ari;


            }
            $elemPmr->indicadores = $ariGroup->count() > 0 ? $ariList : [];

            return $elemPmr;
        });        

        return response()->json([
            'data'=> $listpmr,
        ]);
    }

    /*---------------------------------------------------------------------------------------
    | POST: Insert o Update de una programacion 
    | $req = { indicador: {}, arti_resultado_indicador: {}, indicador_ejecucion: {}, indicadores_programacion: {}
    | linea_base:?, alcance:?, indicadoresProgramacion:[{dato, gestion}, {dato, gestion}], p: id_plan }
     */
    public function saveIndicadorResProg(Request $req)
    {
        $indicador = (object)$req->indicador;
        $ari = (object)$req->arti_resultado_indicador;
        $ejecucion = (object)$req->indicador_ejecucion;
        $programacion = $req->indicadores_programacion;

        $indicador->codp_tipo_indicador = '';
        $indicador->codp_nivel_pmra = 'r';
        try {
            $indicador->id = $this->saveObjectTabla($indicador, 'sp_indicadores');
            $ari->id_indicador = $indicador->id;
            $ari->id = $this->saveObjectTabla($ari, 'sp_arti_resultado_indicador');

            /* se llena la linea base en la tabla de ejecuciones */
            $ejecucion->id_arti_indicador = $ari->id;
            $ejecucion->codp_nivel_pmra = 'r';
            $this->saveObjectTabla($ejecucion, 'sp_indicadores_ejecucion');

            foreach ($programacion as $pr)
            {
                $pr = (object)$pr;
                $pr->id_arti_indicador = $ari->id;
                $pr->codp_nivel_pmra = 'r';
                $this->saveObjectTabla($pr, 'sp_indicadores_programacion');
            }

            return \Response::json([
                'accion' => 'insert',
                'estado' => "success",
                'msg'    => "Se guardo con éxito."]);
        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'estado' => "error",
                'msg'    => $e->getMessage())
            );
        }
    }

    /*---------------------------------------------------------------------------------------
    | POST: delete $req = {id_ari: id_arti_resultado_indicador}
     */
    public function deleteProgramacion(Request $req)
    {
        try{
            $arti_res_ind = \DB::table('sp_arti_resultado_indicador')->where('id', $req->id_ari);

        $pilares = \DB::table('pdes_pilares')->get()->groupBy('id');
        $pilaresPlan = [];
        foreach ($idsPilares as $idp) {
             $pilaresPlan[] = $pilares[$idp]->first();
         } 

            /* inactiva el arti_resultado_indicador */
            $arti_res_ind->update(['activo'=>false]);
            return \Response::json([ 
                'estado' => "success",
                'msg' => "Se eliminó correctamente."
            ]);
        }
        catch (Exception $e) {
            return \Response::json([
                'estado' => "error",
                'msg' => $e->getMessage()
            ]);
        }
    }

    /* ========================================= PLANIFICACION DE LA ACCION ==========================================*/
    

    /*----------------------------------------------------------------------------------------------------------
    | Recupera la lista de acciones asignadas a un plan con sus proyectos 
    | $req = {p:id_plan} 
     */
    public function listaAccionesProyectos(Request $req)
    {
        $pmraProyectos = collect(\DB::select("  
            SELECT a.*, ap.id as id_arti_pdes_proyecto, ap.gestion_ini, ap.gestion_fin, ap.codp_tipo_proyecto, 
                    pa.nombre as tipo_proyecto,  pr.id id_proyecto, pr.nombre_proyecto, 
                    pr.codigo 
            FROM 
            (
                    SELECT pmra.id as id_pmra, pmra.id_p, p.cod_p, p.nombre as nombre_p, 
                            p.descripcion as desc_p, p.logo as logo_p,
                            pmra.id_m, m.cod_m, m.nombre as nombre_m, m.descripcion as desc_m,
                            pmra.id_r, r.cod_r, r.nombre as nombre_r, r.descripcion as desc_r, r.sector,
                            pmra.id_a, a.cod_a, a.nombre as nombre_a, a.descripcion as desc_a, 
                            pmra.id_plan , pl.cod_periodo_plan, pa.valor as periodo_gestion_ini, pa.valor2 as periodo_gestion_fin  
                    FROM sp_plan_articulacion_pdes pmra, pdes_pilares p, pdes_metas m, 
                         pdes_resultados r, pdes_acciones a, sp_planes pl, sp_parametros pa
                    WHERE pmra.id_a = a.id AND a.id_resultado = r.id AND r.id_meta = m.id AND m.id_pilar = p.id 
                    AND pmra.id_plan = pl.id  AND pl.cod_periodo_plan = pa.codigo AND pa.categoria='periodo_plan'
                    AND pmra.activo AND pl.activo AND codp_nivel_articulacion = 'a' 
                    AND pmra.id_plan = ?
            ) a
            LEFT JOIN sp_arti_pdes_proyecto ap ON a.id_pmra = ap.id_plan_articulacion_pdes AND ap.activo
            LEFT JOIN sp_proyectos pr ON ap.id_proyecto = pr.id AND pr.activo
            LEFT JOIN sp_parametros pa ON ap.codp_tipo_proyecto = pa.codigo 
            ORDER BY a.cod_p, a.cod_m, a.cod_r, a.cod_a, pr.codigo ", [$req->p]));


        $pmraProyectosGroup = $pmraProyectos->groupBy('id_pmra');
        $list = [];
        foreach ($pmraProyectosGroup as $key => $elems) {
            $pmra = collect((array)$elems[0])->except(['id_arti_pdes_proyecto', 'gestion_ini', 'gestion_fin', 'codp_tipo_proyecto', 
                    'tipo_proyecto',   'id_proyecto', 'nombre_proyecto', 'codigo'  ]) ;

            $pmra['proyectos'] = ($elems[0]->id_arti_pdes_proyecto <> null) ?
                                        $elems->map(function($el){
                                            return collect((array)$el)->only(['id_arti_pdes_proyecto', 'gestion_ini', 'gestion_fin', 'codp_tipo_proyecto', 
                                                'tipo_proyecto',   'id_proyecto', 'nombre_proyecto', 'codigo'  ]);                                          
                                        }) : [];
            $list[] = $pmra;
        }
        return response()->json([
            'data' => $list,
            // 'data' => $pmraProyectos,
        ]);

    }

    /* ------------------------------------------------------------------------------------------------
    |   Guarda y modifica en sp_arti_pdes_proyecto y sp_proyectos, tambien hace la eliminacion si tiene el atributo elimina, 
     */
    public function saveArtiProyecto(Request $req)
    {
        $req->accion = ($req->id_arti_pdes_proyecto) ? 'update' : 'insert';
        $artiproy = new \stdClass();
        $artiproy->id = $req->id_arti_pdes_proyecto;
        $artiproy->id_plan_articulacion_pdes = $req->id_plan_articulacion_pdes;
        $artiproy->id_proyecto = ($req->accion=='insert') ? $req->select_id_proyecto : $req->id_proyecto;
        $artiproy->codp_tipo_proyecto = $req->codp_tipo_proyecto;
        $artiproy->gestion_ini = $req->gestion_ini;
        $artiproy->gestion_fin = $req->gestion_fin;

        $proyecto = new \stdClass();
        $proyecto->id = $req->id_proyecto;
        $proyecto->nombre_proyecto = $req->nombre_proyecto;
        $proyecto->codigo = $req->codigo;    

        try{

            if($req->delete){
                $this->deleteObjectTabla($artiproy->id, 'sp_arti_pdes_proyecto'); 
                return \Response::json([
                    'estado' => "success",
                    'msg'    => "Se eliminó ."]);
            }

            $tipo = $artiproy->codp_tipo_proyecto;
            if($req->accion == 'insert'){                

                if($tipo == 'pdes'){
                    $artiproy->id = $this->saveObjectTabla($artiproy, 'sp_arti_pdes_proyecto');
                };

                if($tipo == 'accs'){
                    $proyectoAccion = \DB::table('sp_proyectos')->where('id_accion', $req->id_accion)->get();
                    if($proyectoAccion->count() > 0){
                        $artiproy->id_proyecto = $proyectoAccion->first()->id;
                        $artiproy->id = $this->saveObjectTabla($artiproy, 'sp_arti_pdes_proyecto');
                    }
                    else{
                        $proyecto->codp_tipo_proyecto = 'accs';
                        $proyecto->id_accion = $req->id_accion;
                        $artiproy->id_proyecto = $this->saveObjectTabla($proyecto, 'sp_proyectos');
                        $this->saveObjectTabla($artiproy, 'sp_arti_pdes_proyecto');
                    }

                };

                if($tipo == 'cont'){
                    $artiproy->id = $this->saveObjectTabla($artiproy, 'sp_arti_pdes_proyecto');
                };

                if($tipo == 'prod'){
                    $artiproy->id_proyecto = $this->saveObjectTabla($proyecto, 'sp_proyectos');
                    $this->saveObjectTabla($artiproy, 'sp_arti_pdes_proyecto');
                };
            }
            if($req->accion == 'update'){
                $proyecto->id = $artiproy->id_proyecto;
                // unset($artiproy->codp_tipo_proyecto);
                // unset($artiproy->id_plan_articulacion_pdes);
                // unset($artiproy->id_proyecto);
                if($tipo == 'pdes' || $tipo == 'accs' || $tipo == 'cont'  ){                    
                    $this->saveObjectTabla($artiproy, 'sp_arti_pdes_proyecto');
                }
                if($tipo == 'prod'){
                    $this->saveObjectTabla($proyecto, 'sp_proyectos');
                    $this->saveObjectTabla($artiproy, 'sp_arti_pdes_proyecto');
                }
            }

            


            return \Response::json([
                'accion' => $req->accion,
                'estado' => "success",
                'msg'    => "Se guardo con éxito."]);
        }
        catch (Exception $e)
        {
            return response()->json([
                'estado' => "error",
                'msg'    => $e->getMessage()
            ]);
        }
    }



    /* -------------------------------------------------------
    | Obtiene una lista de todos los proyectos
     */
    public function listProyectos()
    {
        $proys = \DB::select('SELECT id, nombre_proyecto, codigo, codp_tipo_proyecto FROM sp_proyectos where activo ORDER BY codp_tipo_proyecto, codigo');
        return response()->json([
            'data' => $proys,
        ]);
    }

    /*---------------------------------------------------------------------------------------
    | POST: Insert o Update de una indicador de proyecto con su programacion 
    | $req = { indicador: {}, arti_pdes_proyecto_indicador: {}, indicador_ejecucion: {}, indicadores_programacion: {}
    | linea_base:?, alcance:?, indicadoresProgramacion:[{dato, gestion}, {dato, gestion}], p: id_plan }
     */
    public function saveIndicadorAccionProg(Request $req)
    {
        $indicador = (object)$req->indicador;
        $appi = (object)$req->arti_pdes_proyecto_indicador;
        $ejecucion = (object)$req->indicador_ejecucion;
        $programacion = $req->indicadores_programacion;

        $indicador->codp_tipo_indicador = '';
        $indicador->codp_nivel_pmra = 'a';
        try {
            $indicador->id = $this->saveObjectTabla($indicador, 'sp_indicadores');
            $appi->id_indicador = $indicador->id;
            $appi->id = $this->saveObjectTabla($appi, 'sp_arti_pdes_proyecto_indicador');

            /* se llena la linea base en la tabla de ejecuciones */
            $ejecucion->id_arti_indicador = $appi->id;
            $ejecucion->codp_nivel_pmra = 'a';

            $this->saveObjectTabla($ejecucion, 'sp_indicadores_ejecucion');

            foreach ($programacion as $pr)
            {
                $pr = (object)$pr;
                $pr->id_arti_indicador = $appi->id;
                $pr->codp_nivel_pmra = 'a';
                $this->saveObjectTabla($pr, 'sp_indicadores_programacion');
            }

            return \Response::json([
                'accion' => 'insert',
                'estado' => "success",
                'msg'    => "Se guardo con éxito."]);
        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'estado' => "error",
                'msg'    => $e->getMessage())
            );
        }
    }

    /*---------------------------------------------------------------------------------------------------------------------
    | Inserta en la tabla spo_responsables los valores nuevos, si se introduces repetidos estos no se insertan
    |   $req: { id_arti_pdes_proyecto : '123', id_entidades: [1,2,3]}
     */
    public function saveResponsables(Request $req){
        $id_arti_pdes_proyecto = $req->id_arti_pdes_proyecto;
        $id_entidades = collect($req->id_entidades);        

        $id_entidades_exist = [];
        $entidadesExist = collect(\DB::select("SELECT id_entidad from sp_responsables where activo and id_arti_pdes_proyecto = {$id_arti_pdes_proyecto}"));
        foreach ($entidadesExist as  $el) {
            $id_entidades_exist[] = $el->id_entidad;
        };

        $inserts = $id_entidades->diff($id_entidades_exist);
        foreach ($inserts as $id) {
            $obj = [
                'id_arti_pdes_proyecto' => $id_arti_pdes_proyecto,
                'id_entidad' => $id,
                'activo' => true,
                'id_user' =>  $this->user->id,
                'created_at' => \Carbon\Carbon::now(-4)];
            \DB::table('sp_responsables')->insert($obj);
        }

        return \Response::json([
                'estado' => "success",
                'msg'    => "Se guardo con éxito."]);
    }


    /*---------------------------------------------------------------------------------------------------------------------
    | Inserta en la tabla sp_roles_actores  los valores nuevos (nuevos actores), si se introduce repetidos estos no se insertan
    |   $req: { id_arti_pdes_proyecto : 123, idp_actor: 123, descripcion: 'abc'}
     */
    public function saveRolesActores(Request $req){
        $obj = new \stdClass();
        $obj->id = $req->id_rol_actor;
        $obj->id_arti_pdes_proyecto = $req->id_arti_pdes_proyecto;
        $obj->idp_actor = $req->idp_actor;
        $obj->descripcion = $req->descripcion;
        $id = $this->saveObjectTabla($obj, 'sp_roles_actores');     
        return \Response::json([
                'estado' => "success",
                'msg'    => "Se guardó con éxito."]);
    }

    /*---------------------------------------------------------------------------------------------------------------------    
    | Inserta en la tabla sp_articulacion_competencial  , si se introduce repetidos estos no se insertan
    |   $req: { id_arti_pdes_proyecto : 123, idp_entidad_territorial: 123, idp_competencia: 123, norma: 'abc'}
     */
    public function saveArticulacionCompetencial(Request $req){
        $obj = new \stdClass();
        $obj->id = $req->id_articulacion_competencial;
        $obj->id_arti_pdes_proyecto = $req->id_arti_pdes_proyecto;
        $obj->idp_entidad_territorial = $req->idp_entidad_territorial;
        $obj->idp_competencia = $req->idp_competencia;
        $obj->norma = $req->norma;
        $id = $this->saveObjectTabla($obj, 'sp_articulacion_competencial');     
        return \Response::json([
                'estado' => "success",
                'msg'    => "Se guardó con éxito."]);
    }    

    /*---------------------------------------------------------------------------------------------------------------------    
    | Inserta en la tabla sp_territorializacion  , si se introduce repetidos estos no se insertan
    |   $req: { id_arti_pdes_proyecto : 123, id_region: 123}
     */
    public function saveTerritorializacion(Request $req){
        $id_arti_pdes_proyecto = $req->id_arti_pdes_proyecto;
        $id_regiones = collect($req->id_regiones);        

        $ids_regiones_exist = [];
        $regionesExist = collect(\DB::select("SELECT id_region from sp_territorializacion where activo and id_arti_pdes_proyecto = {$id_arti_pdes_proyecto}"));
        foreach ($regionesExist as  $el) {
            $ids_regiones_exist[] = $el->id_region;
        };

        $inserts = $id_regiones->diff($ids_regiones_exist);
        foreach ($inserts as $id) {
            $obj = (object)[
                'id' => null,
                'id_arti_pdes_proyecto' => $id_arti_pdes_proyecto,
                'id_region' => $id];
             $this->saveObjectTabla($obj, 'sp_territorializacion');  
        }

        return \Response::json([
                'estado' => "success",
                'msg'    => "Se guardó con éxito."]);
    }

    /*---------------------------------------------------------------------------------------
    | Lista todos los atributos relacionados a un arti_pdes_proyecto segun la opcion de envio
    | req = { id_arti_pdes_proyecto : id , atributo : 'indicadores o Roles Actores o etc', p: id_plan}
     */    
    public function listAtributo(Request $req)
    {
        $atributo = $req->atributo;
        $id_arti_pdes_proyecto = $req->id_app;
        $list = '';
        switch ($atributo) {
            case 'ind': // Indicadores
                $periodo_plan = \DB::select("SELECT p.valor as gestion_ini, p.valor2 as gestion_fin from sp_planes pl, sp_parametros p 
                                                where pl.cod_periodo_plan = p.codigo and pl.activo and p.activo and pl.id= {$req->p}")[0];

                $list = collect(\DB::select("SELECT app.id as id_arti_pdes_proyecto, i.id as id_indicador, i.nombre as nombre_indicador, 
                                i.codp_tipo_indicador, i.idp_unidad, p.codigo as unidad, i.alcance, i.variable, appi.id as id_arti_pdes_proyecto_indicador
                                FROM sp_arti_pdes_proyecto app, sp_indicadores i, sp_arti_pdes_proyecto_indicador appi, sp_parametros p
                                WHERE app.id = appi.id_arti_pdes_proyecto AND i.id = appi.id_indicador  AND i.idp_unidad = p.id
                                AND i.activo AND appi.activo AND app.activo and i.codp_nivel_pmra = 'a' AND app.id = ? 
                                ORDER by i.nombre ", [$id_arti_pdes_proyecto]));
                foreach ($list as $key => $elem) {
                    // $list = $list->map(function($elem){
                    $elem->programacion = \DB::select("SELECT ip.id as id_ip, ip.gestion, ip.dato FROM sp_indicadores_programacion ip 
                                                        where ip.activo AND ip.id_arti_indicador = {$elem->id_arti_pdes_proyecto_indicador} ");

                    $lineabase = collect(\DB::select("SELECT ie.id as id_indicador_ejecucion, ie.gestion, ie.dato 
                                FROM sp_indicadores_ejecucion ie WHERE ie.id_arti_indicador = {$elem->id_arti_pdes_proyecto_indicador} AND ie.codp_nivel_pmra = 'a' AND ie.gestion < {$periodo_plan->gestion_ini} AND ie.dato is not null 
                                ORDER BY gestion desc "))->first() ; 


                    if($lineabase) { 
                        $elem->id_indicador_ejecucion = $lineabase->id_indicador_ejecucion;
                        $elem->linea_base = $lineabase->dato;
                        $elem->linea_base_gestion = $lineabase->gestion;
                    }
                };

                break;
            case 'res': // responsables
                $list = \DB::select("SELECT app.id as id_arti_pdes_proyecto, r.id as id_responsable, e.id as id_entidad, e.nombre as nombre_entidad, e.sigla
                                FROM sp_arti_pdes_proyecto app, sp_responsables r, sp_entidades e
                                WHERE app.id = r.id_arti_pdes_proyecto AND e.id = r.id_entidad 
                                AND app.activo and r.activo AND e.activo AND r.id_arti_pdes_proyecto = {$id_arti_pdes_proyecto}
                                ORDER by e.nombre");
                break;
            case 'rol': // roles y actores
                $list = \DB::select("SELECT ra.id as id_rol_actor, ra.id_arti_pdes_proyecto, ra.idp_actor, ra.descripcion,
                                            pa.nombre as actor, pa.valor as tipo  
                                FROM sp_roles_actores ra, sp_parametros pa 
                                WHERE ra.activo AND pa.activo AND ra.idp_actor = pa.id  
                                AND ra.id_arti_pdes_proyecto =  {$id_arti_pdes_proyecto}
                                ORDER BY pa.nombre ");
                break;           
            case 'art': // roles y actores
                $list = \DB::select("SELECT ac.id as id_articulacion_competencial, ac.idp_entidad_territorial, pet.nombre as nombre_entidad_territorial, 
                                            ac.idp_competencia, pc.nombre as nombre_competencia, ac.norma
                                FROM sp_articulacion_competencial ac, sp_parametros pet, sp_parametros pc
                                WHERE ac.idp_entidad_territorial = pet.id AND ac.idp_competencia = pc.id 
                                AND ac.activo AND pet.activo AND pc.activo
                                AND ac.id_arti_pdes_proyecto = {$id_arti_pdes_proyecto}  ");
                break;
            case 'ter': // roles y actores
                $list = \DB::select("SELECT t.id as id_territorializacion, t.id_region, 
                                r.nombre_comun as nombre_region, r.codigo_numerico as codigo_region, r.categoria as categoria_region  
                        FROM sp_territorializacion t, regiones r
                        WHERE t.id_region = r.id AND t.activo AND r.activo 
                        AND t.id_arti_pdes_proyecto =  {$id_arti_pdes_proyecto}  
                        ORDER BY r.nombre_comun");
                break;

        }
        return response()->json(['data'=> $list]);
    }


    /*------------------------------------------------------------------
    |   Pone en inactivo segun el atributo y el Id que recibe  $Req = {atributo : 'res', id: '123'}
    | atributos ind: indicadores, res:responsables, rol:roles y actores, art: articulacion competencial, ter:territorializacion 
    */ 
    public function deleteAtributo(Request $req){
        $atrib = $req->atributo;
        switch ($atrib) {
            case 'ind':
                $this->deleteObjectTabla($req->id, 'sp_arti_pdes_proyecto_indicador');
                break;    
            case 'res':
                $this->deleteObjectTabla($req->id, 'sp_responsables');
                break;   
            case 'rol':
                $this->deleteObjectTabla($req->id, 'sp_roles_actores');
                break;   
            case 'art':
                $this->deleteObjectTabla($req->id, 'sp_articulacion_competencial');
                break;   
            case 'ter':
                $this->deleteObjectTabla($req->id, 'sp_territorializacion');
                break;          

        }

        return \Response::json([ 
            'estado' => "success",
            'msg' => "Se eliminó correctamente."
        ]); 
    }

    public function listRegiones(Request $req)
    {
        $id_padre = $req->id_padre;
        $list = \DB::select("SELECT * FROM regiones Where activo and id_padre = {$id_padre} ORDER BY codigo_numerico");
        return response()->json(['data' => $list]);
    }


    /* ================================================ FUNCIONES PRIVADAS y PROTEGIDAS ==========================================*/


    /*--------------------------------------------------------------------------------------------------------------
    |   Funcion Generica para incsertar o modificar las tablas
     */
    private function saveObjectTabla($obj, $tabla)
    {
        try{
            if ($obj->id) // UPDATE 
            {
                $obj->activo =  true;
                $obj->id_user_updated = $this->user->id;
                $obj->updated_at = \Carbon\Carbon::now(-4);
                \DB::table($tabla)->where('id', $obj->id)->update(get_object_vars($obj));
                return $obj->id;
            }
            else // INSERT
            {
                unset($obj->id);
                $obj->activo = true;
                $obj->id_user =  $this->user->id;
                $obj->created_at = \Carbon\Carbon::now(-4);
                return \DB::table($tabla)->insertGetId(get_object_vars($obj));
            }
        }
        catch (Exception $e)
        {
            return response()->json(array(
                'estado' => "error",
                'msg'    => $e->getMessage())
            );
        }
    }

     private function deleteObjectTabla($id, $tabla)
    {
        try{
                $obj = new \stdClass();
                $obj->id = $id;
                $obj->activo = false;
                $obj->id_user_updated = $this->user->id;
                $obj->updated_at = \Carbon\Carbon::now(-4);
                \DB::table($tabla)->where('id', $id)->update(get_object_vars($obj));
                return $obj->id;
        }
        catch (Exception $e)
        {
            return response()->json(array(
                'estado' => "error",
                'msg'    => $e->getMessage())
            );
        }
    } 




}
