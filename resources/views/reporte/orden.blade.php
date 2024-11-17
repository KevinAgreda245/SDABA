<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Órdenes de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            text-align: left;
            background-color: #004085;
            color: #fff;
            padding: 10px 20px;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 0;
            font-size: 16px;
        }

        .content {
            padding: 20px;
            flex: 1;
            height: 70vh;
        }

        .content p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .table, .table th, .table td {
            border: 1px solid #ccc;
        }

        .table th {
            background-color: #007bff;
            color: white;
            text-align: left;
            padding: 10px;
        }

        .table td {
            padding: 10px;
        }

        .table tfoot td {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #555;
            padding: 10px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Órdenes de Compra</h1>
    </div>

    <div class="content">
        <p><strong>Fecha de Generación:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>

    @foreach($ordenes as $orden)
        <div class="content">
            <h2>Orden de Compra - <i>#{{ str_pad($orden->ID_ORDEN_COMPRA, 5, '0', STR_PAD_LEFT) }}</i></h2>
            <p><strong>Proveedor:</strong> {{ $orden->proveedor->NOMBRE_PROVEEDOR }}</p>
            <p><strong>Correo:</strong> {{ $orden->proveedor->CORREO_PROVEEDOR }}</p>
            <p><strong>Teléfono:</strong> {{ $orden->proveedor->TELEFONO_PROVEEDOR }}</p>
            @if($orden->proveedor->DIRECCION_PROVEEDOR)
                <p><strong>Dirección:</strong> {{ $orden->proveedor->DIRECCION_PROVEEDOR }}</p>
            @endif
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Costo Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orden->detalles as $index => $detalle)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detalle->producto->NOMBRE_PRODUCTO }}</td>
                        <td>{{ $detalle->CANTIDAD_PRODUCTO }}</td>
                        <td>${{ number_format($detalle->COSTO_PRODUCTO, 2) }}</td>
                        <td>${{ number_format($detalle->CANTIDAD_PRODUCTO * $detalle->COSTO_PRODUCTO, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Total:</td>
                    <td>${{ number_format($orden->detalles->sum(function($detalle) {
                        return $detalle->CANTIDAD_PRODUCTO * $detalle->COSTO_PRODUCTO;
                    }), 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <hr>
    @endforeach

    <div class="footer">
        <p>Generado por: Kevin Agreda</p>
    </div>
</body>
</html>

<body>
    <div class="header">
        <h1>Reporte de Órdenes de Compras</h1>
    </div>

    <div class="content">
        <p><strong>Fecha de Generación:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordenes as $orden)
                @foreach($orden->detalles as $index => $detalle)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detalle->producto->NOMBRE_PRODUCTO }}</td>
                        <td>{{ $detalle->CANTIDAD_PRODUCTO }}</td>
                        <td>${{ number_format($detalle->COSTO_PRODUCTO, 2) }}</td>
                        <td>${{ number_format($detalle->CANTIDAD_PRODUCTO * $detalle->COSTO_PRODUCTO, 2) }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total:</td>
                <td>${{ number_format($ordenes->sum(function($orden) {
                    return $orden->detalles->sum(function($detalle) {
                        return $detalle->CANTIDAD_PRODUCTO * $detalle->COSTO_PRODUCTO;
                    });
                }), 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Fecha de Generación: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }} por Kevin Agreda</p>
    </div>
</body>
</html>
