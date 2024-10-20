<?php

namespace App\Http\Controllers;

use App\Models\TipoProducto;
use Illuminate\Http\Request;

class TipoProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo_productos = TipoProducto::all();
        return view('tipoProducto.index', compact('tipo_productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipoProducto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'NOMBRE_TIPO_PRODUCTO' => 'required|unique:tipo_producto,NOMBRE_TIPO_PRODUCTO',
            'DESCR_TIPO_PRODUCTO' => 'nullable|string',
        ], [
            'NOMBRE_TIPO_PRODUCTO.required' => 'El nombre del tipo de producto es obligatorio.',
            'NOMBRE_TIPO_PRODUCTO.unique' => 'El tipo de producto ya existe.',
        ]);

        // Crear un nuevo tipo de producto
        TipoProducto::create([
            'NOMBRE_TIPO_PRODUCTO' => $request->NOMBRE_TIPO_PRODUCTO,
            'DESCR_TIPO_PRODUCTO' => $request->DESCR_TIPO_PRODUCTO,
        ]);

        // Redirigir a la lista de tipos de productos con un mensaje de éxito
        return redirect()->route('tipoProducto.index')->with('success', 'Tipo de Producto creado exitosamente.');
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
        // Obtén el tipo de producto usando el ID
        $tipoProducto = TipoProducto::findOrFail($id); // Esto lanzará una excepción si no se encuentra

        return view('tipoProducto.edit', compact('tipoProducto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Obtener el tipo de producto usando el ID
        $tipoProducto = TipoProducto::findOrFail($id);

        // Validación
        $request->validate([
            'NOMBRE_TIPO_PRODUCTO' => 'required|unique:tipo_producto,NOMBRE_TIPO_PRODUCTO,' . $id . ',ID_TIPO_PRODUCTO',
            'DESCR_TIPO_PRODUCTO' => 'nullable|string',
        ], [
            'NOMBRE_TIPO_PRODUCTO.required' => 'El nombre del tipo de producto es obligatorio.',
            'NOMBRE_TIPO_PRODUCTO.unique' => 'El tipo de producto ya existe.',
        ]);

        // Actualizar tipo de producto
        $tipoProducto->update([
            'NOMBRE_TIPO_PRODUCTO' => $request->NOMBRE_TIPO_PRODUCTO,
            'DESCR_TIPO_PRODUCTO' => $request->DESCR_TIPO_PRODUCTO,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('tipoProducto.index')->with('success', 'Tipo de Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Busca el tipo de producto por su ID
        $tipoProducto = TipoProducto::findOrFail($id);

        // Elimina el tipo de producto
        $tipoProducto->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('tipoProducto.index')->with('success', 'Tipo de Producto eliminado exitosamente.');
    }
}
