<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Verifica si ya hay una sesión activa
        if (Auth::check()) {
            return redirect()->route('main');
        }
        return view('auth.login');
    }
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'user_usuario' => 'required|string',
            'clave_usuario' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        $user = User::where('USER_USUARIO', $request->user_usuario)->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($user && Hash::check($request->clave_usuario, $user->CLAVE_USUARIO)) {
            Auth::login($user);
            return redirect()->route('main'); // Redirige al dashboard o página principal
        }

        // Si no se encuentra el usuario o la contraseña es incorrecta, enviar un error
        return back()->withErrors([
            'user_usuario' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
