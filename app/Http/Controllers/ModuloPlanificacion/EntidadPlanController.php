<?php

namespace App\Http\Controllers\ModuloPlanificacion;

use App\Http\Controllers\Controller;
use App\Models\ModuloPlanificacion\Entidades;
use App\Models\ModuloPlanificacion\EntidadPlan;
use App\Models\ModuloPlanificacion\TiposEntidades;
use Illuminate\Http\Request;

class EntidadPlanController extends Controller
{   
    public function __construct()
    {
         // $middleware('auth');
        $this->middleware(function ($request, $next)
        {
          $user    = \Auth::user();
          $ModulosMenus = IndexController::GeneraMenus($user);

          \View::share($ModulosMenus);

          return $next($request);
        });
    }

   

    public function showPlanesInstitucion(Request $request)
    {
        if ($request->id_entidad)
        {
            $idEntidad = $request->id_entidad;
        }
        else
        {
            $this->user = \Auth::user();
            $idEntidad  = $this->user->id_institucion;
        }

        return view('ModuloPlanificacion.show-planes-institucion', ['idEntidad' => $idEntidad]);
    }

    public function setEntidadPlan(Request $request)
    {
        if ($request->id_entidad)
        {
            $idEntidad = $request->id_entidad;
        }
        else
        {
            $this->user = \Auth::user();
            $idEntidad  = $this->user->id_institucion;
        }

        $entidadPlan = EntidadPlan::join('sp_entidades as e', 'sp_entidad_plan.id_entidad', '=', 'e.id')
            ->join('sp_tipos_planes as tp', 'sp_entidad_plan.id_tipo_plan', '=', 'tp.id')
            ->where('e.institucion', $idEntidad)
            ->where('sp_entidad_plan.activo', true)
            ->select('sp_entidad_plan.id', 'sp_entidad_plan.gestion_inicio', 'sp_entidad_plan.gestion_fin', 'e.nombre', 'e.sigla', 'tp.sigla as plan')
            ->get();
        return \Response::json($entidadPlan);
    }

}
