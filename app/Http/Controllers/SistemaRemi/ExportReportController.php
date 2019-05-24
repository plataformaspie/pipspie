<?php

namespace App\Http\Controllers\Sistemaremi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\SistemaRemi\TiposMedicion;
use App\Models\SistemaRemi\UnidadesMedidas;
use App\Models\SistemaRemi\Dimensiones;
use App\Models\SistemaRemi\FuenteDatos;
use App\Models\SistemaRemi\Indicadores;
use App\Models\SistemaRemi\FuenteDatosResponsable;
use App\Models\SistemaRemi\FuenteTipos;
use App\Models\SistemaRemi\Frecuencia;
use App\Models\SistemaRemi\Metas;
use App\Models\SistemaRemi\IndicadorAvance;
use App\Models\SistemaRemi\FuenteTiposRecoleccion;
use App\Models\SistemaRemi\FuenteTiposCategoriaTematica;
use App\Models\SistemaRemi\FuenteArchivosRespaldos;
use App\Models\SistemaRemi\FuenteTiposCobertura;
use App\Models\SistemaRemi\VistaCatalogoPdespmr;
use App\Models\SistemaRemi\VistaIndicadoresPdespmri;
use App\Models\ModuloPdes\ProyectoPdes as Proyecto;
use Excel;

