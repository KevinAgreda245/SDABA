@extends('layouts.app')
@section('title', 'Tipo de Productos')
@section('page-content')
    <div class="main-content">
        <div class="row">  
            <div class="col">
                <h1>Gestión de Tipo de Productos</h1>
            </div>
            <div class="col-auto">
                <a href="{{ route('tipoProducto.create') }}" class="btn btn-flat btn-info btn-lg btn-block">Crear Nuevo Tipo de Producto</a>
            </div>    
        </div>
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
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Tipos de productos</h4>
                    <div class="data-tables datatable-dark">
                        <table id="tbl-tipo" class="text-center">
                            <thead class="text-capitalize">
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipo_productos as $index => $tipoProducto)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $tipoProducto->NOMBRE_TIPO_PRODUCTO }}</td>
                                        <td>{{ $tipoProducto->DESCR_TIPO_PRODUCTO ?: 'No registra' }}</td>
                                        <td>
                                            <a href="{{ route('tipoProducto.edit', $tipoProducto->ID_TIPO_PRODUCTO) }}" class="btn btn-warning">Editar</a>
                                            <form action="{{ route('tipoProducto.destroy', $tipoProducto->ID_TIPO_PRODUCTO) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar el tipo de producto: {{ $tipoProducto->NOMBRE_TIPO_PRODUCTO }}? Esta acción no se puede deshacer.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
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
        initTable('#tbl-tipo');
    });
</script>
@endsection