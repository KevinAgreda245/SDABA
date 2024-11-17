@extends('layouts.app')

@section('title', 'Nueva Orden de Compra')

@section('page-content')
    <div class="main-content">
        <h1>Nuevo Orden de Compra</h1>
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
            <form action="{{ route('ordenProducto.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Información general</h4>
                        <!-- Campos de información básica de la orden -->
                        <div class="form-group">
                            <label for="proveedor">Proveedor:</label>
                            <select id="proveedor" name="proveedor" class="form-control">
                                <option value="" disabled selected>Seleccione el proveedor</option>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->ID_PROVEEDOR }}">
                                        {{ $proveedor->NOMBRE_PROVEEDOR }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sección para asignar productos a la orden -->
                        <div class="form-group">
                            <h4 class="header-title">Selección de productos</h4>
                            <div class="form-row align-items-end">
                                <div class="col-md-4">
                                    <label for="productos">Producto:</label>
                                    <select id="productos" name="producto" class="form-control" disabled>
                                        <option value="" disabled selected>Seleccione el producto</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="costo_producto">Costo del producto:</label>
                                    <input type="number" id="costo_producto" class="form-control" placeholder="Costo" min="0" step="0.01" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label for="precio_producto">Precio (con 15% de ganancia):</label>
                                    <input type="number" id="precio_producto" class="form-control" placeholder="Precio" readonly>
                                </div>
                            </div>
                            <div class="form-row align-items-end mt-2">
                                <div class="col-md-4">
                                    <label for="cantidad_producto">Cantidad:</label>
                                    <input type="number" id="cantidad_producto" class="form-control" min="1" value="1">
                                </div>

                                <div class="col-md-4">
                                    <label for="subtotal_producto">Subtotal:</label>
                                    <input type="number" id="subtotal_producto" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-row mt-2">
                                <div class="col-12">
                                    <button type="button" id="add-producto" class="btn btn-secondary">Agregar Producto</button>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla con productos seleccionados -->
                        <table class="table mt-3" id="tabla-productos">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Costo</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Total:</strong></td>
                                    <td><strong>$<span id="total-orden">0.00</span></strong></td>
                                </tr>
                            </tfoot>
                        </table>

                        <input type="hidden" name="productos" id="productos-hidden">
                        <button type="submit" class="btn btn-primary">Guardar Orden</button>
                        <a href="{{ route('ordenProducto.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
<script>
    // Cargar productos cuando se seleccione un proveedor
    document.getElementById('proveedor').addEventListener('change', function() {
        var proveedorId = this.value;
        if (proveedorId) {
            fetch(`/proveedor/${proveedorId}/productos`)
                .then(response => response.json())
                .then(data => {
                    var productosSelect = document.getElementById('productos');
                    productosSelect.innerHTML = '<option value="" disabled selected>Seleccione el producto</option>'; // Limpiar productos
                    data.forEach(producto => {
                        var option = document.createElement('option');
                        option.value = producto.ID_PRODUCTO;
                        option.textContent = producto.NOMBRE_PRODUCTO;
                        productosSelect.appendChild(option);
                    });
                    productosSelect.disabled = false; // Habilitar selección de productos
                })
                .catch(error => {
                    console.error('Error al cargar los productos:', error);
                });
        }
    });

    // Rellenar costo y precio al seleccionar un producto
    document.getElementById('productos').addEventListener('change', function() {
        var productoId = this.value;
        var proveedorSelect = document.getElementById('proveedor'); // Select del proveedor
        var proveedorId = proveedorSelect.value; // Obtener ID del proveedor seleccionado

        // Validar que se seleccionó un proveedor
        if (!proveedorId) {
            alert('Por favor seleccione un proveedor.');
            return;
        }

        if (productoId) {
            fetch(`/producto/${productoId}/proveedor/${proveedorId}`)
                .then(response => response.json())
                .then(data => {
                    var costo = parseFloat(data.costo);
                    var precio = parseFloat(data.precio);
                    document.getElementById('costo_producto').value = costo.toFixed(2);
                    document.getElementById('precio_producto').value = precio.toFixed(2);
                    document.getElementById('cantidad_producto').value = 1; // Reset cantidad
                    document.getElementById('subtotal_producto').value = precio.toFixed(2); // Subtotal por 1 unidad
                })
                .catch(error => {
                    console.error('Error al cargar el producto:', error);
                });
        }
    });

    // Calcular el subtotal al cambiar la cantidad
    document.getElementById('cantidad_producto').addEventListener('input', function() {
        var cantidad = parseInt(this.value);
        var precio = parseFloat(document.getElementById('costo_producto').value);
        var subtotal = cantidad * precio;
        document.getElementById('subtotal_producto').value = subtotal.toFixed(2);
    });

    // Agregar el producto a la tabla
    document.getElementById('add-producto').addEventListener('click', function () {
        var productoId = document.getElementById('productos').value;
        var productoNombre = document.getElementById('productos').options[document.getElementById('productos').selectedIndex].text;
        var cantidad = parseInt(document.getElementById('cantidad_producto').value);
        var costo = parseFloat(document.getElementById('costo_producto').value);
        var precio = parseFloat(document.getElementById('precio_producto').value);
        var subtotal = parseFloat(document.getElementById('subtotal_producto').value);

        // Verificar que todos los campos estén llenos
        if (!productoId || isNaN(cantidad) || isNaN(costo) || isNaN(precio)) {
            alert('Debe completar todos los campos del producto.');
            return;
        }

        // Añadir el producto a la tabla
        var tableBody = document.querySelector('#tabla-productos tbody');
        var newRow = `<tr data-id="${productoId}" data-precio="${precio.toFixed(2)}" data-costo="${costo.toFixed(2)}">
            <td>${productoNombre}</td>
            <td>
                <input type="number" class="cantidad-input form-control" value="${cantidad}" min="1" style="width: 80px;">
            </td>
            <td>${costo.toFixed(2)}</td>
            <td>${precio.toFixed(2)}</td>
            <td class="subtotal">${subtotal.toFixed(2)}</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-producto">Eliminar</button></td>
        </tr>`;
        tableBody.insertAdjacentHTML('beforeend', newRow);

        // Actualizar el total de la orden
        updateTotal();

        // Limpiar los campos
        document.getElementById('cantidad_producto').value = 1;
        document.getElementById('subtotal_producto').value = '';
        document.getElementById('proveedor').readonly = true; // Habilitar selección de productos
    });

    // Eliminar producto de la tabla
    document.querySelector('#tabla-productos').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-producto')) {
            var row = e.target.closest('tr');
            row.remove();
            updateTotal();
        }
    });
    // Escuchar cambios en las cantidades dentro de la tabla
