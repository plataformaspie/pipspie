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




use Excel;

class ExportReportController extends BasecontrollerController
{
  
  public function reporteRecursos(){
    
    $user = \Auth::user();
    $datos = EvaluacionReporteRecursos::where('id_institucion',$user->id_institucion)
                                      ->where('activo',true)
                                      ->get();
  
    $arrayContenido = []; 
    $fila = [];
    $i =0;
                                         
    foreach ($datos as $row) {

      $nombre_recurso = Parametros::where('categoria','tipo_recursos')
                          ->where('id',$row->id_recurso)
                          ->get();

      array_push($fila, $nombre_recurso[0]->nombre,
                      number_format($row->ptdi_pro_2016,2,",","."),
                      
                      number_format($row->ptdi_pro_2017,2,",","."),
                      number_format($row->ptdi_pro_2018,2,",","."),
                      $row->ptdi_total_2016_2018,
                      $row->ptdi_dif_a_poa,
                      $row->ptdi_dif_porcentaje,
                      $row->pei_pro_2016,
                      $row->pei_pro_2017,
                      $row->pei_pro_2018,
                      $row->pei_total_2016_2018,
                      $row->pei_dif_a_poa,
                      $row->pei_dif_porcentaje,
                      $row->poa_pro_2016,
                      $row->poa_pro_2017,
                      $row->poa_pro_2018,
                      $row->poa_total_2016_2018,
                      $row->causas_de_variacion);
      
      $arrayContenido[$i] = $fila;
      $i++;
      $fila = [];
    }
    $totales = \DB::select("select sum(ptdi_pro_2016) as ptdi_total_2016,
                                   sum(ptdi_pro_2017) as ptdi_total_2017,
                                   sum(ptdi_pro_2018) as ptdi_total_2018,
                                   sum(ptdi_total_2016_2018) as ptdi_total_2016_2018,
                                   sum(ptdi_dif_a_poa) as ptdi_total_dif_a_poa,
                                   sum(ptdi_dif_porcentaje) as ptdi_total_dif_porcentaje,
                                   sum(pei_pro_2016) as pei_total_2016,
                                   sum(pei_pro_2017) as pei_total_2017,
                                   sum(pei_pro_2018) as pei_total_2018,
                                   sum(pei_total_2016_2018) as pei_total_2016_2018,
                                   sum(pei_dif_a_poa) as pei_total_dif_a_poa,
                                   sum(pei_dif_porcentaje) as pei_total_dif_porcentaje,
                                   sum(poa_pro_2016) as poa_total_2016,
                                   sum(poa_pro_2017) as poa_total_2017,
                                   sum(poa_pro_2018) as poa_total_2018,
                                   sum(poa_total_2016_2018) as poa_total_2016_2018
                            from sp_eta_evaluacion_reporte_recursos
                            where id_institucion = $user->id_institucion
                            and activo=true");
    
    $arrayTotales=[];
    array_push($arrayTotales,"Totales",
                            $totales[0]->ptdi_total_2016,
                            $totales[0]->ptdi_total_2017,
                           $totales[0]->ptdi_total_2018,
                           $totales[0]->ptdi_total_2016_2018,
                           $totales[0]->ptdi_total_dif_a_poa,
                           $totales[0]->ptdi_total_dif_porcentaje,
                           $totales[0]->pei_total_2016,
                           $totales[0]->pei_total_2017,
                           $totales[0]->pei_total_2018,
                           $totales[0]->pei_total_2016_2018,
                           $totales[0]->pei_total_dif_a_poa,
                           $totales[0]->pei_total_dif_porcentaje,
                           $totales[0]->poa_total_2016,
                           $totales[0]->poa_total_2017,
                           $totales[0]->poa_total_2018,
                           $totales[0]->poa_total_2016_2018);
    //dd($arraytotales);

    //dd($arrayContenido);
    self::construirReporteRecursos($arrayContenido,$arrayTotales);
  }
  static function construirReporteRecursos($arrayContenido,$arrayTotales){

    

    Excel::create('Evaluacion_Recursos', function($excel) use ($arrayContenido,$arrayTotales){
    //CONSTRUYENDO DOCUMENTO EXCEL///
      // Set the file properties
      $excel->setTitle('Registered users')
          ->setCreator('Web App')
          ->setCompany('Client Company')
          ->setDescription('Fictional Users in Company');
      //Create sheet
      $excel->sheet('Actual users', function($hoja) use ($arrayContenido,$arrayTotales) {
        //set general font style
        $hoja->setStyle(array(
            'font' => array(
                'name'      =>  'Calibri',
                'size'      =>  11,
                'bold'      =>  false
            )
        ));
        //creando la cabecera
        
        $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
        $color=0;
        //set background to headers Fuente Ingresos
        $hoja->cells('A4:A5', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);

          });
        $hoja->mergeCells('A4:A5');//combinanado

        $hoja->setCellValue('A4', 'FUENTE  INGRESOS');//colocando el valor inicial
        //PTDI
        $color++;
        $hoja->cells('B4:G5', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });
        $hoja->mergeCells('B4:G4');//combinanado
        $hoja->setCellValue('B4', 'PTDI/PGTC');//colocando el valor inicial
        $hoja->cell('B5', function($cell) {
            $cell->setValue('2016 Prog.');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
            
        });
        $hoja->cell('C5', function($cell) {
            $cell->setValue('2017  Prog.');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('D5', function($cell) {
            $cell->setValue('2018  Prog.');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('E5', function($cell) {
            $cell->setValue('TOTAL 2016-2018');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('F5', function($cell) {
            $cell->setValue('DIF A POA');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('G5', function($cell) {
            $cell->setValue('DIF %');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        }); 
        //CONTRUYENDO PEI
        $color++;
        $hoja->cells('H4:M5', function($cells) use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });
        $hoja->mergeCells('H4:M4');//combinanado
        $hoja->setCellValue('H4', 'PEI');//colocando el valor inicial
        $hoja->cell('H5', function($cell) {
            $cell->setValue('2016 Prog.');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('I5', function($cell) {
            $cell->setValue('2017  Prog.');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('J5', function($cell) {
            $cell->setValue('2018  Prog.');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('K5', function($cell) {
            $cell->setValue('TOTAL 2016-2018');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('L5', function($cell) {
            $cell->setValue('DIF A POA');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('M5', function($cell) {
            $cell->setValue('DIF %');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        /************/ 
        //CONTRUYENDO POA
        $color++;
        $hoja->cells('N4:Q5', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });
        $hoja->mergeCells('N4:Q4');//combinanado
        $hoja->setCellValue('N4', 'POA');//colocando el valor inicial
        $hoja->cell('N5', function($cell) {
            $cell->setValue('2016 Prog.');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('O5', function($cell) {
            $cell->setValue('2017  Prog.');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('P5', function($cell) {
            $cell->setValue('2018  Prog.');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('Q5', function($cell) {
            $cell->setValue('TOTAL 2016-2018');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        
        $color++;
        //set background to headers Fuente Ingresos
        $hoja->cells('R4:R5', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);

          });
        $hoja->mergeCells('R4:R5');//combinanado

        $hoja->setCellValue('R4', 'CAUSAS DE VARIACION');//colocando el valor inicial
        $hoja->getStyle('A1:R100' , $hoja->getHighestRow())->getAlignment()->setWrapText(true);
        $fila = 6;
          
        foreach ($arrayContenido as $mifuente) {

          $hoja->row(++$fila, $mifuente);
        }
        
        $hoja->row(++$fila, $arrayTotales);
        


        
          
      });
    //FIN CONSTRUYENDO DOCUMENTO EXCEL///  
    })->download('xlsx');
  }
  public function reporteAccionesExcel(){
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

      $obj->cantidad_proyectos_poa= $conteo;
      $obj->poa = $poa;
      
    }
    ///////////////////////////
    //return \Response::json(['objEta'=>$objetivo_indicador]);
    self::construirReporteAcciones($objetivo_indicador);
  }
  static function construirReporteAcciones($arrayContenido){

    Excel::create('Evaluacion_Acciones', function($excel) use ($arrayContenido){
    //CONSTRUYENDO DOCUMENTO EXCEL///
      // Set the file properties
      $excel->setTitle('Registered users')
          ->setCreator('Web App')
          ->setCompany('Client Company')
          ->setDescription('Fictional Users in Company');
      //Create sheet
      $excel->sheet('Evaluacion_Acciones', function($hoja) use ($arrayContenido) {
        //set general font style
        $hoja->setStyle(array(
            'font' => array(
                'name'      =>  'Calibri',
                'size'      =>  11,
                'bold'      =>  false
            )
        ));
        //creando la cabecera
        
        $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
        $color=0;
        //set background to headers Fuente Ingresos
        //ARTICULACION PDES
        $hoja->cells('A2:D3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);

          });
        $hoja->mergeCells('A2:D2');//combinanado

        $hoja->setCellValue('A2', 'ARTICULACION PDES');//colocando 
                       
        $hoja->cell('A3', function($cell) {
            $cell->setValue('P');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
            
        });
        $hoja->cell('B3', function($cell) {
            $cell->setValue('M');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('C3', function($cell) {
            $cell->setValue('R');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('D3', function($cell) {
            $cell->setValue('A');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        //INSCRITO PTDI
        $color++;
        $hoja->cells('E2:E3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);

        });
        $hoja->mergeCells('E2:E3');//combinanado

        $hoja->setCellValue('E2', 'INSCRITO EN PTDI/PGTC ACCION ETA');//colocando el valor inicial

        //INSCRITO PEI
        $color++;
        $hoja->cells('F2:F3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);

        });
        $hoja->mergeCells('F2:F3');//combinanado

        $hoja->setCellValue('F2', 'INSCRITO EN PEI');//colocando el valor inicial

        //INSCRITO POA
        $color++;
        $hoja->cells('G2:G3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);

        });
        $hoja->mergeCells('G2:G3');//combinanado

        $hoja->setCellValue('G2', 'INSCRITO EN POA');//colocando el valor inicial

        //CATEGORIA PROGRAMATICA
        $color++;
        $hoja->cells('H2:H3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);

        });
        $hoja->mergeCells('H2:H3');//combinanado

        $hoja->setCellValue('H2', 'COD. CAT. PROG');//colocando el valor inicial

        //GESTION
        $color++;
        $hoja->cells('I2:K3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);

        });
        $hoja->mergeCells('I2:K2');//combinanado

        $hoja->setCellValue('I2', 'GESTION');//colocando el valor inicial
        $hoja->cell('I3', function($cell) {
            $cell->setValue('2016 PROG.');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('J3', function($cell) {
            $cell->setValue('2017 PROG');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        }); 
        $hoja->cell('K3', function($cell) {
            $cell->setValue('2018 PROG');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        }); 
        
        $hoja->getStyle('A1:R100' , $hoja->getHighestRow())->getAlignment()->setWrapText(true);
        $hoja->setWidth(array(
            'A'     =>  11,
            'B'     =>  11,
            'C'     =>  11,
            'D'     =>  11,
            'E'     =>  30,
            'F'     =>  30,
            'G'     =>  30,
            'H'     =>  11,
            'I'     =>  11,
            'J'     =>  11,
            'K'     =>  11,
            'L'     =>  11,
            'M'     =>  11,
            'N'     =>  11,
            'O'     =>  11,
            'P'     =>  11,
            'Q'     =>  11,
            'R'     =>  11,
            'S'     =>  11,
            'T'     =>  11,
            'U'     =>  11,
            'V'     =>  11,
            'W'     =>  11,
            'X'     =>  11,
            'Y'     =>  11,
            'Z'     =>  11,
          ));
        
        $fila = 3;
        $inicioFila = 4; 
        $finFila =0;  //$inicioFila+$cantidad_proyectos
        foreach ($arrayContenido as $mifuente) {

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
                //GESTION 2016
                $hoja->cell('I'.$i, function($cell) use ($p)  {
                  if($p->gestion == 2016){
                    $cell->setValue('X');
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  }else{
                    $cell->setValue('');
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  }

                  
                });
                //GESTION 2017
                $hoja->cell('J'.$i, function($cell) use ($p) {
                  if($p->gestion == 2017){
                    $cell->setValue('X');
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  }else{
                    $cell->setValue('');
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes  
                  }
                  
                });
                //GESTION 2018
                $hoja->cell('K'.$i, function($cell) use ($p) {
                  if($p->gestion == 2018){
                    $cell->setValue('X');
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes  
                  }else{
                    $cell->setValue('');
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  }
                  $cell->setValignment('center');
                });
                $i++;
              }

              
              $color++;//COLOCANDO COLORA A TODOS LOS PROYECTOS POA
              $hoja->cells('A'.$inicioFila.':K'.$finFila, function($cells)use ($color, $paletaColor) {
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
    //FIN CONSTRUYENDO DOCUMENTO EXCEL///  
    })->download('xlsx');
  }
  public function reporteFinancieroExcel(){
    $user = \Auth::user();
    $datos = EvaluacionReporteFinanciero::where('id_institucion',$user->id_institucion)
                                      ->where('activo',true)
                                      ->get();
    
    
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
      $descripcion_accion_eta = $accion_eta[0]->nombre_objetivo;
      

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
      $fila = [];
    }
    

    self::construirReporteFinanciero($arrayContenido);
  }
  static function construirReporteFinanciero($arrayContenido){

    Excel::create('Evaluacion_Financiero', function($excel) use ($arrayContenido){

    //CONSTRUYENDO DOCUMENTO EXCEL///
      // Set the file properties
      
      $excel->setTitle('Registered users')
          ->setCreator('Web App')
          ->setCompany('Client Company')
          ->setDescription('Fictional Users in Company');
      //Create sheet
      $excel->sheet('Evaluacion_Financiero', function($hoja) use ($arrayContenido) {
        //set general font style
        $hoja->setStyle(array(
            'font' => array(
                'name'      =>  'Calibri',
                'size'      =>  11,
                'bold'      =>  false
            )
        ));
        //creando la cabecera
        
        $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
        $color=0;
        //set background to headers Fuente Ingresos
        //ACCION ETA
        $hoja->cells('A2:A4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });
        $hoja->mergeCells('A2:A4');//combinanado
        $hoja->setCellValue('A2', 'ACCION ETA');//colocando

        //PLANIFICACION
        $color++;
        $hoja->cells('B2:D4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
           
           $cells->setValignment('middle');
        });
        $hoja->mergeCells('B2:D3');//combinanado
        $hoja->setCellValue('B2', 'PLANIFICACION');//colocando 
                       
        $hoja->cell('B4', function($cell) {
            $cell->setValue('PTDI/PGTC');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
            $cell->setValignment('middle');
            $cell->setAlignment('middle');

            
        });
        $hoja->cell('C4', function($cell) {
            $cell->setValue('PEI');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
            $cell->setValignment('middle');
            $cell->setAlignment('middle');
            
        });
        $hoja->cell('D4', function($cell) {
            $cell->setValue('POA');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
            $cell->setValignment('middle');
            $cell->setAlignment('middle');
            
        });

        //EN RELACION A LA PROGRAMACION
        $color++;
        $hoja->cells('E2:O4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });
        
        $hoja->mergeCells('E2:O2');//combinanado
        $hoja->setCellValue('E2', 'EN RELACION A LA PLANIFICACION');//colocando 

        $hoja->cells('E3:F3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           //$cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });
        $hoja->mergeCells('E3:F3');//combinanado
        $hoja->setCellValue('E3', '2016');//colocando
        $hoja->cell('E4', function($cell) {
          $cell->setValue('Pf');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('F4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cells('G3:H3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('G3:H3');//combinanado
        $hoja->setCellValue('G3', '2017');//colocando
        $hoja->cell('G4', function($cell) {
          $cell->setValue('Pf');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('H4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
         $hoja->cells('I3:J3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('I3:J3');//combinanado
        $hoja->setCellValue('I3', '2018');//colocando
        $hoja->cells('K3:K4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('K3:K4');//combinanado
        $hoja->cell('I4', function($cell) {
          $cell->setValue('Pf');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('J4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->setCellValue('K3', 'TOTAL PRESUPUESTO PROGRAMADO');//colocando

        $hoja->cells('L3:L4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('L3:L4');//combinanado
        $hoja->setCellValue('L3', 'TOTAL PRESUPUESTO EJECUTADO');//colocando
        $hoja->cells('M3:M4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('M3:M4');//combinanado
        $hoja->setCellValue('M3', '% EJECUCION');//colocando
        $hoja->cells('N3:N4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('N3:N4');//combinanado
        $hoja->setCellValue('N3', 'META AL 2020');//colocando
        $hoja->cells('O3:O4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('O3:O4');//combinanado
        $hoja->setCellValue('O3', '% EJECUCION EN RELACION A LA META 2020');//colocando

        //EN RELACION A LA PROGRAMACION DE ACCIONES
        $color++;
        $hoja->cells('P2:Z4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });

        $hoja->mergeCells('P2:Z2');//combinanado
        $hoja->setCellValue('P2', 'EN RELACION A LA PROGRAMACION DE ACCIONES');//colocando 
        $hoja->cells('P3:Q3', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('P3:Q3');//combinanado
        $hoja->setCellValue('P3', '2016');//colocando 
        $hoja->cell('P4', function($cell) {
          $cell->setValue('PA');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('Q4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cells('R3:S3', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('R3:S3');//combinanado
        $hoja->setCellValue('R3', '2017');//colocando
        $hoja->cell('R4', function($cell) {
          $cell->setValue('Pa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('S4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cells('T3:U3', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('T3:U3');//combinanado
        $hoja->setCellValue('T3', '2018');//colocando
        $hoja->cell('T4', function($cell) {
          $cell->setValue('Pa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('U4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cells('V3:V4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('V3:V4');//combinanado
        $hoja->setCellValue('V3', 'TOTAL PROGRAMACION DE ACCIONES');//colocando
        $hoja->cells('W3:W4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('W3:W4');//combinanado
        $hoja->setCellValue('W3', 'TOTAL ACCIONES EJECUTADAS');//colocando
        $hoja->cells('X3:X4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('X3:X4');//combinanado
        $hoja->setCellValue('X3', '% EJECUCION');//colocando
        $hoja->cells('Y3:Y4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('Y3:Y4');//combinanado
        $hoja->setCellValue('Y3', 'META AL 2020');//colocando
        $hoja->cells('Z3:Z4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('Z3:Z4');//combinanado
        $hoja->setCellValue('Z3', '% EJECUCION EN RELACION A LA META 2020');//colocando

        //CAUSAS DE VARIACION
        $color++;
        $hoja->cells('AA2:AA4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });

        $hoja->mergeCells('AA2:AA4');//combinanado
        $hoja->setCellValue('AA2', 'CAUSAS DE VARIACION');//colocando 

        
        $hoja->getStyle('A1:R100' , $hoja->getHighestRow())->getAlignment()->setWrapText(true);
        
        $hoja->setWidth(array(
            'A'     =>  11,
            'B'     =>  11,
            'C'     =>  11,
            'D'     =>  11,
            'E'     =>  11,
            'F'     =>  11,
            'G'     =>  11,
            'H'     =>  11,
            'I'     =>  11,
            'J'     =>  11,
            'K'     =>  11,
            'L'     =>  11,
            'M'     =>  11,
            'N'     =>  11,
            'O'     =>  11,
            'P'     =>  11,
            'Q'     =>  11,
            'R'     =>  11,
            'S'     =>  11,
            'T'     =>  11,
            'U'     =>  11,
            'V'     =>  11,
            'W'     =>  11,
            'X'     =>  11,
            'Y'     =>  11,
            'Z'     =>  11,
            'AA'    =>  40
          ));
        
        $fila = 4;
        
          foreach ($arrayContenido as $mifuente) {

              $hoja->row(++$fila,$mifuente);
              
          }
          
        
          
      });
    //FIN CONSTRUYENDO DOCUMENTO EXCEL///  
    })->download('xlsx');
  }
  public function reporteRiesgosExcel(){
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
      $descripcion_accion_eta = $accion_eta[0]->nombre_objetivo;
      

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
      $fila = [];
    }
    self::construirReporteGestionRiesgos($arrayContenido);
  }
  static function construirReporteGestionRiesgos($arrayContenido){

    Excel::create('Evaluacion_Gestion_Riesgos', function($excel) use ($arrayContenido){

    //CONSTRUYENDO DOCUMENTO EXCEL///
      // Set the file properties
      
      $excel->setTitle('Registered users')
          ->setCreator('Web App')
          ->setCompany('Client Company')
          ->setDescription('Fictional Users in Company');
      //Create sheet
      $excel->sheet('Evaluacion_Gestion_Riesgos', function($hoja) use ($arrayContenido) {
        //set general font style
        $hoja->setStyle(array(
            'font' => array(
                'name'      =>  'Calibri',
                'size'      =>  11,
                'bold'      =>  false
            )
        ));
        //creando la cabecera
        
        $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
        $color=0;
        //set background to headers Fuente Ingresos
        //ACCION ETA
        $hoja->cells('A2:A4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });
        $hoja->mergeCells('A2:A4');//combinanado
        $hoja->setCellValue('A2', 'ACCION ETA');//colocando

        //PLANIFICACION
        $color++;
        $hoja->cells('B2:D4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
           
           $cells->setValignment('middle');
        });
        $hoja->mergeCells('B2:D3');//combinanado
        $hoja->setCellValue('B2', 'PLANIFICACION');//colocando 
                       
        $hoja->cell('B4', function($cell) {
            $cell->setValue('PTDI/PGTC');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
            $cell->setValignment('middle');
            $cell->setAlignment('middle');

            
        });
        $hoja->cell('C4', function($cell) {
            $cell->setValue('PEI');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
            $cell->setValignment('middle');
            $cell->setAlignment('middle');
            
        });
        $hoja->cell('D4', function($cell) {
            $cell->setValue('POA');
            $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
            $cell->setValignment('middle');
            $cell->setAlignment('middle');
            
        });

        //EN RELACION A LA PROGRAMACION
        $color++;
        $hoja->cells('E2:O4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });
        
        $hoja->mergeCells('E2:O2');//combinanado
        $hoja->setCellValue('E2', 'EN RELACION A LA PLANIFICACION');//colocando 

        $hoja->cells('E3:F3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           //$cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });
        $hoja->mergeCells('E3:F3');//combinanado
        $hoja->setCellValue('E3', '2016');//colocando
        $hoja->cell('E4', function($cell) {
          $cell->setValue('Pf');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('F4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cells('G3:H3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('G3:H3');//combinanado
        $hoja->setCellValue('G3', '2017');//colocando
        $hoja->cell('G4', function($cell) {
          $cell->setValue('Pf');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('H4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
         $hoja->cells('I3:J3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('I3:J3');//combinanado
        $hoja->setCellValue('I3', '2018');//colocando
        $hoja->cells('K3:K4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('K3:K4');//combinanado
        $hoja->cell('I4', function($cell) {
          $cell->setValue('Pf');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('J4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->setCellValue('K3', 'TOTAL PRESUPUESTO PROGRAMADO');//colocando

        $hoja->cells('L3:L4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('L3:L4');//combinanado
        $hoja->setCellValue('L3', 'TOTAL PRESUPUESTO EJECUTADO');//colocando
        $hoja->cells('M3:M4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('M3:M4');//combinanado
        $hoja->setCellValue('M3', '% EJECUCION');//colocando
        $hoja->cells('N3:N4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('N3:N4');//combinanado
        $hoja->setCellValue('N3', 'META AL 2020');//colocando
        $hoja->cells('O3:O4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('O3:O4');//combinanado
        $hoja->setCellValue('O3', '% EJECUCION EN RELACION A LA META 2020');//colocando

        //EN RELACION A LA PROGRAMACION DE ACCIONES
        $color++;
        $hoja->cells('P2:Z4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });

        $hoja->mergeCells('P2:Z2');//combinanado
        $hoja->setCellValue('P2', 'EN RELACION A LA PROGRAMACION DE ACCIONES');//colocando 
        $hoja->cells('P3:Q3', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('P3:Q3');//combinanado
        $hoja->setCellValue('P3', '2016');//colocando 
        $hoja->cell('P4', function($cell) {
          $cell->setValue('PA');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('Q4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cells('R3:S3', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('R3:S3');//combinanado
        $hoja->setCellValue('R3', '2017');//colocando
        $hoja->cell('R4', function($cell) {
          $cell->setValue('Pa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('S4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cells('T3:U3', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('T3:U3');//combinanado
        $hoja->setCellValue('T3', '2018');//colocando
        $hoja->cell('T4', function($cell) {
          $cell->setValue('Pa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('U4', function($cell) {
          $cell->setValue('Epoa');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cells('V3:V4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('V3:V4');//combinanado
        $hoja->setCellValue('V3', 'TOTAL PROGRAMACION DE ACCIONES');//colocando
        $hoja->cells('W3:W4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('W3:W4');//combinanado
        $hoja->setCellValue('W3', 'TOTAL ACCIONES EJECUTADAS');//colocando
        $hoja->cells('X3:X4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('X3:X4');//combinanado
        $hoja->setCellValue('X3', '% EJECUCION');//colocando
        $hoja->cells('Y3:Y4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('Y3:Y4');//combinanado
        $hoja->setCellValue('Y3', 'META AL 2020');//colocando
        $hoja->cells('Z3:Z4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('Z3:Z4');//combinanado
        $hoja->setCellValue('Z3', '% EJECUCION EN RELACION A LA META 2020');//colocando

        //CAUSAS DE VARIACION
        $color++;
        $hoja->cells('AA2:AA4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });

        $hoja->mergeCells('AA2:AA4');//combinanado
        $hoja->setCellValue('AA2', 'CAUSAS DE VARIACION');//colocando 

        
        $hoja->getStyle('A1:R100' , $hoja->getHighestRow())->getAlignment()->setWrapText(true);
        
        $hoja->setWidth(array(
            'A'     =>  11,
            'B'     =>  11,
            'C'     =>  11,
            'D'     =>  11,
            'E'     =>  11,
            'F'     =>  11,
            'G'     =>  11,
            'H'     =>  11,
            'I'     =>  11,
            'J'     =>  11,
            'K'     =>  11,
            'L'     =>  11,
            'M'     =>  11,
            'N'     =>  11,
            'O'     =>  11,
            'P'     =>  11,
            'Q'     =>  11,
            'R'     =>  11,
            'S'     =>  11,
            'T'     =>  11,
            'U'     =>  11,
            'V'     =>  11,
            'W'     =>  11,
            'X'     =>  11,
            'Y'     =>  11,
            'Z'     =>  11,
            'AA'    =>  40
          ));
        
        $fila = 4;
        
          foreach ($arrayContenido as $mifuente) {

              $hoja->row(++$fila,$mifuente);
              
          }
          
        
          
      });
    //FIN CONSTRUYENDO DOCUMENTO EXCEL///  
    })->download('xlsx');
  }
  public function reporteInversionExcel(){
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
      $obj->proyectosInversion = $poa;
    }

    //return \Response::json(['objetivoInversion'=>$objetivoProyectos]);
    self::construirReporteInversion($objetivoProyectos);
  }
  static function construirReporteInversion($arrayContenido){

    Excel::create('Evaluacion_Inversion', function($excel) use ($arrayContenido){

    //CONSTRUYENDO DOCUMENTO EXCEL///
      // Set the file properties
      
      $excel->setTitle('Registered users')
          ->setCreator('Web App')
          ->setCompany('Client Company')
          ->setDescription('Fictional Users in Company');
      //Create sheet
      $excel->sheet('Evaluacion_Inversion', function($hoja) use ($arrayContenido) {
        //set general font style
      $hoja->setStyle(array(
          'font' => array(
              'name'      =>  'Calibri',
              'size'      =>  11,
              'bold'      =>  false
          )
      ));
      $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];

      $color=0;
        //set background to headers Fuente Ingresos
        //ACCION ETA
      $hoja->cells('A2:A4', function($cells)use ($color, $paletaColor) {
         $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
         $cells->setBackground($paletaColor[$color % count($paletaColor)]);
      });

      $hoja->mergeCells('A2:A4');//combinanado
      $hoja->setCellValue('A2', 'ACCION ETA');//colocando

      //PLANIFICACION
      $color++;
      $hoja->cells('B2:D4', function($cells)use ($color, $paletaColor) {
         $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
         $cells->setBackground($paletaColor[$color % count($paletaColor)]);
         
         $cells->setValignment('middle');
      });
      $hoja->mergeCells('B2:D3');//combinanado
      $hoja->setCellValue('B2', 'PLANIFICACION');//colocando 
                     
      $hoja->cell('B4', function($cell) {
          $cell->setValue('PTDI/PGTC');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
          $cell->setValignment('middle');
          $cell->setAlignment('middle');

          
      });
      $hoja->cell('C4', function($cell) {
          $cell->setValue('PEI');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
          $cell->setValignment('middle');
          $cell->setAlignment('middle');
          
      });
      $hoja->cell('D4', function($cell) {
          $cell->setValue('POA');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
          $cell->setValignment('middle');
          $cell->setAlignment('middle');
          
      });

      //INSCRITO EN EL VIPFE
      $color++;
      $hoja->cells('E2:I4', function($cells)use ($color, $paletaColor) {
         $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
         $cells->setBackground($paletaColor[$color % count($paletaColor)]);
      });
      
      $hoja->mergeCells('E2:I2');//combinanado
      $hoja->setCellValue('E2', 'INSCRITO EN EL VIPFE');//colocando 

      $hoja->mergeCells('E3:E4');//combinanado
      $hoja->setCellValue('E3', 'CODIGO SISIN');//colocando
      $hoja->cells('E3:E4', function($cells)use ($color, $paletaColor) {
        $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
      });


      $hoja->mergeCells('F3:F4');//combinanado
      $hoja->setCellValue('F3', 'PROYECTO');//colocando
      $hoja->cells('F3:F4', function($cells)use ($color, $paletaColor) {
        $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
      });

      $hoja->mergeCells('G3:G4');//combinanado
      $hoja->setCellValue('G3', 'COSTO TOTAL DEL PROYECTO');//colocando
      $hoja->cells('G3:G4', function($cells)use ($color, $paletaColor) {
        $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
      });

      $hoja->cells('H3:I3', function($cells)use ($color, $paletaColor) {
         $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
         //$cells->setBackground($paletaColor[$color % count($paletaColor)]);
      });
      $hoja->mergeCells('H3:I3');//combinanado
      $hoja->setCellValue('H3', 'PERIODO DE EJECUCION');
      //colocando
      $hoja->cell('H4', function($cell) {
        $cell->setValue('DEL');
        $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
      });
      $hoja->cell('I4', function($cell) {
        $cell->setValue('AL');
        $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
      });
        //CONCURRENCIA ETA
        $color++;
        $hoja->cells('J2:R4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });
        $hoja->mergeCells('J2:R2');//combinanado
        $hoja->setCellValue('J2', 'CONCURRENCIA ETA');
        $hoja->cells('J2:R2', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('J3:K3');//combinanado
        $hoja->setCellValue('J3', '2016');//colocando
        $hoja->cells('J3:K3', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('L3:M3');//combinanado
        $hoja->setCellValue('L3', '2017');
        $hoja->cells('L3:M3', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->mergeCells('N3:O3');//combinanado
        $hoja->setCellValue('N3', '2018');
        $hoja->cells('N3:O3', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });

        $hoja->cell('J4', function($cell) {
          $cell->setValue('PROG.');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('K4', function($cell) {
          $cell->setValue('EJEC.');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('L4', function($cell) {
          $cell->setValue('PROG.');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('M4', function($cell) {
          $cell->setValue('EJEC.');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('N4', function($cell) {
          $cell->setValue('PROG.');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('O4', function($cell) {
          $cell->setValue('EJEC.');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
         
        $hoja->mergeCells('P3:R3');//combinanado
        $hoja->setCellValue('P3', 'TOTALES');//colocando
        $hoja->cells('P3:R3', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('P4', function($cell) {
          $cell->setValue('PROG..');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('Q4', function($cell) {
          $cell->setValue('EJEC.');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        $hoja->cell('R4', function($cell) {
          $cell->setValue('% EJEC.');
          $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        
        ///TOTAL CONCURRENCIA ENTIDADES
        $color++;
        $hoja->mergeCells('S2:W2');//combinanado
        $hoja->setCellValue('S2', 'TOTAL CONCURRENCIA ENTIDADES');//colocando
        $hoja->cells('S2:W4', function($cells)use ($color, $paletaColor) {
           $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
           $cells->setBackground($paletaColor[$color % count($paletaColor)]);
        });
        
        
        $hoja->mergeCells('S3:S4');//combinanado
        $hoja->setCellValue('S3', 'PROG.');//colocando
        $hoja->cells('S3:S4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        
        $hoja->mergeCells('T3:T4');//combinanado
        $hoja->setCellValue('T3', 'EJECUCION');//colocando
        $hoja->cells('T3:T4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        
        $hoja->mergeCells('U3:U4');//combinanado
        $hoja->setCellValue('U3', '% EJECUCION');//colocando
        $hoja->cells('U3:U4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        
        $hoja->mergeCells('V3:V4');//combinanado
        $hoja->setCellValue('V3', 'META AL 2020');//colocando
        $hoja->cells('V3:V4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });
        
        $hoja->mergeCells('W3:W4');//combinanado
        $hoja->setCellValue('W3', '% AVANCE AL 2020');//colocando
        $hoja->cells('W3:W4', function($cells)use ($color, $paletaColor) {
          $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
        });

        
        $hoja->getStyle('A1:R100' , $hoja->getHighestRow())->getAlignment()->setWrapText(true);
        
        $hoja->setWidth(array(
            'A'     =>  11,
            'B'     =>  11,
            'C'     =>  11,
            'D'     =>  11,
            'E'     =>  30,
            'F'     =>  30,
            'G'     =>  30,
            'H'     =>  11,
            'I'     =>  11,
            'J'     =>  11,
            'K'     =>  11,
            'L'     =>  11,
            'M'     =>  11,
            'N'     =>  11,
            'O'     =>  11,
            'P'     =>  11,
            'Q'     =>  11,
            'R'     =>  11,
            'S'     =>  11,
            'T'     =>  11,
            'U'     =>  11,
            'V'     =>  11,
            'W'     =>  11,
            'X'     =>  11,
            'Y'     =>  11,
            'Z'     =>  11,
            'AA'    =>  40
        ));
        
        ///**CONSTRUYENDO LAS FILAS
        $fila = 3;
        $inicioFila = 5; 
        $finFila =0;  //$inicioFila+$cantidad_proyectos
        foreach ($arrayContenido as $mifuente) {

          $cantidad_proyectos_poa = $mifuente->cantidad_proyectos_poa;
         // dd($cantidad_proyectos_poa);
          if($cantidad_proyectos_poa > 0){

              $finFila = ($inicioFila + $cantidad_proyectos_poa)-1;////AQUI AQUI AQUI
              //dd($finFila);
              //ACCION ETA
              $hoja->cells('A'.$inicioFila.':A'.$finFila, function($cells) {
                $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                $cells->setValignment('center');
                $cells->setAlignment('center');//horizontal
              });
              //dd($inicioFila, $finFila);
              $hoja->mergeCells('A'.$inicioFila.':A'.$finFila);//combinanado 
              $hoja->setCellValue('A'.$inicioFila, $mifuente->nombre_accion_eta);
              


              $proyectos = $mifuente->proyectosInversion;
              //dd($proyectos);
              //dIBUJANDO PROYECTOS POA
              $i=$inicioFila;

              foreach ($proyectos as $p) {
                //INSCRITO PTDI
                if($p->inscrito_ptdi == true){
                  $hoja->cell('B'.$i, function($cell) use ($p) {
                    $cell->setValue("X");
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  });
                }else{
                  $hoja->cell('B'.$i, function($cell) use ($p) {
                    $cell->setValue("");
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  });
                }
                //INSCRITO PEI
                if($p->inscrito_pei == true){
                  $hoja->cell('C'.$i, function($cell) use ($p) {
                    $cell->setValue("X");
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  });
                }else{
                  $hoja->cell('C'.$i, function($cell) use ($p) {
                    $cell->setValue("");
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  });
                }
                //INSCRITO POA
                if($p->inscrito_ptdi == true){
                  $hoja->cell('D'.$i, function($cell) use ($p) {
                    $cell->setValue("X");
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  });
                }else{
                  $hoja->cell('D'.$i, function($cell) use ($p) {
                    $cell->setValue("");
                    $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                  });
                }
                //CODIGO SISIN
                $hoja->cell('E'.$i, function($cell) use ($p) {
                  $cell->setValue($p->codigo_sisin);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //NOMBRE PROYECTO POA
                $hoja->cell('F'.$i, function($cell) use ($p) {
                  $cell->setValue($p->nombre);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });

                //COSTO TOTAL PROYECTO
                $hoja->cell('G'.$i, function($cell) use ($p) {
                  $cell->setValue($p->costo_total_proyecto);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                }); 
                //DEL
                $hoja->cell('H'.$i, function($cell) use ($p) {
                  $cell->setValue($p->periodo_ejecucion_del);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //AL
                $hoja->cell('I'.$i, function($cell) use ($p) {
                  $cell->setValue($p->periodo_ejecucion_al);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //PROGRAMADO 2016
                $hoja->cell('J'.$i, function($cell) use ($p) {
                  $cell->setValue($p->programado_2016);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //EJECUTADO 2016
                $hoja->cell('K'.$i, function($cell) use ($p) {
                  $cell->setValue($p->ejecutado_2016);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //PROGRAMADO 2017
                $hoja->cell('L'.$i, function($cell) use ($p) {
                  $cell->setValue($p->programado_2017);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //EJECUTADO 2017
                $hoja->cell('M'.$i, function($cell) use ($p) {
                  $cell->setValue($p->ejecutado_2017);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //PROGRAMADO 2018
                $hoja->cell('N'.$i, function($cell) use ($p) {
                  $cell->setValue($p->programado_2018);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //EJECUTADO 2018
                $hoja->cell('O'.$i, function($cell) use ($p) {
                  $cell->setValue($p->ejecutado_2018);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                
                //TOTAL PROGRAMADO
                $hoja->cell('P'.$i, function($cell) use ($p) {
                  $cell->setValue($p->total_programado);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //TOTAL EJECUTADO
                $hoja->cell('Q'.$i, function($cell) use ($p) {
                  $cell->setValue($p->total_ejecutado);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //TOTAL PORCENTAJE EJECUTAD
                $hoja->cell('R'.$i, function($cell) use ($p) {
                  $cell->setValue($p->total_porcentaje_ejecutado);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //CONCURRENCIA ENTIDADES PROGRAMADO
                $hoja->cell('S'.$i, function($cell) use ($p) {
                  $cell->setValue($p->concurrencia_entidades_programado);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //CONCURRENCIA ENTIDADES PROGRAMADO
                $hoja->cell('T'.$i, function($cell) use ($p) {
                  $cell->setValue($p->concurrencia_entidades_ejecutado);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
               
                //CONCURRENCIA ENTIDADES PORCENTAJE EJECUTADO
                $hoja->cell('U'.$i, function($cell) use ($p) {
                  $cell->setValue($p->concurrencia_entidades_porcentaje_ejecutado);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //META AL 2020
                $hoja->cell('V'.$i, function($cell) use ($p) {
                  $cell->setValue($p->meta_recurso_2020);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                //CONCURRENCIA ENTIDADES PORCENTAJE AL 2020
                $hoja->cell('W'.$i, function($cell) use ($p) {
                  $cell->setValue($p->concurrencia_entidades_porcentaje_al_2020);
                  $cell->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                });
                

                
                
                $i++;
              }

              
              $color++;//COLOCANDO COLORA A TODOS LOS PROYECTOS POA
              $hoja->cells('A'.$inicioFila.':W'.$finFila, function($cells)use ($color, $paletaColor) {
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
              
              
              $color++;
              $hoja->cells('A'.$inicioFila.':W'.$inicioFila, function($cells) use ($color,$paletaColor) {
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
        //FIN CONSTRUYENDO LAS FILAS
      });
    //FIN CONSTRUYENDO DOCUMENTO EXCEL///  
    })->download('xlsx');
  }
} 

