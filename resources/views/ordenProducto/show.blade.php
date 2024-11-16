@extends('layouts.app')

@section('title', 'Detalle de la Orden')

@section('page-content')
<div class="main-content">
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-area">
                            <div class="invoice-head">
                                <div class="row">
                                    <div class="iv-left col-6">
                                        <span>Orden de Compra</span>
                                    </div>
                                    <div class="iv-right col-6 text-md-right">
                                        <span>#{{ str_pad($orden->ID_ORDEN_COMPRA, 5, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="invoice-address">
                                        <h3>{{ $orden->proveedor->NOMBRE_PROVEEDOR }}</h3>
                                        <p>{{ $orden->proveedor->CORREO_PROVEEDOR }}</p>
                                        <p>{{ $orden->proveedor->TELEFONO_PROVEEDOR }}</p>
                                        <p>{{ $orden->proveedor->DIRECCION_PROVEEDOR }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <ul class="invoice-date">
                                        <li>Fecha de Orden: {{ \Carbon\Carbon::parse($orden->FECHA_COMPRA)->format('d/m/Y') }}</li>
                                        <li>Fecha de Entrega: {{ \Carbon\Carbon::parse($orden->FECHA_ENTREGA)->format('d/m/Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-table table-responsive mt-5">
                                <table class="table table-bordered table-hover text-right">
                                    <thead>
                                        <tr class="text-capitalize">
                                            <th class="text-center" style="width: 5%;">N°</th>
                                            <th class="text-left" style="width: 45%; min-width: 130px;">Descripción</th>
                                            <th>Cantidad</th>
                                            <th style="min-width: 100px">Costo Unitario</th>
                                            <th>Precio Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orden->detalles as $index => $detalle)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="text-left">{{ $detalle->producto->NOMBRE_PRODUCTO }}</td>
                                                <td>{{ $detalle->CANTIDAD_PRODUCTO }}</td>
                                                <td>${{ number_format($detalle->COSTO_PRODUCTO, 2) }}</td>
                                                <td>${{ number_format($detalle->CANTIDAD_PRODUCTO * $detalle->COSTO_PRODUCTO, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                            <td><strong>${{ number_format($orden->detalles->sum(function($detalle) {
                                                return $detalle->CANTIDAD_PRODUCTO * $detalle->COSTO_PRODUCTO;
                                            }), 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-buttons text-right">
                            <a href="#" class="invoice-btn">Imprimir Orden</a>
                            <a href="#" class="invoice-btn">Enviar Orden</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
