<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\DetalleProveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedor = Proveedor::all();
        return view('proveedor.index', compact('proveedor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los productos
        $productos = Producto::all(); 
        return view('proveedor.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'NOMBRE_PROVEEDOR' => 'required|unique:proveedor,NOMBRE_PROVEEDOR',
            'CORREO_PROVEEDOR' => 'required|unique:proveedor,CORREO_PROVEEDOR',
            'TELEFONO_PROVEEDOR' => 'nullable|string',
            'DIRECCION_PROVEEDOR' => 'nullable|string',
        ], [
            'NOMBRE_PROVEEDOR.required' => 'El nombre del proveedor es obligatorio.',
            'NOMBRE_PROVEEDOR.unique' => 'El proveedor ya existe.',
            'CORREO_PROVEEDOR.required' => 'El correo del proveedor es obligatorio.',
            'CORREO_PROVEEDOR.unique' => 'El correo ya existe.',
        ]);

        // Crear el proveedor 
        $data = $request->all();
        $data['USUARIO_PROVEEDOR'] = "Mey";
        $proveedor = Proveedor::create($data);

        // Asignar productos al proveedor en la tabla de detalle_proveedor
        if ($request->has('productos')) {
            foreach ($request->productos as $productoId) {
                DetalleProveedor::create([
                    'ID_PRODUCTO' => $productoId,
                    'ID_PROVEEDOR' => $proveedor->ID_PROVEEDOR,
                    'PRECIO_PROVEEDOR' => $request->input('PRECIO_PROVEEDOR', 0.00),
                    'USUARIO_DET_USUARIO' => "Mey",
                ]);
            }
        }

        // Redirigir con mensaje de éxito
        return redirect()->route('proveedor.index')->with('success', 'Proveedor añadido correctamente.');
    }

    public function show(string $id)
    {
        // Obtener el proveedor por su ID
    $proveedor = Proveedor::findOrFail($id);
    
    // Obtener productos asignados a este proveedor
    $productos = Producto::join('detalle_proveedor', 'producto.ID_PRODUCTO', '=', 'detalle_proveedor.ID_PRODUCTO')
                        ->where('detalle_proveedor.ID_PROVEEDOR', $id)
                        ->select('producto.NOMBRE_PRODUCTO')
                        ->get();

    // Retornar la vista con los datos del proveedor y sus productos
    return view('proveedor.show', compact('proveedor', 'productos'));
    }

    public function edit(string $id)
    {
        $proveedor = Proveedor::findOrFail($id); // Obtener el proveedor
        $productos = Producto::all(); // Obtener todos los productos
        $detalle_proveedor = DetalleProveedor::where('ID_PROVEEDOR', $id)->get(); // Productos asignados

        return view('proveedor.edit', compact('proveedor', 'productos', 'detalle_proveedor'));
    }

    public function update(Request $request, string $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        // Validar los datos del formulario
        $request->validate([
            'NOMBRE_PROVEEDOR' => 'required|unique:proveedor,NOMBRE_PROVEEDOR,'. $id . ',ID_PROVEEDOR',
            'CORREO_PROVEEDOR' => 'required|unique:proveedor,CORREO_PROVEEDOR,'. $id . ',ID_PROVEEDOR',
            'TELEFONO_PROVEEDOR' => 'nullable|string',
            'DIRECCION_PROVEEDOR' => 'nullable|string',
        ], [
            'NOMBRE_PROVEEDOR.required' => 'El nombre del proveedor es obligatorio.',
            'NOMBRE_PROVEEDOR.unique' => 'El proveedor ya existe.',
            'CORREO_PROVEEDOR.required' => 'El correo del proveedor es obligatorio.',
            'CORREO_PROVEEDOR.unique' => 'El correo ya existe.',
        ]);

        // Actualizar proveedor
        $proveedor->update([
            'NOMBRE_PROVEEDOR' => $request->NOMBRE_PROVEEDOR,
            'CORREO_PROVEEDOR' => $request->CORREO_PROVEEDOR,
            'TELEFONO_PROVEEDOR' => $request->TELEFONO_PROVEEDOR,
            'DIRECCION_PROVEEDOR' => $request->DIRECCION_PROVEEDOR,
        ]);

        // Actualizar productos asignados al proveedor
        DetalleProveedor::where('ID_PROVEEDOR', $id)->delete(); // Eliminar asignaciones previas
        if ($request->has('productos')) {
            foreach ($request->productos as $productoId) {
                DetalleProveedor::create([
                    'ID_PRODUCTO' => $productoId,
                    'ID_PROVEEDOR' => $id,
                    'PRECIO_PROVEEDOR' => 0, 
                    'USUARIO_DET_USUARIO' => "Mey"
                ]);
            }
        }

        // Redirigir con mensaje de éxito
        return redirect()->route('proveedor.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        // Eliminar asignaciones de productos
        DetalleProveedor::where('ID_PROVEEDOR', $id)->delete();

        // Eliminar el proveedor
        $proveedor->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('proveedor.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
