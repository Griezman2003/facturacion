@php
$user = Auth::user();
@endphp
@extends('components.master')
@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">

        <!-- Tarjeta Monto Total Facturado -->
        <div class="col-md-6 mb-4">
            <div class="targeta card text-white bg-dark border-0 shadow-lg rounded-3" style="transition: transform 0.3s ease;">
                <div class="card-header bg-black text-white d-flex justify-content-between align-items-center">
                    <i class="fas fa-calendar-day me-2"></i>
                    <span class="fw-bold">Monto Total Facturado en el Día</span>
                </div>
                <div class="card-body text-center">
                    @if ($montoTotalPorDia > 0)
                        <h4 class="card-title">${{ number_format($montoTotalPorDia, 2) }}</h4>
                        <p class="card-text">Total facturado hoy.</p>
                    @else
                        <h4 class="card-title">$0.00</h4>
                        <p class="card-text">No se ha facturado hoy.</p>
                    @endif
                    <p class="text-white">Fecha: {{ now()->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta Facturas Generadas Hoy -->
        <div class="col-md-6 mb-4">
            <div class="targeta card text-white bg-dark border-0 shadow-lg rounded-3" style="transition: transform 0.3s ease;">
                <div class="card-header bg-black text-white d-flex justify-content-between align-items-center">
                    <i class="fas fa-file-invoice me-2"></i>
                    <span class="fw-bold">Facturas Generadas Hoy</span>
                </div>
                <div class="card-body text-center">
                    @if ($facturasHoy > 0)
                        <h4 class="card-title">{{ $facturasHoy }}</h4>
                        <p class="card-text">Número de facturas generadas hoy.</p>
                    @else
                        <h4 class="card-title">0</h4>
                        <p class="card-text">Aún no se han generado facturas hoy.</p>
                    @endif
                    <p class="text-white">Fecha: {{ now()->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

    </div> 
    <!-- Tabla de facturas generadas -->
    <div class="card mt-5">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Facturas generadas
        </div>
        <div class="card-body">
            @if ($facturas->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-circle"></i> No hay facturas registradas por el momento.
                </div>
            @else
                <table id="datatablesSimple" class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">User</th>
                            <th class="text-center">Folio</th>
                            <th class="text-center">UUID</th>
                            <th class="text-center">RFC Emisor</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">RFC Receptor</th>
                            <th class="text-center">Descargar PDF</th>
                            <th class="text-center">Descargar XML</th>
                            <th class="text-center">Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facturas as $factura)
                            <tr>
                                <td class="text-center">{{ $factura->user_id }}</td>
                                <td class="text-center">{{ $factura->folio }}</td>
                                <td class="text-center">{{ $factura->uuid }}</td>
                                <td class="text-center">{{ $factura->rfc_emisor }}</td>
                                <td class="text-center">${{ number_format($factura->subtotal, 2) }}</td>
                                <td class="text-center">${{ number_format($factura->total, 2) }}</td>
                                <td class="text-center">{{ $factura->rfc_receptor }}</td>
                                <td class="text-center">
                                    <a href="{{ asset('storage/' . $factura->pdf_path) }}" class="btn btn-primary btn-sm" target="_blank">PDF</a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ asset('storage/' . $factura->xml_path) }}" class="btn btn-success btn-sm" target="_blank">XML</a>
                                </td>
                                <td class="text-center">
                                    @if($factura->status == 'active')
                                        <span class="badge bg-success text-white py-2 px-3 rounded-pill">
                                            <i class="fas fa-check-circle me-2"></i> Activo
                                        </span>
                                    @elseif($factura->status == 'pending')
                                        <span class="badge bg-warning text-dark py-2 px-3 rounded-pill">
                                            <i class="fas fa-clock me-2"></i> Pendiente
                                        </span>
                                    @elseif($factura->status == 'canceled')
                                        <span class="badge bg-danger text-white py-2 px-3 rounded-pill">
                                            <i class="fas fa-times-circle me-2"></i> Cancelado
                                        </span>
                                    @else
                                        <span class="badge bg-secondary text-white py-2 px-3 rounded-pill">
                                            <i class="fas fa-question-circle me-2"></i> Desconocido
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Registro de facturación diaria -->
<div class="card px-4 mt-5">
    <div class="accordion" id="accordionFacturacionDiaria">
        <div class="card mt-5">
            <div class="card-header" id="headingFacturacionDiaria">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFacturacionDiaria" aria-expanded="true" aria-controls="collapseFacturacionDiaria">
                        <i class="fas fa-table me-1"></i>
                        Registro de Facturación Diaria
                    </button>
                </h5>
            </div>
            <div id="collapseFacturacionDiaria" class="collapse" aria-labelledby="headingFacturacionDiaria" data-bs-parent="#accordionFacturacionDiaria">
                <div class="card-body">
                    @if ($montoPorUsuarioPorDia->isEmpty())
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-circle"></i> No hay registros de facturación diaria.
                        </div>
                    @else
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-center">Usuario ID</th>
                                    <th class="text-center">RFC Emisor</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Monto Facturado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($montoPorUsuarioPorDia as $registro)
                                    <tr>
                                        <td class="text-center">{{ $registro->user_id }}</td>
                                        <td class="text-center">{{ $registro->rfc_emisor }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</td>
                                        <td class="text-center">${{ number_format($registro->monto_total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Acordeón de Facturación Mensual -->
    <div class="accordion mb-4" id="accordionFacturacionMensual">
        <div class="card mt-5">
            <div class="card-header" id="headingFacturacionMensual">
                <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFacturacionMensual" aria-expanded="false" aria-controls="collapseFacturacionMensual">
                        <i class="fas fa-table me-1"></i>
                        Resumen Mensual de Facturación
                    </button>
                </h5>
            </div>
            <div id="collapseFacturacionMensual" class="collapse" aria-labelledby="headingFacturacionMensual" data-bs-parent="#accordionFacturacionMensual">
                <div class="card-body">
                    @if ($montoPorMes->isEmpty())
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-circle"></i> No hay registros de facturación mensual.
                        </div>
                    @else
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-center">Mes</th>
                                    <th class="text-center">Monto Total Facturado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($montoPorMes as $mes)
                                    <tr>
                                        <td class="text-center">{{ $mes->mes }} / {{ $mes->año }}</td>
                                        <td class="text-center">${{ number_format($mes->monto_total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>

   <!-- Animación al pasar el mouse -->
   <style>
    .targeta:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection