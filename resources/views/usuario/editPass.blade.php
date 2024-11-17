@extends('layouts.app')
@section('title', 'Cambiar Contraseña')
@section('page-content')
<div class="main-content">
    <h1>Cambiar Contraseña</h1>
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Actualizar Contraseña</h4>
                <form action="{{ route('usuario.password.update', $usuario->ID_USUARIO) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="password">Nueva Contraseña:</label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Ingrese la nueva contraseña">
                            <button type="button" 
                                    class="btn btn-outline-secondary ml-4" 
                                    onclick="togglePassword('password', this)">
                                Mostrar
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña:</label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Confirme la nueva contraseña">
                            <button type="button" 
                                    class="btn btn-outline-secondary ml-4" 
                                    onclick="togglePassword('password_confirmation', this)">
                                Mostrar
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                    <a href="{{ route('usuario.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('custom-scripts')
<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            button.textContent = "Ocultar";
        } else {
            input.type = "password";
            button.textContent = "Mostrar";
        }
    }
</script>
@endsection