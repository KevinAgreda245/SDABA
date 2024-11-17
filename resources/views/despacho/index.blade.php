@extends('layouts.app')

@section('title', 'Lista de Despachos')

@section('page-content')
<div class="main-content">
    <div class="row">  
        <div class="col">
            <h1>Listado de Despacho</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('despacho.create') }}" class="btn btn-flat btn-info btn-lg btn-block">Nuevo Despacho</a>
        </div>    
    </div>
    
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Despachos Registrados</h4>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="data-tables datatable-dark">
                    <table id="tbl-despachos" class="text-center">
                        <thead class="text-capitalize">
                            <tr>
                                <th>#</th>
                                <th>Fecha de Despacho</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($despachos as $despacho)
                                <tr>
                                    <td>{{ $despacho->ID_DESPACHO }}</td>
                                    <td>{{ $despacho->FECHA_DESPACHO }}</td>
                                    <td>{{ $despacho->usuario->NOMBRE_USUARIO }} {{ $despacho->usuario->APELLIDO_USUARIO }}</td>
                                    <td>
                                        <a href="{{ route('despacho.show', $despacho->ID_DESPACHO) }}" class="btn btn-info">Ver detalle</a>
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
        initTable('#tbl-despachos');
    });
</script>
@endsection