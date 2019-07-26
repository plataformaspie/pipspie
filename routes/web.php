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
            Route::get('showGestionDocumental', 'ModuloPlanificacion\GestionDocumentalController@showGestionDocumental');


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

            Route::get('listarSelecTipoEtas', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@listaSelecTipoEta');
            Route::get('listarNuevaMatrices/{dep}/{prog}', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@listaNuevaMatriz');
            Route::get('listarNuevaSeguimientos/{dep}/{prog}', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@listaNuevSeguimiento');
            Route::get('listarSelProg/{id_tipeta}', 'ModuloPlanificacion\PlanificacionTerritorialControllerBuscador@listaprograma');
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
             Route::get('TipoEtasSeguimientoEdit/{ideta}', 'ModuloPlanificacion\SeguimientoTerritorialABMController@TiposEtas');
             Route::get('listarPilaresSeguimientoedit/{idaccion}', 'ModuloPlanificacion\SeguimientoTerritorialABMController@listaPilares');
             Route::get('listarSeguimientoPMRAs/{idpilar}/{idmeta}/{idresultado}/{idaccion}', 'ModuloPlanificacion\SeguimientoTerritorialABMController@listaPMRAs');
             Route::get('actualizarmatrizSeguimiento/{id}', 'ModuloPlanificacion\SeguimientoTerritorialABMController@update');
              Route::get('eliminarmatrizSeguimiento/{id}', 'ModuloPlanificacion\SeguimientoTerritorialABMController@delete');
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
            Route::post('savepresupuestoscontrapartes', 'ModuloPlanificacion\PlanificaPMRAController@savePresupuestosContrapartes');
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

            /********** Gestio Documental ******************/
            Route::get('listDocumentos', 'ModuloPlanificacion\GestionDocumentalController@listDocumentos');
            Route::post('savedocumento', 'ModuloPlanificacion\GestionDocumentalController@saveDocumento');
            Route::post('deletedocumento', 'ModuloPlanificacion\GestionDocumentalController@deleteDocumento');

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

/*-----------------INICIO MODULO RIME----------------------*/
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
              Route::get('adminMisIndicadores', 'SistemaRemi\IndicadorController@adminIndicador');
              Route::get('adminIndicadorEntidad', 'SistemaRemi\IndicadorController@adminIndicadorEntidad');
              Route::get('setFuenteDatos', 'SistemaRemi\FuenteDatosController@setFuenteDatos');
              Route::get('adminFuenteDatos', 'SistemaRemi\FuenteDatosController@adminFuenteDatos');

              Route::resource('registrar', 'SistemaRemi\RegistrameUserController');
              Route::get('registrar/{id}/destroy','SistemaRemi\RegistrameUserController@destroy')->name('SistemaRemi.registrar.destroy');

              //Route::get('CrudUsers', 'SistemaRemi\IndicadorController@CrudUsers')->name('CrudUsers');
              //Route::get('mostrarReg', 'SistemaRemi\IndicadorController@mostrarReg')->name('mostrarReg');
              //Route::get('registrarUser', 'SistemaRemi\IndicadorController@registrarUser')->name('registrarUser');
              //Route::post('guardarUser', 'SistemaRemi\IndicadorController@guardarUser')->name('guardarUser');
              //Route::get('editarUser/{id}', 'SistemaRemi\IndicadorController@editarUser')->name('SistemaRemi.registrar.editarUser');
              //Route::post('actualizarUser/{id}', 'SistemaRemi\IndicadorController@actualizarUser')->name('SistemaRemi.registrar.actualizarUser');
              //Route::get('eliminarUser/{id}', 'SistemaRemi\IndicadorController@eliminarUser')->name('SistemaRemi.registrar.eliminarUser');


            Route::get('asignarRoles', 'SistemaRemi\IndicadorController@asignarRoles')->name('asignarRoles');
            Route::post('actualizarUserRol', 'SistemaRemi\IndicadorController@actualizarUserRol')->name('actualizarUserRol');

            Route::get('CrudUsers', 'SistemaRemi\AdmiUserController@CrudUsers')->name('CrudUsers');
              Route::get('mostrarReg', 'SistemaRemi\AdmiUserController@mostrarReg')->name('mostrarReg');
              Route::get('registrarUser', 'SistemaRemi\AdmiUserController@registrarUser')->name('registrarUser');
              Route::post('guardarUser', 'SistemaRemi\AdmiUserController@guardarUser')->name('guardarUser');
              Route::get('editarUser/{id}', 'SistemaRemi\AdmiUserController@editarUser')->name('SistemaRemi.registrar.editarUser');
              Route::post('actualizarUser/{id}', 'SistemaRemi\AdmiUserController@actualizarUser')->name('SistemaRemi.registrar.actualizarUser');
            Route::get('eliminarUser/{id}', 'SistemaRemi\AdmiUserController@eliminarUser')->name('SistemaRemi.registrar.eliminarUser');
            Route::get('asignarRoles', 'SistemaRemi\AdmiUserController@asignarRoles')->name('asignarRoles');
            Route::post('actualizarUserRol', 'SistemaRemi\AdmiUserController@actualizarUserRol')->name('actualizarUserRol');
            Route::post('apiAjustesIndicador', 'SistemaRemi\IndicadorController@apiAjustesIndicador');

          });

      Route::group(
          array('prefix' => 'api/sistemaremi'),
          function() {
              Route::get('demo', 'SistemaRemi\IndicadorController@demo');
              Route::post('apiSavePerfil', 'SistemaRemi\SettingController@apiSavePerfil');
              Route::post('apiSavePassword', 'SistemaRemi\SettingController@apiSavePassword');
              Route::get('setDataPdes', 'SistemaRemi\IndicadorController@setDataPdes');
              Route::get('setDataODS', 'SistemaRemi\IndicadorController@setDataODS');
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
              Route::post('apiUploadArchivoRespaldoEdad', 'SistemaRemi\IndicadorController@apiUploadArchivoRespaldoEdad');
              Route::post('apiUploadArchivoRespaldoNac', 'SistemaRemi\IndicadorController@apiUploadArchivoRespaldoNac');
              Route::post('apiUploadArchivoRespaldoDptal', 'SistemaRemi\IndicadorController@apiUploadArchivoRespaldoDptal');
              Route::post('apiUploadArchivoRespaldoMunic', 'SistemaRemi\IndicadorController@apiUploadArchivoRespaldoMunic');

              Route::post('apiUploadArchivoRespaldoMod', 'SistemaRemi\IndicadorController@apiUploadArchivoRespaldoMod');

              Route::post('apiUploadArchivosRespaldos', 'SistemaRemi\IndicadorController@apiUploadArchivosRespaldos');
              Route::get('apiDeleteArchivo', 'SistemaRemi\IndicadorController@apiDeleteArchivo');

              Route::get('apiDeleteArchivo_s', 'SistemaRemi\IndicadorController@apiDeleteArchivo_s');
              Route::get('apiDeleteArchivo_e', 'SistemaRemi\IndicadorController@apiDeleteArchivo_e');
              Route::get('apiDeleteArchivo_n', 'SistemaRemi\IndicadorController@apiDeleteArchivo_n');
              Route::get('apiDeleteArchivo_d', 'SistemaRemi\IndicadorController@apiDeleteArchivo_d');
              Route::get('apiDeleteArchivo_m', 'SistemaRemi\IndicadorController@apiDeleteArchivo_m');
              Route::get('apiExportData', 'SistemaRemi\ExportReportController@descagarExcelAdminFuente');


              Route::get('apiExportDataindicador', 'SistemaRemi\ExportReportController@descagarExcelAdminIndicador');
              Route::get('filtraPdesEntidad', 'SistemaRemi\IndicadorController@filtraPdesEntidad');


              Route::POST('addPost','SistemaRemi\IndicadorController@addPost');
              Route::POST('editPost','SistemaRemi\IndicadorController@editPost');
              Route::POST('deletePost','SistemaRemi\IndicadorController@deletePost');

          }
      );
      Route::group(
          array('prefix' => 'sistemarime'),
          function() {
              Route::get('setFuenteDatos', 'SistemaRemi\FuenteDatosController@setFuenteDatos');
              Route::get('adminFuenteDatos', 'SistemaRemi\FuenteDatosController@adminFuenteDatos');
              Route::get('setIndicadoresEntidad', 'SistemaRemi\IndicadorController@setIndicadoresEntidad');
              Route::get('generatePdf/{id}','SistemaRemi\IndicadorController@generatePdf');
              Route::get('desagregarTipo/{dato}','SistemaRemi\IndexController@desagregarTipo');
              Route::get('desagregarAvance/{dato}','SistemaRemi\IndexController@desagregarAvance');
              Route::get('desagregarEtapa/{dato}','SistemaRemi\IndexController@desagregarEtapa');
              Route::get('listaIndicadores', 'SistemaRemi\IndexController@listaIndicadores');
          }
      );
      Route::group(
          array('prefix' => 'api/sistemarime'),
          function() {
              //fuente de datos
              Route::get('apiSetListIndicadores', 'SistemaRemi\IndicadorController@apiSetListIndicadores');
              Route::get('apiSetListFuenteDatos', 'SistemaRemi\FuenteDatosController@apiSetListFuenteDatos');
              Route::get('apiSourceOrderbyArray2', 'SistemaRemi\FuenteDatosController@apiSourceOrderbyArray2');
              Route::post('apiSaveFuenteDatos', 'SistemaRemi\FuenteDatosController@apiSaveFuenteDatos');
              Route::post('apiUploadArchivoRespaldo', 'SistemaRemi\FuenteDatosController@apiUploadArchivoRespaldo');
              Route::get('apiDeleteArchivo', 'SistemaRemi\FuenteDatosController@apiDeleteArchivo');

              Route::get('apiDataSetFuente', 'SistemaRemi\FuenteDatosController@apiDataSetFuente');

              Route::get('apiDataSetIndicador', 'SistemaRemi\IndicadorController@apiDataSetIndicador');
              Route::get('descagarExcelMetadatosOnly/{id}', 'SistemaRemi\ExportReportController@descagarExcelMetadatosOnly');


              Route::post('apiRecuperarFuente', 'SistemaRemi\FuenteDatosController@apiRecuperarFuente');
              Route::delete('apiDeleteFuente', 'SistemaRemi\FuenteDatosController@apiDeleteFuente');

              Route::get('apiFiltroGrid', 'SistemaRemi\IndicadorController@apiFiltroGrid');
              Route::get('apiFiltroFuenteDatosGrid', 'SistemaRemi\FuenteDatosController@apiFiltroFuenteDatosGrid');

              Route::get('apiUpdateComboResponsables', 'SistemaRemi\FuenteDatosController@apiUpdateComboResponsables');




          }
      );


});
/*-----------------FIN MODULO RIME----------------------*/

