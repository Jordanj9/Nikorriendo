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

//TODOS LOS MENUS
//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('usuarios', 'MenuController@usuarios')->name('admin.usuarios');
    Route::get('estructura', 'MenuController@estructura')->name('admin.estructura');
    Route::get('servicio', 'MenuController@servicio')->name('admin.servicio');
    Route::get('mantenimiento', 'MenuController@mantenimiento')->name('admin.mantenimiento');
    Route::post('acceso', 'HomeController@confirmaRol')->name('rol');
    Route::get('inicio', 'HomeController@inicio')->name('inicio');
//    Route::get('auditoria', 'MenuController@auditoria')->name('admin.auditoria');
});

//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN DE USUARIOS
Route::group(['middleware' => 'auth', 'prefix' => 'usuarios'], function() {
    //MODULOS
    Route::resource('modulo', 'ModuloController');
    //PAGINAS O ITEMS DE LOS MODULOS
    Route::resource('pagina', 'PaginaController');
    //GRUPOS DE USUARIOS
    Route::resource('grupousuario', 'GrupousuarioController');
    Route::get('grupousuario/{id}/delete', 'GrupousuarioController@destroy')->name('grupousuario.delete');
    Route::get('privilegios', 'GrupousuarioController@privilegios')->name('grupousuario.privilegios');
    Route::get('grupousuario/{id}/traerdata/privilegios', 'GrupousuarioController@getPrivilegios');
    Route::post('grupousuario/privilegios', 'GrupousuarioController@setPrivilegios')->name('grupousuario.guardar');
    //USUARIOS
    Route::resource('usuario', 'UsuarioController');
    Route::get('usuario/{id}/delete', 'UsuarioController@destroy')->name('usuario.delete');
    Route::post('operaciones', 'UsuarioController@operaciones')->name('usuario.operaciones');
    Route::post('usuario/contrasenia/cambiar/admin/finalizar', 'UsuarioController@cambiarPass')->name('usuario.cambiarPass');
});

//GRUPO DE RUTAS PARA LA ESTRUCTURA DE LA EMPRESA
Route::group(['middleware' => 'auth', 'prefix' => 'estructura'], function() {
    //SUCURSALES
    Route::resource('sucursal', 'SucursalController');
    //BODEGAS
    Route::resource('bodega', 'BodegaController');
    //LAVADORAS
    Route::resource('lavadora', 'LavadoraController');
    //EMPLLEADOS
    Route::resource('persona', 'PersonaController');
    //ASIGNAR LAVADORA EMPLEADO
    Route::resource('lavadora_persona', 'LavadoraPersonaController');
    Route::get('lavadora_persona/{id}/asignadas', 'LavadoraPersonaController@getAsignadas');
    Route::post('lavadora_persona/asignadas', 'LavadoraPersonaController@setAsignadas')->name('lavadora_persona.guardar');
});

//GRUPO DE RUTAS PARA LA GESTION DE LOS SERVICIOS
Route::group(['middleware' => 'auth', 'prefix' => 'servicio'], function() {
    //SERVICIOS
});

//GRUPO DE RUTAS PARA LA GESTION DE LOS MANTENIMIENTOS DE LAS LAVADORAS DE LA EMPRESA
Route::group(['middleware' => 'auth', 'prefix' => 'mantenimiento'], function() {
    //REPUESTOS
    Route::resource('repuesto', 'RepuestoController');
    //MANTENIMIENTOS
    Route::resource('mantenimiento', 'MantenimientoController');
});
