@extends('layouts.app')
@section('title', 'Editar Producto')
@section('page-content')
    <div class="main-content">
        <h1>Editar Producto</h1>
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Información general.</h4>
                    <form action="{{ route('producto.update', $producto->ID_PRODUCTO) }}" method="POST">
                        @csrf <!-- Token CSRF para seguridad -->
                        @method('PUT')
                        <!-- Nombre del producto -->
                        <div class="form-group">
                            <label for="nombre_producto">Nombre del Producto:</label>
                            <input type="text" class="form-control @error('nombre_producto') is-invalid @enderror" 
                                id="nombre_producto" name="nombre_producto" 
                                value="{{ old('nombre_producto', $producto->NOMBRE_PRODUCTO) }}" required>
                            @error('nombre_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descripción del producto -->
                        <div class="form-group">
                            <label for="descripcion_producto">Descripción del Producto:</label>
                            <textarea class="form-control @error('descripcion_producto') is-invalid @enderror" 
                                id="descripcion_producto" name="descripcion_producto" rows="3">{{ old('descripcion_producto', $producto->DESCRIPCION_PRODUCTO) }}</textarea>
                            @error('descripcion_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mínimo de producto -->
                        <div class="form-group">
                            <label for="minimo_producto">Mínimo del Producto:</label>
                            <input type="number" class="form-control @error('minimo_producto') is-invalid @enderror" 
                                id="minimo_producto" name="minimo_producto" 
                                value="{{ old('minimo_producto', $producto->MINIMO_PRODUCTO) }}" required>
                            @error('minimo_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tipo de Producto -->
                        <div class="form-group">
                            <label for="id_tipo_producto">Tipo de Producto:</label>
                            <select name="id_tipo_producto" id="id_tipo_producto" class="form-control @error('id_tipo_producto') is-invalid @enderror" required>
                                @foreach($tiposProducto as $tipo)
                                    <option value="{{ $tipo->ID_TIPO_PRODUCTO }}" {{ $producto->ID_TIPO_PRODUCTO == $tipo->ID_TIPO_PRODUCTO ? 'selected' : '' }}>
                                        {{ $tipo->NOMBRE_TIPO_PRODUCTO }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_tipo_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('producto.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
@endsection