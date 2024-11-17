<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Inventario;
use App\Models\OrdenCompra;

class MainController extends Controller
{
    public function index()
    {
        // Obtener el conteo de productos
        $cantidadProductos = Producto::count();

        // Obtener la cantidad de órdenes registradas (ID_ESTADO_ORDEN = 1)
        $cantidadOrdenesRegistradas = OrdenCompra::where('ID_ESTADO_ORDEN', 1)->count();

        // Obtener la cantidad de órdenes pendientes de finalizar (ID_ESTADO_ORDEN = 2)
        $cantidadOrdenesPendientes = OrdenCompra::where('ID_ESTADO_ORDEN', 2)->count();

        // Obtener los 15 productos con menos cantidad en inventario
        $productosConMenosInventario = Inventario::with('producto')
            ->where('ESTADO_ACTIVO_INVENTARIO', 1)  // Filtrar por productos activos
            ->orderBy('CANTIDAD_INVENTARIO', 'asc') // Ordenar por cantidad de inventario
            ->limit(15)
            ->get();

        // Obtener la cantidad de productos por tipo de producto
        $productosPorTipo = Producto::with('tipoProducto')
            ->selectRaw('ID_TIPO_PRODUCTO, COUNT(*) as cantidad')
            ->groupBy('ID_TIPO_PRODUCTO')
            ->get();
    
        return view('main.index', compact('cantidadProductos', 'cantidadOrdenesRegistradas', 'cantidadOrdenesPendientes','productosConMenosInventario','productosPorTipo'));
    }
}
