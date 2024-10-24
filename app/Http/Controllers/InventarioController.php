<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        // select * from inventario as inv  join producto where inv.ESTADO_ACTIVO_INVENTARIO = true;
        $inventarios = Inventario::where('ESTADO_ACTIVO_INVENTARIO', true)->join('producto', 'inventario.ID_PRODUCTO', '=', 'producto.ID_PRODUCTO')->get();
        return view('inventario.index', compact('inventarios'));
        return view('inventario.index');
    }
}
