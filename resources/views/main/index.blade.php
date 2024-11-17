@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-content')
    <div class="main-content-inner">
        <h1>¡Bienvenido Kevin Agreda!</h1>    
        <div class="row">
            <div class="col-xs-12 col-md-4 mt-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="ti-package"></i> Productos</div>
                            <h2>{{ $cantidadProductos }}</h2>
                        </div>
                        <canvas id="seolinechart1" height="50"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-4 mt-md-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg2">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="ti-share"></i> Órdenes registradas</div>
                            <h2>{{ $cantidadOrdenesRegistradas }}</h2>
                        </div>
                        <canvas id="seolinechart2" height="50"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-4 mt-md-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg4">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="ti-share"></i> Órdenes autorizadas</div>
                            <h2>{{ $cantidadOrdenesPendientes }}</h2>
                        </div>
                        <canvas id="seolinechart2" height="50"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">Resumen de inventario</h4>
                    </div>
                    <div>
                        <canvas id="inventarioChart" width="400" height="200"></canvas>        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">Producto por tipo de producto</h4>
                    </div>
                    <div>
                        <canvas id="productosPorTipoChart" width="400" height="200"></canvas>      
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos pasados desde el controlador
    const productos = @json($productosConMenosInventario->pluck('producto.NOMBRE_PRODUCTO'));
    const cantidades = @json($productosConMenosInventario->pluck('CANTIDAD_INVENTARIO'));

    // Crear el gráfico con Chart.js
    const ctx = document.getElementById('inventarioChart').getContext('2d');
    const inventarioChart = new Chart(ctx, {
        type: 'line', // Tipo de gráfico lineal
        data: {
            labels: productos, // Nombres de los productos
            datasets: [{
                label: 'Cantidad en Inventario',
                data: cantidades, // Datos de cantidad
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const tipos2 = @json($productosPorTipo->pluck('tipoProducto.NOMBRE_TIPO_PRODUCTO'));
    const cantidades2 = @json($productosPorTipo->pluck('cantidad'));

    // Función para generar un color aleatorio en formato rgba
    function getRandomColor() {
        const r = Math.floor(Math.random() * 256);
        const g = Math.floor(Math.random() * 256);
        const b = Math.floor(Math.random() * 256);
        return `rgba(${r}, ${g}, ${b}, 0.2)`; // Color de fondo
    }

    // Generar un array de colores aleatorios para las barras
    const colors = tipos2.map(() => getRandomColor());

    const ctx2 = document.getElementById('productosPorTipoChart').getContext('2d');
    const productosPorTipoChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: tipos2,  // Etiquetas de tipos de productos
            datasets: [{
                label: 'Cantidad de Productos por Tipo',
                data: cantidades2,  // Cantidad de productos por tipo
                backgroundColor: colors,
                borderColor: colors.map(color => color.replace('0.2', '1')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tipo de Producto'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Cantidad de Productos'
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection