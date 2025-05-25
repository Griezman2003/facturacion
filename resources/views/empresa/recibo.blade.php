<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura CFDI 4.0</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: white;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #4CAF50;
        }
        .totals {
            text-align: right;
        }
        .totals .total-row {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .bordered {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h2>Factura Electrónica CFDI 4.0</h2>
                <p><strong>Serie:</strong> {{ $datos['serie'] ?? 'Ingrese datos en su perfil' }} | <strong>Folio:</strong> {{ $datos['folio'] ?? 'N/A' }}</p>
                <p><strong>Fecha:</strong> {{ $datos['fecha'] ?? 'N/A' }}</p>
                <p><strong>Tipo de comprobante:</strong>  {{ $datos['comprobanteFactura'] ?? 'N/A' }}</p>
                <p><strong>Lugar de Expedición:</strong> {{ $datos['lugar_expedicion'] ?? 'N/A' }}</p>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 bordered">
                    <h5>Emisor</h5>
                    <p><strong>RFC:</strong> {{ $datos['rfcEmisor'] ?? 'N/A' }}</p>
                    <p><strong>Nombre:</strong> {{ $datos['nombre_emisor'] ?? 'N/A' }}</p>
                    <p><strong>Régimen Fiscal:</strong> {{ $datos['regimen_fiscal'] ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 bordered">
                    <h5>Receptor</h5>
                    <p><strong>RFC:</strong> {{ $datos['rfcReceptor'] ?? 'N/A' }}</p>
                    <p><strong>Nombre:</strong> {{ $datos['nombre_receptor'] ?? 'N/A' }}</p>
                    <p><strong>Uso del CFDI:</strong> {{ $datos['uso_cfdi'] ?? 'N/A' }}</p>
                    <p><strong>Domicilio Fiscal:</strong> {{ $datos['domicilioReceptor'] ?? 'N/A' }}</p>
                    <p><strong>Régimen Fiscal:</strong> {{ $datos['regimenFiscal'] ?? 'N/A' }}</p>
                </div>
            </div>
            <h5>Conceptos</h5>
            <table id="recibo" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Clave Producto/Servicio</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Valor Unitario</th>
                        <th>Descuento</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
    @foreach ($productos as $producto)
        <tr>
            <td>{{ $producto['claveProductoServicio'] }}</td>
            <td>{{ $producto['descripcion'] }}</td>
            <td>{{ $producto['cantidad'] }}</td>
            <td>{{ $producto['claveUnidad'] }}</td>
            <td>${{ number_format($producto['valorUnitario'], 2) }}</td>
            <td>${{ number_format($producto['descuento'], 2) }}</td>
            <td>${{ number_format($producto['importe'], 2) }}</td>
        </tr>
    @endforeach
</tbody>
    </table>
  <div class="row mt-4">

    <div class="col-md-6 totals">
    <p><strong>Subtotal:</strong> ${{ number_format($subtotal, 2) }}</p>
    <p><strong>IVA:</strong> ${{ number_format($totalImpuesto, 2) }}</p>
    <p class="total-row"><strong>Total:</strong> ${{ number_format($totalFinal, 2) }}</p>
    </div>
    
    <div class="col-md-6">
        <h5>Comentarios</h5>
        <p>Gracias por su preferencia.</p>
    </div>

</div>

        </div>
        <div class="row">
            <div class="col-md-6">
                {!! $qr_code !!}
            </div>
            <div class="col-md-8">
                    <div class="digital-signature">
                        <h5 class="mb-3">Información Adicional</h5>
                        <div class="mt-4">
                            <strong class="pt-3">Cadena Original del complemento de certificación digital del SAT:</strong>
                            <div class="sello-digital mt-2">{{ $cadena_original ?? 'N/A' }}</div>
                        </div>
                        <div class="mt-4">
                            <strong class="pt-3">Sello Digital del CFDI:</strong>
                            <div class="sello-digital mt-2">{{ $selloCFDI ?? 'N/A' }}</div>
                        </div>
                        <div class="mt-4">
                            <strong class="pt-3">Sello Digital del SAT:</strong>
                            <div class="sello-digital mt-2">proximamente...</div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</body>
<style>
    .sello-digital {
  
}
</style>

<style>
    .digital-signature {
            background-color: var(--light-gray);
            border-radius: 8px;
            margin-top: 2rem;
            font-size: 0.9rem;
            display:flex;
            justify-content:center;
            align-content:center
        }
        .sello-digital {
            font-family: monospace;
            font-size: 0.8rem;
            background-color: white;
            padding: 1rem;
            border-radius: 4px;
            border: 1px solid var(--border-color);
            word-break: break-all;
            overflow-wrap: break-word;     
            word-wrap: break-word;       
            width: 95%; 
        }
    .table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 12px;
    }
    .table th, .table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left;
    }
    .table th {
        background-color: #f4f4f4;
        color: #333;
        font-weight: bold;
    }
    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .totals {
        text-align: right;
        font-size: 14px;
        margin-top: 20px;
    }
    .totals p {
        margin: 5px 0;
    }
    .total-row {
        font-size: 16px;
        font-weight: bold;
        background-color: #8b8b8b;
        padding: 10px;
    }
    .document-title {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
    }
</style>
</html>
