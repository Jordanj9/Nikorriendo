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
//    Route::get('feligresia', 'MenuController@feligresia')->name('admin.feligresia');
//    Route::get('situacion', 'MenuController@situacion')->name('admin.situacion');
//    Route::post('menuexperiencia/operaciones/consultar/traer', 'MenuController@operaciones')->name('admin.operaciones');
//    Route::get('experienciafeligres/cosultar/ir', 'MenuController@experienciafeligres')->name('admin.experienciafeligres');
    Route::post('acceso', 'HomeController@confirmaRol')->name('rol');
//    Route::get('inicio', 'HomeController@inicio')->name('inicio');
//    Route::get('gestiondocumental', 'MenuController@gestiondocumental')->name('admin.gestiondocumental');
//    Route::get('comunicacion', 'MenuController@comunicacion')->name('admin.comunicacion');
//    Route::get('editorial', 'MenuController@editorial')->name('admin.editorial');
//    Route::get('institucional', 'MenuController@institucional')->name('admin.institucional');
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
    Route::get('grupousuario/{id}/privilegios', 'GrupousuarioController@getPrivilegios');
    Route::post('grupousuario/privilegios', 'GrupousuarioController@setPrivilegios')->name('grupousuario.guardar');
    //USUARIOS
    Route::resource('usuario', 'UsuarioController');
    Route::get('usuario/{id}/delete', 'UsuarioController@destroy')->name('usuario.delete');
    Route::post('operaciones', 'UsuarioController@operaciones')->name('usuario.operaciones');
    Route::post('usuario/contrasenia/cambiar/admin/finalizar', 'UsuarioController@cambiarPass')->name('usuario.cambiarPass');
});
