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
                            <li class="list-group-item">{{ $producto->NOMBRE_PRODUCTO }}</li>
                        @endforeach
                    </ul>
                @endif

                <a href="{{ route('proveedor.index') }}" class="btn btn-secondary mt-3">Volver</a>
            </div>
        </div>
    </div>
@endsection