class ExportReportController extends Controller
{
  public function descagarExcelMetadatosOnly(Request $request)
  {
     ini_set('max_execution_time', 300);
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

          //MODO RECOLECCION DATOS OTRO


          if(isset($f->modo_recoleccion_datos)){
            $otroModo = explode(',',$f->modo_recoleccion_datos);


            for ($i=0; $i < sizeof($otroModo) ; $i++) {
              if($otroModo[$i] == 'Otro'){

                $cadenaOtroModo = 'Otro:'.$f->modo_recoleccion_datos_otro.',';

              }else{
                $cadenaOtroModo = $otroModo[$i].',';
                //dd($cadenaOtroModo);
              }
            }
            //dd($cadenaOtroModo);
            $cadenaOtroModo = trim($cadenaOtroModo,',');
            $identificacion['recoleccion_datos']  = $cadenaOtroModo;

            //dd($filaFuente);
          }else{

            $identificacion['recoleccion_datos']  = "";
          }



          $identificacion['unidad_analisis']               = $f->unidad_analisis;
          $identificacion['universo_estudio']              = $f->universo_estudio;
          $identificacion['observacion']                   = $f->observacion;

          array_push($cabeceraTitulos, 'IDENTIFICACION');

          //Demografia estadistica social OTRO

          $otroEstadisticaSocial = explode(',',$f->demografia_estadistica_social);

          for ($i=0; $i < sizeof($otroEstadisticaSocial) ; $i++) {
            if($otroEstadisticaSocial[$i] == 'Otro'){

              $cadenaOtroEstadisticaSocial = 'Otro:'.$f->demografia_estadistica_social_otro.',';


            }else{
              $cadenaOtroEstadisticaSocial = $otroEstadisticaSocial[$i].',';
            }
          }

          $cadenaOtroEstadisticaSocial = trim($cadenaOtroEstadisticaSocial,',');
          $categoriaTematica['demografia_estadistica_social'] = $cadenaOtroEstadisticaSocial;

          //estadistica_economica

          $otroEstadisticaEconomica = explode(',',$f->estadistica_economica);



          for ($i=0; $i < sizeof($otroEstadisticaEconomica) ; $i++) {
            if($otroEstadisticaEconomica[$i] == 'Otro'){

              $cadenaOtroEstadisticaEconomica = 'Otro:'.$f->demografia_estadistica_economica_otro.',';


            }else{
              $cadenaOtroEstadisticaEconomica = $otroEstadisticaEconomica[$i].',';
            }
          }

          $cadenaOtroEstadisticaEconomica = trim($cadenaOtroEstadisticaEconomica,',');
          $categoriaTematica['estadistica_economica']         = $cadenaOtroEstadisticaEconomica ;



          //estadistica_ambiental

          $otroEstadisticaAmbiental = explode(',',$f->estadistica_medioambiental);



          for ($i=0; $i < sizeof($otroEstadisticaAmbiental) ; $i++) {
            if($otroEstadisticaAmbiental[$i] == 'Otro'){

              $cadenaOtroEstadisticaAmbiental = 'Otro:'.$f->estadistica_medioambiental_otro.',';


            }else{
              $cadenaOtroEstadisticaAmbiental = $otroEstadisticaAmbiental[$i].',';
            }
          }

          $cadenaOtroEstadisticaAmbiental = trim($cadenaOtroEstadisticaAmbiental,',');
          $categoriaTematica['estadistica_medioambiental']    = $cadenaOtroEstadisticaAmbiental;



          //informacion georeferencial

          $otroInformacionGeoespacial = explode(',',$f->informacion_geoespacial);


          for ($i=0; $i < sizeof($otroInformacionGeoespacial) ; $i++) {
            if($otroInformacionGeoespacial[$i] == 'Otro'){

              $cadenaOtroInformacionGeoespacial = 'Otro:'.$fuenteDatos->informacion_geoespacial_otro.',';


            }else{
              $cadenaOtroInformacionGeoespacial = $otroInformacionGeoespacial[$i].',';
            }
          }

          $cadenaOtroInformacionGeoespacial = trim($cadenaOtroInformacionGeoespacial,',');




          $categoriaTematica['informacion_geoespacial']       = $cadenaOtroInformacionGeoespacial;

          array_push($cabeceraTitulos, 'CATEGORIA TEMATICA');






                  //trabajando numero de formulario

                  array_push($formularios,$f->numero_total_formulario);



                  array_push($cabeceraFormularios,'CANTIDAD FORMULARIOS');

                  if(isset($f->numero_total_formulario)){

                    $formulario = explode("|",$f->nombre_formulario);

                    $varFor = 1;
                    for($i=0;$i<sizeof($formulario);$i++){
                      $key = 'FORM_'.$varFor;

                      array_push($formularios, $formulario[$i]);
                      array_push($cabeceraFormularios, $key);
                      $varFor++;
                    }

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
              //MODO RECOLECCION DATOS OTRO
              //dd($fuenteDatos->modo_recoleccion_datos);                 "Otro"
              if(isset($f->modo_recoleccion_datos)){
                $otroModo = explode(',',$f->modo_recoleccion_datos);


                for ($i=0; $i < sizeof($otroModo) ; $i++) {
                  if($otroModo[$i] == 'Otro'){

                    $cadenaOtroModo = 'Otro:'.$f->modo_recoleccion_datos_otro.',';

                  }else{
                    $cadenaOtroModo = $otroModo[$i].',';
                    //dd($cadenaOtroModo);
                  }
                }
                //dd($cadenaOtroModo);
                $cadenaOtroModo = trim($cadenaOtroModo,',');
                $identificacion['recoleccion_datos']  = $cadenaOtroModo;

                //dd($filaFuente);
              }else{

                $identificacion['recoleccion_datos']  = "";
              }


              $identificacion['unidad_analisis'] = $f->unidad_analisis;
              $identificacion['universo_estudio'] = $f->universo_estudio;
              $identificacion['disenio_tamanio_muestra'] = $f->disenio_tamanio_muestra;
              $identificacion['tasa_respuesta'] = $f->tasa_respuesta;
              $identificacion['observacion'] = $f->observacion;
              array_push($cabeceraTitulos,'IDENTIFICACION');

              //ESTADISTICA SOCIAL
              $otroEstadisticaSocial = explode(',',$f->demografia_estadistica_social);

              for ($i=0; $i < sizeof($otroEstadisticaSocial) ; $i++) {
                if($otroEstadisticaSocial[$i] == 'Otro'){

                  $cadenaOtroEstadisticaSocial = 'Otro:'.$f->demografia_estadistica_social_otro.',';


                }else{
                  $cadenaOtroEstadisticaSocial = $otroEstadisticaSocial[$i].',';
                }
              }

              $cadenaOtroEstadisticaSocial = trim($cadenaOtroEstadisticaSocial,',');
              $categoriaTematica['demografia_estadistica_social'] = $cadenaOtroEstadisticaSocial;

              //estadistica_economica

              $otroEstadisticaEconomica = explode(',',$f->estadistica_economica);



              for ($i=0; $i < sizeof($otroEstadisticaEconomica) ; $i++) {
                if($otroEstadisticaEconomica[$i] == 'Otro'){

                  $cadenaOtroEstadisticaEconomica = 'Otro:'.$f->demografia_estadistica_economica_otro.',';


                }else{
                  $cadenaOtroEstadisticaEconomica = $otroEstadisticaEconomica[$i].',';
                }
              }

              $cadenaOtroEstadisticaEconomica = trim($cadenaOtroEstadisticaEconomica,',');
              $categoriaTematica['estadistica_economica']         = $cadenaOtroEstadisticaEconomica ;



              //estadistica_ambiental

              $otroEstadisticaAmbiental = explode(',',$f->estadistica_medioambiental);



              for ($i=0; $i < sizeof($otroEstadisticaAmbiental) ; $i++) {
                if($otroEstadisticaAmbiental[$i] == 'Otro'){

                  $cadenaOtroEstadisticaAmbiental = 'Otro:'.$f->estadistica_medioambiental_otro.',';


                }else{
                  $cadenaOtroEstadisticaAmbiental = $otroEstadisticaAmbiental[$i].',';
                }
              }

              $cadenaOtroEstadisticaAmbiental = trim($cadenaOtroEstadisticaAmbiental,',');
              $categoriaTematica['estadistica_medioambiental']    = $cadenaOtroEstadisticaAmbiental;



              //informacion georeferencial

              $otroInformacionGeoespacial = explode(',',$f->informacion_geoespacial);


              for ($i=0; $i < sizeof($otroInformacionGeoespacial) ; $i++) {
                if($otroInformacionGeoespacial[$i] == 'Otro'){

                  $cadenaOtroInformacionGeoespacial = 'Otro:'.$f->informacion_geoespacial_otro.',';


                }else{
                  $cadenaOtroInformacionGeoespacial = $otroInformacionGeoespacial[$i].',';
                }
              }

              $cadenaOtroInformacionGeoespacial = trim($cadenaOtroInformacionGeoespacial,',');

              $categoriaTematica['informacion_geoespacial']       = $cadenaOtroInformacionGeoespacial;

              array_push($cabeceraTitulos, 'CATEGORIA TEMATICA');

              array_push($formularios,$f->numero_total_formulario);

              array_push($cabeceraFormularios,'CANTIDAD FORMULARIOS');

              if(isset($f->numero_total_formulario)){

                $formulario = explode("|",$f->nombre_formulario);

                $varFor = 1;
                for($i=0;$i<sizeof($formulario);$i++){
                  $key = 'FORM_'.$varFor;

                  array_push($formularios, $formulario[$i]);
                  array_push($cabeceraFormularios, $key);
                  $varFor++;
                }

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
              //MODO RECOLECCION DATOS OTRO
              if(isset($f->modo_recoleccion_datos)){
                $otroModo = explode(',',$f->modo_recoleccion_datos);


                for ($i=0; $i < sizeof($otroModo) ; $i++) {
                  if($otroModo[$i] == 'Otro'){

                    $cadenaOtroModo = 'Otro:'.$f->modo_recoleccion_datos_otro.',';

                  }else{
                    $cadenaOtroModo = $otroModo[$i].',';
                    //dd($cadenaOtroModo);
                  }
                }
                //dd($cadenaOtroModo);
                $cadenaOtroModo = trim($cadenaOtroModo,',');
                $identificacion['recoleccion_datos']  = $cadenaOtroModo;

                //dd($filaFuente);
              }else{

                $identificacion['recoleccion_datos']  = "";
              }


              $identificacion['unidad_analisis'] = $f->unidad_analisis;
              $identificacion['universo_estudio'] = $f->universo_estudio;

              $identificacion['observacion'] = $f->observacion;
              array_push($cabeceraTitulos,'IDENTIFICACION');

              //ESTADISTICA SOCIAL
              $otroEstadisticaSocial = explode(',',$f->demografia_estadistica_social);

              for ($i=0; $i < sizeof($otroEstadisticaSocial) ; $i++) {
                if($otroEstadisticaSocial[$i] == 'Otro'){

                  $cadenaOtroEstadisticaSocial = 'Otro:'.$f->demografia_estadistica_social_otro.',';


                }else{
                  $cadenaOtroEstadisticaSocial = $otroEstadisticaSocial[$i].',';
                }
              }

              $cadenaOtroEstadisticaSocial = trim($cadenaOtroEstadisticaSocial,',');
              $categoriaTematica['demografia_estadistica_social'] = $cadenaOtroEstadisticaSocial;

              //estadistica_economica

              $otroEstadisticaEconomica = explode(',',$f->estadistica_economica);



              for ($i=0; $i < sizeof($otroEstadisticaEconomica) ; $i++) {
                if($otroEstadisticaEconomica[$i] == 'Otro'){

                  $cadenaOtroEstadisticaEconomica = 'Otro:'.$f->demografia_estadistica_economica_otro.',';


                }else{
                  $cadenaOtroEstadisticaEconomica = $otroEstadisticaEconomica[$i].',';
                }
              }

              $cadenaOtroEstadisticaEconomica = trim($cadenaOtroEstadisticaEconomica,',');
              $categoriaTematica['estadistica_economica']         = $cadenaOtroEstadisticaEconomica ;



              //estadistica_ambiental

              $otroEstadisticaAmbiental = explode(',',$f->estadistica_medioambiental);



              for ($i=0; $i < sizeof($otroEstadisticaAmbiental) ; $i++) {
                if($otroEstadisticaAmbiental[$i] == 'Otro'){

                  $cadenaOtroEstadisticaAmbiental = 'Otro:'.$f->estadistica_medioambiental_otro.',';


                }else{
                  $cadenaOtroEstadisticaAmbiental = $otroEstadisticaAmbiental[$i].',';
                }
              }

              $cadenaOtroEstadisticaAmbiental = trim($cadenaOtroEstadisticaAmbiental,',');
              $categoriaTematica['estadistica_medioambiental']    = $cadenaOtroEstadisticaAmbiental;



              //informacion georeferencial

              $otroInformacionGeoespacial = explode(',',$f->informacion_geoespacial);


              for ($i=0; $i < sizeof($otroInformacionGeoespacial) ; $i++) {
                if($otroInformacionGeoespacial[$i] == 'Otro'){

                  $cadenaOtroInformacionGeoespacial = 'Otro:'.$f->informacion_geoespacial_otro.',';


                }else{
                  $cadenaOtroInformacionGeoespacial = $otroInformacionGeoespacial[$i].',';
                }
              }

              $cadenaOtroInformacionGeoespacial = trim($cadenaOtroInformacionGeoespacial,',');

              $categoriaTematica['informacion_geoespacial']       = $cadenaOtroInformacionGeoespacial;

              array_push($cabeceraTitulos, 'CATEGORIA TEMATICA');



              //formularios
              array_push($formularios,$f->numero_total_formulario);
              array_push($cabeceraFormularios,'CANTIDAD FORMULARIOS');
              if (isset($f->numero_total_formulario)) {
                $formulario = explode("|",$f->nombre_formulario);
                $varFor = 1;
                for($i=0;$i<count($formulario);$i++){
                  $key = 'FORM_'.$varFor;

                  array_push($formularios, $formulario[$i]);
                  array_push($cabeceraFormularios, $key);
                  $varFor++;
                }
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


              //centreando los valores

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

  ///  ************       ******************
  public function descagarExcelAdminFuente(Request $request){

    //controlar tamaño de campos de formulario 10,77
    $tamanoTitulos = [];
    $ids = explode(",", trim($request->ids,','));
    //dd("ID :",$ids);
    $mayorCantidadFormularios = FuenteDatos::whereIn('remi_fuente_datos.id',$ids)
                                                ->max('numero_total_formulario');

   // dd('Total Form :'.$mayorCantidadFormularios);
    //controlar tamaño de campos Responsable mandar string
    $registros = implode(',', $ids);
    //dd("regsasdad",$registros);

    $registros = '('.$registros.')';
    //dd($registros);

    $mayorCantidadResponsable = \DB::select("SELECT MAX(count_num) FROM
                          (SELECT id_fuente, count(*) as count_num
                          FROM remi_fuente_datos_responsable
                          where id_fuente IN ".$registros."
                          and activo = true
                          GROUP BY id_fuente) x");

    $cabeceraTitulos = ['IDENTIFICACION',
                        'CATEGORIA TEMATICA',
                        'FORMULARIOS',
                        'COBERTURA' ];


    $r = intval($mayorCantidadResponsable[0]->max);
    $numeroMayorResponsables = $r;

    //dd($numeroMayorResponsables);
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
                      'DISEÑO Y TAMAÑO DE MUESTRA(Aplica solo Encuesta)',
                      'TASA DE RESPUESTA(Aplica solo Encuesta)',
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

    array_push($cabeceraDatos,'COBERTURA DEL RRAA(Aplica Registro Administrativo)','DESCRIPCION DEL RRAA(Aplica Registro Administrativo)','COBERTURA GEOGRAFICA','NIVEL DE DESAGREGACION');

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
                        ->orderBy('id', 'asc')
                        ->get();

    //dd($sql);
   //dd("ffcbvbbc",$cabeceraDatos);
    //creando las filas para el excel
    $tamanoColumnas = [];
    $j=0;
    $arrayContenido = [];
    foreach ($sql as $key => $fuenteDatos){
     // dd($fuenteDatos);
      $tipo = $fuenteDatos->tipo;
      $filaFuente = [];
      //llenando fila fuente
          $filaFuente = array($fuenteDatos->nombre,
                              $fuenteDatos->acronimo,
                              $fuenteDatos->tipo,
                              $fuenteDatos->objetivo,
                              $fuenteDatos->serie_datos,
                              $fuenteDatos->periodicidad,
                              $fuenteDatos->variable);
          //MODO RECOLECCION DATOS OTRO

           //dd($fuenteDatos->modo_recoleccion_datos);//hasta aqui muestra e valor modo recoleccion datos
          if(isset($fuenteDatos->modo_recoleccion_datos)){
            $otroModo = explode(',',$fuenteDatos->modo_recoleccion_datos);

           // dd("REC DAT :",$otroModo);
            for ($i=0; $i < sizeof($otroModo) ; $i++) {
              if($otroModo[$i] == 'Otro'){

                $cadenaOtroModo = 'Otro:'.$fuenteDatos->modo_recoleccion_datos_otro.',';

              }else{
                $cadenaOtroModo = $otroModo[$i].',';
                //dd($cadenaOtroModo);
              }
            }
            //dd($cadenaOtroModo);
            $cadenaOtroModo = trim($cadenaOtroModo,',');

            array_push($filaFuente,$cadenaOtroModo);
            //dd($filaFuente);
          }else{
            array_push($filaFuente,"");
          }

          array_push($filaFuente, $fuenteDatos->unidad_analisis);
          array_push($filaFuente, $fuenteDatos->universo_estudio);
          array_push($filaFuente, $fuenteDatos->disenio_tamanio_muestra);
          array_push($filaFuente, $fuenteDatos->tasa_respuesta);
          array_push($filaFuente, $fuenteDatos->observacion);

          //Demografia estadistica social OTRO
          $otroEstadisticaSocial = explode(',',$fuenteDatos->demografia_estadistica_social);



          for ($i=0; $i < sizeof($otroEstadisticaSocial) ; $i++) {
            if($otroEstadisticaSocial[$i] == 'Otro'){

              $cadenaOtroEstadisticaSocial = 'Otro:'.$fuenteDatos->demografia_estadistica_social_otro.',';


            }else{
              $cadenaOtroEstadisticaSocial = $otroEstadisticaSocial[$i].',';
            }
          }

          $cadenaOtroEstadisticaSocial = trim($cadenaOtroEstadisticaSocial,',');

          array_push($filaFuente,$cadenaOtroEstadisticaSocial);

          //estadistica_economica

          $otroEstadisticaEconomica = explode(',',$fuenteDatos->estadistica_economica);



          for ($i=0; $i < sizeof($otroEstadisticaEconomica) ; $i++) {
            if($otroEstadisticaEconomica[$i] == 'Otro'){

              $cadenaOtroEstadisticaEconomica = 'Otro:'.$fuenteDatos->estadistica_economica_otro.',';


            }else{
              $cadenaOtroEstadisticaEconomica = $otroEstadisticaEconomica[$i].',';
            }
          }

          $cadenaOtroEstadisticaEconomica = trim($cadenaOtroEstadisticaEconomica,',');

          array_push($filaFuente,$cadenaOtroEstadisticaEconomica);

          //estadistica_ambiental

          $otroEstadisticaAmbiental = explode(',',$fuenteDatos->estadistica_medioambiental);



          for ($i=0; $i < sizeof($otroEstadisticaAmbiental) ; $i++) {
            if($otroEstadisticaAmbiental[$i] == 'Otro'){

              $cadenaOtroEstadisticaAmbiental = 'Otro:'.$fuenteDatos->estadistica_medioambiental_otro.',';


            }else{
              $cadenaOtroEstadisticaAmbiental = $otroEstadisticaAmbiental[$i].',';
            }
          }

          $cadenaOtroEstadisticaAmbiental = trim($cadenaOtroEstadisticaAmbiental,',');

          array_push($filaFuente,$cadenaOtroEstadisticaAmbiental);

          //informacion georeferencial

          $otroInformacionGeoespacial = explode(',',$fuenteDatos->informacion_geoespacial);


          for ($i=0; $i < sizeof($otroInformacionGeoespacial) ; $i++) {
            if($otroInformacionGeoespacial[$i] == 'Otro'){

              $cadenaOtroInformacionGeoespacial = 'Otro:'.$fuenteDatos->informacion_geoespacial_otro.',';


            }else{
              $cadenaOtroInformacionGeoespacial = $otroInformacionGeoespacial[$i].',';
            }
          }

          $cadenaOtroInformacionGeoespacial = trim($cadenaOtroInformacionGeoespacial,',');

          array_push($filaFuente,$cadenaOtroInformacionGeoespacial);


          //calculo de los FORMULARIOS

          array_push($filaFuente,$fuenteDatos->numero_total_formulario);
          if(isset($fuenteDatos->nombre_formulario)){

            $nombreformularios = explode("|",$fuenteDatos->nombre_formulario);
            $numFor = sizeof($nombreformularios);
            //dd($numFor);
            $varFor = 0;

            //verificar si es mayor o igual que el maximo de los formularios

            //dd($fuenteDatos->numero_total_formulario);

            if($numFor==$mayorCantidadFormularios){

                for ($i=0; $i < $numFor ; $i++) {

                  array_push($filaFuente,$nombreformularios[$i]);
                }
            }else{

                $aumentarFormulario = 0;


                for ($i=0; $i < $numFor ; $i++) {
                  array_push($filaFuente,$nombreformularios[$i]);
                  $aumentarFormulario++;
                }
                for ($i=$aumentarFormulario; $i < $mayorCantidadFormularios ; $i++) {
                  array_push($filaFuente,"");
                }

            }

          }else{
             for ($i=0; $i < $mayorCantidadFormularios ; $i++) {

                array_push($filaFuente, "");
            }

          }

          //dd($filaFuente);

          //COBERTURA
          array_push($filaFuente,$fuenteDatos->cobertura_rraa);
          array_push($filaFuente,$fuenteDatos->cobertura_rraa_descripcion);


          $cober = explode(",", $fuenteDatos->cobertura_geografica);

          if(count($cober)>1){
            $co = FuenteTiposCobertura::whereIn('id', $cober)->get();

            $cadenaCobertura = "";
            foreach ($co as $c) {
                $cadenaCobertura = $cadenaCobertura.$c->nombre.',';
            }

            array_push($filaFuente,trim($cadenaCobertura,','));//llenando...coberura

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
          if(isset($fuenteDatos->nivel_representatividad_datos)){
            $nivelDesagregacion = explode(",", $fuenteDatos->nivel_representatividad_datos);

            //dd($nivelDesagregacion);

            if(sizeof($nivelDesagregacion)> 1){

              $co = FuenteTiposCobertura::whereIn('id', $nivelDesagregacion)->get();
              $cadenaDesagregacion = "";
              foreach ($co as $c) {
                  $cadenaDesagregacion = $cadenaDesagregacion.$c->nombre.',';
              }
              $cadenaDesagregacion = trim($cadenaDesagregacion,',');
              array_push($filaFuente,$cadenaDesagregacion);

            }else{
              $soloId = intval($nivelDesagregacion[0]);
              $co = FuenteTiposCobertura::where('id', $soloId)->get();
              $cadenaDesagregacion = "";
              foreach ($co as $c) {
                  $cadenaDesagregacion = $cadenaDesagregacion.$c->nombre.',';
              }
              $cadenaDesagregacion = trim($cadenaDesagregacion,',');
              array_push($filaFuente,$cadenaDesagregacion);
            }
          }else{
            array_push($filaFuente,"");
          }




          //trabajando responsable
          $nResponsables = FuenteDatosResponsable::where('id_fuente',$fuenteDatos->id)
                                                    ->where('activo',true)->get();
         // dd($nResponsables);
          $responsableFila = sizeof($nResponsables);

          if($responsableFila == $mayorCantidadResponsable){
            foreach ($nResponsables as $varRes) {
              array_push($filaFuente,$varRes->responsable_nivel_1,$varRes->responsable_nivel_2,$varRes->responsable_nivel_3,$varRes->responsable_nivel_4,$varRes->numero_referencia);
            }
          }else{
            $cContadorResponsable = 0;
            foreach ($nResponsables as $varRes) {
              array_push($filaFuente,$varRes->responsable_nivel_1,$varRes->responsable_nivel_2,$varRes->responsable_nivel_3,$varRes->responsable_nivel_4,$varRes->numero_referencia);
              $cContadorResponsable++;
            }
            //dd($numeroMayorResponsables);

            for ($i=$cContadorResponsable; $i <$r ; $i++) {
              array_push($filaFuente,"","","","","");

            }
            //dd($filaFuente);
          }

          //Acceso a informacion
          array_push($filaFuente,$fuenteDatos->confidencialidad);
          array_push($filaFuente,$fuenteDatos->notas_legales);


      $arrayContenido[$j] = $filaFuente;
     // dd("Contenido",$arrayContenido);
      $j++;

         if($j==2){
            //dd("VER",$arrayContenido);
         }

    }  // fin del foreach
    //dd($arrayContenido);
   // dd($cabeceraTitulos,$tamanoTitulos,$cabeceraDatos,$arrayContenido);
    self::contruirExcelAdminFuente($cabeceraTitulos,$tamanoTitulos,$cabeceraDatos,$arrayContenido);
}  // fin de la descarga de BD a Excel  adminfuentes

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
  }  // fin construir excel adminfuente

  public function descagarExcelAdminIndicador(Request $request){

    ini_set('max_execution_time', 800);
    $tamanoTitulos = [];
    $cabeceraDatos = [];
    $tamFD =[];
    $tamFDD =[];


    $ids = explode(",", trim($request->ids,','));

    $registros = implode(',', $ids);
    $registros = '('.$registros.')';

    $tampdes = \DB::select("SELECT MAX(tam_pds) FROM
                          (SELECT oi.id_indicador, count(*) as tam_pds
                          FROM remi_indicador_pdes_resultado oi
                          INNER JOIN pdes_vista_catalogo_pmr c ON oi.id_resultado = c.id_resultado
                          WHERE oi.id_indicador IN ".$registros."
                          GROUP BY oi.id_indicador
                          order by oi.id_indicador) p");

    $maxpdes = intval($tampdes[0]->max);

    if($maxpdes==0){$maxpdes=1;}

   // dd("dsfsf",$maxpdes);
    $tamods = \DB::select("SELECT MAX(tam_ods) FROM
                          (SELECT oi.id_indicador_ods, count(*) as tam_ods
                          FROM remi_indicador_ods_indicador oi
                          INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador
                          WHERE oi.id_indicador_ods IN ".$registros."
                          GROUP BY oi.id_indicador_ods
                          order by oi.id_indicador_ods) d");

    $maxods = intval($tamods[0]->max);

    if($maxods==0){$maxods=1;}
   //dd("dsfsf",$maxods);
    //  nro de reg de fd distinto de vacio
    $fd = \DB::select("SELECT count(*) as tam from
                        (select i.fuente_datos
                        from remi_indicadores i
                        where i.fuente_datos != '' and i.id IN ".$registros.") l");
    $ctam = (int)$fd[0]->tam;
  //  dd("dsfsf",$ctam);
    if($ctam!=0){

       // $ctam = (int)$fd[0]->tam;  //convienrte el tam en entero

        $fdat = \DB::select("SELECT i.id,i.fuente_datos
                            from remi_indicadores i
                            where i.fuente_datos != '' and i.id IN ".$registros."
                              order by id");

        for ($i=0; $i < $ctam ; $i++) {
              $num = explode(',',$fdat[$i]->fuente_datos);  //2,3,6
              array_push($tamFD, count($num));
        }
       /// dd("fgdfgb",count($num));
        $tamfdat =  max($tamFD);      //   max : 3 de los ctam calculados calcula de tamaño mayor de los ctam a lo ancho
    }else{
        $tamfdat =  1;
    }



    $fdd = \DB::select("SELECT count(*) as tamd from
                        (select i.fuente_datos_d
                        from remi_indicadores i
                        where i.fuente_datos_d != '' and i.id IN ".$registros.") d");

    $ctamd = (int)$fdd[0]->tamd;
    if($ctamd!=0){

       // $ctamd = (int)$fdd[0]->tamd;
        $fdatd = \DB::select("SELECT i.id,i.fuente_datos_d
                            from remi_indicadores i
                            where i.fuente_datos_d != '' and i.id IN ".$registros."
                            order by id");

        //$nden = 0;
        for ($j=0; $j < $ctamd ; $j++) {
              $den = explode(',',$fdatd[$j]->fuente_datos_d);  //64,65,317
              array_push($tamFDD, count($den));
              //$nden = $den;
        }
      //   dd("fgdfgb",$tamFDD);
        $tamfdd = max($tamFDD);    // max : 2   de los ctam calculados calcula de tamaño mayor de los ctam a lo ancho
    }else{
        $tamfdd =  1;
    }



    $max_ra = \DB::select("SELECT MAX(reportados) FROM
                           (SELECT id_indicador, count(*) as reportados
                            FROM remi_indicador_avance
                            where id_indicador IN ".$registros."
                            GROUP BY id_indicador) v");

    $ra = intval($max_ra[0]->max);  //  max :: 3

    if($ra==0){$ra=1;}


    $max_sec = \DB::select("SELECT MAX(tam_sec) from
                            (SELECT s.id_indicador, count(*) as tam_sec
                              FROM remi_indicadores_sectores s
                              INNER JOIN pip_instituciones i ON s.id_institucion=i.id
                              where id_indicador IN ".$registros."
                              GROUP BY s.id_indicador) s");

    $sec = intval($max_sec[0]->max);    //   max  :: 4

    if($sec==0){$sec=1;}
    //dd("xtemfdcxv34345xv",$sec);
    $cabeceraTitulos = ['ID INDICADOR',
                        'PDES',
                        'ODS',
                        'ALINEAR AL PDES',
                        'ALINEAR AL ODS',
                        'INFORMACION BASICA',
                        'LINEA BASE Y METAS',
                        'REPORTE DE AVANCES',
                        'VIABILIDAD DEL INDICADOR',
                        'TIPO DE BRECHA PARA REPORTAR EL INDICADOR',
                        'SECRETARIA TECNICA CIMPDES'];

    array_push($cabeceraDatos,'ID INDICADOR');
    array_push($tamanoTitulos,1);

    array_push($cabeceraDatos,'PDES');
    array_push($tamanoTitulos,1);

    array_push($cabeceraDatos,'ODS');
    array_push($tamanoTitulos,1);

    $pils = 'PILAR_';
    $metx = 'META_';
    $reso = 'RESULTADO_'; //
   // dd("dsfs453",$maxpdes);
    for ($v=1; $v <= $maxpdes; $v++) {
    //  dd("dsfs453",$pils.$i);
      array_push($cabeceraDatos,'PILAR_'.$v);
      array_push($cabeceraDatos,'META_'.$v);
      array_push($cabeceraDatos,'RESULTADO_'.$v);
    }

    array_push($tamanoTitulos,$maxpdes*3);

    if($maxods!=0){

        $comp = 'COMPARABILIDAD_';
        $obje = 'OBJETIVO_';
        $mets = 'META_';
        $indi = 'INDICADOR_';
        for ($h=1; $h <= $maxods; $h++) {
          array_push($cabeceraDatos,'COMPARABILIDAD_'.$h);
          array_push($cabeceraDatos,'OBJETIVO_'.$h);
          array_push($cabeceraDatos,'META_'.$h);
          array_push($cabeceraDatos,'INDICADOR_'.$h);
        }

        array_push($tamanoTitulos,$maxods*4);
    }

     array_push($cabeceraDatos,
                      'NOMBRE DEL INDICADOR',
                      'DEFINICION',
                      'TIPO',
                      'UNIDAD DE MEDIDA',
                      'SERIE DISPONIBLE',
                      'VARIABLES DE DESAGREGACION',
                      'SEXO',
                      'EDAD',
                      'NACIONAL',
                      'DEPARTAMENTAL',
                      'MUNICIPAL',
                      'FORMULA',
                      'NUMERADOR');
    //array_push($tamanoTitulos,7,13);
    $tfnum = 'FUENTE NUMERADOR_';
    for ($i=1; $i <= $tamfdat; $i++) {
      array_push($cabeceraDatos,$tfnum.$i);
    }
    //array_push($tamanoTitulos,$tamfdat);

    array_push($cabeceraDatos,'DENOMINADOR');

    $fdnum = 'FUENTE DENOMINADOR_';
    for ($i=1; $i <=$tamfdd; $i++) {
      array_push($cabeceraDatos,$fdnum.$i);
    }
    //array_push($tamanoTitulos,$tamfdat);

    array_push($cabeceraDatos,'OBSERVACIONES DE LA FUENTE DE DATOS');
    array_push($tamanoTitulos,15+$tamfdat+$tamfdd);

    array_push($cabeceraDatos,'DIA LINEA BASE',
                      'MES LINEA BASE',
                      'AÑO LINEA BASE',
                      'VALOR LINEA BASE',
                      'PLAZO EN AÑOS',
                      'GESTION 2016',
                      'VALOR',
                      'GESTION 2017',
                      'VALOR',
                      'GESTION 2018',
                      'VALOR',
                      'GESTION 2019',
                      'VALOR',
                      'META 2020',
                      'VALOR',
                      'META 2025',
                      'VALOR',
                      'META 2030',
                      'VALOR');
   // dd("dsfdsfsdf",$cabeceraDatos);
     array_push($tamanoTitulos,19);
    //$frep =
    for ($k=1; $k <= $ra ; $k++) {
      array_push($cabeceraDatos,'FECHA REPORTADO_'.$k);
      array_push($cabeceraDatos,'VALOR REPORTADO_'.$k);
      array_push($cabeceraDatos,'DETALLE DEL AVANCE_'.$k);
       //array_push($tamanoTitulos,$max_ra);
    }
     array_push($tamanoTitulos,$ra*3);

    array_push($cabeceraDatos,'ESTADO','ETAPA');
    array_push($tamanoTitulos,2);
    array_push($cabeceraDatos,'BRECHA DE DATOS',
                      'BRECHA DE METODOLOGIA',
                      'BRECHA DE CAPACITACION',
                      'BRECHA DE FINANCIAMIENTO');
     array_push($tamanoTitulos,4);

    array_push($cabeceraDatos,'FRECUENCIA DE REPORTE');

    $secre = 'SECTOR RELACIONADO_';
    for ($w=1; $w <= $sec; $w++) {
      array_push($cabeceraDatos,$secre.$w);
       //array_push($tamanoTitulos,$max_ra);
    }
    array_push($tamanoTitulos,1+$sec);

    //******************* COMIENZA A COLOCAR LOS DATOS DESPUES DE LA CABECERA  ******************************

    //dd("dsfdsfsdf",$tamanoTitulos);
    $sql = Indicadores::whereIn('remi_indicadores.id',$ids)
                        ->orderBy('id', 'asc')
                        ->get();
    $tamanoColumnas = [];
    $w=0;
    $arrayContenido = [];

    foreach ($sql as $key => $IndicadorDatos){

      $filaIndicador = [];
      //llenando fila fuente
      $pdes = [];
      // dd("BIEN",$IndicadorDatos);

      $id_indic = \DB::select("SELECT LPAD(i.id::text, 4, '0') as codigo
                            FROM remi_indicadores i
                            where i.id = ".$IndicadorDatos->id);

  //    dd("BIEN7",$IndicadorDatos->id);
      //dd("BIEN",$id_indic[0]->codigo);
      array_push($filaIndicador, $id_indic[0]->codigo);
      //array_push($filaIndicador, $IndicadorDatos->id);

      $agrupdes = \DB::select("SELECT oi.id_indicador,c.codigo
                                FROM remi_indicador_pdes_resultado oi
                                INNER JOIN pdes_vista_catalogo_pmr c ON oi.id_resultado = c.id_resultado
                                WHERE oi.id_indicador = ".$IndicadorDatos->id."
                                GROUP BY oi.id_indicador,c.codigo
                                order by oi.id_indicador");  // ".$IndicadorDatos->id."

      if(!empty($agrupdes)){
          $datpdes ='';
          foreach ($agrupdes as $key => $value){
            if($datpdes==""){
                 $datpdes = $value->codigo.' ';
            }else {
                 $datpdes = $datpdes.'; '.$value->codigo.' ';
            }
          }
          array_push($filaIndicador, $datpdes);
      }else {
          array_push($filaIndicador, '');
      }

   //    dd("dsscsdf", $datpdes);

      $agrupods = \DB::select("SELECT oi.id_indicador_ods,c.codigo
                                FROM remi_indicador_ods_indicador oi
                                INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador
                                WHERE oi.id_indicador_ods = ".$IndicadorDatos->id."
                                GROUP BY oi.id_indicador_ods,c.codigo
                                order by oi.id_indicador_ods");  // ".$IndicadorDatos->id."

      if(!empty($agrupods)){
            $datods ='';
            foreach ($agrupods as $key => $value) {
              if($datods==""){
                   $datods = $value->codigo.' ';
              }else {
                   $datods = $datods.'; '.$value->codigo.' ';
              }
            }
           array_push($filaIndicador, $datods);
       }else {
           // dd(" vacios", $agrupods);
           array_push($filaIndicador, '');
       }

       //dd("dsscsdf", $datods);


      $regpdes = \DB::select("SELECT MAX(tam_pds) FROM
                            (SELECT oi.id_indicador, count(*) as tam_pds
                            FROM remi_indicador_pdes_resultado oi
                            INNER JOIN pdes_vista_catalogo_pmr c ON oi.id_resultado = c.id_resultado
                            WHERE oi.id_indicador = ".$IndicadorDatos->id."
                            GROUP BY oi.id_indicador
                            order by oi.id_indicador) p");

      $xreg_pdes = intval($regpdes[0]->max);
    //  dd("dsscsdf", $xreg_pdes);
      $pdes = \DB::select("SELECT c.*,ir.id
                           FROM remi_indicador_pdes_resultado ir
                           INNER JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                           WHERE ir.id_indicador = ".$IndicadorDatos->id);
     // dd("dsscsdf", $pdes);

          // if(isset($pdes)){dd("si dato", $pdes); }
          // else{dd("no dato", $pdes); }

          if(isset($pdes)){

               //convierte los numeros $regis fd en el nombre de la FD
                $pdes = \DB::select("SELECT c.*,ir.id
                                     FROM remi_indicador_pdes_resultado ir
                                     INNER JOIN pdes_vista_catalogo_pmr c ON ir.id_resultado = c.id_resultado
                                     WHERE ir.id_indicador = ".$IndicadorDatos->id);

                foreach ($pdes as $key => $value)
                {
                    $pilar_p = $value->cod_p; //dd($pmrp);
                    $meta_m = $value->cod_m;// dd($pmrm);
                    $resultado_r = $value->cod_r;   //dd($pmrr);
                    array_push($filaIndicador, $pilar_p);
                    array_push($filaIndicador, $meta_m);
                    array_push($filaIndicador, $resultado_r);
                }

                for ($i=0; $i<($maxpdes-$xreg_pdes)*3; $i++) {
                       array_push($filaIndicador,'');
                }

          }else{
              for ($i=0; $i<$maxpdes*3; $i++) {
                     array_push($filaIndicador,'');
              }
          }

      $regods = \DB::select("SELECT MAX(tam_ods) FROM
                                (SELECT oi.id_indicador_ods, count(*) as tam_ods
                                FROM remi_indicador_ods_indicador oi
                                INNER JOIN ods_vista_catalogo_omi c ON oi.id_resultado_ods = c.id_indicador
                                WHERE oi.id_indicador_ods = ".$IndicadorDatos->id."
                                GROUP BY oi.id_indicador_ods
                                order by oi.id_indicador_ods) d");

      $xreg_ods = intval($regods[0]->max);

      $ods = \DB::select("SELECT c.*,ir.id,ir.comparabilidad_ods_pdes
                           FROM remi_indicador_ods_indicador ir
                           INNER JOIN ods_vista_catalogo_omi c ON ir.id_resultado_ods = c.id_indicador
                           WHERE ir.id_indicador_ods = ".$IndicadorDatos->id);

          if(isset($ods)){

               //convierte los numeros $regis fd en el nombre de la FD
                $ods = \DB::select("SELECT c.*,ir.id,ir.comparabilidad_ods_pdes
                               FROM remi_indicador_ods_indicador ir
                               INNER JOIN ods_vista_catalogo_omi c ON ir.id_resultado_ods = c.id_indicador
                               WHERE ir.id_indicador_ods = ".$IndicadorDatos->id);

                  foreach ($ods as $key => $value)
                  {

                      $comparabilidad = $value->comparabilidad_ods_pdes;
                      $objetivo_p = $value->cod_o; //dd($pmrp);
                      $meta_m = $value->cod_m;// dd($pmrm);
                      $indicador_r = $value->cod_i;   //dd($pmrr);

                      array_push($filaIndicador, $comparabilidad);
                      array_push($filaIndicador, $objetivo_p);
                      array_push($filaIndicador, $meta_m);
                      array_push($filaIndicador, $indicador_r);
                      //dd($pmr);
                  }

                  for ($i=0; $i<($maxods-$xreg_ods)*4; $i++) {
                         array_push($filaIndicador,'');
                  }

          }else{
              for ($i=0; $i<$maxods*4; $i++) {
                     array_push($filaIndicador,'');
              }
          }

          array_push($filaIndicador, $IndicadorDatos->nombre);
          array_push($filaIndicador, $IndicadorDatos->definicion);
          array_push($filaIndicador, $IndicadorDatos->tipo);
          array_push($filaIndicador, $IndicadorDatos->unidad_medida);
          array_push($filaIndicador, $IndicadorDatos->serie_disponible);
          array_push($filaIndicador, $IndicadorDatos->variables_desagregacion);
          array_push($filaIndicador, $IndicadorDatos->desagregacion_sexo);
          array_push($filaIndicador, $IndicadorDatos->desagregacion_edad);
          array_push($filaIndicador, $IndicadorDatos->desagregacion_nacional);
          array_push($filaIndicador, $IndicadorDatos->desagregacion_deptal);
          array_push($filaIndicador, $IndicadorDatos->desagregacion_munic);
          array_push($filaIndicador, $IndicadorDatos->formula);
          array_push($filaIndicador, $IndicadorDatos->numerador_detalle);

          $indfd = $IndicadorDatos->fuente_datos;

          $numw = explode(',',$IndicadorDatos->fuente_datos);  //2,3,6
          $tfd = count($numw);

          if(isset($indfd)){
                $fd_ind = '('.$indfd.')';

               //convierte los numeros $regis fd en el nombre de la FD
               $fd_nom = \DB::select("SELECT nombre
                                    FROM remi_fuente_datos
                                    where id IN ".$fd_ind."");
               foreach ($fd_nom as $nomb){
                    $nomv = $nomb->nombre;
                    array_push($filaIndicador, $nomv);
               }

                for ($i=0; $i<($tamfdat-$tfd); $i++) {
                       array_push($filaIndicador,'');
                }

          }else{
              for ($i=0; $i<$tamfdat; $i++) {
                     array_push($filaIndicador,'');
              }
          }

          array_push($filaIndicador, $IndicadorDatos->denominador_detalle);

          $ind_fdd = $IndicadorDatos->fuente_datos_d;

          $denumw = explode(',',$IndicadorDatos->fuente_datos_d);  //2,3,6
          $tfdd = count($denumw);


          if($ind_fdd){

                $fdd_ind = '('.$ind_fdd.')';

               //convierte los numeros $regis fd en el nombre de la FD
               $fd_denom = \DB::select("SELECT nombre
                                    FROM remi_fuente_datos f
                                    where f.id IN ".$fdd_ind."");

              // dd("FDFS",$fd_denom);
               foreach ($fd_denom as $dnomb){
                    $nomv = $dnomb->nombre;
                    array_push($filaIndicador, $nomv);
               }

                for ($i=0; $i<($tamfdd-$tfdd); $i++) {
                       array_push($filaIndicador,'');
                }

          }else{
              for ($i=0; $i<$tamfdd; $i++) {
                     array_push($filaIndicador,'');
              }
          }

          array_push($filaIndicador, $IndicadorDatos->observacion);
          array_push($filaIndicador, $IndicadorDatos->linea_base_dia);
          array_push($filaIndicador, $IndicadorDatos->linea_base_mes);
          array_push($filaIndicador, $IndicadorDatos->linea_base_anio);
          array_push($filaIndicador, $IndicadorDatos->linea_base_valor);
          array_push($filaIndicador, '5');

          $tam = Metas::where('id_indicador',$IndicadorDatos->id)->count();

          $TamGestion = \DB::select("SELECT *
                              FROM remi_metas
                              where id_indicador=".$IndicadorDatos->id."
                              order by gestion");
         // dd($TamGestion);
          for ($i=0; $i < $tam; $i++){
              array_push($filaIndicador, $TamGestion[$i]->gestion);
              array_push($filaIndicador, $TamGestion[$i]->valor);
          }
         // dd("bmbj788",$filaIndicador);

          $tams = IndicadorAvance::where('id_indicador',$IndicadorDatos->id)->count();
           // dd($tams);
          $TamAvances = \DB::select("SELECT *
                              FROM remi_indicador_avance
                              where id_indicador= ".$IndicadorDatos->id."
                              order by fecha_generado_anio");
            // dd("avances ",$TamAvances);   ".$IndicadorDatos->id."

           if(empty($TamAvances)){
              for ($i=0; $i<($ra*3); $i++) {
                  array_push($filaIndicador,'');
                }

           }else{
              for ($j=0; $j < $tams; $j++){
                  array_push($filaIndicador, $TamAvances[$j]->fecha_generado_dia."/".$TamAvances[$j]->fecha_generado_mes."/".$TamAvances[$j]->fecha_generado_anio);
                  array_push($filaIndicador, $TamAvances[$j]->valor);
                  array_push($filaIndicador, $TamAvances[$j]->detalle_avance);
              }
              //dd("bmbj788",$filaIndicador);
              for ($i=0; $i<(($ra-$tams)*3); $i++) {
                  array_push($filaIndicador,'');
                }

           }

          array_push($filaIndicador, $IndicadorDatos->estado);
          array_push($filaIndicador, $IndicadorDatos->etapa);
          array_push($filaIndicador, $IndicadorDatos->brecha_datos);
          array_push($filaIndicador, $IndicadorDatos->brecha_metodologia);
          array_push($filaIndicador, $IndicadorDatos->brecha_capacitacion);
          array_push($filaIndicador, $IndicadorDatos->brecha_financiamiento);
          array_push($filaIndicador, $IndicadorDatos->frecuencia_reporte);

          $Sectorel = \DB::select("SELECT denominacion
                                    FROM pip_instituciones
                                    where id IN (SELECT id_institucion
                                    FROM remi_indicadores_sectores
                                    where id_indicador=".$IndicadorDatos->id.")");

          for ($h=0; $h<$sec; $h++) {
              if(!empty($Sectorel[$h]->denominacion)){
                 array_push($filaIndicador, $Sectorel[$h]->denominacion);
              }
          }

         $arrayContenido[$w] = $filaIndicador;
         //dd("Contenido",$arrayContenido);
         $w++;


    }  //fin del foreach
         // dd($cabeceraTitulos,$tamanoTitulos,$cabeceraDatos,$arrayContenido);
         self::contruirExcelAdminIndicador($cabeceraTitulos,$tamanoTitulos,$cabeceraDatos,$arrayContenido);
  } // fin descarga indicador

  static function contruirExcelAdminIndicador($cabeceraTitulos,$tamanoTitulos, $cabeceraDatos,$arrayContenido){

 \Excel::create('Admin Indicadores', function ($excel) use ($cabeceraTitulos,$tamanoTitulos, $cabeceraDatos,$arrayContenido){

      // $paletaColor = ['#F1948A', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
      $paletaColor = ['#D4E6F1', '#C39BD3' , '#7FB3D5', '#AED6F1', '#76D7C4', '#F9E79F', '#F8C471', '#F5CBA7', '#E59866', '#D4E6F1'];
      $excel->sheet('Indicadores', function($hoja) use ($cabeceraTitulos,$tamanoTitulos, $cabeceraDatos,$arrayContenido,$paletaColor){


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

  }  // fin de construir excel

}
