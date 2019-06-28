<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlanificacionTerritorial\Parametros;
use App\Models\PlanificacionTerritorial\Recursos;
use App\Models\PlanificacionTerritorial\OtrosIngresos;
use App\Models\PlanificacionTerritorial\DB;
use App\Models\PlanificacionTerritorial\SeguimientoGestiones;
use App\Models\PlanificacionTerritorial\ProyectoPoa;
use App\Models\PlanificacionTerritorial\ProyectoInversion;
use App\Models\PlanificacionTerritorial\EntidadesConcurrencia;
use App\Models\PlanificacionTerritorial\GestionRiesgos;
use App\Models\PlanificacionTerritorial\EvaluacionReporteRecursos;
use App\Models\PlanificacionTerritorial\EvaluacionReporteFinanciero;





class EvaluacionController extends BasecontrollerController
{
  public function evaluacionListaRecursos(Request $request)
  {
      
      $user = \Auth::user();
      $parametros = Parametros::where('categoria', 'tipo_recursos')
      ->where('activo', true)
      ->orderBy('orden', 'ASC')
      ->get();

      $filas = [];
      $total_gestion_2016 = 0;
      $total_gestion_2017 = 0;
      $total_gestion_2018 = 0;
      $total_gestion_poa_2016 = 0;
      $total_gestion_poa_2017 = 0;
      $total_gestion_poa_2018 = 0;
      $total_diferencia_a_poa = 0;
      $total_diferencia_porcentaje_a_poa = 0;
      $total_planificacion_ptdi = 0;
      $total_planificacion_poa = 0;

      $recurso = \DB::select("select DISTINCT id_tipo_recurso as recurso, nombre  from sp_eta_recursos_eta as r,sp_parametros as p
          where r.id_institucion =  $user->id_institucion
          and r.activo = true
          and r.id_tipo_recurso = p.id 
          and categoria = 'tipo_recursos'");

      $i=0;

      foreach ($recurso as $r) {
        $filas[$i]['recurso'] = $r->nombre;
        $filas[$i]['recurso_id'] = $r->recurso;
        $planificacion = \DB::select("select 
          id_institucion,
          id_tipo_recurso,
          gestion,
          monto
        from sp_eta_recursos_eta
        where id_institucion = $user->id_institucion
        and gestion in (2016,2017,2018)
        and id_tipo_recurso = $r->recurso");

        $total_planificacion = 0;

        foreach ($planificacion as $p) {
          if($p->gestion == 2016){
            $filas[$i]['planificacion_2016'] = $p->monto;
            $total_planificacion = $total_planificacion + $p->monto;
            $total_gestion_2016 = $total_gestion_2016 + $p->monto;
          }/*else{
            $filas[$i]['planificacion_2016'] = "";
          }*/
          if($p->gestion == 2017){
            $filas[$i]['planificacion_2017'] = $p->monto;
            $total_planificacion = $total_planificacion + $p->monto;
            $total_gestion_2017 = $total_gestion_2016 + $p->monto;
          }/*else{
            $filas[$i]['planificacion_2017'] = "";
          }*/
          if($p->gestion == 2018){
            $filas[$i]['planificacion_2018'] = $p->monto;
            $total_planificacion = $total_planificacion + $p->monto;
            $total_gestion_2018 = $total_gestion_2016 + $p->monto;
          }/*else{
            $filas[$i]['planificacion_2018'] = "";
          }*/

        }

        $filas[$i]['total_planificacion'] = $total_planificacion;
        /************hasta aqui la planificacion*****************/
        /************EMPIEZA POA*****************/
        $gestion_poa = \DB::select("select 
                                  id_institucion,
                                  id_tipo_recurso,
                                  gestion,
                                  monto_poa_gestion
                            from sp_eta_recursos_poa
                            where id_institucion =  $user->id_institucion
                            and gestion in (2016,2017,2018)
                            and id_tipo_recurso = $r->recurso");
        $total_poa = 0;
        if($gestion_poa){
          foreach ($gestion_poa as $poa) {
          
            if($poa->gestion == 2016){
              $filas[$i]['poa_2016'] = $poa->monto_poa_gestion;
              $total_poa = $total_poa + $poa->monto_poa_gestion;
              $total_gestion_poa_2016 = $total_gestion_poa_2016 + $poa->monto_poa_gestion;
            }else{
              $filas[$i]['poa_2016'] = 0;
            }
            if($poa->gestion == 2017){
              $filas[$i]['poa_2017'] = $poa->monto;
              $total_poa = $total_poa + $poa->monto_poa_gestion;
              $total_gestion_poa_2017 = $total_gestion_poa_2017 + $poa->monto_poa_gestion;
            }else{
              $filas[$i]['poa_2017'] = 0;
            }

            if($poa->gestion == 2018){
              $filas[$i]['poa_2018'] = $poa->monto_poa_gestion;
              $total_poa = $total_poa + $poa->monto_poa_gestion;
              $total_gestion_poa_2018 = $total_gestion_poa_2018 + $poa->monto_poa_gestion;
            }else{
              $filas[$i]['poa_2018'] = 0;
            }

          }
        }else{

            $filas[$i]['poa_2016'] = 0;
            $total_poa = $total_poa + 0;
            $total_gestion_poa_2016 = $total_gestion_poa_2016 + 0;
            $filas[$i]['poa_2017'] = 0;
            $total_poa = $total_poa + 0;
            $total_gestion_poa_2017 = $total_gestion_poa_2017 + 0;
            $filas[$i]['poa_2018'] = 0;
            $total_poa = $total_poa + 0;
            $total_gestion_poa_2018 = $total_gestion_poa_2018 + 0;

        }

        

        $total_planificacion_ptdi = $total_planificacion_ptdi + $total_planificacion;
        $total_planificacion_poa = $total_planificacion_poa + $total_poa;

        $filas[$i]['total_poa'] = $total_poa;
        $filas[$i]['diferencia_a_poa'] = $total_planificacion - $total_poa;
        if($total_poa>0){
          $filas[$i]['diferencia_porcentaje_a_poa'] = (($total_planificacion - $total_poa)  / $total_planificacion)*100;
        }else{
          $filas[$i]['diferencia_porcentaje_a_poa'] = 0;
        }

        $total_diferencia_a_poa = $total_diferencia_a_poa + $filas[$i]['diferencia_a_poa'];
        $total_diferencia_porcentaje_a_poa = $total_diferencia_porcentaje_a_poa + $filas[$i]['diferencia_porcentaje_a_poa'] ;

        $recurso_comentario = \DB::select("select causas_de_variacion from sp_eta_evaluacion_reporte_recursos
                                                                where id_institucion = $user->id_institucion
                                                                and id_recurso = $r->recurso");
     
        //dd($recurso_comentario);
        if($recurso_comentario){
          $filas[$i]['input']=$recurso_comentario[0]->causas_de_variacion; 
        }else{
          $filas[$i]['input']=""; 
        }
       
        $filas[$i]['clase']="";
        $filas[$i]['mensaje']="";
        

        $i++;

      }/*Fin foreach recurso*/
      $totales = [];
      $totales['total_gestion_2016'] = $total_gestion_2016;
      $totales['total_gestion_2017'] = $total_gestion_2017;
      $totales['total_gestion_2018'] = $total_gestion_2018;
      
      $totales['total_gestion_poa_2016'] = $total_gestion_poa_2016;
      $totales['total_gestion_poa_2017'] = $total_gestion_poa_2017;
      $totales['total_gestion_poa_2018'] = $total_gestion_poa_2018;
      $totales['total_diferencia_a_poa'] = $total_diferencia_a_poa;
      $totales['total_diferencia_porcentaje_a_poa'] = $total_diferencia_porcentaje_a_poa;
      $totales['totales_planificacion_ptdi'] = $total_planificacion_ptdi;
      $totales['totales_planificacion_poa'] = $total_planificacion_poa;
      return \Response::json([
        'filas' => $filas,
        'totales' => $totales
      ]);
  }
 
  public function evaluacionListaAcciones(Request $request){

    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    $gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first();
    $user = \Auth::user();
    
    $objetivo_indicador = \DB::select("select 
                                            obj.id,
                                            obj.nombre_objetivo as nombre_accion_eta,
                                            obj.id_accion_eta,
                                            pdes.codigo_pdes as codigo_pdes
                                          from sp_eta_etapas_plan as plan,
                                               sp_eta_objetivos_eta as obj,
                                               sp_eta_articulacion_catalogos as pdes
                                          where plan.id_institucion = $user->id_institucion
                                          and plan.valor_campo_etapa = 'PTDI'
                                          and plan.id = obj.id_etapas_plan
                                          and obj.id_accion_eta = pdes.id_accion_eta
                                          and pdes.activo = true");
    //dd($objetivo_indicador);
    foreach ($objetivo_indicador as $obj) {

      $pmra=explode(".",$obj->codigo_pdes);
      $pilar = $pmra[0];

      $meta = $pmra[1];
      $resultado = $pmra[2];
      $accion = $pmra[3];

       $arrayPmra =[];
       //pilar
      $p = \DB::select("select * from pdes_pilares
                        where cod_p = ".$pilar."");

      $id_pilar = $p[0]->id;
      //meta

      $m = \DB::select("select * from pdes_metas
                        where id_pilar = ".$id_pilar."
                        and cod_m =".$meta."");
      $id_meta = $m[0]->id;

      //resultados

      $r = \DB::select("select * from pdes_resultados
                          where id_meta = ".$id_meta."
                          and cod_r = ".$resultado."");
      $id_resultado = $r[0]->id;


      $a = \DB::select("select * from pdes_acciones
                          where id_resultado = ".$id_resultado."
                          and cod_a=".$accion."");


      $obj->cod_p = $p[0]->cod_p;
      $obj->nombre_p = $p[0]->nombre;
      $obj->descripcion_p = $p[0]->descripcion;
      $obj->logo_p = $p[0]->logo;

      $obj->cod_m = $m[0]->cod_m;
      $obj->nombre_m = $m[0]->nombre;
      $obj->descripcion_m = $m[0]->descripcion;

      $obj->cod_r = $r[0]->cod_r;
      $obj->nombre_r = $r[0]->nombre;
      $obj->descripcion_r = $r[0]->descripcion;

      $obj->cod_a = $a[0]->cod_a;
      $obj->nombre_a = $a[0]->nombre;
      $obj->descripcion_a = $a[0]->descripcion;

      
      $gestiones =[2016,2017,2018];
      $poa = ProyectoPoa::where('id_accion_eta',$obj->id)
                          ->where('id_institucion',$user->id_institucion)
                          ->whereIn('gestion',$gestiones)
                          ->where('activo',true)
                          ->get();

      $obj->poa = $poa;
    }
    return \Response::json(['objEta'=>$objetivo_indicador]);
  }
  public function evaluacionListaFinanciero(){
    $user = \Auth::user();
    $id_institucion= $user->id_institucion;
   
    $accion_eta = \DB::select("select 
      
                                    objetivos.id as id_objetivos,
                                    objetivos.nombre_objetivo as catalogo_accion_eta,
                                    objetivo_indicador.id_indicador ,
                                    CONCAT (objetivo_indicador.linea_base_cantidad,'',objetivo_indicador.linea_base_unidad,'',objetivo_indicador.linea_base_descripcion) as linea_base,
                                    objetivo_indicador.indicador_cantidad,
                                    objetivo_indicador.id as id_objetivo_indicador,
                                    indicadores.nombre_indicador as descripcion_indicador,
                                    indicadores.unidad as unidad_indicador
                                    
                                from sp_eta_etapas_plan as planes, 
                                    sp_eta_objetivos_eta as objetivos,
                                    sp_eta_articulacion_objetivo_indicador as objetivo_indicador,
                                    sp_eta_indicadores as indicadores
                                    
                                where planes.id_institucion = $user->id_institucion
                                and planes.valor_campo_etapa = 'PTDI'
                                and objetivos.id_etapas_plan = planes.id
                                and objetivos.id = objetivo_indicador.id_objetivo_eta
                                and objetivo_indicador.id_indicador = indicadores.id");
    //dd($accion_eta);

    $total_recurso_programado = 0;
    $total_indicador_programado = 0;
    foreach($accion_eta as $f) {
      
      $programacion_recurso = \DB::select("select pro_recurso.id_articulacion_objetivo_indicador,
                                        pro_recurso.gestion as recurso_gestion,
                                        pro_recurso.monto as recurso_monto
                                from sp_eta_programacion_recursos as pro_recurso 
                                where pro_recurso.id_articulacion_objetivo_indicador = $f->id_objetivo_indicador
                                and pro_recurso.gestion in ('2016','2017','2018') ");
      //hallando la PROGRAMACION
      foreach ($programacion_recurso as $pro) {
        if($pro->recurso_gestion == '2016'){
          $f->recurso_gestion_2016 = $pro->recurso_monto;
          $total_recurso_programado = $total_recurso_programado + $pro->recurso_monto;
        }else{
          $f->recurso_gestion_2016 = 0;
        }
        if($pro->recurso_gestion == '2017'){
          $f->recurso_gestion_2017 = $pro->recurso_monto;
          $total_recurso_programado = $total_recurso_programado + $pro->recurso_monto;
        }else{
          $f->recurso_gestion_2017 = 0;
        }
        if($pro->recurso_gestion == '2018'){
          $f->recurso_gestion_2018 = $pro->recurso_monto;
          $total_recurso_programado = $total_recurso_programado + $pro->recurso_monto;
        }else{
          $f->recurso_gestion_2018 = 0;
        }
      }
      $programacion_indicador = \DB::select("select  pro_indicador.id_articulacion_objetivo_indicador,
                                                  pro_indicador.gestion as indicador_gestion,
                                                  pro_indicador.valor as indicador_valor
                                          from sp_eta_programacion_indicador as pro_indicador
                                          where pro_indicador.id_articulacion_objetivo_indicador = $f->id_objetivo_indicador
                                          and pro_indicador.gestion in('2016','2017','2018') ");
      foreach ($programacion_indicador as $indi) {
          
          if($indi->indicador_gestion == '2016'){
            $f->indicador_gestion_2016 = $indi->indicador_valor;
            $total_indicador_programado = $total_indicador_programado + $indi->indicador_valor;
          }else{
            $f->indicador_gestion_2016 = 0;
          }
          if($indi->indicador_gestion == '2017'){
            $f->indicador_gestion_2017 = $indi->indicador_valor;
            $total_indicador_programado = $total_indicador_programado + $indi->indicador_valor;
          }else{
            $f->recurso_gestion_2017 = 0;
          }
          if($indi->indicador_gestion == '2018'){
            $f->indicador_gestion_2018 = $indi->indicador_valor;
            $total_indicador_programado = $total_indicador_programado + $indi->indicador_valor;
          }else{
            $f->indicador_gestion_2018 = 0;
          }
      }
      //hallando la EJECUCION EN EL POA
      $total_recurso_poa = 0;
      $total_indicador_poa = 0;
      $poa = \DB::select("select gestion as poa_gestion,
                                  monto_poa_ejecutado,
                                  accion_poa_ejecutado 

                          from sp_eta_financiero_poa
                          where id_intitucion = $user->id_institucion
                          and gestion in (2016,2017,2018)
                          and id_accion_eta = $f->id_objetivos");
      if($poa){
        foreach ($poa as $eje) {
          if($eje->poa_gestion == 2016){
            $f->recurso_poa_2016 = $eje->monto_poa_ejecutado;
            $total_recurso_poa = $total_recurso_poa + $eje->monto_poa_ejecutado;

            $f->indicador_poa_2016 = $eje->accion_poa_ejecutado;
            $total_indicador_poa = $total_indicador_poa + $eje->accion_poa_ejecutado;
          }else{
            $f->recurso_poa_2016 = 0;
            $f->indicador_poa_2016 = 0;
          }
          if($eje->poa_gestion == 2017){
            $f->recurso_poa_2017 = $eje->monto_poa_ejecutado;
            $total_recurso_poa = $total_recurso_poa + $eje->monto_poa_ejecutado;
            $f->indicador_poa_2016 = $eje->accion_poa_ejecutado;
            $total_indicador_poa = $total_indicador_poa + $eje->accion_poa_ejecutado;
          }else{
            $f->recurso_poa_2017 = 0;
            $f->indicador_poa_2017 = 0;
          }
          if($eje->poa_gestion == 2018){
            $f->recurso_poa_2018 = $eje->monto_poa_ejecutado;
            $total_recurso_poa = $total_recurso_poa + $eje->monto_poa_ejecutado;
            $f->indicador_poa_2016 = $eje->accion_poa_ejecutado;
            $total_indicador_poa = $total_indicador_poa + $eje->accion_poa_ejecutado;
          }else{
            $f->recurso_poa_2018 = 0;
            $f->indicador_poa_2018 = 0;
          }
        }
      }else{
        $f->recurso_poa_2016 = 0;
        $f->indicador_poa_2016 = 0;
        $f->recurso_poa_2017 = 0;
        $f->indicador_poa_2017 = 0;
        $f->recurso_poa_2018 = 0;
        $f->indicador_poa_2018 = 0;
      }
      
      


        $f->total_recurso_programado = $total_recurso_programado;
        $f->total_indicador_programado = $total_indicador_programado;
        $f->total_recurso_poa = $total_recurso_poa;
        $f->total_indicador_poa = $total_indicador_poa;

        //Metas al 2020
        $meta_recurso_2020 = \DB::select("select sum(monto) as meta_recurso_2020 
                                                  from sp_eta_programacion_recursos
                                                  where id_articulacion_objetivo_indicador = $f->id_objetivo_indicador");
        $meta_indicador_2020 = \DB::select("select sum(valor) as meta_indicador_2020 
                                                  from sp_eta_programacion_indicador
                                                  where id_articulacion_objetivo_indicador = $f->id_objetivo_indicador");
        $f->meta_recurso_2020 = $meta_recurso_2020[0]->meta_recurso_2020;
        $f->meta_indicador_2020 = $meta_indicador_2020[0]->meta_indicador_2020;
        //calcualdo porcentuales
        //porcentaje ejecutado = ejecutado/sobre programado
        $f->recurso_porcentaje_ejecutado = ($total_recurso_poa / $total_recurso_programado)*100;
        $f->recurso_porcentaje_ejecutado_meta_2020 = ($total_recurso_poa / $meta_recurso_2020[0]->meta_recurso_2020)*100;
        $f->indicador_porcentaje_ejecutado = ($total_indicador_poa / $total_indicador_programado)*100;
        $f->indicador_porcentaje_ejecutado_meta_2020 = ($total_indicador_poa / $meta_indicador_2020[0]->meta_indicador_2020)*100;
        //incluyendo COMENTARIO DE AXION ETA
        $comentario = \DB::select("select * from sp_eta_evaluacion_reporte_financiero
                                            where id_institucion = $user->id_institucion
                                            and id_accion_eta = $f->id_objetivos
                                            and activo = true");
        //dd($comentario);
        if($comentario){
          $f->input = $comentario[0]->causas_de_variacion;

        }else{
          $f->input = "";
        }
        $f->clase = "";
        $f->comentario ="";
    }
    //dd($accion_eta);
    return \Response::json(array('financiero'=>$accion_eta));
  }
  public function evaluacionListaInversion(){
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    $gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first();

    $user = \Auth::user();
    $gestiones = [2016,2017,2018];
    
    //SELECCIONANDO LAS ACCIONES ETA DE INVERSION
    $objetivoProyectos = \DB::select("select obj.id as id_accion_eta,
                                            obj.nombre_objetivo as nombre_accion_eta
                                    from sp_eta_etapas_plan as plan,
                                          sp_eta_objetivos_eta as obj
                                    where id_institucion = $user->id_institucion
                                    and valor_campo_etapa = 'PTDI'
                                    and obj.id_etapas_plan = plan.id
                                    and id_categoria_accion in (2,3)");
    
    foreach ($objetivoProyectos as $obj) {
      $poa = ProyectoPoa::where('id_accion_eta',$obj->id_accion_eta)
                          ->where('id_institucion',$user->id_institucion)
                          ->whereIn('gestion',$gestiones)
                          ->where('activo',true)
                          ->whereNotNull('codigo_sisin')
                          ->get();
                          
      foreach ($poa as $p) {
        /*$inv = ProyectoInversion::where('id_proyecto_poa',$p->id)
                            ->where('id_institucion',$user->id_institucion)
                            ->where('activo',true)
                            ->get();*/
        $inv = \DB::select("select * 
                            from sp_eta_proyectos_inversion
                            where id_institucion = $user->id_institucion
                            and id_proyecto_poa = $p->id");
          //dd($inv);
                            //dd('Inversion',$inv->count());
              $total_programado = 0;
              $total_ejecutado = 0;              
          if($inv){
            //dd('costo',$inv->costo_total_proyecto);
            $p->id_proyecto_inversion = $inv[0]->id;
            $p->costo_total_proyecto = $inv[0]->costo_total_proyecto;
            $p->periodo_ejecucion_al = $inv[0]->periodo_ejecucion_al;
            $p->periodo_ejecucion_del = $inv[0]->periodo_ejecucion_del;
            $p->concurrencia_eta_programado = $inv[0]->concurrencia_eta_programado;
            $p->concurrencia_eta_ejecutado = $inv[0]->concurrencia_eta_ejecutado;
            $p->concurrencia_porcentaje_ejecutado = $inv[0]->concurrencia_porcentaje_ejecutado;
            $p->entidad_ejecutora_cod = $inv[0]->entidad_ejecutora_cod;
            $p->entidad_ejecutora_denominacion = $inv[0]->entidad_ejecutora_denominacion;
            $p->verificar_existe_proyectos_inversion = "si hay";
            if($p->gestion = 2016){

              $p->programado_2016 = $inv[0]->concurrencia_eta_programado;
              $p->ejecutado_2016 = $inv[0]->concurrencia_eta_ejecutado;
              $total_programado = $total_programado + $inv[0]->concurrencia_eta_programado;
              $total_ejecutado =  $total_ejecutado  + $inv[0]->concurrencia_eta_ejecutado;              
            }
            if($p->gestion = 2017){

              $p->programado_2017 = $inv[0]->concurrencia_eta_programado;
              $p->ejecutado_2017 = $inv[0]->concurrencia_eta_ejecutado;
              $total_programado = $total_programado + $inv[0]->concurrencia_eta_programado;
              $total_ejecutado =  $total_ejecutado  + $inv[0]->concurrencia_eta_ejecutado;              
            }
            if($p->gestion = 2018){

              $p->programado_2018 = $inv[0]->concurrencia_eta_programado;
              $p->ejecutado_2018 = $inv[0]->concurrencia_eta_ejecutado;
              $total_programado = $total_programado + $inv[0]->concurrencia_eta_programado;
              $total_ejecutado =  $total_ejecutado  + $inv[0]->concurrencia_eta_ejecutado;              
            }

            $p->total_programado = $total_programado;
            $p->total_ejecutado = $total_ejecutado;
            $p->total_porcentaje_ejecutado = ($total_ejecutado/$total_programado)*100;
 

            $ent = \DB::select('select id_proyecto_inversion,
                                      sum(programacion_entidad) as programado,
                                      sum(ejecucion_entidad) as ejecutado
                                from sp_eta_entidades_concurrencia
                                where id_proyecto_inversion = '.$inv[0]->id_proyecto_poa.'
                                and id_institucion =  '.$user->id_institucion.'
                                and gestion in (2016,2017,2018)
                                and activo = true
                                GROUP BY (id_proyecto_inversion)');
            if($ent){
              $p->concurrencia_entidades_programado = $ent[0]->programado;
              $p->concurrencia_entidades_ejecutado = $ent[0]->ejecutado;
              $p->concurrencia_entidades_porcentaje_ejecutado = ($ent[0]->ejecutado/$ent[0]->programado)*100;  
            }else{
              $p->concurrencia_entidades_programado = 0;
              $p->concurrencia_entidades_ejecutado = 0;
              $p->concurrencia_entidades_porcentaje_ejecutado = 0;
              
            }
            
            

            //META AL 2020
            $objetivo_indicador = \DB::select("select id from sp_eta_articulacion_objetivo_indicador
                                                where id_objetivo_eta = $obj->id_accion_eta");

            $id_objetivo_indicador =  $objetivo_indicador[0]->id;
            //57
            $meta_recurso_2020 = \DB::select("select sum(monto) as meta_recurso_2020 
                                                  from sp_eta_programacion_recursos
                                                  where id_articulacion_objetivo_indicador = $id_objetivo_indicador");
            //dd($objetivo_indicador);
            $p->meta_recurso_2020 = $meta_recurso_2020[0]->meta_recurso_2020;
            $p->concurrencia_entidades_porcentaje_al_2020 = ($p->concurrencia_entidades_ejecutado/$meta_recurso_2020[0]->meta_recurso_2020)*100;                            
            
          }else{
            $p->verificar_existe_proyectos_inversion = "no hay";
          }
        
      }

      
      $obj->proyectosInversion = $poa;
    }


    return \Response::json(['objetivoInversion'=>$objetivoProyectos]);
  }
  public function evaluacionListaRiesgos(){
    
    $user = \Auth::user();
    $id_institucion= $user->id_institucion;
   
    //dd($accion_eta);
    $accion_eta = \DB::select("select 
                                      objetivos.id as id_objetivos,
                                      objetivos.nombre_objetivo as catalogo_accion_eta,
                                      objetivos.id_accion_eta as accion_catalogo,
                                      objetivo_indicador.id_indicador,
                                      concat(objetivo_indicador.linea_base_cantidad,'',objetivo_indicador.linea_base_unidad,'',objetivo_indicador.linea_base_descripcion) as linea_base,
                                      objetivo_indicador.indicador_cantidad,
                                      objetivo_indicador.id as id_objetivo_indicador,
                                      indicadores.nombre_indicador as descripcion_indicador,
                                      indicadores.unidad as unidad_indicador,
                                      riesgos.id as id_riesgos,
                                      riesgos.es_gestion_riesgos as es_riesgo
                                  from sp_eta_etapaS_plan as planes, 
                                      sp_eta_objetivos_eta as objetivos,
                                      sp_eta_articulacion_objetivo_indicador as objetivo_indicador,
                                      sp_eta_indicadores as indicadores,
                                      sp_eta_gestion_riesgos as riesgos
                                  where planes.id_institucion = $user->id_institucion
                                  and planes.valor_campo_etapa = 'PTDI'
                                  and objetivos.id = objetivo_indicador.id_objetivo_eta
                                  and objetivo_indicador.id_indicador = indicadores.id
                                  and objetivos.id = riesgos.id_accion_eta
                                  and riesgos.activo = true");
    $total_recurso_programado = 0;
    $total_indicador_programado = 0;
    foreach($accion_eta as $f) {
      
      $programacion_recurso = \DB::select("select pro_recurso.id_articulacion_objetivo_indicador,
                                        pro_recurso.gestion as recurso_gestion,
                                        pro_recurso.monto as recurso_monto
                                from sp_eta_programacion_recursos as pro_recurso 
                                where pro_recurso.id_articulacion_objetivo_indicador = $f->id_objetivo_indicador
                                and pro_recurso.gestion in ('2016','2017','2018') ");
      //hallando la PROGRAMACION
      foreach ($programacion_recurso as $pro) {
        if($pro->recurso_gestion == '2016'){
          $f->recurso_gestion_2016 = $pro->recurso_monto;
          $total_recurso_programado = $total_recurso_programado + $pro->recurso_monto;
        }else{
          $f->recurso_gestion_2016 = 0;
        }
        if($pro->recurso_gestion == '2017'){
          $f->recurso_gestion_2017 = $pro->recurso_monto;
          $total_recurso_programado = $total_recurso_programado + $pro->recurso_monto;
        }else{
          $f->recurso_gestion_2017 = 0;
        }
        if($pro->recurso_gestion == '2018'){
          $f->recurso_gestion_2018 = $pro->recurso_monto;
          $total_recurso_programado = $total_recurso_programado + $pro->recurso_monto;
        }else{
          $f->recurso_gestion_2018 = 0;
        }
      }
      $programacion_indicador = \DB::select("select  pro_indicador.id_articulacion_objetivo_indicador,
                                                  pro_indicador.gestion as indicador_gestion,
                                                  pro_indicador.valor as indicador_valor
                                          from sp_eta_programacion_indicador as pro_indicador
                                          where pro_indicador.id_articulacion_objetivo_indicador = $f->id_objetivo_indicador
                                          and pro_indicador.gestion in('2016','2017','2018') ");
      foreach ($programacion_indicador as $indi) {
          
          if($indi->indicador_gestion == '2016'){
            $f->indicador_gestion_2016 = $indi->indicador_valor;
            $total_indicador_programado = $total_indicador_programado + $indi->indicador_valor;
          }else{
            $f->indicador_gestion_2016 = 0;
          }
          if($indi->indicador_gestion == '2017'){
            $f->indicador_gestion_2017 = $indi->indicador_valor;
            $total_indicador_programado = $total_indicador_programado + $indi->indicador_valor;
          }else{
            $f->recurso_gestion_2017 = 0;
          }
          if($indi->indicador_gestion == '2018'){
            $f->indicador_gestion_2018 = $indi->indicador_valor;
            $total_indicador_programado = $total_indicador_programado + $indi->indicador_valor;
          }else{
            $f->indicador_gestion_2018 = 0;
          }
      }
      //hallando la EJECUCION EN EL POA
      $total_recurso_poa = 0;
      $total_indicador_poa = 0;
      $poa = \DB::select("select gestion as poa_gestion,
                                  monto_poa_ejecutado,
                                  accion_poa_ejecutado 

                          from sp_eta_financiero_poa
                          where id_intitucion = $user->id_institucion
                          and gestion in (2016,2017,2018)
                          and id_accion_eta = $f->id_objetivos");
      if($poa){
        foreach ($poa as $eje) {
          if($eje->poa_gestion == 2016){
            $f->recurso_poa_2016 = $eje->monto_poa_ejecutado;
            $total_recurso_poa = $total_recurso_poa + $eje->monto_poa_ejecutado;

            $f->indicador_poa_2016 = $eje->accion_poa_ejecutado;
            $total_indicador_poa = $total_indicador_poa + $eje->accion_poa_ejecutado;
          }else{
            $f->recurso_poa_2016 = 0;
            $f->indicador_poa_2016 = 0;
          }
          if($eje->poa_gestion == 2017){
            $f->recurso_poa_2017 = $eje->monto_poa_ejecutado;
            $total_recurso_poa = $total_recurso_poa + $eje->monto_poa_ejecutado;
            $f->indicador_poa_2016 = $eje->accion_poa_ejecutado;
            $total_indicador_poa = $total_indicador_poa + $eje->accion_poa_ejecutado;
          }else{
            $f->recurso_poa_2017 = 0;
            $f->indicador_poa_2017 = 0;
          }
          if($eje->poa_gestion == 2018){
            $f->recurso_poa_2018 = $eje->monto_poa_ejecutado;
            $total_recurso_poa = $total_recurso_poa + $eje->monto_poa_ejecutado;
            $f->indicador_poa_2016 = $eje->accion_poa_ejecutado;
            $total_indicador_poa = $total_indicador_poa + $eje->accion_poa_ejecutado;
          }else{
            $f->recurso_poa_2018 = 0;
            $f->indicador_poa_2018 = 0;
          }
        }
      }else{
        $f->recurso_poa_2016 = 0;
        $f->indicador_poa_2016 = 0;
        $f->recurso_poa_2017 = 0;
        $f->indicador_poa_2017 = 0;
        $f->recurso_poa_2018 = 0;
        $f->indicador_poa_2018 = 0;
      }
      
      


        $f->total_recurso_programado = $total_recurso_programado;
        $f->total_indicador_programado = $total_indicador_programado;
        $f->total_recurso_poa = $total_recurso_poa;
        $f->total_indicador_poa = $total_indicador_poa;

        //Metas al 2020
        $meta_recurso_2020 = \DB::select("select sum(monto) as meta_recurso_2020 
                                                  from sp_eta_programacion_recursos
                                                  where id_articulacion_objetivo_indicador = $f->id_objetivo_indicador");
        $meta_indicador_2020 = \DB::select("select sum(valor) as meta_indicador_2020 
                                                  from sp_eta_programacion_indicador
                                                  where id_articulacion_objetivo_indicador = $f->id_objetivo_indicador");
        $f->meta_recurso_2020 = $meta_recurso_2020[0]->meta_recurso_2020;
        $f->meta_indicador_2020 = $meta_indicador_2020[0]->meta_indicador_2020;
        //calcualdo porcentuales
        //porcentaje ejecutado = ejecutado/sobre programado
        $f->recurso_porcentaje_ejecutado = ($total_recurso_poa / $total_recurso_programado)*100;
        $f->recurso_porcentaje_ejecutado_meta_2020 = ($total_recurso_poa / $meta_recurso_2020[0]->meta_recurso_2020)*100;
        $f->indicador_porcentaje_ejecutado = ($total_indicador_poa / $total_indicador_programado)*100;
        $f->indicador_porcentaje_ejecutado_meta_2020 = ($total_indicador_poa / $meta_indicador_2020[0]->meta_indicador_2020)*100;
        //incluyendo COMENTARIO DE AXION ETA
        $comentario = \DB::select("select * from sp_eta_evaluacion_reporte_financiero
                                            where id_institucion = 560
                                            and id_accion_eta = $f->id_objetivos
                                            and activo = true");
        //dd($comentario);
        if($comentario){
          $f->input = $comentario[0]->causas_de_variacion;

        }else{
          $f->input = "";
        }
        $f->clase = "";
        $f->comentario ="";
    }
    //dd($accion_eta);
    return \Response::json(array('riesgos'=>$accion_eta));

  }
  public function saveReporteRecursos(Request $request){
    $user = \Auth::user();
    $recu = $request->reporte_recursos;
    //return $request->reporte_recursos;
    
    
      try{

        foreach ($recu as $rep) {
          //verificar si recurso exte
          //si hay actualizar
          //si no crear
          $recurso_identificador =  $rep['recurso_id'];
          /*$verificar = \DB::select("select * from sp_eta_evaluacion_reporte_recursos
                                    where id_institucion = $user->id_institucion
                                    and id_recurso = $recurso_identificador");*/
          $verificar = EvaluacionReporteRecursos::where('id_institucion',$user->id_institucion)
                                                ->where('id_recurso', $rep['recurso_id'])
                                                ->where('activo', true)
                                                ->get();
          //dd($verificar);
          //if($verificar->count()>0){
          if($verificar->count()>0){  
            
            EvaluacionReporteRecursos::where('id_institucion',$user->id_institucion)
                                                ->where('id_recurso', $rep['recurso_id'])
                                                ->where('activo', true)
                                                ->update([
                                                          'ptdi_pro_2016' => $rep['planificacion_2016'],
                                                          'ptdi_pro_2017' => $rep['planificacion_2017'],
                                                          'ptdi_pro_2018' => $rep['planificacion_2018'],
                                                          'ptdi_total_2016_2018' => $rep['total_planificacion'], 
                                                          'ptdi_dif_a_poa'=> $rep['diferencia_a_poa'],
                                                          'ptdi_dif_porcentaje' => $rep['diferencia_porcentaje_a_poa'],
                                                          'pei_pro_2016' => 0,
                                                          'pei_pro_2017' => 0,
                                                          'pei_pro_2018' => 0,
                                                          'pei_total_2016_2018' => 0,
                                                          'pei_dif_a_poa' => 0,
                                                          'pei_dif_porcentaje' => 0,
                                                          'poa_pro_2016' => $rep['poa_2016'],
                                                          'poa_pro_2017' => $rep['poa_2017'],
                                                          'poa_pro_2018' => $rep['poa_2018'],
                                                          'poa_total_2016_2018' => $rep['total_poa'],
                                                          'id_institucion' => $user->id_institucion,
                                                          'activo' => true,
                                                          'causas_de_variacion' => $rep['input']
                                                        ]);
            
          }else{
              
            $recurso = new EvaluacionReporteRecursos();
            $recurso->id_recurso  = $rep['recurso_id'];
            $recurso->ptdi_pro_2016 = $rep['planificacion_2016'];
            $recurso->ptdi_pro_2017 = $rep['planificacion_2017'];
            $recurso->ptdi_pro_2018 = $rep['planificacion_2018'];
            $recurso->ptdi_total_2016_2018  = $rep['total_planificacion'];//$rep[''];
            $recurso->ptdi_dif_a_poa  = $rep['diferencia_a_poa'];//$rep[''];
            $recurso->ptdi_dif_porcentaje  = $rep['diferencia_porcentaje_a_poa'];//$rep[''];
            $recurso->pei_pro_2016  = 0;//$rep[''];
            $recurso->pei_pro_2017  = 0;//$rep[''];
            $recurso->pei_pro_2018 = 0;//$rep[''];
            $recurso->pei_total_2016_2018  = 0;//$rep[''];
            $recurso->pei_dif_a_poa  = 0;//$rep[''];
            $recurso->pei_dif_porcentaje  = 0;//$rep[''];
            $recurso->poa_pro_2016  = $rep['poa_2016'];
            $recurso->poa_pro_2017  = $rep['poa_2017'];
            $recurso->poa_pro_2018  = $rep['poa_2018'];
            $recurso->poa_total_2016_2018  = $rep['total_poa'];//$rep[''];
            $recurso->id_institucion  = $user->id_institucion;
            $recurso->activo  = true;
            $recurso->causas_de_variacion = $rep['input'];
            $recurso->save();
          } 
        }

        return \Response::json(array(
              'error' => true,
              'title' => "Success!",
              'msg' => "Se guardo con exito."
        ));
      }catch(Exception $e){
        return \Response::json(array(
                'error' => false,
                'title' => "Error!",
                'msg' => $e->getMessage())
              );
      }
  }
  public function saveReporteFinanciero(Request $request){
    $user = \Auth::user();
    $financiero = $request->reporte_financiero;
    //dd($financiero);
    try{

        foreach ($financiero as $f) {
          //verificar si la accion eta existe
          //si hay actualizar
          //si no crear
          $id_accion_eta =  $f['id_objetivos'];
          /*$verificar = \DB::select("select * from sp_eta_evaluacion_reporte_recursos
                                    where id_institucion = $user->id_institucion
                                    and id_recurso = $recurso_identificador");*/
          $verificar = EvaluacionReporteFinanciero::where('id_institucion',$user->id_institucion)
                                                ->where('id_accion_eta', $f['id_objetivos'])
                                                ->where('activo', true)
                                                ->get();
          //dd($verificar);
          //if($verificar->count()>0){
          if($verificar->count()>0){  
            
            EvaluacionReporteFinanciero::where('id_institucion',$user->id_institucion)
                                                ->where('id_accion_eta', $f['id_objetivos'])
                                                ->where('activo', true)
                                                ->update([
                                                            'id_accion_eta' =>$f['id_objetivos'],
                                                            'inscrito_ptdi' => true,
                                                            'inscrito_pei' => false,
                                                            'inscrito_poa' =>true,
                                                            'recurso_programado_2016' =>$f['recurso_gestion_2016'],
                                                            'recurso_ejecutado_2016' =>$f['recurso_poa_2016'],
                                                            'recurso_programado_2017' =>$f['recurso_gestion_2017'],
                                                            'recurso_ejecutado_2017' =>$f['recurso_poa_2017'],
                                                            'recurso_programado_2018' =>$f['recurso_gestion_2018'],
                                                            'recurso_ejecutado_2018' =>$f['recurso_poa_2018'],
                                                            'recurso_total_programado_2016_2018' =>$f['total_recurso_programado'],
                                                            'recurso_total_ejecutado_2016_2018' =>$f['total_recurso_poa'],
                                                            'recurso_porcentaje_ejecutado' =>$f['recurso_porcentaje_ejecutado'],
                                                            'recurso_meta_programado_al_2020' =>$f['meta_recurso_2020'],
                                                            'recurso_porcentaje_ejecucion_al_2020' =>$f['recurso_porcentaje_ejecutado_meta_2020'],
                                                            'accion_programado_2016' =>$f['indicador_gestion_2016'],
                                                            'accion_ejecutado_2016' =>$f['indicador_poa_2016'],
                                                            'accion_programado_2017' =>$f['indicador_gestion_2017'],
                                                            'accion_ejecutado_2017' =>$f['indicador_poa_2016'],
                                                            'accion_programado_2018' =>$f['indicador_gestion_2018'],
                                                            'accion_ejecutado_2018' =>$f['indicador_poa_2016'],
                                                            'accion_total_programado_2016_2018' =>$f['total_indicador_programado'],
                                                            'accion_total_ejecutado_2016_2018' =>$f['total_indicador_poa'],
                                                            'accion_porcentaje_ejecutado' =>$f['indicador_porcentaje_ejecutado'],
                                                            'accion_meta_al_2020' =>$f['meta_indicador_2020'],
                                                            'accion_porcentaje_ejecucion_al_2020' =>$f['indicador_porcentaje_ejecutado_meta_2020'],
                                                            'causas_de_variacion' =>$f['input'],
                                                            'id_institucion' =>$user->id_institucion,
                                                            'activo' =>true
                                                          
                                                        ]);

 
  
            
          }else{
              
            $financiero = new EvaluacionReporteFinanciero();
           
            $financiero->id_accion_eta = $f['id_objetivos'];
            $financiero->inscrito_ptdi = true;//$f[''];
            $financiero->inscrito_pei = false;//$f[''];
            $financiero->inscrito_poa = true; //$f[''];
            $financiero->recurso_programado_2016 = $f['recurso_gestion_2016'];
            $financiero->recurso_ejecutado_2016 = $f['recurso_poa_2016'];
            $financiero->recurso_programado_2017 = $f['recurso_gestion_2017'];
            $financiero->recurso_ejecutado_2017 = $f['recurso_poa_2017'];
            $financiero->recurso_programado_2018 = $f['recurso_gestion_2018'];
            $financiero->recurso_ejecutado_2018 = $f['recurso_poa_2018'];
            $financiero->recurso_total_programado_2016_2018 = $f['total_recurso_programado'];
            $financiero->recurso_total_ejecutado_2016_2018 = $f['total_recurso_poa'];
            $financiero->recurso_porcentaje_ejecutado = $f['recurso_porcentaje_ejecutado'];
            $financiero->recurso_meta_programado_al_2020 = $f['meta_recurso_2020'];
            $financiero->recurso_porcentaje_ejecucion_al_2020 = $f['recurso_porcentaje_ejecutado_meta_2020'];
            $financiero->accion_programado_2016 = $f['indicador_gestion_2016'];
            $financiero->accion_ejecutado_2016 = $f['indicador_poa_2016'];
            $financiero->accion_programado_2017 = $f['indicador_gestion_2017'];
            $financiero->accion_ejecutado_2017 = $f['indicador_poa_2016'];
            $financiero->accion_programado_2018 = $f['indicador_gestion_2018'];
            $financiero->accion_ejecutado_2018 = $f['indicador_poa_2016'];
            $financiero->accion_total_programado_2016_2018 = $f['total_indicador_programado'];
            $financiero->accion_total_ejecutado_2016_2018 = $f['total_indicador_poa'];
            $financiero->accion_porcentaje_ejecutado = $f['indicador_porcentaje_ejecutado'];
            $financiero->accion_meta_al_2020 = $f['meta_indicador_2020'];
            $financiero->accion_porcentaje_ejecucion_al_2020 = $f['indicador_porcentaje_ejecutado_meta_2020'];
            $financiero->causas_de_variacion = $f['input'];
            $financiero->id_institucion = $user->id_institucion;
            $financiero->activo = true;
            $financiero->save();
          } 
        }

        return \Response::json(array(
              'error' => true,
              'title' => "Success!",
              'msg' => "Se guardo con exito."
        ));
      }catch(Exception $e){
        return \Response::json(array(
                'error' => false,
                'title' => "Error!",
                'msg' => $e->getMessage())
              );
      }
    
  }

   
}
/*
clase: ""
diferencia_a_poa: 835543
diferencia_porcentaje_a_poa: 17.2791969795326
input: ""
mensaje: ""
planificacion_2016: "0.00"
planificacion_2017: "0.00"
planificacion_2018: "4835543.00"
poa_2016: ""
poa_2017: ""
poa_2018: "4000000.00"
recurso: "Coparticipación Tributaria."
recurso_id: 216
total_planificacion: 4835543
total_poa: 4000000*/