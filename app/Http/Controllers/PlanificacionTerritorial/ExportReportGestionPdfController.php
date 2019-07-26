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
    $arrayContenido = RecursosPoa::where('id_institucion',$user->id_institucion)
                                -> where('gestion',$gestionActiva->gestion)
                                ->get();
    //dd($arrayContenido);
    foreach ($arrayContenido as $row) {

      $nombre_recurso = Parametros::where('categoria','tipo_recursos')
                          ->where('id',$row->id_tipo_recurso)
                          ->get();
      $row->recurso_nombre = $nombre_recurso[0]->nombre;

      $recurso_programado = \DB::select("select * from sp_eta_recursos_eta
                                                  where id_institucion = $user->id_institucion
                                                  and id_tipo_recurso = $row->id_tipo_recurso
                                                  and gestion = '$gestionActiva->gestion'");
      $row->recurso_programado = $recurso_programado[0]->monto;
    }
   //dd($arrayContenido);
    $arrayTotales = \DB::select("select sum(monto_poa_gestion) as poa,
                                        sum(diferencia_ptdi_poa) as dif_ptdi_poa,
                                        sum(diferencia_porcentaje_ptdi_poa) as por_dif_ptdi_poa,
                                        sum(diferencia_pei_poa) as dif_pei_poa,
                                        sum(monto_pei_gestion) as pei
                                        
                                from sp_eta_recursos_poa 
                                where id_institucion = $user->id_institucion
                                and gestion = $gestionActiva->gestion");
    //$now = Carbon::now();
    //$fecha = $now->format('d/m/Y  H:i');
    //
    /*$pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    $data = ['title' => 'Testing Page Number In Body'];
    $pdf->loadView('welcomeView', $data);*/
    $pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.recursosGestionPdf',compact('arrayContenido','arrayTotales','gestionActiva'));
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
   // dd($objetivo_indicador);
    $pdf = app('dompdf.wrapper');
    $pdf->getDomPDF()->set_option("enable_php", true);
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.accionesGestionPdf',compact('objetivo_indicador','gestionActiva'));
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
  //creando PDF
   //dd($objetivos_eta);
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.financieroGestionPdf',compact('objetivos_eta','gestionActiva'));
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
    //return $objetivoProyectos;
    $pdf = PDF::loadView('PlanificacionTerritorial.VistasPdf.inversionGestionPdf',compact('objetivoProyectos','gestionActiva','maximo_entidades'));
    $pdf->setPaper('letter', 'landscape');
    return $pdf->download('inversionoGestion_'.$gestionActiva->gestion.'.pdf');
  }
  
} 

