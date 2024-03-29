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
Route::get('usuarios/contrasenia/cambiar', 'UsuarioController@vistacontrasenia')->name('usuario.vistacontrasenia');
Route::post('usuarios/contrasenia/cambiar/finalizar', 'UsuarioController@cambiarcontrasenia')->name('usuario.cambiarcontrasenia');
Route::post('usuario/contrasenia/cambiar/admin/finalizar', 'UsuarioController@cambiarPass')->name('usuario.cambiarPass');

//TODOS LOS MENUS
//GRUPO DE RUTAS PARA LA ADMINISTRACIÓN
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('usuarios', 'MenuController@usuarios')->name('admin.usuarios');
    Route::get('estructura', 'MenuController@estructura')->name('admin.estructura');
    Route::get('servicio', 'MenuController@servicio')->name('admin.servicio');
    Route::get('mantenimiento', 'MenuController@mantenimiento')->name('admin.mantenimiento');
    Route::get('reporte', 'MenuController@reporte')->name('admin.reporte');
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
    //BARRIOS
    Route::resource('barrio', 'BarrioController');
    //CLIENTES
    Route::resource('cliente','ClienteController');

});

//GRUPO DE RUTAS PARA LA GESTION DE LOS SERVICIOS
Route::group(['middleware' => 'auth', 'prefix' => 'servicio'], function() {
    //SERVICIOS
    Route::resource('servicio', 'ServicioController');
    Route::get('servicio/{telefono}/getcliente', 'ServicioController@getClientes')->name('servicio.getclientes');
    Route::get('getServiciosPendientes', 'ServicioController@getServiciosPendientes')->name('servicio.getServiciosPendientes');
    Route::get('aceptar_servicio/{id}', 'ServicioController@aceptarServicio')->name('servicio.aceptarServicio');
    Route::get('aceptar_servicioJSON/{id}', 'ServicioController@aceptarServicioJSON')->name('servicio.aceptarServicioJSON');
    Route::get('getServiciosPorEntregar', 'ServicioController@getServiciosPorEntregar')->name('servicio.getServiciosPorEntregar');
    Route::get('entregarServicio/{id}', 'ServicioController@entregarServicio')->name('servicio.entregarServicio');
    Route::get('getServiciosPorRecoger', 'ServicioController@getServiciosPorRecoger')->name('servicio.getServiciosPorRecoger');
    Route::post('guardarRecogida', 'ServicioController@guardarRecogida')->name('servicio.guardarRecogida');
    Route::post('guardarEntrega', 'ServicioController@guardarEntrega')->name('servicio.guardarEntrega');
    Route::get('recogerServicio/{id}', 'ServicioController@recogerServicio')->name('servicio.recogerServicio');
    Route::get('liberar_servicio/{id}', 'ServicioController@liberarServicio')->name('servicio.liberarServicio');
    Route::post('permiso', 'ServicioController@permiso')->name('servicio.permiso');
    Route::get('cambiorecoger/{servicio}', 'ServicioController@cambiorecoger')->name('servicio.cambiorecoger');
    Route::post('servicio_observacion', 'ServicioController@guardarObservacion')->name('servicio.observacion');
    //SOLICITUD CAMBIOS
    Route::resource('solicitud', 'SolicitudcambioController');
    Route::get('solicitud/cambio/{id}', 'SolicitudcambioController@solicitudCambio')->name('solicitud.solicitudcambio');
    Route::get('solicitud/cambio/{id}/entregar', 'SolicitudcambioController@entregarCambio')->name('solicitud.entregarCambio');
    Route::post('solicitud/guardarCambio', 'SolicitudcambioController@guardarCambio')->name('solicitud.guardarcambio');
    //PERMISO
    Route::resource('permiso', 'PermisoController');
    //GEOLOCALIZACION
    Route::get('show_mapa', 'ServicioController@showSeriviciosEnMapa')->name('servicio.showSeriviciosEnMapa');
    Route::get('show_mapa/{id}', 'ServicioController@showSeriviciosEnMapa')->name('servicio.showSeriviciosEnMapa');
    Route::get('getServiciosPorRecogerJSON', 'ServicioController@getServiciosPorRecogerJSON')->name('servicio.getServiciosPorRecogerJSON');
    Route::get('getServiciosPorEntregarJSON', 'ServicioController@getServiciosPorEntregarJSON')->name('servicio.getServiciosPorEntregarJSON');
    Route::get('getServiciosEntregadosJSON', 'ServicioController@getServiciosEntregadosJSON')->name('servicio.getServiciosEntregadosJSON');
    Route::get('show_servicios', 'ServicioController@showServicios')->name('servicio.showServicios');
});

//GRUPO DE RUTAS PARA LA GESTION DE LOS MANTENIMIENTOS DE LAS LAVADORAS DE LA EMPRESA
Route::group(['middleware' => 'auth', 'prefix' => 'mantenimiento'], function() {
    //REPUESTOS
    Route::resource('repuesto', 'RepuestoController');
    //MANTENIMIENTOS
    Route::resource('mantenimiento', 'MantenimientoController');
    Route::post('mantenimiento/guardarMantenimiento', 'MantenimientoController@store2')->name('mantenimiento.store2');
});

//GRUPO DE RUTAS PARA LA GESTIÓN DE REPORTES
Route::group(['middleware' => 'auth', 'prefix' => 'reporte'], function() {
    //REPORTE GENERAL
    Route::get('servicio/general', 'ReporteController@reporteGeneral')->name('reporte.general');
    Route::get('servicio/{sucursal_id}/getpersonas', 'ReporteController@getPersonas')->name('reporte.getpersonas');
    Route::get('servicio/{perosona_id}/getlavadoras', 'ReporteController@getLavadoras')->name('reporte.getlavadoras');
    Route::get('servicio/general/{estado}/{fechai}/{fechaf}/{sucursal_id}/{perosona_id}/{lavadora_id}/getservicios', 'ReporteController@getServicios')->name('reporte.getservicios');
});
