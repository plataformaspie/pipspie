<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');
Route::get('siep/dashboard', 'HomeController@siepRedirect');
Route::get('sp/dashboard', 'HomeController@spRedirect');
Route::get('fichas/index', 'HomeController@fichasRedirect');

/* -----------------------------------------------------------------------------
| Ruta general para llamar a una vista de la carpeta Resources/view , en el parametro
| omitir .blase.php y debe ser separado por puntos ej. modulopdes.dashboard
*/
Route::get(Config::get('app.urlBase') . '/{vista}', 'VistaController@index')->middleware('auth');


Route::group(['middleware' => 'auth'],function(){
      Route::group(
          array('prefix' => 'moduloadministracion'),
          function() {
              Route::get('dashboard', 'ModuloAdministracion\DashboardController@index');

              Route::get('abm_usuarios', 'ModuloAdministracion\AbmUsuariosController@index');
              Route::get('listausers', 'ModuloAdministracion\AbmUsuariosController@listarUsers');
              Route::get('listaroles_usu', 'ModuloAdministracion\AbmUsuariosController@listarRoles');
              Route::get('listausers2', 'ModuloAdministracion\AbmUsuariosController@listarUsers2');
              Route::post('guardarusuario', 'ModuloAdministracion\AbmUsuariosController@guardarUsuario');
              Route::post('borrarusuario', 'ModuloAdministracion\AbmUsuariosController@borrarUsuario');
              Route::get('autocompletarinst', 'ModuloAdministracion\AbmUsuariosController@autocompletarInstitucion');

              Route::get('abm_modulos', 'ModuloAdministracion\AbmModulosController@index');
              Route::get('listamodulos', 'ModuloAdministracion\AbmModulosController@listarModulos');
              Route::post('guardarmodulo', 'ModuloAdministracion\AbmModulosController@guardarModulo');
              Route::post('borrarmodulo', 'ModuloAdministracion\AbmModulosController@borrarModulo');
              Route::post('imagenupload', 'ModuloAdministracion\AbmModulosController@get_image');

              Route::get('abm_menus', 'ModuloAdministracion\AbmMenusController@index');
              Route::get('listamenus', 'ModuloAdministracion\AbmMenusController@listarMenus');
              Route::get('listamenus2', 'ModuloAdministracion\AbmMenusController@listarMenus2');
              Route::get('listamodulos_mnu', 'ModuloAdministracion\AbmMenusController@listarModulos');
              Route::post('guardarmenu', 'ModuloAdministracion\AbmMenusController@guardarMenu');
              Route::post('borrarmenu', 'ModuloAdministracion\AbmMenusController@borrarMenu');
              Route::get('listasubmenus', 'ModuloAdministracion\AbmMenusController@listarSubmenus');
              Route::post('guardarsubmenu', 'ModuloAdministracion\AbmMenusController@guardarSubmenu');
              Route::post('borrarsubmenu', 'ModuloAdministracion\AbmMenusController@borrarSubmenu');

              Route::get('abm_roles', 'ModuloAdministracion\AbmRolesController@index');
              Route::get('listaroles', 'ModuloAdministracion\AbmRolesController@listarRoles');
              Route::get('listaroles2', 'ModuloAdministracion\AbmRolesController@listarRoles2');
              Route::get('listamenus_rol', 'ModuloAdministracion\AbmRolesController@listarMenus_rol');
              Route::get('listamodulos_rol', 'ModuloAdministracion\AbmRolesController@listarModulos_rol');
              Route::post('listamenusroles', 'ModuloAdministracion\AbmRolesController@listarMenusRoles');
              Route::post('listamodulosroles', 'ModuloAdministracion\AbmRolesController@listarModulosRoles');
              Route::post('guardarrol', 'ModuloAdministracion\AbmRolesController@guardarRol');
              Route::post('borrarrol', 'ModuloAdministracion\AbmRolesController@borrarRol');
              Route::post('guardarmenusroles', 'ModuloAdministracion\AbmRolesController@guardarMenusRoles');
              Route::post('guardarmodulosroles', 'ModuloAdministracion\AbmRolesController@guardarModulosRoles');

              Route::get('abm_dashmenu', 'ModuloAdministracion\AbmDashMenuController@index');
              Route::get('listadashmenu', 'ModuloAdministracion\AbmDashMenuController@listarDashMenu');
              Route::get('listadashconfigs', 'ModuloAdministracion\AbmDashMenuController@listarDashConfigs');
              Route::post('guardardashmenu', 'ModuloAdministracion\AbmDashMenuController@guardarDashMenu');
              Route::post('borrardashmenu', 'ModuloAdministracion\AbmDashMenuController@borrarDashMenu');


          }
      );
      Route::group(
          array('prefix' => 'moduloadministracion/ajax'),
          function() {
              Route::get('prueba', 'ModuloAdministracion\DashboardController@index');
          }
      );
});

