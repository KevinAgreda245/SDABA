@extends('layouts.app')
@section('title', 'Seleccionar Tipo de Reporte')
@section('page-content')
    <div class="main-content">
        <h1>Seleccionar Tipo de Reporte</h1>
        
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Elija un tipo de reporte</h4>

                    <form action="{{ route('reporte.generar') }}" method="GET">
                        @csrf
                        
                        <div class="form-group">
                            <label for="reporte_tipo">Tipo de Reporte:</label>
                            <select class="form-control" id="reporte_tipo" name="reporte_tipo">
                                <option value="inventario">Reporte de Inventarios</option>
                                <option value="orden">Reporte de Ordenes de compras</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Generar Reporte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection