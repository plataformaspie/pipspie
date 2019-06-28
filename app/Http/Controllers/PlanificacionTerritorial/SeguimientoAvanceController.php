<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlanificacionTerritorial\Parametros;
use App\Models\PlanificacionTerritorial\RecursosPoa;
use App\Models\PlanificacionTerritorial\ProyectoPoa;
use App\Models\PlanificacionTerritorial\ProyectoPoaAjuste;
use App\Models\PlanificacionTerritorial\CategoriaProgramatica;


class SeguimientoAvanceController extends BasecontrollerController
{

  public function listaAvanceObjetivos(){


    $user = \Auth::user();

    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    $gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
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
    
    /*$objEta = \DB::select("select * from sp_eta_planes as etaPlanes,
                            sp_eta_objetivos_eta as etaObj,
                            sp_eta_catalogo_acciones_eta as catEta,
                            sp_eta_articulacion_catalogos as artPmra
              where etaPlanes.id_institucion = 560
              and etaPlanes.id = etaObj.id_plan
              and etaObj.id_accion_eta = catEta.id
              and etaObj.id_accion_eta = artPmra.id_accion_eta");*/
              //$gestion = '2018';
    $objetivo_indicador =\DB::select("select * from sp_eta_planes as plan,
                                      sp_eta_objetivos_eta as objetivos,
                                      sp_eta_articulacion_objetivo_indicador as arti,
                                      sp_eta_indicadores as indi,
                                      sp_eta_programacion_indicador as p_indi,
                                      sp_eta_catalogo_acciones_eta as catEta,
                                     
                        where plan.id_institucion = $user->id_institucion
                        and objetivos.id_plan = plan.id
                        and objetivos.id = arti.id_objetivo_eta
                        and objetivos.id_accion_eta = catEta.id
                        
                        and arti.id_indicador = indi.id
                        and arti.id = p_indi.id_articulacion_objetivo_indicador
                        and p_indi.gestion = $gestionActiva->gestion");

    /*$objetivo_indicador =\DB::select("select * from sp_eta_planes as plan,
                                      sp_eta_objetivos_eta as objetivos,
                                      sp_eta_articulacion_objetivo_indicador as arti,
                                      sp_eta_indicadores as indi,
                                      sp_eta_programacion_indicador as p_indi,
                                      sp_eta_catalogo_acciones_eta as catEta,
                                      sp_eta_articulacion_catalogos as artPmra
                        where plan.id_institucion = 560
                        and objetivos.id_plan = plan.id
                        and objetivos.id = arti.id_objetivo_eta
                        and objetivos.id_accion_eta = catEta.id
                        and objetivos.id_accion_eta = artPmra.id_accion_eta
                        and arti.id_indicador = indi.id
                        and arti.id = p_indi.id_articulacion_objetivo_indicador
                        and p_indi.gestion = '2018'");*/
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

      /*$poa = \DB::select("select * from sp_eta_proyectos_poa
                                where id_accion_eta = 1");*/
      $poa = ProyectoPoa::where('id_accion_eta',$obj->id_accion_eta)
                          ->where('activo',true)
                          ->get();

      $obj->poa = $poa;


    }

    return \Response::json([
                              'objEta'=>$objetivo_indicador,
                              'estado_modulo'=>$estado_etapa,
                              'plan_activo'=>$planActivo->descripcion,
                              'gestion_activa'=>$gestionActiva->gestion]);
  }
  
/*
  public function listaTipoRecursos(Request $request)
  {
      $user = \Auth::user();
      $parametros = Parametros::where('categoria', 'tipo_recursos')
      ->where('activo', true)
      ->orderBy('orden', 'ASC')
      ->get();

      $grupos = Array();
      $sw="";
      $i=0;
      foreach ($parametros as $item) {
          if($item->valor != $sw){
              $sw=$item->valor;
              $grupos[$i]['id'] = $item->id;
              $grupos[$i]['valor'] = $item->valor;
              $grupos[$i]['orden'] = $item->orden;
              $grupos[$i]['codigo'] = $item->codigo;
              $i++;
          }
        }

      $periodo = Array();
      $gestionInicial = 2016;
      $gestionFinal = 2020;
      for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
        $periodo[] = $i;
      }

      $totales = \DB::select("
      SELECT fuente.nombre as gestion,
      (
        SELECT SUM(monto)
        FROM sp_eta_recursos_eta
        WHERE activo = true
        AND id_institucion = ".$user->id_institucion."
        AND gestion = fuente.codigo::int
      ) as total
      FROM(
        SELECT *
        from sp_parametros pa
        WHERE activo = TRUE
        AND categoria = 'gestiones'
        AND codigo BETWEEN '".$gestionInicial."' AND '".$gestionFinal."'
        ORDER BY codigo ASC
      ) as fuente");

      $totalPresupuesto=0;
      foreach ($totales as  $item) {
        $totalPresupuesto = $totalPresupuesto + $item->total;
      }
      

      $recursosCreados = \DB::select("SELECT id_tipo_recurso
      FROM sp_eta_recursos_eta
      WHERE id_institucion = ".$user->id_institucion."
      AND activo = true
      GROUP BY id_tipo_recurso
      ORDER BY id_tipo_recurso ASC");

      $arrayRecursosCreados = Array();
      foreach ($recursosCreados as $item) {
        $arrayRecursosCreados[] = $item->id_tipo_recurso;
      }


      $recursosCreadosGestiones = \DB::select("SELECT id,id_tipo_recurso,gestion,monto
      FROM sp_eta_recursos_eta
      WHERE id_institucion = ".$user->id_institucion."
      and activo = true
      ORDER BY id_tipo_recurso,gestion ASC");

      $arrayRecursosCreadosGestiones  = array();
      foreach ($recursosCreadosGestiones as $item) {
        $arrayRecursosCreadosGestiones['monto'][$item->id_tipo_recurso][$item->gestion] = $item->monto;
        $arrayRecursosCreadosGestiones['id'][$item->id_tipo_recurso][$item->gestion] = $item->id;
      }


      $arrayOtros = OtrosIngresos::where('id_institucion',$user->id_institucion)->where('activo', true)->orderby('id', 'ASC')->get();
      $otrosIngresosRecursosGestiones = \DB::select("SELECT id,id_otro_ingreso,gestion,monto
      FROM sp_eta_recursos_eta
      WHERE id_institucion = ".$user->id_institucion."
      and activo = true
      AND id_otro_ingreso is not null
      ORDER BY id_otro_ingreso,gestion ASC");
      $arrayOtrosIngresosRecursosCreadosGestiones  = array();
      foreach ($otrosIngresosRecursosGestiones as $item) {
        $arrayOtrosIngresosRecursosCreadosGestiones['datos'][$item->id_otro_ingreso][$item->gestion] = $item->monto;
        $arrayOtrosIngresosRecursosCreadosGestiones['ids'][$item->id_otro_ingreso][$item->gestion] = $item->id;
      }

      return \Response::json([
        'parametros' => $parametros,
        'grupos' => $grupos,
        'periodoActivo' => $periodo,
        'totales' => $totales,
        'totalPresupuesto' => $totalPresupuesto,
        'recursosCreados' => $arrayRecursosCreados,
        'recursosCreadosGestiones' => $arrayRecursosCreadosGestiones,
        'otrosIngresos' => $arrayOtros,
        'otrosIngresosRecursosCreadosGestiones' => $arrayOtrosIngresosRecursosCreadosGestiones
      ]);

  }

  public function saveRecursoTipo(Request $request)
  {
    $periodo = Array();
    $gestionInicial = 2016;
    $gestionFinal = 2020;
    for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
      $periodo[] = $i;
    }
    $user = \Auth::user();
    
    try{
        foreach ($request->datos as $k => $v) {
            
            $this->decimal_simbolo($v);
            $recurso = new Recursos();
            $recurso->id_institucion = $user->id_institucion;
            $recurso->id_tipo_recurso = $request->tipo_recurso;
            $recurso->gestion = $periodo[$k];
            $recurso->monto = $this->format_numerica_db($v,$this->decimal_simbolo($v));
            $recurso->activo = true;
            $recurso->id_user_created = $user->id;
            $recurso->save();
        }
        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se guardo con exito.")
        );

      }
      catch (Exception $e) {
          return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'msg' => $e->getMessage())
          );
      }


      return 1;

  }

  public function saveUpdateRecursoTipo(Request $request)
  {
    $periodo = Array();
    $gestionInicial = 2016;
    $gestionFinal = 2020;
    for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
      $periodo[] = $i;
    }
    $user = \Auth::user();

    try{
        foreach ($request->datos as $k => $v) {
            $recurso = Recursos::find($request->id[$k]);
            $recurso->monto = $this->format_numerica_db($v,$this->decimal_simbolo($v));
            $recurso->id_user_updated = $user->id;
            $recurso->save();
        }
        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se guardo con exito.")
        );

      }
      catch (Exception $e) {
          return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'msg' => $e->getMessage())
          );
      }
  }



  public function deleteRecurso(Request $request)
  {

    $user = \Auth::user();
    try{
        foreach ($request->id as $k => $v) {
            $recurso = Recursos::find($v);
            $recurso->activo = false;
            $recurso->id_user_updated = $user->id;
            $recurso->save();
        }
        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se guardo con exito.")
        );

      }
      catch (Exception $e) {
          return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'msg' => $e->getMessage())
          );
      }

  }



    public function saveOtro(Request $request)
    {
      $periodo = Array();
      $gestionInicial = 2016;
      $gestionFinal = 2020;
      for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
        $periodo[] = $i;
      }

      $user = \Auth::user();

      if($request->id_otro == 0){
          try{

              $otro = new OtrosIngresos();
              $otro->id_institucion = $user->id_institucion;
              $otro->concepto = $request->concepto;
              $otro->fuente_financiamiento = $request->fuente_financiamiento;
              $otro->organismo_financiador = $request->organismo_financiador;
              $otro->rubro = $request->rubro;
              $otro->entidad_otorgante = $request->entidad_otorgante;
              $otro->activo = true;
              $otro->id_user_created = $user->id;
              $otro->save();


              foreach ($request->datos as $k => $v) {
                  $recurso = new Recursos();
                  $recurso->id_institucion = $user->id_institucion;
                  $recurso->id_otro_ingreso = $otro->id;
                  $recurso->gestion = $periodo[$k];
                  $recurso->monto = $this->format_numerica_db($v,$this->decimal_simbolo($v));
                  $recurso->activo = true;
                  $recurso->id_user_created = $user->id;
                  $recurso->save();
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

              $otro =  OtrosIngresos::find($request->id_otro);
              $otro->concepto = $request->concepto;
              $otro->fuente_financiamiento = $request->fuente_financiamiento;
              $otro->organismo_financiador = $request->organismo_financiador;
              $otro->rubro = $request->rubro;
              $otro->entidad_otorgante = $request->entidad_otorgante;
              $otro->id_user_updated= $user->id;
              $otro->save();

              foreach ($request->datos as $k => $v) {
                  $recurso = Recursos::find($request->ids[$k]);
                  $recurso->gestion = $periodo[$k];
                  $recurso->monto = $this->format_numerica_db($v,$this->decimal_simbolo($v));
                  $recurso->id_user_updated = $user->id;
                  $recurso->save();
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


  public function deleteOtro(Request $request)
  {

    $user = \Auth::user();
    try{
          $otro =  OtrosIngresos::find($request->id_otro);
          $otro->activo = false;
          $otro->save();
          \DB::table('sp_eta_recursos_eta')->where('id_otro_ingreso', $request->id_otro)->update(['activo' => false]);
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
            'msg' => $e->getMessage())
          );
      }

  }*/
  public function listaCategoriaProgramatica(){
    $user = \Auth::user();
    $tipo_entidad = 'municipio';
    switch($tipo_entidad){
      case 'municipio':{
        $listaProgramatica = CategoriaProgramatica::get();
        return \Response::json(array('categoria'=>$listaProgramatica));
        break;
      }
      case 'gobernacion':{
        break;
      }
    }
  }
  public function listaObjetivosEta(){
    $user = \Auth::user();
    
    /*$objEta = \DB::select("select * from sp_eta_planes as etaPlanes,
                            sp_eta_objetivos_eta as etaObj,
                            sp_eta_catalogo_acciones_eta as catEta,
                            sp_eta_articulacion_catalogos as artPmra
              where etaPlanes.id_institucion = 560
              and etaPlanes.id = etaObj.id_plan
              and etaObj.id_accion_eta = catEta.id
              and etaObj.id_accion_eta = artPmra.id_accion_eta");*/
              $gestion = '2018';
    $objetivo_indicador =\DB::select("select * from sp_eta_planes as plan,
                                      sp_eta_objetivos_eta as objetivos,
                                      sp_eta_articulacion_objetivo_indicador as arti,
                                      sp_eta_indicadores as indi,
                                      sp_eta_programacion_indicador as p_indi,
                                      sp_eta_catalogo_acciones_eta as catEta,
                                      sp_eta_articulacion_catalogos as artPmra
                        where plan.id_institucion = 560
                        and objetivos.id_plan = plan.id
                        and objetivos.id = arti.id_objetivo_eta
                        and objetivos.id_accion_eta = catEta.id
                        and objetivos.id_accion_eta = artPmra.id_accion_eta
                        and arti.id_indicador = indi.id
                        and arti.id = p_indi.id_articulacion_objetivo_indicador
                        and p_indi.gestion = '2018'");
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

      /*$poa = \DB::select("select * from sp_eta_proyectos_poa
                                where id_accion_eta = 1");*/
      $poa = ProyectoPoa::where('id_accion_eta',$obj->id_accion_eta)
                          ->where('activo',true)
                          ->get();

      $obj->poa = $poa;


    }

    return \Response::json(['objEta'=>$objetivo_indicador]);
  }
  public function saveProyectoPoa(Request $request){
    $user = \Auth::user();
    $gestion=2018;
    $p=$request->datos;
    if($p['id'] == 0){
      try{

        $proyPoa = new ProyectoPoa();
        $proyPoa->id_accion_eta = $p['id_accion_eta'];
        $proyPoa->nombre = $p['nombre'];
        $proyPoa->categoria_programatica = $p['categoria_programatica'];
        $proyPoa->gestion = $gestion;
        $proyPoa->id_institucion = $user->id_institucion;
        $proyPoa->activo = true;
        $proyPoa->monto = $p['monto'];
        $proyPoa->avance_fisico = $p['avance_fisico'];
        $proyPoa->codigo_sisin = $p['codigo_sisin'];
        $proyPoa->inscrito_ptdi = $p['inscrito_ptdi'];
        $proyPoa->inscrito_pei = $p['inscrito_pei'];
        $proyPoa->inscrito_poa = $p['inscrito_poa'];
        $proyPoa->id_user_updated = $user->id;
        $proyPoa->save();

        return \Response::json(array(
              'error' => false,
              'title' => "Success!",
              'msg' => "Se guardo con exito."
        ));
      }catch(Exception $e){
        return \Response::json(array(
              'error' => true,
              'title' => "Error!",
              'msg' => $e->getMessage())
            );
      }
    }else{
      try{

          $proyPoa =  ProyectoPoa()::find($p->id);
          $proyPoa->id_accion_eta = $p['id_accion_eta'];
          $proyPoa->nombre = $p['nombre'];
          $proyPoa->categoria_programatica = $p['categoriaProgramatica'];
          $proyPoa->gestion = $gestion;
          $proyPoa->id_institucion = $user->id_institucion;
          $proyPoa->activo = true;
          $proyPoa->monto = $p['monto'];
          $proyPoa->avance_fisico = $p['avance_fisico'];
          $proyPoa->codigo_sisin = $p['codigo_sisin'];
          $proyPoa->inscrito_ptdi = $p['inscrito_ptdi'];
          $proyPoa->inscrito_pei = $p['inscrito_pei'];
          $proyPoa->inscrito_poa = $p['inscrito_poa'];
          $recurso->id_user_updated = $user->id;
          $proyPoa->save();
          
          
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
  public function deleteProyPoa(Request $request)
  {

    $user = \Auth::user();
    if($request->id){
      try{
        
          $proyPoa = ProyectoPoa::find($request->id);
          $proyPoa->activo = false;
          $proyPoa->id_user_updated = $user->id;
          $proyPoa->save();
        
        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se elimino con exito.")
        );

      }
      catch (Exception $e) {
          return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'msg' => $e->getMessage())
          );
      }
    }
  }

