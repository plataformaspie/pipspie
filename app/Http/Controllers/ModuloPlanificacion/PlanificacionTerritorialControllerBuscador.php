<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanificacionTerritorialControllerBuscador extends PlanificacionBaseController
{

  public function showPlanificacionTerritorialBuscador()
  {
    return view('ModuloPlanificacion.show-planificacion-territorial-buscador');
  }
  /*nueva lista por filtros*/
  public function listaSelecTipoEta()
  {
    $seletas = \DB::select('select m.tipo_eta,e.descripcion_eta from sp_pt_matrices m,sp_pt_eta e where e.id_eta=m.tipo_eta group by (m.tipo_eta,e.descripcion_eta)');
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se cargo tipos etas',
      'seletas'=>$seletas
    ]);
  }
  
  public function listaNuevaMatriz($tipoeta,$prog)
  {
    $nmat = \DB::select("select m.tipo_eta,m.id_tarea_eta,m.tipo_eta,e.descripcion_eta,m.id_correlativo,d.id_departamento,d.descripcion_departamento,p.id_provincia,p.descripcion_provincia,mu.id_municipio, mu.descripcion_municipio,m.id_programa,m.descripcion_programa,m.accion_eta,m.linea_base,m.proceso_indicador,m.unidad_indicador,m.cantidad_indicador,indicador2016,indicador2017,indicador2018,indicador2019,indicador2020,m.cantidad_presupuesto,m.presupuesto2016, m.presupuesto2017,m.presupuesto2018,m.presupuesto2019,m.presupuesto2020,m.pilar,m.meta,m.resultado,m.accion,m.id_accion_eta,m.descripcion_accion ,m.id_servicio,s.descripcion_servicio, m.id_clasificador,c.descripcion_clasificador,m.descripcion_accion_eta 
from sp_pt_matrices m,sp_pt_departamentos d ,sp_pt_provincias p,sp_pt_municipios mu,sp_pt_eta e,sp_pt_servicios s, sp_pt_clasificadores c
where m.id_departamento=d.id_departamento and p.id_provincia=m.id_provincia 
and m.id_departamento=p.id_departamento and m.id_municipio=mu.id_municipio and m.id_departamento=mu.id_departamento
and mu.id_provincia=p.id_provincia  and e.id_eta=m.tipo_eta and  m.id_servicio=s.id_servicio and m.id_clasificador=c.id_clasificador
and m.estado<>'ELIMINADO' and tipo_eta=$tipoeta and id_programa=$prog order by m.id_correlativo desc " );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se cargo nueva matriz',
      'nmat'=>$nmat
    ]);
  }
  
  public function listaNuevSeguimiento($tipoeta,$prog)
  {
    $nmatseg = \DB::select("select m.id_eta,m.id_tipo_eta,e.descripcion_eta,m.id_correlativo,d.id_departamento,
d.descripcion_departamento,p.id_provincia,p.descripcion_provincia,mu.id_municipio,
mu.descripcion_municipio,m.id_programa,m.descripcion_programa,
m.id_accion_eta,m.indicador_procesos,m.presupuestoejecutadogestion, 
m.pilar,m.meta,m.resultado,m.accion,m.id_accion_eta,m.descripcion_pdes ,m.id_servicio,
s.descripcion_servicio, m.id_clasificador,c.descripcion_clasificador,m.descripcion_accion_eta 
from sp_pt_seguimientos m,sp_pt_departamentos d ,sp_pt_provincias p,sp_pt_municipios mu,sp_pt_eta e,sp_pt_servicios s, sp_pt_clasificadores c
where m.id_departamento=d.id_departamento and p.id_provincia=m.id_provincia 
and m.id_departamento=p.id_departamento and m.id_municipio=mu.id_municipio and m.id_departamento=mu.id_departamento
and mu.id_provincia=p.id_provincia and e.id_eta=m.id_tipo_eta and  m.id_servicio=s.id_servicio and m.id_clasificador=c.id_clasificador
and m.estado<>'ELIMINADO' and  id_tipo_eta=$tipoeta and id_programa=$prog order by m.id_correlativo desc" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se cargo nueva matriz',
      'nmatseg'=>$nmatseg
    ]);
  }
   public function listaprograma($eta)
  {
    $programas = \DB::select("select id_programa,descripcion_programa from sp_pt_matrices where tipo_eta=$eta group by id_programa,descripcion_programa" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se cargo programas',
      'programas'=>$programas
    ]);
  }
  /*fin lista por filtros*/
  public function listaEtas()
  {
    $etas = \DB::select("select m.id_tarea_eta,t.descripcion_eta 
from sp_pt_matrices m,sp_pt_eta t 
where m.id_tarea_eta=t.id_eta
group by  id_tarea_eta,descripcion_eta  order by id_tarea_eta" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se cargo etas',
      'etas'=>$etas
    ]);
  }
  public function listaTiposEtas($eta)
  {
    $etas = \DB::select("SELECT * from sp_pt_eta where dependiente=$eta order by id_correlativo" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se cargo etas',
      'etas'=>$etas
    ]);
  }
  
  public function listaDepartamentos()
  {
  	$departamentos = \DB::select('select d.id_departamento,d.descripcion_departamento from sp_pt_departamentos d,sp_pt_matrices m where d.id_departamento=m.id_departamento group by d.id_departamento,d.descripcion_departamento order by id_departamento');
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se cargo departamentos',
  		'departamentos'=>$departamentos
  	]);
  }

  public function listaProvinciasMatrices($iddepto)
  {
  	$provs = \DB::select("select p.id_provincia,p.descripcion_provincia 
from sp_pt_provincias p,sp_pt_matrices m 
where p.id_provincia=m.id_provincia and m.id_departamento=p.id_Departamento and m.id_departamento = {$iddepto}
group by p.id_provincia,p.descripcion_provincia  order by id_provincia " );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se cargo provincias',
  		'provincias'=>$provs
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

  public function listaMatrices() 
  {
    $matrices = \DB::select("select m.id_tarea_eta,m.tipo_eta,e.descripcion_eta,m.id_correlativo,d.id_departamento,d.descripcion_departamento,p.id_provincia,p.descripcion_provincia,mu.id_municipio, mu.descripcion_municipio,m.id_programa,m.descripcion_programa,m.accion_eta,m.linea_base,m.proceso_indicador,m.unidad_indicador,m.cantidad_indicador,indicador2016,indicador2017,indicador2018,indicador2019,indicador2020,m.cantidad_presupuesto,m.presupuesto2016, m.presupuesto2017,m.presupuesto2018,m.presupuesto2019,m.presupuesto2020,m.pilar,m.meta,m.resultado,m.accion,m.id_accion_eta,m.descripcion_accion ,m.id_servicio,s.descripcion_servicio, m.id_clasificador,c.descripcion_clasificador,m.descripcion_accion_eta

from sp_pt_departamentos d,sp_pt_provincias p,sp_pt_municipios mu ,sp_pt_matrices m,sp_pt_eta e,sp_pt_servicios s, sp_pt_clasificadores c
where d.id_departamento=p.id_departamento and d.id_departamento=mu.id_departamento and d.id_departamento=m.id_departamento 
and p.id_departamento=mu.id_departamento and p.id_departamento=m.id_departamento and m.id_departamento=mu.id_departamento
and p.id_provincia=mu.id_provincia and p.id_provincia=m.id_provincia and m.id_provincia=mu.id_provincia
and mu.id_municipio=m.id_municipio and m.estado<>'ELIMINADO' and d.id_departamento=e.id_departamento and p.id_provincia=e.id_provincia
and mu.id_municipio=e.id_municipio and m.id_servicio=s.id_servicio and m.id_clasificador=c.id_clasificador
order by m.id_correlativo desc" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo la matriz',
      'matrices'=>$matrices
    ]);
  }

  public function listaGastos1Fil($ideta)
  {
    $gastos = \DB::select("select id_programa,descripcion_programa from sp_pt_matrices where id_tarea_eta=$ideta group by id_programa,descripcion_programa order by id_programa" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo Gastos',
      'gastos'=>$gastos
    ]);
  }
   public function listaGastos2Fil($ideta)
  {
    $programas = \DB::select("select id_programa,descripcion_programa from sp_pt_matrices where id_tarea_eta=$ideta group by id_programa,descripcion_programa order by id_programa" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo programas',
      'programas'=>$programas
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
