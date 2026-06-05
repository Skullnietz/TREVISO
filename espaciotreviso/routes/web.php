<?php

use Illuminate\Support\Facades\Route;

// =============================================
// Portal Cliente
// =============================================
Route::get('/login', 'Cliente\AuthController@showLoginForm')->name('cliente.login');
Route::post('/login', 'Cliente\AuthController@login')->name('cliente.login.post');
Route::post('/logout', 'Cliente\AuthController@logout')->name('cliente.logout');

Route::middleware('auth')->group(function () {
    Route::get('/', 'Cliente\DashboardController@index')->name('cliente.dashboard');

    // Facturas por categoria
    Route::get('/facturas/ingresos', 'Cliente\FacturaController@ingresos')->name('cliente.facturas.ingresos');
    Route::get('/facturas/egresos', 'Cliente\FacturaController@egresos')->name('cliente.facturas.egresos');
    Route::get('/facturas/notas-credito', 'Cliente\FacturaController@notasCredito')->name('cliente.facturas.notas_credito');
    Route::get('/facturas/banco', 'Cliente\FacturaController@banco')->name('cliente.facturas.banco');
    Route::get('/facturas/{cfdi}', 'Cliente\FacturaController@show')->name('cliente.facturas.show');
    Route::get('/facturas/{cfdi}/xml', 'Cliente\FacturaController@downloadXml')->name('cliente.facturas.download');

    // Pagos (complementos)
    Route::get('/pagos', 'Cliente\FacturaController@pagos')->name('cliente.pagos');

    // Nominas
    Route::get('/nominas', 'Cliente\FacturaController@nominas')->name('cliente.nominas');

    // Observaciones
    Route::get('/observaciones', 'Cliente\ObservacionController@index')->name('cliente.observaciones');
    Route::post('/observaciones', 'Cliente\ObservacionController@store')->name('cliente.observaciones.store');
});

// =============================================
// Portal Admin
// =============================================
Route::prefix('admin')->group(function () {
    Route::get('/login', 'Admin\AuthController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Admin\AuthController@login')->name('admin.login.post');
    Route::post('/logout', 'Admin\AuthController@logout')->name('admin.logout');

    Route::middleware('auth.admin')->group(function () {
        Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');

        // Clientes
        Route::resource('clientes', 'Admin\ClienteController')->names('admin.clientes')->except(['show']);
        Route::post('clientes/{cliente}/efirma', 'Admin\ClienteController@uploadEfirma')->name('admin.clientes.efirma.upload');
        Route::delete('clientes/{cliente}/efirma', 'Admin\ClienteController@removeEfirma')->name('admin.clientes.efirma.remove');
        Route::post('clientes/{cliente}/acceso', 'Admin\ClienteController@crearAcceso')->name('admin.clientes.acceso');

        // Facturas
        Route::get('facturas', 'Admin\CfdiController@index')->name('admin.facturas.index');
        Route::get('facturas/{cfdi}', 'Admin\CfdiController@show')->name('admin.facturas.show');
        Route::put('facturas/{cfdi}/pago', 'Admin\CfdiController@actualizarPago')->name('admin.facturas.pago');
        Route::post('facturas/{cfdi}/observacion', 'Admin\CfdiController@responderObservacion')->name('admin.facturas.observacion');
        Route::get('facturas/{cfdi}/xml', 'Admin\CfdiController@downloadXml')->name('admin.facturas.download');

        // Descargas SAT
        Route::get('descargas', 'Admin\DescargaController@index')->name('admin.descargas.index');
        Route::post('descargas/solicitar', 'Admin\DescargaController@solicitar')->name('admin.descargas.solicitar');
    });
});