Route::group(['middleware' => 'auth'],function(){
      Route::group(
          array('prefix' => 'moduloentidades'),
          function() {
              Route::get('dashboard', 'ModuloEntidades\DashboardController@index');
              Route::get('instituciones', 'ModuloEntidades\InstitucionController@index');

              //Route::resource('instituciones', 'ModuloEntidades\InstitucionController');


          }
      );
      Route::group(
          array('prefix' => 'moduloentidades/ajax'),
          function() {
              Route::get('instituciones/obtenertodas', 'ModuloEntidades\InstitucionController@getInstituciones');
              Route::post('instituciones/crud', 'ModuloEntidades\InstitucionController@crudInstitucion');
              Route::get('instituciones/categorias','ModuloEntidades\InstitucionController@getCategorias');
              Route::get('instituciones/regiones','ModuloEntidades\InstitucionController@getRegiones');
          }
      );
});

Route::group(['middleware' => 'auth'],function(){
      Route::group(
          array('prefix' => 'modulopriorizacion'),
          function() {
              Route::get('dashboard', 'ModuloPriorizacion\DashboardController@index');
              Route::get('tablero', 'ModuloPriorizacion\TableroController@index');
          }
      );
      Route::group(
          array('prefix' => 'modulopriorizacion/ajax'),
          function() {
              Route::get('cargarhijos', 'ModuloPriorizacion\DashboardController@cargarHijos');
              Route::get('configurarfiltrovariable', 'ModuloPriorizacion\DashboardController@configurarFiltroVariable');
              Route::get('generardatosVE0001', 'ModuloPriorizacion\DashboardController@generarDatosVE0001');
              Route::get('generardatosVE0003', 'ModuloPriorizacion\DashboardController@generarDatosVE0003');
              Route::get('generardatosVE0002', 'ModuloPriorizacion\DashboardController@generarDatosVE0002');
              Route::get('obtenerDatosFiltro', 'ModuloPriorizacion\DashboardController@obtenerDatosFiltro');
          }
      );
      Route::group(
          array('prefix' => 'api/modulopriorizacion'),
          function() {
              Route::get('menustablero', 'ModuloPriorizacion\TableroController@menusTablero');
              Route::post('datosVariableEstadistica', 'ModuloPriorizacion\TableroController@datosVariableEstadistica');
              Route::post('tablero/guardaconfiguracion', 'ModuloPriorizacion\TableroController@guardaConfiguracion');
              Route::get('datosIndicadoresMeta', 'ModuloPriorizacion\TableroController@datosIndicadoresMeta');

          }
      );
});

