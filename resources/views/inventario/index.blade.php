@extends('layouts.app')
@section('title', 'Inventario')
@section('page-content')
    <div class="main-content">
        <div class="row">
            <div class="col">
                <h1>Inventario</h1>
            </div>

        </div>
        <div class="col-12 mt-2 alert-dismiss">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
                </div>
            @endif
        </div>
        <div class="col-12 mt-3">
            <div class="list-group">
                @foreach ($inventarios as $index => $inventario)
                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h4 class="mb-3">{{ $inventario->producto->NOMBRE_PRODUCTO }}</h4>
                            <small>{{ $inventario->updated_at->format('d/m/Y h:i A') }}</small>
                        </div>
                        <p class="mb-1"><span class="badge {{ $inventario->CANTIDAD_INVENTARIO < $inventario->producto->MINIMO_PRODUCTO ? 'badge-danger' : 'badge-primary' }} p-2"><b>Cantidad en existencia:</b> <span class="badge badge-light">{{ $inventario->CANTIDAD_INVENTARIO }}</span></span></p>
                    </a>
                @endforeach
                <nav aria-label="Inventarios Paginación" class="d-flex justify-content-end mt-3">
                    {{ $inventarios->links('pagination::bootstrap-4') }}
                </nav>
            </div>
        </div>
    </div>
@endsection
@section('custom-scripts')
@endsection
