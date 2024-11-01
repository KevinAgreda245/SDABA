@extends('layouts.app')
@section('title', 'Pedir producto')
@section('page-content')
    <div class="main-content">
        <h1>Pedir producto</h1>
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h3 class="header-title">Detalle del producto</h3>
                        {{-- mostrar datos del producto recibido --}}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $producto->id }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->descripcion }}</td>
                                    <td>{{ $producto->precio }}</td>
                                    <td>{{ $producto->cantidad }}</td>
                                </tr>
                            </tbody>
                        </table>

                </div>
            </div>
        </div>
@endsection