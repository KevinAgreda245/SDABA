<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoProducto;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with('tipoProducto')->get();
        return view('producto.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener los tipos de producto para el selector en el formulario
        $tiposProducto = TipoProducto::all();

        // Retornar la vista 'productos.create' con los tipos de producto disponibles
        return view('producto.create', compact('tiposProducto'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'descripcion_producto' => 'nullable|string',
            'minimo_producto' => 'required|integer|min:1',
            'id_tipo_producto' => 'required|exists:tipo_producto,ID_TIPO_PRODUCTO'
        ], [
            'nombre_producto.required' => 'El nombre del producto es obligatorio.',
            'nombre_producto.unique' => 'El nombre del producto ya existe.',
            'minimo_producto.required' => 'La cantidad mínima es obligatoria.',
            'id_tipo_producto.required' => 'Debe seleccionar un tipo de producto válido.',
            'id_tipo_producto.exists' => 'El tipo de producto seleccionado no existe en la base de datos.'
        ]);

        // Crear el producto con los datos del formulario
        Producto::create([
            'NOMBRE_PRODUCTO' => $request->nombre_producto,
            'DESCRIPCION_PRODUCTO' => $request->descripcion_producto,
            'MINIMO_PRODUCTO' => $request->minimo_producto,
            'ID_TIPO_PRODUCTO' => $request->id_tipo_producto,
            'USUARIO_PRODUCTO' => "kevin agreda",
        ]);

        // Redirigir a la lista de productos con mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        $tiposProducto = TipoProducto::all();
    
        return view('producto.edit', compact('producto', 'tiposProducto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validación
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'descripcion_producto' => 'nullable|string',
            'minimo_producto' => 'required|integer',
            'id_tipo_producto' => 'required|exists:tipo_producto,ID_TIPO_PRODUCTO'
        ], [
            'nombre_producto.required' => 'El nombre del producto es obligatorio.',
            'minimo_producto.required' => 'El mínimo del producto es obligatorio.',
            'id_tipo_producto.exists' => 'El tipo de producto seleccionado no es válido.'
        ]);

        // Actualizar producto
        $producto = Producto::findOrFail($id);
        $producto->update([
            'NOMBRE_PRODUCTO' => $request->nombre_producto,
            'DESCRIPCION_PRODUCTO' => $request->descripcion_producto,
            'MINIMO_PRODUCTO' => $request->minimo_producto,
            'ID_TIPO_PRODUCTO' => $request->id_tipo_producto
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Busca el producto por su ID
        $producto = Producto::findOrFail($id);

        // Elimina el producto
        $producto->delete();

        // Redirige con mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto eliminado exitosamente.');
    }

}
