@extends('layouts.app')

@section('title', 'Nuevo Proveedor')

@section('page-content')
    <div class="main-content">
        <h1>Nuevo Proveedor</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
                                <div class="col-md-4">
                                    <label for="productos">Producto:</label>
                                    <select id="productos" class="form-control">
                                        <option value="" disabled selected>Seleccione el producto</option>
                                        @foreach($productos as $producto)
                                            <option value="{{ $producto->ID_PRODUCTO }}" data-name="{{ $producto->NOMBRE_PRODUCTO }}">
                                                {{ $producto->NOMBRE_PRODUCTO }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="col-md-4">
                                    <label for="costo_producto">Costo del producto:</label>
                                    <input type="number" id="costo_producto" class="form-control" placeholder="Costo" min="0" step="0.01">
                                </div>
                        
                                <div class="col-md-4">
                                    <label for="precio_producto">Precio (con 15% de ganancia):</label>
                                    <input type="number" id="precio_producto" class="form-control" placeholder="Precio" readonly>
                                </div>
                            </div>
                            <div class="form-row align-items-end mt-2">
                                <div class="col-md-4">
                                    <label for="preferido_producto">¿Preferido?</label><br>
                                    <input type="radio" id="preferido_si" name="preferido_producto" value="1">
                                    <label for="preferido_si">Sí</label>
                                    <input type="radio" id="preferido_no" name="preferido_producto" value="0" checked>
                                    <label for="preferido_no">No</label>
                                </div>

                                <div class="col-md-4">
                                    <label for="proveedor_preferido">Proveedor Preferido:</label>
                                    <div id="proveedor_preferido">Seleccione un producto</div>
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
                                    <th>Costo</th>
                                    <th>Precio (con ganancia)</th>
                                    <th>Preferido</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <input type="hidden" name="productos" id="productos-hidden">
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
    // Cuando se ingresa el costo, se actualiza el precio con el 15% de ganancia
    document.getElementById('costo_producto').addEventListener('input', function() {
        var costo = parseFloat(this.value);
        if (!isNaN(costo) && costo > 0) {
            var precioConGanancia = costo * 1.15;

            // Establecer el valor del precio y desbloquear el campo de precio
            var precioProducto = document.getElementById('precio_producto');
            precioProducto.value = precioConGanancia.toFixed(2);
            precioProducto.removeAttribute('readonly');
            precioProducto.setAttribute('min', precioConGanancia.toFixed(2)); // Establecer el valor mínimo del precio
        } else {
            // Si no es un valor válido, bloquear el campo de precio y limpiar el valor
            var precioProducto = document.getElementById('precio_producto');
            precioProducto.value = '';
            precioProducto.setAttribute('readonly', 'true');
        }
    });

    document.getElementById('productos').addEventListener('change', function() {
        var productoId = this.value;
        if (productoId) {
            fetch(`/producto/${productoId}/preferredSupplier`)
                .then(response => response.json())
                .then(data => {
                    var proveedorPreferido = document.getElementById('proveedor_preferido');
                    proveedorPreferido.textContent = data && data.NOMBRE_PROVEEDOR ? data.NOMBRE_PROVEEDOR : 'No registra proveedor preferido';
                })
                .catch(error => {
                    console.error('Error al obtener el proveedor preferido:', error);
                    document.getElementById('proveedor_preferido').textContent = 'Error al cargar';
                });
        } else {
            document.getElementById('proveedor_preferido').textContent = 'Seleccione un producto';
        }
    });

    document.getElementById('add-producto').addEventListener('click', function () {
        var productos = document.getElementById('productos');
        var productoId = productos.value;
        var productoNombre = productos.options[productos.selectedIndex].text;
        var costoProducto = parseFloat(document.getElementById('costo_producto').value);
        var precioProducto = parseFloat(document.getElementById('precio_producto').value);
        var preferido = document.querySelector('input[name="preferido_producto"]:checked').value;

        // Verificar que los valores estén completos
        if (!productoId || isNaN(costoProducto) || isNaN(precioProducto)) {
            alert('Debe completar todos los campos del producto.');
            return;
        }

        // Obtener y parsear la lista de productos del input oculto
        var productosHidden = document.getElementById('productos-hidden');
        var productosList = JSON.parse(productosHidden.value || '[]');

        // Validar si el producto ya existe en la lista
        var productoExistente = productosList.find(producto => producto.id === productoId);
        if (productoExistente) {
            alert('Este producto ya se encuentra en la tabla.');
            return;
        }

        // Agregar producto a la tabla
        var tableBody = document.querySelector('#tabla-productos tbody');
        var newRow = `<tr data-id="${productoId}">
            <td>${productoNombre}</td>
            <td>${costoProducto.toFixed(2)}</td>
            <td>${precioProducto.toFixed(2)}</td>
            <td>${preferido === '1' ? 'Sí' : 'No'}</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-producto">Eliminar</button></td>
        </tr>`;
        tableBody.insertAdjacentHTML('beforeend', newRow);

        // Añadir a la lista de productos en el input oculto
        var productosHidden = document.getElementById('productos-hidden');
        var productosList = JSON.parse(productosHidden.value || '[]');
        productosList.push({ id: productoId, costo: costoProducto, precio: precioProducto, preferido: preferido });
        productosHidden.value = JSON.stringify(productosList);

        // Mostrar la tabla si está oculta
        document.getElementById('tabla-productos').style.display = 'table';

        // Limpiar los campos
        document.getElementById('costo_producto').value = '';
        document.getElementById('precio_producto').value = '';
        document.querySelector('input[name="preferido_producto"][value="0"]').checked = true;
        productos.selectedIndex = 0;
    });

    // Eliminar producto de la tabla
    document.querySelector('#tabla-productos').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-producto')) {
            var row = e.target.closest('tr');
            var productoId = row.getAttribute('data-id');
            console.log(productoId);
            // Eliminar la fila de la tabla
            row.remove();

            // Obtener y parsear la lista de productos del input oculto
            var productosHidden = document.getElementById('productos-hidden');
            var productosList = JSON.parse(productosHidden.value || '[]');
            // Filtrar el producto eliminado del array
            productosList = productosList.filter(producto => producto.id !== productoId);
            // Actualizar el input oculto con la lista actualizada
            productosHidden.value = JSON.stringify(productosList);

            // Ocultar la tabla si no hay más productos
            if (productosList.length === 0) {
                document.getElementById('tabla-productos').style.display = 'none';
            }
        }
    });
</script>
@endsection