@extends('layouts.base')
@section('title', 'Inicio de Sesión')
@section('content')
<div class="login-area">
    <div class="container">
        <div class="login-box ptb--100">
            <form action="{{ route('login') }}" method="POST">
                <div class="login-form-head">
                    <p>Sistema de Abastecimiento Automatico Bodega Amigos</p>
                </div>
                @csrf <!-- Token CSRF necesario para formularios en Laravel -->
                <div class="login-form-body">
                    <div class="form-gp">
                        <label for="user_usuario">Nombre de Usuario:</label>
                        <input type="text" id="user_usuario" name="user_usuario" value="{{ old('user_usuario') }}" required>
                        <i class="ti-email"></i>
                        @error('user_usuario')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-gp">
                        <label for="clave_usuario">Contraseña:</label>
                        <input type="password" id="clave_usuario" name="clave_usuario" required>
                        <i class="ti-lock"></i>
                        @error('clave_usuario')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="submit-btn-area">
                        <button id="form_submit" type="submit">Entrar <i class="ti-arrow-right"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection