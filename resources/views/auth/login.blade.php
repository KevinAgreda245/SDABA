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
                        <label for="exampleInputEmail1">Nombre de Usuario:</label>
                        <input type="email" id="exampleInputEmail1">
                        <i class="ti-email"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="form-gp">
                        <label for="exampleInputPassword1">Contraseña:</label>
                        <input type="password" id="exampleInputPassword1">
                        <i class="ti-lock"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="row mb-4 rmber-area">
                        <div class="col-12 text-right">
                            <a href="#">Olvide mi contraseña</a>
                        </div>
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