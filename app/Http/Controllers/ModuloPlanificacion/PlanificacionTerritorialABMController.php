<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanificacionTerritorialABMController extends PlanificacionBaseController
{

  public function showPlanificacionTerritorial()
  {
    return view('ModuloPlanificacion.show-planificacion-territorial-ABM');
  }
  public function listaMatricesEditar()
  {
    $matrices = \DB::select("select m.id_correlativo,d.id_departamento,d.descripcion_departamento,p.id_provincia,p.descripcion_provincia,mu.id_municipio, mu.descripcion_municipio,m.id_programa,m.descripcion_programa,m.accion_eta,m.linea_base,m.proceso_indicador,m.unidad_indicador,m.cantidad_indicador,indicador2016,indicador2017,indicador2018,indicador2019,indicador2020,m.cantidad_presupuesto,m.presupuesto2016, m.presupuesto2017,m.presupuesto2018,m.presupuesto2019,m.presupuesto2020,pilar,meta,resultado,accion,id_accion_eta,m.descripcion_accion ,m.id_tarea_eta,m.id_servicio, m.id_clasificador,m.descripcion_accion_eta

from sp_pt_departamentos d,sp_pt_provincias p,sp_pt_municipios mu ,sp_pt_matrices m
where d.id_departamento=p.id_departamento and d.id_departamento=mu.id_departamento and d.id_departamento=m.id_departamento 
and p.id_departamento=mu.id_departamento and p.id_departamento=m.id_departamento and m.id_departamento=mu.id_departamento
and p.id_provincia=mu.id_provincia and p.id_provincia=m.id_provincia and m.id_provincia=mu.id_provincia
and mu.id_municipio=m.id_municipio and m.estado<>'ELIMINADO' order by m.id_correlativo desc" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo la matriz',
      'matrices'=>$matrices
    ]);
  }
  public function listaEtasEditar()
  {
    $etas = \DB::select("SELECT * from sp_pt_eta" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se cargo etas',
      'etas'=>$etas
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
  public function listaMunicipiosEditar($iddepto,$idprov)
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
  public function listaTiposEditar()
  {
    $tipos = \DB::select("select id_clasificador,descripcion_clasificador from sp_pt_clasificadores" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo Gastos',
      'tipos'=>$tipos
    ]);
  }
   public function listaServiciosEditar()
  {
    $servicios = \DB::select("select id_servicio,descripcion_servicio from sp_pt_servicios" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo Gastos',
      'servicios'=>$servicios
    ]);
  }
  public function update(Request $req)
  {
    
    $id = $req->id_correlativo;
    $matriz = [];
    $matriz['id_correlativo'] = $req->id_correlativo;
    $matriz['id_tarea_eta'] = $req->id_tarea_eta;
    $matriz['id_departamento'] = $req->id_departamento;
    $matriz['id_provincia'] = $req->id_provincia;
    $matriz['id_municipio'] = $req->id_municipio;
    $matriz['id_programa'] = $req->id_programa;
    $matriz['id_clasificador'] = $req->id_clasificador;
    $matriz['id_servicio'] = $req->id_servicio;
    $matriz['descripcion_programa'] = $req->descripcion_programa;
    $matriz['id_accion_eta'] = $req->id_accion_eta;
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
    $matriz['usuario_modificador']=$this->user->id;
    $matriz['descripcion_accion_eta'] = $req->descripcion_accion_eta;
    
    $matriz['fecha_modificacion']=date("d/m/Y H:i:s");
    $matriz['estado'] = 'MODIFICADO';
    
    try {
      \DB::table('sp_pt_matrices')->where('id_correlativo', $id)->update($matriz);
    return response()->json([
      'msg' => 'Matriz actualizada']);
      
    } catch (Exception $e) {
      return response()->json([
      'msg' => 'Matriz No actualizada'.$e ]);
    }
  }
  public function delete(Request $req)
  {
    
    $id = $req->id_correlativo;
    $matriz = [];     
    $matriz['usuario_modificador']=$this->user->id;
    $matriz['fecha_modificacion']=date("d/m/Y H:i:s");
    $matriz['estado'] = 'ELIMINADO';
    
    try {
      \DB::table('sp_pt_matrices')->where('id_correlativo', $id)->update($matriz);
    return response()->json([
      'msg' => 'Matriz eliminada']);
      
    } catch (Exception $e) {
      return response()->json([
      'msg' => 'Matriz No eliminada'.$e ]);
    }
  }
  public function export() 
{
  $datedoc=date("d/m/Y H:i:s");
    //return Excel::download(new UserExport,'hol.xlsx');
}

  
  
}
