@extends('layouts.app')
@section('title', 'Proveedores')
@section('page-content')
    <div class="main-content">
        <div class="row">  
            <div class="col">
                <h1>Gestión de Proveedores</h1>
            </div>
            <div class="col-auto">
                <a href="{{ route('proveedor.create') }}" class="btn btn-flat btn-info btn-lg btn-block">Crear Nuevo Proveedor</a>
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
                    <h4 class="header-title">Proveedores</h4>
                    <div class="data-tables datatable-dark">
                        <table id="tbl-proveedor" class="text-center">
                            <thead class="text-capitalize">
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proveedor as $index => $prov)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $prov->NOMBRE_PROVEEDOR }}</td>
                                        <td>{{ $prov->CORREO_PROVEEDOR }}</td>
                                        <td>
                                            <a href="{{ route('proveedor.edit', $prov->ID_PROVEEDOR) }}" class="btn btn-warning">Editar</a>
                                            <a href="{{ route('proveedor.editAssign', $prov->ID_PROVEEDOR) }}" class="btn btn-dark">Asignar productos</a>
                                            <a href="{{ route('proveedor.show', $prov->ID_PROVEEDOR) }}" class="btn btn-primary">Ver productos</a>
                                            <form action="{{ route('proveedor.destroy', $prov->ID_PROVEEDOR) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar el proveedor: {{ $prov->NOMBRE_PROVEEDOR }}? Esta acción no se puede deshacer.');">
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
        initTable('#tbl-proveedor');
    });
</script>
@endsection
