<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Plataforma\Instituciones;

class IndexController extends BasecontrollerController
{
  public function index()
  {
      return view('PlanificacionTerritorial.index');
  }

  public function datosUsuario(Request $request)
  {
      $user = \Auth::user();
      $institucion = Instituciones::find($user->id_institucion);
      return \Response::json([
        'user' => $user,
        'institucion' => $institucion
      ]);

  }

}
