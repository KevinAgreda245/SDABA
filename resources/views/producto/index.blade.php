@extends('layouts.app')
@section('title', 'Productos')
@section('page-content')
    <div class="main-content">
        <div class="row">  
            <div class="col">
                <h1>Gestión de Productos</h1>
            </div>
            <div class="col-auto">
                <a href="{{ route('producto.create') }}" class="btn btn-flat btn-info btn-lg btn-block">Crear Nuevo Producto</a>
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
                    <h4 class="header-title">Productos</h4>
                    <div class="data-tables datatable-dark">
                        <table id="tbl-productos" class="text-center">
                            <thead class="text-capitalize">
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Tipo de Producto</th>
                                    <th>Minimo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $index => $producto)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $producto->NOMBRE_PRODUCTO }}</td>
                                        <td>{{ $producto->DESCRIPCION_PRODUCTO ?: 'No registra' }}</td>
                                        <td>{{ $producto->MINIMO_PRODUCTO }}</td>
                                        <td>
                                            <a href="{{ route('producto.edit', $producto->ID_PRODUCTO) }}" class="btn btn-warning">Editar</a>
                                            <form action="{{ route('producto.destroy', $producto->ID_PRODUCTO) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar el producto: {{ $producto->NOMBRE_PRODUCTO }}? Esta acción no se puede deshacer.');">
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
        initTable('#tbl-productos');
    });
</script>
@endsection