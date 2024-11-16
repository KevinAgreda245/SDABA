@extends('layouts.app')

@section('title', 'Editar Productos del Proveedor')

@section('page-content')
    <div class="main-content">
        <div class="row">   
            <div class="col">
                <h1>Editar Productos del Proveedor</h1>
            </div>
        </div>
        <div class="col-12 mt-2 alert-dismiss">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
                </div>
            @endif
        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('proveedor.updateAssign', $proveedor->ID_PROVEEDOR) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Agregar Nuevo Producto -->
                        <div class="form-group">
                            <h4 class="header-title">Agregar Nuevo Producto</h4>
                            <div class="form-row align-items-end">
                                <div class="col-md-4">
                                    <label for="nuevo_producto">Producto:</label>
                                    <select id="nuevo_producto" class="form-control">
                                        <option value="" disabled selected>Seleccione un producto</option>
                                        @foreach($productos as $producto)
                                            <option value="{{ $producto->ID_PRODUCTO }}">{{ $producto->NOMBRE_PRODUCTO }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="nuevo_costo">Costo:</label>
                                    <input type="number" id="nuevo_costo" class="form-control" step="0.01" placeholder="Costo">
                                </div>
                                <div class="col-md-4">
                                    <label for="nuevo_precio">Precio:</label>
                                    <input type="number" id="nuevo_precio" class="form-control" step="0.01" placeholder="Precio" readonly>
                                </div>
                            </div>
                            <div class="form-row align-items-end mt-2">
                                <div class="col-md-2">
                                    <label for="nuevo_preferido">¿Preferido?</label><br>
                                    <input type="radio" id="preferido_si" name="nuevo_preferido" value="1">
                                    <label for="preferido_si">Sí</label>
                                    <input type="radio" id="preferido_no" name="nuevo_preferido" value="0" checked>
                                    <label for="preferido_no">No</label>
                                </div>
                                <div class="col-md-4">
                                    <label for="proveedor_preferido">Proveedor Preferido:</label>
                                    <div id="proveedor_preferido">Seleccione un producto</div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="add-producto" class="btn btn-secondary mt-3">Agregar Producto</button>
                                </div>
                            </div>
                        </div>

                        <table class="table mt-3" id="tabla-productos">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Costo</th>
                                    <th>Precio</th>
                                    <th>Preferido</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detalle_proveedor as $detalle)
                                    <tr>
                                        <td>{{ $detalle->producto->NOMBRE_PRODUCTO }}</td>
                                        <td>
                                            <input type="number" 
                                                   name="costos[{{ $detalle->ID_PRODUCTO }}]" 
                                                   value="{{ $detalle->COSTO_PROVEEDOR }}" 
                                                   step="0.01" 
                                                   class="form-control" />
                                        </td>
                                        <td>
                                            <input type="number" 
                                                   name="precios[{{ $detalle->ID_PRODUCTO }}]" 
                                                   value="{{ $detalle->PRECIO_PROVEEDOR }}" 
                                                   step="0.01" 
                                                   class="form-control" />
                                        </td>
                                        <td>
                                            @if ($detalle->PREFERIDO_PROVEEDOR == 1)
                                                Sí
                                            @else
                                                No
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm delete-producto">Eliminar</button>
                                            <input type="hidden" name="productos[]" value="{{ $detalle->ID_PRODUCTO }}">
                                            <input type="hidden" name="preferidos[{{ $detalle->ID_PRODUCTO }}]" value="{{ $detalle->PREFERIDO_PROVEEDOR }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            <a href="{{ route('proveedor.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
<script>
    // Cuando se ingresa el costo, se actualiza el precio con el 15% de ganancia
    document.getElementById('nuevo_costo').addEventListener('input', function() {
        var costo = parseFloat(this.value);
        if (!isNaN(costo) && costo > 0) {
            var precioConGanancia = costo * 1.15;

            // Establecer el valor del precio y desbloquear el campo de precio
            var precioProducto = document.getElementById('nuevo_precio');
            precioProducto.value = precioConGanancia.toFixed(2);
            precioProducto.removeAttribute('readonly');
            precioProducto.setAttribute('min', precioConGanancia.toFixed(2)); // Establecer el valor mínimo del precio
        } else {
            // Si no es un valor válido, bloquear el campo de precio y limpiar el valor
            var precioProducto = document.getElementById('nuevo_precio');
            precioProducto.value = '';
            precioProducto.setAttribute('readonly', 'true');
        }
    });

    document.getElementById('nuevo_producto').addEventListener('change', function() {
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
        const selectProducto = document.getElementById('nuevo_producto');
        const productoId = selectProducto.value;
        const productoNombre = selectProducto.options[selectProducto.selectedIndex].text;
        const costo = document.getElementById('nuevo_costo').value;
        const precio = document.getElementById('nuevo_precio').value;
        const preferido = document.querySelector('input[name="nuevo_preferido"]:checked').value;

        // Validar los datos ingresados
        if (!productoId || !costo || !precio) {
            alert('Por favor, complete todos los campos para agregar un producto.');
            return;
        }

        const tbody = document.getElementById('tabla-productos').querySelector('tbody');
        const existingProducts = Array.from(tbody.querySelectorAll('input[name="productos[]"]')).map(input => input.value);

        // Validación de Producto Duplicado
        if (existingProducts.includes(productoId)) {
            alert('El producto ya ha sido agregado.');
            return;
        }

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${productoNombre}</td>
            <td>
                <input type="number" name="costos[${productoId}]" value="${costo}" step="0.01" class="form-control" />
            </td>
            <td>
                <input type="number" name="precios[${productoId}]" value="${precio}" step="0.01" class="form-control" />
            </td>
            <td>${preferido == 1 ? 'Sí' : 'No'}
                <input type="hidden" name="preferidos[${productoId}]" value="${preferido}">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete-producto">Eliminar</button>
                <input type="hidden" name="productos[]" value="${productoId}">
            </td>
        `;

        tbody.appendChild(row);

        // Limpiar campos
        selectProducto.value = '';
        document.getElementById('nuevo_costo').value = '';
        document.getElementById('nuevo_precio').value = '';
        document.querySelector('input[name="nuevo_preferido"][value="0"]').checked = true;
    });

    document.getElementById('tabla-productos').addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-producto')) {
            e.target.closest('tr').remove();
        }
    });

    document.getElementById('tabla-productos').addEventListener('input', function (e) {
    if (e.target.name && e.target.name.startsWith('costos[')) {
        // Identificar la fila donde está el input que cambió
        const row = e.target.closest('tr');
        const costoInput = e.target;
        const precioInput = row.querySelector('input[name^="precios["]');

        if (costoInput && precioInput) {
            const costo = parseFloat(costoInput.value) || 0; // Convertir a número o usar 0 si está vacío
            const nuevoPrecio = (costo * 1.15).toFixed(2); // Calcular el precio con un 15%
            precioInput.value = nuevoPrecio; // Asignar el nuevo precio al campo correspondiente
        }
    }
});
</script>
@endsection
