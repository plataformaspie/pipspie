<?php

namespace App\Http\Controllers\SistemaRemi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
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

        //$submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." AND activo = true ORDER BY orden ASC");
    $submenu = \DB::select("SELECT s.* FROM sub_menus s INNER JOIN roles_sub_menus rs ON s.id = rs.id_sub_menu 
          WHERE rs.id_rol = ".$rol." AND s.id_menu = ".$mn->id." AND s.activo = true  ORDER BY orden ASC");        
        array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'tipo_menu'=>$mn->tipo_menu,'class'=>$mn->class,'submenus' => $submenu));
    }



    \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);



    return $next($request);

    });

  }
  public function index()
  {
    $pdes = array();
    for($i=1;$i<=12;$i++){
      $countPilar = \DB::select("SELECT count(i.id) as total
                            FROM pdes_vista_catalogo_pmr c
                            LEFT JOIN remi_indicador_pdes_resultado ir ON c.id_resultado = ir.id_resultado
                            LEFT JOIN remi_indicadores i ON ir.id_indicador = i.id AND i.activo = true
                            WHERE cod_p = ".$i);
      $countPilar =$countPilar[0];
      $pdes[$i]=$countPilar->total;
    }


    return view('SistemaRemi.index',compact('pdes'));
  }
}
