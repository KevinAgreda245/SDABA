<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\OrdenCompra;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    // Mostrar el índice de reportes
    public function index()
    {
        return view('reporte.index');
    }

    public function generarReporte(Request $request)
    {
        $tipoReporte = $request->input('reporte_tipo');

        if ($tipoReporte == 'inventario') {
            // Obtener los datos para el reporte de inventarios
            $inventarios = Inventario::with('producto')->get();  // Aquí obtienes todos los inventarios con la relación de productos
            // Generar el PDF usando una vista
            $pdf = Pdf::loadView('reporte.inventario', compact('inventarios'));
            
            // Retornar el PDF como descarga o para mostrarlo
            return $pdf->stream('Inventario.pdf');
        }

        if ($tipoReporte == 'orden') {
            // Obtener las órdenes de compra y sus detalles
            $ordenes = OrdenCompra::with(['detalles', 'proveedor'])->get();  // Obtienes todas las órdenes con sus detalles y proveedores
            // Generar el PDF usando una vista
            $pdf = Pdf::loadView('reporte.orden', compact('ordenes'));
            return $pdf->stream('OrdenCompra.pdf');
        }

        // Si el tipo de reporte no coincide, redirigir con un error
        return redirect()->route('reportes.index')->withErrors('Tipo de reporte no válido.');
    }
}
