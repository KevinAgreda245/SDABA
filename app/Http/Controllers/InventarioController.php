<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::where('ESTADO_ACTIVO_INVENTARIO', true)
            ->whereColumn('producto.MINIMO_PRODUCTO', '>=', 'inventario.CANTIDAD_INVENTARIO')
            ->join('producto', 'inventario.ID_PRODUCTO', '=', 'producto.ID_PRODUCTO')
            ->get();
        $usuario = Auth::user();
        Log::info($usuario);
        return view('inventario.index', compact('inventarios'));
    }
}
