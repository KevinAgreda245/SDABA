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
        $inventarios = Inventario::where('ESTADO_ACTIVO_INVENTARIO', '1')
            ->join('producto', 'inventario.ID_PRODUCTO', '=', 'producto.ID_PRODUCTO')
            ->paginate(10);
        return view('inventario.index', compact('inventarios'));
    }
}
