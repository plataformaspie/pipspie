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

class ExportReportGestionController extends BasecontrollerController
{
  public function reportePrueba(){
    return View('PlanificacionTerritorial/VistasPdf/accionesGestionPdf');
  }
  
  public function reporteRecursosGestionExcel(){
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
      //dd($arrayTotales);
    /*Excel::load('plantillas_territorial/plantilla_recursos.xlsx', function($excel) use ($arrayContenido,$arrayTotales)
    {
        //$excel->getActiveSheet('Recursos')->setCellValue('A7', 'Valor en A7');
        $excel->sheet('Recursos',function($hoja) use ($arrayContenido,$arrayTotales){
          $hoja->setCellValue('B4', 'PTDI/PGTC');
        });
    }) -> download('xls');*/
    Excel::load('plantillas_territorial/plantilla_recursos.xlsx', function($file) use($arrayTotales,$arrayContenido,$gestionActiva) {
       $file->sheet( 'Recursos', function ($sheet) use($arrayTotales,$arrayContenido,$gestionActiva){
        $sheet->setCellValue('C5',$gestionActiva->gestion);//colocando el valor inicial
        $sheet->setCellValue('F5',$gestionActiva->gestion);//colocando el valor inicial
        $sheet->setCellValue('I5',$gestionActiva->gestion);//colocando el valor inicial
        $i=7;
          $total_programado = 0;
        foreach ($arrayContenido as $r) {
          $sheet->setCellValue('B'.$i, $r->recurso_nombre);
          $sheet->setCellValue('C'.$i, $r->recurso_programado);
          $sheet->setCellValue('D'.$i, $r->diferencia_ptdi_poa);
          $sheet->setCellValue('E'.$i, $r->diferencia_porcentaje_ptdi_poa);
          $sheet->setCellValue('I'.$i, $r->monto_poa_gestion);
          $sheet->setCellValue('J'.$i, $r->causas_variacion);
          $total_programado = $total_programado + $r->recurso_programado;
          $i++;
        }
          $sheet->setCellValue('B'.$i, 'TOTAL');
          $sheet->setCellValue('C'.$i, $total_programado);
          $sheet->setCellValue('D'.$i, $arrayTotales[0]->dif_ptdi_poa);
          $sheet->setCellValue('E'.$i, $arrayTotales[0]->por_dif_ptdi_poa);
          $sheet->setCellValue('I'.$i, $arrayTotales[0]->poa);
            
       });
    })->download('xlsx');
  }
  