Route::group(['middleware' => 'auth'],function(){
      Route::group(
          array('prefix' => 'modulopdes'),
          function() {
              Route::get('indicadores', 'ModuloPdes\DashboardController@index');
              Route::get('proyectos', 'ModuloPdes\DashboardController@proyectos');
              Route::get('presupuesto', 'ModuloPdes\DashboardController@presupuesto');
              Route::get('indicadoresclasificados', 'ModuloPdes\DashboardController@indicadoresClasificados');
              Route::get('tablerosiep', 'ModuloPdes\DashboardController@tableroSiep');
              Route::get('participacion', 'ModuloPdes\DashboardController@participacion');
              Route::get('gestionproyectos', 'ModuloPdes\GestionProyectosController@index');
          }
      );
      Route::group(
          array('prefix' => 'modulopdes/ajax'),
          function() {
              Route::get('listarpilares', 'ModuloPdes\PilaresController@listarPilares');
              Route::get('listarmetas', 'ModuloPdes\MetasController@listarMetas');
              Route::get('listarresultados', 'ModuloPdes\ResultadosController@listarResultados');
              Route::get('listarpilares2', 'ModuloPdes\PilaresController@listarPilares2');
              Route::get('listarresultados2', 'ModuloPdes\ResultadosController@listarResultados2');
              Route::get('datosresultado', 'ModuloPdes\ResultadosController@datosResultado');
              Route::get('listaindicadores', 'ModuloPdes\DashboardController@listaIndicadores');
              Route::get('graficaindicador', 'ModuloPdes\DashboardController@graficaIndicador');
              Route::get('graficaproyecto', 'ModuloPdes\DashboardController@graficaProyecto');
              Route::get('combofiltros', 'ModuloPdes\DashboardController@comboFiltros');
              Route::get('combofiltroshijos', 'ModuloPdes\DashboardController@comboFiltrosHijos');
              Route::get('configcombofiltros', 'ModuloPdes\DashboardController@configComboFiltros');
              Route::get('listaproyectos', 'ModuloPdes\DashboardController@listaProyectos');
              Route::get('totalesproyectosdetalle', 'ModuloPdes\DashboardController@totalesProyectosDetalle');
              Route::get('datosmeta', 'ModuloPdes\MetasController@datosMeta');
              Route::get('datospilar', 'ModuloPdes\PilaresController@datosPilar');
              Route::get('datosproyecto', 'ModuloPdes\DashboardController@datosProyecto');
              Route::get('combofiltroshijosproyectos', 'ModuloPdes\DashboardController@comboFiltrosHijosProyectos');
              Route::get('graficaall', 'ModuloPdes\DashboardController@graficaAll');
              Route::get('totalespresupuestodetalle', 'ModuloPdes\DashboardController@totalesPresupuestoDetalle');
              Route::get('graficapresupuestoall', 'ModuloPdes\DashboardController@graficaPresupuestoAll');
              Route::get('listadatospdes', 'ModuloPdes\DashboardController@listaDatosPdes');
              Route::get('detallepilares', 'ModuloPdes\PilaresController@detallePilares');
              Route::get('datosgraficaparticipacion', 'ModuloPdes\DashboardController@datosGraficaParticipacion');

          }
      );
      //  RUTAS DE GESTION DE PROYECTOS_PDES ///////////////////////////////////
      Route::group(
        array('prefix' => 'api/modulopdes' ),
        function() {
              Route::get('gestionproyectos',      'ModuloPdes\GestionProyectosController@listarProyectosPdesAsociados');
              Route::post('gestionproyectos',     'ModuloPdes\GestionProyectosController@insertar');
              Route::get('gestionproyectos/{id}', 'ModuloPdes\GestionProyectosController@obtieneProyecto');
              Route::get('gestionproyectos/listar/{op}',      'ModuloPdes\GestionProyectosController@listar'); // op:['sectores','instituciones','sisinweb','resultados']
              Route::get('gestionproyectos/buscar/sisin',      'ModuloPdes\GestionProyectosController@buscarSisin');
              /* --- NO EJECUTAR   Funcion para vincular los proyectos y Resultados del SP en la base postgres realiza un insert masivo, sobreescribiendo los datos */
              // Route::get('gestionproyectos/sp/insetar_resultados_proyectos_pdes',  'ModuloPdes\GestionProyectosController@insertarResultadosProyectosPdes');
              Route::get('gestionproyectos/sp/obtener_proyecto_sp/{codigo}',  'ModuloPdes\GestionProyectosController@obtenerProyectoSP');


		  }
      );
});

