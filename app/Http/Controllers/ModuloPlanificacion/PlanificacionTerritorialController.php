<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanificacionTerritorialController extends PlanificacionBaseController
{

  public function showPlanificacionTerritorial()
  {
    return view('ModuloPlanificacion.show-planificacion-territorial');
  }
  public function listaEtas()
  {
  	$etas = \DB::select("SELECT * from sp_pt_eta" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se cargo etas',
  		'etas'=>$etas
  	]);
  }
  public function listaDepartamentos()
  {
  	$departamentos = \DB::select('SELECT * from sp_pt_departamentos');
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se cargo departamentos',
  		'departamentos'=>$departamentos
  	]);
  }

  public function listaProvincias($iddepto)
  {
  	$provs = \DB::select("SELECT * from sp_pt_provincias WHERE id_departamento = {$iddepto}" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se cargo provincias',
  		'provincias'=>$provs
  	]);
  }
  public function listaMunicipios($iddepto,$idprov)
  {
  	$mun = \DB::select("SELECT * from sp_pt_municipios WHERE id_departamento = {$iddepto} and id_provincia = {$idprov}" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se cargo municipios',
  		'municipios'=>$mun
  	]);
  }
   public function listaGastos1()
  {
  	$gas = \DB::select("select id_programa,descripcion_gasto from sp_pt_gad where actividad='0'" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se Cargo Gastos',
  		'gastos'=>$gas
  	]);
  }
  public function listaGastos2()
  {
  	$gas = \DB::select("select distinct(descripcion_gasto),codigo from sp_pt_gam  order by codigo asc" );
  	return response()->json([
  		'status'=>'ok',
  		'mensaje'=>'Se Cargo Gastos',
  		'gastos'=>$gas
  	]);
  }
  public function listaAcciones($idgasto)
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
  	$tipos = \DB::select("select id_clasificador,descripcion_clasificador from sp_pt_clasificadores" );
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
  	$servicios = \DB::select("select id_servicio,descripcion_servicio from sp_pt_servicios" );
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
    $matriz['descripcion_accion_eta'] = $req->descripcion_accion_eta;    
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



  }
/*
class StudInsertController extends Controller {
     
   public function insert(Request $request){
      $name = $request->input('stud_name');
      DB::insert('insert into student (name) values(?)',[$name]);
      echo "Record inserted successfully.<br/>";
      echo '<a href = "/insert">Click Here</a> to go back.';
   }
}*/

    
  
}
