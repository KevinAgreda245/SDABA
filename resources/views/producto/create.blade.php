@extends('layouts.app')
@section('title', 'Nuevo Productos')
@section('page-content')
    <div class="main-content">
        <h1>Nuevo Producto</h1>
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Información general.</h4>
                    <form action="{{ route('producto.store') }}" method="POST">
                        @csrf <!-- Token CSRF para seguridad -->
                
                        <div class="form-group">
                            <label for="nombreProducto" class="d-inline-flex align-items-center">Nombre:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <input type="text" class="form-control @error('nombre_producto') is-invalid @enderror" 
                                   id="nombreProducto" name="nombre_producto" 
                                   placeholder="Ingrese el nombre del producto" 
                                   value="{{ old('nombre_producto') }}">
                            @error('nombre_producto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="descripcionProducto">Descripción:</label>
                            <textarea class="form-control @error('descripcion_producto') is-invalid @enderror" 
                                      id="descripcionProducto" name="descripcion_producto" 
                                      rows="3" placeholder="Ingrese una descripción">{{ old('descripcion_producto') }}</textarea>
                            @error('descripcion_producto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="minimoProducto" class="d-inline-flex align-items-center">Cantidad mínima:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <input type="number" class="form-control @error('minimo_producto') is-invalid @enderror" 
                                   id="minimoProducto" name="minimo_producto" 
                                   placeholder="Ingrese la cantidad mínima" 
                                   value="{{ old('minimo_producto') }}" min="0">
                            @error('minimo_producto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="tipoProducto" class="d-inline-flex align-items-center">Tipo de Producto:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <select class="form-control @error('id_tipo_producto') is-invalid @enderror" 
                                    id="tipoProducto" name="id_tipo_producto">
                                <option value="">Seleccione un tipo de producto</option>
                                @foreach($tiposProducto as $tipo)
                                    <option value="{{ $tipo->ID_TIPO_PRODUCTO }}" {{ old('id_tipo_producto') == $tipo->ID_TIPO_PRODUCTO ? 'selected' : '' }}>
                                        {{ $tipo->NOMBRE_TIPO_PRODUCTO }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_tipo_producto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('producto.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
@endsection