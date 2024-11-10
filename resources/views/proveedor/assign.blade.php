@extends('layouts.app')

@section('title', 'Asignación de producto')

@section('page-content')
    <div class="main-content">
        <div class="row">   
            <div class="col">
                <h1>Asignación de producto</h1>
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
                        <!-- Sección para asignar productos al proveedor -->
                        <div class="form-group">
                            <h4 class="header-title">Selección de productos</h4>
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

                        <table class="table mt-3" id="tabla-productos">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detalle_proveedor as $detalle)
                                    <tr>
                                        <td>{{ $detalle->producto->NOMBRE_PRODUCTO }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm delete-producto">Eliminar</button>
                                            <input type="hidden" name="productos[]" value="{{ $detalle->ID_PRODUCTO }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
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
    document.getElementById('add-producto').addEventListener('click', function () {
        const select = document.getElementById('productos');
        const productoId = select.value;
        const productoNombre = select.options[select.selectedIndex].text;

        // Validación de Producto Vacío
        if (!productoId) {
            alert('Por favor, seleccione un producto.');
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
                <button type="button" class="btn btn-danger btn-sm delete-producto">Eliminar</button>
                <input type="hidden" name="productos[]" value="${productoId}">
            </td>
        `;

        tbody.appendChild(row);
    });

    document.getElementById('tabla-productos').addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-producto')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection

