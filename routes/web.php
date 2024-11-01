<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\TipoProductoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/main', [MainController::class, 'index'])->name('main');
Route::resource('tipoProducto', TipoProductoController::class);
Route::resource('inventario', InventarioController::class);
Route::resource('proveedor', ProveedorController::class);