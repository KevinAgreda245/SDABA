@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('page-content')
    <div class="main-content">
        <div class="row">
            <div class="col">
                <h1>Gestión de Usuarios</h1>
            </div>
            <div class="col-auto">
                <a href="{{ route('usuario.create') }}" class="btn btn-flat btn-info btn-lg btn-block">Crear Nuevo Usuario</a>
            </div>
        </div>

        <!-- Mensaje de éxito -->
        <div class="col-12 mt-2 alert-dismiss">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
                </div>
            @endif
        </div>

        <!-- Tabla de usuarios -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Usuarios</h4>
                    <div class="data-tables datatable-dark">
                        <table id="tbl-usuarios" class="text-center">
                            <thead class="text-capitalize">
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $index => $usuario)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $usuario->NOMBRE_USUARIO }}</td>
                                        <td>{{ $usuario->APELLIDO_USUARIO }}</td>
                                        <td>{{ $usuario->USER_USUARIO }}</td>
                                        <td>{{ $usuario->rol->DESCRIPCION_ROL }}</td>
                                        <td>
                                            @if($usuario->USER_USUARIO != 'admin') 
                                                <a href="{{ route('usuario.edit', $usuario->ID_USUARIO) }}" class="btn btn-warning">Editar</a>
                                            @endif
                                            <a href="{{ route('usuario.password.edit', $usuario->ID_USUARIO) }}" class="btn btn-info">Cambiar Contraseña</a>
                                            @if(Auth::user()->rol->DESCRIPCION_ROL == 'Administrador' && Auth::user()->ID_USUARIO != $usuario->ID_USUARIO && $usuario->USER_USUARIO != 'admin')
                                                <form action="{{ route('usuario.destroy', $usuario->ID_USUARIO) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar al usuario: {{ $usuario->USER_USUARIO }}? Esta acción no se puede deshacer.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
<script>
    $(document).ready(function() {
        initTable('#tbl-usuarios'); // Inicia la tabla con los métodos que definiste en tu función initTable
    });
</script>
@endsection
