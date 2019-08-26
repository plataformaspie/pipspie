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

class ExportReportGestionPdfController extends BasecontrollerController
{
  public function reportePrueba(){
    return View('PlanificacionTerritorial/VistasPdf/accionesGestionPdf');
  }
  public function reporteRecursosGestionPdf(){
    $user = \Auth::user();
    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                          ->where('activo',true)
                                           ->first();

    $recursos = \DB::select("select 
                              p.nombre,
                              r.monto,
                              r.id_tipo_recurso,
                              r.gestion
                            from sp_eta_recursos_eta as r,
                                  sp_parametros as p
                                  
                            where id_institucion = $user->id_institucion
                            and gestion = $gestionActiva->gestion
                            and id_tipo_recurso NOTNULL
                            and p.categoria = 'tipo_recursos'
                            and r.id_tipo_recurso = p.id
                            ");
    foreach ($recursos as $r) {
      $recursos_poa = \DB::select("select * from sp_eta_recursos_poa
                                    where id_institucion = $user->id_institucion
                                    and id_tipo_recurso = $r->id_tipo_recurso
                                    and gestion = '$gestionActiva->gestion'");
      
      
      if(sizeof($recursos_poa) > 0){
        $r->recursos_poa = $recursos_poa;
      }else{
        $recursos_poa = [];
        $recursos_poa[0] = (object)array('diferencia_ptdi_poa' => '0',
                                   
        'diferencia_porcentaje_ptdi_poa'=>'0',
        'monto_poa_gestion'=>'0',
        'causas_variacion'=>""
         );
        $r->recursos_poa = $recursos_poa;
      }
    }
    //dd($recursos);
    $otros = \DB::select("select 
                                r.id_tipo_recurso,
                                r.gestion,
                                r.monto,
                                o.id,
                                o.id_institucion,
                                o.concepto
                                
                        from sp_eta_recursos_eta as r,
                             sp_eta_otros_ingresos as o
                        where r.id_institucion = $user->id_institucion
                        and r.gestion = '$gestionActiva->gestion'
                        and r.id_tipo_recurso ISNULL
                        and r.id_otro_ingreso = o.id");
    
    foreach ($otros as $o) {
      $otros_poa = \DB::select("select * from sp_eta_recursos_poa
                                        where id_institucion = $user->id_institucion
                                        and id_otro_ingreso = $o->id
                                        and gestion = '$gestionActiva->gestion'");
      if($otros_poa){
         $o->otros_poa = $otros_poa;
      }else{
        $otros_poa = [];
        $otros_poa[0] = (object) array(
                                        'diferencia_ptdi_poa' =>'0',
                                        'diferencia_porcentaje_ptdi_poa' =>'0',
                                        'monto_poa_gestion' =>'0',
                                        'causas_variacion' =>"",
                                        );
        $o->otros_poa = $otros_poa;
        
      }
    }
    
    $total_recursos_planificado = \DB::select("select 
                                                   sum(monto) as total_ptdi_monto
                                              from sp_eta_recursos_eta
                                              where id_institucion = $user->id_institucion
                                              and gestion = $gestionActiva->gestion");
    //dd($total_recursos_planificado);

    
    $totales_recursos_poa = \DB::select("select 
                                              sum(diferencia_ptdi_poa) as total_diferencia_ptdi_poa,
                                              sum(diferencia_porcentaje_ptdi_poa) as total_diferencia_porcentaje_ptdi_poa,
                                              sum(monto_pei_gestion) as total_monto_pei_gestion,
                                              sum(diferencia_pei_poa) as total_diferencia_pei_poa,
                                              sum(diferencia_porcentaje_pei_poa) as total_diferencia_porcentaje_pei_poa,
                                              sum(monto_poa_gestion) as total_monto_poa_gestion
                                      from sp_eta_recursos_poa
                                      where id_institucion = $user->id_institucion
                                      and gestion = $gestionActiva->gestion");
    $total_recursos_planificado[0]->totales_poa = $totales_recursos_poa;
   
    $institucion = Instituciones::find($user->id_institucion);
    $pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.recursosGestionPdf',compact('recursos','otros','total_recursos_planificado','institucion','gestionActiva'));
    return $pdf->download('recursosGestion.pdf');
  }
  public function reporteAccionesGestionPdf(){
    $user = \Auth::user();
    /////////////////////////
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();
    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
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

      
      
      
      $poa = ProyectoPoa::where('id_accion_eta',$obj->id)
                          ->where('id_institucion',$user->id_institucion)
                          ->where('gestion',$gestionActiva->gestion)
                          ->where('activo',true)
                          ->get();
      $conteo = $poa->count();

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

      $obj->cantidad_proyectos_poa= $conteo;
      $obj->poa = $array_resto_Poa;
    }
    $institucion = Instituciones::find($user->id_institucion);
   // dd($objetivo_indicador);
    $pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.accionesGestionPdf',compact('objetivo_indicador','gestionActiva','institucion'));
    $pdf->setPaper('letter', 'landscape');
    return $pdf->download('accionesGestion_'.$gestionActiva->gestion.'.pdf');
  }
  public function reporteFinancieroGestionPdf(){
    //return "Hola desde reporteFinancieroGestionPdf";
    $user = \Auth::user();

    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                          ->where('activo',true)
                                           ->first();

    $objetivos_eta = \DB::select("select 
                                              objetivos.id as id_accion_eta_objetivo,
                                              objetivos.nombre_objetivo  as descripcion,
                                              
                                              concat(arti.linea_base_cantidad,' ',arti.linea_base_unidad,' ',arti.linea_base_descripcion) as linea_base,
                                              indi.nombre_indicador,
                                              p_indi.valor,
                                              p_recu.monto
                                      from sp_eta_etapas_plan as plan,
                                        sp_eta_objetivos_eta as objetivos,
                                        sp_eta_articulacion_objetivo_indicador as arti,
                                        sp_eta_indicadores as indi,
                                        sp_eta_programacion_indicador as p_indi,
                                        
                                        sp_eta_programacion_recursos as p_recu,
                                        
                                        sp_eta_catalogo_acciones_eta as catEta,
                                        sp_eta_articulacion_catalogos as artPmra
                                      where plan.id_institucion = $user->id_institucion
                                        and objetivos.id_etapas_plan = plan.id
                                        and objetivos.id = arti.id_objetivo_eta
                                        and objetivos.id_accion_eta = catEta.id
                                        and objetivos.id_accion_eta = artPmra.id_accion_eta
                                        and arti.id_indicador = indi.id
                                        and arti.id = p_indi.id_articulacion_objetivo_indicador
                                        and arti.id = p_recu.id_articulacion_objetivo_indicador
                                        and p_indi.gestion = '$gestionActiva->gestion'
                                        and p_recu.gestion = '$gestionActiva->gestion'");
    
    foreach ($objetivos_eta as $row) {

        $financiero = FinancieroPoa::where('id_intitucion', $user->id_institucion)
                                    ->where('gestion',$gestionActiva->gestion)
                                    ->where('id_accion_eta',$row->id_accion_eta_objetivo)
                                    ->first();
        //dd($financiero);
        if($financiero){

          $row->monto_poa_planificado = $financiero->monto_poa_planificado; 
          $row->monto_poa_ejecutado = $financiero->monto_poa_ejecutado;
          $row->monto_poa_porcentaje = $financiero->monto_poa_porcentaje;
          $row->accion_poa_programado = $financiero->accion_poa_programado; 
          $row->accion_poa_ejecutado = $financiero->accion_poa_ejecutado;
          $row->accion_poa_porcentaje = $financiero->accion_poa_porcentaje;
          $row->porcentaje_ptdi  = $financiero->porcentaje_ptdi;
          $row->porcentaje_accion_ptdi  = $financiero->porcentaje_accion_ptdi;
          $row->porcentaje_pei = $financiero->porcentaje_pei;
          $row->causas_variacion  = $financiero->causas_variacion;
           
        }else{
          $row->monto_poa_planificado  = "";
          $row->monto_poa_ejecutado = "";
          $row->monto_poa_porcentaje = "";
          $row->accion_poa_programado = "";
          $row->accion_poa_ejecutado = "";
          $row->accion_poa_porcentaje = "";
          $row->porcentaje_accion_ptdi = "";
          $row->porcentaje_ptdi = "";
          $row->porcentaje_pei = "";
          $row->causas_variacion = "";

        }   

    }
    $institucion = Instituciones::find($user->id_institucion);
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.financieroGestionPdf',compact('objetivos_eta','gestionActiva','institucion'));
    $pdf->setPaper('legal', 'landscape');
    return $pdf->download('financieroGestion_'.$gestionActiva->gestion.'.pdf');
  }
  public function reporteInversionGestionPdf(){
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    /*$gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first();*/

    $user = \Auth::user();

    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                          ->where('activo',true)
                                           ->first();

    $estadoModulo = \DB::select("select estado_etapa from sp_eta_estado_etapas_seguimiento
                                                    where id_institucion =  $user->id_institucion
                                                    and valor_campo_etapa = 'sProyectosInversion'
                                                    and gestion = $gestionActiva->gestion");
    //dd($estadoModulo);
    if($estadoModulo[0]->estado_etapa == "En Elaboración"){
      $estado_etapa = true;
    }else{
      $estado_etapa = false;
    }
    
    
    //$gestion = '2018';
    /*$objetivoProyectos =\DB::select("select * from sp_eta_planes as plan,
                                      sp_eta_objetivos_eta as objetivos,
                                      sp_eta_articulacion_objetivo_indicador as arti,
                                      sp_eta_indicadores as indi,
                                      sp_eta_programacion_indicador as p_indi,
                                      sp_eta_catalogo_acciones_eta as catEta,
                                      sp_eta_articulacion_catalogos as artPmra
                        where plan.id_institucion = $user->id_institucion
                        and objetivos.id_plan = plan.id
                        and objetivos.id = arti.id_objetivo_eta
                        and objetivos.id_accion_eta = catEta.id
                        and objetivos.id_accion_eta = artPmra.id_accion_eta
                        and arti.id_indicador = indi.id
                        and arti.id = p_indi.id_articulacion_objetivo_indicador
                        and p_indi.gestion = '$gestionActiva->gestion'");*/
    
    $objetivoProyectos= \DB::select("select obj.id as id_accion_eta,
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
                          ->where('gestion',$gestionActiva->gestion)
                          ->where('activo',true)
                          ->whereNotNull('codigo_sisin')
                          ->get();
      $conteo = $poa->count();
                          
      foreach ($poa as $p) {
        $inv = ProyectoInversion::where('id_proyecto_poa',$p->id)
                            ->where('id_institucion',$user->id_institucion)
                            ->where('gestion',$gestionActiva->gestion)
                            ->where('activo',true)
                            ->first();
                            //dd('Inversion',$inv->count());
                            //
          if($inv){
            //dd('costo',$inv->costo_total_proyecto);
            $p->id_proyecto_inversion = $inv->id;
            $p->costo_total_proyecto = $inv->costo_total_proyecto;
            $p->periodo_ejecucion_al = $inv->periodo_ejecucion_al;
            $p->periodo_ejecucion_del = $inv->periodo_ejecucion_del;
            $p->concurrencia_eta_programado = $inv->concurrencia_eta_programado;
            $p->concurrencia_eta_ejecutado = $inv->concurrencia_eta_ejecutado;
            $p->concurrencia_porcentaje_ejecutado = $inv->concurrencia_porcentaje_ejecutado;
            $p->entidad_ejecutora_cod = $inv->entidad_ejecutora_cod;
            $p->entidad_ejecutora_denominacion = $inv->entidad_ejecutora_denominacion;
            $p->verificar_existe_proyectos_inversion = "si hay";

            $ent = EntidadesConcurrencia::select('id','nombre_entidad','programacion_entidad','ejecucion_entidad','porcentaje_ejecucion_entidad')
                                        ->where('id_proyecto_inversion', $inv->id_proyecto_poa)
                                        ->where('id_institucion',$user->id_institucion)
                                        ->where('gestion',$gestionActiva->gestion)
                                        ->where('activo',true)
                                        ->get();
            if($ent){

              $p->entidadesConcurrencia = $ent;
              $p->verificar_existe_entidades_concurrencia ="si hay";

            }else{
              $p->verificar_existe_entidades_concurrencia ="no hay";              
            }
            $maximo = \DB::select("select count(*) as numero_entidades
                                                    from sp_eta_entidades_concurrencia
                                                    where id_institucion = $user->id_institucion
                                                    and gestion = $gestionActiva->gestion
                                                    and id_proyecto_inversion = $inv->id_proyecto_poa");
            //dd($maximo);
            $p->cantidad_entidad = $maximo[0]->numero_entidades;
          }else{
            $p->verificar_existe_proyectos_inversion = "no hay";
          }
          $financiero = \DB::select("select * from sp_eta_financiero_poa
                                      where id_intitucion = $user->id_institucion
                                      and id_accion_eta = $obj->id_accion_eta
                                      and gestion = $gestionActiva->gestion");
          /*FinancieroPoa::where('id_intitucion', $user->id_institucion)
                                      ->where('id_accion_eta',$obj->id_accion_eta)
                                      ->where('gestion',$gestionActiva->gestion)
                                      ->first();*/
                                      //dd($financiero);
          $p->monto_poa_ejecutado = $financiero[0]->monto_poa_ejecutado;
          $p->monto_poa_planificado = $financiero[0]->monto_poa_planificado;
          $p->monto_poa_porcentaje = $financiero[0]->monto_poa_porcentaje;
      }

      
      $array_resto_Poa = [];
      $i=0;
      foreach ($poa as $key => $value) {
        
        if($key == 0){
          /////PRIMER POA
          $obj->primer_poa = $value;
          ////FIN PRIMER POA
        }else{
          $array_resto_Poa[$i] = $value;

        }
        $i++;
      }
      $obj->cantidad_proyectos_poa = $poa->count();
      $obj->proyectosInversion = $array_resto_Poa;
    }
    $maximo = \DB::select("SELECT MAX(count_num) as maximo FROM 
                                      (SELECT id_proyecto_inversion, count(*) as count_num
                                      FROM sp_eta_entidades_concurrencia 
                                      where id_institucion = $user->id_institucion
                                      and gestion = $gestionActiva->gestion
                                      and activo = true
                                      GROUP BY id_proyecto_inversion) x");
            //dd($maximo);
    $maximo_entidades = $maximo[0]->maximo;
    $institucion = Instituciones::find($user->id_institucion);
    //return $objetivoProyectos;
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.inversionGestionPdf',compact('objetivoProyectos','gestionActiva','maximo_entidades','institucion'));
    $pdf->setPaper('letter', 'landscape');
    return $pdf->download('inversionoGestion_'.$gestionActiva->gestion.'.pdf');
  }
  public function reporteFinancieroProgramaGestionPdf(){
    
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    /*$gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first(); */
    $user = \Auth::user();
    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                          ->where('activo',true)
                                           ->first();
    $estadoModulo = \DB::select("select estado_etapa from sp_eta_estado_etapas_seguimiento
                                                    where id_institucion =  $user->id_institucion
                                                    and valor_campo_etapa = 'sFisicaFinanciera'
                                                    and gestion = $gestionActiva->gestion");
    //dd($estadoModulo);
    if($estadoModulo[0]->estado_etapa == "En Elaboración"){
      $estado_etapa = true;
    }else{
      $estado_etapa = false;
    }
    $objetivo_indicador = \DB::select("select 
                                              catEta.nombre_accion_eta,
                                              objetivos.id_accion_eta as agregador,

                                              objetivos.id as id_accion_eta_objetivo,
                                              objetivos.nombre_objetivo  as descripcion,
                                              
                                              concat(arti.linea_base_cantidad,' ',arti.linea_base_unidad,' ',arti.linea_base_descripcion) as linea_base,
                                              indi.nombre_indicador,
                                              p_indi.valor,
                                              p_recu.monto
                                      from sp_eta_etapas_plan as plan,
                                        sp_eta_objetivos_eta as objetivos,
                                        sp_eta_articulacion_objetivo_indicador as arti,
                                        sp_eta_indicadores as indi,
                                        sp_eta_programacion_indicador as p_indi,
                                        
                                        sp_eta_programacion_recursos as p_recu,
                                        
                                        sp_eta_catalogo_acciones_eta as catEta,

                                        sp_eta_articulacion_catalogos as artPmra
                                      where plan.id_institucion = $user->id_institucion
                                        and objetivos.id_etapas_plan = plan.id
                                        and objetivos.id = arti.id_objetivo_eta
                                        and objetivos.id_accion_eta = catEta.id
                                        and objetivos.id_accion_eta = artPmra.id_accion_eta
                                        and arti.id_indicador = indi.id
                                        and arti.id = p_indi.id_articulacion_objetivo_indicador
                                        and arti.id = p_recu.id_articulacion_objetivo_indicador
                                        and p_indi.gestion = '$gestionActiva->gestion'
                                        and p_recu.gestion = '$gestionActiva->gestion'");
    //dd($objetivo_indicador);
    foreach ($objetivo_indicador as $riesgo) {
      $is_checked = \DB::select("select id,
                                        id_accion_eta,
                                        activo
                                    from sp_eta_gestion_riesgos
                                      where id_institucion = $user->id_institucion
                                      and gestion = $gestionActiva->gestion
                                      and id_accion_eta = $riesgo->id_accion_eta_objetivo
                                      ");
                                      //dd($is_checked);
      if($is_checked){
        $riesgo->id_gestion_riesgos = $is_checked[0]->id;//enviando id en la tabla gestion_riesgos
        $riesgo->es_gestion_riesgos = $is_checked[0]->activo;//enviando true or false
        $riesgo->gestion_riesgos = $is_checked[0]->activo;//enviando true or false
      }
    }
    //buscando si lo planificado ha sido comparado con el POA
    foreach ($objetivo_indicador as $r) {
      $id_accion_eta = $r->id_accion_eta_objetivo;
      
      $verificar = FinancieroPoa::where('id_accion_eta',$id_accion_eta)
                                  ->where('gestion',$gestionActiva->gestion)
                                  ->where('activo',true)
                                  ->where('id_intitucion',$user->id_institucion)
                                  ->get();
     
                                  
      if($verificar->count()>0){

        foreach ($verificar as $v) {
          $r->id_financiero_poa = $v->id;
          $r->monto_poa_planificado = $v->monto_poa_planificado ;
          $r->monto_poa_ejecutado = $v->monto_poa_ejecutado ;
          $r->monto_poa_porcentaje = $v->monto_poa_porcentaje ;
          $r->accion_poa_programado = $v->accion_poa_programado ;
          $r->accion_poa_ejecutado = $v->accion_poa_ejecutado ;
          $r->accion_poa_porcentaje = $v->accion_poa_porcentaje ;
          $r->porcentaje_ptdi = $v->porcentaje_ptdi ;
          $r->porcentaje_accion_ptdi = $v->porcentaje_accion_ptdi  ;
          $r->porcentaje_pei = $v->porcentaje_pei ;
          $r->causas_variacion     = $v->causas_variacion;

          

        }

      }else{
        //no hay valores
        $r->id_financiero_poa = "";
        $r->monto_poa_planificado = 0;
        $r->monto_poa_ejecutado = 0;
        $r->monto_poa_porcentaje = 0;
        $r->accion_poa_programado = 0;
        $r->accion_poa_ejecutado = 0;
        $r->accion_poa_porcentaje = 0;
        $r->porcentaje_ptdi = 0;
        $r->porcentaje_accion_ptdi = 0;
        $r->porcentaje_pei = 0;
        $r->causas_variacion = "";
      }
    }

    //SELECCIONANDO PROGRAMAS GLOBALES
    $distint = \DB::select("select 
                                    DISTINCT objetivos.id_accion_eta as agregador,
                                    UPPER(nombre_accion_eta ) as nombre_programa
                            from sp_eta_etapas_plan as plan,
                              sp_eta_objetivos_eta as objetivos,
                              sp_eta_articulacion_objetivo_indicador as arti,
                              sp_eta_indicadores as indi,
                              sp_eta_programacion_indicador as p_indi,
                              sp_eta_programacion_recursos as p_recu,
                              
                              sp_eta_catalogo_acciones_eta as catEta,
                              
                              sp_eta_articulacion_catalogos as artPmra
                              where plan.id_institucion = $user->id_institucion
                              and objetivos.id_etapas_plan = plan.id
                              and objetivos.id = arti.id_objetivo_eta
                              
                              and objetivos.id_accion_eta = catEta.id
                              
                              and objetivos.id_accion_eta = artPmra.id_accion_eta
                              and arti.id_indicador = indi.id
                              and arti.id = p_indi.id_articulacion_objetivo_indicador
                              and arti.id = p_recu.id_articulacion_objetivo_indicador
                              and p_indi.gestion = '$gestionActiva->gestion'
                              and p_recu.gestion = '$gestionActiva->gestion'
                              ORDER BY agregador");
    //ADICIONANDO AL PROGRAMA GLOBAL OBJETIVOS ETA
    $totales_programa = [];
    $orden = 1;
     $j = 0;
    foreach ($distint as $programa) {
      $programa->orden = $orden++;
      $id_programa = $programa->agregador;

      $i = 0;
     
      $objetivo_eta = [];
      $total_ptdi_planificado = 0;
      $total_ptdi_porcentaje_ejecutado = 0;
      $total_accion_ptdi_planificado = 0;
      $total_accion_ptdi_ejecutado = 0;
      $total_monto_poa_planificado = 0;
      $total_monto_poa_ejecutado = 0;
      $total_monto_poa_porcentaje = 0;
      $total_accion_poa_planificado = 0;
      $total_accion_poa_ejecutado = 0;
      $total_accion_poa_porcentaje = 0;
      $totales = [];
      $contador_objetivos_eta = 0;

      foreach ($objetivo_indicador as $obj) {
        if($id_programa == $obj->agregador){
          $objetivo_eta[$i] = $obj;
          //TOTALES
          $total_ptdi_planificado = $total_ptdi_planificado + $obj->monto;
          $total_ptdi_porcentaje_ejecutado = $total_ptdi_porcentaje_ejecutado + $obj->porcentaje_ptdi;
          $total_accion_ptdi_planificado = $total_accion_ptdi_planificado + $obj->valor;
          $total_accion_ptdi_ejecutado = $total_accion_ptdi_ejecutado + $obj->porcentaje_ptdi;
          $total_monto_poa_planificado = $total_monto_poa_planificado + $obj->monto_poa_planificado;
          $total_monto_poa_ejecutado = $total_monto_poa_ejecutado + $obj->monto_poa_ejecutado;
          $total_monto_poa_porcentaje = $total_monto_poa_porcentaje + $obj->monto_poa_porcentaje;
          $total_accion_poa_planificado = $total_accion_poa_planificado + $obj->accion_poa_programado;
          $total_accion_poa_ejecutado = $total_accion_poa_ejecutado + $obj->accion_poa_ejecutado;
          $total_accion_poa_porcentaje = $total_accion_poa_porcentaje + $obj->accion_poa_porcentaje;
          $contador_objetivos_eta++;
          //TOTALES
          $i++;
        }
        
      }
      
      $totales['agregador'] = $programa->agregador;
      $totales['total_ptdi_planificado'] = $total_ptdi_planificado;
      $totales['total_ptdi_porcentaje_ejecutado'] = $total_ptdi_porcentaje_ejecutado;
      $totales['total_accion_ptdi_planificado'] = $total_accion_ptdi_planificado;
      $totales['total_accion_ptdi_ejecutado'] = $total_accion_ptdi_ejecutado;
      $totales['total_monto_poa_planificado'] = $total_monto_poa_planificado;
      $totales['total_monto_poa_ejecutado'] = $total_monto_poa_ejecutado;
      $totales['total_monto_poa_porcentaje'] = $total_monto_poa_porcentaje/$contador_objetivos_eta;
      $totales['total_accion_poa_planificado'] = $total_accion_poa_planificado;
      $totales['total_accion_poa_ejecutado'] = $total_accion_poa_ejecutado;
      $totales['total_accion_poa_porcentaje'] = $total_accion_poa_porcentaje/$contador_objetivos_eta;

      $array_resto_Poa = [];
      $k=0;
      foreach ($objetivo_eta as $key => $value) {
        
        if($key == 0){
          $programa->primer_objetivo_eta = $value;
        }else{
          $array_resto_Poa[$k] = $value;

        }
        $k++;
      }
      

      //aqui sacar de el primer proyecto
      $programa->resto_objetivo_eta = $array_resto_Poa;
      $programa->contador_objetivos = $contador_objetivos_eta;

      $programa->totales = $totales;////REVISAR DESDE AQUI
      //dd($programa->totales);
      $j++;
      //$programa->ver = false;
    }
    //return $distint;
    
      $institucion = Instituciones::find($user->id_institucion);
      /*$region = \DB::select("SELECT *
                             FROM v_pip_catalogo_regiones_nivel_3
                             WHERE muni_codigo = ?",[$institucion->codigo_geografico]);
      me.arrayInstitucion = response.data.institucion;
              me.arrayUser = response.data.user;
      return $region;
      return \Response::json([
        'user' => $user,
        'institucion' => $institucion,
        'periodoActivo' => $periodoActual['gestionesPeriodo'],
        'gestionInicial' => $periodoActual['gestionInicial'],
        'gestionFinal' => $periodoActual['gestionFinal'],
        'region' => $region[0]

      ]);*/
      
      //return $arrayInstitucion;
      //return $distint;
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.financieroGestionProgramaPdf',compact('distint','gestionActiva','institucion','user'));
    $pdf->setPaper('legal', 'landscape');
    return $pdf->download('financieroGestion_'.$gestionActiva->gestion.'.pdf');
  }
  
} 

