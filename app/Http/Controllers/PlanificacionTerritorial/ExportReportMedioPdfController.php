<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Plataforma\Instituciones;
use App\Models\Plataforma\Regiones;
use App\Models\PlanificacionTerritorial\EtapasEstado;
use App\Models\PlanificacionTerritorial\EvaluacionReporteRecursos;
use App\Models\PlanificacionTerritorial\SeguimientoGestiones;
use App\Models\PlanificacionTerritorial\Parametros;
use App\Models\PlanificacionTerritorial\ProyectoPoa;
use App\Models\PlanificacionTerritorial\EvaluacionReporteFinanciero;
use App\Models\PlanificacionTerritorial\ProyectoInversion;
use App\Models\PlanificacionTerritorial\RecursosPoa;
use App\Models\PlanificacionTerritorial\GestionSeleccionada;
use App\Models\PlanificacionTerritorial\Recursos;
use App\Models\PlanificacionTerritorial\FinancieroPoa;
use App\Models\PlanificacionTerritorial\EntidadesConcurrencia;

use Excel;
use PDF;

class ExportReportMedioPdfController extends BasecontrollerController
{
  public function reportePrueba(){
    return View('PlanificacionTerritorial/VistasPdf/accionesGestionPdf');
  }
  public function reporteRecursosMedioPdf(){
    $user = \Auth::user();

    $recursos = \DB::select("SELECT
                                    p.nombre,
                                    e.*
                              from sp_eta_evaluacion_reporte_recursos as e,
                                  sp_parametros as p
                              where e.id_institucion = $user->id_institucion
                              and e.id_recurso = p.id");

    $otros = \DB::select("SELECT
                                o.concepto,
                                e.*
                            from sp_eta_evaluacion_reporte_recursos as e,
                                sp_eta_otros_ingresos as o
                            where e.id_institucion = $user->id_institucion
                            and e.id_recurso isnull
                            and e.id_otro_ingreso = o.id");
    $totales = \DB::select("select   
                                  sum(ptdi_pro_2016) as total_ptdi_pro_2016,
                                  sum(ptdi_pro_2017) as total_ptdi_pro_2017,
                                  sum(ptdi_pro_2018) as total_ptdi_pro_2018,
                                  sum(ptdi_total_2016_2018) as total_ptdi_total_2016_2018,
                                  sum(ptdi_dif_a_poa) as total_ptdi_dif_a_poa,
                                  sum(ptdi_dif_porcentaje) as total_ptdi_dif_porcentaje,
                                  sum(poa_pro_2016) as total_poa_pro_2016, 
                                  sum(poa_pro_2017) as total_poa_pro_2017,
                                  sum(poa_pro_2018) as total_poa_pro_2018,
                                  sum(poa_total_2016_2018) as total_poa_total_2016_2018
                                  
                                from sp_eta_evaluacion_reporte_recursos
                                where id_institucion = $user->id_institucion");
    //dd($totales);

    $institucion = Instituciones::find($user->id_institucion);

    $pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.recursosMedioPdf',compact('recursos','otros','totales','institucion'));
    return $pdf->download('recursosMedioTermino.pdf');
  }
  public function reporteAccionesMedioPdf(){
    //return "Hola desde el controlador reporteAccionesMedioPdf";
    $user = \Auth::user();
    /////////////////////////
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();
    $gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first();
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
      $conteo = $poa->count();

      //$obj->cantidad_proyectos_poa= $conteo;
      //$obj->poa = $poa;
      $array_resto_Poa = [];
      $i=0;
      foreach ($poa as $key => $value) {
        
        if($key == 0){
          $obj->primer_poa = $value;
        }else{
          $array_resto_Poa[$i] = $value;

        }
        $i++;
      }
      $obj->poa = $array_resto_Poa;
      $obj->cantidad_proyectos_poa= $conteo;

    }
    $institucion = Instituciones::find($user->id_institucion);
   //dd($objetivo_indicador);
    $pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.accionesMedioPdf',compact('objetivo_indicador','gestionActiva','institucion'));
    $pdf->setPaper('letter', 'landscape');
    return $pdf->download('accionesMedioTermino.pdf');
  }
  public function reporteFinancieroMedioPdf(){
     $user = \Auth::user();
     //PROGRAMAS
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
     $accion_eta = \DB::select("select 
                                    objetivos.id_accion_eta as agregador, 
                                    objetivos.id as id_objetivos,
                                    objetivos.nombre_objetivo as nombre_objetivo
                                    
                                from sp_eta_etapas_plan as planes, 
                                    sp_eta_objetivos_eta as objetivos
                                    
                                where planes.id_institucion = $user->id_institucion
                                and planes.valor_campo_etapa = 'PTDI'
                                and objetivos.id_etapas_plan = planes.id");

    $datos = EvaluacionReporteFinanciero::where('id_institucion',$user->id_institucion)
                                      ->where('activo',true)
                                      ->get();
    $array_obj_eta = [];
    $i= 0;                                  
    foreach ($programa as $p) {
      $contador_obj_eta = 0;
      $array_obj_eta = [];
      $i= 0; 
      foreach ($accion_eta as $a) {
        if($a->agregador == $p->agregador){
          $datos = EvaluacionReporteFinanciero::where('id_institucion',$user->id_institucion)
                                      ->where('activo',true)
                                      ->where('id_accion_eta',$a->id_objetivos)
                                      ->get();
          //dd($datos);
          $a->datos_evaluacion = $datos;
          $array_obj_eta[$i] = $a;
          $i++;
          $contador_obj_eta++;
        }
      }
      $p->cantidad_objetivos = $contador_obj_eta;
      $p->objetivos_eta = $array_obj_eta;
      $total_agregador = \DB::select("select 
                                            sum(recurso_programado_2016) as recurso_programado_2016,
                                            sum(recurso_ejecutado_2016) as recurso_ejecutado_2016,
                                            sum(recurso_programado_2017) as recurso_programado_2017,
                                            sum(recurso_ejecutado_2017) as recurso_ejecutado_2017,
                                            sum(recurso_programado_2018) as recurso_programado_2018,
                                            sum(recurso_ejecutado_2018) as recurso_ejecutado_2018,
                                            sum(recurso_total_programado_2016_2018) as recurso_total_programado_2016_2018,
                                            sum(recurso_total_ejecutado_2016_2018) as recurso_total_ejecutado_2016_2018,
                                            sum(recurso_porcentaje_ejecutado) as recurso_porcentaje_ejecutado,
                                            sum(recurso_meta_programado_al_2020) as recurso_meta_programado_al_2020,
                                            sum(recurso_porcentaje_ejecucion_al_2020) as recurso_porcentaje_ejecucion_al_2020,
                                            
                                            sum(accion_programado_2016) as accion_programado_2016,
                                            sum(accion_ejecutado_2016) as accion_ejecutado_2016,
                                            sum(accion_programado_2017) as accion_programado_2017,
                                            sum(accion_ejecutado_2017) as accion_ejecutado_2017,
                                            sum(accion_programado_2018) as accion_programado_2018,
                                            sum(accion_ejecutado_2018) as accion_ejecutado_2018,
                                            sum(accion_total_programado_2016_2018) as accion_total_programado_2016_2018,
                                            sum(accion_total_ejecutado_2016_2018) as accion_total_ejecutado_2016_2018,
                                            sum(accion_porcentaje_ejecutado) as accion_porcentaje_ejecutado,
                                            sum(accion_meta_al_2020) as accion_meta_al_2020,
                                            sum(accion_porcentaje_ejecucion_al_2020) as accion_porcentaje_ejecucion_al_2020,
                                            objetivos.id_accion_eta as agregador
                                        from sp_eta_etapas_plan as planes, 
                                            sp_eta_objetivos_eta as objetivos,
                                            sp_eta_evaluacion_reporte_financiero as fin
                                            
                                        where planes.id_institucion = $user->id_institucion
                                        and planes.valor_campo_etapa = 'PTDI'
                                        and objetivos.id_etapas_plan = planes.id
                                        and objetivos.id = fin.id_accion_eta
                                        and objetivos.id_accion_eta = $p->agregador
                                        GROUP BY agregador");
      $p->totales_agregador = $total_agregador;
      
    }
    //dd($programa);
    $institucion = Instituciones::find($user->id_institucion);
    //dd($datos) ;
    $pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.financieroMedioPdf',compact('programa','gestionActiva','institucion'));
    $pdf->setPaper('legal', 'landscape');
    return $pdf->download('financieroMedioTermino.pdf');
  }
  public function reporteInversionMedioPdf(){
    //return "hola desde el controlador";
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
      $obj->cantidad_proyectos_poa = $poa->count();
      $array_resto_Poa = [];
      $i=0;
      foreach ($poa as $key => $value) {
        
        if($key == 0){
          $obj->primer_poa = $value;
        }else{
          $array_resto_Poa[$i] = $value;

        }
        $i++;
      }
      $obj->proyectosInversion = $array_resto_Poa;
    }
    //dd($objetivoProyectos);
    //return \Response::json(['objetivoInversion'=>$objetivoProyectos]);
    //self::construirReporteInversion($objetivoProyectos);
    $institucion = Instituciones::find($user->id_institucion);
    $pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.inversionMedioPdf',compact('objetivoProyectos','gestionActiva','institucion'));
    $pdf->setPaper('legal', 'landscape');
    return $pdf->download('inversionMedioTermino.pdf');
  }
  public function reporteRiesgosMedioPdf(){
    //return "hola desde el controlador";
     //return "Hola desde el reporteRiesgosExcel";
    $user = \Auth::user();
    $datos = \DB::select("select * 
                            from sp_eta_evaluacion_reporte_financiero as rf,
                                 sp_eta_gestion_riesgos as gr
                            where rf.id_institucion = $user->id_institucion
                            and rf.id_accion_eta = gr.id_accion_eta");
  //dd($datos);                                      
    $arrayContenido = []; 
    $fila = [];
    $i =0;
    foreach ($datos as $financiero) {
      if($financiero->inscrito_ptdi == true){
        $financiero->inscrito_ptdi = "X";
      }else{
        $financiero->inscrito_ptdi = "";
      }
      if($financiero->inscrito_pei == true){
        $financiero->inscrito_pei = "X";
      }else{
        $financiero->inscrito_pei = "";
      }
      if($financiero->inscrito_poa == true){
        $financiero->inscrito_poa = "X";
      }else{
        $financiero->inscrito_poa = "";
      }
      $accion_eta = \DB::select("select * from sp_eta_objetivos_eta
                                            where id = $financiero->id_accion_eta");
      $financiero->descripcion_accion_eta = $accion_eta[0]->nombre_objetivo;
      
      /*
      array_push($fila, $descripcion_accion_eta,
                        $financiero->inscrito_ptdi,
                        $financiero->inscrito_pei,
                        $financiero->inscrito_poa,
                        $financiero->recurso_programado_2016,
                        $financiero->recurso_ejecutado_2016,
                        $financiero->recurso_programado_2017,
                        $financiero->recurso_ejecutado_2017,
                        $financiero->recurso_programado_2018,
                        $financiero->recurso_ejecutado_2018,
                        $financiero->recurso_total_programado_2016_2018,
                        $financiero->recurso_total_ejecutado_2016_2018,
                        $financiero->recurso_porcentaje_ejecutado,
                        $financiero->recurso_meta_programado_al_2020,
                        $financiero->recurso_porcentaje_ejecucion_al_2020,
                        $financiero->accion_programado_2016,
                        $financiero->accion_ejecutado_2016,
                        $financiero->accion_programado_2017,
                        $financiero->accion_ejecutado_2017,
                        $financiero->accion_programado_2018,
                        $financiero->accion_ejecutado_2018,
                        $financiero->accion_total_programado_2016_2018,
                        $financiero->accion_total_ejecutado_2016_2018,
                        $financiero->accion_porcentaje_ejecutado,
                        $financiero->accion_meta_al_2020,
                        $financiero->accion_porcentaje_ejecucion_al_2020,
                        $financiero->causas_de_variacion
                        
                      );
      
      $arrayContenido[$i] = $fila;
      $i++;
      $fila = [];*/
    }

    //self::construirReporteGestionRiesgos($arrayContenido);
    //dd($datos) ;
    $institucion = Instituciones::find($user->id_institucion);
    $pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.gestionRiesgosMedioPdf',compact('datos','gestionActiva','institucion'));
    $pdf->setPaper('legal', 'landscape');
    return $pdf->download('gestionRiesgosMedioTermino.pdf');
  }
  
} 

