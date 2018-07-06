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
}