  public function reporteAccionesGestionExcel(){
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

      $obj->cantidad_proyectos_poa= $conteo;
      $obj->poa = $poa;
      
    }
    ///////////////////////////
    //return \Response::json(['objEta'=>$objetivo_indicador]);
    Excel::load('plantillas_territorial/plantilla_acciones.xlsx', function($file) use($objetivo_indicador,$gestionActiva) {
       $file->sheet( 'Acciones', function ($hoja) use($objetivo_indicador,$gestionActiva){
        $hoja->setCellValue('A4','GESTION : '.$gestionActiva->gestion);//colocando el valor inicial
        
        $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
        $color=0;

        $fila = 3;
        $inicioFila = 7; 
        $finFila =0;  //$inicioFila+$cantidad_proyectos
        foreach ($objetivo_indicador as $mifuente) {

          //$hoja->row(++$fila, $mifuente);
          //$cantidad_proyectos_poa = $mifuente->cantidad_proyectos_poa[0]->cantidad_proyectos_poa;
          $cantidad_proyectos_poa = $mifuente->cantidad_proyectos_poa;
         // dd($cantidad_proyectos_poa);
          if($cantidad_proyectos_poa > 0){

              $finFila = ($inicioFila + $cantidad_proyectos_poa)-1;////AQUI AQUI AQUI
              //dd($finFila);
              
              $hoja->cells('A'.$inicioFila.':A'.$finFila, function($cells) {
                $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');
                $cells->setAlignment('center');//horizontal
              });
              //dd($inicioFila, $finFila);
              $hoja->mergeCells('A'.$inicioFila.':A'.$finFila);//combinanado 
              $hoja->setCellValue('A'.$inicioFila, $mifuente->cod_p);
              
              //META
              $hoja->cells('B'.$inicioFila.':B'.$finFila, function($cells) {
                $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');
                $cells->setAlignment('center');//horizontal
              });
              $hoja->mergeCells('B'.$inicioFila.':B'.$finFila);//combinanado
              $hoja->setCellValue('B'.$inicioFila, $mifuente->cod_m);

              //RESULTADO
              $hoja->cells('C'.$inicioFila.':C'.$finFila, function($cells) {
                $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');
                $cells->setAlignment('center');//horizontal
              });
              $hoja->mergeCells('C'.$inicioFila.':C'.$finFila);//combinanado
              $hoja->setCellValue('C'.$inicioFila, $mifuente->cod_r);

              //ACCION
              $hoja->cells('D'.$inicioFila.':D'.$finFila, function($cells) {
                $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');//Vertical
                $cells->setAlignment('center');//horizontal

              });
              $hoja->mergeCells('D'.$inicioFila.':D'.$finFila);//combinanado
              $hoja->setCellValue('D'.$inicioFila, $mifuente->cod_a);

              //INSCRITO PTDI ACCION ETA
              $hoja->cells('E'.$inicioFila.':E'.$finFila, function($cells) {
                $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');//horizontal
              });
              $hoja->mergeCells('E'.$inicioFila.':E'.$finFila);//combinanado
              $hoja->setCellValue('E'.$inicioFila, $mifuente->nombre_accion_eta);

              //INSCRITO EN EL PEI
              $hoja->cells('F'.$inicioFila.':F'.$finFila, function($cells) {
                $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                
                $cells->setValignment('center');
                $cells->setAlignment('center');//horizontal
              });
              $hoja->mergeCells('F'.$inicioFila.':F'.$finFila);//combinanado
              $hoja->setCellValue('F'.$inicioFila, 'INSCRITO PEI');

              $proyectos = $mifuente->poa;
              //dd($proyectos);
              //dIBUJANDO PROYECTOS POA
              $i=$inicioFila;

              foreach ($proyectos as $p) {
                $hoja->cell('G'.$i, function($cell) use ($p) {
                  $cell->setValue($p->nombre);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                }); 
                //CATEGORIA PROGRAMATICA
                $hoja->cell('H'.$i, function($cell) use ($p) {
                  $cell->setValue($p->categoria_programatica);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                }); 
                
                $i++;
              }

              
              $color++;//COLOCANDO COLORA A TODOS LOS PROYECTOS POA
              $hoja->cells('A'.$inicioFila.':H'.$finFila, function($cells)use ($color, $paletaColor) {
                 //$cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');
                $cells->setAlignment('center');//horizontal
                $cells->setBackground($paletaColor[$color % count($paletaColor)]);

              });
              //FIN DIBUJANDO PROYECTOS POA

              $inicioFila = $finFila+1;
              //**************
              



          }else{
              //*********************** DIBUNAJDO LA FILA DE ACCION ETA******************
              $hoja->cell('A'.$inicioFila, function($cell) use ($mifuente) {
                $cell->setValue($mifuente->cod_p);
                $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cell->setValignment('center');
                $cell->setAlignment('center');//horizontal
              });
              $hoja->cell('B'.$inicioFila, function($cell) use ($mifuente) {
                $cell->setValue($mifuente->cod_m);
                $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cell->setValignment('center');
                $cell->setAlignment('center');//horizontal
              }); 
              $hoja->cell('C'.$inicioFila, function($cell) use ($mifuente) {
                $cell->setValue($mifuente->cod_r);
                $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cell->setValignment('center');
                $cell->setAlignment('center');//horizontal
              }); 
              $hoja->cell('D'.$inicioFila, function($cell) use ($mifuente) {
                $cell->setValue($mifuente->cod_a);
                $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cell->setValignment('center');
                $cell->setAlignment('center');//horizontal
              }); 
              $hoja->cell('E'.$inicioFila, function($cell) use ($mifuente) {
                $cell->setValue($mifuente->nombre_accion_eta);
                $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cell->setValignment('center');
                $cell->setAlignment('center');//horizontal
              }); 
              
              $hoja->cell('F'.$inicioFila, function($cell) use ($mifuente) {
                $cell->setValue("INSCRITO PEI");
                $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cell->setValignment('center');
                $cell->setAlignment('center');//horizontal
              }); 
              
              $color++;
              $hoja->cells('A'.$inicioFila.':K'.$inicioFila, function($cells) use ($color,$paletaColor) {
                $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');
                $cells->setAlignment('center');//horizontal
                $cells->setBackground($paletaColor[$color % count($paletaColor)]);
              }); 
             
              $hoja->mergeCells('G'.$inicioFila.':K'.$inicioFila);//combinanado 
              $hoja->setCellValue('G'.$inicioFila,"NO TIENE PROYECTOS POA");
              
              $inicioFila++; 

          }
        }
            
       });
    })->download('xlsx');
    //self::construirReporteAcciones($objetivo_indicador);
  }
  public function reporteFinancieroGestionExcel(){
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
          $row->porcentaje_pei = $financiero->porcentaje_pei;
          $row->causas_variacion  = $financiero->causas_variacion;
           
        }else{
          $row->monto_poa_planificado  = "";
          $row->monto_poa_ejecutado = "";
          $row->monto_poa_porcentaje = "";
          $row->accion_poa_programado = "";
          $row->accion_poa_ejecutado = "";
          $row->accion_poa_porcentaje = "";
          $row->porcentaje_ptdi = "";
          $row->porcentaje_pei = "";
          $row->causas_variacion = "";

        }   

    }
    //dd($objetivos_eta);
    Excel::load('plantillas_territorial/plantilla_financiero.xlsx', function($file) use($objetivos_eta,$gestionActiva) {
       $file->sheet( 'Financiero', function ($sheet) use($objetivos_eta,$gestionActiva){
        $sheet->setCellValue('A3','GESTION : '.$gestionActiva->gestion);//colocando el valor inicial
        
        $i=7;
          
        foreach ($objetivos_eta as $r) {
          $sheet->setCellValue('A'.$i, $r->descripcion);
          $sheet->setCellValue('B'.$i, $r->linea_base);
          $sheet->setCellValue('C'.$i, $r->nombre_indicador);
          $sheet->setCellValue('D'.$i, $r->monto);
          $sheet->setCellValue('E'.$i, $r->monto_poa_ejecutado);
          if($r->monto_poa_ejecutado){
            $sheet->setCellValue('F'.$i, ($r->monto_poa_ejecutado/$r->monto)*100);
          }else{
            $sheet->setCellValue('F'.$i,'');
          }
          
          $sheet->setCellValue('G'.$i, $r->valor);
          $sheet->setCellValue('H'.$i, $r->accion_poa_ejecutado);
          if($r->accion_poa_ejecutado){
            $sheet->setCellValue('I'.$i, ($r->accion_poa_ejecutado/$r->valor)*100);
          }else{
            $sheet->setCellValue('I'.$i,'');
          }
          
          $sheet->setCellValue('P'.$i, $r->monto_poa_planificado);
          $sheet->setCellValue('Q'.$i, $r->monto_poa_ejecutado);
          $sheet->setCellValue('R'.$i, $r->monto_poa_porcentaje);
          $sheet->setCellValue('S'.$i, $r->accion_poa_programado);
          $sheet->setCellValue('T'.$i, $r->accion_poa_ejecutado);
          $sheet->setCellValue('U'.$i, $r->accion_poa_porcentaje);
          $sheet->setCellValue('V'.$i, $r->causas_variacion);
          $i++;
        }
  
            
       });
    })->download('xlsx');    
  //return \Response::json(['objetivos_eta'=>$objetivos_eta]);
    //self::construirReporteFinanciero($arrayContenido);
  }
  public function reporteInversionGestionExcel(){
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

      $obj->proyectosInversion = $poa;
      $obj->cantidad_proyectos_poa = $poa->count();
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

    Excel::load('plantillas_territorial/plantilla_inversion.xlsx', function($file) use($objetivoProyectos,$gestionActiva,$maximo_entidades) {
       $file->sheet( 'Inversion', function ($hoja) use($objetivoProyectos,$gestionActiva,$maximo_entidades){
        $hoja->setCellValue('A3','GESTION : '.$gestionActiva->gestion);//colocando el valor inicial
        
        $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
        $cabeceraExcel = [
           'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
           'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
           'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
           'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
           'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
           'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
           'FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ','FK','FL','FM','FN','FO','FP','FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ',
           'GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ','GK','GL','GM','GN','GO','GP','GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ',
           'HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ','HK','HL','HM','HN','HO','HP','HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ',
           'IA','IB','IC','ID','IE','IF','IG','IH','II','IJ','IK','IL','IM','IN','IO','IP','IQ','IR','IS','IT','IU','IV','IW','IX','IY','IZ'
           ];
           $color=0;
        
           //DIBUJANDO ENTIDADES CONCURRENCTES
                $max_entidades = $maximo_entidades;
                $total_celdas = 12 + $max_entidades*4;
                //dd($total_celdas);
                //COLOCANDO COLORA A TODOS LOS PROYECTOS POA
                $color++;

                /*$hoja->cells($cabeceraExcel[13].'4:'.$cabeceraExcel[$total_celdas].'4', function($cells)use ($color, $paletaColor) {
                   //$cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                   //dd($cabeceraExcel[13].'4:'.$cabeceraExcel[$total_celdas].'4');
                  //$cells->setValignment('center');
                  //$cells->setAlignment('center');//horizontal
                  //dd('ingrese al color');
                  $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  $cells->setBackground('#FDFD96');

                });*/
                $hoja->mergeCells($cabeceraExcel[13].'4:'.$cabeceraExcel[$total_celdas].'4');//combinanado 
                $hoja->setCellValue($cabeceraExcel[13].'4',"ENTIDADES CONCURRENTES");
                $hoja->cell('N5:AC5',function($cell){
                  $cell->setBackground('#FDFD96');
                });//combinanado
               

                $inicio_cabecera = 13;
                for($j=1;$j<=$max_entidades;$j++){
                  
                  //13//17
                  
                  $hoja->mergeCells($cabeceraExcel[$inicio_cabecera].'5:'.$cabeceraExcel[$inicio_cabecera].'6');//combinanado 
                  $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].'5',"ENT.".$j); 
                  //14//18
                  $inicio_cabecera++;
                  $hoja->mergeCells($cabeceraExcel[$inicio_cabecera].'5:'.$cabeceraExcel[$inicio_cabecera].'6');//combinanado 
                  $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].'5',"Prog.");                   
                  //15//19
                  $inicio_cabecera++;
                  $hoja->mergeCells($cabeceraExcel[$inicio_cabecera].'5:'.$cabeceraExcel[$inicio_cabecera].'6');//combinanado 
                  $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].'5',"Ejec.");

                  //16//20
                  $inicio_cabecera++;  

                  $hoja->mergeCells($cabeceraExcel[$inicio_cabecera].'5:'.$cabeceraExcel[$inicio_cabecera].'6');//combinanado 
                  $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].'5',"Ejec.");
                  //dd($cabeceraExcel[$inicio_cabecera]);
                  //17//21
                  $inicio_cabecera++;
                  
                  
                  $hoja->cells($cabeceraExcel[13].'4:'.$cabeceraExcel[$total_celdas].'6', function($cells)use ($color, $paletaColor) {
                   //$cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                    $cells->setValignment('center');
                    $cells->setAlignment('center');//horizontal
                    //$cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                    $cells->setBackground('#FDFD96');

                  });
                  
                }

                $color++;
                $hoja->cells($cabeceraExcel[13].'4:'.$cabeceraExcel[$total_celdas].'300', function($cells)use ($color, $paletaColor) {
                   //$cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  $cells->setValignment('center');
                  $cells->setAlignment('center');//horizontal
                  $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  $cells->setBackground('#FDFD96');

                });

                //DIBUJNDO ENTIDAD EJECUTORIA
                $segunda_col = $inicio_cabecera;
                $segunda_col++;
                
                //dd($cabeceraExcel[$segunda_col]);

                $hoja->mergeCells($cabeceraExcel[$inicio_cabecera].'4:'.$cabeceraExcel[$segunda_col ].'4');//combinanadoAD4:AE4 
                $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].'4',"ENTIDAD EJECUTORA");
                
                $hoja->mergeCells($cabeceraExcel[$inicio_cabecera].'5:'.$cabeceraExcel[$inicio_cabecera].'6');//combinanado
                $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].'5',"COD. ENT.");//AD5:AD6

                
                $hoja->mergeCells($cabeceraExcel[$segunda_col].'5:'.$cabeceraExcel[$segunda_col ].'6');//combinanado 
                $hoja->setCellValue($cabeceraExcel[$segunda_col].'5',"DENOMINACION ENTIDAD");//AE5:AE6

                $color++;

                $hoja->cells($cabeceraExcel[$inicio_cabecera].'4:'.$cabeceraExcel[$segunda_col].'6', function($cells)use ($color, $paletaColor) {
                   //$cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  $cells->setValignment('center');
                  $cells->setAlignment('center');//horizontal
                  $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  $cells->setBackground($paletaColor[$color % count($paletaColor)]);

                });



        //DIBUJANDO CONTENIDO 
        

        $contador = 1;
        $fila = 3;
        $inicioFila = 7; 
        $finFila =0;  //$inicioFila+$cantidad_proyectos
        foreach ($objetivoProyectos as $mifuente) {

          //$hoja->row(++$fila, $mifuente);
          //$cantidad_proyectos_poa = $mifuente->cantidad_proyectos_poa[0]->cantidad_proyectos_poa;
          $cantidad_proyectos_poa = $mifuente->cantidad_proyectos_poa;
         // dd($cantidad_proyectos_poa);
          if($cantidad_proyectos_poa > 0){

              $finFila = ($inicioFila + $cantidad_proyectos_poa)-1;////AQUI AQUI AQUI
              //dd($finFila);
              
              $hoja->cells('A'.$inicioFila.':A'.$finFila, function($cells) {
                $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');
                $cells->setAlignment('center');//horizontal
              });
              //dd($inicioFila, $finFila);
              $hoja->mergeCells('A'.$inicioFila.':A'.$finFila);//combinanado 
              $hoja->setCellValue('A'.$inicioFila, $contador);
              
              //META
              $hoja->cells('B'.$inicioFila.':B'.$finFila, function($cells) {
                $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');
                $cells->setAlignment('center');//horizontal
              });
              $hoja->mergeCells('B'.$inicioFila.':B'.$finFila);//combinanado
              $hoja->setCellValue('B'.$inicioFila, $mifuente->nombre_accion_eta);

              

              $proyectos = $mifuente->proyectosInversion;
              //dd($proyectos);
              //dIBUJANDO PROYECTOS POA
              $i=$inicioFila;

              foreach ($proyectos as $p) {
                if($p->inscrito_ptdi == true){
                  $hoja->setCellValue('C'.$i, 'X');  
                }else{
                  $hoja->setCellValue('C'.$i, '');  
                }
                if($p->inscrito_pei == true){
                  $hoja->setCellValue('D'.$i, 'X');  
                }else{
                  $hoja->setCellValue('D'.$i, '');  
                }
                if($p->inscrito_poa == true){
                  $hoja->setCellValue('E'.$i, 'X');  
                }else{
                  $hoja->setCellValue('D'.$i, '');  
                }

                $hoja->setCellValue('F'.$i, $p->codigo_sisin); 
                $hoja->setCellValue('G'.$i, $p->nombre); 
                $hoja->setCellValue('H'.$i, $p->costo_total_proyecto); 
                $date_del = date_create($p->periodo_ejecucion_del);
                $hoja->setCellValue('I'.$i, date_format($date_del, 'd/m/Y')); 
                $date_al = date_create($p->periodo_ejecucion_al);
 
                $hoja->setCellValue('J'.$i, date_format($date_al, 'd/m/Y')); 
                $hoja->setCellValue('K'.$i, $p->monto_poa_planificado); 
                $hoja->setCellValue('L'.$i, $p->monto_poa_ejecutado); 
                $hoja->setCellValue('M'.$i, $p->monto_poa_porcentaje);
                //DIBUJANDO ENTIDADES CONCURRENCTES
                $ent = $p->entidadesConcurrencia;
                $cantidad_ent = $p->cantidad_entidad;
                $max_entidades = $maximo_entidades;
                $total_celdas = 12 + $max_entidades*4;
                $inicio_cabecera = 13;
                $inicio_color  = 13;
                $resta = $max_entidades - $cantidad_ent;
                foreach ($ent as $ent) {
                  $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].$i, $ent->nombre_entidad);

                  $inicio_cabecera++;
                  $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].$i, $ent->programacion_entidad);

                  $inicio_cabecera++;
                  $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].$i, $ent->ejecucion_entidad);

                  $inicio_cabecera++;
                  $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].$i, $ent->porcentaje_ejecucion_entidad);

                  $inicio_cabecera++;
                }
                if($resta>0){
                  for ($r=0; $r <= $resta ; $r++) { 
                    $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].$i, '');

                    $inicio_cabecera++;
                    $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].$i, '');

                    $inicio_cabecera++;
                    $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].$i, '');

                    $inicio_cabecera++;
                    $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].$i,'');

                    $inicio_cabecera++; 
                  }
                }
               /* $color++;//COLOCANDO COLORA A TODOS LOS PROYECTOS POA
                $hoja->cells($cabeceraExcel[$inicio_color].$i.':'.$cabeceraExcel[$inicio_cabecera].$i, function($cells)use ($color, $paletaColor) {
                  $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  $cells->setValignment('center');
                  $cells->setAlignment('center');//horizontal
                  $cells->setBackground('#FDFD96');

                });*/
                //FIN DIBUJANDO ENTIDADES CONCURRENCTES
                //DIBUJANDO ENTIDADES EJECUTORA
                $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].$i, $p->entidad_ejecutora_cod);
                $inicio_cabecera++;
                $hoja->setCellValue($cabeceraExcel[$inicio_cabecera].$i, $p->entidad_ejecutora_denominacion);
                /*
                $color++;//COLOCANDO COLORA A TODOS LOS PROYECTOS POA
                $hoja->cells('A'.$inicioFila.':H'.$finFila, function($cells)use ($color, $paletaColor) {
                 //$cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');
                $cells->setAlignment('center');//horizontal
                $cells->setBackground($paletaColor[$color % count($paletaColor)]);

              });*/
                ////DIBUJANDO ENTIDADES EJECUTORA
                
                $i++;
              }

              
              
              //FIN DIBUJANDO PROYECTOS POA

              $inicioFila = $finFila+1;
              //**************
              



          }else{
              //*********************** DIBUNAJDO LA FILA DE ACCION ETA******************
              $hoja->cell('A'.$inicioFila, function($cell) use ($mifuente) {
                $cell->setValue($mifuente->$contador);
                $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cell->setValignment('center');
                $cell->setAlignment('center');//horizontal
              });
              $hoja->cell('B'.$inicioFila, function($cell) use ($mifuente) {
                $cell->setValue($mifuente->nombre_accion_eta);
                $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cell->setValignment('center');
                $cell->setAlignment('center');//horizontal
              }); 
              
              
              $color++;
              $hoja->cells('A'.$inicioFila.':K'.$inicioFila, function($cells) use ($color,$paletaColor) {
                $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');
                $cells->setAlignment('center');//horizontal
                $cells->setBackground($paletaColor[$color % count($paletaColor)]);
              }); 
             
              $hoja->mergeCells('C'.$inicioFila.':M'.$inicioFila);//combinanado 
              $hoja->setCellValue('C'.$inicioFila,"NO TIENE REGISTRADO INFORMACION DEL PROYECTO");
              
              $inicioFila++; 

          }
        }
            
       });
    })->download('xlsx');

    
    
    //return \Response::json(['objetivoInversion'=>$objetivoProyectos]);
    //self::construirReporteInversion($objetivoProyectos);
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
    $pdf->setPaper('letter', 'landscape');
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

      $obj->proyectosInversion = $poa;
      $obj->cantidad_proyectos_poa = $poa->count();
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

