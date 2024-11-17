@extends('layouts.app')
@section('title', 'Nuevo Usuario')
@section('page-content')
    <div class="main-content">
        <h1>Nuevo Usuario</h1>
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Información general.</h4>
                    <form action="{{ route('usuario.store') }}" method="POST">
                        @csrf <!-- Token CSRF para seguridad -->
                
                        <div class="form-group">
                            <label for="nombreUsuario" class="d-inline-flex align-items-center">Nombre:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <input type="text" class="form-control @error('NOMBRE_USUARIO') is-invalid @enderror" 
                                id="nombreUsuario" name="NOMBRE_USUARIO" 
                                placeholder="Ingrese el nombre del usuario" 
                                value="{{ old('NOMBRE_USUARIO') }}">
                            @error('NOMBRE_USUARIO')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="apellidoUsuario" class="d-inline-flex align-items-center">Apellido:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <input type="text" class="form-control @error('APELLIDO_USUARIO') is-invalid @enderror" 
                                id="apellidoUsuario" name="APELLIDO_USUARIO" 
                                placeholder="Ingrese el apellido del usuario" 
                                value="{{ old('APELLIDO_USUARIO') }}">
                            @error('APELLIDO_USUARIO')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="userUsuario" class="d-inline-flex align-items-center">Nombre de Usuario:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <input type="text" class="form-control @error('USER_USUARIO') is-invalid @enderror" 
                                id="userUsuario" name="USER_USUARIO" 
                                placeholder="Ingrese el nombre de usuario" 
                                value="{{ old('USER_USUARIO') }}">
                            @error('USER_USUARIO')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="claveUsuario" class="d-inline-flex align-items-center">Contraseña:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <input type="password" class="form-control @error('CLAVE_USUARIO') is-invalid @enderror" 
                                id="claveUsuario" name="CLAVE_USUARIO" 
                                placeholder="Ingrese la contraseña">
                            @error('CLAVE_USUARIO')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="claveUsuario_confirmation" class="d-inline-flex align-items-center">Confirmar Contraseña:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <input type="password" class="form-control @error('CLAVE_USUARIO_confirmation') is-invalid @enderror" 
                                id="claveUsuario_confirmation" name="CLAVE_USUARIO_confirmation" 
                                placeholder="Confirme la contraseña">
                            @error('CLAVE_USUARIO_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="rolUsuario">Rol:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <select class="form-control @error('ID_ROL') is-invalid @enderror" 
                                id="rolUsuario" name="ID_ROL">
                                <option value="">Seleccionar Rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->ID_ROL }}" {{ old('ID_ROL') == $rol->ID_ROL ? 'selected' : '' }}>
                                        {{ $rol->DESCRIPCION_ROL }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ID_ROL')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('usuario.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
