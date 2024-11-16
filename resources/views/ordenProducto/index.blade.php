@extends('layouts.app')

@section('title', 'Órdenes de Compras')

@section('page-content')
<div class="main-content">
    <div class="row">  
        <div class="col">
            <h1>Órdenes de Compras</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('producto.create') }}" class="btn btn-flat btn-info btn-lg btn-block">Crear Nueva Orden</a>
        </div>    
    </div>
    
    <div class="mt-4">
        <h2>Órdenes Pendientes</h2>
        @if($ordenesPendientes->isEmpty())
            <div class="alert alert-info" role="alert">
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
                                    <a href="{{ route('ordenProducto.show', $orden->ID_ORDEN_COMPRA) }}" class="btn btn-success btn-sm">Autorizar</a>
                                    <a href="{{ route('ordenProducto.show', $orden->ID_ORDEN_COMPRA) }}" class="btn btn-danger btn-sm">Denegar</a>
                                @elseif($orden->ID_ESTADO_ORDEN == 2)
                                    <a href="{{ route('ordenProducto.show', $orden->ID_ORDEN_COMPRA) }}" class="btn btn-dark btn-sm">Finalizar</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <div class="mt-4">
        <h2>Órdenes Finalizadas/Denegadas</h2>
        @if($ordenesProcesadas->isEmpty())
            <div class="alert alert-info" role="alert">
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
</script>
@endsection