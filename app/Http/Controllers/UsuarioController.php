<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Mostrar lista de usuarios
    public function index()
    {
        $usuarios = User::all(); // Obtén todos los usuarios
        return view('usuario.index', compact('usuarios'));
    }

    // Mostrar formulario para crear un nuevo usuario
    public function create()
    {
        $roles = Rol::all(); // Obtener todos los roles disponibles
        return view('usuario.create', compact('roles'));
    }

    // Almacenar un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'NOMBRE_USUARIO' => 'required|string|max:255',
            'APELLIDO_USUARIO' => 'required|string|max:255',
            'USER_USUARIO' => 'required|string|max:255|unique:usuario',
            'CLAVE_USUARIO' => 'required|string|min:6|confirmed', // Confirmación de la contraseña
            'ID_ROL' => 'required|exists:rol,ID_ROL',
        ]);

        User::create([
            'NOMBRE_USUARIO' => $request->NOMBRE_USUARIO,
            'APELLIDO_USUARIO' => $request->APELLIDO_USUARIO,
            'USER_USUARIO' => $request->USER_USUARIO,
            'CLAVE_USUARIO' => Hash::make($request->CLAVE_USUARIO),
            'ID_ROL' => $request->ID_ROL,
        ]);

        return redirect()->route('usuario.index')->with('success', 'Usuario creado exitosamente.');
    }

    // Mostrar el formulario de edición de un usuario
    public function edit($id)
    {
        $usuario = User::findOrFail($id); // Obtener el usuario por su ID
        $roles = Rol::all(); // Obtener todos los roles disponibles
        return view('usuario.edit', compact('usuario', 'roles'));
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        // Validar los datos enviados
    $request->validate([
        'NOMBRE_USUARIO' => 'required|string|max:255',
        'APELLIDO_USUARIO' => 'required|string|max:255',
        'ID_ROL' => 'required|exists:rol,ID_ROL',
    ]);

    // Buscar el usuario por ID
    $usuario = User::findOrFail($id);

    // Actualizar los campos
    $usuario->NOMBRE_USUARIO = $request->input('NOMBRE_USUARIO');
    $usuario->APELLIDO_USUARIO = $request->input('APELLIDO_USUARIO');
    $usuario->ID_ROL = $request->input('ID_ROL');
    $usuario->save();

    // Redireccionar con mensaje de éxito
    return redirect()->route('usuario.index')
        ->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuario.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function editPassword($id)
{
    $usuario = User::findOrFail($id);
    return view('usuario.editPass', compact('usuario'));
}

public function updatePassword(Request $request, $id)
{
    $request->validate([
        'password' => 'required|string|min:8|confirmed',
    ]);

    $usuario = User::findOrFail($id);
    $usuario->CLAVE_USUARIO = bcrypt($request->password); // Encripta la nueva contraseña
    $usuario->save();

    return redirect()->route('usuario.index')->with('success', 'Contraseña actualizada con éxito.');
}

}

