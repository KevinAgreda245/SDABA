<?php

namespace App\Http\Controllers;

use App\Models\Despacho;
use App\Models\DetalleDespacho;
use App\Models\Producto;
use App\Models\OrdenCompra;
use App\Models\DetalleOrdenCompra;
use App\Models\Inventario;
use App\Models\User;
use App\Models\DetalleProveedor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DespachoController extends Controller
{
    /**
     * Mostrar la lista de despachos.
     */
    public function index()
    {
        $despachos = Despacho::with('usuario')->get();
        return view('despacho.index', compact('despachos'));
    }

    /**
     * Mostrar el formulario para crear un despacho.
     */
    public function create()
    {
        $usuarios = User::all();
        $productos = Inventario::where('ESTADO_ACTIVO_INVENTARIO', 1) // Solo los productos activos
        ->with('producto') // Cargar la relación con el modelo Producto
        ->get();
        return view('despacho.create', compact('usuarios', 'productos'));
    }

    /**
     * Guardar un nuevo despacho y actualizar el inventario.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'productos' => 'required|json',
            'productos.*.producto_id' => 'required|integer',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        // Crear el despacho
        $despacho = Despacho::create([
            'FECHA_DESPACHO' => now(), // Obtiene la fecha y hora actual
            'ID_USUARIO' => auth()->id(), // Obtiene el ID del usuario autenticado
        ]);

        // Iterar sobre los detalles del despacho
        $productos = json_decode($request->productos, true);  // true convierte el JSON a un array asociativo

        // Procesar cada producto
        foreach ($productos as $producto) {
            // Crear el detalle de despacho
            $detalleDespacho = DetalleDespacho::create([
                'ID_DESPACHO' => $despacho->ID_DESPACHO,
                'ID_PRODUCTO' => $producto['producto_id'],
                'CANTIDAD' => $producto['cantidad'],
                'COSTO_PRODUCTO' => $producto['precio'],  // Asumiendo que 'precio' es el costo
                'PRECIO_PRODUCTO' => $producto['precio'], // El precio de venta
            ]);

            // Suponiendo que $producto contiene el ID del producto y la cantidad a restar
            $productoDb = Inventario::with('producto')->where('ID_PRODUCTO', $producto['producto_id'])->first();

            if ($productoDb) {
            // Restar la cantidad del inventario
                $productoDb->CANTIDAD_INVENTARIO -= $producto['cantidad'];
                $productoDb->save();
            }
            
            // Obtener el valor de minimo_producto directamente desde la tabla productos
            $producto = Producto::find($productoDb->ID_PRODUCTO);

            // Verificar si la cantidad de inventario es menor que el mínimo
            if ($productoDb->CANTIDAD_INVENTARIO < $producto->MINIMO_PRODUCTO) {
                
                // Obtener el proveedor preferido
                $proveedorPreferido = DetalleProveedor::where('ID_PRODUCTO', $productoDb->ID_PRODUCTO)
                    ->where('PREFERIDO_PROVEEDOR', 1) // Filtrar por proveedor preferido
                    ->first();
                
                // Crear una nueva orden de compra
                $ordenCompra = new OrdenCompra();
                $ordenCompra->ID_PROVEEDOR = $proveedorPreferido->ID_PROVEEDOR;
                $ordenCompra->FECHA_COMPRA = Carbon::now(); // Fecha actual
                $ordenCompra->ID_ESTADO_ORDEN = 1; // O el estado que aplique
                $ordenCompra->USUARIO_ORDEN_COMPRA = "admin"; // O el estado que aplique
                $ordenCompra->save(); // Guardar la orden

                // Crear los detalles de la orden de compra (productos a reordenar)
                $detalleOrden = new DetalleOrdenCompra();
                $detalleOrden->ID_ORDEN_COMPRA = $ordenCompra->ID_ORDEN_COMPRA;
                $detalleOrden->ID_PRODUCTO = $productoDb->ID_PRODUCTO;
                $detalleOrden->CANTIDAD_PRODUCTO = $producto->MINIMO_PRODUCTO - $productoDb->CANTIDAD_INVENTARIO; // Cantidad necesaria para reponer
                $detalleOrden->PRECIO_PRODUCTO = $proveedorPreferido->PRECIO_PROVEEDOR; // Asumimos que el precio está en el producto
                $detalleOrden->COSTO_PRODUCTO = $proveedorPreferido->COSTO_PROVEEDOR; // Costo del producto
                $detalleOrden->USUARIO_ORDEN_COMPRA = "admin"; // Costo del producto
                $detalleOrden->save(); // Guardar el detalle de la orden
            }
        }

        return redirect()->route('despacho.index')->with('success', 'Despacho creado y inventario actualizado correctamente.');
    }

    /**
     * Mostrar un despacho específico.
     */
    public function show($id)
    {
        // Obtener el despacho con sus detalles y proveedor
        $despacho = Despacho::with('detalles.producto','usuario')
            ->findOrFail($id);

        // Retornar la vista con el despacho y sus detalles
        return view('despacho.show', compact('despacho'));
    }

    /**
     * Mostrar el formulario para editar un despacho.
     */
    public function edit(Despacho $despacho)
    {
        $usuarios = User::all();
        $productos = Producto::all();
        return view('despacho.edit', compact('despacho', 'usuarios', 'productos'));
    }

    /**
     * Actualizar un despacho.
     */
    public function update(Request $request, Despacho $despacho)
    {
        $request->validate([
            'FECHA_DESPACHO' => 'required|date',
            'ID_USUARIO' => 'required|exists:users,ID_USUARIO',
        ]);

        // Actualizar despacho
        $despacho->update($request->only('FECHA_DESPACHO', 'ID_USUARIO'));

        // Eliminar detalles anteriores
        $despacho->detalles()->delete();

        // Volver a agregar detalles y actualizar inventario
        foreach ($request->detalles as $detalle) {
            // Crear el detalle de despacho
            DetalleDespacho::create([
                'ID_DESPACHO' => $despacho->ID_DESPACHO,
                'ID_PRODUCTO' => $detalle['ID_PRODUCTO'],
                'CANTIDAD' => $detalle['CANTIDAD'],
                'COSTO_PRODUCTO' => $detalle['COSTO_PRODUCTO'],
                'PRECIO_PRODUCTO' => $detalle['PRECIO_PRODUCTO'],
            ]);

            // Actualizar el inventario
            $producto = Producto::find($detalle['ID_PRODUCTO']);
            if ($producto) {
                $producto->cantidad_inventario -= $detalle['CANTIDAD']; // Restar la cantidad al inventario
                $producto->save();

            
            }
        }

        return redirect()->route('despacho.index')->with('success', 'Despacho actualizado correctamente.');
    }

    /**
     * Eliminar un despacho.
     */
    public function destroy(Despacho $despacho)
    {
        // Primero, devolver las cantidades al inventario antes de eliminar
        foreach ($despacho->detalles as $detalle) {
            $producto = Producto::find($detalle->ID_PRODUCTO);
            if ($producto) {
                $producto->cantidad_inventario += $detalle->CANTIDAD; // Regresar la cantidad al inventario
                $producto->save();
            }
        }

        // Eliminar el despacho
        $despacho->delete();

        return redirect()->route('despacho.index')->with('success', 'Despacho eliminado correctamente.');
    }

    public function generatePdf($id)
    {
        // Obtiene el despacho con el ID dado, con sus detalles y producto relacionado
        $despacho = Despacho::with('detalles.producto', 'usuario')->findOrFail($id);

        // Genera el PDF
        $pdf = Pdf::loadView('despacho.print', compact('despacho'));

        // Devuelve el PDF como respuesta para su descarga
        return $pdf->stream('despacho_' . str_pad($despacho->ID_DESPACHO, 5, '0', STR_PAD_LEFT) . '.pdf');
    }
}
