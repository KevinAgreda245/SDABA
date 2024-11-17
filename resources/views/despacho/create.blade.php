@extends('layouts.app')

@section('title', 'Nuevo Despacho')

@section('page-content')
    <div class="main-content">
        <h1>Nuevo Despacho</h1>
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
            <form action="{{ route('despacho.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Información general</h4>
                        <!-- Campo para seleccionar el producto -->
                        <div class="form-group">
                            <label for="producto">Producto:</label>
                            <select id="producto" name="producto" class="form-control">
                                <option value="" disabled selected>Seleccione el producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->ID_INVENTARIO }}" 
                                            data-nombre="{{ $producto->producto->NOMBRE_PRODUCTO }}"
                                            data-stock="{{ $producto->CANTIDAD_INVENTARIO }}"
                                            data-precio="{{ $producto->PRECIO_INVENTARIO }}">
                                        {{ $producto->producto->NOMBRE_PRODUCTO }} (Stock: {{ $producto->CANTIDAD_INVENTARIO }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Campo para seleccionar la cantidad -->
                        <div class="form-group">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" id="cantidad" class="form-control" min="1" value="1">
                        </div>

                        <!-- Sección para agregar productos al despacho -->
                        <div class="form-row align-items-end">
                            <div class="col-md-4">
                                <button type="button" id="add-producto" class="btn btn-secondary">Agregar Producto</button>
                            </div>
                        </div>

                        <!-- Tabla con productos agregados al despacho -->
                        <table class="table mt-3" id="tabla-productos">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total Despacho:</strong></td>
                                    <td><strong><span id="total-despacho">0.00</span></strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        

                        <input type="hidden" name="productos" id="productos-hidden">
                        <button type="submit" class="btn btn-primary">Guardar Despacho</button>
                        <a href="{{ route('despacho.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
<script>
    // Agregar producto al despacho
document.getElementById('add-producto').addEventListener('click', function () {
    var productoId = document.getElementById('producto').value;
    var productoNombre = document.getElementById('producto').selectedOptions[0].getAttribute('data-nombre');
    var stockDisponible = parseInt(document.getElementById('producto').selectedOptions[0].getAttribute('data-stock'));
    var cantidad = parseInt(document.getElementById('cantidad').value);
    var precioVenta = parseFloat(document.getElementById('producto').selectedOptions[0].getAttribute('data-precio'));

    // Verificar que la cantidad no exceda el stock disponible
    if (cantidad > stockDisponible) {
        alert(`No puedes agregar más de ${stockDisponible} unidades del producto.`);
        return;
    }

    if (!productoId || isNaN(cantidad) || cantidad <= 0) {
        alert('Debe completar todos los campos.');
        return;
    }

     // Verificar si el producto ya está en la tabla
    var existingProduct = document.querySelector(`#tabla-productos tbody tr[data-id="${productoId}"]`);
    if (existingProduct) {
        alert('Este producto ya ha sido agregado al despacho.');
        return;
    }

    // Calcular el subtotal para este producto
    var subtotal = precioVenta * cantidad;

    // Añadir el producto a la tabla
    var tableBody = document.querySelector('#tabla-productos tbody');
    var newRow = `<tr data-id="${productoId}" data-nombre="${productoNombre}" data-cantidad="${cantidad}" data-precio="${precioVenta}">
        <td>${productoNombre}</td>
        <td>${cantidad}</td>
        <td>${precioVenta.toFixed(2)}</td>
        <td>${subtotal.toFixed(2)}</td>
        <td><button type="button" class="btn btn-danger btn-sm remove-producto">Eliminar</button></td>
    </tr>`;
    tableBody.insertAdjacentHTML('beforeend', newRow);

    // Actualizar el total del despacho
    updateTotal();

    // Limpiar los campos
    document.getElementById('cantidad').value = 1;
    document.getElementById('producto').value = ""; // Reset producto
});

// Eliminar producto de la tabla
document.querySelector('#tabla-productos').addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-producto')) {
        var row = e.target.closest('tr');
        row.remove();
        updateTotal();
    }
});

// Función para actualizar el total del despacho
function updateTotal() {
    var totalDespacho = 0;
    var rows = document.querySelectorAll('#tabla-productos tbody tr');

    rows.forEach(row => {
        var cantidad = parseInt(row.dataset.cantidad);
        var precio = parseFloat(row.dataset.precio);
        var subtotal = cantidad * precio;
        row.querySelector('td:nth-child(4)').textContent = subtotal.toFixed(2); // Actualizar el subtotal en la tabla
        totalDespacho += subtotal;
    });

    // Actualizar el total del despacho
    document.getElementById('total-despacho').textContent = totalDespacho.toFixed(2);
    
    // Guardar los productos como un campo oculto
    var productosData = [];
    rows.forEach(row => {
        productosData.push({
            producto_id: row.dataset.id,
            cantidad: row.dataset.cantidad,
            precio: row.dataset.precio
        });
    });
    document.getElementById('productos-hidden').value = JSON.stringify(productosData);
}    
</script>
@endsection
