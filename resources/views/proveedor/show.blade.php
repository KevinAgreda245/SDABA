@extends('layouts.app')

@section('title', 'Productos del Proveedor')

@section('page-content')
    <div class="main-content">
        <h1>Productos asignados a {{ $proveedor->NOMBRE_PROVEEDOR }}</h1>

        <div class="card mt-3">
            <div class="card-body">
                <h4 class="header-title">Productos</h4>

                @if($productos->isEmpty())
                    <p class="text-muted">No hay productos asignados a este proveedor.</p>
                @else
                    <ul class="list-group">
                        @foreach ($productos as $producto)
                            <div class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $producto->NOMBRE_PRODUCTO }}</h5>
                                </div>
                                <p class="mb-1">${{ number_format($producto->PRECIO_PROVEEDOR, 2) }}</p>
                                @if ($producto->PREFERIDO_PROVEEDOR == 1)
                                    <span class="badge badge-success">Proveedor preferido</span>
                                @endif
                                
                            </div>    
                        @endforeach
                    </ul>
                @endif

                <a href="{{ route('proveedor.index') }}" class="btn btn-secondary mt-3">Volver</a>
            </div>
        </div>
    </div>
@endsection
