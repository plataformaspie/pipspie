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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'],function(){
      Route::group(
          array('prefix' => 'administration'),
          function() {
              Route::get('dashboard', 'ModuloAdministracion\DashboardController@index');
          }
      );
      Route::group(
          array('prefix' => 'administration/ajax'),
          function() {
              Route::get('prueba', 'ModuloAdministracion\DashboardController@index');
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

          }
      );
});
