<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\DetalleProveedor;
use Illuminate\Support\Facades\Auth;
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
        $data['USUARIO_PROVEEDOR'] = Auth::user()->USER_USUARIO;
        $proveedor = Proveedor::create($data);

        // Asignar productos al proveedor en la tabla de detalle_proveedor
        if ($request->has('productos') && !empty($request->productos)) {
            // Decodifica el JSON a un array
            $productos = json_decode($request->productos, true);
        
            // Itera sobre cada producto y guarda los detalles en la base de datos
            foreach ($productos as $producto) {
                if ($producto['preferido'] == 1) {
                    // Buscar si el producto ya tiene un proveedor preferido asignado
                    $productoPreferidoActual = DetalleProveedor::where('ID_PRODUCTO', $producto['id'])
                                                               ->where('PREFERIDO_PROVEEDOR', 1) // Solo buscamos el preferido actual
                                                               ->first();
                
                    // Si ya hay un proveedor preferido, actualizarlo a 0
                    if ($productoPreferidoActual) {
                        $productoPreferidoActual->PREFERIDO_PROVEEDOR = 0;
                        $productoPreferidoActual->save(); // Guardar el cambio
                    }
                }

                DetalleProveedor::create([
                    'ID_PRODUCTO' => $producto['id'],
                    'ID_PROVEEDOR' => $proveedor->ID_PROVEEDOR, // Usamos el ID del proveedor recién creado
                    'PRECIO_PROVEEDOR' => $producto['precio'],
                    'COSTO_PROVEEDOR' => $producto['costo'],
                    'PREFERIDO_PROVEEDOR' => $producto['preferido'],
                    'USUARIO_DET_USUARIO' => Auth::user()->USER_USUARIO, // Usuario actual o el valor correspondiente
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

        // Obtener productos asignados a este proveedor, incluyendo detalles como el costo y si es preferido
        $productos = Producto::join('detalle_proveedor', 'producto.ID_PRODUCTO', '=', 'detalle_proveedor.ID_PRODUCTO')
            ->where('detalle_proveedor.ID_PROVEEDOR', $id)
            ->select('producto.NOMBRE_PRODUCTO', 'detalle_proveedor.PRECIO_PROVEEDOR', 'detalle_proveedor.PREFERIDO_PROVEEDOR')
            ->get();

        // Retornar la vista con los datos del proveedor y sus productos
        return view('proveedor.show', compact('proveedor', 'productos'));
    }

    public function edit(string $id)
    {
        $proveedor = Proveedor::findOrFail($id); // Obtener el proveedor
        return view('proveedor.edit', compact('proveedor'));
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

    public function editAssign(string $id)
    {
        $proveedor = Proveedor::findOrFail($id); // Obtener el proveedor
        $productos = Producto::all(); // Obtener todos los productos
        $detalle_proveedor = DetalleProveedor::where('ID_PROVEEDOR', $id)->get(); // Productos asignados

        return view('proveedor.assign', compact('proveedor', 'productos', 'detalle_proveedor'));
    }

    public function updateAssign(Request $request, string $id) {
        $request->validate([
            'productos' => 'array',
            'costos' => 'array',
            'precios' => 'array',
            'preferidos' => 'array',
            'costos.*' => 'numeric|min:0',
            'precios.*' => 'numeric|min:0',
        ]);
    
        $productos = $request->input('productos', []);
        $costos = $request->input('costos', []);
        $precios = $request->input('precios', []);
        $preferidos = $request->input('preferidos', []);
    
        // Eliminar productos no seleccionados
        DetalleProveedor::where('ID_PROVEEDOR', $id)
            ->whereNotIn('ID_PRODUCTO', $productos)
            ->delete();
    
        // Actualizar o crear productos
        foreach ($productos as $productoId) {
            DetalleProveedor::updateOrCreate(
                ['ID_PROVEEDOR' => $id, 'ID_PRODUCTO' => $productoId],
                [
                    'COSTO_PROVEEDOR' => $costos[$productoId] ?? 0,
                    'PRECIO_PROVEEDOR' => $precios[$productoId] ?? 0,
                    'PREFERIDO_PROVEEDOR' => $preferidos[$productoId] ?? 0,
                    'USUARIO_DET_USUARIO' => Auth::user()->USER_USUARIO
                ]
            );
        }

        return redirect()->route('proveedor.index')->with('success', 'Los productos han sido actualizados correctamente.');
    }

    public function getPreferredSuplier($id)
    {
        // Busca el proveedor preferido del producto con el ID dado
        $detalleProveedor = DetalleProveedor::where('ID_PRODUCTO', $id)
        ->where('PREFERIDO_PROVEEDOR', 1)
        ->with('proveedor')  // Carga el proveedor asociado
        ->first();

        // Si existe un proveedor preferido, retornamos su nombre, de lo contrario, null
        $proveedor = $detalleProveedor ? $detalleProveedor->proveedor : null;

       
        return response()->json($proveedor);
    }

    // Método para obtener productos de un proveedor
    public function getProductosPorProveedor($proveedorId)
    {
        // Buscar los detalles de proveedor para el proveedor dado
    $detallesProveedor = DetalleProveedor::where('ID_PROVEEDOR', $proveedorId)->get();

    // Verificar si existen detalles de proveedor
    if ($detallesProveedor->isEmpty()) {
        return response()->json(['error' => 'No se encontraron productos para este proveedor'], 404);
    }

    // Obtener los productos asociados a este proveedor a través de los detalles
    $productos = $detallesProveedor->map(function ($detalle) {
        return $detalle->producto; // Obtiene el producto asociado a cada detalle
    });

    // Devolver los productos en formato JSON
    return response()->json($productos);
    }


    public function getInfo($productoId, $proveedorId) {
        // Buscar el detalle del proveedor para este producto y proveedor
        $detalle = DetalleProveedor::where('ID_PRODUCTO', $productoId)
                                   ->where('ID_PROVEEDOR', $proveedorId)
                                   ->first();

        // Verificar si el detalle existe
        if (!$detalle) {
            return response()->json(['error' => 'Detalle no encontrado'], 404);
        }

        // Devolver el costo y precio en formato JSON
        return response()->json([
            'precio' => $detalle->PRECIO_PROVEEDOR,
            'costo' => $detalle->COSTO_PROVEEDOR,
        ]);
    }
}
