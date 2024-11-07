@extends('layouts.app')

@section('title', 'Nuevo Proveedor')

@section('page-content')
    <div class="main-content">
        <h1>Nuevo Proveedor</h1>

        <div class="col-12 mt-5">
            <form action="{{ route('proveedor.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Información general.</h4>
                        <!-- Campos de información básica del proveedor -->
                        <div class="form-group">
                            <label for="nombreProveedor" class="d-inline-flex align-items-center">Nombre:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <input type="text" class="form-control @error('NOMBRE_PROVEEDOR') is-invalid @enderror"  
                                id="nombreProveedor" name="NOMBRE_PROVEEDOR"  
                                placeholder="Ingrese el nombre del proveedor"
                                value="{{ old('NOMBRE_PROVEEDOR') }}"> 
                            @error('NOMBRE_PROVEEDOR')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="correoProveedor" class="d-inline-flex align-items-center">Correo electrónico:<span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></label>
                            <!-- Validar formato de correo-->
                            <input type="email" class="form-control @error('CORREO_PROVEEDOR') is-invalid @enderror"  
                                id="correoProveedor" name="CORREO_PROVEEDOR"  
                                placeholder="Ingrese el correo del proveedor"
                                value="{{ old('CORREO_PROVEEDOR') }}"> 
                            @error('CORREO_PROVEEDOR')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telefonoProveedor">Teléfono:</label>
                            <!-- Máscara para teléfono-->
                            <input type="text" name="TELEFONO_PROVEEDOR" class="form-control @error('TELEFONO_PROVEEDOR') is-invalid @enderror"  
                                id="telefonoProveedor" 
                                placeholder="____-____"  
                                value="{{ old('TELEFONO_PROVEEDOR') }}" pattern="\d{4}-\d{4}"> 
                            @error('TELEFONO_PROVEEDOR')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="direccionProveedor">Dirección:</label>
                            <textarea class="form-control @error('DIRECCION_PROVEEDOR') is-invalid @enderror"  
                                    id="direccionProveedor" name="DIRECCION_PROVEEDOR"  
                                    rows="3" placeholder="Ingrese la dirección del proveedor">{{ old('DIRECCION_PROVEEDOR') }}</textarea>
                            @error('DIRECCION_PROVEEDOR')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Sección para asignar productos al proveedor -->
                        <div class="form-group">
                            <h4 class="header-title">Selección de productos <span class="text-danger ml-1" style="font-size: 0.7em;">(*)</span></h4>
                            <div class="form-row align-items-end">
                                <div class="col-md-8">
                                    <label for="productos">Producto:</label>
                                    <select id="productos" class="form-control">
                                        <option value="" disabled selected>Seleccione el producto</option>
                                        @foreach($productos as $producto)
                                            <option value="{{ $producto->ID_PRODUCTO }}">{{ $producto->NOMBRE_PRODUCTO }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <button type="button" id="add-producto" class="btn btn-secondary mt-2">Agregar Producto</button>
                                </div>
                            </div>
                        </div>

                        <table class="table mt-3" id="tabla-productos" style="display: none;">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('proveedor.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
<!-- Inclusión de jQuery Mask Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        // Aplicar máscara para el campo de teléfono 
        $('#telefonoProveedor').mask('0000-0000');
    });
</script>
<script>
    document.getElementById('add-producto').addEventListener('click', function () {
        const select = document.getElementById('productos');
        const productoId = select.value;
        const productoNombre = select.options[select.selectedIndex].text;

        if (!productoId) {
            alert('Por favor, seleccione un producto.');
            return;
        }

        const tbody = document.getElementById('tabla-productos').querySelector('tbody');
        const existingProducts = Array.from(tbody.querySelectorAll('input[name="productos[]"]')).map(input => input.value);

        if (existingProducts.includes(productoId)) {
            alert('El producto ya ha sido agregado.');
            return;
        }

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${productoNombre}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete-producto">Eliminar</button>
                <input type="hidden" name="productos[]" value="${productoId}">
            </td>
        `;

        tbody.appendChild(row);

        // Mostrar la tabla cuando se agrega el primer producto
        document.getElementById('tabla-productos').style.display = 'table';
    });

    document.getElementById('tabla-productos').addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-producto')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection



