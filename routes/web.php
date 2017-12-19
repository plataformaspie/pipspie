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
              Route::get('tablero2', 'ModuloPriorizacion\TableroController@index2');
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
              Route::get('datosVariableEstadistica', 'ModuloPriorizacion\TableroController@datosVariableEstadistica');
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
              /* OJO   --- NO EJECUTAR   Funcion para vincular los proyectos y Resultados del SP en la base postgres realiza un insert masivo, sobreescribiendo los datos */
              Route::get('gestionproyectos/sp/insetar_resultados_proyectos_pdes',  'ModuloPdes\GestionProyectosController@insertarResultadosProyectosPdes');
              Route::get('gestionproyectos/sp/obtener_proyecto_sp/{codigo}',  'ModuloPdes\GestionProyectosController@obtenerProyectoSP');


		  }
      );
});
