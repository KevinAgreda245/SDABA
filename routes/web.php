<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\DespachoController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrdenProductoController;
use App\Http\Controllers\TipoProductoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); 
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware(['auth'])->group(function () {
    Route::get('/main', [MainController::class, 'index'])->name('main');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('tipoProducto', TipoProductoController::class);
    Route::resource('inventario', InventarioController::class);

    Route::resource('ordenProducto', OrdenProductoController::class);
    Route::get('/ordenProducto/{id}/imprimir', [OrdenProductoController::class, 'imprimir'])->name('ordenes.imprimir');
    Route::get('/ordenProducto/{id}/autorizar', [OrdenProductoController::class, 'autorizar'])->name('ordenProducto.autorizar');
    Route::get('/ordenProducto/{id}/denegar', [OrdenProductoController::class, 'denegar'])->name('ordenProducto.denegar');
    Route::get('/orden-producto/{id}/finalizar', [OrdenProductoController::class, 'finalizar'])->name('ordenProducto.finalizar');

    Route::resource('proveedor', ProveedorController::class);
    Route::get('/proveedor/{id}/editAssign', [ProveedorController::class, 'editAssign'])->name('proveedor.editAssign');
    Route::put('/proveedor/{id}/updateAssign', [ProveedorController::class, 'updateAssign'])->name('proveedor.updateAssign');
    Route::get('/producto/{id}/preferredSupplier', [ProveedorController::class, 'getPreferredSuplier'])->name('proveedor.getPreferredSuplier');
    Route::get('/proveedor/{proveedorId}/productos', [ProveedorController::class, 'getProductosPorProveedor']);

    Route::resource('producto', ProductoController::class);
    Route::get('/producto/{productoId}/proveedor/{proveedorId}', [ProveedorController::class, 'getInfo']);

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reporte.index');
    Route::get('/reportes/generar', [ReporteController::class, 'generarReporte'])->name('reporte.generar');

    Route::resource('usuario', UsuarioController::class); 
    Route::get('usuario/{usuario}/password', [UsuarioController::class, 'editPassword'])->name('usuario.password.edit');
    Route::put('usuario/{usuario}/password', [UsuarioController::class, 'updatePassword'])->name('usuario.password.update');
    
    Route::resource('despacho', DespachoController::class);
    Route::get('/despacho/{id}/pdf', [DespachoController::class, 'generatePdf'])->name('despacho.pdf');
});

