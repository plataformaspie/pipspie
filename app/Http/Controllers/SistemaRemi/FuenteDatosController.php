<?php

namespace App\Http\Controllers\SistemaRemi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SistemaRemi\TiposMedicion;
use App\Models\SistemaRemi\UnidadesMedidas;
use App\Models\SistemaRemi\Dimensiones;
use App\Models\SistemaRemi\FuenteDatos;
use App\Models\SistemaRemi\FuenteDatosResponsable;
use App\Models\SistemaRemi\FuenteTipos;
use App\Models\SistemaRemi\Frecuencia;



class FuenteDatosController extends Controller
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

  public function setFuenteDatos()
  {

    return view('SistemaRemi.set-fuente-datos');
  }

  public function adminFuenteDatos()
  {

    $tipos = TiposMedicion::get();
    $unidades = UnidadesMedidas::where('activo',true)->get();
    $dimensiones = Dimensiones::where('id_variable',4)->get();
    //$variables = Variables::get();
    $frecuencia = Frecuencia::get();
    $fuente_datos = FuenteDatos::get();
    $fuente_tipos = FuenteTipos::get();
    return view('SistemaRemi.admin-fuente-datos',compact('tipos','unidades','frecuencia','fuente_datos','fuente_tipos','dimensiones'));
  }

  public function apiSetListFuenteDatos(Request $request)
  {
      $dataFuente = FuenteDatos::join('remi_fuente_datos_responsable as fdr', 'remi_fuente_datos.id', '=', 'fdr.id_fuente')
                  ->orderBy('nombre','ASC')
                  ->select('remi_fuente_datos.id','remi_fuente_datos.codigo','remi_fuente_datos.nombre', 'remi_fuente_datos.acronimo','remi_fuente_datos.tipo','fdr.responsable_nivel_1')
                  ->get();
      /*foreach ($dataFuente as $value) {
        $data[$value->id] = $value->nombre;
      }*/
      return \Response::json(array(
          'error' => false,
          'title' => "Success!",
          'msg' => "Se guardo con exito.",
          'item' =>$dataFuente)
      );

  }





}
