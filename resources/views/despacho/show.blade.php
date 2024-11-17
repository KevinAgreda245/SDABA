@extends('layouts.app')

@section('title', 'Detalle del Despacho')

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
                                        <span>Despacho de Producto</span>
                                    </div>
                                    <div class="iv-right col-6 text-md-right">
                                        <span>#{{ str_pad($despacho->ID_DESPACHO, 5, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="invoice-address">
                                        <h3>{{ $despacho->usuario->NOMBRE_USUARIO }} {{ $despacho->usuario->APELLIDO_USUARIO }}</h3>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <ul class="invoice-date">
                                        <li>Fecha de Despacho: {{ \Carbon\Carbon::parse($despacho->FECHA_DESPACHO)->format('d/m/Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-table table-responsive mt-5">
                                <table class="table table-bordered table-hover text-right">
                                    <thead>
                                        <tr class="text-capitalize">
                                            <th class="text-center" style="width: 5%;">N°</th>
                                            <th class="text-left" style="width: 45%; min-width: 130px;">Descripción</th>
                                            <th>Cantidad Despachada</th>
                                            <th style="min-width: 100px">Precio Unitario</th>
                                            <th>Precio Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($despacho->detalles as $index => $detalle)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="text-left">{{ $detalle->producto->NOMBRE_PRODUCTO }}</td>
                                                <td>{{ $detalle->CANTIDAD }}</td>
                                                <td>${{ number_format($detalle->PRECIO_PRODUCTO, 2) }}</td>
                                                <td>${{ number_format($detalle->CANTIDAD* $detalle->PRECIO_PRODUCTO, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Total Despachado:</strong></td>
                                            <td><strong>${{ number_format($despacho->detalles->sum(function($detalle) {
                                                return $detalle->CANTIDAD * $detalle->PRECIO_PRODUCTO;
                                            }), 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-buttons text-right">
                            <a href="{{ route('despacho.index') }}" class="invoice-btn">Volver</a>
                            <a href="{{ route('despacho.pdf', $despacho->ID_DESPACHO) }}" class="invoice-btn">Imprimir Despacho</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
