<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrdenProductoController;
use App\Http\Controllers\TipoProductoController;
use App\Http\Controllers\ProductoController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/main', [MainController::class, 'index'])->name('main');
Route::resource('tipoProducto', TipoProductoController::class);
Route::resource('inventario', InventarioController::class);
// Route::resource('ordenProducto', OrdenProductoController::class);
// ruta que recibe el producto y lo manda a la vista
Route::get('ordenProducto/{inventario}', [OrdenProductoController::class, 'create'])->name('ordenProducto.create');
// ruta que recibe el producto y lo manda a la vista
Route::post('ordenProducto', [OrdenProductoController::class, 'store'])->name('ordenProducto.store');