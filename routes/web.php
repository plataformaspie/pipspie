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
Route::get('settingPerfil', 'SettingController@settingPerfil');
Route::get('settingPassword', 'SettingController@settingPassword');
Route::post('apiSavePerfil', 'SettingController@apiSavePerfil');
Route::post('apiSavePassword', 'SettingController@apiSavePassword');
Route::get('apiValidateSession', 'SettingController@apiValidateSession');


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

              Route::get('gestionproyectos/export/excel',  'ModuloPdes\GestionProyectosController@exportExcel');
              Route::get('gestionproyectos/export/excel1',  'ModuloPdes\GestionProyectosController@exportExcel1');

            }
      );
});

Route::group(['middleware' => 'auth'],function(){
    Route::group(
        array('prefix' => 'moduloplanificacion'),
        function() {
            Route::get('index', 'ModuloPlanificacion\PlanificacionBaseController@index');

            Route::get('showEstructura', 'ModuloPlanificacion\AdministracionController@showEstructura');

            Route::get('showPlanesInstitucion', 'ModuloPlanificacion\PlanesController@showPlanesInstitucion');
            Route::get('showEnfoque', 'ModuloPlanificacion\EnfoquePoliticoController@showEnfoque');
            Route::get('showDiagnostico', 'ModuloPlanificacion\DiagnosticoController@showDiagnostico');
            Route::get('showPolitica', 'ModuloPlanificacion\PoliticaController@showPolitica');
            Route::get('showPlanificacion-pmra', 'ModuloPlanificacion\PlanificaPMRAController@showPlanificacionPMRA');


            /*++++++++++admininistracion Clasificador++++++++++++++++++++++++++++++*/
            Route::get('showClasificador','ModuloPlanificacion\AdminClasificadorController@showClasificador');
           
            Route::get('setClasificador','ModuloPlanificacion\AdminClasificadorController@setClasificador');
            Route::post('saveInstitucion','ModuloPlanificacion\AdminClasificadorController@saveInstitucion');
            
            Route::post('saveInstitucionEdit','ModuloPlanificacion\AdminClasificadorController@saveInstitucionEdit');

            Route::get('dataSetInstitucion','ModuloPlanificacion\AdminClasificadorController@dataSetInstitucion');
            Route::get('deleteInstitucion','ModuloPlanificacion\AdminClasificadorController@deleteInstitucion');      
 


            Route::get('showSeguimiento', 'ModuloPlanificacion\SeguimientoController@showSeguimiento');
            Route::get('showReviewPlanesInstitucion', 'ModuloPlanificacion\ReviewController@showReviewPlanesInstitucion');

              // Territorial asignacion ----------------------------------------
              Route::get('showPlanificacionTerritorial', 'ModuloPlanificacion\PlanificacionTerritorialABMController@showPlanificacionTerritorial');
              //Route::get('showPlanificacionTerritorial', 'ModuloPlanificacion\PlanificacionTerritorialController@showPlanificacionTerritorial');
              Route::get('AgregarPlanificacionTerritorial', 'ModuloPlanificacion\PlanificacionTerritorialController@showPlanificacionTerritorial');
              Route::get('listarEtas', 'ModuloPlanificacion\PlanificacionTerritorialController@listaEtas');
              Route::get('listarTipoEtas/{idetas}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaTiposEtas');
              Route::get('TipoEtas/{ideta}', 'ModuloPlanificacion\PlanificacionTerritorialController@TiposEtas');
              Route::get('listarDepartamentos', 'ModuloPlanificacion\PlanificacionTerritorialController@listaDepartamentos');
              Route::get('listarProvincias/{iddepto}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaProvincias');
              Route::get('listarMunicipios/{iddepto}/{idprov}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaMunicipios');
              Route::get('listarGastos1', 'ModuloPlanificacion\PlanificacionTerritorialController@listaGastos1');
              Route::get('listarGastos2', 'ModuloPlanificacion\PlanificacionTerritorialController@listaGastos2');
              Route::get('listarAcciones/{idgasto}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaAcciones');
              Route::get('listarTipos/{idgasto}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaTipos');
              Route::get('listarAcciones2/{idgasto}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaAcciones2');
              Route::get('listarServicios/{idgasto}/{idtipo}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaServicios');
              Route::get('listarAcciones3/{idgasto}/{idtipo}/{idser}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaAcciones3');
              Route::get('listarPilares/{idaccion}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaPilares');
              Route::get('listarMetas/{idaccion}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaMetas');
              Route::get('listarResultados/{idaccion}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaResultados');
              Route::get('listarAccionesEtas/{idaccion}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaAccionesEtas');
              Route::get('listarPMRAs/{idpilar}/{idmeta}/{idresultado}/{idaccion}', 'ModuloPlanificacion\PlanificacionTerritorialController@listaPMRAs');
              Route::post('insertarmatriz', 'ModuloPlanificacion\PlanificacionTerritorialController@insertar');
// Territorial reporte ----------------------------------------
              Route::get('showBuscadorTerritorial', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@showPlanificacionTerritorialBuscador');
              Route::get('listarMatrices', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@listaMatrices');
              Route::get('listarRegistroMatrices', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@listaRegistroMatrices');
              Route::get('exports','ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@export');
              Route::get('listarEtasFil', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@listaEtas');
              Route::get('listarDepartamentosFil', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@listaDepartamentos');
              Route::get('listarTipoEtasFil/{idetas}', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@listaTiposEtas');
              Route::get('listarGastos1Fil/{idetas}', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@listaGastos1Fil');
              Route::get('listarGastos2Fil/{idetas}', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@listaGastos2Fil');
              
              //-------------------------------------editar              
              Route::get('listarMatricesEditar', 'ModuloPlanificacion\PlanificacionTerritorialABMController@listaMatricesEditar');
              Route::get('listarEtasEditar', 'ModuloPlanificacion\PlanificacionTerritorialABMController@listaEtasEditar');
              Route::get('listarDepartamentosEditar', 'ModuloPlanificacion\PlanificacionTerritorialABMController@listaDepartamentosEditar');
              Route::get('listarProvinciasEditar/{iddepto}', 'ModuloPlanificacion\PlanificacionTerritorialABMController@listaProvinciasEditar');
              Route::get('listarTiposEditar', 'ModuloPlanificacion\PlanificacionTerritorialABMController@listaTiposEditar');
              Route::get('listarServiciosEditar', 'ModuloPlanificacion\PlanificacionTerritorialABMController@listaServiciosEditar');
              Route::get('actualizarmatriz/{id}', 'ModuloPlanificacion\PlanificacionTerritorialABMController@update');
              Route::get('eliminarmatriz/{id}', 'ModuloPlanificacion\PlanificacionTerritorialABMController@delete');
              
               Route::get('TipoEtasEdit/{ideta}', 'ModuloPlanificacion\PlanificacionTerritorialABMController@TiposEtas');
               //-/------------------------------------seguimiento
               Route::get('showSeguimientoTerritorial', 'ModuloPlanificacion\SeguimientoTerritorialABMController@seguimiento');
               Route::get('listarMatricesSeguimiento', 'ModuloPlanificacion\SeguimientoTerritorialABMController@listaMatricesSeguimiento');
               Route::post('insertarseguimiento', 'ModuloPlanificacion\SeguimientoTerritorialABMController@insertar');
              //---------------------------------------- finnnn Territorial ----------------------------------------
              Route::get('{otra?}/{ruta?}/{a?}/{b?}/{c?}', function(){
                  return view('ModuloPlanificacion.error', ['mensaje'=>'No existe la URL']);
              });

        }
    );
    Route::group(
        array('prefix' => 'api/moduloplanificacion'),
        function() {
            /********** genericas de la plantilla *********/
            Route::get('getmenu', 'ModuloPlanificacion\PlanificacionBaseController@getMenu');
            Route::get('getuser', 'ModuloPlanificacion\PlanificacionBaseController@getUser');
            Route::get('getplan', 'ModuloPlanificacion\PlanificacionBaseController@getPlan');
            Route::get('getpilares', 'ModuloPlanificacion\PlanificacionBaseController@getPilares');
            Route::get('getmetaspilar', 'ModuloPlanificacion\PlanificacionBaseController@getMetasPilar');
            Route::get('getresultadosmeta', 'ModuloPlanificacion\PlanificacionBaseController@getResultadosMeta');
            Route::get('getaccionesresultado', 'ModuloPlanificacion\PlanificacionBaseController@getAccionesResultado');
            Route::get('getparametros/{categoria}/{a?}/{b?}', 'ModuloPlanificacion\PlanificacionBaseController@getParametros');

            /********** Etidades *************************/
            Route::get('setEstructuraEntidad', 'ModuloPlanificacion\AdministracionController@setEstructuraEntidad');
            Route::post('saveEntidadNew', 'ModuloPlanificacion\AdministracionController@saveEntidadNew');
            Route::get('dataSetEntidad', 'ModuloPlanificacion\AdministracionController@dataSetEntidad');
            Route::post('saveEntidadEdit', 'ModuloPlanificacion\AdministracionController@saveEntidadEdit');
            Route::get('deleteEntidad', 'ModuloPlanificacion\AdministracionController@deleteEntidad');
            Route::get('setEntidadOrganigrama', 'ModuloPlanificacion\AdministracionController@setEntidadOrganigrama');
            Route::get('getEntidadesHijos/{id}', 'ModuloPlanificacion\AdministracionController@obtenerEntidadesHijos');

            /********** oficinas **********************/
            Route::post('saveOficinaNew', 'ModuloPlanificacion\AdministracionController@saveOficinaNew');
            Route::post('saveOficinaEdit', 'ModuloPlanificacion\AdministracionController@saveOficinaEdit');
            Route::get('deleteOficina', 'ModuloPlanificacion\AdministracionController@deleteOficina');
            Route::get('setEstructuraOfi', 'ModuloPlanificacion\AdministracionController@setEstructuraOfi');
            Route::get('setEstructuraEnti', 'ModuloPlanificacion\AdministracionController@setEstructuraEnti');

            /********** Planes ***********************/
            Route::get('listPlanes', 'ModuloPlanificacion\PlanesController@listPlanes');
            Route::post('savePlan', 'ModuloPlanificacion\PlanesController@savePlan');
            Route::get('deletePlan', 'ModuloPlanificacion\PlanesController@deletePlan');
            Route::post('actualizaEtapas', 'ModuloPlanificacion\PlanesController@actualizaEtapas');

            /********** Enfoque politico *****************/
            Route::get('getEnfoque', 'ModuloPlanificacion\EnfoquePoliticoController@getEnfoquePolitico');
            Route::post('saveEnfoque', 'ModuloPlanificacion\EnfoquePoliticoController@saveEnfoque');

            Route::get('listAtribucionesPilares', 'ModuloPlanificacion\EnfoquePoliticoController@listAtribucionesPilares');
            Route::post('saveAtribucion', 'ModuloPlanificacion\EnfoquePoliticoController@saveAtribucion');
            Route::post('deleteAtribucion', 'ModuloPlanificacion\EnfoquePoliticoController@deleteAtribucion');

            Route::get('getPilaresVinculadosAlPlan', 'ModuloPlanificacion\EnfoquePoliticoController@getPilaresVinculadosAlPlan');

            /********** Diagnostico ******************/
            Route::get('setDiagnostico', 'ModuloPlanificacion\DiagnosticoController@setDiagnostico');
            Route::get('dataSetDiagnostico', 'ModuloPlanificacion\DiagnosticoController@dataSetDiagnostico');
            Route::post('saveDataEdit', 'ModuloPlanificacion\DiagnosticoController@saveDataEdit');
            Route::get('deleteDiagnostico', 'ModuloPlanificacion\DiagnosticoController@deleteDiagnostico');
            Route::post('saveDataNew', 'ModuloPlanificacion\DiagnosticoController@saveDataNew');
            Route::get('listvariables_lb', 'ModuloPlanificacion\DiagnosticoController@listVariablesConLineaBase');

            /********** Sistemas de Vida ******************/
            Route::get('setSistemasVida', 'ModuloPlanificacion\SistemasVidaController@setSistemasVida');
            Route::post('saveSistemasVida', 'ModuloPlanificacion\SistemasVidaController@saveSistemasVida');
            Route::get('dataSetSistemaVida', 'ModuloPlanificacion\SistemasVidaController@dataSetSistemaVida');
            Route::get('deleteSistemasVida', 'ModuloPlanificacion\SistemasVidaController@deleteSistemasVida');

            /********** Analisis de Riegos ******************/
            Route::get('setRiesgos', 'ModuloPlanificacion\RiesgosController@setRiesgos');
            Route::post('saveRiesgo', 'ModuloPlanificacion\RiesgosController@saveRiesgo');
            Route::get('dataSetRiesgo', 'ModuloPlanificacion\RiesgosController@dataSetRiesgo');
            Route::get('deleteRiesgo', 'ModuloPlanificacion\RiesgosController@deleteRiesgo');
            Route::get('updateComboJurisdiccionTerritorial', 'ModuloPlanificacion\RiesgosController@updateComboJurisdiccionTerritorial');


            /********** Politica Sectorial/institucional ******************/
            Route::get('listPoliticasPilares', 'ModuloPlanificacion\PoliticaController@listPoliticasPilares');
            Route::post('savePolitica', 'ModuloPlanificacion\PoliticaController@savePolitica');
            Route::post('deletePolitica', 'ModuloPlanificacion\PoliticaController@deletePolitica');

         
            /************Administracion Entidades**************************************/
            Route::get('setMinisterios', 'ModuloPlanificacion\AdminEntidadesController@setMinisterios');
            
            Route::post('saveEntidadNewAdministracion', 'ModuloPlanificacion\AdminEntidadesController@saveEntidadNewAdministracion');

            Route::post('saveMinisterio', 'ModuloPlanificacion\AdminEntidadesController@saveMinisterio');



            

            /********** Planificacion 1 PMRA ******************/
            Route::get('lista_pmraPlan', 'ModuloPlanificacion\PlanificaPMRAController@listaPmraPlan');
            Route::post('save_pmra', 'ModuloPlanificacion\PlanificaPMRAController@savePMRA');
            Route::post('delete_pmra', 'ModuloPlanificacion\PlanificaPMRAController@deletePMRA');

            Route::post('modifycampo', 'ModuloPlanificacion\PlanificaPMRAController@modifyCampo');
            /********** Planificacion 2 programacion ******************/            

            Route::get('listaprogramacion', 'ModuloPlanificacion\PlanificaPMRAController@listaProgramacion');
            Route::post('saveIndicadorResProg', 'ModuloPlanificacion\PlanificaPMRAController@saveIndicadorResProg');
            Route::post('deleteprogramacion', 'ModuloPlanificacion\PlanificaPMRAController@deleteProgramacion');
            /********** Planificacion 3 planificacion accion ******************/            
            Route::get('listaaccionesproy', 'ModuloPlanificacion\PlanificaPMRAController@listaAccionesProyectos');
            Route::post('saveartiproyecto', 'ModuloPlanificacion\PlanificaPMRAController@saveArtiProyecto');
            Route::post('deleteartiproyecto', 'ModuloPlanificacion\PlanificaPMRAController@deleteArtiProyecto');
            Route::get('listproyectos', 'ModuloPlanificacion\PlanificaPMRAController@listProyectos');            
            Route::post('saveIndicadorAccionProg', 'ModuloPlanificacion\PlanificaPMRAController@saveIndicadorAccionProg');
            Route::post('saveresponsables', 'ModuloPlanificacion\PlanificaPMRAController@saveResponsables');
            Route::post('saverolesactores', 'ModuloPlanificacion\PlanificaPMRAController@saveRolesActores');
            Route::post('savearticulacioncompetencial', 'ModuloPlanificacion\PlanificaPMRAController@saveArticulacionCompetencial');
            Route::post('saveterritorializacion', 'ModuloPlanificacion\PlanificaPMRAController@saveTerritorializacion');

            Route::post('delete_atributo', 'ModuloPlanificacion\PlanificaPMRAController@deleteAtributo');
            Route::get('list_atributo', 'ModuloPlanificacion\PlanificaPMRAController@listAtributo');
            Route::get('list_regiones', 'ModuloPlanificacion\PlanificaPMRAController@listRegiones');
            /********** Seguimiento Evaluacion ******************/            
            Route::get('listindicadores', 'ModuloPlanificacion\SeguimientoController@listIndicadores');
            Route::get('datosindicador', 'ModuloPlanificacion\SeguimientoController@datosIndicador');

            Route::post('saveejecuciones', 'ModuloPlanificacion\SeguimientoController@saveEjecuciones');


            
            /********** Review ******************/
            Route::get('apiSetListMinisterios', 'ModuloPlanificacion\ReviewController@apiSetListMinisterios');
            Route::get('apiSetListSinCabeza', 'ModuloPlanificacion\ReviewController@apiSetListSinCabeza');
            Route::get('apiSetListMultis', 'ModuloPlanificacion\ReviewController@apiSetListMultis');

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
              Route::get('/', 'SistemaRemi\IndexController@index');
              Route::get('settingPerfil', 'SistemaRemi\SettingController@settingPerfil');
              Route::get('settingPassword', 'SistemaRemi\SettingController@settingPassword');
              Route::get('index', 'SistemaRemi\IndexController@index');
              Route::get('setIndicadores', 'SistemaRemi\IndicadorController@setIndicadores');
              Route::post('setIndicadoresSearch', 'SistemaRemi\IndicadorController@setIndicadores');
              Route::get('dataIndicador/{id}', 'SistemaRemi\IndicadorController@dataIndicador');
              Route::get('adminIndicador', 'SistemaRemi\IndicadorController@adminIndicador');
              Route::get('setFuenteDatos', 'SistemaRemi\FuenteDatosController@setFuenteDatos');
              Route::get('adminFuenteDatos', 'SistemaRemi\FuenteDatosController@adminFuenteDatos');

          }
      );
      Route::group(
          array('prefix' => 'api/sistemaremi'),

          function() {
              Route::get('demo', 'SistemaRemi\IndicadorController@demo');
              Route::post('apiSavePerfil', 'SistemaRemi\SettingController@apiSavePerfil');
              Route::post('apiSavePassword', 'SistemaRemi\SettingController@apiSavePassword');
              Route::get('setDataPdes', 'SistemaRemi\IndicadorController@setDataPdes');
              Route::get('apiSetIndicadores', 'SistemaRemi\IndicadorController@apiSetIndicadores');
              Route::post('apiSaveIndicador', 'SistemaRemi\IndicadorController@apiSaveIndicador');
              Route::get('apiDataSetIndicador', 'SistemaRemi\IndicadorController@apiDataSetIndicador');
              Route::delete('apiDeleteIndicador', 'SistemaRemi\IndicadorController@apiDeleteIndicador');
              Route::get('apiSourceOrderbyArray', 'SistemaRemi\IndicadorController@apiSourceOrderbyArray');
              Route::get('apiSetFuenteDatos', 'SistemaRemi\IndicadorController@apiSetFuenteDatos');
              Route::get('apiSourceOrderbyArray2', 'SistemaRemi\IndicadorController@apiSourceOrderbyArray2');
              Route::post('apiSaveFuente', 'SistemaRemi\IndicadorController@apiSaveFuente');
              Route::get('apiUpdateComboFuente', 'SistemaRemi\IndicadorController@apiUpdateComboFuente');
              Route::get('setPdes', 'SistemaRemi\IndicadorController@setPdes');
              Route::post('apiUploadArchivoRespaldo', 'SistemaRemi\IndicadorController@apiUploadArchivoRespaldo');
              Route::get('apiDeleteArchivo', 'SistemaRemi\IndicadorController@apiDeleteArchivo');
              Route::get('apiExportData', 'SistemaRemi\ExportReportController@descagarExcelAdminFuente');


          }
      );
      Route::group(
          array('prefix' => 'sistemarime'),
          function() {
              Route::get('setFuenteDatos', 'SistemaRemi\FuenteDatosController@setFuenteDatos');
              Route::get('adminFuenteDatos', 'SistemaRemi\FuenteDatosController@adminFuenteDatos');
          }
      );
      Route::group(
          array('prefix' => 'api/sistemarime'),
          function() {
              //fuente de datos
              Route::get('apiSetListFuenteDatos', 'SistemaRemi\FuenteDatosController@apiSetListFuenteDatos');
              Route::get('apiSourceOrderbyArray2', 'SistemaRemi\FuenteDatosController@apiSourceOrderbyArray2');
              Route::post('apiSaveFuenteDatos', 'SistemaRemi\FuenteDatosController@apiSaveFuenteDatos');
              Route::post('apiUploadArchivoRespaldo', 'SistemaRemi\FuenteDatosController@apiUploadArchivoRespaldo');
              Route::get('apiDeleteArchivo', 'SistemaRemi\FuenteDatosController@apiDeleteArchivo');

              Route::get('apiDataSetFuente', 'SistemaRemi\FuenteDatosController@apiDataSetFuente');
              Route::get('descagarExcelMetadatosOnly/{id}', 'SistemaRemi\ExportReportController@descagarExcelMetadatosOnly');


              Route::post('apiRecuperarFuente', 'SistemaRemi\FuenteDatosController@apiRecuperarFuente');
              Route::delete('apiDeleteFuente', 'SistemaRemi\FuenteDatosController@apiDeleteFuente');

          }
      );
});
