@php
$user = Auth::user();   
@endphp

@extends('components.master')
@section('content')
@php
$Indice = [
"I" =>"INGRESO",
"E" => "EGRESO",
"T" => "TRASLADO"
];
@endphp 
<div class="container mt-3">
    <form action="{{route('dashboard.factura.generate', $user)}}" method="POST">
        @csrf   
        <div class="container py-5">
            <div class="card shadow-sm mb-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0 text-primary">Factura Electrónica CFDI 4.0</h1>
                        <span class="badge bg-primary px-3 py-2">{{ date('Y-m-d') }}</span>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 text-primary">Información de Factura</h5>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="serie" class="form-label fw-bold">Serie</label>
                                            <select class="form-select border-0 shadow-sm" id="serie" name="serie" required>
                                                <option value="" disabled selected>Series cargadas en el sistema</option>
                                                @foreach ($series as $serie)
                                                <option value="{{ $serie['Name'] }}">{{ $serie['Name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="folio" class="form-label fw-bold">Folio</label>
                                            <select class="form-control border-0 shadow-sm"  name="folio" required>
                                                <option value="" disabled selected>El folio debe pertenecer a la serie</option>
                                                @foreach ($series as $serie)
                                                <option value="{{ $serie['Folio'] }}">{{ $serie['Name'] }}-{{ $serie['Folio'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="lugar_expedicion" class="form-label fw-bold">Lugar de Expedición</label>
                                            <input type="number" class="form-control border-0 shadow-sm"  name="expeditionPlace" placeholder="Ejemplo: 24330"   required pattern="\d{5}">
                                        </div>
                                        <div class="col-12">
                                            <label for="lugar_expedicion" class="form-label fw-bold">Forma de Pago</label>
                                            <select class="form-select" name="paymentForm" required>
                                                <option value="01">Efectivo</option>
                                                <option value="02">Cheque nominativo</option>
                                                <option value="03">Transferencia electrónica de fondos</option>
                                                <option value="99">Por definir</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="lugar_expedicion" class="form-label fw-bold">Moneda</label>
                                            <select class="form-select" name="moneda" required>
                                                <option value="MXN">Peso Mexicano</option>
                                                <option value="USD">Dólar Americano</option>
                                                <option value="EUR">Euro</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label class="form-label fw-bold" for="comprobante">Tipo de Comprobante</label>
                                            <select name="cfdiType" id="comprobante" class="form-select border-0 shadow-sm" required>
                                                @foreach ($Indice as $key => $indice)
                                                <option value="{{$key}}">{{$key}}-{{$indice}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 text-primary">Datos del Emisor</h5>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="rfcCliente" class="form-label fw-bold">RFC del Emisor</label>
                                            <select name="rfcEmisor" class="form-control border-0 shadow-sm" required>
                                                @if (empty($csds) || count($csds) == 0)
                                                    <option value="" disabled>No hay CSD cargados..Por favor cargue sus CSD</option>
                                                @else
                                                    <option value="" disabled selected>Selecciona un RFC cargado</option>
                                                    @foreach ($csds as $csd)
                                                        <option value="{{$csd['Rfc']}}">{{$csd['Rfc']}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>                                        
                                        
                                        <div class="col-md-12">
                                            <label for="nombre_emisor" class="form-label fw-bold">Nombre</label>
                                            <input type="text" class="form-control border-0 shadow-sm" id="nombre_emisor" name="nombre_emisor" autocomplete="off" required
                                            >
                                            <small>El nombre debe ser tal y como se encuentra en la Cédula de Identificación Fiscal y Constancia de Situación Fiscal</small>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <label for="regimen_fiscal" class="form-label fw-bold">Régimen Fiscal</label>
                                            <select name="regimenEmisor" id="regimen_fiscal" class="form-select border-0 shadow-sm" required>
                                                @foreach($regimenFiscal as $jsonRegimen)
                                                <option value="{{ $jsonRegimen['id'] }}">
                                                    {{ $jsonRegimen['id'] }} {{ $jsonRegimen['descripcion']}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="metodoPago">Método de Pago:</label>
                                            <select class="form-select border-0 shadow-sm" name="paymentMethod">
                                                <option value="PUE">Pago en una sola exhibición (PUE)</option>
                                                <option value="PPD">Pago en parcialidades o diferido (PPD)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Receptor Section -->
            <div class="card shadow-sm mb-5">
                <div class="card-body">
                    <h5 class="card-title mb-4 text-primary">Datos del Receptor</h5>
                    
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label for="rfcReceptor" class="form-label fw-bold">RFC</label>
                            <input type="text" id="rfcReceptor" name="rfcReceptor" class="form-control border-0 shadow-sm"
                            placeholder="Ingrese su RFC" maxlength="13" pattern="^[A-ZÑ&]{3,4}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A]$"
                            title="Ingrese un RFC válido" style="text-transform: uppercase;" oninput="receptorRFC()" required>
                            <small id="tipo" class="form-text text-muted"></small>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="nombre_receptor" class="form-label fw-bold">Nombre o Razón Social</label>
                            <input type="text"class="form-control border-0 shadow-sm" id="nombre_receptor" name="receiver">
                        </div>
                        <div class="col-4">
                            <label for="regimen_fiscal" class="form-label fw-bold">Régimen Fiscal</label>
                            <select name="regimenFiscal" id="regimen_fiscal" class="form-select border-0 shadow-sm" required>
                                @foreach($regimenFiscal as $jsonRegimen)
                                <option value="{{ $jsonRegimen['id'] }}">
                                    {{ $jsonRegimen['id'] }} {{ $jsonRegimen['descripcion']}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="lugar_expedicion" class="form-label fw-bold">Domicilio Fiscal</label>
                            <input type="text" class="form-control border-0 shadow-sm" name="domicilioReceptor" placeholder="Ejemplo: 64000" required>
                        </div>
                        <div class="col-md-4">
                            <label for="uso_cfdi" class="form-label fw-bold">Uso del CFDI</label>
                            <select name="uso_cfdi" id="uso_cfdi" class="form-select border-0 shadow-sm" required>
                                @foreach($usoCFDI as $jsonCFDI)
                                <option value="{{ $jsonCFDI['id'] }}">
                                    {{ $jsonCFDI['id'] }} {{ $jsonCFDI['descripcion']}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-md-4">
                            <label class="form-label fw-bold">Correo del Receptor</label>
                            <input type="email" name="email" class="form-control border-0 shadow-sm" placeholder="admin@gmail.com">
                            <small class="mt-0 text-primary" >Usted puede mandar la factura por correo al receptor de la compra</small>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- Tabla de Conceptos -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="fw-bold text-primary">Conceptos</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>Clave Producto/Servicio</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Clave Unidad</th>
                                    <th>Valor Unitario</th>
                                    <th>Descuento</th>
                                    <th>Importe</th>
                                    <th>Nombre Interno</th>
                                    <th>No Identificación</th>
                                    <th>Objeto Impuesto</th>
                                    <th>ISR</th>
                                    <th>IVA retencion</th>
                                    <th>IEPS</th>
                                    <th>Precio Final</th>
                                </tr>
                            </thead>
                            <tbody id="conceptos-body" class="text-center">
                                <!-- Filas dinámicas aquí -->
                                <input type="hidden" name="productos" id="productos-json">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Tabla de Totales -->
            <div class="row">
                <div class="col-md-8">
                    <div class="text-start">
                        <button type="button" class="btn btn-primary btn-lg px-4" onclick="toggleModal(true)">
                            <i class="fas fa-plus-circle me-2"></i>Nuevo Producto
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold text-primary">Totales</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-end border-0 fw-semibold">Subtotal:</td>
                                    <td class="text-end border-0 text-success" id="subtotal">$ 00.00</td>
                                </tr>
                                <tr>
                                    <td class="text-end border-0 fw-semibold">Impuestos:</td>
                                    <td class="text-end border-0 text-danger" id="totalImpuesto">$ 00.00</td>
                                </tr>
                                <tr class="table-light fw-bold">
                                    <td class="text-end border-0">Total:</td>
                                    <td class="text-end border-0 text-primary" id="totalFinal">$ 00.00</td>
                                </tr>
                            </tbody>
                            
                            <!-- Campos ocultos para enviar los datos calculados al backend -->
                            <input type="hidden" id="subtotalInput" name="subtotal">
                            <input type="hidden" id="totalImpuestoInput" name="totalImpuesto">
                            <input type="hidden" id="totalFinalInput" name="totalFinal">
                            
                        </table>
                        
                    </div>
                </div>
                <div class="row mt-4 mb-5">
                    <div class="col-md-12" style="display: flex; justify-content:center; align-items:center">
                        <button type="submit" id="Formulario" class="btn btn-primary">Generar Factura</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal -->
    <div id="modalNuevoProducto" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-box me-2"></i>Nuevo Producto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" onclick="toggleModal(false)" aria-label="Cerrar"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row g-4">   
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-primary mb-4">Datos del producto</h6>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nombre Interno</label>
                                        <input type="text" id="nombreInterno" class="form-control border-0 shadow-sm" 
                                        placeholder="Nombre Interno" required>
                                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">No Identificación</label>
                                        <input type="text" id="noIdentificacion" class="form-control border-0 shadow-sm" 
                                        placeholder="Codigo Interno (Opcional)">
                                        <small class="text-muted">Obligatorio solo para comercio exterior</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Descripción</label>
                                        <input type="text" id="descripcion" class="form-control border-0 shadow-sm"
                                        placeholder="Descripción del producto">
                                    </div>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Precio Unitario</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" id="valorUnitario" class="form-control border-0" 
                                                step="0.01" placeholder="0.00" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Cantidad</label>
                                            <input type="number" id="cantidad" class="form-control border-0 shadow-sm" 
                                            step="1" min="1" placeholder="1" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-primary mb-4">Cambios obligatorios CFDI 4.0 SAT</h6>
                                    
                                    {{-- <div class="mb-3">
                                        <label class="form-label fw-bold">Clave de Producto o Servicio</label>
                                        <select id="select-buscador" class="form-select border-0 shadow-sm">
                                            @foreach($ProdServ as $producto)
                                            <option value="{{ $producto['id']}}-{{ $producto['descripcion'] }}">
                                                {{ $producto['id'] }} - {{ $producto['descripcion'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Clave de Producto o Servicio</label>
                                        <input type="text" id="buscador" class="form-control border-0 shadow-sm" placeholder="Clave de Producto o Servicio - 95141904">
                                        <div class="dropdown-container">
                                            <ul id="resultados" class="list-group mt-2"></ul>
                                        </div>
                                        <input type="hidden" id="buscadorProv" name="claveProducto">
                                    </div>
                                    
                                    {{--                                     
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Clave Unidad</label>
                                        <select id="select-buscador2" class="form-select border-0 shadow-sm">
                                            @foreach($claveUnidad as $unidad)
                                            <option value="{{ $unidad['id']}}">{{ $unidad['id'] }} - {{ $unidad['nombre'] }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Clave Unidad</label>
                                        <input type="text" id="buscador2" class="form-control border-0 shadow-sm" placeholder="Clave Unidad - ZZ">
                                        <div class="dropdown-container">
                                            <ul id="resultados2" class="list-group mt-2"></ul>
                                        </div>
                                        <input type="hidden" id="buscadorProv2" name="claveUnidad" />
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label fw-bold" for="objetoImpuesto">Objeto Impuesto</label>
                                        <select id="objetoImpuesto" class="form-select border-0 shadow-sm" aria-label="Selección del objeto de impuesto">
                                            <option value="01">No objeto de impuesto</option>
                                            <option value="02">Sí objeto de impuesto</option>
                                            {{-- <option value="03">Objeto del impuesto, no obligado al desglose</option>
                                            <option value="04">Objeto del impuesto, no causa impuesto</option> --}}
                                        </select>
                                    </div>                                
                                    
                                    <div class="card border-0 bg-white shadow-sm" id="cardImpuestos">
                                        <div class="card-body">
                                            <h6 class="card-title text-primary mb-3">Impuestos Federales</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">IVA</label>
                                                    <select id="iva" class="form-select border-0 bg-light">
                                                        <option value="exento">Exento de IVA</option>
                                                        <option value="0.16">IVA 16%</option>
                                                        <option value="0.08">IVA 8%</option>
                                                        <option value="0.0">IVA 0%</option>
                                                        
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">IVA Retenido</label>
                                                    <select id="ivaRetenido" class="form-select border-0 bg-light">
                                                        <option value="-">No aplica</option>
                                                        <option value="0.1066">2/3 del IVA (10.66%)</option>
                                                        <option value="0.4">IVA Retención Simplificada 4%</option> 
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">ISR</label>
                                                    <select id="isr" class="form-select border-0 bg-light">
                                                        <option value="-">No aplica</option>
                                                        <option value="0.30">ISR Personas Morales (30%)</option>
                                                        <option value="0.20">ISR Retenido Personas Morales (20%)</option>
                                                        <option value="0.10">ISR Retenido (10%)</option>
                                                        <option value="0.054">ISR Simplificado (5.4%)</option>
                                                        {{-- /funciona --}}
                                                        {{-- <option value="tablas">ISR según tablas progresivas</option> --}}
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">IEPS</label>
                                                    <select id="ieps" class="form-select border-0 bg-light">
                                                        <option value="-">No aplica</option>
                                                        <option value="0.265">Bebidas alcohólicas hasta 14° GL - 26.5%</option>
                                                        <option value="0.30">Bebidas alcohólicas 14° a 20° GL - 30%</option> 
                                                        <option value="0.53">Bebidas alcohólicas más de 20° GL - 53%</option>
                                                        <option value="1.60">Cigarros y tabacos labrados - 160%</option>
                                                        {{-- funciona --}}
                                                        <option value="0.08">Alimentos con alto contenido calórico - 8%</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <label class="form-label fw-bold">Precio Final (con impuestos)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-primary text-white">$</span>
                                            <input type="text" id="precioFinal" class="form-control border-0 shadow-sm" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" onclick="toggleModal(false)">
                        <i class="fas fa-times me-2"></i>Cerrar
                    </button>
                    <button type="submit" class="btn btn-primary" onclick="guardarProducto()">
                        <i class="fas fa-save me-2" ></i>Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
<style>
    body {
        background-color: #f8f9fa;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .card {
        border-radius: 10px;
        border: none;
    }
    
    .modal-content {
        border-radius: 15px;
        border: none;
    }
    
    .btn-primary {
        padding: 0.5rem 1.5rem;
    }
    
    .input-group-text {
        border: none;
    }
    
    .form-control,
    .form-select {
        padding: 0.75rem 1rem;
    }
    
    .badge {
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .text-primary {
        color: #0d6efd !important;
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    #resultados {
        max-height: 200px; 
        overflow-y: auto; 
        position: absolute;
        width: 93%;
        z-index: 9999; 
        background-color: white; 
        border-radius: 5px; 
    }
    #resultados2 {
        max-height: 200px; 
        overflow-y: auto; 
        position: absolute;
        width: 93%;
        z-index: 9999; 
        background-color: white; 
        border-radius: 5px; 
    }	
    .list-group-item {
        cursor: pointer;
    }
    #select-buscador {
        opacity: 0;
        display: none;
    }
</style>

<style>
    .btn-teal {
        background-color: #00897b;
        color: white;
    }
    
    .btn-teal:hover {
        background-color: #00796b;
        color: white;
    }
    
    .modal-xl {
        max-width: 1000px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #00897b;
        box-shadow: 0 0 0 0.25rem rgba(0, 137, 123, 0.25);
    }
    
    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .form-label {
        font-weight: 500;
        color: #495057;
    }
</style>
@endpush

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("buscador");
        const resultados = document.getElementById("resultados");
        const buscadorProv = document.getElementById("buscadorProv");
        const productos = @json($ProdServ);
        
        input.addEventListener("input", function() {
            const query = input.value.trim().toLowerCase();
            resultados.innerHTML = query ? productos.filter(p => p.descripcion.toLowerCase().includes(query) || p.id.toString().includes(query))
            .slice(0, 5)
            .map(p => `<li class="list-group-item list-group-item-action">${p.id} - ${p.descripcion}</li>`).join('') : "";
            
            if (!query) return;
            
            resultados.querySelectorAll(".list-group-item").forEach(item => {
                item.addEventListener("click", () => {
                    input.value = item.textContent;
                    buscadorProv.value = productos.find(p => `${p.id} - ${p.descripcion}` === item.textContent).id;
                    resultados.innerHTML = "";
                });
            });
        });
        
        document.addEventListener("click", function(event) {
            if (!input.contains(event.target) && !resultados.contains(event.target)) resultados.innerHTML = "";
        });
        
        input.addEventListener("blur", () => {
            if (!input.value.trim()) buscadorProv.value = "";
        });
    });
    
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("buscador2");
        const resultados = document.getElementById("resultados2");
        const buscadorProv2 = document.getElementById("buscadorProv2");
        const unidades = @json($claveUnidad);
        
        input.addEventListener("input", function() {
            const query = input.value.trim().toLowerCase();
            resultados.innerHTML = query ? unidades.filter(u => u.nombre.toLowerCase().includes(query) || u.id.toString().includes(query))
            .slice(0, 5)
            .map(u => `<li class="list-group-item list-group-item-action">${u.id} - ${u.nombre}</li>`).join('') : "";
            
            if (!query) return;
            
            resultados.querySelectorAll(".list-group-item").forEach(item => {
                item.addEventListener("click", () => {
                    input.value = item.textContent; 
                    buscadorProv2.value = unidades.find(u => `${u.id} - ${u.nombre}` === item.textContent).id; 
                    resultados.innerHTML = ""; 
                });
            });
        });
        
        document.addEventListener("click", function(event) {
            if (!input.contains(event.target) && !resultados.contains(event.target)) {
                resultados.innerHTML = "";
            }
        });
        
        input.addEventListener("blur", () => {
            if (!input.value.trim()) {
                buscadorProv2.value = "";
            }
        });
    });
</script>



@endsection


