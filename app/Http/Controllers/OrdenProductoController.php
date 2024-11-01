<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class OrdenProductoController extends Controller
{
    //

    //create get method
    public function create(Producto $producto)
    {
        //mostrar en consola el producto
        // dd($producto);
        return view('pedirProducto.create', compact('producto'));
    }
}
