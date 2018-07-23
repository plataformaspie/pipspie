<?php

namespace App\Http\Controllers\Sistemaremi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\SistemaRemi\TiposMedicion;
use App\Models\SistemaRemi\UnidadesMedidas;
use App\Models\SistemaRemi\Dimensiones;
use App\Models\SistemaRemi\FuenteDatos;
use App\Models\SistemaRemi\FuenteDatosResponsable;
use App\Models\SistemaRemi\FuenteTipos;
use App\Models\SistemaRemi\Frecuencia;
use App\Models\SistemaRemi\FuenteTiposRecoleccion;
use App\Models\SistemaRemi\FuenteTiposCategoriaTematica;
use App\Models\SistemaRemi\FuenteArchivosRespaldos;
use App\Models\SistemaRemi\FuenteTiposCobertura;
use App\Models\ModuloPdes\ProyectoPdes as Proyecto;
use Excel;

class ExportReportController extends Controller
{
  public function descagarExcelMetadatosOnly(Request $request)
  {
     $id = $request->id;
     $fuente = FuenteDatos::join('remi_estados as et', 'remi_fuente_datos.estado', '=', 'et.id')
                         ->where('remi_fuente_datos.id',$request->id)
                         ->select('remi_fuente_datos.*','et.nombre as estado','et.id as id_estado')
                         ->get();
       $fuenteTipo = $fuente;
       $fuenteDatos = array();
       $cadenaAdministrativo = "Registro Administrativo";
       $cadenaEncuesta = "Encuesta";

       $identificacion = array();
       $categoriaTematica = array();
       $formularios = array();
       $cobertura = array();
       $responsables = array();
       $accesoInformacion = array();



     foreach ($fuenteTipo as $ft){
        if($ft->tipo == $cadenaAdministrativo){
           $cabeceraIdentificacion =  [
                               'TITULO FUENTE DATOS',
                               'ABREVIACION',
                               'TIPO',
                               'OBJETIVO',
                               'SERIE DISPONIBL',
                               'PERIODICIDAD',
                               'VARIABLES/CAMPO CLAVE',
                               'MODO RECOLECCION DATOS',
                               'UNIDAD DE ANALISIS',
                               'UNIVERSO DE ESTUDIO',
                               'OBSERVACIONES'];
           $cabeceraCategoriaTematica =[
                               'DEMOGRAFIA Y ESTADISTICAS SOCIALES',
                               'ESTADISTICAS ECONOMICAS',
                               'ESTADISTICAS MEDIOAMBIENTALES',
                               'INFORMACION GEOESPACIAL'];

           $cabeceraFormularios = array();
           $cabeceraCobertura = array();
           $cabeceraResponsables = array();
           $cabeceraAccesoInformacion = array();
           $cabeceraTitulos = array();

           foreach ($fuente as $f) {
                  $identificacion['Titulo_Fuente_Datos']           = $f->nombre;
                  $identificacion['Abreviacion']                   = $f->acronimo;
                  $identificacion['Tipo']                          = $f->tipo;
                  $identificacion['Objetivo']                      = $f->objetivo;
                  $identificacion['Serie_Disponible']              = $f->serie_datos;
                  $identificacion['Periodicidad']                  = $f->periodicidad;
                  $identificacion['Variable_campo_clave']          = $f->variable;
                  $identificacion['recoleccion_datos']             = $f->modo_recoleccion_datos;
                  $identificacion['unidad_analisis']               = $f->unidad_analisis;
                  $identificacion['universo_estudio']              = $f->universo_estudio;
                  $identificacion['observacion']                   = $f->observacion;

                  array_push($cabeceraTitulos, 'IDENTIFICACION');

                  $categoriaTematica['demografia_estadistica_social'] = $f->demografia_estadistica_social;
                  $categoriaTematica['estadistica_economica']         = $f->estadistica_economica;
                  $categoriaTematica['estadistica_medioambiental']    = $f->estadistica_medioambiental;
                  $categoriaTematica['informacion_geoespacial']       = $f->informacion_geoespacial;

                  array_push($cabeceraTitulos, 'CATEGORIA TEMATICA');
                  //trabajando numero de formulario
                  array_push($formularios,$f->numero_total_formulario);



                  array_push($cabeceraFormularios,'CANTIDAD FORMULARIOS');
                  $formulario = explode("|",$f->nombre_formulario);
                  $varFor = 1;
                  for($i=0;$i<count($formulario);$i++){
                    $key = 'FORM_'.$varFor;

                    array_push($formularios, $formulario[$i]);
                    array_push($cabeceraFormularios, $key);
                    $varFor++;
                  }

                  array_push($cabeceraTitulos, 'FORMULARIOS');

                  $cobertura['cobertura_rraa']                = $f->cobertura_rraa;
                  $cobertura['cobertura_rraa_descripcion']    = $f->cobertura_rraa_descripcion;
                  array_push($cabeceraCobertura,'COBERTURA DEL RRAA');
                  array_push($cabeceraCobertura,'DESCRIPCION DEL RRAA');
                  ///trabajando cobertura 'COBERTURA GEOGRAFICA DE LA FUENTE',

                 $cober = explode(",", $f->cobertura_geografica);
                 $co = FuenteTiposCobertura::whereIn('id', $cober)->get();
                 $cadenaCobertura = "";
                 foreach ($co as $c) {
                    $cadenaCobertura = '-'.$cadenaCobertura.$c->nombre;
                 }
                 $cobertura['cobertura_geografica'] = $cadenaCobertura;
                 array_push($cabeceraCobertura,'COBERTURA GEOGRAFICA');

                 //trabajando  nivel de representatividad/nivel de desagregacion
                 $nivelDesagregacion = explode(",", $f->cobertura_geografica);
                 $co = FuenteTiposCobertura::whereIn('id', $nivelDesagregacion)->get();
                 $cadenaDesagregacion = "";
                 foreach ($co as $c) {
                    $cadenaDesagregacion = '-'.$cadenaDesagregacion.$c->nombre;
                 }

                 $cobertura['nivel_Desagregacion'] = $cadenaDesagregacion;
                 array_push($cabeceraCobertura,'NIVEL DE DESAGREGACION');

                 array_push($cabeceraTitulos, 'COBERTURA');

                  //TRABAJANDO RESPONSANBLE

                 $responsablesCuantos = FuenteDatosResponsable::where('id_fuente',$request->id)->where('activo', true)->get();

                 $varRes = 1;
                 foreach ($responsablesCuantos as $r)
                 {
                    $key = 'RESPONSABLE_'.$varRes;
                    array_push($cabeceraResponsables,$key );
                    array_push($responsables, $r->responsable_nivel_1,$r->responsable_nivel_2,$r->responsable_nivel_3,$r->responsable_nivel_4,$r->numero_referencia);

                    array_push($cabeceraTitulos, $key);
                    $varRes++;
                 }
                 $cabeceraAccesoInformacion = [
                               'CONFIDENCIALIDAD',
                               'NOTAS LEGALES'
                               ];

                 $confidencialidad['confidencialidad'] = $f->confidencialidad;
                 $confidencialidad['notas_legales'] = $f->notas_legales;
                 array_push($cabeceraTitulos, 'ACCESO INFORMACION');
                 //dd($cabeceraTitulos);
                 $cabeceraDatos = array();
                 $cabeceraDatos['cIdentificacion'] = $cabeceraIdentificacion;
                 $cabeceraDatos['cTematica'] = $cabeceraCategoriaTematica;
                 $cabeceraDatos['cFormularios'] = $cabeceraFormularios;
                 $cabeceraDatos['cCobertura'] = $cabeceraCobertura;
                 $cabeceraDatos['cResponsables'] = $cabeceraResponsables;
                 $cabeceraDatos['cAccesoInformacion'] = $cabeceraAccesoInformacion;
                 $contenido = array();
                 $contenido['identificacion'] = $identificacion;
                 $contenido['categoriaTematica'] = $categoriaTematica;
                 $contenido['formularios'] = $formularios;
                 $contenido['cobertura'] = $cobertura;
                 $contenido['responsables'] = $responsables;
                 //dd($responsables);
                 $contenido['accesoInformacion'] = $confidencialidad;


                 self::contruirExcel($cabeceraDatos,$contenido,$cabeceraTitulos);

           }


        //ENCUESTA
        }elseif($ft->tipo == $cadenaEncuesta){
           $cabeceraIdentificacion =  [
                               'TITULO FUENTE DATOS',
                              'ABREVIACION',
                              'TIPO',
                              'OBJETIVO',
                              'SERIE DISPONIBLE',
                              'PERIODICIDAD',
                              'VARIABLES/CAMPO CLAVE',
                              'MODO RECOLECCION DATOS',
                              'UNIDAD DE ANALISIS',
                              'UNIVERSO DE ESTUDIO',
                              'DISEÑO Y TAMAÑO DE MUESTRA',
                              'TASA DE RESPUESTA',
                              'OBSERVACIONEs'];
           $cabeceraCategoriaTematica =[
                                'DEMOGRAFIA Y ESTADISTICAS SOCIALES',
                                'ESTADISTICAS ECONOMICAS',
                                'ESTADISTICAS MEDIOAMBIENTALES',
                                'INFORMACION GEOESPACIAL'];

           $cabeceraFormularios = array();
           $cabeceraCobertura = array();
           $cabeceraResponsables = array();
           $cabeceraAccesoInformacion = array();
           $cabeceraTitulos = array();

           foreach ($fuente as $f) {
              $identificacion['Titulo_Fuente_Datos'] = $f->nombre;
              $identificacion['Abreviacion'] = $f->acronimo;
              $identificacion['Tipo'] = $f->tipo;
              $identificacion['Objetivo'] = $f->objetivo;
              $identificacion['Serie_Disponible'] = $f->serie_datos;
              $identificacion['Periodicidad'] = $f->periodicidad;
              $identificacion['Variable_campo_clave'] = $f->variable;
              $identificacion['recoleccion_datos'] = $f->modo_recoleccion_datos;


              $identificacion['unidad_analisis'] = $f->unidad_analisis;
              $identificacion['universo_estudio'] = $f->universo_estudio;
              $identificacion['disenio_tamanio_muestra'] = $f->disenio_tamanio_muestra;
              $identificacion['tasa_respuesta'] = $f->tasa_respuesta;
              $identificacion['observacion'] = $f->observacion;
              array_push($cabeceraTitulos,'IDENTIFICACION');

              $categoriaTematica['demografia_estadistica_social'] = $f->demografia_estadistica_social;
              $categoriaTematica['estadistica_economica'] = $f->estadistica_economica;
              $categoriaTematica['estadistica_medioambiental'] = $f->estadistica_medioambiental;
              $categoriaTematica['informacion_geoespacial'] = $f->informacion_geoespacial;

              array_push($cabeceraTitulos, 'CATEGORIA TEMATICA');

              array_push($formularios,$f->numero_total_formulario);
              array_push($cabeceraFormularios,'CANTIDAD FORMULARIOS');
                  $formulario = explode("|",$f->nombre_formulario);
                  $varFor = 1;
                  for($i=0;$i<count($formulario);$i++){
                    $key = 'FORM_'.$varFor;

                    array_push($formularios, $formulario[$i]);
                    array_push($cabeceraFormularios, $key);
                    $varFor++;
                  }

              array_push($cabeceraTitulos, 'FORMULARIOS');


              ///trabajando cobertura 'COBERTURA GEOGRAFICA DE LA FUENTE',

                 $cober = explode(",", $f->cobertura_geografica);
                 $co = FuenteTiposCobertura::whereIn('id', $cober)->get();
                 $cadenaCobertura = "";
                 foreach ($co as $c) {
                    $cadenaCobertura = $cadenaCobertura.$c->nombre.',';
                 }
                 $cadenaCobertura = trim($cadenaCobertura, ',');
                 $cobertura['cobertura_geografica'] = $cadenaCobertura;
                 array_push($cabeceraCobertura,'COBERTURA GEOGRAFICA');

                 //trabajando  nivel de representatividad/nivel de desagregacion
                 $nivelDesagregacion = explode(",", $f->cobertura_geografica);
                 $co = FuenteTiposCobertura::whereIn('id', $nivelDesagregacion)->get();
                 $cadenaDesagregacion = "";
                 foreach ($co as $c) {
                    $cadenaDesagregacion = $cadenaDesagregacion.$c->nombre.',';
                 }
                 $cadenaDesagregacion = trim($cadenaDesagregacion, ',');
                 $cobertura['nivel_Desagregacion'] = $cadenaDesagregacion;
                 array_push($cabeceraCobertura,'NIVEL DE DESAGREGACION');

                 array_push($cabeceraTitulos, 'COBERTURA');

                 //TRABAJANDO RESPONSANBLE

                 $responsablesCuantos = FuenteDatosResponsable::where('id_fuente',$request->id)->where('activo', true)->get();

                 $varRes = 1;
                 foreach ($responsablesCuantos as $r)
                 {
                    $key = 'RESPONSABLE_'.$varRes;
                    array_push($cabeceraResponsables,$key );
                    array_push($responsables, $r->responsable_nivel_1,$r->responsable_nivel_2,$r->responsable_nivel_3,$r->responsable_nivel_4,$r->numero_referencia);

                    array_push($cabeceraTitulos, $key);
                    $varRes++;
                 }
                 //ACCESO INFORMACION
                 $cabeceraAccesoInformacion = [
                               'CONFIDENCIALIDAD',
                               'NOTAS LEGALES'
                               ];

                 $confidencialidad['confidencialidad'] = $f->confidencialidad;
                 $confidencialidad['notas_legales'] = $f->notas_legales;
                 array_push($cabeceraTitulos, 'ACCESO INFORMACION');

                 //enviando informacion ENCUESTA
                 $cabeceraDatos = array();
                 $cabeceraDatos['cIdentificacion'] = $cabeceraIdentificacion;
                 $cabeceraDatos['cTematica'] = $cabeceraCategoriaTematica;
                 $cabeceraDatos['cFormularios'] = $cabeceraFormularios;
                 $cabeceraDatos['cCobertura'] = $cabeceraCobertura;
                 $cabeceraDatos['cResponsables'] = $cabeceraResponsables;
                 $cabeceraDatos['cAccesoInformacion'] = $cabeceraAccesoInformacion;
                 $contenido = array();
                 $contenido['identificacion'] = $identificacion;
                 $contenido['categoriaTematica'] = $categoriaTematica;
                 $contenido['formularios'] = $formularios;
                 $contenido['cobertura'] = $cobertura;
                 $contenido['responsables'] = $responsables;

                 $contenido['accesoInformacion'] = $confidencialidad;

                 //dd($cabeceraDatos);
                 self::contruirExcel($cabeceraDatos,$contenido,$cabeceraTitulos);
           }

        }else{

           $cabeceraIdentificacion =  [
                               'TITULO FUENTE DATOS',
                              'ABREVIACION',
                              'TIPO',
                              'OBJETIVO',
                              'SERIE DISPONIBLE',
                              'PERIODICIDAD',
                              'VARIABLES/CAMPO CLAVE',
                              'MODO RECOLECCION DATOS',
                              'UNIDAD DE ANALISIS',
                              'UNIVERSO DE ESTUDIO',
                              'OBSERVACIONEs'];
           $cabeceraCategoriaTematica =[
                                'DEMOGRAFIA Y ESTADISTICAS SOCIALES',
                                'ESTADISTICAS ECONOMICAS',
                                'ESTADISTICAS MEDIOAMBIENTALES',
                                'INFORMACION GEOESPACIAL'];

           $cabeceraFormularios = array();
           $cabeceraCobertura = array();
           $cabeceraResponsables = array();
           $cabeceraAccesoInformacion = array();
           $cabeceraTitulos = array();

           foreach ($fuente as $f) {
              $identificacion['Titulo_Fuente_Datos'] = $f->nombre;
              $identificacion['Abreviacion'] = $f->acronimo;
              $identificacion['Tipo'] = $f->tipo;
              $identificacion['Objetivo'] = $f->objetivo;
              $identificacion['Serie_Disponible'] = $f->serie_datos;
              $identificacion['Periodicidad'] = $f->periodicidad;
              $identificacion['Variable_campo_clave'] = $f->variable;
              $identificacion['recoleccion_datos'] = $f->modo_recoleccion_datos;


              $identificacion['unidad_analisis'] = $f->unidad_analisis;
              $identificacion['universo_estudio'] = $f->universo_estudio;

              $identificacion['observacion'] = $f->observacion;
              array_push($cabeceraTitulos,'IDENTIFICACION');

              $categoriaTematica['demografia_estadistica_social'] = $f->demografia_estadistica_social;
              $categoriaTematica['estadistica_economica'] = $f->estadistica_economica;
              $categoriaTematica['estadistica_medioambiental'] = $f->estadistica_medioambiental;
              $categoriaTematica['informacion_geoespacial'] = $f->informacion_geoespacial;

              array_push($cabeceraTitulos, 'CATEGORIA TEMATICA');

              array_push($formularios,$f->numero_total_formulario);
              array_push($cabeceraFormularios,'CANTIDAD FORMULARIOS');
                  $formulario = explode("|",$f->nombre_formulario);
                  $varFor = 1;
                  for($i=0;$i<count($formulario);$i++){
                    $key = 'FORM_'.$varFor;

                    array_push($formularios, $formulario[$i]);
                    array_push($cabeceraFormularios, $key);
                    $varFor++;
                  }

              array_push($cabeceraTitulos, 'FORMULARIOS');


              ///trabajando cobertura 'COBERTURA GEOGRAFICA DE LA FUENTE',

                 $cober = explode(",", $f->cobertura_geografica);
                 $co = FuenteTiposCobertura::whereIn('id', $cober)->get();
                 $cadenaCobertura = "";
                 foreach ($co as $c) {
                    $cadenaCobertura = $cadenaCobertura.$c->nombre.',';
                 }
                 $cadenaCobertura = trim($cadenaCobertura, ',');
                 $cobertura['cobertura_geografica'] = $cadenaCobertura;
                 array_push($cabeceraCobertura,'COBERTURA GEOGRAFICA');

                 //trabajando  nivel de representatividad/nivel de desagregacion
                 $nivelDesagregacion = explode(",", $f->cobertura_geografica);
                 $co = FuenteTiposCobertura::whereIn('id', $nivelDesagregacion)->get();
                 $cadenaDesagregacion = "";
                 foreach ($co as $c) {
                    $cadenaDesagregacion = $cadenaDesagregacion.$c->nombre.',';
                 }
                 $cadenaDesagregacion = trim($cadenaDesagregacion, ',');
                 $cobertura['nivel_Desagregacion'] = $cadenaDesagregacion;
                 array_push($cabeceraCobertura,'NIVEL DE DESAGREGACION');

                 array_push($cabeceraTitulos, 'COBERTURA');

                 //TRABAJANDO RESPONSANBLE

                 $responsablesCuantos = FuenteDatosResponsable::where('id_fuente',$request->id)->where('activo', true)->get();

                 $varRes = 1;
                 foreach ($responsablesCuantos as $r)
                 {
                    $key = 'RESPONSABLE_'.$varRes;
                    array_push($cabeceraResponsables,$key );
                    array_push($responsables, $r->responsable_nivel_1,$r->responsable_nivel_2,$r->responsable_nivel_3,$r->responsable_nivel_4,$r->numero_referencia);

                    array_push($cabeceraTitulos, $key);
                    $varRes++;
                 }
                 //ACCESO INFORMACION
                 $cabeceraAccesoInformacion = [
                               'CONFIDENCIALIDAD',
                               'NOTAS LEGALES'
                               ];

                 $confidencialidad['confidencialidad'] = $f->confidencialidad;
                 $confidencialidad['notas_legales'] = $f->notas_legales;
                 array_push($cabeceraTitulos, 'ACCESO INFORMACION');

                 //enviando informacion ENCUESTA
                 $cabeceraDatos = array();
                 $cabeceraDatos['cIdentificacion'] = $cabeceraIdentificacion;
                 $cabeceraDatos['cTematica'] = $cabeceraCategoriaTematica;
                 $cabeceraDatos['cFormularios'] = $cabeceraFormularios;
                 $cabeceraDatos['cCobertura'] = $cabeceraCobertura;
                 $cabeceraDatos['cResponsables'] = $cabeceraResponsables;
                 $cabeceraDatos['cAccesoInformacion'] = $cabeceraAccesoInformacion;
                 $contenido = array();
                 $contenido['identificacion'] = $identificacion;
                 $contenido['categoriaTematica'] = $categoriaTematica;
                 $contenido['formularios'] = $formularios;
                 $contenido['cobertura'] = $cobertura;
                 $contenido['responsables'] = $responsables;

                 $contenido['accesoInformacion'] = $confidencialidad;


                 self::contruirExcel($cabeceraDatos,$contenido,$cabeceraTitulos);
           }
        }
     }//fin foreach
  }//fin descargarExcel()
  static function contruirExcel($cabeceraDatos,$contenido,$cabeceraTitulos){



      \Excel::create('INFORMACION FUENTE', function ($excel) use ($cabeceraDatos,$contenido,$cabeceraTitulos)
      {

           $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
           $excel->sheet('Fuente_datos', function ($hoja) use($cabeceraDatos,$contenido,$cabeceraTitulos,$paletaColor)
           {
               $fila = 1;
               $codDemanda = 0;
               $color = 0;
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
               //saber cuanto es el array cabeceraIdentificacion
              //dd($cabeceraExcel);
              //dd($cabeceraDatos);
              $tamanoCabecera = array();
              foreach ($cabeceraDatos as $key => $longitud) {
                 if($key=='cResponsables'){

                    for ($i=0; $i < sizeof($longitud) ; $i++) {
                       array_push($tamanoCabecera, 5);
                    }

                 }else{
                    array_push($tamanoCabecera, sizeof($longitud));
                 }

              }
              //dd($tamanoCabecera[3]);


              $fila = 1;
              $ri = 'A1';
              $rf = 0;
              $aunTamano = 0;
              $color = 0;
              for ($i=0; $i <= sizeof($tamanoCabecera) ; $i++) {

                 $color++;
                 if(isset($tamanoCabecera[$i])){
                    $rf = $rf + $tamanoCabecera[$i];

                    $uTamano = $cabeceraExcel[$rf-1];

                    $rUnido = $ri.':'.$uTamano.$fila;



                    $hoja->cells($rUnido, function($cells)use ($color, $paletaColor) {
                     $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                     $cells->setBackground($paletaColor[$color % count($paletaColor)]);

                    });
                    $hoja->mergeCells($rUnido);//combinanado

                    $hoja->setCellValue($ri, $cabeceraTitulos[$i]);//colocando el valor inicial


                    $ri=$cabeceraExcel[$rf].$fila;

                 }


              }
              $filaCabecera = array();
              $i=0;
              //dd($cabeceraDatos);
              foreach ($cabeceraDatos as $key => $value) {
                 if($key == 'cResponsables'){
                    for ($i=0; $i < sizeof($value); $i++) {
                       array_push($filaCabecera,
                          'INSTITUCION PROPIETARIA/CUSTODIA',
                          'DEPENDENCIA EJECUTIVA',
                          'DEPENDENCIA TECNICA',
                          'DEPENDENCIA INFORMATICA',
                          'TELEFONO DE REFERENCIA');
                    }
                 }else{
                    $i=0;
                   foreach ($value as $key => $r) {
                      array_push($filaCabecera, $r);
                   }
                    //dd($filaCabecera);

                 }
              }
              $hoja->row($fila, function($row) {

                $row->setAlignment('center');

              });
              /*$hoja->row($fila, function($row) use ($color, $paletaColor)  {
                   $row->setBackground($paletaColor[$color % count($paletaColor)]);
               });*/



              //dd($contenido);
              $hoja->row( ++$fila, $filaCabecera );
              $hoja->row($fila, function($row) {

                $row->setAlignment('center');

              });
              $filaContenido = [];
              //dd($contenido);
              foreach ($contenido as $iden => $miValor ) {
                 if($iden == 'responsables'){
                    for ($i=0; $i < sizeof($miValor); $i++) {
                       array_push($filaContenido,$miValor[$i]);
                    }
                 }else{
                    foreach ($miValor as $key => $value) {
                       array_push($filaContenido, $value);
                    }

                 }
              }

              $hoja->row( ++$fila, $filaContenido );
              /*$hoja->row($fila, function($row) {

                $row->setAlignment('center');

              });*/

               // $endCell = str_repeat(chr(count($cabecera) % 26 + 64), ceil(count($cabecera)/26)) . (count($proyectos)+1);
               //$hoja->setBorder('A1:L'  . $fila, 'thin');
               $hoja->setAutoSize(true);
               //$hoja->setWidth(array('B'=>50, 'J'=>50, 'K'=>50, 'L'=>30, 'F'=>3,'G'=>3,'H'=>5,'I'=>3 )) ;
           });



      })->export('xlsx');

  }
  public function descagarExcelAdminFuente(Request $request){

    //controlar tamaño de campos de formulario 10,77
    $tamanoTitulos = [];
    $ids = explode(",", trim($request->ids,','));
    $mayorCantidadFormularios = FuenteDatos::whereIn('remi_fuente_datos.id',$ids)
                                                ->max('numero_total_formulario');

    //controlar tamaño de campos Responsable mandar string  
    //$registros = implode(',', $ids);
    //$registros = '('.$registros.')'; 
    $registros = '(10,77)';                                        
    $mayorCantidadResponsable = \DB::select("SELECT MAX(count_num) FROM 
                          (SELECT id_fuente, count(*) as count_num
                          FROM remi_fuente_datos_responsable 
                          where id_fuente IN ".$registros."
                          GROUP BY id_fuente) x");

    $cabeceraTitulos = ['IDENTIFICACION',
                        'CATEGORIA TEMATICA',
                        'FORMULARIOS',
                        'COBERTURA' ];
    
                        
    $r = intval($mayorCantidadResponsable[0]->max);

    
    if(isset($r)){
      $res = 'RESPONSABLE_';
      for($i=1; $i<=$r; $i++){
        array_push($cabeceraTitulos, 'RESPONSABLE_'.$i);
      }
    }
    array_push($cabeceraTitulos, 'ACCESO INFORMACION');

    //dd($cabeceraTitulos);

    ///CONTRUYENDO SEGUNDA FILA DE CABECERA
    $cabeceraDatos = [
                      'TITULO FUENTE DATOS',
                      'ABREVIACION',
                      'TIPO',
                      'OBJETIVO',
                      'SERIE DISPONIBLE',
                      'PERIODICIDAD',
                      'VARIABLES/CAMPO CLAVE',
                      'MODO RECOLECCION DATOS',
                      'UNIDAD DE ANALISIS',
                      'UNIVERSO DE ESTUDIO',
                      'DISEÑO Y TAMAÑO DE MUESTRA',
                      'TASA DE RESPUESTA',
                      'OBSERVACIONES',
                      'DEMOGRAFIA Y ESTADISTICAS SOCIALES',
                      'ESTADISTICAS ECONOMICAS',
                      'ESTADISTICAS MEDIOAMBIENTALES',
                      'INFORMACION GEOESPACIAL'];

    array_push($tamanoTitulos,13,4);

    array_push($cabeceraDatos,'CANTIDAD FORMULARIOS');
    $form = 'FORM_';
    $cFor = 0;
    for ($i=1; $i <= $mayorCantidadFormularios; $i++) { 
      array_push($cabeceraDatos,$form.$i );
      $cFor++;
    }
    
    array_push($tamanoTitulos,$cFor+1);

    array_push($cabeceraDatos,'COBERTURA DEL RRAA','DESCRIPCION DEL RRAA','COBERTURA GEOGRAFICA','NIVEL DE DESAGREGACION');

    array_push($tamanoTitulos,4);
    //CALCULAR  
    for ($i=1; $i <= $r ; $i++) { 
      array_push($cabeceraDatos,'INSTITUCION PROPIETARIA/CUSTODIA',
                          'DEPENDENCIA EJECUTIVA',
                          'DEPENDENCIA TECNICA',
                          'DEPENDENCIA INFORMATICA',
                          'TELEFONO DE REFERENCIA');
      array_push($tamanoTitulos,5);

    }
    

    array_push($cabeceraDatos,'CONFIDENCIALIDAD','NOTAS LEGALES');
    array_push($tamanoTitulos,2);
    $sql = FuenteDatos::whereIn('remi_fuente_datos.id',$ids)
                        ->get();
    
  
    
    //creando las filas para el excel 
    $tamanoColumnas = []; 
    $j=0;  
    $arrayContenido = [];               
    foreach ($sql as $key => $fuenteDatos){
      $tipo = $fuenteDatos->tipo;
      $filaFuente = [];
      //llenando fila fuente  
          $filaFuente = array($fuenteDatos->nombre,
                              $fuenteDatos->acronimo,
                              $fuenteDatos->tipo,
                              $fuenteDatos->objetivo,
                              $fuenteDatos->serie_datos,
                              $fuenteDatos->periodicidad,
                              $fuenteDatos->variable,
                              $fuenteDatos->modo_recoleccion_datos,
                              $fuenteDatos->unidad_analisis,
                              $fuenteDatos->universo_estudio,
                              $fuenteDatos->disenio_tamanio_muestra,
                              $fuenteDatos->tasa_respuesta,
                              $fuenteDatos->observacion,

                              $fuenteDatos->demografia_estadistica_social,
                              $fuenteDatos->estadistica_economica,
                              $fuenteDatos->estadistica_medioambiental,
                              $fuenteDatos->informacion_geoespacial,
    
                            );
          
          //calculo de los formularios

          array_push($filaFuente,$fuenteDatos->numero_total_formulario);
         
          $nombreformularios = explode("|",$fuenteDatos->nombre_formulario);
          
          //verificar si tiene algun formulario
          if(isset($fuenteDatos->numero_total_formulario)){
            $varFor = 0;
            //verificar si es mayor o igual que el maximo de los formularios
            $nfor = $fuenteDatos->numero_total_formulario;
            if($nfor==$mayorCantidadFormularios){

                for ($i=0; $i < $nfor ; $i++) { 
                    
                  array_push($filaFuente,$nombreformularios[$i]);
                } 
            }else{
                $aumentarFormulario = 0;

                for ($i=0; $i < $nfor ; $i++) { 
                  array_push($filaFuente,$nombreformularios[$i]);
                  $aumentarFormulario++;
                }
                for ($i=0; $i <$aumentarFormulario ; $i++) { 
                  array_push($filaFuente,"");
                }

            }
            
              
          }else{
            for ($i=0; $i < $mayorCantidadFormularios ; $i++) { 

                array_push($filaFuente, "");
            }
          }
          //COBERTURA        
          array_push($filaFuente,$fuenteDatos->cobertura_rraa);
          array_push($filaFuente,$fuenteDatos->cobertura_rraa_descripcion);
          

          $cober = explode(",", $fuenteDatos->cobertura_geografica);
          
          if(count($cober)>1){
            $co = FuenteTiposCobertura::whereIn('id', $cober)->get();
          
            $cadenaCobertura = "";
            foreach ($co as $c) {
                $cadenaCobertura = '-'.$cadenaCobertura.$c->nombre;
            }
            array_push($filaFuente,$cadenaCobertura);//llenando...coberura

          }else{
            if($fuenteDatos->cobertura_geografica){
               $co = FuenteTiposCobertura::where('id', $fuenteDatos->cobertura_geografica)->get();
          
              $cadenaCobertura = "";
              foreach ($co as $c) {
                  $cadenaCobertura = $cadenaCobertura.$c->nombre.',';
              }

              array_push($filaFuente,trim($cadenaCobertura,','));//llenando...coberura

            }else{
              array_push($filaFuente,"");
            }
           

          }
         
          

          
          //dd($fuenteDatos->nivel_representatividad_datos);
           //trabajando  nivel de representatividad/nivel de desagregacion

          $nivelDesagregacion = explode(",", $fuenteDatos->nivel_representatividad_datos);

          if(count($nivelDesagregacion)>1){
            $co = FuenteTiposCobertura::whereIn('id', $nivelDesagregacion)->get();
            $cadenaDesagregacion = "";
            foreach ($co as $c) {
                $cadenaDesagregacion = $cadenaDesagregacion.$c->nombre.',';
            }
            $cadenaDesagregacion = trim($cadenaDesagregacion,',');
            array_push($filaFuente,$cadenaDesagregacion);

          }else{
            //verificar que en el string no exita letras
            if(!isset($fuenteDatos->nivel_representatividad_datos)){

              $co = FuenteTiposCobertura::where('id', $fuenteDatos->nivel_representatividad_datos)->get();
              $cadenaDesagregacion = "";
              foreach ($co as $c) {
                  $cadenaDesagregacion = $cadenaDesagregacion.$c->nombre.',';
              }
              $cadenaDesagregacion = trim($cadenaDesagregacion,',');
              array_push($filaFuente,$cadenaDesagregacion);
            }else{
              array_push($filaFuente,"");
            }
            
          }
          

          //trabajando responsable
          $nResponsables = FuenteDatosResponsable::where('id_fuente',$fuenteDatos->id)->get();
          foreach ($nResponsables as $varRes) {
            array_push($filaFuente,$varRes->responsable_nivel_1,$varRes->responsable_nivel_2,$varRes->responsable_nivel_3,$varRes->responsable_nivel_4,$varRes->numero_referencia);
          }
          //Acceso a informacion
          array_push($filaFuente,$fuenteDatos->confidencialidad);
          array_push($filaFuente,$fuenteDatos->notas_legales);  
        
      
      $arrayContenido[$j] = $filaFuente;
      $j++; 
    }
    //dd($arrayContenido);
    self::contruirExcelAdminFuente($cabeceraTitulos,$tamanoTitulos,$cabeceraDatos,$arrayContenido);                     
}
static function contruirExcelAdminFuente($cabeceraTitulos,$tamanoTitulos, $cabeceraDatos,$arrayContenido){
   // dd( $tamanoTitulos);
    \Excel::create('Admin Fuente', function ($excel) use ($cabeceraTitulos,$tamanoTitulos, $cabeceraDatos,$arrayContenido){

      $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
      $excel->sheet('fuente', function($hoja) use ($cabeceraTitulos,$tamanoTitulos, $cabeceraDatos,$arrayContenido,$paletaColor){

        
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

           //Construir la primera fila combinada
            $fila = 1;
            $ri = 'A1';
            $rf = 0;
            $aunTamano = 0;
            $color = 0;
            //titulos
            for ($i=0; $i <= sizeof($tamanoTitulos) ; $i++) {

               $color++;
                if(isset($tamanoTitulos[$i])){
                  $rf = $rf + $tamanoTitulos[$i];//ULTIMO TAMAÑO

                  $uTamano = $cabeceraExcel[$rf-1];

                  $rUnido = $ri.':'.$uTamano.$fila;



                  $hoja->cells($rUnido, function($cells)use ($color, $paletaColor) {
                   $cells->setBorder('thin', 'thin', 'thin', 'thin');//bordes
                   $cells->setBackground($paletaColor[$color % count($paletaColor)]);

                  });
                  $hoja->mergeCells($rUnido);//combinanado

                  $hoja->setCellValue($ri, $cabeceraTitulos[$i]);//colocando el valor inicial


                  $ri=$cabeceraExcel[$rf].$fila;
                }
            }
            //nombre de la fila
            $hoja->row(++$fila, $cabeceraDatos);
            foreach ($arrayContenido as $mifuente) {

              $hoja->row(++$fila, $mifuente);
              
            }

            $hoja->setBorder('A1:' .$uTamano . $fila, 'thin');  
            
            $hoja->getStyle('A1:'.$uTamano.$fila , $hoja->getHighestRow())->getAlignment()->setWrapText(true);
            $tamanoColumnas = [];

           
            for ($i=0; $i < $rf ; $i++) { 
              $clave = $cabeceraExcel[$i];
              $tamanoColumnas[$clave] = 20;
              
              
             
            }
            $hoja->setWidth($tamanoColumnas);
            
          
       
            



      });

    })->export('xlsx');
  }
}
