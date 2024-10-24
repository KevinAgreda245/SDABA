@extends('layouts.app')
@section('title', 'Tipo de Productos')
@section('page-content')
    <div class="main-content">
        <div class="row">
            <div class="col">
                <h1>Inventario</h1>
            </div>

        </div>
        <div class="col-12 mt-2 alert-dismiss">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
                </div>
            @endif
        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Inventario</h4>
                    <div class="data-tables datatable-dark">
                        <table id="tbl-tipo" class="text-center">
                            <thead class="text-capitalize">
                                <tr>
                                    <th>Producto</th>
                                    <th>Existencias</th>
                                    <th>Tipo de producto</th>
                                    <th>Fecha de compra</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventarios as $index => $inventario)
                                    <tr>
                                        <td>{{ $inventario->producto->NOMBRE_PRODUCTO }}</td>
                                        <td>{{ $inventario->CANTIDAD_INVENTARIO }}</td>
                                        <td>{{ $inventario->producto->tipoProducto->NOMBRE_TIPO_PRODUCTO }}</td>
                                        <td>{{ $inventario->created_at; }}</td>
                                        <td>
                                           
                                            <a href=""
                                                class="btn btn-primary btn-xs"> Agregar pedido
                        
                                            </a>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-scripts')
    <script>
        $(document).ready(function() {
            initTable('#tbl-tipo');
        });
    </script>
@endsection
