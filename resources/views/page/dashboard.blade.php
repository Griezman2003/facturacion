@php
$user = Auth::user();
@endphp
@extends('components.master')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="bg-dark text-light py-4 px-3 rounded shadow-lg mt-1 mb-5">
            <h3 class="text-gold fw-bold text-uppercase">Panel Administrativo de Facturación</h3>
            <ol class="breadcrumb bg-transparent mb-4">
                <li class="breadcrumb-item text-gold fs-5">
                    <i class="fas fa-user-shield me-2"></i> Bienvenido, <span class="fw-bold">{{ $user->nombre_usuario }}</span>
                </li>
            </ol>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Facturas Generadas por Mes
                    </div>
                    <div class="card-body">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>             
        <div class="card mt-5">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Facturas generadas por : {{ $user->email }}
            </div>
            <div class="card-body">
                @if ($factura->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-circle"></i> No hay facturas registradas para este usuario.
                </div>
                @else
                <table id="datatablesSimple">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">Folio</th>
                            <th class="text-center">UUID</th>
                            <th class="text-center">Rfc Emisor</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">RFC Receptor</th>
                            <th class="text-center">Descargar PDF</th>
                            <th class="text-center">Descargar XML</th>
                            <th class="text-center">Estatus</th>
                            <th class="text-center">Cancelar Factura</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($factura as $facturas)
                        <tr>
                            <td class="text-center">{{ $facturas->folio }}</td>
                            <td class="text-center">{{ $facturas->uuid }}</td>
                            <td class="text-center">{{ $facturas->rfc_emisor }}</td>
                            <td class="text-center">${{ number_format($facturas->subtotal, 2) }}</td>
                            <td class="text-center">${{ number_format($facturas->total, 2) }}</td>
                            <td class="text-center">{{ $facturas->rfc_receptor }}</td>
                            <td class="text-center"><a href="{{ asset('storage/' . $facturas->pdf_path) }}" class="btn btn-primary btn-sm" target="_blank">PDF</a></td>
                            <td class="text-center"><a href="{{ asset('storage/' . $facturas->xml_path) }}" class="btn btn-success btn-sm" target="_blank">XML</a></td>
                            <td class="text-center pt-2">
                                @if($facturas->status == 'active')
                                <span class="badge bg-success text-white py-2 px-3 rounded-pill">
                                    <i class="fas fa-check-circle me-2"></i> Activo
                                </span>
                                @elseif($facturas->status == 'canceled')
                                <span class="badge bg-danger text-white py-2 px-3 rounded-pill">
                                    <i class="fas fa-times-circle me-2"></i> Cancelado
                                </span>
                                @elseif($facturas->status == 'pending')
                                <span class="badge bg-danger text-white py-2 px-3 rounded-pill">
                                    <i class="fas fa-times-circle me-2"></i> Pendiente
                                </span>
                                @else
                                <span class="badge bg-secondary text-white py-2 px-3 rounded-pill">
                                    <i class="fas fa-question-circle me-2"></i> Desconocido
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button 
                                class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalCancelarFactura"
                                onclick="abrirModalCancelar('{{ $facturas->uuid }}', '{{ $facturas->IdFactura }}')"
                                >
                                Cancelar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
    
    <!-- Modal para Cancelar Factura -->
    <div class="modal fade" id="modalCancelarFactura" tabindex="-1" aria-labelledby="modalCancelarFacturaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow-lg">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold" id="modalCancelarFacturaLabel">Cancelar Factura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCancelarFactura" action="{{ route('factura.cancelar', $user) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="facturaId" class="form-label fw-semibold">UUID (Factura)</label>
                            <input type="text" id="facturaId" class="form-control bg-light text-secondary" name="uuid" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="facturaId" class="form-label fw-semibold">ID (Factura)</label>
                            <input class="form-control bg-light text-secondary" type="text" id="facturaIdHidden" name="id" readonly>
                        </div>
                        
                        
                        <div class="mb-3">
                            <label for="tipoCancelacion" class="form-label fw-semibold">Tipo</label>
                            <input type="text" id="tipoCancelacion" class="form-control bg-light text-secondary" name="type" value="issuedLite" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="motivoCancelacion" class="form-label fw-semibold">Motivo</label>
                            <select id="motivoCancelacion" class="form-select" name="motive" >
                                <option value="01">Comprobante emitido con errores con relación</option>
                                <option value="02">Comprobante emitido con errores sin relación</option>
                                <option value="03">No se llevó a cabo la operación</option>
                                <option value="04">Operación nominativa relacionada con una factura global</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger px-4">Confirmar Cancelación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</main>
<style>
    .company-card {
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    
    .company-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }
    .text-gold {
        color: #ffd700; /* Dorado */
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var facturasPorMes = @json($facturasPorMes);  
    var anioActual = new Date().getFullYear();  
    
    var options = {
        series: [{
            name: 'Facturas Generadas',
            data: Object.values(facturasPorMes)  
        }],
        chart: {
            height: 350,
            type: 'radar', 
        },
        dataLabels: {
            enabled: true  
        },
        plotOptions: {
            radar: {
                size: 150,  
                polygons: {
                    strokeColors: '#e9e9e9',  
                    fill: {
                        colors: ['#f8f8f8', '#fff'] 
                    }
                }
            }
        },
        title: {
            text: 'Facturas Generadas por Mes - ' + anioActual
        },
        colors: ['#FF4560'], 
        markers: {
            size: 4,
            colors: ['#fff'],  
            strokeColor: '#FF4560',  
            strokeWidth: 2,
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val 
                }
            }
        },
        xaxis: {
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] 
        },
        yaxis: {
            labels: {
                formatter: function(val, i) {
                    if (i % 2 === 0) {
                        return val 
                    } else {
                        return ''
                    }
                }
            }
        }
    };
    
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

<script>
    function abrirModalCancelar(uuid, IdFactura) {
        document.getElementById('facturaId').value = uuid;
        document.getElementById('facturaIdHidden').value = IdFactura;
    }
</script>

@endsection