Route::group(['middleware' => 'auth'],function(){
      Route::group(
          array('prefix' => 'moduloplanificacion'),
          function() {
              Route::get('dashboard', 'ModuloPlanificacion\DashboardController@index');
              Route::get('prueba', 'ModuloPlanificacion\PruebaController@index');
              Route::get('res', 'ModuloPlanificacion\PruebaController@res');
              Route::get('index', 'ModuloPlanificacion\IndexController@index');
              Route::get('showDiagnostico', 'ModuloPlanificacion\PlanificacionController@showDiagnostico');
              Route::get('showEnfoque', 'ModuloPlanificacion\PlanificacionController@showEnfoque');
              Route::get('showEstructura', 'ModuloPlanificacion\AdministracionController@showEstructura');
              Route::get('showPlanesInstitucion', 'ModuloPlanificacion\AdministracionController@showPlanesInstitucion');
          }
      );
      Route::group(
          array('prefix' => 'api/moduloplanificacion'),
          function() {
              Route::get('demo', 'ModuloPlanificacion\DashboardController@demo');
              Route::get('setDiagnostico', 'ModuloPlanificacion\PlanificacionController@setDiagnostico');
              Route::get('dataSetDiagnostico', 'ModuloPlanificacion\PlanificacionController@dataSetDiagnostico');
              Route::post('saveDataEdit', 'ModuloPlanificacion\PlanificacionController@saveDataEdit');
              Route::get('deleteDiagnostico', 'ModuloPlanificacion\PlanificacionController@deleteDiagnostico');
              Route::post('saveDataNew', 'ModuloPlanificacion\PlanificacionController@saveDataNew');
              Route::get('dataEntidadEnfoque', 'ModuloPlanificacion\PlanificacionController@dataEntidadEnfoque');
              Route::post('saveEnfoqueEdit', 'ModuloPlanificacion\PlanificacionController@saveEnfoqueEdit');
              Route::get('setEstructuraEntidad', 'ModuloPlanificacion\AdministracionController@setEstructuraEntidad');
              Route::post('saveEntidadNew', 'ModuloPlanificacion\AdministracionController@saveEntidadNew');
              Route::get('dataSetEntidad', 'ModuloPlanificacion\AdministracionController@dataSetEntidad');
              Route::post('saveEntidadEdit', 'ModuloPlanificacion\AdministracionController@saveEntidadEdit');
              Route::get('deleteEntidad', 'ModuloPlanificacion\AdministracionController@deleteEntidad');
              Route::get('setEntidadOrganigrama', 'ModuloPlanificacion\AdministracionController@setEntidadOrganigrama');
              Route::post('saveOficinaNew', 'ModuloPlanificacion\AdministracionController@saveOficinaNew');
              Route::post('saveOficinaEdit', 'ModuloPlanificacion\AdministracionController@saveOficinaEdit');
              Route::get('deleteOficina', 'ModuloPlanificacion\AdministracionController@deleteOficina');
              Route::get('setEstructuraOfi', 'ModuloPlanificacion\AdministracionController@setEstructuraOfi');
              Route::get('setEstructuraEnti', 'ModuloPlanificacion\AdministracionController@setEstructuraEnti');
              Route::get('setEntidadPlan', 'ModuloPlanificacion\AdministracionController@setEntidadPlan');
          }
      );
});

Route::group(['middleware' => 'auth'],function(){
      Route::group(
          array('prefix' => 'sistemasisgri'),
          function() {
              Route::get('index', 'Sistemasisgri\IndexController@index');
              Route::get('showPilares', 'Sistemasisgri\PdesController@showPilares');
              Route::get('showMetas', 'Sistemasisgri\PdesController@showMetas');
              Route::get('showResultados', 'Sistemasisgri\PdesController@showResultados');
              Route::get('adminClasificador', 'Sistemasisgri\PdesController@adminClasificador');



          }
      );
      Route::group(
          array('prefix' => 'api/sistemasisgri'),
          function() {
              Route::get('setPilares', 'Sistemasisgri\PdesController@setPilares');
              Route::get('setMetas', 'Sistemasisgri\PdesController@setMetas');
              Route::get('setResultados', 'Sistemasisgri\PdesController@setResultados');
              Route::get('setClasificadores', 'Sistemasisgri\PdesController@setClasificadores');
              Route::get('dataSetPilar', 'Sistemasisgri\PdesController@dataSetPilar');
              Route::get('dataSetMeta', 'Sistemasisgri\PdesController@dataSetMeta');
              Route::get('dataSetResultado', 'Sistemasisgri\PdesController@dataSetResultado');
              Route::post('saveDataPilar', 'Sistemasisgri\PdesController@saveDataPilar');
              Route::post('saveDataMeta', 'Sistemasisgri\PdesController@saveDataMeta');
              Route::post('saveDataResultado', 'Sistemasisgri\PdesController@saveDataResultado');
          }
      );
});


Route::group(['middleware' => 'auth'],function(){
      Route::group(
          array('prefix' => 'sistemaremi'),
          function() {
              Route::get('index', 'SistemaRemi\IndexController@index');
          }
      );
      Route::group(
          array('prefix' => 'api/sistemaremi'),
          function() {
              Route::get('demo', 'ModuloPlanificacion\DashboardController@demo');

          }
      );
});
