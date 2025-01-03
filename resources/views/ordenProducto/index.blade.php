@extends('layouts.app')

@section('title', 'Órdenes de Compras')

@section('page-content')
<div class="main-content">
    <div class="row">  
        <div class="col">
            <h1>Órdenes de Compras</h1>
        </div>
        @if(Auth::user()->rol->DESCRIPCION_ROL == 'Gestor de Inventario')
        <div class="col-auto">
            <a href="{{ route('ordenProducto.create') }}" class="btn btn-flat btn-info btn-lg btn-block">Crear Nueva Orden</a>
        </div>
        @endif
    </div>
    
    <div class="mt-4">
        <h2>Órdenes Pendientes</h2>
        @if($ordenesPendientes->isEmpty())
            <div class="alert alert-info mt-2" role="alert">
                <strong>Mensaje:</strong> No hay órdenes pendientes de procesar.
            </div>
        @else
        <div class="data-tables datatable-dark">
            <table class="table table-bordered" id="tbl-pendientes">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>N° de Orden</th>
                        <th>Fecha de Compra</th>
                        <th>Proveedor</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ordenesPendientes as $index => $orden)
                        @if(Auth::user()->rol->DESCRIPCION_ROL != 'Gerente de Almacen' || $orden->ID_ESTADO_ORDEN == 2)  <!-- Verifica si el rol es 3 y si la orden está autorizada -->
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-danger">{{ str_pad($orden->ID_ORDEN_COMPRA, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ \Carbon\Carbon::parse($orden->FECHA_COMPRA)->format('d/m/Y') }}</td>
                                <td>{{ $orden->proveedor->NOMBRE_PROVEEDOR  }}</td>
                                <td class="text-center">
                                    @if($orden->ID_ESTADO_ORDEN == 1)
                                        <span class="badge badge-secondary p-2">Registrada</span>
                                    @elseif($orden->ID_ESTADO_ORDEN == 2)
                                        <span class="badge badge-info p-2">Autorizada</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('ordenProducto.show', $orden->ID_ORDEN_COMPRA) }}" class="btn btn-primary btn-sm">Ver detalle</a>
                                    @if($orden->ID_ESTADO_ORDEN == 1)
                                        @if(Auth::user()->rol->DESCRIPCION_ROL == 'Administrador')
                                            <a href="#" onclick="confirmAction('{{ route('ordenProducto.autorizar', $orden->ID_ORDEN_COMPRA) }}')" class="btn btn-success btn-sm">Autorizar</a>
                                            <a href="#" onclick="confirmAction('{{ route('ordenProducto.denegar', $orden->ID_ORDEN_COMPRA) }}')" class="btn btn-danger btn-sm">Denegar</a>
                                        @endif
                                    @elseif($orden->ID_ESTADO_ORDEN == 2)
                                    <!-- Verifica el rol antes de mostrar el botón de finalizar -->
                                            @if(Auth::user()->rol->DESCRIPCION_ROL == 'Gerente de Almacen')
                                                <a href="#" onclick="confirmFinish('{{ route('ordenProducto.finalizar', $orden->ID_ORDEN_COMPRA) }}')" class="btn btn-dark btn-sm">Finalizar</a>
                                            @endif
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <div class="mt-4">
        <h2>Órdenes Procesadas</h2>
        @if($ordenesProcesadas->isEmpty())
            <div class="alert alert-info  mt-2" role="alert">
                <strong>Mensaje:</strong> No hay órdenes procesadas o denegadas.
            </div>
        @else
            <div class="data-tables datatable-dark">
                <table class="table table-bordered" id="tbl-procesadas">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>N° de Orden</th>
                            <th>Fecha de Compra</th>
                            <th>Proveedor</th>
                            <th>Fecha de Actualización</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ordenesProcesadas as $index => $orden)
                            @if(Auth::user()->rol->DESCRIPCION_ROL != 'Gerente de Almacen' || $orden->ID_ESTADO_ORDEN == 4)  <!-- Verifica si el rol es 3 y si la orden está autorizada -->
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-danger">{{ str_pad($orden->ID_ORDEN_COMPRA, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($orden->FECHA_COMPRA)->format('d/m/Y') }}</td>
                                    <td>{{ $orden->proveedor->NOMBRE_PROVEEDOR  }}</td>
                                    <td>{{ \Carbon\Carbon::parse($orden->FECHA_ENTREGA)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        @if($orden->ID_ESTADO_ORDEN == 4)
                                            <span class="badge badge-success p-2">Finalizada</span>
                                        @elseif($orden->ID_ESTADO_ORDEN == 3)
                                            <span class="badge badge-danger p-2">Denegada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('ordenProducto.show', $orden->ID_ORDEN_COMPRA) }}" class="btn btn-primary btn-sm">Ver Detalle</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
@section('custom-scripts')
<script>
    $(document).ready(function() {
        initTable('#tbl-pendientes');
        initTable('#tbl-procesadas');
    });

    function confirmAction(url) {
        if (confirm('¿Estás seguro de que deseas autorizar o denegar esta orden?')) {
            window.location.href = url;  // Redirige a la ruta de autorizar o denegar
        }
    }

    function confirmFinish(url) {
        if (confirm('¿Estás seguro de que deseas finalizar esta orden?')) {
            window.location.href = url;  // Redirige a la ruta de autorizar o denegar
        }
    }
</script>
@endsection