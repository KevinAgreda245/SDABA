@extends('layouts.app')
@section('title', 'Nuevo Tipo de Productos')
@section('page-content')
    <div class="main-content">
        <h1>Nuevo Tipo de Producto</h1>
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Información general.</h4>
                    <form action="{{ route('tipoProducto.store') }}" method="POST">
                        @csrf <!-- Token CSRF para seguridad -->
                
                        <div class="form-group">
                            <label for="nombreTipoProducto" class="d-inline-flex align-items-center">Nombre:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <input type="text" class="form-control @error('NOMBRE_TIPO_PRODUCTO') is-invalid @enderror" 
                                id="nombreTipoProducto" name="NOMBRE_TIPO_PRODUCTO" 
                                placeholder="Ingrese el nombre del tipo de producto" 
                                value="{{ old('NOMBRE_TIPO_PRODUCTO') }}">
                            @error('NOMBRE_TIPO_PRODUCTO')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="descripcionTipoProducto">Descripción:</label>
                            <textarea class="form-control @error('DESCR_TIPO_PRODUCTO') is-invalid @enderror" 
                                    id="descripcionTipoProducto" name="DESCR_TIPO_PRODUCTO" 
                                    rows="3" placeholder="Ingrese una descripción">{{ old('DESCR_TIPO_PRODUCTO') }}</textarea>
                            @error('DESCR_TIPO_PRODUCTO')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('tipoProducto.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
@endsection