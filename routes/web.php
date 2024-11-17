<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrdenProductoController;
use App\Http\Controllers\TipoProductoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/main', [MainController::class, 'index'])->name('main');
Route::resource('tipoProducto', TipoProductoController::class);
Route::resource('inventario', InventarioController::class);

Route::resource('ordenProducto', OrdenProductoController::class);
Route::get('/ordenProducto/{id}/imprimir', [OrdenProductoController::class, 'imprimir'])->name('ordenes.imprimir');

Route::resource('proveedor', ProveedorController::class);
Route::get('/proveedor/{id}/editAssign', [ProveedorController::class, 'editAssign'])->name('proveedor.editAssign');
Route::put('/proveedor/{id}/updateAssign', [ProveedorController::class, 'updateAssign'])->name('proveedor.updateAssign');
Route::get('/producto/{id}/preferredSupplier', [ProveedorController::class, 'getPreferredSuplier'])->name('proveedor.getPreferredSuplier');
Route::resource('producto', ProductoController::class);

