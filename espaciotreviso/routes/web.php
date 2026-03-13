<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'AuthController@showLoginForm')->name('login');
Route::post('/login', 'AuthController@login')->name('login.post');
Route::post('/logout', 'AuthController@logout')->name('logout');

// Basic module routes (Admin, Auth, etc)
Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', function() {
        return "¡Login Exitoso! Estás autenticado como: " . auth()->user()->NickUsuarioEmpleado;
    })->name('dashboard')->middleware('auth');
    Route::resource('cfdi', 'CfdiController');
    Route::resource('operations', 'OperationsController');
    Route::resource('accounting', 'AccountingController');
    Route::resource('reports', 'ReportsController');
    Route::resource('clients', 'ClientsController');
    Route::resource('staff', 'StaffController');
    Route::resource('notifications', 'NotificationsController');
    Route::resource('admin', 'AdminController');
    Route::resource('sync', 'SyncController');
});