  public function saveProyectoPoaAjuste(Request $request){
    $user = \Auth::user();
    $gestion=2018;
    $id_institucion = $user->id_institucion;
    $p = $request->datos;
    try{
      $poaAjuste = new ProyectoPoaAjuste();
      $poaAjuste->id_institucion = $id_institucion;
      $poaAjuste->nombre_proyecto = $p['nombre_proyecto'];
      $poaAjuste->categoria_programatica = $p['categoria_programatica'];
      $poaAjuste->inscrito_ptdi = $p['inscrito_ptdi'];
      $poaAjuste->inscrito_pei = $p['inscrito_pei'];
      $poaAjuste->gestion = $gestion;
      $poaAjuste->save();
      return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se guardo con exito."
      ));
    }catch(Exception $e){
      return \Response::json(array(
            'error' => true,
            'title' => "Error!",
            'msg' => $e->getMessage())
          );
    }


  }
  public function listaProyectosPoaAjuste(){
    //$user = \Auth::user();
    $gestion = 2018;
    $id_institucion  = 319;
    //$proyectosAjuste = ProyectoPoaAjuste::where('id_institucion',$id_institucion)->get();
    //dd($proyectosAjuste);
    $proyectosAjuste = \DB::select("select * from sp_eta_proyectos_poa_ajuste
                                      where id_institucion = 319");
    foreach ($proyectosAjuste as $v) {
      switch ($v->inscrito_ptdi) {
        case true:
          $v->inscrito_ptdi = 'Si';
          break;
        case false:
          $v->inscrito_ptdi = 'No';
          break;

      }
      switch ($v->inscrito_pei) {
        case true:
          $v->inscrito_pei = 'Si';
          break;
        case false:
          $v->inscrito_pei = 'No';
          break;

      }

    }
    return \Response::json(array("proyectosPoaAjuste"=>$proyectosAjuste));

  }
}
