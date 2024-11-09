<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class MainController extends Controller
{
    public function index()
    {
        // Obtener el conteo de productos
        $cantidadProductos = Producto::count();
        return view('main.index', compact('cantidadProductos'));
    }
}
