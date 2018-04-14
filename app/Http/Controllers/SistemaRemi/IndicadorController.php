<?php

namespace App\Http\Controllers\SistemaRemi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SistemaRemi\Indicadores;
use App\Models\SistemaRemi\TiposMedicion;
use App\Models\SistemaRemi\UnidadesMedidas;
use App\Models\SistemaRemi\Dimensiones;
use App\Models\SistemaRemi\Variables;

class IndicadorController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    // $this->middleware('auth');
    $this->middleware(function ($request, $next) {
    $this->user= \Auth::user();
    $rol = (int) $this->user->id_rol;
    $sql = \DB::select("SELECT  m.* FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol = ".$rol." ORDER BY orden ASC");
    $this->modulos = array();
    foreach ($sql as $mn) {
        array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'target' => $mn->target,'id_html' => $mn->id_html,'sigla' => $mn->sigla));
    }


    $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 11 AND activo = true ORDER BY m.tipo_menu,m.orden ASC");
    $this->menus = array();
    foreach ($sql as $mn) {

        $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." AND activo = true ORDER BY orden ASC");
        array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'tipo_menu'=>$mn->tipo_menu,'submenus' => $submenu));
    }



    \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);



    return $next($request);

    });

  }
  public function setIndicadores(Request $request)
  {
    //$indicadores = Indicadores::paginate();
    $sw=0;
    $tipo = "";
    $unidad = "";

    if($request->has('buscar')){
        dd($request->buscar);
    }
    if($request->has('tipo')){
        $where[] = array("tipo","=",$request->tipo);
        $append[] = array("tipo",$request->tipo);
        $tipo = $request->tipo;
        $sw++;
    }
    if($request->has('unidad')){
        $where[] = array("unidad_medida","=",$request->unidad);
        $append[] = array("unidad",$request->unidad);
        $unidad = $request->unidad;
        $sw++;
    }

    if($sw>0){

        $indicadores = Indicadores::where($where)->paginate(5)->appends("tipo",$request->tipo)->appends("unidad",$request->unidad);

    }else{

      $indicadores = Indicadores::paginate(5);

    }
    // $indicadores = \DB::select("SELECT *
    //                             FROM remi_indicadores")->paginate(5);

    return view('SistemaRemi.set-indicadores',compact('indicadores','tipo','unidad'));
  }


  public function dataIndicador($id)
  {

    $indicador = Indicadores::find($id);

    // $indicadores = \DB::select("SELECT *
    //                             FROM remi_indicadores")->paginate(5);
    return view('SistemaRemi.data-indicador',compact('indicador'));
  }

  public function addIndicador()
  {
    $tipos = TiposMedicion::get();
    $unidades = UnidadesMedidas::where('activo',true)->get();
    $dimensiones = Dimensiones::get();
    $variables = Variables::get();
    return view('SistemaRemi.add-indicador',compact('tipos','unidades','variables'));
  }

}
