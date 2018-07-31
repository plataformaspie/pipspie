<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanificacionTerritorialController2 extends PlanificacionBaseController
{

  public function showPlanificacionTerritorialactualizador()
  {
    return view('ModuloPlanificacion.show-planificacion-territorial-actualizar');
  }
  public function listaMatricesEditar()
  {
    $matrices = \DB::select("select m.id_correlativo,d.id_departamento,d.descripcion_departamento,p.id_provincia,p.descripcion_provincia,mu.id_municipio, mu.descripcion_municipio,m.id_programa,m.descripcion_programa,m.accion_eta,m.cantidad_presupuesto,m.presupuesto2016, m.presupuesto2017,m.presupuesto2018,m.presupuesto2019,m.presupuesto2020,m.descripcion_accion 
from sp_pt_departamentos d,sp_pt_provincias p,sp_pt_municipios mu ,sp_pt_matrices m
where d.id_departamento=p.id_departamento and d.id_departamento=mu.id_departamento and d.id_departamento=m.id_departamento 
and p.id_departamento=mu.id_departamento and p.id_departamento=m.id_departamento and m.id_departamento=mu.id_departamento
and p.id_provincia=mu.id_provincia and p.id_provincia=m.id_provincia and m.id_provincia=mu.id_provincia
and mu.id_municipio=m.id_municipio " );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo la matriz',
      'matrices'=>$matrices
    ]);
  }
  public function listaDepartamentosEditar()
  {
  	$departamentos = \DB::select('select * from sp_pt_departamentos');
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se cargo departamentos',
  		'departamentos'=>$departamentos
  	]);
  }

  public function listaProvinciasEditar($iddepto)
  {
  	$provincias = \DB::select("select * from sp_pt_provincias where id_departamento={$iddepto}" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se cargo provincias',
  		'provincias'=>$provincias
  	]);
  }
  public function listaMunicipiosMatrices($iddepto,$idprov)
  {
  	$mun = \DB::select("select mu.id_municipio,mu.descripcion_municipio 
from sp_pt_municipios mu,sp_pt_matrices m  
where m.id_municipio=mu.id_municipio and m.id_departamento=mu.id_Departamento and mu.id_provincia=m.id_provincia and m.id_departamento = {$iddepto} and m.id_provincia = {$idprov}
group by mu.id_municipio,mu.descripcion_municipio order by id_municipio " );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se cargo municipios',
  		'municipios'=>$mun
  	]);
  }
  public function listaGastosMatrices($iddepto,$idprov,$idmun)
  {
  	$gas = \DB::select("select id_programa,descripcion_programa from sp_pt_matrices where id_departamento={$iddepto} and id_provincia={$idprov} and id_municipio={$idmun} group by id_programa,descripcion_programa order by id_programa" );
    //
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se Cargo Gastos',
  		'gastos'=>$gas
  	]);
  }
   public function listaAccionesMatrices($iddepto,$idprov,$idmun,$idgas)
  {
  	$acciones = \DB::select("select id_programa,accion_eta from sp_pt_matrices where id_departamento={$iddepto} and id_provincia={$idprov} and id_municipio={$idmun} and id_programa={$idgas} group by id_programa,accion_eta" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se Cargaron las Acciones',
  		'acciones'=>$acciones
  	]);
  }
  
  public function listaRegistroMatrices()
  {
    $registros = \DB::select("select  ROW_NUMBER() OVER (ORDER BY descripcion_departamento) as no,descripcion_departamento,descripcion_provincia,descripcion_municipio,count(id_programa) as registros1
 from vw_matriz 
 group by descripcion_departamento,descripcion_provincia,descripcion_municipio " );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo los registros',
      'registros'=>$registros
    ]);
  }
  public function export() 
{
  $datedoc=date("d/m/Y H:i:s");
    //return Excel::download(new UserExport,'hol.xlsx');
}



 

 /* public function listaAcciones($idgasto)
  {
  	$acciones = \DB::select("select id_programa,descripcion_gasto from sp_pt_gad where actividad<>'0' and id_programa={$idgasto}" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se Cargo Gastos',
  		'acciones'=>$acciones
  	]);
  }
   public function listaTipos($idgasto)
  {
  	$tipos = \DB::select("select distinct(clasificador) from sp_pt_accion where   id_estructura_prog={$idgasto} and clasificador<>''" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se Cargo Gastos',
  		'tipos'=>$tipos
  	]);
  }
  public function listaAcciones2($idgasto)
  {
  	$acciones = \DB::select("select id_correlativo,accion_eta from sp_pt_accion where id_estructura_prog={$idgasto}" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se Cargo Gastos',
  		'acciones'=>$acciones
  	]);
  }
   public function listaServicios($idgasto,$idtipo)
  {
  	$servicios = \DB::select("select distinct(servicio) from sp_pt_accion where id_estructura_prog={$idgasto} and clasificador='{$idtipo}' and servicio<>''" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se Cargo Gastos',
  		'servicios'=>$servicios
  	]);
  }
  public function listaAcciones3($idgasto,$idtipo,$idser)
  {
  	$acciones = \DB::select("select id_correlativo,accion_eta from sp_pt_accion where id_estructura_prog={$idgasto}  and clasificador='{$idtipo}' and servicio like '%{$idser}%'" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se Cargo Gastos',
  		'acciones'=>$acciones
  	]);
  }
  public function listaPilares($idaccion)
  {
    $acciones = \DB::select("select id_pilar,id_correlativo,accion_eta from sp_pt_accion where id_correlativo={$idaccion}" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo Gastos',
      'acciones'=>$acciones
    ]);
  }
  public function listaMetas($idaccion)
  {
    $acciones = \DB::select("select id_meta,id_correlativo,accion_eta from sp_pt_accion where id_correlativo={$idaccion}" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo Gastos',
      'acciones'=>$acciones
    ]);
  }
  public function listaResultados($idaccion)
  {
    $acciones = \DB::select("select id_resultado,id_correlativo,accion_eta from sp_pt_accion where id_correlativo={$idaccion}" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo Gastos',
      'acciones'=>$acciones
    ]);
  }
  public function listaAccionesEtas($idaccion)
  {
    $acciones = \DB::select("select id_accion,id_correlativo,accion_eta from sp_pt_accion where id_correlativo={$idaccion}" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo Gastos',
      'acciones'=>$acciones
    ]);
  }
  public function listaPMRAs($idpilar,$idmeta,$idresultado,$idaccion)
  {
    $acciones = \DB::select("select id_correlativo,descripcion_directriz from sp_pt_directrices where id_pilar={$idpilar} and id_meta={$idmeta} and id_resultado={$idresultado} and id_accion={$idaccion}" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo Gastos',
      'acciones'=>$acciones
    ]);
  }

  public function insertar(Request $req)
  {
    $matriz = [];
    $matriz['id_departamento'] = $req->id_departamento;
    $matriz['id_provincia'] = $req->id_provincia;
    $matriz['id_municipio'] = $req->id_municipio;
    $matriz['id_programa'] = $req->id_programa;
    $matriz['descripcion_programa'] = $req->descripcion_programa;
    $matriz['accion_eta'] = $req->accion_eta;
    $matriz['linea_base'] = $req->linea_base;
    $matriz['proceso_indicador'] = $req->proceso_indicador;
    $matriz['unidad_indicador'] = $req->unidad_indicador;
    $matriz['cantidad_indicador'] = $req->cantidad_indicador;
    $matriz['indicador2016'] = $req->indicador2016;
    $matriz['indicador2017'] = $req->indicador2017;
    $matriz['indicador2018'] = $req->indicador2018;
    $matriz['indicador2019'] = $req->indicador2019;
    $matriz['indicador2020'] = $req->indicador2020;
    $matriz['cantidad_presupuesto'] = $req->cantidad_presupuesto;
    $matriz['presupuesto2016'] = $req->presupuesto2016;
    $matriz['presupuesto2017'] = $req->presupuesto2017;
    $matriz['presupuesto2018'] = $req->presupuesto2018;
    $matriz['presupuesto2019'] = $req->presupuesto2019;
    $matriz['presupuesto2020'] = $req->presupuesto2020;
    $matriz['pilar'] = $req->pilar;
    $matriz['meta'] = $req->meta;
    $matriz['resultado'] = $req->resultado;
    $matriz['accion'] = $req->accion;
    $matriz['descripcion_accion'] = $req->descripcion_accion;    
    $matriz['usuario_creador']=$this->user->id;
    $matriz['fecha_creacion']=date("d/m/Y H:i:s");
    $matriz['estado'] = 'CREADO';
    $matriz['indicador_de_genero'] = 0;
    
    try {
      \DB::table('sp_pt_matrices')->insert($matriz);
    return response()->json([
      'msg' => 'Matriz insertada']);
      
    } catch (Exception $e) {
      return response()->json([
      'msg' => 'Matriz No insertada'.$e ]);
    }



  }*/

    
  
}