<?php

namespace App\Http\Controllers\ModuloPriorizacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
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
          array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html));
      }


      $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 5  AND activo = true ORDER BY m.orden ASC");
      $this->menus = array();
      foreach ($sql as $mn) {

          $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id."  AND activo = true ORDER BY orden ASC");
          array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'submenus' => $submenu));
      }



      \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);



      return $next($request);

      });

  }
  public function index()
  {
    return view('ModuloPriorizacion.dashboard');
  }

  public function cargarHijos(Request $request)
  {
    if($request->ajax()) {
        $titulo = "";
        $hijos = "";
        switch ($request->padre) {
          case 1:
            $titulo = '<div class="white-box analytics-info p-10 m-b-0">
                        <div class="message-center">

                                <div class="mail-contnet">
                                   <i class="fa fa-backward m-l-5 p-r-10 " style="font-size:2em;float:left;cursor: pointer;" title="Atras" onclick="back()"> </i>
                                  <h4> DATOS MACROECONOMICOS Y SOCIALES</h4>
                                </div>
                                <div class="user-img" style="width: 57px;margin-top:-45px;float:right;"> <img src="/img/priori-'.$request->padre.'.png" alt="user" class="img-circle" style="opacity: 0.6; filter: alpha(opacity=60);"> </div>

                        </div>
                      </div>';
            $hijos ='
              <div>
                  <b>INDICADORES MACROECONÓMICOS</b>
              </div>

              <div>
                <div class="panel panel-info">
                  <ul class="list-group">
                        <a href="#" class="list-group-item">SECTOR REAL</a>
                        <a href="#" class="list-group-item">SECTOR EXTERNO EXPORTACIONES ACUMULADAS</a>
                        <a href="#" class="list-group-item">SECTOR EXTERNO IMPORTACIONES ACUMULADAS</a>
                        <a href="#" class="list-group-item">COTIZACIONES INDICES DE PRECIOS</a>
                        <a href="#" class="list-group-item">RESERVAS INTERNACIONALES</a>
                        <a href="#" class="list-group-item">SECTOR FISCAL</a>
                        <a href="#" class="list-group-item">SECTOR MONETARIO Y PRECIOS</a>
                        <a href="#" class="list-group-item">SECTOR FINANCIERO</a>
                  </ul>
                </div>

              </div>
              <div>
                  <b>INDICADORES SOCIALES</b>
              </div>
              <div>
                <div class="panel panel-info">
                    <div class="panel-heading" style="background: #D9EDF7; padding: 0 5px;">
                        <h3 class="panel-title">
                            Empleo
                        </h3>
                    </div>
                    <ul class="list-group">
                        <a href="javascript:configurarDatosVE0003(\'v_ve0003_p_desempleo\')" class="list-group-item">Desempleo</a>
                        <a href="#" class="list-group-item">Empleo Informal</a>
                    </ul>
                    <div class="panel-heading" style="background: #D9EDF7; padding: 0 5px;">
                        <h3 class="panel-title">
                            Erradicar la Pobreza Extrema y el Hambre
                        </h3>
                    </div>
                    <ul class="list-group">
                        <a href="javascript:configurarDatosVE0001(\'v_ve0001_p_pobreza_extrema\')"  class="list-group-item">Pobreza Extrema</a>
                        <a href="javascript:configurarDatosVE0002(\'v_ve0002_p_pobreza_moderada\')" class="list-group-item">Pobreza Moderada</a>
                        <a href="#" class="list-group-item">Desigualdad</a>
                        <a href="#" class="list-group-item">Desnutrición Crónica</a>
                    </ul>
                    <div class="panel-heading" style="background: #D9EDF7; padding: 0 5px;">
                        <h3 class="panel-title">
                          Lograr la Enseñanza Primaria Universal
                        </h3>
                    </div>
                    <ul class="list-group">
                        <a href="#" class="list-group-item">Tasa de Término a 6to de Primaria</a>
                    </ul>
                    <div class="panel-heading" style="background: #D9EDF7; padding: 0 5px;">
                        <h3 class="panel-title">
                          Reducir la Mortalidad de los Niños Menores de 5 Años
                        </h3>
                    </div>
                    <ul class="list-group">
                        <a href="#" class="list-group-item">Mortalidad Infantil</a>
                    </ul>
                    <div class="panel-heading" style="background: #D9EDF7; padding: 0 5px;">
                        <h3 class="panel-title">
                            Mejorar la Salud Materna
                        </h3>
                    </div>
                    <ul class="list-group">
                        <a href="#" class="list-group-item">Cobertura de Parto Institucional</a>
                    </ul>
                    <div class="panel-heading" style="background: #D9EDF7; padding: 0 5px;">
                        <h3 class="panel-title">
                           Combatir el VIH/SIDA, el Paludismo y Otras Enfermedades
                        </h3>
                    </div>
                    <ul class="list-group">
                        <a href="#" class="list-group-item">Indice de Parasitosis Anual de la Malaria</a>
                    </ul>
                    <div class="panel-heading" style="background: #D9EDF7; padding: 0 5px;">
                        <h3 class="panel-title">
                           Garantizar la Sostenibilidad del Medio Ambiente
                        </h3>
                    </div>
                    <ul class="list-group">
                        <a href="#" class="list-group-item">Porcentaje de la Poblacion con Acceso Sostenible a Agua Potable</a>
                    </ul>
                </div>
              </div>';
          break;
          case 2:
          $titulo = '<div class="white-box analytics-info p-10 m-b-0">
                      <div class="message-center">

                              <div class="mail-contnet">
                                 <i class="fa fa-backward m-l-5 p-r-10 " style="font-size:2em;float:left;cursor: pointer;" title="Atras" onclick="back()"> </i>
                                 <h4> PROYECTOS ESPECIALES</h4>
                              </div>
                              <div class="user-img" style="width: 57px;margin-top:-45px;float:right;"> <img src="/img/priori-'.$request->padre.'.png" alt="user" class="img-circle"  style="opacity: 0.6; filter: alpha(opacity=60);"> </div>

                      </div>
                    </div>';
          $hijos ='<div>
                          <b>MI AGUA I, II y III</b>
                      </div>
                      <div>
                        <div class="panel panel-info">
                          <ul class="list-group">
                                <a href="#" class="list-group-item">NACIONAL</a>
                                <a href="#" class="list-group-item">LA PAZ</a>
                                <a href="#" class="list-group-item">CHUQUISACA</a>
                                <a href="#" class="list-group-item">PANDO</a>
                                <a href="#" class="list-group-item">BENI</a>
                                <a href="#" class="list-group-item">SANTA CRUZ</a>
                                <a href="#" class="list-group-item">COCHABAMABA</a>
                                <a href="#" class="list-group-item">ORURO</a>
                                <a href="#" class="list-group-item">POTOSÍ</a>
                                <a href="#" class="list-group-item">TARIJA</a>
                          </ul>
                        </div>

                      </div>
                      <div>
                          <b>MI SALUD</b>
                      </div>
                      <div>
                        <div class="panel panel-info">
                        <ul class="list-group">
                              <a href="#" class="list-group-item">NACIONAL</a>
                              <a href="#" class="list-group-item">LA PAZ</a>
                              <a href="#" class="list-group-item">CHUQUISACA</a>
                              <a href="#" class="list-group-item">PANDO</a>
                              <a href="#" class="list-group-item">BENI</a>
                              <a href="#" class="list-group-item">SANTA CRUZ</a>
                              <a href="#" class="list-group-item">COCHABAMABA</a>
                              <a href="#" class="list-group-item">ORURO</a>
                              <a href="#" class="list-group-item">POTOSÍ</a>
                              <a href="#" class="list-group-item">TARIJA</a>
                        </ul>
                        </div>
                      </div>
                      <div>
                      <b>MI RIEGO</b>
                      </div>
                      <div>
                        <div class="panel panel-info">
                          <ul class="list-group">
                                <a href="#" class="list-group-item">NACIONAL</a>
                                <a href="#" class="list-group-item">LA PAZ</a>
                                <a href="#" class="list-group-item">CHUQUISACA</a>
                                <a href="#" class="list-group-item">COCHABAMABA</a>
                                <a href="#" class="list-group-item">ORURO</a>
                                <a href="#" class="list-group-item">POTOSÍ</a>
                                <a href="#" class="list-group-item">TARIJA</a>
                          </ul>
                        </div>
                      </div>';
          break;
          case 3:
          $titulo = '<div class="white-box analytics-info p-10 m-b-0">
                      <div class="message-center">

                              <div class="mail-contnet">
                                 <i class="fa fa-backward m-l-5 p-r-10 " style="font-size:2em;float:left;cursor: pointer;" title="Atras" onclick="back()"> </i>
                                 <h4> INVERSION PUBLICA </h4>
                              </div>
                              <div class="user-img" style="width: 57px;margin-top:-45px;float:right;"> <img src="/img/priori-'.$request->padre.'.png" alt="user" class="img-circle"  style="opacity: 0.6; filter: alpha(opacity=60);"> </div>

                      </div>
                    </div>';
            $hijos ='<div>
                            <b>COMPORTAMIENTO DE LA INVERSIÓN (HISTÓRICA)</b>
                        </div>
                        <div>
                          <div class="panel panel-info">
                            <ul class="list-group">
                                  <a href="#" class="list-group-item">Ejecución de la inversión publica 2000 - 2014</a>
                                  <a href="#" class="list-group-item">Relación programación y ejecución de la inversión pública 2009 - 2013</a>
                                  <a href="#" class="list-group-item">Promedio de ejecución de la inversión pública 2000 - 2014</a>
                                  <a href="#" class="list-group-item">Ejecución de inversión de empresas estatales 2006 - 2014</a>
                                  <a href="#" class="list-group-item">Ejecución de la inversion estatal 2000 - 2014</a>
                            </ul>
                          </div>

                        </div>
                        <div>
                            <b>INVERSIÓN ESTATAL</b>
                        </div>
                        <div>
                          <div class="panel panel-info">
                          <ul class="list-group">
                                <a href="#" class="list-group-item">Programación y Ejecución de la Inversión Estatal</a>
                                <a href="#" class="list-group-item">Programación y Ejecución de la Inversión Publica por Sector</a>
                                <a href="#" class="list-group-item">Programación y Ejecución de la Inversión Publica por Tipo de Recurso</a>
                                <a href="#" class="list-group-item">Inversión Nacional</a>
                          </ul>
                          </div>
                        </div>
                        <div>
                        <b>INVERSIÓN DE GOBERNACIONES</b>
                        </div>
                        <div>
                          <div class="panel panel-info">
                            <ul class="list-group">
                                  <a href="#" class="list-group-item">Programación y Ejecución de la Inversión Pública de Gobernaciones</a>
                            </ul>
                          </div>
                        </div>
                        <div>
                        <b>INVERSIÓN DE MUNICIPIOS</b>
                        </div>
                        <div>
                          <div class="panel panel-info">
                            <ul class="list-group">
                                <a href="#" class="list-group-item">LA PAZ</a>
                                <a href="#" class="list-group-item">CHUQUISACA</a>
                                <a href="#" class="list-group-item">PANDO</a>
                                <a href="#" class="list-group-item">BENI</a>
                                <a href="#" class="list-group-item">SANTA CRUZ</a>
                                <a href="#" class="list-group-item">COCHABAMABA</a>
                                <a href="#" class="list-group-item">ORURO</a>
                                <a href="#" class="list-group-item">POTOSÍ</a>
                                <a href="#" class="list-group-item">TARIJA</a>
                            </ul>
                          </div>
                        </div>';
          break;
          case 4:
          $titulo = '<div class="white-box analytics-info p-10 m-b-0">
                      <div class="message-center">

                              <div class="mail-contnet">
                                 <i class="fa fa-backward m-l-5 p-r-10 " style="font-size:2em;float:left;cursor: pointer;" title="Atras" onclick="back()"> </i>
                                 <h4> RED VIAL FUNDAMENTAL </h4>
                              </div>
                              <div class="user-img" style="width: 57px;margin-top:-45px;float:right;"> <img src="/img/priori-'.$request->padre.'.png" alt="user" class="img-circle"  style="opacity: 0.6; filter: alpha(opacity=60);"> </div>

                      </div>
                    </div>';
            $hijos ='<div>
                        <b>RED VIAL FUNDAMENTAL POR DEPARTAMENTOS</b>
                    </div>
                        <div>
                          <div class="panel panel-info">
                            <ul class="list-group">
                                <a href="#" class="list-group-item">LA PAZ</a>
                                <a href="#" class="list-group-item">CHUQUISACA</a>
                                <a href="#" class="list-group-item">PANDO</a>
                                <a href="#" class="list-group-item">BENI</a>
                                <a href="#" class="list-group-item">SANTA CRUZ</a>
                                <a href="#" class="list-group-item">COCHABAMABA</a>
                                <a href="#" class="list-group-item">ORURO</a>
                                <a href="#" class="list-group-item">POTOSÍ</a>
                                <a href="#" class="list-group-item">TARIJA</a>
                            </ul>
                          </div>
                        </div>';
          break;
          case 5:
          $titulo = '<div class="white-box analytics-info p-10 m-b-0">
                      <div class="message-center">

                              <div class="mail-contnet">
                                 <i class="fa fa-backward m-l-5 p-r-10 " style="font-size:2em;float:left;cursor: pointer;" title="Atras" onclick="back()"> </i>
                                 <h4> INFORMES </h4>
                              </div>
                              <div class="user-img" style="width: 57px;margin-top:-45px;float:right;"> <img src="/img/priori-'.$request->padre.'.png" alt="user" class="img-circle"  style="opacity: 0.6; filter: alpha(opacity=60);"> </div>

                      </div>
                    </div>';
          $hijos ='<div>
                      <b>INFORMES PRESIDENCIALES</b>
                  </div>
                      <div>
                        <div class="panel panel-info">
                          <ul class="list-group">
                              <a href="#" class="list-group-item">INFORME PRESIDENCIAL A ENERO 2015</a>
                              <a href="#" class="list-group-item">DISCURSO PRESIDENCIAL (DEL 6 DE AGOSTO DE 2014)</a>
                          </ul>
                        </div>
                      </div>
                      ';
          break;
        }
        return \Response::json(array('titulo'=>$titulo,'hijos'=>$hijos));


    }
  }

  public function configurarFiltroVariable(Request $request)
  {
      if($request->ajax()) {

          switch ($request->cod) {
            case 'v_ve0001':
                  $html = '<div class="stats-row m-0">
                              <div class="stat-item containertipoimg">
                                  <img name="r_departamento" src="/img/icon-graf/r_departamento.png" alt="11" class="image">
                                  <div class="filt" onclick="filtDepto(this,\'v_ve0001_p_pobreza_extrema\',\'r_departamento\',\'POBRE EXTREMO\', \'POBRE EXTREMO x DEPARTAMENRO\');">
                                    <div class="text">Departamentos</div>
                                  </div>
                              </div>
                              <div class="stat-item containertipoimg">
                                  <img name="r_urbano_rural" src="/img/icon-graf/r_urbano_rural.png" alt="1" class="image">
                                  <div class="filt" onclick="filtUrbRu(this,\'v_ve0001_p_pobreza_extrema\',\'r_urbano_rural\',\'POBRE EXTREMO\', \'POBRE EXTREMO x URBANO-RURAL\');">
                                    <div class="text">Urbano_Rural</div>
                                  </div>
                              </div>
                              <div class="stat-item containertipoimg">
                                  <img name="genero" src="/img/icon-graf/genero.png" alt="3" class="image">
                                  <div class="filt" onclick="filtGenero(this,\'v_ve0001_p_pobreza_extrema\',\'genero\',\'POBRE EXTREMO\', \'POBRE EXTREMO x GÉNERO\');">
                                    <div class="text">Genero</div>
                                  </div>
                              </div>
                              <div class="stat-item containertipoimg">
                                  <img name="pobreza_extrema" src="/img/icon-graf/pex.png" alt="3" class="image">
                                  <div class="filt" onclick="filtPex(this,\'v_ve0001_p_pobreza_extrema\',\'pobreza_extrema\',\' \', \'POBREZA EXTREMA\');">
                                    <div class="text">POBREZA</div>
                                  </div>
                              </div>
                              <div class="stat-item" style="float: right;">
                                  <label><input type="radio" name="operador" onclick="operador(this);" value="null" checked>Número</label><br/>
                                  <label><input type="radio" name="operador" onclick="operador(this);" value="true" >Porcentaje</label>
                              </div>
                        </div>';
              break;
            case 'v_ve0002':
                  $html = '<div class="stats-row m-0">
                      <div class="stat-item containertipoimg">
                          <img name="r_departamento" src="/img/icon-graf/r_departamento.png" alt="11" class="image">
                          <div class="filt" onclick="filtDepto(this,\'v_ve0002_p_pobreza_moderada\',\'r_departamento\',\'POBRE\', \'POBREZA MODERADA x DEPARTAMENRO\');">
                            <div class="text">Departamentos</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="r_urbano_rural" src="/img/icon-graf/r_urbano_rural.png" alt="1" class="image">
                          <div class="filt" onclick="filtUrbRu(this,\'v_ve0002_p_pobreza_moderada\',\'r_urbano_rural\',\'POBRE\', \'POBREZA MODERADA x URBANO-RURAL\');">
                            <div class="text">Urbano_Rural</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="genero" src="/img/icon-graf/genero.png" alt="3" class="image">
                          <div class="filt" onclick="filtGenero(this,\'v_ve0002_p_pobreza_moderada\',\'genero\',\'POBRE\', \'POBREZA MODERADA x GÉNERO\');">
                            <div class="text">Genero</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="pobreza_moderada" src="/img/icon-graf/pmo.png" alt="3" class="image">
                          <div class="filt" onclick="filtPmo(this,\'v_ve0002_p_pobreza_moderada\',\'pobreza_moderada\',\' \', \'POBREZA MODERADA\');">
                            <div class="text">POBREZA</div>
                          </div>
                      </div>
                      <div class="stat-item" style="float: right;">
                        <label><input type="radio" name="operador" onclick="operador(this);" value="null" checked>Número</label><br/>
                        <label><input type="radio" name="operador" onclick="operador(this);" value="true" >Porcentaje</label>
                      </div>

                  </div>';
            break;
            case 'v_ve0003':
                  $html = '<div class="stats-row m-0">
                      <div class="stat-item containertipoimg">
                          <img name="r_departamento" src="/img/icon-graf/r_departamento.png" alt="11" class="image">
                          <div class="filt" onclick="filtDepto(this,\'v_ve0003_p_desempleo\',\'r_departamento\',\'DESOCUPADO\', \'DESEMPLEO x DEPARTAMENRO\');">
                            <div class="text">Departamentos</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="r_urbano_rural" src="/img/icon-graf/r_urbano_rural.png" alt="1" class="image">
                          <div class="filt" onclick="filtUrbRu(this,\'v_ve0003_p_desempleo\',\'r_urbano_rural\',\'DESOCUPADO\', \'DESEMPLEO x URBANO-RURAL\');">
                            <div class="text">Urbano_Rural</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="genero" src="/img/icon-graf/genero.png" alt="3" class="image">
                          <div class="filt" onclick="filtGenero(this,\'v_ve0003_p_desempleo\',\'genero\',\'DESOCUPADO\', \'DESEMPLEO x GÉNERO\');">
                            <div class="text">Genero</div>
                          </div>
                      </div>
                      <div class="stat-item containertipoimg">
                          <img name="po_pd" src="/img/icon-graf/desem.png" alt="3" class="image">
                          <div class="filt" onclick="filtDesem(this,\'v_ve0003_p_desempleo\',\'po_pd\',\' \', \'DESEMPLEO\');">
                            <div class="text">DESEMPLEO</div>
                          </div>
                      </div>
                      <div class="stat-item" style="float: right;">
                          <label><input type="radio" name="operador" onclick="operador(this);" value="null" checked>Número</label><br/>
                          <label><input type="radio" name="operador" onclick="operador(this);" value="true" >Porcentaje</label>
                      </div>

                  </div>';
            break;
            default:
              $html="";
            break;
          }
          return \Response::json($html);
      }
  }

  public function generarDatosVE0001(Request $request)
  {
      if($request->ajax()) {
          $datos = \DB::connection('dbentreparentesys')
                    ->select("SELECT t_ano as dimension, SUM(valor_cargado) as valor
                              FROM ".$request->vista."
                              WHERE pobreza_extrema = 'POBRE EXTREMO'
                              GROUP BY dimension
                              ORDER BY dimension ASC");
          return \Response::json($datos);
      }
  }

  public function generarDatosVE0002(Request $request)
  {
      if($request->ajax()) {
          $datos = \DB::connection('dbentreparentesys')
                    ->select("SELECT t_ano as dimension, SUM(valor_cargado) as valor
                              FROM ".$request->vista."
                              WHERE pobreza_moderada = 'POBRE'
                              GROUP BY dimension
                              ORDER BY dimension ASC");
          return \Response::json($datos);
      }
  }

  public function generarDatosVE0003(Request $request)
  {
      if($request->ajax()) {
          $datos = \DB::connection('dbentreparentesys')
                    ->select("SELECT t_ano as dimension, SUM(valor_cargado) as valor
                              FROM ".$request->vista."
                              WHERE po_pd = 'DESOCUPADO'
                              GROUP BY dimension
                              ORDER BY dimension ASC");
          return \Response::json($datos);
      }
  }











  public function  obtenerDatosFiltro(Request $req)
  {
      // return response()->json([
      //   'round2decimal' => round(12.123456,2),
      //   'round2ent' => round(12123459,2),
      //   'round2entdec' => round(128.999,2),
      // ]);
      $datos = [];
      $totales = [];
      $resultado = [];
      $tabla = '';
      $campoDefecto = '';
      $query = '';

      if(strpos($req->variableEstadistica, 'extrem') ) {
          $tabla = 'v_ve0001_p_pobreza_extrema';
          $campoDefecto = 'pobreza_extrema';
      }
      if(strpos($req->variableEstadistica, 'moderad')) {
          $tabla = 'v_ve0002_p_pobreza_moderada';
          $campoDefecto = 'pobreza_moderada';
      }
      if(strpos($req->variableEstadistica, 'desempleo')) {
          $tabla = 'v_ve0003_p_desempleo';
          $campoDefecto = 'po_pd';
      }


      /////////// En caso de que sea el mismo campo, se muestra este sin filtrar por nivel
      $condicion = "";
      if($req->campo <> $campoDefecto)
      {
          $condicion = " AND " . $campoDefecto . "  = '" . $req->nivel . "' ";
      }

      if($tabla <> '') {


          if($req->porcentaje)
          {
              $totales = collect(\DB::connection('dbentreparentesys')->select("
                SELECT t_ano AS gestion, SUM(valor_cargado)  AS total_ano
                FROM " . $tabla . "
                GROUP BY t_ano"))->groupBy('gestion');
          }

          // si es no es filtrado por ningun campo, pantalla principal devuelve Gestion y valo  (sin dimensiones)
          if($req->campo == '' || $req->campo == null)
          {
            $query = "SELECT t_ano as gestion,  SUM(valor_cargado) AS valor
                    FROM " .$tabla . "
                    WHERE 1 = 1 " . $condicion . "
                    GROUP BY t_ano
                    ORDER BY t_ano " ;
             $datos = collect(\DB::connection('dbentreparentesys')->select($query));
             foreach ($datos as $key => $anoObjetos) {
                  $elem = [];
                  $factorPorcentual = ($req->porcentaje) ?  100 / $totales[$anoObjetos->gestion][0]->total_ano : 1;
                  $anoObjetos->valor = round ($anoObjetos->valor * $factorPorcentual,2);
                  $resultado[] = $anoObjetos;
              }

             return response()->json($resultado);
          }

          $query = "SELECT " .$req->campo. " AS dimension, t_ano as gestion,  SUM(valor_cargado) AS valor
                    FROM " .$tabla . "
                    WHERE 1 = 1 " . $condicion . "
                    GROUP BY " .$req->campo . ", t_ano
                    ORDER BY t_ano, dimension " ;

          $datos = collect(\DB::connection('dbentreparentesys')->select($query))->groupBy('gestion');

          foreach ($datos as $key => $anoObjetos) {
              $elem = [];
              $factorPorcentual = ($req->porcentaje) ?  100 / $totales[$key][0]->total_ano : 1;
              // $factorPorcentual = 1;
              foreach ($anoObjetos as $objeto) {
                  $dimension = ($objeto->dimension == null)? 'otros' : $objeto->dimension;
                  $elem[$dimension] = round($objeto->valor * $factorPorcentual,2) ;
                  $elem['gestion'] = $objeto->gestion;
              }
              $resultado[] = $elem;
          }

      }

      return Response()->json($resultado);
      // return response()->json([
      //   'datos' => $datos,
      //   'sql' => $query,
      //   'resultado' => $resultado,
      //   'totales' => $totales
      //   ]);
  }
}
