<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BasecontrollerController extends Controller
{
    // propiedades publicas
    public $user;

    public function __construct(Request $req)
    {
        // $middleware('auth');
        $this->middleware(function ($request, $next) use ($req)
        {
            $this->user = \Auth::user();
            //$this->complementaUser();
            $autorizado = $modulosMenus = $this->GeneraMenus($this->user);
            if(!$autorizado)
                return response()->view('PlanificacionTerritorial.error',['mensaje' => 'No tiene autorización para ingresar a este módulo']);

            \View::share($modulosMenus);

            return $next($request);
        });
    }

    // ================================================= Funciones privadas y protegidas=====================================================
    // ======================================================================================================================================


    private function GeneraMenus($user)
    {
        // Verifica los modulos del usuario y verifica si puede acceder al modulo que corresponde ejmp: de planificacion = 7
        $modulos = \DB::select("SELECT m.id, m.titulo, m.descripcion, m.url, m.icono, m.target, m.id_html
                                FROM roles_modulos um
                                INNER JOIN modulos m ON um.id_modulo = m.id
                                WHERE um.id_rol =  {$user->id_rol} ORDER BY orden ASC");

        $autorizado = count(array_where($modulos, function ($value){
                                    return $value->id == 13;
                            })) > 0;
        if (!$autorizado)
            return false;


        $menus = $this->menus($user);
        return ['modulos' => $modulos, 'menus' => $menus];
    }

    private function menus($user)
    {
      $sql = \DB::select("SELECT m.* FROM menus m
                          INNER JOIN roles_menu rm ON m.id = rm.id_menu
                          WHERE rm.id_rol = {$user->id_rol}
                          AND id_modulo = 13
                          AND activo = true
                          ORDER BY m.tipo_menu,m.orden ASC");
      $menus = array();
      foreach ($sql as $mn) {
          $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." AND activo = true ORDER BY orden ASC");
          array_push($menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'tipo_menu'=>$mn->tipo_menu,'class'=>$mn->class,'submenus' => $submenu));
      }
      return $menus;
    }

    public function format_numerica_db($numeric=0,$decimal){
        if($decimal == '.'){
          $formated = str_replace(',','',$numeric);
        }elseif($decimal == ','){
          $formated = str_replace('.','',$numeric);
          $formated = str_replace(',','.',$formated);
        }else{
          $formated = str_replace(',','',$numeric);
        }
      return $formated;
    }

    public function decimal_simbolo($numeric=0){

      $decimalSimbol = ',';
      for($i=strlen($numeric);$i>=0;$i--){
          if(substr($numeric,$i,1)=='.' OR substr($numeric,$i,1)==','){
              $decimalSimbol =  substr($numeric,$i,1);
              break;
          }
      }

      return $decimalSimbol;
    }

    public function totalesPlanificacion(){

      $user = \Auth::user();
      $periodo = Array();
      $periodoId = 6;
      $gestionInicial = 2016;
      $gestionFinal = 2020;
      for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
        $periodo[] = $i;
      }

      $totalesRecursos = \DB::select("
      SELECT fuente.nombre as gestion,
      (
        SELECT SUM(monto)
        FROM sp_eta_recursos_eta
        WHERE activo = true
        AND id_institucion = ".$user->id_institucion."
        AND gestion = fuente.codigo::int
      ) as total
      FROM(
        SELECT *
        from sp_parametros pa
        WHERE activo = TRUE
        AND categoria = 'gestiones'
        AND codigo BETWEEN '".$gestionInicial."' AND '".$gestionFinal."'
        ORDER BY codigo ASC
      ) as fuente");

      $totalPresupuesto=0;
      foreach ($totalesRecursos as  $item) {
        $totalPresupuesto = $totalPresupuesto + $item->total;
      }

      $totalesDeudas = \DB::select("
      SELECT fuente.nombre as gestion,
      (
        SELECT SUM(monto)
        FROM sp_eta_deudas_eta
        WHERE activo = true
        AND id_institucion = ".$user->id_institucion."
        AND gestion = fuente.codigo::int
      ) as total
      FROM(
        SELECT *
        from sp_parametros pa
        WHERE activo = TRUE
        AND categoria = 'gestiones'
        AND codigo BETWEEN '".$gestionInicial."' AND '".$gestionFinal."'
        ORDER BY codigo ASC
      ) as fuente");
      $totalDeuda=0;
      foreach ($totalesDeudas as  $item) {
        $totalDeuda = $totalDeuda + $item->total;
      }

      $totalGestionesRecursosAsignados = \DB::select("
      SELECT pr.gestion, SUM(pr.monto) as total
      FROM sp_eta_objetivos_eta o
      INNER JOIN sp_eta_etapas_plan ep ON o.id_etapas_plan = ep.id
      INNER JOIN sp_eta_articulacion_objetivo_indicador aoi ON o.id = aoi.id_objetivo_eta
      INNER JOIN sp_eta_programacion_recursos pr ON aoi.id = pr.id_articulacion_objetivo_indicador
      WHERE o.activo = true
      AND ep.id_institucion = ".$user->id_institucion."
      GROUP BY pr.gestion
      ORDER BY pr.gestion ASC");

      $totalRecursosAsignados=0;
      foreach ($totalGestionesRecursosAsignados as  $value) {
        $totalRecursosAsignados += $value->total;
      }


      $totalCategorias = \DB::select("SELECT SUM(monto) as total
      FROM sp_eta_objetivos_eta o
      INNER JOIN sp_eta_etapas_plan ep ON o.id_etapas_plan = ep.id
      INNER JOIN sp_eta_categorias_acciones_eta cat ON o.id_categoria_accion = cat.id
      INNER JOIN sp_eta_articulacion_objetivo_indicador aoi ON o.id = aoi.id_objetivo_eta
      INNER JOIN sp_eta_programacion_recursos pr ON aoi.id = pr.id_articulacion_objetivo_indicador
      WHERE o.activo = true
      AND ep.id_institucion = ".$user->id_institucion);

      return ['totalRecursos' => $totalPresupuesto,
              'totalDeudas' => $totalDeuda,
              'totalRecursosAsignados'=>$totalRecursosAsignados 
            ];


    }

    public function periodoActual(){
      $user = \Auth::user();
      $periodo = Array();
      $periodoId = 6;
      $gestionInicial = 2016;
      $gestionFinal = 2020;
      for($i=$gestionInicial; $i<=$gestionFinal; $i++) {
        $periodo[] = $i;
      }
      return ['periodoId'=> $periodoId, 'gestionInicial' => $gestionInicial, 'gestionFinal' => $gestionFinal, 'gestionesPeriodo' =>$periodo];

    }





}