document.querySelector('#tabla-productos').addEventListener('input', function (e) {
    if (e.target.classList.contains('cantidad-input')) {
        var input = e.target;
        var row = input.closest('tr'); // Fila actual
        var cantidad = parseInt(input.value);
        var precio = parseFloat(row.cells[2].textContent);

        // Validar la cantidad
        if (isNaN(cantidad) || cantidad <= 0) {
            alert('La cantidad debe ser un número mayor a 0.');
            input.value = 1; // Restaurar a 1 si el valor es inválido
            cantidad = 1;
        }

        // Calcular el nuevo subtotal
        var nuevoSubtotal = cantidad * precio;

        // Actualizar el subtotal en la tabla
        row.querySelector('.subtotal').textContent = nuevoSubtotal.toFixed(2);

        // Recalcular el total general
        updateTotal();
    }
});


    // Función para actualizar el total de la orden
    function updateTotal() {   
        var total = 0;
    var rows = document.querySelectorAll('#tabla-productos tbody tr');
    var productosData = [];

    rows.forEach(row => {
        var productoId = row.dataset.id;
        var cantidadInput = row.querySelector('.cantidad-input');
        var cantidad = cantidadInput ? cantidadInput.value.trim() : 0;

        if (isNaN(cantidad) || cantidad === "") {
            cantidad = 0; // Si la cantidad no es válida o vacía, asignar 0
        }

        // Obtener los valores de precio y costo desde los atributos de la fila
        var precio = parseFloat(row.dataset.precio);
        var costo = parseFloat(row.dataset.costo);

        // Obtener el subtotal desde la celda correspondiente
        var subtotal = costo * cantidad;
        total += subtotal;

        // Añadir los datos del producto con precio y costo
        productosData.push({
            producto_id: productoId,
            cantidad: parseInt(cantidad),
            precio: precio,
            costo: costo
        });
    });

    // Actualizar el total
    document.getElementById('total-orden').textContent = total.toFixed(2);

    // Guardar los productos como un campo oculto
    document.getElementById('productos-hidden').value = JSON.stringify(productosData);
    }
</script>
@endsection
