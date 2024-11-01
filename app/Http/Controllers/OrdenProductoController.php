<?php

namespace App\Http\Controllers;

use App\Models\DetalleOrdenCompra;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;

class OrdenProductoController extends Controller
{
    //

    //create get method
    public function create(Inventario $inventario)
    {
        //obtener los proveedores del producto
        $proveedores = Proveedor::all();
        // dd($proveedores);
        return view('pedirProducto.create', compact('inventario', 'proveedores'));
    }

    // recibe form 
    public function store(Request $request)
    {
        // valida que todos los campos esten llenos
        $request->validate([
            'ID_PROVEEDOR' => 'required',
            'CANTIDAD_PEDIDO' => 'required',
            'COSTO_PRODUCTO' => 'required',
            'PRECIO_PRODUCTO' => 'required',
            'ID_PRODUCTO' => 'required',
        ], [
            'ID_PROVEEDOR.required' => 'El campo proveedor es obligatorio.',
            'CANTIDAD_PEDIDO.required' => 'El campo cantidad pedido es obligatorio.',
            'COSTO_PRODUCTO.required' => 'El campo costo del producto es obligatorio.',
            'PRECIO_PRODUCTO.required' => 'El campo precio del producto es obligatorio.',
            'ID_PRODUCTO.required' => 'El campo producto es obligatorio.',
        ]);
        // dd($request);
       
        //query para obtener el producto
        $producto = Producto::find($request->ID_PRODUCTO);
        //query para obtener el proveedor
        $proveedor = Proveedor::find($request->ID_PROVEEDOR);
        
        // validar que exista el producto y el proveedor
        if (!$producto || !$proveedor) {
            return redirect()->back()->withErrors(['ID_PRODUCTO' => 'Ocurrio un error inesperado.']);
        }

        // crear orden de compra
        $ordenCompra = new \App\Models\OrdenCompra();
        $ordenCompra->FECHA_COMPRA = now();
        $ordenCompra->ID_ESTADO_ORDEN = 1;
        $ordenCompra->ID_PROVEEDOR = $proveedor->ID_PROVEEDOR;
        $ordenCompra->FECHA_ENTREGA = now();
        // $ordenCompra->USUARIO_ORDEN_COMPRA = auth()->user()->ID_USUARIO;
        $ordenCompra->save();

        // crear orden de compra detalle
        $detalleOrdenCompra = new DetalleOrdenCompra();
        $detalleOrdenCompra->ID_ORDEN_COMPRA = $ordenCompra->ID_ORDEN_COMPRA;
        $detalleOrdenCompra->ID_PRODUCTO = $producto->ID_PRODUCTO;
        $detalleOrdenCompra->CANTIDAD_PRODUCTO = $request->CANTIDAD_PEDIDO;
        $detalleOrdenCompra->COSTO_PRODUCTO = $request->COSTO_PRODUCTO;
        $detalleOrdenCompra->PRECIO_PRODUCTO = $request->PRECIO_PRODUCTO;
        // $detalleOrdenCompra->USUARIO_ORDEN_COMPRA = auth()->user()->ID_USUARIO;
        $detalleOrdenCompra->save();
        // cambiar el estado del inventario
        $inventario = Inventario::find($producto->ID_PRODUCTO);
        $inventario->ESTADO_ACTIVO_INVENTARIO = "NuevoPedido";
        $inventario->save();

        return redirect()->route('inventario.index')->with('success', 'Orden de compra creada exitosamente.');

        
    }
}