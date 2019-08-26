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
      $recursos_medio = [];
      $total_diferencia_2016_2018 = 0;
      $total_diferencia_porcentaje_2016_2018 = 0;

    $recursos_unicos = \DB::select("select DISTINCT id_tipo_recurso, nombre  from sp_eta_recursos_eta as r,sp_parametros as p
          where r.id_institucion =  $user->id_institucion
          and r.activo = true
          and r.id_tipo_recurso = p.id 
          and categoria = 'tipo_recursos'");
    $i = 0;
    foreach ($recursos_unicos as $r) {
      $recurso_planificado = \DB::select("select 
                                              r.monto,
                                              r.gestion
                                            from sp_eta_recursos_eta as r
                                            where r.id_institucion = $user->id_institucion
                                            and r.gestion in ('2016','2017','2018')
                                            and r.id_tipo_recurso = $r->id_tipo_recurso
                                            and r.activo = true");
      //dd($recurso_planificado);
      $recursos_medio[$i]['id_tipo_recurso'] = $r->id_tipo_recurso;
      $recursos_medio[$i]['nombre'] = $r->nombre;

      foreach ($recurso_planificado as $rp ) {
        if($rp->gestion = '2016'){
          $recursos_medio[$i]['planificacion_2016'] = $rp->monto;
        }
        if($rp->gestion = '2017') {
          $recursos_medio[$i]['planificacion_2017'] = $rp->monto;
        }
        if($rp->gestion = '2018') {
          $recursos_medio[$i]['planificacion_2018'] = $rp->monto;
        }
      }
      $total_recurso_ptdi_2016_2018 = \DB::select("select 
                                                sum(monto) as total_recurso_ptdi_2016_2018
                                              from sp_eta_recursos_eta
                                              where id_institucion = $user->id_institucion
                                              and id_tipo_recurso = $r->id_tipo_recurso
                                              and gestion in ('2016','2017','2018')");

      $recursos_medio[$i]['total_recurso_2016_2018'] = $total_recurso_ptdi_2016_2018[0]->total_recurso_ptdi_2016_2018;

      $recurso_poa = \DB::select("select 
                                        monto_poa_gestion,
                                        gestion
                                  from sp_eta_recursos_poa
                                    where id_institucion = $user->id_institucion
                                    and gestion in (2016,2017,2018)
                                    and id_tipo_recurso = $r->id_tipo_recurso");
      
      $gestiones = [
                    '2016'=>false,
                    '2017'=>false,
                    '2018'=>false
                  ];
      //dd($recurso_poa);
      foreach ($recurso_poa as $rpoa) {
        if($rpoa->gestion == '2016'){
          $recursos_medio[$i]['poa_2016'] = $rpoa->monto_poa_gestion;
          $gestiones['2016'] =true;
        }
        if($rpoa->gestion == '2017') {
          $recursos_medio[$i]['poa_2017'] = $rpoa->monto_poa_gestion;
          $gestiones['2016'] =true;
        }
        if($rpoa->gestion == '2018') {
          $recursos_medio[$i]['poa_2018'] = $rpoa->monto_poa_gestion;
          $gestiones['2016'] =true;
        }
      }

      foreach ($gestiones as $key => $value) {
        switch ($key) {
          case 2016:
            if($value == false){
              $recursos_medio[$i]['poa_2016'] = 0;
            }
            break;
          case 2017:
            if($value == false){
              $recursos_medio[$i]['poa_2017'] = 0;
            }
            break;
          case 2018:
            if($value == false){
              $recursos_medio[$i]['poa_2018'] = 0;
            }
            break;
          
        }
      }
      //dd($recursos_medio);
      $total_recurso_poa_2016_2018 = \DB::select("select 
                                              sum(monto_poa_gestion) as total_recurso_poa_2016_2018
                                                
                                        from sp_eta_recursos_poa
                                        where id_institucion = $user->id_institucion
                                        and gestion in (2016,2017,2018)
                                        and id_tipo_recurso = $r->id_tipo_recurso");
      
      if(!$total_recurso_poa_2016_2018){
         $recursos_medio[$i]['total_recurso_poa_2016_2018'] = 0; 
      }else{
        $recursos_medio[$i]['total_recurso_poa_2016_2018'] = $total_recurso_poa_2016_2018[0]->total_recurso_poa_2016_2018; 
      }
      
      $recursos_medio[$i]['total_diferencia_ptdi_poa'] = $total_recurso_ptdi_2016_2018[0]->total_recurso_ptdi_2016_2018 - $total_recurso_poa_2016_2018[0]->total_recurso_poa_2016_2018;

      $recursos_medio[$i]['total_diferencia_porcentaje_ptdi_poa'] = ($recursos_medio[$i]['total_diferencia_ptdi_poa']/$recursos_medio[$i]['total_recurso_2016_2018'])*100;

      $total_diferencia_2016_2018 = $total_diferencia_2016_2018 + $recursos_medio[$i]['total_diferencia_ptdi_poa'];
      $total_diferencia_porcentaje_2016_2018 = $total_diferencia_porcentaje_2016_2018 + $recursos_medio[$i]['total_diferencia_porcentaje_ptdi_poa'];
      //COMENTARIOS
      $recurso_comentario = \DB::select("select causas_de_variacion from sp_eta_evaluacion_reporte_recursos
                                                                where id_institucion = $user->id_institucion
                                                                and id_recurso = $r->id_tipo_recurso");
      if($recurso_comentario){
        $recursos_medio[$i]['input']=$recurso_comentario[0]->causas_de_variacion; 
        $recursos_medio[$i]['clase']="";
      $recursos_medio[$i]['mensaje']="";
      }else{
        $recursos_medio[$i]['input']=""; 
        $recursos_medio[$i]['clase']="";
      $recursos_medio[$i]['mensaje']="";
      }
     
      
      
      $i++; 
    }

    $otros_unicos = \DB::select("select 
                                        DISTINCT o.id as id_otro_ingreso,
                                        o.concepto as nombre
                                        from sp_eta_recursos_eta as r,
                                     sp_eta_otros_ingresos as o
                                where r.id_institucion = $user->id_institucion
                                and r.gestion in (2016,2017,2018)
                                and r.id_tipo_recurso ISNULL
                                and r.id_otro_ingreso = o.id");
    $otros_medio = [];
    $j = 0;
    foreach ($otros_unicos as $o) {
      $otro_planificado  = \DB::select("select 
                                              r.monto,
                                              r.gestion
                                            from sp_eta_recursos_eta as r
                                            where r.id_institucion = $user->id_institucion
                                            and r.gestion in ('2016','2017','2018')
                                            and r.id_otro_ingreso = $o->id_otro_ingreso
                                            and r.activo = true");
      $otros_medio[$j]['id_otro_ingreso'] = $o->id_otro_ingreso;
      $otros_medio[$j]['nombre'] = $o->nombre;

      foreach ($otro_planificado as $op ) {
        if($op->gestion = '2016'){
          $otros_medio[$j]['planificacion_2016'] = $op->monto;
        }
        if($op->gestion = '2017') {
          $otros_medio[$j]['planificacion_2017'] = $op->monto;
        }
        if($op->gestion = '2018') {
          $otros_medio[$j]['planificacion_2018'] = $op->monto;
        }
      }
      $total_recurso_otro_ptdi_2016_2018 = \DB::select("select 
                                                sum(monto) as total_recurso_ptdi_2016_2018
                                              from sp_eta_recursos_eta
                                              where id_institucion = $user->id_institucion
                                              and id_otro_ingreso = $o->id_otro_ingreso
                                              and gestion in ('2016','2017','2018')");

      $otros_medio[$j]['total_recurso_2016_2018'] = $total_recurso_otro_ptdi_2016_2018[0]->total_recurso_ptdi_2016_2018;

      //poa
      $otro_poa = \DB::select("select 
                                        monto_poa_gestion,
                                        gestion
                                  from sp_eta_recursos_poa
                                    where id_institucion = $user->id_institucion
                                    and gestion in (2016,2017,2018)
                                    and id_otro_ingreso = $o->id_otro_ingreso");
      $gestiones = [
                    '2016'=>false,
                    '2017'=>false,
                    '2018'=>false
                  ];
      //dd($recurso_poa);
      foreach ($otro_poa as $opoa) {
        if($opoa->gestion = '2016'){
          $otros_medio[$j]['poa_2016'] = $opoa->monto_poa_gestion;
          $gestiones['2016'] =true;
        }
        if($opoa->gestion = '2017') {
          $otros_medio[$j]['poa_2017'] = $opoa->monto_poa_gestion;
          $gestiones['2016'] =true;
        }
        if($opoa->gestion = '2018') {
          $otros_medio[$j]['poa_2018'] = $opoa->monto_poa_gestion;
          $gestiones['2016'] =true;
        }
      }
      foreach ($gestiones as $key => $value) {
        if($key == '2016'){
          $otros_medio[$j]['poa_2016'] = 0;
          
        }
        if($key == '2017'){
          $otros_medio[$j]['poa_2017'] = 0;
          
        }
        if($key == '2018'){
          $otros_medio[$j]['poa_2018'] = 0;
          
        }
        
      }
      $total_recurso_otro_poa_2016_2018 = \DB::select("select 
                                              sum(monto_poa_gestion) as total_recurso_poa_2016_2018 
                                              
                                        from sp_eta_recursos_poa
                                        where id_institucion = $user->id_institucion
                                        and gestion in (2016,2017,2018)
                                        and activo = true
                                        and id_otro_ingreso = $o->id_otro_ingreso");
      
      if(!$total_recurso_poa_2016_2018){
        $otros_medio[$j]['total_recurso_poa_2016_2018'] = $total_recurso_otro_poa_2016_2018[0]->total_recurso_poa_2016_2018;  
      }else{
        $otros_medio[$j]['total_recurso_poa_2016_2018'] = 0;  
      }

      $otros_medio[$j]['total_diferencia_ptdi_poa'] = $otros_medio[$j]['total_recurso_2016_2018'] - $otros_medio[$j]['total_recurso_poa_2016_2018'];

      $otros_medio[$j]['total_diferencia_porcentaje_ptdi_poa'] = ($otros_medio[$j]['total_diferencia_ptdi_poa']/$otros_medio[$j]['total_recurso_2016_2018'] )*100;

      $total_diferencia_2016_2018 = $total_diferencia_2016_2018 + $otros_medio[$j]['total_diferencia_ptdi_poa'];
      $total_diferencia_porcentaje_2016_2018 = $total_diferencia_porcentaje_2016_2018 + $otros_medio[$j]['total_diferencia_porcentaje_ptdi_poa'];

      $otros_comentario = \DB::select("select causas_de_variacion from sp_eta_evaluacion_reporte_recursos
                                                                where id_institucion = $user->id_institucion
                                                                and id_otro_ingreso = $o->id_otro_ingreso");
      if($otros_comentario){
        $otros_medio[$j]['input']=$otros_comentario[0]->causas_de_variacion; 
        $otros_medio[$j]['clase']="";
        $otros_medio[$j]['mensaje']="";
      }else{
        $otros_medio[$j]['input']=""; 
        $otros_medio[$j]['clase']="";
        $otros_medio[$j]['mensaje']="";
      }
     
      
      $j++;
    }
    ///TOTALES
    $total_recursos = [];
    $i = 0;
    $totales_gestiones_planificado = \DB::select("select sum(monto) as total_monto_gestion,gestion 
                                    from sp_eta_recursos_eta
                                    where id_institucion = $user->id_institucion
                                    and gestion in ('2016','2017','2018')
                                    GROUP BY gestion
                                    ORDER BY gestion");
    foreach ($totales_gestiones_planificado as $tg) {
      if($tg->gestion == 2016){
        $total_recursos[0]['total_gestion_2016'] = $tg->total_monto_gestion;  
      }
      if($tg->gestion == 2017){
        $total_recursos[0]['total_gestion_2017'] = $tg->total_monto_gestion;  
      }
      if($tg->gestion == 2018){
        $total_recursos[0]['total_gestion_2018'] = $tg->total_monto_gestion;  
      }
    }
    $total_gestion_2016_2018 = \DB::select("select sum(monto) as total_monto_gestion from sp_eta_recursos_eta
                                          where id_institucion = $user->id_institucion
                                          and gestion in ('2016','2017','2018')");
    $total_recursos[0]['total_gestion_2016_2018'] = $total_gestion_2016_2018[0]->total_monto_gestion;  

    ;
    $totales_gestiones_poa = \DB::select("select sum(monto_poa_gestion) as total_monto_poa_gestion,
                                          gestion
                                          
                                  from sp_eta_recursos_poa
                                  where id_institucion = $user->id_institucion
                                  and gestion in (2016,2017,2018)
                                  GROUP BY gestion
                                  ORDER BY gestion");
    //dd($totales_gestion_poa);
     $gestiones = [
                    '2016'=>false,
                    '2017'=>false,
                    '2018'=>false
                  ];
    foreach ($totales_gestiones_poa as $tgp) {
      if($tgp->gestion == 2016){
        $total_recursos[0]['total_poa_2016'] = $tgp->total_monto_poa_gestion;
        $gestiones['2016'] = true;  
      }
      if($tgp->gestion == 2017){
        $total_recursos[0]['total_poa_2017'] = $tgp->total_monto_poa_gestion;
        
        $gestiones['2017'] = true;  
      }
      if($tgp->gestion == 2018){
        $total_recursos[0]['total_poa_2018'] = $tgp->total_monto_poa_gestion;
        $gestiones['2018'] = true;  
      }
    }

    foreach ($gestiones as $key => $value) {
      switch ($key) {
        case 2016:
          if($value == false){
            $total_recursos[0]['total_poa_2016'] = 0;
            
          }
          break;
        case 2017:
          if($value == false){
            $total_recursos[0]['total_poa_2017'] = 0;
            
          }
          break;
        case 2018:
          if($value == false){
            $total_recursos[0]['total_poa_2018'] = 0;
           
          }
          break;
      }
    }
    $total_gestion_poa_2016_2018  = \DB::select("select sum(monto_poa_gestion) as total_gestion_poa_2016_2018
                                                                                  from sp_eta_recursos_poa
                                                                                  where id_institucion = $user->id_institucion
                                                                                  and gestion in ('2016','2017','2018')");  
    $total_recursos[0]['total_gestion_poa_2016_2018'] = $total_gestion_poa_2016_2018[0]->total_gestion_poa_2016_2018;
    $total_recursos[0]['total_diferencia_ptdi_poa_2016_2018'] = $total_diferencia_2016_2018;
    $total_recursos[0]['total_diferencia_porcentaje_ptdi_poa_2016_2018'] = $total_diferencia_porcentaje_2016_2018;
      return \Response::json([
        'recursos_medio' => $recursos_medio,
        'otros_medio' => $otros_medio,
        'totales' => $total_recursos
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
                                    objetivos.id_accion_eta as agregador, 
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
      //PROGRAMACION DE RECURSO
      $programacion_recurso = \DB::select("select pro_recurso.id_articulacion_objetivo_indicador,
                                        pro_recurso.gestion as recurso_gestion,
                                        pro_recurso.monto as recurso_monto
                                from sp_eta_programacion_recursos as pro_recurso 
                                where pro_recurso.id_articulacion_objetivo_indicador = $f->id_objetivo_indicador
                                and pro_recurso.gestion in ('2016','2017','2018') ");
      
      foreach ($programacion_recurso as $pro) {
        if($pro->recurso_monto > 0){
          if($pro->recurso_gestion == '2016'){
            $f->recurso_gestion_2016_recurso = $pro->recurso_monto;
            $total_recurso_programado = $total_recurso_programado + $pro->recurso_monto;

          }elseif($pro->recurso_gestion == '2017'){

            $f->recurso_gestion_2017_recurso= $pro->recurso_monto;
            $total_recurso_programado = $total_recurso_programado + $pro->recurso_monto;

          }elseif($pro->recurso_gestion == '2018'){

            $f->recurso_gestion_2018_recurso = $pro->recurso_monto;
            $total_recurso_programado = $total_recurso_programado + $pro->recurso_monto;
          }

        }else{

           if($pro->recurso_gestion == '2016'){
            $f->recurso_gestion_2016_recurso = 0;  
           }elseif($pro->recurso_gestion == '2017'){
            $f->recurso_gestion_2017_recurso = 0;
           }elseif ($pro->recurso_gestion == '2018') {
            $f->recurso_gestion_2018_recurso = 0;
           }
          
        }
      }
      //PROGRAMACION INDICADOR
      $programacion_indicador = \DB::select("select  pro_indicador.id_articulacion_objetivo_indicador,
                                                  pro_indicador.gestion as indicador_gestion,
                                                  pro_indicador.valor as indicador_valor
                                          from sp_eta_programacion_indicador as pro_indicador
                                          where pro_indicador.id_articulacion_objetivo_indicador = $f->id_objetivo_indicador
                                          and pro_indicador.gestion in('2016','2017','2018') ");
      foreach ($programacion_indicador as $indi) {
          if($indi->indicador_valor > 0){
            switch ($indi->indicador_gestion) {
              case '2016':
                $f->indicador_gestion_2016_indicador = $indi->indicador_valor;
                $total_indicador_programado = $total_indicador_programado + $indi->indicador_valor;
                break;
              case '2017':
                $f->indicador_gestion_2017_indicador = $indi->indicador_valor;
                $total_indicador_programado = $total_indicador_programado + $indi->indicador_valor;
                break;
              case '2018':
                $f->indicador_gestion_2018_indicador = $indi->indicador_valor;
                $total_indicador_programado = $total_indicador_programado + $indi->indicador_valor;
                break;
              
            }

          }else{
            switch ($indi->indicador_gestion) {
              case '2016':
                $f->indicador_gestion_2016_indicador = 0;
                break;
              case '2017':
                $f->indicador_gestion_2017_indicador = 0;
                break;
              case '2018':
                $f->indicador_gestion_2018_indicador = 0;
                break;
              
            }

          }
      }
      //RECURSOS E INDICADOR EN EL POA
      $total_recurso_poa = 0;
      $total_indicador_poa = 0;
      $verificar = [array('gestion'=>2016,'existe'=>false),
                    array('gestion'=>2017,'existe'=>false),
                    array('gestion'=>2018, 'existe'=>false)
                    ];
      
      $poa = \DB::select("select gestion as poa_gestion,
                                  monto_poa_ejecutado,
                                  accion_poa_ejecutado 

                          from sp_eta_financiero_poa
                          where id_intitucion = $user->id_institucion
                          and gestion in (2016,2017,2018)
                          and id_accion_eta = $f->id_objetivos");
      
      foreach ($poa as $eje) {
          switch ($eje->poa_gestion) {
            case 2016:{
              if($eje->monto_poa_ejecutado > 0){
                $f->recurso_poa_2016 = $eje->monto_poa_ejecutado;
                $total_recurso_poa = $total_recurso_poa + $eje->monto_poa_ejecutado;
                
              }else{
                $f->recurso_poa_2016 = 0;
                
              }
              if($eje->accion_poa_ejecutado > 0){
                $f->indicador_poa_2016 = $eje->accion_poa_ejecutado;
                $total_indicador_poa = $total_indicador_poa + $eje->accion_poa_ejecutado;
                
              }else{
                $f->indicador_poa_2016 = 0;
              }
              $verificar[0]['existe'] = true;
              break;
            }
            case 2017:{
              if($eje->monto_poa_ejecutado > 0){
                $f->recurso_poa_2017 = $eje->monto_poa_ejecutado;
                $total_recurso_poa = $total_recurso_poa + $eje->monto_poa_ejecutado;
                
              }else{
                $f->recurso_poa_2016 = 0;
                
              }
              if($eje->accion_poa_ejecutado > 0){
                $f->indicador_poa_2017 = $eje->accion_poa_ejecutado;
                $total_indicador_poa = $total_indicador_poa + $eje->accion_poa_ejecutado;
                
              }else{
                $f->indicador_poa_2016 = 0;
              }
              $verificar[1]['existe'] = true;
              break;
            }
              
            case 2018:{
              if($eje->monto_poa_ejecutado > 0){
                $f->recurso_poa_2018 = $eje->monto_poa_ejecutado;
                $total_recurso_poa = $total_recurso_poa + $eje->monto_poa_ejecutado;
                
              }else{
                $f->recurso_poa_2018 = 0;
                
              }
              if($eje->accion_poa_ejecutado > 0){
                $f->indicador_poa_2018 = $eje->accion_poa_ejecutado;
                $total_indicador_poa = $total_indicador_poa + $eje->accion_poa_ejecutado;
                
              }else{
                $f->indicador_poa_2018 = 0;
              }
              $verificar[2]['existe'] = true;
              break;
            }
          }
      }
      foreach ($verificar as $v) {
        
        switch ($v['gestion']) {
          case 2016:{
            
            if($v['existe'] == false){
              
              $f->recurso_poa_2016 = 0;
              $f->indicador_poa_2016 = 0;
            }
            break;
          }
          case 2017:{
            if($v['existe'] == false){
              $f->recurso_poa_2017 = 0;
              $f->indicador_poa_2017 = 0;
            }
            break;
          }
          case 2018:{
            if($v['existe'] == false){
              $f->recurso_poa_2018 = 0;
              $f->indicador_poa_2018 = 0;
            }
            break;
          }
            
        }
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
        if($total_recurso_programado > 0){
            $f->recurso_porcentaje_ejecutado = ($total_recurso_poa / $total_recurso_programado)*100;
        }else{
            $f->recurso_porcentaje_ejecutado = 0;
        }
        if($meta_recurso_2020[0]->meta_recurso_2020 > 0){
          
          $f->recurso_porcentaje_ejecutado_meta_2020 = ($total_recurso_poa / $meta_recurso_2020[0]->meta_recurso_2020)*100; 
        }else{
          $f->recurso_porcentaje_ejecutado_meta_2020 = 0;  
        }
        if($total_indicador_programado > 0){
          $f->indicador_porcentaje_ejecutado = ($total_indicador_poa / $total_indicador_programado)*100;
        }else{
          $f->indicador_porcentaje_ejecutado = 0;
        }
        
        
        if($meta_indicador_2020[0]->meta_indicador_2020 > 0){
          $f->indicador_porcentaje_ejecutado_meta_2020 = ($total_indicador_poa / $meta_indicador_2020[0]->meta_indicador_2020)*100;
        }else{
          $f->indicador_porcentaje_ejecutado_meta_2020 = 0;
        }
        
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
        $total_recurso_programado = 0;
        $total_indicador_programado = 0;
    }
    //dd($accion_eta);
    $programa = \DB::select("select 
        
        DISTINCT objetivos.id_accion_eta as agregador,
        UPPER(nombre_accion_eta ) as nombre_programa
    
        from sp_eta_etapas_plan as plan,
          sp_eta_objetivos_eta as objetivos,
          sp_eta_catalogo_acciones_eta as catEta
        where plan.id_institucion = $user->id_institucion
        and objetivos.id_etapas_plan = plan.id
        and objetivos.id_accion_eta = catEta.id
        ORDER BY agregador");
    //BUSCANDO OBJETIVOS QUE PERTENECEN AL PROGRAMA
    foreach ($programa as $p) {
      $i = 0;
      $obj = [];
      $id_agregador = $p->agregador;
      $cantidad_objetivo_eta = 0;
      $totales_programa = [];
      $total_programa_recurso_gestion_2016_recurso = 0;
      $total_programa_recurso_gestion_2017_recurso = 0;
      $total_programa_recurso_gestion_2018_recurso = 0;
      $total_programa_recurso_poa_2016 = 0;
      $total_programa_recurso_poa_2017 = 0;
      $total_programa_recurso_poa_2018 = 0;
      $total_programa_total_recurso_programado = 0;
      $total_programa_total_recurso_poa = 0;
      $total_programa_recurso_porcentaje_ejecutado = 0;
      $total_programa_meta_recurso_2020 = 0;
      $total_programa_recurso_porcentaje_ejecutado_meta_2020 = 0;

      //RESPECTO A LA ACCION
      $total_programa_indicador_poa_2016 = 0;
      $total_programa_indicador_poa_2017 = 0;
      $total_programa_indicador_poa_2018 = 0;
      $total_programa_indicador_gestion_2016_indicador = 0;
      $total_programa_indicador_gestion_2017_indicador = 0;
      $total_programa_indicador_gestion_2018_indicador = 0;
      $total_programa_total_indicador_programado = 0;
      $total_programa_total_indicador_poa = 0;
      $total_programa_indicador_porcentaje_ejecutado = 0;
      $total_programa_meta_indicador_2020 = 0;
      $total_programa_indicador_porcentaje_ejecutado_meta_2020 = 0;
      

      foreach ($accion_eta as $a) {
        $meta_recurso_2020_general = \DB::select("select sum(monto) as meta_recurso_2020 
                                                  from sp_eta_programacion_recursos
                                                  where id_articulacion_objetivo_indicador = $a->id_objetivo_indicador");
        $meta_indicador_2020_general = \DB::select("select sum(valor) as meta_indicador_2020 
                                                  from sp_eta_programacion_indicador
                                                  where id_articulacion_objetivo_indicador = $a->id_objetivo_indicador");
        $meta_recurso_2020_general[0]->meta_recurso_2020;
        $meta_indicador_2020_general[0]->meta_indicador_2020;
        if($a->agregador == $id_agregador){
          $obj[$i] = $a;
          $i++;
          $cantidad_objetivo_eta ++;
          //CALCULANDO TOTALES POR PROGRAMA
          $total_programa_recurso_gestion_2016_recurso = $total_programa_recurso_gestion_2016_recurso + $a->recurso_gestion_2016_recurso;
          $total_programa_recurso_gestion_2017_recurso = $total_programa_recurso_gestion_2017_recurso + $a->recurso_gestion_2017_recurso;
          $total_programa_recurso_gestion_2018_recurso = $total_programa_recurso_gestion_2018_recurso + $a->recurso_gestion_2018_recurso;
          $total_programa_recurso_poa_2016 = $total_programa_recurso_poa_2016 + $a->recurso_poa_2016;
          $total_programa_recurso_poa_2017 = $total_programa_recurso_poa_2017 + $a->recurso_poa_2017;
          $total_programa_recurso_poa_2018 = $total_programa_recurso_poa_2018 + $a->recurso_poa_2018;
          $total_programa_total_recurso_programado = $total_programa_total_recurso_programado + $a->total_recurso_programado ;
          $total_programa_total_recurso_poa = $total_programa_total_recurso_poa + $a->total_recurso_poa;
          $total_programa_recurso_porcentaje_ejecutado = $total_programa_recurso_porcentaje_ejecutado + $a->recurso_porcentaje_ejecutado;
          $total_programa_meta_recurso_2020 = $total_programa_meta_recurso_2020+$meta_recurso_2020_general[0]->meta_recurso_2020;//$a->meta_recurso_2020;//$total_programa_meta_recurso_2020 + $a->meta_recurso_2020;
          $total_programa_recurso_porcentaje_ejecutado_meta_2020 = $total_programa_recurso_porcentaje_ejecutado_meta_2020 + $a->recurso_porcentaje_ejecutado_meta_2020;

          //RESPECTO A LA ACCION
          $total_programa_indicador_poa_2016 = $total_programa_indicador_poa_2016 + $a->indicador_poa_2016;
          $total_programa_indicador_poa_2017 = $total_programa_indicador_poa_2017 + $a->indicador_poa_2017;
          $total_programa_indicador_poa_2018 = $total_programa_indicador_poa_2018 + $a->indicador_poa_2018;
          $total_programa_indicador_gestion_2016_indicador = $total_programa_indicador_gestion_2016_indicador + $a->indicador_gestion_2016_indicador;
          $total_programa_indicador_gestion_2017_indicador = $total_programa_indicador_gestion_2017_indicador + $a->indicador_gestion_2017_indicador;
          $total_programa_indicador_gestion_2018_indicador = $total_programa_indicador_gestion_2018_indicador + $a->indicador_gestion_2018_indicador;
          $total_programa_total_indicador_programado = $total_programa_total_indicador_programado + $a->total_indicador_programado;
          $total_programa_total_indicador_poa = $total_programa_total_indicador_poa + $a->total_indicador_poa;
          $total_programa_indicador_porcentaje_ejecutado = $total_programa_indicador_porcentaje_ejecutado + $a->indicador_porcentaje_ejecutado;
          $total_programa_meta_indicador_2020 = $total_programa_meta_indicador_2020+$meta_indicador_2020_general[0]->meta_indicador_2020;//$a->meta_indicador_2020;//$total_programa_meta_indicador_2020 + $a->meta_indicador_2020;
          $total_programa_indicador_porcentaje_ejecutado_meta_2020 = $total_programa_indicador_porcentaje_ejecutado_meta_2020 + $a->indicador_porcentaje_ejecutado_meta_2020 ;
        }
      }

      
      $totales_programa['total_programa_recurso_gestion_2016_recurso'] = $total_programa_recurso_gestion_2016_recurso;
      $totales_programa['total_programa_recurso_gestion_2017_recurso'] = $total_programa_recurso_gestion_2017_recurso;
      $totales_programa['total_programa_recurso_gestion_2018_recurso'] = $total_programa_recurso_gestion_2018_recurso;
      $totales_programa['total_programa_recurso_poa_2016'] = $total_programa_recurso_poa_2016;
      $totales_programa['total_programa_recurso_poa_2017'] = $total_programa_recurso_poa_2017;
      $totales_programa['total_programa_recurso_poa_2018'] = $total_programa_recurso_poa_2018;
      $totales_programa['total_programa_total_recurso_programado'] = $total_programa_total_recurso_programado;
      $totales_programa['total_programa_total_recurso_poa'] = $total_programa_total_recurso_poa;
      $totales_programa['total_programa_recurso_porcentaje_ejecutado'] = $total_programa_recurso_porcentaje_ejecutado;
      $totales_programa['total_programa_meta_recurso_2020'] = $total_programa_meta_recurso_2020;
      $totales_programa['total_programa_recurso_porcentaje_ejecutado_meta_2020'] = $total_programa_recurso_porcentaje_ejecutado_meta_2020;

      //RESPECTO A LA ACCION
      $totales_programa['total_programa_indicador_poa_2016'] = $total_programa_indicador_poa_2016;
      $totales_programa['total_programa_indicador_poa_2017'] = $total_programa_indicador_poa_2017;
      $totales_programa['total_programa_indicador_poa_2018'] = $total_programa_indicador_poa_2018;
      $totales_programa['total_programa_indicador_gestion_2016_indicador'] = $total_programa_indicador_gestion_2016_indicador;
      $totales_programa['total_programa_indicador_gestion_2017_indicador'] = $total_programa_indicador_gestion_2017_indicador;
      $totales_programa['total_programa_indicador_gestion_2018_indicador'] = $total_programa_indicador_gestion_2018_indicador;
      $totales_programa['total_programa_total_indicador_programado'] = $total_programa_total_indicador_programado;
      $totales_programa['total_programa_total_indicador_poa'] = $total_programa_total_indicador_poa;
      $totales_programa['total_programa_indicador_porcentaje_ejecutado'] = $total_programa_indicador_porcentaje_ejecutado;
      $totales_programa['total_programa_meta_indicador_2020'] = $total_programa_meta_indicador_2020;
      $totales_programa['total_programa_indicador_porcentaje_ejecutado_meta_2020'] = $total_programa_indicador_porcentaje_ejecutado_meta_2020;
      
      $p->totales_programa = $totales_programa; 
      $p->objetivos_eta = $obj;
      $p->cantidad_objetivos = $cantidad_objetivo_eta;
      $p->ver = true;

    }
    //dd($programa);  

    //return \Response::json(array('financiero'=>$accion_eta));
    return \Response::json(array('financiero'=>$programa,
                                  ));
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
                                  from sp_eta_etapas_plan as planes, 
                                      sp_eta_objetivos_eta as objetivos,
                                      sp_eta_articulacion_objetivo_indicador as objetivo_indicador,
                                      sp_eta_indicadores as indicadores,
                                      sp_eta_gestion_riesgos as riesgos
                                  where planes.id_institucion = $user->id_institucion
                                  and planes.valor_campo_etapa = 'PTDI'
                                  and planes.id = objetivos.id_etapas_plan
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
        if($total_recurso_programado == 0){
          $f->recurso_porcentaje_ejecutado = 0;
        }else{
          $f->recurso_porcentaje_ejecutado = ($total_recurso_poa / $total_recurso_programado)*100;
        }
        if($meta_recurso_2020[0]->meta_recurso_2020 == 0){
          $f->recurso_porcentaje_ejecutado_meta_2020 = 0;
        }else{
          $f->recurso_porcentaje_ejecutado_meta_2020 = ($total_recurso_poa / $meta_recurso_2020[0]->meta_recurso_2020)*100;
        }
        
        if($total_indicador_programado == 0){
          $f->indicador_porcentaje_ejecutado = 0;
        }else{
          $f->indicador_porcentaje_ejecutado = ($total_indicador_poa / $total_indicador_programado)*100;
        }
        if($meta_indicador_2020[0]->meta_indicador_2020 == 0){
          $f->indicador_porcentaje_ejecutado_meta_2020 = 0;  
        }else{
          $f->indicador_porcentaje_ejecutado_meta_2020 = ($total_indicador_poa / $meta_indicador_2020[0]->meta_indicador_2020)*100;
        }
        
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
    return \Response::json(array('riesgos'=>$accion_eta));

  }
  public function saveReporteRecursos(Request $request){

    $user = \Auth::user();
    $recu = $request->reporte_recursos;
    $otros = $request->reporte_otros;
    //dd($recu);
    
    
      try{

        foreach ($recu as $rep) {
          $verificar = EvaluacionReporteRecursos::where('id_institucion',$user->id_institucion)
                                                ->where('id_recurso', $rep['id_tipo_recurso'])
                                                ->where('activo', true)
                                                ->get();
          //dd($verificar);
          //if($verificar->count()>0){
          if($verificar->count()>0){  
            
            EvaluacionReporteRecursos::where('id_institucion',$user->id_institucion)
                                                ->where('id_recurso', $rep['id_tipo_recurso'])
                                                ->where('activo', true)
                                                ->update([
                                                          'ptdi_pro_2016' => $rep['planificacion_2016'],
                                                          'ptdi_pro_2017' => $rep['planificacion_2017'],
                                                          'ptdi_pro_2018' => $rep['planificacion_2018'],
                                                          'ptdi_total_2016_2018' => $rep['total_recurso_2016_2018'], 
                                                          'ptdi_dif_a_poa'=> $rep['total_diferencia_ptdi_poa'],
                                                          'ptdi_dif_porcentaje' => $rep['total_diferencia_porcentaje_ptdi_poa'],
                                                          'pei_pro_2016' => 0,
                                                          'pei_pro_2017' => 0,
                                                          'pei_pro_2018' => 0,
                                                          'pei_total_2016_2018' => 0,
                                                          'pei_dif_a_poa' => 0,
                                                          'pei_dif_porcentaje' => 0,
                                                          'poa_pro_2016' => $rep['poa_2016'],
                                                          'poa_pro_2017' => $rep['poa_2017'],
                                                          'poa_pro_2018' => $rep['poa_2018'],
                                                          'poa_total_2016_2018' => $rep['total_recurso_poa_2016_2018'],
                                                          'id_institucion' => $user->id_institucion,
                                                          'activo' => true,
                                                          'causas_de_variacion' => $rep['input']
                                                        ]);


            
          }else{
              
            $recurso = new EvaluacionReporteRecursos();
            $recurso->id_recurso  = $rep['id_tipo_recurso'];
            $recurso->ptdi_pro_2016 = $rep['planificacion_2016'];
            $recurso->ptdi_pro_2017 = $rep['planificacion_2017'];
            $recurso->ptdi_pro_2018 = $rep['planificacion_2018'];
            $recurso->ptdi_total_2016_2018  = $rep['total_recurso_2016_2018'];//$rep[''];
            $recurso->ptdi_dif_a_poa  = $rep['total_diferencia_ptdi_poa'];//$rep[''];
            $recurso->ptdi_dif_porcentaje  = $rep['total_diferencia_porcentaje_ptdi_poa'];//$rep[''];
            $recurso->pei_pro_2016  = 0;//$rep[''];
            $recurso->pei_pro_2017  = 0;//$rep[''];
            $recurso->pei_pro_2018 = 0;//$rep[''];
            $recurso->pei_total_2016_2018  = 0;//$rep[''];
            $recurso->pei_dif_a_poa  = 0;//$rep[''];
            $recurso->pei_dif_porcentaje  = 0;//$rep[''];
            $recurso->poa_pro_2016  = $rep['poa_2016'];
            $recurso->poa_pro_2017  = $rep['poa_2017'];
            $recurso->poa_pro_2018  = $rep['poa_2018'];
            $recurso->poa_total_2016_2018  = $rep['total_recurso_poa_2016_2018'];//$rep[''];
            $recurso->id_institucion  = $user->id_institucion;
            $recurso->activo  = true;
            $recurso->causas_de_variacion = $rep['input'];
            $recurso->save();
          } 
        }
        foreach ($otros as $o) {
          $verificar_otro = EvaluacionReporteRecursos::where('id_institucion',$user->id_institucion)
                                                ->where('id_otro_ingreso', $o['id_otro_ingreso'])
                                                ->where('activo', true)
                                                ->get();
          //dd($verificar);
          //if($verificar->count()>0){
          if($verificar_otro->count()>0){  
            
            EvaluacionReporteRecursos::where('id_institucion',$user->id_institucion)
                                                ->where('id_otro_ingreso', $o['id_otro_ingreso'])
                                                ->where('activo', true)
                                                ->update([
                                                          'ptdi_pro_2016' => $o['planificacion_2016'],
                                                          'ptdi_pro_2017' => $o['planificacion_2017'],
                                                          'ptdi_pro_2018' => $o['planificacion_2018'],
                                                          'ptdi_total_2016_2018' => $o['total_recurso_2016_2018'], 
                                                          'ptdi_dif_a_poa'=> $o['total_diferencia_ptdi_poa'],
                                                          'ptdi_dif_porcentaje' => $o['total_diferencia_porcentaje_ptdi_poa'],
                                                          'pei_pro_2016' => 0,
                                                          'pei_pro_2017' => 0,
                                                          'pei_pro_2018' => 0,
                                                          'pei_total_2016_2018' => 0,
                                                          'pei_dif_a_poa' => 0,
                                                          'pei_dif_porcentaje' => 0,
                                                          'poa_pro_2016' => $o['poa_2016'],
                                                          'poa_pro_2017' => $o['poa_2017'],
                                                          'poa_pro_2018' => $o['poa_2018'],
                                                          'poa_total_2016_2018' => $o['total_recurso_poa_2016_2018'],
                                                          'id_institucion' => $user->id_institucion,
                                                          'activo' => true,
                                                          'causas_de_variacion' => $o['input']
                                                        ]);
          }else{
              
            $otro = new EvaluacionReporteRecursos();
            $otro->id_otro_ingreso = $o['id_otro_ingreso'];
            $otro->ptdi_pro_2016 = $o['planificacion_2016'];
            $otro->ptdi_pro_2017 = $o['planificacion_2017'];
            $otro->ptdi_pro_2018 = $o['planificacion_2018'];
            $otro->ptdi_total_2016_2018  = $o['total_recurso_2016_2018'];//$rep[''];
            $otro->ptdi_dif_a_poa  = $rep['total_diferencia_ptdi_poa'];//$rep[''];
            $otro->ptdi_dif_porcentaje  = $o['total_diferencia_porcentaje_ptdi_poa'];//$rep[''];
            $otro->pei_pro_2016  = 0;//$rep[''];
            $otro->pei_pro_2017  = 0;//$rep[''];
            $otro->pei_pro_2018 = 0;//$rep[''];
            $otro->pei_total_2016_2018  = 0;//$rep[''];
            $otro->pei_dif_a_poa  = 0;//$rep[''];
            $otro->pei_dif_porcentaje  = 0;//$rep[''];
            $otro->poa_pro_2016  = $o['poa_2016'];
            $otro->poa_pro_2017  = $o['poa_2017'];
            $otro->poa_pro_2018  = $o['poa_2018'];
            $otro->poa_total_2016_2018  = $o['total_recurso_poa_2016_2018'];//$rep[''];
            $otro->id_institucion  = $user->id_institucion;
            $otro->activo  = true;
            $otro->causas_de_variacion = $o['input'];
            $otro->save();
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
        foreach ($financiero as $p) {
          $objetivos_eta = $p['objetivos_eta'];
          foreach ($objetivos_eta as $f) {
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
                                                              'recurso_programado_2016' =>$f['recurso_gestion_2016_recurso'],
                                                              'recurso_ejecutado_2016' =>$f['recurso_poa_2016'],
                                                              'recurso_programado_2017' =>$f['recurso_gestion_2017_recurso'],
                                                              'recurso_ejecutado_2017' =>$f['recurso_poa_2017'],
                                                              'recurso_programado_2018' =>$f['recurso_gestion_2018_recurso'],
                                                              'recurso_ejecutado_2018' =>$f['recurso_poa_2018'],
                                                              'recurso_total_programado_2016_2018' =>$f['total_recurso_programado'],
                                                              'recurso_total_ejecutado_2016_2018' =>$f['total_recurso_poa'],
                                                              'recurso_porcentaje_ejecutado' =>$f['recurso_porcentaje_ejecutado'],
                                                              'recurso_meta_programado_al_2020' =>$f['meta_recurso_2020'],
                                                              'recurso_porcentaje_ejecucion_al_2020' =>$f['recurso_porcentaje_ejecutado_meta_2020'],
                                                              'accion_programado_2016' =>$f['indicador_gestion_2016_indicador'],
                                                              'accion_ejecutado_2016' =>$f['indicador_poa_2016'],
                                                              'accion_programado_2017' =>$f['indicador_gestion_2017_indicador'],
                                                              'accion_ejecutado_2017' =>$f['indicador_poa_2016'],
                                                              'accion_programado_2018' =>$f['indicador_gestion_2018_indicador'],
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
              $financiero->recurso_programado_2016 = $f['recurso_gestion_2016_recurso'];
              $financiero->recurso_ejecutado_2016 = $f['recurso_poa_2016'];
              $financiero->recurso_programado_2017 = $f['recurso_gestion_2017_recurso'];
              $financiero->recurso_ejecutado_2017 = $f['recurso_poa_2017'];
              $financiero->recurso_programado_2018 = $f['recurso_gestion_2018_recurso'];
              $financiero->recurso_ejecutado_2018 = $f['recurso_poa_2018'];
              $financiero->recurso_total_programado_2016_2018 = $f['total_recurso_programado'];
              $financiero->recurso_total_ejecutado_2016_2018 = $f['total_recurso_poa'];
              $financiero->recurso_porcentaje_ejecutado = $f['recurso_porcentaje_ejecutado'];
              $financiero->recurso_meta_programado_al_2020 = $f['meta_recurso_2020'];
              $financiero->recurso_porcentaje_ejecucion_al_2020 = $f['recurso_porcentaje_ejecutado_meta_2020'];
              $financiero->accion_programado_2016 = $f['indicador_gestion_2016_indicador'];
              $financiero->accion_ejecutado_2016 = $f['indicador_poa_2016'];
              $financiero->accion_programado_2017 = $f['indicador_gestion_2017_indicador'];
              $financiero->accion_ejecutado_2017 = $f['indicador_poa_2016'];
              $financiero->accion_programado_2018 = $f['indicador_gestion_2018_indicador'];
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