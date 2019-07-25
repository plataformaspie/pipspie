<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PlanificacionTerritorial\CategoriasAccion;
use App\Models\PlanificacionTerritorial\CatalogoEstructuraProgramatica;
use App\Models\PlanificacionTerritorial\CatalogoAccionesEta;
use App\Models\PlanificacionTerritorial\CatalogoPdes;
use App\Models\PlanificacionTerritorial\Indicadores;

use App\Models\PlanificacionTerritorial\ObjetivosEta;
use App\Models\PlanificacionTerritorial\ArticulacionObjetivosIndicador;
use App\Models\PlanificacionTerritorial\ProgramacionIndicador;
use App\Models\PlanificacionTerritorial\ProgramacionRecursos;
use App\Models\PlanificacionTerritorial\EtapasPlan;

class PlanificacionController extends BasecontrollerController
{

  public function listaObjetivosEtaGenerados(Request $request)
  {
        $user = \Auth::user();

        $listaObjetivos = \DB::select("SELECT o.id,o.nombre_objetivo,o.codigo_sisin, ac.nombre_accion_eta,ac.codigo_pdes, ac.ep_descripcion,ac.codigo_estructura_programatica,ac.desc_a,ac.cod_p,ac.cod_m,ac.cod_r,ac.cod_a,ac.img_p,
                                      cata.id as id_categoria, cata.id_categoria_padre
                                      FROM sp_eta_objetivos_eta o
                                      LEFT JOIN sp_eta_etapas_plan ep ON (o.id_etapas_plan = ep.id AND ep.valor_campo_etapa = 'PTDI')
                                      LEFT JOIN sp_eta_articulacion_objetivo_indicador aoi ON o.id = aoi.id_objetivo_eta
                                      LEFT JOIN sp_eta_indicadores i ON aoi.id_indicador = i.id
                                      LEFT JOIN sp_eta_view_articulacion_catalogos ac ON o.id_accion_eta = ac.id
                                      LEFT JOIN sp_eta_categorias_acciones_eta cata ON o.id_categoria_accion = cata.id
                                      WHERE cata.id_categoria_padre = ?
                                      AND o.activo = true
                                      AND ep.id_institucion = ?",[$request->categoria,$user->id_institucion]);
                                      

        $totalCategoriaGestiones = \DB::select("SELECT gestion, SUM( monto ) as total
                                          FROM sp_eta_objetivos_eta o
                                          INNER JOIN sp_eta_etapas_plan ep ON o.id_etapas_plan = ep.id
                                          INNER JOIN sp_eta_categorias_acciones_eta cat ON o.id_categoria_accion = cat.id
                                          INNER JOIN sp_eta_articulacion_objetivo_indicador aoi ON o.id = aoi.id_objetivo_eta
                                          INNER JOIN sp_eta_programacion_recursos pr ON aoi.id = pr.id_articulacion_objetivo_indicador
                                          WHERE o.activo = true
                                          AND ep.id_institucion = ?
                                          AND cat.id_categoria_padre = ?
                                          GROUP BY gestion
                                          ORDER BY gestion ASC",[$user->id_institucion,$request->categoria]);

        $totalCategoriaSelec = 0;
        foreach ($totalCategoriaGestiones as  $value) {
          $totalCategoriaSelec += $value->total;
        }

        $totalesGeneral = $this->totalesPlanificacion();

        return \Response::json(array(
            'error' => false,
            'listaObjetivosGenerados' => $listaObjetivos,
            'totalRecursos' => $totalesGeneral['totalRecursos'],
            'totalDeuda' => $totalesGeneral['totalDeudas'],
            'totalCategoriaGestiones' => $totalCategoriaGestiones,
            'totalRecursosAsignados' => $totalesGeneral['totalRecursosAsignados'],
            'totalCategoriaSelec' => $totalCategoriaSelec,
            'msg' => "Respuesta exitosa.")
        );
  }
  public function datosObjetivoSeleccionado(Request $request)
  {
        $user = \Auth::user();

        $datosObjetivo = \DB::select("SELECT ac.id_categoria_prog, o.id_accion_eta,o.id as id_objetivo,o.nombre_objetivo,o.codigo_sisin,
                                      aoi.id as id_articulacion, aoi.linea_base_descripcion,aoi.linea_base_unidad,aoi.linea_base_cantidad,aoi.id_indicador,aoi.indicador_cantidad,
                                      o.desagregado, o.tipo_objetivo
                                      FROM sp_eta_objetivos_eta o
                                      LEFT JOIN sp_eta_articulacion_objetivo_indicador aoi ON o.id = aoi.id_objetivo_eta
                                      LEFT JOIN sp_eta_view_articulacion_catalogos ac ON o.id_accion_eta = ac.id
                                      WHERE o.id = ?",[$request->id_objetivo]);
        $programacionIndicadorObjetivo = ProgramacionIndicador::where('id_articulacion_objetivo_indicador', $datosObjetivo[0]->id_articulacion)->where('activo', true)->orderBy('gestion', 'ASC')->get();
        $arrayProgramacionIndicadorObjetivo  = array();
        foreach ($programacionIndicadorObjetivo as $item) {
          $arrayProgramacionIndicadorObjetivo['datos'][$item->gestion] = $item->valor;
          $arrayProgramacionIndicadorObjetivo['ids'][$item->gestion] = $item->id;
        }

        $programacionRecursosObjetivo = ProgramacionRecursos::where('id_articulacion_objetivo_indicador', $datosObjetivo[0]->id_articulacion)->where('activo', true)->orderBy('gestion', 'ASC')->get();
        $arrayProgramacionRecursosObjetivo  = array();
        foreach ($programacionRecursosObjetivo as $item) {
          $arrayProgramacionRecursosObjetivo['datos'][$item->gestion] = $item->monto;
          $arrayProgramacionRecursosObjetivo['ids'][$item->gestion] = $item->id;
        }

        return \Response::json(array(
            'error' => false,
            'datosObjetivo' => $datosObjetivo,
            'programacionIndicadorObjetivo' => $arrayProgramacionIndicadorObjetivo,
            'programacionRecursosObjetivo' => $arrayProgramacionRecursosObjetivo,
            'datosObjetivo' => $datosObjetivo,
            'msg' => "Proceso exitoso.")
        );
  }
  public function categoriasPadreAcciones(Request $request)
  {
        $user = \Auth::user();
        $categoriasPadre = \DB::select("SELECT fuente.*,
                                       (
                                        	SELECT SUM(pr.monto) as total
                                        	FROM sp_eta_objetivos_eta o
                                        	INNER JOIN sp_eta_etapas_plan ep ON o.id_etapas_plan = ep.id
                                        	INNER JOIN sp_eta_categorias_acciones_eta cat ON o.id_categoria_accion = cat.id
                                        	INNER JOIN sp_eta_articulacion_objetivo_indicador aoi ON o.id = aoi.id_objetivo_eta
                                        	INNER JOIN sp_eta_programacion_recursos pr ON aoi.id = pr.id_articulacion_objetivo_indicador
                                        	WHERE o.activo = true
                                        	AND ep.id_institucion = fuente.id_institucion
                                        	AND cat.id_categoria_padre = fuente.id_categoria_padre
                                        ) as monto_prorgamado
                                        FROM(
                                          SELECT ca.*,	ep.estado_etapa,ep.id_institucion
                                          FROM sp_eta_categorias_acciones_eta ca
                                          LEFT JOIN sp_eta_etapas_plan ep ON ( ca.sigla = ep.valor_campo_etapa AND ep.id_institucion = ? )
                                          WHERE	ca.nivel = 0
                                          ORDER BY ca.ID ASC
                                        ) as fuente",[$user->id_institucion]);
        $totalesGeneral = $this->totalesPlanificacion();

        return \Response::json(array(
            'error' => false,
            'categoriasPadre' => $categoriasPadre,
            'totalRecursos' => $totalesGeneral['totalRecursos'],
            'totalDeuda' => $totalesGeneral['totalDeudas'],
            'totalRecursosAsignados' => $totalesGeneral['totalRecursosAsignados'],
            'msg' => "Respuesta exitosa.")
        );
  }


  public function categoriasHijosAccion(Request $request)
  {
        $user = \Auth::user();
        $categoriasHijos = CategoriasAccion::where('id_categoria_padre', $request->id_padre)->orderBy('id', 'ASC')->orderBy('id_padre', 'ASC')->get();
        $html='';
        $sw=0;
        $nivelA = 0;

        foreach ($categoriasHijos as  $key =>$value) {
            if($value->nivel != 0){
                if($value->nivel > $nivelA){
                    if($sw==0){
                      $nivelA = $value->nivel;
                      $sw=1;
                      $html.='<li>';
                      if($value->planificable)
                      $html.='<button type="button" class="btn btn-info btn-sm" onclick="crearAccion('.$value->id.')" @click="$emit(\'click\')" style="padding-top: 1px;padding-bottom: 1px;padding-right: 4px;padding-left: 4px;"><i class="fa fa-plus-square"></i> </button> '.$value->nombre_categoria;
                      else
                      $html.=$value->nombre_categoria;
                    }else{
                      $nivelA = $value->nivel;
                        $html.='<ul>';
                        $html.='<li>';
                        if($value->planificable)
                        $html.='<button type="button" class="btn btn-info btn-sm" onclick="crearAccion('.$value->id.')" @click="$emit(\'click\')" style="padding-top: 1px;padding-bottom: 1px;padding-right: 4px;padding-left: 4px;"><i class="fa fa-plus-square"></i> </button> '.$value->nombre_categoria;
                        else
                        $html.=$value->nombre_categoria;
                    }

                }elseif($value->nivel == $nivelA){
                  $nivelA = $value->nivel;
                  $html.='</li>';
                  $html.='<li>';
                  if($value->planificable)
                  $html.='<button type="button" class="btn btn-info btn-sm" onclick="crearAccion('.$value->id.')" @click="$emit(\'click\')" style="padding-top: 1px;padding-bottom: 1px;padding-right: 4px;padding-left: 4px;"><i class="fa fa-plus-square"></i> </button> '.$value->nombre_categoria;
                  else
                  $html.=$value->nombre_categoria;
                }elseif($value->nivel < $nivelA){
                  $nivelA = $value->nivel;
                  $html.='</li>';
                  $html.='</ul>';
                  $html.='</li>';
                  $html.='<li>';
                  if($value->planificable)
                  $html.='<button type="button" class="btn btn-info btn-sm" onclick="crearAccion('.$value->id.')" @click="$emit(\'click\')" style="padding-top: 1px;padding-bottom: 1px;padding-right: 4px;padding-left: 4px;"><i class="fa fa-plus-square"></i> </button> '.$value->nombre_categoria;
                  else
                  $html.=$value->nombre_categoria;
                }
            }else{
              $titulo_categoria = $value->nombre_categoria;
              if(count($categoriasHijos) == 1){
                $nivelA = 1;
                $html.='<li>';
                if($value->planificable)
                $html.='<button type="button" class="btn btn-info btn-sm"   onclick="crearAccion('.$value->id.')" @click="$emit(\'click\')" style="padding-top: 1px;padding-bottom: 1px;padding-right: 4px;padding-left: 4px;"><i class="fa fa-plus-square"></i> </button> '.$value->nombre_categoria;
                else
                $html.=$value->nombre_categoria;

              }
            }
        }
        for($i=1;$i<=$nivelA;$i++){
          if($i==$nivelA){
            $html.='</li>';
          }else{
            $html.='</li>';
            $html.='</ul>';
          }

        }
        return \Response::json(array(
            'error' => false,
            'categoriasHijos' => $html,
            'titulo_nombre_categoria' => $titulo_categoria,
            'msg' => "Respuesta exitosa.")
        );
  }

  public function listaEstructuraProgramaticaIndicadores(Request $request)
  {
        $user = \Auth::user();
        $catalogoEstructuraProgramatica = CatalogoEstructuraProgramatica::orderBy('id', 'ASC')->get();
        $indicadores = Indicadores::orderBy('id', 'ASC')->get();

        return \Response::json(array(
            'error' => false,
            'estructuraProgramatica' => $catalogoEstructuraProgramatica,
            'indicadores' => $indicadores,
            'msg' => "Respuesta exitosa.")
        );
  }

  public function listaCatalogoAccionEta(Request $request)
  {
        $user = \Auth::user();
        $codigoEstructuraProgramatica = CatalogoEstructuraProgramatica::where('id',$request->id_sel)->first();
        $catalogoAccionEtaSel = CatalogoAccionesEta::where('codigo_estructura_programatica',$codigoEstructuraProgramatica->codigo)->orderBy('id', 'ASC')->get();
        return \Response::json(array(
            'error' => false,
            'catalogoAccionEta' => $catalogoAccionEtaSel,
            'msg' => "Respuesta exitosa.")
        );
  }

  public function datosCatalogoAccionEta(Request $request)
  {
        $user = \Auth::user();
        $codigoEstructuraProgramatica = CatalogoEstructuraProgramatica::where('id',$request->id_sel)->first();
        $catalogoAccionEtaSel = CatalogoAccionesEta::where('codigo_estructura_programatica',$codigoEstructuraProgramatica->codigo)->orderBy('id', 'ASC')->get();
        return \Response::json(array(
            'error' => false,
            'catalogoAccionEta' => $catalogoAccionEtaSel,
            'msg' => "Respuesta exitosa.")
        );
  }

  public function datosDetalleAccionEta(Request $request)
  {
        $user = \Auth::user();
        $detalleAccionEta = \DB::select("SELECT *
                    FROM sp_eta_catalogo_acciones_eta ae
                    INNER JOIN pdes_vista_catalogo_pmra c ON ae.codigo_pdes = c.codigo_accion
                    WHERE ae.id = ?",[$request->id_accion_eta]);
        return \Response::json(array(
            'error' => false,
            'detalleAccionEta' => $detalleAccionEta,
            'msg' => "Respuesta exitosa.")
        );
  }

  public function savePlanificacion(Request $request)
  {
    $periodoActual = $this->periodoActual();
    $user = \Auth::user();
    $etapaPlan = EtapasPlan::where('id_institucion',$user->id_institucion)->where('valor_campo_etapa', 'PTDI')->first();

    if($request->id_objetivo == 0){
        try{
            $objetivo = new ObjetivosEta();
            $objetivo->nombre_objetivo = $request->nombre_objetivo;
            $objetivo->id_accion_eta = $request->id_acciones_eta_mediano_plazo;
            $objetivo->id_etapas_plan = $etapaPlan->id;
            $objetivo->id_categoria_accion = $request->categoria_accion;
            $objetivo->desagregado = $request->detalleEta;
            if($objetivo->desagregado){
              $objetivo->tipo_objetivo = $request->tipo_objetivo;
              $objetivo->nombre_objetivo = $request->nombre_objetivo;
              $objetivo->codigo_sisin = $request->codigo_sisin;
            }else{
              $objetivo->tipo_objetivo = "";
              $objetivo->nombre_objetivo = "";
              $objetivo->codigo_sisin = "";
            }
            $objetivo->activo = true;
            $objetivo->id_user_created = $user->id;
            $objetivo->save();


            $articulacion = new ArticulacionObjetivosIndicador();
            $articulacion->id_objetivo_eta = $objetivo->id;
            $articulacion->id_indicador = $request->indicador;
            $articulacion->indicador_cantidad = $request->indicador_cantidad;
            $articulacion->linea_base_descripcion = $request->linea_base_descripcion;
            $articulacion->linea_base_unidad = $request->linea_base_unidad;
            $articulacion->linea_base_cantidad = $request->linea_base_cantidad;
            $articulacion->activo = true;
            $articulacion->id_user_created = $user->id;
            $articulacion->save();
            foreach ($request->programacion_indicador as $k => $v) {
                $programacion = new ProgramacionIndicador();
                $programacion->id_articulacion_objetivo_indicador = $articulacion->id;
                $programacion->gestion = $periodoActual['gestionesPeriodo'][$k];
                $programacion->valor = ($v!='')?$this->format_numerica_db($v,$this->decimal_simbolo($v)):0;
                $programacion->activo = true;
                $programacion->id_user_created = $user->id;
                $programacion->save();
            }

            foreach ($request->programacion_recursos as $k => $v) {
                $recursos = new ProgramacionRecursos();
                $recursos->id_articulacion_objetivo_indicador = $articulacion->id;
                $recursos->gestion = $periodoActual['gestionesPeriodo'][$k];
                $recursos->monto = ($v!='')?$this->format_numerica_db($v,$this->decimal_simbolo($v)):0;
                $recursos->activo = true;
                $recursos->id_user_created = $user->id;
                $recursos->save();
            }

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'alert' => "success",
                'msg' => "Se guardo con exito.")
            );

        }
        catch (Exception $e) {
            return \Response::json(array(
              'error' => true,
              'title' => "Error!",
              'alert' => "error",
              'msg' => $e->getMessage())
            );
        }
    }else{
        try{

          $objetivo = ObjetivosEta::find($request->id_objetivo);
          $objetivo->id_accion_eta = $request->id_acciones_eta_mediano_plazo;
          $objetivo->desagregado = $request->detalleEta;
          if($objetivo->desagregado){
            $objetivo->tipo_objetivo = $request->tipo_objetivo;
            $objetivo->nombre_objetivo = $request->nombre_objetivo;
            $objetivo->codigo_sisin = $request->codigo_sisin;
          }else{
            $objetivo->tipo_objetivo = "";
            $objetivo->nombre_objetivo = "";
            $objetivo->codigo_sisin = "";
          }
          $objetivo->id_user_updated = $user->id;
          $objetivo->save();


          $articulacion = ArticulacionObjetivosIndicador::find($request->id_articulacion);
          $articulacion->id_indicador = $request->indicador;
          $articulacion->indicador_cantidad = $request->indicador_cantidad;
          $articulacion->linea_base_descripcion = $request->linea_base_descripcion;
          $articulacion->linea_base_unidad = $request->linea_base_unidad;
          $articulacion->linea_base_cantidad = $request->linea_base_cantidad;
          $articulacion->id_user_updated = $user->id;
          $articulacion->save();


          foreach ($request->ids_programacion_indicador as $k => $v) {
              $programacion = ProgramacionIndicador::find($v);
              $programacion->gestion = $periodoActual['gestionesPeriodo'][$k];
              $programacion->valor = ($request->programacion_indicador[$k]!='')?$this->format_numerica_db($request->programacion_indicador[$k],$this->decimal_simbolo($request->programacion_indicador[$k])):0;
              $programacion->id_user_updated = $user->id;
              $programacion->save();
          }



          foreach ($request->ids_programacion_recursos as $k => $v) {
              $recursos = ProgramacionRecursos::find($v);
              $recursos->gestion = $periodoActual['gestionesPeriodo'][$k];
              $recursos->monto = ($request->programacion_recursos[$k]!='')?$this->format_numerica_db($request->programacion_recursos[$k],$this->decimal_simbolo($request->programacion_recursos[$k])):0;
              $recursos->id_user_updated = $user->id;
              $recursos->save();
          }

          return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'alert' => "success",
                'msg' => "Se guardo con exito.")
          );

        }
        catch (Exception $e) {
            return \Response::json(array(
              'error' => true,
              'title' => "Error!",
              'alert' => "error",
              'msg' => $e->getMessage())
            );
        }

    }

  }

  public function deleteObjetivo(Request $request)
  {
    $user = \Auth::user();
    $etapaPlan = EtapasPlan::where('id_institucion',$user->id_institucion)->where('valor_campo_etapa', 'PTDI')->first();

    try{
          $objetivo = ObjetivosEta::find($request->id_objetivo);
          $objetivo->activo = false;
          $objetivo->save();

          ArticulacionObjetivosIndicador::where('id_objetivo_eta',$request->id_objetivo)
                                         ->update(['activo'=>false]);
          $articulacionId = ArticulacionObjetivosIndicador::where('id_objetivo_eta',$request->id_objetivo)->get();

          foreach ($articulacionId as $value) {
            ProgramacionIndicador::where('id_articulacion_objetivo_indicador',$value->id)
                        ->update(['activo'=>false]);

            ProgramacionRecursos::where('id_articulacion_objetivo_indicador',$value->id)
                        ->update(['activo'=>false]);
          }
          return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'alert' => "success",
                'msg' => "Se elimino con exito.")
          );

        }
        catch (Exception $e) {
            return \Response::json(array(
              'error' => true,
              'title' => "Error!",
              'alert' => "error",
              'msg' => $e->getMessage())
            );
        }

  }

  public function verificarEtapaCategoria(Request $request)
  {
        $periodoActual = $this->periodoActual();
        $user = \Auth::user();
        switch ($request->categoria) {
          case 1:
              $etapasEstado = EtapasPlan::where('valor_campo_etapa', 'RPV')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan',$periodoActual['periodoId'])->get();
              if($etapasEstado->count() > 0){
                if($etapasEstado[0]->estado_etapa != 'Concluido'){
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 2,
                      'categoria' => 'RPV',
                      'msg' => "Ingresar a Modificar.")
                  );
                }else{
                  return \Response::json(array(
                      'error' => false,
                      'accion' => 3,
                      'categoria' => 'RPV',
                      'msg' => "No puede modificar, categoria concluida.")
                  );
                }
              }else{
                return \Response::json(array(
                    'error' => true,
                    'accion' => 1,
                    'categoria' => 'RPV',
                    'msg' => "Activar el Cargado de la Categoria.")
                );
              }
          break;
          case 4:
           $etapaAnterior = EtapasPlan::where('valor_campo_etapa', 'RPV')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->where('estado_etapa', 'Concluido')->get();
            if($etapaAnterior->count() > 0)
            {
                $etapasEstado = EtapasPlan::where('valor_campo_etapa', 'AL')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->get();
                if($etapasEstado->count() > 0){
                  if($etapasEstado[0]->estado_etapa != 'Concluido'){
                    return \Response::json(array(
                        'error' => false,
                        'accion' => 2,
                        'categoria' => 'AL',
                        'msg' => "Ingresar a Modificar.")
                    );
                  }else{
                    return \Response::json(array(
                        'error' => false,
                        'accion' => 3,
                        'categoria' => 'AL',
                        'msg' => "No puede modificar, categoria concluida.")
                    );
                  }
                }else{
                  return \Response::json(array(
                      'error' => true,
                      'accion' => 1,
                      'categoria' => 'AL',
                      'msg' => "Activar el Cargado de la Categoria.")
                  );
                }
            }else{
              return \Response::json(array(
                  'error' => true,
                  'accion' => 0,
                  'categoria' => 'AL',
                  'msg' => "Debe concluir la categoria anterior para continuar.")
              );
            }
          break;
          case 24:
           $etapaAnterior = EtapasPlan::where('valor_campo_etapa', 'AL')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->where('estado_etapa', 'Concluido')->get();
            if($etapaAnterior->count() > 0)
            {
                $etapasEstado = EtapasPlan::where('valor_campo_etapa', 'PPAP-ETA')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->get();
                if($etapasEstado->count() > 0){
                  if($etapasEstado[0]->estado_etapa != 'Concluido'){
                    return \Response::json(array(
                        'error' => false,
                        'accion' => 2,
                        'categoria' => 'PPAP-ETA',
                        'msg' => "Ingresar a Modificar.")
                    );
                  }else{
                    return \Response::json(array(
                        'error' => false,
                        'accion' => 3,
                        'categoria' => 'PPAP-ETA',
                        'msg' => "No puede modificar,categoria concluida.")
                    );
                  }
                }else{
                  return \Response::json(array(
                      'error' => true,
                      'accion' => 1,
                      'categoria' => 'PPAP-ETA',
                      'msg' => "Activar el Cargado de la Categoria.")
                  );
                }
            }else{
              return \Response::json(array(
                  'error' => true,
                  'accion' => 0,
                  'categoria' => 'PPAP-ETA',
                  'msg' => "Debe concluir la categoria anterior para continuar.")
              );
            }
          break;
          case 25:
          $etapaAnterior = EtapasPlan::where('valor_campo_etapa', 'PPAP-ETA')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->where('estado_etapa', 'Concluido')->get();
           if($etapaAnterior->count() > 0)
           {
               $etapasEstado = EtapasPlan::where('valor_campo_etapa', 'PCGF')->where('id_institucion', $user->id_institucion)->where('id_periodo_plan', $periodoActual['periodoId'])->get();
               if($etapasEstado->count() > 0){
                 if($etapasEstado[0]->estado_etapa != 'Concluido'){
                   return \Response::json(array(
                       'error' => false,
                       'accion' => 2,
                       'categoria' => 'PCGF',
                       'msg' => "Ingresar a Modificar.")
                   );
                 }else{
                   return \Response::json(array(
                       'error' => false,
                       'accion' => 3,
                       'categoria' => 'PCGF',
                       'msg' => "No puede modificar,categoria concluida.")
                   );
                 }
               }else{
                 return \Response::json(array(
                     'error' => true,
                     'accion' => 1,
                     'categoria' => 'PCGF',
                     'msg' => "Activar el Cargado de la Categoria.")
                 );
               }
           }else{
             return \Response::json(array(
                 'error' => true,
                 'accion' => 0,
                 'categoria' => 'PCGF',
                 'msg' => "Debe concluir la categoria anterior para continuar.")
             );
           }
          break;
        }

  }

  public function activarCategoria(Request $request)
  {
        $periodoActual = $this->periodoActual();
        $user = \Auth::user();
        $etapa = new EtapasPlan();
        $etapa->id_institucion = $user->id_institucion;
        $etapa->campo_etapa = 'grupo';
        $etapa->valor_campo_etapa = $request->categoria;
        $etapa->descripcion_campo_etapa = 'Este registro ayuda a controlar el estado del modulo de Recursos de un periodo';
        $etapa->estado_etapa = "En Elaboración";
        $etapa->id_periodo_plan =  $periodoActual['periodoId'];
        $etapa->save();
        return \Response::json(array(
            'error' => false,
            'accion' => 1,
            'msg' => "Se activo el control de estados del módulo seleccionado.")
        );
  }
  public function finalizarCategoria(Request $request)
  {
      $periodoActual = $this->periodoActual();
      $user = \Auth::user();
      $categoria = CategoriasAccion::where('id', $request->categoria)->first();
      \DB::table('sp_eta_etapas_plan')->where('id_institucion', $user->id_institucion)->where('valor_campo_etapa', $categoria->sigla)->where('id_periodo_plan',  $periodoActual['periodoId'])->update(['estado_etapa' => 'Concluido']);
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'alert' => "success",
          'msg' => "Se Cambio la etapa con exito.")
      );
  }
}
