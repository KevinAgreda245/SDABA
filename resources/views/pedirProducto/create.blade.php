@extends('layouts.app')
@section('title', 'Pedir producto')
@section('page-content')
    <div class="main-content">
        <h1>Pedir producto</h1>
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h3 class="header-title">Detalle del producto</h3>
                    {{-- mostrar datos del producto recibido en una card--}}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p><strong>Producto:</strong> {{ $inventario->producto->NOMBRE_PRODUCTO }}</p>
                                    <p><strong>Existencias:</strong> {{ $inventario->CANTIDAD_INVENTARIO }}</p>
                                    <p><strong>Tipo de producto:</strong> {{ $inventario->producto->tipoProducto->NOMBRE_TIPO_PRODUCTO }}</p>
                                    <p><strong>Fecha de compra:</strong> {{ $inventario->created_at }}</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Descripción:</strong> {{ $inventario->producto->DESCRIPCION_PRODUCTO }}</p>
                                    <p><strong>Costo individ:</strong> ${{ $inventario->PRECIO_INVENTARIO }}</p>
                                    <p><strong>Unidades minimas:</strong> {{ $inventario->producto->MINIMO_PRODUCTO }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- formulario para solicitar pedido --}}
                    {{-- titulo del formulario --}}
                    <h3 class="header-title mt-5">Solicitar pedido</h3>
                    {{-- formulario en una card--}}
                    <div class="card">
                        <div class="card-body">
                            {{-- formulario para solicitar pedido --}}
                            <form action="{{ route('ordenProducto.store') }}" method="POST">
                                @csrf <!-- Token CSRF para seguridad -->
                        
                                <div class="form-group">
                                    {{-- dropdown con listado de proveedores --}}
                                    <label for="proveedor">Proveedor:</label>
                                    <select class="form-control @error('ID_PROVEEDOR') is-invalid @enderror" 
                                        id="ID_PROVEEDOR" name="ID_PROVEEDOR">
                                        <option value="">Seleccione un proveedor</option>
                                        @foreach ($proveedores as $proveedor)
                                            <option value="{{ $proveedor->ID_PROVEEDOR }}">{{ $proveedor->NOMBRE_PROVEEDOR }}
                                            </option>
                                        @endforeach
                                    </select>                                    
                                </div>
                        
                                <div class="form-group">
                                   {{-- cantidad de productos a solicitar --}}
                                    <label for="cantidad">Cantidad:</label>
                                    <input type="number" class="form-control @error('CANTIDAD_PEDIDO') is-invalid @enderror"
                                        id="CANTIDAD_PEDIDO" name="CANTIDAD_PEDIDO" value="{{ old('CANTIDAD_PEDIDO') }}">
                                    @error('CANTIDAD_PEDIDO')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                               
                                <div class="form-group">
                                     {{-- Costo del producto --}}
                                     <label for="cantidad">Costo individual:</label>
                                     <input type="number" class="form-control @error('COSTO_PRODUCTO') is-invalid @enderror"
                                         id="COSTO_PRODUCTO" name="COSTO_PRODUCTO" value="{{ old('COSTO_PRODUCTO') }}">
                                     @error('COSTO_PRODUCTO')
                                         <span class="text-danger">{{ $message }}</span>
                                     @enderror
                                 </div>

                                 <div class="form-group">
                                    {{-- PRECIO del producto --}}
                                    <label for="cantidad">Precio individual:</label>
                                    <input type="number" class="form-control @error('PRECIO_PRODUCTO') is-invalid @enderror"
                                        id="PRECIO_PRODUCTO" name="PRECIO_PRODUCTO" value="{{ old('PRECIO_PRODUCTO') }}">
                                    @error('PRECIO_PRODUCTO')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- input hiden para el producto --}}
                                <input type="hidden" name="ID_PRODUCTO" id="ID_PRODUCTO" value="{{ $inventario->producto->ID_PRODUCTO }}">
                                
                        
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Cancelar</a>
                            </form>
                        </div>
                    </div>
                    
        
                </div>
            </div>
        </div>
    @endsection
