<?php

namespace App\Http\Controllers;


use App\Models\DetalleOrdenCompra;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\OrdenCompra;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrdenProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Órdenes pendientes
        $ordenesPendientes = OrdenCompra::with('proveedor', 'estadoOrden')
        ->whereIn('ID_ESTADO_ORDEN', [1, 2])
        ->get();

        // Órdenes procesadas/denegadas
        $ordenesProcesadas = OrdenCompra::with('proveedor', 'estadoOrden')
        ->whereIn('ID_ESTADO_ORDEN', [3, 4])
        ->get();
        
        return view('ordenProducto.index',compact('ordenesPendientes', 'ordenesProcesadas'));
    }

    public function create() {
        //obtener los proveedores del producto
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        return view('ordenProducto.create',compact('productos', 'proveedores'));
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'proveedor' => 'required',
            'productos' => 'required|json',
        ]);

        try {
            // Crear la orden de compra
            $ordenCompra = OrdenCompra::create([
                'ID_PROVEEDOR' => $request->proveedor,
                'ID_ESTADO_ORDEN' => 1, 
                'FECHA_COMPRA' => Carbon::today(), // Solo la fecha (sin hora)
                'USUARIO_ORDEN_COMPRA' => Auth::user()->USER_USUARIO,
            ]);

            // Decodificar los productos seleccionados
            $productos = json_decode($request->productos, true);

            // Crear los detalles de la orden
            foreach ($productos as $producto) {
                DetalleOrdenCompra::create([
                    'ID_ORDEN_COMPRA' => $ordenCompra->ID_ORDEN_COMPRA,
                    'ID_PRODUCTO' => $producto['producto_id'],
                    'CANTIDAD_PRODUCTO' => $producto['cantidad'],
                    'COSTO_PRODUCTO' => $producto['costo'],
                    'PRECIO_PRODUCTO' => $producto['precio'],
                    'FREG_ORDEN_COMPRA' => now(), // Fecha de creación
                    'USUARIO_ORDEN_COMPRA' => Auth::user()->USER_USUARIO,
                ]);
            }

            return redirect()->route('ordenProducto.index')
                ->with('success', 'Orden de compra creada exitosamente.');

        } catch (\Exception $e) {

            return redirect()->back()
                ->withErrors(['error' => 'Ocurrió un error al guardar la orden de compra: ' . $e->getMessage()]);
        }
    }

    //create get method
    public function create2(Inventario $inventario)
    {
        //obtener los proveedores del producto
        $proveedores = Proveedor::all();
        // dd($proveedores);
        return view('pedirProducto.create', compact('inventario', 'proveedores'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Carga la orden con los detalles y el proveedor relacionado
        $orden = OrdenCompra::with(['detalles.producto', 'proveedor'])
        ->findOrFail($id);
        return view('ordenProducto.show',compact('orden'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    public function imprimir($id)
{
    $orden = OrdenCompra::with(['proveedor', 'detalles.producto'])->findOrFail($id);

    // Generar el PDF usando una vista
    $pdf = Pdf::loadView('ordenProducto.print', compact('orden'));

    // Retornar el PDF como descarga o para mostrarlo
    return $pdf->stream('Orden_Compra_' . str_pad($orden->ID_ORDEN_COMPRA, 5, '0', STR_PAD_LEFT) . '.pdf');
}

// Autorizar la orden
public function autorizar($id)
{
    $orden = OrdenCompra::findOrFail($id);
    $orden->ID_ESTADO_ORDEN = 2; // Cambia el estado a "Autorizada"
    $orden->save();

    return redirect()->route('ordenProducto.index')->with('success', 'Orden autorizada correctamente.');
}

// Denegar la orden
public function denegar($id)
{
    $orden = OrdenCompra::findOrFail($id);
    $orden->ID_ESTADO_ORDEN = 3; // Cambia el estado a "Denegada"
    $orden->save();

    return redirect()->route('ordenProducto.index')->with('error', 'Orden denegada correctamente.');
}

public function finalizar($id)
    {
        // Obtener la orden de compra
        $orden = OrdenCompra::findOrFail($id);
        
        // Cambiar el estado de la orden a "Finalizada"
        $orden->ID_ESTADO_ORDEN = 4; // Estado de finalizada
        // Asignar la fecha de hoy como fecha de entrega
        $orden->FECHA_ENTREGA = Carbon::today(); // Solo la fecha (sin hora)
        $orden->save();

        // Recorrer los productos de la orden de compra y actualizar el inventario
        foreach ($orden->detalles as $producto) {
            // Buscar el inventario del producto
            $inventario = Inventario::where('id_producto', $producto->ID_PRODUCTO)->first();

            // Si el producto no tiene inventario, lo creamos
            if (!$inventario) {
                $inventario = new Inventario();
                $inventario->ID_PRODUCTO = $producto->ID_PRODUCTO;
                $inventario->CANTIDAD_INVENTARIO = 0;
                $inventario->PRECIO_INVENTARIO = $producto->PRECIO_PRODUCTO;
                $inventario->COSTO_INVENTARIO = $producto->COSTO_PRODUCTO;
            }

            // Aumentar la cantidad de inventario
            $inventario->CANTIDAD_INVENTARIO += $producto->CANTIDAD_PRODUCTO;

            // Calcular el costo promedio
            $totalCosto = ($inventario->COSTO_INVENTARIO * $inventario->CANTIDAD_INVENTARIO) + ($producto->COSTO_PRODUCTO * $producto->CANTIDAD_PRODUCTO);
            $totalCantidad = $inventario->CANTIDAD_INVENTARIO + $producto->CANTIDAD_PRODUCTO;
            $inventario->COSTO_INVENTARIO = $totalCosto / $totalCantidad;

            // Actualizar el precio del inventario con el precio de la orden
            $inventario->PRECIO_INVENTARIO = $producto->PRECIO_PRODUCTO;

            // Guardar los cambios en el inventario
            $inventario->save();
        }

        return redirect()->route('ordenProducto.index')->with('success', 'Orden finalizada y inventario actualizado correctamente.');
    }
}
