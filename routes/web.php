<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\IndexController;

Route::get('/', [IndexController::class, 'index']);

use App\Http\Controllers\DonacionController;

//Configuracion de Rutas
Route::get('/FormularioDonacion', [DonacionController::class, 'formulario'])->name('donacion.formulario');
Route::post('/FormularioDonacion', [DonacionController::class, 'procesar'])->name('donacion.procesar');
Route::get('/FormularioDonacion', [DonacionController::class, 'mostrarFormulario'])->name('donacion.formulario');

//Pagina de prueba de autenticacion
Route::get('/protegido', function () {
    return 'Acceso concedido';
})->middleware('adminAuth');

use App\Http\Controllers\Admin\DashboardController;

// Grupo protegido por auth básica
Route::middleware('adminAuth')->group(function () {
    Route::get('/admin/donaciones', [DashboardController::class, 'index'])->name('admin.donaciones');
});

Route::get('/asociar-tarjeta', [DonacionController::class, 'asociarTarjeta']);

Route::get('/crear-cliente', [DonacionController::class, 'crearCliente']);









