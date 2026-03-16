<?php

use Illuminate\Support\Facades\Route;

// Auth
Route::get('/',        'AuthController@showLoginForm')->name('login');
Route::post('/login',  'AuthController@login'        )->name('login.post');
Route::post('/logout', 'AuthController@logout'       )->name('logout');

// App — requiere autenticacion
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',        'DashboardController@index'  )->name('dashboard');

    // CFDI / XML
    Route::get('/cfdi',             'CfdiController@index'       )->name('cfdi.index');
    Route::get('/cfdi/{id}',        'CfdiController@show'        )->name('cfdi.show');

    // Operaciones
    Route::get('/operaciones',             'OperacionesController@index'         )->name('operaciones.index');
    Route::get('/operaciones/depositos',   'OperacionesController@depositos'     )->name('operaciones.depositos');
    Route::get('/operaciones/reembolsos',  'OperacionesController@reembolsos'    )->name('operaciones.reembolsos');

    // Contabilidad
    Route::get('/contabilidad',            'ContabilidadController@index'        )->name('contabilidad.index');

    // Reportes
    Route::get('/reportes',                'ReportesController@index'            )->name('reportes.index');

    // Clientes
    Route::get('/clientes',                'ClientesController@index'            )->name('clientes.index');
    Route::get('/clientes/{id}',           'ClientesController@show'             )->name('clientes.show');

    // Notificaciones
    Route::get('/notificaciones',          'NotificacionesController@index'      )->name('notificaciones.index');

    // Admin (solo rol 1) - usar middleware esAdmin registrado en Kernel
    Route::middleware(['esAdmin'])->group(function () {
        Route::get('/admin',               'AdminController@index'               )->name('admin.index');
        Route::get('/admin/empleados',     'AdminController@empleados'           )->name('admin.empleados');
        Route::get('/admin/clientes',      'AdminController@clientes'            )->name('admin.clientes');
    });
});