<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Vista personalizada
    }

    public function login(Request $request)
    {
        // Redirige al usuario a la página principal
        return redirect()->route('main');
    }
}
