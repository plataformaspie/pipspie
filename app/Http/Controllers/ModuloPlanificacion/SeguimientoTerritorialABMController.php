<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeguimientoTerritorialABMController extends PlanificacionBaseController
{

  public function seguimiento(Request $req)
  {
    
    return view('ModuloPlanificacion.show-seguimiento-territorial');
  }

  /*public function listaMatricesSeguimiento()
  {
    
   
$matrices = \DB::select("select m.id_correlativo,m.id_eta,m.id_tipo_eta,d.id_departamento,d.descripcion_departamento,p.id_provincia,
p.descripcion_provincia,mu.id_municipio, mu.descripcion_municipio,m.id_programa,m.descripcion_programa,
m.cantidad_presupuesto,m.presupuesto2016, m.presupuesto2017,m.presupuesto2018,m.presupuesto2019,m.presupuesto2020
,m.pilar,m.meta,m.resultado,m.accion,id_accion_eta,m.descripcion_accion_eta ,m.id_servicio,s.descripcion_servicio
, m.id_clasificador,descripcion_clasificador,m.descripcion_accion_eta_prog,m.descripcion_pdes,m.indicador_procesos
,m.competencia,m.nce,m.gad,m.gam,M.estado

from sp_pt_departamentos d,sp_pt_provincias p,sp_pt_municipios mu ,sp_pt_seguimientos m,sp_pt_clasificadores c,sp_pt_servicios s
where d.id_departamento=p.id_departamento and d.id_departamento=mu.id_departamento and d.id_departamento=m.id_departamento 
and p.id_departamento=mu.id_departamento and p.id_departamento=m.id_departamento and m.id_departamento=mu.id_departamento
and p.id_provincia=mu.id_provincia and p.id_provincia=m.id_provincia and m.id_provincia=mu.id_provincia
and mu.id_municipio=m.id_municipio  and m.estado<>'ELIMINADO'and c.id_clasificador=m.id_clasificador and m.id_servicio=s.id_servicio
order by m.id_correlativo desc " );

    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo la matriz',
      'matrices'=>$matrices
    ]);
  }*/
  public function listaMatricesSeguimiento()
  {
    
   
$matrices = \DB::select("select m.id_correlativo,m.id_eta,e.descripcion_eta,m.id_tipo_eta,d.id_departamento,d.descripcion_departamento,p.id_provincia,
p.descripcion_provincia,mu.id_municipio, mu.descripcion_municipio,m.id_programa,m.descripcion_programa,
m.gestion,m.presupuestoejecutadogestion, m.total_presupuestogestion
,m.pilar,m.meta,m.resultado,m.accion,id_accion_eta,m.descripcion_accion_eta ,m.id_servicio,s.descripcion_servicio
, m.id_clasificador,descripcion_clasificador,m.descripcion_accion_eta_prog,m.descripcion_pdes,m.indicador_procesos
,m.competencia,m.nce,m.gad,m.gam,M.estado

from sp_pt_departamentos d,sp_pt_provincias p,sp_pt_municipios mu ,sp_pt_seguimientos m,sp_pt_clasificadores c,sp_pt_servicios s,
sp_pt_eta e

where d.id_departamento=p.id_departamento and d.id_departamento=mu.id_departamento and d.id_departamento=m.id_departamento 
and p.id_departamento=mu.id_departamento and p.id_departamento=m.id_departamento and m.id_departamento=mu.id_departamento
and p.id_provincia=mu.id_provincia and p.id_provincia=m.id_provincia and m.id_provincia=mu.id_provincia
and mu.id_municipio=m.id_municipio  and m.estado<>'ELIMINADO'and c.id_clasificador=m.id_clasificador and m.id_servicio=s.id_servicio
and m.id_tipo_eta=e.id_eta 
order by m.id_correlativo desc " );

    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo la matriz',
      'matrices'=>$matrices
    ]);
  }
  public function listaEtasEditar()
  {
    $etas = \DB::select("SELECT * from sp_pt_eta where dependiente=0 order by id_eta" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se cargo etas',
      'etas'=>$etas
    ]);
  }
   public function TiposEtas($ideta)
  {
    $etas = \DB::select("SELECT * from sp_pt_eta where id_eta=$ideta order by id_correlativo" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se cargo etas',
      'etas'=>$etas
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
  public function listaPMRAs($idpilar,$idmeta,$idresultado,$idaccion)
  {
    $acciones = \DB::select("select id_correlativo,descripcion_directriz from sp_pt_directrices where id_pilar={$idpilar} and id_meta={$idmeta} and id_resultado={$idresultado} and id_accion={$idaccion}" );
    return response()->json([
      'status'=>'ok',
      'mensaje'=>'Se Cargo Gastos',
      'acciones'=>$acciones
    ]);
  }
  public function listaTiposEtasEditar($eta)
  {
    $etas = \DB::select("SELECT * from sp_pt_eta where dependiente=$eta order by id_correlativo" );
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
 public function insertar(Request $req)
  {
    $matriz = [];
    $matriz['id_eta'] = $req->id_eta;
    $matriz['id_tipo_eta'] = $req->id_tipo_eta;
    $matriz['id_departamento'] = $req->id_departamento;
    $matriz['id_provincia'] = $req->id_provincia;
    $matriz['id_municipio'] = $req->id_municipio;
    $matriz['pilar'] = $req->pilar;
    $matriz['meta'] = $req->meta;
    $matriz['resultado'] = $req->resultado;
    $matriz['accion'] = $req->accion;
    $matriz['descripcion_pdes'] = $req->descripcion_pdes;
    $matriz['id_programa'] = $req->id_programa;
    $matriz['descripcion_programa'] = $req->descripcion_programa;
    $matriz['id_accion_eta'] = $req->id_accion_eta;
    $matriz['descripcion_accion_eta'] = $req->descripcion_accion_eta;    
    $matriz['indicador_procesos'] = $req->indicador_procesos;
    $matriz['descripcion_accion_eta_prog'] = $req->descripcion_accion_eta_prog;    
    $matriz['gestion'] = $req->gestion;
    $matriz['presupuestoejecutadogestion'] = $req->presupuestoejecutadogestion;
    $matriz['total_presupuestogestion'] = $req->total_presupuestogestion;
    
    $matriz['id_servicio'] = $req->id_servicio;
    $matriz['usuario_creacion']=$this->user->id;
    $matriz['fecha_creacion']=date("d/m/Y H:i:s");
    $matriz['estado'] = 'CREADO';    
    
    try {
      \DB::table('sp_pt_seguimientos')->insert($matriz);
    return response()->json([
      'msg' => 'Matriz insertada']);
      
    } catch (Exception $e) {
      return response()->json([
      'msg' => 'Matriz No insertada'.$e ]);
    }



  }

  public function update(Request $req)
  {
    
    $id = $req->id_correlativo;
    $matriz = [];
    $matriz['id_correlativo'] = $req->id_correlativo;
    $matriz['id_eta'] = $req->id_eta;
    $matriz['id_tipo_eta'] = $req->id_tipo_eta;
    $matriz['id_departamento'] = $req->id_departamento;
    $matriz['id_provincia'] = $req->id_provincia;
    $matriz['id_municipio'] = $req->id_municipio;
    $matriz['pilar'] = $req->pilar;
    $matriz['meta'] = $req->meta;
    $matriz['resultado'] = $req->resultado;
    $matriz['accion'] = $req->accion;
    $matriz['descripcion_pdes'] = $req->descripcion_pdes;
    $matriz['id_programa'] = $req->id_programa;
    $matriz['descripcion_programa'] = $req->descripcion_programa;
    $matriz['id_accion_eta'] = $req->id_accion_eta;
    $matriz['descripcion_accion_eta'] = $req->descripcion_accion_eta;    
    $matriz['indicador_procesos'] = $req->indicador_procesos;
    $matriz['descripcion_accion_eta_prog'] = $req->descripcion_accion_eta_prog;    
    $matriz['gestion'] = $req->gestion;
    $matriz['presupuestoejecutadogestion'] = $req->presupuestoejecutadogestion;
    $matriz['total_presupuestogestion'] = $req->total_presupuestogestion;
    $matriz['id_clasificador'] = $req->id_clasificador;
    $matriz['id_servicio'] = $req->id_servicio;  
    $matriz['usuario_modificacion']=$this->user->id;
    $matriz['fecha_modificacion']=date("d/m/Y H:i:s");
    $matriz['estado'] = 'MODIFICADO';
    
    try {
      \DB::table('sp_pt_seguimientos')->where('id_correlativo', $id)->update($matriz);
    return response()->json([
      'msg' => 'Seguimiento actualizada']);
      
    } catch (Exception $e) {
      return response()->json([
      'msg' => 'Seguimiento No actualizada'.$e ]);
    }
  }
  public function delete(Request $req)
  {
    
    $id = $req->id_correlativo;
    $matriz = [];     
    $matriz['usuario_modificacion']=$this->user->id;
    $matriz['fecha_modificacion']=date("d/m/Y H:i:s");
    $matriz['estado'] = 'ELIMINADO';
    
    try {
      \DB::table('sp_pt_seguimientos')->where('id_correlativo', $id)->update($matriz);
    return response()->json([
      'msg' => 'Seguimiento eliminada']);
      
    } catch (Exception $e) {
      return response()->json([
      'msg' => 'Seguimiento No eliminada'.$e ]);
    }
  }
   
  public function export() 
{
  $datedoc=date("d/m/Y H:i:s");
    //return Excel::download(new UserExport,'hol.xlsx');
}

  
  
}
