@extends('layouts.app')
@section('title', 'Editar Usuario')
@section('page-content')
    <div class="main-content">
        <h1>Editar Usuario</h1>
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Información general.</h4>
                    <form action="{{ route('usuario.update', $usuario->ID_USUARIO) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="nombreUsuario" class="d-inline-flex align-items-center">
                                Nombre: <span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('NOMBRE_USUARIO') is-invalid @enderror" 
                                   id="nombreUsuario" 
                                   name="NOMBRE_USUARIO" 
                                   placeholder="Ingrese el nombre del usuario" 
                                   value="{{ old('NOMBRE_USUARIO', $usuario->NOMBRE_USUARIO) }}">
                            @error('NOMBRE_USUARIO')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Apellido -->
                        <div class="form-group">
                            <label for="apellidoUsuario" class="d-inline-flex align-items-center">
                                Apellido: <span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('APELLIDO_USUARIO') is-invalid @enderror" 
                                   id="apellidoUsuario" 
                                   name="APELLIDO_USUARIO" 
                                   placeholder="Ingrese el apellido del usuario" 
                                   value="{{ old('APELLIDO_USUARIO', $usuario->APELLIDO_USUARIO) }}">
                            @error('APELLIDO_USUARIO')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Rol -->
                        <div class="form-group">
                            <label for="rolUsuario" class="d-inline-flex align-items-center">
                                Rol: <span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span>
                            </label>
                            <select class="form-control @error('ID_ROL') is-invalid @enderror" id="rolUsuario" name="ID_ROL">
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->ID_ROL }}" {{ $rol->ID_ROL == $usuario->ID_ROL ? 'selected' : '' }}>
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

                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('usuario.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
