<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::where('ESTADO_ACTIVO_INVENTARIO', true)
            ->whereColumn('producto.MINIMO_PRODUCTO', '>=', 'inventario.CANTIDAD_INVENTARIO')
            ->join('producto', 'inventario.ID_PRODUCTO', '=', 'producto.ID_PRODUCTO')
            ->get();
        return view('inventario.index', compact('inventarios'));

        
    }
}
