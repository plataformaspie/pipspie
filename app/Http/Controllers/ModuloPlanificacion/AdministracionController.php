<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ModuloPlanificacion\Entidades;
use App\Models\ModuloPlanificacion\TiposEntidades;
use App\Models\ModuloPlanificacion\EntidadOrganigrama;

class AdministracionController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(Request $request)
  {
    // $this->middleware('auth');
    $this->middleware(function ($request, $next) {
    $this->user= \Auth::user();
    $rol = (int) $this->user->id_rol;
    $sql = \DB::select("SELECT  m.* FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol = ".$rol." ORDER BY orden ASC");
    $this->modulos = array();
    foreach ($sql as $mn) {
        array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html));
    }

    if($request->id_entidad){
    $sql = \DB::select("SELECT m.*
                        FROM menus m
                        INNER JOIN roles_menu rm ON m.id = rm.id_menu
                        WHERE rm.id_rol = ".$rol."
                        AND id_modulo = 7
                        AND activo = true
                        ORDER BY m.tipo_menu,m.orden ASC");
    }
    else{
      $sql = \DB::select("SELECT m.*
                          FROM menus m
                          INNER JOIN roles_menu rm ON m.id = rm.id_menu
                          WHERE rm.id_rol = ".$rol."
                          AND id_modulo = 7
                          AND m.tipo_menu = 'Estructuración'
                          AND activo = true
                          ORDER BY m.tipo_menu,m.orden ASC");
    }
    $this->menus = array();

    foreach ($sql as $mn) {
        $submenu = \DB::select("SELECT *
                                FROM sub_menus
                                WHERE id_menu = ".$mn->id."
                                AND activo = true
                                ORDER BY orden ASC");
        array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'tipo_menu'=>$mn->tipo_menu,'submenus' => $submenu));
    }



    \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);



    return $next($request);

    });

  }

  public function showEstructura(Request $request)
  {
      if($request->id_entidad)
      {
        $idEntidad = $request->id_entidad;
      }
      else
      {
        $this->user = \Auth::user();
        $idEntidad = $this->user->id_institucion;
      }
    /*$tiposEntidades = \DB::select("SELECT te.id,e.clasificacion,te.orden
                                   FROM sp_entidades e
                                   INNER JOIN sp_tipos_entidades te ON e.clasificacion = te.descripcion
                                   WHERE e.id_padre = 15
                                   GROUP BY te.id,e.clasificacion,te.orden
                                   ORDER BY te.orden ASC");*/
      $estructura = Entidades::where('institucion', $idEntidad)
                   ->join('sp_tipos_entidades as te', 'sp_entidades.id_tipo', '=', 'te.id')
                   ->whereIn('te.id', [1, 7, 8, 9, 10, 11])
                   ->where('sp_entidades.activo',true)
                   ->orderBy('te.orden')
                   ->select('sp_entidades.*','te.orden')
                   ->get();

      $tipo = TiposEntidades::whereIn('id', [1, 7, 8, 9, 10, 11, 12])
              ->get();

      $estructuraOfi = Entidades::where('id_entidad', $idEntidad)
                   ->join('sp_tipos_entidades as te', 'sp_entidades.id_tipo', '=', 'te.id')
                   ->where('sp_entidades.activo',true)
                   ->orderBy('te.orden')
                   ->select('sp_entidades.*','te.orden')
                   ->get();


      $tipoOfi = TiposEntidades::whereIn('id', [2, 3, 4, 5, 6, 14, 15, 12])
              ->get();
      return view('ModuloPlanificacion.show-estructura',['estructura' => $estructura,'tipo' => $tipo,'idEntidad' => $idEntidad,'estructuraOfi' => $estructuraOfi,'tipoOfi' => $tipoOfi]);
  }

  public function setEstructuraEntidad(Request $request)
  {
    if($request->id_entidad)
    {
      $idEntidad = $request->id_entidad;
    }
    else
    {
      $this->user = \Auth::user();
      $idEntidad = $this->user->id_institucion;
    }
    //$estructura = Entidades::where('id_padre', 15)->where("clasificacion",$request->tipo)->get();
    $estructura = Entidades::where('institucion', $idEntidad)
                  ->join('sp_tipos_entidades as te', 'sp_entidades.id_tipo', '=', 'te.id')
                  ->whereIn('te.id', [1, 7, 8, 9, 10, 11])
                  ->where('sp_entidades.activo',true)
                  ->orderBy('te.orden')
                  ->select('sp_entidades.*','te.orden','te.descripcion as tipo')
                  ->get();
    return \Response::json($estructura);
  }

  public function saveEntidadNew(Request $request)
  {
    $this->user = \Auth::user();
    if($request->id_entidad)
    {
      $idEntidad = $request->id_entidad;
    }
    else
    {
      $idEntidad = $this->user->id_institucion;
    }
    $periodo = array(2011,2012,2013,2014,2015);

    try{
          $entidad = new Entidades();
          $entidad->nombre = $request->nombre;
          $entidad->sigla = $request->sigla;
          $entidad->codigo_mef = $request->codigo_mef;
          $entidad->id_tipo = $request->tipo;
          $entidad->activo = true;
          $entidad->nivel = 1;
          $entidad->institucion = $idEntidad;

          if($request->tuicion == -1)
            $entidad->id_tuicion = null;
          else
            $entidad->id_tuicion = $request->tuicion;

          $entidad->id_user = $this->user->id;
          $entidad->save();


          $entidadID = Entidades::find($entidad->id);
          $entidadID->id_entidad = $entidad->id;
          $entidadID->save();

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

  public function saveEntidadEdit(Request $request)
  {
    $this->user = \Auth::user();
    if($request->id_entidad)
    {
      $idEntidad = $request->id_entidad;
    }
    else
    {
      $idEntidad = $this->user->id_institucion;
    }
    $periodo = array(2011,2012,2013,2014,2015);

    try{
          $entidad = Entidades::find($request->mod_id);
          $entidad->nombre = $request->mod_nombre;
          $entidad->sigla = $request->mod_sigla;
          $entidad->codigo_mef = $request->mod_codigo_mef;
          $entidad->id_tipo = $request->mod_tipo;
          $entidad->activo = true;
          $entidad->nivel = 1;

          if($request->mod_tuicion == -1)
            $entidad->id_tuicion = null;
          else
            $entidad->id_tuicion = $request->mod_tuicion;

          $entidad->id_user_updated = $this->user->id;
          $entidad->save();

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

  public function dataSetEntidad(Request $request)
  {
    $entidad = Entidades::find($request->id);
    return \Response::json($entidad);
  }

  public function deleteEntidad(Request $request)
  {
    $periodo = array(2011,2012,2013,2014,2015);

    try{
          $entidad = Entidades::find($request->id);
          $entidad->activo = false;
          $entidad->save();

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

  public function saveOficinaNew(Request $request)
  {
    $this->user = \Auth::user();
    if($request->id_entidad)
    {
      $idEntidad = $request->id_entidad;
    }
    else
    {
      $idEntidad = $this->user->id_institucion;
    }
    $periodo = array(2011,2012,2013,2014,2015);

    try{
          $entidad = new Entidades();
          $entidad->nombre = $request->nombre_ofi;
          $entidad->sigla = $request->sigla_ofi;
          $entidad->id_tipo = $request->tipo_ofi;
          $entidad->activo = true;
          $entidad->nivel = 2;
          $entidad->id_entidad = $request->id_selected;
          $entidad->institucion = $idEntidad;

          if($request->tuicion_ofi == -1)
            $entidad->id_tuicion = null;
          else
            $entidad->id_tuicion = $request->tuicion_ofi;

          $entidad->id_user = $this->user->id;
          $entidad->save();

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

  public function saveOficinaEdit(Request $request)
  {
    $this->user = \Auth::user();
    if($request->id_entidad)
    {
      $idEntidad = $request->id_entidad;
    }
    else
    {
      $idEntidad = $this->user->id_institucion;
    }
    $periodo = array(2011,2012,2013,2014,2015);

    try{
          $entidad = Entidades::find($request->mod_id_ofi);
          $entidad->nombre = $request->mod_nombre_ofi;
          $entidad->sigla = $request->mod_sigla_ofi;
          $entidad->id_tipo = $request->mod_tipo_ofi;
          $entidad->activo = true;
          $entidad->nivel = 1;
          $entidad->id_entidad = $request->id_selected;

          if($request->mod_tuicion_ofi == -1)
            $entidad->id_tuicion = null;
          else
            $entidad->id_tuicion = $request->mod_tuicion_ofi;

          $entidad->id_user_updated = $this->user->id;
          $entidad->save();

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

  public function deleteOficina(Request $request)
  {
    $periodo = array(2011,2012,2013,2014,2015);

    try{
          $entidad = Entidades::find($request->id);
          $entidad->activo = false;
          $entidad->save();

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

  public function setEntidadOrganigrama(Request $request)
  {
    $estructura = Entidades::where('id_entidad', $request->id)
                  ->join('sp_tipos_entidades as te', 'sp_entidades.id_tipo', '=', 'te.id')
                  ->whereIn('te.id', [2, 3, 4, 5, 6, 14, 15, 12])
                  ->where('sp_entidades.activo',true)
                  ->orderBy('te.orden')
                  ->select('sp_entidades.*','te.orden','te.descripcion as tipo')
                  ->get();
    return \Response::json($estructura);
  }

  public function setEstructuraOfi(Request $request)
  {
        $estructuraOfi = Entidades::where('id_entidad', $request->id_selected)
                     ->join('sp_tipos_entidades as te', 'sp_entidades.id_tipo', '=', 'te.id')
                     ->where('sp_entidades.activo',true)
                     ->orderBy('te.orden')
                     ->select('sp_entidades.*','te.orden')
                     ->get();

        $html = '<option value="-1"> Ninguno </option>';
        foreach ($estructuraOfi as $e) {
          $html .= '<option value="'.$e->id.'">'. $e->nombre .'</option>';
        }
        return \Response::json(array('set'=>$html));
   }


   public function showPlanesInstitucion(Request $request)
   {
       if($request->id_entidad)
       {
         $idEntidad = $request->id_entidad;
       }
       else
       {
         $this->user = \Auth::user();
         $idEntidad = $this->user->id_institucion;
       }

       return view('ModuloPlanificacion.show-planes-institucion',['idEntidad' => $idEntidad]);
   }

}