//PLANIFICACION TERRITORIAL
Route::group(['middleware' => 'auth'],function(){
      Route::group(
          array('prefix' => 'planesTerritoriales'),
          function() {
              Route::get('index', 'PlanificacionTerritorial\IndexController@index');
              Route::get('indexseguimiento', 'PlanificacionTerritorial\IndexController@indexseguimiento');
              Route::get('indexevaluacion', 'PlanificacionTerritorial\IndexController@indexevaluacion');

          }
      );
      Route::group(
          array('prefix' => 'api/planesTerritoriales'),
          function() {
              Route::get('datosUsuario', 'PlanificacionTerritorial\IndexController@datosUsuario');
              Route::get('listaTipoRecursos', 'PlanificacionTerritorial\RecursosController@listaTipoRecursos');
              Route::get('listaTipoDeudas', 'PlanificacionTerritorial\DeudasController@listaTipoDeudas');
              Route::get('mapaMunicipio', 'PlanificacionTerritorial\IndexController@mapaMunicipio');
              Route::get('mapaDepartamento', 'PlanificacionTerritorial\IndexController@mapaDepartamento');
              Route::get('verificarEtapa', 'PlanificacionTerritorial\IndexController@verificarEtapa');
              Route::get('verificarEtapaCategoria', 'PlanificacionTerritorial\PlanificacionController@verificarEtapaCategoria');
              Route::get('estadoActualModulos', 'PlanificacionTerritorial\IndexController@estadoActualModulos');
              Route::get('finalizarModulo', 'PlanificacionTerritorial\IndexController@finalizarModulo');
              Route::get('finalizarCategoria', 'PlanificacionTerritorial\PlanificacionController@finalizarCategoria');
              Route::get('categoriasPadreAcciones', 'PlanificacionTerritorial\PlanificacionController@categoriasPadreAcciones');
              Route::get('categoriasHijosAccion', 'PlanificacionTerritorial\PlanificacionController@categoriasHijosAccion');
              Route::get('listaEstructuraProgramaticaIndicadores', 'PlanificacionTerritorial\PlanificacionController@listaEstructuraProgramaticaIndicadores');
              Route::get('listaCatalogoAccionEta', 'PlanificacionTerritorial\PlanificacionController@listaCatalogoAccionEta');
              Route::get('datosCatalogoAccionEta', 'PlanificacionTerritorial\PlanificacionController@datosCatalogoAccionEta');
              Route::get('datosDetalleAccionEta', 'PlanificacionTerritorial\PlanificacionController@datosDetalleAccionEta');
              Route::get('listaObjetivosEtaGenerados', 'PlanificacionTerritorial\PlanificacionController@listaObjetivosEtaGenerados');
              Route::get('datosObjetivoSeleccionado', 'PlanificacionTerritorial\PlanificacionController@datosObjetivoSeleccionado');
              Route::post('activarEtapa', 'PlanificacionTerritorial\IndexController@activarEtapa');
              Route::post('activarCategoria', 'PlanificacionTerritorial\PlanificacionController@activarCategoria');
              Route::post('saveRecursoTipo', 'PlanificacionTerritorial\RecursosController@saveRecursoTipo');
              Route::post('saveUpdateRecursoTipo', 'PlanificacionTerritorial\RecursosController@saveUpdateRecursoTipo');
              Route::post('deleteRecurso', 'PlanificacionTerritorial\RecursosController@deleteRecurso');
              Route::post('saveOtro', 'PlanificacionTerritorial\RecursosController@saveOtro');
              Route::post('saveDeudas', 'PlanificacionTerritorial\DeudasController@saveDeudas');
              Route::post('deleteOtro', 'PlanificacionTerritorial\RecursosController@deleteOtro');
              Route::post('deleteDeuda', 'PlanificacionTerritorial\DeudasController@deleteDeuda');
              Route::post('savePlanificacion', 'PlanificacionTerritorial\PlanificacionController@savePlanificacion');
              Route::post('deleteObjetivo', 'PlanificacionTerritorial\PlanificacionController@deleteObjetivo');


              /***************************************** IRENE JUNIO 2019*************************/
              /*--Recursos*/
              Route::get('listaRecursosGestion', 'PlanificacionTerritorial\SeguimientoController@listaRecursosGestion');
              Route::post('saveUpdateRecursoPoa', 'PlanificacionTerritorial\SeguimientoController@saveUpdateRecursoPoa');

              /*--Acciones*/
              Route::get('listaCategoriaProgramatica', 'PlanificacionTerritorial\SeguimientoAccionesController@listaCategoriaProgramatica');
              Route::post('saveProyectoPoa', 'PlanificacionTerritorial\SeguimientoAccionesController@saveProyectoPoa');
              Route::post('deleteProyPoa', 'PlanificacionTerritorial\SeguimientoAccionesController@deleteProyPoa');
              Route::get('listaObjetivosEta', 'PlanificacionTerritorial\SeguimientoAccionesController@listaObjetivosEta');


              /*----Financiera-----*/

              Route::get('listaAvanceObjetivos', 'PlanificacionTerritorial\FinancieroController@listaAvanceObjetivos');
              Route::post('saveFinancieroPoa', 'PlanificacionTerritorial\FinancieroController@saveFinancieroPoa');
              /*---- Proyectos de Inversion -----*/
              Route::get('listaObjetivosProyectosInversion', 'PlanificacionTerritorial\InversionController@listaObjetivosProyectosInversion');
              Route::post('saveProyectoInversion', 'PlanificacionTerritorial\InversionController@saveProyectoInversion');
              Route::post('saveEntidadesConcurrencia', 'PlanificacionTerritorial\InversionController@saveEntidadesConcurrencia');
              Route::post('updateEntidadesConcurrencia', 'PlanificacionTerritorial\InversionController@updateEntidadesConcurrencia');
              Route::post('deleteEntidad', 'PlanificacionTerritorial\InversionController@deleteEntidad');

              /*--indexSeguimiento*/
              Route::get('estadoActualModulosSeguimiento', 'PlanificacionTerritorial\IndexSeguimientoController@estadoActualModulosSeguimiento');
              Route::get('verificarEtapaSeguimiento', 'PlanificacionTerritorial\IndexSeguimientoController@verificarEtapaSeguimiento');
              Route::post('activarEtapaSeguimiento', 'PlanificacionTerritorial\IndexSeguimientoController@activarEtapaSeguimiento');
              Route::get('finalizarModuloSeguimiento', 'PlanificacionTerritorial\IndexSeguimientoController@finalizarModuloSeguimiento');

              /*--Evaluacion*/
              Route::get('evaluacionListaRecursos', 'PlanificacionTerritorial\EvaluacionController@evaluacionListaRecursos');
              Route::get('evaluacionListaAcciones', 'PlanificacionTerritorial\EvaluacionController@evaluacionListaAcciones');
              Route::get('evaluacionListaFinanciero', 'PlanificacionTerritorial\EvaluacionController@evaluacionListaFinanciero');
              Route::get('evaluacionListaInversion', 'PlanificacionTerritorial\EvaluacionController@evaluacionListaInversion');
              Route::get('evaluacionListaRiesgos', 'PlanificacionTerritorial\EvaluacionController@evaluacionListaRiesgos');
              /*Guardando Reportes*/
              Route::post('saveReporteRecursos', 'PlanificacionTerritorial\EvaluacionController@saveReporteRecursos');
              Route::post('saveReporteFinanciero', 'PlanificacionTerritorial\EvaluacionController@saveReporteFinanciero');

              /*-- Reportes Evaluacion Medio Termino Exportar Excel*/
              Route::get('reporteRecursos', 'PlanificacionTerritorial\ExportReportController@reporteRecursos');
              Route::get('reporteAccionesExcel', 'PlanificacionTerritorial\ExportReportController@reporteAccionesExcel');
              Route::get('reporteFinancieroExcel', 'PlanificacionTerritorial\ExportReportController@reporteFinancieroExcel');
              Route::get('reporteRiesgosExcel', 'PlanificacionTerritorial\ExportReportController@reporteRiesgosExcel');
              Route::get('reporteInversionExcel', 'PlanificacionTerritorial\ExportReportController@reporteInversionExcel');

              /*-- seleccion Gestiones*/
              Route::get('cargarGestiones', 'PlanificacionTerritorial\IndexSeguimientoController@cargarGestiones');
              Route::get('cambiarVista', 'PlanificacionTerritorial\IndexSeguimientoController@cambiarVista');

              /*-- Reportes Evaluacion Gestion Excel*/
              Route::get('reporteRecursosGestionExcel', 'PlanificacionTerritorial\ExportReportGestionController@reporteRecursosGestionExcel');
              Route::get('reporteAccionesGestionExcel', 'PlanificacionTerritorial\ExportReportGestionController@reporteAccionesGestionExcel');
              Route::get('reporteFinancieroGestionExcel', 'PlanificacionTerritorial\ExportReportGestionController@reporteFinancieroGestionExcel');
              Route::get('reporteInversionGestionExcel', 'PlanificacionTerritorial\ExportReportGestionController@reporteInversionGestionExcel');
              /*-- Reportes Evaluacion Gestion Pdf*/
              Route::get('reporteRecursosGestionPdf', 'PlanificacionTerritorial\ExportReportGestionPdfController@reporteRecursosGestionPdf');
              Route::get('reporteAccionesGestionPdf', 'PlanificacionTerritorial\ExportReportGestionPdfController@reporteAccionesGestionPdf');
              Route::get('reporteFinancieroGestionPdf', 'PlanificacionTerritorial\ExportReportGestionPdfController@reporteFinancieroGestionPdf');
              Route::get('reporteInversionGestionPdf', 'PlanificacionTerritorial\ExportReportGestionPdfController@reporteInversionGestionPdf');
              /*-- Reportes Evaluacion Medio Termino Pdf*/
              Route::get('reporteRecursosMedioPdf', 'PlanificacionTerritorial\ExportReportMedioPdfController@reporteRecursosMedioPdf');
              Route::get('reporteAccionesMedioPdf', 'PlanificacionTerritorial\ExportReportMedioPdfController@reporteAccionesMedioPdf');
              Route::get('reporteFinancieroMedioPdf', 'PlanificacionTerritorial\ExportReportMedioPdfController@reporteFinancieroMedioPdf');
              Route::get('reporteInversionMedioPdf', 'PlanificacionTerritorial\ExportReportMedioPdfController@reporteInversionMedioPdf');
              Route::get('reporteRiesgosMedioPdf', 'PlanificacionTerritorial\ExportReportMedioPdfController@reporteRiesgosMedioPdf');


              /*-- entidades Ejecutoras*/
              Route::get('listaEntidadesEjecutoras', 'PlanificacionTerritorial\InversionController@listaEntidadesEjecutoras');

              /*******************************FIN IRENE JUNIO 2019*************************/



          }
      );
});
