@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-content')
    <div class="main-content-inner">
        <h1>¡Bienvenido Kevin Agreda!</h1>    
        <div class="row">
            <div class="col-md-4 mt-5 mb-3">
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
            <div class="col-md-4 mt-md-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg2">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="ti-share"></i> Inventario</div>
                            <h2>3,984</h2>
                        </div>
                        <canvas id="seolinechart2" height="50"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-md-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg4">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="ti-share"></i> Ventas</div>
                            <h2>3,984</h2>
                        </div>
                        <canvas id="seolinechart2" height="50"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection