@php
$user = Auth::user();
@endphp
@extends('components.master')
@section('content')
<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4 text-center text-white bg-dark p-3 rounded shadow-lg">
            <i class="fas fa-cogs me-2"></i> Panel Administrativo de Facturación 
            <span class="badge bg-info text-dark">Rol Actual: <strong>{{$user->rol}}</strong></span>
        </h3>
        
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fas fa-user-circle me-2" style="font-size: 24px;"></i> 
                    <span class="fs-5 text-black">Bienvenido, <strong>{{$user->rol}}</strong></span>
                </div>
            </li>
        </ol>        
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        factura Generadas por Mes de Todos los Usuarios
                    </div>
                    <div class="card-body">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>             
    </div>  
    <div class="container-fluid px-4 mt-5 pt-5">
        @foreach(auth()->user()->unreadNotifications as $notification)
        <div class="card-notificaciones mb-4 shadow-lg" style="background-color: #212529; color: #f8f9fa; border: 1px solid #6c757d; transition: transform 0.3s ease-in-out;">
            <div class="card-noti" style="transition: box-shadow 0.3s ease, transform 0.3s ease;">
                <h5 class="card-title text-warning">¡Nueva Notificación!</h5>
                <p class="card-text">{{ $notification->data['message'] }}</p>
                
                <p class="text-white" style="font-size: 0.9rem;">
                    {{ \Carbon\Carbon::parse($notification->created_at)->setTimezone('America/Mexico_City')->format('d/m/Y H:i:s') }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('notificaciones.leer', $notification->id) }}" class="btn btn-success d-flex align-items-center">
                        <i class="fas fa-check-circle mr-2"></i> Marcar como leída
                    </a>
                    <a href="{{ route('usuarios') }}" class="btn btn-light d-flex align-items-center">
                        <i class="fas fa-users mr-2"></i> Ir a Usuarios
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</main>
<style>
    .card-notificaciones:hover {
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3); /* Sombra al pasar el mouse */
    }

    .card-noti {
        padding: 20px;
        border-radius: 12px; /* Bordes redondeados */
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: scale(1.05); /* Botón ligeramente más grande al pasar el mouse */
    }

    .btn-success {
        background-color: #28a745; /* Color verde */
    }

    .btn-light {
        background-color: #f8f9fa; /* Color claro para el botón */
        color: #212529;
    }

    .btn-light:hover {
        background-color: #e2e6ea;
    }

    /* Efecto de iluminación */
    .card-noti:hover {
        background-color: #343a40; /* Iluminación suave */
    }
    .company-card {
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    
    .company-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var facturasPorMes = @json($facturasPorMes);  
    var anioActual = new Date().getFullYear();  
    
    var options = {
        series: [{
            name: 'factura Generadas',
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

{{-- <script>
    function abrirModalCancelar(uuid, IdFactura) {
    document.getElementById('facturaId').value = uuid;
    document.getElementById('facturaIdHidden').value = IdFactura;
    }
</script> --}}

@endsection

{{-- @extends('components.master')
@section('content')
<h2>factura Emitidas</h2>

<p><strong>Total Facturado:</strong> ${{ number_format($totalFacturado, 2) }}</p>

<table>
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Total</th>
    </tr>
    @foreach ($factura as $factura)
    <tr>
        <td>{{ $factura->id }}</td>
        <td>{{ $factura->cliente->nombre }}</td>
        <td>{{ $factura->fecha }}</td>
        <td>${{ number_format($factura->total, 2) }}</td>
    </tr>
    @endforeach
</table>
@endsection --}}
