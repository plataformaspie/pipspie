<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Controllers\Controller;
use App\Models\ModuloPlanificacion\Entidades;
use App\Models\ModuloPlanificacion\EntidadPlan;
use App\Models\ModuloPlanificacion\Planes;
use App\Models\ModuloPlanificacion\TiposEntidades;
use Illuminate\Http\Request;

class AdministracionController extends PlanificacionBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct(Request $request)
    // {
    //      // $middleware('auth');
    //     $this->middleware(function ($request, $next)
    //     {
    //       $user    = \Auth::user();
    //       $ModulosMenus = IndexController::GeneraMenus($user);

    //       \View::share($ModulosMenus);

    //       return $next($request);
    //     });
    // }

    public function showEstructura(Request $request)
    {

        if ($request->p)
        {
            //$idEntidad = $request->id_entidad;
            $planActivo = Planes::where('id', $request->p)->first();
            $idEntidad =$planActivo->id_entidad;
        }
        else
        {
            $this->user = \Auth::user();
            $idEntidad  = $this->user->id_institucion;
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
            ->where('sp_entidades.activo', true)
            ->orderBy('te.orden')
            ->select('sp_entidades.*', 'te.orden')
            ->get();

        $tipo = TiposEntidades::whereIn('id', [1, 7, 8, 9, 10, 11, 12])
            ->get();

        $estructuraOfi = Entidades::where('id_entidad', $idEntidad)
            ->join('sp_tipos_entidades as te', 'sp_entidades.id_tipo', '=', 'te.id')
            ->where('sp_entidades.activo', true)
            ->orderBy('te.orden')
            ->select('sp_entidades.*', 'te.orden')
            ->get();

        $tipoOfi = TiposEntidades::whereIn('id', [2, 3, 4, 5, 6, 14, 15, 12])
            ->get();
        return view('ModuloPlanificacion.show-estructura', ['estructura' => $estructura, 'tipo' => $tipo, 'idEntidad' => $idEntidad, 'estructuraOfi' => $estructuraOfi, 'tipoOfi' => $tipoOfi]);
    }

    public function setEstructuraEntidad(Request $request)
    {
        if ($request->p)
        {
            //$idEntidad = $request->id_entidad;
            $planActivo = Planes::where('id', $request->p)->first();
            $idEntidad =$planActivo->id_entidad;
        }
        else
        {
            $this->user = \Auth::user();
            $idEntidad  = $this->user->id_institucion;
        }
        //$estructura = Entidades::where('id_padre', 15)->where("clasificacion",$request->tipo)->get();
        $estructura = Entidades::where('institucion', $idEntidad)
            ->join('sp_tipos_entidades as te', 'sp_entidades.id_tipo', '=', 'te.id')
            ->whereIn('te.id', [1, 7, 8, 9, 10, 11])
            ->where('sp_entidades.activo', true)
            ->orderBy('te.orden')
            ->select('sp_entidades.*', 'te.orden', 'te.descripcion as tipo')
            ->get();
        return \Response::json($estructura);
    }

    public function saveEntidadNew(Request $request)
    {
        $this->user = \Auth::user();

        if ($request->p)
        {
            //$idEntidad = $request->id_entidad;
            $planActivo = Planes::where('id', $request->p)->first();
            $idEntidad =$planActivo->id_entidad;
        }
        else
        {
            $idEntidad = $this->user->id_institucion;
        }
        $periodo = array(2011, 2012, 2013, 2014, 2015);

        try {
            $entidad              = new Entidades();
            $entidad->nombre      = $request->nombre;
            $entidad->sigla       = $request->sigla;
            $entidad->codigo_mef  = $request->codigo_mef;
            $entidad->id_tipo     = $request->tipo;
            $entidad->activo      = true;
            $entidad->nivel       = 1;
            $entidad->institucion = $idEntidad;

            if ($request->tuicion == -1)
            {
                $entidad->id_tuicion = null;
            }
            else
            {
                $entidad->id_tuicion = $request->tuicion;
            }

            $entidad->id_user = $this->user->id;//capturando el id del usuario logueado

            //salvando organigrama
            $carpeta = "sp-files/organigramas/";
            $nombreDatabase = "";
            $mensajeFile ="";

            //$file=$request->organigrama;

            if($request->mod_logo){

            	$file=$request->mod_logo;

            	$nombre = $file->getClientOriginalName();
            	$tipo   = $file->getMimeType();
            	$extension = $file->getClientOriginalExtension();
            	$ruta_provisional = $file->getPathName();
            	$size = $file->getSize();
            	$nombreSystem = uniqid('ORG-');
            	$src = $carpeta.$nombreSystem.'.'.$extension;

            	if(move_uploaded_file($ruta_provisional,$src)){

            		$msgFile="Archivo subido correctamente";
            		$nombreDatabase = $nombreSystem.'.'.$extension;
            	}else{
            		$msgFile = "Error al subir el Archivo";
            	}
            	//guardando la ruta en el campo ruta_org
            	$entidad->ruta_org = $nombreSystem.'.'.$extension;

            }

            //fin salvando organigrama
            $entidad->save();

            $entidadID             = Entidades::find($entidad->id);
            $entidadID->id_entidad = $entidad->id;
            $entidadID->save();

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg'   => "Se guardo con exito.")
            );

        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg'   => $e->getMessage())
            );
        }
    }

    public function saveEntidadEdit(Request $request)
    {
    	//dd($request->mod_logo_Editar);

        $this->user = \Auth::user();
        if ($request->p)
        {
            //$idEntidad = $request->id_entidad;
            $planActivo = Planes::where('id', $request->p)->first();
            $idEntidad =$planActivo->id_entidad;
        }
        else
        {
            $idEntidad = $this->user->id_institucion;
        }
        $periodo = array(2011, 2012, 2013, 2014, 2015);

        try {
            $entidad             = Entidades::find($request->mod_id);
            $entidad->nombre     = $request->mod_nombre;
            $entidad->sigla      = $request->mod_sigla;
            $entidad->codigo_mef = $request->mod_codigo_mef;
            $entidad->id_tipo    = $request->mod_tipo;
            $entidad->activo     = true;
            $entidad->nivel      = 1;

            if ($request->mod_tuicion == -1)
            {
                $entidad->id_tuicion = null;
            }
            else
            {
                $entidad->id_tuicion = $request->mod_tuicion;
            }

            $entidad->id_user_updated = $this->user->id;

            //salvando organigrama
            $carpeta = "sp-files/organigramas/";

            $mensajeFile ="";
            $nombreDataBase = "";


            if($request->mod_logo_Editar){

            	$file = $request->mod_logo_Editar;

            	$nombre = $file->getClientOriginalName();
            	$tipo   = $file->getMimeType();
            	$extension = $file->getClientOriginalExtension();
            	$ruta_provisional = $file->getPathName();
            	$size = $file->getSize();
            	$nombreSystem = uniqid('ORG-');
            	$src = $carpeta.$nombreSystem.'.'.$extension;

            	if(move_uploaded_file($ruta_provisional,$src)){

            		$msgFile="Archivo subido correctamente";
            		$nombreDatabase = $nombreSystem.'.'.$extension;
            	}else{
            		$msgFile = "Error al subir el Archivo";
            	}
            	//guardando la ruta en el campo ruta_org
            	$entidad->ruta_org = $nombreSystem.'.'.$extension;

            }else{
            	$entidad->ruta_org = "";
            }

            //fin salvando organigrama


            $entidad->save();

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg'   => "Se guardo con exito.")
            );

        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg'   => $e->getMessage())
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
        $periodo = array(2011, 2012, 2013, 2014, 2015);

        try {
            $entidad         = Entidades::find($request->id);
            $entidad->activo = false;
            $entidad->save();

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg'   => "Se elimino con exito.")
            );

        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg'   => $e->getMessage())
            );
        }
    }

    public function saveOficinaNew(Request $request)
    {
        $this->user = \Auth::user();
        if ($request->id_entidad)
        {
            $idEntidad = $request->id_entidad;
        }
        else
        {
            $idEntidad = $this->user->id_institucion;
        }
        $periodo = array(2011, 2012, 2013, 2014, 2015);

        try {
            $entidad              = new Entidades();
            $entidad->nombre      = $request->nombre_ofi;
            $entidad->sigla       = $request->sigla_ofi;
            $entidad->id_tipo     = $request->tipo_ofi;
            $entidad->activo      = true;
            $entidad->nivel       = 2;
            $entidad->id_entidad  = $request->id_selected;
            $entidad->institucion = $idEntidad;

            if ($request->tuicion_ofi == -1)
            {
                $entidad->id_tuicion = null;
            }
            else
            {
                $entidad->id_tuicion = $request->tuicion_ofi;
            }

            $entidad->id_user = $this->user->id;
            $entidad->save();

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg'   => "Se guardo con exito.")
            );

        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg'   => $e->getMessage())
            );
        }
    }

    public function saveOficinaEdit(Request $request)
    {
        $this->user = \Auth::user();
        if ($request->id_entidad)
        {
            $idEntidad = $request->id_entidad;
        }
        else
        {
            $idEntidad = $this->user->id_institucion;
        }
        $periodo = array(2011, 2012, 2013, 2014, 2015);

        try {
            $entidad             = Entidades::find($request->mod_id_ofi);
            $entidad->nombre     = $request->mod_nombre_ofi;
            $entidad->sigla      = $request->mod_sigla_ofi;
            $entidad->id_tipo    = $request->mod_tipo_ofi;
            $entidad->activo     = true;
            $entidad->nivel      = 1;
            $entidad->id_entidad = $request->id_selected;

            if ($request->mod_tuicion_ofi == -1)
            {
                $entidad->id_tuicion = null;
            }
            else
            {
                $entidad->id_tuicion = $request->mod_tuicion_ofi;
            }

            $entidad->id_user_updated = $this->user->id;
            $entidad->save();

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg'   => "Se guardo con exito.")
            );

        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg'   => $e->getMessage())
            );
        }
    }

    public function deleteOficina(Request $request)
    {
        $periodo = array(2011, 2012, 2013, 2014, 2015);

        try {
            $entidad         = Entidades::find($request->id);
            $entidad->activo = false;
            $entidad->save();

            return \Response::json(array(
                'error' => false,
                'title' => "Success!",
                'msg'   => "Se elimino con exito.")
            );

        }
        catch (Exception $e)
        {
            return \Response::json(array(
                'error' => true,
                'title' => "Error!",
                'msg'   => $e->getMessage())
            );
        }
    }

    public function setEntidadOrganigrama(Request $request)
    {
        $estructura = Entidades::where('id_entidad', $request->id)
            ->join('sp_tipos_entidades as te', 'sp_entidades.id_tipo', '=', 'te.id')
            ->whereIn('te.id', [2, 3, 4, 5, 6, 14, 15, 12])
            ->where('sp_entidades.activo', true)
            ->orderBy('te.orden')
            ->select('sp_entidades.*', 'te.orden', 'te.descripcion as tipo')
            ->get();
        return \Response::json($estructura);
    }

    public function setEstructuraOfi(Request $request)
    {
        $estructuraOfi = Entidades::where('id_entidad', $request->id_selected)
            ->join('sp_tipos_entidades as te', 'sp_entidades.id_tipo', '=', 'te.id')
            ->where('sp_entidades.activo', true)
            ->orderBy('te.orden')
            ->select('sp_entidades.*', 'te.orden')
            ->get();

        $html = '<option value="-1"> Ninguno </option>';
        foreach ($estructuraOfi as $e)
        {
            $html .= '<option value="' . $e->id . '">' . $e->nombre . '</option>';
        }
        return \Response::json(array('set' => $html));
    }

    // public function showPlanesInstitucion(Request $request)
    // {
    //     if ($request->id_entidad)
    //     {
    //         $idEntidad = $request->id_entidad;
    //     }
    //     else
    //     {
    //         $this->user = \Auth::user();
    //         $idEntidad  = $this->user->id_institucion;
    //     }

    //     return view('ModuloPlanificacion.show-planes-institucion', ['idEntidad' => $idEntidad]);
    // }

    // public function setEntidadPlan(Request $request)
    // {
    //     if ($request->id_entidad)
    //     {
    //         $idEntidad = $request->id_entidad;
    //     }
    //     else
    //     {
    //         $this->user = \Auth::user();
    //         $idEntidad  = $this->user->id_institucion;
    //     }

    //     $entidadPlan = EntidadPlan::join('sp_entidades as e', 'sp_entidad_plan.id_entidad', '=', 'e.id')
    //         ->join('sp_tipos_planes as tp', 'sp_entidad_plan.id_tipo_plan', '=', 'tp.id')
    //         ->where('e.institucion', $idEntidad)
    //         ->where('sp_entidad_plan.activo', true)
    //         ->select('sp_entidad_plan.id', 'sp_entidad_plan.gestion_inicio', 'sp_entidad_plan.gestion_fin', 'e.nombre', 'e.sigla', 'tp.sigla as plan')
    //         ->get();
    //     return \Response::json($entidadPlan);
    // }

}
